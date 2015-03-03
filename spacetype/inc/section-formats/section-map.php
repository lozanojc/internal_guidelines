
	<?php
		$width = rwmb_meta( 'sn_css_section_width' );
		$map_type = rwmb_meta( 'sn_section_map_type' );
		$map_address = rwmb_meta( 'sn_section_map_address' );
		$map_zoom = rwmb_meta( 'sn_section_map_zoom' );
		$map_marker = rwmb_meta( 'sn_section_map_marker' );
		$map_style = rwmb_meta( 'sn_section_map_style' );
		$map_style = str_replace("\r\n", '', $map_style);

	?>

	<!-- Mapa sekce -->
	<div class="section <?php echo $width; ?>" id="section-<?php echo $post->ID; ?>">
		<div id="post-<?php echo $post->ID; ?>" class="section-holder section-map" data-map-address="<?php echo $map_address; ?>" data-map-zoom="<?php echo $map_zoom; ?>" data-map-marker="<?php echo $map_marker; ?>" data-map-styles='<?php echo $map_style; ?>'>
			<div class="map"></div>
		</div>
	</div>