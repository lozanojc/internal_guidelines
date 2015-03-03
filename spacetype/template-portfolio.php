<?php
/**
 * Template name: Portfolio
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package seniores
 */

get_header(); ?>

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

		<?php sn_breadcrumbs(); ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php
				$hide_title = rwmb_meta( 'sn_hide_title', array(), $post->ID );

				if ( $post->post_content || $hide_title == 0 ) {

					get_template_part( 'inc/post-formats/page' );

				}
			?>

		<?php endwhile; // end of the loop. ?>

		<?php
			$args = array(
				'post_type' => 'sn_portfolio',
				'orderby' => 'date',
				'order' => 'DESC',
				'posts_per_page' => -1
			);
			$portfolio_query = new WP_Query($args);

			if( $portfolio_query->have_posts() ) :
		?>

		<?php
			$args = array(
				'orderby' => 'id',
				'taxonomy' => 'sn_portfolio_category',
				'hide_empty' => 1,
				'parent' => 0
			);
			$categories = get_categories( $args );
			if ( $categories ) :
		?>
		<div class="box-filter h6">
			<p>
				<a href="#all" class="active"><?php _e( 'Everything', 'sn' ) ?></a>

				<?php
					foreach($categories as $category) :
				?>

				<a href="#cat-<?php echo $category->slug; ?>"><?php echo $category->name; ?></a>

				<?php endforeach; ?>

			</p>
		</div>
		<?php endif; ?>

		<div class="grid crossroad-portfolio">

			<?php
				while( $portfolio_query->have_posts() ) : $portfolio_query->the_post();

				get_template_part( 'inc/portfolio', 'item' );

				endwhile;
				wp_reset_postdata();
			?>

		</div>

		<?php else : ?>

		<article id="post-0" <?php post_class(); ?>>

			<h2 class="entry-title"><?php _e('No Portfolios Found', 'sn') ?></h2>

			<!--BEGIN .entry-content-->
			<div class="entry-content">
				<p><?php _e('Sorry, but no portfolios have been created.', 'sn') ?></p>
			<!--END .entry-content-->
			</div>

		</article><!-- #post -->

		<?php endif; ?>

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

<?php get_footer(); ?>