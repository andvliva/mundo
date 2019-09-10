<?php

class Custom_Text_Fullwidth extends ET_Builder_Module_Text {
    function init() {
        parent::init();
        $this->name       = esc_html__( 'Custom Text Fullwidth', 'liva-divi' );
        $this->slug       = 'et_pb_text_fullwidth';
        $this->fb_support = true;
        $this->fullwidth  = true;
        $this->fields_defaults['module_class'] = array('text-fullwidth');
    }
}
new Custom_Text_Fullwidth;