<?php

/*-----------------------------------------------------------------------------------*/
/*  Create the widget - Custom Latest Tweets
/*-----------------------------------------------------------------------------------*/

add_action( 'widgets_init', 'sn_portfolio_widgets' );
function sn_portfolio_widgets() {
	register_widget( 'SN_Portfolio_Widget' );
}

/*-----------------------------------------------------------------------------------*/
/*  Widget class
/*-----------------------------------------------------------------------------------*/
class sn_portfolio_widget extends WP_Widget {

	function SN_Portfolio_Widget() {

		/*-------------------------------------------------------------------------------*/
		/*	Widget Setup
		/*-------------------------------------------------------------------------------*/
		$widget_ops = array( 'classname' => 'widget_portfolio', 'description' => __('A widget that displays last portfolio item ', 'sn') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sn_portfolio_widget' );
		$this->WP_Widget( 'sn_portfolio_widget', __('Custom Portfolio', 'sn'), $widget_ops, $control_ops );

	}

    /*-----------------------------------------------------------------------------------*/
    /*	Display Widget
    /*-----------------------------------------------------------------------------------*/
	function widget( $args, $instance ) {
		extract( $args );

    	/* Our variables from the widget settings ---------------------------------------*/
		$title = apply_filters('widget_title', $instance['title'] );
		
		$random = $instance['random'];

    	/* Display widget ---------------------------------------------------------------*/
		echo $before_widget;

		if ( $title ) { echo $before_title . $title . $after_title; }

		/* Display Latest Tweets */
		?>

			<?php
				$orderby = ($random == 1) ? 'rand' : 'ID';
				$args = array(
					'post_type' => 'sn_portfolio',
					'orderby' => $orderby,
					'order' => 'DESC',
					'posts_per_page' => 1
				);
				$portfolio_query = new WP_Query($args);

				if( $portfolio_query->have_posts() ) :
			?>

			<div class="crossroad-portfolio">
				<?php
					while( $portfolio_query->have_posts() ) : $portfolio_query->the_post();
					$portfolio_title = of_get_option( 'sn_portfolio_title' );
				?>

				<article>
					<?php if ( $portfolio_title == 'bottom' ) : ?>
					<a href="<?php the_permalink(); ?>">
						<p class="img-content">
							<?php the_post_thumbnail( 'portfolio_3' ); ?>
	                        <span class="caption">
	                            <span class="holder">
	                                <span class="text">
	                                    <span class="icon icon-hover-plus"></span>
	                                </span>
	                            </span>
	                        </span>
						</p>
						<p class="small"><?php the_title(); ?></p>
					</a>
					<?php else : ?>
					<a href="<?php the_permalink(); ?>">
						<p class="img-content">
							<?php the_post_thumbnail( 'portfolio_3' ); ?>
	                        <span class="caption"></span>
						</p>
					</a>
					<?php endif; ?>
				</article>

				<?php
					endwhile;
					wp_reset_postdata();

					global $portfolio_page_id;
					if ( !empty( $portfolio_page_id ) ) :
				?>
				<p>
					<a href="<?php echo get_permalink( $portfolio_page_id ); ?>" class="light"><?php _e('More', 'sn'); ?></a>
				</p>
				<?php endif; ?>
			</div>

			<?php endif; ?>
		
		<?php 

		echo $after_widget;
	}

    /*-------------------------------------------------------------------------------*/
    /*	Update Widget
    /*-------------------------------------------------------------------------------*/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags to remove HTML (important for text inputs). -------------------*/
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['random'] = strip_tags( $new_instance['random'] );

		return $instance;
	}
	
    /*-------------------------------------------------------------------------------*/
    /*	Widget Settings (Displays the widget settings controls on the widget panel)
    /*-------------------------------------------------------------------------------*/
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title' => 'Latest work',
			'random' => 0
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		
		/* Build our form -----------------------------------------------------------*/
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'random' ); ?>"><?php _e('Random', 'sn') ?></label>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'random' ); ?>" name="<?php echo $this->get_field_name( 'random' ); ?>" value="1" <?php checked($instance['random'], 1); ?> />
		</p>

	<?php
	}

}

?>