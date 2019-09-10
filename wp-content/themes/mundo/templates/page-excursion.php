<div class="excursion-page"> 
<?php
$destination_category = get_query_var('excursion_place');
//print_r($destination_category);exit();
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
?>
<?php
$img_banner = get_post_meta($post_id,'image_banner_excursion',false);
$terms = wp_get_post_terms($post_id,'category-destination'); 
                if($terms){
                    $list_category = '';
                    foreach($terms as $term){
                        $list_category = $term->name;
                    }
                }
if($img_banner){
    foreach ($img_banner as  $att_id) {
        $url = wp_get_attachment_url($att_id);
        //echo 'ảnh ảnh';
         //print_r($url);//exit();
        //$img_shortcode .= '[et_pb_slide _builder_version="3.0.106"  background_image="'.$url.'" /]';
        $img_shortcode .= '[et_pb_slide _builder_version="3.0.106" heading="'.$name_excursion.' '.$post->post_title.'" use_background_color_gradient="off"  background_image="'.$url.'" parallax="off" ]<a href="'.home_url().'">'.__('Home','Mundo').'</a> /  '.$name_excursion.' '.__('Excursion','Mundo').'[/et_pb_slide]';
    }
}
//Phần header
$tab_mobile = '[et_pb_text_fullwidth admin_label="Mobile call" _builder_version="3.0.106" background_layout="light" header_line_height_tablet="2" module_class="wrapper-mobile-tab"]
                    [tab_mobile]
                    [/et_pb_text_fullwidth]';
    //echo do_shortcode('
        // [et_pb_section bb_built="1" fullwidth="on"]
        //     [et_pb_fullwidth_slider _builder_version="3.0.106" auto="on" auto_speed="300000" auto_ignore_hover="on" module_class=" banner_not_home " ]    
        //         '.$img_shortcode.'
        //     [/et_pb_fullwidth_slider]'.$tab_mobile .'
        // [/et_pb_section]');
?>
<div class="wrapper-ex_img_banner">
    <div class="ex_img_banner_text">
        <h2>
            <?php 
            $current_lang = pll_current_language();
            switch ($current_lang) {
                case 'en':
                    $name_excursion =__($name_excursion. ' Excursion','custom');
                    break;
                case 'es':
                    $name_excursion =__('Excursion','Mundo').' '.$name_excursion;
                    break;
                case 'pt':
                    $name_excursion = __('Excursion '.$name_excursion,'custom');
                    break;
                
            }
            echo $name_excursion;?>     
        </h2>
        <div>
            <?php echo '<a href="'.home_url().'">'.__('Home','Mundo').'</a> /  '.$name_excursion;?>
        </div>
    </div>
    <img src="<?php echo $url;?>" class="ex_img_banner show_on_desktop">
    <div class="show_on_mobile ex_background_banner" style="background: url(<?php echo $url;?>)"></div>
    <?php echo do_shortcode($tab_mobile);?>
</div>

