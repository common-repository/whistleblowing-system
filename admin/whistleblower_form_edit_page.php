<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WhistleblowerFormEdit {
    public $form_fields = array(
            'text' => array(
                'type' => 'text',
                'title' => 'Single Line Text',
                'description' => '',
                'value' => '',
                'name' => '',
                'icon' => '',
                'order' => '0',
                'public' => true,
                'class' => '',
                'id' => '',
                'label' => 'Single Line Text',
                'placeholder' => '',
                'pro' => 0,
                'required' => 0,
            ),
            'textarea' => array(
                'type' => 'textarea',
                'title' => 'Paragraph Text',
                'description' => '',
                'value' => '',
                'name' => '',
                'icon' => '',
                'order' => '1',
                'public' => true,
                'class' => '',
                'id' => '',
                'label' => 'Paragraph Text',
                'placeholder' => '',
                'pro' => 0,
                'required' => 0,
            ),
            'checkbox' => array(
                'type' => 'checkbox',
                'title' => 'Checkbox',
                'description' => '',
                'value' => '',
                'name' => '',
                'options' => array(
                    array('miniLabel' =>'New Choice', 'name' => '', 'checked' => '0', 'order' => 1),
                ),
                'icon' => '',
                'order' => '2',
                'public' => true,
                'class' => '',
                'id' => '',
                'label' => 'Checkbox',
                'pro' => 0,
                'required' => 0,
            ),
            'radio' => array(
                'type' => 'radio',
                'title' => 'Single Choice',
                'description' => '',
                'value' => '',
                'name' => '',
                'options' => array(
                    array('key'=>'First Choice', 'val' => 'First Choice', 'order' => 1),
                    array('key'=>'Second Choice', 'val' => 'Second Choice', 'order' => 2),
                    array('key'=>'Third Choice', 'val' => 'Third Choice', 'order' => 3),
                ),
                'default_option' => 0,
                'icon' => '',
                'order' => '3',
                'public' => true,
                'class' => '',
                'id' => '',
                'label' => 'Single Choice',
                'pro' => 0,
                'required' => 0,
            ),
            'select' => array(
                'type' => 'select',
                'title' => 'Dropdown',
                'description' => '',
                'value' => '',
                'name' => '',
                'options' => array(
                       array('key'=>'Option 1', 'val' => 'Option 1', 'order' => 1),
                       array('key'=>'Option 2', 'val' => 'Option 2', 'order' => 2),
                       array('key'=>'Option 3', 'val' => 'Option 3', 'order' => 3),
                ),
                'default_option' => 0,
                'icon' => '',
                'order' => '3',
                'public' => true,
                'class' => '',
                'id' => '',
                'label' => 'Dropdown',
                'pro' => 1,
                'required' => 0,
            ),
            'email' => array(
                'type' => 'email',
                'title' => 'Email',
                'description' => '',
                'value' => '',
                'name' => '',
                'icon' => '',
                'order' => '0',
                'public' => true,
                'class' => '',
                'id' => '',
                'label' => 'Email',
                'placeholder' => '',
                'pro' => 0,
                'required' => 0,
            ),
            'number' => array(
                'type' => 'number',
                'title' => 'Number',
                'description' => '',
                'value' => '',
                'name' => '',
                'icon' => '',
                'order' => '0',
                'public' => true,
                'class' => '',
                'id' => '',
                'label' => 'Number',
                'placeholder' => '',
                'pro' => 0,
                'required' => 0,
            ),
            'file' => array(
                'type' => 'file',
                'title' => 'Upload',
                'description' => '',
                'value' => '',
                'name' => '',
                'icon' => '',
                'order' => '0',
                'public' => true,
                'class' => '',
                'id' => '',
                'label' => 'Upload',
                'placeholder' => '',
                'pro' => 1,
                'required' => 0,
                'multiple' => 0,
            ),
            'fullName' => array(
                'type' => 'fullName',
                'title' => 'Full Name',
                'description' => '',
                'value' => '',
                'name' => '',
                'icon' => '',
                'order' => '0',
                'public' => true,
                'class' => '',
                'id' => '',
                'label' => 'Name',
                'placeholder' => '',
                'pro' => 0,
                'required' => 0,
                'fname' => '',
                'mname' => '',
                'lname' => '',
                'firstNamePlaceholder' => '',
                'firstNameMiniLabel' => 'First',
                'lastNamePlaceholder' => '',
                'lastNameMiniLabel' => 'Last',
                'middleNamePlaceholder' => '',
                'middleNameMiniLabel' => 'Middle',
                'hideMiddleName' => 1,
            ),
            'address' => array(
                'type' => 'address',
                'title' => 'Address',
                'description' => '',
                'value' => '',
                'name' => '',
                'icon' => '',
                'order' => '0',
                'public' => true,
                'class' => '',
                'id' => '',
                'label' => 'Address',
                'placeholder' => '',
                'pro' => 0,
                'required' => 0,
                'streetName' => '',
                'street1Name' => '',
                'cityName' => '',
                'stateName' => '',
                'postalName' => '',
                'countryName' => '',
                'streetPlaceholder' => '',
                'streetMiniLabel' => 'Street Address',
                'street1Placeholder' => '',
                'street1MiniLabel' => 'Street Address Line 2',
                'cityPlaceholder' => '',
                'cityMiniLabel' => 'City',
                'statePlaceholder' => '',
                'stateMiniLabel' => 'State / Province / Region',
                'postalPlaceholder' => '',
                'postalMiniLabel' => 'Postal / Zip Code',
                'countryPlaceholder' => '',
                'countryMiniLabel' => 'Country',
                'hideStreet' => 0,
                'hideStreet1' => 0,
                'hideCity' => 0,
                'hideState' => 0,
                'hidePostal' => 0,
                'hideCountry' => 0,
            ),
            'submit' => array(
                'type' => 'submit',
                'title' => 'Submit Button',
                'description' => '',
                'value' => '',
                'name' => '',
                'icon' => '',
                'order' => '0',
                'public' => true,
                'class' => '',
                'id' => '',
                'label' => 'Submit',
                'placeholder' => '',
                'pro' => 0,
                'required' => 0,
            ),
            'recaptcha' => array(
                'type' => 'recaptcha',
                'title' => 'reCAPTCHA',
                'description' => '',
                'value' => '',
                'name' => '',
                'icon' => '',
                'order' => '0',
                'public' => true,
                'class' => '',
                'id' => '',
                'label' => 'Recaptcha',
                'placeholder' => '',
                'version' => 'v2',
                'score' => 0.5,
                'pro' => 1,
                'required' => 0,
            ),
            'page_break' => array(
                'type' => 'page_break',
                'title' => 'Page break',
                'progress_type' => 'none',
                'pageTitles' => array(),
                'next_button_text' => 'Next',
                'previous_button_text' => 'Previous',
                'show_previous' => 0,
                'default_option' => 0,
                'icon' => '',
                'order' => '3',
                'public' => true,
                'class' => '',
                'id' => '',
                'label' => 'Page break',
                'pro' => 1,
                'required' => 0,
            ),

    );

    public $teeny_active;

    public $whistleblower_active;

    public $fields_options = [];

    public function __construct() {
        $this->teeny_active = get_option('teeny_active', true);
        $task = isset($_GET['task']) ? sanitize_text_field($_GET['task']) : '';
        require_once 'includes/fields_templates.php';
        if ( method_exists($this, $task) ) {
            $this->$task();
        } else {
            $this->display();
        }
    }

    public function display() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $form_conditions = [];
        $form_settings = [];
        $this->whistleblower_active = 1;
        $form_title = esc_html__('Untitled Form', 'whistleblowing-system');
        $fieldNameLastId = 0;
        if( $id ) {
            $this->fields_options = get_post_meta( $id, 'wbls_field_options', true );
            $form_settings = get_post_meta( $id, 'wbls_form_settings', true );
            $form_conditions = get_post_meta( $id, 'wbls_form_conditions', true );
            if( empty($form_conditions) ) {
                $form_conditions = [];
            }
            $this->whistleblower_active = $form_settings['whistleblower_active'] ?? 1;
            $form_title = get_the_title($id);
            $fieldNameLastId = get_post_meta($id, 'wbls_fieldNameLastId', true);
        }
        $default_theme = get_option( 'wbls_theme_default' );
        $active_theme = $form_settings['active_theme'] ?? $default_theme;


        $permalink = '';
        if( $id ) {
            $permalink = get_post_permalink($id,true);
        }
        $recaptcha_active = 0;
        $wbls_global_settings = json_decode( get_option( 'wbls_global_settings' ), 1 );
        if( !empty($wbls_global_settings) ) {
            if( $wbls_global_settings['reCAPTCHA_v2_site_key'] != '' || $wbls_global_settings['reCAPTCHA_v3_site_key'] != '' ) {
                $recaptcha_active = 1;
            }
        }
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_script( WBLS_WhistleBlower::instance()->prefix . '-conditions');
        wp_enqueue_script( WBLS_WhistleBlower::instance()->prefix . '-edit');
        wp_localize_script(WBLS_WhistleBlower::instance()->prefix . '-edit', 'wbls_edit', array(
            "form_fields" => $this->form_fields,
            "form_conditions" => $form_conditions,
            "fields_options" => $this->fields_options,
            "fieldNameLastId" => $fieldNameLastId,
            "ajaxnonce" => wp_create_nonce('wbls_ajax_nonce'),
            "pro" => WBLS_PRO,
            "recaptcha_active" => $recaptcha_active,
            "teeny_active" => $this->teeny_active,
        ));
        wp_enqueue_script( WBLS_WhistleBlower::instance()->prefix . '-select2');
        wp_enqueue_style(WBLS_WhistleBlower::instance()->prefix . '-select2');

        wp_enqueue_style(WBLS_WhistleBlower::instance()->prefix . '-edit');
        wp_enqueue_style(WBLS_WhistleBlower::instance()->prefix . '-style');
        $wp_upload_dir = wp_upload_dir();
        $wbls_style_dir = $wp_upload_dir[ 'basedir' ] . '/wbls-system/wbls-theme-style_' . $active_theme . '.css';
        $wbls_style_url = $wp_upload_dir[ 'baseurl' ] . '/wbls-system/wbls-theme-style_' . $active_theme . '.css';
        if( file_exists($wbls_style_dir) ) {
            wp_enqueue_style(WBLS_WhistleBlower::instance()->prefix . '-theme-style_' . $active_theme, $wbls_style_url, array(), WBLS_VERSION);
        } else {
            wp_enqueue_style(WBLS_WhistleBlower::instance()->prefix . '-theme-style', WBLS_URL . '/frontend/assets/css/default.css', array(), WBLS_VERSION);
        }

        ?>
        <div class="wbls-edit-page">
            <div class="wbls-admin-header">
                <div class="wbls-form-logo-row">
                </div>
                <div class="wbls-form-title-row">
                    <span class="wbls-form-title-label"></span>
                    <input type="text" id="wbls-form-title" class="wbls-form-title" placeholder="<?php esc_html_e('Form Title','whistleblowing-system'); ?>" value="<?php echo esc_html($form_title) ?>">
                </div>
                <div class="wbls-whistleblower-switcher">
                    <p><?php _e('WhistleBlower Off','whistleblowing-system'); ?></p>
                    <label class="wbls-switch">
                        <input class="wbls-whistleblower-active" type="checkbox" <?php echo $this->whistleblower_active ? 'checked' : ''?>>
                        <span class="wbls-slider wbls-round"></span>
                    </label>
                    <p><?php _e('On','whistleblowing-system'); ?></p>
                </div>

                <div class="wbls-top-menu-icon">
                    <span class="dashicons dashicons-menu-alt3"></span>
                    <div class="wbls-top-menu">
                        <div class="wbls-menu-group">
                            <div class="wbls-menu-grouptitle">Whistleblower Pages</div>
                            <a href="admin.php?page=whistleblower_forms" class="wbls-menu-item" target="_blank"><?php _e('All Forms','whistleblowing-system'); ?></a>
                            <a href="admin.php?page=whistleblower_form_edit" class="wbls-menu-item" target="_blank"><?php _e('Add New Form','whistleblowing-system'); ?></a>
                            <a href="admin.php?page=whistleblower_submissions" class="wbls-menu-item" target="_blank"><?php _e('Form Submissions','whistleblowing-system'); ?></a>
                            <a href="admin.php?page=whistleblower_settings" class="wbls-menu-item" target="_blank"><?php _e('Global Settings','whistleblowing-system'); ?></a>
                            <a href="admin.php?page=whistleblower_themes" class="wbls-menu-item" target="_blank"><?php _e('Form Themes','whistleblowing-system'); ?></a>
                        </div>
                        <div class="wbls-menu-group">
                            <div class="wbls-menu-grouptitle">Wordpress Pages</div>
                            <a href="index.php" class="wbls-menu-item" target="_blank"><?php _e('Dashboard','whistleblowing-system'); ?></a>
                            <a href="edit.php?post_type=page" class="wbls-menu-item" target="_blank"><?php _e('All Pages','whistleblowing-system'); ?></a>
                            <a href="edit.php" class="wbls-menu-item" target="_blank"><?php _e('All Posts','whistleblowing-system'); ?></a>
                            <a href="plugins.php" class="wbls-menu-item" target="_blank"><?php _e('Plugins','whistleblowing-system'); ?></a>
                            <a href="themes.php" class="wbls-menu-item" target="_blank"><?php _e('Themes','whistleblowing-system'); ?></a>
                            <a href="opload.php" class="wbls-menu-item" target="_blank"><?php _e('Media','whistleblowing-system'); ?></a>
                        </div>
                    </div>
                </div>


                <span class="wbls-button wbls-embed-form">
                    <span class="dashicons dashicons-shortcode"></span>
                    <?php esc_html_e('Shortcode', 'whistleblowing-system') ?>
                </span>
                <?php if( $id ) { ?>
                <a href="<?php echo esc_url($permalink)?>" target="_blank" class="wbls-button wbls-preview-button">
                    <span class="dashicons dashicons-visibility"></span>
                    <?php esc_html_e('Preview', 'whistleblowing-system') ?>
                </a>
                <?php } ?>
                <span class="wbls-button wbls-add-form"><?php esc_html_e('Save', 'whistleblowing-system') ?></span>
                <div class="wbls-edit-close-row">
                    <a href="?page=whistleblower_forms" class="wbls-edit-close"><span class="dashicons dashicons-no"></span></a>
                </div>
            </div>
            <div class="wbls-form-menu">
                <span data-content="wbls-form-field-menu" class="wbls-form-menu-item wbls-form-menu-item-active wbls-form-field-menu"><?php echo esc_html__("Fields", "whistleblowing-system") ?></span>
                <span data-content="wbls-form-header-menu" class="wbls-form-menu-item wbls-form-header-menu"><?php echo esc_html__("Headers", "whistleblowing-system") ?></span>
                <span data-content="wbls-form-email-options-menu" class="wbls-form-menu-item wbls-form-email-options-menu"><?php echo esc_html__("Email Options", "whistleblowing-system") ?></span>
                <span data-content="wbls-form-displayOption-menu" class="wbls-form-menu-item wbls-form-displayOption-menu"><?php echo esc_html__("Display options", "whistleblowing-system") ?></span>
                <span data-content="wbls-form-settings-menu" class="wbls-form-menu-item wbls-form-settings-menu"><?php echo esc_html__("Settings", "whistleblowing-system") ?></span>
            </div>
            <div class="wbls-body">
                <div class="wbls-sidebar">
                    <?php
                    $this->fields_sidebar();
                    $this->headers_sidebar();
                    $this->email_options_sidebar();
                    $this->display_options_sidebar();
                    $this->settings_sidebar();
                    ?>
                </div>
                <div class="wbls-content">
                    <?php
                    $this->fields();
                    $this->headers( $form_settings );
                    $this->email_options( $id, $this->fields_options );
                    $this->display_options( $form_settings );
                    $this->settings( $form_settings );
                    ?>
                </div>
            </div>
            <?php
            if( $id ) {
                $this->shortcode_popup( $id );
            }
            ?>
        </div>
        <?php
    }

    private function fields_sidebar() {
        ?>
        <div class="wbls-sidebar-menu" id="wbls-form-field-menu-sidebar">
            <div class="wbls-sidebar-tabs">
                <div id="wbls-sidebar-fields-tab" class="wbls-sidebar-tab wbls-sidebar-tab-active"><?php esc_html_e('Add Fields', 'whistleblowing-system') ?></div>
                <div id="wbls-sidebar-field-options-tab" class="wbls-sidebar-tab"><?php esc_html_e('Field Options', 'whistleblowing-system') ?></div>
            </div>
            <div class="wbls-sidebar-fields-content">
                <?php $this->fields_content(); ?>
            </div>
            <div class="wbls-sidebar-field-options-content" style="display: none">
            </div>
        </div>
        <?php
    }

    private function fields() {
    ?>
        <div id="wbls-form-field-menu" class="wbls-form-menu-item-content wbls-form-edit-content">
            <div class="wbls-form-content">
                <?php $this->form_content(); ?>
            </div>
        </div>
        <?php
    }

    private function headers_sidebar() {
        ?>
        <div class="wbls-sidebar-menu" id="wbls-form-header-menu-sidebar" style="display: none">
            <span id="wbls-sidebar-form-header" class="wbls-sidebar-menu-item wbls-sidebar-menu-item-active">
                <?php esc_html_e('Form Header', 'whistleblowing-system'); ?>
            </span>
            <span id="wbls-sidebar-token-header" class="wbls-sidebar-menu-item">
                <?php esc_html_e('Token Header', 'whistleblowing-system'); ?>
            </span>
            <span id="wbls-sidebar-login-header" class="wbls-sidebar-menu-item">
                <?php esc_html_e('Login Header', 'whistleblowing-system'); ?>
            </span>
        </div>
        <?php
    }

    private function headers( $form_settings ) {
        ?>
        <div id="wbls-form-header-menu" class="wbls-form-menu-item-content wbls-header-container" style="display: none">
            <?php
            $show_form_header = !empty($form_settings['show_form_header']) ? $form_settings['show_form_header'] : 0;
            $show_token_header = !empty($form_settings['show_token_header']) ? $form_settings['show_token_header'] : 0;
            $show_login_header = !empty($form_settings['show_login_header']) ? $form_settings['show_login_header'] : 0;
            $form_header = !empty($form_settings['form_header']) ? $form_settings['form_header'] : '';
            $token_header = !empty($form_settings['token_header']) ? $form_settings['token_header'] : '';
            $login_header = !empty($form_settings['login_header']) ? $form_settings['login_header'] : '';
            ?>
            <div class="wbls-form-content">
                <div class="wbls-option-section-column">
                    <div class="wbls-option-section wbls-sidebar-menu-item-content wbls-sidebar-form-header">
                        <div class="wbls-option-section-content">
                            <div class="wbls-option-section-group">
                                <label><?php _e('Show header', 'whistleblowing-system'); ?></label>
                                <input type="radio" name="show_form_header" class="wbls-show-form-header" value="1" <?php echo $show_form_header ? 'checked' : ''; ?>> Yes
                                <input type="radio" name="show_form_header" class="wbls-show-form-header" value="0" <?php echo !$show_form_header ? 'checked' : ''; ?>> No
                                <p class="wbls-option-section-group-description">
                                    <?php _e('Enable the option to show form header in the frontend above the form', 'whistleblowing-system'); ?>
                                </p>
                            </div>
                            <div class="wbls-option-section-group">
                                <label><?php _e('Header text', 'whistleblowing-system'); ?></label>
                                <?php
                                if ( user_can_richedit() && $this->teeny_active ) {
                                    wp_editor(
                                            wp_kses($form_header, WBLSLibrary::$wp_kses_default),
                                            'wbls_form_header',
                                            array(
                                                'textarea_name' => 'wbls_form_header',
                                                'media_buttons' => false,
                                                'textarea_rows' => 10,
                                                'teeny'         => false,
                                                'quicktags'     => true,
                                            ),
                                    );
                                }
                                else {
                                    ?>
                                    <textarea name="wbls_form_header" id="wbls-form-header" class="wbls-form-header"><?php echo wp_kses($form_header, WBLSLibrary::$wp_kses_default); ?></textarea>
                                    <?php
                                }
                                ?>
                                <p class="wbls-option-section-group-description">
                                    <?php _e('The header text is visible on the frontend above the form.', 'whistleblowing-system'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="wbls-option-section wbls-sidebar-menu-item-content wbls-sidebar-token-header" style="display: none">
                        <div class="wbls-option-section-content">
                            <div class="wbls-option-section-group">
                                <label><?php _e('Show header', 'whistleblowing-system'); ?></label>
                                <input type="radio" name="show_token_header" class="wbls-show-token-header" value="1" <?php echo $show_token_header ? 'checked' : ''; ?>> Yes
                                <input type="radio" name="show_token_header" class="wbls-show-token-header" value="0" <?php echo !$show_token_header ? 'checked' : ''; ?>> No
                                <p class="wbls-option-section-group-description">
                                    <?php _e('Enable the option to show the token header in the frontend above the copy token field in the popup that appears after form submission.', 'whistleblowing-system'); ?>
                                </p>
                            </div>
                            <div class="wbls-option-section-group">
                                <label><?php _e('Header text', 'whistleblowing-system'); ?></label>
                                <?php
                                if ( user_can_richedit() && $this->teeny_active ) {
                                    wp_editor(
                                        wp_kses($token_header, WBLSLibrary::$wp_kses_default),
                                        'wbls_token_header',
                                        array(
                                            'textarea_name' => 'wbls_token_header',
                                            'media_buttons' => false,                 // Show the "Add Media" button
                                            'textarea_rows' => 10,                   // Set the height of the editor
                                            'teeny'         => false,                // Whether to load the minimal TinyMCE editor
                                            'quicktags'     => true,                 // Enable the Text mode (HTML editor)
                                        ),
                                    );
                                }
                                else {
                                    ?>
                                    <textarea name="wbls_token_header" id="wbls-token-header" class="wbls-token-header"><?php echo wp_kses($token_header, WBLSLibrary::$wp_kses_default); ?></textarea>
                                    <?php
                                }
                                ?>
                                <p class="wbls-option-section-group-description">
                                    <?php _e('The header text is visible on the token header in the frontend above the copy token field in the popup that appears after form submission.', 'whistleblowing-system'); ?>
                                </p>
                            </div>
                        </div>
                    </div sty>
                    <div class="wbls-option-section wbls-sidebar-menu-item-content wbls-sidebar-login-header" style="display: none">
                        <div class="wbls-option-section-title" style="display: none">
                            <strong><?php _e('Login header', 'whistleblowing-system'); ?></strong>
                        </div>
                        <div class="wbls-option-section-content">
                            <div class="wbls-option-section-group">
                                <label><?php _e('Show header', 'whistleblowing-system'); ?></label>
                                <input type="radio" name="show_login_header" class="wbls-show-login-header" value="1" <?php echo $show_login_header ? 'checked' : ''; ?>> Yes
                                <input type="radio" name="show_login_header" class="wbls-show-login-header" value="0" <?php echo !$show_login_header ? 'checked' : ''; ?>> No
                                <p class="wbls-option-section-group-description">
                                    <?php _e('Enable the option to show login page/popup header in the frontend above the login input', 'whistleblowing-system'); ?>
                                </p>
                            </div>
                            <div class="wbls-option-section-group">
                                <label><?php _e('Header text', 'whistleblowing-system'); ?></label>
                                <?php
                                if ( user_can_richedit() && $this->teeny_active ) {
                                    wp_editor(
                                        wp_kses($login_header, WBLSLibrary::$wp_kses_default),
                                        'wbls_login_header',
                                        array(
                                            'textarea_name' => 'wbls_login_header',
                                            'media_buttons' => false,
                                            'textarea_rows' => 10,
                                            'teeny'         => false,
                                            'quicktags'     => true,
                                        ),
                                    );
                                }
                                else {
                                    ?>
                                    <textarea name="wbls_login_header" id="wbls-login-header" class="wbls-login-header"><?php echo wp_kses($login_header, WBLSLibrary::$wp_kses_default); ?></textarea>
                                    <?php
                                }
                                ?>
                                <p class="wbls-option-section-group-description">
                                    <?php _e('The header text is visible on the frontend above the login form.', 'whistleblowing-system'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    private function email_options_sidebar() {
        ?>
        <div class="wbls-sidebar-menu" id="wbls-form-email-options-menu-sidebar" style="display: none">
            <span id="wbls-sidebar-email-on" class="wbls-sidebar-menu-item wbls-sidebar-menu-item-active">
                <?php esc_html_e('Send Notification Email', 'whistleblowing-system'); ?>
            </span>
            <span id="wbls-sidebar-email-admin" class="wbls-sidebar-menu-item">
                <?php esc_html_e('Email to Administrator', 'whistleblowing-system'); ?>
            </span>
            <span id="wbls-sidebar-email-user" class="wbls-sidebar-menu-item">
                <?php esc_html_e('Email to User', 'whistleblowing-system'); ?>
            </span>
        </div>
        <?php
    }

    private function email_options( $id, $fields_options ) {
        $email_options = get_post_meta($id, 'wbls_email_options', true);
        $email_option = array(
            'sendemail' => isset($email_options['sendemail']) ? intval($email_options['sendemail']) : 0,
            'admin_mail' => isset($email_options['admin_mail']) ? esc_html($email_options['admin_mail']) : '',
            'wbls_mail_from' => isset($email_options['wbls_mail_from']) ? esc_html($email_options['wbls_mail_from']) : '',
            'from_name' => isset($email_options['from_name']) ? esc_html($email_options['from_name']) : '',
            'mail_subject' => isset($email_options['mail_subject']) ? esc_html($email_options['mail_subject']) : '',
            'wbls_mail_body' => isset($email_options['wbls_mail_body']) ? wp_kses($email_options['wbls_mail_body'], WBLSLibrary::$wp_kses_default) : '',
            'wbls_user_send_to' => isset($email_options['wbls_user_send_to']) ? intval($email_options['wbls_user_send_to']) : '0',
            'wbls_user_mail_from' => isset($email_options['wbls_user_mail_from']) ? esc_html($email_options['wbls_user_mail_from']) : '',
            'wbls_user_from_name' => isset($email_options['wbls_user_from_name']) ? esc_html($email_options['wbls_user_from_name']) : '',
            'wbls_user_mail_subject' => isset($email_options['wbls_user_mail_subject']) ? esc_html($email_options['wbls_user_mail_subject']) : '',
            'wbls_user_mail_body' => isset($email_options['wbls_user_mail_body']) ? wp_kses($email_options['wbls_user_mail_body'], WBLSLibrary::$wp_kses_default) : '',
            );
        ?>
        <div id="wbls-form-email-options-menu" class="wbls-emailOptions-container wbls-form-menu-item-content" style="display:none;">
            <div id="form_email_options_tab_content" class="adminform js">
                <div class="wbls-table wbls-sidebar-email-on wbls-sidebar-menu-item-content">
                    <div class="wbls-table-col-100">
                        <div class="wbls-box-section">
                            <div class="wbls-box-content">
                                <div class="wbls-group">
                                    <label class="wbls-label"><?php _e('Send Notification Email','whistleblowing-system'); ?></label>
                                    <input type="radio" name="sendemail" <?php echo $email_option['sendemail'] == 1 ? 'checked="checked"' : '' ?> id="wbls_sendemail-1" class="wbls-radio wbls_sendemail" value="1" />
                                    <label class="wbls-label-radio" for="wbls_sendemail-1"><?php _e('Yes', 'whistleblowing-system'); ?></label>
                                    <input type="radio" name="sendemail" <?php echo $email_option['sendemail'] == 0 ? 'checked="checked"' : '' ?> id="wbls_sendemail-0" class="wbls-radio wbls_sendemail" value="0" />
                                    <label class="wbls-label-radio" for="wbls_sendemail-0"><?php _e('No', 'whistleblowing-system'); ?></label>
                                    <p class="description"><?php _e('Enable this setting to send submitted information to administrators and/or the submitter.', 'whistleblowing-system'); ?></p>
                                    <p class="description wbls_email_options"><?php _e('In case you cannot find the submission email in your Inbox, make sure to check the Spam folder as well.', 'whistleblowing-system'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wbls-table meta-box-sortables wbls_email_options wbls-sidebar-email-admin wbls-sidebar-menu-item-content" id="emailTab_fieldset" style="display: none">
                    <div class="wbls-table-col-100 wbls-table-col-left">
                        <div class="wbls-box-section">
                            <div class="wbls-box-title">
                                <h3><?php _e('Email to Administrator', 'whistleblowing-system'); ?></h3>
                            </div>
                            <div class="wbls-box-content">
                                <div class="wbls-group wbls-has-placeholder">
                                    <label class="wbls-label" for="mail"><?php _e('Email to send submissions to', 'whistleblowing-system'); ?></label>
                                    <input autocomplete="off" class="wbls-validate" data-type="email" data-callback="wbls_validate_email" data-callback-parameter="" data-tab-id="emailTab" data-content-id="emailTab_fieldset" type="text" id="mail" name="mail" value="<?php echo $email_option['admin_mail']; ?>" />
                                    <p class="description"><?php _e('Specify the email address(es), to which submitted form information will be sent. For multiple email addresses separate with commas.', 'whistleblowing-system'); ?></p>
                                </div>
                                <div class="wd-group<?php echo WBLS_PRO ? '' : ' wbls-pro-tooltip wbls-pro-tooltip-action'; ?>">
                                    <label class="wbls-label"><?php _e('Email From', 'whistleblowing-system'); ?></label>
                                    <input class="wbls-validate" data-type="email" data-callback="wbls_validate_email" data-callback-parameter="" data-tab-id="emailTab" data-content-id="emailTab_fieldset" type="text" name="wbls_mail_from" id="wbls_mail_from" value="<?php echo $email_option['wbls_mail_from']; ?>" />
                                    <p class="description"><?php _e('Specify the email address from which the administrator will receive the email.', 'whistleblowing-system'); ?></p>
                                    <p class="description"><?php _e('We recommend you to use an email address belonging to your website domain.', 'whistleblowing-system'); ?></p>
                                    <div id="wbls-email-from-info" class="wbls-hide">
                                        <p><?php _e('If sender email address is not hosted on the same domain as your website, some hosting providers may not send the emails.', 'whistleblowing-system'); ?></p>
                                        <p><?php _e('In addition, relaying mail servers may consider the emails as phishing.', 'whistleblowing-system'); ?></p>
                                    </div>
                                </div>
                                <div class="wbls-group wd-has-placeholder<?php echo WBLS_PRO ? '' : ' wbls-pro-tooltip wbls-pro-tooltip-action'; ?>">
                                    <label class="wbls-label" for="from_name"><?php _e('From Name', 'whistleblowing-system'); ?></label>
                                    <input autocomplete="off" type="text" name="from_name" value="<?php echo $email_option['from_name']; ?>" id="from_name" />
                                    <p class="description"><?php _e('Set the name or search for a form field which is shown as the sender’s name in submission or confirmation emails.', 'whistleblowing-system'); ?></p>
                                </div>
                                <div class="wbls-group wbls-has-placeholder<?php echo WBLS_PRO ? '' : ' wbls-pro-tooltip wbls-pro-tooltip-action'; ?>">
                                    <label class="wbls-label" for="mail_subject"><?php _e('Subject', 'whistleblowing-system'); ?></label>
                                    <?php $this->placeholder_buttons($this->fields_options, 'text','wbls-subject-field'); ?>
                                    <input autocomplete="off" type="text" id="mail_subject" name="mail_subject" value="<?php echo $email_option['mail_subject']; ?>" />
                                    <p class="description"><?php _e('Add a custom subject or search for a form field for the submission email. In case it’s left blank, Form Title will be set as the subject of submission emails.', 'whistleblowing-system'); ?></p>
                                </div>
                                <div class="wd-group<?php echo WBLS_PRO ? '' : ' wbls-pro-tooltip wbls-pro-tooltip-action'; ?>">
                                    <label class="wbls-label" for="wbls_mail_body"><?php _e('Custom Text in Email For Administrator', 'whistleblowing-system'); ?></label>
                                    <?php
                                    $this->placeholder_buttons($this->fields_options,'','', ['admin_token' => 'Admin Token']);
                                    if ( user_can_richedit() && $this->teeny_active ) {
                                        wp_editor($email_option['wbls_mail_body'], 'wbls_mail_body', array(
                                            'textarea_name' => 'wbls_mail_body',
                                            'media_buttons' => false,
                                            'textarea_rows' => 10,
                                            'teeny'         => false,
                                            'quicktags'     => true,
                                        ));
                                    }
                                    else {
                                        ?>
                                        <textarea name="wbls_mail_body" id="wbls_mail_body" cols="20" rows="10" style="width:100%; height:200px;"><?php echo wp_kses($email_option['wbls_mail_body'], WBLSLibrary::$wp_kses_default); ?></textarea>
                                        <?php
                                    }
                                    ?>
                                    <p class="description"><?php _e('Write custom content to the email message which is sent to administrator. Include All Fields List to forward all submitted information, or click on fields buttons to use individual field values in the content.', 'whistleblowing-system'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wbls-table meta-box-sortables wbls_user_email_options wbls_email_options wbls-sidebar-email-user wbls-sidebar-menu-item-content" id="emailTab_fieldset" style="display: none">
                    <div class="wbls-table-col-100 wbls-table-col-left">
                        <div class="wbls-box-section">
                            <div class="wbls-box-title">
                                <h3><?php _e('Email to User', 'whistleblowing-system'); ?></h3>
                            </div>
                            <div class="wbls-box-content">
                                <div class="wbls-has-placeholder wd-group<?php echo WBLS_PRO ? '' : ' wbls-pro-tooltip wbls-pro-tooltip-action'; ?>">
                                    <?php if( !empty(WBLSLibrary::is_emailField_exists($this->fields_options)) ) { ?>
                                        <label class="wbls-label" for="mail"><?php _e('Email', 'whistleblowing-system'); ?></label>
                                        <input type="checkbox" name="wbls_user_send_to" id="wbls_user_send_to"  <?php echo $email_option['wbls_user_send_to'] == 1 ? 'checked="checked"' : '' ?> value="1" />
                                        <p class="description"><?php _e('Use this setting to select the email field of your form, to which the submissions will be sent.', 'whistleblowing-system'); ?></p>
                                    <?php } else { ?>
                                        <p><b><?php _e('There is no email field', 'whistleblowing-system'); ?></b></p>
                                        <p class="description"><?php _e('Use this setting to select the email field of your form, to which the submissions will be sent.', 'whistleblowing-system'); ?></p>
                                    <?php } ?>
                                </div>
                                <div class="wd-group<?php echo WBLS_PRO ? '' : ' wbls-pro-tooltip wbls-pro-tooltip-action'; ?>">
                                    <label class="wbls-label"><?php _e('Email From', 'whistleblowing-system'); ?></label>
                                    <input class="wbls-validate" data-type="email" data-callback="wbls_validate_email" data-callback-parameter="" data-tab-id="emailTab" data-content-id="emailTab_fieldset" type="text" name="wbls_user_mail_from" id="wbls_user_mail_from" value="<?php echo $email_option['wbls_user_mail_from']; ?>" />
                                    <p class="description"><?php _e('Specify the email address from which the user will receive the email.', 'whistleblowing-system'); ?></p>
                                    <p class="description"><?php _e('We recommend you to use an email address belonging to your website domain.', 'whistleblowing-system'); ?></p>
                                    <div id="wbls-email-from-info" class="wbls-hide">
                                        <p><?php _e('If sender email address is not hosted on the same domain as your website, some hosting providers may not send the emails.', 'whistleblowing-system'); ?></p>
                                        <p><?php _e('In addition, relaying mail servers may consider the emails as phishing.', 'whistleblowing-system'); ?></p>
                                    </div>
                                </div>
                                <div class="wbls-group wd-has-placeholder<?php echo WBLS_PRO ? '' : ' wbls-pro-tooltip wbls-pro-tooltip-action'; ?>">
                                    <label class="wbls-label" for="from_name"><?php _e('From Name', 'whistleblowing-system'); ?></label>
                                    <input autocomplete="off" type="text" name="wbls_user_from_name" value="<?php echo $email_option['wbls_user_from_name']; ?>" id="wbls_user_from_name" />
                                    <p class="description"><?php _e('Set the name or search for a form field which is shown as the sender’s name in submission or confirmation emails.', 'whistleblowing-system'); ?></p>
                                </div>
                                <div class="wbls-group wbls-has-placeholder<?php echo WBLS_PRO ? '' : ' wbls-pro-tooltip wbls-pro-tooltip-action'; ?>">
                                    <label class="wbls-label" for="mail_subject"><?php _e('Subject', 'whistleblowing-system'); ?></label>
                                    <?php $this->placeholder_buttons($this->fields_options, 'text','wbls-subject-field'); ?>
                                    <input autocomplete="off" type="text" id="wbls_user_mail_subject" name="wbls_user_mail_subject" value="<?php echo $email_option['wbls_user_mail_subject']; ?>" />
                                    <p class="description"><?php _e('Add a custom subject or search for a form field for the submission email. In case it’s left blank, Form Title will be set as the subject of submission emails.', 'whistleblowing-system'); ?></p>
                                </div>
                                <div class="wd-group<?php echo WBLS_PRO ? '' : ' wbls-pro-tooltip wbls-pro-tooltip-action'; ?>">
                                    <label class="wbls-label" for="wbls_mail_body"><?php _e('Custom Text in Email For User', 'whistleblowing-system'); ?></label>
                                    <?php
                                    $this->placeholder_buttons($this->fields_options,'','', ['user_token' => 'User Token']);
                                    if ( user_can_richedit() && $this->teeny_active ) {
                                        wp_editor($email_option['wbls_user_mail_body'], 'wbls_user_mail_body', array(
                                            'textarea_name' => 'wbls_mail_body',
                                            'media_buttons' => false,                 // Show the "Add Media" button
                                            'textarea_rows' => 10,                   // Set the height of the editor
                                            'teeny'         => false,                // Whether to load the minimal TinyMCE editor
                                            'quicktags'     => true,                 // Enable the Text mode (HTML editor)
                                        ));
                                    }
                                    else {
                                        ?>
                                        <textarea name="wbls_user_mail_body" id="wbls_user_mail_body" cols="20" rows="10" style="width:100%; height:200px;"><?php echo wp_kses($email_option['wbls_user_mail_body'], WBLSLibrary::$wp_kses_default); ?></textarea>
                                        <?php
                                    }
                                    ?>
                                    <p class="description"><?php _e('Write custom content to the email message which is sent to user. Include All Fields List to forward all submitted information, or click on fields buttons to use individual field values in the content.', 'whistleblowing-system'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    private function display_options_sidebar() {
        ?>
        <div class="wbls-sidebar-menu" id="wbls-form-displayOption-menu-sidebar" style="display: none">
            <span id="wbls-sidebar-button-texts" class="wbls-sidebar-menu-item wbls-sidebar-menu-item-active">
                <?php esc_html_e('Whistleblower form button texts', 'whistleblowing-system'); ?>
            </span>
            <span id="wbls-sidebar-active-theme" class="wbls-sidebar-menu-item">
                <?php esc_html_e('Form active theme', 'whistleblowing-system'); ?>
            </span>
            <span id="wbls-sidebar-submit-messages" class="wbls-sidebar-menu-item">
                <?php esc_html_e('Submit messages', 'whistleblowing-system'); ?>
            </span>
        </div>
        <?php
    }

    private function display_options( $form_settings ) {
        ?>
        <div id="wbls-form-displayOption-menu" class="wbls-form-menu-item-content wbls-displayOption-container" style="display:none;">
            <?php
            $new_case_button_title = !empty($form_settings['new_case']) ? $form_settings['new_case'] : 'Report a new case';
            $follow_case_button_title = !empty($form_settings['follow_case']) ? $form_settings['follow_case'] : 'Follow up on a case';
            $login_case_button_title = !empty($form_settings['login_case']) ? $form_settings['login_case'] : 'Login';
            $copy_token_button_title = !empty($form_settings['copy_token']) ? $form_settings['copy_token'] : 'Copy token';
            $reply_button_title = !empty($form_settings['reply_button']) ? $form_settings['reply_button'] : 'Send';
            $success_message_text = !empty($form_settings['success_message']) ? $form_settings['success_message'] : 'Form successfully submitted';
            $success_message_copy_token = !empty($form_settings['success_message_copy_token']) ? $form_settings['success_message_copy_token'] : 'Please copy and retain this token for future login and for follow-up on the response.';
            $error_message_text = !empty($form_settings['error_message']) ? $form_settings['error_message'] : 'Something went wrong';

            $themes = get_posts(array(
                'posts_per_page'  => -1,
                'post_type' => 'wbls_theme'
            ));
            $default_theme = get_option( 'wbls_theme_default' );
            $active_theme = !empty($form_settings['active_theme']) ? $form_settings['active_theme'] : $default_theme;
            ?>
            <div class="wbls-option-section-column">
                <div class="wbls-option-section wbls-sidebar-menu-item-content wbls-sidebar-button-texts">
                    <div class="wbls-option-section-title">
                        <strong><?php _e('Whistleblower form button texts', 'whistleblowing-system'); ?></strong>
                    </div>
                    <div class="wbls-option-section-content">
                        <div class="wbls-option-section-group">
                            <label><?php _e('New case button text', 'whistleblowing-system'); ?></label>
                            <input type="text" name="new_case" class="wbls-new_case-button" value="<?php echo esc_html($new_case_button_title); ?>">
                            <p class="wbls-option-section-group-description">
                                <?php _e('The \'New Case\' button text is visible on the frontend for the whistleblower form. When clicked, it opens the form in a popup.', 'whistleblowing-system'); ?>
                            </p>
                        </div>
                        <div class="wbls-option-section-group">
                            <label><?php _e('Follow up case button text', 'whistleblowing-system'); ?></label>
                            <input type="text" name="follow_case" class="wbls-follow_case-button" value="<?php echo esc_html($follow_case_button_title); ?>">
                            <p class="wbls-option-section-group-description">
                                <?php _e('The \'Follow up\' button text is visible on the frontend for the whistleblower form. When clicked, it opens the login form in a popup.', 'whistleblowing-system'); ?>
                            </p>
                        </div>
                        <div class="wbls-option-section-group">
                            <label><?php _e('Login button text', 'whistleblowing-system'); ?></label>
                            <input type="text" name="login_case" class="wbls-login_case-button" value="<?php echo esc_html($login_case_button_title); ?>">
                            <p class="wbls-option-section-group-description">
                                <?php _e('The \'Login\' button text is visible on the frontend for the whistleblower form. When clicked, it opens the login form in a popup.', 'whistleblowing-system'); ?>
                            </p>
                        </div>
                        <div class="wbls-option-section-group">
                            <label><?php _e('Copy token button text', 'whistleblowing-system'); ?></label>
                            <input type="text" name="copy_token" class="wbls-copy_token-button" value="<?php echo esc_html($copy_token_button_title); ?>">
                            <p class="wbls-option-section-group-description">
                                <?php _e('The \'Copy token\' button text is visible on the frontend for the whistleblower form. After the form is submitted, it displays the token for future reference, along with the \'Copy token\' button.', 'whistleblowing-system'); ?>
                            </p>
                        </div>
                        <div class="wbls-option-section-group">
                            <label><?php _e('Reply button text', 'whistleblowing-system'); ?></label>
                            <input type="text" name="reply_button" class="wbls-reply_button" value="<?php echo esc_html($reply_button_title); ?>">
                            <p class="wbls-option-section-group-description">
                                <?php _e('The \'Reply\' button text is visible on the frontend for the whistleblower form. After logging in using the token, it displays the chat popup, along with the \'Reply\' button.', 'whistleblowing-system'); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="wbls-option-section wbls-sidebar-menu-item-content wbls-sidebar-active-theme">
                    <div class="wbls-option-section-title">
                        <strong><?php _e('Form active theme', 'whistleblowing-system'); ?></strong>
                    </div>
                    <div class="wbls-option-section-content">
                        <div class="wbls-option-section-group">
                            <label><?php _e('Theme', 'whistleblowing-system'); ?></label>
                            <select name="wbls_form_theme" class="wbls-active-theme">
                                <?php foreach ($themes as $theme ) { ?>
                                    <option value="<?php echo intval($theme->ID); ?>" <?php echo ($active_theme == $theme->ID) ? 'selected' : ''; ?>>
                                        <?php echo esc_html($theme->post_title); ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <p class="wbls-option-section-group-description">
                                <?php _e('Select a theme to which the form should be connected.', 'whistleblowing-system'); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="wbls-option-section wbls-sidebar-menu-item-content wbls-sidebar-submit-messages">
                    <div class="wbls-option-section-title">
                        <strong><?php _e('Submit messages', 'whistleblowing-system'); ?></strong>
                    </div>
                    <div class="wbls-option-section-content">
                        <div class="wbls-option-section-group">
                            <label><?php _e('Success message text', 'whistleblowing-system'); ?></label>
                            <textarea name="success_message" class="wbls-success-message"><?php echo esc_html($success_message_text); ?></textarea>
                            <p class="wbls-option-section-group-description">
                                <?php _e('A form success message text typically informs users that their submission was successful.', 'whistleblowing-system'); ?>
                            </p>
                        </div>
                        <div class="wbls-option-section-group">
                            <label><?php _e('Success message text about token copy for whistleblowing form', 'whistleblowing-system'); ?></label>
                            <textarea name="success_message_copy_token" class="wbls-success-message-copy-token"><?php echo esc_html($success_message_copy_token); ?></textarea>
                            <p class="wbls-option-section-group-description">
                                <?php _e('A form success message text typically informs users that he/she should keep token for future login.', 'whistleblowing-system'); ?>
                            </p>
                        </div>
                        <div class="wbls-option-section-group">
                            <label><?php _e('Error message text', 'whistleblowing-system'); ?></label>
                            <textarea name="error_message" class="wbls-error-message"><?php echo esc_html($error_message_text); ?></textarea>
                            <p class="wbls-option-section-group-description">
                                <?php _e('A form error message text typically informs users that their submission was not successful.', 'whistleblowing-system'); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    private function settings_sidebar() {
        ?>
        <div class="wbls-sidebar-menu" id="wbls-form-settings-menu-sidebar" style="display: none">
            <span id="wbls-sidebar-upload-settings" class="wbls-sidebar-menu-item wbls-sidebar-menu-item-active">
                <?php esc_html_e('Upload file settings', 'whistleblowing-system'); ?>
            </span>
        </div>
        <?php
    }

    private function settings( $form_settings ) {
        $file_max_size = isset($form_settings['file_max_size']) ? floatval($form_settings['file_max_size']) : 10;
        $file_types = $form_settings['file_types'] ?? ['jpg', 'png', 'gif'];
        ?>
        <div id="wbls-form-settings-menu" class="wbls-form-menu-item-content wbls-settings-container" style="display:none;">
            <div class="wbls-option-section-column">
                <div class="wbls-option-section wbls-sidebar-menu-item-content wbls-sidebar-upload-settings">
                    <div class="wbls-option-section-title">
                        <strong><?php _e('Upload file settings', 'whistleblowing-system'); ?></strong>
                    </div>
                    <div class="wbls-option-section-content">
                        <div class="wbls-option-section-group">
                            <label><?php _e('Allowed file types', 'whistleblowing-system'); ?></label>
                            <select name="file_types" class="wbls-file-types" multiple="multiple">
                                <option value="jpg" <?php echo in_array("jpg", $file_types) ? 'selected="selected"' : ''; ?>>JPG</option>
                                <option value="png" <?php echo in_array("png", $file_types) ? 'selected="selected"' : ''; ?>>PNG</option>
                                <option value="gif" <?php echo in_array("gif", $file_types) ? 'selected="selected"' : ''; ?>>GIF</option>
                                <option value="pdf" <?php echo in_array("pdf", $file_types) ? 'selected="selected"' : ''; ?>>PDF</option>
                                <option value="mp3" <?php echo in_array("mp3", $file_types) ? 'selected="selected"' : ''; ?>>MP3</option>
                                <option value="wav" <?php echo in_array("wav", $file_types) ? 'selected="selected"' : ''; ?>>WAV</option>
                                <option value="webm" <?php echo in_array("webm", $file_types) ? 'selected="selected"' : ''; ?>>WEBM</option>
                                <option value="mp4" <?php echo in_array("mp4", $file_types) ? 'selected="selected"' : ''; ?>>MP4</option>
                                <option value="mov" <?php echo in_array("mov", $file_types) ? 'selected="selected"' : ''; ?>>MOV</option>
                                <option value="avi" <?php echo in_array("avi", $file_types) ? 'selected="selected"' : ''; ?>>AVI</option>
                                <option value="m4v" <?php echo in_array("m4v", $file_types) ? 'selected="selected"' : ''; ?>>M4V</option>
                                <option value="flv" <?php echo in_array("flv", $file_types) ? 'selected="selected"' : ''; ?>>FLV</option>
                                <option value="3gp" <?php echo in_array("3gp", $file_types) ? 'selected="selected"' : ''; ?>>3GP</option>
                                <option value="3g2" <?php echo in_array("3g2", $file_types) ? 'selected="selected"' : ''; ?>>3G2</option>
                                <option value="ogg" <?php echo in_array("ogg", $file_types) ? 'selected="selected"' : ''; ?>>OGG</option>
                                <option value="wmv" <?php echo in_array("wmv", $file_types) ? 'selected="selected"' : ''; ?>>WMV</option>
                                <option value="ogv" <?php echo in_array("ogv", $file_types) ? 'selected="selected"' : ''; ?>>OGV</option>
                            </select>
                            <p class="wbls-option-section-group-description">
                                <?php _e('Select file types which will be allowed for upload', 'whistleblowing-system'); ?>
                                <br>
                                <?php _e('Note that this option also affects the chat upload field on the admin page and the chat upload field on the frontend page.', 'whistleblowing-system'); ?>
                            </p>
                        </div>
                        <div class="wbls-option-section-group">
                            <label><?php _e('File maximum size', 'whistleblowing-system'); ?></label>
                            <input type="number" name="file_max_size" class="wbls-file-max-size" value="<?php echo esc_html($file_max_size); ?>">
                            <p class="wbls-option-section-group-description">
                                <?php _e('The maximum file size that a user can upload, in MB.', 'whistleblowing-system'); ?>
                                <br>
                                <?php _e('Note that this option also affects the chat upload field on the admin page and the chat upload field on the frontend page.', 'whistleblowing-system'); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }

    private function shortcode_popup( $id ) {
        ?>
        <div class="wbls-shortcode-layer" style="display:none"></div>
        <div class="wbls-shortcode-popup" style="display:none">
            <?php if ( $this->whistleblower_active ) { ?>
                <div class="wbls-shortcode-popup-title">
                    <?php _e('Shortcode will show buttons view as start.', 'whistleblowing-system'); ?>
                    <span class="dashicons dashicons-info"><img src="<?php echo WBLS_URL; ?>/admin/assets/images/buttons_view.jpg"></span>
                </div>
            <?php } ?>
            <div class="wbls-shortcode-popup-row">
                <input type="text" id="wbls-shortcode" class="wbls-form-shortcode" disabled="" value='[wblsform id="<?php echo intval($id); ?>"]'>
                <span id="wbls-shortcode-copy" title="<?php esc_html_e('Copy embed code to clipboard', 'whistleblowing-system'); ?>">
                        <span class="wbls-form-shortcode-copy-tooltip"><?php esc_html_e('Copied', 'whistleblowing-system') ?></span>
                    </span>
            </div>
            <?php if ( $this->whistleblower_active ) { ?>
                <div class="wbls-shortcode-popup-title">
                    <?php _e('Shortcode will show form.', 'whistleblowing-system'); ?>
                    <span class="dashicons dashicons-info"><img src="<?php echo WBLS_URL; ?>/admin/assets/images/form.jpg"></span>
                </div>
                <div class="wbls-shortcode-popup-row">
                    <input type="text" id="wbls-form-shortcode" class="wbls-form-shortcode" disabled="" value='[wblsform id="<?php echo intval($id); ?>" type="form"]'>
                    <span id="wbls-form-shortcode-copy" title="<?php esc_html_e('Copy embed code to clipboard', 'whistleblowing-system'); ?>">
                        <span class="wbls-form-shortcode-copy-tooltip"><?php esc_html_e('Copied', 'whistleblowing-system') ?></span>
                    </span>
                </div>
                <div class="wbls-shortcode-popup-title">
                    <?php _e('Shortcode will show login/chat view', 'whistleblowing-system'); ?>
                    <span class="dashicons dashicons-info"><img src="<?php echo WBLS_URL; ?>/admin/assets/images/login_view.jpg"></span>
                </div>
                <div class="wbls-shortcode-popup-row">
                    <input type="text" id="wbls-reply-shortcode" class="wbls-form-shortcode" disabled="" value='[wblsform id="<?php echo intval($id); ?>" type="login"]'>
                    <span id="wbls-reply-shortcode-copy" title="<?php esc_html_e('Copy embed code to clipboard', 'whistleblowing-system'); ?>">
                        <span class="wbls-form-shortcode-copy-tooltip"><?php esc_html_e('Copied', 'whistleblowing-system') ?></span>
                    </span>
                </div>
            <?php } ?>
        </div>

        <?php
    }

    public function placeholder_buttons( $fields_options, $field_type = '', $class_name = '', $custom_fields = [] ) { ?>
        <div class="wbls-email-placeholder-row <?php echo esc_attr($class_name)?>">
        <?php
        foreach ( $fields_options as $key => $field ) {
            if( empty($field) || $field['type'] == 'recaptcha' || $field['type'] == 'submit' || $field['type'] == 'file' || ($field_type != '' && $field_type !== $field['type'])) {
                continue;
            }
            $label = $field['label'] ? $field['label'] : $field['title'];
            ?>
            <span class="wbls-field-placeholder" data-field-id="<?php echo esc_html($key); ?>"><?php echo strip_tags($label); ?></span>
            <?php
        }
        foreach ( $custom_fields as $key => $field ) {
            ?>
            <span class="wbls-field-placeholder" data-field-id="<?php echo esc_html($key); ?>"><?php echo strip_tags($field); ?></span>
            <?php
        }

        ?>
        </div>
        <?php
    }

    public function fields_content() {
        foreach ( $this->form_fields as $form_field ) {
            $pro_class = "";
            if ( $form_field['pro'] && !WBLS_PRO ) {
                $pro_class = " wbls-pro-tooltip wbls-pro-tooltip-action";
            }
            ?>
            <span class="wbls-field-item<?php echo esc_attr($pro_class); ?>" data-type="<?php echo esc_attr($form_field['type']); ?>"><?php echo esc_html__($form_field['title'],'whistleblowing-system'); ?></span>
            <?php
        }
    }

    public function form_content() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $content = '';
        if( $id ) {
            $content =  get_post_meta( $id, 'wbls_form_content', true );
            if( empty($content) ) {
                wp_redirect('?page=whistleblower_form_edit');
            }
            ?>
            <div class="wbls-form-container wbls-form-container-admin">
                <div class="wbls-form wbls-form-admin">
                    <div id="wbls-take" data-id="<?php echo intval($id); ?>">
                        <?php echo trim($content); ?>
                    </div>
                    <div class="wbls-add-new-page wbls-field-item wbls-pro-tooltip wbls-pro-tooltip-action" data-type="page_break">
                        <?php esc_html_e('Add New Page', 'whistleblowing-system'); ?>
                    </div>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="wbls-form-container wbls-form-container-admin">
                <div class="wbls-form wbls-form-admin">
                    <div id="wbls-take" data-id="0">
                        <div class="wblsform-page-and-images wbls-form-builder">
                            <div class="wblsform_section">
                                <div class="wblsform_column wbls-hidden ui-sortable"></div>
                                <div class="wblsform_column wblsform_column-active ui-sortable"></div>
                                <div class="wblsform_column wbls-hidden ui-sortable"></div>
                            </div>
                        </div>
                    </div>
                    <div class="wbls-add-new-page wbls-field-item wbls-pro-tooltip wbls-pro-tooltip-action" data-type="page_break">
                        <?php esc_html_e('Add New Page', 'whistleblowing-system'); ?>
                    </div>

                </div>
            </div>
            <?php
        }
    }
}
