<?php

class CC_Custom_Tour_Page extends Custom_Post {
	function init() {
		parent::init();
		$this->name = __('CC Custom Tour Page', 'liva-divi');
		$this->slug = 'et_pb_cc_custom_tour_page';
		$this->fb_support = true;
		$this->whitelisted_fields[] = 'post_type';
		$this->whitelisted_fields[] = 'more_text';
		$this->whitelisted_fields[] = 'show_more_posts';
		$this->whitelisted_fields[] = 'number_posts_more';
		$this->whitelisted_fields[] = 'display_content';
		$this->whitelisted_fields[] = 'filter_url';
		$this->fields_defaults['more_text'] = array('Read More');
		$this->fields_defaults['display_content'] = array('on');
		$this->fields_defaults['show_more_posts'] = array('on');
		$this->fields_defaults['filter_url'] = array('on');
		// need to use global settings from the slider module
// 		$this->global_settings_slug = 'et_pd_custom_post_slider';
	}

	function get_fields() {
		$fields = parent::get_fields();
		$fields['show_more_posts'] = array(
			'label' => esc_html__('Show more posts', 'liva-divi'),
			'type' => 'yes_no_button',
			'option_category' => 'configuration',
			'options' => array(
				'off' => esc_html__('No', 'et_builder'),
				'on' => esc_html__('Yes', 'et_builder'),
			),
			'toggle_slug' => 'main_content',
		);
		$fields['number_posts_more'] = array(
			'label' => esc_html__('Number posts more', 'liva-divi'),
			'type' => 'text',
			'option_category' => 'configuration',
			'options' => array(
				'off' => esc_html__('No', 'et_builder'),
				'on' => esc_html__('Yes', 'et_builder'),
			),
			'toggle_slug' => 'main_content',
		);

		$fields['filter_url'] = array(
			'label' => esc_html__('Filter Url', 'liva-divi'),
			'type' => 'yes_no_button',
			'option_category' => 'configuration',
			'options' => array(
				'off' => esc_html__('No', 'et_builder'),
				'on' => esc_html__('Yes', 'et_builder'),
			),
			'toggle_slug' => 'main_content',
		);

		return $fields;
	}

	function shortcode_callback($atts, $content = null, $function_name) {

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

		$module_id = $this->shortcode_atts['module_id'];
		$module_class = $this->shortcode_atts['module_class'];
		$fullwidth = $this->shortcode_atts['fullwidth'];
		$posts_number = $this->shortcode_atts['posts_number'];
		$include_categories = $this->shortcode_atts['include_categories'];
		$meta_date = $this->shortcode_atts['meta_date'];
		$show_thumbnail = $this->shortcode_atts['show_thumbnail'];
		$show_content = $this->shortcode_atts['show_content'];
		$show_author = $this->shortcode_atts['show_author'];
		$show_date = $this->shortcode_atts['show_date'];
		$show_categories = $this->shortcode_atts['show_categories'];
		$show_comments = $this->shortcode_atts['show_comments'];
		$show_pagination = $this->shortcode_atts['show_pagination'];
		$background_layout = $this->shortcode_atts['background_layout'];
		$show_more = $this->shortcode_atts['show_more'];
		$offset_number = $this->shortcode_atts['offset_number'];
		$masonry_tile_background_color = $this->shortcode_atts['masonry_tile_background_color'];
		$overlay_icon_color = $this->shortcode_atts['overlay_icon_color'];
		$hover_overlay_color = $this->shortcode_atts['hover_overlay_color'];
		$hover_icon = $this->shortcode_atts['hover_icon'];
		$use_overlay = $this->shortcode_atts['use_overlay'];
		$header_level = $this->shortcode_atts['header_level'];
		$more_text = $this->shortcode_atts['more_text'];
		$display_content = $this->shortcode_atts['display_content'];
		$show_more_posts = $this->shortcode_atts['show_more_posts'];
		$number_posts_more = $this->shortcode_atts['number_posts_more'];
		$more_text = apply_filters('custom_post_more_text', $more_text, $module_id);
		$show_more_posts = apply_filters('show_more_posts', $show_more_posts, $module_id);
		$enable_filter_url	= $this->shortcode_atts['filter_url'];

		global $paged;

		$module_class = ET_Builder_Element::add_module_order_class($module_class, $function_name);
		$video_background = $this->video_background();
		$parallax_image_background = $this->get_parallax_image_background();

		$container_is_closed = false;

		$processed_header_level = et_pb_process_header_level($header_level, 'h2');

		// some themes do not include these styles/scripts so we need to enqueue them in this module to support audio post format
		wp_enqueue_style('wp-mediaelement');
		wp_enqueue_script('wp-mediaelement');

		// include easyPieChart which is required for loading Blog module content via ajax correctly
		wp_enqueue_script('easypiechart');

		// include ET Shortcode scripts
		wp_enqueue_script('et-shortcodes-js');

		// remove all filters from WP audio shortcode to make sure current theme doesn't add any elements into audio module
		remove_all_filters('wp_audio_shortcode_library');
		remove_all_filters('wp_audio_shortcode');
		remove_all_filters('wp_audio_shortcode_class');

		wp_enqueue_style('cc-style', plugins_url('/css/cc-style.css', __FILE__));
		wp_enqueue_style('jquery-range', plugins_url('/css/jquery.range.css', __FILE__));

		wp_enqueue_script('jquery-range', plugins_url('/js/jquery.range-min.js', __FILE__), array('jquery'), false, true);
		wp_enqueue_script('amyui-fancy-select', plugins_url('/js/amyui-fancy-select.js', __FILE__), array('jquery'), false, true);
		wp_enqueue_script('cc-tour-script', plugins_url('/js/cc-tour-script.js', __FILE__), array('jquery'), false, true);

		wp_localize_script('cc-tour-script', 'cc_script', array(
			'ajax_url' 				=> admin_url('admin-ajax.php'),
			'price_val'				=> esc_html__('$', 'liva-divi'),
			'duration_label'		=> esc_html__('days', 'liva-divi'),
			'filter_url'			=> $enable_filter_url
		));

		if (get_query_var('type_of_tour') && get_query_var('type_of_tour') != '') {
			global $wp;
			$current_url = home_url('/') . $wp->request;
		} else {
			$current_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] . 'filter/type_of_tour/category_destination/travel_style/tour_guide/duration/price_range/per_page/sort_by/search/departure';
		}

