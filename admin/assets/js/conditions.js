class WBLS_CONDITIONS {

    init( edit_field_id ) {
        this.form_fields = JSON.parse(JSON.stringify(wbls_edit.form_fields));
        this.fields_options = JSON.parse(JSON.stringify(wbls_edit.fields_options));
        this.edit_field_id =  edit_field_id;

        if( typeof this.conditions == 'undefined' ) {
            this.conditions = JSON.parse(JSON.stringify(wbls_edit.form_conditions));
        }
        this.setNewConditionArray( this.edit_field_id );

        this.registerEvents();
        this.drawCurrentConditions();
    }

    setNewConditionArray( field_id ) {
        /* undefined check need for not overwrite current value */
        if( typeof this.conditions[field_id] == 'undefined' ||  !this.conditions[field_id] ) {
            this.conditions[field_id] = {};
            this.conditions[field_id]['showField'] = 1;
            this.conditions[field_id]['conditions'] = {};
            this.conditions[field_id]['status'] = 1;
        }
    }

    registerEvents() {
        let self = this;
        jQuery(document).off( "click", ".wbls-add-condition-group").on("click", ".wbls-add-condition-group", function() {
            self.addConditionGroup(this);
        });

        jQuery(document).off( "click", ".wbls-add-condition-item").on("click", ".wbls-add-condition-item", function() {
            self.addConditionItem(this);
        });

        jQuery(document).off( "click", ".wbls-remove-condition-item").on("click", ".wbls-remove-condition-item", function() {
            self.removeConditionItem(this);
        });

        jQuery(document).off( "change", ".wbls-condition-fields").on("change", ".wbls-condition-fields", function() {
            self.fieldsSelectChangeAction(this);
        });

        jQuery(document).off( "change", ".wbls-condition-type").on("change", ".wbls-condition-type", function() {
            self.conditionTypeSelectChangeAction(this);
        });

        jQuery(document).off( "change", ".wbls-condition-value").on("change", ".wbls-condition-value", function() {
            self.conditionValueChangeAction(this);
        });

        jQuery(document).off( "change", ".wbls-show-field").on("change", ".wbls-show-field", function() {
            self.changeFieldShowSelect(this);
        });
    }

    drawCurrentConditions() {
        let self = this;
        if( (Array.isArray(this.conditions) && !this.conditions.length) ||
            (typeof this.conditions === 'object' && !Object.keys(this.conditions).length) ||
            typeof this.conditions[this.edit_field_id] == 'undefined' ||
            typeof this.conditions[this.edit_field_id]['conditions'] == 'undefined' ) {
            return;
        }

        let show_filed = this.conditions[this.edit_field_id]['showField'];
        jQuery(document).find(".wbls-show-field option[value='"+show_filed+"']").prop("selected", true);


        let groupTemplate = jQuery("#wbls-template-empty-condition-group").html();
        let itemTemplate = jQuery("#wbls-template-empty-condition-row").html();

        let content = jQuery(document).find(".wbls-editor-conditions.wbls-editor-menu-content");

        let groupObjects = this.conditions[this.edit_field_id]['conditions'];

        let ind = 0;
        /* Foreach on groups indexes object[field_id][group_index] scheme */
        Object.keys(groupObjects).forEach(function(groupKey) {
            if( ind === 0 ) {
                content.append("<p>IF</p>");
            } else {
                content.append("<p>OR</p>");
            }
            content.append(groupTemplate);
            let new_group = jQuery(document).find(".wbls-condition-group-new");
            new_group.attr("data-group-id", groupKey);
            let conditionsObjects = self.conditions[self.edit_field_id]['conditions'][groupKey];
            /* Foreach on condition row indexes object[field_id][group_index][condition_row_index] scheme */
            Object.keys(conditionsObjects).forEach(function(conditionsKey) {
                new_group.append(itemTemplate);
                let new_item = new_group.find(".wbls-condition-item-row-new");
                new_item.attr("data-id", conditionsKey);
                self.setFieldList( new_item );
                let conditionColumns = self.conditions[self.edit_field_id]['conditions'][groupKey][conditionsKey];
                new_item.find(".wbls-condition-fields option[value='"+conditionColumns['field_id']+"']").prop('selected', true);
                new_item.find(".wbls-condition-type option[value='"+conditionColumns['condition']+"']").prop('selected', true);

                /* Check if select or radio change value field to select tag with options */
                let conditionColumnId = conditionColumns['field_id'];
                conditionColumnId = conditionColumnId.replace('_street1', '').replace('_street', '').
                replace('_city', '').replace('_postal', '').replace('_state', '')
                    .replace('_country', '').replace('_f', '').replace('_m', '').replace('_l', '');
                if( conditionColumns['field_id'] != '' && (self.fields_options[ conditionColumnId ]['type'] === 'select' || self.fields_options[ conditionColumnId ]['type'] === 'radio') ) {
                    let options = '';
                    let selectOptions = self.fields_options[ conditionColumnId ]['options'];
                    Object.keys(selectOptions).forEach(function(key) {
                        if( selectOptions[key]['key'] === conditionColumns['value'] ) {
                            options += "<option value='"+selectOptions[key]['key']+"' selected>" + selectOptions[key]['val'] + "</option>";
                        } else {
                            options += "<option value='"+selectOptions[key]['key']+"'>" + selectOptions[key]['val'] + "</option>";
                        }
                    });
                    let select = "<select class='wbls-condition-value' name='contition_value'>";
                    if( conditionColumns['condition'] === 'empty' || conditionColumns['condition'] === 'not empty' ) {
                        select = "<select class='wbls-condition-value' name='contition_value' disabled>";
                    }
                    select += options;
                    select += "</select>";
                    new_item.find(".wbls-condition-value-container").empty().append(select);

                    jQuery(document).find(".wbls-condition-item-row-new .wbls-condition-type").find("option[value='empty'], option[value='not empty']").remove();
                }
                else if( conditionColumns['field_id'] != '' && (self.fields_options[ conditionColumnId ]['type'] == 'checkbox') ) {
                    let options = '';
                    if( '1' == conditionColumns['value'] ) {
                        options += "<option value='1' selected>Checked</option>";
                        options += "<option value='0'>Unchecked</option>";
                    } else {
                        options += "<option value='1'>Checked</option>";
                        options += "<option value='0' selected>Unchecked</option>";
                    }
                    let select = "<select class='wbls-condition-value' name='contition_value'>";
                    if( conditionColumns['condition'] == 'empty' || conditionColumns['condition'] == 'not empty' ) {
                        select = "<select class='wbls-condition-value' name='contition_value' disabled>";
                    }

                    select += options;
                    select += "</select>";
                    new_item.find(".wbls-condition-value-container").empty().append(select);

                    jQuery(document).find(".wbls-condition-item-row-new .wbls-condition-type").find("option[value='empty'], option[value='not empty']").remove();
                }
                else
                {
                    let field = '<input class="wbls-condition-value" type="text" name="contition_value" value="'+conditionColumns['value']+'">';
                    if( conditionColumns['condition'] == 'empty' || conditionColumns['condition'] == 'not empty' ) {
                        field = '<input class="wbls-condition-value" type="text" name="contition_value" value="'+conditionColumns['value']+'" disabled>';
                    }

                    new_item.find(".wbls-condition-value-container").empty().append(field);
                }
                new_item.removeClass("wbls-condition-item-row-new");
            });
            new_group.removeClass("wbls-condition-group-new");
            ind++;
        });


    }

    changeFieldShowSelect(that) {
        this.setNewConditionArray( this.edit_field_id );
        let val = jQuery(that).val();
        if( typeof this.conditions[this.edit_field_id] != 'undefined' && this.conditions[this.edit_field_id] != '' ) {
            this.conditions[this.edit_field_id]['showField'] = val;
        }
    }

    fieldsSelectChangeAction(that) {
        let group_id = jQuery(that).closest(".wbls-condition-group").attr("data-group-id");
        let item_id = jQuery(that).closest(".wbls-condition-item-row").attr("data-id");
        let field_id = jQuery(that).val();


        let field_name = jQuery(that).find(':selected').attr('data-name');
        this.conditions[this.edit_field_id]['conditions'][group_id][item_id]['field_id'] = field_id;
        this.conditions[this.edit_field_id]['conditions'][group_id][item_id]['field_name'] = field_name;

        field_id = field_id.replace('_street1', '').replace('_street', '').
        replace('_city', '').replace('_postal', '').replace('_state', '')
            .replace('_country', '').replace('_f', '').replace('_m', '').replace('_l', '');

        if( this.fields_options[field_id]['type'] == 'select' || this.fields_options[field_id]['type'] == 'radio' ) {
            let options = '';
            let defaultVal = '';
            let opt = this.fields_options[field_id]['options'];
            Object.keys(opt).forEach(function(key) {
                if(defaultVal == '') {
                    defaultVal = opt[key]['key'];
                }
                options += "<option value='"+opt[key]['key']+"'>" + opt[key]['val'] + "</option>";
            });
            let select = "<select class='wbls-condition-value' name='contition_value'>";
            select += options;
            select += "</select>";
            jQuery(that).closest(".wbls-condition-item-row").find(".wbls-condition-value-container").empty().append(select);
            jQuery(that).closest(".wbls-condition-item-row").find(".wbls-condition-type").find("option[value='empty'], option[value='not empty']").remove();

            this.conditions[this.edit_field_id]['conditions'][group_id][item_id]['value'] = defaultVal;
        }
        else if( this.fields_options[field_id]['type'] == 'checkbox' ) {
            let options = '';
            options += "<option value='1'>Checked</option>";
            options += "<option value='0'>Unchecked</option>";
            let select = "<select class='wbls-condition-value' name='contition_value'>";
            select += options;
            select += "</select>";
            jQuery(that).closest(".wbls-condition-item-row").find(".wbls-condition-value-container").empty().append(select);

            jQuery(that).closest(".wbls-condition-item-row").find(".wbls-condition-type").find("option[value='empty'], option[value='not empty']").remove();
            this.conditions[this.edit_field_id]['conditions'][group_id][item_id]['value'] = 1;
        }
        else
        {
            let field = '<input class="wbls-condition-value" type="text" name="contition_value" value="">';
            jQuery(that).closest(".wbls-condition-item-row").find(".wbls-condition-value-container").empty().append(field);
        }
    }

    conditionTypeSelectChangeAction(that) {
        let group_id = jQuery(that).closest(".wbls-condition-group").attr("data-group-id");
        let item_id = jQuery(that).closest(".wbls-condition-item-row").attr("data-id");
        let val = jQuery(that).val();
        this.conditions[this.edit_field_id]['conditions'][group_id][item_id]['condition'] = val;
        if( val == 'empty' || val == 'not empty' ) {
            jQuery(that).closest(".wbls-condition-item-row").find(".wbls-condition-value").attr("disabled", true);
        } else {
            jQuery(that).closest(".wbls-condition-item-row").find(".wbls-condition-value").attr("disabled", false);
        }
    }

    conditionValueChangeAction(that) {
        let group_id = jQuery(that).closest(".wbls-condition-group").attr("data-group-id");
        let item_id = jQuery(that).closest(".wbls-condition-item-row").attr("data-id");
        let val = jQuery(that).val();
        this.conditions[this.edit_field_id]['conditions'][group_id][item_id]['value'] = val;
    }

    addConditionGroup(that) {
        let self = this;
        this.setNewConditionArray( self.edit_field_id );
        let groupTemplate = jQuery("#wbls-template-empty-condition-group").html();
        jQuery(that).closest(".wbls-editor-conditions").append(groupTemplate);
        let groupCount = jQuery(that).closest(".wbls-editor-conditions").find(".wbls-condition-group").length;
        let groupIndex = parseInt(groupCount) - 1;
        let new_group = jQuery(that).closest(".wbls-editor-conditions").find(".wbls-condition-group-new");
        new_group.attr("data-group-id", groupIndex);

        let conditionItemTemplate = jQuery("#wbls-template-empty-condition-row").html();
        new_group.append(conditionItemTemplate);
        jQuery(document).find(".wbls-condition-item-row-new").attr("data-id", 0);
        jQuery(document).find(".wbls-condition-item-row-new").removeClass("wbls-condition-item-row-new");


        if( jQuery(that).closest(".wbls-editor-conditions").find(".wbls-condition-group").length > 1 ) {
            new_group.before("<p>OR</p>");
        } else if( jQuery(that).closest(".wbls-editor-conditions").find(".wbls-condition-group").length == 1 ) {
            new_group.before("<p>IF</p>");
        }
        new_group.removeClass("wbls-condition-group-new");


        if( !this.conditions[self.edit_field_id] ) {
            this.conditions[self.edit_field_id] = {};
        }
        if( !this.conditions[self.edit_field_id]['conditions'] ) {
            this.conditions[self.edit_field_id]['conditions'] = {};
        }
        if( !this.conditions[self.edit_field_id]['conditions'][groupIndex] ) {
            this.conditions[self.edit_field_id]['conditions'][groupIndex] = {};
        }

        if( !this.conditions[self.edit_field_id]['conditions'][groupIndex][0] ) {
            this.conditions[self.edit_field_id]['conditions'][groupIndex][0] = {};
        }

        this.conditions[self.edit_field_id]['conditions'][groupIndex][0]['field_id'] = '';
        this.conditions[self.edit_field_id]['conditions'][groupIndex][0]['condition'] = 'is';
        this.conditions[self.edit_field_id]['conditions'][groupIndex][0]['value'] = '';
        this.conditions[self.edit_field_id]['conditions'][groupIndex][0]['field_name'] = '';


        let item = jQuery(document).find(".wbls-condition-group[data-group-id='"+groupIndex+"'] .wbls-condition-item-row[data-id='0']");
        this.setFieldList(item);
    }

    addConditionItem(that) {
        let self = this;
        let template = jQuery("#wbls-template-empty-condition-row").html();
        jQuery(that).closest(".wbls-condition-item-row").after(template);

        let group_id = jQuery(that).closest(".wbls-condition-group").attr("data-group-id");

        let highestKey = Math.max(...Object.keys(this.conditions[self.edit_field_id]['conditions'][group_id]));
        highestKey = highestKey + 1;

        let new_item = jQuery(that).closest(".wbls-condition-group").find(".wbls-condition-item-row-new");
        new_item.attr("data-id", highestKey);
        this.setFieldList(new_item);
        new_item.removeClass("wbls-condition-item-row-new");

        if( !this.conditions[self.edit_field_id]['conditions'][group_id][highestKey] ) {
            this.conditions[self.edit_field_id]['conditions'][group_id][highestKey] = {};
        }
        this.conditions[self.edit_field_id]['conditions'][group_id][highestKey]['field_id'] = '';
        this.conditions[self.edit_field_id]['conditions'][group_id][highestKey]['condition'] = 'is';
        this.conditions[self.edit_field_id]['conditions'][group_id][highestKey]['value'] = '';
        this.conditions[self.edit_field_id]['conditions'][group_id][highestKey]['field_name'] = '';
    }

    removeConditionItem(that) {
        let self = this;
        let group_id = jQuery(that).closest(".wbls-condition-group").attr("data-group-id");
        let item_id = jQuery(that).closest(".wbls-condition-item-row").attr("data-id");
        if( jQuery(that).closest(".wbls-condition-group").find(".wbls-condition-item-row").length === 1 ) {
            jQuery(that).closest(".wbls-condition-group").prev("p").remove();
            jQuery(that).closest(".wbls-condition-group").remove();
            delete this.conditions[self.edit_field_id]['conditions'][group_id];
        } else {
            jQuery(that).closest(".wbls-condition-item-row").remove();
            delete this.conditions[self.edit_field_id]['conditions'][group_id][item_id];
        }
        if( !Object.keys(this.conditions[self.edit_field_id]['conditions']).length ) {
            delete this.conditions[self.edit_field_id];
        }
    }

    setFieldList( that ) {
        let self = this;
        let options = '';
        Object.keys(self.fields_options).forEach(function(key) {
            if( !self.fields_options[key] || self.fields_options[key]['type'] === 'submit' || self.fields_options[key]['type'] === 'file' || self.fields_options[key]['type'] === 'recaptcha' || self.fields_options[key]['type'] === 'page_break' || key === self.edit_field_id ) {
                return;
            }
            if ( self.fields_options[key]['type'] == 'checkbox' ) {
                Object.keys(self.fields_options[key]['options']).forEach(function(key1) {
                    let item = self.fields_options[key]['options'][key1];
                    options += "<option value='" + key + "' data-name='" + item['name'] + "'>" + item['miniLabel'] + "</option>";
                });
            } else if( self.fields_options[key]['type'] == 'fullName' ) {
                options += "<option value='" + key + "_f' data-name='" + self.fields_options[key]['name'] + "_f'>" + self.fields_options[key]['firstNameMiniLabel'] + "</option>";
                if( self.fields_options[key]['hideMiddleName'] != 1 ) {
                    options += "<option value='" + key + "_m' data-name='" + self.fields_options[key]['name'] + "_m'>" + self.fields_options[key]['middleNameMiniLabel'] + "</option>";
                }
                options += "<option value='" + key + "_l' data-name='" + self.fields_options[key]['name'] + "_l'>" + self.fields_options[key]['lastNameMiniLabel'] + "</option>";
            } else if( self.fields_options[key]['type'] == 'address' ) {
                options += "<option value='" + key + "_street' data-name='" + self.fields_options[key]['name'] + "_street'>" + self.fields_options[key]['streetMiniLabel'] + "</option>";
                options += "<option value='" + key + "_street1' data-name='" + self.fields_options[key]['name'] + "_street1'>" + self.fields_options[key]['street1MiniLabel'] + "</option>";
                options += "<option value='" + key + "_city' data-name='" + self.fields_options[key]['name'] + "_city'>" + self.fields_options[key]['cityMiniLabel'] + "</option>";
                options += "<option value='" + key + "_state' data-name='" + self.fields_options[key]['name'] + "_state'>" + self.fields_options[key]['stateMiniLabel'] + "</option>";
                options += "<option value='" + key + "_postal' data-name='" + self.fields_options[key]['name'] + "_postal'>" + self.fields_options[key]['postalMiniLabel'] + "</option>";
                options += "<option value='" + key + "_country' data-name='" + self.fields_options[key]['name'] + "_country'>" + self.fields_options[key]['countryMiniLabel'] + "</option>";
            } else {
                options += "<option value='" + key + "' data-name='" + self.fields_options[key]['name'] + "'>" + self.fields_options[key]['label'] + "</option>";
            }
        });

        that.find(".wbls-condition-fields").append(options);
    }
}
