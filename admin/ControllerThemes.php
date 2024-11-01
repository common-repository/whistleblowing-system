<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class WBLS_ControllerThemes
{
    public $defaults = array(
                        'general' =>
                            array (
                                'container_width' => '100',
                                'container_height' => '100',
                                'bg_color' => '#ffffff',
                                'border_width' => '0',
                                'border_style' => 'solid',
                                'border_color' => '#c1c1c1',
                                'border_radius' => '0',
                                'layout_bg_color' => '#000000',
                                'layout_bg_opacity' => '0.5',
                            ),
                        'general_form' =>
                                        array (
                                            'container_width' => '600',
                                            'bg_color' => '#f4f4f4',
                                            'margin' => 'auto',
                                            'padding' => '20px',
                                            'border_width' => '0',
                                            'border_style' => 'solid',
                                            'border_color' => '#c1c1c1',
                                            'border_radius' => '10',
                                        ),
                        'labels' =>
                                        array (
                                            'font_size' => '16',
                                            'font_weight' => 'bold',
                                            'color' => '#000000',
                                            'margin' => '0 0 10px 0',
                                            'padding' => '0',
                                            'border_width' => '0',
                                            'border_style' => 'solid',
                                            'border_color' => '#c1c1c1',
                                            'border_radius' => '0',
                                            'box_shadow' => 'none',
                                        ),
                        'input_fields' =>
                                        array (
                                            'width' => '100',
                                            'height' => '43',
                                            'font_size' => '16',
                                            'font_weight' => 'normal',
                                            'bg_color' => '#f9f9f9',
                                            'color' => '#000000',
                                            'margin' => '0px',
                                            'padding' => '2px 10px',
                                            'border_width' => '1',
                                            'border_style' => 'solid',
                                            'border_color' => '#c1c1c1',
                                            'border_radius' => '5',
                                            'box_shadow' => 'none',
                                        ),
                        'textarea' =>
                                        array (
                                            'width' => '100',
                                            'height' => '100',
                                            'font_size' => '16',
                                            'font_weight' => 'normal',
                                            'bg_color' => '#f9f9f9',
                                            'color' => '#000000',
                                            'margin' => '0px',
                                            'padding' => '2px 10px',
                                            'border_width' => '1',
                                            'border_style' => 'solid',
                                            'border_color' => '#c1c1c1',
                                            'border_radius' => '5',
                                            'box_shadow' => 'none',
                                        ),
                        'drodown_fields' =>
                                        array (
                                            'width' => '100',
                                            'height' => '43',
                                            'font_size' => '12',
                                            'font_weight' => 'normal',
                                            'bg_color' => '#ffffff',
                                            'color' => '#000000',
                                            'margin' => '0px',
                                            'padding' => '2px 10px',
                                            'border_width' => '1',
                                            'border_style' => 'solid',
                                            'border_color' => '#c1c1c1',
                                            'border_radius' => '2',
                                            'box_shadow' => 'none',
                                        ),
                        'checkbox_fields' =>
                                        array (
                                            'width' => '17',
                                            'height' => '17',
                                            'bg_color' => '#ffffff',
                                            'margin' => '0 12px 0 0',
                                            'padding' => '2px',
                                            'checked_bg_color' => '#000000',
                                            'label_font_size' => '14',
                                            'label_color' => '#000000',
                                            'label_font_weight' => 'normal',
                                            'accent-color' => '#000000',
                                        ),
                        'button_fields' =>
                                        array (
                                            'width' => '150',
                                            'height' => '43',
                                            'font_size' => '16',
                                            'bg_color' => '#303030',
                                            'color' => '#ffffff',
                                            'font_weight' => 'normal',
                                            'margin' => '12px 2px',
                                            'padding' => '0',
                                            'border_width' => '1',
                                            'border_style' => 'solid',
                                            'border_color' => '#000000',
                                            'border_radius' => '4',
                                            'box_shadow' => 'none',
                                            'text_align' => 'center',
                                            'hover_font_weight' => 'normal',
                                            'hover_bg_color' => '#000000',
                                            'hover_color' => '#ffffff',
                                        ),
                        'new_case_button_fields' =>
                                        array (
                                            'width' => '200',
                                            'height' => '40',
                                            'font_size' => '14',
                                            'bg_color' => '#d9514e',
                                            'color' => '#ffffff',
                                            'font_weight' => 'normal',
                                            'margin' => '2px',
                                            'padding' => '1px',
                                            'border_width' => '1',
                                            'border_style' => 'solid',
                                            'border_color' => '#c14545',
                                            'border_radius' => '2',
                                            'box_shadow' => 'none',
                                            'text_align' => 'center',
                                            'hover_font_weight' => 'normal',
                                            'hover_bg_color' => '#c14545',
                                            'hover_color' => '#ffffff',
                                        ),
                        'follow_case_button_fields' =>
                                        array (
                                            'width' => '200',
                                            'height' => '40',
                                            'font_size' => '14',
                                            'bg_color' => '#643e46',
                                            'color' => '#ffffff',
                                            'font_weight' => 'normal',
                                            'margin' => '2px',
                                            'padding' => '1px',
                                            'border_width' => '1',
                                            'border_style' => 'solid',
                                            'border_color' => '#593740',
                                            'border_radius' => '2',
                                            'box_shadow' => 'none',
                                            'text_align' => 'center',
                                            'hover_font_weight' => 'normal',
                                            'hover_bg_color' => '#643e46',
                                            'hover_color' => '#ffffff',
                                        ),
                        'client_message_styles' =>
                                        array (
                                            'font_size' => '14',
                                            'font_weight' => 'normal',
                                            'bg_color' => '#643e46',
                                            'color' => '#ffffff',
                                            'margin' => '2px',
                                            'padding' => '4px 12px',
                                            'border_width' => '1',
                                            'border_style' => 'solid',
                                            'border_color' => '#643e46',
                                            'border_radius' => '4',
                                            'box_shadow' => 'none',
                                        ),
                        'admin_message_styles' =>
                                        array (
                                            'font_size' => '14',
                                            'font_weight' => 'normal',
                                            'bg_color' => '#d9514e',
                                            'color' => '#ffffff',
                                            'margin' => '2px',
                                            'padding' => '4px 12px',
                                            'border_width' => '1',
                                            'border_style' => 'solid',
                                            'border_color' => '#d9514e',
                                            'border_radius' => '4',
                                            'box_shadow' => 'none',
                                        ),
                        'message_textarea' =>
                                        array (
                                            'width' => '100',
                                            'height' => '50',
                                            'font_size' => '14',
                                            'font_weight' => 'normal',
                                            'bg_color' => '#ffffff',
                                            'color' => '#000000',
                                            'margin' => '2px',
                                            'padding' => '2px',
                                            'border_width' => '1',
                                            'border_style' => 'solid',
                                            'border_color' => '#dfdfdf',
                                            'border_radius' => '5',
                                            'box_shadow' => 'none',
                                        ),
                        'message_send_button' =>
                                        array (
                                            'width' => '200',
                                            'height' => '38',
                                            'font_size' => '16',
                                            'bg_color' => '#303030',
                                            'color' => '#ffffff',
                                            'font_weight' => 'normal',
                                            'margin' => '2px',
                                            'padding' => '0',
                                            'border_width' => '1',
                                            'border_style' => 'solid',
                                            'border_color' => '#000000',
                                            'border_radius' => '4',
                                            'box_shadow' => 'none',
                                            'text_align' => 'center',
                                            'hover_font_weight' => 'normal',
                                            'hover_bg_color' => '#000000',
                                            'hover_color' => '#ffffff',
                                        ),
                        'login_input_styles' =>
                                        array (
                                            'width' => '100',
                                            'height' => '30',
                                            'font_size' => '14',
                                            'font_weight' => 'normal',
                                            'bg_color' => '#ffffff',
                                            'color' => '#000000',
                                            'margin' => '2px',
                                            'padding' => '2px',
                                            'border_width' => '1',
                                            'border_style' => 'solid',
                                            'border_color' => '#593740',
                                            'border_radius' => '2',
                                            'box_shadow' => 'none',
                                        ),
                        'login_button_styles' =>
                                        array (
                                            'width' => '200',
                                            'height' => '38',
                                            'font_size' => '14',
                                            'bg_color' => '#643e46',
                                            'color' => '#ffffff',
                                            'font_weight' => 'normal',
                                            'margin' => '15px auto',
                                            'padding' => '1px',
                                            'border_width' => '1',
                                            'border_style' => 'solid',
                                            'border_color' => '#593740',
                                            'border_radius' => '2',
                                            'box_shadow' => 'none',
                                            'text_align' => 'center',
                                            'hover_font_weight' => 'normal',
                                            'hover_bg_color' => '#593740',
                                            'hover_color' => '#ffffff',
                                        ),
                        'next_prev_button_styles' =>
                                        array (
                                            'width' => '150',
                                            'height' => '43',
                                            'font_size' => '16',
                                            'bg_color' => '#303030',
                                            'color' => '#ffffff',
                                            'font_weight' => 'normal',
                                            'margin' => '12px 2px',
                                            'padding' => '0',
                                            'border_width' => '1',
                                            'border_style' => 'solid',
                                            'border_color' => '#000000',
                                            'border_radius' => '4',
                                            'box_shadow' => 'none',
                                            'text_align' => 'center',
                                            'hover_font_weight' => 'normal',
                                            'hover_bg_color' => '#000000',
                                            'hover_color' => '#ffffff',
                                        ),
                        'page_title_style' =>
                                        array (
                                            'font_size' => '16',
                                            'font_weight' => 'bold',
                                            'color' => '#000000',
                                            'margin' => '0 0 10px 0',
                                            'padding' => '0',
                                            'border_width' => '0',
                                            'border_style' => 'solid',
                                            'border_color' => '#c1c1c1',
                                            'border_radius' => '0',
                                            'box_shadow' => 'none',
                                            'text_align' => 'center',
                                        ),
                        'custom_css' =>
                                        array (
                                            'custom_css' => '',
                                        ),
                    );

    public function __construct()
    {
        $task = isset($_POST['task']) ? sanitize_text_field($_POST['task']) : '';
        $nonce = isset($_POST['wbls_theme_nonce']) ? sanitize_text_field($_POST['wbls_theme_nonce']) : '';
        if( $task != '') {
            if (!wp_verify_nonce($nonce, 'wbls_theme')) {
                die(esc_html__('Security check', 'whistleblowing-system'));
            }
        } else {
            return;
        }

        if (method_exists($this, $task)) {
            $this->$task();
        }
    }

    public function save_theme() {
        $data = array();
        foreach ( $this->defaults as $key => $vals ) {
            foreach ( $vals as $k => $val ) {
               $data[$key][$k] = $this->defaults[$key][$k];
            }
        }
        $wbls_theme_title = esc_html__('Untitled Theme', 'whistleblowing-system');

        $my_post = array(
            'post_title'    => $wbls_theme_title,
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_category' => array( 8,39 ),
            'post_type' => 'wbls_theme'
        );

        $insert = wp_insert_post( $my_post );
        if( $insert ) {
            add_post_meta( $insert, 'wbls_theme', $data, true );
            $count_posts = wp_count_posts( 'wbls_theme' )->publish;
            if( $count_posts == 1 ) {
                update_option( 'wbls_theme_default', $insert );
            }
            $reload_url = add_query_arg(array(
                'page' => 'whistleblower_theme_edit',
                'id' => intval($insert),
            ), admin_url('admin.php'));
            $this->wbls_create_css( $data, $insert );
            wp_safe_redirect($reload_url);
        }
    }

    public function wbls_create_css( $data, $id ) {
        $wbls_theme = $data['custom_css']['custom_css'];
        $wbls_theme .= ".wbls-front-content { 
          width: ".$data['general']['container_width']."%;
          height: ".$data['general']['container_height']."%;
          box-sizing: border-box;
          background-color: ".$data['general']['bg_color'].";
          border-width: ".$data['general']['border_width']."px;
          border-style: ".$data['general']['border_style'].";
          border-color: ".$data['general']['border_color'].";
          border-radius: ".$data['general']['border_radius']."px;
          left: ".intval((100-$data['general']['container_width'])/2)."%;
          top: ".intval((100-$data['general']['container_width'])/2)."%;
        }\n";

        $wbls_theme .= ".wbls-form-container .wbls-form { 
          width: ".$data['general_form']['container_width']."px;
          box-sizing: border-box;
          background-color: ".$data['general_form']['bg_color'].";
          margin: ".$data['general_form']['margin'].";
          padding: ".$data['general_form']['padding'].";
          border-width: ".$data['general_form']['border_width']."px;
          border-style: ".$data['general_form']['border_style'].";
          border-color: ".$data['general_form']['border_color'].";
          border-radius: ".$data['general_form']['border_radius']."px;
        }\n";

        $wbls_theme .= ".wbls-front-layout { 
          background-color: ".$data['general']['layout_bg_color'].";
          opacity: ".$data['general']['layout_bg_opacity'].";
        }\n";

        $wbls_theme .= ".wbls-form-container .wbls-form label { 
          font-size: ".$data['labels']['font_size']."px;
          font-weight: ".$data['labels']['font_weight'].";
          color: ".$data['labels']['color'].";
          margin: ".$data['labels']['margin'].";
          padding: ".$data['labels']['padding'].";
          border-width: ".$data['labels']['border_width']."px;
          border-style: ".$data['labels']['border_style'].";
          border-color: ".$data['labels']['border_color'].";
          border-radius: ".$data['labels']['border_radius']."px;
          box-shadow: ".$data['labels']['box_shadow'].";
        }\n";

        $wbls_theme .= ".wbls-form-container .wbls-form input[type=text], 
         .wbls-form-container .wbls-form input[type=number],.wbls-form-container .wbls-form input[type=email], 
         .wbls-form-container .wbls-form input[type=password], .wbls-form-container .wbls-form input[type=search]{ 
          width: ".$data['input_fields']['width']."%;
          height: ".$data['input_fields']['height']."px;
          font-size: ".$data['input_fields']['font_size']."px;
          font-weight: ".$data['input_fields']['font_weight'].";
          background-color: ".$data['input_fields']['bg_color'].";
          color: ".$data['input_fields']['color'].";
          margin: ".$data['input_fields']['margin'].";
          padding: ".$data['input_fields']['padding'].";
          border-width: ".$data['input_fields']['border_width']."px;
          border-style: ".$data['input_fields']['border_style'].";
          border-color: ".$data['input_fields']['border_color'].";
          border-radius: ".$data['input_fields']['border_radius']."px;
          box-shadow: ".$data['input_fields']['box_shadow'].";
        }\n";

        $wbls_theme .= ".wbls-form-container .wbls-form textarea { 
          width: ".$data['textarea']['width']."%;
          height: ".$data['textarea']['height']."px;
          font-size: ".$data['textarea']['font_size']."px;
          font-weight: ".$data['textarea']['font_weight'].";
          background-color: ".$data['textarea']['bg_color'].";
          color: ".$data['textarea']['color'].";
          margin: ".$data['textarea']['margin'].";
          padding: ".$data['textarea']['padding'].";
          border-width: ".$data['textarea']['border_width']."px;
          border-style: ".$data['textarea']['border_style'].";
          border-color: ".$data['textarea']['border_color'].";
          border-radius: ".$data['textarea']['border_radius']."px;
          box-shadow: ".$data['textarea']['box_shadow'].";
        }\n";

        $wbls_theme .= ".wbls-form-container .wbls-form select { 
          width: ".$data['drodown_fields']['width']."%;
          height: ".$data['drodown_fields']['height']."px;
          font-size: ".$data['drodown_fields']['font_size']."px;
          font-weight: ".$data['drodown_fields']['font_weight'].";
          background-color: ".$data['drodown_fields']['bg_color'].";
          color: ".$data['drodown_fields']['color'].";
          margin: ".$data['drodown_fields']['margin'].";
          padding: ".$data['drodown_fields']['padding'].";
          border-width: ".$data['drodown_fields']['border_width']."px;
          border-style: ".$data['drodown_fields']['border_style'].";
          border-color: ".$data['drodown_fields']['border_color'].";
          border-radius: ".$data['drodown_fields']['border_radius']."px;
          box-shadow: ".$data['drodown_fields']['box_shadow'].";
        }\n";

        $wbls_theme .= ".wbls-form-container .wbls-form input[type=checkbox],
         .wbls-form-container .wbls-form input[type=radio] { 
          width: ".$data['checkbox_fields']['width']."px;
          height: ".$data['checkbox_fields']['height']."px;
          background-color: ".$data['checkbox_fields']['bg_color'].";
          margin: ".$data['checkbox_fields']['margin'].";
          padding: ".$data['checkbox_fields']['padding'].";
          accent-color: ".$data['checkbox_fields']['checked_bg_color'].";
        }\n";

        $wbls_theme .= ".wbls-form-container .wbls-form .wbls-field-row-radio { 
          margin-top: 10px;
        }\n";

        $wbls_theme .= ".wbls-form-container .wbls-form .wbls-field-row-checkbox label.wbls-field-miniLabel.wbls-checkbox-label,
         .wbls-form-container .wbls-form .wbls-field-row-radio label.wbls-field-miniLabel.wbls-radio-label { 
          font-size: ".$data['checkbox_fields']['label_font_size']."px;
          color: ".$data['checkbox_fields']['label_color'].";
          font-weight: ".$data['checkbox_fields']['label_font_weight'].";
          opacity: 1;
          margin: 0;
        }\n";

        $wbls_theme .= ".wbls-form-container .wbls-form .wblsform-row-pageTitle { 
          margin: ".$data['page_title_style']['margin'].";
          padding: ".$data['page_title_style']['padding'].";
          border-width: ".$data['page_title_style']['border_width']."px;
          border-style: ".$data['page_title_style']['border_style'].";
          border-color: ".$data['page_title_style']['border_color'].";
          border-radius: ".$data['page_title_style']['border_radius']."px;
          box-shadow: ".$data['page_title_style']['box_shadow'].";
          text-align: ".$data['page_title_style']['text_align'].";
          box-sizing: border-box;
        }\n";
        $wbls_theme .= ".wbls-form-container .wbls-form .wbls-form-page-title { 
          font-size: ".$data['page_title_style']['font_size']."px;
          font-weight: ".$data['page_title_style']['font_weight'].";
          color: ".$data['page_title_style']['color'].";
          text-align: ".$data['page_title_style']['text_align'].";
        }\n";

        $wbls_theme .= ".wbls-form-container .wbls-form button.wbls-next-button,
         .wbls-form-container .wbls-form button.wbls-previous-button { 
            width: ".$data['next_prev_button_styles']['width']."px;
            height: ".$data['next_prev_button_styles']['height']."px;
            font-size: ".$data['next_prev_button_styles']['font_size']."px;
            font-weight: ".$data['next_prev_button_styles']['font_weight'].";
            color: ".$data['next_prev_button_styles']['color'].";
            background-color: ".$data['next_prev_button_styles']['bg_color'].";
            margin: ".$data['next_prev_button_styles']['margin'].";
            padding: ".$data['next_prev_button_styles']['padding'].";
            border-width: ".$data['next_prev_button_styles']['border_width']."px;
            border-style: ".$data['next_prev_button_styles']['border_style'].";
            border-color: ".$data['next_prev_button_styles']['border_color'].";
            border-radius: ".$data['next_prev_button_styles']['border_radius']."px;
            box-shadow: ".$data['next_prev_button_styles']['box_shadow'].";
            text-align: ".$data['next_prev_button_styles']['text_align'].";
        }\n";
        $wbls_theme .= ".wbls-form-container .wbls-form button.wbls-next-button:hover,
         .wbls-form-container .wbls-form button.wbls-previous-button:hover {
            font-weight: ".$data['next_prev_button_styles']['hover_font_weight'].";
            color: ".$data['next_prev_button_styles']['hover_color'].";
            background-color: ".$data['next_prev_button_styles']['hover_bg_color'].";
        }\n";

        $wbls_theme .= ".wbls-form-container .wbls-form button.wbls-submit-form,
         .wbls-form-container .wbls-form button.wbls-form-submit { 
            width: ".$data['button_fields']['width']."px;
            height: ".$data['button_fields']['height']."px;
            font-size: ".$data['button_fields']['font_size']."px;
            font-weight: ".$data['button_fields']['font_weight'].";
            color: ".$data['button_fields']['color'].";
            background-color: ".$data['button_fields']['bg_color'].";
            margin: ".$data['button_fields']['margin'].";
            padding: ".$data['button_fields']['padding'].";
            border-width: ".$data['button_fields']['border_width']."px;
            border-style: ".$data['button_fields']['border_style'].";
            border-color: ".$data['button_fields']['border_color'].";
            border-radius: ".$data['button_fields']['border_radius']."px;
            box-shadow: ".$data['button_fields']['box_shadow'].";
            text-align: ".$data['button_fields']['text_align'].";
        }\n";
        $wbls_theme .= ".wbls-form-container .wbls-form button.wbls-submit-form:hover {
            font-weight: ".$data['button_fields']['hover_font_weight'].";
            color: ".$data['button_fields']['hover_color'].";
            background-color: ".$data['button_fields']['hover_bg_color'].";
        }\n";

        $wbls_theme .= ".wbls-front-buttons-container .wbls-new-case-button { 
            width: ".$data['new_case_button_fields']['width']."px;
            height: ".$data['new_case_button_fields']['height']."px;
            line-height: ".($data['new_case_button_fields']['height']-$data['new_case_button_fields']['border_width']*2)."px;
            font-size: ".$data['new_case_button_fields']['font_size']."px;
            font-weight: ".$data['new_case_button_fields']['font_weight'].";
            color: ".$data['new_case_button_fields']['color'].";
            background-color: ".$data['new_case_button_fields']['bg_color'].";
            margin: ".$data['new_case_button_fields']['margin'].";
            padding: ".$data['new_case_button_fields']['padding'].";
            border-width: ".$data['new_case_button_fields']['border_width']."px;
            border-style: ".$data['new_case_button_fields']['border_style'].";
            border-color: ".$data['new_case_button_fields']['border_color'].";
            border-radius: ".$data['new_case_button_fields']['border_radius']."px;
            box-shadow: ".$data['new_case_button_fields']['box_shadow'].";
            text-align: ".$data['new_case_button_fields']['text_align'].";
        }\n";
        $wbls_theme .= ".wbls-front-buttons-container .wbls-new-case-button:hover { 
            font-weight: ".$data['new_case_button_fields']['hover_font_weight'].";
            color: ".$data['new_case_button_fields']['hover_color'].";
            background-color: ".$data['new_case_button_fields']['hover_bg_color'].";
        }\n";

        $wbls_theme .= ".wbls-front-buttons-container .wbls-followup-button { 
            width: ".$data['follow_case_button_fields']['width']."px;
            height: ".$data['follow_case_button_fields']['height']."px;
            line-height: ".($data['follow_case_button_fields']['height']-$data['follow_case_button_fields']['border_width']*2)."px;
            font-size: ".$data['follow_case_button_fields']['font_size']."px;
            font-weight: ".$data['follow_case_button_fields']['font_weight'].";
            color: ".$data['follow_case_button_fields']['color'].";
            background-color: ".$data['follow_case_button_fields']['bg_color'].";
            margin: ".$data['follow_case_button_fields']['margin'].";
            padding: ".$data['follow_case_button_fields']['padding'].";
            border-width: ".$data['follow_case_button_fields']['border_width']."px;
            border-style: ".$data['follow_case_button_fields']['border_style'].";
            border-color: ".$data['follow_case_button_fields']['border_color'].";
            border-radius: ".$data['follow_case_button_fields']['border_radius']."px;
            box-shadow: ".$data['follow_case_button_fields']['box_shadow'].";
            text-align: ".$data['follow_case_button_fields']['text_align'].";
        }\n";
        $wbls_theme .= ".wbls-front-buttons-container .wbls-followup-button:hover { 
            font-weight: ".$data['follow_case_button_fields']['hover_font_weight'].";
            color: ".$data['follow_case_button_fields']['hover_color'].";
            background-color: ".$data['follow_case_button_fields']['hover_bg_color'].";
        }\n";

        $wbls_theme .= ".wbls-chat-container .wbls_user_row .wbls_message { 
          font-size: ".$data['client_message_styles']['font_size']."px;
          font-weight: ".$data['client_message_styles']['font_weight'].";
          background-color: ".$data['client_message_styles']['bg_color'].";
          color: ".$data['client_message_styles']['color'].";
          margin: ".$data['client_message_styles']['margin'].";
          padding: ".$data['client_message_styles']['padding'].";
          border-width: ".$data['client_message_styles']['border_width']."px;
          border-style: ".$data['client_message_styles']['border_style'].";
          border-color: ".$data['client_message_styles']['border_color'].";
          border-radius: ".$data['client_message_styles']['border_radius']."px;
          box-shadow: ".$data['client_message_styles']['box_shadow'].";
        }\n";

        $wbls_theme .= ".wbls-chat-container .wbls_admin_row .wbls_message { 
          font-size: ".$data['admin_message_styles']['font_size']."px;
          font-weight: ".$data['admin_message_styles']['font_weight'].";
          background-color: ".$data['admin_message_styles']['bg_color'].";
          color: ".$data['admin_message_styles']['color'].";
          margin: ".$data['admin_message_styles']['margin'].";
          padding: ".$data['admin_message_styles']['padding'].";
          border-width: ".$data['admin_message_styles']['border_width']."px;
          border-style: ".$data['admin_message_styles']['border_style'].";
          border-color: ".$data['admin_message_styles']['border_color'].";
          border-radius: ".$data['admin_message_styles']['border_radius']."px;
          box-shadow: ".$data['admin_message_styles']['box_shadow'].";
        }\n";

        $wbls_theme .= ".wbls-chat-container #wbls-new-reply { 
          width: ".$data['message_textarea']['width']."%;
          height: ".$data['message_textarea']['height']."px;
          font-size: ".$data['message_textarea']['font_size']."px;
          font-weight: ".$data['message_textarea']['font_weight'].";
          background-color: ".$data['message_textarea']['bg_color'].";
          color: ".$data['message_textarea']['color'].";
          margin: ".$data['message_textarea']['margin'].";
          padding: ".$data['message_textarea']['padding'].";
          border-width: ".$data['message_textarea']['border_width']."px;
          border-style: ".$data['message_textarea']['border_style'].";
          border-color: ".$data['message_textarea']['border_color'].";
          border-radius: ".$data['message_textarea']['border_radius']."px;
          box-shadow: ".$data['message_textarea']['box_shadow'].";
        }\n";

        $wbls_theme .= ".wbls-new-chat-section #wbls-reply-button { 
            width: ".$data['message_send_button']['width']."px;
            height: ".$data['message_send_button']['height']."px;
            line-height: ".($data['message_send_button']['height']-$data['follow_case_button_fields']['border_width']*2)."px;
            font-size: ".$data['message_send_button']['font_size']."px;
            font-weight: ".$data['message_send_button']['font_weight'].";
            color: ".$data['message_send_button']['color'].";
            background-color: ".$data['message_send_button']['bg_color'].";
            margin: ".$data['message_send_button']['margin'].";
            padding: ".$data['message_send_button']['padding'].";
            border-width: ".$data['message_send_button']['border_width']."px;
            border-style: ".$data['message_send_button']['border_style'].";
            border-color: ".$data['message_send_button']['border_color'].";
            border-radius: ".$data['message_send_button']['border_radius']."px;
            box-shadow: ".$data['message_send_button']['box_shadow'].";
            text-align: ".$data['message_send_button']['text_align'].";
        }\n";
        $wbls_theme .= ".wbls-front-buttons-container #wbls-reply-button:hover { 
            font-weight: ".$data['message_send_button']['hover_font_weight'].";
            color: ".$data['message_send_button']['hover_color'].";
            background-color: ".$data['follow_case_button_fields']['hover_bg_color'].";
        }\n";

        $wbls_theme .= ".wbls-login-container .wbls-token-input, .wbls-token-container span.wbls-token-value { 
          width: ".$data['login_input_styles']['width']."%;
          height: ".$data['login_input_styles']['height']."px;
          font-size: ".$data['login_input_styles']['font_size']."px;
          font-weight: ".$data['login_input_styles']['font_weight'].";
          background-color: ".$data['login_input_styles']['bg_color'].";
          color: ".$data['login_input_styles']['color'].";
          margin: ".$data['login_input_styles']['margin'].";
          padding: ".$data['login_input_styles']['padding'].";
          border-width: ".$data['login_input_styles']['border_width']."px;
          border-style: ".$data['login_input_styles']['border_style'].";
          border-color: ".$data['login_input_styles']['border_color'].";
          border-radius: ".$data['login_input_styles']['border_radius']."px;
          box-shadow: ".$data['login_input_styles']['box_shadow'].";
        }\n";

        $wbls_theme .= ".wbls-login-container .wbls-login-button, .wbls-token-container .wbls-copy-button { 
            width: ".$data['login_button_styles']['width']."px;
            height: ".$data['login_button_styles']['height']."px;
            line-height: ".($data['login_button_styles']['height']-$data['login_button_styles']['border_width']*2)."px;
            font-size: ".$data['login_button_styles']['font_size']."px;
            font-weight: ".$data['login_button_styles']['font_weight'].";
            color: ".$data['login_button_styles']['color'].";
            background-color: ".$data['login_button_styles']['bg_color'].";
            margin: ".$data['login_button_styles']['margin'].";
            padding: ".$data['login_button_styles']['padding'].";
            border-width: ".$data['login_button_styles']['border_width']."px;
            border-style: ".$data['login_button_styles']['border_style'].";
            border-color: ".$data['login_button_styles']['border_color'].";
            border-radius: ".$data['login_button_styles']['border_radius']."px;
            box-shadow: ".$data['login_button_styles']['box_shadow'].";
            text-align: ".$data['login_button_styles']['text_align'].";
        }\n";
        $wbls_theme .= ".wbls-login-container .wbls-login-button:hover, .wbls-token-container .wbls-copy-button:hover { 
            font-weight: ".$data['login_button_styles']['hover_font_weight'].";
            color: ".$data['login_button_styles']['hover_color'].";
            background-color: ".$data['login_button_styles']['hover_bg_color'].";
        }\n";

        $wp_upload_dir = wp_upload_dir();
        $form_dir = '/wbls-system/';
        if ( !is_dir( $wp_upload_dir[ 'basedir' ] . $form_dir ) ) {
            mkdir( $wp_upload_dir[ 'basedir' ] . $form_dir );
            file_put_contents( $wp_upload_dir[ 'basedir' ] . $form_dir . 'index.html', WBLSLibrary::forbidden_template() );
        }

        $wbls_style_dir = $wp_upload_dir[ 'basedir' ] . $form_dir . 'wbls-theme-style_'.$id.'.css';
        clearstatcache();
        file_put_contents( $wbls_style_dir, $wbls_theme );
    }


}