		$params = array();

		if (get_query_var('type_of_tour') && get_query_var('type_of_tour') != 'type_of_tour') {
			$query_url_type_of_tour = get_query_var('type_of_tour');
		} else {
			$query_url_type_of_tour = '';
		}

		if (get_query_var('category_destination') && get_query_var('category_destination') != 'category_destination') {
			$query_url_category_destination = get_query_var('category_destination');
		} else {
			$query_url_category_destination = '';
		}

		if (get_query_var('travel_style') && get_query_var('travel_style') != 'travel_style') {
			$query_url_travel_style = get_query_var('travel_style');
		} else {
			$query_url_travel_style = '';
		}

		if (get_query_var('tour_guide') && get_query_var('tour_guide') != 'tour_guide') {
			$query_url_tour_guide	= get_query_var('tour_guide');
		} else {
			$query_url_tour_guide 	= '';
		}

		if (get_query_var('duration') && get_query_var('duration') != 'duration') {
			$query_url_duration_tour	= get_query_var('duration');
		} else {
			$query_url_duration_tour	= '';
		}

		if (get_query_var('price_range') && get_query_var('price_range') != 'price_range') {
			$query_url_price_range	= get_query_var('price_range');
		} else {
			$query_url_price_range	= '';
		}

		if (get_query_var('per_page') && get_query_var('per_page') != 'per_page') {
			$query_url_per_page		= get_query_var('per_page');
		} else {
			$query_url_per_page		= '';
		}

		if (get_query_var('sort_by') && get_query_var('sort_by') != 'sort_by') {
			$query_url_sort_by	= get_query_var('sort_by');
		} else {
			$query_url_sort_by	= '';
		}

		if (get_query_var('search') && get_query_var('search') != 'search') {
			$params['s_tour'] = get_query_var('search');
			$query_url_search	= get_query_var('search');
		} else {
			$query_url_search	= '';
		}

		if (get_query_var('departure') && get_query_var('departure') != 'departure') {
			$query_url_departure	= get_query_var('departure');
		} else {
			$query_url_departure	= '';
		}

		$params['type_of_tour'] 		= $query_url_type_of_tour;
		$params['category_destination'] = $query_url_category_destination;
		$params['travel_style']			= $query_url_travel_style;
		$params['tour_guide']			= $query_url_tour_guide;
		$params['duration_tour']		= $query_url_duration_tour;
		$params['filter_price']			= $query_url_price_range;
		$params['sort_by']				= $query_url_sort_by;
		$params['posts_per_page']		= $query_url_per_page;
		$params['s_tour']				= $query_url_search;
		$params['departure']			= $query_url_departure;


