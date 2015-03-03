<?php
/**
 * The Template for displaying all single posts.
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

		while ( have_posts() ) : the_post();

			$content = get_the_content();
			$portfolio_related = of_get_option( 'sn_portfolio_related' );
			$portfolio_pager = of_get_option( 'sn_portfolio_pager' );

			if ( !empty($content) || ($portfolio_related == 1) || ($portfolio_pager == 1) ) :
		?>

		<div class="row-main">

			<?php if ( !empty($content) ) : ?>

			<?php sn_breadcrumbs(); ?>

			<article <?php post_class() ?> >

				<?php
					$hide_title = rwmb_meta( 'sn_hide_title' );
					if ( !$hide_title ) :
				?>
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php endif; ?>
				<?php the_content(); ?>

				<?php edit_post_link( __( 'Edit', 'sn' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>

			</article>

			<?php endif; ?>

			<?php
				if ( $portfolio_related == 1 ) :

				$portfolio_filter = wp_get_object_terms($post->ID, 'sn_portfolio_category');
				$filter = array();
				foreach ( $portfolio_filter as $item ) {
					$filter[] = $item->slug;
				}
				$not_in = array($post->ID);
				$portfolio_type = of_get_option( 'sn_portfolio_type' );
				$portfolio_type_a = explode( '_', $portfolio_type );

				if ( !empty($filter) ) {

					$args = array(
						'tax_query' => array(
							array(
								'taxonomy' => 'sn_portfolio_category',
								'field' => 'slug',
								'terms' => $filter
							),
						),
						'post_type' => 'sn_portfolio',
						'post__not_in' => $not_in,
						'orderby' => 'date',
						'order' => 'DESC',
						'posts_per_page' => $portfolio_type_a[0]
					);

				} else {

					$args = array(
						'post_type' => 'sn_portfolio',
						'post__not_in' => $not_in,
						'orderby' => 'date',
						'order' => 'DESC',
						'posts_per_page' => $portfolio_type_a[0]
					);

				}
				$portfolio_query = new WP_Query($args);

				if ( $portfolio_query->have_posts() ) :

			?>
			<div class="separator"></div>
			<h2><?php _e( 'Other projects', 'sn' ) ?></h2>
			<div class="grid crossroad-portfolio">

				<?php
					while( $portfolio_query->have_posts() ) : $portfolio_query->the_post();

					get_template_part( 'inc/portfolio', 'item' );

					endwhile;
					wp_reset_postdata();
				?>

			</div>

			<?php
				endif; // end if have_posts
				endif; // end if portfolio_related
			?>

			<?php
				if ( $portfolio_pager == 1 ) :

				$portfolio_list = get_posts('posts_per_page=-1&sort_column=post_date&sort_order=desc&post_type=sn_portfolio');
				$projects = array();
				foreach ($portfolio_list as $project) {
				   $projects[] += $project->ID;
				}

				$current = array_search(get_the_ID(), $projects);

				if ( array_key_exists( $current-1, $projects ) ) {
					$prevID = $projects[$current-1];
				}
				if ( array_key_exists( $current+1, $projects ) ) {
					$nextID = $projects[$current+1];
				}

				global $portfolio_page_id;
			?>
			<p class="paging-portfolio center">
				<?php if (!empty($prevID)) : ?>
				<a href="<?php echo get_permalink($prevID); ?>" title="<?php echo get_the_title($prevID); ?>" class="l">
					<span class="icon icon-crossroad-arrow-left"></span>
				</a>
				<?php endif; ?>

				<?php if (!empty($nextID)) : ?>
				<a href="<?php echo get_permalink($nextID); ?>" title="<?php echo get_the_title($nextID); ?>" class="r">
					<span class="icon icon-crossroad-arrow-right"></span>
				</a>
				<?php endif; ?>

				<?php if (!empty($portfolio_page_id)) : ?>
				<a href="<?php echo get_permalink($portfolio_page_id); ?>">
					<span class="icon icon-crossroad"></span>
				</a>
				<?php endif; ?>
			</p>
			<?php endif; ?>

		</div>
		<?php endif; ?>

	<?php endwhile; // end of the loop. ?>

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