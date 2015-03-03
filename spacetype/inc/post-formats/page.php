<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package seniores
 */
?>

	<article <?php post_class() ?> id="post-<?php the_ID(); ?>">

		<?php
			$hide_title = rwmb_meta( 'sn_hide_title' );
			if ( !$hide_title ) :
		?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php endif; ?>

		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'sn' ),
				'after'  => '</div>',
			) );
		?>

		<?php edit_post_link( __( 'Edit', 'sn' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>

	</article>