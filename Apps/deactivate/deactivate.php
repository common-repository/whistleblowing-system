<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class WBLS_Deactivate
{
    public function __construct( $task )
    {
        if ($task != '' && method_exists($this, $task) && $task != '__construct') {
            $this->$task();
        } else {
            $this->enqueue_scripts();
            $this->template();
        }
    }

    private function wbls_send_reason() {
        if( isset($_POST['skip']) && $_POST['skip'] == 0 ) {
            $email = !empty($_POST['email']) ? sanitize_email($_POST['email']) : sanitize_email(get_option('admin_email'));
            $reason_value = isset($_POST['reason_value']) ? sanitize_text_field($_POST['reason_value']) : '';
            $message = isset($_POST['message']) ? sanitize_text_field($_POST['message']) : '';
            $reason = isset($_POST['reason']) ? sanitize_text_field($_POST['reason']) : '';
            $site_url = get_site_url();

        } else { /* Skip case */
            $email = '';
            $reason = 'Skipped';
            $site_url = '';
            $message = '';
            $reason_value = '';
        }

        $data = [
            'reason_value' => $reason_value,
            'message'      => $message,
            'reason'       => $reason,
            'email'        => $email,
            'site_url'     => $site_url,
        ];

        // Set up the request headers
        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer 833f3ab4b2ec0f49575b7e4ac82cdbfc45e217b3e18846d59c707bfafff06526',
        ];


        wp_remote_post(WBLS_DEACTIVATION_REST, [
            'method'    => 'POST',
            'headers'   => $headers,
            'body'      => json_encode($data),
            'data_format' => 'body',
        ]);
        wp_send_json_success();
    }

    private function enqueue_scripts() {
        wp_enqueue_script('wbls-deactivate');
        wp_enqueue_style('wbls-deactivate');
    }

    private function template() {
        ?>
        <script type="text/template" id="wbls-deactivate-template">
            <div class="wbls-deactivat-layout"></div>
            <div class="wbls-deactivat-container">
                <span class="wbls-close dashicons dashicons-dismiss"></span>
                <div class="wbls-header-row">
                    <?php esc_html_e('Please let us know why you are deactivating. Your answer will help us to provide you support or sometimes offer discounts. (Optional):', 'whistleblowing-system'); ?>
                </div>
                <div class="wbls-reason-row">
                    <input type="radio" value="no_need" name="wbls_reason" class="wbls-reason">
                    <label><?php esc_html_e('I no longer need the plugin', 'whistleblowing-system'); ?></label>
                </div>
                <div class="wbls-reason-row">
                    <input type="radio" value="free_limited" name="wbls_reason" class="wbls-reason">
                    <label><?php esc_html_e('Free version is limited', 'whistleblowing-system'); ?></label>
                </div>
                <div class="wbls-reason-row">
                    <input type="radio" value="better_alternative" name="wbls_reason" class="wbls-reason">
                    <label><?php esc_html_e('I found a better alternative', 'whistleblowing-system'); ?></label>
                </div>
                <div class="wbls-reason-row">
                    <input type="radio" value="conflict" name="wbls_reason" class="wbls-reason">
                    <label><?php esc_html_e('Technical problems / hard to use', 'whistleblowing-system'); ?></label>
                </div>
                <div class="wbls-reason-row">
                    <input type="radio" value="upgrade" name="wbls_reason" class="wbls-reason">
                    <label><?php esc_html_e('Upgrading to paid version', 'whistleblowing-system'); ?></label>
                </div>
                <div class="wbls-reason-row">
                    <input type="radio" value="other" name="wbls_reason" class="wbls-reason">
                    <label><?php esc_html_e('Other', 'whistleblowing-system'); ?></label>
                </div>

                <div class="wbls-additional-row" style="display:none"></div>
                <hr>
                <div class="wbls-reason-row wbls-terms-agree-row" style="display: none">
                    <input type="checkbox" class="wbls-terms-agree">
                    <label class="wbls-terms-agree-msg">
                        <?php
                        esc_html_e('By submitting this form your email and website URL will be sent to Whistleblowing. Click the checkbox if you consent to usage of mentioned data by Whistleblowing in accordance with our ', 'whistleblowing-system'); ?>
                        <a href="https://whistleblowing-form.de/en/privacy-policy/" target="_blank">
                            <?php esc_html_e('Privacy Policy.', 'whistleblowing-system'); ?>
                        </a>
                    </label>
                </div>

                <div class="wbls-buttons-row">
                    <a href="#" class="wbls-skip-button button button-secondary"><?php esc_html_e('Skip and Deactivate', 'whistleblowing-system'); ?></a>
                    <span class="wbls-submit-button wbls-submit-disabled button button-primary" style="display: none"><?php esc_html_e('Submit and Deactivate', 'whistleblowing-system'); ?></span>
                </div>
            </div>
        </script>

        <script type="text/template" id="wbls-deactivate-support-template">
            <p class="wbls-issue-title"><?php esc_html_e('Please describe your issue.', 'whistleblowing-system'); ?></p>
            <textarea class="wbls-issue-message"></textarea>
            <div class="wbls-issue-email-row">
                <span><?php esc_html_e('Our support will contact', 'whistleblowing-system'); ?></span>
                <input type="email" value="<?php echo esc_attr(get_option('admin_email')); ?>" class="wbls-admin-email">
                <span><?php esc_html_e('shortly.', 'whistleblowing-system'); ?></span>
            </div>
        </script>

        <script type="text/template" id="wbls-deactivate-pro-offer-template">
            <p class="wbls-issue-title"><?php esc_html_e('We believe our premium version will fit your needs.', 'whistleblowing-system'); ?></p>
            <a href="https://whistleblowing-form.de/produkt/whistleblowing-system-pro/?from=plugin">
                <?php esc_html_e('Try with 30 day money back guarantee.', 'whistleblowing-system'); ?>
            </a>
        </script>

        <script type="text/template" id="wbls-deactivate-other-template">
            <p class="wbls-issue-title"><?php esc_html_e('Please describe the reason.', 'whistleblowing-system'); ?></p>
            <textarea class="wbls-issue-message"></textarea>
        </script>

        <?php
    }
}