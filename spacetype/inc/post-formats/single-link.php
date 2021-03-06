<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package seniores
 */
?>
		<?php
			$link_name = rwmb_meta( 'sn_post_link_name' );
			$link_url = rwmb_meta( 'sn_post_link_url' );
		?>
		<h1 class="entry-title"><a href="<?php echo esc_url($link_url); ?>"><?php echo $link_name; ?></a></h1>

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

		<?php the_content(); ?>