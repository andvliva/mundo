<?php

get_header();
global $post;

?>

<div id="main-content single-travel-guide">

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
                    foreach ($img_banner as  $att_id) {
                        $url_image = wp_get_attachment_url($att_id);
                        $bread =$list_category.'/ Travel Guide';
                        $img_shortcode .= '[et_pb_slide _builder_version="3.0.106" heading="'.$post->post_title.'" use_background_color_gradient="off"  background_image="'.$url_image.'" parallax="off" ]Home/Destination/'.$bread.' [/et_pb_slide]';
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
                <?php
                //Phần body
                $content_over_view = get_post_meta($post_id,'over_view',true);
                echo '<div class="hotel-overview text_gray text-align-center" id="overvew-tour">'.$content_over_view.'</div>'?:'';
                $language_spoken = get_post_meta($post_id,'language_spoken',true);
                $currency = get_post_meta($post_id,'currency',true);
                $time_zones = get_post_meta($post_id,'time_zones',true);
                $weather = get_post_meta($post_id,'weather',true);
            $tabs ='[et_pb_section bb_built="1" fullwidth="off" specialty="off"  _builder_version="3.0.106" module_id="wrapper_tab_single" background_color="rgba(0,0,0,0)"  prev_background_color="#000000" next_background_color="#000000"][et_pb_row][et_pb_column type="4_4"]
            [et_pb_tabs _builder_version="3.0.106"  background_color="rgba(224,224,224,0)" border_width_all="0px" module_class="tab-travel-guide "]';
            $tab_content = '<div class="row">';
            $tab_content .= '<div class="col-md-3 language_spoken"><img src="'.home_url('/wp-content/themes/mundo/icon/language_spoken.png').'"/><h6>'.__('Languages Spoken', 'Mundo').'</h6><p>'. $language_spoken.'</p></div>';
            $tab_content .= '<div class="col-md-3 language_spoken"><img src="'.home_url('/wp-content/themes/mundo/icon/currency.png').'"/><h6>'.__('Currency', 'Mundo').'</h6><p>'.$currency.'</p></div>';
            $tab_content .= '<div class="col-md-3 language_spoken"><img src="'.home_url('/wp-content/themes/mundo/icon/time_zones.png').'"/><h6>'.__('Time Zones', 'Mundo').'</h6><p>'. $time_zones.'</p></div>';
            $tab_content .= '<div class="col-md-3 language_spoken"><img src="'.home_url('/wp-content/themes/mundo/icon/weather.png').'"/><h6>'.__('Weather', 'Mundo').'</h6><p>'. $weather.'</p></div>';
            $tab_content .= '</div>';
            $tabs_detail[] = '[et_pb_tab _builder_version="3.0.106" title="Vietnam Fast Fatcs" use_background_color_gradient="off" background_color_gradient_start="#2b87da" background_color_gradient_end="#29c4a9" background_color_gradient_type="linear" background_color_gradient_direction="180deg" background_color_gradient_direction_radial="center" background_color_gradient_start_position="0%" background_color_gradient_end_position="100%" background_color_gradient_overlays_image="off" parallax="off" parallax_method="on" background_size="cover" background_position="center" background_repeat="no-repeat" background_blend="normal" allow_player_pause="off" background_video_pause_outside_viewport="on" tab_text_shadow_style="none" body_text_shadow_style="none" tab_text_shadow_horizontal_length="0em" tab_text_shadow_vertical_length="0em" tab_text_shadow_blur_strength="0em" body_text_shadow_horizontal_length="0em" body_text_shadow_vertical_length="0em" body_text_shadow_blur_strength="0em"]'. $tab_content.'[/et_pb_tab]';

            $tabs_detail[] = '[et_pb_tab _builder_version="3.0.106" title="Vietnam Travel Costs" use_background_color_gradient="off" background_color_gradient_start="#2b87da" background_color_gradient_end="#29c4a9" background_color_gradient_type="linear" background_color_gradient_direction="180deg" background_color_gradient_direction_radial="center" background_color_gradient_start_position="0%" background_color_gradient_end_position="100%" background_color_gradient_overlays_image="off" parallax="off" parallax_method="on" background_size="cover" background_position="center" background_repeat="no-repeat" background_blend="normal" allow_player_pause="off" background_video_pause_outside_viewport="on" tab_text_shadow_style="none" body_text_shadow_style="none" tab_text_shadow_horizontal_length="0em" tab_text_shadow_vertical_length="0em" tab_text_shadow_blur_strength="0em" body_text_shadow_horizontal_length="0em" body_text_shadow_vertical_length="0em" body_text_shadow_blur_strength="0em"][/et_pb_tab]';
            $tabs .= implode(" ",$tabs_detail);
            $tabs .= '[/et_pb_tabs][/et_pb_column][/et_pb_row][/et_pb_section]';
            echo do_shortcode($tabs);
            //End tabs
            ?>
            <div id="city">
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
                <h2 class="title-overview container city-of"><?php echo __('Best','Mundo');?> <span> <?php echo __('Destination Of','Mundo');?> <?php echo  $post->post_title;?> </span></h2>
                <?php 
                    echo do_shortcode('[et_pb_section bb_built="1" fullwidth="off" specialty="off" prev_background_color="#000000" next_background_color="#000000"][et_pb_row][et_pb_column type="4_4"][et_pb_post_owlcarousel _builder_version="3.0.106" show_content="off" post_type="post" show_thumbnail="on" show_more="off" show_author="off" show_date="off" show_categories="off" show_comments="off" show_pagination="off" title_before_image="off" fullwidth="on" use_overlay="off" owl_nav="on" owl_items="6" owl_margin="30"  background_layout="light" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2" module_id="city_of_vietnam" /][/et_pb_column][/et_pb_row][/et_pb_section]');
                }
                ?>
            </div>
            <div class="travel-guide-description ">
                <div class="discover et_pb_row">
                    <input type="hidden" name="post_id" class="post_id" value="<?php echo $post->ID;?>" >
                    <h2 class="title-overview container city-of">Discover <span> <?php echo  $post->post_title;?> </span></h2>
                    <div class="travel-guide-tour">
                        <?php 
                            echo do_shortcode('[et_pb_post_slider_with_js admin_label="Departure month" show_more="on" show_comments="off" module_id="travel_guide_tour" post_type="post" title_before_image="off" owl_items="3" owl_margin="20" _builder_version="3.0.106" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2" show_content="off" show_thumbnail="on" show_author="off" show_date="off" show_categories="on" show_pagination="off" fullwidth="on" use_overlay="off" background_layout="light" display_content="on"]');
                        ?>
                    </div>
                    <?php 
                        $args = array(
                            'marker'       => false,
                        );
                        $maps = rwmb_meta( 'map',$args, $post_id );
                        echo '<div id="map-travel">'.$maps.'</div>';
                    ?>
                </div>
                <div class="vietnam-travel-infomation">
                    <h2 class="title-overview city-of">Time <span> to Visit </span> </h2>
                    <?php 
                        $content_info = get_post_meta($post_id,'description_time_to_visit',true);
                        echo $content_info;
                        $content_info = get_post_meta($post_id,'travel-guide-time-to-visit',true);
                    ?>
                    <div class="row">
                    	   <div class="col-md-5 month head-travel"></div>
                           <div class="col-md-2 popularity head-travel">Popularity</div>
                           <div class="col-md-2 high-low head-travel">High/Low</div>
                           <div class="col-md-2 col-md-offset-1 precip head-travel">Precip</div>
                        <?php 
                            foreach ($content_info as $key => $value) {
                                echo '<div class="col-md-5 month">'.$value['month'].'</div>';
                                echo '<div class="col-md-2 popularity">';
                                	for ($i=1; $i <= 5 ; $i++) { 
                                		if ( $i <= $value['popularity'] ) {
                                			//echo '<i class="fa fa-male icon-black"></i>';
                                            echo '<img src="'.home_url().'/wp-content/themes/mundo/icon/male_black.png">';
                                		}else{
                                			//echo '<i class="fa fa-male icon-gray"></i>';
                                            echo '<img src="'.home_url().'/wp-content/themes/mundo/icon/male_gray.png">';
                                		}
                                		
                                	}
                                echo '</div>';
                                echo '<div class="col-md-2 high-low">'.$value['high-low'].'</div>';
                                echo '<div class="col-md-2 col-md-offset-1 precip">'.$value['precip'].'</div>';
                            }
                        ?>
                        	<div class="col-md-5 month travel-bot ">All month</div>
                            <div class="col-md-2 popularity travel-bot head-travel"></div>
                            <div class="col-md-2 high-low travel-bot head-travel"></div>
                            <div class="col-md-2 col-md-offset-1 precip head-travel-icon travel-bot"><i class="fa fa-caret-up"></i></div>
                    </div>
                </div>
                <div class="travel-guide-expert">
                	<div class="et_pb_row">
	                	<h2 class="title-overview city-of"><span>Meet Our </span> Expert </h2>
	                	<?php 
	                		$experts = get_post_meta($post_id,'experts',false);
	                	?>
	                	<div class="row">
	                		<?php 
	                			foreach ($experts as $key => $value) {
	                				// d($value);
	                				$expert = get_post($value);
	                				$name_expert = $expert->post_title;
	                				$Specialize = get_post_meta($value,'Specialize',true);
	                				$Introduce = get_post_meta($value,'Introduce',true);
	                				// d($name_expert);
	                				$thumbnail_id = get_post_thumbnail_id($value);
						            if($thumbnail_id) {
						                $src = mundo_get_attachment_image_src($thumbnail_id, 'travel_guide_expert');
						                $image = sprintf('<img src="%s" alt="%s" />', $src, $value->post_title);
						            }
	                				?>
	                				<div class="col-md-6 row">
	                					<div class="col-md-4 travel-guide-expert-image">
	                					<?php echo $image;?>
	                					</div>
	                					<div class="col-md-8 travel-guide-expert-info">
	                						<?php 
	                							echo '<h5>'.$name_expert.'</h5>';
	                							echo '<h6>'.$Specialize.'</h6>';
	                							echo '<p>'.$Introduce.'</p>';
	                						?>
	                						<a href="#">Make an Enquiry</a>
	                					</div>
	                				</div>
	                			<?php } ?>
	                	</div>
	                </div>
                </div>
                <div class="travel-guide-infomation">
                	<div class="et_pb_row single-tour-infomation" id="tour_info">
			             <h2><span><?php echo $post->post_title; ?></span> <?php echo __("Travel nfomation","Mundo");?></h2>
			        </div>
			       
			        <?php 
			        $tour_info = get_post_meta($post_id,'travel-guide-travel-infomation-gr',true);
			        $tab_header = '<div class="et_pb_row tab_title_tour_info tab_header">';
			        foreach($tour_info as $key => $item){
			            $active = ($key == 0)?'active':'';
			            $tab_header .= '<span class="other_travel_guide_tab_name '.$active.'" data-post="'.$post_id.'" data-title="'.$item['title_travel_info'].'">'.$item['title_travel_info'].' </span>';
			        }
			        $tab_header .= '</div>';
			        
			        //tab content
			        $tab_content = '<div class="et_pb_row tab_content_tour_info">';
			        foreach ($tour_info[0] as $key => $value){
			            switch ($key){
			                case 'description':
			                    $tab_content .= $value?'<div class="clear-both"></div><div class="tab_content et_pb_row">'.$value.'</div>':' ';
			                    break;
			                case 'hotel-in-travel':
			                    $content = '<div class"tab_content">';
			                    foreach($value as $post_id_ht){
                                    $thumbnail_id = get_post_thumbnail_id($post_id_ht);
                                        $src = mundo_get_attachment_image_src($thumbnail_id, 'hotel_another')?:'';                   
                                        $title = (get_the_title($post_id_ht))?:''; 
                                        $location = wp_get_post_terms( $post_id_ht, 'category-destination', array() );
                                        $hotel_styles = wp_get_post_terms( $post_id_ht, 'hotel_style', array() );
                                        $content .= '<article id="'.$post_id_ht.'" class="et_pb_post hotel-div-3 clearfix post-'.$post_id_ht.' post type-post status-publish format-standard has-post-thumbnail hentry category-uncategorized">';
                                        $content .= '<div class="et_pb_image_container">    ';
                                        $content .= '<a href="'.get_the_permalink($post_id_ht).'" class="entry-featured-image-url">';
                                        $content .= '<img src="'.$src.'" alt=""> ';  
                                        $content .= '</a>'   ;  
                                        $content .= '</div>';
                                        $content .= '<div class="content"><a href="'.get_the_permalink($post_id_ht).'">';
                                        $content .= '   <h2 class="entry-title"><b>'.$title.'</b></h2>';
                                        $content .= ' <span class="location">'.$location[0]->name.'</span>   ';
                                        $content .= ' <span class="style">'.$hotel_styles[0]->name.'</span>  <hr> ';
                                        $discount_price_html = '';
                                        $price = get_post_meta($post_id_ht, 'price_from',true);
                                        $content .= '<div class=""><b class="text_gray">From:  </b>'.$discount_price_html.' <b class="price'.$discount.' ">$'.$price.' </b> <b class=" '.$discount.' text_gray "> per room</b></div>';
                                        $content .= '</a></div>';
                                        $content .= '   </article>';
			                    }
			                    $tab_content .= $content;
			                    break;
			            } 
			        }
                    $tab_content .= '</div>';
			        $tab_content .= '</div>';
			        echo $tab_header;
			        echo $tab_content; ?>
                </div>
                
            </div>
            <div class="traveller-reviews">
                <div class="row et_pb_row">
                    <div class="col-md-3">
                        <h2 class="title-overview city-of"><?php echo __('Traveller','Mundo');?><br><span> <?php echo __('Reviews','Mundo');?> </span>  </h2>
                    </div>
                    <div class="col-md-9">
                        <?php echo do_shortcode('[et_pb_custom_post_show_more _builder_version="3.0.106" posts_number="2" show_content="off" show_more_posts="on" display_content="on" show_thumbnail="off" show_more="off" show_author="off" show_date="off" show_categories="off" show_comments="off" show_pagination="off" fullwidth="on" use_overlay="off" background_layout="light" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2" number_posts_more="2" module_id="excursion_reviews" module_class="traveller_reviews" /]');?>
                    </div>
                </div>
            </div>
            <div class="more-post-single-bolg travel-guide-blog">
                <?php 
                    echo do_shortcode('[et_pb_section bb_built="1" _builder_version="3.0.106" prev_background_color="#000000" module_class="travel-post-wrapper"][et_pb_row _builder_version="3.0.106" background_size="initial" background_position="top_left" background_repeat="repeat" module_class="travel-post"][et_pb_column type="4_4"][et_pb_text admin_label="Travel Ispirations" _builder_version="3.0.106" background_layout="light" module_class="travel-post-text" custom_padding="50px|||"]
                        <h2><strong><span style="color: #000;"><span style="color: #ac2430;">Do You</span></span></strong><strong><span style="color: #000;"><span style="color: #ac2430;"><span style="color: #000000;"><br>Need a Little More Inspiration?</span></span></span></strong></h2>
                        [/et_pb_text][et_pb_custom_post fullwidth="off" posts_number="3" show_author="off" show_date="off" show_categories="off" show_pagination="off" module_id="related_post" display_content="on" _builder_version="3.0.106" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2" show_content="off" show_thumbnail="on" show_more="on" show_comments="off" use_overlay="off" background_layout="light" more_text="Show More" module_class="travel-post-list"]

                        &nbsp;

                        [/et_pb_custom_post][/et_pb_column][/et_pb_row][/et_pb_section]');
                ?>
                <div class="clear-both"></div>
            </div>
            <div class="contact-travel">
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
                    //     [/et_pb_text_fullwidth][/et_pb_column][/et_pb_row][et_pb_row _builder_version="3.0.106" background_size="initial" background_position="top_left" background_repeat="repeat" module_class="whatever-contact with-call"][et_pb_column type="1_3"][et_pb_text admin_label="sdt" _builder_version="3.0.106" background_layout="light" module_class="what-ever-or"]

                    //     <span style="color: #9B9B9B; font-size: 18px">Call Mundo: </span><span style="color: #fff; font-size: 24px; font-weight: bold">'.ot_get_option('what_ever_phone').'</span>

                    //     [/et_pb_text][/et_pb_column][et_pb_column type="1_3"][et_pb_button button_text="'.ot_get_option('what_ever_button_1').'" _builder_version="3.0.106" url_new_window="off" background_layout="light" custom_button="off" button_icon_placement="right" module_class=" make-an-enquiry-contatct" button_url="'.$link.'"]

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
        
        </div> <!-- .entry-content -->

    </article> <!-- .et_pb_post -->

<?php endwhile; ?>

</div> <!-- #main-content -->

<?php

get_footer();
