<?php

class Custom_Suite_Gallery extends ET_Builder_Module_Text {
    function init() {
       //parent::init();
       $this->name       = esc_html__( 'Suite Gallery', 'liva-divi' );
       $this->slug       = 'et_pb_text_suite_gallery';
       $this->fields_defaults['module_class'] = array('custom-suite-gallery');
    }

    function shortcode_callback( $atts, $content = null, $function_name ) {
        global $post;
        //d($post);
//		$module_id            = $this->shortcode_atts['module_id'];
		$module_class         = $this->shortcode_atts['module_class'];
//		$background_layout    = $this->shortcode_atts['background_layout'];
//		$ul_type              = $this->shortcode_atts['ul_type'];
//		$ul_position          = $this->shortcode_atts['ul_position'];
//		$ul_item_indent       = $this->shortcode_atts['ul_item_indent'];
//		$ol_type              = $this->shortcode_atts['ol_type'];
//		$ol_position          = $this->shortcode_atts['ol_position'];
//		$ol_item_indent       = $this->shortcode_atts['ol_item_indent'];
//		$quote_border_weight  = $this->shortcode_atts['quote_border_weight'];
//		$quote_border_color   = $this->shortcode_atts['quote_border_color'];

        // some themes do not include these styles/scripts so we need to enqueue them in this module to support audio post format
        wp_enqueue_style( 'slick.css', plugins_url( '/js/slick/slick.css', __FILE__ ) );
        wp_enqueue_style( 'slick-theme.css', plugins_url( '/js/slick/slick-theme.css', __FILE__ ) );
		wp_enqueue_script( 'slick.min.js', plugins_url( '/js/slick/slick.min.js', __FILE__ ), array('jquery'), false, true );
		wp_enqueue_script( 'custom-slick', plugins_url( '/js/custom-slick.js', __FILE__ ), array('slick.min.js'), false, true );

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		$this->shortcode_content = '';
        
        $images = get_post_meta($post->ID, 'images') ?: array();
        d($images);
        $tmp = $tmp2 = array();
        foreach($images as $image_id) {
            $src = $this->get_attachment_image_src($image_id, 'suite');
            $tmp[] = sprintf('<img src="%s" alt="%s"/>', $src, $post->post_title);
            
            $src = $this->get_attachment_image_src($image_id, 'suite_thumb');
            $tmp2[] = sprintf('<div><img src="%s" alt="%s"/></div>', $src, $post->post_title);
        }
        $this->shortcode_content = implode('', $tmp);
        $content_thumb = implode('', $tmp2);
        
        $data_slick = array(
            'slidesToShow' => 1,
            'slidesToScroll' => 1,
            'arrows' => false,
            'fade' => true,
            'asNavFor' => '.slider-nav'
        );
        $data_slick_thumb = array(
            'slidesToShow' => 4,
            'slidesToScroll' => 1,
            'arrows' => true,
            'asNavFor' => '.slider-for',
            'focusOnSelect' => true,
            // 'centerMode' => true,
            // 'focusOnSelect' => true
        );


		$class = " et_pb_module et_pb_bg_layout_{$background_layout}";

		$output = sprintf(
			'<div%3$s class="et_pb_text%2$s%4$s ">
				<div class="slider slider-for" data-slick="%5$s">
					%1$s
				</div>
                <div class="slider slider-nav" data-slick="%7$s">
                    %6$s
                </div>
			</div> <!-- .et_pb_text -->',
			$this->shortcode_content,
			esc_attr( $class ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
            htmlspecialchars(json_encode($data_slick)),
            $content_thumb,
            htmlspecialchars(json_encode($data_slick_thumb))
		);

		return $output;
	}
    
    function get_attachment_image_src( $att_id, $image_size ) {
        if( function_exists( 'fly_get_attachment_image_src' ) ) {
            $image = fly_get_attachment_image_src( $att_id, $image_size );
            return $image['src'];
        }
        return 'fly_get_attachment_image_src';
    }
}
new Custom_Suite_Gallery;