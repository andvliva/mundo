<?php

class Gallery_Image extends ET_Builder_Module_Text {
    function init() {
       parent::init();
       $this->name       = esc_html__( 'Gallery Image', 'liva-divi' );
       $this->slug       = 'et_pb_text_gallery_image';
       $this->fields_defaults['module_class'] = array('text-gallery-image');
    }
    static function get_video( $args = array(), $conditional_tags = array(), $current_page = array() ) {
        $defaults = array(
            'src'      => '',
            'src_webm' => '',
        );

        $args = wp_parse_args( $args, $defaults );

        $video_src = '';

        if ( false !== et_pb_check_oembed_provider( esc_url( $args['src'] ) ) ) {
            $video_src = wp_oembed_get( esc_url( $args['src'] ) );
        } else {
            $video_src = sprintf( '
                <video controls>
                    %1$s
                    %2$s
                </video>',
                ( '' !== $args['src'] ? sprintf( '<source type="video/mp4" src="%s" />', esc_url( $args['src'] ) ) : '' ),
                ( '' !== $args['src_webm'] ? sprintf( '<source type="video/webm" src="%s" />', esc_url( $args['src_webm'] ) ) : '' )
            );

            wp_enqueue_style( 'wp-mediaelement' );
            wp_enqueue_script( 'wp-mediaelement' );
        }

        return $video_src;
    }
    function shortcode_callback( $atts, $content = null, $function_name ) {
        global $post;
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

        // some themes do not include these styles/scripts so we need to enqueue them in this module to support audio post format
       // wp_enqueue_style( 'custom-jquery.marquee-css', plugins_url( '/css/custom-post-marquee.css', __FILE__ ) );
        //wp_enqueue_script( 'masonry.pkgd-js', plugins_url( '/js/masonry.pkgd.min.js', __FILE__ ), array('jquery'), false, true );
        wp_enqueue_style( 'light-css', plugins_url( 'js/lightGallery-master/dist/css/lightgallery.css', __FILE__ ),array(), rand() );
        wp_enqueue_script( 'light-mim-js', plugins_url( 'js/lightGallery-master/dist/js/lightgallery.min.js', __FILE__ ), array('jquery'), false, true );
        wp_enqueue_script( 'light-mim-all-js', plugins_url( 'js/lightGallery-master/dist/js/lightgallery-all.min.js', __FILE__ ), array('jquery'), false, true );
        wp_enqueue_script( 'light-js', plugins_url( 'js/lightGallery-master/modules/lg-thumbnail.min.js', __FILE__ ), array('jquery'), false, true );
        wp_enqueue_script( 'light-js-fullscreen', plugins_url( 'js/lightGallery-master/modules/lg-fullscreen.min.js', __FILE__ ), array('jquery'), false, true );
        wp_enqueue_script( 'custom-gallery-box', plugins_url( '/js/custom-gallery-light.js', __FILE__ ), array('jquery'), false, true );
        //wp_enqueue_script( 'froogaloop2-js','https://f.vimeocdn.com/js/froogaloop2.min.js', array('jquery'), false, true );
        //wp_enqueue_script( 'custom-jquery.marquee-js', plugins_url( '/js/custom-post-marquee.js', __FILE__ ), array(), false, true );

        $module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

        $this->shortcode_content = et_builder_replace_code_content_entities( $this->shortcode_content );

        $video_background = $this->video_background();
        $parallax_image_background = $this->get_parallax_image_background();
        
        //global $post;
        $post_id = $post->ID;
        $destination_category = get_query_var('excursion_place');
        if ($destination_category) {
            $args = array(
                'post_type' => 'destination',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'category-destination',
                        'field'    => 'slug',
                        'terms'    => $destination_category,
                        'include_children' =>false
                    ),
                ),
            );
            $excursions = get_posts($args);
            foreach ($excursions as $key => $excursion) {
                $post_id = $excursion->ID;
                $name_excursion = $excursion->post_title;
            }
        }
        $gallery = get_post_meta($post_id, 'gallery', false) ?: 0;
        $tmp = array();
        $i = 0;
        $j = 1;
        //print_r($gallery);
        foreach($gallery[0] as $item) {
            $excerpt = $item['file_name']?: 0;
            if ($module_id == 'tour_gallrey') {
                $excerpt = $item['title']?: 0;
            }
            $image_id = $item['image'] ?: 0;
            $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true);
            $image_id_thumb = $item['image_thumb'] ?: 0;
            $image_thumb_alt = get_post_meta( $image_id_thumb, '_wp_attachment_image_alt', true);
            if(!empty($item['link'])){
                $video = $item['link']?: 0;
            }
            
            if ($module_id == 'tour_gallrey') {
                $video = $item['video']?: 0;
            }
            $i++;
            $image_size = $i==1 ? 'gallery_big' : 'gallery_small';
            //$image_size = 'gallery_small';
            if ($module_id == 'tour_gallrey') {
                $image_size = 'gallery_small';
            }
            $class = 'img-all';
            if ($module_id == 'destination_gallrey' || $module_id == 'excursion_gallrey') {
                $class = $i==1 ? 'first-img' : 'img-all' ;
            }
            
            $image_size = apply_filters( 'customize_image_size_gallery',$image_size, $module_id );
            if (!empty($video)) {
                $video_src       = self::get_video( array(
                    'src'      => $video,
                    'src_webm' => $src_webm,
                ) );
            }
            
            $class_private_gallery = $j%4==0?'class_private_gallery':'';
            if ($module_id == 'destination_gallrey' || $module_id == 'excursion_gallrey') {
                $class_private_gallery = in_array($j, array(3,5,9)) ? 'class_private_gallery' : ' ';
            }
            $j++;
            if (!empty($video)) {
                $video_size = $i==1 ? 'width:570px;height:570px;' : 'width:270px;height:270px;';
                if ($module_id == 'tour_gallrey') {
                    $video_size = 'width:270px;height:270px;';
                }
                $src_thumb = $this->get_attachment_image_src($image_id_thumb, $image_size);
                $video_play =str_replace("iframe","iframe height=270 width=270",$video_src);
                $video_play =str_replace("?feature=oembed","?rel=0",$video_play);
                //$html = "<span  class='grid-item ".$class."'>";
                //$html .= '<div class=""><div class="gallery-item" style="'.$video_size.' margin-bottom:5px;">';
                $html = '<a href="'.$video.'"  class="mfp-iframe icon_video_play '.$class_private_gallery.' image-'.$j.' " title="'.$excerpt.'" >
                             <img src="'.$src_thumb.'" alt="'.$image_thumb_alt.'"/> 
                             <h5 class="title-in-gallery">'.$excerpt.'</h5>
                          </a>';
                // $html .= '<div class="gallery-item-info">';
                // $html .= '<div class="gallery-item-desc">' . $excerpt . '</div>';
                // $html .= '</div>';
                //$html .='</div></div></span>';
                $tmp[] = $html;
            }
            else{
                $src_thumb = $this->get_attachment_image_src($image_id_thumb, $image_size);
                $src_full = wp_get_attachment_url($image_id);
                //$html = "<span  class='grid-item ".$class."'>";
                //$html .= '<div class="gallery-item">';
                $html = '<a href="'.$src_full.'" class="'.$class_private_gallery.' image-'.$j.' item-gallery" title="'.$excerpt.'">';
                $html .= "<img src='{$src_thumb}' alt='{$image_thumb_alt}'/>
                <h5 class=title-in-gallery>".$excerpt."</h5>
                </a>";
                // $html .= '<div class="gallery-item-info">';
                // $html .= '<div class="gallery-item-desc">' . $excerpt . '</div>';
                // $html .= '</div>';
                //$html .= '</div></span>';
                $tmp[] = $html;
            }
        }
        $this->shortcode_content = implode('', $tmp);
        
        if ($module_id == 'tour_gallrey') {
            $data_masonry = array(
                'gutter' => 30,
                'itemSelector' => '.grid-item',
            );
        }else{
            $data_masonry = array(
                'gutter' => 30,
                'itemSelector' => '.grid-item',
                'columnWidth' => 270,
            );
        }
        


        $class = " et_pb_module et_pb_bg_layout_{$background_layout}";
        $wrapper_module_id = 'wrapper_'.$module_id;
        $output = sprintf(
            '<div%3$s class="et_pb_text%2$s%4$s ">
                <div class="masonry-grid grid gallery-image-box %6$s"     data-masonry="%5$s">
                    %1$s
                </div>
            </div> <!-- .et_pb_text -->',
            $this->shortcode_content,
            esc_attr( $class ),
            ( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
            ( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
            htmlspecialchars(json_encode($data_masonry)),
            $wrapper_module_id
        );

        return $output;
    }
    
    function get_attachment_image_src( $att_id, $image_size ) {
        if( function_exists( 'fly_get_attachment_image_src' ) ) {
            $image = fly_get_attachment_image_src( $att_id, $image_size );
            return $image['src'];
        }
        return 'fly_get_attachment_image_src';
    }
}
new Gallery_Image;


