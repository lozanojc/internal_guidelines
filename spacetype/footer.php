<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package seniores
 */
?>

			<?php sn_content_end(); ?>

		</div><!-- /main -->

		<?php sn_footer_before(); ?>

		<footer id="footer">
			<div class="row-main">

				<?php
					if ( is_active_sidebar( 'sidebar-footer' ) ) :
						$count = sn_count_sidebar_widgets( 'sidebar-footer', false );
				?>

					<div class="grid widgets widgets<?php echo $count; ?>">
						<?php dynamic_sidebar( 'sidebar-footer' ); ?>
					</div>

				<?php endif; ?>

				<?php sn_footer_in(); ?>

			</div>
		</footer>


		<?php sn_footer_after(); ?>

		<?php wp_footer(); ?>

	</body>
</html>