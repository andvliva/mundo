<?php 
class Slider_3_image extends ET_Builder_Module_Slider {
    function init() {
        parent::init();
  		$this->name            = esc_html__( 'Slider 3 img', 'liva-divi' );
		$this->slug            = 'et_pb_slider_3_img';
		$this->fb_support      = true;
		$this->child_slug      = 'et_pb_slide_3_img';
		$this->child_item_text = esc_html__('Slider 3 img', 'liva-divi' );
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
        $content = apply_filters('post_content_3_img_slider', $content, $module_id);
       // $owlCarousel_options = htmlspecialchars(json_encode($owlCarousel_options));
        //d($content);

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

		
        

		$output = sprintf(
			'<div%4$s class="slider">
                <div id="jssor_1" class = "jssor_1"  style="position:relative;margin:0 auto;top:0px;left:0px;width:980px;height:640px;overflow:hidden;visibility:hidden;opacity:1">
                    <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:980px;height:640px;overflow:hidden;opacity:1">
                		%2$s
                    </div>
                    %6$s
                     <!-- Bullet Navigator -->
                    <div data-u="navigator" class="jssorb051" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
                        <div data-u="prototype" class="i" style="width:16px;height:16px;">
                            <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                                <circle class="b" cx="8000" cy="8000" r="5800"></circle>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Arrow Navigator -->
                    <div data-u="arrowleft" class="jssora093 hotel-btn-left" style="width:50px;height:50px;top:0px;left:30px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
                        
                    </div>
                    <div data-u="arrowright" class="jssora093 hotel-btn-right" style="width:50px;height:50px;top:0px;right:30px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
                        
                    </div>
                </div>
                <div class="slider-layer layer-left"></div>
    			<div class="slider-layer layer-right"></div>    
                </div> <!-- .et_pb_slider -->
			',
			esc_attr( $class ),
			$content,
			( $et_pb_slider_has_video ? ' et_pb_preload' : '' ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			$this->inner_shadow_back_compatibility( $function_name )
		);
        //d($content);
		// Reset passed slider item value
		$et_pb_slider_owlcarousel = array();

		return $output;
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
    new Slider_3_image;