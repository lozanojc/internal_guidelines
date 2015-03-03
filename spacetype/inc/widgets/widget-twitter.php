<?php
/*
    Copyright 2012  Paul Underwood

    This program is free software; you can redistribute it and/or
    modify it under the terms of the GNU General Public License,
    version 2, as published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/

/**
 * Register the Widget
 */
add_action( 'widgets_init', create_function( '', 'register_widget("sn_tweet_widget");' ) );

/**
 * Create the widget class and extend from the WP_Widget
 */
 class sn_tweet_widget extends WP_Widget {

	private $twitter_title = "My Tweets";
	private $twitter_username = "envato";
	private $twitter_postcount = "5";
	private $twitter_follow_text = "Follow Me On Twitter";

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {

		parent::__construct(
			'sn_tweet_widget',		// Base ID
			'Custom Latest Tweets',	// Name
			array(
				'classname'		=>	'widget_twitter',
				'description'	=>	__('A widget that displays your latest tweets.', 'sn')
			)
		);

		// Load JavaScript and stylesheets
		$this->register_scripts_and_styles();

	} // end constructor

	/**
	 * Registers and enqueues stylesheets for the administration panel and the
	 * public facing site.
	 */
	public function register_scripts_and_styles() {

	} // end register_scripts_and_styles

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$this->twitter_title = apply_filters('widget_title', $instance['title'] );

		$this->twitter_username = $instance['username'];
		$this->twitter_postcount = $instance['postcount'];
		$this->twitter_follow_text = $instance['tweettext'];

	    require_once FRAMEWORK_DIRECTORY . 'twitteroauth/twitteroauth.php';
		$twitterConnection = new TwitterOAuth(
			'tc2iNQtyrZzxTmSmEDsmCQ',	// Consumer Key
			'Yyz2DXrHX9Iu1fpnjHOvzPFOZGduGoybodEoDm0jQ',   	// Consumer secret
			'104864700-ICb7swORTkLJEWbjT3kssrWlfGK3gtg4wnqPKj7c',       // Access token
			'pc870Aw5jGBcyIBSpHmGjEO90BuqpVTgPsLaCE1QpqVuM'    	// Access token secret
		);

		$twitterData = $twitterConnection->get(
			'statuses/user_timeline',
			array(
				'screen_name'     => $this->twitter_username,
				'count'           => $this->twitter_postcount,
				'exclude_replies' => false
			)
		);

		/* Before widget (defined by themes). */
		echo $before_widget;
		?>
		<div class="twitter_box"><?php

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $this->twitter_title )
			echo $before_title . $this->twitter_title . $after_title;

		/* Display Latest Tweets */
		 ?>

            <?php
            	if(!empty($twitterData) || !isset($twitterData['error'])){
            		$i=  0;
					$hyperlinks = true;
					$encode_utf8 = false;
					$twitter_users = true;
					$update = true;

					echo '<ul class="twitter_update_list">';

		            foreach($twitterData as $item){

		                    $msg = $item->text;
		                    $permalink = 'http://twitter.com/#!/'. $this->twitter_username .'/status/'. $item->id_str;
		                    if($encode_utf8) $msg = utf8_encode($msg);
		                    $link = $permalink;

		                     echo '<li class="twitter-item">';

		                      if ($hyperlinks) {    $msg = hyperlinks($msg); }
		                      if ($twitter_users)  { $msg = twitter_users($msg); }

		                      echo $msg;

		                    if($update) {
		                      $time = strtotime($item->created_at);

		                      if ( ( abs( time() - $time) ) < 86400 )
		                        $h_time = sprintf( __('%s ago', 'sn'), human_time_diff( $time ) );
		                      else
		                        $h_time = date(__('Y/m/d', 'sn'), $time);

		                      echo sprintf( __('%s', 'sn'),' <span class="twitter-timestamp"><abbr title="' . date(__('Y/m/d H:i:s', 'sn'), $time) . '">' . $h_time . '</abbr></span>' );
		                     }

		                    echo '</li>';

		                    $i++;
		                    if ( $i >= $this->twitter_postcount ) break;
		            }

					echo '</ul>';

            	}
            ?>

			<a href="https://twitter.com/<?php echo $this->twitter_username; ?>"
				class="twitter-follow-button"
				data-show-count="true"
				data-lang="en">Follow @<?php echo $this->twitter_username; ?></a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            
       		</div>
		<?php

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// Strip tags to remove HTML (important for text inputs)
		foreach($new_instance as $k => $v){
			$instance[$k] = strip_tags($v);
		}

		return $instance;
	}

	/**
	 * Create the form for the Widget admin
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
		'title' => $this->twitter_title,
		'username' => $this->twitter_username,
		'postcount' => $this->twitter_postcount,
		'tweettext' => $this->twitter_follow_text,
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'framework') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<!-- Username: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e('Twitter Username e.g. paulund_', 'framework') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" />
		</p>

		<!-- Postcount: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'postcount' ); ?>"><?php _e('Number of tweets (max 20)', 'framework') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'postcount' ); ?>" name="<?php echo $this->get_field_name( 'postcount' ); ?>" value="<?php echo $instance['postcount']; ?>" />
		</p>

		<!-- Tweettext: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'tweettext' ); ?>"><?php _e('Follow Text e.g. Follow me on Twitter', 'framework') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'tweettext' ); ?>" name="<?php echo $this->get_field_name( 'tweettext' ); ?>" value="<?php echo $instance['tweettext']; ?>" />
		</p>

	<?php
	}

 }
?>