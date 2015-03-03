<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package seniores
 */
?>

	<?php do_action( 'before_sidebar' ); ?>
	<?php if ( ! dynamic_sidebar( 'sidebar-blog' ) ) : ?>

	<?php endif; // end sidebar widget area ?>