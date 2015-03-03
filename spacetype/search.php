<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package seniores
 */

get_header(); ?>

	<div class="row-main">

		<?php
			$sidebar_settings = of_get_option( 'sn_blog_sidebar_settings' );
			$grid_class = ($sidebar_settings == 'none') ? 'grid grid-center' : 'grid';
			$col2_3_class = ($sidebar_settings == 'left') ? 'col col-content col-2-3 push-1-3' : 'col col-content col-2-3';
			$col1_3_class = ($sidebar_settings == 'left') ? 'col col-side col-1-3 pull-2-3' : 'col col-side col-1-3';
		?>

		<div class="<?php echo $grid_class; ?>">

			<div class="<?php echo $col2_3_class; ?>">

				<?php if ( have_posts() ) : ?>

				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'sn' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
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

				<article id="post-0" <?php post_class(); ?>>
					
					<h1 class="entry-title"><?php printf( __( 'Search Results for: %s', 'sn' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				
					<!--BEGIN .entry-content-->
					<div class="message message-notice">
						<p><?php _e('Sorry, but no posts found.', 'sn') ?></p>
					<!--END .entry-content-->
					</div>

				</article><!-- #post -->

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