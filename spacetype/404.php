<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package seniores
 */

get_header(); ?>

	<div id="post-404">
		<div class="row-main">
			<div class="center">
				<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'sn' ); ?></h1>
				<div style="height:2px" class="separator separator-small"></div>
				<p><?php _e( 'It looks like nothing was found at this location.', 'sn' ); ?></p>
			</div>
		</div>
	</div>

<?php get_footer(); ?>