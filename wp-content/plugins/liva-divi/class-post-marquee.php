<?php
class Post_Marquee extends ET_Builder_Module_Blog {
    function init() {
    	parent::init();
        $this->name = __( 'Post marquee', 'et_builder' );
        $this->slug = 'et_pb_post_marquee';
       	$this->fb_support = true;
        $this->fullwidth  = true;
       	//$this->whitelisted_fields[] = 'post_type';
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
        $admin_label         = $this->shortcode_atts['admin_label'];

		global $paged;

		$module_class              = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		$video_background          = $this->video_background();
		$parallax_image_background = $this->get_parallax_image_background();

		$container_is_closed = false;

		$processed_header_level = et_pb_process_header_level( $header_level, 'h2' );

		// some themes do not include these styles/scripts so we need to enqueue them in this module to support audio post format
        wp_enqueue_style( 'custom-jquery.marquee-css', plugins_url( '/css/custom-post-marquee.css', __FILE__ ) );
		wp_enqueue_script( 'jquery.marquee-js', plugins_url( '/js/jquery.marquee.min.js', __FILE__ ), array('jquery'), false, true );
		wp_enqueue_script( 'custom-jquery.marquee-js', plugins_url( '/js/custom-post-marquee.js', __FILE__ ), array(), false, true );

		$overlay_class = 'on' === $use_overlay ? ' et_pb_has_overlay' : '';

		if ( 'on' !== $fullwidth ){
			wp_enqueue_script( 'salvattore' );

			$background_layout = 'light';
		}

		$args = array( 'posts_per_page' => (int) $posts_number );

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
        
        $args = apply_filters('post_marquee_query_args', $args, $module_id);

		ob_start();

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

                <a href="<?php esc_url( the_permalink() ); ?>" class="entry-featured-image-url">
                    <?php echo $titletext; ?>
				</a>
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

		ob_end_clean();

		$class = " et_pb_bg_layout_{$background_layout}";

		if ( 'on' !== $fullwidth ) {
			$output = sprintf(
				'<div%5$s class="et_pb_module et_pb_blog_grid_wrapper%6$s">
					<div class="%1$s%3$s%7$s%9$s%11$s">
					%10$s
					%8$s
					<div class="et_pb_ajax_pagination_container">
						%2$s
					</div>
					%4$s %12$s
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
				$this->drop_shadow_back_compatibility( $function_name )
			);
		} else {
			$output = sprintf(
				'<div%5$s class="et_pb_module %1$s%3$s%6$s%7$s%9$s%11$s">
				%10$s
				%8$s
				<div class="et_pb_ajax_pagination_container marquee_container">
                    <label>%13$s</label>
                    <div class="marquee" data-duplicated="true">
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
                $admin_label
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
new Post_Marquee;