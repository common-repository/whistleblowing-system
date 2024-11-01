class WBLS_FRONTEND {
    init() {
        this.token = '';
        this.conditions = wbls_front.conditions;
        this.hiddenConditions = [];
        this.recaptchaWidgetId;
        this.registerEvents();
        this.showFirstPage()
    }

    showFirstPage() {
        jQuery(document).find(".wblsform-page-and-images").eq(0).addClass("wblsform-active-page");
    }

    registerEvents() {
        let self = this;
        jQuery(document).on("click", ".wbls-new-case-button", function() {
            jQuery("body").addClass("wbls-hide-overflow");
            jQuery(".wbls-front-form-content").show();
            jQuery(".wbls-front-layout").show();
            jQuery(".wbls-form-container").show();
        });

        jQuery(document).on("click", ".wbls-front-content-close", function() {
            jQuery("body").removeClass("wbls-hide-overflow");
            jQuery(".wbls-chat-container, .wbls-login-container, .wbls-token-container, .wbls-form-container").hide();
            jQuery(".wbls-front-form-content").hide();
            jQuery(".wbls-front-layout").hide();
        });

        jQuery(document).on("click", ".wbls-submit-form", function(e) {
            e.preventDefault();
            if( wbls_front.recaptcha_version == "v2i" ) {
                grecaptcha.execute(self.recaptchaWidgetId);
            }
            else {
                self.wbls_submit_form(this);
            }

        });

        jQuery(document).on("click", ".wbls-copy-button", function(e) {
            e.preventDefault();
            self.wbls_copyToken();
        });

        jQuery(document).on("click", ".wbls-followup-button", function(e) {
            e.preventDefault();
            jQuery("body").addClass("wbls-hide-overflow");
            jQuery(".wbls-front-form-content").show();
            jQuery(".wbls-front-layout").show();
            jQuery(".wbls-login-container").show();
        });

        jQuery(document).on("click", ".wbls-login-button", function(e) {
            e.preventDefault();
            self.wbls_login(jQuery(this));
        });

        jQuery(document).on("click", "#wbls-reply-button", function(e) {
            e.preventDefault();
            self.wbls_reply(this);
        });

        jQuery(document).on("change", ".wbls-field[type='email']", function(e) {
            self.wbls_validate_email_fields(jQuery(this));
        });

        jQuery(document).on("change", "#wbls-file-input", function(e) {
            let inputImage = jQuery(this).val().split('\\').pop();
            jQuery("#imageName").text(inputImage);
        });
    }

    wbls_login(that) {
        let self = this;
        this.token = jQuery(that).closest(".wbls-login-container").find(".wbls-token-input").val();
        let wbls_form_id = jQuery(that).closest(".wbls-login-container").find(".wbls-form-id").val();
        if( this.token == '' ) {
            jQuery(".wbls-error-msg").text("Token field can't be empty").show();
            return;
        }
        let security = jQuery(that).closest(".wbls-login-container").find(".wbls-security").val();
        if( security != "" ) {
            return;
        }

        jQuery.ajax({
            type: 'POST',
            url: wbls_front.ajax_url,
            data: {
                'wbls_token': this.token,
                'wbls_security': security,
                'action': 'wbls_front_ajax',
                'task': 'wbls_login',
                'nonce': wbls_front.ajaxnonce
            },
            success: function (response) {
                if( !response['success'] ) {
                    jQuery(".wbls-error-msg").text(response['data']['message']).show();
                }
                else if( response['success'] && response['data']['chats'] != '' ) {
                    let data = response['data']['chats'];
                    self.admin_token_active = response['data']['chats']['admin_token_active'];
                    self.wbls_add_chats( data );
                    jQuery(".wbls-login-container").hide();
                    jQuery(".wbls-chat-container").show();
                }
            },
            complete: function() {
            },
            error: function (jqXHR, exception) {
                console.log(jqXHR);
            },

        });

    }

    wbls_check_required(that) {
        let form = jQuery(that).closest(".wbls-form");
        form.find(".wbls-required-error").removeClass("wbls-required-error");
        let required_error = false;
        
        if( wbls_front.recaptcha_version == "v2" ) {
            let recaptchaResponse = grecaptcha.getResponse();
            if (recaptchaResponse.length === 0) {
                jQuery("#wbls-grecaptcha").closest(".wblsform-row").addClass("wbls-required-error");
                required_error = true;
            }

        }

        form.find(".wbls-field").each(function( index ) {
            if( jQuery(this).attr('type') == 'radio' && typeof jQuery(this).attr('required') !== 'undefined' ) {
                let name = jQuery(this).attr('name');
                let is_checked = false;
                jQuery(document).find("input[name='"+name+"']").each(function() {
                    if( jQuery(this).is(':checked') ) {
                        is_checked = true;
                    }
                });
                if ( ! is_checked ) {
                    jQuery(this).closest(".wblsform-row").addClass("wbls-required-error");
                    required_error = true;
                }
            }
            else if( typeof jQuery(this).attr('required') !== 'undefined' &&
                (( jQuery(this).attr('type') == 'checkbox' && !jQuery(this).is(":checked") ) ||
                    ( jQuery(this).attr('type') != 'checkbox' && !jQuery(this).val() ) ) &&
                jQuery(this).is(":visible")) {
                jQuery(this).closest(".wblsform-row").addClass("wbls-required-error");
                required_error = true;
            }
        });

        if( required_error && wbls_front.recaptcha_version == "v2i" ) {
            grecaptcha.reset(self.recaptchaWidgetId);
        }

        return required_error;
    }

    wbls_validate_email_fields(that) {
        let form = jQuery(that).closest(".wbls-form");
        form.find(".wbls-field[type='email']").removeClass("wbls-validation-error");
        let validation_error = false;
        form.find(".wbls-field[type='email']").each(function( index ) {
            let email_val = jQuery(this).val();
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if( email_val !== '' && !regex.test(email_val) && jQuery(this).is(":visible") ) {
                jQuery(this).closest(".wblsform-row").addClass("wbls-validation-error");
                validation_error = true;
            } else {
                jQuery(this).closest(".wblsform-row").removeClass("wbls-validation-error");
            }
        });
        return validation_error;
    }

    get_hidden_condition_fields() {
        let self = this;
        let ind = 0;
        jQuery(document).find(".wbls-field").each(function() {
            if( !jQuery(this).is(":visible") ) {
                self.hiddenConditions[ind] = jQuery(this).attr('name');
                ind++;
            }
        })
    }

    wbls_submit_form(that) {
        if( this.wbls_check_required(that) || this.wbls_validate_email_fields(that) ) {
            return;
        }

        let self = this;
        let form = jQuery(that).closest(".wbls-form");
        let form_id = form.attr("id");
        let buttonLabel = jQuery(that).text();
        let security = form.find(".wbls-security").val();
        if( security != "" ) {
            form.find(".wbls-submit-form").removeClass("wbls-button-loading").text(buttonLabel);
            return;
        }
        jQuery(that).empty().addClass("wbls-button-loading");

        var checkbox = form.find("input[type=checkbox]");
        jQuery.each(checkbox, function(key, val) {
            if( jQuery(this).is(':checked') ) {
                jQuery(this).val(1);
            }
        });

        var formData = new FormData(document.getElementById(form_id));
        formData.append('nonce', wbls_front.ajaxnonce);
        formData.append('wbls_security', security);
        this.get_hidden_condition_fields();
        formData.append('wbls_hidden_conditions', this.hiddenConditions);

        jQuery.ajax({
            type: 'POST',
            processData: false,
            contentType: false,
            dataType: "json",
            url: wbls_front.ajax_url,
            data:  formData,
            success: function (response) {
                if( response['success'] && response['data']['token'] != '' ) {
                    jQuery(document).find(".wbls-success-msg").remove();
                    if( response['data']['whistleblower_active'] && response['data']['token'] != '') {
                        let formContainer = jQuery(that).closest(".wbls-front-form-content");
                        if( formContainer.length ) {
                            formContainer.find(".wbls-form-container").hide();
                            formContainer.find(".wbls-token-value").text(response['data']['token']);
                            formContainer.find(".wbls-token-container").show();
                        } else {
                            let msg = "<p class='wbls-success-msg'>" + wbls_front.success_msg +"<br>" + wbls_front.token_msg;
                            msg += "<br><b>Token: <span class='wbls-msg-token'>"+response['data']['token']+"</span></b>";
                            msg += "</p>"
                            jQuery(that).closest(".wbls-form").prepend(msg);
                        }
                    } else if( !response['data']['whistleblower_active'] ) {
                        jQuery(that).closest(".wbls-form").prepend("<p class='wbls-success-msg'>" + wbls_front.success_msg + "</p>");
                        setTimeout(()=> {
                            jQuery(document).find("#" + form_id + " .wbls-success-msg").remove();
                        }, 5000);

                    }
                    document.getElementById(form_id).reset();
                } else if( !response['success'] ) {
                    jQuery(that).closest(".wbls-form").prepend("<p class='wbls-error-msg'>" + wbls_front.error_msg + "</p>");
                    setTimeout(()=> {
                        jQuery(document).find("#" + form_id + " .wbls-error-msg").remove();
                    }, 5000);

                }
            },
            complete: function() {
                form.find(".wbls-submit-form").removeClass("wbls-button-loading").text(buttonLabel);
                jQuery('html, body').scrollTop(form.offset().top-50);
                
                if( wbls_front.recaptcha_active == "1" ) {
                    if( wbls_front.recaptcha_version == "v3" ) {
                        grecaptcha.execute(wbls_front.recaptcha_key, {action: 'submit'}).then(function(token) {
                            // Add the token to the form
                            document.getElementById('recaptchaToken').value = token;
                        });
                    } else {
                        grecaptcha.reset(self.recaptchaWidgetId);
                    }
                }

            },
            error: function (jqXHR, exception) {
                console.log(jqXHR);
            },

        });
    }

    wbls_reply(that) {
        let self = this;
        const form = document.getElementById("wbls-reply-form");
        let security = jQuery(form).find(".wbls-security").val();
        if( security != "" ) {
            return;
        }

        var formData = new FormData(form);
        formData.append('wbls_security', security);
        formData.append('nonce', wbls_front.ajaxnonce);
        formData.append('token', self.token);

        let buttonLabel = jQuery(document).find("#wbls-reply-button").text();
        jQuery(document).find("#wbls-reply-button").empty().addClass("wbls-button-loading");

        jQuery.ajax({
            type: 'POST',
            processData: false,
            contentType: false,
            dataType: "json",
            url: wbls_front.ajax_url,
            data:  formData,
            success: function (response){
                if( !response['success'] ) {
                    jQuery(".wbls-error-msg").text(response['data']['message']).show();
                }
                else if( response['success'] && response['data']['chats'] != '' ) {
                    let data = response['data']['chats'];
                    self.wbls_add_chats( data );
                    jQuery(".wbls-login-container").hide();
                    jQuery(".wbls-chat-container").show();
                    jQuery("#wbls-new-reply").val('');
                    jQuery("#wbls-file-input").val('');
                    jQuery("#imageName").empty();
                }
            },
            complete: function() {
                jQuery(document).find("#wbls-reply-button").removeClass("wbls-button-loading").text(buttonLabel);
            },
            error: function (jqXHR, exception) {
                console.log(jqXHR);
            },

        });
    }

    wbls_add_chats( data ) {
        const h2 = document.createElement("h2");
        h2.textContent = data['subject'];
        let rowDiv = "";
        jQuery('.wbls-chats-section').empty();
        let chatSection = document.getElementsByClassName('wbls-chats-section');
        chatSection[0].appendChild(h2);
        jQuery.each(data['message'], function (index, value) {
            rowDiv = document.createElement("div");
            rowDiv.classList.add('wbls_' + value['role'] + '_row');

            const msgColDiv = document.createElement("div");
            msgColDiv.classList.add('wbls_message_col');

            const roleSpan = document.createElement("span");
            roleSpan.classList.add('wbls_message_role');
            roleSpan.textContent = value['role']+'/'+value['date'];
            msgColDiv.appendChild(roleSpan);


            const msgSpan = document.createElement("span");
            if(value['text'] != '') {
                msgSpan.classList.add('wbls_message');
                msgSpan.textContent = value['text'];
            }

            const dateSpan = document.createElement("span");
            dateSpan.classList.add('wbls_message_date');
            dateSpan.textContent = value['date'];
            msgColDiv.appendChild(msgSpan);
            
               
         
            rowDiv.appendChild(msgColDiv);
            chatSection[0].appendChild(rowDiv);
        });
    }

    wbls_copyToken() {
        // Get the text field
        var copyText = jQuery(document).find(".wbls-token-value").text();

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText);
        jQuery(document).find(".wbls-copy-button .wbls-form-token-copy-tooltip").show();
        setTimeout(() => {
            jQuery(document).find(".wbls-copy-button .wbls-form-token-copy-tooltip").hide();
        }, 500);
    }
}

let wbls_frontend;
jQuery(document).ready(function() {
    wbls_frontend = new WBLS_FRONTEND();
    wbls_frontend.init();
});

