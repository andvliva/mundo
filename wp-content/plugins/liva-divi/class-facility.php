<?php

class Custom_Facility extends ET_Builder_Module_Text {
    function init() {
       //parent::init();
       $this->name       = esc_html__( 'Ship facility', 'liva-divi' );
       $this->slug       = 'et_pb_text_ship_facility';
       $this->fields_defaults['module_class'] = array('text-ship-facility');
    }

    function shortcode_callback( $atts, $content = null, $function_name ) {
        global $post;
        //d($post);
		$module_id            = $this->shortcode_atts['module_id'];
		$module_class         = $this->shortcode_atts['module_class'];
		$background_layout    = $this->shortcode_atts['background_layout'];
		$ul_type              = $this->shortcode_atts['ul_type'];
		$ul_position          = $this->shortcode_atts['ul_position'];
		$ul_item_indent       = $this->shortcode_atts['ul_item_indent'];
		$ol_type              = $this->shortcode_atts['ol_type'];
		$ol_position          = $this->shortcode_atts['ol_position'];
		$ol_item_indent       = $this->shortcode_atts['ol_item_indent'];
		$quote_border_weight  = $this->shortcode_atts['quote_border_weight'];
		$quote_border_color   = $this->shortcode_atts['quote_border_color'];

        // some themes do not include these styles/scripts so we need to enqueue them in this module to support audio post format
        //wp_enqueue_style( 'custom-jquery.marquee-css', plugins_url( '/css/custom-post-marquee.css', __FILE__ ) );
		wp_enqueue_script( 'masonry.pkgd-js', plugins_url( '/js/masonry.pkgd.min.js', __FILE__ ), array('jquery'), false, true );
		//wp_enqueue_script( 'custom-jquery.marquee-js', plugins_url( '/js/custom-post-marquee.js', __FILE__ ), array(), false, true );

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		$this->shortcode_content = et_builder_replace_code_content_entities( $this->shortcode_content );

		$video_background = $this->video_background();
		$parallax_image_background = $this->get_parallax_image_background();
        
        $posts_facility = get_posts(array(
            'post_type' => 'facility',
            'numberposts' => 7,
            'meta_query' => array(
                'ship' => array(
                    'key' => 'ship',
                    'value' => $post->ID,
                ),
            ),
        ));
        //d($posts_facility);
        $tmp = array();
        $i = 0;
        foreach($posts_facility as $item) {
            $excerpt = $item->post_excerpt;
            $image_id = get_post_meta($item->ID, 'images', true) ?: 0;
            $i++;
            if($i == 8) {
                $i = 1;
            }
            $image_size = in_array($i, array(1,2,3,6,7)) ? 'facility_1' : ( $i == 4 ? 'facility_2' : ($i == 5 ? 'facility_3' : '') );
            if($image_size) {
                $src = $this->get_attachment_image_src($image_id, $image_size);
                //d("$image_id, $image_size");
                $html  = '<div class="grid-item"><div class="facility-item">';
                $html .= "<img src='{$src}' alt='{$item->post_title}' />";
                $html .= '<div class="facility-item-info">';
                $html .= '<div class="facility-item-title">' . $item->post_title . '</div>';
                $html .= '<div class="facility-item-desc">' . $excerpt . '</div>';
                $html .= '</div></div></div>';
                $tmp[] = $html;
            }
        }
        $this->shortcode_content = implode('', $tmp);
        $data_masonry = array(
            'gutter' => 5,
        );


		$class = " et_pb_module et_pb_bg_layout_{$background_layout}";

		$output = sprintf(
			'<div%3$s class="et_pb_text%2$s%4$s ">
				<div class="masonry-grid grid" data-masonry="%5$s">
					%1$s
				</div>
			</div> <!-- .et_pb_text -->',
			$this->shortcode_content,
			esc_attr( $class ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
            htmlspecialchars(json_encode($data_masonry))
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
new Custom_Facility;


