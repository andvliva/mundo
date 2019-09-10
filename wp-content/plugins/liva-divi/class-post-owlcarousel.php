<?php
class Post_Owlcarousel extends ET_Builder_Module_Blog {
    function init() {
    	parent::init();
        $this->name = __( 'Post Owlcarousel', 'liva-divi' );
        $this->slug = 'et_pb_post_owlcarousel';
       	$this->fb_support = true;
        //$this->fullwidth  = true;
        $this->whitelisted_fields[] = 'more_text';
       	$this->whitelisted_fields[] = 'title_before_image';
       	$this->whitelisted_fields[] = 'owl_items';
       	$this->whitelisted_fields[] = 'owl_margin';
       	$this->whitelisted_fields[] = 'post_type';
       	$this->whitelisted_fields[] = 'display_content';
       	$this->fields_defaults['display_content'] = array( 'on' );
        //d($this->options_toggles);
        $this->options_toggles['advanced']['toggles']['owlcarousel_options'] = esc_html__( 'OwlCarousel options', 'liva-divi' );
        $this->fields_defaults['more_text'] = array( 'Read More' );
	}
    
    function get_fields() {
        $fields = parent::get_fields();
        $options = get_post_types();
        $fields['post_type'] = array(
				'label'             => esc_html__( 'Post type', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'options'           => $options,
				'toggle_slug'       => 'main_content', // vung hien thi main_content/elements/featured_image..
				'description'       => esc_html__( 'Here you can adjust the post type in which posts are displayed.', 'et_builder' ),
				'computed_affects'  => array(
					'__posts',
				),
			);
        $fields['more_text'] = array(
			'label'             => esc_html__( 'More text', 'liva-divi' ),
			'type'              => 'text',
			'option_category'   => 'configuration',
			'toggle_slug'       => 'main_content',
		);
        $fields['title_before_image'] = array(
			'label'             => esc_html__( 'Title before image', 'liva-divi' ),
			'type'              => 'yes_no_button',
			'option_category'   => 'configuration',
			'options'           => array(
				'off' => esc_html__( 'No', 'liva-divi' ),
				'on'  => esc_html__( 'Yes', 'liva-divi' ),
			),
			'toggle_slug'       => 'elements',
		);
        $fields['owl_items'] = array(
			'label'             => esc_html__( 'Owl items', 'liva-divi' ),
			'type'              => 'text',
			'option_category'   => 'owlcarousel_options',
			'description'       => '',
            'tab_slug'           => 'advanced',
			'toggle_slug'        => 'owlcarousel_options',
		);
        $fields['owl_margin'] = array(
			'label'             => esc_html__( 'Owl margin', 'liva-divi' ),
			'type'              => 'text',
			'option_category'   => 'owlcarousel_options',
			'description'       => '',
            'tab_slug'           => 'advanced',
			'toggle_slug'        => 'owlcarousel_options',
		);
		$fields['display_content'] = array(
				'label'           => esc_html__( 'Display content', 'et_builder' ),
				'type'            => 'select',
				'option_category' => 'color_option',
				'options'         => array(
					'on'  => esc_html__( 'On', 'et_builder' ),
					'off' => esc_html__( 'Off', 'et_builder' ),
				),
				'toggle_slug'     => 'main_content',
				'description'     => esc_html__( 'Display content of post' , 'et_builder' ),
			);
        return $fields;
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
        $display_content        	 = $this->shortcode_atts['display_content'];
        $owl_items = intval($this->shortcode_atts['owl_items']);
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
            'items' => $owl_items ? $owl_items : 3,
            'navText' => array('',''),
            'margin' => $owl_margin,
            'dots' => false,
        );

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
        
        $args = apply_filters('post_owlcarousel_query_args', $args, $module_id);

		ob_start();
		//print_r($args);exit();
        //print_r(get_posts($args)); exit;
		query_posts( $args );

		if ( have_posts() ) {
			if ( 'off' === $fullwidth ) {
				echo '<div class="et_pb_salvattore_content" data-columns>';
			}

			while ( have_posts() ) {
				the_post();

				global $post;

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

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post clearfix' . $no_thumb_class  ); ?>>

			<?php
				et_divi_post_format_content();
                if( $title_before_image == 'on' && $display_content=='on') {
				    if ( ! in_array( $post_format, array( 'link', 'audio' ) ) || post_password_required( $post ) ) {
                    ?>
					<<?php echo $processed_header_level; ?> class="entry-title"><a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a></<?php echo $processed_header_level; ?>>
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
				<?php if ( $title_before_image != 'on' &&  $display_content=='on' && ( ! in_array( $post_format, array( 'link', 'audio' ) ) || post_password_required( $post ) ) ) { ?>
					<<?php echo $processed_header_level; ?> class="entry-title"><a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a></<?php echo $processed_header_level; ?>>
				<?php } ?>

				<?php
					if ( 'on' === $show_author || 'on' === $show_date || 'on' === $show_categories || 'on' === $show_comments ) {
						printf( '<p class="post-meta">%1$s %2$s %3$s %4$s %5$s %6$s %7$s</p>',
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
									? get_the_category_list(', ')
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

					echo '<div class="post-content">';
					global $et_pb_rendering_column_content;
					if ($display_content=='on') {
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
							$custom_content = ' ';
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

	                    if ( 'on' !== $show_content ) {
							$more = 'on' == $show_more ? sprintf( ' <a href="%1$s" class="more-link" >%2$s</a>' , esc_url( get_permalink() ), $more_text )  : '';
							echo $more;
						}        	
			        }
					echo '</div>';
					?>
			<?php } // 'off' === $fullwidth || ! in_array( $post_format, array( 'link', 'audio', 'quote', 'gallery' ?>

			</article> <!-- .et_pb_post -->
	<?php
			} // endwhile

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
        $posts = apply_filters('post_owlcarousel_posts', $posts, $module_id);
        
		
		ob_end_clean();

		$class = " et_pb_bg_layout_{$background_layout}";
        
        $owlCarousel_options = apply_filters('post_owlCarousel_options', $owlCarousel_options, $module_id);
        $owlCarousel_options = htmlspecialchars(json_encode($owlCarousel_options));
       // print_r($post); exit;
		if ( 'on' !== $fullwidth ) {
           print_r($this->get_text_orientation_classname());
          
			$output = sprintf(
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
			$output = sprintf(
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
new Post_Owlcarousel;