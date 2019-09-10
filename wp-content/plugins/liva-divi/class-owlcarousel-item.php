<?php

class Custom_Slider_Owlcarousel_Item extends ET_Builder_Module_Slider_Item {
	function init() {
        parent::init();
		$this->name                        = esc_html__( 'Slide Owlcarousel Item', 'liva-divi' );
		$this->slug                        = 'et_pb_custom_slide_owlcarousel';
		$this->fb_support                  = true;
		$this->type                        = 'child';
		$this->child_title_var             = 'admin_title';
		$this->child_title_fallback_var    = 'heading';
		$this->whitelisted_fields[] = 'title_before_image';
	}
	function get_fields() {
        $fields = parent::get_fields();
        $fields['title_before_image'] = array(
			'label'             => esc_html__( 'Title before images', 'liva-divi' ),
			'type'              => 'yes_no_button',
			'option_category'   => 'configuration',
			'options'           => array(
				'off' => esc_html__( 'No', 'liva-divi' ),
				'on'  => esc_html__( 'Yes', 'liva-divi' ),
			),
			'toggle_slug'       => 'main_content',
		);
        return $fields;
    }
	static function get_video_embed( $args = array(), $conditonal_args = array(), $current_page = array() ) {
		global $wp_embed;

		$video_url = esc_url( $args['video_url'] );

		$autoembed      = $wp_embed->autoembed( $video_url );
		$is_local_video = has_shortcode( $autoembed, 'video' );
		$video_embed    = '';

		if ( $is_local_video ) {
			$video_embed = wp_video_shortcode( array( 'src' => $video_url ) );
		} else {
			$video_embed = wp_oembed_get( $video_url );

			$video_embed = preg_replace( '/<embed /','<embed wmode="transparent" ', $video_embed );

			$video_embed = preg_replace( '/<\/object>/','<param name="wmode" value="transparent" /></object>', $video_embed );
		}

		return $video_embed;
	}

