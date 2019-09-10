<?php
add_action('admin_init', function() {
	if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
		if ( in_array(basename($_SERVER['PHP_SELF']), array('post-new.php', 'page-new.php', 'post.php', 'page.php') ) ) {
			add_filter('mce_buttons', 'laregina_filter_mce_button');
			add_filter('mce_external_plugins', 'laregina_filter_mce_plugin');
			add_action('admin_head','laregina_add_simple_buttons');
			//add_action('edit_form_advanced', 'et_advanced_buttons');
			//add_action('edit_page_form', 'et_advanced_buttons');
		}
	}
});

function laregina_filter_mce_button($buttons) {
	array_push( $buttons, '|', 'Title overview' );
	return $buttons;
}

function laregina_filter_mce_plugin($plugins) {
	$plugins['et_quicktags'] = get_stylesheet_directory_uri(). "/shortcodes/js/editor_plugin.js";

	return $plugins;
}

function laregina_add_simple_buttons(){
    wp_print_scripts( 'quicktags' );
	$output = "<script type='text/javascript'>\n
	/* <![CDATA[ */ \n";

	$buttons = array();
	$buttons[] = array('name' => 'title_overview',
					'options' => array(
						'display_name' => 'title overview',
						'open_tag' => '\n[title_overview]',
						'close_tag' => '[/title_overview]\n',
						'key' => ''
					));


	for ($i=0; $i <= (count($buttons)-1); $i++) {
		$output .= "edButtons[edButtons.length] = new edButton('ed_{$buttons[$i]['name']}'
			,'{$buttons[$i]['options']['display_name']}'
			,'{$buttons[$i]['options']['open_tag']}'
			,'{$buttons[$i]['options']['close_tag']}'
			,'{$buttons[$i]['options']['key']}'
		); \n";
	}

	$output .= "\n /* ]]> */ \n
	</script>";
	echo $output;
}