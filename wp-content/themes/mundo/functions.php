<?php
/**
 * Theme functions and definitions
 *
 * @package divi-child
 * @since Divi 1.0
 */
function remove_divi_projects(){
unregister_post_type( 'project' );
}
add_action('init','remove_divi_projects');
require_once 'shortcodes/shortcodes.php';
require_once 'cc-func.php';
add_action('admin_enqueue_scripts', function(){
     wp_enqueue_script('my_mundo_script', get_stylesheet_directory_uri() . '/js/admin_mundo.js');
});
add_action( 'wp_enqueue_scripts', function() {
	
    wp_register_style( 'jquery-ui', 'https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.min.css' );
    wp_enqueue_style( 'jquery-ui' );
    wp_enqueue_style( 'bootstrap-style', get_stylesheet_directory_uri() . '/bootstrap/css/bootstrap.css' );
    wp_enqueue_style( 'bootstrap-min-style', get_stylesheet_directory_uri() . '/bootstrap/css/bootstrap.min.css' );
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'divi-style', get_stylesheet_directory_uri() . '/style.css', array(), rand() );
    wp_enqueue_style( 'style-person2', get_stylesheet_directory_uri() . '/style2.css', array(), rand() );
    wp_enqueue_style( 'style-excursion', get_stylesheet_directory_uri() . '/style_excursion.css', array(), rand() );
    wp_enqueue_style('reponsive_css', get_stylesheet_directory_uri() .'/reponsive.css');   
    wp_enqueue_style('reponsive_css_ipad', get_stylesheet_directory_uri() .'/reponsive-ipad.css');   
    wp_enqueue_style('select2_css', get_stylesheet_directory_uri() .'/js/select2-4.0.4/dist/css/select2.min.css');  

    
    wp_enqueue_script('slider-jssor', get_stylesheet_directory_uri() . '/js/jssor.slider-27.1.0.min.js');
    wp_enqueue_script('jquery-1', get_stylesheet_directory_uri() . '/js/jquery-1.11.3.min.js');
    
    wp_enqueue_script('bootstrap_js', get_stylesheet_directory_uri() . '/bootstrap/js/bootstrap.min.js');
    wp_enqueue_script( 'select2_js', get_stylesheet_directory_uri() . '/js/select2-4.0.4/dist/js/select2.min.js' );
    wp_enqueue_script( 'map_js', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCk2KOy3Rqcz-Jy7ZMlXeA7cInikpHwMR0&sensor=false&libraries=geometry,places&ext=.js' , array(), rand(), true );
    wp_enqueue_script( 'infobox.js', get_stylesheet_directory_uri() . '/js/infobox.js', array(), rand(), true );
    wp_enqueue_script( 'maps_match-js', get_stylesheet_directory_uri() . '/js/map_match.js', array(), rand(), true );
    wp_enqueue_script( 'cookie-js', get_stylesheet_directory_uri() . '/js/jquery-cookie/jquery.cookie.js', array(), rand(), true );
    wp_enqueue_script( 'jquery-ui-datepicker' );
    wp_enqueue_script('checkvalid_js', get_stylesheet_directory_uri() . '/js/jquery.validate.min.js');
    wp_enqueue_script( 'child-js', get_stylesheet_directory_uri() . '/js/mundo.js', array(), rand(), true );
    wp_add_inline_script( 'child-js', 'var choose_des_home = "'.__('Destinations', 'Mundo').'"');
    wp_add_inline_script( 'child-js', 'var choose_style_home = "'.__('Experiences', 'Mundo').'"');
    wp_add_inline_script( 'child-js', 'var durations_home = "'.__('Departure', 'Mundo').'"');
    wp_add_inline_script( 'child-js', 'var choose_des = "'.__('Choose destination here', 'Mundo').'"');
    wp_add_inline_script( 'child-js', 'var choose_style = "'.__('Choose style here', 'Mundo').'"');
    wp_add_inline_script( 'child-js', 'var choose_duration = "'.__('Choose duration here', 'Mundo').'"');
    wp_add_inline_script( 'child-js', 'var choose_duration_enqiry = "'.__('Departure', 'Mundo').'"');
    wp_add_inline_script( 'child-js', 'var or_text = "'.__('or', 'Mundo').'"');
    wp_add_inline_script( 'child-js', 'var by_click = "'.ot_get_option('cookie_text').'"');
    wp_add_inline_script( 'child-js', 'var title_email = "'.__('Your email  address', 'Mundo').'"');
    wp_add_inline_script( 'child-js', 'var btn_email = "'.__('SIGN UP', 'Mundo').'"');
    wp_add_inline_script( 'child-js', 'var read_more = "'.__('Read more', 'Mundo').'"');
    wp_add_inline_script( 'child-js', 'var fill_out = "'.__('Please fill out this field ', 'Mundo').'"');
    wp_add_inline_script( 'child-js', 'var check_field = "'.__('This field is required', 'Mundo').'"');
    wp_add_inline_script( 'child-js', 'var check_email = "'.__('Invalid email', 'Mundo').'"');
    // $text_translate_special = ot_get_option('text_translate_special');
    // wp_add_inline_script( 'child-js', 'var check_special = "'.__($text_translate_special, 'Mundo').'"');
    // $text_translate_special = __('text_translate_special__Cambodia__Cidade de Ho Chi Minh__Ho Chi Minh city','Mundo');
    // wp_add_inline_script( 'child-js', 'var check_special = "'.__($text_translate_special, 'Mundo').'"');
    // wp_enqueue_script( 'excursion-js', get_stylesheet_directory_uri() . '/js/excursion.js', array(), rand(), true );
} );
function liva_get_user_name($uid)
    {
        $ams = get_userdata( $uid );
        return ($ams->data->display_name);
    }
function mundo_current_language() {
    if(function_exists('pll_current_language')) {
        return pll_current_language();
    }
    return 'vi';
}
add_action('after_setup_theme', function() {
	register_nav_menu('currentcy-menu', esc_html__('Currency menu', 'colormag'));
	load_theme_textdomain( 'Mundo', get_stylesheet_directory() . '/languages' );
    if ( function_exists( 'fly_add_image_size' ) ) {
    	fly_add_image_size( 'map_image', 550, 550, array( 'center', 'center' ) );
    	fly_add_image_size( 'gallery_big', 570, 570, array( 'center', 'center' ) );
    	fly_add_image_size( 'gallery_small', 270, 270, array( 'center', 'center' ) );
    	fly_add_image_size( 'image_size_full', 700, 700, array( 'center', 'center' ) );
    	fly_add_image_size( 'hotel_detail', 500, 500, array( 'center', 'center' ) );
        fly_add_image_size( 'room_hotel', 270, 170, array( 'center', 'center' ) );
    	fly_add_image_size( 'tour_detail', 350, 350, array( 'center', 'center' ) );
    	fly_add_image_size( 'post_home', 400, 220, array( 'center', 'center' ) );
    	fly_add_image_size( 'post_expert_home', 250, 250, array( 'center', 'center' ) );
    	fly_add_image_size( 'post_destination', 270, 270, array( 'center', 'center' ) );
    	fly_add_image_size( 'tour_another', 470, 290, array( 'center', 'center' ) );
    	fly_add_image_size( 'hotel_another', 470, 290, array( 'center', 'center' ) );
    	fly_add_image_size( 'city_of_vietnam', 350, 350, array( 'center', 'center' ) );
    	fly_add_image_size( 'post_expert_detination', 190, 190, array( 'center', 'center' ) );
    	fly_add_image_size( 'know_more_first', 770, 370, array( 'center', 'center' ) );
    	fly_add_image_size( 'know_more_all', 370, 370, array( 'center', 'center' ) );
    	fly_add_image_size( 'why_us', 570, 370, array( 'center', 'center' ) );
    	fly_add_image_size( 'blog_list_first', 800, 450 , array( 'center', 'center' ) );
    	fly_add_image_size( 'blog_list_all', 470, 290, array( 'center', 'center' ) );
    	fly_add_image_size( 'post_expert_blog', 250, 250, array( 'center', 'center' ) );
    	fly_add_image_size( 'related_post', 470, 290, array( 'center', 'center' ) );
    	fly_add_image_size( 'map_description', 140, 100, array( 'center', 'center' ) );
    	fly_add_image_size( 'travel_guide_expert', 400, 400, array( 'center', 'center' ) );
    	fly_add_image_size( 'excursion_relate_check', 290, 180, array( 'center', 'center' ) );
    	fly_add_image_size( 'favorate_tour', 220, 140, array( 'center', 'center' ) );
    }
});
function getIDfromGUID( $guid ){
    global $wpdb;
    return $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid=%s", $guid ) );
}
add_filter('wpmm_text', function($text) {
    
    ob_start();
    get_template_part('maintenance');
    $text = ob_get_clean();
    return $text;
});

add_filter('wpmm_scripts', function($scripts) {
    $scripts['mm-maintenance'] = get_stylesheet_directory_uri() . '/js/maintenance.js';
    return $scripts;
});



