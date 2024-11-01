<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WhistleblowerForms {
    public function __construct() {
        $task = isset($_GET['task']) ? sanitize_text_field($_GET['task']) : '';
        if ( method_exists($this, $task) ) {
            $this->$task();
        } else {
            $this->display();
        }
    }

    public function display() {
        $forms = get_posts( ['post_type' => 'wbls_form', 'numberposts' => -1] );
        wp_enqueue_style(WBLS_WhistleBlower::instance()->prefix . '-style');
        ?>
        <div class="wbls-admin-header">
            <img class="wbls-admin-header-logo" src="<?php echo WBLS_URL; ?>/admin/assets/images/whistleblowing_logo.png">
            <h2 class="wbls-page-title"><?php esc_html_e('All Forms', 'whistleblowing-system') ?></h2>
            <a href="?page=whistleblower_form_edit" class="wbls-button wbls-button-add-form"><?php esc_html_e('Add New', 'whistleblowing-system') ?></a>
        </div>
        <p class="wbls-response-message"></p>
        <div class="wrap wbls-content">
            <div class="wbls-forms-list">
                <div class="wbls-forms-list-row wbls-forms-list-title">
                    <div class="wbls-form-name"><?php esc_html_e('Name', 'whistleblowing-system') ?></div>
                    <div class="wbls-form-author"><?php esc_html_e('Author', 'whistleblowing-system') ?></div>
                    <div class="wbls-form-shortcode"><?php esc_html_e('Shortcode', 'whistleblowing-system') ?></div>
                    <div class="wbls-form-date"><?php esc_html_e('Date', 'whistleblowing-system') ?></div>
                    <div class="wbls-form-type"><?php esc_html_e('Type', 'whistleblowing-system') ?></div>
                </div>
                <?php
                foreach ($forms as $form ) {
                    $whistleblower_active = WBLSLibrary::is_whistleblower_active( $form->ID );
                    ?>
                    <div class="wbls-forms-list-row">
                        <div class="wbls-form-name">
                            <a href="?page=whistleblower_form_edit&id=<?php echo intval($form->ID) ?>"><?php echo esc_html($form->post_title) ?></a>
                            <div class="wbls-row-actions row-actions">
                                <span class="edit"><a href="?page=whistleblower_form_edit&id=<?php echo intval($form->ID) ?>" aria-label="Edit “Hello world!”"><?php esc_html_e('Edit', 'whistleblowing-system') ?></a> | </span>
                                <span class="wbls-delete-form" data-id="<?php echo intval($form->ID); ?>">
                                    <?php esc_html_e('Delete', 'whistleblowing-system') ?>
                                </span>
                            </div>
                        </div>
                        <div class="wbls-form-author"><?php echo esc_html($form->post_author); ?></div>
                        <div class="wbls-form-shortcode">[wblsform id="<?php echo intval($form->ID); ?>"]</div>
                        <div class="wbls-form-date"><?php echo esc_html($form->post_date); ?></div>
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
}
