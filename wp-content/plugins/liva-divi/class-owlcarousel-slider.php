<?php
class Custom_Owlcarousel_Slider extends ET_Builder_Module_Slider {
    function init() {
        parent::init();
        $this->name            = esc_html__( 'Custom slider owlcarousel', 'liva-divi' );
		$this->slug            = 'et_pb_custom_slider_owlcarousel';
		$this->fb_support      = true;
		$this->child_slug      = 'et_pb_custom_slide_owlcarousel';
		$this->child_item_text = esc_html__( 'Slide owlcarousel', 'liva-divi' );
        
        $this->whitelisted_fields[] = 'owl_items';
       	$this->whitelisted_fields[] = 'owl_margin';
        
        $this->options_toggles['advanced']['toggles']['owlcarousel_options'] = esc_html__( 'OwlCarousel options', 'liva-divi' );
        $this->fields_defaults['more_text'] = array( 'Read More' );
        $this->fields_defaults['owl_items'] = array( 3 );
    }
    
    function get_fields() {
        $fields = parent::get_fields();
        $fields['owl_items'] = array(
			'label'             => esc_html__( 'Owl items', 'liva-divi' ),
			'type'              => 'text',
			'option_category'   => 'owlcarousel_options',
			'description'       => '',
            'tab_slug'           => 'advanced',
			'toggle_slug'        => 'owlcarousel_options',
		);
        $fields['owl_margin'] = array(
			'label'             => esc_html__( 'Owl margin', 'liva-divi' ),
			'type'              => 'text',
			'option_category'   => 'owlcarousel_options',
			'description'       => '',
            'tab_slug'           => 'advanced',
			'toggle_slug'        => 'owlcarousel_options',
		);
        return $fields;
    }

    function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id               = $this->shortcode_atts['module_id'];
		$module_class            = $this->shortcode_atts['module_class'];
		$show_arrows             = $this->shortcode_atts['show_arrows'];
		$show_pagination         = $this->shortcode_atts['show_pagination'];
		$parallax                = $this->shortcode_atts['parallax'];
		$parallax_method         = $this->shortcode_atts['parallax_method'];
		$auto                    = $this->shortcode_atts['auto'];
		$auto_speed              = $this->shortcode_atts['auto_speed'];
		$auto_ignore_hover       = $this->shortcode_atts['auto_ignore_hover'];
		$body_font_size          = $this->shortcode_atts['body_font_size'];
		$show_content_on_mobile  = $this->shortcode_atts['show_content_on_mobile'];
		$show_cta_on_mobile      = $this->shortcode_atts['show_cta_on_mobile'];
		$show_image_video_mobile = $this->shortcode_atts['show_image_video_mobile'];
		$background_position     = $this->shortcode_atts['background_position'];
		$background_size         = $this->shortcode_atts['background_size'];
		$owl_items = intval($this->shortcode_atts['owl_items']);
        $owl_margin = intval($this->shortcode_atts['owl_margin']);


		global $et_pb_slider_has_video, $et_pb_slider_parallax, $et_pb_slider_parallax_method, $et_pb_slider_show_mobile, $et_pb_slider_custom_icon, $et_pb_slider_owlcarousel;
        
		// some themes do not include these styles/scripts so we need to enqueue them in this module to support audio post format
        wp_enqueue_style( 'carousel-css', plugins_url( '/js/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css', __FILE__ ) );
        wp_enqueue_style( 'carousel-default-css', plugins_url( '/js/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css', __FILE__ ) );
		wp_enqueue_script( 'OwlCarousel-js', plugins_url( '/js/OwlCarousel2-2.3.4/dist/owl.carousel.min.js', __FILE__ ), array('jquery'), false, true );
		wp_enqueue_script( 'custom-OwlCarousel-js', plugins_url( '/js/custom-OwlCarousel.js', __FILE__ ), array(), false, true );


		$content = $this->shortcode_content;

		$module_class              = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		$video_background          = $this->video_background();
		$parallax_image_background = $this->get_parallax_image_background();

		if ( '' !== $background_position && 'default' !== $background_position  && 'off' === $parallax ) {
			$processed_position = str_replace( '_', ' ', $background_position );

			ET_Builder_Module::set_style( $function_name, array(
				'selector'    => '%%order_class%% .et_pb_slide',
				'declaration' => sprintf(
					'background-position: %1$s;',
					esc_html( $processed_position )
				),
			) );
		}