		$args = cc_tour_build_query($params);

		$et_paged = is_front_page() ? get_query_var('page') : get_query_var('paged');

		if (is_front_page()) {
			$paged = $et_paged;
		}

		ob_start();

		$cc_tour_query 	= new WP_Query($args);
		$data			= $cc_tour_query->posts;
		$max			= intval($cc_tour_query->max_num_pages);
		$found_post		= $cc_tour_query->found_posts;

		global $wp;

		$output = array();

		//begin
		$output[] = '<div class="cc-tour-page">';
		$output[] = '<input type="hidden" value="' . $current_url . '" class="current_url"/>';
		$output[] = '<div class="row">';

		//begin left content
		$output[] = '<div class="col-md-3 col-sm-4">';

		//search
		$output[] = '<div class="cc-search">';
		$output[] = '<h3>' . esc_html__('Search', 'liva-divi') . '</h3>';
		$output[] = '<input type="text" name="s_tour" placeholder="' . esc_html__('Type keyword', 'liva-divi') . '"/>';
		$output[] = '</div>';

		//begin filter
		if (array_key_exists('type_of_tour', $_GET) || array_key_exists('category_destination', $_GET) || array_key_exists('travel_style', $_GET) || array_key_exists('duration_tour', $_GET) || array_key_exists('highlight', $_GET) || array_key_exists('departure', $_GET) || array_key_exists('tour_guide', $_GET)) {
			$class_filter = 'has-checked';
		} else {
			$class_filter = '';
		}

		$output[] = '<div class="cc-filter-all ' . $class_filter . '">';

		//price
		$output[] = cc_custom_tour_page_filter_by_price();

		//type of tour
		$output[] = cc_custom_tour_page_filter_type_of_tour();

		//destination
		$output[] = cc_custom_tour_page_filter_destination();

		//travel style
		$output[] = cc_custom_tour_page_filter_travel_style();

		//duration tour
		$output[] = cc_custom_tour_page_filter_duration_tour();

		//tour guide
		$output[] = cc_custom_tour_page_filter_tour_guide();

		//departure
		$output[] = cc_custom_tour_page_filter_departure();

		//end filter
		$output[] = '</div>';

		//end left content
		$output[] = '</div>';


		//begin right content
		$output[] = '<div class="col-md-9 col-sm-8">';

		//begin top action
		$output[] = '<div class="cc-top-action"><div class="row">';

		//result founds
		$output[] = '<div class="col-md-2 col-sm-2"><div class="cc-result-found results-found">';
		$output[] = esc_html__('Results:','liva-divi').'<span class="total_posts"> '. $found_post.'<span>';
		$output[] = '</div></div>';

		//post per page
		$output[] = '<div class="col-md-3 col-sm-3"><div class="cc-per-page">';
		$output[] = '<span>' . esc_html__('View:', 'liva-divi') . '</span>';
		$output[] = '<select class="cc-select" name="post_per_page">
					<option value="9">' . esc_html__('9', 'liva-divi') . '</option>
					<option value="18">' . esc_html__('18', 'liva-divi') . '</option>
					<option value="27">' . esc_html__('27', 'liva-divi') . '</option>
					<option value="36">' . esc_html__('36', 'liva-divi') . '</option>
					<option value="45">' . esc_html__('45', 'liva-divi') . '</option>
				</select>';

		$output[] = '<span>' . esc_html__('per page', 'liva-divi') . '</span>';
		$output[] = '</div></div>';

		//sort by
		$output[] = '<div class="col-md-7 col-sm-7"><div class="cc-sort-by">';
		$output[] = '<span>' . esc_html__('Sort By:', 'liva-divi') . '</span>';
		$output[] = '<select class="cc-select" name="sort_by">
					<option value="view-count">' . esc_html__('Most popular', 'liva-divi') . '</option>
					<option value="price-asc">' . esc_html__('Price Low to high', 'liva-divi') . '</option>
					<option value="price-desc">' . esc_html__('Price High to low', 'liva-divi') . '</option>
					<option value="position">' . esc_html__('Suggested experiences', 'liva-divi') . '</option>
				</select>';
		$output[] = '</div></div>';

