
	<?php
		$width = rwmb_meta( 'sn_css_section_width' );
		$bg_id = rwmb_meta( 'sn_css_bg_image' );
		$bg = wp_get_attachment_image_src( $bg_id, 'full' );
	?>

	<div class="section <?php echo $width; ?>" id="section-<?php echo $post->ID; ?>">
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
	</div>