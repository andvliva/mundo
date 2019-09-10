<?php

class Custom_Our_Suites extends ET_Builder_Module_Post_Slider {
    function init() {
        parent::init();
		$this->name       = esc_html__( 'Our Suites', 'liva-divi' );
		$this->slug       = 'et_pb_post_slider_our_suites';
        $this->whitelisted_fields[] = 'post_type';
        $this->fields_defaults['module_id'] = array('custom_our_suites');
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
        return $fields;
    }
    
    static function get_blog_posts( $args = array(), $conditional_tags = array(), $current_page = array(), $is_ajax_request = true ) {
		$defaults = array(
            'post_type'          => 'suite',
			'posts_number'       => '',
			'include_categories' => '',
			'orderby'            => '',
			'content_source'     => '',
			'use_manual_excerpt' => '',
			'excerpt_length'     => '',
		);

		$args = wp_parse_args( $args, $defaults );
        
        global $post;

		$query_args = array(
            'post_type'      => $args['post_type'],
			'posts_per_page' => (int) $args['posts_number'],
			'post_status'    => 'publish',
		);
        
        $ship = $post->post_type == 'ship' ? $post->ID : ( get_post_meta( $post->ID, 'ship', true ) ?: 0 );        
        if($ship) {
            $query_args['meta_query']['ship'] = array(
                'key' => 'ship',
                'value' => $ship,
            );
        }
        if( $post->post_type == 'suite' ) {
            $query_args['post__not_in'] = array($post->ID);
        }

		if ( '' !== $args['include_categories'] ) {
			$query_args['cat'] = $args['include_categories'];
		}

		if ( 'date_desc' !== $args['orderby'] ) {
			switch ( $args['orderby'] ) {
				case 'date_asc':
					$query_args['orderby'] = 'date';
					$query_args['order'] = 'ASC';
					break;
				case 'title_asc':
					$query_args['orderby'] = 'title';
					$query_args['order'] = 'ASC';
					break;
				case 'title_desc':
					$query_args['orderby'] = 'title';
					$query_args['order'] = 'DESC';
					break;
				case 'rand':
					$query_args['orderby'] = 'rand';
					break;
			}
		}
        //d($query_args);
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
				}d($query->posts[ $post_index ]->ID);

				$query->posts[ $post_index ]->post_featured_image = esc_url( wp_get_attachment_url( get_post_thumbnail_id() ) );
				$query->posts[ $post_index ]->has_post_thumbnail  = has_post_thumbnail();
				$query->posts[ $post_index ]->post_permalink      = get_the_permalink();
				$query->posts[ $post_index ]->post_author_url     = get_author_posts_url( $post_author_id );
				$query->posts[ $post_index ]->post_author_name    = get_the_author_meta( 'display_name', $post_author_id );
				$query->posts[ $post_index ]->post_date_readable  = get_the_date();
				$query->posts[ $post_index ]->categories          = $categories;
				$query->posts[ $post_index ]->post_comment_popup  = sprintf( esc_html( _nx( '%s Comment', '%s Comments', get_comments_number(), 'number of comments', 'et_builder' ) ), number_format_i18n( get_comments_number() ) );

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
						$more = 1;

						$builder_post_content = et_is_builder_plugin_active() ? do_shortcode( $post_content ) : apply_filters( 'the_content', $post_content );