		//end top action
		$output[] = '</div></div>';

		//begin result filter
		$output[] = '<div class="cc-result-filter">';
		$output[] = '<h3 class="n">' . esc_html__('Filtered by: ', 'liva-divi') . '</h3>';

		$output[] = '<div class="result-filter-content">';

		//tour filter
		$cf_type_of_tour = $query_url_type_of_tour ? 'has-content' : 'no-content';

		$output[] = '<div class="r-f r-f_type_of_tour ' . $cf_type_of_tour . '" id="cc-type_of_tour">';
		$output[] = '<h5>' . esc_html__('Tour:', 'liva-divi') . '</h5>';

		if ($query_url_type_of_tour) {
			$arr_f_type_of_tour = explode('+', $query_url_type_of_tour);

			if (!empty($arr_f_type_of_tour)) {
				foreach ($arr_f_type_of_tour as $f) {
					$t = get_term_by('slug', $f, 'type_of_tour');
					$output[] = '<div class="r-c" id="cc-' . $f . '">' . $t->name . '<span>x</span></div>';
				}
			}
		}

		$output[] = '</div>';

		//destination filter
		if (get_query_var('category_destination') && get_query_var('category_destination') != 'category_destination') {
			$c_class = 'has-content';
		} else {
			$c_class = 'no-content';
		}

		$cf_category_destination = $query_url_category_destination ? 'has-content' : 'no-content';
		$output[] = '<div class="r-f r-f_category_destination ' . $cf_category_destination . '" id="cc-category_destination">';
		$output[] = '<h5>' . esc_html__('Destination:', 'liva-divi') . '</h5>';

		if ($query_url_category_destination) {
			$arr_f_category_destination = explode('+', $query_url_category_destination);

			if (!empty($arr_f_category_destination)) {
				foreach ($arr_f_category_destination as $f) {
					$t = get_term_by('slug', $f, 'category-destination');
					$output[] = '<div class="r-c" id="cc-' . $f . '">' . $t->name . '<span>x</span></div>';
				}
			}
		}

		$output[] = '</div>';

		//travel style filter
		$cf_travel_style = $query_url_travel_style ? 'has-content' : 'no-content';
		$output[] = '<div class="r-f r-f_travel_style ' . $cf_travel_style . '" id="cc-travel_style">';
		$output[] = '<h5>' . esc_html__('Experience:', 'liva-divi') . '</h5>';

		if ($query_url_travel_style) {
			$arr_f_travel_style = explode('+', $query_url_travel_style);

			if (!empty($arr_f_travel_style)) {
				foreach ($arr_f_travel_style as $f) {
					$t = get_term_by('slug', $f, 'travel_style');
					$output[] = '<div class="r-c" id="cc-' . $f . '">' . $t->name . '<span>x</span></div>';
				}
			}
		}

		$output[] = '</div>';

		//tour guide filter
		if (get_query_var('tour_guide') && get_query_var('tour_guide') != 'tour_guide') {
			$g_class = 'has-content';
		} else {
			$g_class = 'no-content';
		}

		$cf_tour_guide	= $query_url_tour_guide ? 'has-content' : 'no-content';
		$output[] = '<div class="r-f r-f_tour_guide ' . $cf_tour_guide . '" id="cc-tour_guide">';
		$output[] = '<h5>' . esc_html__('Tour Guide:', 'liva-divi') . '</h5>';
		if ($query_url_tour_guide) {
			$arr_f_tour_guide = explode('+', $query_url_tour_guide);

			if (!empty($arr_f_tour_guide)) {
				foreach ($arr_f_tour_guide as $f) {
					$t = get_term_by('slug', $f, 'tour_guide');
					$output[] = '<div class="r-c" id="cc-' . $f . '">' . $t->name . '<span>x</span></div>';
				}
			}
		}
		$output[] = '</div>';

		//duration filter
		$cf_duration = $query_url_duration_tour ? 'has-content' : 'no-content';
		$output[] = '<div class="r-f r-f_duration_tour ' . $cf_duration . '" id="cc-duration_tour">';
		$output[] = '<h5>' . esc_html__('Duration:', 'liva-divi') . '</h5>';
		if ($query_url_duration_tour) {
			$arr_f_duration = str_replace('day', '', $query_url_duration_tour);
			$arr_f_duration = explode('-', $arr_f_duration);

			if (!empty($arr_f_duration)) {
				$str_duration = $arr_f_duration[0] . esc_html__('day', 'liva-divi') . ' - ' . $arr_f_duration[1] . esc_html__('day', 'liva-divi');

				$output[] = '<div class="r-c" id="cc-' . $query_url_duration_tour . '">' . $str_duration . '<span>x</span></div>';
			}
		}