function et_divi_customizer_theme_settings( $wp_customize ) {
	$site_domain = get_locale();

	$google_fonts = et_builder_get_fonts( array(
		'prepend_standard_fonts' => false,
	) );

	$user_fonts = et_builder_get_custom_fonts();

	// combine google fonts with custom user fonts
	$google_fonts = array_merge( $user_fonts, $google_fonts );

	$et_domain_fonts = array(
		'ru_RU' => 'cyrillic',
		'uk'    => 'cyrillic',
		'bg_BG' => 'cyrillic',
		'vi'    => 'vietnamese',
		'el'    => 'greek',
		'ar'    => 'arabic',
		'he_IL' => 'hebrew',
		'th'    => 'thai',
		'si_lk' => 'sinhala',
		'bn_bd' => 'bengali',
		'ta_lk' => 'tamil',
		'te'    => 'telegu',
		'km'    => 'khmer',
		'kn'    => 'kannada',
		'ml_in' => 'malayalam',
	);

	$et_one_font_languages = et_get_one_font_languages();

	$font_choices = array();
	$font_choices['none'] = array(
		'label' => 'Default Theme Font'
	);

	$removed_fonts_mapping = et_builder_old_fonts_mapping();

	foreach ( $google_fonts as $google_font_name => $google_font_properties ) {
		$use_parent_font = false;

		if ( isset( $removed_fonts_mapping[ $google_font_name ] ) ) {
			$parent_font = $removed_fonts_mapping[ $google_font_name ]['parent_font'];
			$google_font_properties['character_set'] = $google_fonts[ $parent_font ]['character_set'];
			$use_parent_font = true;
		}

		if ( '' !== $site_domain && isset( $et_domain_fonts[$site_domain] ) && isset( $google_font_properties['character_set'] ) && false === strpos( $google_font_properties['character_set'], $et_domain_fonts[$site_domain] ) ) {
			continue;
		}

		$font_choices[ $google_font_name ] = array(
			'label' => $google_font_name,
			'data'  => array(
				'parent_font'    => $use_parent_font ? $google_font_properties['parent_font'] : '',
				'parent_styles'  => $use_parent_font ? $google_fonts[$parent_font]['styles'] : $google_font_properties['styles'],
				'current_styles' => $use_parent_font && isset( $google_fonts[$parent_font]['styles'] ) && isset( $google_font_properties['styles'] ) ? $google_font_properties['styles'] : '',
				'parent_subset'  => $use_parent_font && isset( $google_fonts[$parent_font]['character_set'] ) ? $google_fonts[$parent_font]['character_set'] : '',
				'standard'       => isset( $google_font_properties['standard'] ) && $google_font_properties['standard'] ? 'on' : 'off',
			)
		);
	}

	$wp_customize->add_panel( 'et_divi_general_settings' , array(
		'title'		=> esc_html__( 'General Settings', 'Divi' ),
		'priority'	=> 1,
	) );

	$wp_customize->add_section( 'title_tagline', array(
		'title'    => esc_html__( 'Site Identity', 'Divi' ),
		'panel' => 'et_divi_general_settings',
	) );

	$wp_customize->add_section( 'et_divi_general_layout' , array(
		'title'		=> esc_html__( 'Layout Settings', 'Divi' ),
		'panel' => 'et_divi_general_settings',
	) );

	$wp_customize->add_section( 'et_divi_general_typography' , array(
		'title'		=> esc_html__( 'Typography', 'Divi' ),
		'panel' => 'et_divi_general_settings',
	) );

	$wp_customize->add_panel( 'et_divi_mobile' , array(
		'title'		=> esc_html__( 'Mobile Styles', 'Divi' ),
		'priority' => 6,
	) );

	$wp_customize->add_section( 'et_divi_mobile_tablet' , array(
		'title'		=> esc_html__( 'Tablet', 'Divi' ),
		'panel' => 'et_divi_mobile',
	) );

	$wp_customize->add_section( 'et_divi_mobile_phone' , array(
		'title'		=> esc_html__( 'Phone', 'Divi' ),
		'panel' => 'et_divi_mobile',
	) );

	$wp_customize->add_section( 'et_divi_mobile_menu' , array(
		'title'		=> esc_html__( 'Mobile Menu', 'Divi' ),
		'panel' => 'et_divi_mobile',
	) );

	$wp_customize->add_section( 'et_divi_general_background' , array(
		'title'		=> esc_html__( 'Background', 'Divi' ),
		'panel' => 'et_divi_general_settings',
	) );

	$wp_customize->add_panel( 'et_divi_header_panel', array(
		'title' => esc_html__( 'Header & Navigation', 'Divi' ),
		'priority' => 2,
	) );

	$wp_customize->add_section( 'et_divi_header_layout' , array(
		'title'		=> esc_html__( 'Header Format', 'Divi' ),
		'panel' => 'et_divi_header_panel',
	) );

	$wp_customize->add_section( 'et_divi_header_primary' , array(
		'title'		=> esc_html__( 'Primary Menu Bar', 'Divi' ),
		'panel' => 'et_divi_header_panel',
	) );

	$wp_customize->add_section( 'et_divi_header_secondary' , array(
		'title'		=> esc_html__( 'Secondary Menu Bar', 'Divi' ),
		'panel' => 'et_divi_header_panel',
	) );

	$wp_customize->add_section( 'et_divi_header_slide' , array(
		'title'		=> esc_html__( 'Slide In & Fullscreen Header Settings', 'Divi' ),
		'panel' => 'et_divi_header_panel',
	) );

	$wp_customize->add_section( 'et_divi_header_fixed' , array(
		'title'		=> esc_html__( 'Fixed Navigation Settings', 'Divi' ),
		'panel' => 'et_divi_header_panel',
	) );

	$wp_customize->add_section( 'et_divi_header_information' , array(
		'title'		=> esc_html__( 'Header Elements', 'Divi' ),
		'panel' => 'et_divi_header_panel',
	) );

	$wp_customize->add_panel( 'et_divi_footer_panel' , array(
		'title'		=> esc_html__( 'Footer', 'Divi' ),
		'priority'	=> 3,
	) );

	$wp_customize->add_section( 'et_divi_footer_layout' , array(
		'title'		=> esc_html__( 'Layout', 'Divi' ),
		'panel' => 'et_divi_footer_panel',
	) );

	$wp_customize->add_section( 'et_divi_footer_widgets' , array(
		'title'		=> esc_html__( 'Widgets', 'Divi' ),
		'panel' => 'et_divi_footer_panel',
	) );

	$wp_customize->add_section( 'et_divi_footer_elements' , array(
		'title'		=> esc_html__( 'Footer Elements', 'Divi' ),
		'panel' => 'et_divi_footer_panel',
	) );

	$wp_customize->add_section( 'et_divi_footer_menu' , array(
		'title'		=> esc_html__( 'Footer Menu', 'Divi' ),
		'panel' => 'et_divi_footer_panel',
	) );

	$wp_customize->add_section( 'et_divi_bottom_bar' , array(
		'title'		=> esc_html__( 'Bottom Bar', 'Divi' ),
		'panel' => 'et_divi_footer_panel',
	) );

	$wp_customize->add_section( 'et_color_schemes' , array(
		'title'       => esc_html__( 'Color Schemes', 'Divi' ),
		'priority'    => 7,
		'description' => esc_html__( 'Note: Color settings set above should be applied to the Default color scheme.', 'Divi' ),
	) );

	$wp_customize->add_panel( 'et_divi_buttons_settings' , array(
		'title'		=> esc_html__( 'Buttons', 'Divi' ),
		'priority'	=> 4,
	) );

	$wp_customize->add_section( 'et_divi_buttons' , array(
		'title'       => esc_html__( 'Buttons Style', 'Divi' ),
		'panel'       => 'et_divi_buttons_settings',
	) );

	$wp_customize->add_section( 'et_divi_buttons_hover' , array(
		'title'       => esc_html__( 'Buttons Hover Style', 'Divi' ),
		'panel'       => 'et_divi_buttons_settings',
	) );

	$wp_customize->add_panel( 'et_divi_blog_settings' , array(
		'title'		=> esc_html__( 'Blog', 'Divi' ),
		'priority'	=> 5,
	) );

	$wp_customize->add_section( 'et_divi_blog_post' , array(
		'title'       => esc_html__( 'Post', 'Divi' ),
		'panel'       => 'et_divi_blog_settings',
	) );

	$wp_customize->add_setting( 'et_divi[post_meta_font_size]', array(
		'default'       => '14',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';

	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[post_meta_font_size]', array(
		'label'	      => esc_html__( 'Meta Text Size', 'Divi' ),
		'section'     => 'et_divi_blog_post',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 10,
			'max'  => 32,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[post_meta_height]', array(
		'default'       => '1',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'et_sanitize_float_number',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[post_meta_height]', array(
		'label'	      => esc_html__( 'Meta Line Height', 'Divi' ),
		'section'     => 'et_divi_blog_post',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => .8,
			'max'  => 3,
			'step' => .1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[post_meta_spacing]', array(
		'default'       => '0',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[post_meta_spacing]', array(
		'label'	      => esc_html__( 'Meta Letter Spacing', 'Divi' ),
		'section'     => 'et_divi_blog_post',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => -2,
			'max'  => 10,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[post_meta_style]', array(
		'default'       => '',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'et_sanitize_font_style',
	) );

	$wp_customize->add_control( new ET_Divi_Font_Style_Option ( $wp_customize, 'et_divi[post_meta_style]', array(
		'label'	      => esc_html__( 'Meta Font Style', 'Divi' ),
		'section'     => 'et_divi_blog_post',
		'type'        => 'font_style',
		'choices'     => et_divi_font_style_choices(),
	) ) );

	$wp_customize->add_setting( 'et_divi[post_header_font_size]', array(
		'default'       => '30',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[post_header_font_size]', array(
		'label'	      => esc_html__( 'Header Text Size', 'Divi' ),
		'section'     => 'et_divi_blog_post',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 10,
			'max'  => 72,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[post_header_height]', array(
		'default'       => '1',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'et_sanitize_float_number',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[post_header_height]', array(
		'label'	      => esc_html__( 'Header Line Height', 'Divi' ),
		'section'     => 'et_divi_blog_post',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 0.8,
			'max'  => 3,
			'step' => 0.1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[post_header_spacing]', array(
		'default'       => '0',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'et_sanitize_int_number',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[post_header_spacing]', array(
		'label'	      => esc_html__( 'Header Letter Spacing', 'Divi' ),
		'section'     => 'et_divi_blog_post',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => -2,
			'max'  => 10,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[post_header_style]', array(
		'default'       => '',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'et_sanitize_font_style',
	) );

	$wp_customize->add_control( new ET_Divi_Font_Style_Option ( $wp_customize, 'et_divi[post_header_style]', array(
		'label'	      => esc_html__( 'Header Font Style', 'Divi' ),
		'section'     => 'et_divi_blog_post',
		'type'        => 'font_style',
		'choices'     => et_divi_font_style_choices(),
	) ) );

	$wp_customize->add_setting( 'et_divi[boxed_layout]', array(
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'wp_validate_boolean',
	) );

	$wp_customize->add_control( 'et_divi[boxed_layout]', array(
		'label'		=> esc_html__( 'Enable Boxed Layout', 'Divi' ),
		'section'	=> 'et_divi_general_layout',
		'type'      => 'checkbox',
	) );

	$wp_customize->add_setting( 'et_divi[content_width]', array(
		'default'       => '1080',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[content_width]', array(
		'label'	      => esc_html__( 'Website Content Width', 'Divi' ),
		'section'     => 'et_divi_general_layout',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 960,
			'max'  => 1920,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[gutter_width]', array(
		'default'       => '3',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[gutter_width]', array(
		'label'	      => esc_html__( 'Website Gutter Width', 'Divi' ),
		'section'     => 'et_divi_general_layout',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 1,
			'max'  => 4,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[use_sidebar_width]', array(
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'wp_validate_boolean',
	) );

	$wp_customize->add_control( 'et_divi[use_sidebar_width]', array(
		'label'		=> esc_html__( 'Use Custom Sidebar Width', 'Divi' ),
		'section'	=> 'et_divi_general_layout',
		'type'      => 'checkbox',
	) );

	$wp_customize->add_setting( 'et_divi[sidebar_width]', array(
		'default'       => '21',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[sidebar_width]', array(
		'label'	      => esc_html__( 'Sidebar Width', 'Divi' ),
		'section'     => 'et_divi_general_layout',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 19,
			'max'  => 33,
			'step' => 1,
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[section_padding]', array(
		'default'       => '4',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[section_padding]', array(
		'label'	      => esc_html__( 'Section Height', 'Divi' ),
		'section'     => 'et_divi_general_layout',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 0,
			'max'  => 10,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[phone_section_height]', array(
		'default'       => et_get_option( 'tablet_section_height', '50' ),
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[phone_section_height]', array(
		'label'	      => esc_html__( 'Section Height', 'Divi' ),
		'section'     => 'et_divi_mobile_phone',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 0,
			'max'  => 150,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[tablet_section_height]', array(
		'default'       => '50',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[tablet_section_height]', array(
		'label'	      => esc_html__( 'Section Height', 'Divi' ),
		'section'     => 'et_divi_mobile_tablet',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 0,
			'max'  => 150,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[row_padding]', array(
		'default'       => '2',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[row_padding]', array(
		'label'	      => esc_html__( 'Row Height', 'Divi' ),
		'section'     => 'et_divi_general_layout',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 0,
			'max'  => 10,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[phone_row_height]', array(
		'default'       => et_get_option( 'tablet_row_height', '30' ),
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[phone_row_height]', array(
		'label'	      => esc_html__( 'Row Height', 'Divi' ),
		'section'     => 'et_divi_mobile_phone',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 0,
			'max'  => 150,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[tablet_row_height]', array(
		'default'       => '30',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[tablet_row_height]', array(
		'label'	      => esc_html__( 'Row Height', 'Divi' ),
		'section'     => 'et_divi_mobile_tablet',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 0,
			'max'  => 150,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[cover_background]', array(
		'default'       => 'on',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'wp_validate_boolean',
	) );

	$wp_customize->add_control( 'et_divi[cover_background]', array(
		'label'		=> esc_html__( 'Stretch Background Image', 'Divi' ),
		'section'	=> 'et_divi_general_background',
		'type'      => 'checkbox',
	) );

	if ( ! is_null( $wp_customize->get_setting( 'background_color' ) ) ) {
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'background_color', array(
			'label'		=> esc_html__( 'Background Color', 'Divi' ),
			'section'	=> 'et_divi_general_background',
		) ) );
	}

	if ( ! is_null( $wp_customize->get_setting( 'background_image' ) ) ) {
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'background_image', array(
			'label'		=> esc_html__( 'Background Image', 'Divi' ),
			'section'	=> 'et_divi_general_background',
		) ) );
	}

	// Remove default background_repeat setting and control since native
	// background_repeat field has different different settings
	$wp_customize->remove_setting( 'background_repeat' );
	$wp_customize->remove_control( 'background_repeat' );

	// Re-defined Divi specific background repeat option
	$wp_customize->add_setting( 'background_repeat', array(
		'default'           => apply_filters( 'et_divi_background_repeat_default', 'repeat' ),
		'sanitize_callback' => 'et_sanitize_background_repeat',
		'theme_supports'    => 'custom-background',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'background_repeat', array(
		'label'		=> esc_html__( 'Background Repeat', 'Divi' ),
		'section'	=> 'et_divi_general_background',
		'type'      => 'radio',
		'choices'   => et_divi_background_repeat_choices(),
	) );

	$wp_customize->add_control( 'background_position_x', array(
		'label'		=> esc_html__( 'Background Position', 'Divi' ),
		'section'	=> 'et_divi_general_background',
		'type'      => 'radio',
		'choices'    => array(
				'left'       => esc_html__( 'Left', 'Divi' ),
				'center'     => esc_html__( 'Center', 'Divi' ),
				'right'      => esc_html__( 'Right', 'Divi' ),
			),
	) );

	// Remove default background_attachment setting and control since native
	// background_attachment field has different different settings
	$wp_customize->remove_setting( 'background_attachment' );
	$wp_customize->remove_control( 'background_attachment' );

	$wp_customize->add_setting( 'background_attachment', array(
		'default'           => apply_filters( 'et_sanitize_background_attachment_default', 'scroll' ),
		'sanitize_callback' => 'et_sanitize_background_attachment',
		'theme_supports'    => 'custom-background',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'background_attachment', array(
		'label'		=> esc_html__( 'Background Position', 'Divi' ),
		'section'	=> 'et_divi_general_background',
		'type'      => 'radio',
		'choices'    => et_divi_background_attachment_choices(),
	) );

	$wp_customize->add_setting( 'et_divi[body_font_size]', array(
		'default'       => '14',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[body_font_size]', array(
		'label'	      => esc_html__( 'Body Text Size', 'Divi' ),
		'section'     => 'et_divi_general_typography',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 10,
			'max'  => 32,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[body_font_height]', array(
		'default'       => '1.7',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'et_sanitize_float_number',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[body_font_height]', array(
		'label'	      => esc_html__( 'Body Line Height', 'Divi' ),
		'section'     => 'et_divi_general_typography',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 0.8,
			'max'  => 3,
			'step' => 0.1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[phone_body_font_size]', array(
		'default'       => et_get_option( 'tablet_body_font_size', '14' ),
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[phone_body_font_size]', array(
		'label'	      => esc_html__( 'Body Text Size', 'Divi' ),
		'section'     => 'et_divi_mobile_phone',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 10,
			'max'  => 32,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[tablet_body_font_size]', array(
		'default'       => et_get_option( 'body_font_size', '14' ),
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[tablet_body_font_size]', array(
		'label'	      => esc_html__( 'Body Text Size', 'Divi' ),
		'section'     => 'et_divi_mobile_tablet',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 10,
			'max'  => 32,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[body_header_size]', array(
		'default'       => '30',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[body_header_size]', array(
		'label'	      => esc_html__( 'Header Text Size', 'Divi' ),
		'section'     => 'et_divi_general_typography',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 22,
			'max'  => 72,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[body_header_spacing]', array(
		'default'       => '0',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'et_sanitize_int_number',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[body_header_spacing]', array(
		'label'	      => esc_html__( 'Header Letter Spacing', 'Divi' ),
		'section'     => 'et_divi_general_typography',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => -2,
			'max'  => 10,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[body_header_height]', array(
		'default'       => '1',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'et_sanitize_float_number',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[body_header_height]', array(
		'label'	      => esc_html__( 'Header Line Height', 'Divi' ),
		'section'     => 'et_divi_general_typography',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 0.8,
			'max'  => 3,
			'step' => 0.1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[body_header_style]', array(
		'default'       => '',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'et_sanitize_font_style',
	) );

	$wp_customize->add_control( new ET_Divi_Font_Style_Option ( $wp_customize, 'et_divi[body_header_style]', array(
		'label'	      => esc_html__( 'Header Font Style', 'Divi' ),
		'section'     => 'et_divi_general_typography',
		'type'        => 'font_style',
		'choices'     => et_divi_font_style_choices(),
	) ) );

	$wp_customize->add_setting( 'et_divi[phone_header_font_size]', array(
		'default'       => et_get_option( 'tablet_header_font_size', '30' ),
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[phone_header_font_size]', array(
		'label'	      => esc_html__( 'Header Text Size', 'Divi' ),
		'section'     => 'et_divi_mobile_phone',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 22,
			'max'  => 72,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[tablet_header_font_size]', array(
		'default'       => et_get_option( 'body_header_size', '30' ),
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[tablet_header_font_size]', array(
		'label'	      => esc_html__( 'Header Text Size', 'Divi' ),
		'section'     => 'et_divi_mobile_tablet',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 22,
			'max'  => 72,
			'step' => 1
		),
	) ) );

	if ( ! isset( $et_one_font_languages[$site_domain] ) ) {
		$wp_customize->add_setting( 'et_divi[heading_font]', array(
			'default'		=> 'none',
			'type'			=> 'option',
			'capability'	=> 'edit_theme_options',
			'transport'		=> 'postMessage',
			'sanitize_callback' => 'et_sanitize_font_choices',
		) );

		$wp_customize->add_control( new ET_Divi_Select_Option ( $wp_customize, 'et_divi[heading_font]', array(
			'label'		=> esc_html__( 'Header Font', 'Divi' ),
			'section'	=> 'et_divi_general_typography',
			'settings'	=> 'et_divi[heading_font]',
			'type'		=> 'select',
			'choices'	=> $font_choices,
		) ) );

		$wp_customize->add_setting( 'et_divi[body_font]', array(
			'default'		=> 'none',
			'type'			=> 'option',
			'capability'	=> 'edit_theme_options',
			'transport'		=> 'postMessage',
			'sanitize_callback' => 'et_sanitize_font_choices',
		) );

		$wp_customize->add_control( new ET_Divi_Select_Option ( $wp_customize, 'et_divi[body_font]', array(
			'label'		=> esc_html__( 'Body Font', 'Divi' ),
			'section'	=> 'et_divi_general_typography',
			'settings'	=> 'et_divi[body_font]',
			'type'		=> 'select',
			'choices'	=> $font_choices
		) ) );
	}

	$wp_customize->add_setting( 'et_divi[link_color]', array(
		'default'	=> et_get_option( 'accent_color', '#2ea3f2' ),
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[link_color]', array(
		'label'		=> esc_html__( 'Body Link Color', 'Divi' ),
		'section'	=> 'et_divi_general_typography',
		'settings'	=> 'et_divi[link_color]',
	) ) );

	$wp_customize->add_setting( 'et_divi[font_color]', array(
		'default'		=> '#666666',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[font_color]', array(
		'label'		=> esc_html__( 'Body Text Color', 'Divi' ),
		'section'	=> 'et_divi_general_typography',
		'settings'	=> 'et_divi[font_color]',
	) ) );

	$wp_customize->add_setting( 'et_divi[header_color]', array(
		'default'		=> '#666666',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[header_color]', array(
		'label'		=> esc_html__( 'Header Text Color', 'Divi' ),
		'section'	=> 'et_divi_general_typography',
		'settings'	=> 'et_divi[header_color]',
	) ) );

	$wp_customize->add_setting( 'et_divi[accent_color]', array(
		'default'		=> '#2ea3f2',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[accent_color]', array(
		'label'		=> esc_html__( 'Theme Accent Color', 'Divi' ),
		'section'	=> 'et_divi_general_layout',
		'settings'	=> 'et_divi[accent_color]',
	) ) );

	$wp_customize->add_setting( 'et_divi[color_schemes]', array(
		'default'		=> 'none',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_color_scheme',
	) );

	$wp_customize->add_control( 'et_divi[color_schemes]', array(
		'label'		=> esc_html__( 'Color Schemes', 'Divi' ),
		'section'	=> 'et_color_schemes',
		'settings'	=> 'et_divi[color_schemes]',
		'type'		=> 'select',
		'choices'	=> et_divi_color_scheme_choices(),
	) );

	$wp_customize->add_setting( 'et_divi[header_style]', array(
		'default'       => 'left',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_header_style',
	) );

	$wp_customize->add_control( 'et_divi[header_style]', array(
		'label'		=> esc_html__( 'Header Style', 'Divi' ),
		'section'	=> 'et_divi_header_layout',
		'type'      => 'select',
		'choices'	=> et_divi_header_style_choices(),
	) );

	$wp_customize->add_setting( 'et_divi[vertical_nav]', array(
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'wp_validate_boolean',
	) );

	$wp_customize->add_control( 'et_divi[vertical_nav]', array(
		'label'		=> esc_html__( 'Enable Vertical Navigation', 'Divi' ),
		'section'	=> 'et_divi_header_layout',
		'type'      => 'checkbox',
	) );

	$wp_customize->add_setting( 'et_divi[vertical_nav_orientation]', array(
		'default'       => 'left',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_left_right',
	) );

	$wp_customize->add_control( 'et_divi[vertical_nav_orientation]', array(
		'label'		=> esc_html__( 'Vertical Menu Orientation', 'Divi' ),
		'section'	=> 'et_divi_header_layout',
		'type'      => 'select',
		'choices'	=> et_divi_left_right_choices(),
	) );

	if ( 'on' === et_get_option( 'divi_fixed_nav', 'on' ) ) {

		$wp_customize->add_setting( 'et_divi[hide_nav]', array(
			'type'			=> 'option',
			'capability'	=> 'edit_theme_options',
			'transport'		=> 'postMessage',
			'sanitize_callback' => 'wp_validate_boolean',
		) );

		$wp_customize->add_control( 'et_divi[hide_nav]', array(
			'label'		=> esc_html__( 'Hide Navigation Until Scroll', 'Divi' ),
			'section'	=> 'et_divi_header_layout',
			'type'      => 'checkbox',
		) );

	} // 'on' === et_get_option( 'divi_fixed_nav', 'on' )

	$wp_customize->add_setting( 'et_divi[show_header_social_icons]', array(
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'wp_validate_boolean',
	) );

	$wp_customize->add_control( 'et_divi[show_header_social_icons]', array(
		'label'		=> esc_html__( 'Show Social Icons', 'Divi' ),
		'section'	=> 'et_divi_header_information',
		'type'      => 'checkbox',
	) );

	$wp_customize->add_setting( 'et_divi[show_search_icon]', array(
		'default'       => 'on',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'wp_validate_boolean',
	) );

	$wp_customize->add_control( 'et_divi[show_search_icon]', array(
		'label'		=> esc_html__( 'Show Search Icon', 'Divi' ),
		'section'	=> 'et_divi_header_information',
		'type'      => 'checkbox',
	) );

	$wp_customize->add_setting( 'et_divi[slide_nav_show_top_bar]', array(
		'default'       => 'on',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'wp_validate_boolean',
	) );

	$wp_customize->add_control( 'et_divi[slide_nav_show_top_bar]', array(
		'label'		=> esc_html__( 'Show Top Bar', 'Divi' ),
		'section'	=> 'et_divi_header_slide',
		'type'      => 'checkbox',
	) );

	$wp_customize->add_setting( 'et_divi[slide_nav_width]', array(
		'default'       => '320',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[slide_nav_width]', array(
		'label'	      => esc_html__( 'Menu Width', 'Divi' ),
		'section'     => 'et_divi_header_slide',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 280,
			'max'  => 600,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[slide_nav_font_size]', array(
		'default'       => '14',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[slide_nav_font_size]', array(
		'label'	      => esc_html__( 'Menu Text Size', 'Divi' ),
		'section'     => 'et_divi_header_slide',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 24,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[slide_nav_top_font_size]', array(
		'default'       => '14',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[slide_nav_top_font_size]', array(
		'label'	      => esc_html__( 'Top Bar Text Size', 'Divi' ),
		'section'     => 'et_divi_header_slide',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 24,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[fullscreen_nav_font_size]', array(
		'default'       => '30',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[fullscreen_nav_font_size]', array(
		'label'	      => esc_html__( 'Menu Text Size', 'Divi' ),
		'section'     => 'et_divi_header_slide',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 50,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[fullscreen_nav_top_font_size]', array(
		'default'       => '18',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[fullscreen_nav_top_font_size]', array(
		'label'	      => esc_html__( 'Top Bar Text Size', 'Divi' ),
		'section'     => 'et_divi_header_slide',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 40,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[slide_nav_font_spacing]', array(
		'default'       => '0',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'et_sanitize_int_number',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[slide_nav_font_spacing]', array(
		'label'	      => esc_html__( 'Letter Spacing', 'Divi' ),
		'section'     => 'et_divi_header_slide',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => -1,
			'max'  => 8,
			'step' => 1
		),
	) ) );

	if ( ! isset( $et_one_font_languages[$site_domain] ) ) {
		$wp_customize->add_setting( 'et_divi[slide_nav_font]', array(
			'default'		=> 'none',
			'type'			=> 'option',
			'capability'	=> 'edit_theme_options',
			'transport'		=> 'postMessage',
			'sanitize_callback' => 'et_sanitize_font_choices',
		) );

		$wp_customize->add_control( new ET_Divi_Select_Option ( $wp_customize, 'et_divi[slide_nav_font]', array(
			'label'		=> esc_html__( 'Font', 'Divi' ),
			'section'	=> 'et_divi_header_slide',
			'settings'	=> 'et_divi[slide_nav_font]',
			'type'		=> 'select',
			'choices'	=> $font_choices
		) ) );
	}

	$wp_customize->add_setting( 'et_divi[slide_nav_font_style]', array(
		'default'       => '',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'et_sanitize_font_style',
	) );

	$wp_customize->add_control( new ET_Divi_Font_Style_Option ( $wp_customize, 'et_divi[slide_nav_font_style]', array(
		'label'	      => esc_html__( 'Font Style', 'Divi' ),
		'section'     => 'et_divi_header_slide',
		'type'        => 'font_style',
		'choices'     => et_divi_font_style_choices(),
	) ) );

	$wp_customize->add_setting( 'et_divi[slide_nav_bg]', array(
		'default'		=> et_get_option( 'accent_color', '#2ea3f2' ),
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[slide_nav_bg]', array(
		'label'		=> esc_html__( 'Background Color', 'Divi' ),
		'section'	=> 'et_divi_header_slide',
		'settings'	=> 'et_divi[slide_nav_bg]',
	) ) );

	$wp_customize->add_setting( 'et_divi[slide_nav_links_color]', array(
		'default'		=> '#ffffff',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[slide_nav_links_color]', array(
		'label'		=> esc_html__( 'Menu Link Color', 'Divi' ),
		'section'	=> 'et_divi_header_slide',
		'settings'	=> 'et_divi[slide_nav_links_color]',
	) ) );

	$wp_customize->add_setting( 'et_divi[slide_nav_links_color_active]', array(
		'default'		=> '#ffffff',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[slide_nav_links_color_active]', array(
		'label'		=> esc_html__( 'Active Link Color', 'Divi' ),
		'section'	=> 'et_divi_header_slide',
		'settings'	=> 'et_divi[slide_nav_links_color_active]',
	) ) );

	$wp_customize->add_setting( 'et_divi[slide_nav_top_color]', array(
		'default'		=> 'rgba(255,255,255,0.6)',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[slide_nav_top_color]', array(
		'label'		=> esc_html__( 'Top Bar Text Color', 'Divi' ),
		'section'	=> 'et_divi_header_slide',
		'settings'	=> 'et_divi[slide_nav_top_color]',
	) ) );

	$wp_customize->add_setting( 'et_divi[slide_nav_search]', array(
		'default'		=> 'rgba(255,255,255,0.6)',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[slide_nav_search]', array(
		'label'		=> esc_html__( 'Search Bar Text Color', 'Divi' ),
		'section'	=> 'et_divi_header_slide',
		'settings'	=> 'et_divi[slide_nav_search]',
	) ) );

	$wp_customize->add_setting( 'et_divi[slide_nav_search_bg]', array(
		'default'		=> 'rgba(0,0,0,0.2)',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[slide_nav_search_bg]', array(
		'label'		=> esc_html__( 'Search Bar Background Color', 'Divi' ),
		'section'	=> 'et_divi_header_slide',
		'settings'	=> 'et_divi[slide_nav_search_bg]',
	) ) );

	$wp_customize->add_setting( 'et_divi[nav_fullwidth]', array(
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'wp_validate_boolean',
	) );

	$wp_customize->add_control( 'et_divi[nav_fullwidth]', array(
		'label'		=> esc_html__( 'Make Full Width', 'Divi' ),
		'section'	=> 'et_divi_header_primary',
		'type'      => 'checkbox',
	) );

	$wp_customize->add_setting( 'et_divi[hide_primary_logo]', array(
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'wp_validate_boolean',
	) );

	$wp_customize->add_control( 'et_divi[hide_primary_logo]', array(
		'label'		=> esc_html__( 'Hide Logo Image', 'Divi' ),
		'section'	=> 'et_divi_header_primary',
		'type'      => 'checkbox',
	) );

	$wp_customize->add_setting( 'et_divi[menu_height]', array(
		'default'       => '66',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[menu_height]', array(
		'label'	      => esc_html__( 'Menu Height', 'Divi' ),
		'section'     => 'et_divi_header_primary',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 30,
			'max'  => 300,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[logo_height]', array(
		'default'       => '54',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[logo_height]', array(
		'label'	      => esc_html__( 'Logo Max Height', 'Divi' ),
		'section'     => 'et_divi_header_primary',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 30,
			'max'  => 150,
			'step' => 1,
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[menu_margin_top]', array(
		'default'       => '0',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[menu_margin_top]', array(
		'label'	      => esc_html__( 'Menu Top Margin', 'Divi' ),
		'section'     => 'et_divi_header_primary',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 0,
			'max'  => 300,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[primary_nav_font_size]', array(
		'default'       => '14',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[primary_nav_font_size]', array(
		'label'	      => esc_html__( 'Text Size', 'Divi' ),
		'section'     => 'et_divi_header_primary',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 24,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[primary_nav_font_spacing]', array(
		'default'       => '0',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'et_sanitize_int_number',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[primary_nav_font_spacing]', array(
		'label'	      => esc_html__( 'Letter Spacing', 'Divi' ),
		'section'     => 'et_divi_header_primary',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => -1,
			'max'  => 8,
			'step' => 1
		),
	) ) );

	if ( ! isset( $et_one_font_languages[$site_domain] ) ) {
		$wp_customize->add_setting( 'et_divi[primary_nav_font]', array(
			'default'		=> 'none',
			'type'			=> 'option',
			'capability'	=> 'edit_theme_options',
			'transport'		=> 'postMessage',
			'sanitize_callback' => 'et_sanitize_font_choices',
		) );

		$wp_customize->add_control( new ET_Divi_Select_Option ( $wp_customize, 'et_divi[primary_nav_font]', array(
			'label'		=> esc_html__( 'Font', 'Divi' ),
			'section'	=> 'et_divi_header_primary',
			'settings'	=> 'et_divi[primary_nav_font]',
			'type'		=> 'select',
			'choices'	=> $font_choices
		) ) );
	}

	$wp_customize->add_setting( 'et_divi[primary_nav_font_style]', array(
		'default'       => '',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'et_sanitize_font_style',
	) );

	$wp_customize->add_control( new ET_Divi_Font_Style_Option ( $wp_customize, 'et_divi[primary_nav_font_style]', array(
		'label'	      => esc_html__( 'Font Style', 'Divi' ),
		'section'     => 'et_divi_header_primary',
		'type'        => 'font_style',
		'choices'     => et_divi_font_style_choices(),
	) ) );

	$wp_customize->add_setting( 'et_divi[secondary_nav_font_size]', array(
		'default'       => '12',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_setting( 'et_divi[secondary_nav_fullwidth]', array(
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'wp_validate_boolean',
	) );

	$wp_customize->add_control( 'et_divi[secondary_nav_fullwidth]', array(
		'label'		=> esc_html__( 'Make Full Width', 'Divi' ),
		'section'	=> 'et_divi_header_secondary',
		'type'      => 'checkbox',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[secondary_nav_font_size]', array(
		'label'	      => esc_html__( 'Text Size', 'Divi' ),
		'section'     => 'et_divi_header_secondary',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 20,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[secondary_nav_font_spacing]', array(
		'default'       => '0',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'et_sanitize_int_number',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[secondary_nav_font_spacing]', array(
		'label'	      => esc_html__( 'Letter Spacing', 'Divi' ),
		'section'     => 'et_divi_header_secondary',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => -1,
			'max'  => 8,
			'step' => 1
		),
	) ) );

	if ( ! isset( $et_one_font_languages[$site_domain] ) ) {
		$wp_customize->add_setting( 'et_divi[secondary_nav_font]', array(
			'default'		=> 'none',
			'type'			=> 'option',
			'capability'	=> 'edit_theme_options',
			'transport'		=> 'postMessage',
			'sanitize_callback' => 'et_sanitize_font_choices',
		) );

		$wp_customize->add_control( new ET_Divi_Select_Option ( $wp_customize, 'et_divi[secondary_nav_font]', array(
			'label'		=> esc_html__( 'Font', 'Divi' ),
			'section'	=> 'et_divi_header_secondary',
			'settings'	=> 'et_divi[secondary_nav_font]',
			'type'		=> 'select',
			'choices'	=> $font_choices
		) ) );
	}

	$wp_customize->add_setting( 'et_divi[secondary_nav_font_style]', array(
		'default'       => '',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'et_sanitize_font_style',
	) );

	$wp_customize->add_control( new ET_Divi_Font_Style_Option ( $wp_customize, 'et_divi[secondary_nav_font_style]', array(
		'label'	      => esc_html__( 'Font Style', 'Divi' ),
		'section'     => 'et_divi_header_secondary',
		'type'        => 'font_style',
		'choices'     => et_divi_font_style_choices(),
	) ) );

	$wp_customize->add_setting( 'et_divi[menu_link]', array(
		'default'		=> 'rgba(0,0,0,0.6)',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[menu_link]', array(
		'label'		=> esc_html__( 'Text Color', 'Divi' ),
		'section'	=> 'et_divi_header_primary',
		'settings'	=> 'et_divi[menu_link]',
	) ) );

	$wp_customize->add_setting( 'et_divi[hide_mobile_logo]', array(
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'wp_validate_boolean',
	) );

	$wp_customize->add_control( 'et_divi[hide_mobile_logo]', array(
		'label'		=> esc_html__( 'Hide Logo Image', 'Divi' ),
		'section'	=> 'et_divi_mobile_menu',
		'type'      => 'checkbox',
	) );

	$wp_customize->add_setting( 'et_divi[mobile_menu_link]', array(
		'default'		=> et_get_option( 'menu_link', 'rgba(0,0,0,0.6)' ),
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[mobile_menu_link]', array(
		'label'		=> esc_html__( 'Text Color', 'Divi' ),
		'section'	=> 'et_divi_mobile_menu',
		'settings'	=> 'et_divi[mobile_menu_link]',
	) ) );

	$wp_customize->add_setting( 'et_divi[menu_link_active]', array(
		'default'		=> et_get_option( 'accent_color', '#2ea3f2' ),
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[menu_link_active]', array(
		'label'		=> esc_html__( 'Active Link Color', 'Divi' ),
		'section'	=> 'et_divi_header_primary',
		'settings'	=> 'et_divi[menu_link_active]',
	) ) );

	$wp_customize->add_setting( 'et_divi[primary_nav_bg]', array(
		'default'		=> '#ffffff',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[primary_nav_bg]', array(
		'label'		=> esc_html__( 'Background Color', 'Divi' ),
		'section'	=> 'et_divi_header_primary',
		'settings'	=> 'et_divi[primary_nav_bg]',
	) ) );

	$wp_customize->add_setting( 'et_divi[primary_nav_dropdown_bg]', array(
		'default'		=> et_get_option( 'primary_nav_bg', '#ffffff' ),
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[primary_nav_dropdown_bg]', array(
		'label'		=> esc_html__( 'Dropdown Menu Background Color', 'Divi' ),
		'section'	=> 'et_divi_header_primary',
		'settings'	=> 'et_divi[primary_nav_dropdown_bg]',
	) ) );

	$wp_customize->add_setting( 'et_divi[primary_nav_dropdown_line_color]', array(
		'default'		=> et_get_option( 'accent_color', '#2ea3f2' ),
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[primary_nav_dropdown_line_color]', array(
		'label'		=> esc_html__( 'Dropdown Menu Line Color', 'Divi' ),
		'section'	=> 'et_divi_header_primary',
		'settings'	=> 'et_divi[primary_nav_dropdown_line_color]',
	) ) );

	$wp_customize->add_setting( 'et_divi[primary_nav_dropdown_link_color]', array(
		'default'		=> et_get_option( 'menu_link', 'rgba(0,0,0,0.7)' ),
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[primary_nav_dropdown_link_color]', array(
		'label'		=> esc_html__( 'Dropdown Menu Text Color', 'Divi' ),
		'section'	=> 'et_divi_header_primary',
		'settings'	=> 'et_divi[primary_nav_dropdown_link_color]',
	) ) );

	$wp_customize->add_setting( 'et_divi[primary_nav_dropdown_animation]', array(
		'default'       => 'fade',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_dropdown_animation',
	) );

	$wp_customize->add_control( 'et_divi[primary_nav_dropdown_animation]', array(
		'label'		=> esc_html__( 'Dropdown Menu Animation', 'Divi' ),
		'section'	=> 'et_divi_header_primary',
		'type'      => 'select',
		'choices'	=> et_divi_dropdown_animation_choices(),
	) );

	$wp_customize->add_setting( 'et_divi[mobile_primary_nav_bg]', array(
		'default'		=> et_get_option( 'primary_nav_bg', '#ffffff' ),
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[mobile_primary_nav_bg]', array(
		'label'		=> esc_html__( 'Background Color', 'Divi' ),
		'section'	=> 'et_divi_mobile_menu',
		'settings'	=> 'et_divi[mobile_primary_nav_bg]',
	) ) );

	$wp_customize->add_setting( 'et_divi[secondary_nav_bg]', array(
		'default'		=> et_get_option( 'accent_color', '#2ea3f2' ),
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[secondary_nav_bg]', array(
		'label'		=> esc_html__( 'Background Color', 'Divi' ),
		'section'	=> 'et_divi_header_secondary',
		'settings'	=> 'et_divi[secondary_nav_bg]',
	) ) );

	$wp_customize->add_setting( 'et_divi[secondary_nav_text_color_new]', array(
		'default'		=> '#ffffff',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[secondary_nav_text_color_new]', array(
		'label'		=> esc_html__( 'Text Color', 'Divi' ),
		'section'	=> 'et_divi_header_secondary',
		'settings'	=> 'et_divi[secondary_nav_text_color_new]',
	) ) );

	$wp_customize->add_setting( 'et_divi[secondary_nav_dropdown_bg]', array(
		'default'		=> et_get_option( 'secondary_nav_bg', et_get_option( 'accent_color', '#2ea3f2' ) ),
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[secondary_nav_dropdown_bg]', array(
		'label'		=> esc_html__( 'Dropdown Menu Background Color', 'Divi' ),
		'section'	=> 'et_divi_header_secondary',
		'settings'	=> 'et_divi[secondary_nav_dropdown_bg]',
	) ) );

	$wp_customize->add_setting( 'et_divi[secondary_nav_dropdown_link_color]', array(
		'default'		=> et_get_option( 'secondary_nav_text_color_new', '#ffffff' ),
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[secondary_nav_dropdown_link_color]', array(
		'label'		=> esc_html__( 'Dropdown Menu Text Color', 'Divi' ),
		'section'	=> 'et_divi_header_secondary',
		'settings'	=> 'et_divi[secondary_nav_dropdown_link_color]',
	) ) );

	$wp_customize->add_setting( 'et_divi[secondary_nav_dropdown_animation]', array(
		'default'       => 'fade',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_dropdown_animation',
	) );

	$wp_customize->add_control( 'et_divi[secondary_nav_dropdown_animation]', array(
		'label'		=> esc_html__( 'Dropdown Menu Animation', 'Divi' ),
		'section'	=> 'et_divi_header_secondary',
		'type'      => 'select',
		'choices'	=> et_divi_dropdown_animation_choices(),
	) );

	// Setting with no control kept for backwards compatbility
	$wp_customize->add_setting( 'et_divi[primary_nav_text_color]', array(
		'default'       => 'dark',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	// Setting with no control kept for backwards compatbility
	$wp_customize->add_setting( 'et_divi[secondary_nav_text_color]', array(
		'default'       => 'light',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	if ( 'on' === et_get_option( 'divi_fixed_nav', 'on' ) ) {
		$wp_customize->add_setting( 'et_divi[hide_fixed_logo]', array(
			'type'			=> 'option',
			'capability'	=> 'edit_theme_options',
			'transport'		=> 'postMessage',
			'sanitize_callback' => 'wp_validate_boolean',
		) );

		$wp_customize->add_control( 'et_divi[hide_fixed_logo]', array(
			'label'		=> esc_html__( 'Hide Logo Image', 'Divi' ),
			'section'	=> 'et_divi_header_fixed',
			'type'      => 'checkbox',
		) );

		$wp_customize->add_setting( 'et_divi[minimized_menu_height]', array(
			'default'       => '40',
			'type'          => 'option',
			'capability'    => 'edit_theme_options',
			'transport'     => 'postMessage',
			'sanitize_callback' => 'absint',
		) );

		$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[minimized_menu_height]', array(
			'label'	      => esc_html__( 'Fixed Menu Height', 'Divi' ),
			'section'     => 'et_divi_header_fixed',
			'type'        => 'range',
			'input_attrs' => array(
				'min'  => 30,
				'max'  => 300,
				'step' => 1
			),
		) ) );

		$wp_customize->add_setting( 'et_divi[fixed_primary_nav_font_size]', array(
			'default'       => et_get_option( 'primary_nav_font_size', '14' ),
			'type'          => 'option',
			'capability'    => 'edit_theme_options',
			'transport'     => 'postMessage',
			'sanitize_callback' => 'absint',
		) );

		$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[fixed_primary_nav_font_size]', array(
			'label'	      => esc_html__( 'Text Size', 'Divi' ),
			'section'     => 'et_divi_header_fixed',
			'type'        => 'range',
			'input_attrs' => array(
				'min'  => 12,
				'max'  => 24,
				'step' => 1
			),
		) ) );

		$wp_customize->add_setting( 'et_divi[fixed_primary_nav_bg]', array(
			'default'		=> et_get_option( 'primary_nav_bg', '#ffffff' ),
			'type'			=> 'option',
			'capability'	=> 'edit_theme_options',
			'transport'		=> 'postMessage',
			'sanitize_callback' => 'et_sanitize_alpha_color',
		) );

		$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[fixed_primary_nav_bg]', array(
			'label'		=> esc_html__( 'Primary Menu Background Color', 'Divi' ),
			'section'	=> 'et_divi_header_fixed',
			'settings'	=> 'et_divi[fixed_primary_nav_bg]',
		) ) );

		$wp_customize->add_setting( 'et_divi[fixed_secondary_nav_bg]', array(
			'default'		=> et_get_option( 'secondary_nav_bg', '#2ea3f2' ),
			'type'			=> 'option',
			'capability'	=> 'edit_theme_options',
			'transport'		=> 'postMessage',
			'sanitize_callback' => 'et_sanitize_alpha_color',
		) );

		$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[fixed_secondary_nav_bg]', array(
			'label'		=> esc_html__( 'Secondary Menu Background Color', 'Divi' ),
			'section'	=> 'et_divi_header_fixed',
			'settings'	=> 'et_divi[fixed_secondary_nav_bg]',
		) ) );

		$wp_customize->add_setting( 'et_divi[fixed_menu_link]', array(
			'default'       => et_get_option( 'menu_link', 'rgba(0,0,0,0.6)' ),
			'type'			=> 'option',
			'capability'	=> 'edit_theme_options',
			'transport'		=> 'postMessage',
			'sanitize_callback' => 'et_sanitize_alpha_color',
		) );

		$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[fixed_menu_link]', array(
			'label'		=> esc_html__( 'Primary Menu Link Color', 'Divi' ),
			'section'	=> 'et_divi_header_fixed',
			'settings'	=> 'et_divi[fixed_menu_link]',
		) ) );

		$wp_customize->add_setting( 'et_divi[fixed_secondary_menu_link]', array(
			'default'       => et_get_option( 'secondary_nav_text_color_new', '#ffffff' ),
			'type'			=> 'option',
			'capability'	=> 'edit_theme_options',
			'transport'		=> 'postMessage',
			'sanitize_callback' => 'et_sanitize_alpha_color',
		) );

		$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[fixed_secondary_menu_link]', array(
			'label'		=> esc_html__( 'Secondary Menu Link Color', 'Divi' ),
			'section'	=> 'et_divi_header_fixed',
			'settings'	=> 'et_divi[fixed_secondary_menu_link]',
		) ) );

		$wp_customize->add_setting( 'et_divi[fixed_menu_link_active]', array(
			'default'       => et_get_option( 'menu_link_active', '#2ea3f2' ),
			'type'			=> 'option',
			'capability'	=> 'edit_theme_options',
			'transport'		=> 'postMessage',
			'sanitize_callback' => 'et_sanitize_alpha_color',
		) );

		$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[fixed_menu_link_active]', array(
			'label'		=> esc_html__( 'Active Primary Menu Link Color', 'Divi' ),
			'section'	=> 'et_divi_header_fixed',
			'settings'	=> 'et_divi[fixed_menu_link_active]',
		) ) );
	}

	$wp_customize->add_setting( 'et_divi[phone_number]', array(
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_html_input_text',
	) );

	$wp_customize->add_control( 'et_divi[phone_number]', array(
		'label'		=> esc_html__( 'Phone Number', 'Divi' ),
		'section'	=> 'et_divi_header_information',
		'type'      => 'text',
	) );

	$wp_customize->add_setting( 'et_divi[header_email]', array(
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'sanitize_email',
	) );

	$wp_customize->add_control( 'et_divi[header_email]', array(
		'label'		=> esc_html__( 'Email', 'Divi' ),
		'section'	=> 'et_divi_header_information',
		'type'      => 'text',
	) );

	$wp_customize->add_setting( 'et_divi[show_footer_social_icons]', array(
		'default'       => 'on',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'wp_validate_boolean',
	) );

	$wp_customize->add_control( 'et_divi[show_footer_social_icons]', array(
		'label'		=> esc_html__( 'Show Social Icons', 'Divi' ),
		'section'	=> 'et_divi_footer_elements',
		'type'      => 'checkbox',
	) );

	$wp_customize->add_setting( 'et_divi[footer_columns]', array(
		'default'       => '4',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'et_sanitize_footer_column',
	) );

	$wp_customize->add_control( 'et_divi[footer_columns]', array(
		'label'		=> esc_html__( 'Column Layout', 'Divi' ),
		'section'	=> 'et_divi_footer_layout',
		'settings'	=> 'et_divi[footer_columns]',
		'type'		=> 'select',
		'choices'	=> et_divi_footer_column_choices(),
	) );

	$wp_customize->add_setting( 'et_divi[footer_bg]', array(
		'default'		=> '#222222',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[footer_bg]', array(
		'label'		=> esc_html__( 'Footer Background Color', 'Divi' ),
		'section'	=> 'et_divi_footer_layout',
		'settings'	=> 'et_divi[footer_bg]',
	) ) );

	$wp_customize->add_setting( 'et_divi[widget_header_font_size]', array(
		'default'       => absint( et_get_option( 'body_header_size', '30' ) ) * .6,
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[widget_header_font_size]', array(
		'label'	      => esc_html__( 'Header Text Size', 'Divi' ),
		'section'     => 'et_divi_footer_widgets',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 10,
			'max'  => 72,
			'step' => 1,
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[widget_header_font_style]', array(
		'default'       => et_get_option( 'widget_header_font_style', '' ),
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'et_sanitize_font_style',
	) );

	$wp_customize->add_control( new ET_Divi_Font_Style_Option ( $wp_customize, 'et_divi[widget_header_font_style]', array(
		'label'	      => esc_html__( 'Header Font Style', 'Divi' ),
		'section'     => 'et_divi_footer_widgets',
		'type'        => 'font_style',
		'choices'     => et_divi_font_style_choices(),
	) ) );

	$wp_customize->add_setting( 'et_divi[widget_body_font_size]', array(
		'default'       => et_get_option( 'body_font_size', '14' ),
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[widget_body_font_size]', array(
		'label'	      => esc_html__( 'Body/Link Text Size', 'Divi' ),
		'section'     => 'et_divi_footer_widgets',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 10,
			'max'  => 32,
			'step' => 1,
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[widget_body_line_height]', array(
		'default'       => '1.7',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'et_sanitize_float_number',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[widget_body_line_height]', array(
		'label'	      => esc_html__( 'Body/Link Line Height', 'Divi' ),
		'section'     => 'et_divi_footer_widgets',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 0.8,
			'max'  => 3,
			'step' => 0.1,
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[widget_body_font_style]', array(
		'default'       => et_get_option( 'footer_widget_body_font_style', '' ),
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'et_sanitize_font_style',
	) );

	$wp_customize->add_control( new ET_Divi_Font_Style_Option ( $wp_customize, 'et_divi[widget_body_font_style]', array(
		'label'	      => esc_html__( 'Body Font Style', 'Divi' ),
		'section'     => 'et_divi_footer_widgets',
		'type'        => 'font_style',
		'choices'     => et_divi_font_style_choices(),
	) ) );

	$wp_customize->add_setting( 'et_divi[footer_widget_text_color]', array(
		'default'		=> '#fff',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[footer_widget_text_color]', array(
		'label'		=> esc_html__( 'Widget Text Color', 'Divi' ),
		'section'	=> 'et_divi_footer_widgets',
		'settings'	=> 'et_divi[footer_widget_text_color]',
	) ) );

	$wp_customize->add_setting( 'et_divi[footer_widget_link_color]', array(
		'default'		=> '#fff',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[footer_widget_link_color]', array(
		'label'		=> esc_html__( 'Widget Link Color', 'Divi' ),
		'section'	=> 'et_divi_footer_widgets',
		'settings'	=> 'et_divi[footer_widget_link_color]',
	) ) );

	$wp_customize->add_setting( 'et_divi[footer_widget_header_color]', array(
		'default'		=> et_get_option( 'accent_color', '#2ea3f2' ),
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[footer_widget_header_color]', array(
		'label'		=> esc_html__( 'Widget Header Color', 'Divi' ),
		'section'	=> 'et_divi_footer_widgets',
		'settings'	=> 'et_divi[footer_widget_header_color]',
	) ) );

	$wp_customize->add_setting( 'et_divi[footer_widget_bullet_color]', array(
		'default'		=> et_get_option( 'accent_color', '#2ea3f2' ),
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[footer_widget_bullet_color]', array(
		'label'		=> esc_html__( 'Widget Bullet Color', 'Divi' ),
		'section'	=> 'et_divi_footer_widgets',
		'settings'	=> 'et_divi[footer_widget_bullet_color]',
	) ) );

	/* Footer Menu */
	$wp_customize->add_setting( 'et_divi[footer_menu_background_color]', array(
		'default'		=> 'rgba(255,255,255,0.05)',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[footer_menu_background_color]', array(
		'label'		=> esc_html__( 'Footer Menu Background Color', 'Divi' ),
		'section'	=> 'et_divi_footer_menu',
		'settings'	=> 'et_divi[footer_menu_background_color]',
	) ) );

	$wp_customize->add_setting( 'et_divi[footer_menu_text_color]', array(
		'default'		=> '#bbbbbb',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[footer_menu_text_color]', array(
		'label'		=> esc_html__( 'Footer Menu Text Color', 'Divi' ),
		'section'	=> 'et_divi_footer_menu',
		'settings'	=> 'et_divi[footer_menu_text_color]',
	) ) );

	$wp_customize->add_setting( 'et_divi[footer_menu_active_link_color]', array(
		'default'		=> et_get_option( 'accent_color', '#2ea3f2' ),
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[footer_menu_active_link_color]', array(
		'label'		=> esc_html__( 'Footer Menu Active Link Color', 'Divi' ),
		'section'	=> 'et_divi_footer_menu',
		'settings'	=> 'et_divi[footer_menu_active_link_color]',
	) ) );

	$wp_customize->add_setting( 'et_divi[footer_menu_letter_spacing]', array(
		'default'       => '0',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[footer_menu_letter_spacing]', array(
		'label'	      => esc_html__( 'Letter Spacing', 'Divi' ),
		'section'     => 'et_divi_footer_menu',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 0,
			'max'  => 20,
			'step' => 1,
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[footer_menu_font_style]', array(
		'default'       => et_get_option( 'footer_footer_menu_font_style', '' ),
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'et_sanitize_font_style',
	) );

	$wp_customize->add_control( new ET_Divi_Font_Style_Option ( $wp_customize, 'et_divi[footer_menu_font_style]', array(
		'label'	      => esc_html__( 'Font Style', 'Divi' ),
		'section'     => 'et_divi_footer_menu',
		'type'        => 'font_style',
		'choices'     => et_divi_font_style_choices(),
	) ) );

	$wp_customize->add_setting( 'et_divi[footer_menu_font_size]', array(
		'default'       => '14',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[footer_menu_font_size]', array(
		'label'	      => esc_html__( 'Font Size', 'Divi' ),
		'section'     => 'et_divi_footer_menu',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 10,
			'max'  => 32,
			'step' => 1,
		),
	) ) );

	/* Bottom Bar */
	$wp_customize->add_setting( 'et_divi[bottom_bar_background_color]', array(
		'default'		=> 'rgba(0,0,0,0.32)',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[bottom_bar_background_color]', array(
		'label'		=> esc_html__( 'Background Color', 'Divi' ),
		'section'	=> 'et_divi_bottom_bar',
		'settings'	=> 'et_divi[bottom_bar_background_color]',
	) ) );

	$wp_customize->add_setting( 'et_divi[bottom_bar_text_color]', array(
		'default'		=> '#666666',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[bottom_bar_text_color]', array(
		'label'		=> esc_html__( 'Text Color', 'Divi' ),
		'section'	=> 'et_divi_bottom_bar',
		'settings'	=> 'et_divi[bottom_bar_text_color]',
	) ) );

	$wp_customize->add_setting( 'et_divi[bottom_bar_font_style]', array(
		'default'       => et_get_option( 'footer_bottom_bar_font_style', '' ),
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'et_sanitize_font_style',
	) );

	$wp_customize->add_control( new ET_Divi_Font_Style_Option ( $wp_customize, 'et_divi[bottom_bar_font_style]', array(
		'label'	      => esc_html__( 'Font Style', 'Divi' ),
		'section'     => 'et_divi_bottom_bar',
		'type'        => 'font_style',
		'choices'     => et_divi_font_style_choices(),
	) ) );

	$wp_customize->add_setting( 'et_divi[bottom_bar_font_size]', array(
		'default'       => '14',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[bottom_bar_font_size]', array(
		'label'	      => esc_html__( 'Font Size', 'Divi' ),
		'section'     => 'et_divi_bottom_bar',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 10,
			'max'  => 32,
			'step' => 1,
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[bottom_bar_social_icon_size]', array(
		'default'       => '24',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[bottom_bar_social_icon_size]', array(
		'label'	      => esc_html__( 'Social Icon Size', 'Divi' ),
		'section'     => 'et_divi_bottom_bar',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 10,
			'max'  => 32,
			'step' => 1,
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[bottom_bar_social_icon_color]', array(
		'default'		=> '#666666',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[bottom_bar_social_icon_color]', array(
		'label'		=> esc_html__( 'Social Icon Color', 'Divi' ),
		'section'	=> 'et_divi_bottom_bar',
		'settings'	=> 'et_divi[bottom_bar_social_icon_color]',
	) ) );

	$wp_customize->add_setting( 'et_divi[disable_custom_footer_credits]', array(
		'type'              => 'option',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_validate_boolean',
	) );

	$wp_customize->add_control( 'et_divi[disable_custom_footer_credits]', array(
		'label'   => esc_html__( 'Disable Footer Credits', 'Divi' ),
		'section' => 'et_divi_bottom_bar',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'et_divi[custom_footer_credits]', array(
		'default'           => '',
		'type'              => 'option',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'et_sanitize_html_input_text',
	) );

	$wp_customize->add_control( 'et_divi[custom_footer_credits]', array(
		'label'    => esc_html__( 'Edit Footer Credits', 'Divi' ),
		'section'  => 'et_divi_bottom_bar',
		'settings' => 'et_divi[custom_footer_credits]',
		'type'     => 'textarea',
	) );

	$wp_customize->add_setting( 'et_divi[all_buttons_font_size]', array(
		'default'       => ET_Global_Settings::get_value( 'all_buttons_font_size', 'default' ),
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[all_buttons_font_size]', array(
		'label'	      => esc_html__( 'Text Size', 'Divi' ),
		'section'     => 'et_divi_buttons',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 30,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[all_buttons_text_color]', array(
		'default'		=> '#ffffff',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[all_buttons_text_color]', array(
		'label'		=> esc_html__( 'Text Color', 'Divi' ),
		'section'	=> 'et_divi_buttons',
		'settings'	=> 'et_divi[all_buttons_text_color]',
	) ) );

	$wp_customize->add_setting( 'et_divi[all_buttons_bg_color]', array(
		'default'		=> 'rgba(0,0,0,0)',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[all_buttons_bg_color]', array(
		'label'		=> esc_html__( 'Background Color', 'Divi' ),
		'section'	=> 'et_divi_buttons',
		'settings'	=> 'et_divi[all_buttons_bg_color]',
	) ) );

	$wp_customize->add_setting( 'et_divi[all_buttons_border_width]', array(
		'default'       => ET_Global_Settings::get_value( 'all_buttons_border_width', 'default' ),
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[all_buttons_border_width]', array(
		'label'	      => esc_html__( 'Border Width', 'Divi' ),
		'section'     => 'et_divi_buttons',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 0,
			'max'  => 10,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[all_buttons_border_color]', array(
		'default'		=> '#ffffff',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[all_buttons_border_color]', array(
		'label'		=> esc_html__( 'Border Color', 'Divi' ),
		'section'	=> 'et_divi_buttons',
		'settings'	=> 'et_divi[all_buttons_border_color]',
	) ) );

	$wp_customize->add_setting( 'et_divi[all_buttons_border_radius]', array(
		'default'       => ET_Global_Settings::get_value( 'all_buttons_border_radius', 'default' ),
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[all_buttons_border_radius]', array(
		'label'	      => esc_html__( 'Border Radius', 'Divi' ),
		'section'     => 'et_divi_buttons',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 0,
			'max'  => 50,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[all_buttons_spacing]', array(
		'default'       => ET_Global_Settings::get_value( 'all_buttons_spacing', 'default' ),
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'et_sanitize_int_number',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[all_buttons_spacing]', array(
		'label'	      => esc_html__( 'Letter Spacing', 'Divi' ),
		'section'     => 'et_divi_buttons',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => -2,
			'max'  => 10,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[all_buttons_font_style]', array(
		'default'       => '',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'et_sanitize_font_style',
	) );

	$wp_customize->add_control( new ET_Divi_Font_Style_Option ( $wp_customize, 'et_divi[all_buttons_font_style]', array(
		'label'	      => esc_html__( 'Button Font Style', 'Divi' ),
		'section'     => 'et_divi_buttons',
		'type'        => 'font_style',
		'choices'     => et_divi_font_style_choices(),
	) ) );

	if ( ! isset( $et_one_font_languages[$site_domain] ) ) {
		$wp_customize->add_setting( 'et_divi[all_buttons_font]', array(
			'default'		=> 'none',
			'type'			=> 'option',
			'capability'	=> 'edit_theme_options',
			'transport'		=> 'postMessage',
			'sanitize_callback' => 'et_sanitize_font_choices',
		) );

		$wp_customize->add_control( new ET_Divi_Select_Option ( $wp_customize, 'et_divi[all_buttons_font]', array(
			'label'		=> esc_html__( 'Buttons Font', 'Divi' ),
			'section'	=> 'et_divi_buttons',
			'settings'	=> 'et_divi[all_buttons_font]',
			'type'		=> 'select',
			'choices'	=> $font_choices
		) ) );
	}

	$wp_customize->add_setting( 'et_divi[all_buttons_icon]', array(
		'default'       => 'yes',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'sanitize_callback' => 'et_sanitize_yes_no',
	) );

	$wp_customize->add_control( 'et_divi[all_buttons_icon]', array(
		'label'		=> esc_html__( 'Add Button Icon', 'Divi' ),
		'section'	=> 'et_divi_buttons',
		'type'      => 'select',
		'choices'	=> et_divi_yes_no_choices(),
	) );

	$wp_customize->add_setting( 'et_divi[all_buttons_selected_icon]', array(
		'default'       => '5',
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'et_sanitize_font_icon',
	) );

	$wp_customize->add_control( new ET_Divi_Icon_Picker_Option ( $wp_customize, 'et_divi[all_buttons_selected_icon]', array(
		'label'	      => esc_html__( 'Select Icon', 'Divi' ),
		'section'     => 'et_divi_buttons',
		'type'        => 'icon_picker',
	) ) );

	$wp_customize->add_setting( 'et_divi[all_buttons_icon_color]', array(
		'default'		=> '#ffffff',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[all_buttons_icon_color]', array(
		'label'		=> esc_html__( 'Icon Color', 'Divi' ),
		'section'	=> 'et_divi_buttons',
		'settings'	=> 'et_divi[all_buttons_icon_color]',
	) ) );

	$wp_customize->add_setting( 'et_divi[all_buttons_icon_placement]', array(
		'default'       => 'right',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_left_right',
	) );

	$wp_customize->add_control( 'et_divi[all_buttons_icon_placement]', array(
		'label'		=> esc_html__( 'Icon Placement', 'Divi' ),
		'section'	=> 'et_divi_buttons',
		'type'      => 'select',
		'choices'	=> et_divi_left_right_choices(),
	) );

	$wp_customize->add_setting( 'et_divi[all_buttons_icon_hover]', array(
		'default'       => 'yes',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_yes_no',
	) );

	$wp_customize->add_control( 'et_divi[all_buttons_icon_hover]', array(
		'label'		=> esc_html__( 'Only Show Icon on Hover', 'Divi' ),
		'section'	=> 'et_divi_buttons',
		'type'      => 'select',
		'choices'	=> et_divi_yes_no_choices(),
	) );

	$wp_customize->add_setting( 'et_divi[all_buttons_text_color_hover]', array(
		'default'		=> '#ffffff',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[all_buttons_text_color_hover]', array(
		'label'		=> esc_html__( 'Text Color', 'Divi' ),
		'section'	=> 'et_divi_buttons_hover',
		'settings'	=> 'et_divi[all_buttons_text_color_hover]',
	) ) );

	$wp_customize->add_setting( 'et_divi[all_buttons_bg_color_hover]', array(
		'default'		=> 'rgba(255,255,255,0.2)',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[all_buttons_bg_color_hover]', array(
		'label'		=> esc_html__( 'Background Color', 'Divi' ),
		'section'	=> 'et_divi_buttons_hover',
		'settings'	=> 'et_divi[all_buttons_bg_color_hover]',
	) ) );

	$wp_customize->add_setting( 'et_divi[all_buttons_border_color_hover]', array(
		'default'		=> 'rgba(0,0,0,0)',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage',
		'sanitize_callback' => 'et_sanitize_alpha_color',
	) );

	$wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'et_divi[all_buttons_border_color_hover]', array(
		'label'		=> esc_html__( 'Border Color', 'Divi' ),
		'section'	=> 'et_divi_buttons_hover',
		'settings'	=> 'et_divi[all_buttons_border_color_hover]',
	) ) );

	$wp_customize->add_setting( 'et_divi[all_buttons_border_radius_hover]', array(
		'default'       => ET_Global_Settings::get_value( 'all_buttons_border_radius_hover', 'default' ),
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[all_buttons_border_radius_hover]', array(
		'label'	      => esc_html__( 'Border Radius', 'Divi' ),
		'section'     => 'et_divi_buttons_hover',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 0,
			'max'  => 50,
			'step' => 1
		),
	) ) );

	$wp_customize->add_setting( 'et_divi[all_buttons_spacing_hover]', array(
		'default'       => ET_Global_Settings::get_value( 'all_buttons_spacing_hover', 'default' ),
		'type'          => 'option',
		'capability'    => 'edit_theme_options',
		'transport'     => 'postMessage',
		'sanitize_callback' => 'et_sanitize_int_number',
	) );

	$wp_customize->add_control( new ET_Divi_Range_Option ( $wp_customize, 'et_divi[all_buttons_spacing_hover]', array(
		'label'	      => esc_html__( 'Letter Spacing', 'Divi' ),
		'section'     => 'et_divi_buttons_hover',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => -2,
			'max'  => 10,
			'step' => 1
		),
	) ) );
}