						// Overwrite default content, in case the content is protected
						$query->posts[ $post_index ]->post_content = $builder_post_content;
					} else {
						$more = null;

						// Overwrite default content, in case the content is protected
						$query->posts[ $post_index ]->post_content = et_is_builder_plugin_active() ? do_shortcode( get_the_content( '' ) ) : apply_filters( 'the_content', get_the_content( '' ) );
					}
				} else {
					if ( has_excerpt() && 'off' !== $args['use_manual_excerpt'] ) {
						$query->posts[ $post_index ]->post_content =  et_is_builder_plugin_active() ? do_shortcode( et_strip_shortcodes( get_the_excerpt(), true ) ) : apply_filters( 'the_content', et_strip_shortcodes( get_the_excerpt(), true ) );
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
			$query  = '<div class="et_pb_no_results">';
			$query .= self::get_no_results_template();
			$query .= '</div>';

			$query = array( 'posts' => $query );
		}

		return $query;
	}

    function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id               = $this->shortcode_atts['module_id'];
		$module_class            = $this->shortcode_atts['module_class'];
		$show_arrows             = $this->shortcode_atts['show_arrows'];
		$show_pagination         = $this->shortcode_atts['show_pagination'];
		$parallax                = $this->shortcode_atts['parallax'];
		$parallax_method         = $this->shortcode_atts['parallax_method'];
		$auto                    = $this->shortcode_atts['auto'];
		$auto_speed              = $this->shortcode_atts['auto_speed'];
		$auto_ignore_hover       = $this->shortcode_atts['auto_ignore_hover'];
		$body_font_size          = $this->shortcode_atts['body_font_size'];
		$show_content_on_mobile  = $this->shortcode_atts['show_content_on_mobile'];
		$show_cta_on_mobile      = $this->shortcode_atts['show_cta_on_mobile'];
		$show_image_video_mobile = $this->shortcode_atts['show_image_video_mobile'];
		$background_position     = $this->shortcode_atts['background_position'];
		$background_size         = $this->shortcode_atts['background_size'];
		$background_repeat       = $this->shortcode_atts['background_repeat'];
		$background_blend        = $this->shortcode_atts['background_blend'];
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
		$use_bg_overlay          = $this->shortcode_atts['use_bg_overlay'];
		$bg_overlay_color        = $this->shortcode_atts['bg_overlay_color'];
		$use_text_overlay        = $this->shortcode_atts['use_text_overlay'];
		$text_overlay_color      = $this->shortcode_atts['text_overlay_color'];
		$orderby                 = $this->shortcode_atts['orderby'];
		$show_meta               = $this->shortcode_atts['show_meta'];
		$button_custom           = $this->shortcode_atts['custom_button'];
		$custom_icon             = $this->shortcode_atts['button_icon'];
		$use_manual_excerpt      = $this->shortcode_atts['use_manual_excerpt'];
		$excerpt_length          = $this->shortcode_atts['excerpt_length'];
		$text_border_radius      = $this->shortcode_atts['text_border_radius'];
		$dot_nav_custom_color    = $this->shortcode_atts['dot_nav_custom_color'];
		$arrows_custom_color     = $this->shortcode_atts['arrows_custom_color'];
		$button_rel              = $this->shortcode_atts['button_rel'];
		$header_level            = $this->shortcode_atts['header_level'];
        
        $post_type               = $this->shortcode_atts['post_type'];
        if(empty($post_type)) {
            $post_type = 'post';
        }

		$post_index = 0;

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		$is_text_overlay_applied = 'on' === $use_text_overlay;

		$hide_on_mobile_class = self::HIDE_ON_MOBILE;

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

		$fullwidth = 'et_pb_fullwidth_slider' === $function_name ? 'on' : 'off';

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

		$data_dot_nav_custom_color = '' !== $dot_nav_custom_color
			? sprintf( ' data-dots_color="%1$s"', esc_attr( $dot_nav_custom_color ) )
			: '';

		$data_arrows_custom_color = '' !== $arrows_custom_color
			? sprintf( ' data-arrows_color="%1$s"', esc_attr( $arrows_custom_color ) )
			: '';

		$video_background = $this->video_background();
		$parallax_image_background = $this->get_parallax_image_background();

		ob_start();

		// Re-used self::get_blog_posts() for builder output
		$query = self::get_blog_posts(array(
            'post_type'          => $post_type,
			'posts_number'       => $posts_number,
			'include_categories' => $include_categories,
			'orderby'            => $orderby,
			'content_source'     => $content_source,
			'use_manual_excerpt' => $use_manual_excerpt,
			'excerpt_length'     => $excerpt_length,
		), array(), array(), false );
        
        $post_title = array();

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();

				$slide_class = 'off' !== $show_image && in_array( $image_placement, array( 'left', 'right' ) ) && has_post_thumbnail() ? ' et_pb_slide_with_image' : '';
				$slide_class .= 'off' !== $show_image && ! has_post_thumbnail() ? ' et_pb_slide_with_no_image' : '';
				$slide_class .= " et_pb_bg_layout_{$background_layout}";
                
                $post_title[$post_index] = get_the_title();
			?>
			<div class="et_pb_slide et_pb_media_alignment_center<?php echo esc_attr( $slide_class ); ?>" <?php echo $data_dot_nav_custom_color; echo $data_arrows_custom_color; ?>>
				<div class="et_pb_container clearfix">
					<div class="et_pb_slider_container_inner">
						<div class="et_pb_slide_description">
							<?php if ( false && $is_text_overlay_applied ) : ?><div class="et_pb_text_overlay_wrapper"><?php endif; ?>

    							<div class="et_pb_slide_image2">
    								<?php
                                        $image_id = get_post_meta(get_the_ID(), 'images', true) ?: 0;
                                        if($image_id) {
                                            //suite
                                            $src = $this->get_attachment_image_src($image_id, 'suite');
                                            printf('<img src="%s" alt="%s" />', $src, get_the_title());
                                        }
                                        else {
                                            the_post_thumbnail();
                                        }
                                    ?>
    							</div>
    							<div class="our-suite-content-text">
									<<?php echo et_pb_process_header_level( $header_level, 'h2' ) ?> class="et_pb_slide_title"><a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a></<?php echo et_pb_process_header_level( $header_level, 'h2' ) ?>>
									<div class="et_pb_slide_content <?php if ( 'on' !== $show_content_on_mobile ) { echo esc_attr( $hide_on_mobile_class ); } ?>">
										<?php
										if ( false && 'off' !== $show_meta ) {
											printf(
												'<p class="post-meta">%1$s | %2$s | %3$s | %4$s</p>',
												et_get_safe_localization( sprintf( __( 'by %s', 'et_builder' ), '<span class="author vcard">' .  et_pb_get_the_author_posts_link() . '</span>' ) ),
												et_get_safe_localization( sprintf( __( '%s', 'et_builder' ), '<span class="published">' . esc_html( get_the_date() ) . '</span>' ) ),
												get_the_category_list(', '),
												sprintf( esc_html( _nx( '%s Comment', '%s Comments', get_comments_number(), 'number of comments', 'et_builder' ) ), number_format_i18n( get_comments_number() ) )
											);
										}
										?>
										<?php
											echo $query->posts[ $post_index ]->post_content;
										?>
									</div>
								</div>
							<?php if ( false && $is_text_overlay_applied ) : ?></div><?php endif; ?>
							<?php if ( false && 'off' !== $show_more_button && '' !== $more_text ) {
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
						<?php if ( false && 'off' !== $show_image && has_post_thumbnail() && 'bottom' === $image_placement ) { ?>
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
			$content  = '<div class="et_pb_no_results">';
			$content .= self::get_no_results_template();
			$content .= '</div>';
		}

		// Images: Add CSS Filters and Mix Blend Mode rules (if set)
		if ( array_key_exists( 'image', $this->advanced_options ) && array_key_exists( 'css', $this->advanced_options['image'] ) ) {
			$module_class .= $this->generate_css_filters(
				$function_name,
				'child_',
				self::$data_utils->array_get( $this->advanced_options['image']['css'], 'main', '%%order_class%%' )
			);
		}
        $control_title = '';
        foreach($post_title as $post_index => $title) {
            $c = $post_index == 0 ? 'et-pb-active-control' : '';
            $control_title .= sprintf('<a href="#" data-index="%d" class="%s">%s</a>', $post_index, $c, $title);
        }
        if($control_title) {
            $control_title = '<div class="et-pb-title-controllers">'.$control_title.'</div>';
        }

		$output = sprintf(
			'<div%3$s class="et_pb_module et_pb_slider et_pb_post_slider%1$s%4$s%5$s%7$s">
				%8$s
				%6$s
				<div class="et_pb_slides">
					%2$s
				</div> <!-- .et_pb_slides -->
				%10$s
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
			$this->inner_shadow_back_compatibility( $function_name ),
            $control_title
		);
        d($post_title);

		return $output;
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
    
    function get_attachment_image_src( $att_id, $image_size ) {
        if( function_exists( 'fly_get_attachment_image_src' ) ) {
            $image = fly_get_attachment_image_src( $att_id, $image_size );
            return $image['src'];
        }
        return 'fly_get_attachment_image_src';
    }
}
new Custom_Our_Suites;