		$output[] = '</div>';

		//price filter
		$cf_price = $query_url_price_range ? 'has-content' : 'no-content';
		$output[] = '<div class="r-f r-f_price ' . $cf_price . '" id="cc-f_price">';
		$output[] = '<h5>' . esc_html__('Price:', 'liva-divi') . '</h5>';
		if ($query_url_price_range) {
			$arr_f_price_ranger = str_replace('$', '', $query_url_price_range);
			$arr_f_price_ranger = explode('-', $arr_f_price_ranger);

			if (!empty($arr_f_price_ranger)) {
				$str_price_ranger = esc_html__('$', 'liva-divi') . $arr_f_price_ranger[0] . ' - ' . esc_html__('$', 'liva-divi') . $arr_f_price_ranger[1];

				$output[] = '<div class="r-c" id="cc-' . $query_url_price_range . '">' . $str_price_ranger . '<span>x</span></div>';
			}
		}
		$output[] = '</div>';

		//departure filter
		$output[] = '<div class="r-f r-f_departure no-content" id="cc-f_departure">';
		$output[] = '<h5>' . esc_html__('Departure:', 'liva-divi') . '</h5>';
		$output[] = '</div>';

		//filter all
		//if ()
		//$output[] = '<div class="cc-clear-all">';
		//$output[] = '<span>' . esc_html__('Clear all', 'liva-divi') . '</span>';
		//$output[] = '</div>';


		$output[] = '</div>';

		//end result filter
		$output[] = '</div>';

		//begin tour content
		$output[] = '<div class="cc-tour-content" id="tours_travel_style">';

		ob_start();

		cc_custom_tour_page_data_content($data, $max, $current_url);

		$output[] = ob_get_clean();

		//end tour content
		$output[] = '</div>';

		//end right content
		$output[] = '</div>';

		//end
		$output[] = '</div></div>';


		// Restore $wp_filter
		$wp_filter = $wp_filter_cache;
		unset($wp_filter_cache);

		// Restore global $post into its original state when et_pb_blog shortcode ends to avoid
		// the rest of the page uses incorrect global $post variable
		$post = $post_cache;

		return implode('', $output);
	}
}

new CC_Custom_Tour_Page;

if (!function_exists('cc_custom_tour_page_filter_by_price')) {
	function cc_custom_tour_page_filter_by_price() {
		$output = array();

		$output[] = '<div class="cc-filters cc-price-filter active">';
		$output[] = '<h3>' . esc_html__('Price(per person)', 'liva-divi') . '</h3>';

		$output[] = '<div class="cc-single-filter">';

		$output[] = '<input type="hidden" class="cc-ranger-slide cc-price" value="1" name="price[]"/>';

		$output[] = '</div>';

		//end type of tour
		$output[] = '</div>';

		return implode('', $output);
	}
}

if (!function_exists('cc_custom_tour_page_filter_type_of_tour')) {
	function cc_custom_tour_page_filter_type_of_tour() {
		$output 		= array();

		if (get_query_var('type_of_tour') && get_query_var('type_of_tour') != 'type_of_tour') {
			$check_query 	= explode('+', get_query_var('type_of_tour'));
			$class			= 'active';
		} else {
			$check_query = array();
			$class			= '';
		}

		//type of tour
		$output[] = '<div class="cc-filters cc-type-of-tour ' . $class . '">';
		$output[] = '<h3>' . esc_html__('Type of tour', 'liva-divi') . '</h3>';

		$output[] = '<div class="cc-single-filter">';

		$type_of_tour = array(
			'private-tours'	=> esc_html__('Private tours', 'liva-divi'),
			'group-tours'	=> esc_html__('Group tours', 'liva-divi'),
			'excursions'	=> esc_html__('Excursions', 'liva-divi')
		);

		if (!empty($type_of_tour)) {
			foreach ($type_of_tour as $key => $value) {
				if ($key == 'tour') {
					continue;
				}

				if (in_array($key, $check_query)) {
					$checked = 'checked';
				} else {
					$checked = '';
				}

				$output[] = '<div><input ' . $checked . ' type="checkbox" data-s="' . $value . '" value="' . $key . '" name="type_of_tour[]"/><span>' . $value . '</span></div>';
			}
		}

		$output[] = '</div>';

		//end type of tour
		$output[] = '</div>';

		return implode('', $output);
	}
}

