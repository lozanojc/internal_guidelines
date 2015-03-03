<?php
/**
 * The template for displaying all pages.
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

			if ( $sections_before ) {

				$sections = array();
				foreach ( $sections_before as $post ) {
					$sections[$post->ID] = $post;
				}

				foreach ( $sections_before_id as $i ) :
					$post = $sections[$i];
					setup_postdata($post);

					$section_before_type = rwmb_meta( 'sn_section_type' );
					get_template_part( 'inc/section-formats/section', $section_before_type );
				endforeach;

			}

			wp_reset_postdata();
		endif;
	?>

	<?php
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();

			$content = get_the_content();
			if (!empty($content)) :
		?>

	<div class="row-main">

		<?php sn_breadcrumbs(); ?>

		<?php get_template_part( 'inc/post-formats/page' ); ?>

		<?php
			// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || '0' != get_comments_number() )
				comments_template();
		?>

	</div>

	<?php
				endif;
			endwhile;
		endif;
	?>

	<?php
		// SECTIONS AFTER
		$sections_after_id = rwmb_meta( 'sn_page_sections_after' );
		if (!empty($sections_after_id)) :
			$sections_after = get_posts( array( 'posts_per_page' => -1, 'post_type' => 'sn_sections', 'post__in' => $sections_after_id, 'orderby' => 'post__in' ) );

			if ( $sections_after ) {
				$sections = array();
				foreach ( $sections_after as $post )
				{
					$sections[$post->ID] = $post;
				}

				foreach ( $sections_after_id as $i ) :
					$post = $sections[$i];
					setup_postdata($post);

					$section_after_type = rwmb_meta( 'sn_section_type' );
					get_template_part( 'inc/section-formats/section', $section_after_type );

				endforeach;
			}
			wp_reset_postdata();
		endif;
	?>

<?php get_footer(); ?>