<?php
class Video_Embed extends ET_Builder_Module_Video {
    function init() {
   	    parent::init();
		$this->name = esc_html__( 'Video embed', 'et_builder' );
		$this->slug = 'et_pb_video_embed';
		$this->fb_support = true;
        $this->whitelisted_fields['video_popup'] = 'video_popup';
        $this->options_toggles['general']['toggles']['infor'] = esc_html__( 'Info', 'et_builder' );
        $this->fields_defaults['video_popup'] = array( 'off' );
    }
   	function get_fields() {
        $fields = parent::get_fields();
        $fields['video_popup'] = array(
            'label'             => esc_html__( 'Show video popup', 'liva-divi' ),
            'type'              => 'yes_no_button',
            'option_category'   => 'configuration',
            'options'           => array(
             'off' => esc_html__( 'No', 'et_builder' ),
             'on'  => esc_html__( 'Yes', 'et_builder' ),
            ),
            'toggle_slug'       => 'main_content',
        );
		return $fields;
	}
	static function get_video_embed( $args = array(), $conditonal_args = array(), $current_page = array() ) {
		global $wp_embed;

		$video_url = esc_url( $args['video_url'] );

		$playlistID = explode("?list=", $video_url);
		if ($playlistID[0] != $video_url) {
			$video_embed = '<iframe  src="https://www.youtube.com/embed/videoseries?list='.$playlistID[1].'&rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
		}else{
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
		}

		return $video_embed;
	}
	function shortcode_callback( $atts, $content = null, $function_name ) {
	   //print_r($this->shortcode_atts);
		$module_id       = $this->shortcode_atts['module_id'];
		$module_class    = $this->shortcode_atts['module_class'];
		$src             = $this->shortcode_atts['src'];
		$src_webm        = $this->shortcode_atts['src_webm'];
		$image_src       = $this->shortcode_atts['image_src'];
		$play_icon_color = $this->shortcode_atts['play_icon_color'];
        $video_popup     = $this->shortcode_atts['video_popup'];
		$image_output = self::get_video_cover_src( array(
			'image_src' => $image_src,
		) );
        $video_src       = self::get_video_embed( array(
            'video_url'      => $src,
        ) );
        $video_src = str_replace('?feature=oembed', '?rel=0', $video_src);
		$module_class              = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		$video_background          = $this->video_background();
		$parallax_image_background = $this->get_parallax_image_background();

		if ( '' !== $play_icon_color ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector' => '%%order_class%% .et_pb_video_overlay .et_pb_video_play',
				'declaration' => sprintf(
					'color: %1$s;',
					esc_html( $play_icon_color )
				),
			) );
		}
        if($src && $video_popup=='on'){
            wp_enqueue_script( 'masonry.pkgd-js', plugins_url( '/js/masonry.pkgd.min.js', __FILE__ ), array('jquery'), false, true );
            wp_enqueue_script( 'custom-gallery-box', plugins_url( '/js/custom-gallery-box.js', __FILE__ ), array('jquery'), false, true );
            //Lay tieu de va noi dung {-}
            $html = '<a href="'.$src.'" class="mfp-iframe icon_video_play">
                             <img src="'.$image_src.'"> 
                          </a>';
            //Lay noi dung video
            $output .= sprintf(
    			'
                <div%2$s class="et_pb_module et_pb_video%3$s%5$s%7$s gallery-image-box">
    				%8$s
    				%6$s
    				<div class="et_pb_video_box">
    					%1$s
    				</div>
    				%4$s
    			</div>',
                $html,  
    			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
    			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
                ' ',
    			// ( '' !== $image_output
    			// 	? sprintf(
    			// 		' 
       //                  <div class="et_pb_video_overlay" style="background-image: url(%1$s);">
    			// 			<div class="et_pb_video_overlay_hover">
    			// 				<a href="#" class="et_pb_video_play"></a>
    			// 			</div>
    			// 		</div>',
    			// 		esc_attr( $image_output )
    			// 	)
    			// 	: ''
    			// ),
    			'' !== $video_background ? ' et_pb_section_video et_pb_preload' : '',
    			$video_background,
    			'' !== $parallax_image_background ? ' et_pb_section_parallax' : '',
    			$parallax_image_background
    		);
        }elseif ($src && $video_popup=='off') {
                $output = sprintf(
                '<div%2$s class="et_pb_module et_pb_video%3$s%5$s%7$s">
                    %8$s
                    %6$s
                    <div class="et_pb_video_box">
                        %1$s
                    </div>
                    %4$s
                </div>',
                ( '' !== $video_src ? $video_src : '' ),
                ( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
                ( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
                ( '' !== $image_output
                    ? sprintf(
                        '<div class="et_pb_video_overlay" style="background-image: url(%1$s);">
                            <div class="et_pb_video_overlay_hover">
                                <a href="#" class="et_pb_video_play"></a>
                            </div>
                        </div>',
                        esc_attr( $image_output )
                    )
                    : ''
                ),
                '' !== $video_background ? ' et_pb_section_video et_pb_preload' : '',
                $video_background,
                '' !== $parallax_image_background ? ' et_pb_section_parallax' : '',
                $parallax_image_background
            );
        }
        else{
            $video_title = str_replace("{","<span>",$video_title);
            $video_title = str_replace("}","</span>",$video_title);
            $output = sprintf(
    			'<div class="video_title"> <h2>%s </h2></div>
                <div class="video_content">%s </div>',( '' !== $video_title ? $video_title : '' ),( '' !== $video_content ? $video_content : '' ));
        }
		

		return $output;
	}
}
new Video_Embed;