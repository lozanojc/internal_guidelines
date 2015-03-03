<?php

/**
 * Create a custom hook definitions
 *
 * @since 0.1
 */

/* header.php -----------------------------------------------------------------*/
function sn_header_before() { do_action('sn_header_before'); }
function sn_header_after() { do_action('sn_header_after'); }
function sn_header_start() { do_action('sn_header_start'); }
function sn_header_end() { do_action('sn_header_end'); }
function sn_nav_start() { do_action('sn_nav_start'); }
function sn_nav_end() { do_action('sn_nav_end'); }
function sn_content_start() { do_action('sn_content_start'); }

/* index.php, single.php, search.php, archive.php -----------------------------*/
function sn_post_before() { do_action('sn_post_before'); }
function sn_post_after() { do_action('sn_post_after'); }
function sn_post_start() { do_action('sn_post_start'); }
function sn_post_end() { do_action('sn_post_end'); }

/* page.php -------------------------------------------------------------------*/
function sn_page_before() { do_action('sn_page_before'); }
function sn_page_after() { do_action('sn_page_after'); }
function sn_page_start() { do_action('sn_page_start'); }
function sn_page_end() { do_action('sn_page_end'); }

/* footer.php -----------------------------------------------------------------*/
function sn_content_end() { do_action('sn_content_end'); }
function sn_footer_in() { do_action('sn_footer_in'); }
function sn_footer_before() { do_action('sn_footer_before'); }
function sn_footer_after() { do_action('sn_footer_after'); }


/*-----------------------------------------------------------------------------------*/
/*	Filters that allow shortcodes in Text Widgets
/*-----------------------------------------------------------------------------------*/

add_filter( 'widget_text', 'shortcode_unautop' );
add_filter( 'widget_text', 'do_shortcode' );
add_filter( 'the_excerpt', 'shortcode_unautop' );
add_filter( 'the_excerpt', 'do_shortcode' );


/*-----------------------------------------------------------------------------------*/
/*	Remove Generator for Security
/*-----------------------------------------------------------------------------------*/

remove_action( 'wp_head', 'wp_generator' );

/*-----------------------------------------------------------------------------------*/
/*	Creating TinyMCE buttons
/*-----------------------------------------------------------------------------------*/

//********************************************************************
//check user has correct permissions and hook some functions into the tiny MCE architecture.
function add_editor_button() {
   //Check if user has correct level of privileges + hook into Tiny MC methods.
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
   {
     //Check if Editor is in Visual, or rich text, edior mode.
     if (get_user_option('rich_editing')) {
        //Called when tiny MCE loads plugins - 'add_custom' is defined below.
        add_filter('mce_external_plugins', 'add_custom');
        //Called when buttons are loading. -'register_button' is defined below.
        add_filter('mce_buttons', 'register_button');
     }
   }
}

//add action is a wordpress function, it adds a function to a specific action...
//in this case the function is added to the 'init' action. Init action runs after wordpress is finished loading!
add_action('init', 'add_editor_button', 10);

//Add button to the button array.
function register_button($buttons) {
   //Use PHP 'array_push' function to add the sn_help button to the $buttons array
   array_push($buttons, "sn_help");
   //Return buttons array to TinyMCE
   return $buttons;
}

//Add custom plugin to TinyMCE - returns associative array which contains link to JS file. The JS file will contain your plugin when created in the following step.
function add_custom($plugin_array) {
	$plugin_array['sn_help'] = THEME_WEB_ROOT . '/framework/js/custombutton.js';
	return $plugin_array;
}


/*-----------------------------------------------------------------------------------*/
/*	Function for twitter widget and shortcodes
/*-----------------------------------------------------------------------------------*/
/**
 * Find links and create the hyperlinks
 */
