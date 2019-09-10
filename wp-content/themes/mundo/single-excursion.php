<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
get_header();

$show_default_title = get_post_meta( get_the_ID(), '_et_pb_show_title', true );

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );
//exit();
?>

<div id="main-content">
	
	<div id="content-area" class="clearfix">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php if (et_get_option('divi_integration_single_top') <> '' && et_get_option('divi_integrate_singletop_enable') == 'on') echo(et_get_option('divi_integration_single_top')); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>
				<div class="entry-content content-single-excursion">
					 <?php
    $post_id = get_the_ID();
    $img_banner = get_post_meta($post_id,'image_banner',false);
    $terms = wp_get_post_terms($post_id,'category-destination'); 
                    if($terms){
                        $list_category = '';
                        foreach($terms as $term){
                            $list_category = $term->name;
                            $desti_name = $term->name;
                            $desti_name_main = $term->name;
                            if ($term->parent != 0) {
 
                                $parent_terms = get_terms(
                                    array(
                                        'taxonomy' => 'category-destination',
                                        'include' => array($term->parent),
                                    )
                                );

                                foreach ($parent_terms as $key_par => $value_par) {
                                     $desti_name .= ' '.$value_par->name;

                                }
                            }
                        }
                    }
    $img_shortcode = ' ';
    if($img_banner){
        $image_count = 0;
        foreach ($img_banner as  $att_id) {
            if ($image_count==0) {
                $url_image_pdf = wp_get_attachment_url($att_id);
            }
            $url_image = wp_get_attachment_url($att_id);
            //$bread ='<a href="'.'#'.'">'.$list_category.' / '.$post->post_title;
            $bread = $post->post_title;
            $img_shortcode .= '[et_pb_slide _builder_version="3.0.106" heading="'.$post->post_title.'" use_background_color_gradient="off"  background_image="'.$url_image.'" parallax="off" ]<a href="'.home_url().'">'.__('Home','Mundo').'</a> /  '.__('Excursion','Mundo').' / '.$bread.' [/et_pb_slide]';
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
                    <a class="nav-item nav-link active" scroll-to ="excursion-highlight" ><?php echo esc_html__('Highlights', 'Mundo');?></a>
                    <a class="nav-item nav-link" scroll-to ="excursion-infomation" ><?php echo esc_html__('Excursion information', 'Mundo');?></a>
                    <a class="nav-item nav-link" scroll-to ="excurson-review" ><?php echo esc_html__('Reviews', 'Mundo');?></a>

                </div>
                <div class="btn-nav col-md-6">
                    <?php 
                    
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
                                <li class="et-social-icon et-social-whatsapp" >
                                    <a href="<?php echo $link_share_print;?>" target="blank">
                                        <i class="fa fa-pinterest" ></i>
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
                    <a href="" class="save-tour-head"><img src="<?php echo $home_url;?>./wp-content/themes/mundo/icon/salecolor.png"> <?php echo ot_get_option('save_tour');?></a>
                    <?php 
                        $current_lang = pll_current_language();
                        $type = get_post_meta($post->ID,'select_type',true);
                        switch ($current_lang) {
                                case 'en':
                                    $link = 'en';
                                    break;
                                case 'es':
                                    $link = 'es';
                                    break;
                                case 'pt':
                                   $link = 'pt';
                                    break;
   
                            }
                    ?>
                    <a href="<?php echo $link;?>" class="make-enquire"><?php echo __('CHECK AVAILABILITY','Mundo');?> </a>
                </div>
            </div>
        </div>
    </nav>
    			<div class="container">
                    <div class="single-excursion-overview">
                        <div class="overview">
                            <?php echo get_post_meta($post_id,'over_view',true);?>
                        </div>
                        <div class="single-excursion-highlight" id="excursion-highlight">
                            <div class="highlight-head"><?php echo __('Highlights','Mundo');?></div>
                            <div class="single-excursion-list-highlight row">
                                <?php 
                                    $highlights = get_post_meta($post_id,'group_excursion_highlight',true);
                                    if ($highlights) {
                                        $highlights_2 = array_chunk($highlights,2);
                                        echo '<div class="col-md-6">';
                                            foreach($highlights_2 as $key=>$item) {  
                                               if (!empty($item[0]['highlight'])) {
                                                    $title_highlight = $item[0]['highlight'] ;
                                                   echo '<p>'.$title_highlight.'</p>';
                                               }
                                            }
                                            echo '</div>';
                                            echo '<div class="col-md-6">';
                                            foreach($highlights_2 as $key=>$item) {                                               
                                               if (!empty($item[1]['highlight'])) {
                                                    $title_highlight = $item[1]['highlight'] ;
                                                   echo '<p>'.$title_highlight.'</p>';
                                               }
                                            }
                                        echo '</div>';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="single-excursion-about">
                            <div class="highlight-head"><?php echo __('About this trip','Mundo');?></div>
                            <div class="single-list-excursion-about">
                                <?php 
                                $home_url =  $current_lang=='en'?home_url():substr( esc_url( home_url( '/' ) ),0,-3);
                                $from_rate = get_post_meta($post_id,'from_rate',true);
                                    if ($from_rate) {?>
                                    <span><img src="<?php echo $home_url ?>/wp-content/themes/mundo/icon/Excursion-location.png"><?php echo __('From','Mundo').' '.$from_rate;?></span>
                                <?php } ?>
                                
                                <?php 
                                $pick_up_point_group = get_post_meta($post_id,'pick_up_point_group',true);
                                $pick_up_point_private = get_post_meta($post_id,'pick_up_point_private',true);
                                if ($pick_up_point_group||$pick_up_point_private) {?>
                                    <span class="pick-up-point"><img src="<?php echo $home_url ?>/wp-content/themes/mundo/icon/sports-car.png"><?php echo ot_get_option('pick_up_point');?></span>
                                <?php } ?>
                                
                                <?php 
                                    if (get_post_meta($post_id,'time_trip',true)) {?>
                                    <span><img src="<?php echo $home_url ?>/wp-content/themes/mundo/icon/hourglass.png"><?php echo get_post_meta($post_id,'time_trip',true);?></span>
                                <?php } ?>
                                
                            </div>
                        </div>
                    </div>
                    <div class="gallery-excursion">
                        <div class="clear-both"></div>
                        <?php echo do_shortcode('[et_pb_text_gallery_image _builder_version="3.0.106" module_id="excursion_gallrey"/]');?>
                        <div class="clear-both"></div>
                        
                    </div>
                    <div class="excursion-detail-rate">
                        <?php echo do_shortcode('[excursion_price_box]');?>
                    </div>
    				
                    
    			</div> <!-- container 1 -->
				<div class="single-excursion-infomation information-toggle-tabs single-toggle-mundo" id="excursion-infomation">
                    <div class="container">
                        <h2 class="title-head"><?php echo __('<span>Excursion</span> information','Mundo');?></h2>
                        
                        <?php 
                            $itinerary = apply_filters('the_content',get_post_meta($post_id,'itinerary',true) );
                            $title = __('Itinerary','Mundo');
                            echo do_shortcode('[et_pb_toggle _builder_version="3.0.106" title="'.$title.'" off]'.$itinerary.'[/et_pb_toggle]');

                            $inclusions_exclusions_group = apply_filters('the_content',get_post_meta($post_id,'inclusions_exclusions_group',true) );
                            $title = __('Inclusions & Exclusions','Mundo');
                            echo do_shortcode('[et_pb_toggle _builder_version="3.0.106" title="'.$title.'" off module_class="show_group_rate"]'.$inclusions_exclusions_group.'[/et_pb_toggle]');

                            $inclusions_exclusions_private = apply_filters('the_content',get_post_meta($post_id,'inclusions_exclusions_private',true) );
                            $title = __('Inclusions & Exclusions','Mundo');
                            echo do_shortcode('[et_pb_toggle _builder_version="3.0.106" title="'.$title.'" off module_class="show_private_rate"]'.$inclusions_exclusions_private.'[/et_pb_toggle]');

                            $how_to_book_pay = apply_filters('the_content',get_post_meta($post_id,'how_to_book_pay',true) );
                            $title = __('How to book & pay','Mundo');
                            echo do_shortcode('[et_pb_toggle _builder_version="3.0.106" title="'.$title.'" off]'.$how_to_book_pay.'[/et_pb_toggle]');

                            $cancellation_policy = apply_filters('the_content',get_post_meta($post_id,'cancellation_policy',true) );
                            $title = __('Cancellation policy','Mundo');
                            echo do_shortcode('[et_pb_toggle _builder_version="3.0.106" title="'.$title.'" off]'.$cancellation_policy.'[/et_pb_toggle]');

                            $tips_advice = apply_filters('the_content',get_post_meta($post_id,'tips_advice',true) );
                            $title = __('Tips and advice','Mundo');
                            if (!empty($tips_advice)) {
                                echo do_shortcode('[et_pb_toggle _builder_version="3.0.106" title="'.$title.'" off]'.$tips_advice.'[/et_pb_toggle]');
                            }
                            
                        ?>
                    </div>
                </div>	

                <div class="container">
                    <div class="reviews-excusrion-single" id="excurson-review">

                            <div class="row et_pb_row">
                                <div class="col-md-3 review-main-text">
                                    <h2><?php echo __('Reviews','Mundo');?></h2>
                                </div>
                                <?php 
                                        $all_group_reviews = get_post_meta($post_id,'reviews_group',true);
                                        if ($all_group_reviews) {
                                            $my_class = 'display_block_excursion';
                                        }else{
                                            $my_class = 'display_none_excursion';
                                        }

                                ?>
                                <div class="col-md-9">
                                	<div class="show_group_rate <?php echo $my_class; ?> " >
                                		<?php 
                                    		$all_group_reviews = get_post_meta($post_id,'reviews_group',true);
                                            if (!empty($all_group_reviews)) {
 
                                            
                                    		foreach ($all_group_reviews as $key => $value) {
                                    			$class_review = ' ';
                                    			if ($key >= 2) {
                                    				$class_review = 'review-none';
                                    			} ?>
                                    			<div class="content-reviews <?php echo $class_review;?>">
                                                    <div class="row">
                                                        <div class="col-md-3 review-avatar">
                                                            <?php 
                                                            if (!empty($value['avatar'])) {
                                                                $src = mundo_get_attachment_image_src($value['avatar'], 'post_expert_blog');
                                                            }
                                                                
                                                            ?>
                                                            <img src="<?php echo $src;?>">
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="single-star-excursion">
                                                                <?php 
                                                                    $value['star_rate'] = !empty($value['star_rate'])?:0;
                                                                    for ($i=1; $i <= 5 ; $i++) { 
                                                                        if($i <= $value['star_rate'] ){
                                                                            echo '<span aria-hidden="true" class="icon_star icon_star_all"></span>';
                                                                        }else{
                                                                            echo '<span aria-hidden="true" class="icon_star_none icon_star_all"></span>';
                                                                        }
                                                                        
                                                                    }
                                                                ?>
                                                            </div>
                                                            <div class="single-head-reviews">
                                                                <span class="title-review-ex"><?php echo !empty($value['title'])?$value['title']:''; ?></span>
                                                                <span class="day-review-ex"><?php echo !empty($value['day'])?$value['day']:''; ?></span>
                                                            </div>
                                                            <div class="content-reviews-ex">
                                                                <?php 
                                                                    echo apply_filters('the_content',$value['content']);
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                    	<?php 	}
                                        }
                                        if ($all_group_reviews) {
                                            $class = 'display_none_excursion';
                                        }else{
                                            $class = 'display_block_excursion';
                                        }
                                    	?>
                                    	<div class="wrapper-show-more-review"><a class="show-more-review-excursion" data-number-record="2"><?php echo __('Show more','Mundo');?> </a></div>
                                        <div class="clear-both"></div>
                                	</div>
                                	<div class="show_private_rate <?php echo $class;?>">
                                		<?php 
                                    		$all_group_reviews = get_post_meta($post_id,'reviews_private',true);
                                    		foreach ($all_group_reviews as $key => $value) {
                                    			$class_review = ' ';
                                    			if ($key >= 2) {
                                    				$class_review = 'review-none-private';
                                    			} ?>
                                                    <div class="content-reviews <?php echo $class_review;?>">
                                                        <div class="row">
                                                            <div class="col-md-3 review-avatar">
                                                                <?php 
                                                                    $src = mundo_get_attachment_image_src($value['avatar'], 'post_expert_blog');
                                                                ?>
                                                                <img src="<?php echo $src;?>">
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="single-star-excursion">
                                                                    <?php 
                                                                        for ($i=1; $i <= 5 ; $i++) { 
                                                                            if($i <= $value['star_rate'] ){
                                                                                echo '<span aria-hidden="true" class="icon_star icon_star_all"></span>';
                                                                            }else{
                                                                                echo '<span aria-hidden="true" class="icon_star_none icon_star_all"></span>';
                                                                            }
                                                                            
                                                                        }
                                                                    ?>
                                                                </div>
                                                                <div class="single-head-reviews">
                                                                    <span class="title-review-ex"><?php echo $value['title']; ?></span>
                                                                    <span class="day-review-ex"><?php echo $value['day']; ?></span>
                                                                </div>
                                                                <div class="content-reviews-ex">
                                                                    <?php 
                                                                        echo apply_filters('the_content',$value['content']);
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                    	<?php	}
                                    	?>
                                    	<div class="wrapper-show-more-review"><a class="show-more-review-excursion-private" data-number-record="2"><?php echo __('Show more','Mundo');?> </a></div>
                                        <div class="clear-both"></div>
                                	</div>
                                    
                                </div>
                            </div>

                    </div> <!-- end review -->
                    <?php 
                        $excursion_relate = get_post_meta($post_id,'excursion_relate',true);
                        if (!empty($excursion_relate)) {
                    ?>
                    <div class="relate-excursion-single">
                        <h2 class="head-title"><?php echo __('Recommended Excursions','Mundo');?> <?php //echo __('from').' '.$desti_name_main;?></h2>
                        <?php 
                            echo do_shortcode('[et_pb_post_owlcarousel admin_label="Slide excursion relate" _builder_version="3.0.106" posts_number="-1" show_content="on" post_type="excursion" display_content="on" show_thumbnail="off" show_more="off" show_author="off" show_date="off" show_categories="off" show_comments="off" show_pagination="off" title_before_image="off" fullwidth="on" use_overlay="off" background_layout="light" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2" module_id="excursion_relate" /]');
                        ?>
                    </div>
                    <?php } ?>
                    <div class="relate-expert-single">
                        <h2 class="head-title"><span><?php echo __('Meet our','Mundo');?></span> <?php echo __('experts','Mundo');?></h2>
                        <?php 
                            echo do_shortcode('[et_pb_post_owlcarousel admin_label="Slide expert relate" _builder_version="3.0.106" posts_number="-1" show_content="on" post_type="expert" display_content="on" show_thumbnail="on" show_more="off" show_author="off" show_date="off" show_categories="off" show_comments="off" show_pagination="off" title_before_image="off" fullwidth="on" use_overlay="off" background_layout="light" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2" module_id="excursion_expert_relate" /]');
                        ?>
                    </div>
                    
                </div> <!-- container 2 -->

                <div id="get_in_touch_excursion">
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

				</div> <!-- .entry-content -->
				
			</article> <!-- .et_pb_post -->

		<?php endwhile; ?>

	</div> <!-- #content-area -->


</div> <!-- #main-content -->

<?php

get_footer();
