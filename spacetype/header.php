<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package seniores
 */
?>
<!DOCTYPE html>
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="ie7 no-js"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="ie8 no-js"> <![endif]-->
<!--[if IE 9 ]>    <html <?php language_attributes(); ?> class="ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
		<?php
			$responsive = of_get_option( 'sn_responsive' );
			if ( $responsive ) :
		?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=1" />
		<?php endif; ?>

		<meta name="author" content="HTML &amp; WordPress by Seniores" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

		<title>
		<?php
			global $page, $paged;
			wp_title( '|', true, 'right' );
			// Add the blog name.
			bloginfo( 'name' );
			// Add the blog description for the home/front page.
			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description && ( is_home() || is_front_page() ) )
				echo " | $site_description";
			// Add a page number if necessary:
			if ( $paged >= 2 || $page >= 2 )
				echo ' | ' . sprintf( __( 'Page %s', 'ellipsis' ), max( $paged, $page ) );
		?>
		</title>

		<!--[if lte IE 8]>
			<script src="<?php echo THEME_WEB_ROOT; ?>/js/respond.min.js"></script>
		<![endif]-->

		<?php
			$favicon = of_get_option( 'sn_favicon' );
			if (!empty($favicon)) :
		?>
		<?php endif; ?>

		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>

		<?php sn_header_before(); ?>
		<div id="loader"></div>
		<header id="header">
			<div class="header-main">
				<div class="wrap">

					<?php sn_header_start(); ?>

					<!-- MAIN MENU -->
					<div id="menu-main">
						<?php
							sn_nav_start();

							wp_nav_menu( array(
								'container' => '',
								'menu_id' => '',
								'menu_class' => 'reset',
								'theme_location' => 'menu'
							) );

							sn_nav_end();
						?>
					</div><!-- /menu-main -->

					<?php sn_header_end(); ?>

				</div><!-- /wrap -->
			</div><!-- /row-main -->
		</header><!-- /header -->

		<?php sn_header_after(); ?>

		<div id="main">

			<?php sn_content_start(); ?>