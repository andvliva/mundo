<?php
class Post_Logo_Doitac extends ET_Builder_Module_Filterable_Portfolio {
    function init() {
    	parent::init();
        $this->name = __( 'Post Logo Doi tac', 'et_builder' );
        $this->slug = 'et_pb_post_logo_doi_tac';
       	$this->fb_support = true;
	}

    static function get_portfolio_item( $args = array(), $conditional_tags = array(), $current_page = array() ) {
		global $et_fb_processing_shortcode_object;

		$global_processing_original_value = $et_fb_processing_shortcode_object;

		$defaults = array(
			'show_pagination'    => 'on',
			'include_categories' => '',
			'fullwidth'          => 'on',
			'nopaging'           => true,
		);

		$query_args = array();

		$args = wp_parse_args( $args, $defaults );

		if ( '' !== $args['include_categories'] ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'project_category',
					'field' => 'id',
					'terms' => explode( ',', $args['include_categories'] ),
					'operator' => 'IN',
				)
			);
		}

		$default_query_args = array(
			'post_type'   => 'project',
			'post_status' => 'publish',
			'posts_per_page' => -1,
		);

		$query_args = wp_parse_args( $query_args, $default_query_args );
        
        $query_args = apply_filters('post_logo_doi_tac_query_args', $query_args, $args['module_id']);

		// Get portfolio query
		$query = new WP_Query( $query_args );

		// Format portfolio output, and add supplementary data
		$width     = 'on' === $args['fullwidth'] ?  1080 : 400;
		$width     = (int) apply_filters( 'et_pb_portfolio_image_width', $width );
		$height    = 'on' === $args['fullwidth'] ?  9999 : 284;
		$height    = (int) apply_filters( 'et_pb_portfolio_image_height', $height );
		$classtext = 'on' === $args['fullwidth'] ? 'et_pb_post_main_image' : '';
		$titletext = get_the_title();

		// Loop portfolio item and add supplementary data
		if( $query->have_posts() ) {
			$post_index = 0;
			while ( $query->have_posts() ) {
				$query->the_post();

				$categories = array();

				$category_classes = array( 'et_pb_portfolio_item' );

				if ( 'on' !== $args['fullwidth'] ) {
					$category_classes[] = 'et_pb_grid_item';
				}

				$categories_object = get_the_terms( get_the_ID(), 'project_category' );
				if ( ! empty( $categories_object ) ) {
					foreach ( $categories_object as $category ) {
						// Update category classes which will be used for post_class
						$category_classes[] = 'project_category_' . urldecode( $category->slug );

						// Push category data
						$categories[] = array(
							'id'        => $category->term_id,
							'slug'      => $category->slug,
							'label'     => $category->name,
							'permalink' => get_term_link( $category ),
						);
					}
				}

				// need to disable processnig to make sure get_thumbnail() doesn't generate errors
				$et_fb_processing_shortcode_object = false;

				// Get thumbnail
				$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );

				$et_fb_processing_shortcode_object = $global_processing_original_value;

				// Append value to query post
				$query->posts[ $post_index ]->post_permalink 	= get_permalink();
				$query->posts[ $post_index ]->post_thumbnail 	= print_thumbnail( $thumbnail['thumb'], $thumbnail['use_timthumb'], $titletext, $width, $height, '', false, true );
				$query->posts[ $post_index ]->post_categories 	= $categories;
				$query->posts[ $post_index ]->post_class_name 	= array_merge( get_post_class( '', get_the_ID() ), $category_classes );

				// Append category classes
				$category_classes = implode( ' ', $category_classes );

				$post_index++;
			}
		} else if ( wp_doing_ajax() ) {
			// This is for the VB
			$query = array( 'posts' => self::get_no_results_template() );
		}

		wp_reset_postdata();

		return $query;
	}

    function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id          = $this->shortcode_atts['module_id'];
		$module_class       = $this->shortcode_atts['module_class'];
		$fullwidth          = $this->shortcode_atts['fullwidth'];
		$posts_number       = $this->shortcode_atts['posts_number'];
		$include_categories = $this->shortcode_atts['include_categories'];
		$show_title         = $this->shortcode_atts['show_title'];
		$show_categories    = $this->shortcode_atts['show_categories'];
		$show_pagination    = $this->shortcode_atts['show_pagination'];
		$background_layout  = $this->shortcode_atts['background_layout'];
		$hover_icon          = $this->shortcode_atts['hover_icon'];
		$zoom_icon_color     = $this->shortcode_atts['zoom_icon_color'];
		$hover_overlay_color = $this->shortcode_atts['hover_overlay_color'];
		$header_level        = $this->shortcode_atts['title_level'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		wp_enqueue_script( 'hashchange' );

		if ( '' !== $zoom_icon_color ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .et_overlay:before',
				'declaration' => sprintf(
					'color: %1$s !important;',
					esc_html( $zoom_icon_color )
				),
			) );
		}

		if ( '' !== $hover_overlay_color ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .et_overlay',
				'declaration' => sprintf(
					'background-color: %1$s;
					border-color: %1$s;',
					esc_html( $hover_overlay_color )
				),
			) );
		}

		$projects = self::get_portfolio_item( array(
            'module_id'          => $module_id,
			'show_pagination'    => $show_pagination,
			'posts_number'       => $posts_number,
			'include_categories' => $include_categories,
			'fullwidth'          => $fullwidth,
		) );

		$categories_included = array();
		ob_start();
		if( $projects->post_count > 0 ) {
			while ( $projects->have_posts() ) {
				$projects->the_post();

				$category_classes = array();
				$categories = get_the_terms( get_the_ID(), 'project_category' );
				if ( $categories ) {
					foreach ( $categories as $category ) {
						$category_classes[] = 'project_category_' . urldecode( $category->slug );
						$categories_included[] = $category->term_id;
					}
				}

				$category_classes = implode( ' ', $category_classes );

				$main_post_class = sprintf(
					'et_pb_portfolio_item%1$s %2$s',
					( 'on' !== $fullwidth ? ' et_pb_grid_item' : '' ),
					$category_classes
				);

				?>
				<div id="post-<?php the_ID(); ?>" <?php post_class( $main_post_class ); ?>>
				<?php
					$thumb = '';

					$width = 'on' === $fullwidth ?  1080 : 400;
					$width = (int) apply_filters( 'et_pb_portfolio_image_width', $width );

					$height = 'on' === $fullwidth ?  9999 : 284;
					$height = (int) apply_filters( 'et_pb_portfolio_image_height', $height );
					$classtext = 'on' === $fullwidth ? 'et_pb_post_main_image' : '';
					$titletext = get_the_title();
					$permalink = get_permalink();
					$post_meta = get_the_term_list( get_the_ID(), 'project_category', '', ', ' );
					$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
					$thumb = $thumbnail["thumb"];
                    
                    $permalink = apply_filters('post_logo_doi_tac_permalink', $permalink, get_the_ID(), $module_id);


					if ( '' !== $thumb ) : ?>
						<a class="img" href="<?php echo esc_url( $permalink ); ?>" target="_blank" rel="nofollow">
							<span class="et_portfolio_image">
								<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height ); ?>
							</span>
						</a>
				<?php
					endif;
				?>
						

				<?php if ( 'on' === $show_title ) : ?>
					<<?php echo et_pb_process_header_level( $header_level, 'h2' ) ?> class="et_pb_module_header"><a href="<?php echo esc_url( $permalink ); ?>"><?php echo $titletext; ?></a></<?php echo et_pb_process_header_level( $header_level, 'h2' ) ?>>
				<?php endif; ?>

				<?php if ( 'on' === $show_categories ) : ?>
					<p class="post-meta"><?php echo $post_meta; ?></p>
				<?php endif; ?>

				</div><!-- .et_pb_portfolio_item -->
				<?php
			}
		}

		wp_reset_postdata();

		if ( ! $posts = ob_get_clean() ) {
			$posts            = self::get_no_results_template();
			$category_filters = '';
		} else {
			$categories_included = explode ( ',', $include_categories );
			$terms_args = array(
				'include' => $categories_included,
				'orderby' => 'name',
				'order' => 'ASC',
			);
			$terms = get_terms( 'project_category', $terms_args );

			$category_filters = '<ul class="clearfix">';
			$category_filters .= sprintf( '<li class="et_pb_portfolio_filter et_pb_portfolio_filter_all"><a href="#" class="active" data-category-slug="all">%1$s</a></li>',
				esc_html__( 'All', 'et_builder' )
			);
			foreach ( $terms as $term  ) {
				$category_filters .= sprintf( '<li class="et_pb_portfolio_filter"><a href="#" data-category-slug="%1$s">%2$s</a></li>',
					esc_attr( urldecode( $term->slug ) ),
					esc_html( $term->name )
				);
			}
			$category_filters .= '</ul>';
		}

		$video_background = $this->video_background();
		$parallax_image_background = $this->get_parallax_image_background();

		$class = " et_pb_module et_pb_bg_layout_{$background_layout}";

		// Images: Add CSS Filters and Mix Blend Mode rules (if set)
		if ( isset( $this->advanced_options['image']['css'] ) ) {
			$module_class .= $this->generate_css_filters(
				$function_name,
				'child_',
				self::$data_utils->array_get( $this->advanced_options['image']['css'], 'main', '%%order_class%%' )
			);
		}

		$output = sprintf(
			'<div%5$s class="et_pb_filterable_portfolio et_pb_portfolio %1$s%4$s%6$s%11$s%13$s%15$s" data-posts-number="%7$d"%10$s>
				%14$s
				%12$s
				<div class="et_pb_portfolio_filters clearfix">%2$s</div><!-- .et_pb_portfolio_filters -->

				<div class="et_pb_portfolio_items_wrapper %8$s">
					<div class="et_pb_portfolio_items">%3$s</div><!-- .et_pb_portfolio_items -->
				</div>
				%9$s
			</div> <!-- .et_pb_filterable_portfolio -->',
			( 'on' === $fullwidth ? 'et_pb_filterable_portfolio_fullwidth' : 'et_pb_filterable_portfolio_grid clearfix' ),
			$category_filters,
			$posts,
			esc_attr( $class ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			esc_attr( $posts_number),
			('on' === $show_pagination ? 'clearfix' : 'no_pagination' ),
			('on' === $show_pagination ? '<div class="et_pb_portofolio_pagination"></div>' : '' ),
			is_rtl() ? ' data-rtl="true"' : '',
			'' !== $video_background ? ' et_pb_section_video et_pb_preload' : '',
			$video_background,
			'' !== $parallax_image_background ? ' et_pb_section_parallax' : '',
			$parallax_image_background,
			$this->get_text_orientation_classname()
		);

		return $output;
	}
}
new Post_Logo_Doitac;