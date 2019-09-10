<?php
class Post_Sliders_With_Js extends Post_Slider_With_Js {
    function init() {
    	parent::init();
        $this->name = __( 'Post Sliders With Js', 'liva-divi' );
        $this->slug = 'et_pb_post_sliders_with_js';
       	$this->fb_support = true;
        //$this->fullwidth  = true;
        $this->whitelisted_fields[] = 'more_text';
       	$this->whitelisted_fields[] = 'title_before_image';
       	$this->whitelisted_fields[] = 'owl_items';
       	$this->whitelisted_fields[] = 'owl_margin';
       	$this->whitelisted_fields[] = 'post_type';
        $this->options_toggles['advanced']['toggles']['owlcarousel_options'] = esc_html__( 'OwlCarousel options', 'liva-divi' );
        $this->fields_defaults['more_text'] = array( 'Read More' );
	}
    
    function shortcode_callback( $atts, $content = null, $function_name ) {
		global $post;
		// Stored current global post as variable so global $post variable can be restored
		// to its original state when et_pb_blog shortcode ends to avoid incorrect global $post
		// being used on the page (i.e. blog + shop module in backend builder)
		$post_cache = $post;

		/**
		 * Cached $wp_filter so it can be restored at the end of the callback.
		 * This is needed because this callback uses the_content filter / calls a function
		 * which uses the_content filter. WordPress doesn't support nested filter
		 */
		global $wp_filter;
		$wp_filter_cache = $wp_filter;

		$module_id           = $this->shortcode_atts['module_id'];
		$module_class        = $this->shortcode_atts['module_class'];
		$fullwidth           = $this->shortcode_atts['fullwidth'];
		$posts_number        = $this->shortcode_atts['posts_number'];
		$include_categories  = $this->shortcode_atts['include_categories'];
		$meta_date           = $this->shortcode_atts['meta_date'];
		$show_thumbnail      = $this->shortcode_atts['show_thumbnail'];
		$show_content        = $this->shortcode_atts['show_content'];
		$show_author         = $this->shortcode_atts['show_author'];
		$show_date           = $this->shortcode_atts['show_date'];
		$show_categories     = $this->shortcode_atts['show_categories'];
		$show_comments       = $this->shortcode_atts['show_comments'];
		$show_pagination     = $this->shortcode_atts['show_pagination'];
		$background_layout   = $this->shortcode_atts['background_layout'];
		$show_more           = $this->shortcode_atts['show_more'];
		$offset_number       = $this->shortcode_atts['offset_number'];
		$masonry_tile_background_color = $this->shortcode_atts['masonry_tile_background_color'];
		$overlay_icon_color  = $this->shortcode_atts['overlay_icon_color'];
		$hover_overlay_color = $this->shortcode_atts['hover_overlay_color'];
		$hover_icon          = $this->shortcode_atts['hover_icon'];
		$use_overlay         = $this->shortcode_atts['use_overlay'];
		$header_level        = $this->shortcode_atts['header_level'];
        
        $slider_items = intval($this->shortcode_atts['owl_items']);
        $owl_margin = intval($this->shortcode_atts['owl_margin']);
        $title_before_image = $this->shortcode_atts['title_before_image'];
        $more_text           = $this->shortcode_atts['more_text'];
        $post_type               = $this->shortcode_atts['post_type'];
        if(empty($post_type)) {
            $post_type = 'post';
        }
		global $paged;

		$module_class              = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		$video_background          = $this->video_background();
		$parallax_image_background = $this->get_parallax_image_background();

		$container_is_closed = false;

		$processed_header_level = et_pb_process_header_level( $header_level, 'h2' );

		// some themes do not include these styles/scripts so we need to enqueue them in this module to support audio post format
        wp_enqueue_style( 'carousel-css', plugins_url( '/js/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css', __FILE__ ) );
        wp_enqueue_style( 'carousel-default-css', plugins_url( '/js/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css', __FILE__ ) );
		wp_enqueue_script( 'OwlCarousel-js', plugins_url( '/js/OwlCarousel2-2.3.4/dist/owl.carousel.min.js', __FILE__ ), array('jquery'), false, true );
		wp_enqueue_script( 'custom-OwlCarousel-js', plugins_url( '/js/custom-OwlCarousel.js', __FILE__ ), array(), false, true );
        $owlCarousel_options = array(
            'nav' => true,
            'navText' => array('',''),
            'items' => 1,
            'margin' => $owl_margin,
            'dots' => false,
           // 'autoWidth' => true,
        );
		
		wp_enqueue_style('cc-other', plugins_url('/css/cc-other.css', __FILE__));
       	wp_enqueue_script('cc-script', plugins_url('/js/cc-script.js', __FILE__), array('jquery'), false, true);

		$args = array(
            'post_type'      => $post_type,
			'posts_per_page' => (int) $posts_number,
			'post_status'    => 'publish',
		);
		$et_paged = is_front_page() ? get_query_var( 'page' ) : get_query_var( 'paged' );

		if ( is_front_page() ) {
			$paged = $et_paged;
		}

		if ( '' !== $include_categories ) {
			$args['cat'] = $include_categories;
		}

		if ( ! is_search() ) {
			$args['paged'] = $et_paged;
		}

		if ( '' !== $offset_number && ! empty( $offset_number ) ) {
			/**
			 * Offset + pagination don't play well. Manual offset calculation required
			 * @see: https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
			 */
			if ( $paged > 1 ) {
				$args['offset'] = ( ( $et_paged - 1 ) * intval( $posts_number ) ) + intval( $offset_number );
			} else {
				$args['offset'] = intval( $offset_number );
			}
		}

		if ( is_single() && ! isset( $args['post__not_in'] ) ) {
			$args['post__not_in'] = array( get_the_ID() );
		}

		// Images: Add CSS Filters and Mix Blend Mode rules (if set)
		if ( array_key_exists( 'image', $this->advanced_options ) && array_key_exists( 'css', $this->advanced_options['image'] ) ) {
			$module_class .= $this->generate_css_filters(
				$function_name,
				'child_',
				self::$data_utils->array_get( $this->advanced_options['image']['css'], 'main', '%%order_class%%' )
			);
		}
        
        
       
        $taxonomies = get_terms( array(
            'taxonomy' => 'travel_style',
            'hide_empty' => false,
            'meta_query' => array(
                array(
                    'key' => 'style_view_home',
                    'value' => 1,
                ),
                'stt' => array(
                    'key' => 'style_thu_tu',
                    'compare' => 'meta_value_num',
                    'type'    => 'numeric',
                ), 
            ),
            'orderby' => 'stt',
            
        ) );
        $taxonomies = apply_filters('post_slider_with_js_taxonomy', $taxonomies, $module_id);
        $tab_header = '<div class = "travel_style tab_header" data-taxonomy="'.$taxonomies[0]->taxonomy.'" data-module_id='.$module_id.'>
        <span class="tab_name active" data-slug="all">'.__("All",'liva-divi').'</span>
        ';
        foreach($taxonomies as $taxonomy){
           $tab_header .= '<span class="tab_name" data-slug="'.$taxonomy->slug.'">'.$taxonomy->name.'</span>'; 
        }
        $link_travel_style = home_url('travel-style');
        $current_lang = pll_current_language();
        switch ($current_lang) {
                case 'en':
                    $link_travel_style = get_permalink(get_page_by_path('experiences'));
                    break;
                case 'es':
                    $link_travel_style = get_permalink(get_page_by_path('experiencias-2'));
                    break;
                case 'pt':
                    $link_travel_style = get_permalink(get_page_by_path('experiencias'));
                    break;
                default:
                    $link_travel_style = get_permalink(get_page_by_path('experiences'));
                    break;
            }
		
        //custom by cc
        $tab_header .= '<span class="show_more"><a href="javascript:void();">'.__("Show more",'liva-divi').'</a>';

		$tax_current_arr = array();

		foreach($taxonomies as $taxonomy)	{
			$tax_current_arr[] = $taxonomy->term_id;
		}

		$cc_terms = get_terms( array(
            'taxonomy' => 'travel_style',
            'hide_empty' => false,
        ) );

		$tab_header .= '<ul class="cc-list-travel-style">';
        foreach ($cc_terms as $cc_term) {
        	if (!in_array($cc_term->term_id, $tax_current_arr)) {
				$tab_header .= '<li><a href="' . get_permalink(get_page_by_path( 'experiences')) . $cc_term->slug . '">' . $cc_term->name . '</a></li>';
        	}
        }

		$tab_header .= '</ul></span>';
       	$tab_header .= '</div>';
		//end custom by cc
       
        $args = apply_filters('post_slider_with_js_query_args', $args, $module_id);
        ob_start();
		$posts = get_posts( $args );
		if ( $posts ) {
			if ( 'off' === $fullwidth ) {
				echo '<div class="et_pb_salvattore_content" data-columns>';
			}
            $posts = array_chunk($posts,3);
            $posts = array_chunk($posts,2);

            foreach ($posts as $owl_items){
                echo '<div  class="item">';
                 echo '<div  class="row">';
                    foreach($owl_items as $rows){
                       
                 			foreach($rows as $post) {
                				$post_format = et_pb_post_format();
                				$thumb = '';
                				$width = 'on' === $fullwidth ? 1080 : 400;
                				$width = (int) apply_filters( 'et_pb_blog_image_width', $width );
                				$height = 'on' === $fullwidth ? 675 : 250;
                				$height = (int) apply_filters( 'et_pb_blog_image_height', $height );
                				$classtext = 'on' === $fullwidth ? 'et_pb_post_main_image' : '';
                				$titletext = get_the_title();
                				$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
                				$thumb = $thumbnail['thumb'];
                				$no_thumb_class = '' === $thumb || 'off' === $show_thumbnail ? ' et_pb_no_thumb' : '';                
                				if ( in_array( $post_format, array( 'video', 'gallery' ) ) ) {
                					$no_thumb_class = '';
                				}
                				?>
                            <div  class="col-md-4">
                			<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post clearfix' . $no_thumb_class  ); ?>><div class="post-thumbnail" >
                			<?php
                				et_divi_post_format_content();
                                if( $title_before_image == 'on' ) {
                				    if ( ! in_array( $post_format, array( 'link', 'audio' ) ) || post_password_required( $post ) ) {
                                    ?>
                					<<?php echo $processed_header_level; ?> class="entry-title content"><a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a></<?php echo $processed_header_level; ?>>
                				    <?php
                                    }
                                }
                				if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) || post_password_required( $post ) ) {
                					if ( 'video' === $post_format && false !== ( $first_video = et_get_first_video() ) ) :
                						$video_overlay = has_post_thumbnail() ? sprintf(
                							'<div class="et_pb_video_overlay" style="background-image: url(%1$s); background-size: cover;">
                								<div class="et_pb_video_overlay_hover">
                									<a href="#" class="et_pb_video_play"></a>
                								</div>
                							</div>',
                							$thumb
                						) : '';
                
                						printf(
                							'<div class="et_main_video_container">
                								%1$s
                								%2$s
                							</div>',
                							$video_overlay,
                							$first_video
                						);
                					elseif ( 'gallery' === $post_format ) :
                						et_pb_gallery_images( 'slider' );
                					elseif ( '' !== $thumb && 'on' === $show_thumbnail ) :
                						if ( 'on' !== $fullwidth ) {
                							echo '<div class="et_pb_image_container">';
                						}
                						?>
                							<a href="<?php esc_url( the_permalink() ); ?>" class="entry-featured-image-url">
                								<?php
                                                    $filter_thumb = apply_filters('post_owlCarousel_post_thumb', null, $post, $module_id);
                                                    if($filter_thumb != null) {
                                                        echo $filter_thumb;
                                                    }
                                                    else {
                                                        print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height );
                                                    }
                                                ?>
                								<?php if ( 'on' === $use_overlay ) {
                									echo $overlay_output;
                								} ?>
                							</a>
                					<?php
                						if ( 'on' !== $fullwidth ) echo '</div> <!-- .et_pb_image_container -->';
                					endif;
                				} ?>
                
                			<?php if ( 'off' === $fullwidth || ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) || post_password_required( $post ) ) { ?>
                				<?php if ( $title_before_image != 'on' && ( ! in_array( $post_format, array( 'link', 'audio' ) ) || post_password_required( $post ) ) ) { ?>
                                    <?php
                                    	if ( 'on' === $show_author || 'on' === $show_date || 'on' === $show_categories || 'on' === $show_comments ) {
                					   
                                        $terms = wp_get_post_terms($post->ID,'travel_style'); 
                                        if($terms){
                                            $list_category = '';
                                            foreach($terms as $term){
                                                $list_category .= $term->name .'    ';
                                            }
                                        }
                                        $list_category = get_post_meta($post->ID,'travel_style',true);    
                						printf( '<p class="post-meta post-content content category_tour">%1$s %2$s %3$s %4$s %5$s %6$s %7$s</p>',
                							(
                								'on' === $show_author
                									? et_get_safe_localization( sprintf( __( 'by %s', 'liva-divi' ), '<span class="author vcard">' .  et_pb_get_the_author_posts_link() . '</span>' ) )
                									: ''
                							),
                							(
                								( 'on' === $show_author && 'on' === $show_date )
                									? ' | '
                									: ''
                							),
                							(
                								'on' === $show_date
                									? et_get_safe_localization( sprintf( __( '%s', 'liva-divi' ), '<span class="published">' . esc_html( get_the_date( $meta_date ) ) . '</span>' ) )
                									: ''
                							),
                							(
                								(( 'on' === $show_author || 'on' === $show_date ) && 'on' === $show_categories)
                									? ' | '
                									: ''
                							),
                							(
                                           
                								'on' === $show_categories
                									? get_the_category_list(', ').$list_category
                									: ''
                							),
                							(
                								(( 'on' === $show_author || 'on' === $show_date || 'on' === $show_categories ) && 'on' === $show_comments)
                									? ' | '
                									: ''
                							),
                							(
                								'on' === $show_comments
                									? sprintf( esc_html( _nx( '%s Comment', '%s Comments', get_comments_number(), 'number of comments', 'liva-divi' ) ), number_format_i18n( get_comments_number() ) )
                									: ''
                							)
                						);
                					}
                                    $label_tour = wp_get_post_terms($post->ID, 'label_tour');
                                    if($label_tour){
                                        echo '<div class="label_tour">'.$label_tour[0]->name.' </div>';
                                    }
                                    $days = 0; 
                                    $itinerary = (get_post_meta($post->ID, 'itinerary',true))?:array();            
                                    if($itinerary){
                                        $days = count($itinerary);
                                        if($days>0){
                                            $day_html = ($days==1)?$days.__(' Day / 0 Night','liva-divi'): $days.__(' Days','liva-divi').' / '.($days-1).__(' Nights','liva-divi');
                                        }
                                    }
                                    echo '<div class="days"><b>'.$day_html.'</b> </div>';
                                    ?>
                                
                                    </div>
                                    <div class="post_content">
                					<<?php echo $processed_header_level; ?> class="entry-title content"><a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a></<?php echo $processed_header_level; ?>>
                				<?php } ?>
                
                				<?php
                                    $route = (get_post_meta($post->ID,'route',true))?:'';
                                    echo '<div class="route content"><b>'.str_replace(",", " - ",$route).'</b></div>';
                                    $highlight_city = get_post_meta($post->ID, 'highlight_city', true);
                                    echo '<div class="highlight_city content"><b>'.__("Highlights",'liva-divi').' : </b> <b class="text_gray">'.$highlight_city.'</b> </div>';
                					echo '</div>';
                                    //content
                                    echo '<hr>';
                                    echo '<div class="content row">';
                					global $et_pb_rendering_column_content;
                
                					$post_content = et_strip_shortcodes( et_delete_post_first_video( get_the_content() ), true );
                
                					$et_pb_rendering_column_content = true;
                
                					if ( 'on' === $show_content ) {
                						global $more;
                						// page builder doesn't support more tag, so display the_content() in case of post made with page builder
                						if ( et_pb_is_pagebuilder_used( get_the_ID() ) ) {
                							$more = 1;
                							echo apply_filters( 'the_content', $post_content );
                						} else {
                							$more = null;
                							echo apply_filters( 'the_content', et_delete_post_first_video( get_the_content( esc_html__( 'read more...', 'liva-divi' ) ) ) );
                						}
                						$custom_content = apply_filters( 'custom-post-owlcarosel-content', $custom_content,$module_id );
                						echo $custom_content;
                					} else {
                						if ( has_excerpt() ) {
                							the_excerpt();
                						} else {
                							echo wpautop( et_delete_post_first_video( strip_shortcodes( truncate_post( 270, false, '', true ) ) ) );
                						}
                					}
                
                					$et_pb_rendering_column_content = false;
                                    $symbol_exchange = '$';
                                    if (isset($_COOKIE['exchange_rate'])){
                                        $exchange_rate_string = $_COOKIE['exchange_rate'];
                                        $exchange_rate_cookie = explode("-",$exchange_rate_string); 
                                        $symbol_exchange = $exchange_rate_cookie[1];
                                    }
                                    if ( 'on' !== $show_content ) {
                                        $discount_price = get_post_meta($post->ID, 'discount_price',true);
                                        $text_gray = '';
                                        $discount = 'price';
                                        $discount_price_html = '';
                                        if($discount_price){
                                            $discount_price_html = '<b class="discount_price"> '.$symbol_exchange.$discount_price.'pp </b>';
                                            $text_gray = 'text_gray';
                                            $discount = 'discount';
                                        }
                                        
                                        //lay lai gia của tour khong lay theo gia from 
                                        $price = mundo_get_price_last_6_month($post->ID);
                                        if($price){
                                            $lang = pll_current_language();
                                            $price = (intval($price))?mundo_exchange_rate($price,$lang ):$price;
                                            $price_html = (intval($price))?'<b class="'.$discount.' '.$text_gray.'">'.$symbol_exchange.$price.' </b> <b class=" '.$discount.' text_gray ">pp</b>':'<b class="'.$discount.' '.$text_gray.'">'.$price.' </b>';
                                        }
                                        $from = $price=='On request'&&empty($discount_price)?__('Price','liva-divi').': ':__('From','liva-divi').': ';
                                        echo '<div class = "col-lg-7 col-md-6"><b class="text_gray">'.$from.'</b>'.$discount_price_html.$price_html.'</div>';
                						$more = 'on' == $show_more ? sprintf( '<div class="col-lg-5 col-md-6 view-tour"><a href="%1$s" class="more-link " >%2$s</a></div>' , esc_url( get_permalink() ), __('View tour','liva-divi') )  : '';
                						echo $more;
                					}
                
                					echo '</div>';
                					?>
                			<?php } // 'off' === $fullwidth || ! in_array( $post_format, array( 'link', 'audio', 'quote', 'gallery' ?>
                    
         			</article> <!-- .et_pb_post -->
                    </div>
                	<?php
                			} // endwhile
                        //echo '</div>';
                    }  
                    echo '</div>';
                echo '</div>';
            }


			if ( 'off' === $fullwidth ) {
 				echo '</div><!-- .et_pb_salvattore_content -->';
 			}

			if ( 'on' === $show_pagination && ! is_search() ) {
				if ( function_exists( 'wp_pagenavi' ) ) {
					wp_pagenavi();
				} else {
					if ( et_is_builder_plugin_active() ) {
						include( ET_BUILDER_PLUGIN_DIR . 'includes/navigation.php' );
					} else {
						get_template_part( 'includes/navigation', 'index' );
					}
				}

				echo '</div> <!-- .et_pb_posts -->';  
				$container_is_closed = true;
			}
		} else {
			if ( et_is_builder_plugin_active() ) {
				include( ET_BUILDER_PLUGIN_DIR . 'includes/no-results.php' );
			} else {
				get_template_part( 'includes/no-results', 'index' );
			}
		}

		wp_reset_query();

		$posts = ob_get_contents();

		ob_end_clean();

		$class = " et_pb_bg_layout_{$background_layout}";
        
        $owlCarousel_options = apply_filters('post_owlCarousel_options', $owlCarousel_options, $module_id);
        $owlCarousel_options = htmlspecialchars(json_encode($owlCarousel_options));
        $output = $tab_header;
       // $posts = ' <div class="item"><h4>1</h4></div>
