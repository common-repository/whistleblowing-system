<!--Simple text Template Front-->
<script type="text/template" id="wbls-template-text">
    <div class="wblsform-row wbls-label-top wblsform-row-new" data-field-id="">
        <label class="wbls-field-label"></label>
        <input class="wbls-field" type="text" name="" value="">
        <p class="wbls-field-description"></p>
    </div>
</script>

<!--Front Email Template-->
<script type="text/template" id="wbls-template-email">
    <div class="wblsform-row wbls-label-top wblsform-row-new" data-field-id="">
        <label class="wbls-field-label"></label>
        <input class="wbls-field" type="email" name="" value="">
        <p class="wbls-field-description"></p>
    </div>
</script>

<!--Front Number Template-->
<script type="text/template" id="wbls-template-number">
    <div class="wblsform-row wbls-label-top wblsform-row-new" data-field-id="">
        <label class="wbls-field-label"></label>
        <input class="wbls-field" type="number" name="" value="">
        <p class="wbls-field-description"></p>
    </div>
</script>

<!--Front Textarea Template-->
<script type="text/template" id="wbls-template-textarea">
    <div class="wblsform-row wbls-label-top wblsform-row-new" data-field-id="">
        <label class="wbls-field-label"></label>
        <textarea class="wbls-field" name=""></textarea>
        <p class="wbls-field-description"></p>
    </div>
</script>

<!--Front Submit Template-->
<script type="text/template" id="wbls-template-submit">
    <div class="wblsform-row wblsform-row-submit wbls-label-top wblsform-row-new" data-field-id="">
        <button class="wbls-submit-form">Submit</button>
    </div>
</script>

<!--Front Checkbox Template-->
<script type="text/template" id="wbls-template-checkbox">
    <div class="wblsform-row wbls-label-top wblsform-row-new" data-field-id="">
        <label class="wbls-field-label"></label>
        <div class="wbls-field-row-checkbox">
            <input class="wbls-field" type="checkbox" name="" value="">
            <label class="wbls-field-miniLabel wbls-checkbox-label"><?php esc_html_e('New Choice', 'whistleblowing-system'); ?></label>
        </div>
        <p class="wbls-field-description"></p>
    </div>
</script>

<!--Front Checkbox single Template-->
<script type="text/template" id="wbls-template-checkbox-single">
    <div class="wbls-field-row-checkbox wbls-field-row-checkbox-new">
        <input class="wbls-field" type="checkbox" name="" value="0">
        <label class="wbls-field-miniLabel wbls-checkbox-label"><?php esc_html_e('New Choice', 'whistleblowing-system'); ?></label>
    </div>
</script>

<!--Front Radio Template-->
<script type="text/template" id="wbls-template-radio">
    <div class="wblsform-row wbls-label-top wblsform-row-new" data-field-id="">
        <label class="wbls-field-label"></label>
        <div class="wbls-field-row-radio">
            <input class="wbls-field" type="radio" name="" value="First Choice" checked>
            <label class="wbls-field-miniLabel wbls-radio-label"><?php esc_html_e('First Choice', 'whistleblowing-system'); ?></label>
        </div>
        <div class="wbls-field-row-radio">
            <input class="wbls-field" type="radio" name="" value="Second Choice">
            <label class="wbls-field-miniLabel wbls-radio-label"><?php esc_html_e('Second Choice', 'whistleblowing-system'); ?></label>
        </div>
        <div class="wbls-field-row-radio">
            <input class="wbls-field" type="radio" name="" value="Third Choice">
            <label class="wbls-field-miniLabel wbls-radio-label"><?php esc_html_e('Third Choice', 'whistleblowing-system'); ?></label>
        </div>
        <p class="wbls-field-description"></p>
    </div>
</script>

