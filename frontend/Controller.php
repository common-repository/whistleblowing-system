<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class WBLSFront_Controller {
    public $submissions = array();
    public $form_data = array();
    public $user_token = '';
    public $admin_token = '';

    public function __construct( $task ) {
        if ( method_exists($this, $task) && $task != '__construct' ) {
                $this->$task();
        }
    }

    public function wbls_reply() {        
        $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
        if ( ! wp_verify_nonce( $nonce, 'wbls_ajax_nonce' ) ) {
            die( esc_html__( 'Security check', 'whistleblowing-system' ) );
        }
        $wbls_security = isset($_POST['wbls_security']) ? sanitize_text_field($_POST['wbls_security']) : '';
        if( $wbls_security != "" ) {
            wp_send_json_error(array(
                'message' => esc_html__('Security issue!', 'whistleblowing-system'),
            ));
        }

        $reply = isset( $_POST['reply'] ) ? sanitize_text_field($_POST['reply']) : '';
        $token = isset( $_POST['token'] ) ? sanitize_text_field($_POST['token']) : '';
        $form_id = isset( $_POST['wbls_form_id'] ) ? intval($_POST['wbls_form_id']) : 0;
        if( $form_id == 0 ) {
            wp_send_json_error(array(
                'message' => esc_html__('Security issue!', 'whistleblowing-system'),
            ));
        }

        $file_path = "";
        if( ($reply == "" && $file_path == "") || $token == "" ) {
            wp_send_json_error(array(
                'message' => esc_html__('Something went wrong', 'whistleblowing-system'),
            ));
        }

        $args = array(
            'post_type'		=>	'wbls_form_subm',
            'post_status' => 'closed',
            'meta_query'	=>	array(
                array(
                    'key'	=>	['wbls_admin_token', 'wbls_user_token'],
                    'value'	=>	$token,
                )
            ),
            "numberposts" => 1000,
            "posts_per_page" => 1000,
        );
        $query = new WP_Query( $args );
        $post_id = 0;
        $admin_token_active = 1;
        if ( $query->posts ) {
            foreach ( $query->posts as $post ) {
                $post_id = $post->ID;
                $temp_token = get_post_meta($post_id, 'wbls_user_token', 1);
                if( $token == $temp_token ) {
                    $admin_token_active = 0;
                }
            }
        } else {
            wp_send_json_error(array(
                'message' => esc_html__('Token is not correct, please check and try one more time', 'whistleblowing-system'),
            ));
        }

        $role = 'user';
        if( $admin_token_active ) {
            $role = 'admin';
        }
        $chat = array(
            'message' => sanitize_text_field($reply),
            'file' => !empty($chat_attachments) ? $chat_attachments : [],
            'published' => 1,
            'role' => $role,
            'modified_date' => current_time( 'timestamp' ),
        );

        $chats = get_post_meta( $post_id, 'wbls_chat', 1 );

        $chats[] = $chat;

        $message_insert = update_post_meta($post_id, 'wbls_chat', $chats, false);

        if ( $message_insert ) {
            $response_data = array('message' => array());
            foreach ( $chats as $chat ) {
                $file = [];
                if( !empty($chat) ) {
                    if( !empty($chat['file']) ) {
                        if (is_array($chat['file'])) {
                            $files = [];
                            foreach ($chat['file'] as $file) {
                                $files[] = !empty($file) ? esc_url(WBLS_UPLOAD_URL . '/' . $file) : '';
                            }
                            $file = $files;
                        } else {
                            $file[] = !empty($chat['file']) ? esc_url(WBLS_UPLOAD_URL . '/' . $chat['file']) : '';
                        }
                    }
                    $response_data['message'][] = array('text' => $chat['message'], 'attachment' => $file, 'role' => $chat['role'], 'date' => gmdate("Y-m-d H:i:s", $chat['modified_date']));
                }
            }
            
            wp_send_json_success(array(
                'chats' => $response_data,
            ), 200 );
        }

        wp_send_json_error(array(
            'message' => esc_html__('Something went wrong', 'whistleblowing-system'),
        ));
    }

    public function wbls_login() {
        $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
        if ( ! wp_verify_nonce( $nonce, 'wbls_ajax_nonce' ) ) {
            die( esc_html__( 'Security check', 'whistleblowing-system' ) );
        }
        $wbls_security = isset($_POST['wbls_security']) ? sanitize_text_field($_POST['wbls_security']) : '';
        if( $wbls_security != "" ) {
            wp_send_json_error(array(
                'message' => esc_html__('Security issue!', 'whistleblowing-system'),
            ));
        }
        $token = isset($_POST['wbls_token']) ? sanitize_text_field($_POST['wbls_token']) : '';
        if( $token == '' ) {
            wp_send_json_error(array(
                'message' => esc_html__('Token issue, please check and try one more time', 'whistleblowing-system'),
            ));
        }

        $args = array(
            'post_type'		=>	'wbls_form_subm',
            'post_status' => 'closed',
            'meta_query'	=>	array(
                array(
                    'key'	=>	['wbls_admin_token', 'wbls_user_token'],
                    'value'	=>	$token,
                )
            ),
            "numberposts" => 1000,
            "posts_per_page" => 1000,
        );
        $query = new WP_Query( $args );
        $post_id = 0;
        $admin_token_active = 1;
        if ( $query->posts ) {
            foreach ( $query->posts as $post ) {
                $post_id = $post->ID;
                $status_id = get_post_meta( $post_id, 'wbls_submission_status', 1 );
                if( intval($status_id) == 2 ) {
                    wp_send_json_error(array(
                        'message' => esc_html__('Your token is blocked', 'whistleblowing-system'),
                    ));
                }
                $temp_token = get_post_meta($post_id, 'wbls_user_token', 1);
                if( $token == $temp_token ) {
                    $admin_token_active = 0;
                }
            }
        } else {
            wp_send_json_error(array(
                'message' => esc_html__('Token is not correct, please check and try one more time', 'whistleblowing-system'),
            ));
        }
        $chats = get_post_meta($post_id, 'wbls_chat', 1);
        if ( empty($chats) ) {
            wp_send_json_error(array(
                'message' => esc_html__('There is no any message in this ticket, please open new ticket', 'whistleblowing-system'),
            ));
        }

        $response_data = array('admin_token_active' => $admin_token_active, 'message' => array());
        foreach ( $chats as $chat ) {
            $file = [];
            if( !empty($chat) ) {
                if( !empty($chat['file']) ) {
                    if (is_array($chat['file'])) {
                        $files = [];
                        foreach ($chat['file'] as $file) {
                            $files[] = !empty($file) ? esc_url(WBLS_UPLOAD_URL . '/' . $file) : '';
                        }
                        $file = $files;
                    } else {
                        $file[] = !empty($chat['file']) ? esc_url(WBLS_UPLOAD_URL . '/' . $chat['file']) : '';
                    }
                }
                $response_data['message'][] = array('text' => $chat['message'], 'attachment' => $file, 'role' => $chat['role'], 'date' => gmdate("Y-m-d H:i:s", $chat['modified_date']));
            }
        }


        wp_send_json_success(array(
            'chats' => $response_data,
        ), 200 );

    }

    public function wbls_submit_form() {

        $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
        if ( ! wp_verify_nonce( $nonce, 'wbls_ajax_nonce' ) ) {
            wp_send_json_error(array(
                'message' => esc_html__("Security check", "whistleblowing-system"),
            ));
        }
        $form_id = isset($_POST['wbls_form_id']) ? intval($_POST['wbls_form_id']) : 0;
        $wbls_security = isset($_POST['wbls_security']) ? sanitize_text_field($_POST['wbls_security']) : '';
        if( !$form_id || $wbls_security != "" ) {
            wp_send_json_error(array(
                'message' => esc_html__("Security check", "whistleblowing-system"),
            ));
        }

        $this->form_data = get_post_meta( $form_id, 'wbls_field_options', true );
        $submission = array();
        $required_validation = true;
        $file_path = '';
        $chatMessage = '';
        $wbls_hidden_conditions = isset($_POST['wbls_hidden_conditions']) ? sanitize_text_field($_POST['wbls_hidden_conditions']) : '';
        if( $wbls_hidden_conditions != '' ) {
            $wbls_hidden_conditions = explode(",",$wbls_hidden_conditions);
        }
        foreach ( $this->form_data as $data ) {
            if( empty($data) ) {
                continue;
            }

            $name = $data['name'];
            /* Check if field hidden by condition and skip required check */
            if( $wbls_hidden_conditions != '' && !in_array($name, $wbls_hidden_conditions) ) {
                /* Check required */
                if ($data['type'] == 'fullName') {
                    if ((empty($_POST[$name . '_f']) || (empty($_POST[$name . '_m']) && $data['hideMiddleName'] != 1) || empty($_POST[$name . '_l'])) && $data['required']) {
                        $required_validation = false;
                        break;
                    }
                } elseif ($data['type'] == 'address') {
                    if ((empty($_POST[$name . '_street']) ||
                        empty($_POST[$name . '_city']) ||
                        empty($_POST[$name . '_state']) ||
                        empty($_POST[$name . '_postal']) ||
                        empty($_POST[$name . '_country'])) && $data['required'] ) {
                        $required_validation = false;
                        break;
                    }
                } elseif ($data['type'] == 'checkbox') {
                    foreach ($data['options'] as $option) {
                        $name = $option['name'];
                        if (empty($_POST[$name]) && $data['required']) {
                            $required_validation = false;
                            break;
                        }
                    }
                } else {
                    if (empty($_POST[$name]) && $data['required'] && !isset($_FILES[$name])) {
                        $required_validation = false;
                        break;
                    }
                }
            }

            if ( $data['type'] == 'fullName' ) {
                $fName = isset($_POST[$name.'_f']) ? sanitize_text_field($_POST[$name.'_f']) : '';
                $mName = isset($_POST[$name.'_m']) ? sanitize_text_field($_POST[$name.'_m']) : '';
                $lName = isset($_POST[$name.'_l']) ? sanitize_text_field($_POST[$name.'_l']) : '';
                $submission[$name] = array(
                    'firstName' => $fName,
                    'middleName' => $mName,
                    'lastName' => $lName,
                );
            }
            elseif ( $data['type'] == 'address' ) {
                $street = isset($_POST[$name.'_street']) ? sanitize_text_field($_POST[$name.'_street']) : '';
                $street1 = isset($_POST[$name.'_street1']) ? sanitize_text_field($_POST[$name.'_street1']) : '';
                $city = isset($_POST[$name.'_city']) ? sanitize_text_field($_POST[$name.'_city']) : '';
                $state = isset($_POST[$name.'_state']) ? sanitize_text_field($_POST[$name.'_state']) : '';
                $postal = isset($_POST[$name.'_postal']) ? sanitize_text_field($_POST[$name.'_postal']) : '';
                $country = isset($_POST[$name.'_country']) ? sanitize_text_field($_POST[$name.'_country']) : '';
                $submission[$name] = array(
                    'street' => $street,
                    'street1' => $street1,
                    'city' => $city,
                    'state' => $state,
                    'postal' => $postal,
                    'country' => $country,
                );
            }
            elseif( $data['type'] == 'checkbox' ) {
                foreach ( $data['options'] as $option ) {
                    $name = $option['name'];
                    $submission[$name] = isset($_POST[$name]) ? sanitize_text_field($_POST[$name]) : '';
                }
            }
            elseif ( isset($_POST[$name]) ) {
                $submission[$name] = isset($_POST[$name]) ? sanitize_text_field($_POST[$name]) : '';
                if ($data['type'] == 'textarea') {
                    $chatMessage = $submission[$name];
                }
            }
        }

	    $this->submissions = $submission;
        if( !$required_validation ) {
            wp_send_json_error();
        }

        $my_post = array(
            'post_status'   => 'closed',
            'post_author'   => 1,
            'post_type' => 'wbls_form_subm'
        );

        /* Create submission post */
        $insert = wp_insert_post($my_post);
        if( $insert ) {
            foreach ( $submission as $key => $subm ) {
                add_post_meta( $insert, $key, $subm, true );
            }
            add_post_meta( $insert, 'wbls_created_at', current_time( 'timestamp' ), true );
            add_post_meta( $insert, 'wbls_form_id', intval($form_id), true );

            $whistleblower_active = WBLSLibrary::is_whistleblower_active($form_id);

            if( $whistleblower_active ) {
                $this->user_token = md5(uniqid(wp_rand(), true));
                $this->admin_token = md5(uniqid(wp_rand(), true));

                add_post_meta( $insert, 'wbls_admin_token', $this->admin_token, true );
                add_post_meta( $insert, 'wbls_user_token', $this->user_token, true );


                $chat[] = array(
                    'message' => sanitize_text_field($chatMessage),
                    'file' => !empty($chat_attachments) ? $chat_attachments : '',
                    'published' => 1,
                    'role' => 'user',
                    'modified_date' => current_time( 'timestamp' ),
                );
                $message_insert = add_post_meta( $insert, 'wbls_chat', $chat, true );
                if ( $message_insert ) {
                    $this->wbls_send_email( $form_id );
                    wp_send_json_success( array(
                        'whistleblower_active' => $whistleblower_active,
                        'token' => $this->user_token,
                    ), 200 );
                }
            } else {
                $this->wbls_send_email( $form_id );
                wp_send_json_success( array(
                    'whistleblower_active' => $whistleblower_active
                ), 200 );
            }

        }
        wp_send_json_error();
    }

    private function wbls_send_email( $form_id, $subject = '', $body = '' ) {

        $settings = get_post_meta( $form_id, 'wbls_email_options', true );
        $subjectTemp = $subject;
        if( isset($settings['sendemail']) && $settings['sendemail'] && isset($settings['admin_mail']) && $settings['admin_mail'] != '') {
            $to = esc_html($settings['admin_mail']);
            if( $subject == '' ) {
                $subject = !empty($settings['mail_subject']) ? esc_html($this->convert_body_placeholders($settings['mail_subject'], 1)) : 'Whistleblower new message';
            }
            $from_name = !empty($settings['from_name']) ? esc_html($settings['from_name']) : 'Whistleblower';
            $from_mail = !empty($settings['wbls_mail_from']) ? esc_html($settings['wbls_mail_from']) : '';
            if( $body == '' ) {
                $body = !empty($settings['wbls_mail_body']) ? wp_kses($this->convert_body_placeholders($settings['wbls_mail_body'], 0), WBLSLibrary::$wp_kses_default) : 'You have new message from the Whistleblower form';
            }
            $headers[] = "Content-type: text/html; charset=UTF-8";
            $headers[] = "MIME-Version: 1.0";
            $headers[] = "Content-Transfer-Encoding: 8bit";
            if ( $from_mail != '' ) {
                $headers[] = "From: " . $from_name . " <" . $from_mail . ">";
            } else {
                $headers[] = "From: " . $from_name . " <" . get_bloginfo('admin_email') . ">";
            }
            wp_mail($to, $subject, $body, $headers);
        }
    }

    private function get_email_fields() {
        $emails = [];
        foreach ($this->form_data as $data ) {
            if ( empty($data) || $data['type'] != 'email' ) {
                continue;
            }
            $emails[] = $this->submissions[$data['name']];
        }
        return $emails;
    }

    private function convert_body_placeholders( $body, $is_subject ) {
        foreach ($this->form_data as $data ) {
            if ( empty($data) ||
                ($data['type'] == 'submit' ||
                (!isset($this->submissions[$data['name']]) && $data['type'] != 'checkbox' )) ) {
                continue;
            }
            if ( $data['type'] == 'file' ) {
                continue;
            }
            if ( $data['type'] == 'checkbox' ) {
                $emailText = '';
                foreach ( $data['options'] as $option ) {
                    if( $this->submissions[$option['name']] ) {
                        $text = esc_html__('Checked', 'whistleblowing-system');
                    } else {
                        $text = esc_html__('Not checked', 'whistleblowing-system');
                    }
                    $emailText .= $option['miniLabel'] . ": " . $text . "\n";
                }
                $default_label = ( $data['label'] == "" ) ? "Checkbox": $data['label'];
                $body = str_replace("{".$default_label."}", $emailText, $body);
            } elseif( $data['type'] == 'fullName' ) {
                $val = $this->submissions[$data['name']];
                $fullName = $val['firstName'] . ' ' . $val['middleName'] . ' ' . $val['lastName'];
                $body = str_replace("{" . $data['label'] . "}", $data['label'] . ": " . $fullName, $body);
            } elseif( $data['type'] == 'address' ) {
                $val = $this->submissions[$data['name']];
                $addressJoined = '';
                if( is_array($val) ) {
                    foreach ($val as $a) {
                        if ($a != '') {
                            $addressJoined .= $a . ', ';
                        }
                    }
                    $addressJoined = substr($addressJoined, 0, -2);
                }

                $body = str_replace("{" . $data['label'] . "}", $data['label'] . ": " . $addressJoined, $body);
            } else {
                if( $is_subject ) {
                    $body = str_replace("{" . $data['label'] . "}", $this->submissions[$data['name']], $body);
                } else {
                    $body = str_replace("{" . $data['label'] . "}", $data['label'] . ": " . $this->submissions[$data['name']], $body);
                }
            }
        }
        $body = str_replace("{Admin Token}", "Admin Token: " . $this->admin_token, $body);
        $body = str_replace("{User Token}", "User Token: " . $this->user_token, $body);
        return $body;
    }
}