function hyperlinks($text) {
    $text = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&#038;%#+$*!]*)\b/i',"<a href=\"$1\" class=\"twitter-link\">$1</a>", $text);
    $text = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&#038;%#+$*!]*)\b/i',"<a href=\"http://$1\" class=\"twitter-link\">$1</a>", $text);

    // match name@address
    $text = preg_replace("/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i","<a href=\"mailto://$1\" class=\"twitter-link\">$1</a>", $text);
        //mach #trendingtopics. Props to Michael Voigt
    $text = preg_replace('/([\.|\,|\:|\|\|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/#search?q=$2\" class=\"twitter-link\">#$2</a>$3 ", $text);
    return $text;
}

/**
 * Find twitter usernames and link to them
 */
function twitter_users($text) {
	$text = preg_replace('/([\.|\,|\:|\|\|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/$2\" class=\"twitter-user\">@$2</a>$3 ", $text);
	return $text;
}


/*-----------------------------------------------------------------------------------*/
/*  Get portfolio page by id by template
/*-----------------------------------------------------------------------------------*/
global $wpdb;
global $portfolio_page_id;
$sn_get_portfolio_page = $wpdb->get_results("
	SELECT post_id
	FROM $wpdb->postmeta
	WHERE meta_value LIKE 'template-portfolio.php' LIMIT 1
");
if (!empty($sn_get_portfolio_page))
	$portfolio_page_id = $sn_get_portfolio_page[0]->post_id;

/*-----------------------------------------------------------------------------------*/
/*	Enable script in textarea options framework
/*-----------------------------------------------------------------------------------*/
/*
 * This is an example of how to override a default filter
 * for 'textarea' sanitization and $allowedposttags + embed and script.
 */
add_action('admin_init','optionscheck_change_santiziation', 100);
function optionscheck_change_santiziation() {
	remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
	add_filter( 'of_sanitize_textarea', 'custom_sanitize_textarea' );
}
function custom_sanitize_textarea($input) {
	global $allowedposttags;

	$custom_allowedtags["script"] = array();
	$custom_allowedtags = array_merge($custom_allowedtags, $allowedposttags);
	$output = wp_kses( $input, $custom_allowedtags);

	return $output;
}

/*-----------------------------------------------------------------------------------*/
/*	Get option item form DB
/*-----------------------------------------------------------------------------------*/
function sn_get_option($option) {

	$optionsframework_settings = get_option('optionsframework');
	$themename = $optionsframework_settings['id'];

	if (isset($_POST[$themename][$option])) return esc_html($_POST[$themename][$option]);
	else return of_get_option($option);
}


/*-----------------------------------------------------------------------------------*/
/*	Check if is blog
/*-----------------------------------------------------------------------------------*/
function sn_is_blog_page() {

	$blogpage_id = get_option('page_for_posts');
	$blogpage = get_permalink($blogpage_id);
	$actualpage = getUrl();

	if ( $actualpage === $blogpage )
		return true;
	else
		return false;

}

/*-----------------------------------------------------------------------------------*/
/*	Add accessibility menu to header
/*-----------------------------------------------------------------------------------*/
function sn_menu_accessibility() {
	$output = '
		<p id="menu-accessibility">
			<a title="Go to Content (Shortcut: Alt + 2)" accesskey="2" href="#main">Go to Content</a>
			<span class="hide">|</span>
			<a href="#menu-main">Go to Main Menu</a>
			<span class="hide">|</span>
			<a href="#form-search">Go to Search</a>
		</p>
	';

	echo $output;
}
add_action('sn_header_before', 'sn_menu_accessibility', 2);

/*-----------------------------------------------------------------------------------*/
/*	Add footer content
/*-----------------------------------------------------------------------------------*/
function sn_footer_function() {

	$footer_text = of_get_option('sn_footer_text');
	if ( $footer_text ) {
		echo apply_filters('the_content', $footer_text);
	}

}
add_action('sn_footer_in', 'sn_footer_function', 2);

/*-----------------------------------------------------------------------------------*/
/*	Add logo to header
/*-----------------------------------------------------------------------------------*/
function sn_header_logo( $get_logo_height = false ) {

	if ( is_front_page() ) {

		if ( !is_home() ) {

			$is_fixed = of_get_option( 'sn_header_fixed' );
			if ( $is_fixed == '1' )
				$logo_el_start = '<h1 id="logo"><a href="#main">';
			else
				$logo_el_start = '<h1 id="logo">';

		} else {

			$logo_el_start = '<h1 id="logo">';

		}

	} else {
		$logo_el_start = '<p id="logo"><a href="'.home_url('/').'">';
	}

	if ( is_front_page() ) {

		if ( !is_home() ) {

			$is_fixed = of_get_option( 'sn_header_fixed' );
			if ( $is_fixed == '1' )
				$logo_el_end = '</a><strong class="toggle-menu"><span class="icon icon-crossroad"></span></strong></h1>';
			else
				$logo_el_end = '<strong class="toggle-menu"><span class="icon icon-crossroad"></span></strong></h1>';

		} else {

			$logo_el_end = '<strong class="toggle-menu"><span class="icon icon-crossroad"></span></strong></h1>';

		}

	} else {
		$logo_el_end = '</a><strong class="toggle-menu"><span class="icon icon-crossroad"></span></strong></p>';
	}

	// start logo el
	$img_logo = '';
	$output = $logo_el_start;

	$logo_url = of_get_option('sn_logo');
	$retina = of_get_option('sn_logo_retina');

    if ( $logo_url ) {
    	$img_id = sn_get_attachment_id_from_src( $logo_url );
    	$img_logo = wp_get_attachment_image_src( $img_id, 'full' );
    	$width = ($retina) ? ($img_logo[1]/2) : $img_logo[1];
    	$height = ($retina) ? ($img_logo[2]/2) : $img_logo[2];

    	if ( $img_logo ) {
    		// use $img_logo array if exist
    		$output .= '<img src="' . $img_logo[0] . '" width="' . $width . '" height="' . $height . '" alt="' . get_bloginfo( 'name' ) . '" />';
    	} else {
    		// use logo url
    		$output .= '<img src="' . esc_attr( $logo_url ) . '" alt="' . get_bloginfo( 'name' ) . '" />';
    	}
    } else {
    	$output .= '<span>' . get_bloginfo('name') . '</span>';
    }

    // end logo el
   	$output .= $logo_el_end;

   	if ( $get_logo_height )
   		if ( $img_logo )
   			return $height;
   		else return '';
   	else
		echo $output;

}
add_action('sn_header_start', 'sn_header_logo', 2);

/*-----------------------------------------------------------------------------------*/
/*	GA code in header
/*-----------------------------------------------------------------------------------*/
function sn_header_scripts() {

	$scripts = of_get_option( 'sn_header_scripts' );

	echo html_entity_decode($scripts);

}
add_action('wp_head', 'sn_header_scripts', 20);

/*-----------------------------------------------------------------------------------*/
/*	Create custom css from meta boxes
/*-----------------------------------------------------------------------------------*/
function sn_generate_custom_css( $postID, $saveCssFile = true) {
	global $wpdb;

	$template = sn_get_css_template('section');

	$sn_css_options = $wpdb->get_results("
		SELECT *
		FROM $wpdb->postmeta
		WHERE meta_key LIKE 'sn_css_%'
		AND post_id = {$postID}
	");

	$css = array();
	foreach ($sn_css_options as $option) {
		$css[$option->meta_key] = $option->meta_value;
	}

	$section = 'post-'.$postID;
	$section2 = 'page-id-'.$postID;
	$template = str_replace('post-0', $section, $template);
	$template = str_replace('page-id-0', $section2, $template);

	// bg styles
	if (!isset($css['sn_css_bg_color'])) $css['sn_css_bg_color'] = '';
	sn_process_css($template, 'sn_css_bg_color', $css['sn_css_bg_color']);

	if (isset($css['sn_css_section_width']) && $css['sn_css_section_width'] != 'section-fullimage' ) {

		if (isset($css['sn_css_bg_image'])) {

			$bg_image_src = wp_get_attachment_image_src($css['sn_css_bg_image'], 'full');
			sn_process_css($template, 'sn_css_bg_image', "url('" . $bg_image_src[0] . "')");

			sn_process_css($template, 'sn_css_bg_position', $css['sn_css_bg_position']);
			sn_process_css($template, 'sn_css_bg_repeat', $css['sn_css_bg_repeat']);
			sn_process_css($template, 'sn_css_bg_size', $css['sn_css_bg_size']);
			sn_process_css($template, 'sn_css_bg_attachment', $css['sn_css_bg_attachment']);
		}

	} elseif ( !isset($css['sn_css_section_width']) ) {

		if (isset($css['sn_css_bg_image'])) {

			$bg_image_src = wp_get_attachment_image_src($css['sn_css_bg_image'], 'full');
			sn_process_css($template, 'sn_css_bg_image', "url('" . $bg_image_src[0] . "')");

			sn_process_css($template, 'sn_css_bg_position', $css['sn_css_bg_position']);
			sn_process_css($template, 'sn_css_bg_repeat', $css['sn_css_bg_repeat']);
			sn_process_css($template, 'sn_css_bg_size', $css['sn_css_bg_size']);
			sn_process_css($template, 'sn_css_bg_attachment', $css['sn_css_bg_attachment']);
		}

	}

	if (!isset($css['sn_css_title_color'])) $css['sn_css_title_color'] = '';
	sn_process_css($template, 'sn_css_title_color', $css['sn_css_title_color']);

	if (!isset($css['sn_css_text_color'])) $css['sn_css_text_color'] = '';
	sn_process_css($template, 'sn_css_text_color', $css['sn_css_text_color']);

	if (!isset($css['sn_css_text_secondary_color'])) $css['sn_css_text_secondary_color'] = '';
	sn_process_css($template, 'sn_css_text_secondary_color', $css['sn_css_text_secondary_color']);

	if (!isset($css['sn_css_link_color'])) $css['sn_css_link_color'] = '';
	sn_process_css($template, 'sn_css_link_color', $css['sn_css_link_color']);

	if (!isset($css['sn_css_link_color_hover'])) $css['sn_css_link_color_hover'] = '';
	sn_process_css($template, 'sn_css_link_color_hover', $css['sn_css_link_color_hover']);

	if (!isset($css['sn_css_button_bg'])) $css['sn_css_button_bg'] = '';
	sn_process_css($template, 'sn_css_button_bg', $css['sn_css_button_bg']);

	if (!isset($css['sn_css_button_bg_hover'])) $css['sn_css_button_bg_hover'] = '';
	sn_process_css($template, 'sn_css_button_bg_hover', $css['sn_css_button_bg_hover']);

	if (!isset($css['sn_css_button_color'])) $css['sn_css_button_color'] = '';
	sn_process_css($template, 'sn_css_button_color', $css['sn_css_button_color']);

	if (!isset($css['sn_css_button_color_hover'])) $css['sn_css_button_color_hover'] = '';
	sn_process_css($template, 'sn_css_button_color_hover', $css['sn_css_button_color_hover']);

	if (!isset($css['sn_css_section_horizont_pos'])) $css['sn_css_section_horizont_pos'] = '';
	sn_process_css($template, 'sn_css_section_horizont_pos', $css['sn_css_section_horizont_pos']);

	if (isset($css['sn_css_section_width']) && $css['sn_css_section_width'] != 'section-fullimage' ) {
		if (isset($css['sn_css_section_min_height'])) 
		{
			//$css['sn_css_section_min_height'] = '';
			sn_process_css($template, 'sn_css_section_min_height', $css['sn_css_section_min_height'].'px');
		}
	}

	$wpdb->query("
		INSERT INTO $wpdb->options (option_name, option_value)
		VALUES ('sn_css_p{$postID}', '".mysql_real_escape_string($template)."')
		ON DUPLICATE KEY UPDATE option_value = '".mysql_real_escape_string($template)."';
	");

	if ($saveCssFile) sn_save_css();

	return;
}
add_action( 'save_post', 'sn_generate_custom_css', 100 );

function sn_generate_common_css() {
	global $wpdb;

	$template = sn_get_css_template('common');

	$fontcss = sn_get_font_css();

	$wpdb->query("
		INSERT INTO $wpdb->options (option_name, option_value)
		VALUES ('sn_css_afont', '".mysql_real_escape_string($fontcss)."')
		ON DUPLICATE KEY UPDATE option_value = '".mysql_real_escape_string($fontcss)."';
	");

	// set logo height
	$logo_height = sn_header_logo( true );
	if ( !empty($logo_height) ) {

		$logo_height_px = (int)$logo_height;

		if ( $logo_height_px < 60 ) {
			sn_process_css($template, 'sn_css_padding_top', '60px');
		} else {
			sn_process_css($template, 'sn_css_padding_top', $logo_height.'px');
		}

	}

	$theme = wp_get_theme();
	$themename = $theme->Name;
	$themename = strtolower($themename);
	$themename = str_replace(' ', '_', $themename);

	$optionsframework = $wpdb->get_var("
		SELECT option_value
		FROM $wpdb->options
		WHERE option_name = 'optionsframework_".$themename."'
	");
	$optionsframework = unserialize($optionsframework);

	if (isset($optionsframework['sn_global_loader']['color']))
		sn_process_css($template, 'sn_global_loader_color', $optionsframework['sn_global_loader']['color']);
	if (isset($optionsframework['sn_global_loader']['image']) && $optionsframework['sn_global_loader']['image'])
		sn_process_css($template, 'sn_global_loader_image', "url('" . $optionsframework['sn_global_loader']['image'] . "')");
	if (isset($optionsframework['sn_global_loader']['repeat']))
		sn_process_css($template, 'sn_global_loader_repeat', $optionsframework['sn_global_loader']['repeat']);
	if (isset($optionsframework['sn_global_loader']['position']))
		sn_process_css($template, 'sn_global_loader_position', $optionsframework['sn_global_loader']['position']);
	if (isset($optionsframework['sn_global_loader']['attachment']))
		sn_process_css($template, 'sn_global_loader_attachment', $optionsframework['sn_global_loader']['attachment']);
	if (isset($optionsframework['sn_global_loader']['size']))
		sn_process_css($template, 'sn_global_loader_size', $optionsframework['sn_global_loader']['size']);

	if (isset($optionsframework['sn_global_page_background']['color']))
		sn_process_css($template, 'sn_global_page_background_color', $optionsframework['sn_global_page_background']['color']);
	if (isset($optionsframework['sn_global_page_background']['image']))
		sn_process_css($template, 'sn_global_page_background_image', $optionsframework['sn_global_page_background']['image']);
	if (isset($optionsframework['sn_global_page_background']['repeat']))
		sn_process_css($template, 'sn_global_page_background_repeat', $optionsframework['sn_global_page_background']['repeat']);
	if (isset($optionsframework['sn_global_page_background']['position']))
		sn_process_css($template, 'sn_global_page_background_position', $optionsframework['sn_global_page_background']['position']);
	if (isset($optionsframework['sn_global_page_background']['attachment']))
		sn_process_css($template, 'sn_global_page_background_attachment', $optionsframework['sn_global_page_background']['attachment']);
	if (isset($optionsframework['sn_global_page_background']['size']))
		sn_process_css($template, 'sn_global_page_background_size', $optionsframework['sn_global_page_background']['size']);

	if (isset($optionsframework['sn_global_title_color']))
		sn_process_css($template, 'sn_global_title_color', $optionsframework['sn_global_title_color']);
	if (isset($optionsframework['sn_global_text_color']))
		sn_process_css($template, 'sn_global_text_color', $optionsframework['sn_global_text_color']);
	if (isset($optionsframework['sn_global_link_color']))
		sn_process_css($template, 'sn_global_link_color', $optionsframework['sn_global_link_color']);
	if (isset($optionsframework['sn_global_button_background']))
		sn_process_css($template, 'sn_global_button_background', $optionsframework['sn_global_button_background']);
	if (isset($optionsframework['sn_global_button_color']))
		sn_process_css($template, 'sn_global_button_color', $optionsframework['sn_global_button_color']);
	if (isset($optionsframework['sn_global_title_color']))
		sn_process_css($template, 'sn_global_title_color', $optionsframework['sn_global_title_color']);
	if (isset($optionsframework['sn_global_title_color']))
		sn_process_css($template, 'sn_global_title_color', $optionsframework['sn_global_title_color']);
	if (isset($optionsframework['sn_global_text_secondary_color']))
		sn_process_css($template, 'sn_global_text_secondary_color', $optionsframework['sn_global_text_secondary_color']);
	if (isset($optionsframework['sn_global_link_color_hover']))
		sn_process_css($template, 'sn_global_link_color_hover', $optionsframework['sn_global_link_color_hover']);
	if (isset($optionsframework['sn_global_button_bg_hover']))
		sn_process_css($template, 'sn_global_button_bg_hover', $optionsframework['sn_global_button_bg_hover']);
	if (isset($optionsframework['sn_global_button_color_hover']))
		sn_process_css($template, 'sn_global_button_color_hover', $optionsframework['sn_global_button_color_hover']);

	if (isset($optionsframework['sn_header_background']['color']))
		sn_process_css($template, 'sn_header_background_color', $optionsframework['sn_header_background']['color']);
	if (isset($optionsframework['sn_header_background']['image']) && $optionsframework['sn_header_background']['image'])
		sn_process_css($template, 'sn_header_background_image', "url('" . $optionsframework['sn_header_background']['image'] . "')");
	if (isset($optionsframework['sn_header_background']['repeat']))
		sn_process_css($template, 'sn_header_background_repeat', $optionsframework['sn_header_background']['repeat']);
	if (isset($optionsframework['sn_header_background']['position']))
		sn_process_css($template, 'sn_header_background_position', $optionsframework['sn_header_background']['position']);
	if (isset($optionsframework['sn_header_background']['attachment']))
		sn_process_css($template, 'sn_header_background_attachment', $optionsframework['sn_header_background']['attachment']);
	if (isset($optionsframework['sn_header_background']['size']))
		sn_process_css($template, 'sn_header_background_size', $optionsframework['sn_header_background']['size']);

	if (isset($optionsframework['sn_header_menu_color']))
		sn_process_css($template, 'sn_header_menu_color', $optionsframework['sn_header_menu_color']);
	if (isset($optionsframework['sn_header_menu_color_hover']))
		sn_process_css($template, 'sn_header_menu_color_hover', $optionsframework['sn_header_menu_color_hover']);
	if (isset($optionsframework['sn_header_border_color']))
		sn_process_css($template, 'sn_header_border_color', $optionsframework['sn_header_border_color']);
	if (isset($optionsframework['sn_header_submenu_bg']))
		sn_process_css($template, 'sn_header_submenu_bg', $optionsframework['sn_header_submenu_bg']);
	if (isset($optionsframework['sn_header_submenu_border']))
		sn_process_css($template, 'sn_header_submenu_border', $optionsframework['sn_header_submenu_border']);

	if (isset($optionsframework['sn_footer_background']['color']))
		sn_process_css($template, 'sn_footer_background_color', $optionsframework['sn_footer_background']['color']);
	if (isset($optionsframework['sn_footer_background']['image']) && $optionsframework['sn_footer_background']['image'])
		sn_process_css($template, 'sn_footer_background_image', "url('" . $optionsframework['sn_footer_background']['image'] . "')");
	if (isset($optionsframework['sn_footer_background']['repeat']))
		sn_process_css($template, 'sn_footer_background_repeat', $optionsframework['sn_footer_background']['repeat']);
	if (isset($optionsframework['sn_footer_background']['position']))
		sn_process_css($template, 'sn_footer_background_position', $optionsframework['sn_footer_background']['position']);
	if (isset($optionsframework['sn_footer_background']['attachment']))
		sn_process_css($template, 'sn_footer_background_attachment', $optionsframework['sn_footer_background']['attachment']);
	if (isset($optionsframework['sn_footer_background']['size']))
		sn_process_css($template, 'sn_footer_background_size', $optionsframework['sn_footer_background']['size']);

	if (isset($optionsframework['sn_footer_text_secondary_color']))
		sn_process_css($template, 'sn_footer_text_secondary_color', $optionsframework['sn_footer_text_secondary_color']);
	if (isset($optionsframework['sn_footer_link_color_hover']))
		sn_process_css($template, 'sn_footer_link_color_hover', $optionsframework['sn_footer_link_color_hover']);
	if (isset($optionsframework['sn_footer_button_background_hover']))
		sn_process_css($template, 'sn_footer_button_background_hover', $optionsframework['sn_footer_button_background_hover']);
	if (isset($optionsframework['sn_footer_button_color_hover']))
		sn_process_css($template, 'sn_footer_button_color_hover', $optionsframework['sn_footer_button_color_hover']);
	if (isset($optionsframework['sn_footer_title_color']))
		sn_process_css($template, 'sn_footer_title_color', $optionsframework['sn_footer_title_color']);
	if (isset($optionsframework['sn_footer_text_color']))
		sn_process_css($template, 'sn_footer_text_color', $optionsframework['sn_footer_text_color']);
	if (isset($optionsframework['sn_footer_link_color']))
		sn_process_css($template, 'sn_footer_link_color', $optionsframework['sn_footer_link_color']);
	if (isset($optionsframework['sn_footer_button_background']))
		sn_process_css($template, 'sn_footer_button_background', $optionsframework['sn_footer_button_background']);
	if (isset($optionsframework['sn_footer_button_color']))
		sn_process_css($template, 'sn_footer_button_color', $optionsframework['sn_footer_button_color']);
	if (isset($optionsframework['sn_footer_border_color']))
		sn_process_css($template, 'sn_footer_border_color', $optionsframework['sn_footer_border_color']);

	if (isset($optionsframework['sn_css_text_weight']))
		sn_process_css($template, 'sn_css_text_weight', $optionsframework['sn_css_text_weight']);
	if (isset($optionsframework['sn_css_heading_weight']))
		sn_process_css($template, 'sn_css_heading_weight', $optionsframework['sn_css_heading_weight']);
	if (isset($optionsframework['sn_css_h1_weight']))
		sn_process_css($template, 'sn_css_h1_weight', $optionsframework['sn_css_h1_weight']);

	// THICKBOX
	if (isset($optionsframework['sn_thickbox_overlay']))
		sn_process_css($template, 'sn_thickbox_overlay', $optionsframework['sn_thickbox_overlay']);
	if (isset($optionsframework['sn_thickbox_opacity']))
		sn_process_css($template, 'sn_thickbox_opacity', $optionsframework['sn_thickbox_opacity']);
	if (isset($optionsframework['sn_thickbox_color']))
		sn_process_css($template, 'sn_thickbox_color', $optionsframework['sn_thickbox_color']);
	if (isset($optionsframework['sn_thickbox_controls']))
		sn_process_css($template, 'sn_thickbox_controls', $optionsframework['sn_thickbox_controls']);

	$template .= $optionsframework['sn_custom_css'];

	$wpdb->query("
		INSERT INTO $wpdb->options (option_name, option_value)
		VALUES ('sn_css_zcommon', '".mysql_real_escape_string($template)."')
		ON DUPLICATE KEY UPDATE option_value = '".mysql_real_escape_string($template)."';
	");

	sn_save_css();
}

//add_action( 'optionsframework_after_validate', 'sn_generate_common_css', 1000 );
function sn_save_common_css() {
	if (isset($_GET['page']) && ($_GET['page'] == 'options-framework') && isset($_GET['settings-updated']) && ($_GET['settings-updated'] == true)) {
		sn_generate_common_css();
	}
}
add_action('admin_init', 'sn_save_common_css', 50);

function sn_regenerate_css(){
	global $wpdb;

	//delete all
	$wpdb->query("
			DELETE FROM $wpdb->options
			WHERE option_name LIKE 'sn_css_%'
		");

	//regenerate_all_posts
	$posts = $wpdb->get_col("
			SELECT post_id
			FROM $wpdb->postmeta
			WHERE meta_key LIKE 'sn_css_%'
			GROUP BY post_id
		");

	foreach ($posts as $postID)
	{
		sn_generate_custom_css($postID, false);
	}

	//save common
	sn_generate_common_css();
}


function sn_get_css_template($name) {
	$start = "/* #editable - {$name} */";
	$end = "/* /editable */";
	$matches = array();
	$saving = false;

	$handle = fopen(get_template_directory()."/css/style.css", "r");
	if ($handle)
	{
		while (!feof($handle))
		{
			$buffer = fgets($handle);
			if($saving && strpos($buffer, $end) !== FALSE)
			{
				//echo $buffer;
				$matches[] = str_replace($end,'', $buffer);
				$saving = false;
			}
			if ($saving) $matches[] = $buffer;
			if(strpos($buffer, $start) !== FALSE)
			{
				$saving = true;
			}
		}
		fclose($handle);
	}
	//printr($matches);
	return implode("", $matches);
}

function sn_process_css(&$template, $name, $value) {
	$findme = '\/\* '.$name.' \*\/';
	$pattern = "/([^:]+)({$findme}).*/";

	if (!strpos($value, ';')) $value = $value.';';

	// search, and store all matching occurences in $matches
	if(preg_match_all($pattern, $template, $matches, PREG_PATTERN_ORDER)){

		if ($matches[1] && $matches[2])
		{
			foreach ($matches[1] as $k=> $v)
			{
				$template = str_replace($matches[1][$k].$matches[2][$k], $value, $template);
			}
		}
	}

	return true;
}

define('SN_CUSTOM_STYLES_FILENAME', get_template_directory() . '/css/custom-styles.css');
function sn_save_css() {

	global $wpdb;

	$css_options = $wpdb->get_results("
		SELECT *
		FROM $wpdb->options
		WHERE option_name LIKE 'sn_css_%'
		ORDER BY option_name
	");

	$css = '';
	foreach ($css_options as $option) {
		$css .= $option->option_value;
	}

	//odstran nesmysly
	$pattern = "/([a-z-]*:;)/";
	$css = preg_replace($pattern, '', $css);

	$sn_filename = SN_CUSTOM_STYLES_FILENAME;

	require_once 'cssmin.php';
	$minifier = new CssMinifier($css);
	$css = $minifier->getMinified();

	$sn_file = fopen($sn_filename, 'w+');
	@chmod($sn_filename, 0777);

	fwrite($sn_file, $css);
	fclose($sn_file);
}


function sn_check_custom_styles_writeable()
{
	return is_writable(SN_CUSTOM_STYLES_FILENAME);
}

//add_action('admin_init', 'on_admin_init');
add_action('admin_notices', 'sn_admin_notice');

function sn_admin_notice() {

	if (!sn_check_custom_styles_writeable())
	{
		$sn_filename = SN_CUSTOM_STYLES_FILENAME;

		$sn_file = @fopen($sn_filename, 'w+');
		@chmod($sn_filename, 0777);
		@fwrite($sn_file, '');
		@fclose($sn_file);

	}

	if (!sn_check_custom_styles_writeable())
	{
		?>
		<div id="message" class="error error-message">
			<p><?php printf( __( 'WARNING: Your custom Spacetype Theme settings can\'t be saved when changed. You must set file "%s" permissions to [666].', 'sn' ), SN_CUSTOM_STYLES_FILENAME); ?></p>
		</div>

	<?php
	}
}


/*-----------------------------------------------------------------------------------*/
/*	Generate custom fonts from options page
/*-----------------------------------------------------------------------------------*/
function sn_get_font_css($header = false) {

	$font_options = sn_get_option('sn_css_font_settings');
    $css = '';
    $output = '';

	switch ( $font_options ) {

    	// Typekit
        case 'typekit':
			$typekit_id = sn_get_option('sn_css_typekit_id');
			$typekit_font = sn_get_option('sn_css_typekit_font');
			$typekit_font_heading = sn_get_option('sn_css_typekit_font_heading');

			//wp_register_script('typekit', 'http://use.typekit.net/'.$typekit_id.'.js', array(), '1.0', false);
			//wp_enqueue_script('typekit');

			$output .= '<script src="http://use.typekit.net/'.$typekit_id.'.js?ver=1.0"></script>';
			$output .= '<script>try{Typekit.load();}catch(e){}</script>';
			if ( !empty($typekit_font) )
				$css .= 'body,.toggle-title,.btn span,th,.tabs-line a {font-family: "'.$typekit_font.'", sans-serif;}';
			if ( !empty($typekit_font_heading) )
				$css .= 'h1,.h1,h2,.h2,h3,.h3,h4,.h4,h5,.h5,h6,.h6,.box-title {font-family: "'.$typekit_font_heading.'", sans-serif;}';

            break;

        // Google fonts
        case 'google_fonts':
        	$font_weight = sn_get_option('sn_css_text_weight') . ',' . sn_get_option('sn_css_heading_weight') . ',' . sn_get_option('sn_css_h1_weight');
        	$google_font = sn_get_option('sn_css_google_font');
        	$google_font_name = str_replace('+', ' ', $google_font);
        	$font1 = '';
        	if (!empty($google_font_name))
        		$font1 = $google_font_name . ':' . $font_weight;

        	$google_font_heading = sn_get_option('sn_css_google_font_heading');
        	$google_font_heading_name = str_replace('+', ' ', $google_font_heading);
        	$font2 = '';
        	if (!empty($google_font_heading_name))
        		$font2 = $google_font_heading_name . ':' . $font_weight;

        	$fonts = '';
        	if( !empty($font1) && !empty($font2) ) {
        		$fonts = $font1 . '|' . $font2;
        	} elseif( !empty($font1) ) {
        		$fonts = $font1;
        	} elseif( !empty($font2) ) {
        		$fonts = $font2;
        	}

            //wp_register_style( 'google-fonts', 'http://fonts.googleapis.com/css?family='.$google_font, array(), '1.0', 'screen, projection' );
            //wp_enqueue_style( 'google-fonts' );

            $output .= '<link rel="stylesheet" id="sn-google-css" href="http://fonts.googleapis.com/css?family='.$fonts.'" type="text/css" media="screen, projection" />';

        	$css .= 'body,.toggle-title,.btn span,th,.tabs-line a {font-family: "'.$google_font_name.'", sans-serif;}';
        	$css .= 'h1,.h1,h2,.h2,h3,.h3,h4,.h4,h5,.h5,h6,.h6,.box-title {font-family: "'.$google_font_heading_name.'", sans-serif;}';

            break;

        // Default
        case 'default':
       	default:
            $output = '';
            $css = '';
            break;
    }

    if ($header) return $output;
    else return $css;

}

/*-----------------------------------------------------------------------------------*/
/*  Font settings
/*-----------------------------------------------------------------------------------*/

function sn_font_settings() {
    echo sn_get_font_css(true);
}

add_action('wp_head', 'sn_font_settings', 20);
//add_action('wp_enqueue_scripts', 'sn_font_settings', 1);


/*-----------------------------------------------------------------------------------*/
/*  Manage post columns
/*-----------------------------------------------------------------------------------*/

add_filter( 'manage_sn_portfolio_posts_columns', 'sn_admin_post_header_columns', 10, 1);
add_action( 'manage_sn_portfolio_posts_custom_column', 'sn_admin_post_data_row', 10, 2);
add_filter( 'manage_sn_portfolio_posts_columns', 'sn_id_column', 10, 3 );

add_filter( 'manage_sn_sections_posts_columns', 'sn_admin_post_header_columns', 10, 1);
add_action( 'manage_sn_sections_posts_custom_column', 'sn_admin_post_data_row', 10, 2);
add_filter( 'manage_sn_sections_posts_columns', 'sn_id_column', 10, 3 );

add_filter( 'manage_page_posts_columns', 'sn_admin_post_header_columns', 10, 1);
add_action( 'manage_page_posts_custom_column', 'sn_admin_post_data_row', 10, 2);
add_filter( 'manage_page_posts_columns', 'sn_id_column', 10, 3 );

function sn_admin_post_header_columns($columns) {

    if (!isset($columns['id']))
        $columns['id'] = "ID";

    return $columns;

}

function sn_admin_post_data_row($column_name, $post_id) {

    switch($column_name) {

        case 'id':
        	echo $post_id;

            break;

        default:
            break;

    }
}

function sn_id_column($columns) {
	$new = array();
	foreach($columns as $key => $title) {
		if ($key == 'title') // Put the Thumbnail column before the Author column
			$new['id'] = 'ID';
		$new[$key] = $title;
	}
	return $new;
}