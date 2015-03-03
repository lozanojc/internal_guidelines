<?php
/**
 * @package seniores
 */
?>

<article <?php post_class(); ?>>
	<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

	<?php the_excerpt(); ?>

	<?php
		$embed = rwmb_meta( 'sn_post_video' );
		if ( !empty( $embed ) ) :
	?>
	<div class="box-video">
		<div class="video"><?php echo $embed; ?></div>
	</div>
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
