class WBLS_SUBMISSIONS {
    init() {
        this.registerEvents();
    }

    registerEvents() {
        let self = this;

        jQuery(".wbls-access-key-column").mouseenter(function() {
            jQuery(this).find(".wbls-access-key-container").show();
        }).mouseleave(function() {
            jQuery(this).find(".wbls-access-key-container").hide();
        });

        jQuery(document).on("click", ".wbls-chat-icon", function() {
            jQuery("body").addClass("wbls-hide-overflow");
            jQuery(this).closest(".wbls-access-chat-column").find(".wbls-chats-content").show();
        });

        jQuery(document).on("click", ".wbls-chats-close", function() {
            jQuery("body").removeClass("wbls-hide-overflow");
            jQuery(this).closest(".wbls-chats-content").hide();
        });

        jQuery(document).on("change", ".wbls-file-input", function(e) {
            let inputImage = jQuery(this).val().split('\\').pop();
            jQuery(this).closest(".wbls-reply-attachement-cont").find(".imageName").text(inputImage);
        });

        jQuery(document).on("click", ".wbls-reply-button", function(e) {
            e.preventDefault();
            self.wbls_reply(this);
        });

        jQuery(document).on("click", ".wbls-all-submissions", function(e) {
            if( jQuery(this).prop("checked") ) {
                jQuery(document).find(".wp-list-table.wbls-subm-table .wbls-single-submissions").prop("checked", true);
            } else {
                jQuery(document).find(".wp-list-table.wbls-subm-table .wbls-single-submissions").prop("checked", false);
            }
        });

        jQuery(document).on("click", ".wbls-export-csv", function(e) {
            e.preventDefault();
            self.wbls_export_csv(this);
        });

        jQuery(document).on("click", ".wbls-delete-submission", function(e) {
            e.preventDefault();
            if (confirm("Are you sure you want to delete the submission, including all chats?") == true) {
                self.wbls_remove_submission(this);
            }
        });

        jQuery(document).on("click", ".wbls-delete-all-submission", function(e) {
            e.preventDefault();
            if (confirm("Are you sure you want to delete the submissions, including all chats?") == true) {
                self.wbls_remove_all_submission(this);
            }
        });

        jQuery(document).on("click", ".wbls-status-button", function(e) {
            if ( jQuery(this).find(".wbls-status-dropdown").hasClass('wbls-hidden') ) {
                jQuery(document).find(".wbls-status-dropdown").addClass('wbls-hidden');
                jQuery(this).find(".wbls-status-dropdown").removeClass('wbls-hidden');
            } else {
                jQuery(this).find(".wbls-status-dropdown").addClass('wbls-hidden');
            }
        });

        jQuery(document).on("click", ".wbls-status-item", function(e) {
           self.wbls_change_status(this);
        });

    }

    wbls_change_status( that ) {
        let status_id = jQuery(that).attr("data-status");
        let current_status_id = jQuery(that).closest(".wbls-status-button").find(".wbls-status-button-title").attr("data-status");
        let submission_id = jQuery(that).closest(".wbls-status-button").find(".wbls-status-button-title").attr("data-submission_id");
        if( status_id === current_status_id ) {
            return;
        }
        let status_text = jQuery(that).text();
        let buttonTitle = jQuery(that).closest(".wbls-status-button").find(".wbls-status-button-title");

        let data = {};
        data['submission_id'] = submission_id;
        data['status_id'] = status_id;
        data['nonce'] = wbls_submissions.ajaxnonce;
        data['task'] = 'wbls_change_status';
        data['action'] = "wbls_admin_ajax";


        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data:  data,
            success: function (response){
                if( response['success'] ) {
                    buttonTitle.text(status_text);
                    buttonTitle.attr("data-status", status_id);
                }
            },
            error: function (jqXHR, exception) {
            },

        });

    }

    wbls_remove_submission(that) {

        jQuery(that).closest('tr').addClass("wbls-loading");
        jQuery(".wbls-response-message").removeClass("wbls-error-message").removeClass("wbls-success-message").hide();

        let submission_id = jQuery(that).attr("data-submissionId");
        let data = {};
        data['submission_id'] = submission_id;
        data['nonce'] = wbls_submissions.ajaxnonce;
        data['task'] = 'wbls_remove_submission';
        data['action'] = "wbls_admin_ajax";
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data:  data,
            success: function (response){
                if( !response['success'] ) {
                    jQuery(".wbls-response-message").addClass("wbls-error-message").empty().text(wbls_submissions.submission_error_delete).show();
                }
                else if( response['success'] && response['data']['delete'] ) {
                    jQuery(".wbls-response-message").addClass("wbls-success-message").empty().text(wbls_submissions.submission_success_delete).show();
                    jQuery(that).closest('tr').remove();
                } else {
                    jQuery(".wbls-response-message").addClass("wbls-error-message").empty().text(wbls_submissions.submission_error_delete).show();
                }
            },
            complete: function() {
                jQuery(that).closest('tr').removeClass("wbls-loading");
            },
            error: function (jqXHR, exception) {
                jQuery(".wbls-response-message").addClass("wbls-error-message").empty().text(wbls_submissions.submission_error_delete).show();
            },

        });
    }
    wbls_remove_all_submission(that) {

        jQuery(that).closest('.wbls-forms-list-row').addClass("wbls-loading");
        jQuery(".wbls-response-message").removeClass("wbls-error-message").removeClass("wbls-success-message").hide();

        let id = jQuery(that).attr("data-id");
        let data = {};
        data['id'] = id;
        data['nonce'] = wbls_submissions.ajaxnonce;
        data['task'] = 'wbls_remove_all_submission';
        data['action'] = "wbls_admin_ajax";
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data:  data,
            success: function (response){
                if( !response['success'] ) {
                    jQuery(".wbls-response-message").addClass("wbls-error-message").empty().text(wbls_submissions.submission_error_delete).show();
                }
                else {
                    jQuery(".wbls-response-message").addClass("wbls-success-message").empty().text(wbls_submissions.submission_success_delete).show();
                    jQuery(that).closest('.wbls-forms-list-row').remove();
                }
            },
            complete: function() {
                jQuery(that).closest('.wbls-forms-list-row').removeClass("wbls-loading");
            },
            error: function (jqXHR, exception) {
                jQuery(".wbls-response-message").addClass("wbls-error-message").empty().text(wbls_submissions.submission_error_delete).show();
            },

        });
    }
    wbls_export_csv(that) {}
    wbls_reply(that) {}

    wbls_add_chats( data, that ) {}
}

let wbls_subm;
jQuery(document).ready(function() {
    wbls_subm= new WBLS_SUBMISSIONS();
    wbls_subm.init();
});