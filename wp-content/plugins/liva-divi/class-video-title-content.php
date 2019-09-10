<?php
class Video_With_Title_Content extends ET_Builder_Module_Video {
    function init() {
   	    parent::init();
		$this->name = esc_html__( 'Video with title and content', 'et_builder' );
		$this->slug = 'et_pb_video_title_content';
		$this->fb_support = true;
        $this->whitelisted_fields['video_title'] = 'video_title';
        $this->whitelisted_fields['video_content'] = 'video_content';
        $this->options_toggles['general']['toggles']['infor'] = esc_html__( 'Info', 'et_builder' );
    }
   	function get_fields() {
        $fields = parent::get_fields();
		$fields['video_title'] = array(
			'label'              => esc_html__( 'Title', 'et_builder' ),
			'type'               => 'text',
			'option_category'    => 'basic_option',
			'toggle_slug'        => 'main_content',
		);
        $fields['video_content'] = array(
			'label'              => esc_html__( 'Content', 'et_builder' ),
			'type'               => 'textarea',
			'option_category'    => 'basic_option',
			'toggle_slug'        => 'main_content',
		);
		return $fields;
	}
	function shortcode_callback( $atts, $content = null, $function_name ) {
	   //print_r($this->shortcode_atts);
		$module_id       = $this->shortcode_atts['module_id'];
		$module_class    = $this->shortcode_atts['module_class'];
		$src             = $this->shortcode_atts['src'];
		$src_webm        = $this->shortcode_atts['src_webm'];
		$image_src       = $this->shortcode_atts['image_src'];
		$play_icon_color = $this->shortcode_atts['play_icon_color'];
        $video_title           = $this->shortcode_atts['video_title'];
        $video_content         = $this->shortcode_atts['video_content'];
        wp_enqueue_script( 'masonry.pkgd-js', plugins_url( '/js/masonry.pkgd.min.js', __FILE__ ), array('jquery'), false, true );
        wp_enqueue_script( 'custom-gallery-box', plugins_url( '/js/custom-gallery-box.js', __FILE__ ), array('jquery'), false, true );
		$video_src       = self::get_video( array(
			'src'      => $src,
			'src_webm' => $src_webm,
		) );

		$image_output = self::get_video_cover_src( array(
			'image_src' => $image_src,
		) );
        
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
        if($src){
            //Lay tieu de va noi dung {-}
            
            $video_title = str_replace("{ -","</span><hr>",$video_title);
            $video_title = '<span class="line">'.$video_title;
            $video_title = str_replace("{","<span>",$video_title);
            $video_title = str_replace("}","</span>",$video_title);
            $output = sprintf(
            '<div class="row">
                <div class="col-6 col-md-6">
                    <div class="video_title_left"><h2>%s </h2> </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="video_content_right text_gray">%s </div>
                </div>
            </div>',( '' !== $video_title ? $video_title : 'tieu de' ),( '' !== $video_content ? $video_content : 'noi dung' ));
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
    			//( '' !== $video_src ? $video_src : '' ),
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
            if($module_id=='overview_about'){
                $video_src = str_replace('width="1080" height="608"', 'width="572" height="374"', $video_src);
                $video_src = str_replace('feature=oembed', 'rel=0', $video_src);
                $output = sprintf(
                '',( '' !== $video_title ? $video_title : 'tieu de' ),( '' !== $video_content ? $video_content : 'noi dung' ));
                $output = sprintf(
                '
                <div%2$s class="et_pb_module et_pb_video%3$s%5$s%7$s">
                    %8$s
                    %6$s
                    <div class="et_pb_video_box">
                        <div class="row">
                            <div class="col-6 col-md-6">
                                <div class="video_title_left"><h2>%9$s </h2> </div>
                                <div class="video_content_right text_gray">%10$s </div>
                            </div>
                            <div class="col-6 col-md-6">
                                %1$s
                                %4$s
                            </div>
                        </div>
                    </div>
                   
                </div>',
                ( '' !== $video_src ? $video_src : '' ),
                ( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
                ( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
                ( '' !== $image_output
                    ? sprintf(
                        ' 
                        <div class="et_pb_video_overlay" style="background-image: url(%1$s);">
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
                $parallax_image_background,( '' !== $video_title ? $video_title : 'tieu de' ),( '' !== $video_content ? $video_content : 'noi dung' )
            );
            }
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
new Video_With_Title_Content;