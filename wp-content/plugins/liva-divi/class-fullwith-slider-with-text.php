<?php

class ET_Builder_Module_Fullwidth_Slider_With_Text extends ET_Builder_Module_Fullwidth_Slider {
	function init() {
		parent::init();
		$this->name            = esc_html__( 'Fullwidth Slider With Text', 'et_builder' );
		$this->slug            = 'et_pb_fullwidth_slider_with_text';
		$this->fb_support      = true;
		$this->fullwidth       = true;
		$this->child_slug      = 'et_pb_slide_with_text';
		$this->child_item_text = esc_html__( 'Slide with text', 'et_builder' );
		$this->whitelisted_fields[] = 'more_text';
	}

	function get_fields() {
		$fields = parent::get_fields();
        $fields['more_text'] = array(
			'label'             => esc_html__( 'More text', 'liva-divi' ),
			'type'              => 'text',
			'option_category'   => 'configuration',
			'toggle_slug'       => 'main_content',
		);
		return $fields;
	}

	function pre_shortcode_content() {
		global $et_pb_slider_has_video, $et_pb_slider_parallax, $et_pb_slider_parallax_method, $et_pb_slider_show_mobile, $et_pb_slider_custom_icon, $et_pb_slider_item_num, $et_pb_slider_button_rel;

		$et_pb_slider_item_num = 0;

		$parallax        = $this->shortcode_atts['parallax'];
		$parallax_method = $this->shortcode_atts['parallax_method'];
		$show_content_on_mobile  = $this->shortcode_atts['show_content_on_mobile'];
		$show_cta_on_mobile      = $this->shortcode_atts['show_cta_on_mobile'];
		$button_rel              = $this->shortcode_atts['button_rel'];
		$button_custom           = $this->shortcode_atts['custom_button'];
		$custom_icon             = $this->shortcode_atts['button_icon'];
		$more_text        	 = $this->shortcode_atts['more_text'];
		$et_pb_slider_has_video = false;

		$et_pb_slider_parallax = $parallax;

		$et_pb_slider_parallax_method = $parallax_method;

		$et_pb_slider_show_mobile = array(
			'show_content_on_mobile'  => $show_content_on_mobile,
			'show_cta_on_mobile'      => $show_cta_on_mobile,
		);

		$et_pb_slider_custom_icon = 'on' === $button_custom ? $custom_icon : '';
		$et_pb_slider_button_rel  = $button_rel;

		// Pass Fullwidth Slider Module settings to Slide Item
		global $et_pb_slider;

		$et_pb_slider = array(
			'background_color'                           => $this->shortcode_atts['background_color'],
			'use_background_color_gradient'              => $this->shortcode_atts['use_background_color_gradient'],
			'background_color_gradient_type'             => $this->shortcode_atts['background_color_gradient_type'],
			'background_color_gradient_direction'        => $this->shortcode_atts['background_color_gradient_direction'],
			'background_color_gradient_direction_radial' => $this->shortcode_atts['background_color_gradient_direction_radial'],
			'background_color_gradient_start'            => $this->shortcode_atts['background_color_gradient_start'],
			'background_color_gradient_end'              => $this->shortcode_atts['background_color_gradient_end'],
			'background_color_gradient_start_position'   => $this->shortcode_atts['background_color_gradient_start_position'],
			'background_color_gradient_end_position'     => $this->shortcode_atts['background_color_gradient_end_position'],
			'background_image'                           => $this->shortcode_atts['background_image'],
			'background_size'                            => $this->shortcode_atts['background_size'],
			'background_position'                        => $this->shortcode_atts['background_position'],
			'background_repeat'                          => $this->shortcode_atts['background_repeat'],
			'background_blend'                           => $this->shortcode_atts['background_blend'],
			'parallax'                                   => $this->shortcode_atts['parallax'],
			'parallax_method'                            => $this->shortcode_atts['parallax_method'],
			'background_video_mp4'                       => $this->shortcode_atts['background_video_mp4'],
			'background_video_webm'                      => $this->shortcode_atts['background_video_webm'],
			'background_video_width'                     => $this->shortcode_atts['background_video_width'],
			'background_video_height'                    => $this->shortcode_atts['background_video_height'],
			'header_level'                               => $this->shortcode_atts['header_level'],
		);
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
		$show_image_video_mobile = $this->shortcode_atts['show_image_video_mobile'];
		$background_position     = $this->shortcode_atts['background_position'];
		$background_size         = $this->shortcode_atts['background_size'];

		global $et_pb_slider_has_video, $et_pb_slider_parallax, $et_pb_slider_parallax_method, $et_pb_slider_show_mobile, $et_pb_slider_custom_icon, $et_pb_slider;

		$content = $this->shortcode_content;

		$module_class              = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		if ( '' !== $background_position && 'default' !== $background_position && 'off' === $parallax ) {
			$processed_position = str_replace( '_', ' ', $background_position );

			ET_Builder_Module::set_style( $function_name, array(
				'selector'    => '%%order_class%% .et_pb_slide',
				'declaration' => sprintf(
					'background-position: %1$s;',
					esc_html( $processed_position )
				),
			) );
		}

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

		$output = sprintf(
			'<div%4$s class="et_pb_module et_pb_slider%1$s%3$s%5$s">
				<div class="et_pb_slides">
					%2$s
				</div> <!-- .et_pb_slides -->
				%6$s
			</div> <!-- .et_pb_slider -->
			',
			esc_attr( $class ),
			$content,
			( $et_pb_slider_has_video ? ' et_pb_preload' : '' ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			$this->inner_shadow_back_compatibility( $function_name )
		);

		// Reset passed slider item value
		$et_pb_slider = array();

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

new ET_Builder_Module_Fullwidth_Slider_With_Text;
