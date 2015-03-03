
	<?php
		$width = rwmb_meta( 'sn_css_section_width' );
		$slider_fx = rwmb_meta( 'sn_section_slider_fx' );
		$slider_timeout = rwmb_meta( 'sn_section_slider_timeout' );
		$slider_easing = rwmb_meta( 'sn_section_slider_animation' );
		$slider_speed = rwmb_meta( 'sn_section_slider_speed' );
		$slider_pages = rwmb_meta( 'sn_section_slider_pages' );
		$slider_nav = rwmb_meta( 'sn_section_slider_nav' );
	?>

	<div class="section <?php echo $width; ?>" id="section-<?php echo $post->ID; ?>">
		<div id="post-<?php echo $post->ID; ?>" class="section-slider" data-cycle-fx="<?php echo $slider_fx; ?>" data-cycle-timeout="<?php echo $slider_timeout; ?>" data-cycle-easing="<?php echo $slider_easing; ?>" data-cycle-speed="<?php echo $slider_speed; ?>" >

			<?php
				// slides
				$sections_slides_id = rwmb_meta( 'sn_section_slider_items' );
				if (!empty($sections_slides_id)) :
					$sections = get_posts( array( 'post_type' => 'sn_sections', 'post__in' => $sections_slides_id, 'orderby' => 'post__in' ) );
					foreach ( $sections as $post ) :
						setup_postdata($post);

						$sub_width = rwmb_meta( 'sn_css_section_width', array(), $post->ID );
						$slider_link = rwmb_meta( 'sn_section_slider_link', array(), $post->ID );
						$width = rwmb_meta( 'sn_css_section_width', array(), $post->ID );
						$bg_id = rwmb_meta( 'sn_css_bg_image', array(), $post->ID );
						$bg = wp_get_attachment_image_src( $bg_id, 'full' );
			?>

					<!-- slide -->
					<div class="section-slide">
						<?php if ( empty( $slider_link ) ) : ?>
						<div class="section <?php echo $sub_width; ?>">
						<?php else : ?>
						<a href="<?php echo esc_url($slider_link); ?>" class="section <?php echo $sub_width; ?>">
						<?php endif; ?>
							<div id="post-<?php echo $post->ID; ?>" class="section-holder">
								<?php if ( $width == 'section-fullimage' ) : ?>
								<img src="<?php echo $bg[0]; ?>" width="<?php echo $bg[1]; ?>" height="<?php echo $bg[2]; ?>" alt="<?php the_title(); ?>" />
								<?php else : ?>
								<div class="section-inner">
									<div class="row-main">
										<?php the_content(); ?>
									</div>
								</div>
								<?php endif; ?>
							</div>
						<?php if ( empty( $slider_link ) ) : ?>
						</div>
						<?php else : ?>
						</a>
						<?php endif; ?>
					</div>

			<?php
					endforeach;
				endif;
			?>

			<!-- pager -->
			<?php if ( count($sections_slides_id) > 1 ) : ?>
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
	</div>