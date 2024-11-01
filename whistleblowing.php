<?php
/**
 * Plugin Name: Whistleblowing System
 * Plugin URI: https://whistleblowing-form.de
 * Description: Whistleblowing system form is the ultimate solution for effortlessly creating and managing contact and whistleblowing forms.
 * Version: 1.2.1
 * Author: Whistleblowing System Team
 * Author URI: https://whistleblowing-form.de
 * Text Domain: whistleblowing-system
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @package whistleblowing-system
 */

defined( 'ABSPATH' ) || die( 'Access Denied' );
$bwg = 0;
final class WBLS_WhistleBlower {
    /**
     * The single instance of the class.
     */
    protected static $instance = null;

    public $plugin_dir = '';
    public $plugin_url = '';
    public $prefix = '';

    /**
     * Main WBLS_WhistleBlower Instance.
     *
     * Ensures only one instance is loaded or can be loaded.
     *
     * @static
     * @return WBLS_WhistleBlower - Main instance.
     */
    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct() {
        require_once 'config.php';
        $this->define_constants();
        $this->add_actions();
    }

    /**
     * Define Constants.
     */
    private function define_constants() {
        $this->plugin_dir = WP_PLUGIN_DIR . '/' . plugin_basename(dirname(__FILE__));
        require_once($this->plugin_dir . '/library.php');
        $this->plugin_url = plugins_url(plugin_basename(dirname(__FILE__)));
        $this->prefix = 'wbls';
    }

    public function activate() {
        update_option("wbls-plugin-version", WBLS_VERSION);
    }

    private function add_actions() {
        // Plugin activation.
        register_activation_hook(__FILE__, array($this, 'global_activate'));

        add_action('init', array($this, 'init'));
        add_action('admin_init', array($this, 'admin_init'));
        add_action('admin_menu', array( $this, 'admin_menu' ) );

        // Plugin activation.
        register_activation_hook(__FILE__, array($this, 'activate'));

        // Register scripts/styles.
        add_action('wp_enqueue_scripts', array($this, 'register_frontend_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'register_admin_scripts'));

        add_action('wp_ajax_wbls_admin_ajax', array($this, 'wbls_admin_ajax') );
        add_action('wp_ajax_wbls_front_ajax', array($this, 'wbls_front_ajax') );
        add_action('wp_ajax_nopriv_wbls_front_ajax', array($this, 'wbls_front_ajax') );

        add_shortcode( 'wbls-whistleblower-form',array($this, 'wbls_shortcode')  );
        add_shortcode( 'wblsform', array($this, 'wbls_shortcode')  );
        if ( !WBLS_PRO ) {
            add_action("admin_footer", array($this, 'pro_banner'));
            add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'plugin_action_links'));
            add_action('wp_ajax_wbls_send_deactivation_reason', array($this, 'wbls_send_deactivation_reason') );
            add_action('current_screen', array( $this, 'check_plugins_page' ) );
        }
    }

    public function wbls_send_deactivation_reason() {

        $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
        if ( ! wp_verify_nonce( $nonce, 'wbls_ajax_nonce' ) ) {
            wp_send_json_error(['message' => 'Something went wrong.']);
        }
        $this->check_plugins_page('plugins' );
    }

    public function check_plugins_page( $current_screen ) {
        $task = isset($_POST['task']) ? sanitize_text_field($_POST['task']) : '';
        $cid = '';
        if( isset($current_screen->id) ) {
            $cid = $current_screen->id;
        } elseif( $current_screen == 'plugins' ) {
            $cid = 'plugins';
        }
        if ( 'plugins' == $cid ) {
            require_once WBLS_DIR."/Apps/deactivate/deactivate.php";
            new WBLS_Deactivate($task);
        }
    }

    /*
    * Global activate.
    *
    * @param $networkwide
    */
    public function global_activate() {
        $this->wbls_register_cpt();
        $count_themes = wp_count_posts( 'wbls_theme' )->publish;
        if( !$count_themes ) {
            require_once WBLS_DIR."/admin/ControllerThemes.php";
            $ob = new WBLS_ControllerThemes();
            $ob->save_theme();
        }
        global $wp_rewrite;
        $wp_rewrite->init();
        $wp_rewrite->flush_rules();

    }

    /**
     * Plugin action links.
     *
     * Adds action links to the plugin list table
     *
     * Fired by `plugin_action_links` filter.
     *
     * @since 1.1.1
     * @access public
     *
     * @param array $links An array of plugin action links.
     *
     * @return array An array of plugin action links.
     */
    function plugin_action_links( $links )
    {
        $links['go_pro'] = sprintf( '<a href="%1$s" target="_blank" class="wbls-plugins-gopro">%2$s</a>', 'https://whistleblowing-form.de/produkt/whistleblowing-system-pro/?from=plugin', esc_html__( 'Get Whistleblower Pro', 'whistleblowing-system' ) );
        return $links;
    }

