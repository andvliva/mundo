<?php
class Vertical_tabs_mundo extends ET_Builder_Module_Tabs {
	function init() {
		parent::init();
		$this->name            = esc_html__( 'Vertical Tabs', 'et_builder' );
		$this->slug            = 'vertical_et_pb_tabs';
		$this->fb_support      = true;
	}

	function get_fields() {
		$fields = parent::get_fields();
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id                         = $this->shortcode_atts['module_id'];
		$module_class                      = $this->shortcode_atts['module_class'];
		$active_tab_background_color       = $this->shortcode_atts['active_tab_background_color'];
		$inactive_tab_background_color     = $this->shortcode_atts['inactive_tab_background_color'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		$all_tabs_content = $this->shortcode_content;
		
		global $et_pb_tab_titles;
		global $et_pb_tab_classes;

		if ( '' !== $inactive_tab_background_color ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .et_pb_tabs_controls li',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $inactive_tab_background_color )
				),
			) );
		}

		if ( '' !== $active_tab_background_color ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .et_pb_tabs_controls li.et_pb_tab_active',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $active_tab_background_color )
				),
			) );
		}

		$tabs = '';

		$i = 0;
		if ( ! empty( $et_pb_tab_titles ) ) {
			foreach ( $et_pb_tab_titles as $tab_title ){
				++$i;
				$tabs .= sprintf( '<li class="%3$s%1$s"><a href="#">%2$s</a></li>',
					( 1 == $i ? ' et_pb_tab_active' : '' ),
					esc_html( $tab_title ),
					esc_attr( ltrim( $et_pb_tab_classes[ $i-1 ] ) )
				);
			}
		}

		$video_background = $this->video_background();
		$parallax_image_background = $this->get_parallax_image_background();

		$et_pb_tab_titles = $et_pb_tab_classes = array();

		$output = sprintf(
			'<div%3$s class="et_pb_module row vertical_tabs et_pb_tabs%4$s%5$s%7$s%9$s">
				%8$s
				%6$s
				<ul class="et_pb_tabs_controls col-md-4 clearfix">
					%1$s
				</ul>
				<div class="et_pb_all_tabs col-md-8">
					%2$s
				</div> <!-- .et_pb_all_tabs -->
			</div> <!-- .et_pb_tabs -->',
			$tabs,
			$all_tabs_content,
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			'' !== $video_background ? ' et_pb_section_video et_pb_preload' : '', // 5
			$video_background,
			'' !== $parallax_image_background ? ' et_pb_section_parallax' : '',
			$parallax_image_background,
			$this->get_text_orientation_classname()
		);

		return $output;
	}

	public function process_box_shadow( $function_name ) {
		$boxShadow = ET_Builder_Module_Fields_Factory::get( 'BoxShadow' );
		$style     = $boxShadow->get_value( $this->shortcode_atts );

		if ( empty( $style ) ) {
			return;
		}

		$selector = $boxShadow->is_inset( $style ) ? '%%order_class%% .et-pb-active-slide' : '%%order_class%%';

		self::set_style( $function_name, array(
			'selector'    => $selector,
			'declaration' => $style
		) );
	}
}

new Vertical_tabs_mundo;
