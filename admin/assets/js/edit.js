class WBLS_FIELDS {
    init() {
        this.conditionsOb = new WBLS_CONDITIONS();
        this.registerEvents();

        if( !wbls_edit.fields_options ) {
            this.fields_options = [];
        } else {
            this.fields_options = JSON.parse(JSON.stringify(wbls_edit.fields_options));
            this.reset_field_options_new_keys();
        }
        this.set_field_actions();
        if( !wbls_edit.fieldNameLastId ) {
            this.fieldNameLastId = 0;
        } else {
            this.fieldNameLastId = wbls_edit.fieldNameLastId;
        }
        this.conditions = wbls_edit.form_conditions;

        this.wblsRunDragDrop();
    }

    /* Add new field options to current field options with default value */
    reset_field_options_new_keys() {
        let self = this;
        Object.keys(self.fields_options).forEach(function (key) {
            if( typeof self.fields_options[key] != 'object' ) {
                return;
            }
            let type = self.fields_options[key]['type'];
            Object.keys(wbls_edit.form_fields[type]).forEach(function (key1) {
                if( typeof self.fields_options[key][key1] == "undefined" ) {
                    self.fields_options[key][key1] = wbls_edit.form_fields[type][key1];
                }
            });
        });
    }

    set_field_actions() {
        let actionsTemplate = jQuery("#wbls-template-actions").html();
        jQuery(document).find(".wblsform-row").append(actionsTemplate);
        jQuery(document).find(".wblsform-row-pageTitle").append(actionsTemplate);
    }

    registerEvents() {
        let self = this;
        jQuery(document).off( "click", "#wbls-sidebar-fields-tab")
            .on("click", "#wbls-sidebar-fields-tab", function () {
            jQuery(".wbls-sidebar-tab").removeClass("wbls-sidebar-tab-active");
            jQuery(this).addClass("wbls-sidebar-tab-active");
            jQuery(".wbls-sidebar-field-options-content").hide();
            jQuery(".wbls-sidebar-fields-content").show();
        })

        jQuery(document).off( "click", "#wbls-sidebar-field-options-tab")
            .on("click", "#wbls-sidebar-field-options-tab", function () {
                if( !jQuery(document).find(".wblsform-row-edit-active").length ) {
                    return;
                }
                jQuery(".wbls-sidebar-tab").removeClass("wbls-sidebar-tab-active");
                jQuery(this).addClass("wbls-sidebar-tab-active");
                jQuery(".wbls-sidebar-field-options-content").show();
                jQuery(".wbls-sidebar-fields-content").hide();
        })

        jQuery(document).off( "click", ".wbls-field-item")
            .on("click", ".wbls-field-item", function () {
            if( jQuery(this).attr("data-type") !== "page_break" ) {
                self.add_field(this);
            } else {
                self.wblsAddNewPage( jQuery(document).find(".wbls-add-new-page") );
            }
        })

        jQuery(document).off( "click", ".wbls-add-form").on("click", ".wbls-add-form", function () {
            self.save_form();
        })

        jQuery(document).off( "click", ".wblsform-row:not(.dashicons-trash), .wblsform-row-page:not(.dashicons-trash)")
            .on("click", ".wblsform-row:not(.dashicons-trash), .wblsform-row-page:not(.dashicons-trash)", function () {
                jQuery(document).find(".wblsform-row-edit-active").removeClass("wblsform-row-edit-active")
                jQuery(this).addClass("wblsform-row-edit-active");
            self.edit_field(jQuery(this));
        })

        jQuery(document).off( "click", ".wblsform-actions .dashicons-trash")
            .on("click", ".wblsform-actions .dashicons-trash", function () {

                let template = jQuery(document).find("#wbls-template-alert").html();
                jQuery('body').append(template);
                if( jQuery(this).parents(".wblsform-row-pageTitle").length ) {
                    jQuery(document).find(".wbls-alert-container .wbls-alert-title").text("Are you sure you want to delete this page and all associated fields?");
                } else {
                    jQuery(document).find(".wbls-alert-container .wbls-alert-title").text("Are you sure you want to delete this field?");
                }
                jQuery(this).addClass("wbls-active-delete");

        });

        jQuery(document).off( "click", ".wbls-alert-buttons-delete")
            .on("click", ".wbls-alert-buttons-delete", function () {
                let el = jQuery(document).find(".wbls-active-delete");
                if( el.parents(".wblsform-row-pageTitle").length ) {
                    self.delete_page(el);
                } else {
                    self.delete_field(el);
                }
        });

        jQuery(document).off( "click", ".wbls-alert-buttons-cancel, .wbls-alert-layer")
            .on("click", ".wbls-alert-buttons-cancel, .wbls-alert-layer", function () {
                jQuery(document).find(".wbls-active-delete").removeClass("wbls-active-delete");
                jQuery(document).find(".wbls-alert-layer, .wbls-alert-container").remove();
        });

        jQuery(document).on("input", ".wbls-sidebar-field-options-content .wbls-field-option", function () {
            let current_option = jQuery(this).attr("data-option");
            let val = jQuery(this).val();
            self.fields_options[self.edit_field_id][current_option] = val;

            switch(current_option) {
                case 'label':
                    if( self.fields_options[self.edit_field_id]['type'] == 'submit' ) {
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-submit-form").text(val);
                    } else {
                        if(self.fields_options[self.edit_field_id]['required'] === "1") {
                            jQuery(".wblsform-row[data-field-id='" + self.edit_field_id + "'] .wbls-field-label").text(val+"*");
                        } else {
                            jQuery(".wblsform-row[data-field-id='" + self.edit_field_id + "'] .wbls-field-label").text(val);
                        }
                    }
                    break;
                case 'required':
                    let labelVal = jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-label").text();
                    if(  jQuery(this).val() === "1" ) {
                        labelVal += "*";
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-label").text(labelVal);
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field").prop('required',true);
                    } else {
                        if( labelVal.slice(-1) == "*" ) {
                            labelVal = labelVal.slice(0, -1);
                        }
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-label").text(labelVal);
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field").prop('required',false);
                    }
                    break;
                case 'placeholder':
                    jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] input, .wblsform-row[data-field-id='"+self.edit_field_id+"'] textarea").attr('placeholder', val);
                    break;
                case 'description':
                    jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-description").text(val);
                    break;
                case 'firstNamePlaceholder':
                    jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-firstName input").attr('placeholder', val);
                    break;
                case 'lastNamePlaceholder':
                    jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-lastName input").attr('placeholder', val);
                    break;
                case 'middleNamePlaceholder':
                    jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-middleName input").attr('placeholder', val);
                    break;
                case 'firstNameMiniLabel':
                    jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-firstName .wbls-field-miniLabel").text(val);
                    break;
                case 'lastNameMiniLabel':
                    jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-lastName .wbls-field-miniLabel").text(val);
                    break;
                case 'middleNameMiniLabel':
                    jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-middleName .wbls-field-miniLabel").text(val);
                    break;
                case 'hideMiddleName':
                    if( jQuery(this).val() === "1" ) {
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-middleName").remove();
                    } else {
                        let templ = jQuery(document).find("#wbls-template-middleName").html();
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-firstName").after(templ);
                        let miniLabel = self.fields_options[self.edit_field_id]['middleNameMiniLabel'];
                        let placeholder = self.fields_options[self.edit_field_id]['middleNamePlaceholder'];
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-middleName input").attr('name', self.fields_options[self.edit_field_id]['mname']);
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-middleName input").attr('placeholder', placeholder);
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-middleName .wbls-field-miniLabel").text(miniLabel);
                    }
                    break;
                case 'streetPlaceholder':
                    jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-street input").attr('placeholder', val);
                    break;
                case 'street1Placeholder':
                    jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-street1 input").attr('placeholder', val);
                    break;
                case 'cityPlaceholder':
                    jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-city input").attr('placeholder', val);
                    break;
                case 'statePlaceholder':
                    jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-state input").attr('placeholder', val);
                    break;
                case 'postalPlaceholder':
                    jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-postal input").attr('placeholder', val);
                    break;
                case 'countryPlaceholder':
                    jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-country input").attr('placeholder', val);
                    break;
                case 'streetMiniLabel':
                    jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"']  .wbls-field-street .wbls-field-miniLabel").text(val);
                    break;
                case 'street1MiniLabel':
                    jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"']  .wbls-field-street1 .wbls-field-miniLabel").text(val);
                    break;
                case 'cityMiniLabel':
                    jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"']  .wbls-field-city .wbls-field-miniLabel").text(val);
                    break;
                case 'stateMiniLabel':
                    jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"']  .wbls-field-state .wbls-field-miniLabel").text(val);
                    break;
                case 'postalMiniLabel':
                    jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"']  .wbls-field-postal .wbls-field-miniLabel").text(val);
                    break;
                case 'countryMiniLabel':
                    jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"']  .wbls-field-country .wbls-field-miniLabel").text(val);
                    break;
                case 'hideStreet':
                    if( jQuery(this).val() === "1" ) {
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-street").remove();
                    } else {
                        let templ = jQuery(document).find("#wbls-template-street").html();
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-address-container").prepend(templ);
                        let miniLabel = self.fields_options[self.edit_field_id]['streetMiniLabel'];
                        let placeholder = self.fields_options[self.edit_field_id]['streetPlaceholder'];
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-street input").attr('name', self.fields_options[self.edit_field_id]['streetName']);
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-street input").attr('placeholder', placeholder);
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-street .wbls-field-miniLabel").text(miniLabel);
                    }
                    break;
                case 'hideStreet1':
                    if( jQuery(this).val() === "1" ) {
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-street1").remove();
                    } else {
                        let templ = jQuery(document).find("#wbls-template-street1").html();
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-address-container > div:nth-child(1)").after(templ);
                        let miniLabel = self.fields_options[self.edit_field_id]['street1MiniLabel'];
                        let placeholder = self.fields_options[self.edit_field_id]['street1Placeholder'];
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-street1 input").attr('name', self.fields_options[self.edit_field_id]['street1Name']);
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-street1 input").attr('placeholder', placeholder);
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-street1 .wbls-field-miniLabel").text(miniLabel);
                    }
                    break;
                case 'hideCity':
                    if( jQuery(this).val() === "1" ) {
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-city").remove();
                    } else {
                        let templ = jQuery(document).find("#wbls-template-city").html();
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-address-container .wbls-address-row").eq(0).prepend(templ);
                        let miniLabel = self.fields_options[self.edit_field_id]['cityMiniLabel'];
                        let placeholder = self.fields_options[self.edit_field_id]['cityPlaceholder'];
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-city input").attr('name', self.fields_options[self.edit_field_id]['cityName']);
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-city input").attr('placeholder', placeholder);
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-city .wbls-field-miniLabel").text(miniLabel);
                    }
                    break;
                case 'hideState':
                    if( jQuery(this).val() === "1" ) {
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-state").remove();
                    } else {
                        let templ = jQuery(document).find("#wbls-template-state").html();
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-address-container .wbls-address-row").eq(0).append(templ);
                        let miniLabel = self.fields_options[self.edit_field_id]['stateMiniLabel'];
                        let placeholder = self.fields_options[self.edit_field_id]['statePlaceholder'];
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-state input").attr('name', self.fields_options[self.edit_field_id]['stateName']);
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-state input").attr('placeholder', placeholder);
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-state .wbls-field-miniLabel").text(miniLabel);
                    }
                    break;
                case 'hidePostal':
                    if( jQuery(this).val() === "1" ) {
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-postal").remove();
                    } else {
                        let templ = jQuery(document).find("#wbls-template-postal").html();
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-address-container .wbls-address-row").eq(1).prepend(templ);
                        let miniLabel = self.fields_options[self.edit_field_id]['postalMiniLabel'];
                        let placeholder = self.fields_options[self.edit_field_id]['postalPlaceholder'];
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-postal input").attr('name', self.fields_options[self.edit_field_id]['postalName']);
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-postal input").attr('placeholder', placeholder);
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-postal .wbls-field-miniLabel").text(miniLabel);
                    }
                    break;
                case 'hideCountry':
                    if( jQuery(this).val() === "1" ) {
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-country").remove();
                    } else {
                        let templ = jQuery(document).find("#wbls-template-country").html();
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-address-container .wbls-address-row").eq(1).append(templ);
                        let miniLabel = self.fields_options[self.edit_field_id]['countryMiniLabel'];
                        let placeholder = self.fields_options[self.edit_field_id]['countryPlaceholder'];
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-country input").attr('name', self.fields_options[self.edit_field_id]['countryName']);
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-country input").attr('placeholder', placeholder);
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-country .wbls-field-miniLabel").text(miniLabel);
                    }
                    break;
                case 'multiple':
                    let input = jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] input");
                    let currentName = input.attr('name');  // Get the current name attribute
                    if( jQuery(this).val() === "1" ) {
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field").prop('multiple',true);
                        let newName = currentName + '[]';
                        input.attr('name', newName);
                    } else {
                        jQuery(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field").prop('multiple',false);
                        let newName = currentName.replace("[]", "");
                        input.attr('name', newName);

                    }
                    break;
                case 'next_button_text':
                    jQuery(".wblsform-row-pageButtonNext .wbls-next-button").text(val);
                    break;

                case 'previous_button_text':
                    jQuery(".wblsform-row-pageButtonPrev .wbls-previous-button").text(val);
                    break;

                case 'show_previous':
                    if( jQuery(this).val() === "1" ) {
                        let prevButtonTemplate = jQuery(document).find("#wbls-template-page-previous-button").html();

                        jQuery(document).find(".wblsform-page-and-images").each( function(index) {
                            if ( 0 !== index ) {
                                if( jQuery(this).find(".wblsform-row-pageButtonNextPrev-container").length ) {
                                    jQuery(this).find(".wblsform-row-pageButtonNextPrev-container").prepend(prevButtonTemplate);
                                } else {
                                    let nextPrevContTemplate = jQuery(document).find("#wbls-template-page-next-prev-container").html();
                                    jQuery(this).append(nextPrevContTemplate);
                                    jQuery(this).find(".wblsform-row-pageButtonNextPrev-container").prepend(prevButtonTemplate);
                                }
                                jQuery(this).find(".wblsform-row-pageButtonPrev").attr("data-field-id", self.edit_field_id);
                            }
                        });
                    } else {
                        jQuery(".wblsform-row-pageButtonPrev.wblsform-row-page").remove();
                    }
                    break;
                default:
                // code block
            }
        });

        /* Set new default Selected option */
        jQuery(document).off( "click", ".wbls-sidebar-field-options-content .wbls-select-item-default")
            .on("click", ".wbls-sidebar-field-options-content .wbls-select-item-default", function () {
            let index = jQuery(this).closest(".wbls-select-item").index();
            self.fields_options[self.edit_field_id]['default_option'] = parseInt(index)-1;

        });

        /* Set new value to option */
        jQuery(document).on("input", ".wbls-sidebar-field-options-content .wbls-select-item-value", function () {
            let key = jQuery(this).attr("data-key");
            let val = jQuery(this).val();
            self.fields_options[self.edit_field_id]['options'][key]['key'] = val;
            self.fields_options[self.edit_field_id]['options'][key]['val'] = val;

            jQuery(document).find(".wblsform-row[data-field-id='"+self.edit_field_id+"'] select option")
                .eq(key).text(val).val(val);
        });

        /* Set new value to pageination  title */
        jQuery(document).on("input", ".wbls-sidebar-field-options-content .wbls-page-title-option", function () {
            let key = jQuery(this).attr("data-key");
            let val = jQuery(this).val();
            self.fields_options[self.edit_field_id]['pageTitles'][key]['title'] = val;

            jQuery(document).find(".wblsform-page-and-images").eq(key).find(".wbls-form-page-title").text(val);
        });


        /* Set new default Selected option */
        jQuery(document).off( "click", ".wbls-sidebar-field-options-content .wbls-add-select-item")
            .on("click", ".wbls-sidebar-field-options-content .wbls-add-select-item", function () {
            let index = jQuery(this).closest(".wbls-select-item").index();
            self.fields_options[self.edit_field_id]['options'].splice(index, 0, {'key':'', 'val' : '', 'order' : index});
            let option_template = jQuery("#wbls-template-field-select").html();
            jQuery(document).find(".wbls-select-item").eq((index-1)).after(option_template);
            jQuery(document).find(".wbls-select-item").eq((index)).find(".wbls-select-item-value").attr("data-key", index);

            jQuery(document).find(".wblsform-row[data-field-id='"+self.edit_field_id+"'] select option")
                .eq((index-1)).after('<option value=""></option>');
        });

        /* Set new default Selected option */
        jQuery(document).off( "click", ".wbls-sidebar-field-options-content .wbls-remove-select-item")
            .on("click", ".wbls-sidebar-field-options-content .wbls-remove-select-item", function () {
            let index = jQuery(this).closest(".wbls-select-item").index();
            self.fields_options[self.edit_field_id]['options'].splice((index-1), 1);
            jQuery(document).find(".wbls-select-item").eq((index-1)).remove();
            jQuery(document).find(".wblsform-row[data-field-id='"+self.edit_field_id+"'] select option")
                .eq((index-1)).remove();
        });

        /* Radio field events */

        /* Set new default Radio option */
        jQuery(document).off( "click", ".wbls-sidebar-field-options-content .wbls-radio-item-default")
            .on("click", ".wbls-sidebar-field-options-content .wbls-radio-item-default", function () {
            let index = jQuery(this).closest(".wbls-radio-item").index();
            let el = jQuery(document).find(".wblsform-row[data-field-id='"+self.edit_field_id+"'] input").eq((index-1));
            jQuery(document).find(".wblsform-row[data-field-id='"+self.edit_field_id+"'] input").removeAttr("checked");
            if( self.fields_options[self.edit_field_id]['default_option'] === (parseInt(index)-1) ) {
                self.fields_options[self.edit_field_id]['default_option'] = '';
                jQuery(this).prop("checked", false);
                el.prop("checked", false);
                el.removeAttr("checked");
            } else {
                self.fields_options[self.edit_field_id]['default_option'] = parseInt(index) - 1;
                el.prop("checked", true);
                el.attr("checked", "checked");
            }
        });

        /* Set new value to option */
        jQuery(document).on("input", ".wbls-sidebar-field-options-content .wbls-radio-item-value", function () {
            let key = jQuery(this).attr("data-key");
            let val = jQuery(this).val();
            self.fields_options[self.edit_field_id]['options'][key]['key'] = val;
            self.fields_options[self.edit_field_id]['options'][key]['val'] = val;

            let inputVal = val.replace(/(<([^>]+)>)/gi, "");
            jQuery(document).find(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-row-radio")
                .eq(key).find("input").val(inputVal);
            jQuery(document).find(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-row-radio")
                .eq(key).find("label").html(val);
        });

        jQuery(document).on("change", ".wbls-sidebar-field-options-content .wbls-radio-item-value", function () {
            let key = jQuery(this).attr("data-key");
            let val = jQuery(this).val();
        });

        /* Set new default Selected option */
        jQuery(document).off( "click", ".wbls-sidebar-field-options-content .wbls-add-radio-item")
            .on("click", ".wbls-sidebar-field-options-content .wbls-add-radio-item", function () {
            let index = jQuery(this).closest(".wbls-radio-item").index();
            self.fields_options[self.edit_field_id]['options'].splice(index, 0, {'key':'', 'val' : '', 'order' : index});
            let name = self.fields_options[self.edit_field_id]['name'];
            let option_template = jQuery("#wbls-template-field-radio").html();
            jQuery(document).find(".wbls-radio-item").eq((index-1)).after(option_template);
            let ind = 0;
            jQuery(document).find(".wbls-radio-item").each(function () {
                jQuery(this).find(".wbls-radio-item-value").attr("data-key", ind);
                ind++;
            });
            let radio_single_template = jQuery("#wbls-template-radio-single").html();
            jQuery(document).find(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-row-radio")
                .eq((index-1)).after(radio_single_template);
            jQuery(document).find(".wbls-field-row-radio-new .wbls-field").attr("name", name).removeClass("wbls-field-row-radio-new");
        });


        /* Set new default Selected option */
        jQuery(document).off( "click", ".wbls-sidebar-field-options-content .wbls-remove-radio-item")
            .on("click", ".wbls-sidebar-field-options-content .wbls-remove-radio-item", function () {
            let index = jQuery(this).closest(".wbls-radio-item").index();
            self.fields_options[self.edit_field_id]['options'].splice((index-1), 1);
            jQuery(document).find(".wbls-radio-item").eq((index-1)).remove();
            jQuery(document).find(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-row-radio")
                .eq((index-1)).remove();
        });
        /* End radio */

        /* Start checkbox */
        /* Set new default Checkbox option */
        jQuery(document).off( "click", ".wbls-sidebar-field-options-content .wbls-add-checkbox-item")
            .on("click", ".wbls-sidebar-field-options-content .wbls-add-checkbox-item", function () {
            let index = jQuery(this).closest(".wbls-checkbox-item").index();

            let new_name = 'wbls_field_' + self.fieldNameLastId;
            self.fields_options[self.edit_field_id]['options'].splice(index, 0, {'miniLabel':'New choice', 'name' : new_name, 'checked' : 0, 'order' : index});
            let option_template = jQuery("#wbls-template-field-checkbox").html();
            jQuery(document).find(".wbls-checkbox-item").eq((index-1)).after(option_template);
            let ind = 0;
            jQuery(document).find(".wbls-checkbox-item").each(function () {
                jQuery(this).find(".wbls-checkbox-item-value").attr("data-key", ind);
                ind++;
            });

            let checkbox_single_template = jQuery("#wbls-template-checkbox-single").html();
            jQuery(document).find(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-row-checkbox")
                .eq((index-1)).after(checkbox_single_template);

            jQuery(document).find(".wblsform-row .wbls-field-row-checkbox-new input").attr("name", new_name);
            jQuery(document).find(".wblsform-row .wbls-field-row-checkbox-new").removeClass("wbls-field-row-checkbox-new");
            self.fieldNameLastId = parseInt(self.fieldNameLastId) + 1;
        });

        /* Remove checkbox item */
        jQuery(document).off( "click", ".wbls-sidebar-field-options-content .wbls-remove-checkbox-item")
            .on("click", ".wbls-sidebar-field-options-content .wbls-remove-checkbox-item", function () {
            let index = jQuery(this).closest(".wbls-checkbox-item").index();
            self.fields_options[self.edit_field_id]['options'].splice((index-1), 1);
            jQuery(document).find(".wbls-checkbox-item").eq((index-1)).remove();
            jQuery(document).find(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-row-checkbox")
                .eq((index-1)).remove();
        });

        /* Set new value to option */
        jQuery(document).on("input", ".wbls-sidebar-field-options-content .wbls-checkbox-item-value", function () {
            let key = jQuery(this).attr("data-key");
            let val = jQuery(this).val();
            //self.fields_options[self.edit_field_id]['options'][key]['key'] = val;
            self.fields_options[self.edit_field_id]['options'][key]['miniLabel'] = val;

            let inputVal = val.replace(/(<([^>]+)>)/gi, "");
            jQuery(document).find(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-row-checkbox")
                .eq(key).find("input").val(inputVal);
            jQuery(document).find(".wblsform-row[data-field-id='"+self.edit_field_id+"'] .wbls-field-row-checkbox")
                .eq(key).find("label").html(val);
        });

        /* Set default Checked option */
        jQuery(document).off( "click", ".wbls-sidebar-field-options-content .wbls-checkbox-item-default")
            .on("click", ".wbls-sidebar-field-options-content .wbls-checkbox-item-default", function () {
            let index = jQuery(this).closest(".wbls-checkbox-item").index();
            let el = jQuery(document).find(".wblsform-row[data-field-id='"+self.edit_field_id+"'] input").eq((index-1));
            if( self.fields_options[self.edit_field_id]['options'][(parseInt(index) - 1)]['checked'] == 1 ) {
                self.fields_options[self.edit_field_id]['options'][(parseInt(index) - 1)]['checked'] = 0;
                jQuery(this).prop("checked", false);
                el.prop("checked", false);
                el.val(0);
                el.removeAttr("checked");
            } else {
                self.fields_options[self.edit_field_id]['options'][(parseInt(index) - 1)]['checked'] = 1;
                el.prop("checked", true);
                el.val(1);
                el.attr("checked", "checked");
            }
        });
        /* End Checkbox field events */

        /* Recaptcha version change */
        jQuery(document).off( "click", ".wbls-recaptcha-version").on("click", ".wbls-recaptcha-version", function () {
            let val = jQuery(this).val();
            self.fields_options[self.edit_field_id]['version'] = val;
        });
        /* End Recaptcha version change */

        /* Form edit page menu item click */
        jQuery(document).off( "click", ".wbls-form-menu-item")
            .on("click", ".wbls-form-menu-item", function () {
            let content = jQuery(this).attr("data-content");
            jQuery(".wbls-form-menu-item").removeClass("wbls-form-menu-item-active");
            jQuery(this).addClass("wbls-form-menu-item-active");
            jQuery(".wbls-form-menu-item-content").hide();
            jQuery(".wbls-sidebar-menu").hide();
            jQuery("#"+content).show();
            jQuery("#"+content+"-sidebar").show();
            jQuery("#"+content+"-sidebar").find(".wbls-sidebar-menu-item-active").trigger("click");
        });

        /* Form edit page sidebar menu item click */
        jQuery(document).off( "click", ".wbls-sidebar-menu-item")
            .on("click", ".wbls-sidebar-menu-item", function () {
            let content = jQuery(this).attr("id");
            jQuery(this).closest(".wbls-sidebar-menu").find(".wbls-sidebar-menu-item").removeClass("wbls-sidebar-menu-item-active");
            jQuery(this).addClass("wbls-sidebar-menu-item-active");
            jQuery(".wbls-sidebar-menu-item-content").hide();
            jQuery("."+content).show();
        })

        jQuery(document).off( "click", ".wbls-field-placeholder").on("click", ".wbls-field-placeholder", function() {
            self.wbls_set_email_placeholder(this);
        });

        jQuery(document).off( "click", ".wbls-embed-form").on("click", ".wbls-embed-form", function () {
            jQuery(document).find(".wbls-shortcode-layer, .wbls-shortcode-popup").show()
        })

        jQuery(document).off( "click", ".wbls-shortcode-layer").on("click", ".wbls-shortcode-layer", function () {
            jQuery(document).find(".wbls-shortcode-layer, .wbls-shortcode-popup").hide()
        })

        jQuery(document).off( "click", "#wbls-shortcode-copy, #wbls-form-shortcode-copy, #wbls-reply-shortcode-copy")
            .on("click", "#wbls-shortcode-copy, #wbls-form-shortcode-copy, #wbls-reply-shortcode-copy", function () {
            let text = jQuery(this).closest(".wbls-shortcode-popup-row").find(".wbls-form-shortcode").val();
            navigator.clipboard.writeText(text);
            jQuery(this).find(".wbls-form-shortcode-copy-tooltip").show();
            setTimeout(() => {
                jQuery(this).find(".wbls-form-shortcode-copy-tooltip").hide();
            }, 500);
        })

        jQuery('.wbls-file-types').select2({
            width: '100%',
            minimumInputLength: 0  // Ensures dropdown opens without needing typing
        });

        jQuery(document).off( "click", ".wbls-tabs-menu-item").on("click", ".wbls-tabs-menu-item", function () {
            let id = jQuery(this).attr("id");
            jQuery(document).find(".wbls-tabs-menu-item").removeClass("wbls-tabs-menu-item-active");
            jQuery(this).addClass("wbls-tabs-menu-item-active");
            jQuery(document).find(".wbls-editor-menu-content").hide();
            jQuery(document).find("." + id).show()
        })

    }

    wblsAddNewPage(that) {}

    wblsRunDragDrop() {
        jQuery(document).find(".wblsform_column").sortable({
            connectWith: ".wblsform_column", // Allow sorting between elements with the class "parent"
            revert: true, // Animation when items revert
        }).disableSelection(); // Prevent text selection during drag
    }

    wbls_set_email_placeholder(that) {
        let field_id = jQuery(that).attr("data-field-id");
        let field_label = jQuery(that).text();
        let content = '';
        if( jQuery(that).closest(".wbls_user_email_options").length == 0 ) {
            if (jQuery(that).closest(".wbls-email-placeholder-row").hasClass("wbls-subject-field")) {
                content = jQuery("#mail_subject").val() + " {" + field_label + "}";
                jQuery("#mail_subject").val(content);
            } else {
                if( wbls_edit.teeny_active == "1" ) {
                    content = self.getEditorContent("wbls_mail_body");
                    tinymce.get("wbls_mail_body").setContent(content + " {" + field_label + "}");
                } else {
                    content = jQuery(document).find("#wbls_mail_body").val();
                    jQuery(document).find("#wbls_mail_body").val(content + " {" + field_label + "}");
                }
            }
        } else {
            if (jQuery(that).closest(".wbls-email-placeholder-row").hasClass("wbls-subject-field")) {
                content = jQuery("#wbls_user_mail_subject").val() + " {" + field_label + "}";
                jQuery("#wbls_user_mail_subject").val(content);
            } else {
                if( wbls_edit.teeny_active == "1" ) {
                    let content = self.getEditorContent("wbls_user_mail_body");
                    tinymce.get("wbls_user_mail_body").setContent(content + " {" + field_label + "}");
                } else {
                    content = jQuery(document).find("#wbls_user_mail_body").val();
                    jQuery(document).find("#wbls_user_mail_body").val(content + " {" + field_label + "}");
                }
            }
        }
    }

    edit_field(that) {
        if ( jQuery(that).parents('.wblsform-row-page').length > 0 ) {
            this.edit_field_id = jQuery(that).attr("data-field-id");
        } else {
            this.edit_field_id = jQuery(that).attr("data-field-id");
        }
        let field = this.fields_options[this.edit_field_id];
        if( field['pro'] == "1" && !wbls_edit.pro ) {
            return false;
        }
        let field_options_content = jQuery(".wbls-sidebar-field-options-content");
        field_options_content.attr("data-field-id", parseInt(this.edit_field_id));

        let default_template = jQuery("#wbls-template-field-default").html();
        field_options_content.empty().append(default_template);

        let values = this.fields_options[this.edit_field_id];
        switch (values['type']) {
            case 'select':
                this.edit_select_field(values);
                break;
            case 'radio':
                this.edit_radio_field(values);
                break;
            case 'submit':
                this.remove_field_option_html(".wbls-field-option-placeholder");
                this.remove_field_option_html(".wbls-field-option-description");
                this.remove_field_option_html(".wbls-field-option-required");
                break;
            case 'checkbox':
                this.edit_checkbox_field(values);
                break;
            case 'file':
                this.remove_field_option_html(".wbls-field-option-placeholder");
                let multiple_template = jQuery("#wbls-template-field-file").html();
                field_options_content.find(".wbls-editor-general").append(multiple_template);
                break;
            case 'fullName':
                this.remove_field_option_html(".wbls-field-option-placeholder");
                let name_template = jQuery("#wbls-template-fullName-options").html();
                field_options_content.find(".wbls-editor-general").append(name_template);
                break;
            case 'address':
                this.remove_field_option_html(".wbls-field-option-placeholder");
                let address_template = jQuery("#wbls-template-address-options").html();
                field_options_content.find(".wbls-editor-general").append(address_template);
                break;
            case 'recaptcha':
                this.edit_recaptcha_field(values, field_options_content);
                break;
            case 'page_break':
                this.remove_field_option_html(".wbls-field-option-label");
                this.remove_field_option_html(".wbls-field-option-placeholder");
                this.remove_field_option_html(".wbls-field-option-description");
                this.remove_field_option_html(".wbls-field-option-required");
                this.edit_page_break_field(values);
                break;
        }

        Object.keys(values).forEach(function (key){
            if( key == 'required' ) {
                field_options_content.find(".wbls-field-option-"+key+"[value='"+values[key]+"']").prop( "checked", true );
            }
            else if( key == 'hideMiddleName' ) {
                field_options_content.find(".wbls-field-option-"+key+"[value='"+values[key]+"']").prop( "checked", true );
            }
            else if( key == 'hideStreet' ) {
                field_options_content.find(".wbls-field-option-"+key+"[value='"+values[key]+"']").prop( "checked", true );
            }
            else if( key == 'hideStreet1' ) {
                field_options_content.find(".wbls-field-option-"+key+"[value='"+values[key]+"']").prop( "checked", true );
            }
            else if( key == 'hideCity' ) {
                field_options_content.find(".wbls-field-option-"+key+"[value='"+values[key]+"']").prop( "checked", true );
            }
            else if( key == 'hideState' ) {
                field_options_content.find(".wbls-field-option-"+key+"[value='"+values[key]+"']").prop( "checked", true );
            }
            else if( key == 'hidePostal' ) {
                field_options_content.find(".wbls-field-option-"+key+"[value='"+values[key]+"']").prop( "checked", true );
            }
            else if( key == 'hideCountry' ) {
                field_options_content.find(".wbls-field-option-"+key+"[value='"+values[key]+"']").prop( "checked", true );
            }
            else if( key == 'multiple' ) {
                field_options_content.find(".wbls-field-option-"+key+"[value='"+values[key]+"']").prop( "checked", true );
            }
            else if( key == 'show_previous' ) {
                field_options_content.find(".wbls-field-option-"+key+"[value='"+values[key]+"']").prop( "checked", true );
            }
            else {
                field_options_content.find(".wbls-field-option[data-option='" + key + "']").val(values[key]);
            }
        });

        jQuery(".wbls-sidebar-tabs #wbls-sidebar-field-options-tab").trigger("click");
        this.conditionsOb.init(this.edit_field_id);
    }

    edit_page_break_field( field_options ) {
        let pageTitles = field_options['pageTitles'];
        let field_options_content = jQuery(".wbls-sidebar-field-options-content");
        jQuery("#wbls-editor-conditions").remove();
        let page_break_template = jQuery("#wbls-template-field-newPage").html();
        field_options_content.find(".wbls-editor-general").append(page_break_template);
        let pageText = ['First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth', 'Seventh', 'Eighth', 'Ninth'];
        let pagesCount = jQuery(document).find(".wblsform-page-and-images").length;
        let title = '';
        let className = '';
        for( let i = 0; i < pagesCount; i++ ) {
            let template = jQuery("#wbls-template-field-page-title").html();
            jQuery(document).find(".wbls-sidebar .wbls-field-option-group").append(template);

            title = pageText[i] + " Page Title";
            className = title.replaceAll(" ", '-');
            className = className.toLowerCase();
            jQuery(document).find(".wbls-sidebar .wbls-field-option-group .wbls-field-option-row-empty label").text(title);
            if( typeof pageTitles[i] !== 'undefined' ) {
                jQuery(document).find(".wbls-sidebar .wbls-field-option-group .wbls-field-option-row-empty input").val(pageTitles[i]['title']);
            }
            jQuery(document).find(".wbls-sidebar .wbls-field-option-group .wbls-field-option-row-empty input").attr("data-key", i);
            jQuery(document).find(".wbls-sidebar .wbls-field-option-group .wbls-field-option-row-empty").removeClass("wbls-field-option-row-empty");
        }

    }

    delete_page(that) {
        let self = this;
        let field_id = jQuery(that).closest(".wblsform-row-pageTitle").attr("data-field-id");
        let page = jQuery(that).closest(".wblsform-page-and-images");
        let pageIndex= page.index();
        let pageCount= jQuery('.wblsform-page-and-images').length;
        let lastPage = jQuery('.wblsform-page-and-images').not(page).last();

        /* This case delete all Page titles as there will be only one page*/
        if( pageCount == 2 ) {
            delete this.fields_options[field_id];
            jQuery(document).find(".wblsform-row-pageTitle").remove();
            jQuery(document).find(".wblsform-row-pageButtonNextPrev-container").remove();
        } else {
            delete this.fields_options[field_id]['pageTitles'][pageIndex];
        }

        /* Foreach on all fields in the page */
        page.find(".wblsform-row").each(function() {
            /* If page has submit button, submit button move to last page */
            if( jQuery(this).hasClass("wblsform-row-submit") ) {
                if( lastPage.find(".wblsform-row-pageButtonNextPrev-container").length ) {
                    lastPage.find(".wblsform-row-pageButtonNextPrev-container").before(jQuery(this));
                    lastPage.find(".wblsform-row-pageButtonNextPrev-container").before(lastPage.find(".wblsform-row-pageButtonPrev"));
                    lastPage.find(".wblsform-row-pageButtonNextPrev-container").remove();
                } else if( page.find(".wblsform-row-pageButtonPrev").length ) {
                    lastPage.find(".wblsform-row-pageButtonPrev").before(jQuery(this));
                } else {
                    lastPage.append(jQuery(this));
                }
            } else {
                self.delete_field(jQuery(this).find(".wblsform-actions"));
            }
        });

        jQuery('.wblsform-page-and-images').not(page).last().find(".wblsform-row-pageButtonNext").remove();
        jQuery('.wblsform-page-and-images').not(page).first().find(".wblsform-row-pageButtonPrev").remove();

        page.remove();
    }

    delete_field(that){
        let delete_field_id = jQuery(that).closest(".wblsform-row").attr("data-field-id");
        delete this.fields_options[delete_field_id];
        if( typeof this.conditionsOb.conditions == 'undefined' ) {
            delete this.conditions[delete_field_id];
        } else {
            delete this.conditionsOb.conditions[delete_field_id];
        }

        jQuery(document).find(".wblsform-row[data-field-id="+delete_field_id+"]").remove();
        jQuery(document).find("#wbls-sidebar-fields-tab").trigger("click");
    }

    remove_field_option_html(className) {
        jQuery(document).find(className).closest(".wbls-field-option-row").remove();
    }

    edit_select_field( field_options ){
        let empty_row_template = jQuery("#wbls-template-empty-row").html();
        let option_template = jQuery("#wbls-template-field-select").html();
        let option_items = field_options['options'];
        let default_option_index = this.fields_options[this.edit_field_id]['default_option'];

        /* No need placeholder row for Select field */
        this.remove_field_option_html(".wbls-field-option-placeholder");
        jQuery(document).find(".wbls-field-option-label").closest(".wbls-field-option-row").after(empty_row_template);
        let select_row_div = jQuery(document).find(".wbls-field-option-row-empty");
        select_row_div.find('label').text('Choices')
        Object.keys(option_items).forEach(function (key){
            select_row_div.append(option_template);
            jQuery(document).find(".wbls-select-new-item input[name='option_value']").attr('data-key', key);
            jQuery(document).find(".wbls-select-new-item input[name='option_value']").val(option_items[key]['val']);
            jQuery(document).find(".wbls-select-new-item").removeClass("wbls-select-new-item");
        });
        jQuery(document).find( ".wbls-select-item:eq( "+default_option_index+" ) .wbls-select-item-default").prop( "checked", true );
        select_row_div.removeClass("wbls-field-option-row-empty");
    }

    edit_radio_field( field_options ){
        let empty_row_template = jQuery("#wbls-template-empty-row").html();
        let option_template = jQuery("#wbls-template-field-radio").html();
        let option_items = field_options['options'];
        let default_option_index = field_options['default_option'];

        /* No need placeholder row for Select field */
        this.remove_field_option_html(".wbls-field-option-placeholder");
        jQuery(document).find(".wbls-field-option-label").closest(".wbls-field-option-row").after(empty_row_template);
        let radio_row_div = jQuery(document).find(".wbls-field-option-row-empty");
        radio_row_div.find('label').text('Choices')
        Object.keys(option_items).forEach(function (key){
            radio_row_div.append(option_template);
            jQuery(document).find(".wbls-radio-new-item input[name='option_value']").attr('data-key', key);
            jQuery(document).find(".wbls-radio-new-item input[name='option_value']").val(option_items[key]['val']);
            jQuery(document).find(".wbls-radio-new-item").removeClass("wbls-radio-new-item");
        });
        if( default_option_index !== "" ) {
            jQuery(document).find(".wbls-radio-item:eq( " + default_option_index + " ) .wbls-radio-item-default").prop("checked", true);
        }
        radio_row_div.removeClass("wbls-field-option-row-empty");
    }

    edit_checkbox_field( field_options ){
        let empty_row_template = jQuery("#wbls-template-empty-row").html();
        let option_template = jQuery("#wbls-template-field-checkbox").html();
        let option_items = field_options['options'];

        /* No need placeholder row for Checkbox field */
        this.remove_field_option_html(".wbls-field-option-placeholder");
        jQuery(document).find(".wbls-field-option-label").closest(".wbls-field-option-row").after(empty_row_template);
        let checkbox_row_div = jQuery(document).find(".wbls-field-option-row-empty");
        checkbox_row_div.find('label').text('Choices')
        Object.keys(option_items).forEach(function (key){
            checkbox_row_div.append(option_template);
            jQuery(document).find(".wbls-checkbox-new-item input[name='option_value']").attr('data-key', key);
            jQuery(document).find(".wbls-checkbox-new-item input[name='option_value']").val(option_items[key]['miniLabel']);
            if( option_items[key]['checked'] == 1 ) {
                jQuery(document).find(".wbls-checkbox-new-item input[name='option_default']").prop('checked', true);
            }
            jQuery(document).find(".wbls-checkbox-new-item").removeClass("wbls-checkbox-new-item");
        });
        checkbox_row_div.removeClass("wbls-field-option-row-empty");
    }

    edit_recaptcha_field( field_options, field_options_content ) {
        let recaptcha_version = field_options['version'];
        let recaptcha_visible = field_options['visible'];
        jQuery("#wbls-editor-conditions").hide();
        this.remove_field_option_html(".wbls-field-option-placeholder");
        this.remove_field_option_html(".wbls-field-option-description");
        this.remove_field_option_html(".wbls-field-option-radio-row");
        this.remove_field_option_html(".wbls-field-option-label");
        let recaptcha_template = jQuery("#wbls-template-field-recaptcha").html();
        field_options_content.find(".wbls-editor-general").append(recaptcha_template);

        jQuery(document).find(".wbls-recaptcha-version[value='" + recaptcha_version + "']").prop('checked', true);
    }

    getEditorContent(editorID) {
        if ( typeof tinymce !== 'undefined' && tinymce.get(editorID) && !tinymce.get(editorID).isHidden() ) {
            // TinyMCE is active and Visual tab is selected
            return tinymce.get(editorID).getContent();
        } else {
            // TinyMCE is not active (Text tab is selected), fallback to textarea
            let textarea = document.getElementById(editorID);
            return textarea ? textarea.value : '';
        }
    }

    save_form() {
        let self = this;
        jQuery("#wbls-take").find(".wblsform-actions").remove();

        let form = jQuery("#wbls-take").html();
        form = form.replaceAll("<div class=\"wbls-add-new-page\">Add New Page</div>", "");
        form = form.replaceAll(" ui-sortable-handle", "");
        form = form.replaceAll(" ui-sortable", "");
        form = form.replace(/[\t ]+\</g, "<");
        form = form.replace(/\>[\t ]+\</g, "><");
        form = form.replace(/\n/g, "");
        let form_id = jQuery("#wbls-take").attr('data-id');
        let data = {};
        data['email_options'] = {};
        data['form_settings'] = {};
        data['action'] = "wbls_admin_ajax";
        data['task'] = "wbls_add_form";
        data['nonce'] = wbls_edit.ajaxnonce;
        data['form_title'] = jQuery("#wbls-form-title").val();
        data['form_id'] = form_id;
        data['form'] = form;
        data['fieldNameLastId'] = this.fieldNameLastId;
        data['field_options'] = this.fields_options;
        data['form_settings']['whistleblower_active'] = 0;
        if ( jQuery(".wbls-whistleblower-active").prop( "checked" ) ) {
            data['form_settings']['whistleblower_active'] = 1;
        }
        data['form_settings']['new_case'] = jQuery(document).find(".wbls-new_case-button").val();
        data['form_settings']['follow_case'] = jQuery(document).find(".wbls-follow_case-button").val();
        data['form_settings']['login_case'] = jQuery(document).find(".wbls-login_case-button").val();
        data['form_settings']['copy_token'] = jQuery(document).find(".wbls-copy_token-button").val();
        data['form_settings']['reply_button'] = jQuery(document).find(".wbls-reply_button").val();
        data['form_settings']['success_message'] = jQuery(document).find(".wbls-success-message").val();
        data['form_settings']['success_message_copy_token'] = jQuery(document).find(".wbls-success-message-copy-token").val();
        data['form_settings']['error_message'] = jQuery(document).find(".wbls-error-message").val();
        data['form_settings']['active_theme'] = jQuery(document).find(".wbls-active-theme").val();
        data['form_settings']['file_max_size'] = jQuery(document).find(".wbls-file-max-size").val();
        data['form_settings']['file_types'] = jQuery(document).find(".wbls-file-types").val();

        data['form_settings']['show_form_header'] = jQuery(document).find(".wbls-show-form-header:checked").val();
        data['form_settings']['show_token_header'] = jQuery(document).find(".wbls-show-token-header:checked").val();
        data['form_settings']['show_login_header'] = jQuery(document).find(".wbls-show-login-header:checked").val();

        if( jQuery(document).find(".wbls-form-header").length ) {
            data['form_settings']['form_header'] = jQuery(document).find(".wbls-form-header").val();
        } else {
            if( wbls_edit.teeny_active == "1" ) {
                data['form_settings']['form_header'] = self.getEditorContent("wbls_form_header");
            } else {
                data['form_settings']['form_header'] = jQuery(document).find("#wbls_form_header").val();
            }
        }

        if( jQuery(document).find(".wbls-token-header").length ) {
            data['form_settings']['token_header'] = jQuery(document).find(".wbls-token-header").val();
        } else {
            if( wbls_edit.teeny_active == "1" ) {
                data['form_settings']['token_header'] = self.getEditorContent("wbls_token_header");
            } else {
                data['form_settings']['token_header'] = jQuery(document).find("#wbls_token_header").val();
            }
        }

        if( jQuery(document).find(".wbls-login-header").length ) {
            data['form_settings']['login_header'] = jQuery(document).find(".wbls-login-header").val();
        } else {
            if( wbls_edit.teeny_active == "1" ) {
                data['form_settings']['login_header'] = self.getEditorContent("wbls_login_header");
            } else {
                data['form_settings']['login_header'] = jQuery(document).find("#wbls_login_header").val();
            }


        }
        if( typeof this.conditionsOb.conditions == 'undefined' ) {
            data['form_conditions'] = this.conditions;
        } else {
            data['form_conditions'] = this.conditionsOb.conditions;
        }

        let wbls_sendemail = jQuery(".wbls_sendemail:checked").val();
        let admin_mail = jQuery("#mail").val();
        data['email_options']['sendemail'] = parseInt(wbls_sendemail);
        data['email_options']['admin_mail'] = admin_mail;

        jQuery(".wbls-add-form").addClass("wbls-save-loading");

        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data:  data,
            success: function (response) {
                if( !response['success'] ) {
                   // jQuery(".wbls-notice").removeClass("wbls-notice-success").addClass("wbls-notice-error").text(response['data']['message']).show();
                }
                else if( response['success'] ) {
                    if( response['data']['reload_url'] && response['data']['reload_url'] != '' ) {
                        location.replace(response['data']['reload_url']);
                    }
                    jQuery("#wbls-take").attr('data-id', response['data']['form_id']);
                }
            },
            complete: function() {
                jQuery(".wbls-add-form").removeClass("wbls-save-loading");
                self.set_field_actions();
                //jQuery(".wbls-save-form").removeClass("wbls-button-loading").text(buttonLabel);
            },
            error: function (jqXHR, exception) {
            },

        });
    }

    add_field(that) {
        let field_type = jQuery(that).attr("data-type");
        let field_args = JSON.parse(JSON.stringify(wbls_edit.form_fields[field_type]));
        if( field_args['pro'] && !wbls_edit.pro ) {
            return false;
        }
        let fieldTemplate = jQuery("#wbls-template-"+field_type).html();
        let actionsTemplate = jQuery("#wbls-template-actions").html();

        let field_id = this.fieldNameLastId;
        this.fields_options[field_id] = field_args;

        if( field_type == "fullName" ) {
            this.fields_options[field_id]['name'] = 'wbls_field_' + this.fieldNameLastId;
            this.fields_options[field_id]['fname'] = 'wbls_field_' + this.fieldNameLastId + '_f';
            this.fields_options[field_id]['mname'] = 'wbls_field_' + this.fieldNameLastId + '_m';
            this.fields_options[field_id]['lname'] = 'wbls_field_' + this.fieldNameLastId + '_l';
        }
        else if( field_type == "address" ) {
            this.fields_options[field_id]['name'] = 'wbls_field_' + this.fieldNameLastId;
            this.fields_options[field_id]['streetName'] = 'wbls_field_' + this.fieldNameLastId + '_street';
            this.fields_options[field_id]['street1Name'] = 'wbls_field_' + this.fieldNameLastId + '_street1';
            this.fields_options[field_id]['cityName'] = 'wbls_field_' + this.fieldNameLastId + '_city';
            this.fields_options[field_id]['stateName'] = 'wbls_field_' + this.fieldNameLastId + '_state';
            this.fields_options[field_id]['postalName'] = 'wbls_field_' + this.fieldNameLastId + '_postal';
            this.fields_options[field_id]['countryName'] = 'wbls_field_' + this.fieldNameLastId + '_country';
        }
        else if( field_type == "checkbox" ) {
            this.fields_options[field_id]['options'][0]['name'] = 'wbls_field_' + this.fieldNameLastId;
        }
        else if( field_type == "recaptcha" ) {
            if( jQuery(document).find("#wbls-grecaptcha").length ) {
                alert("You already have reCAPTCHA field in the form.");
                return;
            } else if( wbls_edit.recaptcha_active == '0' ) {
                alert("Please set the reCAPTCHA keys from the plugin's 'Settings' menu.");
                return;
            }
        }
        else if( field_type != "submit" ) {
            this.fields_options[field_id]['name'] = 'wbls_field_' + this.fieldNameLastId;
        }
        fieldTemplate = fieldTemplate.replace('data-field-id=""', 'data-field-id="'+field_id+'"');
        if( jQuery(".wblsform-page-and-images:last .wblsform_column-active .wblsform-row-submit").length ) {
            jQuery(".wblsform-page-and-images:last .wblsform_column-active .wblsform-row-submit").before(fieldTemplate.trim());
        } else {
            jQuery(".wblsform-page-and-images:last .wblsform_column-active").append(fieldTemplate.trim());
        }
        jQuery(document).find(".wblsform-row-new[data-field-id="+field_id+"]").append(actionsTemplate);
        if( field_type == 'fullName' ) {
            jQuery(document).find(".wblsform-row-new .wbls-field-firstName .wbls-field").attr("name", this.fields_options[field_id]['fname']);
            jQuery(document).find(".wblsform-row-new .wbls-field-middleName .wbls-field").attr("name", this.fields_options[field_id]['mname']);
            jQuery(document).find(".wblsform-row-new .wbls-field-lastName .wbls-field").attr("name", this.fields_options[field_id]['lname']);
        } else if( field_type == 'address' ) {
            jQuery(document).find(".wblsform-row-new .wbls-field-street .wbls-field").attr("name", this.fields_options[field_id]['streetName']);
            jQuery(document).find(".wblsform-row-new .wbls-field-street1 .wbls-field").attr("name", this.fields_options[field_id]['street1Name']);
            jQuery(document).find(".wblsform-row-new .wbls-field-city .wbls-field").attr("name", this.fields_options[field_id]['cityName']);
            jQuery(document).find(".wblsform-row-new .wbls-field-state .wbls-field").attr("name", this.fields_options[field_id]['stateName']);
            jQuery(document).find(".wblsform-row-new .wbls-field-postal .wbls-field").attr("name", this.fields_options[field_id]['postalName']);
            jQuery(document).find(".wblsform-row-new .wbls-field-country .wbls-field").attr("name", this.fields_options[field_id]['countryName']);
        } else if( field_type == "checkbox" ) {
            jQuery(document).find(".wblsform-row-new .wbls-field").attr("name", this.fields_options[field_id]['options'][0]['name']);
        } else if( field_type == "file" ) {
            jQuery(document).find(".wblsform-row-new .wbls-field").attr("name", this.fields_options[field_id]['name']);
        } else {
            jQuery(document).find(".wblsform-row-new .wbls-field").attr("name", this.fields_options[field_id]['name']);
        }
        jQuery(document).find(".wblsform-row-new label.wbls-field-label").text(field_args['label']);
     
        jQuery('.wbls-content').animate({
            scrollTop: jQuery('.wbls-content')[0].scrollHeight - 100
        }, 1000); // Scroll over 1 second
        jQuery(document).find(".wblsform-row-new").trigger("click");
        jQuery(document).find(".wblsform-row-new").removeClass("wblsform-row-new");
        this.fieldNameLastId = parseInt(this.fieldNameLastId) + 1;
    }
}

let wbls_fields;
jQuery(document).ready(function() {
    wbls_fields= new WBLS_FIELDS();
    wbls_fields.init();
});