    public function pro_banner() {
        require_once WBLS_DIR.'/admin/wistleblower_templates.php';
    }

    public function admin_init() {
        $version = get_option('wbls-plugin-version');
        if( !$version ) {
            WBLSLibrary::wbls_convert_old_form();
        }
    }

    public function wbls_shortcode($attr) {
        require_once $this->plugin_dir . "/frontend/frontend.php";
        if ( !isset($attr['id']) ) {
            $old_form_id = get_option('wbls-oldForm_id');
            if( $old_form_id ) {
                $attr = ['id' => intval($old_form_id)];
            }
        }
        $ob = new WBLS_frontend($attr);
        return $ob->display();
    }

    public function wbls_front_ajax() {
        $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
        if ( ! wp_verify_nonce( $nonce, 'wbls_ajax_nonce' ) ) {
            die( esc_html__( 'Security check', 'whistleblowing-system' ) );
        }
        $task = isset($_POST['task']) ? sanitize_text_field($_POST['task']) : '';
        require_once $this->plugin_dir . "/frontend/Controller.php";
        new WBLSFront_Controller($task);

    }
    public function wbls_admin_ajax() {
        $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
        if ( ! wp_verify_nonce( $nonce, 'wbls_ajax_nonce' ) ) {
            die( esc_html__( 'Security check', 'whistleblowing-system' ) );
        }
        $task = isset($_POST['task']) ? sanitize_text_field($_POST['task']) : '';

        require_once $this->plugin_dir . "/admin/Controller.php";
        new WBLS_Controller($task);

    }

    public function register_admin_scripts( $hook ) {
        wp_register_style($this->prefix . '-style', $this->plugin_url . '/admin/assets/css/style.css', array(), WBLS_VERSION);
        wp_register_script($this->prefix . '-conditions', $this->plugin_url . '/admin/assets/js/conditions.js', array('jquery'), WBLS_VERSION);
        wp_register_style($this->prefix . '-edit', $this->plugin_url . '/admin/assets/css/edit.css', array(), WBLS_VERSION);
        wp_enqueue_editor();
        wp_register_script($this->prefix . '-edit', $this->plugin_url . '/admin/assets/js/edit.js', array('jquery','jquery-ui-draggable', 'wbls-conditions', 'wp-editor'), WBLS_VERSION);
        wp_register_script($this->prefix . '-select2', $this->plugin_url . '/admin/assets/js/select2.min.js', array('jquery'), WBLS_VERSION);
        wp_register_style($this->prefix . '-select2', $this->plugin_url . '/admin/assets/css/select2.min.css', array(), WBLS_VERSION);
        wp_register_style($this->prefix . '-themes', $this->plugin_url . '/admin/assets/css/themes.css', array(), WBLS_VERSION);
        wp_register_script($this->prefix . '-themes', $this->plugin_url . '/admin/assets/js/themes.js',  array( 'jquery', 'wp-color-picker' ), WBLS_VERSION);
        wp_register_style($this->prefix . '-submissions', $this->plugin_url . '/admin/assets/css/submissions.css', array(), WBLS_VERSION);
        wp_register_script($this->prefix . '-submissions', $this->plugin_url . '/admin/assets/js/submissions.js',  array( 'jquery' ), WBLS_VERSION);
        wp_register_script($this->prefix . '-admin', $this->plugin_url . '/admin/assets/js/admin.js',  array( 'jquery' ), WBLS_VERSION);
        wp_enqueue_script( $this->prefix . '-admin');
        wp_localize_script($this->prefix . '-admin', 'wbls_admin', array(
            "ajaxnonce" => wp_create_nonce('wbls_ajax_nonce'),
            'form_success_delete' => esc_html__("Form successfully deleted", 'whistleblowing-system'),
            'theme_success_delete' => esc_html__("Theme successfully deleted", 'whistleblowing-system'),
            'form_error_delete' => esc_html__("Something went wrong", 'whistleblowing-system'),
            'success_save' => esc_html__("Data successfully saved", 'whistleblowing-system'),
        ));
        wp_enqueue_style($this->prefix . '-admin', $this->plugin_url . '/admin/assets/css/admin.css', array(), WBLS_VERSION);

        /* Deactivate scripts */
        if ( $hook === 'plugins.php' && !WBLS_PRO ) {
            wp_register_script($this->prefix . '-deactivate', $this->plugin_url . '/Apps/deactivate/assets/deactivate.js', array('jquery'), WBLS_VERSION);
            // Pass AJAX URL to the script
            wp_localize_script($this->prefix . '-deactivate', 'deactivate_options', [
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('wbls_ajax_nonce'),
                'pro' => WBLS_PRO,
            ]);
            wp_register_style($this->prefix . '-deactivate', $this->plugin_url . '/Apps/deactivate/assets/deactivate.css', array(), WBLS_VERSION);
        }
    }

