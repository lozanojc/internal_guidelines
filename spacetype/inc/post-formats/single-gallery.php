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

			<?php
				$gallery = rwmb_meta( 'sn_post_gallery', 'type=image' );

				$slider_fx = rwmb_meta( 'sn_post_gallery_fx' );
				$slider_timeout = rwmb_meta( 'sn_post_gallery_timeout' );
				$slider_easing = rwmb_meta( 'sn_post_gallery_animation' );
				$slider_speed = rwmb_meta( 'sn_post_gallery_speed' );
				$slider_pages = rwmb_meta( 'sn_post_gallery_pages' );
				$slider_nav = rwmb_meta( 'sn_post_gallery_nav' );
				
				if ( !empty( $gallery ) ) :
			?>
			<div class="box-slides" data-cycle-fx="<?php echo $slider_fx; ?>" data-cycle-timeout="<?php echo $slider_timeout; ?>" data-cycle-easing="<?php echo $slider_easing; ?>" data-cycle-speed="<?php echo $slider_speed; ?>">

				<?php
					$content = '';
					foreach ( $gallery as $image ) :
						$image_url = wp_get_attachment_image_src( $image['ID'], 'grid2_3');

						$content .= '<p class="slide"><img src="'.$image_url[0].'" width="'.$image_url[1].'" height="'.$image_url[2].'" alt="'.$image['alt'].'" /></p>';

					endforeach;

					echo $content;

				?>

				<?php if ( count($gallery) > 1 ) : ?>
				<!-- pager -->
				<p class="pager">
					<?php if( $slider_nav == 1 ) : ?>
					<a href="#" class="prev"><span class="vhide"><?php _e('previous', 'sn'); ?></span></a>
					<?php endif; ?>
					<?php if( $slider_pages == 1 ) : ?>
					<span class="pages"></span>
					<?php endif; ?>
					<?php if( $slider_nav == 1 ) : ?>
					<a href="#" class="next"><span class="vhide"><?php _e('next', 'sn'); ?></span></a>
					<?php endif; ?>
				</p>
				<?php endif; ?>
			</div>
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