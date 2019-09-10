<!DOCTYPE html>
<?php 
	// setcookie('post_tour', 'tour_id', time() + 86400*365);
?>
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<!-- Google Tag Manager -->
<script async="async">(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NBHFFWN');</script>
<!-- End Google Tag Manager -->
	<meta name="google-site-verification" content="Xu9BZyyVp19FN8NBDT9Up0NExmEE3yAYTfSFkQaclYY" />
	<meta name="robots" content="index, follow">
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<?php elegant_description(); ?>
	<?php elegant_keywords(); ?>
	<?php elegant_canonical(); ?>

	<?php do_action( 'et_head_meta' ); ?>

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php $template_directory_uri = get_template_directory_uri(); ?>
	
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( $template_directory_uri . '/js/html5.js"' ); ?>" type="text/javascript"></script>
	<![endif]-->

	<script type="text/javascript">
		document.documentElement.className = 'js';
	</script>
    
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php 
		$current_lang = pll_current_language();
	?>
	<div class='language-<?php echo $current_lang;?>' >
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NBHFFWN"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php
	$product_tour_enabled = et_builder_is_product_tour_enabled();
	$page_container_style = $product_tour_enabled ? ' style="padding-top: 0px;"' : ''; ?>
	<div id="page-container"<?php echo $page_container_style; ?>>
<?php
	if ( $product_tour_enabled || is_page_template( 'page-template-blank.php' ) ) {
		return;
	}

	$et_secondary_nav_items = et_divi_get_top_nav_items();

	$et_phone_number = $et_secondary_nav_items->phone_number;

	$et_email = $et_secondary_nav_items->email;

	$et_contact_info_defined = $et_secondary_nav_items->contact_info_defined;

	$show_header_social_icons = $et_secondary_nav_items->show_header_social_icons;

	$et_secondary_nav = $et_secondary_nav_items->secondary_nav;

	$et_top_info_defined = $et_secondary_nav_items->top_info_defined;

	$et_slide_header = 'slide' === et_get_option( 'header_style', 'left' ) || 'fullscreen' === et_get_option( 'header_style', 'left' ) ? true : false;
?>

	<?php if ( $et_top_info_defined && ! $et_slide_header || is_customize_preview() ) : ?>
		
		<div id="top-header"<?php echo $et_top_info_defined ? '' : 'style="display: none;"'; ?>>
			<div class="container clearfix">

			<?php if ( $et_contact_info_defined ) : ?>

				<div id="et-info">
				<?php if ( '' !== ( $et_phone_number = et_get_option( 'phone_number' ) ) ) : ?>
					<span id="et-info-phone"><?php echo et_sanitize_html_input_text( $et_phone_number ); ?></span>
				<?php endif; ?>

				<?php if ( '' !== ( $et_email = et_get_option( 'header_email' ) ) ) : ?>
					<a href="<?php echo esc_attr( 'mailto:' . $et_email ); ?>"><span id="et-info-email"><?php echo esc_html( $et_email ); ?></span></a>
				<?php endif; ?>

				<?php
				if ( true === $show_header_social_icons ) {
					get_template_part( 'includes/social_icons', 'header' );
				} ?>
				</div> <!-- #et-info -->

			<?php endif; // true === $et_contact_info_defined
				$current_lang = pll_current_language();
				$home_url =  $current_lang=='en'?home_url():substr( esc_url( home_url( '/' ) ),0,-3);
			 ?>

				<div id="et-secondary-menu">
					<?php 
						$all_exchange_rate = ot_get_option('exchange_rate_country');
					?>
					<nav class="nav nav-currentcy">
						<div class="currentcy-menu">
							<ul id="menu-currency-menu" class="menu"> 
								<li id="menu-item-11350" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-11350">
									<?php 
										$exchange_rate_cookie = array('USD','$',1 );
										if (isset($_COOKIE['exchange_rate'])){
											$exchange_rate_string = $_COOKIE['exchange_rate'];
											$exchange_rate_cookie = explode("-",$exchange_rate_string);	
										}
									?>
									<a href="#" class="exchange_main"><?php echo $exchange_rate_cookie[0];?> (<?php echo $exchange_rate_cookie[1];?>)</a>
									<ul class="sub-menu">
										<?php 
											foreach ($all_exchange_rate as $key_exchange => $value_exchange) {
												echo '<li class="menu-item menu-item-type-custom menu-item-object-custom" >
													<a href="#" class="exchange_rate_show" data-title="'.$value_exchange['title'].'" data-symbol="'.$value_exchange['symbol'].'" data-number="'.$value_exchange['exchange_detail'].'">'.
													$value_exchange['title'].' ('.$value_exchange['symbol'].')</a>
												</li>';
											}
										?>
									</ul>
								</li>
						 	</ul>
						</div>
					</nav>
				<!-- 	<nav class='nav nav-currentcy'>
						<?php if ( has_nav_menu( 'currentcy-menu' ) ) {
		                  	wp_nav_menu( array( 'theme_location' => 'currentcy-menu', 'container_class' => 'currentcy-menu', 'items_wrap'      => '<ul id="%1$s" class="%2$s"> %3$s </ul>' ) );
		              		 }
							else {
								wp_page_menu();
							}
						?>
					</nav> -->
				<?php
					if ( ! $et_contact_info_defined && true === $show_header_social_icons ) {
						get_template_part( 'includes/social_icons', 'header' );
					} else if ( $et_contact_info_defined && true === $show_header_social_icons ) {
						ob_start();

						get_template_part( 'includes/social_icons', 'header' );

						$duplicate_social_icons = ob_get_contents();

						ob_end_clean();

						printf(
							'<div class="et_duplicate_social_icons">
								%1$s
							</div>',
							$duplicate_social_icons
						);
					}

					if ( '' !== $et_secondary_nav ) {
						echo $et_secondary_nav;
						if (isset($_COOKIE['post_tour']))
						{ 
							$cookie_tour =  $_COOKIE['post_tour'];
    						$all_id_tour = explode("-",$cookie_tour);
    						$all_id_tour =array_filter($all_id_tour);
    						$count_save = count($all_id_tour);
    						switch ($current_lang) {
    							case 'en':
    								$link_short = get_permalink(get_page_by_path('shortlisted'));
    								break;
    							case 'es':
    								$link_short = get_permalink(get_page_by_path('viajes-favoritos'));
    								break;
    							case 'pt':
    								$link_short = get_permalink(get_page_by_path('viagem-preferida'));
    								break;
    						}
    						echo '<div class="save-tour-cookie"><a href="'.$link_short.'"><i class="fa fa-heart"></i>'.$count_save.' '.__('SHORTLIST','Mundo').'</a></div>';
						}
						
					}

					et_show_cart_total();
				?>
				</div> <!-- #et-secondary-menu -->

			</div> <!-- .container -->
		</div> <!-- #top-header -->
	<?php endif; // true ==== $et_top_info_defined ?>

	<?php if ( $et_slide_header || is_customize_preview() ) : ?>
		<div class="et_slide_in_menu_container">
			<?php if ( 'fullscreen' === et_get_option( 'header_style', 'left' ) || is_customize_preview() ) { ?>
				<span class="mobile_menu_bar et_toggle_fullscreen_menu"></span>
			<?php } ?>

			<?php
				if ( $et_contact_info_defined || true === $show_header_social_icons || false !== et_get_option( 'show_search_icon', true ) || class_exists( 'woocommerce' ) || is_customize_preview() ) { ?>
					<div class="et_slide_menu_top">

					<?php if ( 'fullscreen' === et_get_option( 'header_style', 'left' ) ) { ?>
						<div class="et_pb_top_menu_inner">
					<?php } ?>
			<?php }

				if ( true === $show_header_social_icons ) {
					get_template_part( 'includes/social_icons', 'header' );
				}

				et_show_cart_total();
			?>
			<?php if ( false !== et_get_option( 'show_search_icon', true ) || is_customize_preview() ) : ?>
				<?php if ( 'fullscreen' !== et_get_option( 'header_style', 'left' ) ) { ?>
					<div class="clear"></div>
				<?php } ?>
				<form role="search" method="get" class="et-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php
						printf( '<input type="search" class="et-search-field" placeholder="%1$s" value="%2$s" name="s" title="%3$s" />',
							esc_attr__( 'Search &hellip;', 'Divi' ),
							get_search_query(),
							esc_attr__( 'Search for:', 'Divi' )
						);
					?>
					<button type="submit" id="searchsubmit_header"></button>
				</form>
			<?php endif; // true === et_get_option( 'show_search_icon', false ) ?>

			<?php if ( $et_contact_info_defined ) : ?>

				<div id="et-info">
				<?php if ( '' !== ( $et_phone_number = et_get_option( 'phone_number' ) ) ) : ?>
					<span id="et-info-phone"><?php echo et_sanitize_html_input_text( $et_phone_number ); ?></span>
				<?php endif; ?>

				<?php if ( '' !== ( $et_email = et_get_option( 'header_email' ) ) ) : ?>
					<a href="<?php echo esc_attr( 'mailto:' . $et_email ); ?>"><span id="et-info-email"><?php echo esc_html( $et_email ); ?></span></a>
				<?php endif; ?>
				</div> <!-- #et-info -->

			<?php endif; // true === $et_contact_info_defined ?>
			<?php if ( $et_contact_info_defined || true === $show_header_social_icons || false !== et_get_option( 'show_search_icon', true ) || class_exists( 'woocommerce' ) || is_customize_preview() ) { ?>
				<?php if ( 'fullscreen' === et_get_option( 'header_style', 'left' ) ) { ?>
					</div> <!-- .et_pb_top_menu_inner -->
				<?php } ?>

				</div> <!-- .et_slide_menu_top -->
			<?php } ?>

			<div class="et_pb_fullscreen_nav_container">
				<?php
					$slide_nav = '';
					$slide_menu_class = 'et_mobile_menu';

					$slide_nav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'echo' => false, 'items_wrap' => '%3$s' ) );
					$slide_nav .= wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'container' => '', 'fallback_cb' => '', 'echo' => false, 'items_wrap' => '%3$s' ) );
				?>

				<ul id="mobile_menu_slide" class="<?php echo esc_attr( $slide_menu_class ); ?>">

				<?php
					if ( '' == $slide_nav ) :
				?>
						<?php if ( 'on' == et_get_option( 'divi_home_link' ) ) { ?>
							<li <?php if ( is_home() ) echo( 'class="current_page_item"' ); ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'Divi' ); ?></a></li>
						<?php }; ?>

						<?php show_page_menu( $slide_menu_class, false, false ); ?>
						<?php show_categories_menu( $slide_menu_class, false ); ?>
				<?php
					else :
						echo( $slide_nav );
					endif;
				?>

				</ul>
			</div>
		</div>
	<?php endif; // true ==== $et_slide_header ?>

		<header id="main-header" data-height-onload="<?php echo esc_attr( et_get_option( 'menu_height', '66' ) ); ?>">
			<div class="container clearfix et_menu_container">
			<?php
				$logo = ( $user_logo = et_get_option( 'divi_logo' ) ) && '' != $user_logo
					? $user_logo
					: $template_directory_uri . '/images/logo.png';
			?>
				<div class="logo_container">
					<span class="logo_helper"></span>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" id="logo" data-height-percentage="<?php echo esc_attr( et_get_option( 'logo_height', '54' ) ); ?>" />
					</a>
				</div>
				<div id="et-top-navigation" data-height="<?php echo esc_attr( et_get_option( 'menu_height', '66' ) ); ?>" data-fixed-height="<?php echo esc_attr( et_get_option( 'minimized_menu_height', '40' ) ); ?>">
					<?php if ( ! $et_slide_header || is_customize_preview() ) : ?>
						<nav id="top-menu-nav">
						<?php
							$menuClass = 'nav';
							if ( 'on' == et_get_option( 'divi_disable_toptier' ) ) $menuClass .= ' et_disable_top_tier';
							$primaryNav = '';

							$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => 'top-menu', 'echo' => false ) );

							if ( '' == $primaryNav ) :
						?>
							<ul id="top-menu" class="<?php echo esc_attr( $menuClass ); ?>">
								<?php if ( 'on' == et_get_option( 'divi_home_link' ) ) { ?>
									<li <?php if ( is_home() ) echo( 'class="current_page_item"' ); ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'Divi' ); ?></a></li>
								<?php }; ?>

								<?php show_page_menu( $menuClass, false, false ); ?>
								<?php show_categories_menu( $menuClass, false ); ?>
							</ul>
						<?php
							else :
								echo( $primaryNav );
							endif;
						?>
						</nav>
					<?php endif; ?>
					<ul class="et-social-icons icon-menu-top-second">
						<li class="et-social-whatsapp-2">
							<a href="<?php echo ot_get_option( 'whatsapp');?>" >
								<span><?php echo __('WhatsApp', 'Mundo');?></span>
							</a>
						</li>
						<li class="et-social-hotline">
							<a  class="et-social-hotlinelink">
								<span><?php echo __('Hotline', 'Mundo');?></span>
							</a>
							<div class="triangle">
								<p><b><?php echo __('Our customer Support', 'Mundo');?></b></p>
								<a href="tel:<?php echo ot_get_option( 'vietnam');?>" class="row1"><span><?php echo __('Vietnam', 'Mundo');?></span>  <span><?php echo ot_get_option( 'vietnam');?></span></a> 
