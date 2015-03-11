<?php
/**
 * @package seniores
 */
?>

<a class="download-link" href="<?php the_field('download_file') ?>" target= "_blank">
	<article <?php post_class(); ?>>
		<h2 class="entry-title"><?php the_title(); ?></h2>

		<?php the_excerpt(); ?>

		<?php if ( has_post_thumbnail() ) : ?>
		<p class="img-content">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'grid2_3' ); ?>
			</a>
		</p>
		<?php endif; ?>

		<p class="small">
			<?php sn_posted_on(); ?>
			<?php
				if ( comments_open() && ! is_single() ) :
					echo '<span class="line">/</span>';
					echo '<strong>';
					comments_popup_link( '<span class="leave-reply">' . __( 'Leave a comment', 'sn' ) . '</span>', __( 'One comment so far', 'sn' ), __( 'View all % comments', 'sn' ) );
					echo '</strong>';
				endif; // comments_open()
			?>
			<br />
			<span class="light">
				<?php the_tags( __('Tags:', 'sn') . ' ', ', ', ''); ?>
			</span>
		</p>
	</article><!-- #post -->
</a>