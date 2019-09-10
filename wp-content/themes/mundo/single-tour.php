<?php
global $post;
$post_id = $post->ID;
// print_r($_COOKIE);exit();
if (isset($_COOKIE['post_tour']))
{   
    $cookie_tour =  $_COOKIE['post_tour'];
    //print_r($cookie_tour);exit();
    $all_id_tour = explode("-",$cookie_tour);
    //print_r($all_id_tour);exit();
    if (in_array($post_id, $all_id_tour)) {
        $save_tour_text = __('Remove tour','Mundo');
    }else{
        $save_tour_text = __('Save tour','Mundo');
    }
}else{
    $save_tour_text = __('Save tour','Mundo');
}
//print_r($save_tour_text);exit();
 $symbol_exchange = '$';
if (isset($_COOKIE['exchange_rate'])){
    $exchange_rate_string = $_COOKIE['exchange_rate'];
    $exchange_rate_cookie = explode("-",$exchange_rate_string); 
    $exchange_detail = $exchange_rate_cookie[2];
    $symbol_exchange = $exchange_rate_cookie[1];
}
$current_lang =  pll_current_language();
date_default_timezone_set('Asia/Ho_Chi_Minh');
switch ($current_lang) {
    case 'en':
        setlocale(LC_TIME, 'us_US');
        break;
    case 'es':
        setlocale(LC_TIME, 'es_ES');
        break;
    case 'pt':
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        break;

}

get_header();
//lấy ngày có giá nhỏ nhất
$sort_tour_by_cat = get_post_meta($post_id,'sort_tour_by_cat',true);
//print_r($sort_tour_by_cat);
    $min_time_rate = get_min_time_tour_rate($post_id);
    $min_time = $min_time_rate['min_time'] ;
    $min_date = $min_time_rate['min_date'] ;
    //print_r($min_time_rate);exit();