    public function register_frontend_scripts() {
        $recaptcha = json_decode( get_option( 'wbls_global_settings' ), 1 );
        if( !empty($recaptcha) ) {
            $lng = empty($recaptcha['reCAPTCHA_language']) ? 'en' : esc_html($recaptcha['reCAPTCHA_language']);
            wp_register_script($this->prefix . '-recaptcha-v3', 'https://www.google.com/recaptcha/api.js?hl=' . $lng . '&onload=onloadCallbackv3&render=' . $recaptcha['reCAPTCHA_v3_site_key'], [], null, true);
            wp_register_script($this->prefix . '-recaptcha-v2', 'https://www.google.com/recaptcha/api.js?hl=' . $lng . '&onload=onloadCallback', [], null, ['strategy' => 'async']);
        }
        wp_register_script('wbls-script', WBLS_URL . '/frontend/assets/js/script.js', array('jquery'), WBLS_VERSION, true);
    }

    public function init() {
        $this->wbls_register_cpt();
        load_plugin_textdomain( 'whistleblowing-system', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');
    }

    public function admin_menu() {
        $nicename = 'Whistleblower';
        add_menu_page($nicename, $nicename, 'manage_options', 'whistleblower_forms', array( $this, 'admin_pages' ), WBLS_URL.'/admin/assets/images/logo.svg');
        add_submenu_page('whistleblower_forms', esc_html__('All Forms', 'whistleblowing-system'), esc_html__('All Forms', 'whistleblowing-system'), 'manage_options', 'whistleblower_forms', array($this, 'admin_pages'));
        // add_submenu_page('whistleblower_forms', esc_html__('Form', 'whistleblowing-system'), esc_html__('Form', 'whistleblowing-system'), 'manage_options', 'whistleblower_form', array($this, 'admin_pages'));
        add_submenu_page('whistleblower_forms', esc_html__('Submissions', 'whistleblowing-system'), esc_html__('Submissions', 'whistleblowing-system'), 'manage_options', 'whistleblower_submissions', array($this, 'admin_pages'));
        add_submenu_page('whistleblower_forms', esc_html__('Settings', 'whistleblowing-system'), esc_html__('Settings', 'whistleblowing-system'), 'manage_options', 'whistleblower_settings', array($this, 'admin_pages'));
        add_submenu_page(null, esc_html__('Edit', 'whistleblowing-system'), esc_html__('Edit', 'whistleblowing-system'), 'manage_options', 'whistleblower_form_edit', array($this, 'admin_pages'));
        add_submenu_page(null, esc_html__('Edit', 'whistleblowing-system'), esc_html__('Edit', 'whistleblowing-system'), 'manage_options', 'whistleblower_submission_edit', array($this, 'admin_pages'));
        add_submenu_page(null, esc_html__('Edit', 'whistleblowing-system'), esc_html__('Edit', 'whistleblowing-system'), 'manage_options', 'whistleblower_theme_edit', array($this, 'admin_pages'));
        add_submenu_page('whistleblower_forms', esc_html__('Themes', 'whistleblowing-system'), esc_html__('Themes', 'whistleblowing-system'), 'manage_options', 'whistleblower_themes', array($this, 'admin_pages'));
    }

    public function admin_pages() {
        $page = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : '';
        require_once $this->plugin_dir.'/admin/'.$page."_page.php";
        $class_name = str_replace("_"," ", $page);
        $class_name = str_replace(" ", "", ucwords($class_name));
        if( class_exists($class_name) ) {
            new $class_name();
        }
    }


    function wbls_register_cpt() {
        register_post_type('wbls_form',
            array(
                'labels'      => array(
                    'name'          => __('Forms', 'whistleblowing-system'),
                    'singular_name' => __('Form', 'whistleblowing-system'),
                ),
                'public'              => true,
                'exclude_from_search' => true,
                'show_menu'          => false,
                'show_ui'             => false,
                'show_in_admin_bar'   => false,
                'rewrite'             => false,
                'query_var'           => false,
                'can_export'          => false,
                'supports'            => [ 'title', 'author', 'revisions' ],
                'capability_type'     => 'post', // Not using 'capability_type' anywhere. It just has to be custom for security reasons.
                'map_meta_cap'        => false, // Don't let WP to map meta caps to have a granular control over this process via 'map_meta_cap' filter.
            )
        );


        $labels = array(
            'name'                => esc_html_x( 'Submissions', 'Post Type General Name', 'whistleblowing-system' ),
            'singular_name'       => esc_html_x( 'Submission', 'Post Type Singular Name', 'whistleblowing-system' ),
            'menu_name'           => esc_html__( 'Submissions', 'whistleblowing-system' ),
            'name_admin_bar'      => esc_html__( 'Submissions', 'whistleblowing-system' ),
            'parent_item_colon'   => esc_html__( 'Parent Item:', 'whistleblowing-system' ),
            'all_items'           => esc_html__( 'All Items', 'whistleblowing-system' ),
            'add_new_item'        => esc_html__( 'Add New Item', 'whistleblowing-system' ),
            'add_new'             => esc_html__( 'Add New', 'whistleblowing-system' ),
            'new_item'            => esc_html__( 'New Item', 'whistleblowing-system' ),
            'edit_item'           => esc_html__( 'Edit Item', 'whistleblowing-system' ),
            'update_item'         => esc_html__( 'Update Item', 'whistleblowing-system' ),
            'view_item'           => esc_html__( 'View Item', 'whistleblowing-system' ),
            'search_items'        => esc_html__( 'Search Item', 'whistleblowing-system' ),
            'not_found'           => '',
            'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'whistleblowing-system' ),
        );

        $args = array(
            'label'               => esc_html__( 'Submission', 'whistleblowing-system' ),
            'description'         => esc_html__( 'Form Submissions', 'whistleblowing-system' ),
            'labels'              => $labels,
            'supports'            => false,
            'hierarchical'        => false,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'menu_position'       => 5,
            'show_in_admin_bar'   => false,
            'show_in_nav_menus'   => false,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'rewrite'             => false,
            'capabilities' => array(
                'publish_posts' => 'wbls_form_subm',
                'edit_posts' => 'wbls_form_subm',
                'edit_others_posts' => 'wbls_form_subm',
                'delete_posts' => 'wbls_form_subm',
                'delete_others_posts' => 'wbls_form_subm',
                'read_private_posts' => 'wbls_form_subm',
                'edit_post' => 'wbls_form_subm',
                'delete_post' => 'wbls_form_subm',
                'read_post' => 'wbls_form_subm',
            ),
        );
        register_post_type( 'wbls_form_subm', $args );

        $labels = array(
            'name'                => esc_html_x( 'Themes', 'Post Type General Name', 'whistleblowing-system' ),
            'singular_name'       => esc_html_x( 'Theme', 'Post Type Singular Name', 'whistleblowing-system' ),
            'menu_name'           => esc_html__( 'Themes', 'whistleblowing-system' ),
            'name_admin_bar'      => esc_html__( 'Themes', 'whistleblowing-system' ),
            'parent_item_colon'   => esc_html__( 'Parent Item:', 'whistleblowing-system' ),
            'all_items'           => esc_html__( 'All themes', 'whistleblowing-system' ),
            'add_new_item'        => esc_html__( 'Add New theme', 'whistleblowing-system' ),
            'add_new'             => esc_html__( 'Add New', 'whistleblowing-system' ),
            'new_item'            => esc_html__( 'New Item', 'whistleblowing-system' ),
            'edit_item'           => esc_html__( 'Edit Item', 'whistleblowing-system' ),
            'update_item'         => esc_html__( 'Update Item', 'whistleblowing-system' ),
            'view_item'           => esc_html__( 'View Item', 'whistleblowing-system' ),
            'search_items'        => esc_html__( 'Search Item', 'whistleblowing-system' ),
            'not_found'           => '',
            'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'whistleblowing-system' ),
        );
        $args = array(
            'label'               => esc_html__( 'Theme', 'whistleblowing-system' ),
            'description'         => esc_html__( 'Form themes', 'whistleblowing-system' ),
            'labels'              => $labels,
            'supports'            => false,
            'hierarchical'        => false,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'menu_position'       => 100,
            'show_in_admin_bar'   => false,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'rewrite'             => false,
            'capabilities' => array(
                'publish_posts' => 'wbls_theme',
                'edit_posts' => 'wbls_theme',
                'edit_others_posts' => 'wbls_theme',
                'delete_posts' => 'wbls_theme',
                'delete_others_posts' => 'wbls_theme',
                'read_private_posts' => 'wbls_theme',
                'edit_post' => 'wbls_theme',
                'delete_post' => 'wbls_theme',
                'read_post' => 'wbls_theme',
            ),
        );
        register_post_type( 'wbls_theme', $args );
        flush_rewrite_rules();
    }
}

function WBLS_WhistleBlower() {
    return WBLS_WhistleBlower::instance();
}

WBLS_WhistleBlower();