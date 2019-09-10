<?php
/**
 * Plugin Name: Meta Box Columns
 * Plugin URI: https://metabox.io/plugins/meta-box-columns/
 * Description: Display fields more beautiful by putting them into 12-columns grid.
 * Version: 1.1
 * Author: MetaBox.io
 * Author URI: https://metabox.io
 * License: GPL2+
 *
 * @package    Meta Box
 * @subpackage Meta Box Columns
 */

// Prevent loading this file directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'mb_columns_load' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'class-mb-columns.php';

	/**
	 * Initialize. Must run after meta boxes are registered.
	 */
	function mb_columns_load() {
		if ( ! function_exists( 'rwmb_get_registry' ) ) {
			return;
		}

		$meta_boxes = rwmb_get_registry( 'meta_box' )->all();

		foreach ( $meta_boxes as $meta_box ) {
			new MB_Columns( $meta_box );
		}
	}
	add_action( 'init', 'mb_columns_load', 99 );
}