add_shortcode('highlight', function(){
    $highlight = '';

    $posts = get_posts(array(
        'post_type' => 'highlight',
        'numberposts' => 3,
    ));
    $button_text = __('Be inspired more', 'divi-child');

    foreach($posts as $item) {
        $button_link = get_post_meta($item->ID, 'link', true) ?: '#';
        $att_id = get_post_thumbnail_id($item);
        $image = laregina_get_attachment_image_src($att_id, 'highlight');
        
        ob_start();
        get_template_part('templates/highlight-slider');
        $str = ob_get_clean();

        $highlight .= str_replace(
            array('background_image="#"', 'heading="#"', 'button_text="#"', 'button_link="#"', '[content]'),
            array('background_image="'.$image.'"', 'heading="'.$item->post_title.'"', 'button_text="'.$button_text.'"', 'button_link="'.$button_link.'"', $item->post_content),
            $str
        );
    }
    return do_shortcode($highlight);
});

add_shortcode('tab_mobile', function(){
	$current_lang = pll_current_language();
	$link =  $current_lang=='en'?home_url():substr( esc_url( home_url( '/' ) ),0,-3);
	$link_img = $link.'/wp-content/themes/mundo/icon/whatsapp-mobile.png';
        $str = "<div class='mobile-tab'>
        	<div class='mobile-tab-left'><a href='tel:".ot_get_option( 'vietnam')."'><span class='phone-icon'></span> Call Now</a></div>
        	<div class='mobile-tab-right'><a href='".ot_get_option( 'whatsapp')."'><span class='whatsapp-icon'></span> Whatsapp</a></div>
        	<div class='clear-both'></div>
        </div>";
    return $str;
});

