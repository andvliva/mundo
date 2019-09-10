<?php
/*
 * Plugin Name: LIVA Divi Builder
 * Plugin URI: 
 * Description: a custom divi plugin
 * Version: 1.0
 * Author: LIVA
 * Author URI: http://liva.com.vn
 * License: 
 */

add_action( 'et_builder_modules_loaded', function(){
	require_once( plugin_dir_path( __FILE__ ). 'class-du-an-slider.php' );
	require_once( plugin_dir_path( __FILE__ ). 'class-post-fullwidth-slider.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-custom-post.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-custom-post-show-more.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-custom-post2.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-post-marquee.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-post-owlcarousel.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-logo-doi-tac.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-owlcarousel-sliderItem.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-owlcarousel-slider.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-title-overview.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-subtitle-overview.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-our-suites.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-gallery-masonry-item.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-gallery-masonry.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-facility.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-suite-gallery.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-suite-icons.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-text-fullwidth.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-slider-tours.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-video-title-content.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-vertical-tabs.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-post-travel-about.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-garllery-image.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-owlcarousel-item.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-custom-sliderItem.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-custom-slider.php' );
    // require_once( plugin_dir_path( __FILE__ ). 'class-slider-3-image-item.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-slider-3-image-sliderItem.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-slider-3-image.php' );
    // require_once( plugin_dir_path( __FILE__ ). 'class-tour-child-sliderItem.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-post-slider-with-js.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-posts-slider-with-js.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-image-text.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-blog-list.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-blog-list-show-more.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-map-grayscale.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-custom-map-item.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-custom-contact-form.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-custom-contact-form-item.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-video-embed.php' );
     require_once( plugin_dir_path( __FILE__ ). 'class-excursion-show-more.php' );

     require_once( plugin_dir_path( __FILE__ ). 'class-cc-custom-tour.php' );
});


add_action('et_builder_ready', function() {
    //d('test');
});

