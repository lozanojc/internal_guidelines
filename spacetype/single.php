<?php
/**
 * The Template for displaying all single posts.
 *
 * @package seniores
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

	<div class="row-main">

		<?php
			$sidebar_settings = of_get_option( 'sn_blog_sidebar_settings' );
			$grid_class = ($sidebar_settings == 'none') ? 'grid grid-center' : 'grid';
			$col2_3_class = ($sidebar_settings == 'left') ? 'col col-content col-2-3 push-1-3' : 'col col-content col-2-3';
			$col1_3_class = ($sidebar_settings == 'left') ? 'col col-side col-1-3 pull-2-3' : 'col col-side col-1-3';
		?>

		<div class="<?php echo $grid_class; ?>">

			<div class="<?php echo $col2_3_class; ?>">

				<?php sn_breadcrumbs(); ?>

				<article <?php post_class() ?> id="post-<?php the_ID(); ?>">

					<?php
						get_template_part( 'inc/post-formats/single', get_post_format() );
					?>

					<?php
						// author info
						$user_id = get_the_author_meta('ID');
						$user_name = get_the_author_meta('display_name');
						$user_desc = get_the_author_meta('description');
						$user_desc = get_the_author_meta('description');
					?>
					<div class="box-article-bottom">
						<p>
							<?php
								if (empty($user_desc)) {
									printf( __('Author: <a href="%1$s">%2$s</a>', 'sn'), get_author_posts_url($user_id), $user_name );
									echo '<br />';
								}
							?>
							<span class="light">
								<?php the_tags( __('Tags:', 'sn') . ' ', ', ', ''); ?>
							</span>
						</p>
					</div>

					<?php if (!empty($user_desc)) : ?>
					<div class="box-author">
						<h3><?php printf( __('Posted by %1$s', 'sn'), $user_name ); ?></h3>
						<p>
							<span class="img"><?php echo get_avatar( $user_id, 60 ); ?></span>
							<?php echo $user_desc; ?>
							<br />
							<a href="<?php echo get_author_posts_url($user_id); ?>" class="light">Show all articles by this author.</a>
						</p>
					</div>
					<?php endif; ?>

					<?php
						wp_link_pages( array(
							'before' => '<div class="page-links">' . __( 'Pages:', 'sn' ),
							'after'  => '</div>',
						) );
					?>

					<?php edit_post_link( __( 'Edit', 'sn' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() )
							comments_template();
					?>

					<?php
						$articles_list = get_posts('posts_per_page=-1&sort_column=post_date&sort_order=desc&post_type=post');
						$articles = array();
						foreach ($articles_list as $article) {
						   $articles[] += $article->ID;
						}

						$current = array_search(get_the_ID(), $articles);

						if ( array_key_exists( $current-1, $articles ) ) {
							$prevID = $articles[$current-1];
						}
						if ( array_key_exists( $current+1, $articles ) ) {
							$nextID = $articles[$current+1];
						}

						$portfolio_page = of_get_option( 'sn_portfolio_page' );
						$date_format = get_option( 'date_format' );
					?>
					<div class="pager-articles">
						<div class="separator"></div>
						<?php if (!empty($prevID)) : ?>
						<p class="l">
							<span class="h6"><?php _e('Previous article', 'sn'); ?></span>
							<a href="<?php echo get_permalink($prevID); ?>"><?php echo get_the_title($prevID); ?></a> <br />
							<span class="small light"><?php echo get_the_date($date_format, $prevID); ?></span>
						</p>
						<?php endif; ?>

						<?php if (!empty($nextID)) : ?>
						<p class="r">
							<span class="h6"><?php _e('Next article', 'sn'); ?></span>
							<a href="<?php echo get_permalink($nextID); ?>"><?php echo get_the_title($nextID); ?></a> <br />
							<span class="small light"><?php echo get_the_date($date_format, $nextID); ?></span>
						</p>
						<?php endif; ?>
					</div>

				</article>

			</div>

			<?php if ( $sidebar_settings != 'none' ) : ?>
			<div class="<?php echo $col1_3_class; ?>">
				<?php get_sidebar(); ?>
			</div>
			<?php endif; ?>

		</div>

	</div>

	<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>