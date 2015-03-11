<?php
/**
 * Template Name: Home Screen
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package seniores
 */

get_header(); ?>

	<?php
		// SECTIONS BEFORE
		$sections_before_id = rwmb_meta( 'sn_page_sections_before' );

		if (!empty($sections_before_id)) :
			$sections_before = get_posts( array( 'posts_per_page' => -1, 'post_type' => 'sn_sections', 'post__in' => $sections_before_id, 'orderby' => 'post__in' ) );

			if ( $sections_before ) {

				$sections = array();
				foreach ( $sections_before as $post ) {
					$sections[$post->ID] = $post;
				}

				foreach ( $sections_before_id as $i ) :
					$post = $sections[$i];
					setup_postdata($post);

					$section_before_type = rwmb_meta( 'sn_section_type' );
					get_template_part( 'inc/section-formats/section', $section_before_type );
				endforeach;

			}

			wp_reset_postdata();
		endif;
	?>
	<div class="welcome-section home-sections">
		<div class="welcome-header"><?php the_field('welcome-text'); ?>
			<img class="color-palette" alt="" src="https://cdn.cpbgroup.com/styles/hero-content-image/s3/CPBcolor-palette.jpg?itok=gJOgVm9r">
		</div>
		<?php the_field('instagram_sc'); ?>
	</div>

	<div class="templates home-sections">
			<h1>Document Library</h1>
			<a class="template sow" href="<?php get_home_url();?>/<?php the_field('sow_link');?>">
				<div class="flip-container" ontouchstart="this.classList.toggle('hover');">
					<div class="flipper">
						<div class="front">
							<h2><?php the_field('sow_title'); ?></h2>
						</div>
						<div class="back">
							<p class="excerpt"><?php the_field('sow_excerpt'); ?></p>
						</div>
					</div>
				</div>
			</a>

			<a class="template rfp" href="<?php get_site_url();?>/<?php the_field('rfp_link'); ?>">
				<div class="flip-container" ontouchstart="this.classList.toggle('hover');">
					<div class="flipper">
						<div class="front">
							<h2><?php the_field('rfp_title'); ?></h2>
						</div>
					
						<div class="back">
							<p class="excerpt"><?php the_field('rfp_excerpt'); ?></p>
						</div>
					</div>
				</div>

			</a>

			<a class="template vs" href="<?php get_site_url();?>/<?php the_field('vs_link'); ?>">
				<div class="flip-container" ontouchstart="this.classList.toggle('hover');">
					<div class="flipper">
						<div class="front">
							<h2><?php the_field('vs_title'); ?></h2>
						</div>
					
						<div class="back">
							<p class="excerpt"><?php the_field('vs_excerpt'); ?></p>
						</div>
					</div>
				</div>
			</a>

			<a class="template ci" href="<?php get_site_url();?>/<?php the_field('ci_link'); ?>">
				<div class="flip-container" ontouchstart="this.classList.toggle('hover');">
					<div class="flipper">
						<div class="front">
							<h2><?php the_field('ci_title'); ?></h2>
						</div>

						<div class="back">
							<p class="excerpt"><?php the_field('ci_excerpt'); ?></p>
						</div>
					</div>
				</div>

			</a>

			<a class="template bp" href="<?php get_site_url();?>/<?php the_field('bp_link'); ?>">
				<div class="flip-container" ontouchstart="this.classList.toggle('hover');">
					<div class="flipper">
						<div class="front">
							<h2><?php the_field('bp_title'); ?></h2>
						</div>

						<div class="back">
							<p class="excerpt"><?php the_field('bp_excerpt'); ?></p>
						</div>
					</div>
				</div>	

			</a>

			<a class="template dev" href="<?php the_field('dev_link'); ?>">
				<div class="flip-container" ontouchstart="this.classList.toggle('hover');">
					<div class="flipper">
						<div class="front">
							<h2><?php the_field('dev_title'); ?></h2>
						</div>

						<div class="back">
							<p class="excerpt"><?php the_field('dev_excerpt'); ?></p>
						</div>
					</div>
				</div>	
			</a>

			<a class="template nda" href="<?php the_field('nda_link'); ?>">
				<div class="flip-container" ontouchstart="this.classList.toggle('hover');">
					<div class="flipper">
						<div class="front">
							<h2><?php the_field('nda_title'); ?></h2>
						</div>

						<div class="back">
							<p class="excerpt"><?php the_field('nda_excerpt'); ?></p>
						</div>
					</div>
				</div>
			</a>

			<a class="template magic" href="<?php the_field('magic_link'); ?>">
				<div class="flip-container" ontouchstart="this.classList.toggle('hover');">
					<div class="flipper">
						<div class="front">
							<h2><?php the_field('magic_title'); ?></h2>
						</div>

						<div class="back">
							<p class="excerpt"><?php the_field('magic_excerpt'); ?></p>
						</div>
					</div>
				</div>
			</a>

			<a class="template design" href="<?php the_field('design_link'); ?>">
				<div class="flip-container" ontouchstart="this.classList.toggle('hover');">
					<div class="flipper">
						<div class="front">
							<h2><?php the_field('design_title'); ?></h2>
						</div>

						<div class="back">
							<p class="excerpt"><?php the_field('design_excerpt'); ?></p>
						</div>
					</div>
				</div>
			</a>
	</div>



	<div class = "hot-shit home-sections">			
			<h1>Internal Tools</h1>
		<?php
			$args = array(
				'post_type' => 'hot_shit',
				'orderby' => 'time',
				'order' => 'ASC', 
				'posts_per_page' => 20
			);
			$loop2 = new WP_Query( $args );

			$obj = get_post_type_object('hot_shit');
			?>
			
			<?php
			while ( $loop2->have_posts()) : $loop2->the_post(); ?>

				<a class="template hs" target="_blank" href="<?php the_field('hs_link'); ?>">
					<div class="flip-container" ontouchstart="this.classList.toggle('hover');">
						<div class="flipper">
							<div class="front">
								<h3><?php the_title(); ?></h3>
							</div>
							<div class="back">
								<div class="excerpt"><?php the_content(); ?></div>
							</div>
						</div>
					</div>
				</a>

			
		<?php endwhile; wp_reset_query(); ?>
	</div>




	<div class = "important-stuff home-sections">					
			<h1>External Tools</h1>

		<?php
			$args = array(
				'post_type' => 'important_s',
				'orderby' => 'time',
				'order' => 'ASC', 
				'posts_per_page' => 20
			);
			$loop1 = new WP_Query( $args );

			$obj = get_post_type_object('important_s');
			?>
			
			<?php
			while ( $loop1->have_posts()) : $loop1->the_post(); ?>

				<a class="template is" target="_blank" href="<?php the_field('hs_link'); ?>">
					<div class="flip-container" ontouchstart="this.classList.toggle('hover');">
						<div class="flipper">
							<div class="front">
								<h3><?php the_title(); ?></h3>
							</div>
							<div class="back">
								<div class="excerpt"><?php the_content(); ?></div>
							</div>
						</div>
					</div>
				</a>

			
		<?php endwhile; wp_reset_query(); ?>
	</div>




	<?php
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();

			$content = get_the_content();
			if (!empty($content)) :
		?>

	<div class="row-main">

		<?php get_template_part( 'inc/post-formats/page' ); ?>

		<?php
			// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || '0' != get_comments_number() )
				comments_template();
		?>

	</div>

	<?php
				endif;
			endwhile;
		endif;
	?>

	<?php
		// SECTIONS AFTER
		$sections_after_id = rwmb_meta( 'sn_page_sections_after' );
		if (!empty($sections_after_id)) :
			$sections_after = get_posts( array( 'posts_per_page' => -1, 'post_type' => 'sn_sections', 'post__in' => $sections_after_id, 'orderby' => 'post__in' ) );

			if ( $sections_after ) {
				$sections = array();
				foreach ( $sections_after as $post )
				{
					$sections[$post->ID] = $post;
				}

				foreach ( $sections_after_id as $i ) :
					$post = $sections[$i];
					setup_postdata($post);

					$section_after_type = rwmb_meta( 'sn_section_type' );
					get_template_part( 'inc/section-formats/section', $section_after_type );

				endforeach;
			}
			wp_reset_postdata();
		endif;
	?>

<?php get_footer(); ?>