<?php

class Custom_Slider_Item extends ET_Builder_Module {
	function init() {
		$this->name                        = esc_html__( 'Slide Item', 'liva-divi' );
		$this->slug                        = 'et_pb_slide_owlcarousel';
		$this->fb_support                  = true;
		$this->type                        = 'child';
		$this->child_title_var             = 'admin_title';
		$this->child_title_fallback_var    = 'heading';

		$this->whitelisted_fields = array(
			'heading',
			'admin_title',
			'button_text',
			'button_link',
			'image',
			'alignment',
			'video_url',
			'image_alt',
			'background_layout',
			'content_new',
			'arrows_custom_color',
			'dot_nav_custom_color',
			'use_bg_overlay',
			'use_text_overlay',
			'bg_overlay_color',
			'text_overlay_color',
			'text_border_radius',
		);

		$this->fields_defaults = array(
			'button_link'         => array( '#' ),
			'background_position' => array( 'center' ),
			'background_size'     => array( 'cover' ),
			'background_color'    => array( '#ffffff', 'only_default_setting' ),
			'alignment'           => array( 'center' ),
			'background_layout'   => array( 'dark' ),
			'allow_player_pause'  => array( 'off' ),
		);

		$this->advanced_setting_title_text = esc_html__( 'New Slide Owlcarousel', 'liva-divi' );
		$this->settings_text               = esc_html__( 'Slide Owlcarousel Settings', 'liva-divi' );
		$this->main_css_element = '%%order_class%%';

		$this->options_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Text', 'liva-divi' ),
					'link'         => esc_html__( 'Link', 'liva-divi' ),
					'image_video'  => esc_html__( 'Image & Video', 'liva-divi' ),
					'player_pause' => esc_html__( 'Player Pause', 'liva-divi' ),
					'background'   => esc_html__( 'Background', 'liva-divi' ),
					'admin_label'  => esc_html__( 'Admin Label', 'liva-divi' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'overlay'    => esc_html__( 'Overlay', 'liva-divi' ),
					'navigation' => esc_html__( 'Navigation', 'liva-divi' ),
					'alignment'  => esc_html__( 'Alignment', 'liva-divi' ),
					'image' => array(
						'title' => esc_html__( 'Image', 'liva-divi' ),
					),
					'text'       => array(
						'title'    => esc_html__( 'Text', 'liva-divi' ),
						'priority' => 49,
					),
				),
			),
			'custom_css' => array(
				'toggles' => array(
					'attributes' => array(
						'title'    => esc_html__( 'Attributes', 'liva-divi' ),
						'priority' => 95,
					),
				),
			),
		);

		$this->advanced_options = array(
			'fonts' => array(
				'header' => array(
					'label'    => esc_html__( 'Title', 'liva-divi' ),
					'css'      => array(
						'main' => ".et_pb_slider {$this->main_css_element}.et_pb_slide .et_pb_slide_description .et_pb_slide_title",
						'plugin_main' => ".et_pb_slider {$this->main_css_element}.et_pb_slide .et_pb_slide_description .et_pb_slide_title, .et_pb_slider {$this->main_css_element}.et_pb_slide .et_pb_slide_description .et_pb_slide_title a",
						'important' => 'all',
					),
					'line_height' => array(
						'range_settings' => array(
							'min'  => '1',
							'max'  => '100',
							'step' => '0.1',
						),
					),
					'header_level' => array(
						'default' => 'h2',
					),
				),
				'body'   => array(
					'label'    => esc_html__( 'Body', 'liva-divi' ),
					'css'      => array(
						'main'        => ".et_pb_slider.et_pb_module 2 {$this->main_css_element}.et_pb_slide .et_pb_slide_description .et_pb_slide_content",
						'line_height' => "{$this->main_css_element} p",
						'important'   => 'all',
					),
					'line_height' => array(
						'range_settings' => array(
							'min'  => '1',
							'max'  => '100',
							'step' => '0.1',
						),
					),
				),
			),
			'button' => array(
				'button' => array(
					'label' => esc_html__( 'Button', 'liva-divi' ),
					'css'      => array(
						'main' => ".et_pb_slider {$this->main_css_element}.et_pb_slide .et_pb_button",
						'plugin_main' => ".et_pb_slider {$this->main_css_element}.et_pb_slide .et_pb_more_button.et_pb_button",
						'alignment' => ".et_pb_slider {$this->main_css_element} .et_pb_slide_description .et_pb_button_wrapper",
					),
					'use_alignment' => true,
				),
			),
			'background' => array(
				'css' => array(
					'main' => ".et_pb_slider %%order_class%%",
				),
			),
			'custom_margin_padding' => array(
				'use_margin' => false,
				'css' => array(
					'padding'   => '.et_pb_slider %%order_class%% .et_pb_slide_description, .et_pb_slider_fullwidth_off %%order_class%% .et_pb_slide_description',
					'important' => array( 'custom_padding' ), // Important is needed to overwrite parent and column-specific padding specificity
				),
			),
			'text' => array(
				'css' => array(
					'text_orientation' => '.et_pb_slides %%order_class%%.et_pb_slide .et_pb_slide_description',
					'text_shadow'      => '.et_pb_slides %%order_class%%.et_pb_slide .et_pb_slide_description',
				),
			),
			'filters' => array(
				'child_filters_target' => array(
					'tab_slug' => 'advanced',
					'toggle_slug' => 'image',
				),
			),
			'image' => array(
				'css' => array(
					'main' => array(
						'%%order_class%% .et_pb_slide_image',
						'%%order_class%% .et_pb_section_video_bg',
					),
				),
			),
		);

		$this->custom_css_options = array(
			'slide_title' => array(
				'label'    => esc_html__( 'Slide Title', 'liva-divi' ),
				'selector' => '.et_pb_slide_description h2',
			),
			'slide_container' => array(
				'label'    => esc_html__( 'Slide Description Container', 'liva-divi' ),
				'selector' => '.et_pb_container',
			),
			'slide_description' => array(
				'label'    => esc_html__( 'Slide Description', 'liva-divi' ),
				'selector' => '.et_pb_slide_description',
			),
			'slide_button' => array(
				'label'    => esc_html__( 'Slide Button', 'liva-divi' ),
				'selector' => '.et_pb_slide .et_pb_container a.et_pb_more_button.et_pb_button',
				'no_space_before_selector' => true,
			),
			'slide_image' => array(
				'label'    => esc_html__( 'Slide Image', 'liva-divi' ),
				'selector' => '.et_pb_slide_image',
			),
		);
	}

	function get_fields() {
		$fields = array(
			'heading' => array(
				'label'           => esc_html__( 'Heading', 'liva-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Define the title text for your slide.', 'liva-divi' ),
				'toggle_slug'     => 'main_content',
			),
			'button_text' => array(
				'label'           => esc_html__( 'Button Text', 'liva-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Define the text for the slide button', 'liva-divi' ),
				'toggle_slug'     => 'main_content',
			),
			'button_link' => array(
				'label'           => esc_html__( 'Button URL', 'liva-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input a destination URL for the slide button.', 'liva-divi' ),
				'toggle_slug'     => 'link',
			),
			'image' => array(
				'label'              => esc_html__( 'Slide Image', 'liva-divi' ),
				'type'               => 'upload',
				'option_category'    => 'configuration',
				'upload_button_text' => esc_attr__( 'Upload an image', 'liva-divi' ),
				'choose_text'        => esc_attr__( 'Choose a Slide Image', 'liva-divi' ),
				'update_text'        => esc_attr__( 'Set As Slide Image', 'liva-divi' ),
				'affects'            => array(
					'image_alt',
				),
				'description'        => esc_html__( 'If defined, this slide image will appear to the left of your slide text. Upload an image, or leave blank for a text-only slide.', 'liva-divi' ),
				'toggle_slug'        => 'image_video',
			),
			'use_bg_overlay'      => array(
				'label'           => esc_html__( 'Use Background Overlay', 'liva-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => esc_html__( 'No', 'liva-divi' ),
					'on'  => esc_html__( 'yes', 'liva-divi' ),
				),
				'affects'           => array(
					'bg_overlay_color',
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'overlay',
				'description'     => esc_html__( 'When enabled, a custom overlay color will be added above your background image and behind your slider content.', 'liva-divi' ),
			),
			'bg_overlay_color' => array(
				'label'             => esc_html__( 'Background Overlay Color', 'liva-divi' ),
				'type'              => 'color-alpha',
				'custom_color'      => true,
				'depends_show_if'   => 'on',
				'description'       => esc_html__( 'Use the color picker to choose a color for the background overlay.', 'liva-divi' ),
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'overlay',
			),
			'use_text_overlay'      => array(
				'label'           => esc_html__( 'Use Text Overlay', 'liva-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => esc_html__( 'No', 'liva-divi' ),
					'on'  => esc_html__( 'yes', 'liva-divi' ),
				),
				'affects'           => array(
					'text_overlay_color',
					'text_border_radius',
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'overlay',
				'description'     => esc_html__( 'When enabled, a background color is added behind the slider text to make it more readable atop background images.', 'liva-divi' ),
			),
			'text_overlay_color' => array(
				'label'             => esc_html__( 'Text Overlay Color', 'liva-divi' ),
				'type'              => 'color-alpha',
				'custom_color'      => true,
				'depends_show_if'   => 'on',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'overlay',
				'description'       => esc_html__( 'Use the color picker to choose a color for the text overlay.', 'liva-divi' ),
			),
			'alignment' => array(
				'label'           => esc_html__( 'Slide Image Vertical Alignment', 'liva-divi' ),
				'type'            => 'select',
				'option_category' => 'layout',
				'options'         => array(
					'center' => esc_html__( 'Center', 'liva-divi' ),
					'bottom' => esc_html__( 'Bottom', 'liva-divi' ),
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'alignment',
				'description'     => esc_html__( 'This setting determines the vertical alignment of your slide image. Your image can either be vertically centered, or aligned to the bottom of your slide.', 'liva-divi' ),
			),
			'video_url' => array(
				'label'           => esc_html__( 'Slide Video', 'liva-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'If defined, this video will appear to the left of your slide text. Enter youtube or vimeo page url, or leave blank for a text-only slide.', 'liva-divi' ),
				'toggle_slug'     => 'image_video',
				'computed_affects' => array(
					'__video_embed',
				),
			),
			'image_alt' => array(
				'label'           => esc_html__( 'Image Alternative Text', 'liva-divi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'depends_default' => true,
				'depends_to'      => array(
					'image',
				),
				'description'     => esc_html__( 'If you have a slide image defined, input your HTML ALT text for the image here.', 'liva-divi' ),
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'attributes',
			),
			'background_layout' => array(
				'label'           => esc_html__( 'Text Color', 'liva-divi' ),
				'type'            => 'select',
				'option_category' => 'color_option',
				'options'         => array(
					'dark'  => esc_html__( 'Light', 'liva-divi' ),
					'light' => esc_html__( 'Dark', 'liva-divi' ),
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'text',
				'description'     => esc_html__( 'Here you can choose whether your text is light or dark. If you have a slide with a dark background, then choose light text. If you have a light background, then use dark text.' , 'liva-divi' ),
			),
			'allow_player_pause' => array(
				'label'           => esc_html__( 'Pause Video When Another Video Plays', 'liva-divi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => esc_html__( 'No', 'liva-divi' ),
					'on'  => esc_html__( 'Yes', 'liva-divi' ),
				),
				'toggle_slug'     => 'player_pause',
				'description'     => esc_html__( 'Allow video to be paused by other players when they begin playing' ,'liva-divi' ),
			),
			'content_new' => array(
				'label'           => esc_html__( 'Content', 'liva-divi' ),
				'type'            => 'tiny_mce',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input your main slide text content here.', 'liva-divi' ),
				'toggle_slug'     => 'main_content',
			),
			'arrows_custom_color' => array(
				'label'        => esc_html__( 'Arrows Custom Color', 'liva-divi' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'navigation',
			),
			'dot_nav_custom_color' => array(
				'label'        => esc_html__( 'Dot Nav Custom Color', 'liva-divi' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'navigation',
			),
			'admin_title' => array(
				'label'       => esc_html__( 'Admin Label', 'liva-divi' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the slide in the builder for easy identification.', 'liva-divi' ),
				'toggle_slug' => 'admin_label',
			),
			'text_border_radius' => array(
				'label'           => esc_html__( 'Text Overlay Border Radius', 'liva-divi' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'default'         => '3',
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'depends_show_if' => 'on',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'overlay',
			),
			'__video_embed' => array(
				'type' => 'computed',
				'computed_callback' => array( 'Slider_Item_Owlcarousel', 'get_video_embed' ),
				'computed_depends_on' => array(
					'video_url',
				),
				'computed_minimum' => array(
					'video_url',
				),
			),
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

	function shortcode_callback( $atts, $content = null, $function_name ) {d($function_name);
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
		$parallax_image_background = $this->get_parallax_image_background();d('test');

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

		$style = '' !== $style ? " style='{$style}'" : '';

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
		d($this->shortcode_content);
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
		d($arr_content);
		$shortcode_content = '<div class="left-content">'.$arr_content[0].'</div>';
		$shortcode_content .=  '<div class="right-content">'.$arr_content[1].'</div>';
		$shortcode_content .= '<div class="btn-content"><a class="et_pb_button be_inspried_more et_pb_button_1 et_pb_module et_pb_bg_layout_light">BE INSPIRED MORE</a></div>';
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
			'<div class="et_pb_slide%5$s%11$s%12$s"%3$s%8$s%9$s>
				%7$s
				%10$s
				<div class="et_pb_container clearfix">
					<div class="et_pb_slider_container_inner">
						%4$s
						<div class="et_pb_slide_description">
							%1$s
							%2$s
						</div> <!-- .et_pb_slide_description -->
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
			'' !== $video_background ? ' et_pb_section_video et_pb_preload' : ''
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
new Custom_Slider_Item;