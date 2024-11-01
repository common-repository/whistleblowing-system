jQuery(document).ready(function() {
    jQuery(".wbls-tab-item").on("click", function() {
        jQuery(".wbls-tab-item").removeClass("wbls-tab-active");
        jQuery(this).addClass("wbls-tab-active");
        let content_class = jQuery(this).data("content");
        content_class = ".wbls-tabs-content-" + content_class;
        jQuery(".wbls-tabs-content-item").hide();
        jQuery(content_class).show();
    });

    jQuery(document).find(".wbls-style-item-title .dashicons").on("click", function() {

        if( jQuery(this).hasClass("dashicons-arrow-up-alt2") ) {
            jQuery(this).closest(".wbls-style-item").find(".wbls-style-item-content").hide();
            jQuery(this).removeClass("dashicons-arrow-up-alt2").addClass("dashicons-arrow-down-alt2");
        } else {
            jQuery(this).closest(".wbls-style-item").find(".wbls-style-item-content").show();
            jQuery(this).removeClass("dashicons-arrow-down-alt2").addClass("dashicons-arrow-up-alt2");

        }
    })

    /* Color Picker fields */
    jQuery(".general_bg_color, .general_border_color, .general_layout_bg_color").wpColorPicker();
    jQuery(".input_bg_color, .input_color, .input_border_color").wpColorPicker();
    jQuery(".textarea_bg_color, .textarea_color, .textarea_border_color").wpColorPicker();
    jQuery(".drodown_bg_color, .drodown_color, .drodown_border_color").wpColorPicker();
    jQuery(".checkbox_bg_color, .checkbox_checked_bg_color, .checkbox_border_color").wpColorPicker();
    jQuery(".button_color, .button_bg_color, .button_border_color, .button_hover_bg_color, .button_hover_color").wpColorPicker();
})