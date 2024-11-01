<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WhistleblowerThemes {
    public function __construct() {
        $task = isset($_GET['task']) ? sanitize_text_field($_GET['task']) : '';
        if ( method_exists($this, $task) ) {
            $this->$task();
        } else {
            $this->display();
        }
    }

    public function display() {
        $themes = get_posts( ['post_type' => 'wbls_theme', 'numberposts' => -1] );
        wp_enqueue_style(WBLS_WhistleBlower::instance()->prefix . '-style');
        wp_enqueue_script( WBLS_WhistleBlower::instance()->prefix . '-themes');
        wp_localize_script(WBLS_WhistleBlower::instance()->prefix . '-themes', 'wbls_theme', array(
            "ajaxnonce" => wp_create_nonce('wbls_ajax_nonce'),
        ));
        $default_theme_id = get_option( 'wbls_theme_default');
        ?>
        <div class="wbls-admin-header">
            <img class="wbls-admin-header-logo" src="<?php echo WBLS_URL; ?>/admin/assets/images/whistleblowing_logo.png">
            <h2 class="wbls-page-title"><?php esc_html_e('All themes', 'whistleblowing-system') ?></h2>
            <a href="?page=whistleblower_theme_edit" class="wbls-button wbls-button-add-form"><?php esc_html_e('Add New', 'whistleblowing-system') ?></a>
        </div>
        <p class="wbls-response-message"></p>
        <div class="wrap wbls-content">
            <div class="wbls-forms-list">
                <div class="wbls-forms-list-row wbls-forms-list-title">
                    <div class="wbls-form-name"><?php esc_html_e('Name', 'whistleblowing-system') ?></div>
                    <div class="wbls-form-author"><?php esc_html_e('Author', 'whistleblowing-system') ?></div>
                    <div class="wbls-form-date"><?php esc_html_e('Date', 'whistleblowing-system') ?></div>
                    <div class="wbls-form-type"><?php esc_html_e('Default', 'whistleblowing-system') ?></div>
                </div>
                <?php
                foreach ($themes as $theme ) {
                    ?>
                    <div class="wbls-forms-list-row">
                        <div class="wbls-form-name">
                            <a href="?page=whistleblower_theme_edit&id=<?php echo intval($theme->ID) ?>"><?php echo esc_html($theme->post_title) ?></a>
                            <div class="wbls-row-actions row-actions">
                                <span class="edit"><a href="?page=whistleblower_theme_edit&id=<?php echo intval($theme->ID) ?>" aria-label="Edit “Hello world!”"><?php esc_html_e('Edit', 'whistleblowing-system') ?></a> | </span>
                                <span class="wbls-delete-theme" data-id="<?php echo intval($theme->ID) ?>">
                                    <?php esc_html_e('Delete', 'whistleblowing-system') ?>
                                </span>
                            </div>
                        </div>
                        <div class="wbls-form-author"><?php echo esc_html($theme->post_author); ?></div>
                        <div class="wbls-form-date"><?php echo esc_html($theme->post_date); ?></div>
                        <div class="wbls-form-type">
                            <input type="radio" name="wbls_theme_default" class="wbls-theme-default" value="<?php echo intval($theme->ID)?>" <?php echo ($default_theme_id == $theme->ID) ? 'checked' : ''; ?>>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
    }
}