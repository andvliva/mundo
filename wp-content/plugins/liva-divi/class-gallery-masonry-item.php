<?php

class Custom_Gallery_Masonry_Item extends ET_Builder_Module_Slider_Item {
    function init() {
        parent::init();
		$this->name                        = esc_html__( 'Slide Gallery Masonry', 'liva-divi' );
		$this->slug                        = 'et_pb_slide_gallery_masonry';
		$this->fb_support                  = true;
		$this->type                        = 'child';
        
        $this->advanced_setting_title_text = esc_html__( 'New Slide Gallery Masonry', 'liva-divi' );
		$this->settings_text               = esc_html__( 'Slide Gallery Masonry Settings', 'liva-divi' );
    }
    
}
new Custom_Gallery_Masonry_Item;