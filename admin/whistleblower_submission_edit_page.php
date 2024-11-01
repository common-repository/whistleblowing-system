<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WhistleblowerSubmissionEdit {

    public $fields = [];
    public $form_id;
    public $submissions = [];
    public $settings = [];
    public $whistleblower_active = false;

    public function __construct() {
        $task = isset($_GET['task']) ? sanitize_text_field($_GET['task']) : '';
        $this->form_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $this->get_submissions();
        $this->get_form_fields();
        $this->whistleblower_active = WBLSLibrary::is_whistleblower_active( $this->form_id );
        $this->settings = get_post_meta($this->form_id, 'wbls_form_settings', 1);

        if ( method_exists($this, $task) ) {
            $this->$task();
        } else {
            $this->display();
        }
    }

    public function get_submissions() {
        $args = array(
            'post_type' => 'wbls_form_subm',
            'post_status' => 'closed',
            'meta_query' => array(
                array(
                    'key' => 'wbls_form_id',
                    'value' => $this->form_id,
                    'compare' => '=',
                )
            ),
            "numberposts" => 1000,
            "posts_per_page" => 1000,
        );
        $query = new WP_Query($args);

        if ( $query->posts ) {
            foreach ( $query->posts as $post ) {
                $this->submissions[] = $post->ID;
            }
        }
    }

    public function get_form_fields() {
        $fields = get_post_meta($this->form_id, 'wbls_field_options', true);
        $this->fields = $fields;
    }

    public function display() {
        $file_max_size = isset($this->settings['file_max_size']) ? floatval($this->settings['file_max_size']) : 10;
        $ajaxnonce = wp_create_nonce('wbls_ajax_nonce');
        $export_url = add_query_arg(array(
            'form_id' => $this->form_id,
            'nonce' => $ajaxnonce,
            'action' => 'wbls_admin_ajax',
            'task' => 'download_csv_file'
        ), admin_url('admin-ajax.php'));

        wp_enqueue_style(WBLS_WhistleBlower::instance()->prefix . '-submissions');
        wp_enqueue_style(WBLS_WhistleBlower::instance()->prefix . '-style');
        wp_enqueue_script( WBLS_WhistleBlower::instance()->prefix . '-submissions');
        wp_localize_script(WBLS_WhistleBlower::instance()->prefix . '-submissions', 'wbls_submissions', array(
            "ajaxnonce" => $ajaxnonce,
            'file_size_msg' =>  esc_html__("File size should be less then", 'whistleblowing-system'),
            'file_type_msg' =>  esc_html__("Invalid file type: allowed types are", 'whistleblowing-system'),
            'file_max_size' =>  $file_max_size,
            'file_types' =>  $this->settings['file_types'] ?? ['jpg', 'png', 'gif'],
            'export_url' => $export_url,
            'submission_success_delete' => esc_html__("Submission successfully deleted", 'whistleblowing-system'),
            'submission_error_delete' => esc_html__("Something went wrong", 'whistleblowing-system'),
        ));
        ?>
        <div class="wbls-admin-header">
            <img class="wbls-admin-header-logo" src="<?php echo WBLS_URL; ?>/admin/assets/images/whistleblowing_logo.png">
            <h2 class="wbls-page-title">
                <?php esc_html_e('Submissions of', 'whistleblowing-system'); ?>
                <?php echo get_the_title($this->form_id); ?>
                <?php esc_html_e('form', 'whistleblowing-system'); ?>
            </h2>
            <span class="wbls-button wbls-export-csv wbls-pro-tooltip-action"><?php esc_html_e('Export CSV', 'whistleblowing-system') ?></span>
        </div>
        <p class="wbls-response-message"></p>
        <div class="wbls-bulk-action-row">
            <select class="wbls-bulk-actions">
                <option value="-1"><?php esc_html_e('Bulk Actions', 'whistleblowing-system'); ?></option>
                <option value="delete"><?php esc_html_e('Delete', 'whistleblowing-system'); ?></option>
                <option value="activate"><?php esc_html_e('Activate', 'whistleblowing-system'); ?></option>
                <option value="block"><?php esc_html_e('Block', 'whistleblowing-system'); ?></option>
                <option value="complete"><?php esc_html_e('Complete', 'whistleblowing-system'); ?></option>
            </select>
            <span class="button wbls-bulk-action-apply"><?php esc_html_e('Apply', 'whistleblowing-system'); ?></span>
        </div>
        <div class="wrap wbls-content">
            <table class="wp-list-table wbls-subm-table">
                <thead>
                <tr>
                    <th><input type="checkbox" name="all" data-id="all" class="wbls-all-submissions"></th>
                    <th>#</th>
                    <?php
                    foreach ( $this->fields as $field ) {
                        if( empty($field) || $field['type'] == 'submit' || $field['type'] == 'recaptcha' || $field['type'] == 'page_break' ) {
                            continue;
                        } elseif ( $field['type'] == 'checkbox' ) {
                            foreach ( $field['options'] as $option ) {
                                $shortText = strip_tags($option['miniLabel']);
                                if(strlen($shortText) > 20) {
                                    $shortText = substr($shortText, 0, 20) . '...';
                                }
                                ?>
                                <th title="<?php echo esc_html($option['miniLabel']); ?>"><?php echo strip_tags($shortText); ?></th>
                                <?php
                            }
                        } else {
                            $shortText = $field['label'];
                            if(strlen($field['label']) > 20) {
                                $shortText = substr($shortText, 0, 20) . '...';
                            }
                            ?>
                            <th title="<?php echo esc_html($field['label']); ?>"><?php echo strip_tags($shortText); ?></th>
                            <?php
                        }
                    }
                    ?>
                    <th><?php esc_html_e('Date', 'whistleblowing-system') ?></th>
                    <?php if ( $this->whistleblower_active ) { ?>
                        <th><?php esc_html_e('Chat', 'whistleblowing-system') ?></th>
                        <th><?php esc_html_e('Access', 'whistleblowing-system') ?></th>
                        <th><?php esc_html_e('Status', 'whistleblowing-system') ?></th>
                    <?php } ?>
                </tr>
                </thead>
                <tbody>
                <?php
                $count = count($this->submissions);
                foreach ( $this->submissions as $submission_id ) { ?>
                <tr>
                    <td><input type="checkbox" data-id="<?php echo intval($submission_id) ?>" class="wbls-single-submissions"></td>
                    <td><?php echo $count--; ?>
                        <div class="wbls-row-actions row-actions">
                          <span class="wbls-delete-submission" data-submissionId="<?php echo intval($submission_id); ?>">
                              <?php esc_html_e('Delete', 'whistleblowing-system'); ?>
                          </span>
                        </div>

                    </td>
                    <?php
                    foreach ( $this->fields as $field ) {
                        if( empty($field) || $field['type'] == 'submit' || $field['type'] == 'recaptcha' || $field['type'] == 'page_break') continue;
                        $field_value = get_post_meta($submission_id, $field['name'], true);
                        if( $field['type'] == 'file' && !empty($field_value)) {
                            $field_values = explode(',', $field_value);
                            ?>
                            <td>
                                <?php  foreach ( $field_values as $field_value )  {
                                    $file_url = WBLS_UPLOAD_URL . '/' . $field_value;
                                    $ext = pathinfo($field_value, PATHINFO_EXTENSION);
                                    ?>
                                <a href='<?php echo esc_url($file_url); ?>' target='_blank'>
                                    <?php
                                    if( $ext == 'pdf' ) {
                                        esc_html_e('PDF file', 'whistleblowing-system');
                                    } elseif( $ext == 'mp3' || $ext == 'wav') {
                                        ?>
                                        <span class="dashicons dashicons-microphone" title="<?php esc_html_e('Audio file', 'whistleblowing-system')?>"></span>
                                        <?php
                                    } elseif( strtolower($ext) == 'jpg' ||  strtolower($ext) == 'jpeg' || strtolower($ext) == 'png' || strtolower($ext) == 'gif') {
                                        ?>
                                        <img style="max-height: 25px; width: auto" src="<?php echo esc_url($file_url); ?>">
                                        <?php
                                    } else { ?>
                                        <span class="dashicons dashicons-format-video"></span>
                                    <?php } ?>
                                </a>
                                <?php } ?>
                            </td>
                            <?php
                        }
                        elseif ( $field['type'] == 'fullName' ) {
                            $firstName = $field_value['firstName'] ?? '';
                            $middleName = $field_value['middleName'] ?? '';
                            $lastName = $field_value['lastName'] ?? '';
                            $fullName = $firstName . ' ' . $middleName . ' ' . $lastName;
                            ?>
                            <td><?php echo esc_html($fullName); ?></td>
                        <?php
                        }
                        elseif ( $field['type'] == 'address' ) {
                            $addressJoined = '';
                            if( is_array($field_value) ) {
                                foreach ($field_value as $a) {
                                    if ($a != '') {
                                        $addressJoined .= $a . ', ';
                                    }
                                }
                                $addressJoined = substr($addressJoined, 0, -2);
                            }
                            ?>
                            <td><?php echo esc_html($addressJoined); ?></td>
                        <?php
                        }
                        elseif ( $field['type'] == 'checkbox' ) {
                            foreach ( $field['options'] as $option ) {
                                $field_value = get_post_meta($submission_id, $option['name'], true);
                                if( $field_value ) {
                                    $field_value = 'Checked';
                                }
                                ?>
                                <td><?php echo esc_html($field_value); ?></td>
                                <?php
                            }
                        }
                        elseif ( $field['type'] == 'textarea' ) {
                            $shortText = $field_value;
                            if(strlen($field_value) > 50) $shortText = substr($shortText, 0, 50).'...';
                            ?>
                            <td class="wbls-textarea" title="<?php echo esc_html($field_value); ?>"><?php echo esc_html($shortText); ?></td>
                        <?php
                        }
                        else { ?>
                            <td><?php echo esc_html($field_value); ?></td>
                        <?php
                        }
                    } ?>
                    <td>
                        <?php
                        $created_at = get_post_meta($submission_id, 'wbls_created_at', true);
                        echo date("Y-m-d H:i:s", $created_at);
                        ?>
                    </td>
                    <?php
                    if ( $this->whistleblower_active ) {
                        $admin_token = get_post_meta($submission_id, 'wbls_admin_token', true);
                        $user_token = get_post_meta($submission_id, 'wbls_user_token', true);
                        $status_id = get_post_meta( $submission_id, 'wbls_submission_status', 1 );
                        if( $status_id === false || $status_id === '' ) {
                            $status_id = 0;
                        }
                        $statuses = ['Active', 'Completed', 'Blocked'];
                        ?>
                        <td class="wbls-access-chat-column">
                            <span class="dashicons dashicons-format-chat wbls-chat-icon" title="<?php esc_html_e('Open Chat', 'whistleblowing-system'); ?>"></span>
                            <?php $this->chat($submission_id); ?>
                        </td>
                        <td class="wbls-access-key-column">
                            <span class="dashicons dashicons-admin-network wbls-access-icon" title="<?php esc_html_e('Get access tokens', 'whistleblowing-system') ?>"></span>
                            <div class="wbls-access-key-container">
                                <div class="wbls-access-key-item wbls-access-key-admin">
                                    <label><?php esc_html_e('Admin login token', 'whistleblowing-system') ?></label>
                                    <span><?php echo esc_html($admin_token); ?></span>
                                </div>
                                <div class="wbls-access-key-item wbls-access-key-user">
                                    <label><?php esc_html_e('User login token', 'whistleblowing-system') ?></label>
                                    <span><?php echo esc_html($user_token); ?></span>
                                <div>
                            </div>
                        </td>
                        <td class="wbls-status-column">
                            <spam class="wbls-status-button" title="Click to edit">
                                <span data-status="<?php echo intval($status_id); ?>" data-submission_id=<?php echo intval($submission_id); ?>  class="wbls-status-button-title"><?php echo $statuses[$status_id]; ?></span>
                                <div class="wbls-hidden wbls-status-dropdown">
                                    <?php foreach ($statuses as $key => $status ) { ?>
                                        <span data-status="<?php echo intval($key); ?>" class="wbls-status-item"><?php esc_html_e($status, 'whistleblowing-system'); ?></span>
                                    <?php } ?>
                                </div>
                            </spam>
                        </td>
                    <?php } ?>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    public function chat( $submission_id ) {
        $chats = get_post_meta( $submission_id, 'wbls_chat', 1 );
        if( !$chats ) $chats = [];
        $admin_token = get_post_meta( $submission_id, 'wbls_admin_token', 1 );
        ?>
        <div class="wbls-chats-content" style="display:none">
            <span class="dashicons dashicons-no wbls-chats-close"></span>
            <div class="wbls-chat-container">
                <div class="wbls-chats-section">
                    <?php
                    foreach ($chats as $chat ) {
                        $message = $chat['message'];
                        $files = [];
                        if( !is_array($chat['file']) ) {
                            $files[] = $chat['file'];
                        } else {
                            $files = $chat['file'];
                        }
                        ?>
                        <div class="wbls_<?php echo esc_html($chat['role']); ?>_row">
                            <div class="wbls_message_col">
                                <span class="wbls_message_role">
                                    <?php echo esc_html($chat['role'])." / "; ?>
                                    <?php echo date('d-m-Y H:i:s',esc_html($chat['modified_date'])); ?>
                                </span>
                                <?php if( $message != '' ) { ?>
                                <span class="wbls_message"><?php echo esc_html($message); ?></span>
                                <?php } ?>
                                <?php
                                foreach ( $files as $file ) {
                                    if( $file == '' ) continue;
                                    $file = WBLS_UPLOAD_URL . '/' . $file;
                                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                                    ?>
                                    <a href='<?php echo esc_url($file); ?>' target='_blank'>
                                        <?php
                                        if( $ext == 'pdf' ) {
                                            esc_html_e('PDF file', 'whistleblowing-system');
                                        } elseif( $ext == 'wav' || $ext == 'mp3' ) { ?>
                                            <span class="dashicons dashicons-microphone" title="<?php esc_html_e('Audio file', 'whistleblowing-system'); ?>"></span>
                                            <?php
                                        } elseif( strtolower($ext) == 'jpg' ||  strtolower($ext) == 'jpeg' || strtolower($ext) == 'png' || strtolower($ext) == 'gif') {
                                            ?>
                                            <img class="wbls_message_attachement" src="<?php echo esc_url($file); ?>">
                                            <?php
                                        } else { ?>
                                            <span class="dashicons dashicons-format-video" title="<?php esc_html_e('Video file', 'whistleblowing-system'); ?>"></span>
                                        <?php } ?>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="wbls-new-chat-section">
                <form class="wbls-reply-form" id="wbls-reply-form_<?php echo intval($submission_id); ?>">
                    <?php if( WBLS_PRO ) { ?>
                    <input type="hidden" name="action" value="wbls_admin_ajax">
                    <input type="hidden" name="task" value="wbls_reply">
                    <input type="hidden" value="<?php echo intval($this->form_id); ?>" name="wbls_form_id">
                    <input type="hidden" value="<?php echo esc_html($admin_token); ?>" name="wbls-admin-token" class="wbls-admin-token">
                    <input type="hidden" value="<?php echo intval($submission_id); ?>" name="wbls-ticket_id" class="wbls-ticket_id">
                    <?php } ?>
                    <textarea name="reply" class="wbls-new-reply"></textarea>
                    <div class="wbls-reply-button-container">
                        <!--PRO start-->
                        <div class="wbls-reply-attachement-cont">
                            <span class="imageName"></span>
                            <label for="wbls-file-input_<?php echo intval($submission_id); ?>">
                                <img title="Attachment" src="<?php echo WBLS_URL ?>/frontend/assets/images/attachment.svg"/>
                            </label>
                            <input id="wbls-file-input_<?php echo intval($submission_id); ?>" type="file" name="wbls-attachement[]" multiple="multiple" class="wbls-reply-attachement wbls-file-input" accept="image/*,.pdf,audio/*,video/*">
                        </div>
                        <!--PRO end-->
                        <button class="wbls-reply-button<?php echo !WBLS_PRO ? ' wbls-pro-tooltip-action' : '';?>"><?php esc_html_e('Send', 'whistleblowing-system') ?></button>
                    </div>
                </form>
                </div>
            </div>
        </div>

        <?php
    }
}
