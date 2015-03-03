<?php
/**
 * @package seniores
 */
?>

<article <?php post_class(); ?>>
	<?php
		$link_name = rwmb_meta( 'sn_post_link_name' );
		$link_url = rwmb_meta( 'sn_post_link_url' );
	?>
	<h2 class="entry-title"><a href="<?php echo esc_url($link_url); ?>"><?php echo $link_name; ?></a></h2>

	<p class="small">
		<?php sn_posted_on(); ?>
	</p>
</article><!-- #post -->