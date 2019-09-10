<?php

class Text_Overview extends ET_Builder_Module_Text {
	function init() {
		$this->name       = esc_html__( 'Text overview', 'liva-divi' );
		$this->slug       = 'et_pb_text_overview';
		$this->fb_support = true;

		$this->whitelisted_fields[] = 'title_new';

	}

	function get_fields() {
        $fields['title_new'] = array(
			'label'           => esc_html__( 'Title', 'liva-divi' ),
			'type'            => 'text',
			'option_category' => 'basic_option',
			'description'     => '',
			'toggle_slug'     => 'main_content',
		);
        return $fields;
	}

	// Don't add text-shadow fields since they already are via font-options
	protected function _add_additional_text_shadow_fields() {}

	function shortcode_callback( $atts, $content = null, $function_name ) {
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

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		$this->shortcode_content = et_builder_replace_code_content_entities( $this->shortcode_content );

		$video_background = $this->video_background();
		$parallax_image_background = $this->get_parallax_image_background();

		if ( '' !== $ul_type || '' !== $ul_position || '' !== $ul_item_indent ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% ul',
				'declaration' => sprintf(
					'%1$s
					%2$s
					%3$s',
					'' !== $ul_type ? sprintf( 'list-style-type: %1$s;', esc_html( $ul_type ) ) : '',
					'' !== $ul_position ? sprintf( 'list-style-position: %1$s;', esc_html( $ul_position ) ) : '',
					'' !== $ul_item_indent ? sprintf( 'padding-left: %1$s;', esc_html( $ul_item_indent ) ) : ''
				),
			) );
		}

		if ( '' !== $ol_type || '' !== $ol_position || '' !== $ol_item_indent ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% ol',
				'declaration' => sprintf(
					'%1$s
					%2$s
					%3$s',
					'' !== $ol_type ? sprintf( 'list-style-type: %1$s;', esc_html( $ol_type ) ) : '',
					'' !== $ol_position ? sprintf( 'list-style-position: %1$s;', esc_html( $ol_position ) ) : '',
					'' !== $ol_item_indent ? sprintf( 'padding-left: %1$s;', esc_html( $ol_item_indent ) ) : ''
				),
			) );
		}

		if ( '' !== $quote_border_weight || '' !== $quote_border_color ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% blockquote',
				'declaration' => sprintf(
					'%1$s
					%2$s',
					'' !== $quote_border_weight ? sprintf( 'border-width: %1$s;', esc_html( $quote_border_weight ) ) : '',
					'' !== $quote_border_color ? sprintf( 'border-color: %1$s;', esc_html( $quote_border_color ) ) : ''
				),
			) );
		}

		$class = " et_pb_module et_pb_bg_layout_{$background_layout}{$this->get_text_orientation_classname()}";

		$output = sprintf(
			'<div%3$s class="et_pb_text%2$s%4$s%5$s%7$s">
				%8$s
				%6$s
				<div class="et_pb_text_inner">
					%1$s
				</div>
			</div> <!-- .et_pb_text -->',
			$this->shortcode_content,
			esc_attr( $class ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			'' !== $video_background ? ' et_pb_section_video et_pb_preload' : '', // #5
			$video_background,
			'' !== $parallax_image_background ? ' et_pb_section_parallax' : '',
			$parallax_image_background
		);

		return $output;
	}
}

new Text_Overview;