if (!function_exists('cc_custom_tour_page_filter_destination')) {
	function cc_custom_tour_page_filter_destination() {
		$output 		= array();

		if (get_query_var('category_destination') && get_query_var('category_destination') != 'category_destination') {
			$check_query 	= explode('+', get_query_var('category_destination'));
			$class			= 'active';
		} else {
			$check_query = array();
			$class			= '';
		}


		//destination
		$output[] = '<div class="cc-filters cc-destination ' . $class . '">';
		$output[] = '<h3>' . esc_html__('Destination', 'liva-divi') . '</h3>';

		$output[] = '<div class="cc-single-filter">';

		$destination = get_terms(array(
			'taxonomy' => 'category-destination',
			'hide_empty' => false,
			'parent' => 0
		));

		if (!empty($destination)) {
			foreach ($destination as $s) {
				if (in_array($s->slug, $check_query)) {
					$checked = 'checked';
				} else {
					$checked = '';
				}

				$output[] = '<div class="parent-destination">';
				$output[] = '<input type="checkbox" ' . $checked . ' value="' . $s->slug . '" data-s="' . $s->name . '" name="category_destination[]"/><span>' . $s->name . '</span>';

				$childs = get_terms(array(
					'taxonomy' => 'category-destination',
					'hide_empty' => false,
					'parent' => $s->term_id
				));

				if (!empty($childs)) {
					$output[] = '<span class="open">+</span>';
					$output[] = '<span class="close">-</span>';
					$output[] = '<div class="child-parent-destination">';

					foreach ($childs as $c) {
						if (in_array($c->slug, $check_query)) {
							$checked = 'checked';
						} else {
							$checked = '';
						}
						$output[] = '<div><input type="checkbox" ' . $checked . ' value="' . $c->slug . '" data-s="' . $s->name . '" name="category_destination[]"/><span>' . $c->name . '</span></div>';
					}

					$output[] = '</div>';
				}

				$output[] = '</div>';
			}
		}

		$output[] = '</div>';

		//end destination
		$output[] = '</div>';

		return implode('', $output);
	}
}

if (!function_exists('cc_custom_tour_page_filter_travel_style')) {
	function cc_custom_tour_page_filter_travel_style() {
		$output 		= array();

		if (get_query_var('travel_style') && get_query_var('travel_style') != 'travel_style') {
			$check_query 	= explode('+', get_query_var('travel_style'));
			$class			= 'active';
		} else {
			$check_query = array();
			$class			= '';
		}

		$output[] = '<div class="cc-filters cc-travel-style ' . $class . '">';
		$output[] = '<h3>' . esc_html__('Experience', 'liva-divi') . '</h3>';

		$output[] = '<div class="cc-single-filter">';

		$type_of_tour = get_terms(array(
			'taxonomy' => 'travel_style',
			'hide_empty' => false,
		));

		if (!empty($type_of_tour)) {
			foreach ($type_of_tour as $s) {
				if (in_array($s->slug, $check_query)) {
					$checked = 'checked';
				} else {
					$checked = '';
				}

				$output[] = '<div><input type="checkbox" ' . $checked . ' value="' . $s->slug . '" data-s="' . $s->name . '" name="travel_style[]"/><span>' . $s->name . '</span></div>';
			}
		}

		$output[] = '</div>';

		//end type of tour
		$output[] = '</div>';

		return implode('', $output);
	}
}

if (!function_exists('cc_custom_tour_page_filter_duration_tour')) {
	function cc_custom_tour_page_filter_duration_tour() {
		$output 		= array();

		//duration
		$output[] = '<div class="cc-filters cc-duration-tour">';
		$output[] = '<h3>' . esc_html__('Duration', 'liva-divi') . '</h3>';

		$output[] = '<div class="cc-single-filter">';

		$output[] = '<input type="hidden" class="cc-duration" value="1,32" name="duration_tour[]"/>';

		$output[] = '</div>';

		$output[] = '</div>';

		return implode('', $output);
	}
}

