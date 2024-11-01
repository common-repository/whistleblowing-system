jQuery(document).ready( function () {
    jQuery(document).on("click", ".wbls-pro-tooltip-action", function () {
        let template = jQuery(document).find("#wbls-buy-pro-banner-template").html();
        jQuery("body").append(template);
    });

    jQuery(document).on("click", ".wbls-pro-banner-layout", function () {
        let template = jQuery(document).find("#wbls-buy-pro-banner-template").html();
        jQuery(document).find(".wbls-pro-banner-layout").remove();
    });

    jQuery(document).on("click", ".wbls-delete-form", function(e) {
        e.preventDefault();
        if (confirm("Are you sure you want to delete the form, including all submissions?") == true) {
            self.wbls_remove_form(this);
        }
    });

    jQuery(document).on("click", ".wbls-delete-theme", function(e) {
        e.preventDefault();
        if (confirm("Are you sure you want to delete the theme?") == true) {
            self.wbls_remove_theme(this);
        }
    });

    jQuery(document).on("click", ".wbls-save-settings", function(e) {
        e.preventDefault();
        wbls_save_settings();
    });

    jQuery(document).on("click", ".wbls-bulk-action-apply", function(e) {
        e.preventDefault();
        wbls_bulk_action(this);
    });

});

function wbls_bulk_action(that) {
    let action_type = jQuery(that).closest(".wbls-bulk-action-row").find(".wbls-bulk-actions").val();
    jQuery(document).find(".wbls-response-message").empty().hide();
    if( action_type == -1 ) {
        return;
    }

    let ids = [];
    jQuery(".wbls-single-submissions").each(function() {
        if( jQuery(this).is(':checked') ) {
            ids.push(jQuery(this).attr("data-id"));
        }
    });

    if( !ids.length ) {
        return;
    }
    let button_title = jQuery(that).text();
    jQuery(that).empty()
    jQuery(that).addClass("wbls-button-loading");
    let data = {
        nonce : wbls_admin.ajaxnonce,
        task : 'wbls_bulk_action',
        action : 'wbls_admin_ajax',
        action_type : action_type,
        ids : ids
    };


    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data:  data,
        success: function (response){
            if( !response['success'] ) {
                jQuery(".wbls-response-message").addClass("wbls-error-message").empty().text(response['data']['message']).show();
            }
            else if( response['success'] ) {
                jQuery(".wbls-single-submissions").each(function() {
                    if( jQuery(this).is(':checked') ) {
                        ids.push(jQuery(this).attr("data-id"));
                    }
                });

                // Construct a single jQuery selector from the array
                const selector = ids.map(id => `[data-id='${id}']`).join(',');

                if ( action_type == 'delete' ) {
                    // Remove all matching elements in one go
                    jQuery(selector).closest('tr').remove();
                } else {
                    let action_title = 'Active';
                    switch ( action_type ) {
                        case "block":
                            action_title = 'Blocked';
                            break;
                        case "complete":
                            action_title = 'Completed';
                            break;
                    }
                    jQuery(selector).closest('tr').find(".wbls-status-button-title").text(action_title);
                }

                jQuery(".wbls-response-message").addClass("wbls-success-message").empty().text(response['data']['message']).show();
            } else {
                jQuery(".wbls-response-message").addClass("wbls-error-message").empty().text(wbls_admin.form_error_delete).show();
            }
        },
        complete: function () {
            jQuery(that).removeClass("wbls-button-loading");
            jQuery(that).text(button_title);
        },
        error: function (jqXHR, exception) {
            jQuery(".wbls-response-message").addClass("wbls-error-message").empty().text(wbls_admin.form_error_delete).show();
        },

    });

}

