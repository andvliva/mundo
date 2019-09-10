<?php

class Custom_Title_Overview extends ET_Builder_Module_Text {
    function init() {
       parent::init();
       $this->name       = esc_html__( 'Text Title Overview', 'liva-divi' );
       $this->slug       = 'et_pb_text_title_overview';
       $this->fields_defaults['module_class'] = array('text-title-overview');
    }
}
new Custom_Title_Overview;