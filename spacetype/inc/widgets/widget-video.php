<?php

/*-----------------------------------------------------------------------------------*/
/*  Create the widget - Custom Latest Tweets
/*-----------------------------------------------------------------------------------*/

add_action( 'widgets_init', 'sn_video_widgets' );
function sn_video_widgets() {
	register_widget( 'SN_Video_Widget' );
}

/*-----------------------------------------------------------------------------------*/
/*  Widget class
/*-----------------------------------------------------------------------------------*/
class sn_video_widget extends WP_Widget {

	function SN_Video_Widget() {

		/*-------------------------------------------------------------------------------*/
		/*	Widget Setup
		/*-------------------------------------------------------------------------------*/
		$widget_ops = array( 'classname' => 'widget_video', 'description' => __('A widget that displays custom video ', 'sn') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sn_video_widget' );
		$this->WP_Widget( 'sn_video_widget', __('Custom Video', 'sn'), $widget_ops, $control_ops );

	}

    /*-----------------------------------------------------------------------------------*/
    /*	Display Widget
    /*-----------------------------------------------------------------------------------*/
	function widget( $args, $instance ) {
		extract( $args );

    	/* Our variables from the widget settings ---------------------------------------*/
		$title = apply_filters('widget_title', $instance['title'] );
		
		$sn_embed = $instance['embed'];
		$sn_description = $instance['description'];

    	/* Display widget ---------------------------------------------------------------*/
		echo $before_widget;

		if ( $title ) { echo $before_title . $title . $after_title; }

		/* Display Latest Tweets */
		?>

		<div class="box-video">
			<div class="video">
				<?php echo $sn_embed; ?>
			</div>
		</div>
		<?php if (!empty($sn_description)) : ?>
		<p><?php echo $sn_description; ?></p>
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
		$instance['embed'] = stripslashes( $new_instance['embed']);
		$instance['description'] = stripslashes( $new_instance['description']);

		return $instance;
	}
	
    /*-------------------------------------------------------------------------------*/
    /*	Widget Settings (Displays the widget settings controls on the widget panel)
    /*-------------------------------------------------------------------------------*/
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title' => 'Video widget',
			'embed' => '',
			'description' => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		
		/* Build our form -----------------------------------------------------------*/
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'embed' ); ?>"><?php _e('Embed', 'sn') ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id( 'embed' ); ?>" name="<?php echo $this->get_field_name( 'embed' ); ?>"><?php echo $instance['embed']; ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e('Description', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" value="<?php echo $instance['description']; ?>" />
		</p>

	<?php
	}

}

?>