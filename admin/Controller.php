<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class WBLS_Controller {
    public function __construct( $task ) {
        if ( method_exists($this, $task) && $task != '__construct' ) {
            $this->$task();
        }
    }

    /* New insert form functionality */
    public function wbls_add_form() {
        $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
        if ( ! wp_verify_nonce( $nonce, 'wbls_ajax_nonce' ) ) {
            wp_send_json_error(array(
                'message' => esc_html__( 'You are not allowed to add form', 'whistleblowing-system' ),
            ));
        }

        $form_id = isset($_POST['form_id']) ? intval($_POST['form_id']) : 0;
        if ( $form_id && get_post_type( $form_id ) != 'wbls_form' ) {
            wp_send_json_error(array(
                'message' => esc_html__( 'Wrong Form ID.', 'whistleblowing-system' ),
            ));
        }
        $form_content = isset($_POST['form']) ? wp_kses(trim($_POST['form']), WBLSLibrary::$wp_kses_form) : '';
        $form_content = str_replace("\n", "", $form_content);
        $my_post = array(
            'post_title'    => wp_strip_all_tags( $_POST['form_title'] ),
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_category' => array( 8,39 ),
            'post_type' => 'wbls_form'
        );

        $field_options = isset($_POST['field_options']) ? $_POST['field_options'] : '';
        if( !empty($field_options) ) {
            foreach ( $field_options as $key => $field_option ) {
                if ( empty($field_option) ) {
                    unset($field_options[$key]);
                }
            }
        }
        $email_options = isset($_POST['email_options']) ? $_POST['email_options'] : '';
        $form_settings = isset($_POST['form_settings']) ? $_POST['form_settings'] : '';
        if( !empty($form_settings['form_header']) ) {
            $form_settings['form_header'] = wp_kses($form_settings['form_header'], WBLSLibrary::$wp_kses_default);
        }
        if( !empty($form_settings['token_header']) ) {
            $form_settings['token_header'] = wp_kses($form_settings['token_header'], WBLSLibrary::$wp_kses_default);
        }
        if( !empty($form_settings['login_header']) ) {
            $form_settings['login_header'] = wp_kses($form_settings['login_header'], WBLSLibrary::$wp_kses_default);
        }

        $fieldNameLastId = isset($_POST['fieldNameLastId']) ? $_POST['fieldNameLastId'] : '';

        $form_conditions = isset($_POST['form_conditions']) ? $_POST['form_conditions'] : [];
        if( !empty($form_conditions) ) {
            $form_conditions = $this->wbls_clear_conditions_array($form_conditions, $field_options);
        }
        require_once "includes/conditions.php";

        if ( $form_id ) {
            $my_post['ID'] = $form_id;
            $insert = wp_update_post( $my_post );

            if ( $insert ) {

                $post_meta = update_post_meta( $form_id, 'wbls_field_options', $field_options, false);
                update_post_meta( $form_id, 'wbls_email_options', $email_options, false);
                update_post_meta( $form_id, 'wbls_form_settings', $form_settings, false);
                update_post_meta( $form_id, 'wbls_fieldNameLastId', intval($fieldNameLastId), false);
                update_post_meta( $form_id, 'wbls_form_content', wp_kses($form_content, WBLSLibrary::$wp_kses_form), false);
                wp_update_post( array('ID' => $form_id, 'post_content' => '[wblsform id="' . intval($form_id) . '"]') );
                update_post_meta($form_id, 'wbls_form_conditions', $form_conditions, false);
                $args = [
                    'form_id' => $form_id,
                    'field_options' => $field_options,
                    'form_conditions' => $form_conditions
                ];
                if( !empty($form_conditions) ) {
                    new WBLS_Conditions($args);
                }

                $reload_url = '';
                if( $post_meta ) {
                    $reload_url = add_query_arg(array(
                        'page' => 'whistleblower_form_edit',
                        'id' => $form_id,
                    ), admin_url('admin.php'));
                }


                wp_send_json_success(array(
                    'form_id' => intval($insert),
                    'message' => esc_html__('Form successfully updated.', 'whistleblowing-system'),
                    'reload_url' => $reload_url,
                ), 200);
            }
        } else {
            $insert = wp_insert_post( $my_post );
            if( $insert ) {
                $post_meta = add_post_meta( $insert, 'wbls_field_options', $field_options, true );
                add_post_meta( $insert, 'wbls_email_options', $email_options, true );
                add_post_meta( $insert, 'wbls_form_settings', $form_settings, true );
                add_post_meta( $insert, 'wbls_fieldNameLastId', intval($fieldNameLastId), true );
                add_post_meta( $insert, 'wbls_form_content', wp_kses($form_content, WBLSLibrary::$wp_kses_form), true);
                if( !empty($form_conditions) ) {
                    add_post_meta($form_id, 'wbls_form_conditions', $form_conditions, true);
                    $args = [
                        'form_id' => $form_id,
                        'field_options' => $field_options,
                        'form_conditions' => $form_conditions
                    ];
                    if( !empty($form_conditions) ) {
                        new WBLS_Conditions($args);
                    }
                }
                wp_update_post( array('ID' => $insert, 'post_content' => '[wblsform id="' . intval($insert) . '"]') );

                $reload_url = add_query_arg(array(
                                                'page' => 'whistleblower_form_edit',
                                                'id' => intval($insert),
                                            ), admin_url('admin.php'));

                if( $post_meta ) {
                    wp_send_json_success(array(
                        'form_id' => intval($insert),
                        'message' => esc_html__('Form successfully updated.', 'whistleblowing-system'),
                        'reload_url' => $reload_url,
                    ), 200);
                } else {
                    wp_delete_post( $insert, true);
                    wp_send_json_error(array(
                        'message' => esc_html__( 'Error during the field or email options save, please try again.', 'whistleblowing-system' ),
                    ));
                }
            }
        }
        wp_send_json_error(array(
            'message' => esc_html__( 'Something went wrong, please try again.', 'whistleblowing-system' ),
        ));
    }

    /**
     *  Clearing Conditions array empty keys and removed fields
     *
     * @params $form_conditions array which has structure condition[field_id][conditions][group_id][condition_item_id]
     *
     * @return array $form_conditions
    */
    private function wbls_clear_conditions_array( $form_conditions, $field_options ) {

        /* This is condition[field_id] foreach */
        foreach ($form_conditions as $key => $val ) {
            if( empty($val) || empty($val['conditions']) || !isset($field_options[$key]) ) {
                unset($form_conditions[$key]);
            } else {
                /* This is condition[field_id][conditions] foreach */
                foreach($val['conditions'] as $key1 => $val1 ) {
                    if( empty($val1) ) {
                        unset($form_conditions[$key]['conditions'][$key1]);
                    } else {
                        /* This is condition[field_id][group_id] foreach */
                        foreach($val1 as $key2 => $val2 ) {
                            if( empty($val2) || !isset($field_options[$val2['field_id']]) ) {
                                unset($form_conditions[$key]['conditions'][$key1][$key2]);
                            }
                        }
                    }
                }
            }
        }

        return $form_conditions;
    }
    public function wbls_reply() {}

    public function wbls_set_default_theme() {}
    public function wbls_export_csv(){}

    public function get_submissions( $form_id = 0, $ids = '' ) {
        $submissions = [];
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

        if ( $query->posts ) {
            foreach ( $query->posts as $post ) {
                $submissions[] = $post->ID;
            }
        }
        return $submissions;
    }

    public function wbls_remove_submission() {
        $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
        if ( ! wp_verify_nonce( $nonce, 'wbls_ajax_nonce' ) ) {
            wp_send_json_error(["nonce" => 'false']);
        }

        $submission_id = isset($_POST['submission_id']) ? intval($_POST['submission_id']) : 0;
        global $wpdb;
        $delete = $wpdb->query("DELETE p, pm FROM " . $wpdb->prefix . "posts p INNER JOIN " . $wpdb->prefix . "postmeta pm ON pm.post_id = p.ID
                                        WHERE p.ID=" . intval($submission_id));
        wp_send_json_success(["delete" => $delete]);
    }

    public function wbls_change_status() {
        $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
        if ( ! wp_verify_nonce( $nonce, 'wbls_ajax_nonce' ) ) {
            wp_send_json_error(["nonce" => 'false']);
        }

        $submission_id = isset($_POST['submission_id']) ? intval($_POST['submission_id']) : 0;
        $status_id = isset($_POST['status_id']) ? intval($_POST['status_id']) : 0;

        update_post_meta( $submission_id, 'wbls_submission_status', $status_id );
        wp_send_json_success();
    }

    public function wbls_remove_all_submission() {
        $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
        if ( ! wp_verify_nonce( $nonce, 'wbls_ajax_nonce' ) ) {
            wp_send_json_error(["nonce" => 'false']);
        }
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $args = array(
            'post_type'		=>	'wbls_form_subm',
            'post_status' => 'closed',
            'meta_query'	=>	array(
                array(
                    'key'	=>	'wbls_form_id',
                    'value'	=>	$id,
                )
            ),
            "numberposts" => 1000,
            "posts_per_page" => 1000,
        );
        $query = new WP_Query( $args );
        if ( $query->posts ) {
            global $wpdb;
            foreach ( $query->posts as $post ) {
                $wpdb->query("DELETE p, pm FROM " . $wpdb->prefix . "posts p INNER JOIN " . $wpdb->prefix . "postmeta pm ON pm.post_id = p.ID
                                    WHERE p.ID=".$post->ID);
            }
        }
        wp_send_json_success();
    }

    public function remove_form() {
        $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
        if ( ! wp_verify_nonce( $nonce, 'wbls_ajax_nonce' ) ) {
            wp_send_json_error(["nonce" => 'false']);
        }
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        wp_delete_post($id);
        delete_post_meta($id, 'wbls_field_options');
        delete_post_meta($id, 'wbls_email_options');
        delete_post_meta($id, 'wbls_form_settings');
        delete_post_meta($id, 'wbls_fieldNameLastId');
        delete_post_meta($id, 'wbls_form_content');
        delete_post_meta($id, 'wbls_form_conditions');

        $args = array(
            'post_type'		=>	'wbls_form_subm',
            'post_status' => 'closed',
            'meta_query'	=>	array(
                array(
                    'key'	=>	'wbls_form_id',
                    'value'	=>	$id,
                )
            ),
            "numberposts" => 1000,
            "posts_per_page" => 1000,
        );
        $query = new WP_Query( $args );
        if ( $query->posts ) {
            global $wpdb;
            foreach ( $query->posts as $post ) {
                $wpdb->query("DELETE p, pm FROM " . $wpdb->prefix . "posts p INNER JOIN " . $wpdb->prefix . "postmeta pm ON pm.post_id = p.ID
                                WHERE p.ID=".$post->ID);
            }
        }
        wp_send_json_success();
    }

    public function remove_theme() {
        $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
        if ( ! wp_verify_nonce( $nonce, 'wbls_ajax_nonce' ) ) {
            wp_send_json_error(["nonce" => 'false']);
        }
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

        wp_delete_post($id);
        delete_post_meta($id, 'wbls_theme');
        $wp_upload_dir = wp_upload_dir();
        $wbls_style_file = $wp_upload_dir[ 'basedir' ] . '/wbls-system/wbls-theme-style_'.$id.'.css';
        unlink($wbls_style_file);
        wp_send_json_success();
    }

    public function wbls_save_settings()
    {
        $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
        if (!wp_verify_nonce($nonce, 'wbls_ajax_nonce')) {
            wp_send_json_error(["nonce" => 'false']);
        }
        $teeny_active = isset($_POST['teeny_active']) ? intval($_POST['teeny_active']) : 1;
        update_option( 'teeny_active', $teeny_active );
        wp_send_json_success();
    }

    public function wbls_bulk_action() {
        /* Pro started */
        $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
        if ( ! wp_verify_nonce( $nonce, 'wbls_ajax_nonce' ) ) {
            wp_send_json_error(["nonce" => 'false']);
        }

        $ids = isset($_POST['ids']) ? WBLSLibrary::sanitize_array($_POST['ids'], 'intval') : '';

        $action_type = isset($_POST['action_type']) ? 'bulk_' . sanitize_text_field($_POST['action_type']) : '';
        if ( $action_type == 'bulk_activate' || $action_type == 'bulk_block' || $action_type == 'bulk_complete' ) {
            $this->bulk_status_change( $ids, $action_type );
        }
        elseif ( method_exists($this, $action_type) ) {
            $this->$action_type( $ids );
        }
        wp_send_json_success();
        /* Pro end */
    }

    public function bulk_delete( $ids = [] ) {
        global $wpdb;
        if (!empty($ids)) {
            $submission_ids_string = implode(',', $ids);
            // Corrected query to delete posts and post meta data in one go
            $wpdb->query(
                "DELETE p, pm 
                 FROM {$wpdb->posts} p
                 INNER JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID
                 WHERE p.ID IN ($submission_ids_string)"
            );
            wp_send_json_success(["message" => 'Submissions successfully deleted']);
        }
        wp_send_json_error(["message" => 'There is no selected submission to delete']);
    }

    public function bulk_status_change( $ids, $status ) {
        if (!empty($ids)) {
            $st = 0;
            switch ($status) {
                case "bulk_block":
                    $st = 2;
                    break;
                case "bulk_complete":
                    $st = 1;
                    break;
            }
            foreach ( $ids as $id ) {
                update_post_meta( $id, 'wbls_submission_status', $st );
            }

            wp_send_json_success(["message" => 'The statuses were changed successfully.']);
        }
        wp_send_json_error(["message" => 'There is no selected submission to delete']);

    }
}
