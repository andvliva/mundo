<?php
/**
 * Theme Single Post Section for our theme.
 *
 * @package ThemeGrill
 * @subpackage ColorMag
 * @since ColorMag 1.0
 */
 global $post;
 $post_id = $post->ID;
 $current_lang = pll_current_language();
 ?>
<?php get_header(); ?>
<?php
        //the_content();
        $post_id = get_the_ID();
        // print_r($post_id);exit();
        $img_banner = get_post_meta($post_id,'image_banner',false);
        $terms = wp_get_post_terms($post_id,'category-destination');
                        if($terms){
                            $list_category = '';
                            foreach($terms as $term){
                                $list_category = $term->name;
                            }
                        }
        //print_r($img_banner);exit();
        if($img_banner){
            foreach ($img_banner as  $att_id) {
                switch ($current_lang) {
                    case 'en':
                        $banner_title = $post->post_title.' tour & travel';
                        break;
                    case 'es':
                        $banner_title = 'Paquetes de viajes a '.$post->post_title.' 2019';
                        break;
                    case 'pt':
                    $banner_title = 'Pacotes e viagens no '.$post->post_title;
                    break;
                }
                $url = wp_get_attachment_url($att_id);
                //$img_shortcode .= '[et_pb_slide _builder_version="3.0.106"  background_image="'.$url.'" /]';
                $img_shortcode .= '[et_pb_slide _builder_version="3.0.106" heading="'.$banner_title.'" use_background_color_gradient="off"  background_image="'.$url.'" parallax="off" ]<a href="'.home_url().'">'.__('Home','Mundo').'</a> /  '.__('Destination','Mundo').'[/et_pb_slide]';
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
        ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="navbarNavAltMarkup">
    <div class="navbar-nav container row navbar-nav-single et_pb_row">
        <?php $link = get_permalink();?>
        <div class="col-md-7 scroll-to-div">
            <a class="nav-item nav-link active " scroll-to ="overvew" ><?php echo __('Overview', 'Mundo');?></a>
            <a class="nav-item nav-link " scroll-to ="des_our_trips" ><?php echo __('Itineraries', 'Mundo');?></a>
            <a class="nav-item nav-link " scroll-to ="city"><?php echo __('Highlights', 'Mundo');?></a>
            <a class="nav-item nav-link " scroll-to ="gallrey"><?php echo __('Gallery', 'Mundo');?></a>
            <a class="nav-item nav-link " scroll-to ="information"><?php echo __('Information', 'Mundo');?></a>
            <a class="nav-item nav-link " scroll-to ="our_expert"><?php echo __('Experts', 'Mundo');?></a>
        </div>
            
        <div class="btn-nav btn-single-desti col-md-5 show_on_desktop">
                        <?php 
                            $files = rwmb_meta('pdf_file', array(), $post->ID );
                            foreach ( $files as $file ) {
                                $pdf = $file['url'];
                            }
                            $current_lang = pll_current_language();
                            $home_url =  $current_lang=='en'?home_url():substr( esc_url( home_url( '/' ) ),0,-3);
                        ?>
                        <span class="show_on_desktop">
                            <a href="" class="share-head"><?php echo __('Share', 'Mundo');?></a>
                            <div class="triangle2" >
                                    <ul class="et-social-icons icon-menu-top">
                                                    <li class="et-social-icon et-social-facebook">
                                                        <?php $link_share = "https://www.facebook.com/sharer.php?u=".get_permalink($post->ID);
                                                        $link_share_print = "https://www.pinterest.com/pin/find/?url=".get_permalink($post->ID);
                                                         $link_share_twitter = "https://twitter.com/intent/tweet?text=How%20to%20share%20a%20Tweet&url=".get_permalink($post->ID);
                                          ?>
                                                    <a href="<?php echo $link_share;?>" class="icon" target="blank">
                                                            <span><?php echo __('Facebook','Mundo') ?></span>
                                                        </a>
                                                    </li>
                                                    <!-- <li class="et-social-icon et-social-google-plus">
                                                        <a href="https://mail.google.com/mail/u/0/#inbox">
                                                            <img src="<?php echo $home_url;?>/wp-content/themes/mundo/icon/google.png" class="icon-img">
                                                            <img src="<?php echo $home_url;?>/wp-content/themes/mundo/icon/google_hover.png" class="icon-hover">
                                                        </a>
                                                    </li> -->
                                                    <li class="et-social-icon et-social-whatsapp" >
                                                        <a href="<?php echo $link_share_print;?>" target="blank">
                                                            <i class="fa fa-pinterest" ></i>
                                                            <!-- <img src="<?php echo $home_url;?>/wp-content/themes/mundo/icon/whatsapp.png" class="icon-img">
                                                            <img src="<?php echo $home_url;?>/wp-content/themes/mundo/icon/whatsapp_hover.png" class="icon-hover"> -->
                                                        </a>
                                                    </li>
                                                    <li class="et-social-icon et-social-twitter" >
                                                        <a href="<?php echo $link_share_twitter;?>" class="icon" target="blank" >
                                                            <span><?php echo __('Twitter','Mundo') ?></span>
                                                        </a>
                                                    </li>
                                    </ul>
                            </div>
                        </span>
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
                        ?>
                        <a href="<?php echo $link;?>" class="make-enquire"> <?php echo __('MAKE AN ENQUIRY','Mundo') ?></a>
                    </div>
    </div>
    </div>
</nav>
<div id="main" class="clearfix   ">
    <input type="hidden" name="destination_id" value="<?php echo $post_id; ?>" id="destination_id">
    <div class="inner-wrap clearfix">
  <?php do_action( 'colormag_before_body_content' ); ?>
    <div id="content" class="clearfix destination-single">
        <div id="overvew" class="row container et_pb_row">
            
            <div class="col-md-7 col-sm-7">
                <h2 class="title-overview"><?php echo __('Overview', 'Mundo');?></h2>

                <div class="content-overview">
                    <?php echo get_post_meta($post_id,'content',true);?>
                    <div class="wrapper-image-map show_on_mobile">
                        <?php 
                            $map_img_id = get_post_meta($post_id,'map_image',true);
                            $map_img_iframe = get_post_meta($post_id,'map_iframe',true);
                            if( $map_img_id && empty($map_img_iframe) ) {
                                $src = mundo_get_attachment_image_src($map_img_id, 'map_image');
                                $map_img = sprintf('<img src="%s" alt="%s" class="image_map" />', $src, $post->post_title);
                                echo $map_img;
                            }
                            if($map_img_iframe) {
                                echo $map_img_iframe;
                            }
                        ?>
                    </div>
                    <?php 
                        $Capital = get_post_meta($post_id,'capital',true);
                        if($Capital){
                    ?>
                        <div class="row">
                            <span class="desti-left-overview col-md-3 col-sm-3"><?php echo __('Capital','Mundo') ?>:</span>
                            <span class="desti-right-overview col-md-7 col-sm-5"><?php echo $Capital;?></span>
                        </div>
                    <?php } ?>
                    <?php 
                        $mainlanguage = get_post_meta($post_id,'mainlanguage',true);
                        if($mainlanguage){
                    ?>
                        <div class="row">
                            <span class="desti-left-overview col-md-3 col-sm-3"><?php echo __('Language','Mundo') ?>:</span>
                            <span class="desti-right-overview col-md-7 col-sm-5"><?php echo $mainlanguage;?></span>
                        </div>
                    <?php } ?>
                    <?php 
                        $population = get_post_meta($post_id,'population',true);
                        if($population){
                    ?>
                        <div class="row">
                            <span class="desti-left-overview col-md-3 col-sm-3"><?php echo __('Population','Mundo') ?>:</span>
                            <span class="desti-right-overview col-md-7 col-sm-5"><?php echo $population;?></span>
                        </div>
                    <?php } ?>
                    <?php 
                        $curentcy = get_post_meta($post_id,'curentcy',true);
                        if($curentcy){
                    ?>
                        <div class="row">
                            <span class="desti-left-overview col-md-3 col-sm-3"><?php echo __('Currency','Mundo') ?>:</span>
                            <span class="desti-right-overview col-md-7 col-sm-5"><?php echo $curentcy;?></span>
                        </div>
                    <?php } ?>
                     <?php 
                        $time_zone = get_post_meta($post_id,'time_zone',true);
                        if($time_zone){
                    ?>
                        <div class="row">
                            <span class="desti-left-overview col-md-3 col-sm-3"><?php echo __('Time zone','Mundo') ?>:</span>
                            <span class="desti-right-overview col-md-7 col-sm-5"><?php echo $time_zone;?></span>
                        </div>
                    <?php } ?>
                    <?php 
                        $calling_code = get_post_meta($post_id,'calling_code',true);
                        if($calling_code ){
                    ?>
                        <div class="row">
                            <span class="desti-left-overview col-md-3 col-sm-3"><?php echo __('Calling code','Mundo') ?>:</span>
                            <span class="desti-right-overview col-md-7 col-sm-8"><?php echo $calling_code;?></span>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-5 col-sm-5 wrapper-image-map show_on_desktop">
                <?php 
                    $map_img_id = get_post_meta($post_id,'map_image',true);
                    $map_img_iframe = get_post_meta($post_id,'map_iframe',true);
                    if( $map_img_id && empty($map_img_iframe) ) {
                        $src = mundo_get_attachment_image_src($map_img_id, 'map_image');
                        $map_img = sprintf('<img src="%s" alt="%s" class="image_map" />', $src, $post->post_title);
                        echo $map_img;
                    }
                    if($map_img_iframe) {
                        echo $map_img_iframe;
                    }
                ?>
            </div>
        </div>
        <div id="des_our_trips"></div>
        <div id="our_trips">
            <div class="show_on_desktop">
                <?php 
                switch ($current_lang) {
                    case 'en':
                        $group_title = '<span> 2019 '.$post->post_title.'</span> travel packages';
                        break;
                    case 'es':
                        $group_title = 'Paquetes de viajes a <span> 2019 '.$post->post_title.'</span>';
                        break;
                    case 'pt':
                    $group_title = 'Os melhores pacotes<span> 2019 '.$post->post_title.'</span>';
                    break;
                }
                    echo do_shortcode('[et_pb_section bb_built="1" _builder_version="3.0.106" prev_background_color="#ffffff" next_background_color="#ffffff" background_color="#f5f5f5"][et_pb_row _builder_version="3.0.47" background_size="initial" background_position="top_left" background_repeat="repeat"][et_pb_column type="4_4"][et_pb_text admin_label="Travel style" _builder_version="3.0.106" background_layout="light"]
                        <h2>'.$group_title.'</h2>
                        [/et_pb_text][et_pb_post_sliders_with_js _builder_version="3.0.106" show_content="off" post_type="post" display_content="on" show_thumbnail="on" show_more="on" show_author="off" show_date="off" show_categories="on" show_comments="off" show_pagination="off" title_before_image="off" fullwidth="on" use_overlay="off" owl_items="6" owl_margin="16" background_layout="light" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2" module_id="post_tour_slider_js" /][/et_pb_column][/et_pb_row][/et_pb_section]');
                ?>
            </div>
            <div class="show_on_mobile">
                <?php 
                    echo do_shortcode('[et_pb_section bb_built="1" _builder_version="3.0.106" prev_background_color="#ffffff" next_background_color="#ffffff" background_color="#f5f5f5"][et_pb_row _builder_version="3.0.47" background_size="initial" background_position="top_left" background_repeat="repeat"][et_pb_column type="4_4"][et_pb_text admin_label="Travel style" _builder_version="3.0.106" background_layout="light" custom_padding="230px|||"]
                        <h2>'.__("Inspiring",'Mundo').'<br> <span>'.__("Experiences",'Mundo').' '.__("in",'Mundo').' '.$post->post_title.'</span></h2>
                        [/et_pb_text][et_pb_post_slider_with_js admin_label="Post Sliders With Js Show in mobile" show_more="on" show_comments="off" module_id="post_tour_slider_js_mobile" post_type="post" title_before_image="off" owl_items="3" owl_margin="20" _builder_version="3.0.106" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2" show_content="off" show_thumbnail="on" show_author="off" show_date="off" show_categories="on" show_pagination="off" fullwidth="on" use_overlay="off" background_layout="light" display_content="on" module_class="show_on_mobile" /][/et_pb_column][/et_pb_row][/et_pb_section]');
                ?>
            </div>
            <?php $current_lang = pll_current_language();
                    $post_id = $post->ID;
                        $terms = wp_get_post_terms( $post_id, 'category-destination', array() );
                        $query_args['post_type']= 'tour';
                        $query_args['posts_per_page'] = -1;
                        $query_args['meta_query'] = array(
                            array(
                                'key' => 'select_type',
                                'value' => 'seat_in_coach',
                                'compare' => '=',
                            ),                       
                        );
                        $query_args['tax_query']['destination'] = array(
                                    'taxonomy' => 'category-destination',
                                    'field'    => 'slug',
                                    'terms'    => $terms[0]->slug,
                       );
                    $sic_tour = get_posts($query_args);
                if($current_lang!='en' && !empty($sic_tour)){ ?>
            <div class="list-sic-tour">
            <?php 
                echo do_shortcode('[et_pb_section bb_built="1" _builder_version="3.0.106" prev_background_color="#000000" next_background_color="#f5f5f5" module_class="travel-post-wrapper"][et_pb_row _builder_version="3.0.106" background_size="initial" background_position="top_left" background_repeat="repeat" module_class="travel-post"][et_pb_column type="4_4"][et_pb_text admin_label="Travel Ispirations" _builder_version="3.0.106" background_layout="light" module_class="travel-post-text"]
                    <h2><span>'.__("Group",'Mundo').'</span> '.__('tours','Mundo').'</h2>
                    [/et_pb_text]
                    [et_pb_post_owlcarousel _builder_version="3.0.106" posts_number="-1" include_categories="634" show_content="on" post_type="post" display_content="on" show_thumbnail="off" show_more="on" show_author="off" show_date="off" show_categories="off" show_comments="off" show_pagination="on" title_before_image="off" fullwidth="on" use_overlay="off" background_layout="light" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2" module_class="" module_id="sic_destination_page" more_text="'.__("Show more","Mundo").'" owl_margin="30px" /]
                    [/et_pb_column][/et_pb_row][/et_pb_section]');
            ?>
        </div>
        <?php }?>
        </div>

        <div id="city">
            <?php 
                $terms = wp_get_post_terms( $post_id, 'category-destination', array() );
                $terms_parent = get_terms( array(
                            'taxonomy' => 'category-destination',
                            'hide_empty' => false,
                            'parent' => 0,
                        ) );
                $terms_parent_id = wp_list_pluck($terms_parent,'term_id');
                if(in_array($terms[0]->term_id, $terms_parent_id)){ //Nếu là đất nước thì chạy đoạn code này
                $terms_parent_2 = get_terms( array(
                            'taxonomy' => 'category-destination',
                            'hide_empty' => false,
                            'parent' => $terms[0]->term_id,
                        ) );  
                // print_r($terms_parent_2);exit();
                if( $terms_parent_2 ){//Nếu nó có child thì mới chạy đoạn này
            ?>
            <h2 class="title-overview container city-of et_pb_row">
                
                <?php 
                $current_lang = pll_current_language();
                if($current_lang == 'en'){?>
                    <?php echo  $post->post_title;?> <span> <?php echo __(' highlights','Mundo') ?></span>
                <?php } elseif($current_lang == 'es'){
                    echo ot_get_option('highlight_es');
                }else{ echo ot_get_option('highlight_pt'); }?>
            </h2>
            <?php 
                echo do_shortcode('[et_pb_section bb_built="1" fullwidth="off" specialty="off" prev_background_color="#000000" next_background_color="#000000"][et_pb_row][et_pb_column type="4_4"][et_pb_post_owlcarousel _builder_version="3.0.106" show_content="off" post_type="post" show_thumbnail="on" show_more="off" show_author="off" show_date="off" show_categories="off" show_comments="off" show_pagination="off" title_before_image="off" fullwidth="on" use_overlay="off" owl_nav="on" owl_items="6" owl_margin="30"  background_layout="light" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2" module_id="city_of_vietnam" /][/et_pb_column][/et_pb_row][/et_pb_section]');
            }//end if term parent 2
            }
            ?>
            <div class="gallrey " id="gallrey">
                <div class="container et_pb_row">
                    <h2 class="title-overview container et_pb_row gallery"><?php echo __('Gallery','Mundo') ?></h2>
                    <div class="clear-both"></div>
                    <?php echo do_shortcode('[et_pb_text_gallery_image _builder_version="3.0.106" module_id="destination_gallrey"/]');?>
                    <div class="clear-both"></div>
                </div>
            </div>

        </div>
        <div id="information" class="container et_pb_row">
            <?php 
                 $terms = wp_get_post_terms( $post_id, 'category-destination', array() );
                    $terms_parent = get_terms( array(
                                'taxonomy' => 'category-destination',
                                'hide_empty' => false,
                                'parent' => 0,
                            ) );
                    $terms_parent_id = wp_list_pluck($terms_parent,'term_id');
                    if(in_array($terms[0]->term_id, $terms_parent_id)){
                ?>
                <h2 class="title-overview"><?php echo __('Information:', 'Mundo');?></h2>
            <?php }else{ ?>
                <h2 class="title-overview"><?php echo __('Information:', 'Mundo');?></h2>
            <?php } ?>
            <div class="information-toggle-tabs single-toggle-mundo">
                <?php 
                $information = get_post_meta($post_id, 'information', false) ?: 0;
                //$toggle = ('[et_pb_accordion _builder_version="3.0.106"]');
                foreach($information[0] as $key=>$item) {
                   $title = $item['title_destination_info'] ;
                   $content = $item['content_destination_info'] ; 
                   $open = $key == 0?'open=on':'open=off';
                   $open = 'open=off';
                   echo do_shortcode('[et_pb_toggle _builder_version="3.0.106" title="'.$title.'" '.$open.']
                                    '.apply_filters('the_content',$content).'
                                    [/et_pb_toggle]');
                    // $toggle .= '[et_pb_accordion_item _builder_version="3.0.106" title="'.$title.'" use_background_color_gradient="off" background_color_gradient_start="#2b87da" background_color_gradient_end="#29c4a9" background_color_gradient_type="linear" background_color_gradient_direction="180deg" background_color_gradient_direction_radial="center" background_color_gradient_start_position="0%" background_color_gradient_end_position="100%" background_color_gradient_overlays_image="off" parallax="off" parallax_method="on" background_size="cover" background_position="center" background_repeat="no-repeat" background_blend="normal" allow_player_pause="off" background_video_pause_outside_viewport="on" text_shadow_style="none" box_shadow_style="none" text_shadow_horizontal_length="0em" text_shadow_vertical_length="0em" text_shadow_blur_strength="0em"]
                    //             '.apply_filters( 'the_content', $content ).'
                    //         [/et_pb_accordion_item]';
                }
                //$toggle .= '[/et_pb_accordion]';
                //echo do_shortcode($toggle);
                ?>
            </div>
        </div>
        <?php 
            $terms = wp_get_post_terms( $post_id, 'category-destination', array() );
            $terms_parent = get_terms( array(
                        'taxonomy' => 'category-destination',
                        'hide_empty' => false,
                        'parent' => 0,
                    ) );
            $terms_parent_id = wp_list_pluck($terms_parent,'term_id');

        if( in_array($terms[0]->term_id, $terms_parent_id) ) {
        ?>
        <div class="customer-feedback container et_pb_row display_none">
                <h2 class="title-overview"><?php echo __('Trip <span style="color:black;">review</span>', 'Mundo');?></h2>
                <!-- <div class="row"> -->
                    <?php
                    $terms = wp_get_post_terms( $post_id, 'category-destination', array() );
                    $args = array(
                      'numberposts' => -1,
                      'post_type'   => 'customer_feedback',
                      'tax_query' => array(
                            array(
                                'taxonomy' => 'category-destination',
                                'field'    => 'slug',
                                'terms'    => $terms[0]->slug,
                            ),
                        ),

                    );
                    $customer_feedbacks = get_posts( $args );
                    $customer_feedbacks_2 = array_chunk($customer_feedbacks, 2);
                    foreach ($customer_feedbacks_2 as $key2 => $value2) {
                        echo '<div class="row">';
                        foreach ($value2 as  $customer_feedbacks) {
                            $customer_id = $customer_feedbacks->ID;
                            $name = get_post_meta($customer_id,'guest_name',true);
                            $form = '<span class="feedback-info">'.get_post_meta($customer_id,'from',true).'</span>';
                            $tour = get_post_meta($customer_id,'tour',true);
                            $tour_arr = get_post($tour);
                            $tour_name = '<span class="feedback-info">'.$tour_arr->post_title.'</span>';
                            $content = get_post_meta($customer_id,'content',true);?>
                            <div class="col-md-6 col-sm-6">
                                <h4 class="customer-feedback-name"><?php echo $name;?></h4>
                                <div class="info-customer"> 
                                    <span><?php //echo __('From: ', 'Mundo').$from;?></span>
                                    <span><?php //echo __('Tour: ', 'Mundo').$tour_name;?></span>    
                                </div>
                                <div class="content-customer">
                                    <?php echo $content;?>
                                </div>
                            </div>
                            <?php
                        }    
                        echo '</div>';
                    } ?>
        </div>
        <?php }else{?>
        <div class="destination-hotel alternative_hotel ">
            <?php 
           

                // echo do_shortcode('[et_pb_section bb_built="1" fullwidth="off" specialty="off" prev_background_color="#000000" next_background_color="#000000"][et_pb_row][et_pb_column type="4_4"][et_pb_text admin_label="Our Expert" _builder_version="3.0.106" background_layout="light"]
                // <h2><strong>Hotel in<span style="color: #ff0000;">'.$post->post_title.'</span></strong></h2>
                // [/et_pb_text][et_pb_custom_post admin_label="Our expert" _builder_version="3.0.106" posts_number="3" show_content="on" show_thumbnail="on" show_more="off" show_author="off" show_date="off" show_categories="off" show_comments="off" show_pagination="off" fullwidth="off" use_overlay="off" background_layout="light" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2" module_id="post_hotel_detination" child_mix_blend_mode="multiply" /][/et_pb_column][/et_pb_row][/et_pb_section]');


                // [et_pb_custom_post admin_label="Our expert" _builder_version="3.0.106" posts_number="3" show_content="on" show_thumbnail="on" show_more="off" show_author="off" show_date="off" show_categories="off" show_comments="off" show_pagination="off" fullwidth="off" use_overlay="off" background_layout="light" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2" module_id="post_hotel_detination" child_mix_blend_mode="multiply" /]
                echo do_shortcode('[et_pb_section bb_built="1" fullwidth="off" specialty="off" prev_background_color="#000000" next_background_color="#000000"][et_pb_row][et_pb_column type="4_4"][et_pb_text admin_label="Our Expert" _builder_version="3.0.106" background_layout="light"]
                <h2><span>'.__("Hotels","Mundo").'</span> '.__("in","Mundo").' '.$post->post_title.'</h2>
                [/et_pb_text]
                [et_pb_post_owlcarousel _builder_version="3.0.106" posts_number="-1" include_categories="634" show_content="on" post_type="post" display_content="on" show_thumbnail="on" show_more="on" show_author="off" show_date="off" show_categories="off" show_comments="off" show_pagination="on" title_before_image="off" fullwidth="on" use_overlay="off" background_layout="light" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2"  module_id="post_hotel_detination" " owl_margin="30px" /]

                [/et_pb_column][/et_pb_row][/et_pb_section]');

                $link_show_more_city = get_permalink(get_page_by_path('hotel')).'?city='.$terms[0]->slug;
                switch ($current_lang) {
                    case 'en':
                        $link_hotel = get_permalink(get_page_by_path('hotel-2')).'?city='.$terms[0]->slug;
                        $link_res = get_permalink(get_page_by_path('restaurants')).'?city='.$terms[0]->slug;
                        break;
                    case 'es':
                        $link_hotel = get_permalink(get_page_by_path('hotel-es')).'?city='.$terms[0]->slug;
                        $link_res = get_permalink(get_page_by_path('restaurantes')).'?city='.$terms[0]->slug;
                        break;
                    case 'pt':
                        $link_hotel = get_permalink(get_page_by_path('hotel-pt')).'?city='.$terms[0]->slug;
                        $link_res = get_permalink(get_page_by_path('restaurants-pt')).'?city='.$terms[0]->slug;
                        break;
                }
            ?>
            <div class="wrapper-make-enquire-city et_pb_row">
                        <a href="<?php echo $link_hotel;?>" class="make-enquire show-more-city"><?php echo __('SHOW MORE','Mundo') ?></a>
            </div>
            <div class="destination-restaurant">
                <?php 
                    echo do_shortcode('[et_pb_section bb_built="1" fullwidth="off" specialty="off" prev_background_color="#000000" next_background_color="#000000"][et_pb_row][et_pb_column type="4_4"][et_pb_text admin_label="Our Expert" _builder_version="3.0.106" background_layout="light"]
                    <h2><span>'.__("Restaurants","Mundo").'</span> '.__("in","Mundo").' '.$post->post_title.'</h2>
                    [/et_pb_text]
                    [et_pb_post_owlcarousel _builder_version="3.0.106" posts_number="-1" include_categories="634" show_content="on" post_type="post" display_content="on" show_thumbnail="on" show_more="on" show_author="off" show_date="off" show_categories="off" show_comments="off" show_pagination="on" title_before_image="off" fullwidth="on" use_overlay="off" background_layout="light" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2"  module_id="post_restaurant_detination" " owl_margin="30px" /]
                    
                    [/et_pb_column][/et_pb_row][/et_pb_section]');


                ?>
                <div class="wrapper-make-enquire-city et_pb_row">
                            <a href="<?php echo $link_res;?>" class="make-enquire show-more-city"><?php echo __('SHOW MORE','Mundo') ?></a>
                </div>
            </div>
        </div>
        <?php } ?>
        <div id="our_expert">
            <?php 

            $experts = get_post_meta($post_id,'experts',false);
                // echo do_shortcode('[et_pb_section bb_built="1" fullwidth="off" specialty="off" prev_background_color="#000000" next_background_color="#000000"][et_pb_row][et_pb_column type="4_4"][et_pb_text admin_label="Our Expert" _builder_version="3.0.106" background_layout="light"]
                // <h2><strong>Our <span style="color: #ff0000;">Expert</span></strong></h2>
                // [/et_pb_text][et_pb_custom_post_2 admin_label="Our expert" _builder_version="3.0.106" posts_number="4" show_content="off" show_thumbnail="on" show_more="off" show_author="off" show_date="off" show_categories="off" show_comments="off" show_pagination="off" fullwidth="off" use_overlay="off" background_layout="light" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2" module_id="post_expert_detination" child_mix_blend_mode="multiply" /][/et_pb_column][/et_pb_row][/et_pb_section]');

                 echo do_shortcode('[et_pb_section bb_built="1" _builder_version="3.0.106" prev_background_color="#000000" next_background_color="#000000" module_class="wrapper-our-expert" custom_padding="110px|||"][et_pb_row module_class="four-column-blog-grid our-expert-text-wrapper" _builder_version="3.0.106"][et_pb_column type="4_4"][et_pb_text admin_label="Our Expert" _builder_version="3.0.106" background_layout="light"]
                <h2><strong><span style="color: #000;">'.__("Meet our",'Mundo').'</span> <span style="color: #bd1e2d;">'.__("experts",'Mundo').'</span></strong></h2>
                [/et_pb_text][/et_pb_column][/et_pb_row][et_pb_row module_class="four-column-blog-grid our-expert-list-wrapper" _builder_version="3.0.106"][et_pb_column type="1_4"][et_pb_custom_post_2 admin_label="Our expert" fullwidth="off" posts_number="4" show_author="off" show_date="off" show_categories="off" show_pagination="off" module_id="post_expert_detination" _builder_version="3.0.106" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2" child_mix_blend_mode="multiply" more_text="Read More" show_content="off" show_thumbnail="on" show_more="off" show_comments="off" use_overlay="off" background_layout="light"]
                &nbsp;
                [/et_pb_custom_post_2][/et_pb_column][et_pb_column type="3_4"][/et_pb_column][/et_pb_row][/et_pb_section]');
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

                // echo do_shortcode('[et_pb_section bb_built="1" _builder_version="3.0.106" prev_background_color="#cc3333" next_background_color="#cc3333" background_color="#cc3333" module_class="what_ever_you_want  what-ever-single-tour"][et_pb_row _builder_version="3.0.106" background_size="initial" background_position="top_left" background_repeat="repeat" module_class="whatever-text"][et_pb_column type="4_4"][et_pb_text_fullwidth admin_label="What ever you want" _builder_version="3.0.106" header_line_height_tablet="2" background_layout="light" custom_padding="20px|||"]
                //     '.ot_get_option('what_ever_main_title').'
                //     <p style="text-align: center;"><span style="color: #e7a4a4;">'.ot_get_option('what_ever_sub_title').'</span></p>
                //     [/et_pb_text_fullwidth][/et_pb_column][/et_pb_row][et_pb_row _builder_version="3.0.106" background_size="initial" background_position="top_left" background_repeat="repeat" module_class="whatever-contact "][et_pb_column type="1_3"][et_pb_text admin_label="sdt" _builder_version="3.0.106" background_layout="light" module_class="what-ever-or"]
                //     <a href="tel:'.strip_tags(ot_get_option('what_ever_phone')).'" class="phone-mundo"><h4><span style="color: #fff; font-size: 18px;">'.ot_get_option('what_ever_phone').'</span></h4></a>

                //     [/et_pb_text][/et_pb_column][et_pb_column type="1_3"][et_pb_button button_text="'.ot_get_option('what_ever_button_1').'" _builder_version="3.0.106" url_new_window="off" background_layout="light" custom_button="off" button_icon_placement="right" module_class=" make-an-enquiry-contatct" button_url="'.$link.'"]

                //     &nbsp;

                //     [/et_pb_button][/et_pb_column][et_pb_column type="1_3"][/et_pb_column][/et_pb_row][/et_pb_section]');
            ?>
        </div>
        <?php 
            global $post;
                $post_id = $post->ID;
                $terms = wp_get_post_terms( $post_id, 'category-destination', array() );

                $query_args_blog['post_type']= 'post'; 
                $query_args_blog['tax_query']['blog_destination'] = array(
                            'taxonomy' => 'category-destination',
                            'field'    => 'slug',
                            'terms'    => $terms[0]->slug,
               );
                //print_r($query_args);exit();
                $wp_query = new WP_Query( $query_args_blog );
               $found_posts =  $wp_query->found_posts;
               if($found_posts>0){
        ?>
        <div class="trvel-inspiration">
            <?php 
                // echo do_shortcode('[et_pb_section bb_built="1" fullwidth="off" specialty="off" prev_background_color="#000000" next_background_color="#000000"][et_pb_row][et_pb_column type="4_4"][et_pb_text admin_label="Travel Inspirations" _builder_version="3.0.106" background_layout="light"]
                // <h2><strong>Travel <span style="color: #ff0000;">Inspirations</span></strong></h2>
                // [/et_pb_text][et_pb_custom_post admin_label="Travel Inspirations list" _builder_version="3.0.106" posts_number="3" show_content="off" show_thumbnail="on" show_more="on" show_author="off" show_date="on" show_categories="off" show_comments="off" show_pagination="off" fullwidth="off" use_overlay="off" background_layout="light" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2" module_id="post_home" more_text="Show More" /][/et_pb_column][/et_pb_row][/et_pb_section]');
                echo do_shortcode('[et_pb_section bb_built="1" _builder_version="3.0.106" prev_background_color="#000000" next_background_color="#f7f7f7" module_class="travel-post-wrapper"][et_pb_row _builder_version="3.0.106" background_size="initial" background_position="top_left" background_repeat="repeat" module_class="travel-post"][et_pb_column type="4_4"][et_pb_text admin_label="Travel Ispirations" _builder_version="3.0.106" background_layout="light" module_class="travel-post-text"]
                    <h2>'.__("Travel",'Mundo').' <span>'.__('inspirations','Mundo').'</span></h2>
                    [/et_pb_text]
                    [et_pb_post_owlcarousel _builder_version="3.0.106" posts_number="-1" include_categories="634" show_content="off" post_type="post" display_content="on" show_thumbnail="on" show_more="on" show_author="off" show_date="off" show_categories="off" show_comments="off" show_pagination="on" title_before_image="off" fullwidth="on" use_overlay="off" background_layout="light" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2" module_class="travel-post-list" module_id="post_destination_page" more_text="'.__("Show more","Mundo").'" owl_margin="30px" /]
                    [/et_pb_column][/et_pb_row][/et_pb_section]');
            ?>
        </div>
       <?php }?>
    </div><!-- #content -->
<?php do_action( 'colormag_after_body_content' ); ?>
</div>
</div>
<?php get_footer(); ?>
