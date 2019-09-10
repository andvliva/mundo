<?php

class  Map_Gray_Scale extends ET_Builder_Module_Map {
	function init() {
		parent::init();
		$this->name            = esc_html__( 'Map Grayscale', 'et_builder' );
		$this->slug            = 'et_pb_map_gray_scale';
		$this->fb_support      = true;
		$this->child_slug      = 'et_pb_map_pin_gray_scale';
		$this->child_item_text = esc_html__( 'Pin', 'et_builder_gray_scale' );
		$this->whitelisted_fields[] = 'percent_gray_scale';
		$this->fields_defaults['percent_gray_scale'] = array( '100' );
	}

	function get_fields() {
		$fields = parent::get_fields();
		$fields['percent_gray_scale'] = array(
			'label'             => esc_html__( 'Percent gray scale', 'liva-divi' ),
			'type'              => 'text',
			'option_category'   => 'configuration',
			'toggle_slug'       => 'main_content',
		);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id               = $this->shortcode_atts['module_id'];
		$module_class            = $this->shortcode_atts['module_class'];
		$address_lat             = $this->shortcode_atts['address_lat'];
		$address_lng             = $this->shortcode_atts['address_lng'];
		$zoom_level              = $this->shortcode_atts['zoom_level'];
		$mouse_wheel             = $this->shortcode_atts['mouse_wheel'];
		$mobile_dragging         = $this->shortcode_atts['mobile_dragging'];
		$use_grayscale_filter    = $this->shortcode_atts['use_grayscale_filter'];
		$grayscale_filter_amount = $this->shortcode_atts['grayscale_filter_amount'];
		$percent_gray_scale        	 = $this->shortcode_atts['percent_gray_scale'];
		$grayscale_filter_amount = $percent_gray_scale ;
		if ( et_pb_enqueue_google_maps_script() ) {
			wp_enqueue_script( 'google-maps-api' );
		}

		$module_class              = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		$video_background          = $this->video_background();
		$parallax_image_background = $this->get_parallax_image_background();

		$all_pins_content = $this->shortcode_content;

		$grayscale_filter_data = '';
		//if ( 'on' === $use_grayscale_filter && '' !== $grayscale_filter_amount ) {
			$grayscale_filter_data = sprintf( ' data-grayscale="%1$s"', esc_attr( $grayscale_filter_amount ) );
		//}

		// Map Tiles: Add CSS Filters and Mix Blend Mode rules (if set)
		if ( array_key_exists( 'child_filters', $this->advanced_options ) && array_key_exists( 'css', $this->advanced_options['child_filters'] ) ) {
			$module_class .= $this->generate_css_filters(
				$function_name,
				'child_',
				self::$data_utils->array_get( $this->advanced_options['child_filters']['css'], 'main', '%%order_class%%' )
			);
		}

		$output = sprintf(
			'<div%5$s class="et_pb_module et_pb_map_container%6$s%10$s%12$s"%8$s>
				%13$s
				%11$s
				<div class="et_pb_map" data-center-lat="%1$s" data-center-lng="%2$s" data-zoom="%3$d" data-mouse-wheel="%7$s" data-mobile-dragging="%9$s"></div>
				%4$s
			</div>',
			esc_attr( $address_lat ),
			esc_attr( $address_lng ),
			esc_attr( $zoom_level ),
			$all_pins_content,
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			esc_attr( $mouse_wheel ),
			$grayscale_filter_data,
			esc_attr( $mobile_dragging ),
			'' !== $video_background ? ' et_pb_section_video et_pb_preload' : '',
			$video_background,
			'' !== $parallax_image_background ? ' et_pb_section_parallax' : '',
			$parallax_image_background
		);

		return $output;
	}

	public function process_box_shadow( $function_name ) {
		$boxShadow = ET_Builder_Module_Fields_Factory::get( 'BoxShadow' );

		self::set_style( $function_name, $boxShadow->get_style(
			'.' . self::get_module_order_class( $function_name ),
			$this->shortcode_atts
		) );
	}
}

new Map_Gray_Scale;
