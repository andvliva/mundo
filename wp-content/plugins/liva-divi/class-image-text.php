<?php

class Image_text extends ET_Builder_Module_Image {
	function init() {
		parent::init();
		$this->name       = esc_html__( 'Image text', 'et_builder' );
		$this->slug       = 'et_pb_image_text';
		$this->fb_support = true;
		$this->whitelisted_fields['image_title'] = 'image_title';
        $this->whitelisted_fields['image_content'] = 'image_content';
        $this->whitelisted_fields['image_position'] = 'image_position';
        $this->fields_defaults['image_position'] = array( 'left' );
	}

	function get_fields() {
		$fields = parent::get_fields();
		$fields['image_title'] = array(
			'label'              => esc_html__( 'Title', 'et_builder' ),
			'type'               => 'text',
			'option_category'    => 'basic_option',
			'toggle_slug'        => 'main_content',
		);
        $fields['image_content'] = array(
			'label'              => esc_html__( 'Contents', 'et_builder' ),
			'type'               => 'tiny_mce',
			'option_category'    => 'basic_option',
			'toggle_slug'        => 'main_content',
		);
		$fields['image_position'] = array(
			'label'              => esc_html__( 'Image Position', 'et_builder' ),
			'type'            => 'select',
			'option_category' => 'color_option',
				'options'         => array(
					'left'  => esc_html__( 'Left', 'et_builder' ),
					'right' => esc_html__( 'Right', 'et_builder' ),
				),
			'toggle_slug'     => 'main_content',
			'description'     => esc_html__( 'Display postion image' , 'et_builder' ),
		);
		return $fields;
	}

