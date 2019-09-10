<?php

get_header();
global $post;
$post_id = $post->ID;
$current_lang = pll_current_language();
?>

<div id="main-content">

<?php while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <div class="entry-content">
        <?php
        $post_id = get_the_ID();
        $img_banner = get_post_meta($post_id,'image_banner',false);
        $terms = wp_get_post_terms($post_id,'category-destination'); 
                        if($terms){
                            $list_category = '';
                            foreach($terms as $term){
                                $list_category = $term->name;
                                $term_parent = $term->parent;
                                $term_post_id = $term->term_id;
                            }
                        }

        $args = array(
            'post_type' => 'destination',
            'tax_query' => array(
                array(
                    'taxonomy' => 'category-destination',
                    'field'    => 'term_id',
                    'terms'    => array( $term_parent),
                    'include_children' => false
                ),
            ),
        );

        $destination_post = get_posts($args);
        //print_r($destination_post);exit();
        $term_parents = get_term($term_parent,'category-destination');
        $term_parents_list = '<a href="'.get_permalink($destination_post[0]->ID).'">'.$term_parents->name.'</a>';
        if($img_banner){
            foreach ($img_banner as  $att_id) {
                $url = wp_get_attachment_url($att_id);
                //$img_shortcode .= '[et_pb_slide _builder_version="3.0.106"  background_image="'.$url.'" /]';
                $bread =$term_parents_list.' / '.$list_category;
                $img_shortcode = '[et_pb_slide _builder_version="3.0.106" heading="'.$post->post_title.'" use_background_color_gradient="off"  background_image="'.$url.'" parallax="off" ]<a href="'.home_url().'">'.__('Home','Mundo').'</a> /  '.$bread.' [/et_pb_slide]';
            }
        }
        //Phần header
        $tab_mobile = '[et_pb_text_fullwidth admin_label="Mobile call" _builder_version="3.0.106" background_layout="light" header_line_height_tablet="2" module_class="wrapper-mobile-tab"]
                        [tab_mobile]
                        [/et_pb_text_fullwidth]';
        echo do_shortcode('
            [et_pb_section bb_built="1" fullwidth="on"]
                [et_pb_fullwidth_slider _builder_version="3.0.106" auto="on" auto_speed="300000" auto_ignore_hover="on" module_class="banner_not_home " ]    
                    '.$img_shortcode.'
                [/et_pb_fullwidth_slider]'.$tab_mobile .'
            [/et_pb_section]');
        //Phần body
        $over_view_text = get_post_meta($post_id,'over_view_text',true);
        echo '<div class="hotel-overview text_gray text_center et_pb_row">'.$over_view_text.'</div>';
        $terms = wp_get_post_terms( $post_id, 'hotel_style', array() );
        $hotel_style = $terms[0]->name;
        $location = get_post_meta($post_id,'location',true);
        $no_of_rooms = get_post_meta($post_id,'no_of_rooms',true);
        $price_from = get_post_meta($post_id,'price_from',true);
        $price_from = $price_from?'$'.$price_from:__('On Request','Mundo');
        ?>
        <div class="row et_pb_row hotel_info text-align-center">
            <div class="col-md-4 col-sm-4"><span class="text_gray text_inline"><?php echo __('Style','Mundo') ?></span><h2><?php echo $hotel_style;?></h2></div>
            <div class="col-md-4 col-sm-4"><span class="text_gray text_inline"><?php echo __('No. of rooms','Mundo') ?></span><h2><?php echo $no_of_rooms;?></h2></div>
            <div class="col-md-4 col-sm-4"><span class="text_gray text_inline"><?php echo __('Location','Mundo') ?></span><h2><?php echo $list_category;?></h2></div>
        </div>
        <hr class="line_center"/>
        <div class="row et_pb_row">
            <h3 class="col-md-12 text-align-center key-hotel"><b><?php echo __('Key features','Mundo') ?></b></h3>
            <div class="col-md-12  text-align-center text_gray key-features">
            <div class="key_features">
                <?php $terms = wp_get_post_terms( $post_id, 'key_features', array() );
                 $terms_name = array();
                foreach ($terms as $term) {
                     //$terms_name[] =$term->name;
                     $term_name .= '<span>'.$term->name.' </span>';
                }
                    //$term_name .= '<span>'.$terms_name.' </span>';//implode( ' ', $terms_name);
                    echo $term_name;  
                ?>
            </div>
            </div>
        </div>
        
        <div class="slider_hotel">
        <?php 
        // slider
     
        $img_shortcode ='';
        $gallery  = get_post_meta($post_id,'gallery',true);
      //  print_r($gallery); exit;
        if($gallery){
            foreach ($gallery as  $att_id) {
                $url = wp_get_attachment_url($att_id['image'][0]);
                $title = $att_id['title'];
               // $img_shortcode .= '[et_pb_slide _builder_version="3.0.106"  background_image="'.$url.'" /]';
                $img_shortcode .= '[et_pb_slide_3_img _builder_version="3.0.106" use_background_color_gradient="off" background_color_gradient_start="#2b87da" background_color_gradient_end="#29c4a9" background_color_gradient_type="linear" background_color_gradient_direction="180deg" background_color_gradient_direction_radial="center" background_color_gradient_start_position="0%" background_color_gradient_end_position="100%" background_color_gradient_overlays_image="off" parallax="off" parallax_method="on" background_size="cover" background_position="center" background_repeat="no-repeat" background_blend="normal" allow_player_pause="off" background_video_pause_outside_viewport="on" use_bg_overlay="off" use_text_overlay="off" text_border_radius="3" alignment="center" child_filter_hue_rotate="0deg" child_filter_saturate="100%" child_filter_brightness="100%" child_filter_contrast="100%" child_filter_invert="0%" child_filter_sepia="0%" child_filter_opacity="70%" child_filter_blur="0px" child_mix_blend_mode="normal" background_layout="dark" text_shadow_style="none" header_text_shadow_style="none" body_text_shadow_style="none" custom_button="off" button_bg_use_color_gradient="off" button_bg_color_gradient_overlays_image="off" button_use_icon="on" button_on_hover="on" button_text_shadow_style="none" box_shadow_style_button="none" image="'.$url.'" text_shadow_horizontal_length="0em" text_shadow_vertical_length="0em" text_shadow_blur_strength="0em" header_text_shadow_horizontal_length="0em" header_text_shadow_vertical_length="0em" header_text_shadow_blur_strength="0em" body_text_shadow_horizontal_length="0em" body_text_shadow_vertical_length="0em" body_text_shadow_blur_strength="0em" button_text_shadow_horizontal_length="0em" button_text_shadow_vertical_length="0em" button_text_shadow_blur_strength="0em" heading="'.$title.'" button_text="sea" image_alt="'.$title.'"]

ataegas
        [/et_pb_slide_3_img]';
            }
        }
        $slider = '
        [et_pb_section bb_built="1" fullwidth="on" specialty="off" prev_background_color="#000000"][et_pb_row][et_pb_column type="4_4"]
        [et_pb_slider_3_img _builder_version="3.0.106" show_arrows="on" show_pagination="on" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" custom_button="off" button_icon_placement="right" show_content_on_mobile="on" show_cta_on_mobile="on" show_image_video_mobile="off"]
       '.$img_shortcode.'
        [/et_pb_slider_3_img]
        [/et_pb_column][/et_pb_row][/et_pb_section]';

         echo do_shortcode($slider);
        ?>
        </div>
        <?php
        $tabs ='[et_pb_section bb_built="1" fullwidth="off" specialty="off"  _builder_version="3.0.106" module_id="wrapper_tab_single" background_color="rgba(0,0,0,0)"  prev_background_color="#000000" next_background_color="#000000"][et_pb_row][et_pb_column type="4_4"]
        [et_pb_tabs _builder_version="3.0.106"  background_color="rgba(224,224,224,0)" border_width_all="0px" module_class="tab-itinerary "]';
        
        $tab_contents = array();
        $rooms = get_post_meta($post_id,'hotel_detail',true);
       // print_r($rooms); exit;
        $content = '<div class="row et_pb_row">';
            foreach ($rooms as $key => $value) {
                $content .= '<div class="col-md-3 col-sm-3">';
                $img_banner = $value['room_img'];
                if($img_banner){
                    $img = '';
                    $src = mundo_get_attachment_image_src($img_banner[0], 'room_hotel');
                    $image_alt = get_post_meta( $img_banner[0], '_wp_attachment_image_alt', true);
                    $content .= '<img src="'.$src.'" alt="'.$image_alt.'">';
                }
                $content .='<div class="img_title">'.$value['room_img_title'].'</div></div>';
            }
        $detail_left = get_post_meta($post_id,'detail_left',true);
        $detail_right = get_post_meta($post_id,'detail_right',true);
        $content .= '</div> <div class="row et_pb_row">
        <div class="col-md-6 col-sm-6">'.$detail_left.'</div>
        <div class="col-md-6 col-sm-6">'.$detail_right.'</div>
        </div>';
        $tab_contents = array(
            'accommodation' =>array(
                'tab_title' => 'Accommodation',
                'tab_content' => $content,
            ),
            'location' => array(
                'tab_title' => get_post_meta($post_id, 'title_location', true)?:__('Location','Mundo'),
                'tab_content' => get_post_meta($post_id, 'location_hotel', true),
            ),
            'map' => array(
                'tab_title' => 'Map',
                'tab_content' => get_post_meta($post_id, 'map_hotel', true),
            )
            
        );
        if (empty($location)) {
            unset($tab_contents['location']);        
        }
        foreach($tab_contents as $tab_content){
            $tabs_detail[] = '[et_pb_tab _builder_version="3.0.106" title="'.__($tab_content['tab_title'],'Mundo').'" use_background_color_gradient="off" background_color_gradient_start="#2b87da" background_color_gradient_end="#29c4a9" background_color_gradient_type="linear" background_color_gradient_direction="180deg" background_color_gradient_direction_radial="center" background_color_gradient_start_position="0%" background_color_gradient_end_position="100%" background_color_gradient_overlays_image="off" parallax="off" parallax_method="on" background_size="cover" background_position="center" background_repeat="no-repeat" background_blend="normal" allow_player_pause="off" background_video_pause_outside_viewport="on" tab_text_shadow_style="none" body_text_shadow_style="none" tab_text_shadow_horizontal_length="0em" tab_text_shadow_vertical_length="0em" tab_text_shadow_blur_strength="0em" body_text_shadow_horizontal_length="0em" body_text_shadow_vertical_length="0em" body_text_shadow_blur_strength="0em"]'. $tab_content['tab_content'].'[/et_pb_tab]';
        }
        
        //d($tabs_detail);
        $tabs .= implode(" ",$tabs_detail);
        $tabs .= '[/et_pb_tabs][/et_pb_column][/et_pb_row][/et_pb_section]';
        echo do_shortcode($tabs);
        // $detail_left = get_post_meta($post_id,'detail_left',true);
        // $detail_right = get_post_meta($post_id,'detail_right',true);

?>
       <hr class="hotel_line et_pb_row" />
       <?php 
            // $highlight_posts = (get_post_meta($post->ID,'things_to_do',false))?:array();
            // $destination_posts = (get_post_meta($post->ID,'destination',false))?:array();
            // $hotel_posts = (get_post_meta($post->ID,'hotel',false))?:array();
            $excursion_posts = (get_post_meta($post->ID,'excursion',false))?:array();
            // $restaurant_posts = (get_post_meta($post->ID,'restaurant',false))?:array();
            // $blog_posts = (get_post_meta($post->ID,'blog',false))?:array();                                                
            // $things_to_do = array_merge($highlight_posts,$destination_posts, $hotel_posts,$excursion_posts, $restaurant_posts, $blog_posts);
            if ($excursion_posts) {
            
       ?>
        <div class="hotel_things_to_do">
            <h2 class="et_pb_row"><span><?php echo __('Things','Mundo') ?> </span><?php echo __('to do','Mundo') ?></h2>
            <?php
              
              echo do_shortcode('[et_pb_section bb_built="1" fullwidth="off" specialty="off"][et_pb_row][et_pb_column type="4_4"][et_pb_post_owlcarousel _builder_version="3.0.106" posts_number="-1" show_content="off" post_type="post" display_content="on" show_thumbnail="on" show_more="off" show_author="off" show_date="off" show_categories="off" show_comments="off" show_pagination="off" title_before_image="off" fullwidth="on" use_overlay="off" background_layout="light" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2" module_id="thing_to_do_hotel" owl_items="4" owl_margin="20" /][/et_pb_column][/et_pb_row][/et_pb_section]');
             ?>
        </div>
        <?php 
        }
            if(get_post_meta($post->ID,'alternative_hotel',true)){
        ?>
        <div class="alternative_hotel">
        <?php
            echo do_shortcode('[et_pb_section bb_built="1" fullwidth="off" specialty="off" prev_background_color="#000000" next_background_color="#000000"][et_pb_row][et_pb_column type="4_4"][et_pb_text admin_label="Our Expert" _builder_version="3.0.106" background_layout="light"]
                <h2><strong><span>'.__("Alternative",'Mundo').' </span>'.__("places to stay nearby",'Mundo').' </strong></h2>
                [/et_pb_text][et_pb_custom_post admin_label="Our expert" _builder_version="3.0.106" posts_number="3" show_content="on" show_thumbnail="on" show_more="off" show_author="off" show_date="off" show_categories="off" show_comments="off" show_pagination="off" fullwidth="off" use_overlay="off" background_layout="light" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2" module_id="post_hotel_alternative" child_mix_blend_mode="multiply" /][/et_pb_column][/et_pb_row][/et_pb_section]');
          ?>
          </div>
        <?php } ?>
          <div class="hotel_contact">
          <?php    
          $current_lang = pll_current_language();
            switch ($current_lang) {
                    case 'en':
                        $link = get_permalink(get_page_by_path('make-enquiry'));
                        $link_join = get_permalink(get_page_by_path('subcribe'));
                        break;
                    case 'es':
                        $link = get_permalink(get_page_by_path('hacer-reserva'));
                        $link_join = get_permalink(get_page_by_path('suscribirse'));
                        break;
                    case 'pt':
                        $link = get_permalink(get_page_by_path('solicite-aqui'));
                        $link_join = get_permalink(get_page_by_path('make-enquiry'));
                        break;
                    default:
                        $link = get_permalink(get_page_by_path('make-enquiry'));
                        $link_join = get_permalink(get_page_by_path('subscribe-pt'));
                        break;
                }
            // echo do_shortcode('[et_pb_section bb_built="1" _builder_version="3.0.106" prev_background_color="#bd1e2d" next_background_color="#bd1e2d" background_color="#bd1e2d" module_class="what_ever_you_want"][et_pb_row _builder_version="3.0.106" background_size="initial" background_position="top_left" background_repeat="repeat" module_class="whatever-text"][et_pb_column type="4_4"][et_pb_text_fullwidth admin_label="What ever you want" _builder_version="3.0.106" header_line_height_tablet="2" background_layout="light" custom_padding="20px|||"]
            //     '.ot_get_option('what_ever_main_title').'
            //     <p style="text-align: center;"><span style="color: #fff;">'.ot_get_option('what_ever_sub_title').'</span></p>
            //     [/et_pb_text_fullwidth][/et_pb_column][/et_pb_row][et_pb_row _builder_version="3.0.106" background_size="initial" background_position="top_left" background_repeat="repeat" module_class="whatever-contact"][et_pb_column type="1_3"][et_pb_text admin_label="sdt" _builder_version="3.0.106" background_layout="light" module_class="what-ever-or"]
            //     <a href="tel:'.strip_tags(ot_get_option('what_ever_phone')).'" class="phone-mundo">
            //     <h4><span style="color: #fff; font-size: 24px; font-weight: bold">'.ot_get_option('what_ever_phone').'</span></h4></a>

            //     [/et_pb_text][/et_pb_column][et_pb_column type="1_3"][et_pb_button button_text="'.ot_get_option('what_ever_button_1').' " _builder_version="3.0.106" url_new_window="off" background_layout="light" custom_button="off" button_icon_placement="right" module_class=" make-an-enquiry-contatct" button_url="'.$link.'"]

            //     &nbsp;

            //     [/et_pb_button][/et_pb_column][et_pb_column type="1_3"][/et_pb_column][/et_pb_row][/et_pb_section]');
            switch ($current_lang) {
                    case 'en':
                        echo do_shortcode('[et_pb_section bb_built="1" _builder_version="3.0.106" module_class="get-in-touch" prev_background_color="#000000" next_background_color="#000000" global_module="19984"][/et_pb_section]');
                        break;
                    case 'es':
                        echo do_shortcode('[et_pb_section bb_built="1" _builder_version="3.0.106" module_class="get-in-touch" prev_background_color="#000000" next_background_color="#000000" global_module="20848"][/et_pb_section]');
                        break;
                    case 'pt':
                        echo do_shortcode('[et_pb_section bb_built="1" _builder_version="3.0.106" module_class="get-in-touch" prev_background_color="#000000" next_background_color="#000000" global_module="20860"][/et_pb_section]');
                        break;
                    default:
                        echo do_shortcode('[et_pb_section bb_built="1" _builder_version="3.0.106" module_class="get-in-touch" prev_background_color="#000000" next_background_color="#000000" global_module="19984"][/et_pb_section]');
                        break;
                }

        ?>
        </div> 
    </div><!-- .entry-content -->
    </article> <!-- .et_pb_post -->

<?php  endwhile; ?>

</div> <!-- #main-content -->

<?php
get_footer();