<!--Front single radio Template-->
<script type="text/template" id="wbls-template-radio-single">
        <div class="wbls-field-row-radio wbls-field-row-radio-new">
            <input class="wbls-field" type="radio" name="" value="New Choice">
            <label class="wbls-field-miniLabel wbls-radio-label"><?php esc_html_e('New Choice', 'whistleblowing-system'); ?></label>
        </div>
    </div>
</script>

<!--Front Full name Template-->
<script type="text/template" id="wbls-template-fullName">
    <div class="wblsform-row wbls-label-top wblsform-row-new" data-field-id="">
        <label class="wbls-field-label"></label>
        <div class="wbls-field-fullName-container">
            <div class="wbls-field-firstName">
                <input class="wbls-field" type="text" name="" value="">
                <label class="wbls-field-miniLabel"><?php esc_html_e('First', 'whistleblowing-system'); ?></label>
            </div>
            <div class="wbls-field-lastName">
                <input class="wbls-field" type="text" name="" value="">
                <label class="wbls-field-miniLabel"><?php esc_html_e('Last', 'whistleblowing-system'); ?></label>
            </div>
        </div>
        <p class="wbls-field-description"></p>
    </div>
</script>

<!--Front Middle name Template-->
<script type="text/template" id="wbls-template-middleName">
    <div class="wbls-field-middleName">
        <input class="wbls-field" type="text" name="" value="">
        <label class="wbls-field-miniLabel"><?php esc_html_e('Middle', 'whistleblowing-system'); ?></label>
    </div>
</script>

<!--Front Address Template-->
<script type="text/template" id="wbls-template-address">
    <div class="wblsform-row wbls-label-top wblsform-row-new" data-field-id="">
        <label class="wbls-field-label"></label>
        <div class="wbls-field-address-container">
            <div class="wbls-field-street">
                <input class="wbls-field" type="text" name="" value="">
                <label class="wbls-field-miniLabel"><?php esc_html_e('Street Address', 'whistleblowing-system'); ?></label>
            </div>
            <div class="wbls-field-street1">
                <input class="wbls-field" type="text" name="" value="">
                <label class="wbls-field-miniLabel"><?php esc_html_e('Street Address Line 2', 'whistleblowing-system'); ?></label>
            </div>
            <div class="wbls-address-row">
                <div class="wbls-field-city">
                    <input class="wbls-field" type="text" name="" value="">
                    <label class="wbls-field-miniLabel"><?php esc_html_e('City', 'whistleblowing-system'); ?></label>
                </div>
                <div class="wbls-field-state">
                    <input class="wbls-field" type="text" name="" value="">
                    <label class="wbls-field-miniLabel"><?php esc_html_e('State / Province / Region', 'whistleblowing-system'); ?></label>
                </div>

            </div>
            <div class="wbls-address-row">
                <div class="wbls-field-postal">
                    <input class="wbls-field" type="text" name="" value="">
                    <label class="wbls-field-miniLabel"><?php esc_html_e('Postal / Zip Code', 'whistleblowing-system'); ?></label>
                </div>
                <div class="wbls-field-country">
                    <select class="wbls-field" name="">
                        <option value=""><?php echo esc_html__('Choose a Country', 'whistleblowing-system'); ?></option>
                        <?php foreach ( WBLSLibrary::$country_list as $country ) { ?>
                            <option value="<?php echo esc_html($country); ?>"><?php echo esc_html($country); ?></option>
                        <?php } ?>
                    </select>
                    <label class="wbls-field-miniLabel"><?php esc_html_e('Country', 'whistleblowing-system'); ?></label>
                </div>
            </div>
        </div>
        <p class="wbls-field-description"></p>
    </div>
</script>

<!--Front Address street Template-->
<script type="text/template" id="wbls-template-street">
    <div class="wbls-field-street">
        <input class="wbls-field" type="text" name="" value="">
        <label class="wbls-field-miniLabel"><?php esc_html_e('Street Address', 'whistleblowing-system'); ?></label>
    </div>
</script>