<a href="tel:<?php echo ot_get_option( 'thailand');?>" class="row2"><span><?php echo __('Thailand', 'Mundo');?></span>  <span><?php echo ot_get_option( 'thailand');?></span></a>
							</div>
						</li>
						<li class="et-social-enqui">
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
							<a href="<?php echo $link;?>" class='make-enquire' >
								<?php echo __('MAKE AN ENQUIRY', 'Mundo'); ?>
							</a>
						</li>
					</ul>
					<?php
					if ( ! $et_top_info_defined && ( ! $et_slide_header || is_customize_preview() ) ) {
						et_show_cart_total( array(
							'no_text' => true,
						) );
					}
					?>

					<?php if ( $et_slide_header || is_customize_preview() ) : ?>
						<span class="mobile_menu_bar et_pb_header_toggle et_toggle_<?php echo esc_attr( et_get_option( 'header_style', 'left' ) ); ?>_menu"></span>
					<?php endif; ?>

					<?php if ( ( false !== et_get_option( 'show_search_icon', true ) && ! $et_slide_header ) || is_customize_preview() ) : ?>
					<div id="et_top_search">
						<span id="et_search_icon"></span>
					</div>

					<?php endif; // true === et_get_option( 'show_search_icon', false ) ?>

					<?php do_action( 'et_header_top' ); ?>
					<div class='mobile-phone click-mobile-phone call-whatsapp-mobile'><i class="call-us-icon"></i></div>
					<div class="dropdown show_on_mobile menu-lang-mobile">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        	<?php echo $lang_text;?><span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="https://test.mundoasiatours.com/">English</a></li>
                            <li><a href="https://test.mundoasiatours.com/es">Español</a></li>
                            <li><a href="https://test.mundoasiatours.com/pt">Portugês</a></li>
                        </ul>
                    </div>
					<div class="clear-both"></div>
				</div> <!-- #et-top-navigation -->
			</div> <!-- .container -->
			<!-- <select class='language'>
				<option>EN</option>
				<option>VI</option>
			</select> -->
			<div class="et_search_outer">
				<div class="container et_search_form_container">
					<form role="search" method="get" class="et-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php
						printf( '<input type="search" class="et-search-field" placeholder="%1$s" value="%2$s" name="s" title="%3$s" />',
							esc_attr__( 'Search &hellip;', 'Divi' ),
							get_search_query(),
							esc_attr__( 'Search for:', 'Divi' )
						);
					?>
					</form>
					<span class="et_close_search_field"></span>
				</div>
			</div>
		</header> <!-- #main-header -->

		<div id="et-main-area">
