<?php get_header(); ?>

<div id="main-content">

		<div id="content-area" class="clearfix">
			<div id="page-404" style="background-image:url(<?php echo ot_get_option('404_image'); ?>);height: 900px; ">
				<div class="content-not-found">
					<h1><?php echo __('404','Mundo');?></h1>
					<h5><?php echo __("We're sorry, the page you requested could not be found!",'Mundo');?></h5>
					<a class="et_pb_button make-enquire et_pb_button_0 et_pb_module et_pb_bg_layout_light" href="/"><?php echo __('BACK TO HOMEPAGE','Mundo');?></a>
				</div>
				
			</div> <!-- #left-area -->

			
		</div> <!-- #content-area -->

</div> <!-- #main-content -->

<?php

get_footer();