<!--Front Address street1 Template-->
<script type="text/template" id="wbls-template-street1">
    <div class="wbls-field-street1">
        <input class="wbls-field" type="text" name="" value="">
        <label class="wbls-field-miniLabel"><?php esc_html_e('Street Address Line 2', 'whistleblowing-system'); ?></label>
    </div>
</script>

<!--Front Address city Template-->
<script type="text/template" id="wbls-template-city">
    <div class="wbls-field-city">
        <input class="wbls-field" type="text" name="" value="">
        <label class="wbls-field-miniLabel"><?php esc_html_e('City', 'whistleblowing-system'); ?></label>
    </div>
</script>

<!--Front Address state Template-->
<script type="text/template" id="wbls-template-state">
    <div class="wbls-field-state">
        <input class="wbls-field" type="text" name="" value="">
        <label class="wbls-field-miniLabel"><?php esc_html_e('State / Province / Region', 'whistleblowing-system'); ?></label>
    </div>
</script>

<!--Front Address postal Template-->
<script type="text/template" id="wbls-template-postal">
    <div class="wbls-field-postal">
        <input class="wbls-field" type="text" name="" value="">
        <label class="wbls-field-miniLabel"><?php esc_html_e('Postal / Zip Code', 'whistleblowing-system'); ?></label>
    </div>
</script>

<!--Front Address country Template-->
<script type="text/template" id="wbls-template-country">
    <div class="wbls-field-country">
        <select class="wbls-field" name="" value="">
            <option value=""><?php echo esc_html__('Choose a Country', 'whistleblowing-system'); ?></option>
            <?php foreach ( WBLSLibrary::$country_list as $country ) { ?>
                <option value="<?php echo esc_html($country); ?>"><?php echo esc_html($country); ?></option>
            <?php } ?>
        </select>
        <label class="wbls-field-miniLabel"><?php esc_html_e('Country', 'whistleblowing-system'); ?></label>
    </div>
</script>


<!--Front Actions edit/delete field Template-->
<script type="text/template" id="wbls-template-actions">
    <div class="wblsform-actions">
        <span class="dashicons dashicons-edit" title="<?php esc_html_e('Edit Field', 'whistleblowing-system'); ?>"></span>
        <span class="dashicons dashicons-trash" title="<?php esc_html_e('Delete Field', 'whistleblowing-system'); ?>"></span>
    </div>
</script>

