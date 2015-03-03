<?php

/*-----------------------------------------------------------------------------------*/
/*  Create the widget - Custom Latest Tweets
/*-----------------------------------------------------------------------------------*/

add_action( 'widgets_init', 'sn_social_widgets' );
function sn_social_widgets() {
	register_widget( 'SN_Social_Widget' );
}

/*-----------------------------------------------------------------------------------*/
/*  Widget class
/*-----------------------------------------------------------------------------------*/
class sn_social_widget extends WP_Widget {

	function SN_Social_Widget() {

		/*-------------------------------------------------------------------------------*/
		/*	Widget Setup
		/*-------------------------------------------------------------------------------*/
		$widget_ops = array( 'classname' => 'widget_social', 'description' => __('A widget that displays social icons', 'sn') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sn_social_widget' );
		$this->WP_Widget( 'sn_social_widget', __('Custom Social Icons', 'sn'), $widget_ops, $control_ops );

	}

    /*-----------------------------------------------------------------------------------*/
    /*	Display Widget
    /*-----------------------------------------------------------------------------------*/
	function widget( $args, $instance ) {
		extract( $args );

    	/* Our variables from the widget settings ---------------------------------------*/
		$title = apply_filters('widget_title', $instance['title'] );
		
		$sn_youtube = $instance['youtube'];
		$sn_vimeo = $instance['vimeo'];
		$sn_twitter = $instance['twitter'];
		$sn_soundcloud = $instance['soundcloud'];
		$sn_skype = $instance['skype'];
		$sn_pinterest = $instance['pinterest'];
		$sn_linkedin = $instance['linkedin'];
		$sn_lastfm = $instance['lastfm'];
		$sn_instagram = $instance['instagram'];
		$sn_googleplus = $instance['googleplus'];
		$sn_github = $instance['github'];
		$sn_forrst = $instance['forrst'];
		$sn_flickr = $instance['flickr'];
		$sn_facebook = $instance['facebook'];
		$sn_dribbble = $instance['dribbble'];
		$sn_deviantart = $instance['deviantart'];
		$sn_behance = $instance['behance'];

    	/* Display widget ---------------------------------------------------------------*/
		echo $before_widget;

		if ( $title ) { echo $before_title . $title . $after_title; }

		/* Display Latest Tweets */
		?>

		<ul class="reset">
			<?php if( !empty( $sn_youtube ) ) : ?>
			<li>
				<a href="<?php echo esc_url($sn_youtube); ?>" target="_blank">
					<span class="icon icon-social-youtube"></span>
					<span class="vhide"><?php _e('Youtube', 'sn'); ?></span>
				</a>
			</li>
			<?php endif; ?>
			<?php if( !empty( $sn_vimeo ) ) : ?>
			<li>
				<a href="<?php echo esc_url($sn_vimeo); ?>" target="_blank">
					<span class="icon icon-social-vimeo "></span>
					<span class="vhide"><?php _e('Vimeo', 'sn'); ?></span>
				</a>
			</li>
			<?php endif; ?>
			<?php if( !empty( $sn_twitter ) ) : ?>
			<li>
				<a href="<?php echo esc_url($sn_twitter); ?>" target="_blank">
					<span class="icon icon-social-twitter "></span>
					<span class="vhide"><?php _e('Twitter', 'sn'); ?></span>
				</a>
			</li>
			<?php endif; ?>
			<?php if( !empty( $sn_soundcloud ) ) : ?>
			<li>
				<a href="<?php echo esc_url($sn_soundcloud); ?>" target="_blank">
					<span class="icon icon-social-soundcloud"></span>
					<span class="vhide"><?php _e('Soundcloud', 'sn'); ?></span>
				</a>
			</li>
			<?php endif; ?>
			<?php if( !empty( $sn_skype ) ) : ?>
			<li>
				<a href="<?php echo esc_url($sn_skype); ?>" target="_blank">
					<span class="icon icon-social-skype"></span>
					<span class="vhide"><?php _e('Skype', 'sn'); ?></span>
				</a>
			</li>
			<?php endif; ?>
			<?php if( !empty( $sn_pinterest ) ) : ?>
			<li>
				<a href="<?php echo esc_url($sn_pinterest); ?>" target="_blank">
					<span class="icon icon-social-pinterest"></span>
					<span class="vhide"><?php _e('Pinterest', 'sn'); ?></span>
				</a>
			</li>
			<?php endif; ?>
			<?php if( !empty( $sn_linkedin ) ) : ?>
			<li>
				<a href="<?php echo esc_url($sn_linkedin); ?>" target="_blank">
					<span class="icon icon-social-linkedin"></span>
					<span class="vhide"><?php _e('linkedin', 'sn'); ?></span>
				</a>
			</li>
			<?php endif; ?>
			<?php if( !empty( $sn_lastfm ) ) : ?>
			<li>
				<a href="<?php echo esc_url($sn_lastfm); ?>" target="_blank">
					<span class="icon icon-social-lastfm"></span>
					<span class="vhide"><?php _e('lastfm', 'sn'); ?></span>
				</a>
			</li>
			<?php endif; ?>
			<?php if( !empty( $sn_instagram ) ) : ?>
			<li>
				<a href="<?php echo esc_url($sn_instagram); ?>" target="_blank">
					<span class="icon icon-social-instagram"></span>
					<span class="vhide"><?php _e('instagram', 'sn'); ?></span>
				</a>
			</li>
			<?php endif; ?>
			<?php if( !empty( $sn_googleplus ) ) : ?>
			<li>
				<a href="<?php echo esc_url($sn_googleplus); ?>" target="_blank">
					<span class="icon icon-social-googleplus"></span>
					<span class="vhide"><?php _e('googleplus', 'sn'); ?></span>
				</a>
			</li>
			<?php endif; ?>
			<?php if( !empty( $sn_github ) ) : ?>
			<li>
				<a href="<?php echo esc_url($sn_github); ?>" target="_blank">
					<span class="icon icon-social-github"></span>
					<span class="vhide"><?php _e('github', 'sn'); ?></span>
				</a>
			</li>
			<?php endif; ?>
			<?php if( !empty( $sn_forrst ) ) : ?>
			<li>
				<a href="<?php echo esc_url($sn_forrst); ?>" target="_blank">
					<span class="icon icon-social-forrst"></span>
					<span class="vhide"><?php _e('forrst', 'sn'); ?></span>
				</a>
			</li>
			<?php endif; ?>
			<?php if( !empty( $sn_flickr ) ) : ?>
			<li>
				<a href="<?php echo esc_url($sn_flickr); ?>" target="_blank">
					<span class="icon icon-social-flickr"></span>
					<span class="vhide"><?php _e('flickr', 'sn'); ?></span>
				</a>
			</li>
			<?php endif; ?>
			<?php if( !empty( $sn_facebook ) ) : ?>
			<li>
				<a href="<?php echo esc_url($sn_facebook); ?>" target="_blank">
					<span class="icon icon-social-facebook"></span>
					<span class="vhide"><?php _e('facebook', 'sn'); ?></span>
				</a>
			</li>
			<?php endif; ?>
			<?php if( !empty( $sn_dribbble ) ) : ?>
			<li>
				<a href="<?php echo esc_url($sn_dribbble); ?>" target="_blank">
					<span class="icon icon-social-dribbble"></span>
					<span class="vhide"><?php _e('dribbble', 'sn'); ?></span>
				</a>
			</li>
			<?php endif; ?>
			<?php if( !empty( $sn_deviantart ) ) : ?>
			<li>
				<a href="<?php echo esc_url($sn_deviantart); ?>" target="_blank">
					<span class="icon icon-social-deviantart"></span>
					<span class="vhide"><?php _e('deviantart', 'sn'); ?></span>
				</a>
			</li>
			<?php endif; ?>
			<?php if( !empty( $sn_behance ) ) : ?>
			<li>
				<a href="<?php echo esc_url($sn_behance); ?>" target="_blank">
					<span class="icon icon-social-behance"></span>
					<span class="vhide"><?php _e('behance', 'sn'); ?></span>
				</a>
			</li>
			<?php endif; ?>
		</ul>
		
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
		$instance['youtube'] = strip_tags( $new_instance['youtube'] );
		$instance['vimeo'] = strip_tags( $new_instance['vimeo'] );
		$instance['twitter'] = strip_tags( $new_instance['twitter'] );
		$instance['soundcloud'] = strip_tags( $new_instance['soundcloud'] );
		$instance['skype'] = strip_tags( $new_instance['skype'] );
		$instance['pinterest'] = strip_tags( $new_instance['pinterest'] );
		$instance['linkedin'] = strip_tags( $new_instance['linkedin'] );
		$instance['lastfm'] = strip_tags( $new_instance['lastfm'] );
		$instance['instagram'] = strip_tags( $new_instance['instagram'] );
		$instance['googleplus'] = strip_tags( $new_instance['googleplus'] );
		$instance['github'] = strip_tags( $new_instance['github'] );
		$instance['forrst'] = strip_tags( $new_instance['forrst'] );
		$instance['flickr'] = strip_tags( $new_instance['flickr'] );
		$instance['facebook'] = strip_tags( $new_instance['facebook'] );
		$instance['dribbble'] = strip_tags( $new_instance['dribbble'] );
		$instance['deviantart'] = strip_tags( $new_instance['deviantart'] );
		$instance['behance'] = strip_tags( $new_instance['behance'] );

		return $instance;
	}
	
    /*-------------------------------------------------------------------------------*/
    /*	Widget Settings (Displays the widget settings controls on the widget panel)
    /*-------------------------------------------------------------------------------*/
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title' => 'Follow us everyehere',
			'youtube' => '',
			'vimeo' => '',
			'twitter' => '',
			'soundcloud' => '',
			'skype' => '',
			'pinterest' => '',
			'linkedin' => '',
			'lastfm' => '',
			'instagram' => '',
			'googleplus' => '',
			'github' => '',
			'forrst' => '',
			'flickr' => '',
			'facebook' => '',
			'dribbble' => '',
			'deviantart' => '',
			'behance' => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		
		/* Build our form -----------------------------------------------------------*/
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e('Youtube', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" value="<?php echo $instance['youtube']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'vimeo' ); ?>"><?php _e('Vimeo', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'vimeo' ); ?>" name="<?php echo $this->get_field_name( 'vimeo' ); ?>" value="<?php echo $instance['vimeo']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e('Twitter', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" value="<?php echo $instance['twitter']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'soundcloud' ); ?>"><?php _e('Soundcloud', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'soundcloud' ); ?>" name="<?php echo $this->get_field_name( 'soundcloud' ); ?>" value="<?php echo $instance['soundcloud']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'skype' ); ?>"><?php _e('Skype', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'skype' ); ?>" name="<?php echo $this->get_field_name( 'skype' ); ?>" value="<?php echo $instance['skype']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'pinterest' ); ?>"><?php _e('Pinterest', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'pinterest' ); ?>" name="<?php echo $this->get_field_name( 'pinterest' ); ?>" value="<?php echo $instance['pinterest']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'linkedin' ); ?>"><?php _e('LinkedIn', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'linkedin' ); ?>" name="<?php echo $this->get_field_name( 'linkedin' ); ?>" value="<?php echo $instance['linkedin']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'lastfm' ); ?>"><?php _e('Lastfm', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'lastfm' ); ?>" name="<?php echo $this->get_field_name( 'lastfm' ); ?>" value="<?php echo $instance['lastfm']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'instagram' ); ?>"><?php _e('Instagram', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" value="<?php echo $instance['instagram']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'googleplus' ); ?>"><?php _e('Google Plus', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'googleplus' ); ?>" name="<?php echo $this->get_field_name( 'googleplus' ); ?>" value="<?php echo $instance['googleplus']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'github' ); ?>"><?php _e('Github', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'github' ); ?>" name="<?php echo $this->get_field_name( 'github' ); ?>" value="<?php echo $instance['github']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'forrst' ); ?>"><?php _e('Forrst', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'forrst' ); ?>" name="<?php echo $this->get_field_name( 'forrst' ); ?>" value="<?php echo $instance['forrst']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'flickr' ); ?>"><?php _e('Flickr', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'flickr' ); ?>" name="<?php echo $this->get_field_name( 'flickr' ); ?>" value="<?php echo $instance['flickr']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e('Facebook', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" value="<?php echo $instance['facebook']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'dribbble' ); ?>"><?php _e('Dribbble', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'dribbble' ); ?>" name="<?php echo $this->get_field_name( 'dribbble' ); ?>" value="<?php echo $instance['dribbble']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'deviantart' ); ?>"><?php _e('Deviantart', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'deviantart' ); ?>" name="<?php echo $this->get_field_name( 'deviantart' ); ?>" value="<?php echo $instance['deviantart']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'behance' ); ?>"><?php _e('Behance', 'sn') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'behance' ); ?>" name="<?php echo $this->get_field_name( 'behance' ); ?>" value="<?php echo $instance['behance']; ?>" />
		</p>

	<?php
	}

}

?>