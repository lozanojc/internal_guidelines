<?php
/**
 * Template name: Archives
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package seniores
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

	<?php
		// SECTIONS BEFORE
		$sections_before_id = rwmb_meta( 'sn_page_sections_before' );
		if (!empty($sections_before_id)) :
			$sections_before = get_posts( array( 'posts_per_page' => -1, 'post_type' => 'sn_sections', 'post__in' => $sections_before_id, 'orderby' => 'post__in' ) );
			foreach ( $sections_before as $post ) :
				setup_postdata($post);

				$section_before_type = rwmb_meta( 'sn_section_type' );
				get_template_part( 'inc/section-formats/section', $section_before_type );

			endforeach;
			wp_reset_postdata();
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

				<?php sn_breadcrumbs(); ?>

				<article <?php post_class() ?> id="post-<?php the_ID(); ?>">

					<h1 class="entry-title"><?php the_title(); ?></h1>

					<?php the_content(); ?>

					<h2><?php _e('Last 30 Posts', 'sn') ?></h2>
					<ul>
					<?php $archive_30 = get_posts('numberposts=30');
					foreach($archive_30 as $post) : ?>
						<li><a href="<?php the_permalink(); ?>"><?php the_title();?></a></li>
					<?php
					endforeach;
					wp_reset_postdata();
					?>
					</ul>
					
					<h2><?php _e('Archives by Month:', 'sn') ?></h2>
					<ul>
						<?php wp_get_archives('type=monthly'); ?>
					</ul>

					<h2><?php _e('Archives by Category:', 'sn') ?></h2>
					<ul>
				 		<?php wp_list_categories( 'title_li=' ); ?>
					</ul>

					<?php
						wp_link_pages( array(
							'before' => '<div class="page-links">' . __( 'Pages:', 'sn' ),
							'after'  => '</div>',
						) );
					?>

					<?php edit_post_link( __( 'Edit', 'sn' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>

				</article>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template();
				?>

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
		$sections_after_id = rwmb_meta( 'sn_page_sections_after' );
		if (!empty($sections_after_id)) :
			$sections_after = get_posts( array( 'posts_per_page' => -1, 'post_type' => 'sn_sections', 'post__in' => $sections_after_id, 'orderby' => 'post__in' ) );
			foreach ( $sections_after as $post ) :
				setup_postdata($post);

				$section_after_type = rwmb_meta( 'sn_section_type' );
				get_template_part( 'inc/section-formats/section', $section_after_type );

			endforeach;
			wp_reset_postdata();
		endif;
	?>

	<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>