<!--Editor full name Template-->
<script type="text/template" id="wbls-template-fullName-options">
    <hr>
    <div class="wbls-field-option-row">
        <label><?php esc_html_e('First name', 'whistleblowing-system') ?></label>
        <div class="wbls-field-option-firstName wbls-field-option-name-cont">
            <div>
                <input type="text" class="wbls-field-option-placeholder wbls-field-option" data-option="firstNamePlaceholder">
                <label class="wbls-field-miniLabel"><?php esc_html_e('Placeholder', 'whistleblowing-system'); ?></label>
            </div>
            <div>
                <input type="text" class="wbls-field-option-miniLabel wbls-field-option" data-option="firstNameMiniLabel" value="<?php esc_html_e('First', 'whistleblowing-system') ?>">
                <label class="wbls-field-miniLabel"><?php esc_html_e('Mini label', 'whistleblowing-system'); ?></label>
            </div>
        </div>
    </div>
    <div class="wbls-field-option-row">
        <label><?php esc_html_e('Middle name', 'whistleblowing-system') ?></label>
        <div class="wbls-field-option-middleName wbls-field-option-name-cont">
            <div>
                <input type="text" class="wbls-field-option-placeholder wbls-field-option" data-option="middleNamePlaceholder">
                <label class="wbls-field-miniLabel"><?php esc_html_e('Placeholder', 'whistleblowing-system'); ?></label>
            </div>
            <div>
                <input type="text" class="wbls-field-option-miniLabel wbls-field-option" data-option="middleNameMiniLabel" value="<?php esc_html_e('Middle', 'whistleblowing-system') ?>">
                <label class="wbls-field-miniLabel"><?php esc_html_e('Mini label', 'whistleblowing-system'); ?></label>
            </div>
        </div>
    </div>
    <div class="wbls-field-option-row">
        <label><?php esc_html_e('Hide middle name', 'whistleblowing-system') ?></label>
        <div class="wbls-field-option-radio-row">
            <input type="radio" name="wbls-field-option-hideMiddleName" value="1" class="wbls-field-option-hideMiddleName wbls-field-option" data-option="hideMiddleName" checked> Yes
            <input type="radio" name="wbls-field-option-hideMiddleName" value="0" class="wbls-field-option-hideMiddleName wbls-field-option" data-option="hideMiddleName"> No
        </div>

    </div>
    <div class="wbls-field-option-row">
        <label><?php esc_html_e('Last name', 'whistleblowing-system') ?></label>
        <div class="wbls-field-option-lastName wbls-field-option-name-cont">
            <div>
                <input type="text" class="wbls-field-option-placeholder wbls-field-option" data-option="lastNamePlaceholder">
                <label class="wbls-field-miniLabel"><?php esc_html_e('Placeholder', 'whistleblowing-system'); ?></label>
            </div>
            <div>
                <input type="text" class="wbls-field-option-miniLabel wbls-field-option" data-option="lastNameMiniLabel" value="<?php esc_html_e('Last', 'whistleblowing-system') ?>">
                <label class="wbls-field-miniLabel"><?php esc_html_e('Mini label', 'whistleblowing-system'); ?></label>
            </div>
        </div>
    </div>
</script>