//   <div>
//        <div class="row">
//            <div class="item col-md-4"><h4>1.1</h4></div> 
//            <div class="item col-md-4"><h4>1.2</h4></div> 
//            <div class="item col-md-4"><h4>1.3</h4></div>
//        
//        </div>
//        <div class="row">
//            <div class="item col-md-4"><h4>1.1</h4></div> 
//            <div class="item col-md-4"><h4>1.2</h4></div> 
//            <div class="item col-md-4"><h4>1.3</h4></div>
//        
//        </div>
//    </div>
//    <div><h4>3</h4></div>
//    <div><h4>4</h4></div>
//    <div><h4>5</h4></div>
//    <div><h4>6</h4></div>
//    <div class="item"><h4>7</h4></div>
//    <div class="item"><h4>8</h4></div>
//    <div class="item"><h4>9</h4></div>
//    <div class="item"><h4>10</h4></div>
//    <div class="item"><h4>11</h4></div>
//    <div class="item"><h4>12</h4></div>';
		if ( 'on' !== $fullwidth ) {
           print_r($this->get_text_orientation_classname());
          
			$output .= sprintf(
				'<div%5$s class="et_pb_module et_pb_blog_grid_wrapper%6$s">
					<div class="%1$s%3$s%7$s%9$s%11$s">
					%10$s
					%8$s
					<div class="et_pb_ajax_pagination_container owlcarousel-container">
                        <div class="owl-carousel owl-theme" data-options="%12$s">
						%2$s
                        </div>
					</div>
					%4$s
				</div>',
				( 'on' === $fullwidth ? 'et_pb_posts' : 'et_pb_blog_grid clearfix' ),
				$posts,
				esc_attr( $class ),
				( ! $container_is_closed ? '</div> <!-- .et_pb_posts -->' : '' ),
				( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
				( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
				'' !== $video_background ? ' et_pb_section_video et_pb_preload' : '',
				$video_background,
				'' !== $parallax_image_background ? ' et_pb_section_parallax' : '',
				$parallax_image_background,
				$this->get_text_orientation_classname(),
			//	$this->drop_shadow_back_compatibility( $function_name ),
                $owlCarousel_options
			);
           // print_r($output); exit;
		} else {
			$output .= sprintf(
				'<div%5$s class="et_pb_module %1$s%3$s%6$s%7$s%9$s%11$s">
				%10$s
				%8$s
				<div class="et_pb_ajax_pagination_container owlcarousel-container">
                    <div class="owl-carousel owl-theme" data-options="%13$s">
					%2$s
                    </div>
				</div>
				%4$s %12$s',
				( 'on' === $fullwidth ? 'et_pb_posts' : 'et_pb_blog_grid clearfix' ),
				$posts,
				esc_attr( $class ),
				( ! $container_is_closed ? '</div> <!-- .et_pb_posts -->' : '' ),
				( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
				( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
				'' !== $video_background ? ' et_pb_section_video et_pb_preload' : '',
				$video_background,
				'' !== $parallax_image_background ? ' et_pb_section_parallax' : '',
				$parallax_image_background,
				$this->get_text_orientation_classname(),
				$this->drop_shadow_back_compatibility( $function_name ),
                $owlCarousel_options
			);
		}

		// Restore $wp_filter
		$wp_filter = $wp_filter_cache;
		unset($wp_filter_cache);

		// Restore global $post into its original state when et_pb_blog shortcode ends to avoid
		// the rest of the page uses incorrect global $post variable
		$post = $post_cache;
       
		return $output;
	}
    
   	/**
	 * Since the styling file is not updated until the author updates the page/post,
	 * we should keep the drop shadow visible.
	 *
	 * @param string $functions_name
	 *
	 * @return string
	 */
	private function drop_shadow_back_compatibility( $functions_name ) {
		$utils = ET_Core_Data_Utils::instance();
		$atts  = $this->shortcode_atts;

		if (
			version_compare( $utils->array_get( $atts, '_builder_version', '3.0.93' ), '3.0.94', 'lt' )
			&&
			'on' !== $utils->array_get( $atts, 'fullwidth' )
			&&
			'on' === $utils->array_get( $atts, 'use_dropshadow' )
		) {
			$class = self::get_module_order_class( $functions_name );

			return sprintf(
				'<style>%1$s</style>',
				sprintf( '.%1$s  article.et_pb_post { box-shadow: 0 1px 5px rgba(0,0,0,.1) }', esc_html( $class ) )
			);
		}

		return '';
	}
}
new Post_Sliders_With_Js;