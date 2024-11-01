let deactivate_link = '';
jQuery(document).ready(function () {
    let idName = 'deactivate-whistleblowing-system';
    if( deactivate_options.pro == "1" ) {
        idName = 'deactivate-whistleblowing-system-pro';
    }
    // Listen for plugin deactivation link click
    jQuery(document).on('click', '#'+idName, function (e) {
        e.preventDefault();
        deactivate_link = jQuery(this).attr("href");
        let template = jQuery(document).find("#wbls-deactivate-template").html();
        jQuery("body").append(template);
    });

    jQuery(document).on('click', '.wbls-close, .wbls-deactivat-layout', function (e) {
        jQuery(document).find(".wbls-deactivat-layout").remove();
        jQuery(document).find(".wbls-deactivat-container").remove();
    });

    jQuery(document).on('change', '.wbls-reason',function() {
        let template = '';
        jQuery(document).find(".wbls-terms-agree-row").show();
        jQuery(document).find(".wbls-submit-button").show();
        switch (this.value) {
            case 'free_limited':
                template = jQuery(document).find("#wbls-deactivate-pro-offer-template").html();
                jQuery(".wbls-additional-row").empty().append(template).show();
                break;
            case 'better_alternative':
                template = jQuery(document).find("#wbls-deactivate-pro-offer-template").html();
                jQuery(".wbls-additional-row").empty().append(template).show();
                break;
            case 'conflict':
                template = jQuery(document).find("#wbls-deactivate-support-template").html();
                jQuery(".wbls-additional-row").empty().append(template).show();
                break;
            case 'other':
                template = jQuery(document).find("#wbls-deactivate-other-template").html();
                jQuery(".wbls-additional-row").empty().append(template).show();
                break;
            default:
                jQuery(".wbls-additional-row").empty().hide();
        }
    });

    jQuery(document).on('click', '.wbls-terms-agree', function (e) {
        if( jQuery(this).is(':checked') ) {
            jQuery(".wbls-submit-button").removeClass("wbls-submit-disabled");
        } else {
            jQuery(".wbls-submit-button").addClass("wbls-submit-disabled");
        }
    });

    jQuery(document).on('click', '.wbls-skip-button', function (e) {
        if( jQuery(this).hasClass('wbls-submit-loading') ) {
            return false;
        }

        let button_text = jQuery(this).text();
        jQuery(this).addClass("wbls-submit-loading").empty();

        let data = {
            action: 'wbls_send_deactivation_reason',
            task: 'wbls_send_reason',
            nonce: deactivate_options.nonce,
            skip: 1,
        }

        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: data,
            success: function (response) {
                jQuery(document).find('.wbls-skip-button').removeClass("wbls-submit-loading").text(button_text);
            },
            complete: function (response) {
                window.location.href = deactivate_link;
            },
            error: function () {
                jQuery(document).find('.wbls-submit-button').removeClass("wbls-submit-loading").text(button_text);
            },
        });
    });

    jQuery(document).on('click', '.wbls-submit-button', function (e) {
        if( jQuery(this).hasClass('wbls-submit-disabled') || jQuery(this).hasClass('wbls-submit-loading') ) {
            return false;
        }

        let button_text = jQuery(this).text();
        jQuery(this).addClass("wbls-submit-loading").empty();

        let checked = jQuery(".wbls-reason-row input[type='radio'][name=wbls_reason]:checked");
        let reason_value = checked.val();
        let reason = checked.parent().find('label').text();
        let message = '';
        let email = '';

        switch (reason_value) {
            case 'conflict':
                message = jQuery(document).find(".wbls-issue-message").val();
                email = jQuery(document).find(".wbls-admin-email").val();
                break;
            case 'other':
                message = jQuery(document).find(".wbls-issue-message").val();
                break;
            default:
                jQuery(".wbls-additional-row").empty().hide();
        }

        data = {
            action: 'wbls_send_deactivation_reason',
            task: 'wbls_send_reason',
            reason_value: reason_value,
            reason: reason,
            message: message,
            email: email,
            nonce: deactivate_options.nonce,
            skip: 0,
        }

        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: data,
            success: function (response) {
                jQuery(document).find('.wbls-submit-button').removeClass("wbls-submit-loading").text(button_text);
            },
            complete: function (response) {
                window.location.href = deactivate_link;
            },
            error: function () {
                jQuery(document).find('.wbls-submit-button').removeClass("wbls-submit-loading").text(button_text);
            },
        });

    });
});