		// Handle slider's previous background size default value ("default") as well
		if ( '' !== $background_size && 'default' !== $background_size && 'off' === $parallax ) {
			ET_Builder_Module::set_style( $function_name, array(
				'selector'    => '%%order_class%% .et_pb_slide',
				'declaration' => sprintf(
					'-moz-background-size: %1$s;
					-webkit-background-size: %1$s;
					background-size: %1$s;',
					esc_html( $background_size )
				),
			) );
		}

		$fullwidth = 'et_pb_fullwidth_slider' === $function_name ? 'on' : 'off';

		$class  = '';
		$class .= 'off' === $fullwidth ? ' et_pb_slider_fullwidth_off' : '';
		$class .= 'off' === $show_arrows ? ' et_pb_slider_no_arrows' : '';
		$class .= 'off' === $show_pagination ? ' et_pb_slider_no_pagination' : '';
		$class .= 'on' === $parallax ? ' et_pb_slider_parallax' : '';
		$class .= 'on' === $auto ? ' et_slider_auto et_slider_speed_' . esc_attr( $auto_speed ) : '';
		$class .= 'on' === $auto_ignore_hover ? ' et_slider_auto_ignore_hover' : '';
		$class .= 'on' === $show_image_video_mobile ? ' et_pb_slider_show_image' : '';

		$owlCarousel_options = array(
            'nav' => true,
            'items' => $owl_items ? $owl_items : 3,
            'margin' => $owl_margin,
            'loop' => true,
        );
        $owlCarousel_options = apply_filters('post_owlCarousel_options', $owlCarousel_options, $module_id);
        $owlCarousel_options = htmlspecialchars(json_encode($owlCarousel_options));

		$output = sprintf(
			'<div%4$s class="et_pb_module et_pb_slider%1$s%3$s%5$s">
                <div class="owlcarousel-container">
                    <div class="owl-carousel owl-theme" data-options="%7$s">
    					%2$s
                    </div>
                </div>
				%6$s
			</div> <!-- .et_pb_slider -->
			',
			esc_attr( $class ),
			$content,
			( $et_pb_slider_has_video ? ' et_pb_preload' : '' ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			$this->inner_shadow_back_compatibility( $function_name ),
			$owlCarousel_options
		);

		// Reset passed slider item value
		$et_pb_slider_owlcarousel = array();

		return $output;
	}

	public function process_box_shadow( $function_name ) {
		$boxShadow = ET_Builder_Module_Fields_Factory::get( 'BoxShadow' );
		$selector  = '.' . self::get_module_order_class( $function_name );

		if ( isset( $this->shortcode_atts['custom_button'] ) && 'on' === $this->shortcode_atts['custom_button'] ) {
			self::set_style( $function_name, array(
				'selector'    => $selector . ' .et_pb_button',
				'declaration' => $boxShadow->get_value( $this->shortcode_atts, array( 'suffix' => '_button' ) )
			) );
		}

		self::set_style( $function_name, $boxShadow->get_style( $selector, $this->shortcode_atts ) );
	}

	private function inner_shadow_back_compatibility( $functions_name ) {
		$utils = ET_Core_Data_Utils::instance();
		$atts  = $this->shortcode_atts;
		$style = '';

		if (
			version_compare( $utils->array_get( $atts, '_builder_version', '3.0.93' ), '3.0.99', 'lt' )
		) {
			$class = self::get_module_order_class( $functions_name );
			$style = sprintf(
				'<style>%1$s</style>',
				sprintf(
					'.%1$s.et_pb_slider .et_pb_slide {'
					. '-webkit-box-shadow: none; '
					. '-moz-box-shadow: none; '
					. 'box-shadow: none; '
					.'}',
					esc_attr( $class )
				)
			);

			if ( 'off' !== $utils->array_get( $atts, 'show_inner_shadow' ) ) {
				$style .= sprintf(
					'<style>%1$s</style>',
					sprintf(
						'.%1$s > .box-shadow-overlay { '
						. '-webkit-box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1); '
						. '-moz-box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1); '
						. 'box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1); '
						. '}',
						esc_attr( $class )
					)
				);
			}
		}

		return $style;
	}
}
new Custom_Owlcarousel_Slider;