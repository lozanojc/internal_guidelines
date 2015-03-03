<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package seniores
 */
?>

		<h1 class="entry-title"><?php the_title(); ?></h1>

		<div class="box-article-top">
			<p>
				<?php sn_posted_on(); ?>
				<?php
					if ( comments_open() && ! is_single() ) :
						echo '<span class="line">/</span>';
						echo '<strong>';
						comments_popup_link( '<span class="leave-reply">' . __( 'Leave a comment', 'sn' ) . '</span>', __( 'One comment so far', 'sn' ), __( 'View all % comments', 'sn' ) );
						echo '</strong>';
					endif; // comments_open()
				?>
			</p>
		</div>

		<div class="box-article-teaser">
			<?php if ( has_post_thumbnail() ) : ?>
			<p class="img-content">
				<?php the_post_thumbnail( 'grid2_3' ); ?>
			</p>
			<?php endif; ?>
			<?php if ( $post->post_excerpt ): ?>
			<p class="big">
				<?php echo get_the_excerpt(); ?>
			</p>
			<?php endif; ?>
			<?php
				$show_likes = of_get_option( 'sn_post_social' );
				if ($show_likes == 1)
					echo do_shortcode('[like]');
			?>

		</div>
		<div class="separator"></div>

		<?php
			$audio_id = rwmb_meta( 'sn_post_audio_file' );
			$audio_url = wp_get_attachment_url( $audio_id );
			if ( !empty( $audio_url ) ) :
		?>
		<div class="box-audio">
			<?php echo do_shortcode('[audio '.$audio_url.']'); ?>
		</div>
		<?php endif; ?>

		<?php the_content(); ?>