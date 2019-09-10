<?php

class Custom_Suite_Icons extends ET_Builder_Module_Text {
    function init() {
       //parent::init();
       $this->name       = esc_html__( 'Suite Icons', 'liva-divi' );
       $this->slug       = 'et_pb_text_suite_icons';
       $this->fields_defaults['module_class'] = array('custom-suite-icons');
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
        //wp_enqueue_style( 'slick.css', plugins_url( '/js/slick/slick.css', __FILE__ ) );
        //wp_enqueue_style( 'slick-theme.css', plugins_url( '/js/slick/slick-theme.css', __FILE__ ) );
		//wp_enqueue_script( 'slick.min.js', plugins_url( '/js/slick/slick.min.js', __FILE__ ), array('jquery'), false, true );
		//wp_enqueue_script( 'custom-slick', plugins_url( '/js/custom-slick.js', __FILE__ ), array('slick.min.js'), false, true );

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		$this->shortcode_content = '';
        
        $icons = get_post_meta($post->ID, 'icons', true) ?: array();
        //d($icons);
        $tmp = array();
        foreach($icons as $item) {
            $tooltip = '[tooltip text="%s"]%s[/tooltip]';
            $image_id = reset($item['image']);
            $src = $this->get_attachment_image_src($image_id, 'suite_icon');
            $icon = sprintf('<img src="%s" alt="%s"/>', $src, $item['title']);
            
            $tmp[] = sprintf($tooltip, $item['title'], $icon);
        }
        $this->shortcode_content = implode('', $tmp);
        //d($this->shortcode_content);
        $this->shortcode_content = do_shortcode($this->shortcode_content);
		$class = " et_pb_module et_pb_bg_layout_{$background_layout}";

		$output = sprintf(
			'<div%3$s class="et_pb_text%2$s%4$s ">
				<div class="">
					%1$s
				</div>
			</div> <!-- .et_pb_text -->',
			$this->shortcode_content,
			esc_attr( $class ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
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
new Custom_Suite_Icons;