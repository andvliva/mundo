<?php
class Custom_Excursion_Show_More extends Custom_Post {
     function init() {
    	parent::init();
        $this->name = __( 'Custom Excursion Show More', 'liva-divi' );
        $this->slug = 'et_pb_custom_excursion_show_more';
       	$this->fb_support = true;
       	$this->whitelisted_fields[] = 'post_type';
       	$this->whitelisted_fields[] = 'more_text';
        $this->whitelisted_fields[] = 'show_more_posts';
        $this->whitelisted_fields[] = 'number_posts_more';
        $this->whitelisted_fields[] = 'display_content';
        $this->fields_defaults['more_text'] = array( 'Read More' );
        $this->fields_defaults['display_content'] = array( 'on' );
        $this->fields_defaults['show_more_posts'] = array( 'on' );
	}
	function get_fields() {
        $fields = parent::get_fields();
        $fields['show_more_posts'] = array(
			'label'             => esc_html__( 'Show more posts', 'liva-divi' ),
			'type'              => 'yes_no_button',
			'option_category'   => 'configuration',
            'options'           => array(
                 'off' => esc_html__( 'No', 'et_builder' ),
                 'on'  => esc_html__( 'Yes', 'et_builder' ),
            ),
			'toggle_slug'       => 'main_content',
		);
        $fields['number_posts_more'] = array(
			'label'             => esc_html__( 'Number posts more', 'liva-divi' ),
			'type'              => 'text',
			'option_category'   => 'configuration',
            'options'           => array(
                 'off' => esc_html__( 'No', 'et_builder' ),
                 'on'  => esc_html__( 'Yes', 'et_builder' ),
            ),
			'toggle_slug'       => 'main_content',
		);

        return $fields;
    }
    function shortcode_callback( $atts, $content = null, $function_name) {
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
		$more_text        	 = $this->shortcode_atts['more_text'];
		$display_content     = $this->shortcode_atts['display_content'];
        $show_more_posts     = $this->shortcode_atts['show_more_posts'];
        $number_posts_more     = $this->shortcode_atts['number_posts_more'];
        $more_text           = apply_filters('custom_post_more_text', $more_text, $module_id);
        $show_more_posts           = apply_filters('show_more_posts', $show_more_posts, $module_id);
		global $paged;
        
		$module_class              = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		$video_background          = $this->video_background();
		$parallax_image_background = $this->get_parallax_image_background();

		$container_is_closed = false;

		$processed_header_level = et_pb_process_header_level( $header_level, 'h2' );

		// some themes do not include these styles/scripts so we need to enqueue them in this module to support audio post format
		wp_enqueue_style( 'wp-mediaelement' );
		wp_enqueue_script( 'wp-mediaelement' );

		// include easyPieChart which is required for loading Blog module content via ajax correctly
		wp_enqueue_script( 'easypiechart' );

		// include ET Shortcode scripts
		wp_enqueue_script( 'et-shortcodes-js' );

		// remove all filters from WP audio shortcode to make sure current theme doesn't add any elements into audio module
		remove_all_filters( 'wp_audio_shortcode_library' );
		remove_all_filters( 'wp_audio_shortcode' );
		remove_all_filters( 'wp_audio_shortcode_class' );

		if ( '' !== $masonry_tile_background_color ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .et_pb_blog_grid .et_pb_post',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $masonry_tile_background_color )
				),
			) );
		}

		if ( '' !== $overlay_icon_color ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .et_overlay:before',
				'declaration' => sprintf(
					'color: %1$s !important;',
					esc_html( $overlay_icon_color )
				),
			) );
		}

		if ( '' !== $hover_overlay_color ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .et_overlay',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $hover_overlay_color )
				),
			) );
		}

		if ( 'on' === $use_overlay ) {
			$data_icon = '' !== $hover_icon
				? sprintf(
					' data-icon="%1$s"',
					esc_attr( et_pb_process_font_icon( $hover_icon ) )
				)
				: '';

			$overlay_output = sprintf(
				'<span class="et_overlay%1$s"%2$s></span>',
				( '' !== $hover_icon ? ' et_pb_inline_icon' : '' ),
				$data_icon
			);
		}

		$overlay_class = 'on' === $use_overlay ? ' et_pb_has_overlay' : '';

		if ( 'on' !== $fullwidth ){
			wp_enqueue_script( 'salvattore' );

			$background_layout = 'light';
		}

		$args = array( 
            'post_type' => 'post',
            'posts_per_page' => (int) $posts_number+1 );

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

		ob_start();
        $args =  apply_filters('custom_post_query_args', $args, $module_id);
		$posts = get_posts( $args );
        $post_found = count($posts);
        if($post_found > $posts_number){
            array_pop($posts);
        }
        //lay ra tat ca cac bai viet
        $args_all_post = $args;
        $args_all_post['posts_per_page'] = -1;
        $all_posts = get_posts($args_all_post);
        $total_posts = count($all_posts);                
        
                       
		if ( !empty($posts) ) {
			if ( 'off' === $fullwidth ) {
				echo '<div class="et_pb_salvattore_content" data-columns >';
			}
			foreach($posts as $post){

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

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post clearfix' . $no_thumb_class . $overlay_class  ); ?>>

			<?php
				et_divi_post_format_content();

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
                                    $filter_thumb = apply_filters('custom_post_post_thumb', null, $post, $module_id);
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
                <?php
                    $show_date_before = apply_filters('custom_post_show_date_before', false, $module_id);
                    if($show_date_before && 'on' === $show_date) {
                        echo et_get_safe_localization( sprintf( __( '%s', 'liva-divi' ), '<div class="published date_before">' . esc_html( get_the_date( $meta_date ) ) . '</div>' ) );
                    }
                ?>

			<?php if ( 'off' === $fullwidth || ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) || post_password_required( $post ) ) { ?>
				<?php if ( ! in_array( $post_format, array( 'link', 'audio' ) ) || post_password_required( $post ) ) { 
					if ($module_id=='post_home') {
						$date = et_get_safe_localization( sprintf( __( '%s', 'liva-divi' ), '<span class="published">' . esc_html( get_the_date( $meta_date ) ) . '</span>' ) );
						echo $date;
					}
					if ($module_id != 'traveller_reviews') {
					?>
					<<?php echo $processed_header_level; ?> class="entry-title"><a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a></<?php echo $processed_header_level; ?>>
				<?php } } ?>

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

					$post_content = et_strip_shortcodes( et_delete_post_first_video( get_the_content() ), true );

					$et_pb_rendering_column_content = true;
                    $show_content = apply_filters('custom_post_show_content', $show_content, $module_id, $post);
                    if ($display_content=='off') {
                    	$show_content = ' ';
                    }
					if ( 'on' === $show_content ) {
						global $more;

						// page builder doesn't support more tag, so display the_content() in case of post made with page builder
						if ( et_pb_is_pagebuilder_used( get_the_ID() ) ) {
							$more = 1;
							echo apply_filters( 'the_content', $post_content , $module_id );
						} else {
							$more = null;
							echo apply_filters( 'the_content', et_delete_post_first_video( get_the_content( esc_html__( 'read more...', 'liva-divi' ) ) ) );
						}
					}elseif( 'off' === $show_content ){
                        if ( has_excerpt() ) {
                        	the_excerpt();
                        } else {
                        	echo wpautop( et_delete_post_first_video( strip_shortcodes( truncate_post( 270, false, '', true ) ) ) );
                        }
					}else {
						echo $show_content;
					}

					$et_pb_rendering_column_content = false;


					echo '</div>';
					$more = 'on' == $show_more ? sprintf( ' <a href="%1$s" class="more-link" >%2$s</a>' , esc_url( get_permalink() ), $more_text )  : '';
					echo $more;
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
		$posts = ob_get_contents();
        $posts =  apply_filters('custom_posts_show_more', $posts, $module_id, $args, $number_posts_more,$fullwidth);
        
        $json_args = json_encode($args);
        $json_args = str_replace('"','/',$json_args);
        if ( ('on' === $show_more_posts) && ($post_found > $posts_number) ){
        	$show_more_text = 'Show More';
        	$show_more_text =apply_filters( 'custom_show_more_text',$show_more_text,$module_id);
            $posts .= '<div class="show_more_posts"><input type="submit" class="make-enquire" name="btn_show_more_posts" id="btn_show_more_posts" value="'.$show_more_text.'" data-step="1" data-args="'.$json_args.'" /></div>
            <!-- .et_pb_salvattore_content -->';
        }
		ob_end_clean();

		$class = " et_pb_bg_layout_{$background_layout}";
       // print_r($parallax_image_background);
		if ( 'on' !== $fullwidth ) {
			$output .= sprintf(
				'<div%5$s class="et_pb_module et_pb_blog_grid_wrapper%6$s custom_post_show_more" data-id="'.$module_id.'" data-offset="'.$number_posts_more.'" data-post_number="'.$posts_number.'" data-fullwidth="'.$fullwidth.'">
					<div class="%1$s%3$s%7$s%9$s%11$s">
					%10$s
					%8$s
					<div class="et_pb_ajax_pagination_container">
						%2$s
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
				$this->get_text_orientation_classname()
			//	$this->drop_shadow_back_compatibility( $function_name )
			);
         //   $output ='test';
          //  print_r($output);
		} else {
			$output .= sprintf(
				'<div%5$s class="et_pb_module %1$s%3$s%6$s%7$s%9$s%11$s custom_post_show_more" data-id="'.$module_id.'" data-offset="'.$number_posts_more.'" data-post_number="'.$posts_number.'" data-fullwidth="'.$fullwidth.'">
				%10$s
				%8$s
				<div class="et_pb_ajax_pagination_container">
					%2$s
				</div>
				%4$s',
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
				$this->get_text_orientation_classname()
			//	$this->drop_shadow_back_compatibility( $function_name )
			);
		}

		// Restore $wp_filter
		$wp_filter = $wp_filter_cache;
		unset($wp_filter_cache);

		// Restore global $post into its original state when et_pb_blog shortcode ends to avoid
		// the rest of the page uses incorrect global $post variable
		$post = $post_cache;
      //  print_r($output); exit;
		return $output;
	}
 }
 new Custom_Excursion_Show_More;