add_shortcode('guest_review', function($atts){
    $atts = shortcode_atts( array(
		'type' => '',
	), $atts, 'guest_review' );
    
    $posts = get_posts(array(
        'post_type' => 'guest_review',
        'numberposts' => 5,
        'tax_query' => array(
            'review-category' => array(
                'taxonomy' => 'review-category',
    			'field'    => 'slug',
    			'terms'    => $atts['type'],
            ),
        ),
    ));
    $guest_review = '';
    
    if($posts) {
        $slide = '';
        foreach($posts as $item) {
            ob_start();
            get_template_part('templates/guest-review-slide');
            $str = ob_get_clean();
            $slide .= str_replace('[review_content]', $item->post_content, $str);
        }
        ob_start();
        get_template_part('templates/guest-review-slider');
        $slider = ob_get_clean();
        $slider = str_replace('[review_slide]', $slide, $slider);
        
        $guest_review = do_shortcode($slider);
    }
    $term = get_term_by('slug', $atts['type'], 'review-category');
    
    if($term) {
        $link = get_term_meta($term->term_id, 'link', true) ?: '#';
        $logo = rwmb_meta( 'logo', array( 'object_type' => 'term', 'limit' => 1 ), $term->term_id );
        $logo = reset($logo);
        
        if($link) {
            $guest_review .= '<div class="et_pb_button_wrapper">
                <a href="'.$link.'" class="et_pb_more_button et_pb_button">'.sprintf( __( 'View %s', 'divi-child'), $term->name ).'</a></div>';
        }
        if($logo) {
            $guest_review .= '<div class="cat-logo"><img src="'.$logo['full_url'].'" alt="'.$term->name.'" /></div>';
        }

    }
    return $guest_review;
});
// add_filter('post_owlCarousel_post_thumb', function($thumb, $post, $module_id) {
//     if($module_id == 'package_home') {
//         $thumbnail_id = get_post_thumbnail_id($post);
//         if($thumbnail_id) {
//             $src = laregina_get_attachment_image_src($thumbnail_id, 'package');
//             $thumb = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
//         }
//     }
//     return $thumb;
// }, 10, 3);