<!--Editor address Template-->
<script type="text/template" id="wbls-template-address-options">
    <hr>
    <div class="wbls-field-option-row">
        <label><?php esc_html_e('Street Address', 'whistleblowing-system') ?></label>
        <div class="wbls-field-option-street wbls-field-option-address-cont">
            <div>
                <input type="text" class="wbls-field-option-placeholder wbls-field-option" data-option="streetPlaceholder">
                <label class="wbls-field-miniLabel"><?php esc_html_e('Placeholder', 'whistleblowing-system'); ?></label>
            </div>
            <div>
                <input type="text" class="wbls-field-option-miniLabel wbls-field-option" data-option="streetMiniLabel" value="<?php esc_html_e('Street Address', 'whistleblowing-system') ?>">
                <label class="wbls-field-miniLabel"><?php esc_html_e('Mini label', 'whistleblowing-system'); ?></label>
            </div>
        </div>
    </div>
    <div class="wbls-field-option-row">
        <label><?php esc_html_e('Hide Street Address', 'whistleblowing-system') ?></label>
        <div class="wbls-field-option-radio-row">
            <input type="radio" name="wbls-field-option-hideStreet" value="1" class="wbls-field-option-hideStreet wbls-field-option" data-option="hideStreet"> Yes
            <input type="radio" name="wbls-field-option-hideStreet" value="0" class="wbls-field-option-hideStreet wbls-field-option" data-option="hideStreet" checked> No
        </div>
    </div>
    <hr>
    <div class="wbls-field-option-row">
        <label><?php esc_html_e('Street Address Line 2', 'whistleblowing-system') ?></label>
        <div class="wbls-field-option-street1 wbls-field-option-address-cont">
            <div>
                <input type="text" class="wbls-field-option-placeholder wbls-field-option" data-option="street1Placeholder">
                <label class="wbls-field-miniLabel"><?php esc_html_e('Placeholder', 'whistleblowing-system'); ?></label>
            </div>
            <div>
                <input type="text" class="wbls-field-option-miniLabel wbls-field-option" data-option="street1MiniLabel" value="<?php esc_html_e('Street Address Line 2', 'whistleblowing-system') ?>">
                <label class="wbls-field-miniLabel"><?php esc_html_e('Mini label', 'whistleblowing-system'); ?></label>
            </div>
        </div>
    </div>
    <div class="wbls-field-option-row">
        <label><?php esc_html_e('Hide Street Address Line 2', 'whistleblowing-system') ?></label>
        <div class="wbls-field-option-radio-row">
            <input type="radio" name="wbls-field-option-hideStreet1" value="1" class="wbls-field-option-hideStreet1 wbls-field-option" data-option="hideStreet1"> Yes
            <input type="radio" name="wbls-field-option-hideStreet1" value="0" class="wbls-field-option-hideStreet1 wbls-field-option" data-option="hideStreet1" checked> No
        </div>
    </div>
    <hr>
    <div class="wbls-field-option-row">
        <label><?php esc_html_e('City', 'whistleblowing-system') ?></label>
        <div class="wbls-field-option-city wbls-field-option-address-cont">
            <div>
                <input type="text" class="wbls-field-option-placeholder wbls-field-option" data-option="cityPlaceholder">
                <label class="wbls-field-miniLabel"><?php esc_html_e('Placeholder', 'whistleblowing-system'); ?></label>
            </div>
            <div>
                <input type="text" class="wbls-field-option-miniLabel wbls-field-option" data-option="cityMiniLabel" value="<?php esc_html_e('City', 'whistleblowing-system') ?>">
                <label class="wbls-field-miniLabel"><?php esc_html_e('Mini label', 'whistleblowing-system'); ?></label>
            </div>
        </div>
    </div>
    <div class="wbls-field-option-row">
        <label><?php esc_html_e('Hide City', 'whistleblowing-system') ?></label>
        <div class="wbls-field-option-radio-row">
            <input type="radio" name="wbls-field-option-hideCity" value="1" class="wbls-field-option-hideCity wbls-field-option" data-option="hideCity"> Yes
            <input type="radio" name="wbls-field-option-hideCity" value="0" class="wbls-field-option-hideCity wbls-field-option" data-option="hideCity" checked> No
        </div>
    </div>
    <hr>
    <div class="wbls-field-option-row">
        <label><?php esc_html_e('State / Province / Region', 'whistleblowing-system') ?></label>
        <div class="wbls-field-option-state wbls-field-option-address-cont">
            <div>
                <input type="text" class="wbls-field-option-placeholder wbls-field-option" data-option="statePlaceholder">
                <label class="wbls-field-miniLabel"><?php esc_html_e('Placeholder', 'whistleblowing-system'); ?></label>
            </div>
            <div>
                <input type="text" class="wbls-field-option-miniLabel wbls-field-option" data-option="stateMiniLabel" value="<?php esc_html_e('State / Province / Region', 'whistleblowing-system') ?>">
                <label class="wbls-field-miniLabel"><?php esc_html_e('Mini label', 'whistleblowing-system'); ?></label>
            </div>
        </div>
    </div>
    <div class="wbls-field-option-row">
        <label><?php esc_html_e('Hide State / Province / Region', 'whistleblowing-system') ?></label>
        <div class="wbls-field-option-radio-row">
            <input type="radio" name="wbls-field-option-hideState" value="1" class="wbls-field-option-hideState wbls-field-option" data-option="hideState"> Yes
            <input type="radio" name="wbls-field-option-hideState" value="0" class="wbls-field-option-hideState wbls-field-option" data-option="hideState" checked> No
        </div>
    </div>
    <hr>
    <div class="wbls-field-option-row">
        <label><?php esc_html_e('Postal / Zip Code', 'whistleblowing-system') ?></label>
        <div class="wbls-field-option-postal wbls-field-option-address-cont">
            <div>
                <input type="text" class="wbls-field-option-placeholder wbls-field-option" data-option="postalPlaceholder">
                <label class="wbls-field-miniLabel"><?php esc_html_e('Placeholder', 'whistleblowing-system'); ?></label>
            </div>
            <div>
                <input type="text" class="wbls-field-option-miniLabel wbls-field-option" data-option="postalMiniLabel" value="<?php esc_html_e('Postal / Zip Code', 'whistleblowing-system') ?>">
                <label class="wbls-field-miniLabel"><?php esc_html_e('Mini label', 'whistleblowing-system'); ?></label>
            </div>
        </div>
    </div>
    <div class="wbls-field-option-row">
        <label><?php esc_html_e('Hide Postal / Zip Code', 'whistleblowing-system') ?></label>
        <div class="wbls-field-option-radio-row">
            <input type="radio" name="wbls-field-option-hidePostal" value="1" class="wbls-field-option-hidePostal wbls-field-option" data-option="hidePostal"> Yes
            <input type="radio" name="wbls-field-option-hidePostal" value="0" class="wbls-field-option-hidePostal wbls-field-option" data-option="hidePostal" checked> No
        </div>
    </div>
    <hr>
    <div class="wbls-field-option-row">
        <label><?php esc_html_e('Country', 'whistleblowing-system') ?></label>
        <div class="wbls-field-option-country wbls-field-option-address-cont">
            <div>
                <input type="text" class="wbls-field-option-placeholder wbls-field-option" data-option="countryPlaceholder">
                <label class="wbls-field-miniLabel"><?php esc_html_e('Placeholder', 'whistleblowing-system'); ?></label>
            </div>
            <div>
                <input type="text" class="wbls-field-option-miniLabel wbls-field-option" data-option="countryMiniLabel" value="<?php esc_html_e('Country', 'whistleblowing-system') ?>">
                <label class="wbls-field-miniLabel"><?php esc_html_e('Mini label', 'whistleblowing-system'); ?></label>
            </div>
        </div>
    </div>
    <div class="wbls-field-option-row">
        <label><?php esc_html_e('Hide Country', 'whistleblowing-system') ?></label>
        <div class="wbls-field-option-radio-row">
            <input type="radio" name="wbls-field-option-hideCountry" value="1" class="wbls-field-option-hideCountry wbls-field-option" data-option="hideCountry"> Yes
            <input type="radio" name="wbls-field-option-hideCountry" value="0" class="wbls-field-option-hideCountry wbls-field-option" data-option="hideCountry" checked> No
        </div>
    </div>
