<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 *
 */

function optionsframework_option_name() {

	$theme = wp_get_theme();
	$themename = $theme->Name;
	$themename = strtolower($themename);

	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *
 */

function optionsframework_options() {

	// Shortname
	global $prefix;

	// Background Defaults
	$background_defaults = array(
		'color' => '#ffffff',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment' => 'scroll' );

	$background_loader = array(
		'color' => '#ffffff',
		'image' => THEME_WEB_ROOT . '/framework/images/loader.gif',
		'repeat' => 'no-repeat',
		'position' => 'center center',
		'attachment' => 'fixed' );

	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select page';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	$options = array();

	$options[] = array(
		"name" => __('General','sn'),
		"type" => "heading"
	);

	$options[] = array(
		'name' => __('Blog sidebar position','sn'),
		//'desc' => __('Blog sidebar settings description.','sn'),
		'id' => $prefix . "blog_sidebar_settings",
		"type" => "select",
		"options" => array(
			'none' => __('None', 'sn'),
			'left' => __('Left', 'sn'),
			'right' => __('Right', 'sn')
		),
		"std" => "right"
	);

	$options[] = array(
		'name' => __('Enable social likes in blog post', 'sn'),
		'desc' => __('Enable social likes.', 'sn'),
		'id' => $prefix . 'post_social',
		'std' => '1',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Portfolio type','sn'),
		//'desc' => __('Portfolio list type.','sn'),
		'id' => $prefix . "portfolio_type",
		"type" => "select",
		"options" => array(
			'3_cols' => __('3 columns', 'sn'),
			'4_cols' => __('4 columns', 'sn')
		),
		"std" => "3_cols"
	);

	$options[] = array(
		'name' => __('Portfolio crossroad item title', 'sn'),
		'id' => $prefix . 'portfolio_title',
		"type" => "select",
		"options" => array(
			'bottom' => __('Bottom', 'sn'),
			'none' => __('None', 'sn'),
		),
		"std" => "bottom");

	$options[] = array(
		'name' => __('Portfolio related projects', 'sn'),
		'desc' => __('Enable related projects.', 'sn'),
		'id' => $prefix . 'portfolio_related',
		'std' => '1',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Portfolio pager', 'sn'),
		'desc' => __('Enable portfolio pager.', 'sn'),
		'id' => $prefix . 'portfolio_pager',
		'std' => '1',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Show breadcrumb', 'sn'),
		'desc' => __('Enable breadcrumb.', 'sn'),
		'id' => $prefix . 'breadcrumb_enable',
		'std' => '1',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Responsive design', 'sn'),
		'desc' => __('Enable responsive design.', 'sn'),
		'id' => $prefix . 'responsive',
		'std' => '1',
		'type' => 'checkbox');

	$options[] = array(
		"name" => __('Favicon','sn'),
		"desc" => __('Favicon size 16x16px.','sn'),
		"id" => $prefix . "favicon",
		"type" => "upload"
	);

	$options[] = array(
		'name' => __('Header scripts', 'sn'),
		'desc' => __('Place Google Analytics code here.', 'sn'),
		'id' => $prefix . 'header_scripts',
		'type' => 'textarea');

	// TYPOGRAPHY
	$options[] = array(
		"name" => __('Typography','sn'),
		"desc" => "",
		"type" => "heading"
	);

	$options[] = array(
		"name" => __('Font options','sn'),
		"id" => $prefix . "css_font_settings",
		"type" => "radio",
		"options" => array(
			'default' => __('Default ("Helvetica Neue",Helvetica,Arial,serif)', 'sn'),
			'typekit' => __('Typekit', 'sn'),
			'google_fonts' => __('Google fonts', 'sn')
		),
		"std" => "default"
	);

	$options[] = array(
		"id" => 'typekit',
		"type" => "wrap"
	);

	$options[] = array(
		"name" => __('Typekit settings','sn'),
		"desc" => '<a href="https://typekit.com/fonts" target="_blank">More info</a> about Typekit fonts.',
		"type" => "info"
	);

	$options[] = array(
		"name" => __('Typekit ID','sn'),
		"desc" => __('Get your Typekit ID in Kit editor on typekit.com website.','sn'),
		"id" => $prefix . "css_typekit_id",
		"type" => "text"
	);

	$options[] = array(
		"name" => __('Text font family name','sn'),
		"id" => $prefix . "css_typekit_font",
		"type" => "text"
	);

	$options[] = array(
		"name" => __('Heading font family name','sn'),
		"id" => $prefix . "css_typekit_font_heading",
		"type" => "text"
	);

	$options[] = array(
		"type" => "wrap_end"
	);

	$options[] = array(
		"id" => 'google_fonts',
		"type" => "wrap"
	);

	$options[] = array(
		"name" => __('Google fonts settings','sn'),
		"desc" => "",
		"type" => "info"
	);

	$options[] = array(
		"name" => __('Text font family','sn'),
		"desc" => __('Enter the name of the font you want to use for text. <a href="https://www.google.com/fonts" target="_blank">More info</a>. <code>For example: "Open+Sans".</code>','sn'),
		"id" => $prefix . "css_google_font",
		"type" => "text",
		"std" => "Open+Sans"
	);

	$options[] = array(
		"name" => __('Heading font family','sn'),
		"desc" => __('Enter the name of the font you want to use for headlines. <a href="https://www.google.com/fonts" target="_blank">More info</a>. <code>For example: "Raleway".</code>','sn'),
		"id" => $prefix . "css_google_font_heading",
		"type" => "text",
		"std" => "Open+Sans"
	);

	$options[] = array(
		"type" => "wrap_end"
	);

	// $options[] = array(
	// 	"name" => __('Custom fonts','sn'),
	// 	"desc" => __('Do you want custom fonts? <a href="#">Click here</a>.','sn'),
	// 	"type" => "info"
	// );

	$options[] = array(
		"name" => __('Font weight settings','sn'),
		"desc" => "",
		"type" => "info"
	);

	$options[] = array(
		"name" => __('Normal text','sn'),
		"id" => $prefix . "css_text_weight",
		"type" => "select",
		"options" => array(
			'200' => __('Extra Light (200)', 'sn'),
			'300' => __('Light (300)', 'sn'),
			'400' => __('Regular (400)', 'sn'),
			'500' => __('Medium (500)', 'sn'),
			'600' => __('Semibold (600)', 'sn'),
			'700' => __('Bold (700)', 'sn'),
			'800' => __('Black (800)', 'sn')
		),
		"std" => "400"
	);

	$options[] = array(
		"name" => __('Headings','sn'),
		"id" => $prefix . "css_heading_weight",
		"type" => "select",
		"options" => array(
			'200' => __('Extra Light (200)', 'sn'),
			'300' => __('Light (300)', 'sn'),
			'400' => __('Regular (400)', 'sn'),
			'500' => __('Medium (500)', 'sn'),
			'600' => __('Semibold (600)', 'sn'),
			'700' => __('Bold (700)', 'sn'),
			'800' => __('Black (800)', 'sn')
		),
		"std" => "700"
	);

	$options[] = array(
		"name" => __('H1 + strong','sn'),
		"id" => $prefix . "css_h1_weight",
		"type" => "select",
		"options" => array(
			'200' => __('Extra Light (200)', 'sn'),
			'300' => __('Light (300)', 'sn'),
			'400' => __('Regular (400)', 'sn'),
			'500' => __('Medium (500)', 'sn'),
			'600' => __('Semibold (600)', 'sn'),
			'700' => __('Bold (700)', 'sn'),
			'800' => __('Black (800)', 'sn')
		),
		"std" => "700"
	);

	// COLORS
	$options[] = array(
		"name" => __('Colors','sn'),
		"type" => "heading"
	);

	$options[] = array(
		'name' =>  __('Page background settings', 'sn'),
		'desc' => __('Default color is #ffffff.', 'sn'),
		'id' => $prefix . 'global_page_background',
		'std' => $background_defaults,
		'type' => 'background'
	);

	$options[] = array(
		'name' => __('Titles color', 'sn'),
		'desc' => __('Default color is #000000.', 'sn'),
		'id' => $prefix . 'global_title_color',
		'std' => '#000000',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Text color', 'sn'),
		'desc' => __('Default color is #333333.', 'sn'),
		'id' => $prefix . 'global_text_color',
		'std' => '#333333',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Secondary color', 'sn'),
		'desc' => __('Default color is #cccccc.', 'sn'),
		'id' => $prefix . 'global_text_secondary_color',
		'std' => '#cccccc',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Link color', 'sn'),
		'desc' => __('Default color is #000000.', 'sn'),
		'id' => $prefix . 'global_link_color',
		'std' => '#000000',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Link color hover', 'sn'),
		'desc' => __('Default color is #000000.', 'sn'),
		'id' => $prefix . 'global_link_color_hover',
		'std' => '#000000',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Button border color', 'sn'),
		'desc' => __('Default color is #333333.', 'sn'),
		'id' => $prefix . 'global_button_background',
		'std' => '#333333',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Button hover border & background color', 'sn'),
		'desc' => __('Default color is #333333.', 'sn'),
		'id' => $prefix . 'global_button_bg_hover',
		'std' => '#333333',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Button text color', 'sn'),
		'desc' => __('Default color is #333333.', 'sn'),
		'id' => $prefix . 'global_button_color',
		'std' => '#333333',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Button hover text color', 'sn'),
		'desc' => __('Default color is #ffffff.', 'sn'),
		'id' => $prefix . 'global_button_color_hover',
		'std' => '#ffffff',
		'type' => 'color' );

	// HEADER
	$options[] = array(
		"name" => __('Header','sn'),
		"type" => "heading"
	);

	$options[] = array(
		"name" => __('Logo','sn'),
		"desc" => __('Logo in header.','sn'),
		"id" => $prefix . "logo",
		"type" => "upload"
	);

	$options[] = array(
		'name' => __('Retina logo', 'sn'),
		'desc' => __('Upload your logo in double size.', 'sn'),
		'id' => $prefix . 'logo_retina',
		'std' => '0',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Fixed header', 'sn'),
		'desc' => __('Enable fixed header.', 'sn'),
		'id' => $prefix . 'header_fixed',
		'std' => '0',
		'type' => 'checkbox');

	$options[] = array(
		'name' =>  __('Header background settings', 'sn'),
		'desc' => __('Default color is #ffffff.', 'sn'),
		'id' => $prefix . 'header_background',
		'std' => $background_defaults,
		'type' => 'background'
	);

	$options[] = array(
		'name' => __('Menu color text', 'sn'),
		'desc' => __('Default color is #808080.', 'sn'),
		'id' => $prefix . 'header_menu_color',
		'std' => '#808080',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Menu hover color text', 'sn'),
		'desc' => __('Default color is #000000.', 'sn'),
		'id' => $prefix . 'header_menu_color_hover',
		'std' => '#000000',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Header border color', 'sn'),
		'id' => $prefix . 'header_border_color',
		'std' => '#eeeeee',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Submenu background', 'sn'),
		'id' => $prefix . 'header_submenu_bg',
		'std' => '#ffffff',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Submenu border color', 'sn'),
		'id' => $prefix . 'header_submenu_border',
		'std' => '#ebebeb',
		'type' => 'color' );

	// FOOTER
	$options[] = array(
		"name" => __('Footer','sn'),
		"type" => "heading"
	);

	$options[] = array(
		"name" => __('Footer text','sn'),
		"desc" => __('Footer copyright text.','sn'),
		"id" => $prefix . "footer_text",
		"type" => "editor"
	);

	$options[] = array(
		"name" => __('Footer color settings','sn'),
		"desc" => "",
		"type" => "info"
	);

	$options[] = array(
		'name' =>  __('Footer background settings', 'sn'),
		'desc' => __('Default color is #ffffff.', 'sn'),
		'id' => $prefix . 'footer_background',
		'std' => $background_defaults,
		'type' => 'background'
	);

	$options[] = array(
		'name' => __('Titles color', 'sn'),
		'desc' => __('Default color is #000000.', 'sn'),
		'id' => $prefix . 'footer_title_color',
		'std' => '#000000',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Text color', 'sn'),
		'desc' => __('Default color is #333333.', 'sn'),
		'id' => $prefix . 'footer_text_color',
		'std' => '#333333',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Secondary color', 'sn'),
		'desc' => __('Default color is #cccccc.', 'sn'),
		'id' => $prefix . 'footer_text_secondary_color',
		'std' => '#cccccc',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Link color', 'sn'),
		'desc' => __('Default color is #000000.', 'sn'),
		'id' => $prefix . 'footer_link_color',
		'std' => '#000000',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Link color hover', 'sn'),
		'desc' => __('Default color is #000000.', 'sn'),
		'id' => $prefix . 'footer_link_color_hover',
		'std' => '#000000',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Button border color', 'sn'),
		'desc' => __('Default color is #333333.', 'sn'),
		'id' => $prefix . 'footer_button_background',
		'std' => '#333333',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Button hover border & background color', 'sn'),
		'desc' => __('Default color is #333333.', 'sn'),
		'id' => $prefix . 'footer_button_background_hover',
		'std' => '#333333',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Button text color', 'sn'),
		'desc' => __('Default color is #333333.', 'sn'),
		'id' => $prefix . 'footer_button_color',
		'std' => '#333333',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Button hover text color', 'sn'),
		'desc' => __('Default color is #ffffff.', 'sn'),
		'id' => $prefix . 'footer_button_color_hover',
		'std' => '#ffffff',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Footer border color', 'sn'),
		'id' => $prefix . 'footer_border_color',
		'std' => '#eeeeee',
		'type' => 'color' );



	// CONTACT
	$options[] = array(
		"name" => __('Contact','sn'),
		"type" => "heading"
	);

	$options[] = array(
		"name" => __('Contact form e-mail','sn'),
		"desc" => __('E-mail will be sent on the form.','sn'),
		"id" => $prefix . "contact_email",
		"type" => "text"
	);

	$options[] = array(
		"name" => __('E-mail logo','sn'),
		"desc" => __('Logo placed in e-mail body.','sn'),
		"id" => $prefix . "contact_email_logo",
		"type" => "upload"
	);

	$options[] = array(
		"name" => __('E-mail text','sn'),
		"desc" => __('{name} - return user name; {email} - return user e-mail; {message} - return user message; {site_name} - return site name','sn'),
		"id" => $prefix . "contact_email_body",
		"type" => "editor",
		"std" => __("<strong>Name:</strong> {name}\n<strong>E-mail:</strong> {email}\n<strong>Message:</strong>\n{message}\n\nE-mail was send from {site_name} website.","sn")
	);

	$options[] = array(
		"name" => __('Texts in form','sn'),
		"desc" => "",
		"type" => "info"
	);

	$options[] = array(
		"name" => __('Your name','sn'),
		"id" => $prefix . "contact_info_name",
		"type" => "text",
		"std" => __('Your name','sn')
	);

	$options[] = array(
		"name" => __('E-mail address','sn'),
		"id" => $prefix . "contact_info_email",
		"type" => "text",
		"std" => __('E-mail address','sn')
	);

	$options[] = array(
		"name" => __('Message','sn'),
		"id" => $prefix . "contact_info_message",
		"type" => "text",
		"std" => __('Message','sn')
	);

	$options[] = array(
		"name" => __('Send button','sn'),
		"id" => $prefix . "contact_info_button",
		"type" => "text",
		"std" => __('Send message','sn')
	);

	$options[] = array(
		"name" => __('Info messages in form','sn'),
		"desc" => "",
		"type" => "info"
	);

	$options[] = array(
		"name" => __('Verification incorrect','sn'),
		"id" => $prefix . "contact_message_verification",
		"type" => "text",
		"std" => __('Human verification incorrect','sn')
	);

	$options[] = array(
		"name" => __('Missing content','sn'),
		"id" => $prefix . "contact_message_content",
		"type" => "text",
		"std" => __('Please supply all information','sn')
	);

	$options[] = array(
		"name" => __('E-mail invalid','sn'),
		"id" => $prefix . "contact_message_email",
		"type" => "text",
		"std" => __('E-mail Address Invalid','sn')
	);

	$options[] = array(
		"name" => __('Message unsent','sn'),
		"id" => $prefix . "contact_message_notsent",
		"type" => "text",
		"std" => __('Message was not sent. Try Again','sn')
	);

	$options[] = array(
		"name" => __('Message sent','sn'),
		"id" => $prefix . "contact_message_sent",
		"type" => "text",
		"std" => __('Thanks! Your message has been sent','sn')
	);

	// THICKBOX
	$options[] = array(
		"name" => __('Thickbox','sn'),
		"type" => "heading"
	);

	$options[] = array(
		'name' => __('Overlay color', 'sn'),
		'desc' => __('Default color is #ffffff.', 'sn'),
		'id' => $prefix . 'thickbox_overlay',
		'std' => '#ffffff',
		'type' => 'color' );

	$options[] = array(
		"name" => __('Overlay transparency','sn'),
		'desc' => __('Default value is 0.4, min: 0, max: 1', 'sn'),
		"id" => $prefix . "thickbox_opacity",
		"type" => "text",
		"std" => "0.4"
	);

	$options[] = array(
		'name' => __('Thickbox color', 'sn'),
		'desc' => __('Default color is #000000.', 'sn'),
		'id' => $prefix . 'thickbox_color',
		'std' => '#000000',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Thickbox text & controls color', 'sn'),
		'desc' => __('Default color is #ffffff.', 'sn'),
		'id' => $prefix . 'thickbox_controls',
		'std' => '#ffffff',
		'type' => 'color' );

	// LOADER
	$options[] = array(
		"name" => __('Loader','sn'),
		"type" => "heading"
	);

	$options[] = array(
		'name' =>  __('Loader background color & image', 'sn'),
		//'desc' => __('Loader image settings.', 'sn'),
		'id' => $prefix . 'global_loader',
		'std' => $background_loader,
		'type' => 'background'
	);

	// USER CSS
	$options[] = array(
		"name" => __('User CSS','sn'),
		"type" => "heading"
	);

	$options[] = array(
		"name" => __('Custom CSS','sn'),
		"id" => $prefix . "custom_css",
		"type" => "textarea"
	);

/*
	// THEMEFOREST
	$options[] = array(
		"name" => __('Updates','sn'),
		"type" => "heading"
	);

	$options[] = array(
		"desc" => __('Insert your ThemeForest username and API key for receiving future Spacetype template updates','sn'),
		"type" => "info"
	);

	$options[] = array(
		"name" => __('ThemeForest username','sn'),
		"id" => $prefix . "themeforest_username",
		"type" => "text"
	);

	$options[] = array(
		"name" => __('ThemeForest API key','sn'),
		"id" => $prefix . "themeforest_apikey",
		"type" => "text"
	);
*/

	return $options;
}