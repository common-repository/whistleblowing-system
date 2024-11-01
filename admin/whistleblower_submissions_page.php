<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WhistleblowerSubmissions {

    public function __construct() {
        $task = isset($_GET['task']) ? sanitize_text_field($_GET['task']) : '';
        if ( method_exists($this, $task) ) {
            $this->$task();
        } else {
            $this->wbls_display();
        }
    }
    private function wbls_display() {
        $ajaxnonce = wp_create_nonce('wbls_ajax_nonce');
        wp_enqueue_script( WBLS_WhistleBlower::instance()->prefix . '-submissions');
        wp_localize_script(WBLS_WhistleBlower::instance()->prefix . '-submissions', 'wbls_submissions', array(
            "ajaxnonce" => $ajaxnonce,
            'submission_success_delete' => esc_html__("Submission successfully deleted", 'whistleblowing-system'),
            'submission_success_partly_delete' => esc_html__("Submission partly successfully deleted", 'whistleblowing-system'),
            'submission_error_delete' => esc_html__("Something went wrong", 'whistleblowing-system'),
        ));

        wp_enqueue_style(WBLS_WhistleBlower::instance()->prefix . '-submissions');

        $forms = get_posts( ['post_type' => 'wbls_form', 'numberposts' => 500] );
        wp_enqueue_style(WBLS_WhistleBlower::instance()->prefix . '-style');

        ?>
        <div class="wbls-admin-header">
            <img class="wbls-admin-header-logo" src="<?php echo WBLS_URL; ?>/admin/assets/images/whistleblowing_logo.png">
            <h2 class="wbls-page-title">
                <?php esc_html_e('All Submissions', 'whistleblowing-system') ?>
            </h2>
        </div>
        <p class="wbls-response-message"></p>
        <div class="wrap wbls-content">
            <div class="wbls-forms-list">
                <div class="wbls-forms-list-row wbls-forms-list-title">
                    <div class="wbls-form-name"><?php esc_html_e('Name', 'whistleblowing-system') ?></div>
                    <div class="wbls-form-count"><?php esc_html_e('Count', 'whistleblowing-system') ?></div>
                    <div class="wbls-form-type"><?php esc_html_e('Type', 'whistleblowing-system') ?></div>
                </div>
                <?php
                foreach ($forms as $form ) {
                    $whistleblower_active = WBLSLibrary::is_whistleblower_active( $form->ID );
                    ?>
                    <div class="wbls-forms-list-row">
                        <div class="wbls-form-name">
                            <a href="?page=whistleblower_submission_edit&id=<?php echo intval($form->ID) ?>"><?php echo esc_html($form->post_title) ?></a>
                            <div class="wbls-row-actions row-actions">
                                <span class="view"><a href="?page=whistleblower_submission_edit&id=<?php echo intval($form->ID) ?>"><?php esc_html_e('View', 'whistleblowing-system') ?></a> | </span>
                                <span class="trash">
                                    <span class="wbls-delete-all-submission" data-id="<?php echo intval($form->ID) ?>">
                                        <?php esc_html_e('Delete', 'whistleblowing-system'); ?>
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="wbls-form-count"><?php echo esc_html($this->get_submissions_count($form->ID)) ?></div>
                        <div class="wbls-form-type">
                            <?php
                            if( !$whistleblower_active ) {
                                esc_html_e('Standart', 'whistleblowing-system');
                            } else {
                                esc_html_e('Whistleblowing', 'whistleblowing-system');
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
    }

    public function get_submissions_count($form_id) {
        $args = array(
            'post_type' => 'wbls_form_subm',
            'post_status' => 'closed',
            'meta_query' => array(
                array(
                    'key' => 'wbls_form_id',
                    'value' => $form_id,
                    'compare' => '=',
                )
            ),
            "numberposts" => 1000,
            "posts_per_page" => 1000,
        );
        $query = new WP_Query($args);
        $submissions = [];
        if ( $query->posts ) {
            foreach ( $query->posts as $post ) {
                $submissions[] = $post->ID;
            }
        }
        return count($submissions);
    }
}