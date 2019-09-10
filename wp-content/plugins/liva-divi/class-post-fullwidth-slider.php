<?php
class Custom_Fullwidth_Post_Slider extends ET_Builder_Module_Fullwidth_Post_Slider {
    function init() {
   	    parent::init();
        $this->name = __( 'Custom post fullwidth slider', 'liva-divi' );
        $this->slug = 'et_pb_custom_post_fullwidth';
       	$this->fb_support = true;
        $this->fullwidth  = false;
       	$this->whitelisted_fields[] = 'post_type';
       	$this->whitelisted_fields[] = 'id_module';
        //d($this)
		// need to use global settings from the slider module
// 		$this->global_settings_slug = 'et_pd_custom_post_slider';
	}
    function get_fields() {
        $fields = parent::get_fields();
        
        $post_types = get_post_types();
        
        $fields['post_type'] = array(
			'label'             => esc_html__( 'Post type', 'liva-divi' ),
			'type'              => 'select',
			'option_category'   => 'configuration',
			'options'           => $post_types,
			'description'       => '',
            'computed_affects'   => array(
				'__posts',
			),
            'toggle_slug'       => 'main_content',
		);

        return $fields;
    }
    
    function shortcode_callback( $atts, $content = null, $function_name ) {
		/**
		 * Cached $wp_filter so it can be restored at the end of the callback.
		 * This is needed because this callback uses the_content filter / calls a function
		 * which uses the_content filter. WordPress doesn't support nested filter
		 */
		global $wp_filter;
		$wp_filter_cache = $wp_filter;

		$module_id               = $this->shortcode_atts['module_id'];
		$module_class            = $this->shortcode_atts['module_class'];
		$show_arrows             = $this->shortcode_atts['show_arrows'];
		$show_pagination         = $this->shortcode_atts['show_pagination'];
		$parallax                = $this->shortcode_atts['parallax'];
		$parallax_method         = $this->shortcode_atts['parallax_method'];
		$auto                    = $this->shortcode_atts['auto'];
		$auto_speed              = $this->shortcode_atts['auto_speed'];
		$auto_ignore_hover       = $this->shortcode_atts['auto_ignore_hover'];
		$body_font_size 		 = $this->shortcode_atts['body_font_size'];
		$show_content_on_mobile  = $this->shortcode_atts['show_content_on_mobile'];
		$show_cta_on_mobile      = $this->shortcode_atts['show_cta_on_mobile'];
		$show_image_video_mobile = $this->shortcode_atts['show_image_video_mobile'];
		$background_position     = $this->shortcode_atts['background_position'];
		$background_size         = $this->shortcode_atts['background_size'];
		$posts_number            = $this->shortcode_atts['posts_number'];
		$include_categories      = $this->shortcode_atts['include_categories'];
		$show_more_button        = $this->shortcode_atts['show_more_button'];
		$more_text               = $this->shortcode_atts['more_text'];
		$content_source          = $this->shortcode_atts['content_source'];
		$background_color        = $this->shortcode_atts['background_color'];
		$show_image              = $this->shortcode_atts['show_image'];
		$image_placement         = $this->shortcode_atts['image_placement'];
		$background_image        = $this->shortcode_atts['background_image'];
		$background_layout       = $this->shortcode_atts['background_layout'];
		$background_repeat       = $this->shortcode_atts['background_repeat'];
		$background_blend        = $this->shortcode_atts['background_blend'];
		$use_bg_overlay          = $this->shortcode_atts['use_bg_overlay'];
		$bg_overlay_color        = $this->shortcode_atts['bg_overlay_color'];
		$use_text_overlay        = $this->shortcode_atts['use_text_overlay'];
		$text_overlay_color      = $this->shortcode_atts['text_overlay_color'];
		$orderby                 = $this->shortcode_atts['orderby'];
		$show_meta               = $this->shortcode_atts['show_meta'];
		$button_custom           = $this->shortcode_atts['custom_button'];
		$button_rel              = $this->shortcode_atts['button_rel'];
		$custom_icon             = $this->shortcode_atts['button_icon'];
		$use_manual_excerpt      = $this->shortcode_atts['use_manual_excerpt'];
		$excerpt_length          = $this->shortcode_atts['excerpt_length'];
		$text_border_radius      = $this->shortcode_atts['text_border_radius'];
		$dot_nav_custom_color    = $this->shortcode_atts['dot_nav_custom_color'];
		$arrows_custom_color     = $this->shortcode_atts['arrows_custom_color'];
		$header_level            = $this->shortcode_atts['header_level'];
        
        $post_type               = $this->shortcode_atts['post_type'];
        //$id_module               = $this->shortcode_atts['id_module'];

		$post_index = 0;

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		$hide_on_mobile_class = self::HIDE_ON_MOBILE;

		$is_text_overlay_applied = 'on' === $use_text_overlay;

		// Applying backround-related style to slide item since advanced_option only targets module wrapper
		if ( 'on' === $this->shortcode_atts['show_image'] && 'background' === $this->shortcode_atts['image_placement'] && 'off' === $parallax ) {
			if ('' !== $background_color) {
				ET_Builder_Module::set_style( $function_name, array(
					'selector'    => '%%order_class%% .et_pb_slide:not(.et_pb_slide_with_no_image)',
					'declaration' => sprintf(
						'background-color: %1$s;',
						esc_html( $background_color )
					),
				) );
			}

			if ( '' !== $background_size && 'default' !== $background_size ) {
				ET_Builder_Module::set_style( $function_name, array(
					'selector'    => '%%order_class%% .et_pb_slide',
					'declaration' => sprintf(
						'-moz-background-size: %1$s;
						-webkit-background-size: %1$s;
						background-size: %1$s;',
						esc_html( $background_size )
					),
				) );

				if ( 'initial' === $background_size ) {
					ET_Builder_Module::set_style( $function_name, array(
						'selector'    => 'body.ie %%order_class%% .et_pb_slide',
						'declaration' => '-moz-background-size: auto; -webkit-background-size: auto; background-size: auto;',
					) );
				}
			}

			if ( '' !== $background_position && 'default' !== $background_position ) {
				$processed_position = str_replace( '_', ' ', $background_position );

				ET_Builder_Module::set_style( $function_name, array(
					'selector'    => '%%order_class%% .et_pb_slide',
					'declaration' => sprintf(
						'background-position: %1$s;',
						esc_html( $processed_position )
					),
				) );
			}

			if ( '' !== $background_repeat ) {
				ET_Builder_Module::set_style( $function_name, array(
					'selector'    => '%%order_class%% .et_pb_slide',
					'declaration' => sprintf(
						'background-repeat: %1$s;',
						esc_html( $background_repeat )
					),
				) );
			}

			if ( '' !== $background_blend ) {
				ET_Builder_Module::set_style( $function_name, array(
					'selector'    => '%%order_class%% .et_pb_slide',
					'declaration' => sprintf(
						'background-blend-mode: %1$s;',
						esc_html( $background_blend )
					),
				) );
			}
		}

		if ( 'on' === $use_bg_overlay && '' !== $bg_overlay_color ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .et_pb_slide .et_pb_slide_overlay_container',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $bg_overlay_color )
				),
			) );
		}

		if ( $is_text_overlay_applied && '' !== $text_overlay_color ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .et_pb_slide .et_pb_text_overlay_wrapper',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $text_overlay_color )
				),
			) );
		}

		if ( '' !== $text_border_radius ) {
			$border_radius_value = et_builder_process_range_value( $text_border_radius );
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%%.et_pb_slider_with_text_overlay .et_pb_text_overlay_wrapper',
				'declaration' => sprintf(
					'border-radius: %1$s;',
					esc_html( $border_radius_value )
				),
			) );
		}

		$fullwidth = 'et_pb_fullwidth_post_slider' === $function_name ? 'on' : 'off';

		$class  = '';
		$class .= 'off' === $fullwidth ? ' et_pb_slider_fullwidth_off' : '';
		$class .= 'off' === $show_arrows ? ' et_pb_slider_no_arrows' : '';
		$class .= 'off' === $show_pagination ? ' et_pb_slider_no_pagination' : '';
		$class .= 'on' === $parallax ? ' et_pb_slider_parallax' : '';
		$class .= 'on' === $auto ? ' et_slider_auto et_slider_speed_' . esc_attr( $auto_speed ) : '';
		$class .= 'on' === $auto_ignore_hover ? ' et_slider_auto_ignore_hover' : '';
		$class .= 'on' === $show_image_video_mobile ? ' et_pb_slider_show_image' : '';
		$class .= ' et_pb_post_slider_image_' . $image_placement;
		$class .= 'on' === $use_bg_overlay ? ' et_pb_slider_with_overlay' : '';
		$class .= 'on' === $use_text_overlay ? ' et_pb_slider_with_text_overlay' : '';

		$video_background = $this->video_background();
		$parallax_image_background = $this->get_parallax_image_background();

		$data_dot_nav_custom_color = '' !== $dot_nav_custom_color
			? sprintf( ' data-dots_color="%1$s"', esc_attr( $dot_nav_custom_color ) )
			: '';

		$data_arrows_custom_color = '' !== $arrows_custom_color
			? sprintf( ' data-arrows_color="%1$s"', esc_attr( $arrows_custom_color ) )
			: '';
            
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

		ob_start();

		// Re-used self::get_blog_posts() for builder output
		$query = self::get_blog_posts(array(
            'module_id'          => $module_id,
            'post_type'          => $post_type,
			'posts_number'       => $posts_number,
			'include_categories' => $include_categories,
			'orderby'            => $orderby,
			'content_source'     => $content_source,
			'use_manual_excerpt' => $use_manual_excerpt,
			'excerpt_length'     => $excerpt_length,
		), array(), array(), false );

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();

				$slide_class = 'off' !== $show_image && in_array( $image_placement, array( 'left', 'right' ) ) && has_post_thumbnail() ? ' et_pb_slide_with_image' : '';
				$slide_class .= 'off' !== $show_image && ! has_post_thumbnail() ? ' et_pb_slide_with_no_image' : '';
				$slide_class .= " et_pb_bg_layout_{$background_layout}";
			?>
			<div class="et_pb_slide et_pb_media_alignment_center<?php echo esc_attr( $slide_class ); ?>" <?php if ( 'on' !== $parallax && 'off' !== $show_image && 'background' === $image_placement ) { printf( 'style="background-image:url(%1$s)"', esc_url( wp_get_attachment_url( get_post_thumbnail_id() ) ) );  } ?><?php echo $data_dot_nav_custom_color; echo $data_arrows_custom_color; ?>>
				<?php if ( 'on' === $parallax && 'off' !== $show_image && 'background' === $image_placement ) { ?>
					<div class="et_parallax_bg<?php if ( 'off' === $parallax_method ) { echo ' et_pb_parallax_css'; } ?>" style="background-image: url(<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id() ) ); ?>);"></div>
				<?php } ?>
				<?php if ( 'on' === $use_bg_overlay ) { ?>
					<div class="et_pb_slide_overlay_container"></div>
				<?php } ?>
				<div class="et_pb_container clearfix">
					<div class="et_pb_slider_container_inner">
						<?php if ( 'off' !== $show_image && has_post_thumbnail() && ! in_array( $image_placement, array( 'background', 'bottom' ) ) ) { ?>
							<div class="et_pb_slide_image">
								<?php the_post_thumbnail(); ?>
							</div>
						<?php } ?>
						<div class="et_pb_slide_description">
							<?php if ( $is_text_overlay_applied ) : ?><div class="et_pb_text_overlay_wrapper"><?php endif; ?>
								<<?php echo et_pb_process_header_level( $header_level, 'h2' ) ?> class="et_pb_slide_title"><a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a></<?php echo et_pb_process_header_level( $header_level, 'h2' ) ?>>
								<div class="et_pb_slide_content <?php if ( 'on' !== $show_content_on_mobile ) { echo esc_attr( $hide_on_mobile_class ); } ?>">
									<?php
									if ( 'off' !== $show_meta ) {
										printf(
											'<p class="post-meta">%1$s | %2$s | %3$s | %4$s</p>',
											et_get_safe_localization( sprintf( __( 'by %s', 'liva-divi' ), '<span class="author vcard">' .  et_pb_get_the_author_posts_link() . '</span>' ) ),
											et_get_safe_localization( sprintf( __( '%s', 'liva-divi' ), '<span class="published">' . esc_html( get_the_date() ) . '</span>' ) ),
											get_the_category_list(', '),
											sprintf( esc_html( _nx( '%s Comment', '%s Comments', get_comments_number(), 'number of comments', 'liva-divi' ) ), number_format_i18n( get_comments_number() ) )
										);
									}
									?>
									<?php
										echo $query->posts[ $post_index ]->post_content;
									?>
								</div>
							<?php if ( $is_text_overlay_applied ) : ?></div><?php endif; ?>
							<?php if ( 'off' !== $show_more_button && '' !== $more_text ) {
									printf(
										'<div class="et_pb_button_wrapper"><a href="%1$s" class="et_pb_more_button et_pb_button%4$s%5$s"%3$s%6$s>%2$s</a></div>',
										esc_url( get_permalink() ),
										esc_html( $more_text ),
										'' !== $custom_icon && 'on' === $button_custom ? sprintf(
											' data-icon="%1$s"',
											esc_attr( et_pb_process_font_icon( $custom_icon ) )
										) : '',
										'' !== $custom_icon && 'on' === $button_custom ? ' et_pb_custom_button_icon' : '',
										'on' !== $show_cta_on_mobile ? esc_attr( " {$hide_on_mobile_class}" ) : '',
										$this->get_rel_attributes( $button_rel )
									);
								}
							?>
						</div> <!-- .et_pb_slide_description -->
						<?php if ( 'off' !== $show_image && has_post_thumbnail() && 'bottom' === $image_placement ) { ?>
							<div class="et_pb_slide_image">
								<?php the_post_thumbnail(); ?>
							</div>
						<?php } ?>
					</div>
				</div> <!-- .et_pb_container -->
			</div> <!-- .et_pb_slide -->
		<?php
			$post_index++;

			} // end while
		} // end if

		wp_reset_query();

		if ( ! $content = ob_get_clean() ) {
			$content  = '<div class="et_pb_row et_pb_no_results">';
			$content .= self::get_no_results_template();
			$content .= '</div>';
		}

		$output = sprintf(
			'<div%3$s class="et_pb_module et_pb_slider et_pb_post_slider%1$s%4$s%5$s%7$s">
				%8$s
				%6$s
				<div class="et_pb_slides">
					%2$s
				</div> <!-- .et_pb_slides -->
				%9$s
			</div> <!-- .et_pb_slider -->
			',
			esc_attr( $class ),
			$content,
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			'' !== $video_background ? ' et_pb_section_video et_pb_preload' : '',
			$video_background,
			'' !== $parallax_image_background ? ' et_pb_section_parallax' : '',
			$parallax_image_background,
			$this->inner_shadow_back_compatibility( $function_name )
		);

		// Restore $wp_filter
		$wp_filter = $wp_filter_cache;
		unset($wp_filter_cache);

		return $output;
	}
    
    static function get_blog_posts( $args = array(), $conditional_tags = array(), $current_page = array(), $is_ajax_request = true ) {
		$defaults = array(
			'posts_number'       => '',
			'include_categories' => '',
			'orderby'            => '',
			'content_source'     => '',
			'use_manual_excerpt' => '',
			'excerpt_length'     => '',
		);

		$args = wp_parse_args( $args, $defaults );

		$query_args = array(
			'posts_per_page' => (int) $args['posts_number'],
			'post_status'    => 'publish',
		);
        if( !empty($args['post_type']) ) {
            $query_args['post_type'] = $args['post_type'];
        }

		if ( '' !== $args['include_categories'] ) {
			$query_args['cat'] = $args['include_categories'];
		}

		if ( 'date_desc' !== $args['orderby'] ) {
			switch( $args['orderby'] ) {
				case 'date_asc' :
					$query_args['orderby'] = 'date';
					$query_args['order'] = 'ASC';
					break;
				case 'title_asc' :
					$query_args['orderby'] = 'title';
					$query_args['order'] = 'ASC';
					break;
				case 'title_desc' :
					$query_args['orderby'] = 'title';
					$query_args['order'] = 'DESC';
					break;
				case 'rand' :
					$query_args['orderby'] = 'rand';
					break;
			}
		}
        $module_id = empty($args['module_id']) ? '' : $args['module_id'];

        $query_args = apply_filters('custom_fullwidth_post_slider_query_args', $query_args, $module_id);
        
		$query = new WP_Query( $query_args );

		if ( $query->have_posts() ) {
			$post_index = 0;
			while ( $query->have_posts() ) {
				$query->the_post();

				$post_author_id = $query->posts[ $post_index ]->post_author;

				$categories = array();

				$categories_object = get_the_terms( get_the_ID(), 'category' );

				if ( ! empty( $categories_object ) ) {
					foreach ( $categories_object as $category ) {
						$categories[] = array(
							'id' => $category->term_id,
							'label' => $category->name,
							'permalink' => get_term_link( $category ),
						);
					}
				}

				$query->posts[ $post_index ]->post_featured_image = esc_url( wp_get_attachment_url( get_post_thumbnail_id() ) );
				$query->posts[ $post_index ]->has_post_thumbnail  = has_post_thumbnail();
				$query->posts[ $post_index ]->post_permalink      = get_the_permalink();
				$query->posts[ $post_index ]->post_author_url     = get_author_posts_url( $post_author_id );
				$query->posts[ $post_index ]->post_author_name    = get_the_author_meta( 'display_name', $post_author_id );
				$query->posts[ $post_index ]->post_date_readable  = get_the_date();
				$query->posts[ $post_index ]->categories          = $categories;
				$query->posts[ $post_index ]->post_comment_popup  = sprintf( esc_html( _nx( '%s Comment', '%s Comments', get_comments_number(), 'number of comments', 'liva-divi' ) ), number_format_i18n( get_comments_number() ) );

				$post_content = et_strip_shortcodes( get_the_content(), true );

				global $et_fb_processing_shortcode_object, $et_pb_rendering_column_content;

				$global_processing_original_value = $et_fb_processing_shortcode_object;

				// reset the fb processing flag
				$et_fb_processing_shortcode_object = false;
				// set the flag to indicate that we're processing internal content
				$et_pb_rendering_column_content = true;

				if ( $is_ajax_request ) {
					// reset all the attributes required to properly generate the internal styles
					ET_Builder_Element::clean_internal_modules_styles();
				}

				if ( 'on' === $args['content_source'] ) {
					global $more;

					// page builder doesn't support more tag, so display the_content() in case of post made with page builder
					if ( et_pb_is_pagebuilder_used( get_the_ID() ) ) {

						$builder_post_content = et_is_builder_plugin_active() ? do_shortcode( $post_content ) : apply_filters( 'the_content', $post_content );

						// Overwrite default content, in case the content is protected
						$query->posts[ $post_index ]->post_content = $builder_post_content;
					} else {
						$more = null;

						// Overwrite default content, in case the content is protected
						$query->posts[ $post_index ]->post_content = et_is_builder_plugin_active() ? do_shortcode( get_the_content('') ) : apply_filters( 'the_content', get_the_content('') );
					}
				} else {
					if ( has_excerpt() && 'off' !== $args['use_manual_excerpt'] ) {
						$query->posts[ $post_index ]->post_content = et_is_builder_plugin_active() ? do_shortcode( et_strip_shortcodes( get_the_excerpt(), true ) ) : apply_filters( 'the_content', et_strip_shortcodes( get_the_excerpt(), true ) );
					} else {
						$query->posts[ $post_index ]->post_content = strip_shortcodes( truncate_post( intval( $args['excerpt_length'] ), false, '', true ) );
					}
				}

				$et_fb_processing_shortcode_object = $global_processing_original_value;

				if ( $is_ajax_request ) {
					// retrieve the styles for the modules inside Blog content
					$internal_style = ET_Builder_Element::get_style( true );

					// reset all the attributes after we retrieved styles
					ET_Builder_Element::clean_internal_modules_styles( false );

					$query->posts[ $post_index ]->internal_styles = $internal_style;
				}

				$et_pb_rendering_column_content = false;

				$post_index++;
			} // end while
			wp_reset_query();
		} else if ( wp_doing_ajax() ) {
			// This is for the VB
			$query  = '<div class="et_pb_row et_pb_no_results">';
			$query .= self::get_no_results_template();
			$query .= '</div>';

			$query = array( 'posts' => $query );
		}

		return $query;
	}
    
    private function inner_shadow_back_compatibility( $functions_name ) {
		$utils = ET_Core_Data_Utils::instance();
		$atts  = $this->shortcode_atts;
		$style = '';

		if (
			version_compare( $utils->array_get( $atts, '_builder_version', '3.0.93' ), '3.0.99', 'lt' )
		) {
			$class = self::get_module_order_class( $functions_name );
			$style = sprintf(
				'<style>%1$s</style>',
				sprintf(
					'.%1$s.et_pb_slider .et_pb_slide {'
					. '-webkit-box-shadow: none; '
					. '-moz-box-shadow: none; '
					. 'box-shadow: none; '
					.'}',
					esc_attr( $class )
				)
			);

			if ( 'off' !== $utils->array_get( $atts, 'show_inner_shadow' ) ) {
				$style .= sprintf(
					'<style>%1$s</style>',
					sprintf(
						'.%1$s > .box-shadow-overlay { '
						. '-webkit-box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1); '
						. '-moz-box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1); '
						. 'box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1); '
						. '}',
						esc_attr( $class )
					)
				);
			}
		}

		return $style;
	}
}
new Custom_Fullwidth_Post_Slider;