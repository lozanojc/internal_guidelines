<?php
/**
 * @package seniores
 */
?>

<article <?php post_class(); ?>>
	<h2 class="entry-title"><?php echo get_the_content(); ?></h2>

	<?php the_content(); ?>

	<?php
		$quote_author = rwmb_meta( 'sn_post_quote_author' );
		if (!empty($quote_author)) :
	?>
	<p><strong><?php echo $quote_author; ?></strong></p>
	<?php endif; ?>

	<p class="small">
		<?php sn_posted_on(); ?>
	</p>
</article><!-- #post -->