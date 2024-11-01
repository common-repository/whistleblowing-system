<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WhistleblowerSettings {
    public function __construct() {
        $this->display();
    }

    public function display() {
        wp_enqueue_style(WBLS_WhistleBlower::instance()->prefix . '-style');
        wp_enqueue_style(WBLS_WhistleBlower::instance()->prefix . '-edit');
        wp_enqueue_style(WBLS_WhistleBlower::instance()->prefix . '-admin');

        $wbls_global_settings = json_decode( get_option( 'wbls_global_settings' ), 1 );
        $teeny_active = get_option('teeny_active', true);

        $reCAPTCHA_v2_site_key = isset($wbls_global_settings['reCAPTCHA_v2_site_key']) ? esc_html($wbls_global_settings['reCAPTCHA_v2_site_key']) : '';
        $reCAPTCHA_v2_secret_key = isset($wbls_global_settings['reCAPTCHA_v2_secret_key']) ? esc_html($wbls_global_settings['reCAPTCHA_v2_secret_key']) : '';
        $reCAPTCHA_language = isset($wbls_global_settings['reCAPTCHA_language']) ? esc_html($wbls_global_settings['reCAPTCHA_language']) : '';
        $reCAPTCHA_v3_site_key = isset($wbls_global_settings['reCAPTCHA_v3_site_key']) ? esc_html($wbls_global_settings['reCAPTCHA_v3_site_key']) : '';
        $reCAPTCHA_v3_secret_key = isset($wbls_global_settings['reCAPTCHA_v3_secret_key']) ? esc_html($wbls_global_settings['reCAPTCHA_v3_secret_key']) : '';

        ?>
        <div class="wbls-admin-header">
            <img class="wbls-admin-header-logo" src="<?php echo WBLS_URL; ?>/admin/assets/images/whistleblowing_logo.png">
            <h2 class="wbls-page-title"><?php esc_html_e('Global Settings', 'whistleblowing-system') ?></h2>
            <span class="wbls-button wbls-save-settings"><?php _e('Save', 'whistleblowing-system'); ?></span>
        </div>
        <p class="wbls-response-message"></p>

        <div id="wbls-form-settings-menu" class="wbls-form-menu-item-content wbls-settings-container">
            <div class="wbls-option-section-column">
                <div class="wbls-option-section<?php echo WBLS_PRO ? '' : ' wbls-pro-tooltip wbls-pro-tooltip-action'; ?>">
                    <div class="wbls-option-section-title">
                        <strong><?php _e('reCAPTCHA', 'whistleblowing-system'); ?></strong>
                    </div>
                    <div class="wbls-option-section-content">
                        <div class="wbls-option-section-group">
                            <label><?php _e('reCAPTCHA v2 Site Key', 'whistleblowing-system'); ?></label>
                            <input type="text" name="reCAPTCHA_v2_site_key" class="reCAPTCHA_v2_site_key" value="<?php echo esc_html($reCAPTCHA_v2_site_key); ?>">
                            <p class="wbls-option-section-group-description">
                                <?php _e('Get a site key for your domain by registering. ', 'whistleblowing-system'); ?>
                                <a href="https://www.google.com/recaptcha/intro/index.html" target="_blank"><?php _e('here', 'whistleblowing-system'); ?></a>
                            </p>
                        </div>
                        <div class="wbls-option-section-group">
                            <label><?php _e('reCAPTCHA v2 Secret Key', 'whistleblowing-system'); ?></label>
                            <input type="text" name="reCAPTCHA_v2_secret_key" class="reCAPTCHA_v2_secret_key" value="<?php echo esc_html($reCAPTCHA_v2_secret_key); ?>">
                            <p class="wbls-option-section-group-description">
                            </p>
                        </div>
                        <div class="wbls-option-section-group">
                            <label><?php _e('reCAPTCHA Language', 'whistleblowing-system'); ?></label>
                            <input type="text" name="reCAPTCHA_language" class="reCAPTCHA_language" value="<?php echo esc_html($reCAPTCHA_language); ?>">
                            <p class="wbls-option-section-group-description">
                                <?php _e('e.g. en, de - Language used by reCAPTCHA. To get the code for your language click ', 'whistleblowing-system'); ?>
                                <a href="https://www.google.com/recaptcha/intro/index.html" target="_blank"><?php _e('here', 'whistleblowing-system'); ?></a>
                            </p>
                        </div>
                        <div class="wbls-option-section-group">
                            <label><?php _e('reCAPTCHA v3 Site Key', 'whistleblowing-system'); ?></label>
                            <input type="text" name="reCAPTCHA_v3_site_key" class="reCAPTCHA_v3_site_key" value="<?php echo esc_html($reCAPTCHA_v3_site_key); ?>">
                            <p class="wbls-option-section-group-description">
                                <?php _e('Get a site key for your domain by registering. ', 'whistleblowing-system'); ?>
                                <a href="https://www.google.com/recaptcha/intro/index.html" target="_blank"><?php _e('here', 'whistleblowing-system'); ?></a>
                            </p>
                        </div>
                        <div class="wbls-option-section-group">
                            <label><?php _e('reCAPTCHA v3 Secret Key', 'whistleblowing-system'); ?></label>
                            <input type="text" name="reCAPTCHA_v3_secret_key" class="reCAPTCHA_v3_secret_key" value="<?php echo esc_html($reCAPTCHA_v3_secret_key); ?>">
                            <p class="wbls-option-section-group-description">
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wbls-option-section-column">
                <div class="wbls-option-section">
                    <div class="wbls-option-section-title">
                        <strong><?php _e('Advanced', 'whistleblowing-system'); ?></strong>
                    </div>
                    <div class="wbls-option-section-content">
                        <div class="wbls-option-section-group">
                            <label><?php _e('TinyMce Active', 'whistleblowing-system'); ?></label>
                            <input type="radio" name="teeny_active" class="wbls-teeny_active" value="1" <?php if($teeny_active) { echo 'checked'; } ?>> Yes
                            <input type="radio" name="teeny_active" class="wbls-teeny_active" value="0" <?php if(!$teeny_active) { echo 'checked'; } ?>> No
                            <p class="wbls-option-section-group-description"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
}