function wbls_save_settings() {

    let reCAPTCHA_v2_site_key = '';
    let reCAPTCHA_v2_secret_key = '';
    let reCAPTCHA_language = '';
    let reCAPTCHA_v3_site_key = '';
    let reCAPTCHA_v3_secret_key = '';
    let teeny_active = jQuery(document).find(".wbls-teeny_active:checked").val();
    let data = {
        nonce : wbls_admin.ajaxnonce,
        task : 'wbls_save_settings',
        action : 'wbls_admin_ajax',
        reCAPTCHA_v2_site_key : reCAPTCHA_v2_site_key,
        reCAPTCHA_v2_secret_key : reCAPTCHA_v2_secret_key,
        reCAPTCHA_language : reCAPTCHA_language,
        reCAPTCHA_v3_site_key : reCAPTCHA_v3_site_key,
        reCAPTCHA_v3_secret_key : reCAPTCHA_v3_secret_key,
        teeny_active : teeny_active
    };

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data:  data,
        success: function (response){
            if( !response['success'] ) {
                if( typeof response['data'] != 'undefined' &&  typeof response['data']['message'] != 'undefined') {
                    jQuery(".wbls-response-message").addClass("wbls-error-message").empty().text(response['data']['message']).show();
                } else {
                    jQuery(".wbls-response-message").addClass("wbls-error-message").empty().text(wbls_admin.form_error_delete).show();
                }
            }
            else if( response['success'] ) {
                jQuery(".wbls-response-message").addClass("wbls-success-message").empty().text(wbls_admin.success_save).show();
            } else {
                jQuery(".wbls-response-message").addClass("wbls-error-message").empty().text(wbls_admin.form_error_delete).show();
            }
        },
        error: function (jqXHR, exception) {
            jQuery(".wbls-response-message").addClass("wbls-error-message").empty().text(wbls_admin.form_error_delete).show();
        },

    });

}

function wbls_remove_form(that) {

    jQuery(that).closest('.wbls-forms-list-row').addClass("wbls-loading");
    jQuery(".wbls-response-message").removeClass("wbls-error-message").removeClass("wbls-success-message").hide();

    let id = jQuery(that).attr("data-id");
    let data = {};
    data['id'] = id;
    data['nonce'] = wbls_admin.ajaxnonce;
    data['task'] = 'remove_form';
    data['action'] = "wbls_admin_ajax";
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data:  data,
        success: function (response){
            if( !response['success'] ) {
                jQuery(".wbls-response-message").addClass("wbls-error-message").empty().text(wbls_admin.form_error_delete).show();
            }
            else if( response['success'] ) {
                jQuery(".wbls-response-message").addClass("wbls-success-message").empty().text(wbls_admin.form_success_delete).show();
                jQuery(that).closest('.wbls-forms-list-row').remove();
            } else {
                jQuery(".wbls-response-message").addClass("wbls-error-message").empty().text(wbls_admin.form_error_delete).show();
            }
        },
        complete: function() {
            jQuery(that).closest('.wbls-forms-list-row').removeClass("wbls-loading");
        },
        error: function (jqXHR, exception) {
            jQuery(".wbls-response-message").addClass("wbls-error-message").empty().text(wbls_admin.form_error_delete).show();
        },

    });
}

function wbls_remove_theme(that) {

    jQuery(that).closest('.wbls-forms-list-row').addClass("wbls-loading");
    jQuery(".wbls-response-message").removeClass("wbls-error-message").removeClass("wbls-success-message").hide();

    let id = jQuery(that).attr("data-id");
    let data = {};
    data['id'] = id;
    data['nonce'] = wbls_admin.ajaxnonce;
    data['task'] = 'remove_theme';
    data['action'] = "wbls_admin_ajax";
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data:  data,
        success: function (response){
            if( !response['success'] ) {
                jQuery(".wbls-response-message").addClass("wbls-error-message").empty().text(wbls_admin.form_error_delete).show();
            }
            else if( response['success'] ) {
                jQuery(".wbls-response-message").addClass("wbls-success-message").empty().text(wbls_admin.theme_success_delete).show();
                jQuery(that).closest('.wbls-forms-list-row').remove();
            } else {
                jQuery(".wbls-response-message").addClass("wbls-error-message").empty().text(wbls_admin.form_error_delete).show();
            }
        },
        complete: function() {
            jQuery(that).closest('.wbls-forms-list-row').removeClass("wbls-loading");
        },
        error: function (jqXHR, exception) {
            jQuery(".wbls-response-message").addClass("wbls-error-message").empty().text(wbls_admin.form_error_delete).show();
        },

    });
}
