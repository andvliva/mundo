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
 ?>
<?php get_header(); ?>
 <?php
        $current_lang = pll_current_language();
        switch ($current_lang) {
            case 'en':
                $about_link = get_permalink(get_page_by_path('about'));
                break;
            case 'es':
                $about_link = get_permalink(get_page_by_path('acerca-de-mundo-asia'));
                break;
            case 'pt':
                $about_link = get_permalink(get_page_by_path('sobre-nos'));
                break;
            default:
                # code...
                break;
        }
        $img_banner = get_post_meta($post_id,'blog_banner',false);
        if($img_banner){
            foreach ($img_banner as  $att_id) {
                $url = wp_get_attachment_url($att_id);
                //$img_shortcode .= '[et_pb_slide _builder_version="3.0.106"  background_image="'.$url.'" /]';
                $bread = $post->post_title;
                $img_shortcode .= '[et_pb_slide _builder_version="3.0.106" heading="'.$post->post_title.'" use_background_color_gradient="off"  background_image="'.$url.'" parallax="off" ]<a href="'.home_url().'">'.__('Home','Mundo').'</a> / <a href="'.$about_link.'">'.__("About",'Mundo').'</a> / '.__("Blog",'Mundo').' / '.$bread.' [/et_pb_slide]';
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
<div id="main" class="clearfix page-blog-detail container ">
    <div class="inner-wrap clearfix">
  <?php do_action( 'colormag_before_body_content' ); ?>
    <div id="content" class="clearfix tin-tuc-content row">
        <div class="col-md-8 blog-detail-left">
                <?php while ( have_posts() ) : the_post(); ?>
                <div class="article-container ">
                        <!-- <span class="detail-blog-category">
                                <?php   echo __('Categories:', 'Mundo');
                                        $terms_destination = wp_get_post_terms( $post_id, 'category-destination', array() );
                                        echo '<span>'.$terms_destination[0]->name.'</span>';
                                ?>
                        </span> -->
                        <!-- <span class='detail-blog-date'><?php  $date= date('M d,Y', strtotime($post->post_date));echo $date;?> </span> -->
                        <?php 
                                $author_id = $post->post_author;
                                $author = liva_get_user_name($author_id);
                                //echo '<span class="detail-blog-author">'.__("Post by",'Mundo').' <span>'.$author.'</span></span>';
                                echo '<div class="content-blog-detail">';
                                the_content();
                                echo '</div>';
                        ?>

                </div>
        <?php 
            $other_tours = get_post_meta($post_id,'related_tour',false);
            if ($other_tours) {
        
        ?>

        <!-- OTHER TOUR -->
        <div class="exploretour">
	        <?php
	        
	        $html = '<div class=" et_pb_row"><div class="row ">';
        foreach($other_tours as $post_another){
            //$thubnail = (get_the_post_thumbnail_url($post, 'post-thumbnail'))?:'';
            $thumbnail_id = get_post_thumbnail_id($post_another);
            $thubnail = mundo_get_attachment_image_src($thumbnail_id, 'tour_another')?:'';
            $link = (get_the_permalink($post_another))?:'';
            $title = (get_the_title($post_another))?:''; 
            $experts = (get_the_excerpt($post_another))?:'';
            $label_tour = (wp_get_post_terms($post_another, 'label_tour'))?:array();
            
                
                        $days = 0; 
                        $itinerary = (get_post_meta($post_another, 'itinerary',true))?:array();            
                        if($itinerary){
                            $days = count($itinerary);
                            if($days>0){
                                $day_html = ($days==1)?$days.' Day / 0 Night': $days. ' Days / '.($days-1).' Nights';
                            }
                        }
                        $departure_dates = (get_post_meta($post_another, 'departure_date',true))?:array();
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
                        <article id="post-'.$post_another.'" class="et_pb_post clearfix post-'.$post_another.' post type-post status-publish format-standard has-post-thumbnail hentry category-uncategorized">
                            
                                <div class="post-thumbnail"><a href="'.$link.'" class="entry-featured-image-url">
                                    <img src="'.$thubnail.'" alt="'.$title.'" width="1080" height="675">
                                </a>';
                                if ($label_tour) {
                                        $html .= '<div class="label_tour">'.$label_tour[0]->name.' </div>';
                                    }
                                $html .= '<div class="days"><b>'.$day_html.'</b> </div>';

                            $html .=     '</div><div class="post_content">
                                <h2 class="entry-title content"><a href="'.$link.'">'.$title.'</a></h2>';
                            $highlight_city = get_post_meta($post_another, '', true);
            
                        //$html .= '<div class="departure_date content"><b> Departures date: '.$departure_date_text.'</b> </div>';
                        $terms = wp_get_post_terms($post_another,'travel_style'); 
                        if($terms){
                            $list_category = '';
                            foreach($terms as $term){
                                $list_category .= $term->name .'    ';
                            }
                        }
                        $html .= '<div class="category_tour"><b>'.$list_category.'</b> </div>';
                        
                        
                        $route = (get_post_meta($post_another, 'route', true))?:'';
                        $html .= '<div class="route content"><b class="text_gray">'.str_replace(',', '/', $route).'</b> </div>';

                        $highlight_city = (get_post_meta($post_another, 'highlight_city', true))?:'';
                        $html .= '<div class="highlight_city content"><b>'.__('Highlights','mundo').':  </b><b class="text_gray">'.$highlight_city.' </b></div><div class="clear-both"></div>';
                        $price = get_post_meta($post_another, 'price_from',true);
                        $price = floor($price);
                    $html .= '</div>';
                    $html .= '<hr> <div class="row content exploretour-bot"> <div class = "col-lg-7 col-md-6"><span class="text_gray">'.__("From",'Mundo').':</span> <b class="price"> $'.$price.' </b><span class="text_gray price_sub"> pp</span></div>';
       $html .= '
                <div class="col-lg-5 col-md-6 view-tour"><a href="'.$link.'" class="more-link ">'.__("View tour",'Mundo').'</a></div>

       </div></article></div>';
           
        }
        $html .='</div></div></div>';
        echo $html;
        }

	    ?>
	         
	       
	        <div class="single-desti-nav row">
	        	<div class="single-desti-tag col-md-7 col-sm-7">
	        		<span class="tag-destination">Tag: </span>
	        		<?php
		        		$tags_array = get_tags( $args );
	        			foreach ($tags_array as $key => $value) {
	        				echo '<span class="all-tags">'.$value->name.'</span>';
	        			}
	        		?>
	        	</div>
	        	<div class='social_icons social_icons_blog col-md-5 col-sm-5'>   
	        		<span class="share-desti"><?php echo __('Share: ', 'Mundo'); ?></span> 
                    <?php 
                        $link_share = "https://www.facebook.com/sharer.php?u=".get_permalink($post->ID);
                        $link_share_print = "https://www.pinterest.com/pin/find/?url=".get_permalink($post->ID);
                        $link_share_twitter = "https://twitter.com/intent/tweet?text=How%20to%20share%20a%20Tweet&url=".get_permalink($post->ID);
                    ?>          
	                <a href="<?php echo $link_share;?>" class="icon" target="blank">
	                    <span aria-hidden="true" class="social_facebook"></span>
	                </a>
	                
	             <!--    <span aria-hidden="true" class="social-googleplus-ft">
	                    <a href="<?php echo ot_get_option( 'google');?>">
	                        <img src="<?php echo $home_url.'/wp-content/themes/mundo/icon/google.png';?>" class='icon-img'>
	                        <img src="<?php echo $home_url.'/wp-content/themes/mundo/icon/google_hover.png';?>" class='icon-hover'>
	                    </a>
	                </span> -->
	                
	                <a href="<?php echo $link_share_twitter;?>" class="icon" target="blank">
	                    <span aria-hidden="true" class="social_twitter"></span>
	                </a>
	                <a href="<?php echo $link_share_print;?>" class="icon" target="blank">
	                    <i class="fa fa-pinterest" ></i>
	                </a>            
	            </div>
	        </div>
        	<?php endwhile; ?> 
        </div><!-- end col-md-8 -->
        <div class="col-md-4 blog-detail-right">
                <div class="blog-detail-blog">
                        <?php 
                        $text_title = ot_get_option('text_title');
                        $text_content = ot_get_option('text_content');
                        $text_button = ot_get_option('text_button');
                        $link_button = ot_get_option('link_button');
                        echo do_shortcode('[et_pb_text admin_label="'.__("Search article",'Mundo').'" _builder_version="3.0.106" background_layout="light" module_class="wrapper-search-blog"]
                            <p><strong>'.__("Search article",'Mundo').'</strong></p>

                            [form_search_blog]

                            [/et_pb_text][et_pb_custom_post admin_label="Blog list expert" _builder_version="3.0.106" posts_number="1" show_content="on" show_thumbnail="on" show_more="off" show_author="off" show_date="off" show_categories="off" show_comments="off" show_pagination="off" fullwidth="on" use_overlay="off" background_layout="light" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2" module_id="expert_blog" display_content="on" module_class="expert_blog" custom_margin="||0px|" /][et_pb_text_subtitle_overview admin_label="Your Plan" _builder_version="3.0.106" title_text="'.$text_title.'" background_layout="light" header_line_height_tablet="2" title_text_position="top" custom_margin="||0px|" module_class="blog-plan"]

                            '.$text_content.'

                            [/et_pb_text_subtitle_overview][et_pb_button admin_label="'.$text_button.'" _builder_version="3.0.106" button_text="'.$text_button.' " url_new_window="off" background_layout="light" custom_button="off" button_icon_placement="right" custom_margin="||0px|" module_class="make-enquire make-enquire-blog" button_url="'.$link_button.'" /]

                            [et_pb_text admin_label="List category" _builder_version="3.0.106" background_layout="light" module_class="list-category"]

                            [list_category_blog_destination]

                            [/et_pb_text]');
                        ?>
                </div>
                <div class="blog-detail-wrapper-popular">
                        <h5><?php echo __('Popular posts', 'Mundo'); ?></h5>
                        <div class="blog-detail-popular">
                                <?php 
                                        $args = array(
                                          'numberposts' => 5,
                                          'post_type'   => 'post',
                                          'meta_query' => array(
                                                                array(
                                                                        'key'     => 'popular_post',
                                                                        'value'   => 1,
                                                                ),
                                                        ),
                                          'post__not_in' => array( $post_id ),
                                        );
                                        $popular_posts = get_posts( $args );
                                        foreach ($popular_posts as $popular_post) {
                                            echo '<a href="'.get_permalink( $popular_post->ID).'">';
                                                echo '<div class="blog-detail-popular-content">';
                                                        $date= date('M d,Y', strtotime($popular_post->post_date));echo '<p>'.$date.'</p>';
                                                        echo '<p class="detail-post">'.$popular_post->post_title.'</p>';
                                                echo '</div></a>';
                                        }
                                ?>
                        </div>
                </div>
                <?php
                ?>
        </div>
    </div><!-- #content -->
    <?php 
    $related_post = get_post_meta($post_id,'related_post',false);
    // print_r($related_post);
    ?>
<?php do_action( 'colormag_after_body_content' ); ?>
</div>
</div>
<div class="more-post-single-bolg">
        <?php 
            echo do_shortcode('[et_pb_section bb_built="1" _builder_version="3.0.106" prev_background_color="#000000" module_class="travel-post-wrapper"][et_pb_row _builder_version="3.0.106" background_size="initial" background_position="top_left" background_repeat="repeat" module_class="travel-post"][et_pb_column type="4_4"][et_pb_text admin_label="Travel Ispirations" _builder_version="3.0.106" background_layout="light" module_class="travel-post-text" custom_padding="50px|||"]
                <h2><span>'.__("Discover","Mundo").'</span> '.__("more posts",'Mundo').'</h2>
                [/et_pb_text][et_pb_custom_post fullwidth="off" posts_number="3" show_author="off" show_date="off" show_categories="off" show_pagination="off" module_id="related_post" display_content="on" _builder_version="3.0.106" header_font_size_tablet="51" header_line_height_tablet="2" body_font_size_tablet="51" body_line_height_tablet="2" meta_font_size_tablet="51" meta_line_height_tablet="2" pagination_font_size_tablet="51" pagination_line_height_tablet="2" show_content="off" show_thumbnail="on" show_more="on" show_comments="off" use_overlay="off" background_layout="light" more_text="'.__("Show more",'Mundo').'" module_class="travel-post-list"]

                &nbsp;

                [/et_pb_custom_post][/et_pb_column][/et_pb_row][/et_pb_section]');
        ?>
</div>
    <div class="contact-single-bolg">
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
            // echo do_shortcode('[et_pb_section bb_built="1" _builder_version="3.0.106" prev_background_color="#000000" next_background_color="#000000" module_class="what_ever_you_want what_ever_you_want_red"][et_pb_row _builder_version="3.0.106" background_size="initial" background_position="top_left" background_repeat="repeat" module_class="whatever-text"][et_pb_column type="4_4"][et_pb_text_fullwidth admin_label="What ever you want" _builder_version="3.0.106" header_line_height_tablet="2" background_layout="light" custom_padding="20px|||"]
            //     '.ot_get_option('what_ever_main_title').'
            //     <p style="text-align: center;"><span style="color: #ffffff;">'.ot_get_option('what_ever_sub_title').'</span></p>
            //     [/et_pb_text_fullwidth][/et_pb_column][/et_pb_row][et_pb_row _builder_version="3.0.106" background_size="initial" background_position="top_left" background_repeat="repeat" module_class="whatever-contact"][et_pb_column type="1_3"][et_pb_text admin_label="sdt" _builder_version="3.0.106" background_layout="light" module_class="what-ever-or"]
            //     <a href="tel:'.strip_tags(ot_get_option('what_ever_phone')).'" class="phone-mundo">
            //     <h4>'.ot_get_option('what_ever_phone').'</h4>
            //     </a>
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
<?php get_footer(); ?>