</script>

<!--Editor default Template-->
<script type="text/template" id="wbls-template-field-default">
    <div class="wbls-tabs-menu">
        <div id="wbls-editor-general" class="wbls-tabs-menu-item wbls-tabs-menu-item-active"><?php esc_html_e('General', 'whistleblowing-system'); ?></div>
        <div id="wbls-editor-conditions" class="wbls-tabs-menu-item"><?php esc_html_e('Conditional fields', 'whistleblowing-system'); ?></div>
    </div>
    <div class="wbls-editor-general wbls-editor-menu-content">
        <div class="wbls-field-option-row">
            <label><?php esc_html_e('Label', 'whistleblowing-system'); ?></label>
            <input type="text" class="wbls-field-option-label wbls-field-option" data-option="label">
        </div>
        <div class="wbls-field-option-row">
            <label><?php esc_html_e('Description', 'whistleblowing-system') ?></label>
            <textarea class="wbls-field-option-description wbls-field-option" data-option="description"></textarea>
        </div>
        <div class="wbls-field-option-row">
            <label><?php esc_html_e('Placeholder', 'whistleblowing-system') ?></label>
            <input type="text" class="wbls-field-option-placeholder wbls-field-option" data-option="placeholder">
        </div>
        <div class="wbls-field-option-row">
            <label><?php esc_html_e('Required', 'whistleblowing-system') ?></label>
            <div class="wbls-field-option-radio-row">
            <input type="radio" name="wbls-field-option-required" value="1" class="wbls-field-option-required wbls-field-option" data-option="required"> Yes
            <input type="radio" name="wbls-field-option-required" value="0" class="wbls-field-option-required wbls-field-option" data-option="required"> No
            </div>
        </div>
    </div>

    <div class="wbls-editor-conditions wbls-editor-menu-content" style="display:none">
        <div class="wbls-field-option-row wbls-condition-item-row wbls-condition-header-row">
            <select class="wbls-show-field">
                <option value="1"><?php esc_html_e('Show this field', 'whistleblowing-system'); ?></option>
                <option value="0"><?php esc_html_e('Hide this field', 'whistleblowing-system'); ?></option>
            </select>
            <span class="wbls-add-condition-group"><?php esc_html_e('Add new group', 'whistleblowing-system'); ?></span>
        </div>
    </div>