//Phần mundo 
add_action('after_setup_theme', function() {
    if ( function_exists( 'fly_add_image_size' ) ) {
    	fly_add_image_size( 'doi_tac', 150, 100, array( 'center', 'center' ) );
    }
});

function mundo_get_attachment_image_src( $att_id, $image_size ) {
    if( function_exists( 'fly_get_attachment_image_src' ) ) {
    	if ($att_id) {
    		$image = fly_get_attachment_image_src( $att_id, $image_size );
        	return $image['src'];
    	}
        
    }
    return 'fly_get_attachment_image_src';
}
add_filter('post_owlCarousel_post_thumb', function($thumb, $post, $module_id) {
    // if($module_id == 'doi_tac_slider') {
    //     $thumbnail_id = get_post_thumbnail_id($post);
    //     if($thumbnail_id) {
    //         $src = mundo_get_attachment_image_src($thumbnail_id, 'doi_tac');
    //         d($src);
    //         $thumb = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
    //     }
    // }
    if($module_id == 'excursion_relate') {
            $thumbnail_id = get_post_thumbnail_id($post);
            if($thumbnail_id) {
                $src = mundo_get_attachment_image_src($thumbnail_id, 'tour_another');
                $thumb = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
            }
            return $thumb;
        }
    if($module_id == 'relate_excursion_check_out') {
            $thumbnail_id = get_post_thumbnail_id($post);
            if($thumbnail_id) {
                $src = mundo_get_attachment_image_src($thumbnail_id, 'excursion_relate_check');
                $thumb = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
            }
            return $thumb;
        }
    if($module_id == 'excursion_expert_relate') {
            $thumbnail_id = get_post_thumbnail_id($post);
            if($thumbnail_id) {
                $src = mundo_get_attachment_image_src($thumbnail_id, 'post_expert_detination');
                $thumb = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
            }
            return $thumb;
        }
	if($module_id == 'post_destination_page') {
            $thumbnail_id = get_post_thumbnail_id($post);
            if($thumbnail_id) {
                $src = mundo_get_attachment_image_src($thumbnail_id, 'post_home');
                $thumb = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
            }
            return $thumb;
        }
    if($module_id == 'sic_destination_page') {
            $thumbnail_id = get_post_thumbnail_id($post);
            if($thumbnail_id) {
                $src = mundo_get_attachment_image_src($thumbnail_id, 'post_home');
                $thumb = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
            }
            return $thumb;
        }
    if($module_id == 'post_home') {
            $thumbnail_id = get_post_thumbnail_id($post);
            if($thumbnail_id) {
                $src = mundo_get_attachment_image_src($thumbnail_id, 'post_home');
                $thumb = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
            }
            return $thumb;
        }
    if($module_id == 'city_of_vietnam') {
        $thumbnail_id = get_post_thumbnail_id($post);
        if($thumbnail_id) {
            $src = mundo_get_attachment_image_src($thumbnail_id, 'city_of_vietnam');
            $thumb = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
        }
    }
    if($module_id == 'post_tour_slider_js') {
        $thumbnail_id = get_post_thumbnail_id($post);
        if($thumbnail_id) {
            $src = mundo_get_attachment_image_src($thumbnail_id, 'tour_another');
            $thumb = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
        }
    }
    if($module_id == 'post_tour_slider_js_mobile') {
        $thumbnail_id = get_post_thumbnail_id($post);
        if($thumbnail_id) {
            $src = mundo_get_attachment_image_src($thumbnail_id, 'tour_another');
            $thumb = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
        }
    }
    return $thumb;
}, 10, 3);
add_filter('post_owlCarousel_options', function($owlCarousel_options, $module_id) {
	if($module_id == 'post_tour_slider_js') {
		$owlCarousel_options['loop'] = true;
        $owlCarousel_options['responsive'] = array(
            0 => array('items' => 1,'stagePadding'=>20,'margin'=>15),
            480 => array('items' => 1,'stagePadding'=>30),
            768 => array('items' => 0.6,'stagePadding'=>30),
            800 => array('items' => 1),
        );
    }
	if($module_id == 'doi_tac') {
		$owlCarousel_options['loop'] = true;
        $owlCarousel_options['autoWidth'] = true;
        $owlCarousel_options['margin'] = 60;
        $owlCarousel_options['navText'] = array('<span></span>', '<span></span>');
        $owlCarousel_options['responsiveClass'] = true;
        $owlCarousel_options['slideBy'] = 4;
        $owlCarousel_options['responsive'] = array(
            0 => array('items' => 1,'stagePadding'=>40),
            550 => array('items' => 2,'stagePadding'=>60),
            768 => array('items' => 2),
            981 => array('items' => 3),
        );
    }
    if($module_id == 'city_of_vietnam') {
    	$owlCarousel_options['loop'] = true;
    	$owlCarousel_options['slideBy'] = 4;
        $owlCarousel_options['responsive'] = array(
    			//0 => array(
				// 	array('items' => 1.5),
				// 	array('stagePadding' => 50),
				// ),
            0 => array('items' => 1,'stagePadding'=>60),
            350 => array('items' => 1,'stagePadding'=>60),
            480 => array('items' => 1,'stagePadding'=>80),
            550 => array('items' => 2,'stagePadding'=>60),
            768 => array('items' => 3),
            981 => array('items' => 4),
        );
    }
    if($module_id == 'tour_highlights') {
    	$owlCarousel_options['loop'] = true;
    	$owlCarousel_options['slideBy'] = 4;
        $owlCarousel_options['responsive'] = array(
    			//0 => array(
				// 	array('items' => 1.5),
				// 	array('stagePadding' => 50),
				// ),
            0 => array('items' => 1,'stagePadding'=>60),
            480 => array('items' => 1,'stagePadding'=>60),
            550 => array('items' => 2,'stagePadding'=>60),
            768 => array('items' => 4),
            981 => array('items' => 4),
        );
    }
    if($module_id == 'thing_to_do_hotel') {
    	$owlCarousel_options['loop'] = true;
    	$owlCarousel_options['slideBy'] = 4;
        $owlCarousel_options['responsive'] = array(
            0 => array('items' => 1,'stagePadding'=>30),
            550 => array('items' => 2,'stagePadding'=>60),
            768 => array('items' => 2),
            981 => array('items' => 3,'slideBy'=>3),
        );
    }
    if($module_id == 'doi_tac_slider') {
    	$owlCarousel_options['loop'] = true;
    	$owlCarousel_options['slideBy'] = 6;
        $owlCarousel_options['responsive'] = array(
            0 => array('items' => 3),
            550 => array('items' => 3,'stagePadding'=>60),
            768 => array('items' => 4),
            981 => array('items' => 6),
        );
        $owlCarousel_options['autoWidth'] = 'true';
    }
    if($module_id == 'expert_about_page') {
    	$owlCarousel_options['slideBy'] = 4;
    	$owlCarousel_options['loop'] = true;
        $owlCarousel_options['responsive'] = array(
            0 => array('items' => 1,'stagePadding'=>80),
            550 => array('items' => 2,'stagePadding'=>60),
            768 => array('items' => 3),
            981 => array('items' => 4),
        );
    }
    if($module_id == 'excursion_expert_relate') {
    	$owlCarousel_options['slideBy'] = 4;
    	$owlCarousel_options['loop'] = true;
    	$owlCarousel_options['margin'] = 30;
        $owlCarousel_options['responsive'] = array(
            0 => array('items' => 1,'stagePadding'=>80),
            550 => array('items' => 2,'stagePadding'=>60),
            768 => array('items' => 3),
            981 => array('items' => 4),
        );
    }
    if($module_id == 'post_home') {
    	$owlCarousel_options['loop'] = true;
    	$owlCarousel_options['slideBy'] = 3;
        $owlCarousel_options['responsive'] = array(
            0 => array('items' => 1,'stagePadding'=>50),
            550 => array('items' => 2,'stagePadding'=>60),
            768 => array('items' => 2),
            981 => array('items' => 3),
        );
    }
    if($module_id == 'excursion_relate') {
    	$owlCarousel_options['loop'] = true;
    	$owlCarousel_options['slideBy'] = 3;
    	$owlCarousel_options['margin'] = 30;
        $owlCarousel_options['responsive'] = array(
            0 => array('items' => 1,'stagePadding'=>50),
            550 => array('items' => 2,'stagePadding'=>60),
            768 => array('items' => 2),
            981 => array('items' => 3),
        );
    }
    if($module_id == 'relate_excursion_check_out') {
    	$owlCarousel_options['loop'] = true;
    	$owlCarousel_options['slideBy'] = 2;
    	$owlCarousel_options['margin'] = 30;
        $owlCarousel_options['responsive'] = array(
            0 => array('items' => 1,'stagePadding'=>50),
            550 => array('items' => 1,'stagePadding'=>60),
            768 => array('items' => 1,'stagePadding'=>80),
            981 => array('items' => 2),
        );
    }
    if($module_id == 'post_destination_page'||$module_id == 'sic_destination_page' || $module_id == 'travel_guide_tour' || $module_id == 'tour_in_list_hotel'
	|| $module_id == 'tour_in_list_restaurant') {
    	$owlCarousel_options['loop'] = true;
    	$owlCarousel_options['slideBy'] = 3;
        $owlCarousel_options['responsive'] = array(
            0 => array('items' => 1,'stagePadding'=>20,'margin'=>15),
            550 => array('items' => 2,'stagePadding'=>60),
            768 => array('items' => 2),
            981 => array('items' => 3),
        );
        //print_r($owlCarousel_options);exit();
    }
    if($module_id == 'departure_month') {
    	$owlCarousel_options['loop'] = true;
    	$owlCarousel_options['slideBy'] = 3;
        $owlCarousel_options['responsive'] = array(
            0 => array('items' => 1,'stagePadding'=>20,'margin'=>15),
            550 => array('items' => 1,'stagePadding'=>60),
            768 => array('items' => 2),
            981 => array('items' => 3),
        );
    }
    if($module_id == 'post_tour_slider_js_mobile') {
    	$owlCarousel_options['loop'] = true;
    	$owlCarousel_options['slideBy'] = 3;
        $owlCarousel_options['responsive'] = array(
            0 => array('items' => 1,'stagePadding'=>20,'margin'=>15),
            550 => array('items' => 1,'stagePadding'=>60),
            768 => array('items' => 2),
            981 => array('items' => 3),
        );
    }
    return $owlCarousel_options;
}, 10, 2);
// add_filter('custom_post_query_args', function($query_args, $module_id) {
//     if( $module_id == 'post_destination_whyus' ) {
//         $query_args['post_type']= 'destination'; 
//         $query_args['meta_query']= array(array(
//                 'key' => 'view_why_us',
//                 'value' => '1',
//                 'compare' => '='
//             ));
//         return $query_args;
//     }
//     return $query_args;
// },9,2); 
add_filter('custom_post_post_thumb',function($image, $post, $module_id) {
    switch ($module_id) {
        case 'post_destination_whyus':
            $thumbnail_id = get_post_thumbnail_id($post);
            if($thumbnail_id) {
                $src = mundo_get_attachment_image_src($thumbnail_id, 'post_destination');
                $image = sprintf('<img src="%s" alt="%s" />', $src, $post->post_title);
            }
            return $image;
        default:
            # code...
            break;
    }
    return $image;
},9,3);
// function get_location_tour($location_id){
//     d($location_id);
//     $post   = get_post( $location_id );
//     $terms = get_terms( 'location_tour', array(
//                         'hide_empty' => false,
//                         'include'=>$location_id
//                     ) );
//     d($terms);
//     $location['id'] = get_term_meta( $location_id, 'location',  true )?:'';
//     $location['description'] = $terms[0]->description?:'';
//     $image_id = get_term_meta( $location_id, 'location_image',  true )?:'';
//     $src = mundo_get_attachment_image_src($image_id, 'map_description');
//     $location['image'] = $src;
//     return $location;
// }
function get_location_tour($location_id){
    $destination   = get_post( $location_id );
    $location['id'] = get_post_meta( $location_id, 'location_maps',  true )?:'';
    $location['description'] = $destination->post_excerpt;
    $image_id = get_post_thumbnail_id($location_id);
    $src = mundo_get_attachment_image_src($image_id, 'map_description');
    $location['image'] = $src;
    return $location;
}
add_action('wp_ajax_nopriv_get_another_travel', 'mundo_get_another_travel');
add_action('wp_ajax_get_another_travel', 'mundo_get_another_travel');
function mundo_get_another_travel(){
    $post_id = ($_POST['post_id'])?:0;
    $title = ($_POST['title'])?:'';
    $tour_info = get_post_meta($post_id,'travel-guide-travel-infomation-gr',true);
			        //tab content
			        $tab_content = '<div class="et_pb_row tab_content_tour_info"';
			        $tab = '';
				    foreach($tour_info as $key => $tour){
				        if($tour['title_travel_info'] == $title){
				            $tab = $key;
				        }
				        
				    }
			        foreach ($tour_info[$tab] as $key => $value){
			            switch ($key){
			                case 'description':
			                    $tab_content .= $value?'<div class="tab_content et_pb_row">'.$value.'</div>':' ';

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
                                        $content .= '<div class=""><b class="text_gray">From:  </b>'.$discount_price_html.' <b class="price'.$discount.' '.$text_gray.'">$'.$price.' </b> <b class=" '.$discount.' text_gray "> per room</b></div>';
                                        $content .= '</a></div>';
                                        $content .= '   </article>';
			                    }
			                    $tab_content .= $content;
			                    break;
			            }
			        }
		$tab_content .= '</div>';
        echo json_encode(array(
            'error' => 0,
            'mess' => '',
            'html' => $tab_content,
        ));
        exit();
}
//Polylang giữ category 
	add_filter( 'pll_copy_taxonomies', function($taxonomies, $sync, $from, $to, $lang ){
		$post_type = get_post_type( $from );
		if($post_type=='destination')
		{
			 $taxonomies['category-destination']='category-destination';
			 $taxonomies['post_tag'] = 'post_tag';
    		 $taxonomies['0'] = 'post_format';
			 return $taxonomies;
		}
		if($post_type=='tour')
		{
			 $taxonomies['travel_style']='travel_style';
			 $taxonomies['post_tag'] = 'post_tag';
    		 $taxonomies['0'] = 'post_format';
			 return $taxonomies;
		}
		
	},10,5);
