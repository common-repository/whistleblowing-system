<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class WBLS_Conditions {

    public $conditions = [];
    public $form_id = [];
    public $field_options = [];

    public function __construct( $args ) {
            $this->conditions = $args['form_conditions'];
            $this->form_id = $args['form_id'];
            $this->field_options = $args['field_options'];
            $this->generate_js();
    }

    public function generate_js() {
        $js = 'jQuery(document).ready( function() { 
                  wbls_condition_'.$this->form_id.'(); ';
        $js .= "\n";
        $js .= 'jQuery(document).on("click",".wbls-new-case-button", function() {
                    wbls_condition_'.$this->form_id.'();
                })';
        $js .= "\n";
        $jsFunction = 'function wbls_condition_'.$this->form_id.'() { ';
        $jsFunction .= "\n";

        foreach( $this->conditions as $field_id => $field_conditions ) {
            if( empty($field_conditions['conditions']) ) {
                continue;
            }
            //$ifArguments = '';
            $if = '';
            foreach ( $field_conditions['conditions'] as $group_id => $group_conditions ) {
                $ifArguments = '';
                foreach ( $group_conditions as $key => $val ) {
                    if( !isset($val['field_id']) || $val['field_id'] == "" ) {
                        continue;
                    }
                    $js .= 'jQuery(document).on("change", "#wbls-form-' . $this->form_id . ' .wblsform-row input[name=\''.$val['field_name'].'\'],';
                    $js .=     '#wbls-form-' . $this->form_id . ' .wblsform-row textarea[name=\''.$val['field_name'].'\'],';
                    $js .=     '#wbls-form-' . $this->form_id . ' .wblsform-row select[name=\''.$val['field_name'].'\']", function() {
                            wbls_condition_'.$this->form_id.'();
                    });';
                    $js .= "\n";

                    $ifValue = $val['value'];
                    $ifCondition = $val['condition'];

                    if(!isset($this->field_options[$val['field_id']]) || !isset($this->field_options[$val['field_id']]['type'])) {
                        continue;
                    }
                    switch ( $this->field_options[$val['field_id']]['type'] ) {
                        case 'radio':
                            $ifFirst = "jQuery(document).find('#wbls-form-" . $this->form_id . " .wblsform-row .wbls-field[name=\"".$val['field_name']."\"]:checked').val()";
                            break;
                        case 'checkbox':
                            if($val['value'] == "1") {
                                $ifArguments .= "jQuery(document).find('#wbls-form-" . $this->form_id . " .wblsform-row .wbls-field[name=\"".$val['field_name']."\"]').prop('checked')";
                            } else {
                                $ifArguments .= "!jQuery(document).find('#wbls-form-" . $this->form_id . " .wblsform-row .wbls-field[name=\"".$val['field_name']."\"]').prop('checked')";
                            }
                            $ifFirst = "jQuery(document).find('#wbls-form-" . $this->form_id . " .wblsform-row .wbls-field[name=\"".$val['field_name']."\"]:checked').val()";
                            break;
                        default:
                            $ifFirst = "jQuery(document).find('#wbls-form-" . $this->form_id . " .wblsform-row .wbls-field[name=\"".$val['field_name']."\"]').val()";
                    }
                    $elementIsVisible = "jQuery(document).find('#wbls-form-" . $this->form_id . " .wblsform-row .wbls-field[name=\"".$val['field_name']."\"]').is(':visible')";
                    if( $this->field_options[$val['field_id']]['type'] != 'checkbox' ) {
                        switch ($ifCondition) {
                            case 'is':
                                $ifArguments .= $ifFirst . ' === ' . "'" . $ifValue . "'";
                                break;
                            case 'is not':
                                $ifArguments .= $ifFirst . ' !== ' . "'" . $ifValue . "'";
                                break;
                            case 'empty':
                                $ifArguments .= $ifFirst . ' === ""';
                                break;
                            case 'not empty':
                                $ifArguments .= $ifFirst . ' !== ""';
                                break;
                        }
                    }
                    $ifArguments .= " && " . $elementIsVisible . " && ";
                }

                $ifArguments = substr($ifArguments, 0, -4);
                if( $ifArguments != "" ) {
                    //$ifArguments = "(" . $ifArguments . ") || ";
                    $if .= "(" . $ifArguments . ") || ";
                }
            }
            $if = substr($if, 0, -4);
            if($if != "") {
                if( $field_conditions['showField'] ) {
                    $jsFunction .= "
                    if( " . $if . " ) {
                        jQuery(document).find('#wbls-form-" . $this->form_id . " .wblsform-row[data-field-id=\"" . $field_id . "\"]').show();
                    } else {
                        jQuery(document).find('#wbls-form-" . $this->form_id . " .wblsform-row[data-field-id=\"" . $field_id . "\"]').hide();
                    }";
                } else {
                    $jsFunction .= "
                    if( " . $if . " ) {
                        jQuery(document).find('#wbls-form-" . $this->form_id . " .wblsform-row[data-field-id=\"" . $field_id . "\"]').hide();
                    } else {
                        jQuery(document).find('#wbls-form-" . $this->form_id . " .wblsform-row[data-field-id=\"" . $field_id . "\"]').show();
                    }";
                }
            }
        }
        $jsFunction .= "\n";
        $jsFunction .= " }";
        $wp_upload_dir = wp_upload_dir();
        $form_dir = '/wbls-system/';
        if ( !is_dir( $wp_upload_dir[ 'basedir' ] . $form_dir ) ) {
            mkdir( $wp_upload_dir[ 'basedir' ] . $form_dir );
            file_put_contents( $wp_upload_dir[ 'basedir' ] . $form_dir . 'index.html', WBLSLibrary::forbidden_template() );
        }

        $wbls_style_dir = $wp_upload_dir[ 'basedir' ] . $form_dir . 'wbls-codition_'.$this->form_id.'.js';
        clearstatcache();
        file_put_contents( $wbls_style_dir, $js . "\n" . $jsFunction . "\n })" );
    }
}