<div id="main" class="clearfix   ">
    <div class="inner-wrap clearfix">
  <?php do_action( 'colormag_before_body_content' ); ?>
    <div id="content" class="clearfix destination-single">
        <div id="overvew" class="row container et_pb_row overview-excursion">
            <?php 
                $excursion_overview = get_post_meta($post_id,'over_view',true);
                echo apply_filters('the_content',$excursion_overview);
            ?>
        </div>

        <div class="list-all-excursion">  
            <div class="container content-list-all-excursion">
                <h2 class="head-excursion-page"><?php echo __('<span>Recommended</span> itineraries','Mundo');?> </h2>
                <?php 
                    echo do_shortcode('[et_pb_custom_excursion_show_more _builder_version="3.0.106" posts_number="9" show_content="off" show_more_posts="on" display_content="on" number_posts_more="9" show_thumbnail="on" show_more="off" show_author="off" show_date="off" show_categories="off" show_comments="off" show_pagination="on" fullwidth="on" use_overlay="off" background_layout="light" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2" module_id="excursions_list_page" /]');
                ?>
            </div>
        </div>

        <div id="city" class="highlight-place-excursion">
            <?php 
                $terms = wp_get_post_terms( $post_id, 'category-destination', array() );
                $terms_parent = get_terms( array(
                            'taxonomy' => 'category-destination',
                            'hide_empty' => false,
                            'parent' => 0,
                        ) );
                $terms_parent_id = wp_list_pluck($terms_parent,'term_id');
                //if(in_array($terms[0]->term_id, $terms_parent_id)){ //Nếu là đất nước thì chạy đoạn code này
                $terms_parent_2 = get_terms( array(
                            'taxonomy' => 'category-destination',
                            'hide_empty' => false,
                            'parent' => $terms[0]->term_id,
                        ) );  
                // print_r($terms_parent_2);exit();
                //if( $terms_parent_2 ){//Nếu nó có child thì mới chạy đoạn này
            ?>
            <h2 class="title-overview container city-of et_pb_row">
                <?php 
                $current_lang = pll_current_language();
                if($current_lang == 'en'){?>
                    <?php echo  $name_excursion;?> <span> <?php echo __(' highlights','Mundo') ?></span></h2>
                <?php } elseif($current_lang == 'es'){
                    echo ot_get_option('highlight_es');
                }else{ echo ot_get_option('highlight_pt'); }?>
            <?php 
                echo do_shortcode('[et_pb_section bb_built="1" fullwidth="off" specialty="off" prev_background_color="#000000" next_background_color="#000000"][et_pb_row][et_pb_column type="4_4"][et_pb_post_owlcarousel _builder_version="3.0.106" show_content="off" post_type="post" show_thumbnail="on" show_more="off" show_author="off" show_date="off" show_categories="off" show_comments="off" show_pagination="off" title_before_image="off" fullwidth="on" use_overlay="off" owl_nav="on" owl_items="6" owl_margin="30"  background_layout="light" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2" module_id="city_of_vietnam" /][/et_pb_column][/et_pb_row][/et_pb_section]');
            //}//end if term parent 2
            //}
            ?>
        </div>
        <?php 
            //$information = get_post_meta($post_id, 'excursion_travel_guide', true) ?: 0;
            $information = get_post_meta($post_id, 'information', true) ?: 0;
            //print_r($information);exit();
            if (!empty($information)) { 
        ?>
            <div id="information" class="container et_pb_row">
                <h2 class="head-excursion-page"><span><?php echo __('Travel', 'Mundo');?></span> <?php echo __('Guide', 'Mundo');?></h2>
                
                <div class="information-toggle-tabs single-toggle-mundo tab-travel-guide-ex">
                    <div class="row">
                    <?php 
                   // $information = get_post_meta($post_id, 'excursion_travel_guide', true) ?: 0;
                    $information = get_post_meta($post_id, 'information', true) ?: 0;
                    $information_2 = array_chunk($information,2);
                    
                    echo '<div class="col-md-6">';
                    foreach($information_2 as $key=>$item) {

                       $title = $item[0]['title_destination_info'] ;
                       $content = $item[0]['content_destination_info'] ; 
                       echo do_shortcode('[et_pb_toggle _builder_version="3.0.106" title="'.$title.'" off]
                                        '.$content.'
                                        [/et_pb_toggle]');
                    }
                    echo '</div>';
                    echo '<div class="col-md-6">';
                    foreach($information_2 as $key=>$item) {
                       $title = $item[1]['title_destination_info'] ;
                       $content = $item[1]['content_destination_info'] ; 
                       if ($content) {
                           echo do_shortcode('[et_pb_toggle _builder_version="3.0.106" title="'.$title.'" off]
                                        '.$content.'
                                        [/et_pb_toggle]');
                       }
                    }
                    echo '</div>';
                    ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="gallrey " id="gallrey">
            <div class="container et_pb_row">
                <h2 class="title-overview container et_pb_row gallery"><?php echo __('Gallery','Mundo') ?></h2>
                <div class="clear-both"></div>
                <?php echo do_shortcode('[et_pb_text_gallery_image _builder_version="3.0.106" module_id="destination_gallrey"/]');?>
                <div class="clear-both"></div>
            </div>
        </div>
        
        <div id="our_expert">
            <?php 
            $experts = get_post_meta($post_id,'experts',false);
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
            ?>
        </div>
       <?php 
            echo do_shortcode('[et_pb_section bb_built="1" _builder_version="3.0.106" prev_background_color="#bd1e2d" custom_padding="25px||25px|" border_width_bottom="1px" border_color_bottom="#eeeeee" module_class="excursion-doitac"][et_pb_row _builder_version="3.0.106" background_size="initial" background_position="top_left" background_repeat="repeat"][et_pb_column type="4_4"][et_pb_post_owlcarousel admin_label="doi_tac_slider" posts_number="-1" show_author="off" show_date="off" show_categories="off" show_pagination="off" module_id="doi_tac_slider" post_type="partner" title_before_image="off" owl_items="6" _builder_version="3.0.106" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2" show_content="on" show_thumbnail="on" show_more="off" show_comments="off" fullwidth="on" use_overlay="off" background_layout="light" display_content="off" /][/et_pb_column][/et_pb_row][/et_pb_section]');
       ?>
    </div><!-- #content -->
<?php do_action( 'colormag_after_body_content' ); ?>
</div>
</div>
</div>