	function maybe_inherit_values() {
		// Inheriting slider attribute
		global $et_pb_slider_owlcarousel;

		// Attribute inheritance should be done on front-end / published page only.
		// Don't run attribute inheritance in VB and Backend to avoid attribute inheritance accidentally being saved on VB / BB
		if ( ! empty( $et_pb_slider_owlcarousel ) && ! is_admin() && ! et_fb_is_enabled() ) {
			foreach ( $et_pb_slider_owlcarousel as $slider_attr => $slider_attr_value ) {
				// Get default value
				$default = isset( $this->fields_unprocessed[ $slider_attr ][ 'default' ] ) ? $this->fields_unprocessed[ $slider_attr ][ 'default' ] : '';

				if ( isset( $this->fields_defaults[ $slider_attr ] ) && isset( $this->fields_defaults[ $slider_attr ][0] ) ) {
					$default = $this->fields_defaults[ $slider_attr ][0];
				}

				// Slide item isn't empty nor default
				if ( ! in_array( $this->shortcode_atts[ $slider_attr ], array( '', $default ) ) ) {
					continue;
				}

				// Slider value is equal to empty or slide item's default
				if ( in_array( $slider_attr_value, array( '', $default ) ) ) {
					continue;
				}

				// Overwrite slider item's empty / default value
				$this->shortcode_atts[ $slider_attr ] = $slider_attr_value;
			}
		}
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id               = $this->shortcode_atts['module_id'];
		$alignment            = $this->shortcode_atts['alignment'];
		$heading              = $this->shortcode_atts['heading'];
		$button_text          = $this->shortcode_atts['button_text'];
		$button_link          = $this->shortcode_atts['button_link'];
		$image                = $this->shortcode_atts['image'];
		$image_alt            = $this->shortcode_atts['image_alt'];
		$background_layout    = $this->shortcode_atts['background_layout'];
		$video_url            = $this->shortcode_atts['video_url'];
		$dot_nav_custom_color = $this->shortcode_atts['dot_nav_custom_color'];
		$arrows_custom_color  = $this->shortcode_atts['arrows_custom_color'];
		$custom_icon          = $this->shortcode_atts['button_icon'];
		$button_custom        = $this->shortcode_atts['custom_button'];
		$button_rel           = $this->shortcode_atts['button_rel'];
		$use_bg_overlay       = $this->shortcode_atts['use_bg_overlay'];
		$bg_overlay_color     = $this->shortcode_atts['bg_overlay_color'];
		$use_text_overlay     = $this->shortcode_atts['use_text_overlay'];
		$text_overlay_color   = $this->shortcode_atts['text_overlay_color'];
		$text_border_radius   = $this->shortcode_atts['text_border_radius'];
		$header_level         = $this->shortcode_atts['header_level'];
		$video_background          = $this->video_background();
		$parallax_image_background = $this->get_parallax_image_background();
		$title_before_image = $this->shortcode_atts['title_before_image'];

		global $et_pb_slider_has_video, $et_pb_slider_parallax, $et_pb_slider_parallax_method, $et_pb_slider_show_mobile, $et_pb_slider_custom_icon, $et_pb_slider_item_num, $et_pb_slider_button_rel;

		$et_pb_slider_item_num++;

		$hide_on_mobile_class = self::HIDE_ON_MOBILE;

		$is_text_overlay_applied = 'on' === $use_text_overlay;

		$custom_slide_icon = 'on' === $button_custom && '' !== $custom_icon ? $custom_icon : $et_pb_slider_custom_icon;

		if ( '' !== $heading ) {
			if ( '#' !== $button_link ) {
				$heading = sprintf( '<a href="%1$s">%2$s</a>',
					esc_url( $button_link ),
					$heading
				);
			}

			$heading = sprintf( '<%1$s class="et_pb_slide_title">%2$s</%1$s>', et_pb_process_header_level( $header_level, 'h2' ), $heading );
		}

		// Overwrite button rel with pricin tables' button_rel if needed
		if ( in_array( $button_rel, array( '', 'off|off|off|off|off' ) ) && '' !== $et_pb_slider_button_rel ) {
			$button_rel = $et_pb_slider_button_rel;
		}

		$button = '';
		if ( '' !== $button_text ) {
			$button = sprintf( '<div class="et_pb_button_wrapper"><a href="%1$s" class="et_pb_more_button et_pb_button%3$s%5$s"%4$s%6$s>%2$s</a></div>',
				esc_url( $button_link ),
				esc_html( $button_text ),
				( 'on' !== $et_pb_slider_show_mobile['show_cta_on_mobile'] ? esc_attr( " {$hide_on_mobile_class}" ) : '' ),
				'' !== $custom_slide_icon ? sprintf(
					' data-icon="%1$s"',
					esc_attr( et_pb_process_font_icon( $custom_slide_icon ) )
				) : '',
				'' !== $custom_slide_icon ? ' et_pb_custom_button_icon' : '',
				$this->get_rel_attributes( $button_rel )
			);
		}

		$style = $class = '';

		if ( 'on' === $use_bg_overlay && '' !== $bg_overlay_color ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%%.et_pb_slide .et_pb_slide_overlay_container',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $bg_overlay_color )
				),
			) );
		}

		if ( $is_text_overlay_applied && '' !== $text_overlay_color ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%%.et_pb_slide .et_pb_text_overlay_wrapper',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $text_overlay_color )
				),
			) );
		}

		if ( '' !== $text_border_radius ) {
			$border_radius_value = et_builder_process_range_value( $text_border_radius );
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%%.et_pb_slider_with_text_overlay .et_pb_text_overlay_wrapper',
				'declaration' => sprintf(
					'border-radius: %1$s;',
					esc_html( $border_radius_value )
				),
			) );
		}
		if( $title_before_image == 'on' ) {
				$heading_before_img = sprintf( '<%1$s class="et_pb_slide_title_before">%2$s</%1$s>', et_pb_process_header_level( $header_level, 'h2' ), $heading );
            }
		$style = '' !== $style ? " style='{$style}'" : '';

		// $post_img = get_post( getIDfromGUID($image) );
		// d($post_img);
		// $att_id = $post_img->ID;
		//$image = mundo_get_attachment_image_src($att_id,'hotel_detail');
		$image = '' !== $image
			? sprintf( '<div class="et_pb_slide_image2"><img src="%1$s" alt="%2$s" /></div>',
				esc_url( $image ),
				esc_attr( $image_alt )
			)
			: '';

		if ( '' !== $video_url ) {
			$video_embed = self::get_video_embed(array(
				'video_url' => $video_url,
			));

			$image = sprintf( '<div class="et_pb_slide_video">%1$s</div>',
				$video_embed
			);
		}

		if ( '' !== $image ) $class = ' et_pb_slide_with_image';

		if ( '' !== $video_url ) $class .= ' et_pb_slide_with_video';

		$class .= " et_pb_bg_layout_{$background_layout}";

		$class .= 'on' === $use_bg_overlay ? ' et_pb_slider_with_overlay' : '';
		$class .= 'on' === $use_text_overlay ? ' et_pb_slider_with_text_overlay' : '';

		if ( 'bottom' !== $alignment ) {
			$class .= " et_pb_media_alignment_{$alignment}";
		}

		$data_dot_nav_custom_color = '' !== $dot_nav_custom_color
			? sprintf( ' data-dots_color="%1$s"', esc_attr( $dot_nav_custom_color ) )
			: '';

		$data_arrows_custom_color = '' !== $arrows_custom_color
			? sprintf( ' data-arrows_color="%1$s"', esc_attr( $arrows_custom_color ) )
			: '';

		$class = ET_Builder_Element::add_module_order_class( $class, $function_name );

		// Images: Add CSS Filters and Mix Blend Mode rules (if set)
		if ( array_key_exists( 'image', $this->advanced_options ) && array_key_exists( 'css', $this->advanced_options['image'] ) ) {
			$class .= $this->generate_css_filters(
				$function_name,
				'child_',
				self::$data_utils->array_get( $this->advanced_options['image']['css'], 'main', '%%order_class%%' )
			);
		}

		if ( 1 === $et_pb_slider_item_num ) {
			$class .= " et-pb-active-slide";
		}

		$shortcode_content = $this->shortcode_content;
		//kiểm tra <!--more--> có trong $shortcode_content ko. Nếu có thì vẽ cái button ra
		$check = false;
		if (strpos($shortcode_content, '<p><!--more--></p>') !== false) {
			$check ='<p><!--more--></p>';
		}elseif (strpos($shortcode_content, '<!--more-->') !== false) {
			$check ='<!--more-->';
		}elseif (strpos($shortcode_content, '<span id="more-119"></span>') !== false) {
			$check ='<span id="more-119"></span>';
		}
		if ($check) {
			$arr_content = explode($check, $shortcode_content);
		}
			// $shortcode_content = '<div class="left-content">'.str_replace( '<!--more-->', '</div><div class="btn-content"><a class="et_pb_button be_inspried_more et_pb_button_1 et_pb_module et_pb_bg_layout_light" href="#">BE INSPIRED MORE</a></div><div class="right-content">', $shortcode_content ).'</div>';

		// $shortcode_content = '<div class="left-content">'.$arr_content[0].'</div>';
		// $shortcode_content .=  '<div class="right-content">'.$arr_content[1].'</div>';
		$shortcode_content = '<div class="owl-content">'.$this->shortcode_content.'</div>';
		$shortcode_content .= '<div class="text-left"><hr><div class="clear-both"></div></div>';
		$shortcode_content .= '<div class="btn-content"><a href='.$button_link.' class="et_pb_button be_inspried_more et_pb_button_1 et_pb_module et_pb_bg_layout_light">SEE MORE</a></div>';
		$slide_content = sprintf(
			'%1$s
				<div class="et_pb_slide_content%3$s">%2$s</div>',
			$heading,
			$shortcode_content,
			( 'on' !== $et_pb_slider_show_mobile['show_content_on_mobile'] ? esc_attr( " {$hide_on_mobile_class}" ) : '' )
		);

		//apply text overlay wrapper
		if ( $is_text_overlay_applied ) {
			$slide_content = sprintf(
				'<div class="et_pb_text_overlay_wrapper">
					%1$s
				</div>',
				$slide_content
			);
		}

		$output = sprintf(
			'<div class="item"%3$s%8$s%9$s>
				%7$s
				%10$s
				<div class="et_pb_container clearfix">
					<div class="et_pb_slider_container_inner">
						%13$s
						%4$s
						<div class="wrapper-content-slider-owl">
							%1$s
							%2$s
						</div> 
					</div>
				</div> <!-- .et_pb_container -->
				%6$s
			</div> <!-- .et_pb_slide -->
			',
			$slide_content,
			$button,
			$style,
			$image,
			esc_attr( $class ),
			$video_background,
			$parallax_image_background,
			$data_dot_nav_custom_color,
			$data_arrows_custom_color,
			'on' === $use_bg_overlay ? '<div class="et_pb_slide_overlay_container"></div>' : '',
			'' !== $parallax_image_background ? ' et_pb_section_parallax' : '',
			'' !== $video_background ? ' et_pb_section_video et_pb_preload' : '',
			$heading_before_img
		);

		return $output;
	}

	public function _add_additional_shadow_fields() {

	}

	public function process_box_shadow( $function_name ) {
		$boxShadow = ET_Builder_Module_Fields_Factory::get( 'BoxShadow' );
		$selector  = sprintf( '.%1$s .et_pb_button', self::get_module_order_class( $function_name ) );

		if ( isset( $this->shortcode_atts['custom_button'] ) && 'on' === $this->shortcode_atts['custom_button'] ) {
			self::set_style( $function_name, array(
				'selector'    => $selector,
				'declaration' => $boxShadow->get_value( $this->shortcode_atts, array(
					'suffix'    => '_button',
					'important' => true,
				) )
			) );
		}
	}

	protected function _add_additional_border_fields() {
		return false;
	}

	function process_advanced_border_options( $function_name ) {
		return false;
	}


}
new Custom_Slider_Owlcarousel_Item;