if (!function_exists('cc_custom_tour_page_filter_highlight')) {
	function cc_custom_tour_page_filter_highlight() {
		$output 		= array();
		$check_query 	= ($_GET['highlight']) ? explode('.', $_GET['highlight']) : array();

		$output[] = '<div class="cc-filters cc-highlight">';
		$output[] = '<h3>' . esc_html__('Highlight', 'liva-divi') . '</h3>';

		$output[] = '<div class="cc-single-filter">';

		$type_of_tour = get_posts(array(
			'post_type' 		=> 'highlight',
			'posts_per_page'	=> -1
		));

		if (!empty($type_of_tour)) {
			foreach ($type_of_tour as $s) {
				if (in_array($s->ID, $check_query)) {
					$checked = 'checked';
				} else {
					$checked = '';
				}

				$output[] = '<div><input type="checkbox" ' . $checked . ' value="' . $s->ID . '" data-s="' . $s->name . '" name="highlight[]"/><span>' . $s->post_title . '</span></div>';
			}
		}

		$output[] = '</div>';

		//end type of tour
		$output[] = '</div>';

		return implode('', $output);
	}
}

if (!function_exists('cc_custom_tour_page_filter_departure')) {
	function cc_custom_tour_page_filter_departure() {
		$output 		= array();
		$check_query 	= ($_GET['departure']) ? explode('.', $_GET['departure']) : array();

		//type of tour
		$output[] = '<div class="cc-filters cc-departure">';
		$output[] = '<h3>' . esc_html__('Departure', 'liva-divi') . '</h3>';

		$output[] = '<div class="cc-single-filter">';

		$output[] = '<h4>' . esc_html__('Depature Date', 'liva-divi') . '</h4>';
		$output[] = '<ul class="cc-departure-month">';

		for ($i = 0; $i < 12; $i++) {
			$output[] = '<li data-d="' . date("m-Y", strtotime( date( 'Y-m-01' )." + $i months")) . '">';
			$output[] = date("M Y", strtotime( date( 'Y-m-01' )." + $i months"));
			$output[] = '</li>';
		}

		$output[] = '</ul>';

		$output[] = '<h4>' . esc_html__('Depature Between', 'liva-divi') . '</h4>';

		$output[] = '<div class="cc-departure-date">';
		$output[] = '<input type="text" name="cc_start_date" class="cc_date_picker cc_start_date" placeholder="' . esc_html__('Start Date', 'liva-divi') . '" />';
		$output[] = '<svg viewBox="0 0 1000 1000" class="t084-arrow"><path d="M694.4 242.4l249.1 249.1c11 11 11 21 0 32L694.4 772.7c-5 5-10 7-16 7s-11-2-16-7c-11-11-11-21 0-32l210.1-210.1H67.1c-13 0-23-10-23-23s10-23 23-23h805.4L662.4 274.5c-21-21.1 11-53.1 32-32.1z"></path></svg>';
		$output[] = '<input type="text" name="cc_end_date" class="cc_date_picker cc_end_date" placeholder="' . esc_html__('End Date', 'liva-divi') . '" />';
		$output[] = '</div>';

		$output[] = '</div>';

		//end type of tour
		$output[] = '</div>';

		return implode('', $output);
	}
}

if (!function_exists('cc_custom_tour_page_filter_tour_guide')) {
	function cc_custom_tour_page_filter_tour_guide() {
		$output 		= array();

		if (get_query_var('tour_guide') && get_query_var('tour_guide') != 'tour_guide') {
			$check_query 	= explode('+', get_query_var('tour_guide'));
			$class			= 'active';
		} else {
			$check_query = array();
			$class			= '';
		}

		//type of tour
		$output[] = '<div class="cc-filters cc-tour-guide ' . $class . '">';
		$output[] = '<h3>' . esc_html__('Guide language', 'liva-divi') . '</h3>';

		$output[] = '<div class="cc-single-filter">';

		$type_of_tour = get_terms(array(
			'taxonomy' => 'tour_guide',
			'hide_empty' => false,
		));

		if (!empty($type_of_tour)) {
			foreach ($type_of_tour as $s) {
				if (in_array($s->slug, $check_query)) {
					$checked = 'checked';
				} else {
					$checked = '';
				}

				$output[] = '<div><input type="checkbox" ' . $checked . ' value="' . $s->slug . '" data-s="' . $s->name . '" name="tour_guide[]" /><span>' . $s->name . '</span></div>';
			}
		}

		$output[] = '</div>';

		//end type of tour
		$output[] = '</div>';

		return implode('', $output);
	}
}



