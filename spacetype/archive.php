<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package seniores
 */

get_header(); ?>

	<div class="row-main">

		<?php
			$sidebar_settings = of_get_option( 'sn_blog_sidebar_settings' );
			$grid_class = ($sidebar_settings == 'none') ? 'grid grid-center' : 'grid';
			$col2_3_class = ($sidebar_settings == 'left') ? 'col col-2-3 push-1-3' : 'col col-2-3';
			$col1_3_class = ($sidebar_settings == 'left') ? 'col col-1-3 pull-2-3' : 'col col-1-3';
		?>

		<div class="<?php echo $grid_class; ?>">

			<div class="<?php echo $col2_3_class; ?>">

				<?php sn_breadcrumbs(); ?>

				<h1>
					<?php
						if ( is_category() ) :
							single_cat_title();

						elseif ( is_tag() ) :
							single_tag_title();

						elseif ( is_author() ) :
							/* Queue the first post, that way we know
							 * what author we're dealing with (if that is the case).
							*/
							the_post();
							printf( __( 'Author: %s', 'sn' ), '<span class="vcard">' . get_the_author() . '</span>' );
							/* Since we called the_post() above, we need to
							 * rewind the loop back to the beginning that way
							 * we can run the loop properly, in full.
							 */
							rewind_posts();

						elseif ( is_day() ) :
							printf( __( 'Day: %s', 'sn' ), '<span>' . get_the_date() . '</span>' );

						elseif ( is_month() ) :
							printf( __( 'Month: %s', 'sn' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

						elseif ( is_year() ) :
							printf( __( 'Year: %s', 'sn' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

						elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
							_e( 'Images', 'sn');

						elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
							_e( 'Videos', 'sn' );

						else :
							_e( 'Archives', 'sn' );

						endif;
					?>
				</h1>

				<?php if ( have_posts() ) : ?>

					<?php
						// Show an optional term description.
						$term_description = term_description();
						if ( ! empty( $term_description ) ) :
							printf( '<div class="taxonomy-description">%s</div>', $term_description );
						endif;
					?>

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

<?php get_footer(); ?>