$departings = get_post_meta($post_id,'departure_date',true);
foreach($departings as $key => $departing){
    if ($key==0) {
        $time_sic = $departing['date']['timestamp'];
    }
    
}
//print_r($min_date);exit();
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
                            }
                        }
        if($img_banner){
            $image_count = 0;
            foreach ($img_banner as  $att_id) {
                if ($image_count==0) {
                    $url_image_pdf = wp_get_attachment_url($att_id);
                }
                $url_image = wp_get_attachment_url($att_id);
                //$bread ='<a href="'.'#'.'">'.$list_category.' / '.$post->post_title;
                $bread = $post->post_title;
                $img_shortcode .= '[et_pb_slide _builder_version="3.0.106" heading="'.$post->post_title.'" use_background_color_gradient="off"  background_image="'.$url_image.'" parallax="off" ]<a href="'.home_url().'">'.__('Home','Mundo').'</a> /  '.__('Destination','Mundo').' / '.$bread.' [/et_pb_slide]';
                $image_count++;
            }
        }
        //Phần header
        $tab_mobile = '[et_pb_text_fullwidth admin_label="Mobile call" _builder_version="3.0.106" background_layout="light" header_line_height_tablet="2" module_class="wrapper-mobile-tab"]
                        [tab_mobile]
                        [/et_pb_text_fullwidth]';
        echo do_shortcode('
            [et_pb_section bb_built="1" fullwidth="on"]
                [et_pb_fullwidth_slider _builder_version="3.0.106" auto="on" auto_speed="300000" auto_ignore_hover="on" module_class=" banner_not_home " ]    
                    '.$img_shortcode.'
                [/et_pb_fullwidth_slider]'.$tab_mobile .'
            [/et_pb_section]');
        ?>
        <div class='banner-pdf'>
            <h2><?php echo $post->post_title;?></h2>
            <img src="<?php echo $url_image_pdf;?>" class='url-image-pdf'>
        </div>
        
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarNavAltMarkup">
                <div class="navbar-nav et_pb_row navbar-nav-single row">
                    <?php $link = get_permalink();
                        $nav_texts = ot_get_option('nav_header_single_tour');
                        $nav_text = explode('-',$nav_texts);
                    ?>
                    <div class="col-md-6 scroll-to-div show_on_desktop">
                        <a class="nav-item nav-link active" scroll-to ="overvew-tour" ><?php echo esc_html__($nav_text[0], 'Mundo');?></a>
                        <a class="nav-item nav-link" scroll-to ="highlight" ><?php echo esc_html__($nav_text[1], 'Mundo');?></a>
                        <a class="nav-item nav-link" scroll-to ="Itinerary" ><?php echo esc_html__($nav_text[2], 'Mundo');?></a>
                        <a class="nav-item nav-link disabled" scroll-to ="Gallrey"><?php echo __($nav_text[3], 'Mundo');?></a>
                        <a class="nav-item nav-link disabled" scroll-to ="tour_info" ><?php echo __($nav_text[4], 'Mundo');?></a>
                    </div>
                    <div class="btn-nav col-md-6">
                        <?php 
                            $files = rwmb_meta('pdf_file', array(), $post->ID );
                            
                            foreach ( $files as $file ) {
                                $pdf = $file['url'];
                            }
                            $current_lang = pll_current_language();
                            $home_url =  $current_lang=='en'?home_url():substr( esc_url( home_url( '/' ) ),0,-3);
                        ?>
                        <span>
                            <a href="" class="share-head"><?php echo __('Share','Mundo');?></a>
                            <div class="triangle2" >
                                <ul class="et-social-icons icon-menu-top">
                                    <li class="et-social-icon et-social-facebook">
                                    <?php $link_share = "https://www.facebook.com/sharer.php?u=".get_permalink($post->ID);
                                          $link_share_print = "https://www.pinterest.com/pin/find/?url=".get_permalink($post->ID);
                                          $link_share_twitter = "https://twitter.com/intent/tweet?text=How%20to%20share%20a%20Tweet&url=".get_permalink($post->ID);
                                    ?>
                                    <a href="<?php echo $link_share;?>" class="icon" target="blank">
                                            <span><?php echo __('Facebook','Mundo');?></span>
                                        </a>
                                    </li>
                                  <!--   <li class="et-social-icon et-social-google-plus">
                                        <a href="https://mail.google.com/mail/u/0/#inbox">
                                            <img src="<?php echo $home_url;?>./wp-content/themes/mundo/icon/google.png" class="icon-img">
                                            <img src="<?php echo $home_url;?>./wp-content/themes/mundo/icon/google_hover.png" class="icon-hover">
                                        </a>
                                    </li> -->
                                    <li class="et-social-icon et-social-whatsapp" >
                                        <a href="<?php echo $link_share_print;?>" target="blank">
                                            <i class="fa fa-pinterest" ></i>
                                            <!-- <img src="<?php echo $home_url;?>./wp-content/themes/mundo/icon/whatsapp.png" class="icon-img">
                                            <img src="<?php echo $home_url;?>./wp-content/themes/mundo/icon/whatsapp_hover.png" class="icon-hover"> -->
                                        </a>
                                    </li>
                                    <li class="et-social-icon et-social-twitter" >
                                        <a href="<?php echo $link_share_twitter;?>" class="icon" target="blank">
                                            <span>Twitter</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </span>
                        <a href="<?php echo $pdf;?>" class="dowload-pdf" data-post="<?php echo $post->ID;?>"><?php echo __('Download PDF','Mundo');?></a>
                        <a class="save-tour-head"><img src="<?php echo $home_url;?>/wp-content/themes/mundo/icon/salecolor.png"> <?php echo $save_tour_text;?></a>
                        <?php 
                            $tour_guides = wp_get_post_terms($post_id,'tour_guide',array());
                            if ($tour_guides) {
                                    $tour_guide_cus = get_main_lang_tour($post_id);
                                    $tour_lang_main = $tour_guide_cus['main_lang'];
                            }
                            $current_lang = pll_current_language();
                            $type = get_post_meta($post->ID,'select_type',true);
                            switch ($current_lang) {
                                    case 'en':
                                        $link_customize = get_permalink(get_page_by_path('booking-customize-tour')).'?post_id='.$post->ID.'&month='.$min_date.'&adult=2&language='.$tour_lang_main.'&flight=no&book=BOOK+NOW';
                                        $link_sic = get_permalink(get_page_by_path('booking-sic-tour')).'?post_id='.$post->ID.'&date_from='.$time_sic.'&book=BOOK+NOW';;
                                        $link = $type == 'customize'?$link_customize:$link_sic;
                                        break;
                                    case 'es':
                                        $link_customize = get_permalink(get_page_by_path('reservar-ahora')).'?post_id='.$post->ID.'&month='.$min_date.'&adult=2&language='.$tour_lang_main.'&flight=no&book=BOOK+NOW';
                                        $link_sic = get_permalink(get_page_by_path('reserva-de-salidas-garantizadas')).'?post_id='.$post->ID.'&date_from='.$time_sic.'&book=BOOK+NOW';;
                                        $link = $type == 'customize'?$link_customize:$link_sic;
                                        break;
                                    case 'pt':
                                        $link_customize = get_permalink(get_page_by_path('reserva-personalizar')).'?post_id='.$post->ID.'&month='.$min_date.'&adult=2&language='.$tour_lang_main.'&flight=no&book=BOOK+NOW';
                                        $link_sic = get_permalink(get_page_by_path('reserva-saidas-regulares')).'?post_id='.$post->ID.'&date_from='.$time_sic.'&book=BOOK+NOW';;
                                        $link = $type == 'customize'?$link_customize:$link_sic;
                                        break;
                                    default:
                                        $link_customize = get_permalink(get_page_by_path('booking-customize-tour')).'?post_id='.$post->ID.'&month='.$min_date.'&adult=2&language='.$tour_lang_main.'&flight=no&book=BOOK+NOW';
                                        $link_sic = get_permalink(get_page_by_path('booking-sic-tour')).'?post_id='.$post->ID.'&date_from='.$time_sic.'&book=BOOK+NOW';;
                                        $link = $type == 'customize'?$link_customize:$link_sic;
                                        break;
                                }
                        ?>
                        <a href="<?php echo $link;?>" class="make-enquire"><?php echo __('BOOK NOW','Mundo');?> </a>
                    </div>
                </div>
            </div>
        </nav>
        <?php
        //Phần body
        $content_over_view = get_post_meta($post_id,'content_over_view',true);
        echo '<div class="hotel-overview text_gray text-align-center" id="overvew-tour">'.$content_over_view.'</div>'?:'';
        $terms = wp_get_post_terms( $post_id, 'hotel_style', array() );
        $hotel_style = $terms[0]->name;
        $location = get_post_meta($post_id,'location',true);
        $no_of_rooms = get_post_meta($post_id,'no_of_rooms',true);
        $tour_guides = wp_get_post_terms($post_id,'tour_guide',array());
        if ($tour_guides) {
        ?>
            <div class="row et_pb_row">
                <p class="text-align-center text_gray guide-lang" ><?php echo __('Language spoken on tour','Mundo');?></p> 
            </div>
             <?php 
                
                $tour_guide_cus = get_main_lang_tour($post_id);

                $tour_html = $tour_guide_cus['tour_html'];
                $tour_lang_main = $tour_guide_cus['main_lang'];
                echo '<div class="tour_guide text-align-center"> <b>'.$tour_html.'</b></div>';//exit();
        }
        $highlight_citys = get_post_meta( $post_id, 'highlight_city', true );
        if ($highlight_citys) {
            ?>
            <div class="row et_pb_row">
                <p class="col-md-12 text-align-center text_gray"><?php echo __('Places visited','Mundo');?></p>
                <div class="col-md-12 place-of-visit text-align-center">
                    <?php 
                    $highlight_citys = str_replace(',','</span><span>',$highlight_citys);
                        echo '<div class="text-align-center"><span>'.$highlight_citys.'</span></div>';  
                    ?>
                </div>
            </div>
            
        <?php 
        }
            $terms = wp_get_post_terms( $post_id, 'travel_style', array() );
            $travel_style = $terms[0]->name;    
            $travel_style = get_post_meta($post_id,'travel_style',true);  
            $primary_style = get_primary_taxonomy_id($post_id,'travel_style');
			$terms_style = get_terms( 'travel_style', array(
                            'hide_empty' => false,'term_taxonomy_id'=>$primary_style,
                        ) );
            $travel_style = $terms_style[0]->name;            
            //print_r($terms_style);exit();    
            $price_from = mundo_get_price_last_6_month($post_id)?$symbol_exchange.' '.floor(mundo_get_price_last_6_month($post_id)):__('On Request','Mundo');
            //print_r($post_id);exit();
            $lang = pll_current_language();
            //print_r($price_from);exit();
            $price_from = (intval($price_from))?mundo_exchange_rate($price_from,$lang ):$price_from;
            //$price_from = mundo_get_by_guide($price_from,$tour_lang_main);
            $price = floor($price);
            $itinerarys = get_post_meta($post_id,'itinerary',false);
            $days = count($itinerarys[0]);
             //if ($days&&$travel_style) {
        ?>
            <div class="row et_pb_row text-align-center list-infotour">
                <div class="col-md-4 col-sm-4 "><span class="text_gray text_inline"><?php echo __('Days','Mundo');?></span><?php echo '<h2>'.$days.'</h2>';?></div>
                <div class="col-md-4 col-sm-4"><span class="text_gray text_inline"><?php echo __('Style','Mundo');?></span><?php echo '<h2>'.$travel_style.'</h2>';?></div>
                <?php if ($price_from) {
                    ?>
                    <div class="col-md-4 col-sm-4"><span class="text_gray text_inline"><?php echo __('From','Mundo');?></span><h2> <?php echo  $price_from.'</h2>';?></div>
                <?php }
                else{
                    $link_contact = get_permalink(get_page_by_path( 'subcribe' ));
                    echo '<div class="col-md-3 offset-md-1"><span class="text_gray text_inline">'.__('Price','Mundo').'</span><h2><a href="'.$link_contact.'">On request</a></h2></div>';
                }?>
            </div>
        <?php  //}
                $highlight_posts = (get_post_meta($post_id,'tour_highlight',false))?:array();
                $destination_posts = (get_post_meta($post_id,'destination',false))?:array();
                $hotel_posts = (get_post_meta($post_id,'hotel',false))?:array();
                $restaurant_posts = (get_post_meta($post_id,'restaurant',false))?:array();
                $blog_posts = (get_post_meta($post_id,'blog',false))?:array();                
                $tour_highlights = array_merge($highlight_posts,$destination_posts, $hotel_posts, $restaurant_posts, $blog_posts);
            if ($tour_highlights) {
         ?>
            <div class="highlight " id="highlight"><div class="et_pb_row">
                <h2 class="et_pb_row text-align-center"><?php echo ot_get_option('text_high_light');?></h2></div>
                <?php 
                                                
                
                 
                
                                                    
                $highlight = '[et_pb_section bb_built="1" fullwidth="off" specialty="off" prev_background_color="rgba(0,0,0,0)" _builder_version="3.0.106" background_color="rgba(29,30,30,0)"][et_pb_row _builder_version="3.0.106" custom_margin="0px|||" custom_padding="0px|||"][et_pb_custom_slider_owlcarousel _builder_version="3.0.106" show_arrows="off" show_pagination="off" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" custom_button="off" button_icon_placement="right" show_content_on_mobile="on" show_cta_on_mobile="on" show_image_video_mobile="off" owl_items="4" module_class="explore" module_id="tour_highlights"]';
                $i = 0;
                foreach ($tour_highlights as $p) {
                    $thumbnail_id = get_post_thumbnail_id($p);
                    $src = mundo_get_attachment_image_src($thumbnail_id, 'tour_detail')?:'';
                                        
                    $title = (get_the_title($p))?:'';
                                          
                    $description_tour_highlight = (get_the_excerpt($p))?:'';
                 
                    $link = get_permalink($p);
                    $class = ($i%2==0) ? 'class-chan':'class-le';
                    $highlight .='[et_pb_custom_slide_owlcarousel _builder_version="3.0.106" heading="'.$title.'" image="'.$src.'" use_background_color_gradient="off" background_color_gradient_start="#2b87da" background_color_gradient_end="#29c4a9" background_color_gradient_type="linear" background_color_gradient_direction="180deg" background_color_gradient_direction_radial="center" background_color_gradient_start_position="0%" background_color_gradient_end_position="100%" background_color_gradient_overlays_image="off" parallax="off" parallax_method="on" background_size="cover" background_position="center" background_repeat="no-repeat" background_blend="normal" allow_player_pause="off" background_video_pause_outside_viewport="on" use_bg_overlay="off" use_text_overlay="off" text_border_radius="3" alignment="center" child_filter_hue_rotate="0deg" child_filter_saturate="100%" child_filter_brightness="100%" child_filter_contrast="100%" child_filter_invert="0%" child_filter_sepia="0%" child_filter_opacity="100%" child_filter_blur="0px" child_mix_blend_mode="normal" background_layout="dark" text_shadow_style="none" header_text_shadow_style="none" body_text_shadow_style="none" custom_button="off" button_bg_use_color_gradient="off" button_bg_color_gradient_overlays_image="off" button_use_icon="on" button_on_hover="on" button_text_shadow_style="none" box_shadow_style_button="none" text_shadow_horizontal_length="0em" text_shadow_vertical_length="0em" text_shadow_blur_strength="0em" header_text_shadow_horizontal_length="0em" header_text_shadow_vertical_length="0em" header_text_shadow_blur_strength="0em" body_text_shadow_horizontal_length="0em" body_text_shadow_vertical_length="0em" body_text_shadow_blur_strength="0em" button_text_shadow_horizontal_length="0em" button_text_shadow_vertical_length="0em" button_text_shadow_blur_strength="0em" title_before_image="of" button_link="#"]';
                    $highlight .= $description_tour_highlight;
                    $highlight .='[/et_pb_custom_slide_owlcarousel]';
                }
                

                  $highlight .=  '[/et_pb_custom_slider_owlcarousel][/et_pb_row][/et_pb_section]';
                  echo do_shortcode($highlight);
                 ?>
            </div>
        <?php }//end if nếu có tour highlight 
        // /$mpdf->AddPage();
        ?>
        
        
        <!-- MAP -->
        <div class="div-tour-information single-toggle-mundo row et_pb_row">
             <?php 
                $title_map = get_post_meta($post_id,'title_map',true);
                $title_map = str_replace("{","<span>",$title_map);
                $title_map = str_replace("}","</span>",$title_map);
                $description_map = get_post_meta($post_id,'description_map',true);
                //if ($title_map&&$description_map) {
                
             ?>
                 <div class="text-align-center">
                    <h2 class="col-md-12 " id="Itinerary"><?php echo $title_map;?></h2>
                    <div class="wrapper-map-des">
                        <?php if($description_map){?>
                            <p class="col-md-12 text_gray"><?php echo $description_map;?></p>
                        <?php } ?>
                    </div>
                    
                 </div>
            <?php 
            //}
            $location_tour_map = get_post_meta($post_id,'location_tour_map',true);
            if ($location_tour_map) {   
                //$map_iframe = get_post_meta($post_id,'map_iframe',true);
                // print_r($location_tour_map);
                foreach ($location_tour_map as $key => $location_tour_map_toado) {
                    $location_first =  get_location_tour($location_tour_map_toado['location_first']);
                    $location_last =  get_location_tour($location_tour_map_toado['location_last']);
                    $arr_location[0] = $location_first;
                    $arr_location[1] = $location_last;
                    $arr_location['curvature'] = $location_tour_map_toado['curvature'];
                    $all_location[] = $arr_location;
                }

                // foreach ($location_tour_map as $key => $value) {
                //$json_location_php = json_encode($value);
                // 
               if ($all_location) {
               ?>
                     <script type="text/javascript">
                         var json_location = <?php echo json_encode($all_location) ?>;
                     </script>
                    <?php
                     //}
                    echo '<div id="map-canvas" style="border: 2px solid #3872ac;"></div>';
                }
            }
        
            $itinerary = get_post_meta($post_id, 'itinerary', true) ?: array();
            if ($itinerary) {
            ?>
                <div class="information-toggle-tabs" >
                    <?php 
                   // $toggle = ('[et_pb_accordion _builder_version="3.0.106"]');
                   $toggle = ('[et_pb_section bb_built="1" fullwidth="off" specialty="off"]');
                    foreach($itinerary as $key => $item) {
                       $title = $item['day_title'] ;
                       $content = $item['itinerary_detail']; 
                       $content = apply_filters( 'the_content', $item['itinerary_detail']);
           
                       $meals = str_replace("no_meals",__("No meals",'Mundo'),implode(', ', $item['meals']));
                       $meals = str_replace("breakfast",__("Breakfast",'Mundo'),$meals);
                       $meals = str_replace("lunch",__("Lunch",'Mundo'),$meals);
                       $meals = str_replace("dinner",__("Dinner",'Mundo'),$meals);
                       if($meals){
                            $content .= '<p class="meals"><span>'.__("Meals",'Mundo').': </span>'.$meals.'</p>'; 
                       }
                       $name = array();
                       foreach ($item['visited'] as  $value) {
                           // $terms = get_terms( 'category-destination', array(
                           //      'hide_empty' => false,'include' => $value,
                           //  ) );
                           // $name[] = $terms[0]->name;
                            $post_des = get_post($value);
                            $name[] = $post_des->post_title;
                        }
                        if($name){
                            $content .= '<p><span>'.__('Visited','Mundo').': </span>'.implode(', ', $name) .'</p>'; 
                        }
                       

                       $name_ac = array();
                       foreach ($item['accomodation'] as  $value) {
                           $p = get_post($value);
                           $name_ac[] = $p->post_title?:'';
                       }
                       $name_ac = implode(', ', $name_ac );
                       if ($name_ac) {
                          $content .= '<p><span>'.__('Accomodation','Mundo').': </span>'.$name_ac .'</p>' ;
                       }
                       
                       $open = $key == 0?'open=on':'open=off';
                       $open = 'open=off';
                       $key =$key+1;
                       $day = __('Day ','Mundo').$key.' : ';
         
                      // $toggle .='[et_pb_row][et_pb_column type="4_4"][et_pb_toggle _builder_version="3.0.106" title="'.$day.$title.'" '.$open.']'.$content.'[/et_pb_toggle][/et_pb_column][/et_pb_row]';
                        $toggle .= ('[et_pb_toggle _builder_version="3.0.106" title=" '.$day.$title.'" '.$open.']
                                         '.$content.'
                                         [/et_pb_toggle]');
                      // $toggle .= '[et_pb_accordion_item _builder_version="3.0.106" title="'.$day.$title.'" use_background_color_gradient="off" background_color_gradient_start="#2b87da" background_color_gradient_end="#29c4a9" background_color_gradient_type="linear" background_color_gradient_direction="180deg" background_color_gradient_direction_radial="center" background_color_gradient_start_position="0%" background_color_gradient_end_position="100%" background_color_gradient_overlays_image="off" parallax="off" parallax_method="on" background_size="cover" background_position="center" background_repeat="no-repeat" background_blend="normal" allow_player_pause="off" background_video_pause_outside_viewport="on" text_shadow_style="none" box_shadow_style="none" text_shadow_horizontal_length="0em" text_shadow_vertical_length="0em" text_shadow_blur_strength="0em"]
//                                '.$content.'
//                            [/et_pb_accordion_item]';
                    }
                   // $toggle .= '[/et_pb_accordion]';
                   $toggle .= '[/et_pb_section]';
                    echo do_shortcode($toggle);
                    ?>
                    <div class="clear-both"></div>
                    <div class="wrapper-make-enquire">
                        <?php 
                        
                        $tour_type = get_post_meta($post_id,'select_type',true);
                        if($tour_type == 'customize'){
                            //1. lay post co gia
                            $custom_rate_posts = get_posts(array(
                                'post_type' => 'customize_rate',
                                'posts_per_page' => -1,
                                'meta_query' => array(
                                    array(
                                        'key' => 'tour_name',
                                        'value' => $post_id,
                                    )
                                ),
                            ));
                            $has_rate = (!empty($custom_rate_posts))?true:false;
                        }else{
                            $departings = get_post_meta($post_id,'departure_date',true);
                            $has_rate = (!empty($departings))?true:false;
                        }
                         //   $link_rate = $has_rate ? $link : $link_rate;
                            $current_lang = pll_current_language();
                            $type = get_post_meta($post->ID,'select_type',true);
                            switch ($current_lang) {
                                    case 'en':
                                        $link_customize = get_permalink(get_page_by_path('booking-customize-tour')).'?post_id='.$post->ID.'&month='.$min_date.'&adult=2&language='.$tour_lang_main.'&flight=no&book=BOOK+NOW';
                                        $link_sic = get_permalink(get_page_by_path('booking-sic-tour')).'?post_id='.$post->ID.'&date_from='.$time_sic.'&book=BOOK+NOW';;
                                        $link = $type == 'customize'?$link_customize:$link_sic;
                                        break;
                                    case 'es':
                                        $link_customize = get_permalink(get_page_by_path('reservar-ahora')).'?post_id='.$post->ID.'&month='.$min_date.'&adult=2&language='.$tour_lang_main.'&flight=no&book=BOOK+NOW';
                                        $link_sic = get_permalink(get_page_by_path('reserva-de-salidas-garantizadas')).'?post_id='.$post->ID.'&date_from='.$time_sic.'&book=BOOK+NOW';;
                                        $link = $type == 'customize'?$link_customize:$link_sic;
                                        break;
                                    case 'pt':
                                        $link_customize = get_permalink(get_page_by_path('reserva-personalizar')).'?post_id='.$post->ID.'&month='.$min_date.'&adult=2&language='.$tour_lang_main.'&flight=no&book=BOOK+NOW';
                                        $link_sic = get_permalink(get_page_by_path('reserva-saidas-regulares')).'?post_id='.$post->ID.'&date_from='.$time_sic.'&book=BOOK+NOW';;
                                        $link = $type == 'customize'?$link_customize:$link_sic;
                                        break;
                                    default:
                                        $link_customize = get_permalink(get_page_by_path('booking-customize-tour')).'?post_id='.$post->ID.'&month='.$min_date.'&adult=2&language='.$tour_lang_main.'&flight=no&book=BOOK+NOW';
                                        $link_sic = get_permalink(get_page_by_path('booking-sic-tour')).'?post_id='.$post->ID.'&date_from='.$time_sic.'&book=BOOK+NOW';;
                                        $link = $type == 'customize'?$link_customize:$link_sic;
                                        break;
                                }
                        ?>
                        <a href="<?php echo $link;?>" class="make-enquire"><?php echo __('BOOK NOW','Mundo');?></a>
                    </div>
                   
                </div>
        <?php } ?>
        </div>
        
        
        
        <!-- GALLERY-->
        <?php 
            $gallery = get_post_meta($post_id, 'gallery', false) ?: 0;
            if ($gallery[0]) {
            
        ?>
        <div class="gallrey " id="Gallrey">
            <div class="et_pb_row">
                 <h2><span><?php echo __('Gallery','Mundo');?></span></h2>
                <?php global $post;echo do_shortcode('[et_pb_text_gallery_image _builder_version="3.0.106" module_id="tour_gallrey"/]');?>
            </div>
        </div>
        <?php } ?>
       
        
        
        
        <!-- Dates &</span> Availability -->
        <?php /* kiem tra tour la customize hay SIC ?
                Neu la customize: tieu de = Caculate best rate ; form khach tu nhap so luong nguoi di, he thong tu dong tinh gia /ng va tong gia.
                Neu la tour SIC: he thong hien thi tat ca gia tour da nhap theo departure month
                
            */
        $tour_type = get_post_meta($post_id,'select_type',true);
        ///print_r($tour_type);
        $tour_type_title = ($tour_type == 'customize')?''.__("Calculate",'Mundo').' '.__("<span>best rate</span>",'Mundo').'':'<span>'.__("Dates &",'Mundo').'</span> '.__("Availability",'Mundo').'';
        $type = get_post_meta($post_id,'select_type',true);
        switch ($current_lang) {
            case 'en':
                $link_customize = get_permalink(get_page_by_path('booking-customize-tour')).'?post_id='.$post->ID.'&month='.$min_date.'&adult=2&language='.$tour_lang_main.'&flight=no&book=BOOK+NOW';
                $link_sic = get_permalink(get_page_by_path('booking-sic-tour')).'?post_id='.$post->ID.'&date_from='.$time_sic.'&book=BOOK+NOW';;
                $url = $type == 'customize'?$link_customize:$link_sic;
                break;
            case 'es':
                $link_customize = get_permalink(get_page_by_path('reservar-ahora')).'?post_id='.$post->ID.'&month='.$min_date.'&adult=2&language='.$tour_lang_main.'&flight=no&book=BOOK+NOW';
                $link_sic = get_permalink(get_page_by_path('reserva-de-salidas-garantizadas')).'?post_id='.$post->ID.'&date_from='.$time_sic.'&book=BOOK+NOW';;
                $url = $type == 'customize'?$link_customize:$link_sic;
                break;
            case 'pt':
                $link_customize = get_permalink(get_page_by_path('reserva-personalizar')).'?post_id='.$post->ID.'&month='.$min_date.'&adult=2&language='.$tour_lang_main.'&flight=no&book=BOOK+NOW';
                $link_sic = get_permalink(get_page_by_path('reserva-saidas-regulares')).'?post_id='.$post->ID.'&date_from='.$time_sic.'&book=BOOK+NOW';;
                $url = $type == 'customize'?$link_customize:$link_sic;
                break;
            default:
                $link_customize = get_permalink(get_page_by_path('booking-customize-tour')).'?post_id='.$post->ID.'&month='.$min_date.'&adult=2&language='.$tour_lang_main.'&flight=no&book=BOOK+NOW';
                $link_sic = get_permalink(get_page_by_path('booking-sic-tour')).'?post_id='.$post->ID.'&date_from='.$time_sic.'&book=BOOK+NOW';;
                $url = $type == 'customize'?$link_customize:$link_sic;
                break;
        }
        //$url = ($tour_type == 'customize')?home_url('booking-customize-tour'):home_url('booking-sic-tour');
            if($tour_type == 'customize'){
                //lay tour guide cho truong Language cua form
                if(!empty($tour_guides)){

                    $lang_select = '<select class="language_select" name="language">';
                    $lang_num = 0;
                    foreach($tour_guides as $tour){
                                $selected_guide = $tour_lang_main==$tour->term_id?'selected':'';
                                $lang_select .= '<option '.$selected_guide.' value="'.$tour->term_id.'">'.pll__($tour->name).'</option>' ;
                                $lang_num++;
                            };
                    $lang_select .= '</select>';
                }
                if(!empty($tour_guides) && $lang_num == 1){//Nếu chỉ có 1 ngôn ngữ thì ô select ko cho chọn
                    $lang_select = '<select class="language_select select-readonly" name="language" readonly>';
                    foreach($tour_guides as $tour){
                                $lang_select .= '<option value="'.$tour->term_id.'">'.pll__($tour->name).'</option>' ;
                            };
                    $lang_select .= '</select>';
                    $only_lang = 'only_lang';
                }
                //print_r($only_lang);exit();
               //lay thang 
               //1. lay post co gia
               $custom_rate_posts = get_posts(array(
                    'post_type' => 'customize_rate',
                    'posts_per_page' => -1,
                    'meta_query' => array(
                        array(
                            'key' => 'tour_name_customize',
                            'value' => $post_id,
                        )
                    ),
               ));
               //print_r($custom_rate_posts);
               //if(!empty($custom_rate_posts)){//ko có giá thì ko show
                if(true){
                    //lay ngay thang hien tai
                   //$current_month_stm = strtotime($current_month)/60/60/24/365;
                   //xet khoang gia lay cac thang sap xep theo thu tu tu thap den cao
                   $months = array();
                   $custom_rates = get_post_meta($custom_rate_posts[0]->ID,'group_tour_rate',true);
                   foreach ($custom_rates as $custom_rate){
                        $from_date = $custom_rate['from_date']['timestamp'];
                        $to_date =  $custom_rate['to_date']['timestamp'];
                        if($to_date <  time()){
                            continue;
                        }
                        $from_date = ($from_date< time())?time():$from_date;
                        for ($i = $from_date; $i < $to_date; $i = strtotime('+1 month', $i)){
                                $months[date('m_Y', $i)] = date('M Y',$i);
                        
                        }
                         
                   }
                    //$month_select = '<select class="month_select" name="month">';
    //                foreach($months as $key => $month){
    //                            $month_select .= '<option value="'.$key.'">'.$month.'</option>' ;
    //                        };
    //                 $month_select .= '</select>';
                    $on_request = mundo_calculate_customize_price_per_person($post->ID, $min_date, 2, $tour_lang_main, 'no');
                    $on_request = $on_request?:'on_request_calender';
                    $month_select = '<input readonly="true" type="text" name="month" value="'.$min_date.'" class="month_select '.$on_request.'">';  
                    //lay so luong nguoi
                    $adult = (get_post_meta($post_id,'number_of_tourists',true))?:14;

                    $adult_select = '<select class="adult_select" name="adult">';
                    for( $i=1; $i <= $adult; $i++){
                                $selected = ($i==2)?'selected':'';
                                $adult_select .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>' ;
                            };
                    $adult_select .= '</select>';
                    
                    // co tinh gia flight
                    $flight_select = '<select class="flight_select" name="flight">
                                        <option value="no">'.__('No','Mundo').'</option>
                                        <option value="yes">'.__('Yes','Mundo').'</option>
                                    </select>';
                    $bottom_text_form = ot_get_option('bottom_text_form');
                    //lay gia tour
                    //$total = mundo_calculate_customize_price_per_person($post_id, $departing['date']['timestamp']);
                    //$total = mundo_exchange_rate($total, $lang);
                    $date_time = date('d/m/Y', time());

                    //foreach($tour_guides as $tour){
                    $lang_id =   $tour_guides[0]->term_id;
                    //        };
                    //print_r($date_time);print_r($lang_id);
                    $price_per_person = mundo_calculate_customize_price_per_person($post->ID, $min_date, 2, $tour_lang_main, 'no');
                    //$price_per_person = $price_per_person ? $price_per_person :__('On Request','Mundo'); 
                    $total_price = $price_per_person*2;
                    $total_price_show =  $total_price ? ' ' :'display_none';
                    $total_price = $total_price ?$symbol_exchange.$total_price:__('On Request','Mundo');

                    $price_per_person = $price_per_person ? $symbol_exchange.$price_per_person : __('On Request','Mundo'); 

                    $flight_tour = wp_get_post_terms($post->ID,'flight',array());
                    $flight_html .= '<ul class="list-filght">';
                    foreach ($flight_tour as $key => $value) {
                        $flight_html .= '<li>'.$value->name.'</li>';
                    }
                    $col_month = $flight_tour?'mundo-6-item':'mundo-5-item';//nếu có flight thì chia làm 6 cột nếu ko thì chia 4 cho tháng

                    $col_month = $total_price_show == 'display_none'?'mundo-5-item':'mundo-6-item';
                    
                    $flight_html .= '</ul>';
                    $form = '
                    <div class="form_cuctomize_tour '.$col_month.'">
                    <form method = "GET" action="'.$url.'" name="frm_customize_tour" id="form_cuctomize_tour" data-post="'.$post_id.'">
                        <input type="hidden" name="post_id" value="'.$post_id.'">
                        <div class="row header"> 
                            <div class="col-md-2 col-sm-2 col-xs-6">'.__('Departure date','Mundo').' </div>
                            <div class="col-md-2 col-sm-2 col-xs-6 show_on_mobile" id="month">'.$month_select.' </div>
                            <div class="col-md-2 col-sm-2 col-xs-6"> '.__('Adult','Mundo').'</div>
                            <div class="col-md-2 col-sm-2 show_on_mobile col-xs-6" id="adult"> '.$adult_select.'</div>
                            <div class="col-md-2 col-sm-2 col-xs-6">'.__('Language','Mundo').' 
                                
                                <i class="fa fa-question-circle mundo-tooltip-head" aria-hidden="true" data-icon="u"  data-toggle="modal" data-target="#myModal_lang"></i>
                                  <!-- Modal -->
                                  <div class="modal fade mundo-tooltip" id="myModal_lang" role="dialog">
                                    <div class="modal-dialog">
                                    
                                      <!-- Modal content-->
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">'.__('Language','Mundo').'</h4>
                                        </div>
                                        <div class="modal-body">
                                          '.ot_get_option('tooltip_language').'
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">'.__('Close','Mundo').'</button>
                                        </div>
                                      </div>
                                      
                                    </div>
                                  </div> <!-- Modal -->
                            </div>';
                    $form        .='<div class="col-md-2 col-sm-2 col-xs-6 '.$only_lang.' show_on_mobile" id="language" > '.$lang_select.'</div>';
                    if($flight_tour){//Nếu có bay thì mới vẽ
                    $form .=    '<div class="col-md-2 col-sm-2 col-xs-6"> '.__('Flight','Mundo').'
                               
                                <i class="fa fa-question-circle mundo-tooltip-head" aria-hidden="true" data-icon="u"  data-toggle="modal" data-target="#myModal"></i>
                                  <!-- Modal -->
                                  <div class="modal fade mundo-tooltip" id="myModal" role="dialog">
                                    <div class="modal-dialog">
                                    
                                      <!-- Modal content-->
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">'.__('Flight','Mundo').'</h4>
                                        </div>
                                        <div class="modal-body">
                                          '.ot_get_option('tooltip_flight').$flight_html.'<div class="clear-both"></div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">'.__('Close','Mundo').'</button>
                                        </div>
                                      </div>
                                      
                                    </div>
                                  </div> <!-- Modal -->
                            </div>';
                            $form .='<div class="col-md-2 col-sm-2 col-xs-6 show_on_mobile" id="flight"> '.$flight_select.'</div>';
                    }
                    $form .= '<div class="col-md-2 col-sm-2 col-xs-6"> '.__('Per person','Mundo').'</div>
                            <div class="col-md-2 col-sm-2 col-xs-6 show_on_mobile" id="per_person">'.$price_per_person.'</div>
                            <div class="col-md-2 col-sm-2 col-xs-6 '.$total_price_show.'"> '.__('Total','Mundo').' </div>
                            <div class="col-md-2 col-sm-2 col-xs-6 show_on_mobile '.$total_price_show.'" id="total">'.$total_price.'</div>
                        </div>
                        <div class="row value show_on_desktop">
                            <div class="col-md-2 col-sm-2 show_on_desktop" id="month">'.$month_select.' </div>
                            <div class="col-md-2 col-sm-2 show_on_desktop" id="adult"> '.$adult_select.'</div>
                            <div class="col-md-2 col-sm-2 '.$only_lang.' show_on_desktop" id="language" > '.$lang_select.'</div>';
                            if($flight_tour){
                                $form .='<div class="col-md-2 col-sm-2 show_on_desktop" id="flight"> '.$flight_select.'</div>';
                            }
                            $form .='<div class="col-md-2 col-sm-2 show_on_desktop" id="per_person">'.$price_per_person.'</div>
                            <div class="col-md-2 col-sm-2 show_on_desktop '.$total_price_show.'" id="total">'.$total_price.'</div>
                            <div class="clear-both"></div>
                        </div>
                        <div class="bottom_text_form text_center text_gray"><span>* </span>'.__($bottom_text_form).'</div>
                        <div class="submit text_center" ><input type="submit" value="'.__('BOOK NOW','Mundo').'" name="book" class="make-enquire"/></div>
                    </form>
                    </div>
                    ';
               }else{
                $form = "<h2> On request </h2>";
               }
            }
            else{
                
                $form = '
                    <div class="form_sic_tour">
                        <div class="row header show_on_desktop"> 
                            <div class="col-md-3 col-sm-3"> '.__('Departing','Mundo').'</div>
                            <div class="col-md-3 col-sm-3"> '.__('Finishing','Mundo').'</div>
                            <div class="col-md-2 col-sm-2"> </div>';
                            //<div class="col-md-2 col-sm-2"> '.__('Adult','Mundo').' </div>
                 $form .=   '<div class="col-md-2 col-sm-2"> '.__('Total from  USD','Mundo').'</div>
                            <div class="col-md-2 col-sm-2"> </div>
                        </div>';
                // lay ngay khoi hanh + ket thuc
                $departings = get_post_meta($post_id,'departure_date',true);
                $departings = array_filter($departings,function($variable){
                    $time_next_10 = time()+86400*10;
                    return $variable['date']['timestamp']>=$time_next_10;
                });
                if(!empty($departings)){
                    $departings_before = array_slice($departings,0, 5);
                    $departings_affter = array_slice($departings, 5);
                    //print_r($departings_affter);
                    $departings_affter = json_encode($departings_affter);
                    $departings_affter = str_replace('"','/',$departings_affter);
                    
                    $dem = 1;
                    foreach($departings_before as $departing){
                        $row_light = (($dem % 2) == 0)?'row_light':'row_black';
                        $dem++;
                        $date_from = date('d M Y', $departing['date']['timestamp']);
                        $date_from_text = utf8_encode( strftime('%d  %B %Y', $departing['date']['timestamp'] ) );
                        $days = 0; 
                        $itinerary = (get_post_meta($post->ID, 'itinerary',true))?:array();            
                        if($itinerary){
                            $days = count($itinerary);
                            if($days>0){
                               $finishing = strtotime('+'.$days.' days', $departing['date']['timestamp']);
                               $finishing = date('d M Y', $finishing);
                               $finishing_text = utf8_encode( strftime('%d  %B %Y', strtotime('+'.$days.' days', $departing['date']['timestamp']) ) );
                            }
                        }
                        //lay so luong nguoi
                        $adult = (get_post_meta($post_id,'number_of_tourists',true))?:1;
                        $adult_select = '<select class="adult_sic_select" name="adult" >';
                        for( $i=1; $i <= $adult; $i++){
                           // $selected = ($i==2)?'selected':'';
                            $adult_select .= '<option value="'.$i.'">'.$i.'</option>' ;
                        };
                        $adult_select .= '</select>';
                        // css cho btn
                        $btn_hide = ($departing["status"][0]== 'full')?'hide_btn':'';
                        $available_text = ($departing["status"][0]== 'full')?__('Fully Booked','Mundo'):__('Available','Mundo');
                        $available_class = ($departing["status"][0]== 'full')?__('fully','Mundo'):__('available','Mundo');
                        
                        //lay gia tour
                        $total = mundo_get_sic_price($post_id, $departing['date']['timestamp']);
                        $total = mundo_exchange_rate($total, $lang);
                        if(($departing["status"][0]== 'full')){
                            $adult_select = '';
                            $total = '';
                        }
                        $form .=  '<form method="GET" action="'.$url.'" name="frm_sic_tour" id="form_sic_tour" data-post="'.$post_id.'">    
                                        <input type="hidden" name="post_id" value='.$post_id.'>
                                        <input type="hidden" name="date_from" value='.$departing['date']['timestamp'].'>
                                        <div class="row  value '.$row_light.'" >
                                            <div class="col-md-3 col-sm-3 col-xs-4 sic-head-mobile show_on_mobile"> '.__('Departing','Mundo').'</div>
                                            <div class="col-md-3 col-sm-3 col-xs-4 sic-head-mobile show_on_mobile"> '.__('Finishing','Mundo').'</div>
                                            <div class="col-md-2 col-sm-2 col-xs-4 show_on_mobile sic-head-mobile"> '.__('Total from  USD','Mundo').'</div>

                                            <div class="col-md-3 col-sm-3 col-xs-4 sic-body-mobile departing '.$dem.' " id="departing" data-date="'.$departing['date']['timestamp'].'">'.$date_from_text.'</div>
                                            <div class="col-md-3 col-sm-3 col-xs-4 sic-body-mobile show_on_mobile" id="finishing">'.$finishing_text.'</div>
                                            <div class="col-md-2 col-sm-2 total col-xs-4 sic-body-mobile show_on_mobile '.$dem.'" id="total"> '.$symbol_exchange.$total.'</div>

                                            

                                            <div class="col-md-3 col-sm-3 show_on_desktop" id="finishing">'.$finishing_text.'</div>
                                            <div class="col-md-2 col-sm-2 show_on_desktop '.$available_class.'">'.$available_text.' </div>';
                        //$form .=            '<div class="col-md-2 col-sm-2" id="adult" data-row="'.$dem.'"> '.$adult_select.'</div>';
                        $form .=        '<div class="col-md-2 col-sm-2  total show_on_desktop '.$dem.'" id="total"> '.$symbol_exchange.$total.'</div>
                                            <div class="col-md-2 col-sm-2 show_on_desktop btn_submit '.$dem.'" id="submit"><input type="submit" value="'.__("BOOK NOW",'Mundo').'" name="book" class="make-enquire '.$btn_hide.'"/></div>
                                            <hr class="show_on_mobile">
                                            
                                            <div class="col-md-2 col-sm-2 col-xs-4 show_on_mobile '.$available_class.'">'.$available_text.' </div>
                                            <div class="col-md-2 col-sm-2 show_on_mobile submit_sic_mobile col-xs-2 btn_submit '.$dem.'" id="submit"><input type="submit" value="'.__("BOOK NOW",'Mundo').'" name="book" class="make-enquire '.$btn_hide.'"/></div>
                                        </div>    
                            </form>';
                          
                    }
                    if(!empty($departings_affter)){
                         $form .='<div id="data" data-departings_affter="'.$departings_affter.'" data-dem="'.$dem.'" data-post="'.$post_id.'">  <div id="sic_tour_rate" class="text_center">'.__('Show more','Mundo').'</div></div></div>';
               
                    }
                }
            }
        
        ?>
          <div class="et_pb_row check-rate-tour" id='tour-rate'>
                <h2 class='title'><?php echo __($tour_type_title,'Mundo')?></h2>
                <?php 
                    echo $form;
                ?>   
          </div>
         <?php
        $price_match_title = get_post_meta($post_id, 'price_match_title', true) ?: '';
        //print_r($price_match_title); exit;
        $price_match_content = get_post_meta($post_id, 'price_match_guarantee', true);
        if(!$price_match_content){
            $price_match_post = get_post_meta($post_id,'price_match_post',true);
            $price_match_content = ($price_match_post->post_content)?:'';
        }
        $why_book_this_trip_title = get_post_meta($post_id, 'why_book_title', true) ?: 0;
        $why_book_this_trip_content = get_post_meta($post_id, 'why_book_this_trip', true) ?: 0;
        if (empty($price_match_title)||empty($why_book_this_trip_content)) {
            $class_full = 'col-md-12';
        }else{
            $class_full = 'col-md-6';
        }
        ?>
            <div class="et_pb_row why-book-this-tour">
                <div class="row et_pb_row">
                    <?php if ($price_match_title){?>
                    <div class="<?php echo $class_full ;?>">
                        <div class=" price-match-guarantee ">
                            <h2 ><span><?php echo $price_match_title?></span></h2>
                            <div class="text_gray">
                                <?php echo $price_match_content;?>
                            </div>
                        </div>
                    </div>
                   <?php }?>
                   <?php if ($why_book_this_trip_content){?>
                    <div class="<?php echo $class_full ;?>">
                        <div class=" price-match-guarantee ">
                            <h2><span><?php echo $why_book_this_trip_title?></span></h2>
                            <div class="text_gray">
                                <?php echo $why_book_this_trip_content;?>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        <!-- Tour information -->
        <div class="et_pb_row single-tour-infomation" id="tour_info">
             <h2><?php echo __('Tour','Mundo');?><span> <?php echo __('information','Mundo');?></span> </h2>
        </div>
       
        <?php 
        $tour_info = get_post_meta($post_id,'inclussion',true);

        $tab_header = '<div class="et_pb_row tab_title_tour_info tab_header">';
        foreach($tour_info as $key => $item){
            $active = ($key == 0)?'active':'';
            $tab_header .= '<span class="other_tour_tab_name '.$active.'" data-post="'.$post_id.'" data-title="'.$item['inclussion_title'].'">'.$item['inclussion_title'].'</span>';
        }
        $tab_header .= '</div>';
        
        //tab content
        $tab_content = '<div class="et_pb_row tab_content_tour_info">';
        foreach ($tour_info[0] as $key => $value){
            switch ($key){
                case 'inclussion_detail':
                    $tab_content .= $value?'<div class="tab_content"><div class="content-inclussion-detail">'.str_replace("<!--more-->","</div><div class='content-inclussion-detail'>",$value).'</div></div>':' ';
                    break;
                    
                case 'other_info':
                    $other_info = (get_the_excerpt($value))?:'';
                    $tab_content .= '<div class"tab_content">'.$other_info.'</div>';
                    // $tab_content .= $value?'<div class="tab_content"><div class="content-inclussion-detail">'.str_replace("<!--more-->","</div><div class='content-inclussion-detail'>",$other_info).'</div></div>':' ';
                    break;
                case 'restaurants_in_tour':
                case 'hotels_in_tour':
                    $content = '<div class="tab_content tab_hotels_in_tour">';
                    foreach($value as $post_id){
                        $thumbnail_id = get_post_thumbnail_id($post_id);
                        $src = mundo_get_attachment_image_src($thumbnail_id, 'tour_another')?:'';                   
                        $title = (get_the_title($post_id))?:'';                            
                        $excerpt= (get_the_excerpt($post_id))?:'';
                        $location = get_post_meta($post_id,'location',true);
                        $terms_des = wp_get_post_terms( $post_id, 'category-destination', array() );
                        $location = $terms_des[0]->name;
                        $hotel_styles = wp_get_post_terms( $post_id, 'hotel_style', array() );
                        $content .= '<div class="row hotels_in_tour">';
                        $content .= '<div class="col-md-4 col-sm-4">';
                        $content .= '<a href="'.get_the_permalink($post_id).'">';
                        $content .= ' <div class="et_pb_slide_image2"><img src="'.$src.'" alt=""></div>   ';  
                        $content .= '</a>'   ;  
                        $content .= '</div>';
                        $content .= '<div class="col-md-8 col-sm-8">';
                            $content .= '<a href="'.get_the_permalink($post_id).'">';
                            $content .= '<b>'.$title.'</b><br>';
                            $content .= ' <span class="location">'.$location.'a</span>   ';
                            $content .= ' <span class="style">'.$hotel_styles[0]->name.'b</span>   ';
                            $content .= '<p>'.$excerpt.'</p>';
                        $content .= '</a></div>';
                        $content .= '</div>';
                    }
                    $tab_content .= $content.'</div>';
                    
                    break;
                default:
                    break;
                
            }
        }
        $tab_content .= '</div>';
        $tab_content .= '</div>';
        echo $tab_header;
        echo $tab_content;

        echo '<div class="information-pdf">'.mundo_get_infomation_tour_pdf($post_id).'</div>';
        $other_tours = get_post_meta($post->ID,'explore_another_tour',false);
        //print_r($other_tours);
        if ($other_tours) {
        ?>

        <!-- OTHER TOUR -->
        <div class="exploretour">
        <div class="et_pb_row">
             <h2 class="title-page"><span><?php echo __('More ','Mundo');?></span> <?php echo __('inspiration','Mundo');?></h2>
        </div>
        <?php
        
 
        $html = '<div class=" et_pb_row"><div class="row ">';
        foreach($other_tours as $post){
            //$thubnail = (get_the_post_thumbnail_url($post, 'post-thumbnail'))?:'';
            $thumbnail_id = get_post_thumbnail_id($post);
            $thubnail = mundo_get_attachment_image_src($thumbnail_id, 'tour_another')?:'';
            $link = (get_the_permalink($post))?:'';
            $title = (get_the_title($post))?:''; 
            $experts = (get_the_excerpt($post))?:'';
            $label_tour = (wp_get_post_terms($post, 'label_tour'))?:array();
            
                
                        $days = 0; 
                        $itinerary = (get_post_meta($post, 'itinerary',true))?:array();            
                        if($itinerary){
                            $days = count($itinerary);
                            if($days>0){
                                $day_html = ($days==1)?$days.' Day / 0 Night': $days. ' Days / '.($days-1).' Nights';
                            }
                        }
                        $departure_dates = (get_post_meta($post, 'departure_date',true))?:array();
                        $departure_date_text = '';
                        $i = 1;
                        if($departure_dates){
                            foreach($departure_dates as $departure_date){
                            if($i>3){
                                continue;
                            }
                            $departure_date = date_create($departure_date);
                            $departure_date =   date_format($departure_date, 'd M');
                            if($i == 3){
                                $departure_date_text .= $departure_date.' ... ';
                            }else{
                                $departure_date_text .= $departure_date.' / ';
                            }
                            
                            $i += 1;
                        }
                        }
                       
            $html .= '<div class="col-md-4 col-sm-6 et_pb_posts">
                        <article id="post-'.$post.'" class="et_pb_post clearfix post-'.$post.' post type-post status-publish format-standard has-post-thumbnail hentry category-uncategorized">
                            
                                <div class="post-thumbnail"><a href="'.$link.'" class="entry-featured-image-url">
                                    <img src="'.$thubnail.'" alt="'.$title.'" width="1080" height="675">
                                </a>';
                                if ($label_tour) {
                                        $html .= '<div class="label_tour">'.$label_tour[0]->name.' </div>';
                                    }
                                $html .= '<div class="days"><b>'.$day_html.'</b> </div>';

                            $html .=     '</div><div class="post_content">
                                <h2 class="entry-title content"><a href="'.$link.'">'.$title.'</a></h2><p>'.$experts.'</p>';
            $highlight_city = get_post_meta($post, '', true);
            
                        //$html .= '<div class="departure_date content"><b> Departures date: '.$departure_date_text.'</b> </div>';
                        $terms = wp_get_post_terms($post,'travel_style'); 
                        if($terms){
                            $list_category = '';
                            foreach($terms as $term){
                                $list_category .= $term->name .'    ';
                            }
                        }
                        $html .= '<div class="category_tour"><b>'.$list_category.'</b> </div>';
                        
                        
                        $route = (get_post_meta($post, 'route', true))?:'';
                        $html .= '<div class="route content"><b class="text_gray">'.str_replace(',', '/', $route).'</b> </div>';

                        $highlight_city = (get_post_meta($post, 'highlight_city', true))?:'';
                        $html .= '<div class="highlight_city content"><b>Highlight city:  </b><b class="text_gray">'.$highlight_city.' </b></div><div class="clear-both"></div>';
                        $price = get_post_meta($post, 'price_from',true);
                        $symbol_exchange = '$';
                        if (isset($_COOKIE['exchange_rate'])){
                            $exchange_rate_string = $_COOKIE['exchange_rate'];
                            $exchange_rate_cookie = explode("-",$exchange_rate_string); 
                            $price = $price * $exchange_rate_cookie[2];
                            $symbol_exchange = $exchange_rate_cookie[1];
                        }
                    $html .= '</div>';
                    $html .= '<hr> <div class="row content exploretour-bot"> <div class = "col-lg-7 col-md-6"><span class="text_gray">From:</span> <b class="price"> '.$symbol_exchange.$price.' </b><span class="text_gray price_sub"> pp</span></div>';
       $html .= '
                <div class="col-lg-5 col-md-6 view-tour"><a href="'.$link.'" class="more-link ">View tour</a></div>

       </div></article></div>';
           
        }
        $html .='</div></div></div>';
        echo $html;
        }//end nếu ko có dữ liệu Explore
       // // OTHER TOUR
//        echo do_shortcode('[et_pb_section bb_built="1" fullwidth="off" specialty="off"][et_pb_row][et_pb_column type="4_4"][et_pb_post_slider_with_js admin_label="Departure month" show_more="on" show_comments="off" module_id="other_tours" post_type="post" title_before_image="off" owl_items="3" owl_margin="20" _builder_version="3.0.106" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2" show_content="off" show_thumbnail="on" show_author="off" show_date="off" show_categories="on" show_pagination="off" fullwidth="on" use_overlay="off" background_layout="light" module_class="tour_travel_style"]
//
//&nbsp;
//
//[/et_pb_post_slider_with_js][/et_pb_column][/et_pb_row][/et_pb_section]'); 
        $current_lang = pll_current_language();
       // switch ($current_lang) {
       //              case 'en':
       //                  $link = get_permalink(get_page_by_path('make-enquiry'));
       //                  $link_join = get_permalink(get_page_by_path('subcribe'));
       //                  break;
       //              case 'es':
       //                  $link = get_permalink(get_page_by_path('hacer-reserva'));
       //                  $link_join = get_permalink(get_page_by_path('hacer-reserva'));
       //                  break;
       //              case 'pt':
       //                  $link = get_permalink(get_page_by_path('solicite-aqui'));
       //                  $link_join = get_permalink(get_page_by_path('make-enquiry'));
       //                  break;
       //              default:
       //                  $link = get_permalink(get_page_by_path('make-enquiry'));
       //                  $link_join = get_permalink(get_page_by_path('subscribe-pt'));
       //                  break;
       //          }
            
        // echo do_shortcode('[et_pb_section bb_built="1" _builder_version="3.0.106" prev_background_color="#ffffff" next_background_color="#ffffff" background_color="#ffffff" module_class="what_ever_you_want what-ever-single-tour"][et_pb_row _builder_version="3.0.106" background_size="initial" background_position="top_left" background_repeat="repeat" module_class="whatever-text"][et_pb_column type="4_4"][et_pb_text_fullwidth admin_label="What ever you want" _builder_version="3.0.106" header_line_height_tablet="2" background_layout="light" custom_padding="20px|||"]
        //     '.ot_get_option('what_ever_main_title').'
        //     <p style="text-align: center;"><span style="color: #696969;">'.ot_get_option('what_ever_sub_title').'</span></p>
        //     [/et_pb_text_fullwidth][/et_pb_column][/et_pb_row][et_pb_row _builder_version="3.0.106" background_size="initial" background_position="top_left" background_repeat="repeat" module_class="whatever-contact"][et_pb_column type="1_3"][et_pb_text admin_label="sdt" _builder_version="3.0.106" background_layout="light" module_class="what-ever-or"]
        //     <a href="tel:'.strip_tags(ot_get_option('what_ever_phone')).'" class="phone-mundo">
        //     <h4>'.ot_get_option('what_ever_phone').'</h4></a>

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
        </div> <!-- .entry-content -->

    </article> <!-- .et_pb_post -->

<?php endwhile; ?>
</div> <!-- #main-content -->
<!-- <div class="footer-pdf">
    <h4><?php echo __('Mundo Asia','mundo');?></h4>
    <?php 
        $ft_pdfs = ot_get_option('footer_pdf');
        $ft_pdf = explode('-',$ft_pdfs);
        foreach ($ft_pdf as $key => $value) {
            echo '<span class="item-ft-pdf">'.$value.'</span>';
        }
    ?>
</div> -->
<?php

get_footer();
