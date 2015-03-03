<?php
/**
 * @package seniores
 */
?>

<article <?php post_class(); ?>>
	<h2 class="entry-title"><?php echo get_the_content(); ?></h2>

	<p class="small">
		<?php sn_posted_on(); ?>
	</p>
</article><!-- #post -->