</script>

<!--Editor condition group row Template-->
<script type="text/template" id="wbls-template-empty-condition-group">
    <div class="wbls-condition-group wbls-condition-group-new"></div>
</script>

<!--Editor condition item row Template-->
<script type="text/template" id="wbls-template-empty-condition-row">
    <div class="wbls-field-option-row wbls-condition-item-row wbls-condition-item-row-new">
        <select class="wbls-condition-fields">
            <option value=""><?php esc_html_e('Select field', 'whistleblowing-system'); ?></option>
        </select>
        <select class="wbls-condition-type">
            <option value="is"><?php esc_html_e('is', 'whistleblowing-system'); ?></option>
            <option value="is not"><?php esc_html_e('is not', 'whistleblowing-system'); ?></option>
            <option value="empty"><?php esc_html_e('empty', 'whistleblowing-system'); ?></option>
            <option value="not empty"><?php esc_html_e('not empty', 'whistleblowing-system'); ?></option>
        </select>
        <div class="wbls-condition-value-container">
            <input class="wbls-condition-value" type="text" name="contition_value" value="">
        </div>
        <span class="wbls-add-condition-item"><?php esc_html_e('AND', 'whistleblowing-system'); ?></span>
        <span class="dashicons dashicons-trash wbls-remove-condition-item" title="<?php esc_html_e('Remove', 'whistleblowing-system'); ?>"></span>
    </div>
</script>

<!--Editor default empty row Template-->
<script type="text/template" id="wbls-template-empty-row">
    <div class="wbls-field-option-row wbls-field-option-row-empty">
        <label></label>
    </div>
</script>

<!--Editor Radio Template-->
<script type="text/template" id="wbls-template-field-radio">
    <div class="wbls-radio-item wbls-radio-new-item">
        <input type="radio" class="wbls-radio-item-default" name="option_default">
        <input type="text" class="wbls-radio-item-value" name="option_value" value="New Choice">
        <span class="dashicons dashicons-plus-alt wbls-add-radio-item"></span>
        <span class="dashicons dashicons-trash wbls-remove-radio-item"></span>
    </div>
</script>

<!--Editor checkbox Template-->
<script type="text/template" id="wbls-template-field-checkbox">
    <div class="wbls-checkbox-item wbls-checkbox-new-item">
        <input type="checkbox" class="wbls-checkbox-item-default" name="option_default">
        <input type="text" class="wbls-checkbox-item-value" name="option_value" value="New Choice">
        <span class="dashicons dashicons-plus-alt wbls-add-checkbox-item"></span>
        <span class="dashicons dashicons-trash wbls-remove-checkbox-item"></span>
    </div>
</script>

<!--Front alert Template-->
<script type="text/template" id="wbls-template-alert">
    <div class="wbls-alert-layer">
    <div class="wbls-alert-container">
        <div class="wbls-alert-title"></div>
        <div class="wbls-alert-buttons-row">
            <span class="wbls-alert-buttons-delete wbls-alert-button">Delete</span>
            <span class="wbls-alert-buttons-cancel wbls-alert-button">Cancel</span>
        </div>
    </div>
</script>

