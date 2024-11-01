<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// TODO should be work for front

class WBLSLibrary
{
    public static $wp_kses_default = array(
        'h1' => array(
            'class' => array(),
            'id' => array(),
            'alt' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'h2' => array(
            'class' => array(),
            'id' => array(),
            'alt' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'h3' => array(
            'class' => array(),
            'id' => array(),
            'alt' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'h4' => array(
            'class' => array(),
            'id' => array(),
            'alt' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'h5' => array(
            'class' => array(),
            'id' => array(),
            'alt' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'span' => array(
            'class' => array(),
            'id' => array(),
            'alt' => array(),
            'title' => array(),
            'style' => array(),
            'data-placeholder' => array(),
        ),
        'p' => array(
            'class' => array(),
            'id' => array(),
            'alt' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'div' => array(
            'class' => array(),
            'id' => array(),
            'alt' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'img' => array(
            'src' => array(),
            'class' => array(),
            'alt' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'a' => array(
            'href' => array(),
            'class' => array(),
            'id' => array(),
            'alt' => array(),
            'title' => array(),
            'target' => array(),
            'style' => array(),
        ),
        'ul' => array(
            'class' => array(),
            'id' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'li' => array(
            'class' => array(),
            'id' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'ol' => array(
            'class' => array(),
            'id' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'em' => array(
            'class' => array(),
            'id' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'strong' => array(
            'class' => array(),
            'id' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'b' => array(
            'class' => array(),
            'id' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'i' => array(
            'class' => array(),
            'id' => array(),
            'title' => array(),
            'style' => array(),
        ),

    );

    public static $wp_kses_form = array(
        'div' => array(
            'class' => array(),
            'id' => array(),
            'data-field-id' => array(),
        ),
        'span' => array(
            'class' => array(),
            'id' => array(),
            'title' => array(),
            'data-placeholder' => array(),
        ),
        'p' => array(
            'class' => array(),
            'id' => array(),
            'title' => array(),
        ),
        'label' => array(
            'class' => array(),
            'id' => array(),
        ),
        'input' => array(
            'type' => array(),
            'name' => array(),
            'value' => array(),
            'placeholder' => array(),
            'class' => array(),
            'id' => array(),
            'required' => array(),
            'accept' => array(),
            'checked' => array(),
            'multiple' => array(),
        ),
        'textarea' => array(
            'type' => array(),
            'name' => array(),
            'value' => array(),
            'placeholder' => array(),
            'class' => array(),
            'id' => array(),
            'required' => array(),
        ),
        'select' => array(
            'name' => array(),
            'class' => array(),
            'id' => array(),
            'required' => array(),
        ),
        'option' => array(
            'value' => array(),
            'class' => array(),
            'id' => array(),
        ),
        'button' => array(
            'type' => array(),
            'name' => array(),
            'value' => array(),
            'placeholder' => array(),
            'class' => array(),
            'id' => array(),
        ),
        'a' => array(
            'href' => array(),
            'class' => array(),
            'id' => array(),
            'alt' => array(),
            'title' => array(),
            'target' => array(),
        ),
    );

    public static $country_list = array(
                                    "Afghanistan",
                                    "Albania",
                                    "Algeria",
                                    "Andorra",
                                    "Angola",
                                    "Antigua and Barbuda",
                                    "Argentina",
                                    "Armenia",
                                    "Australia",
                                    "Austria",
                                    "Azerbaijan",
                                    "Bahamas",
                                    "Bahrain",
                                    "Bangladesh",
                                    "Barbados",
                                    "Belarus",
                                    "Belgium",
                                    "Belize",
                                    "Benin",
                                    "Bhutan",
                                    "Bolivia",
                                    "Bosnia and Herzegovina",
                                    "Botswana",
                                    "Brazil",
                                    "Brunei",
                                    "Bulgaria",
                                    "Burkina Faso",
                                    "Burundi",
                                    "Cambodia",
                                    "Cameroon",
                                    "Canada",
                                    "Cape Verde",
                                    "Central African Republic",
                                    "Chad",
                                    "Chile",
                                    "China",
                                    "Colombi",
                                    "Comoros",
                                    "Congo (Brazzaville)",
                                    "Congo",
                                    "Costa Rica",
                                    "Cote d'Ivoire",
                                    "Croatia",
                                    "Cuba",
                                    "Cyprus",
                                    "Czech Republic",
                                    "Denmark",
                                    "Djibouti",
                                    "Dominica",
                                    "Dominican Republic",
                                    "East Timor (Timor Timur)",
                                    "Ecuador",
                                    "Egypt",
                                    "El Salvador",
                                    "Equatorial Guinea",
                                    "Eritrea",
                                    "Estonia",
                                    "Ethiopia",
                                    "Fiji",
                                    "Finland",
                                    "France",
                                    "Gabon",
                                    "Gambia, The",
                                    "Georgia",
                                    "Germany",
                                    "Ghana",
                                    "Greece",
                                    "Grenada",
                                    "Guatemala",
                                    "Guinea",
                                    "Guinea-Bissau",
                                    "Guyana",
                                    "Haiti",
                                    "Honduras",
                                    "Hungary",
                                    "Iceland",
                                    "India",
                                    "Indonesia",
                                    "Iran",
                                    "Iraq",
                                    "Ireland",
                                    "Israel",
                                    "Italy",
                                    "Jamaica",
                                    "Japan",
                                    "Jordan",
                                    "Kazakhstan",
                                    "Kenya",
                                    "Kiribati",
                                    "Korea, North",
                                    "Korea, South",
                                    "Kuwait",
                                    "Kyrgyzstan",
                                    "Laos",
                                    "Latvia",
                                    "Lebanon",
                                    "Lesotho",
                                    "Liberia",
                                    "Libya",
                                    "Liechtenstein",
                                    "Lithuania",
                                    "Luxembourg",
                                    "Macedonia",
                                    "Madagascar",
                                    "Malawi",
                                    "Malaysia",
                                    "Maldives",
                                    "Mali",
                                    "Malta",
                                    "Marshall Islands",
                                    "Mauritania",
                                    "Mauritius",
                                    "Mexico",
                                    "Micronesia",
                                    "Moldova",
                                    "Monaco",
                                    "Mongolia",
                                    "Morocco",
                                    "Mozambique",
                                    "Myanmar",
                                    "Namibia",
                                    "Nauru",
                                    "Nepal",
                                    "Netherlands",
                                    "New Zealand",
                                    "Nicaragua",
                                    "Niger",
                                    "Nigeria",
                                    "Norway",
                                    "Oman",
                                    "Pakistan",
                                    "Palau",
                                    "Panama",
                                    "Papua New Guinea",
                                    "Paraguay",
                                    "Peru",
                                    "Philippines",
                                    "Poland",
                                    "Portugal",
                                    "Qatar",
                                    "Romania",
                                    "Russia",
                                    "Rwanda",
                                    "Saint Kitts and Nevis",
                                    "Saint Lucia",
                                    "Saint Vincent",
                                    "Samoa",
                                    "San Marino",
                                    "Sao Tome and Principe",
                                    "Saudi Arabia",
                                    "Senegal",
                                    "Serbia and Montenegro",
                                    "Seychelles",
                                    "Sierra Leone",
                                    "Singapore",
                                    "Slovakia",
                                    "Slovenia",
                                    "Solomon Islands",
                                    "Somalia",
                                    "South Africa",
                                    "Spain",
                                    "Sri Lanka",
                                    "Sudan",
                                    "Suriname",
                                    "Swaziland",
                                    "Sweden",
                                    "Switzerland",
                                    "Syria",
                                    "Taiwan",
                                    "Tajikistan",
                                    "Tanzania",
                                    "Thailand",
                                    "Togo",
                                    "Tonga",
                                    "Trinidad and Tobago",
                                    "Tunisia",
                                    "Turkey",
                                    "Turkmenistan",
                                    "Tuvalu",
                                    "Uganda",
                                    "Ukraine",
                                    "United Arab Emirates",
                                    "United Kingdom",
                                    "United States",
                                    "Uruguay",
                                    "Uzbekistan",
                                    "Vanuatu",
                                    "Vatican City",
                                    "Venezuela",
                                    "Vietnam",
                                    "Yemen",
                                    "Zambia",
                                    "Zimbabwe"
    );

    /**
     * Forbidden template.
     *
     * @return string
     */
    public static function forbidden_template() {
        return '<!DOCTYPE html>
				<html>
				<head>
					<title>403 Forbidden</title>
				</head>
				<body>
					<p>Directory access is forbidden.</p>
				</body>
				</html>';
    }

    /* Check if form whistleblower setting active */
    public static function is_whistleblower_active( $form_id ) {
        $settings = get_post_meta($form_id, 'wbls_form_settings', 1);
        if (isset($settings['whistleblower_active']) && $settings['whistleblower_active']) {
            return TRUE;
        }
        return FALSE;
    }

    public static function wbls_set_upload_file($params = []) {
                return '';
    }

    public static function wbls_convert_old_form() {
        $form = get_option('wbls_form');
        if( !$form ) return;
        $form = json_decode($form,1);
        $form_html = '<div class="wblsform-page-and-images wbls-form-builder">';
        $form_html .= '<div class="wblsform_section"><div class="wblsform_column wbls-hidden"></div>';
        $form_html .= '<div class="wblsform_column wblsform_column-active">';
        $i = 0;
        $form_fields = [];
        $placeholder = [];
        foreach( $form as $field ) {
            if( !$field['status'] ) continue;
            $required = '';
            $required_attr = '';
            if( $field['required'] ) {
                $required = "*";
                $required_attr = " required";
            }
            $nameKey = $i;
            $form_fields[$i] = $field;
            $form_html .= '<div class="wblsform-row wbls-label-top" data-field-id="'.$i.'">';
            switch ($field['type']) {
                case "text":
                    $form_html .= '<label class="wbls-field-label">'.$field['label'].$required.'</label>';
                    $form_html .= '<input class="wbls-field" type="text" name="wbls_field_'.$nameKey.'" value="" placeholder="'.$field['placeholder'].'"' . $required_attr . '>';
                    $form_html .= '<p class="wbls-field-description"></p>';
                    $form_fields[$i]['title'] = 'Single Line Text';
                    $placeholder['subject'] = $field['label'];
                    break;
                case "textarea":
                    $form_html .= '<label class="wbls-field-label">'.$field['label'].$required.'</label>';
                    $form_html .= '<textarea class="wbls-field" name="wbls_field_'.$nameKey.'" placeholder="'.$field['placeholder'].'"' . $required_attr . '></textarea>';
                    $form_html .= '<p class="wbls-field-description"></p>';
                    $form_fields[$i]['title'] = 'Paragraph Text';
                    $placeholder['message'] = $field['label'];
                    break;
                case "email":
                    $form_html .= '<label class="wbls-field-label">'.$field['label'].$required.'</label>';
                    $form_html .= '<input class="wbls-field" type="email" name="wbls_field_'.$nameKey.'" value="" placeholder="'.$field['placeholder'].'"' . $required_attr . '>';
                    $form_html .= '<p class="wbls-field-description"></p>';
                    $form_fields[$i]['title'] = 'Email';
                    $placeholder['email'] = $field['label'];
                    break;
                case "file":
                    $form_html .= '<label class="wbls-field-label">'.$field['label'].$required.'</label>';
                    $form_html .= '<input class="wbls-field" type="file" name="wbls_field_'.$nameKey.'" value="" accept="image/*,.pdf,audio/*,video/*"' . $required_attr . '>';
                    $form_html .= '<p class="wbls-field-description"></p>';
                    $form_fields[$i]['title'] = 'Upload';
                    $form_fields[$i]['pro'] = true;
                    break;
                case "checkbox":
                    $miniLabel = ($field['label'] != '') ? $field['label'] : __('New choice', 'whistleblowing-system');
                    $form_html .= '<div class="wbls-field-row-checkbox"><input class="wbls-field" type="checkbox" name="wbls_field_'.$nameKey.'" value="0"' . $required_attr . '>';
                    $form_html .= '<label class="wbls-field-miniLabel wbls-checkbox-label">'.$field['label'].$required.'</label></div>';
                    $form_html .= '<p class="wbls-field-description"></p>';
                    $form_fields[$i]['title'] = 'Checkbox';
                    $form_fields[$i]['label'] = '';
                    $form_fields[$i]['options'][0]['miniLabel'] = $miniLabel;
                    $form_fields[$i]['options'][0]['name'] = "wbls_field_".$nameKey;
                    $placeholder['agree_terms'] = $field['label'];
                    break;
                case "button":
                    $label = ($field['label'] != '') ? $field['label'] : __('Send', 'whistleblowing-system');
                    $form_html .= '<button class="wbls-submit-form">'.$label.'</button>';
                    $form_fields[$i]['title'] = 'Submit Button';
                    $form_fields[$i]['type'] = 'submit';
                    $form_fields[$i]['label'] = $label;
                    break;
            }
            $form_html .= '</div>';

            $form_fields[$i]['description'] = '';
            $form_fields[$i]['icon'] = '';
            $form_fields[$i]['pro'] = false;
            $form_fields[$i]['name'] = "wbls_field_".$nameKey;
            $i++;
        }
        $form_html .= '</div><div class="wdform_column wbls-hidden"></div></div></div>';
        $my_post = array(
            'post_title'    => "Whistleblowing Form",
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_category' => array( 8,39 ),
            'post_type' => 'wbls_form'
        );
        $insert = wp_insert_post( $my_post );
        if( $insert ) {
            add_post_meta($insert, 'wbls_fieldNameLastId', intval($i), true);
            add_post_meta($insert, 'wbls_field_options', $form_fields, true);
            add_post_meta( $insert, 'wbls_form_content', wp_kses($form_html, self::$wp_kses_form), true);
            wp_update_post( array('ID' => $insert, 'post_content' => '[wblsform id="' . intval($insert) . '"]') );

            $email_options = get_option('wbls_settings');
            if ( $email_options ) {
                foreach ( $placeholder as $key => $value ) {
                    $email_options = str_replace("{".$key."}", "{".strip_tags($value)."}", $email_options);
                }
                add_post_meta($insert, 'wbls_email_options', $email_options, true);
            }

            /* Submissions */
            global $wpdb;
            $query = "SELECT * FROM " . $wpdb->prefix . "wbls_tickets ORDER BY modified_date DESC";
            $results = $wpdb->get_results($query, ARRAY_A);
            if( $results ) {
                $my_post = array(
                    'post_status'   => 'closed',
                    'post_author'   => 1,
                    'post_type' => 'wbls_form_subm'
                );

                foreach ( $results as $result ) {
                    $submission_id = wp_insert_post($my_post);
                    if( $submission_id ) {
                        add_post_meta( $submission_id, 'wbls_admin_token', $result['admin_token'], true );
                        add_post_meta( $submission_id, 'wbls_user_token', $result['user_token'], true );


                        $query = "SELECT * FROM " . $wpdb->prefix . "wbls_chats WHERE ticket_id=%d ORDER BY id ASC";
                        $submits = $wpdb->get_results($wpdb->prepare($query, intval($result['id'])), ARRAY_A);
                        $first_submit = isset($submits[0]) ? $submits[0] : '';
                        $info = json_decode($first_submit['message'], 1);
                        foreach ( $form_fields as $field ) {
                            switch ($field['type']) {
                                case "text":
                                    $val = isset($info['subject']) ? sanitize_text_field($info['subject']) : '';
                                    add_post_meta( $submission_id, $field['name'], $val, true );
                                    break;
                                case "textarea":
                                    $val = isset($info['message']) ? sanitize_text_field($info['message']) : '';
                                    add_post_meta( $submission_id, $field['name'], $val, true );
                                    break;
                                case "email":
                                    $val = isset($info['email']) ? sanitize_text_field($info['email']) : '';
                                    add_post_meta( $submission_id, $field['name'], $val, true );
                                    break;
                                case "file":
                                    $val = isset($info['file']) ? sanitize_text_field($info['file']) : '';
                                    add_post_meta( $submission_id, $field['name'], $val, true );
                                    break;
                                case "checkbox":
                                    $val = isset($info['agree_terms']) ? sanitize_text_field($info['agree_terms']) : '';
                                    add_post_meta( $submission_id, $field['name'], $val, true );
                                    break;
                            }
                        }
                        add_post_meta( $submission_id, 'wbls_created_at', $first_submit['modified_date'], true );
                        add_post_meta( $submission_id, 'wbls_form_id', intval($insert), true );
                        $chat = array();
                        foreach ( $submits as $submit ) {
                            $chatMessage = json_decode($submit['message'],1);
                            $chat[] = array(
                                'message' => sanitize_text_field($chatMessage['message']),
                                'file' => isset($chatMessage['file']) ? sanitize_text_field($chatMessage['file']) : '',
                                'published' => 1,
                                'role' => $submit['role'],
                                'modified_date' => $submit['modified_date'],
                            );

                        }
                        if( !empty($chat) ) {
                            add_post_meta( $submission_id, 'wbls_chat', $chat, true );
                        }
                    }

                }

            }
            update_option('wbls-plugin-version', WBLS_VERSION);
            update_option('wbls-oldForm_id', $insert);

            $current_theme = get_option('wbls_theme');
            if( $current_theme ) {
                $insert_theme = wp_insert_post( array(
                    'post_title'    => 'Theme 1',
                    'post_content'  => '',
                    'post_status'   => 'publish',
                    'post_author'   => 1,
                    'post_category' => array( 8,39 ),
                    'post_type' => 'wbls_theme'
                ) );

                if( $insert_theme ) {
                    add_post_meta( $insert_theme, 'wbls_theme', $current_theme, true );
                    update_option('wbls_theme_default', $insert_theme);
                }
            } else {
                require_once WBLS_DIR."/admin/ControllerThemes.php";
                $ob = new WBLS_ControllerThemes();
                $ob->save_theme();
            }

            $wbls_form_settings = get_option('wbls_button_texts');
            
            $wbls_form_settings['active_theme'] = $insert_theme;
            
            if( $wbls_form_settings ) {
                $wbls_form_settings['whistleblower_active'] = 1;
                add_post_meta($insert, 'wbls_form_settings', $wbls_form_settings, true);
            } else {
                add_post_meta($insert, 'wbls_form_settings', array('whistleblower_active' => 1), true);
            }
           
        }
    }

    public static function is_emailField_exists( $fields_options ) {
        $searchKey = 'type';
        $searchValue = 'email';
        if ( empty($fields_options) ) {
            return [];
        }
        $result = array_filter($fields_options, function ($subarray) use ($searchKey, $searchValue) {
            return isset($subarray[$searchKey]) && $subarray[$searchKey] === $searchValue;
        });
        if (!empty($result)) {
            return $result;
        }

        return [];
    }

    public static function is_recaptcha_active($form_id) {
        return [];
    }

    public static function sanitize_array($data, $sanitize_type) {
        // Check if the input is an array
        if (is_array($data)) {
            // Iterate through each element and sanitize recursively
            foreach ($data as $key => $value) {
                // Recursively call sanitize_array for nested arrays
                $data[$key] = self::sanitize_array($value, $sanitize_type);
            }
        } else {
            // Sanitize non-array values
            $data = $sanitize_type($data);
        }
        return $data;
    }

}