	public function get_alignment() {
		$alignment = isset( $this->shortcode_atts['align'] ) ? $this->shortcode_atts['align'] : '';

		return et_pb_get_alignment( $alignment );
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id               = $this->shortcode_atts['module_id'];
		$module_class            = $this->shortcode_atts['module_class'];
		$src                     = $this->shortcode_atts['src'];
		$alt                     = $this->shortcode_atts['alt'];
		$title_text              = $this->shortcode_atts['title_text'];
		$url                     = $this->shortcode_atts['url'];
		$url_new_window          = $this->shortcode_atts['url_new_window'];
		$show_in_lightbox        = $this->shortcode_atts['show_in_lightbox'];
		$show_bottom_space       = $this->shortcode_atts['show_bottom_space'];
		$align                   = $this->get_alignment();
		$force_fullwidth         = $this->shortcode_atts['force_fullwidth'];
		$always_center_on_mobile = $this->shortcode_atts['always_center_on_mobile'];
		$overlay_icon_color      = $this->shortcode_atts['overlay_icon_color'];
		$hover_overlay_color     = $this->shortcode_atts['hover_overlay_color'];
		$hover_icon              = $this->shortcode_atts['hover_icon'];
		$use_overlay             = $this->shortcode_atts['use_overlay'];
		$animation_style         = $this->shortcode_atts['animation_style'];
		$image_title             = $this->shortcode_atts['image_title'];
        $image_content            = et_builder_replace_code_content_entities( $this->shortcode_content );
        $image_position	 		  = $this->shortcode_atts['image_position'];
		$module_class              = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		$video_background          = $this->video_background();
		$parallax_image_background = $this->get_parallax_image_background();
		//$image_position = $image_position?:'left';
		// Handle svg image behaviour
		$src_pathinfo = pathinfo( $src );
		$is_src_svg = isset( $src_pathinfo['extension'] ) ? 'svg' === $src_pathinfo['extension'] : false;

		if ( 'on' === $always_center_on_mobile ) {
			$module_class .= ' et_always_center_on_mobile';
		}

		// overlay can be applied only if image has link or if lightbox enabled
		$is_overlay_applied = 'on' === $use_overlay && ( 'on' === $show_in_lightbox || ( 'off' === $show_in_lightbox && '' !== $url ) ) ? 'on' : 'off';

		if ( 'on' === $force_fullwidth ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%%',
				'declaration' => 'max-width: 100% !important;',
			) );

			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .et_pb_image_wrap, %%order_class%% img',
				'declaration' => 'width: 100%;',
			) );
		}

		if ( $this->fields_defaults['align'][0] !== $align ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%%',
				'declaration' => sprintf(
					'text-align: %1$s;',
					esc_html( $align )
				),
			) );
		}

		if ( 'center' !== $align ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%%',
				'declaration' => sprintf(
					'margin-%1$s: 0;',
					esc_html( $align )
				),
			) );
		}

		if ( 'on' === $is_overlay_applied ) {
			if ( '' !== $overlay_icon_color ) {
				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%% .et_overlay:before',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $overlay_icon_color )
					),
				) );
			}

			if ( '' !== $hover_overlay_color ) {
				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%% .et_overlay',
					'declaration' => sprintf(
						'background-color: %1$s;',
						esc_html( $hover_overlay_color )
					),
				) );
			}

			$data_icon = '' !== $hover_icon
				? sprintf(
					' data-icon="%1$s"',
					esc_attr( et_pb_process_font_icon( $hover_icon ) )
				)
				: '';

			$overlay_output = sprintf(
				'<span class="et_overlay%1$s"%2$s></span>',
				( '' !== $hover_icon ? ' et_pb_inline_icon' : '' ),
				$data_icon
			);
		}

		// Set display block for svg image to avoid disappearing svg image
		if ( $is_src_svg ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .et_pb_image_wrap',
				'declaration' => 'display: block;',
			) );
		}


		// $post_img = get_post( getIDfromGUID($src) );
		// $att_id = $post_img->ID;
		// $src = mundo_get_attachment_image_src($att_id,'why_us');
		if($image_position=='left'){
			$output = sprintf(
				'<div class="row postion_left"><div class="col-md-6"><span class="et_pb_image_wrap"><img src="%1$s" alt="%2$s"%3$s />%4$s</span></div>
				<div class="col-md-6">
					<h3>%5$s</h3>
					%6$s
				</div></div>',
				esc_url( $src ),
				esc_attr( $alt ),
				( '' !== $title_text ? sprintf( ' title="%1$s"', esc_attr( $title_text ) ) : '' ),
				'on' === $is_overlay_applied ? $overlay_output : '',
				$image_title,
				$image_content
			);
		}else{
			$output = sprintf(
				'<div class="row postion_right">
				<div class="col-md-6">
					<h3>%5$s</h3>
					%6$s
				</div>
				<div class="col-md-6">
					<span class="et_pb_image_wrap">
					<img src="%1$s" alt="%2$s"%3$s />%4$s</span>
				</div>
				</div>',
				esc_url( $src ),
				esc_attr( $alt ),
				( '' !== $title_text ? sprintf( ' title="%1$s"', esc_attr( $title_text ) ) : '' ),
				'on' === $is_overlay_applied ? $overlay_output : '',
				$image_title,
				$image_content
			);
		}
		

		if ( 'on' === $show_in_lightbox ) {
			$output = sprintf( '<a href="%1$s" class="et_pb_lightbox_image" title="%3$s">%2$s</a>',
				esc_url( $src ),
				$output,
				esc_attr( $alt )
			);
		} else if ( '' !== $url ) {
			$output = sprintf( '<a href="%1$s"%3$s>%2$s</a>',
				esc_url( $url ),
				$output,
				( 'on' === $url_new_window ? ' target="_blank"' : '' )
			);
		}

		$output = sprintf(
			'<div%5$s class="et_pb_module et_pb_image%2$s%3$s%4$s%6$s%7$s%9$s">
				%10$s
				%8$s
				%1$s
			</div>',
			$output,
			in_array( $animation_style, array( '', 'none' ) ) ? '' : ' et-waypoint',
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( ltrim( $module_class ) ) ) : '' ),
			( 'on' !== $show_bottom_space ? esc_attr( ' et_pb_image_sticky' ) : '' ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			'on' === $is_overlay_applied ? ' et_pb_has_overlay' : '',
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
			sprintf( '.%1$s .et_pb_image_wrap', self::get_module_order_class( $function_name ) ),
			$this->shortcode_atts
		) );
	}

	protected function _add_additional_border_fields() {
		parent::_add_additional_border_fields();

		$this->advanced_options["border"]['css'] = array(
			'main' => array(
				'border_radii'  => "%%order_class%% .et_pb_image_wrap",
				'border_styles' => "%%order_class%% .et_pb_image_wrap",
			)
		);

	}


}

new Image_text;
