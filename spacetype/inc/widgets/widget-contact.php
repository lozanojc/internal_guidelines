<?php

/*-----------------------------------------------------------------------------------*/
/*  Create the widget - Custom Latest Tweets
/*-----------------------------------------------------------------------------------*/

add_action( 'widgets_init', 'sn_contact_widgets' );
function sn_contact_widgets() {
	register_widget( 'SN_Contact_Widget' );
}

/*-----------------------------------------------------------------------------------*/
/*  Widget class
/*-----------------------------------------------------------------------------------*/
class sn_contact_widget extends WP_Widget {

	function SN_Contact_Widget() {

		/*-------------------------------------------------------------------------------*/
		/*	Widget Setup
		/*-------------------------------------------------------------------------------*/
		$widget_ops = array( 'classname' => 'widget_contact', 'description' => __('A widget that displays contact address ', 'sn') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sn_contact_widget' );
		$this->WP_Widget( 'sn_contact_widget', __('Custom Address', 'sn'), $widget_ops, $control_ops );

	}

    /*-----------------------------------------------------------------------------------*/
    /*	Display Widget
    /*-----------------------------------------------------------------------------------*/
	function widget( $args, $instance ) {
		extract( $args );

    	/* Our variables from the widget settings ---------------------------------------*/
		$title = apply_filters('widget_title', $instance['title'] );
		
		$sn_row1_hd = $instance['row1_hd'];
		$sn_row1 = $instance['row1'];
		$sn_row2_hd = $instance['row2_hd'];
		$sn_row2 = $instance['row2'];
		$sn_row3_hd = $instance['row3_hd'];
		$sn_row3 = $instance['row3'];
		$sn_row4_hd = $instance['row4_hd'];
		$sn_row4 = $instance['row4'];

    	/* Display widget ---------------------------------------------------------------*/
		echo $before_widget;

		if ( $title ) { echo $before_title . $title . $after_title; }

		/* Display Latest Tweets */
		?>

			<table class="reset">
				<?php if ( !empty($sn_row1_hd) && !empty($sn_row1) ) : ?>
				<tr>
					<td><?php echo $sn_row1_hd; ?></td>
					<td><?php echo $sn_row1; ?></td>
				</tr>
				<?php endif; ?>
				<?php if ( !empty($sn_row2_hd) && !empty($sn_row2) ) : ?>
				<tr>
					<td><?php echo $sn_row2_hd; ?></td>
					<td><?php echo $sn_row2; ?></td>
				</tr>
				<?php endif; ?>
				<?php if ( !empty($sn_row3_hd) && !empty($sn_row3) ) : ?>
				<tr>
					<td><?php echo $sn_row3_hd; ?></td>
					<td><?php echo $sn_row3; ?></td>
				</tr>
				<?php endif; ?>
				<?php if ( !empty($sn_row4_hd) && !empty($sn_row4) ) : ?>
				<tr>
					<td><?php echo $sn_row4_hd; ?></td>
					<td><?php echo $sn_row4; ?></td>
				</tr>
				<?php endif; ?>
			</table>
		
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
		$instance['row1_hd'] = strip_tags( $new_instance['row1_hd'] );
		$instance['row1'] = strip_tags( $new_instance['row1'] );
		$instance['row2_hd'] = strip_tags( $new_instance['row2_hd'] );
		$instance['row2'] = strip_tags( $new_instance['row2'] );
		$instance['row3_hd'] = strip_tags( $new_instance['row3_hd'] );
		$instance['row3'] = strip_tags( $new_instance['row3'] );
		$instance['row4_hd'] = strip_tags( $new_instance['row4_hd'] );
		$instance['row4'] = strip_tags( $new_instance['row4'] );

		return $instance;
	}
	
    /*-------------------------------------------------------------------------------*/
    /*	Widget Settings (Displays the widget settings controls on the widget panel)
    /*-------------------------------------------------------------------------------*/
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title' => 'Contact us',
			'row1_hd' => '',
			'row1' => '',
			'row2_hd' => '',
			'row2' => '',
			'row3_hd' => '',
			'row3' => '',
			'row4_hd' => '',
			'row4' => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		
		/* Build our form -----------------------------------------------------------*/
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'row1_hd' ); ?>"><?php _e('Row 1 header', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'row1_hd' ); ?>" name="<?php echo $this->get_field_name( 'row1_hd' ); ?>" value="<?php echo $instance['row1_hd']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'row1' ); ?>"><?php _e('Row 1 text', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'row1' ); ?>" name="<?php echo $this->get_field_name( 'row1' ); ?>" value="<?php echo $instance['row1']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'row2_hd' ); ?>"><?php _e('Row 2 header', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'row2_hd' ); ?>" name="<?php echo $this->get_field_name( 'row2_hd' ); ?>" value="<?php echo $instance['row2_hd']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'row2' ); ?>"><?php _e('Row 2 text', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'row2' ); ?>" name="<?php echo $this->get_field_name( 'row2' ); ?>" value="<?php echo $instance['row2']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'row3_hd' ); ?>"><?php _e('Row 3 header', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'row3_hd' ); ?>" name="<?php echo $this->get_field_name( 'row3_hd' ); ?>" value="<?php echo $instance['row3_hd']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'row3' ); ?>"><?php _e('Row 3 text', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'row3' ); ?>" name="<?php echo $this->get_field_name( 'row3' ); ?>" value="<?php echo $instance['row3']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'row4_hd' ); ?>"><?php _e('Row 4 header', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'row4_hd' ); ?>" name="<?php echo $this->get_field_name( 'row4_hd' ); ?>" value="<?php echo $instance['row4_hd']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'row4' ); ?>"><?php _e('Row 3 text', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'row4' ); ?>" name="<?php echo $this->get_field_name( 'row4' ); ?>" value="<?php echo $instance['row4']; ?>" />
		</p>

	<?php
	}

}

?>