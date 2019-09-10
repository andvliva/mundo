<?php if ( 'on' == et_get_option( 'divi_back_to_top', 'false' ) ) : ?>

	<span class="et_pb_scroll_top et-pb-icon"></span>

<?php endif;
$current_lang = pll_current_language();
if ( ! is_page_template( 'page-template-blank.php' ) ) : ?>
			<div class='footer-top row et_pb_row'>
				<div class="mundo-add-1 "><h4 class="col-md-12"><?php echo __('Mundo Asia Vietnam','Mundo');?></h4><?php echo ot_get_option( 'mundo_asia_vietnam' );?></div>
				<div class="mundo-add-2 "><h4 class="col-md-12"><?php echo __('Mundo Asia Thailand','Mundo');?></h4><?php echo ot_get_option( 'mundo_asia_thailand' );?></div>
				
				<div class="mundo-ft-cate  row">
					<h4 class="col-md-12"><?php echo __('Support','Mundo');?></h4>
					<div class="clear-both"></div>
					<?php 
						$terms_destination = get_terms( array(
						    'taxonomy' => 'category-destination',
						    'hide_empty' => true,
						    'parent' => 0
						) );
	                    $mang = array_chunk($terms_destination,2);
	                    echo '<div class="col-md-12 support-ft">';
		                    // foreach($mang as $key0 => $value0)
		                    //   {
		                    //     echo '<p>'.$value0['0']->name.'</p>';
		                    //   }
	                    switch ($current_lang ) {
	                    	case 'en':
	                    		$link_p = get_permalink(get_page_by_path('privacy-policy'));
	                    		$link_b = get_permalink(get_page_by_path('term-and-conditions'));
	                    		$link_f = get_permalink(get_page_by_path('faq'));
	                    		break;
	                    	case 'es':
	                    		$link_p = get_permalink(get_page_by_path('politica-de-privacidad'));
	                    		$link_b = get_permalink(get_page_by_path('terminos-y-condiciones'));
	                    		$link_f = get_permalink(get_page_by_path('preguntas-frecuentes'));
	                    		break;
	                    	case 'pt':
	                    		$link_p = get_permalink(get_page_by_path('politica-de-privacidade'));
	                    		$link_b = get_permalink(get_page_by_path('termos-e-condicoes-gerais'));
	                    		$link_f = get_permalink(get_page_by_path('perguntas-frequentes'));
	                    		break;
	                    	default:
	                    		$link_p = get_permalink(get_page_by_path('privacy-policy'));
	                    		$link_b = get_permalink(get_page_by_path('term-and-conditions'));
	                    		$link_f = get_permalink(get_page_by_path('faq'));
	                    		break;
	                    }
	                    echo '<a href="'.$link_p.'"><p>'.__("Privacy policy",'Mundo').'</p></a>';
	                    echo '<a href="'.$link_b.'"><p>'.__("Booking terms and conditions",'Mundo').'</p></a>';
	                    echo '<a href="'.$link_f.'"><p>'.__("Frequently asked questions",'Mundo').'</p></a>';
	                    echo '</div>';  
					?>
					<div class="clear-both"></div>
					<!-- <h4 class='col-md-12 travel-style-ft'><?php //echo __('Stay updated','Mundo');?></h4> -->
					<div class='email-letter'>
						<?php  //dynamic_sidebar( 'Footer Area #1' ); ?>
						<?php  dynamic_sidebar( 'my_newletter' ); ?>
					</div>
				</div>
				<div class="mundo-social-ft">
					<?php echo ot_get_option( 'facebook_big');?>
					 <?php //dynamic_sidebar('Footer Area #1'); ?>
					<div class="clear-both"></div>
					<h4><?php echo __('Payment','Mundo');?></h4>
					<?php $home_url =  $current_lang=='en'?home_url():substr( esc_url( home_url( '/' ) ),0,-3);?>
					<div class="Payment"></div>
				</div>
			</div>
			<div class="clear-both"></div>
			<footer id="main-footer">
				<?php $home_url =  $current_lang=='en'?home_url():substr( esc_url( home_url( '/' ) ),0,-3);?>
				
				<?php //get_sidebar( 'footer' ); ?>

				<div id="footer-bottom">
					<div class="container clearfix row et_pb_row">
							<div class='social_icons col-md-4'>
								
								<a href="<?php echo ot_get_option( 'facebook');?>" class="icon">
									<span aria-hidden="true" class="social_facebook"></span>
								</a>
																						
									<a href="<?php echo ot_get_option( 'twitter');?>" class="icon">
										<span aria-hidden="true" class="social_twitter"></span>
									</a>
								
								
									<a href="<?php echo ot_get_option( 'instagram');?>" class="icon">
										<span aria-hidden="true" class="social_instagram"></span>
									</a>
								
								
									<a href="<?php echo ot_get_option( 'linkedin');?>" class="icon">
										<span aria-hidden="true" class="social_linkedin"></span>
									</a>
								
								
									<a href="<?php echo ot_get_option( 'youtube');?>" class="icon">
										<span aria-hidden="true" class="social_youtube"></span>
									</a>
								
							</div>
							<div class="col-md-4 copy-right"><?php echo ot_get_option( 'copy_right' );?></div>
							<div class="col-md-4 logo-ft"><?php echo ot_get_option( 'footer_image' );?> </div>
							

				<?php
					// if ( false !== et_get_option( 'show_footer_social_icons', true ) ) {
					// 	get_template_part( 'includes/social_icons', 'footer' );
					// }

					//echo et_get_footer_credits();
				?>
					</div>	<!-- .container -->
				</div>
			<!-- 	<div class="et-social-enqui show_on_mobile make-enquiry-ft"> -->
					<?php 
						$current_lang = pll_current_language();
						switch ($current_lang) {
							case 'en':
								$link = get_permalink(get_page_by_path('make-enquiry'));
								$lang_text = 'English';
								break;
							case 'es':
								$link = get_permalink(get_page_by_path('hacer-reserva'));
								$lang_text = 'Español';
								break;
							case 'pt':
								$link = get_permalink(get_page_by_path('solicite-aqui'));
								$lang_text = 'Portugês';
								break;
							default:
								$link = get_permalink(get_page_by_path('make-enquiry'));
								break;
						}
					?>
					<!--<a href="<?php echo $link;?>" class='make-enquire make-enquire-btn-ft show_on_mobile' >
						<?php //echo __('MAKE AN ENQUIRY', 'Mundo'); ?>
					</a>-->
				<!-- </div> -->
			</footer> <!-- #main-footer -->
		</div> <!-- #et-main-area -->

<?php endif; // ! is_page_template( 'page-template-blank.php' ) ?>

	</div> <!-- #page-container -->

	<?php wp_footer(); ?>
	<script type="text/javascript">
		//console.log($json_location);
	</script>
</div>

	<link rel="stylesheet" href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome-font-awesome.min.css">
	

    <!-- <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"> -->
</body>
