<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package seniores
 */

get_header(); ?>

	<?php

		$blogpage_id = get_option('page_for_posts');
		$actualpage = getUrl();
		$blogpage = get_permalink($blogpage_id);
		if ( $actualpage == $blogpage ) :

			// SECTIONS BEFORE
			$sections_before_id = rwmb_meta( 'sn_page_sections_before', array(), $blogpage_id );
			if (!empty($sections_before_id)) :
				$sections_before = get_posts( array( 'post_type' => 'sn_sections', 'post__in' => $sections_before_id, 'orderby' => 'post__in' ) );
				foreach ( $sections_before as $post ) :
					setup_postdata($post);

					$section_before_type = rwmb_meta( 'sn_section_type' );
					get_template_part( 'inc/section-formats/section', $section_before_type );

				endforeach;
				wp_reset_postdata();
			endif;
		endif;
	?>

	<div class="row-main">

		<?php
			$sidebar_settings = of_get_option( 'sn_blog_sidebar_settings' );
			$grid_class = ($sidebar_settings == 'none') ? 'grid grid-center' : 'grid';
			$col2_3_class = ($sidebar_settings == 'left') ? 'col col-content col-2-3 push-1-3' : 'col col-content col-2-3';
			$col1_3_class = ($sidebar_settings == 'left') ? 'col col-side col-1-3 pull-2-3' : 'col col-side col-1-3';
		?>

		<div class="<?php echo $grid_class; ?>">

			<div class="<?php echo $col2_3_class; ?>">

				<?php if ( sn_is_blog_page() ) : ?>

				<?php
					sn_breadcrumbs();

					$hide_title = rwmb_meta( 'sn_hide_title', array(), $blogpage_id );
					if ( !$hide_title ) :
					$blog_title = get_the_title( $blogpage_id );
				?>
				<h1 class="entry-title"><?php echo $blog_title; ?></h1>
				<?php endif; ?>

				<?php endif; // end of is blog page ?>

				<?php if ( have_posts() ) : ?>

					<div class="crossroad-articles">

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>

						<?php
							/* Include the Post-Format-specific template for the content.
							 * If you want to overload this in a child theme then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'inc/post-formats/content', get_post_format() );
						?>

					<?php endwhile; ?>

					</div>

					<?php
						global $wp_query;
						$post_count = $wp_query->found_posts;
						$posts_per_page = get_option( 'posts_per_page' );
						$big = 999999999; // need an unlikely integer

						$pagination = array(
							'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format' => '?page=%#%',
							'current' => max(1, get_query_var('paged')),
							'total' => $wp_query->max_num_pages,
							'next_text' => '&gt;',
							'prev_text' => '&lt;'
						);
						if ( $post_count > $posts_per_page ) {
							echo '<p class="menu-paging primary-links">' . paginate_links( $pagination ) . '</p>';
						}
					?>

				<?php else : ?>

					<?php get_template_part( 'no-results', 'archive' ); ?>

				<?php endif; ?>

			</div>
			<?php if ( $sidebar_settings != 'none' ) : ?>
			<div class="<?php echo $col1_3_class; ?>">
				<?php get_sidebar(); ?>
			</div>
			<?php endif; ?>
		</div>

	</div>

	<?php
		// SECTIONS AFTER

		if ( $actualpage == $blogpage ) :
			$sections_after_id = rwmb_meta( 'sn_page_sections_after', array(), $blogpage_id );
			if (!empty($sections_after_id)) :
				$sections_after = get_posts( array( 'post_type' => 'sn_sections', 'post__in' => $sections_after_id, 'orderby' => 'post__in' ) );
				foreach ( $sections_after as $post ) :
					setup_postdata($post);

					$section_after_type = rwmb_meta( 'sn_section_type' );
					get_template_part( 'inc/section-formats/section', $section_after_type );

				endforeach;
				wp_reset_postdata();
			endif;
		endif;
	?>

<?php get_footer(); ?>