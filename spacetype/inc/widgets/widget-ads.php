<?php

/*-----------------------------------------------------------------------------------*/
/*  Create the widget - Custom Latest Tweets
/*-----------------------------------------------------------------------------------*/

add_action( 'widgets_init', 'sn_ads_widgets' );
function sn_ads_widgets() {
	register_widget( 'SN_Ads_Widget' );
}

/*-----------------------------------------------------------------------------------*/
/*  Widget class
/*-----------------------------------------------------------------------------------*/
class sn_ads_widget extends WP_Widget {

	function SN_Ads_Widget() {

		/*-------------------------------------------------------------------------------*/
		/*	Widget Setup
		/*-------------------------------------------------------------------------------*/
		$widget_ops = array( 'classname' => 'widget_action', 'description' => __('A widget that displays 125x125 ads ', 'sn') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sn_ads_widget' );
		$this->WP_Widget( 'sn_ads_widget', __('Custom Ads 125', 'sn'), $widget_ops, $control_ops );

	}

    /*-----------------------------------------------------------------------------------*/
    /*	Display Widget
    /*-----------------------------------------------------------------------------------*/
	function widget( $args, $instance ) {
		extract( $args );

    	/* Our variables from the widget settings ---------------------------------------*/
		$title = apply_filters('widget_title', $instance['title'] );
		
		$sn_ad1 = $instance['ad1'];
		$sn_ad2 = $instance['ad2'];
		$sn_ad3 = $instance['ad3'];
		$sn_ad4 = $instance['ad4'];
		$sn_link1 = $instance['link1'];
		$sn_link2 = $instance['link2'];
		$sn_link3 = $instance['link3'];
		$sn_link4 = $instance['link4'];

    	/* Display widget ---------------------------------------------------------------*/
		echo $before_widget;

		if ( $title ) { echo $before_title . $title . $after_title; }

		/* Display Latest Tweets */
		?>

		<?php

			$ads = array();

			// ad1
			if ($sn_link1) {
				$ads[] = '<li><a href="' . esc_url($sn_link1) . '"><img src="' . $sn_ad1 . '" alt="" width="125" height="125" /></a></li>';
			} elseif ($sn_ad1) {
				$ads[] = '<li><img src="' . $sn_ad1 . '" alt="" width="125" height="125" /></li>';
			}

			// ad2
			if ($sn_link2) {
				$ads[] = '<li><a href="' . esc_url($sn_link2) . '"><img src="' . $sn_ad2 . '" alt="" width="125" height="125" /></a></li>';
			} elseif ($sn_ad2) {
				$ads[] = '<li><img src="' . $sn_ad2 . '" alt="" width="125" height="125" /></li>';
			}

			// ad3
			if ($sn_link3) {
				$ads[] = '<li><a href="' . esc_url($sn_link3) . '"><img src="' . $sn_ad3 . '" alt="" width="125" height="125" /></a></li>';
			} elseif ($sn_ad3) {
				$ads[] = '<li><img src="' . $sn_ad3 . '" alt="" width="125" height="125" /></li>';
			}

			// ad4
			if ($sn_link4) {
				$ads[] = '<li><a href="' . esc_url($sn_link4) . '"><img src="' . $sn_ad4 . '" alt="" width="125" height="125" /></a></li>';
			} elseif ($sn_ad4) {
				$ads[] = '<li><img src="' . $sn_ad4 . '" alt="" width="125" height="125" /></li>';
			}

			echo '<ul class="reset">';
			foreach($ads as $ad){
				echo $ad;
			}
			echo '</ul>';

		?>
		
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
		$instance['ad1'] = strip_tags( $new_instance['ad1'] );
		$instance['ad2'] = strip_tags( $new_instance['ad2'] );
		$instance['ad3'] = strip_tags( $new_instance['ad3'] );
		$instance['ad4'] = strip_tags( $new_instance['ad4'] );
		$instance['link1'] = strip_tags( $new_instance['link1'] );
		$instance['link2'] = strip_tags( $new_instance['link2'] );
		$instance['link3'] = strip_tags( $new_instance['link3'] );
		$instance['link4'] = strip_tags( $new_instance['link4'] );

		return $instance;
	}
	
    /*-------------------------------------------------------------------------------*/
    /*	Widget Settings (Displays the widget settings controls on the widget panel)
    /*-------------------------------------------------------------------------------*/
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title' => 'Banner Widget',
			'ad1' => '',
			'ad2' => '',
			'ad3' => '',
			'ad4' => '',
			'link1' => '',
			'link2' => '',
			'link3' => '',
			'link4' => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		/* Build our form -----------------------------------------------------------*/
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'ad1' ); ?>"><?php _e('Ad 1 image url', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'ad1' ); ?>" name="<?php echo $this->get_field_name( 'ad1' ); ?>" value="<?php echo $instance['ad1']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link1' ); ?>"><?php _e('Ad 1 link url', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'link1' ); ?>" name="<?php echo $this->get_field_name( 'link1' ); ?>" value="<?php echo $instance['link1']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'ad2' ); ?>"><?php _e('Ad 2 image url', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'ad2' ); ?>" name="<?php echo $this->get_field_name( 'ad2' ); ?>" value="<?php echo $instance['ad2']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link2' ); ?>"><?php _e('Ad 2 link url', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'link2' ); ?>" name="<?php echo $this->get_field_name( 'link2' ); ?>" value="<?php echo $instance['link2']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'ad3' ); ?>"><?php _e('Ad 3 image url', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'ad3' ); ?>" name="<?php echo $this->get_field_name( 'ad3' ); ?>" value="<?php echo $instance['ad3']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link3' ); ?>"><?php _e('Ad 3 link url', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'link3' ); ?>" name="<?php echo $this->get_field_name( 'link3' ); ?>" value="<?php echo $instance['link3']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'ad4' ); ?>"><?php _e('Ad 4 image url', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'ad4' ); ?>" name="<?php echo $this->get_field_name( 'ad4' ); ?>" value="<?php echo $instance['ad4']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link4' ); ?>"><?php _e('Ad 4 link url', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'link4' ); ?>" name="<?php echo $this->get_field_name( 'link4' ); ?>" value="<?php echo $instance['link4']; ?>" />
		</p>

	<?php
	}

}

?>