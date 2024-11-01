<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WBLS_frontend {

    private $form_id;
    private $settings;
    private $whistleblower_active = 0;

    private $post_data;

    private $form_content;
    private $form_type;

    public function __construct( $attr )
    {
        $this->form_id = $attr['id'];

        $this->form_type = $attr['type'] ?? '';
        $this->settings = get_post_meta($this->form_id, 'wbls_form_settings', 1);
        $this->post_data = get_post($this->form_id);
        if (!$this->post_data) {
            return;
        }
        $this->form_content = get_post_meta($this->form_id, 'wbls_form_content', 1);
        $this->whistleblower_active = $this->settings['whistleblower_active'] ?? 1;
        $success_msg = isset($this->settings['success_message']) ? esc_html($this->settings['success_message']) : esc_html__('Form Successfully Submitted', 'whistleblowing-system');
        $error_msg = isset($this->settings['error_message']) ? esc_html($this->settings['error_message']) : esc_html__('Something went wrong', 'whistleblowing-system');
        $success_msg_copy_token = $this->settings['success_message_copy_token'] ?? esc_html__('Please copy and retain this token for future login and for follow-up on the response.', 'whistleblowing-system');
        $default_theme = get_option('wbls_theme_default');
        $active_theme = isset($this->settings['active_theme']) ? $this->settings['active_theme'] : $default_theme;
        $file_max_size = isset($this->settings['file_max_size']) ? floatval($this->settings['file_max_size']) : 10;
        $form_conditions = get_post_meta($this->form_id, 'wbls_form_conditions', true);
        if (empty($form_conditions)) {
            $form_conditions = [];
        }

        $localized_data = array(
            "ajaxnonce" => wp_create_nonce('wbls_ajax_nonce'),
            'ajax_url' => admin_url('admin-ajax.php'),
            'success_msg' => esc_html($success_msg),
            'error_msg' => esc_html($error_msg),
            'token_msg' => esc_html($success_msg_copy_token),
            'file_size_msg' => esc_html__("File size should be less then", 'whistleblowing-system'),
            'file_type_msg' => esc_html__("Invalid file type: allowed types are", 'whistleblowing-system'),
            'file_max_size' => $file_max_size,
            'file_types' => $this->settings['file_types'] ?? ['jpg', 'png', 'gif'],
            'file_types' => $this->settings['file_types'] ?? ['jpg', 'png', 'gif'],
            'recaptcha_active' => 0,
        );
        $recaptcha = WBLSLibrary::is_recaptcha_active($this->form_id);
        if (!empty($recaptcha)) {
            $localized_data['recaptcha_active'] = 1;
            $localized_data['recaptcha_version'] = $recaptcha['version'];
            if ($recaptcha['version'] == 'v3') {
                $localized_data['recaptcha_key'] = $recaptcha['reCAPTCHA_v3_site_key'];
            } else {
                $localized_data['recaptcha_key'] = $recaptcha['reCAPTCHA_v2_site_key'];
            }
        }


        
        if ( ! wp_script_is( 'wbls-script', 'registered' ) ) {
            wp_register_script('wbls-script', WBLS_URL . '/frontend/assets/js/script.js', array('jquery'), WBLS_VERSION, true);
        }
        wp_enqueue_script('wbls-script');
        wp_localize_script('wbls-script', 'wbls_front', $localized_data);

        $wp_upload_dir = wp_upload_dir();
        $wbls_style_dir = $wp_upload_dir[ 'basedir' ] . '/wbls-system/wbls-theme-style_' . $active_theme . '.css';
        $wbls_style_url = $wp_upload_dir[ 'baseurl' ] . '/wbls-system/wbls-theme-style_' . $active_theme . '.css';
        wp_enqueue_style(WBLS_PREFIX . '-style', WBLS_URL . '/frontend/assets/css/style.css', array(), WBLS_VERSION);
        if( file_exists($wbls_style_dir) ) {
            wp_enqueue_style(WBLS_PREFIX . '-theme-style_' . $active_theme, $wbls_style_url, array(), WBLS_VERSION);
        } else {
            wp_enqueue_style(WBLS_PREFIX . '-theme-style', WBLS_URL . '/frontend/assets/css/default.css', array(), WBLS_VERSION);
        }

        $wbls_js_dir = $wp_upload_dir[ 'basedir' ] . '/wbls-system/wbls-codition_' . $this->form_id . '.js';
        $wbls_js_url = $wp_upload_dir[ 'baseurl' ] . '/wbls-system/wbls-codition_' . $this->form_id . '.js';
        if( file_exists($wbls_js_dir) ) {
            wp_enqueue_script( 'wbls-condition_' . $this->form_id, $wbls_js_url, array('jquery'), WBLS_VERSION, true);

        }
    }

    public function display() {
        ob_start();
        if( $this->whistleblower_active ) {
            $buttons = [
                'new_case' => !empty($this->settings['new_case']) ? $this->settings['new_case'] : 'Report a new case',
                'follow_case' => !empty($this->settings['follow_case']) ? $this->settings['follow_case'] : 'Follow up on a case',
                'login_case' => !empty($this->settings['login_case']) ? $this->settings['login_case'] : 'Login',
                'copy_token' => !empty($this->settings['copy_token']) ? $this->settings['copy_token'] : 'Copy token',
                'reply_button' => !empty($this->settings['reply_button']) ? $this->settings['reply_button'] : 'Send',
            ];
            if( $this->form_type == '' ) {
                ?>
                <div class="wbls-front-buttons-container">
                    <span class="wbls-new-case-button"><?php echo esc_html($buttons['new_case']); ?></span>
                    <span class="wbls-followup-button"><?php echo esc_html($buttons['follow_case']); ?></span>
                    <span></span>
                </div>
                <?php
                $this->form( $buttons );
            } elseif ( $this->form_type == 'form' ) {
                $this->embed_form();
            } elseif ( $this->form_type == 'login' ) {
                $this->login_form( $buttons );
            }
        } else {
            $this->embed_form();
        }
        return ob_get_clean();
    }

    public function embed_form() {
        ?>
        <div class="wbls-form-container">
            <form method="post" class="wbls-form" id="wbls-form-<?php echo intval($this->form_id); ?>" <?php echo WBLS_PRO ? 'enctype="multipart/form-data"' : ''; ?>>
                <?php if(isset($this->settings['show_form_header']) && $this->settings['show_form_header']) { ?>
                    <div class="wbls-front-header">
                        <?php echo wp_kses($this->settings['form_header'], WBLSLibrary::$wp_kses_default); ?>
                    </div>
                <?php } ?>
                <input type="hidden" value="<?php echo intval($this->form_id); ?>" name="wbls_form_id">
                <input type="hidden" value="wbls_front_ajax" name="action">
                <input type="hidden" value="wbls_submit_form" name="task">
                <input type="hidden" value="<?php echo intval($this->form_id); ?>" name="wbls_form_id">
                <input type="text" value="" name="wbls_security" class="wbls-security" required>
                <?php echo wp_kses($this->form_content, WBLSLibrary::$wp_kses_form); ?>
            </form>
        </div>
        <?php
    }

    public function login_form( $buttons ) {
        ?>
        <div class="wbls-login-container">
            <?php if(isset($this->settings['show_login_header']) && $this->settings['show_login_header']) { ?>
                <div class="wbls-front-header">
                    <?php echo wp_kses($this->settings['login_header'], WBLSLibrary::$wp_kses_default); ?>
                </div>
            <?php } ?>

            <div class="wbls-token-row">
                <input type="text" value="" name="wbls_token" class="wbls-token-input">
                <input type="text" value="" name="wbls_security" class="wbls-security" required>
                <button class="wbls-login-button"><?php echo esc_html($buttons['login_case']); ?></button>
                <span class="wbls-error-msg" style="display:none"></span>
            </div>
        </div>
        <div class="wbls-chat-container" style="display: none">
            <div class="wbls-chats-section"></div>
            <div class="wbls-new-chat-section">
                <form id="wbls-reply-form">
                    <input type="hidden" name="action" value="wbls_front_ajax">
                    <input type="hidden" name="task" value="wbls_reply">
                    <input type="hidden" value="<?php echo intval($this->form_id); ?>" name="wbls_form_id">
                    <input type="text" value="" name="wbls_security" class="wbls-security" required>
                    <textarea name="reply" id="wbls-new-reply" class="wbls-new-reply"></textarea>
                    <div class="wbls-reply-button-container">
                        
                        <button id="wbls-reply-button"><?php echo esc_html($buttons['reply_button']); ?></button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }

    public function form($buttons) {
        $success_msg_copy_token = $this->settings['success_message_copy_token'] ?? esc_html__('Please copy and retain this token for future login and for follow-up on the response.', 'whistleblowing-system');
        ?>
        <div class="wbls-front-layout" <?php echo $this->whistleblower_active ? 'style="display: none"': ''?>></div>
        <div class="wbls-front-content wbls-front-form-content" style="display: none">
            <span class="wbls-front-content-close"></span>
            <div class="wbls-form-container" style="display: none">
                <form method="post" class="wbls-form" id="wbls-form-<?php echo intval($this->form_id); ?>" <?php echo WBLS_PRO ? 'enctype="multipart/form-data"' : ''; ?>>
                    <?php if(isset($this->settings['show_form_header']) && $this->settings['show_form_header']) { ?>
                        <div class="wbls-front-header">
                            <?php echo wp_kses($this->settings['form_header'], WBLSLibrary::$wp_kses_default); ?>
                        </div>
                    <?php } ?>
                    <input type="hidden" value="<?php echo intval($this->form_id); ?>" name="wbls_form_id">
                    <input type="hidden" value="wbls_front_ajax" name="action">
                    <input type="hidden" value="wbls_submit_form" name="task">
                    <input type="hidden" value="<?php echo intval($this->form_id); ?>" name="wbls_form_id">
                    <input type="text" value="" name="wbls_security" class="wbls-security" required>
                    <?php echo wp_kses($this->form_content, WBLSLibrary::$wp_kses_form); ?>
                </form>
            </div>
            <div class="wbls-token-container" style="display: none">

                <div class="wbls-token-row">
                    <?php if(isset($this->settings['show_token_header']) && $this->settings['show_token_header']) { ?>
                        <div class="wbls-front-header">
                            <?php echo wp_kses($this->settings['token_header'], WBLSLibrary::$wp_kses_default); ?>
                        </div>
                    <?php } ?>

                    <span class="wbls-token-value"></span>
                    <button class="wbls-copy-button">
                        <?php echo esc_html($buttons['copy_token']); ?>
                        <span class="wbls-form-token-copy-tooltip"><?php esc_html_e('Copied', 'whistleblowing-system') ?></span>
                    </button>
                    <span class="wbls-token-description">
                        <?php echo esc_html($success_msg_copy_token); ?>
                    </span>
                </div>
            </div>
            <div class="wbls-login-container" style="display: none">
                <div class="wbls-token-row">
                    <?php if(isset($this->settings['show_login_header']) && $this->settings['show_login_header']) { ?>
                        <div class="wbls-front-header">
                            <?php echo wp_kses($this->settings['login_header'], WBLSLibrary::$wp_kses_default); ?>
                        </div>
                    <?php } ?>

                    <input type="text" value="" name="wbls_token" class="wbls-token-input">
                    <input type="text" value="" name="wbls_security" class="wbls-security" required>
                    <button class="wbls-login-button"><?php echo esc_html($buttons['login_case']); ?></button>
                    <span class="wbls-error-msg" style="display:none"></span>
                </div>
            </div>
            <div class="wbls-chat-container" style="display: none">
                <div class="wbls-chats-section"></div>
                <div class="wbls-new-chat-section">
                    <form id="wbls-reply-form">
                        <input type="hidden" name="action" value="wbls_front_ajax">
                        <input type="hidden" name="task" value="wbls_reply">
                        <input type="hidden" value="<?php echo intval($this->form_id); ?>" name="wbls_form_id">
                        <input type="text" value="" name="wbls_security" class="wbls-security" required>
                        <textarea name="reply" id="wbls-new-reply" class="wbls-new-reply"></textarea>
                        <div class="wbls-reply-button-container">
                            <button id="wbls-reply-button"><?php echo esc_html($buttons['reply_button']); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }
}