<?php

class Custom_Gallery_Masonry extends ET_Builder_Module_Slider {
    function init() {
        parent::init();
		$this->name            = esc_html__( 'Gallery Masonry', 'liva-divi' );
		$this->slug            = 'et_pb_slider_gallery_masonry';
		$this->fb_support      = true;
		$this->child_slug      = 'et_pb_slide_gallery_masonry';
		$this->child_item_text = esc_html__( 'Slide Gallery Masonry', 'liva-divi' );
    }
    
}
new Custom_Gallery_Masonry;