if ( ! function_exists( 'get_primary_taxonomy_id' ) ) {
    function get_primary_taxonomy_id( $post_id, $taxonomy ) {
        $prm_term = '';
        if (class_exists('WPSEO_Primary_Term')) {
            $wpseo_primary_term = new WPSEO_Primary_Term( $taxonomy, $post_id );
            $prm_term = $wpseo_primary_term->get_primary_term();
        }
        if ( !is_object($wpseo_primary_term) || empty( $prm_term ) ) {
            $term = wp_get_post_terms( $post_id, $taxonomy );
            if (isset( $term ) && !empty( $term ) ) {
                return $term[0]->term_id;
            } else {
                return '';
            }

        }
        return $wpseo_primary_term->get_primary_term();
    }
}
add_filter( 'wp_unique_post_slug',function($slug, $post_ID, $post_status, $post_type, $post_parent, $original_slug){
	// print_r($slug);echo '<br>';
	// print_r($post_ID);echo '<br>';
	// print_r($post_status);echo '<br>';
	// print_r($post_type);echo '<br>';
	// print_r($post_parent);echo '<br>';
	//print_r($original_slug);echo '<br>';exit();
	$current_lang =pll_current_language();
	$terms = get_terms( 'language', array(
	    'hide_empty' => false,
	    'slug' => $current_lang,
	) );
	$lang_id = $terms[0]->term_id;
	global $wpdb;
	$check_sql = "SELECT post_name FROM $wpdb->posts p
					INNER JOIN $wpdb->term_relationships trl ON p.ID = trl.object_id AND trl.term_taxonomy_id = %d
					WHERE post_name = '%s' AND post_type = '%s' AND ID != %d LIMIT 1";
	$post_name_check = $wpdb->get_var( $wpdb->prepare( $check_sql, $lang_id, $original_slug, $post_type, $post_ID ) );
	// echo "SELECT post_name FROM $wpdb->posts p
	// 				INNER JOIN $wpdb->term_relationships trl ON p.ID = trl.object_id AND trl.term_taxonomy_id != $lang_id
	// 				WHERE post_name = $original_slug AND post_type = $post_type AND ID != $post_ID LIMIT 1";exit();
	//Nếu 1 post trong 1 post type mà có post name như nhập và ngôn ngữ giống ngôn ngữ hiện tại thì , slug  tăng như họ. Nếu ko thì slug giữ nguyên
	if ($post_name_check ) {
		return  $slug;
	}else{
		return  $original_slug; 
	}

},10,6  );
add_action('init',function(){
	function get_main_lang_tour($post_id){
		$current_lang = pll_current_language();
                $tour_guides = wp_get_post_terms($post_id,'tour_guide',array());
                $i= 0;
                $primary_term = get_primary_taxonomy_id($post_id,'tour_guide');
                foreach($tour_guides as $tour){
                    $tour_name = pll__($tour->name);
                    $tour_term_id = $value->term_id;
                    $i++;
                };
                if(function_exists('yoast_get_primary_term_id')) {
                    $primary_term = yoast_get_primary_term_id( 'tour_guide', $post );
                }
                if($primary_term){
                    if ($i == 1) {
                        $tour_html = $tour_name;
                    }elseif($i==2){
                        foreach ($tour_guides as $key => $value) {
                            if ($value->term_id == $primary_term) {
                                $tour_html .= pll__($value->name);
                                $tour_lang_main = $value->term_id;
                            }
                        }
                        foreach ($tour_guides as $key => $value) {
                            if ($value->term_id != $primary_term) {
                                if ($current_lang=='es') {
                                    //$tour_html .= ' ( '.__('Available','Mundo').' '.pll__($value->name).')';
                                    //$tour_html .= __('(available','Mundo').' '.pll__($value->name).')';
                                    $tour_html .= ' (También disponible en '.pll__($value->name).')';
                                }else{
                                    $tour_html .= ' ( '.pll__($value->name).' '.__('(available','Mundo').')';
                                    //$tour_html .= ' ( '.pll__($value->name).' '.'available)';
                                }
                            }
                        }
                    }else{
                        foreach ($tour_guides as $key => $value) {
                            if ($value->term_id == $primary_term) {
                                $tour_html = pll__($value->name);
                                $tour_lang_main = $value->term_id;
                            }
                        }
                        foreach ($tour_guides as $key => $value) {
                            if ($value->term_id != $primary_term) {
                                $tour_html_arr[] = pll__($value->name);

                            }
                        }

                        $tour_html_text = implode( ' '.__('or','Mundo').' ', $tour_html_arr);
                        $current_lang = pll_current_language();
                        if ($current_lang=='es') {
                            //$tour_html .= ' ('.__('Available','Mundo').' '.$tour_html_text.')';
                            //$tour_html .= __('(available','Mundo').' '.pll__($value->name).')';
                            $tour_html .= ' (También disponible en '.$tour_html_text.')';
                        }else{
                            $tour_html .= ' ('.$tour_html_text.' '.__('available','Mundo').')';
                        }
                    }
                }else{
                    $current_lang = pll_current_language();
                    if ($i == 1) {
                        $tour_html = $tour_name;
                        $tour_lang_main = $tour_term_id;
                    }elseif($i==2){
                        foreach ($tour_guides as $key => $value) {
                            if ($value->description == $current_lang) {
                                $tour_html .= pll__($value->name);
                                $tour_lang_main = $value->term_id;
                                $tour_html_first = $value->description;
                            }
                            //echo $tour_html;exit();
                            if (!$tour_html && $current_lang=='pt' && $value->description == 'es') {
                                $tour_html .= pll__($value->name);
                                $tour_lang_main = $value->term_id;
                                $tour_html_first = $value->description;
                            }
                        }
                        foreach ($tour_guides as $key => $value) {
                            if ($tour_html_first != $value->description) {
                                if ($current_lang=='es') {
                                    //$tour_html .= ' ('.__('Available','Mundo').' '.pll__($value->name).')';
                                   // $tour_html .= __('(available','Mundo').' '.pll__($value->name).')';
                                    $tour_html .= ' (También disponible en '.pll__($value->name).')';
                                }else{
                                    $tour_html .= ' ('.pll__($value->name).' '.'available'.')';
                                }
                            }
                        }
                    }else{
                        foreach ($tour_guides as $key => $value) {
                            if ($value->description == $current_lang) {
                                $tour_html .= pll__($value->name);
                                $tour_lang_main = $value->term_id;
                                $tour_html_first = $value->description;
                            }
                            if (!$tour_html && $current_lang=='pt' && $value->description == 'es') {
                                $tour_html .= pll__($value->name);
                                $tour_lang_main = $value->term_id;
                                $tour_html_first = $value->description;
                            }
                        }
                        foreach ($tour_guides as $key => $value) {
                            if ( $tour_html_first != $value->description) {
                                $tour_html_arr[] = pll__($value->name);
                            }
                        }

                        $tour_html_text = implode(' '.__('or','Mundo').' ', $tour_html_arr);
                        $current_lang = pll_current_language();
                        
                        if ($current_lang=='es') {
                            //$tour_html .= ' ('.__('Available','Mundo').' '.$tour_html_text.')';
                            //$tour_html .= __('(available','Mundo').' '.$tour_html_text.')';
                            $tour_html .= ' (También disponible en '.$tour_html_text.')';
                        }else{
                            $tour_html .= ' ('.$tour_html_text.' '.__('available','Mundo').')';
                        }
                        
                    }
                }
                $tour_guide['tour_html']=$tour_html;
                $tour_guide['main_lang']=$tour_lang_main;
                return $tour_guide;
    };
    function get_min_time_tour_rate($post_id){
    	$custom_rate_posts = get_posts(array(
		    'post_type' => 'customize_rate',
		    'posts_per_page' => -1,
		    'meta_query' => array(
		        array(
		            'key' => 'tour_name_customize',
		            'value' => $post_id,
		            'compare' => '='
		        )
		    ),
		));
		if ($custom_rate_posts) {
			$custom_rates = get_post_meta($custom_rate_posts[0]->ID,'group_tour_rate',true);
		}
		//$price_from = mundo_get_price_last_6_month($post_id)?__('$','Mundo').' '.mundo_get_price_last_6_month($post_id):__('On Request','Mundo');
		$price_from = get_post_meta($post_id,'price_from',true);
		$price_from = get_post_meta($post_id,'price_not_guide',true);
	
		$price_from = floor($price_from);
		//print_r($price_from);exit();
		if(!empty($custom_rates)){
			//print_r($custom_rates);exit();
			foreach ($custom_rates as $custom_rate){//chạy vòng lặp qua các khoảng time
			    $from_date = $custom_rate['from_date']['timestamp'];//lấy ngày đầu của khoảng
			    $to_date =  $custom_rate['to_date']['timestamp']; //lấy ngày cuối của khoảng
			    $rate_detail = $custom_rate['group_rate'];

			    array_filter ( $rate_detail, function($rate_detail){
			    	return ( $rate_detail['from'] == 2 && $rate_detail['price'] == $price_from);
			    } );
			    foreach ($rate_detail as $key => $rate_detail) {
			    	if ($rate_detail['from'] == 2 && $rate_detail['price'] == $price_from) {
						
			    		$rate_detail_min = $custom_rate;
			    	}
			    }

			    // if( ( (strtotime('+6 months', time() ) >=  $from_date)&&($from_date >= time())  )  || ( (time() >= $from_date) && (time() <= $to_date) ) ){
			    // //Nếu ngày đầu thuộc khoảng 6 tháng tới hoặc  ngày hiện tại thuộc khoảng from to 
			    //     if ( ((time() >= $from_date) && (time() <= $to_date)) ) { //Nếu thuộc khoảng hiện tại thì break luôn
			    //         $min_time = time();
			    //         $min_date = date('d/m/Y', $min_time);
			    //         // continue;
			    //     }else{
			    //         if($min_time){
			    //             $min_time = ($min_time < $from_date )?$min_time: $from_date;
			    //             $min_date = date('d/m/Y', $min_time);
			    //         }else{
			    //             $min_time = $from_date;
			    //             $min_date = date('d/m/Y', $min_time);
			    //         }
			    //     }
			    // }
			     
			}
		}

		// if (!empty($min_time)) {
		// 	$min_time_rate['min_time'] = $min_time;
		// }
		// if (!empty($min_date)) {
		// 	$min_time_rate['min_date'] = $min_date;
		// }
		// if (!empty($min_time_rate)) {
		// 	return $min_time_rate;
		// }
		//print_r($rate_detail_min);exit();
		$min_time_from = $rate_detail_min['from_date']['timestamp']?:time();
		$min_date_from = date('d/m/Y', $min_time_from);

		$min_time_to = $rate_detail_min['to_date']['timestamp']?:time();
		$min_date_to = date('d/m/Y', $min_time_to);

		//print_r($rate_detail_min);exit();
		if ($min_time_from < time() ) {
			$min_time_rate['min_time'] = time();
			$min_time_rate['min_date'] = date('d/m/Y', time());
		}else{
			$min_time_rate['min_time'] = $min_time_from;
			$min_time_rate['min_date'] = $min_date_from;
		}

			
		
		
		return $min_time_rate;
		
    }

});
function override_mce_options($initArray) 
{
  $opts = '*[*]';
  $initArray['valid_elements'] = $opts;
  $initArray['extended_valid_elements'] = $opts;
  return $initArray;
}
add_filter('tiny_mce_before_init', 'override_mce_options'); 
function get_price_usd($price){
	$symbol_exchange = '$';
	$exchange_detail = 1;
    if (isset($_COOKIE['exchange_rate'])){
        $exchange_rate_string = $_COOKIE['exchange_rate'];
        $exchange_rate_cookie = explode("-",$exchange_rate_string); 
        $exchange_detail = $exchange_rate_cookie[2];
        $symbol_exchange = $exchange_rate_cookie[1];
    }
    $price = str_replace($symbol_exchange, '', $price);
    $price = str_replace('$', '', $price);
    $price = $price/$exchange_detail;
    return floor($price) ;
}

add_filter('gettext',function($translation, $text, $domain){
	$current_lang = pll_current_language();
	// $check_special = strpos($text, 'text_translate_special');
	//print_r($text);exit();
	// if ($check_special !== false) {

	// 	$text_custome = explode('__', $text);
		//print_r($text_custome);exit();
		//foreach ($text_custome as $key_text => $value_text) {
			//$value_text = 'Cidade de Ho Chi Minh';
			if ($domain == 'custom' && $current_lang == 'pt') {
				
				$text_custome_str =  ot_get_option( 'text_translate_special' );
				$text_custome = explode('__', $text_custome_str);
				foreach ($text_custome as $key_text => $value_text) {
					//$text_translate = 'Excursion Cidade de Ho Chi Minh';
					$text_translate = 'Excursion '.$value_text;
					//print_r($text);echo 'test';
					//print_r($text_translate);exit();
					if ( $text == $text_translate) {
					  	$dia_diem = str_replace('Excursion', '', $text);
						return __('Excursion','Mundo').' da '.$dia_diem;
					}else{
						$dia_diem = str_replace('Excursion', '', $text);
						return __('Excursion','Mundo').' de '.$dia_diem;
					}
				}
			}
		//}
	//}
	
  	return $translation;
},10,3);