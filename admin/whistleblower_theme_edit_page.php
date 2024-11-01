<?php
if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WhistleblowerThemeEdit {

    public $default = array();
    public function __construct() {

        require_once WBLS_DIR . "/admin/ControllerThemes.php";
        $ob = new WBLS_ControllerThemes();

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if( $id ) {
            $this->default = get_post_meta($id, 'wbls_theme', true);
            if( empty($this->default) ) {
                $this->default = $ob->defaults;
            } else {
                foreach ( $ob->defaults as $key => $default ) {
                    foreach ( $default as $opt => $val ) {
                        if( !isset($this->default[$key][$opt]) ) {
                            $this->default[$key][$opt] = $val;
                        }
                    }
                }
            }
        } else {
            $this->default = $ob->defaults;
        }
        //$this->default = get_option('wbls_theme');
        $this->wbls_display();
    }
    private function wbls_display() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $theme_title = esc_html__('Untitled Form', 'whistleblowing-system');
        if( $id ) {
            $theme_title = get_the_title($id);
        }

        wp_enqueue_style(WBLS_WhistleBlower::instance()->prefix . '-themes');
        wp_enqueue_script( WBLS_WhistleBlower::instance()->prefix . '-themes');
        wp_localize_script(WBLS_WhistleBlower::instance()->prefix . '-themes', 'wbls_theme', array(
            "ajaxnonce" => wp_create_nonce('wbls_ajax_nonce'),
        ));

        wp_enqueue_style('wp-color-picker');
        ?>
        <form method="post">
            <input type="hidden" name="task" value="save_theme">
            <?php wp_nonce_field( 'wbls_theme', 'wbls_theme_nonce' ); ?>
            <div class="wbls-admin-header">
                <img class="wbls-admin-header-logo" src="<?php echo WBLS_URL; ?>/admin/assets/images/whistleblowing_logo.png">
                <div class="wbls-theme-title-row">
                    <span class="wbls-theme-title-label"><?php esc_html_e('Theme Title', 'whistleblowing-system') ?></span>
                    <input type="text" name="wbls_theme_title" id="wbls-theme-title" class="wbls-theme-title" value="<?php echo esc_html($theme_title) ?>">
                </div>

                <?php if ( !WBLS_PRO ) { ?>
                <div class="wbls-pro-banner">
                    <div class="wbls-pro-banner-content">
                        <p class="wbls-pro-tooltip-action wbls-pro-link">
                            <?php echo esc_html('This is a PRO functionality. Buy the PRO version to customize your frontend.'); ?>
                        </p>
                    </div>
                </div>
                <?php } ?>
                <input type="<?php echo WBLS_PRO ? 'submit' : 'button'; ?>" class="is-primary<?php echo !WBLS_PRO ? ' wbls-pro-tooltip-action' : ''; ?>" value="<?php esc_html_e('Save', 'whistleblowing-system') ?>">
            </div>

            <div class="wbls-theme">
                <div class="wbls-tabs-row">
                    <span class="wbls-tab-item wbls-tab-active" data-content="general"><?php esc_html_e('General', 'whistleblowing-system') ?></span>
                    <span class="wbls-tab-item" data-content="form_fields"><?php esc_html_e('Form fields', 'whistleblowing-system') ?></span>
                    <span class="wbls-tab-item" data-content="start_buttons"><?php esc_html_e('Start Buttons', 'whistleblowing-system') ?></span>
                    <span class="wbls-tab-item" data-content="chat_styles"><?php esc_html_e('Chat styles', 'whistleblowing-system') ?></span>
                    <span class="wbls-tab-item" data-content="login_styles"><?php esc_html_e('Login styles', 'whistleblowing-system') ?></span>
                    <span class="wbls-tab-item" data-content="pagination_styles"><?php esc_html_e('Pagination styles', 'whistleblowing-system') ?></span>
                </div>
                <div class="wbls-tabs-content">
                    <div class="wbls-tabs-content-general wbls-tabs-content-item">
                        <?php $this->general_content(); ?>
                    </div>
                    <div class="wbls-tabs-content-form_fields wbls-tabs-content-item" style="display:none">
                        <?php $this->form_fields_content(); ?>
                    </div>
                    <div class="wbls-tabs-content-start_buttons wbls-tabs-content-item" style="display:none">
                        <?php $this->start_buttons_content(); ?>
                    </div>
                    <div class="wbls-tabs-content-chat_styles wbls-tabs-content-item" style="display:none">
                        <?php $this->chat_content(); ?>
                    </div>
                    <div class="wbls-tabs-content-login_styles wbls-tabs-content-item" style="display:none">
                        <?php $this->login_content(); ?>
                    </div>
                    <div class="wbls-tabs-content-pagination_styles wbls-tabs-content-item" style="display:none">
                        <?php $this->pagination_content(); ?>
                    </div>
                </div>
            </div>
        </form>
        <?php
    }

    public function general_content() {
        ?>
        <div class="wbls-style-item wbls-cols-50">
            <div class="wbls-style-item-title">
                <?php esc_html_e('Popup Container Styles', 'whistleblowing-system') ?>
                <span class="dashicons dashicons-arrow-up-alt2"></span>
            </div>
            <div class="wbls-style-item-content">
                <?php $this->general_styles($this->default['general']); ?>
            </div>
        </div>
        <div class="wbls-style-item wbls-cols-50">
            <div class="wbls-style-item-title">
                <?php esc_html_e('Form Container Styles', 'whistleblowing-system') ?>
                <span class="dashicons dashicons-arrow-up-alt2"></span>
            </div>
            <div class="wbls-style-item-content">
                <?php $this->form_general_styles($this->default['general_form']); ?>
            </div>
        </div>
        <div class="wbls-style-item wbls-cols-50">
            <div class="wbls-style-item-title">
                <?php esc_html_e('Custom CSS', 'whistleblowing-system') ?>
                <span class="dashicons dashicons-arrow-up-alt2"></span>
            </div>
            <div class="wbls-style-item-content">
                <textarea name="custom_css_custom_css" class="wbls_theme_custom_css"><?php echo esc_attr($this->default['custom_css']['custom_css']); ?></textarea>
            </div>

        </div>

        <?php
    }

    public function general_styles($params) {

        ?>
        <div class="wbls-style-row">
            <label>Container Width</label>
            <input type="text" name="general_container_width" value="<?php echo esc_attr($params['container_width']); ?>">
            <span class="cf7b-um">%</span>
        </div>
        <div class="wbls-style-row">
            <label>Container Height</label>
            <input type="text" name="general_container_height" value="<?php echo esc_attr($params['container_height']); ?>">
            <span class="cf7b-um">%</span>
        </div>
        <div class="wbls-style-row">
            <label>Background Color</label>
            <input type="text" name="general_bg_color" value="<?php echo esc_attr($params['bg_color']); ?>" class="general_bg_color" />
        </div>
        <div class="wbls-style-row">
            <label>Border Width</label>
            <input type="number" name="general_border_width" min="0" value="<?php echo esc_attr($params['border_width']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Border Type</label>
            <select name="general_border_style">
                <option value="solid" <?php echo ($params['border_style'] == 'solid') ? 'selected' : '' ?>>Solid</option>
                <option value="dotted" <?php echo ($params['border_style'] == 'dotted') ? 'selected' : '' ?>>Dotted</option>
                <option value="dashed" <?php echo ($params['border_style'] == 'dashed') ? 'selected' : '' ?>>Dashed</option>
                <option value="double" <?php echo ($params['border_style'] == 'double') ? 'selected' : '' ?>>Double</option>
                <option value="groove" <?php echo ($params['border_style'] == 'groove') ? 'selected' : '' ?>>Groove</option>
                <option value="ridge" <?php echo ($params['border_style'] == 'ridge') ? 'selected' : '' ?>>Ridge</option>
                <option value="inset" <?php echo ($params['border_style'] == 'inset') ? 'selected' : '' ?>>Inset</option>
                <option value="outset" <?php echo ($params['border_style'] == 'outset') ? 'selected' : '' ?>>Outset</option>
                <option value="initial" <?php echo ($params['border_style'] == 'initial') ? 'selected' : '' ?>>Initial</option>
                <option value="inherit" <?php echo ($params['border_style'] == 'inherit') ? 'selected' : '' ?>>Inherit</option>
            </select>
        </div>
        <div class="wbls-style-row">
            <label>Border Color</label>
            <input type="text" name="general_border_color" value="<?php echo esc_attr($params['border_color']); ?>" class="general_border_color" />
        </div>
        <div class="wbls-style-row">
            <label>Border Radius</label>
            <input type="number" name="general_border_radius" value="<?php echo esc_attr($params['border_radius']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <hr>
        <div class="wbls-style-row">
            <label>Layout Background Color</label>
            <input type="text" name="general_layout_bg_color" value="<?php echo esc_attr($params['layout_bg_color']); ?>" class="general_layout_bg_color" />
        </div>
        <div class="wbls-style-row">
            <label>Layout Background Color Opacity</label>
            <input type="number" name="general_layout_bg_opacity" step="0.1" max="1" min="0" value="<?php echo esc_attr($params['layout_bg_opacity']); ?>">
        </div>
        <?php
    }

    public function form_general_styles($params) {

        ?>
        <div class="wbls-style-row">
            <label>Container Width</label>
            <input type="text" name="general_form_container_width" value="<?php echo esc_attr($params['container_width']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Background Color</label>
            <input type="text" name="general_form_bg_color" value="<?php echo esc_attr($params['bg_color']); ?>" class="general_bg_color" />
        </div>
        <div class="wbls-style-row">
            <label>Margin</label>
            <input type="text" name="general_form_margin" value="<?php echo esc_attr($params['margin']); ?>">
            <p class="cf7b-description">Use CSS type values. Ex 5px 3px</p>
        </div>
        <div class="wbls-style-row">
            <label>Padding</label>
            <input type="text" name="general_form_padding" value="<?php echo esc_attr($params['padding']); ?>">
            <p class="cf7b-description">Use CSS type values. Ex 5px 3px</p>
        </div>

        <div class="wbls-style-row">
            <label>Border Width</label>
            <input type="number" name="general_form_border_width" min="0" value="<?php echo esc_attr($params['border_width']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Border Type</label>
            <select name="general_form_border_style">
                <option value="solid" <?php echo ($params['border_style'] == 'solid') ? 'selected' : '' ?>>Solid</option>
                <option value="dotted" <?php echo ($params['border_style'] == 'dotted') ? 'selected' : '' ?>>Dotted</option>
                <option value="dashed" <?php echo ($params['border_style'] == 'dashed') ? 'selected' : '' ?>>Dashed</option>
                <option value="double" <?php echo ($params['border_style'] == 'double') ? 'selected' : '' ?>>Double</option>
                <option value="groove" <?php echo ($params['border_style'] == 'groove') ? 'selected' : '' ?>>Groove</option>
                <option value="ridge" <?php echo ($params['border_style'] == 'ridge') ? 'selected' : '' ?>>Ridge</option>
                <option value="inset" <?php echo ($params['border_style'] == 'inset') ? 'selected' : '' ?>>Inset</option>
                <option value="outset" <?php echo ($params['border_style'] == 'outset') ? 'selected' : '' ?>>Outset</option>
                <option value="initial" <?php echo ($params['border_style'] == 'initial') ? 'selected' : '' ?>>Initial</option>
                <option value="inherit" <?php echo ($params['border_style'] == 'inherit') ? 'selected' : '' ?>>Inherit</option>
            </select>
        </div>
        <div class="wbls-style-row">
            <label>Border Color</label>
            <input type="text" name="general_form_border_color" value="<?php echo esc_attr($params['border_color']); ?>" class="general_border_color" />
        </div>
        <div class="wbls-style-row">
            <label>Border Radius</label>
            <input type="number" name="general_form_border_radius" value="<?php echo esc_attr($params['border_radius']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <?php
    }

    public function login_content() {
        ?>
        <div class="wbls-style-item wbls-cols-50">
            <div class="wbls-style-item-title">
                <?php esc_html_e('Login and Copy token Input Field  Styles', 'whistleblowing-system') ?>
                <span class="dashicons dashicons-arrow-up-alt2"></span>
            </div>
            <div class="wbls-style-item-content">
                <?php $this->input_fields_styles($this->default['login_input_styles'], 'login_input_styles_'); ?>
            </div>
        </div>
        <div class="wbls-style-item wbls-cols-50">
            <div class="wbls-style-item-title">
                <?php esc_html_e('Login and Copy token Buttons Styles', 'whistleblowing-system') ?>
                <span class="dashicons dashicons-arrow-up-alt2"></span>
            </div>
            <div class="wbls-style-item-content">
                <?php $this->buttons_styles($this->default['login_button_styles'], 'login_button_styles_'); ?>
            </div>
        </div>

        <?php
    }

    public function pagination_content() {
        ?>
        <div class="wbls-style-item wbls-cols-50">
            <div class="wbls-style-item-title">
                <?php esc_html_e('Pagination Title Styles', 'whistleblowing-system') ?>
                <span class="dashicons dashicons-arrow-up-alt2"></span>
            </div>
            <div class="wbls-style-item-content">
                <?php $this->labels_styles($this->default['page_title_style'], 'page_title_style_'); ?>
            </div>
        </div>
        <div class="wbls-style-item wbls-cols-50">
            <div class="wbls-style-item-title">
                <?php esc_html_e('Next/Previous Buttons Styles', 'whistleblowing-system') ?>
                <span class="dashicons dashicons-arrow-up-alt2"></span>
            </div>
            <div class="wbls-style-item-content">
                <?php $this->buttons_styles($this->default['next_prev_button_styles'], 'next_prev_button_styles_'); ?>
            </div>
        </div>

        <?php
    }

    public function chat_content() {
        ?>
        <div class="wbls-style-item wbls-cols-50">
            <div class="wbls-style-item-title">
                <?php esc_html_e('Client Message Styles', 'whistleblowing-system') ?>
                <span class="dashicons dashicons-arrow-up-alt2"></span>
            </div>
            <div class="wbls-style-item-content">
                <?php $this->message_styles($this->default['client_message_styles'], 'client_message_styles_'); ?>
            </div>
        </div>
        <div class="wbls-style-item wbls-cols-50">
            <div class="wbls-style-item-title">
                <?php esc_html_e('Admin Message Styles', 'whistleblowing-system') ?>
                <span class="dashicons dashicons-arrow-up-alt2"></span>
            </div>
            <div class="wbls-style-item-content">
                <?php $this->message_styles($this->default['admin_message_styles'], 'admin_message_styles_'); ?>
            </div>
        </div>
        <div class="wbls-style-item wbls-cols-50">
            <div class="wbls-style-item-title">
                <?php esc_html_e('Message Textarea Styles', 'whistleblowing-system') ?>
                <span class="dashicons dashicons-arrow-up-alt2"></span>
            </div>
            <div class="wbls-style-item-content">
                <?php $this->textarea_styles($this->default['message_textarea'], 'message_textarea_'); ?>

            </div>
        </div>
        <div class="wbls-style-item wbls-cols-50">
            <div class="wbls-style-item-title">
                <?php esc_html_e('Send Button Styles', 'whistleblowing-system') ?>
                <span class="dashicons dashicons-arrow-up-alt2"></span>
            </div>
            <div class="wbls-style-item-content">
                <?php $this->buttons_styles($this->default['message_send_button'], 'message_send_button_'); ?>
            </div>
        </div>
        <?php
    }

    public function start_buttons_content() {
        ?>
        <div class="wbls-style-item wbls-cols-50">
            <div class="wbls-style-item-title">
                <?php esc_html_e('New Case Button Styles', 'whistleblowing-system') ?>
                <span class="dashicons dashicons-arrow-up-alt2"></span>
            </div>
            <div class="wbls-style-item-content">
                <?php $this->buttons_styles($this->default['new_case_button_fields'], 'new_case_button_fields_'); ?>
            </div>
        </div>
        <div class="wbls-style-item wbls-cols-50">
            <div class="wbls-style-item-title">
                <?php esc_html_e('Follow Case Button Styles', 'whistleblowing-system') ?>
                <span class="dashicons dashicons-arrow-up-alt2"></span>
            </div>
            <div class="wbls-style-item-content">
                <?php $this->buttons_styles($this->default['follow_case_button_fields'], 'follow_case_button_fields_'); ?>
            </div>
        </div>
        <?php
    }

    public function form_fields_content() {
        ?>
        <div class="wbls-style-item wbls-cols-50">
            <div class="wbls-style-item-title">
                <?php esc_html_e('Labels', 'whistleblowing-system') ?>
                <span class="dashicons dashicons-arrow-up-alt2"></span>
            </div>
            <div class="wbls-style-item-content">
            <?php $this->labels_styles($this->default['labels'], 'labels_'); ?>
            </div>
        </div>
        <div class="wbls-style-item wbls-cols-50">
            <div class="wbls-style-item-title">
                <?php esc_html_e('Input Field', 'whistleblowing-system') ?>
                <span class="dashicons dashicons-arrow-up-alt2"></span>
            </div>
            <div class="wbls-style-item-content">
            <?php $this->input_fields_styles($this->default['input_fields'], 'input_fields_'); ?>
            </div>
        </div>
        <div class="wbls-style-item wbls-cols-50">
            <div class="wbls-style-item-title">
                <?php esc_html_e('Textarea', 'whistleblowing-system') ?>
                <span class="dashicons dashicons-arrow-up-alt2"></span>
            </div>
            <div class="wbls-style-item-content">
                <?php $this->textarea_styles($this->default['textarea'], 'textarea_'); ?>
            </div>
        </div>
        <div class="wbls-style-item wbls-cols-50">
            <div class="wbls-style-item-title">
                <?php esc_html_e('Dropdown', 'whistleblowing-system') ?>
                <span class="dashicons dashicons-arrow-up-alt2"></span>
            </div>
            <div class="wbls-style-item-content">
                <?php $this->dropdown_field_styles(); ?>
            </div>
        </div>
        <div class="wbls-style-item wbls-cols-50">
            <div class="wbls-style-item-title">
                <?php esc_html_e('Checkbox/Radio Field', 'whistleblowing-system') ?>
                <span class="dashicons dashicons-arrow-up-alt2"></span>
            </div>
            <div class="wbls-style-item-content">
                <?php $this->checkbox_field_styles(); ?>
            </div>

        </div>
        <div class="wbls-style-item wbls-cols-50">
            <div class="wbls-style-item-title">
                <?php esc_html_e('Buttons', 'whistleblowing-system') ?>
                <span class="dashicons dashicons-arrow-up-alt2"></span>
            </div>
            <div class="wbls-style-item-content">
                <?php $this->buttons_styles($this->default['button_fields'], 'button_fields_'); ?>
            </div>

        </div>
        <?php
    }

    public function labels_styles($params, $name_prefix) {
        ?>
        <div class="wbls-style-row">
            <label>Font Size</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>font_size" value="<?php echo esc_attr($params['font_size']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Font Weight</label>
            <select name="<?php echo esc_html($name_prefix); ?>font_weight">
                <option value=""></option>
                <option value="normal" <?php echo ($params['font_weight'] == 'normal') ? 'selected' : '' ?>>Normal</option>
                <option value="bold" <?php echo ($params['font_weight'] == 'bold') ? 'selected' : '' ?>>Bold</option>
                <option value="bolder" <?php echo ($params['font_weight'] == 'bolder') ? 'selected' : '' ?>>Bolder</option>
                <option value="lighter" <?php echo ($params['font_weight'] == 'lighter') ? 'selected' : '' ?>>Lighter</option>
                <option value="initial" <?php echo ($params['font_weight'] == 'initial') ? 'selected' : '' ?>>Initial</option>
            </select>
        </div>
        <div class="wbls-style-row">
            <label>Color</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>color" value="<?php echo esc_attr($params['color']); ?>" class="input_color" />
        </div>
        <div class="wbls-style-row">
            <label>Margin</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>margin" value="<?php echo esc_attr($params['margin']); ?>">
            <p class="cf7b-description">Use CSS type values. Ex 5px 3px</p>
        </div>
        <div class="wbls-style-row">
            <label>Padding</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>padding" value="<?php echo esc_attr($params['padding']); ?>">
            <p class="cf7b-description">Use CSS type values. Ex 5px 3px</p>
        </div>
        <div class="wbls-style-row">
            <label>Border Width</label>
            <input type="number" name="<?php echo esc_html($name_prefix); ?>border_width" min="0" value="<?php echo esc_attr($params['border_width']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Border Type</label>
            <select name="<?php echo esc_html($name_prefix); ?>border_style">
                <option value="solid" <?php echo ($params['border_style'] == 'solid') ? 'selected' : '' ?>>Solid</option>
                <option value="dotted" <?php echo ($params['border_style'] == 'dotted') ? 'selected' : '' ?>>Dotted</option>
                <option value="dashed" <?php echo ($params['border_style'] == 'dashed') ? 'selected' : '' ?>>Dashed</option>
                <option value="double" <?php echo ($params['border_style'] == 'double') ? 'selected' : '' ?>>Double</option>
                <option value="groove" <?php echo ($params['border_style'] == 'groove') ? 'selected' : '' ?>>Groove</option>
                <option value="ridge" <?php echo ($params['border_style'] == 'ridge') ? 'selected' : '' ?>>Ridge</option>
                <option value="inset" <?php echo ($params['border_style'] == 'inset') ? 'selected' : '' ?>>Inset</option>
                <option value="outset" <?php echo ($params['border_style'] == 'outset') ? 'selected' : '' ?>>Outset</option>
                <option value="initial" <?php echo ($params['border_style'] == 'initial') ? 'selected' : '' ?>>Initial</option>
                <option value="inherit" <?php echo ($params['border_style'] == 'inherit') ? 'selected' : '' ?>>Inherit</option>
            </select>
        </div>
        <div class="wbls-style-row">
            <label>Border Color</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>border_color" value="<?php echo esc_attr($params['border_color']); ?>" class="input_border_color" />
        </div>
        <div class="wbls-style-row">
            <label>Border Radius</label>
            <input type="number" name="<?php echo esc_html($name_prefix); ?>border_radius" value="<?php echo esc_attr($params['border_radius']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Box Shadow</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>box_shadow" value="<?php echo esc_attr($params['box_shadow']); ?>" placeholder="e.g. 5px 5px 2px #888888">
        </div>
        <?php if( isset($params['text_align']) ) { ?>
        <div class="wbls-style-row">
            <label>Text align</label>
            <select name="<?php echo esc_html($name_prefix); ?>text_align">
                <option value="left" <?php echo ($params['text_align'] == 'left') ? 'selected' : '' ?>>Left</option>
                <option value="center" <?php echo ($params['text_align'] == 'center') ? 'selected' : '' ?>>Center</option>
                <option value="right" <?php echo ($params['text_align'] == 'right') ? 'selected' : '' ?>>Right</option>
            </select>
        </div>
        <?php } ?>
        <?php
    }

    public function input_fields_styles( $params, $name_prefix ) {
        ?>
        <div class="wbls-style-row">
            <label>Width</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>width" value="<?php echo esc_attr($params['width']); ?>">
            <span class="cf7b-um">%</span>
        </div>
        <div class="wbls-style-row">
            <label>Height</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>height" value="<?php echo esc_attr($params['height']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Font Size</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>font_size" value="<?php echo esc_attr($params['font_size']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Font Weight</label>
            <select name="<?php echo esc_html($name_prefix); ?>font_weight">
                <option value=""></option>
                <option value="normal" <?php echo ($params['font_weight'] == 'normal') ? 'selected' : '' ?>>Normal</option>
                <option value="bold" <?php echo ($params['font_weight'] == 'bold') ? 'selected' : '' ?>>Bold</option>
                <option value="bolder" <?php echo ($params['font_weight'] == 'bolder') ? 'selected' : '' ?>>Bolder</option>
                <option value="lighter" <?php echo ($params['font_weight'] == 'lighter') ? 'selected' : '' ?>>Lighter</option>
                <option value="initial" <?php echo ($params['font_weight'] == 'initial') ? 'selected' : '' ?>>Initial</option>
            </select>
        </div>
        <div class="wbls-style-row">
            <label>Background Color</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>bg_color" value="<?php echo esc_attr($params['bg_color']); ?>" class="input_bg_color" />
        </div>
        <div class="wbls-style-row">
            <label>Color</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>color" value="<?php echo esc_attr($params['color']); ?>" class="input_color" />
        </div>
        <div class="wbls-style-row">
            <label>Margin</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>margin" value="<?php echo esc_attr($params['margin']); ?>">
            <p class="cf7b-description">Use CSS type values. Ex 5px 3px</p>
        </div>
        <div class="wbls-style-row">
            <label>Padding</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>padding" value="<?php echo esc_attr($params['padding']); ?>">
            <p class="cf7b-description">Use CSS type values. Ex 5px 3px</p>
        </div>
        <div class="wbls-style-row">
            <label>Border Width</label>
            <input type="number" name="<?php echo esc_html($name_prefix); ?>border_width" min="0" value="<?php echo esc_attr($params['border_width']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Border Type</label>
            <select name="<?php echo esc_html($name_prefix); ?>border_style">
                <option value="solid" <?php echo ($params['border_style'] == 'solid') ? 'selected' : '' ?>>Solid</option>
                <option value="dotted" <?php echo ($params['border_style'] == 'dotted') ? 'selected' : '' ?>>Dotted</option>
                <option value="dashed" <?php echo ($params['border_style'] == 'dashed') ? 'selected' : '' ?>>Dashed</option>
                <option value="double" <?php echo ($params['border_style'] == 'double') ? 'selected' : '' ?>>Double</option>
                <option value="groove" <?php echo ($params['border_style'] == 'groove') ? 'selected' : '' ?>>Groove</option>
                <option value="ridge" <?php echo ($params['border_style'] == 'ridge') ? 'selected' : '' ?>>Ridge</option>
                <option value="inset" <?php echo ($params['border_style'] == 'inset') ? 'selected' : '' ?>>Inset</option>
                <option value="outset" <?php echo ($params['border_style'] == 'outset') ? 'selected' : '' ?>>Outset</option>
                <option value="initial" <?php echo ($params['border_style'] == 'initial') ? 'selected' : '' ?>>Initial</option>
                <option value="inherit" <?php echo ($params['border_style'] == 'inherit') ? 'selected' : '' ?>>Inherit</option>
            </select>
        </div>
        <div class="wbls-style-row">
            <label>Border Color</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>border_color" value="<?php echo esc_attr($params['border_color']); ?>" class="input_border_color" />
        </div>
        <div class="wbls-style-row">
            <label>Border Radius</label>
            <input type="number" name="<?php echo esc_html($name_prefix); ?>border_radius" value="<?php echo esc_attr($params['border_radius']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Box Shadow</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>box_shadow" value="<?php echo esc_attr($params['box_shadow']); ?>" placeholder="e.g. 5px 5px 2px #888888">
        </div>
        <?php
    }

    public function textarea_styles($params, $name_prefix) {
        ?>
        <div class="wbls-style-row">
            <label>Width</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>width" value="<?php echo esc_attr($params['width']); ?>">
            <span class="cf7b-um">%</span>
        </div>
        <div class="wbls-style-row">
            <label>Height</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>height" value="<?php echo esc_attr($params['height']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Font Size</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>font_size" value="<?php echo esc_attr($params['font_size']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Font Weight</label>
            <select name="<?php echo esc_html($name_prefix); ?>font_weight">
                <option value=""></option>
                <option value="normal" <?php echo ($params['font_weight'] == 'normal') ? 'selected' : '' ?>>Normal</option>
                <option value="bold" <?php echo ($params['font_weight'] == 'bold') ? 'selected' : '' ?>>Bold</option>
                <option value="bolder" <?php echo ($params['font_weight'] == 'bolder') ? 'selected' : '' ?>>Bolder</option>
                <option value="lighter" <?php echo ($params['font_weight'] == 'lighter') ? 'selected' : '' ?>>Lighter</option>
                <option value="initial" <?php echo ($params['font_weight'] == 'initial') ? 'selected' : '' ?>>Initial</option>
            </select>
        </div>
        <div class="wbls-style-row">
            <label>Background Color</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>bg_color" value="<?php echo esc_attr($params['bg_color']); ?>" class="textarea_bg_color" />
        </div>
        <div class="wbls-style-row">
            <label>Color</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>color" value="<?php echo esc_attr($params['color']); ?>" class="textarea_color" />
        </div>
        <div class="wbls-style-row">
            <label>Margin</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>margin" value="<?php echo esc_attr($params['margin']); ?>">
            <p class="cf7b-description">Use CSS type values. Ex 5px 3px</p>
        </div>
        <div class="wbls-style-row">
            <label>Padding</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>padding" value="<?php echo esc_attr($params['padding']); ?>">
            <p class="cf7b-description">Use CSS type values. Ex 5px 3px</p>
        </div>
        <div class="wbls-style-row">
            <label>Border Width</label>
            <input type="number" name="<?php echo esc_html($name_prefix); ?>border_width" min="0" value="<?php echo esc_attr($params['border_width']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Border Type</label>
            <select name="<?php echo esc_html($name_prefix); ?>border_style">
                <option value="solid" <?php echo ($params['border_style'] == 'solid') ? 'selected' : '' ?>>Solid</option>
                <option value="dotted" <?php echo ($params['border_style'] == 'dotted') ? 'selected' : '' ?>>Dotted</option>
                <option value="dashed" <?php echo ($params['border_style'] == 'dashed') ? 'selected' : '' ?>>Dashed</option>
                <option value="double" <?php echo ($params['border_style'] == 'double') ? 'selected' : '' ?>>Double</option>
                <option value="groove" <?php echo ($params['border_style'] == 'groove') ? 'selected' : '' ?>>Groove</option>
                <option value="ridge" <?php echo ($params['border_style'] == 'ridge') ? 'selected' : '' ?>>Ridge</option>
                <option value="inset" <?php echo ($params['border_style'] == 'inset') ? 'selected' : '' ?>>Inset</option>
                <option value="outset" <?php echo ($params['border_style'] == 'outset') ? 'selected' : '' ?>>Outset</option>
                <option value="initial" <?php echo ($params['border_style'] == 'initial') ? 'selected' : '' ?>>Initial</option>
                <option value="inherit" <?php echo ($params['border_style'] == 'inherit') ? 'selected' : '' ?>>Inherit</option>
            </select>
        </div>
        <div class="wbls-style-row">
            <label>Border Color</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>border_color" value="<?php echo esc_attr($params['border_color']); ?>" class="textarea_border_color" />
        </div>
        <div class="wbls-style-row">
            <label>Border Radius</label>
            <input type="number" name="<?php echo esc_html($name_prefix); ?>border_radius" value="<?php echo esc_attr($params['border_radius']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Box Shadow</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>box_shadow" value="<?php echo esc_attr($params['box_shadow']); ?>" placeholder="e.g. 5px 5px 2px #888888">
        </div>

        <?php
    }

    public function dropdown_field_styles() {
        $params = $this->default;
        ?>
        <div class="wbls-style-row">
            <label>Width</label>
            <input type="text" name="drodown_fields_width" value="<?php echo esc_attr($params['drodown_fields']['width']); ?>">
            <span class="cf7b-um">%</span>
        </div>
        <div class="wbls-style-row">
            <label>Height</label>
            <input type="text" name="drodown_fields_height" value="<?php echo esc_attr($params['drodown_fields']['height']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Font Size</label>
            <input type="text" name="drodown_fields_font_size" value="<?php echo esc_attr($params['drodown_fields']['font_size']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Font Weight</label>
            <select name="drodown_fields_font_weight">
                <option value=""></option>
                <option value="normal" <?php echo ($params['drodown_fields']['font_weight'] == 'normal') ? 'selected' : '' ?>>Normal</option>
                <option value="bold" <?php echo ($params['drodown_fields']['font_weight'] == 'bold') ? 'selected' : '' ?>>Bold</option>
                <option value="bolder" <?php echo ($params['drodown_fields']['font_weight'] == 'bolder') ? 'selected' : '' ?>>Bolder</option>
                <option value="lighter" <?php echo ($params['drodown_fields']['font_weight'] == 'lighter') ? 'selected' : '' ?>>Lighter</option>
                <option value="initial" <?php echo ($params['drodown_fields']['font_weight'] == 'initial') ? 'selected' : '' ?>>Initial</option>
            </select>
        </div>
        <div class="wbls-style-row">
            <label>Background Color</label>
            <input type="text" name="drodown_fields_bg_color" value="<?php echo esc_attr($params['drodown_fields']['bg_color']); ?>" class="drodown_bg_color" />
        </div>
        <div class="wbls-style-row">
            <label>Color</label>
            <input type="text" name="drodown_fields_color" value="<?php echo esc_attr($params['drodown_fields']['color']); ?>" class="drodown_color" />
        </div>
        <div class="wbls-style-row">
            <label>Margin</label>
            <input type="text" name="drodown_fields_margin" value="<?php echo esc_attr($params['drodown_fields']['margin']); ?>">
            <p class="cf7b-description">Use CSS type values. Ex 5px 3px</p>
        </div>
        <div class="wbls-style-row">
            <label>Padding</label>
            <input type="text" name="drodown_fields_padding" value="<?php echo esc_attr($params['drodown_fields']['padding']); ?>">
            <p class="cf7b-description">Use CSS type values. Ex 5px 3px</p>
        </div>
        <div class="wbls-style-row">
            <label>Border Width</label>
            <input type="number" name="drodown_fields_border_width" min="0" value="<?php echo esc_attr($params['drodown_fields']['border_width']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Border Type</label>
            <select name="drodown_fields_border_style">
                <option value="solid" <?php echo ($params['drodown_fields']['border_style'] == 'solid') ? 'selected' : '' ?>>Solid</option>
                <option value="dotted" <?php echo ($params['drodown_fields']['border_style'] == 'dotted') ? 'selected' : '' ?>>Dotted</option>
                <option value="dashed" <?php echo ($params['drodown_fields']['border_style'] == 'dashed') ? 'selected' : '' ?>>Dashed</option>
                <option value="double" <?php echo ($params['drodown_fields']['border_style'] == 'double') ? 'selected' : '' ?>>Double</option>
                <option value="groove" <?php echo ($params['drodown_fields']['border_style'] == 'groove') ? 'selected' : '' ?>>Groove</option>
                <option value="ridge" <?php echo ($params['drodown_fields']['border_style'] == 'ridge') ? 'selected' : '' ?>>Ridge</option>
                <option value="inset" <?php echo ($params['drodown_fields']['border_style'] == 'inset') ? 'selected' : '' ?>>Inset</option>
                <option value="outset" <?php echo ($params['drodown_fields']['border_style'] == 'outset') ? 'selected' : '' ?>>Outset</option>
                <option value="initial" <?php echo ($params['drodown_fields']['border_style'] == 'initial') ? 'selected' : '' ?>>Initial</option>
                <option value="inherit" <?php echo ($params['drodown_fields']['border_style'] == 'inherit') ? 'selected' : '' ?>>Inherit</option>
            </select>
        </div>
        <div class="wbls-style-row">
            <label>Border Color</label>
            <input type="text" name="drodown_fields_border_color" value="<?php echo esc_attr($params['drodown_fields']['border_color']); ?>" class="drodown_border_color" />
        </div>
        <div class="wbls-style-row">
            <label>Border Radius</label>
            <input type="number" name="drodown_fields_border_radius" value="<?php echo esc_attr($params['drodown_fields']['border_radius']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Box Shadow</label>
            <input type="text" name="drodown_fields_box_shadow" value="<?php echo esc_attr($params['drodown_fields']['box_shadow']); ?>" placeholder="e.g. 5px 5px 2px #888888">
        </div>
        <?php
    }

    public function checkbox_field_styles() {
        $params = $this->default;
        ?>
        <div class="wbls-style-row">
            <label>Width</label>
            <input type="text" name="checkbox_fields_width" value="<?php echo esc_attr($params['checkbox_fields']['width']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Height</label>
            <input type="text" name="checkbox_fields_height" value="<?php echo esc_attr($params['checkbox_fields']['height']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Background Color</label>
            <input type="text" name="checkbox_fields_bg_color" value="<?php echo esc_attr($params['checkbox_fields']['bg_color']); ?>" class="checkbox_bg_color" />
        </div>
        <div class="wbls-style-row">
            <label>Checked Background Color</label>
            <input type="text" name="checkbox_fields_checked_bg_color" value="<?php echo esc_attr($params['checkbox_fields']['checked_bg_color']); ?>" class="checkbox_checked_bg_color" />
        </div>
        <div class="wbls-style-row">
            <label>Margin</label>
            <input type="text" name="checkbox_fields_margin" value="<?php echo esc_attr($params['checkbox_fields']['margin']); ?>">
            <p class="cf7b-description">Use CSS type values. Ex 5px 3px</p>
        </div>
        <div class="wbls-style-row">
            <label>Padding</label>
            <input type="text" name="checkbox_fields_padding" value="<?php echo esc_attr($params['checkbox_fields']['padding']); ?>">
            <p class="cf7b-description">Use CSS type values. Ex 5px 3px</p>
        </div>
        <hr>
        <h4>Mini Labels</h4>
        <div class="wbls-style-row">
            <label>Label Font Size</label>
            <input type="text" name="checkbox_fields_label_font_size" value="<?php echo esc_attr($params['checkbox_fields']['label_font_size']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Label Font Color</label>
            <input type="text" name="checkbox_fields_label_color" value="<?php echo esc_attr($params['checkbox_fields']['label_color']); ?>" class="button_color" />
        </div>
        <div class="wbls-style-row">
            <label>Label Font Weight</label>
            <select name="checkbox_fields_label_font_weight">
                <option value=""></option>
                <option value="normal" <?php echo ($params['checkbox_fields']['label_font_weight'] == 'normal') ? 'selected' : '' ?>>Normal</option>
                <option value="bold" <?php echo ($params['checkbox_fields']['label_font_weight'] == 'bold') ? 'selected' : '' ?>>Bold</option>
                <option value="bolder" <?php echo ($params['checkbox_fields']['label_font_weight'] == 'bolder') ? 'selected' : '' ?>>Bolder</option>
                <option value="lighter" <?php echo ($params['checkbox_fields']['label_font_weight'] == 'lighter') ? 'selected' : '' ?>>Lighter</option>
                <option value="initial" <?php echo ($params['checkbox_fields']['label_font_weight'] == 'initial') ? 'selected' : '' ?>>Initial</option>
            </select>
        </div>
        <?php
    }

    public function buttons_styles($params, $name_prefix) {
        ?>
        <div class="wbls-style-row">
            <label>Width</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>width" value="<?php echo esc_attr($params['width']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Height</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>height" value="<?php echo esc_attr($params['height']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Font Size</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>font_size" value="<?php echo esc_attr($params['font_size']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Font Color</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>color" value="<?php echo esc_attr($params['color']); ?>" class="button_color" />
        </div>
        <div class="wbls-style-row">
            <label>Font Weight</label>
            <select name="<?php echo esc_html($name_prefix); ?>font_weight">
                <option value=""></option>
                <option value="normal" <?php echo ($params['font_weight'] == 'normal') ? 'selected' : '' ?>>Normal</option>
                <option value="bold" <?php echo ($params['font_weight'] == 'bold') ? 'selected' : '' ?>>Bold</option>
                <option value="bolder" <?php echo ($params['font_weight'] == 'bolder') ? 'selected' : '' ?>>Bolder</option>
                <option value="lighter" <?php echo ($params['font_weight'] == 'lighter') ? 'selected' : '' ?>>Lighter</option>
                <option value="initial" <?php echo ($params['font_weight'] == 'initial') ? 'selected' : '' ?>>Initial</option>
            </select>
        </div>
        <div class="wbls-style-row">
            <label>Background Color</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>bg_color" value="<?php echo esc_attr($params['bg_color']); ?>" class="button_bg_color" />
        </div>
        <div class="wbls-style-row">
            <label>Margin</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>margin" value="<?php echo esc_attr($params['margin']); ?>">
            <p class="cf7b-description">Use CSS type values. Ex 5px 3px</p>
        </div>
        <div class="wbls-style-row">
            <label>Padding</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>padding" value="<?php echo esc_attr($params['padding']); ?>">
            <p class="cf7b-description">Use CSS type values. Ex 5px 3px</p>
        </div>
        <div class="wbls-style-row">
            <label>Border Width</label>
            <input type="number" name="<?php echo esc_html($name_prefix); ?>border_width" min="0" value="<?php echo esc_attr($params['border_width']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Border Type</label>
            <select name="<?php echo esc_html($name_prefix); ?>border_style">
                <option value="solid" <?php echo ($params['border_style'] == 'solid') ? 'selected' : '' ?>>Solid</option>
                <option value="dotted" <?php echo ($params['border_style'] == 'dotted') ? 'selected' : '' ?>>Dotted</option>
                <option value="dashed" <?php echo ($params['border_style'] == 'dashed') ? 'selected' : '' ?>>Dashed</option>
                <option value="double" <?php echo ($params['border_style'] == 'double') ? 'selected' : '' ?>>Double</option>
                <option value="groove" <?php echo ($params['border_style'] == 'groove') ? 'selected' : '' ?>>Groove</option>
                <option value="ridge" <?php echo ($params['border_style'] == 'ridge') ? 'selected' : '' ?>>Ridge</option>
                <option value="inset" <?php echo ($params['border_style'] == 'inset') ? 'selected' : '' ?>>Inset</option>
                <option value="outset" <?php echo ($params['border_style'] == 'outset') ? 'selected' : '' ?>>Outset</option>
                <option value="initial" <?php echo ($params['border_style'] == 'initial') ? 'selected' : '' ?>>Initial</option>
                <option value="inherit" <?php echo ($params['border_style'] == 'inherit') ? 'selected' : '' ?>>Inherit</option>
            </select>
        </div>
        <div class="wbls-style-row">
            <label>Border Color</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>border_color" value="<?php echo esc_attr($params['border_color']); ?>" class="button_border_color" />
        </div>
        <div class="wbls-style-row">
            <label>Border Radius</label>
            <input type="number" name="<?php echo esc_html($name_prefix); ?>border_radius" value="<?php echo esc_attr($params['border_radius']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Box Shadow</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>box_shadow" value="<?php echo esc_attr($params['box_shadow']); ?>" placeholder="e.g. 5px 5px 2px #888888">
        </div>
        <div class="wbls-style-row">
            <label>Text align</label>
            <select name="<?php echo esc_html($name_prefix); ?>text_align">
                <option value="left" <?php echo ($params['text_align'] == 'left') ? 'selected' : '' ?>>Left</option>
                <option value="center" <?php echo ($params['text_align'] == 'center') ? 'selected' : '' ?>>Center</option>
                <option value="right" <?php echo ($params['text_align'] == 'right') ? 'selected' : '' ?>>Right</option>
            </select>
        </div>
        <!-- Hover -->
        <div class="wbls-style-row">
            <label>Hover Font Weight</label>
            <select name="<?php echo esc_html($name_prefix); ?>hover_font_weight">
                <option value=""></option>
                <option value="normal" <?php echo ($params['hover_font_weight'] == 'normal') ? 'selected' : '' ?>>Normal</option>
                <option value="bold" <?php echo ($params['hover_font_weight'] == 'bold') ? 'selected' : '' ?>>Bold</option>
                <option value="bolder" <?php echo ($params['hover_font_weight'] == 'bolder') ? 'selected' : '' ?>>Bolder</option>
                <option value="lighter" <?php echo ($params['hover_font_weight'] == 'lighter') ? 'selected' : '' ?>>Lighter</option>
                <option value="initial" <?php echo ($params['hover_font_weight'] == 'initial') ? 'selected' : '' ?>>Initial</option>
            </select>
        </div>
        <div class="wbls-style-row">
            <label>Hover Background Color</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>hover_bg_color" value="<?php echo esc_attr($params['hover_bg_color']); ?>" class="button_hover_bg_color" />
        </div>
        <div class="wbls-style-row">
            <label>Hover Font Color</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>hover_color" value="<?php echo esc_attr($params['hover_color']); ?>" class="button_hover_color" />
        </div>
        <?php
    }

    public function message_styles($params, $name_prefix) {
        ?>
        <div class="wbls-style-row">
            <label>Text Font Size</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>font_size" value="<?php echo esc_attr($params['font_size']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Text Font Weight</label>
            <select name="<?php echo esc_html($name_prefix); ?>font_weight">
                <option value=""></option>
                <option value="normal" <?php echo ($params['font_weight'] == 'normal') ? 'selected' : '' ?>>Normal</option>
                <option value="bold" <?php echo ($params['font_weight'] == 'bold') ? 'selected' : '' ?>>Bold</option>
                <option value="bolder" <?php echo ($params['font_weight'] == 'bolder') ? 'selected' : '' ?>>Bolder</option>
                <option value="lighter" <?php echo ($params['font_weight'] == 'lighter') ? 'selected' : '' ?>>Lighter</option>
                <option value="initial" <?php echo ($params['font_weight'] == 'initial') ? 'selected' : '' ?>>Initial</option>
            </select>
        </div>
        <div class="wbls-style-row">
            <label>Message Background Color</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>bg_color" value="<?php echo esc_attr($params['bg_color']); ?>" class="input_bg_color" />
        </div>
        <div class="wbls-style-row">
            <label>Text Color</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>color" value="<?php echo esc_attr($params['color']); ?>" class="input_color" />
        </div>
        <div class="wbls-style-row">
            <label>Margin</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>margin" value="<?php echo esc_attr($params['margin']); ?>">
            <p class="cf7b-description">Use CSS type values. Ex 5px 3px</p>
        </div>
        <div class="wbls-style-row">
            <label>Padding</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>padding" value="<?php echo esc_attr($params['padding']); ?>">
            <p class="cf7b-description">Use CSS type values. Ex 5px 3px</p>
        </div>
        <div class="wbls-style-row">
            <label>Border Width</label>
            <input type="number" name="<?php echo esc_html($name_prefix); ?>border_width" min="0" value="<?php echo esc_attr($params['border_width']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Border Type</label>
            <select name="<?php echo esc_html($name_prefix); ?>border_style">
                <option value="solid" <?php echo ($params['border_style'] == 'solid') ? 'selected' : '' ?>>Solid</option>
                <option value="dotted" <?php echo ($params['border_style'] == 'dotted') ? 'selected' : '' ?>>Dotted</option>
                <option value="dashed" <?php echo ($params['border_style'] == 'dashed') ? 'selected' : '' ?>>Dashed</option>
                <option value="double" <?php echo ($params['border_style'] == 'double') ? 'selected' : '' ?>>Double</option>
                <option value="groove" <?php echo ($params['border_style'] == 'groove') ? 'selected' : '' ?>>Groove</option>
                <option value="ridge" <?php echo ($params['border_style'] == 'ridge') ? 'selected' : '' ?>>Ridge</option>
                <option value="inset" <?php echo ($params['border_style'] == 'inset') ? 'selected' : '' ?>>Inset</option>
                <option value="outset" <?php echo ($params['border_style'] == 'outset') ? 'selected' : '' ?>>Outset</option>
                <option value="initial" <?php echo ($params['border_style'] == 'initial') ? 'selected' : '' ?>>Initial</option>
                <option value="inherit" <?php echo ($params['border_style'] == 'inherit') ? 'selected' : '' ?>>Inherit</option>
            </select>
        </div>
        <div class="wbls-style-row">
            <label>Border Color</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>border_color" value="<?php echo esc_attr($params['border_color']); ?>" class="input_border_color" />
        </div>
        <div class="wbls-style-row">
            <label>Border Radius</label>
            <input type="number" name="<?php echo esc_html($name_prefix); ?>border_radius" value="<?php echo esc_attr($params['border_radius']); ?>">
            <span class="cf7b-um">px</span>
        </div>
        <div class="wbls-style-row">
            <label>Box Shadow</label>
            <input type="text" name="<?php echo esc_html($name_prefix); ?>box_shadow" value="<?php echo esc_attr($params['box_shadow']); ?>" placeholder="e.g. 5px 5px 2px #888888">
        </div>
        <?php
    }

}