<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/meta-box/
 */

/********************* META BOX DEFINITIONS ***********************/

/**
 * Prefix of meta keys (optional)
 * Use underscore (_) at the beginning to make keys hidden
 * Alt.: You also can make prefix empty to disable it
 */
// Better has an underscore as last sign
global $prefix;
global $meta_boxes;

$meta_boxes = array();

// Use in template
// rwmb_meta( 'sn_page_button_en' );

// Page, post, portfolio
$meta_boxes[] = array(
	'id' => 'color-settings',
	'title' => __('Custom background and color settings', 'sn'),
	'pages' => array( 'page', 'sn_portfolio' ),
	'context' => 'normal',
	'priority' => 'low',
	'fields' => array(
		// COLOR
		array(
			'before' => '
<script type="text/javascript" src="'.THEME_WEB_ROOT.'/framework/options-framework/js/options-custom.js?ver=3.7"></script>
<h2 class="nav-tab-wrapper">
<a href="#sn_section_type_color-wrap" title="Colors" class="nav-tab colors-tab" id="sn_section_type_color-wrap-tab">'.__( 'Color settings', 'sn' ).'</a>
<a href="#sn_section_type_bg-wrap" title="Colors" class="nav-tab colors-tab" id="sn_section_type_color-wrap-tab">'.__( 'Background settings', 'sn' ).'</a>
</h2>
<div id="sn_section_type_color-wrap" class="group">',
/*			'type' => 'heading',
			'name' => __( 'Color settings', 'sn' ),
			'id'   => $prefix . 'header_color',
		),
		array(
*/
			'name'  => __('Title color', 'sn'),
			'id'    => $prefix . 'css_title_color',
			'type'  => 'color',
			'std' => ''
		),
		array(
			'name'  => __('Text color', 'sn'),
			'id'    => $prefix . 'css_text_color',
			'type'  => 'color',
			'std' => ''
		),
		array(
			'name'  => __('Secondary color', 'sn'),
			'id'    => $prefix . 'css_text_secondary_color',
			'type'  => 'color',
			'std' => ''
		),
		array(
			'name'  => __('Link color', 'sn'),
			'id'    => $prefix . 'css_link_color',
			'type'  => 'color',
			'std' => ''
		),
		array(
			'name'  => __('Link hover color', 'sn'),
			'id'    => $prefix . 'css_link_color_hover',
			'type'  => 'color',
			'std' => ''
		),
		array(
			'name'  => __('Button border color', 'sn'),
			'id'    => $prefix . 'css_button_bg',
			'type'  => 'color',
			'std' => ''
		),
		array(
			'name'  => __('Button hover border & background color', 'sn'),
			'id'    => $prefix . 'css_button_bg_hover',
			'type'  => 'color',
			'std' => ''
		),
		array(
			'name'  => __('Button text color', 'sn'),
			'id'    => $prefix . 'css_button_color',
			'type'  => 'color',
			'std' => ''
		),
		array(
			'after' => '</div>',
			'name'  => __('Button text hover color ', 'sn'),
			'id'    => $prefix . 'css_button_color_hover',
			'type'  => 'color',
			'std' => ''
		),
		// BG
		array(
			'before' => '<div id="sn_section_type_bg-wrap" class="group">',
/*
			'type' => 'heading',
			'name' => __( 'Background settings', 'sn' ),
			'id'   => $prefix . 'header_bg',
		),
		/*
		array(
			'name' => __('Enable Image Background', 'sn'),
			'id' => $prefix .'css_bg_enable',
			'type' => 'checkbox',
		),

		array(*/
			'name' => __('Background image', 'sn'),
			'id' => $prefix . 'css_bg_image',
			'type'  => 'image_advanced',
			'max_file_uploads' => 1,
			'std' => ''
		),
		array(
			'name' => __('Background repeat', 'sn'),
			'id' => $prefix . 'css_bg_repeat',
			'type' => 'select',
			'options' => array(
				'no-repeat' => __('No repeat', 'sn'),
				'repeat-x' => __('Repeat horizontally', 'sn'),
				'repeat-y' => __('Repeat vertically', 'sn'),
				'repeat' => __('Repeat', 'sn')
			),
			'std' => 'no-repeat'
		),
		array(
			'name' => __('Background position', 'sn'),
			'id' => $prefix . 'css_bg_position',
			'type' => 'select',
			'options' => array(
				'top left' => __('Top Left', 'sn'),
				'top center' => __('Top Center', 'sn'),
				'top right' => __('Top Right', 'sn'),
				'center left' => __('Center Left', 'sn'),
				'center center' => __('Center Center', 'sn'),
				'center right' => __('Center Right', 'sn'),
				'bottom left' => __('Bottom Left', 'sn'),
				'bottom center' => __('Bottom Center', 'sn'),
				'bottom right' => __('Bottom Right', 'sn')
			),
			'std' => 'center center'
		),
		array(
			'name' => __('Background scroll', 'sn'),
			'id' => $prefix . 'css_bg_attachment',
			'type' => 'select',
			'options' => array(
				'scroll' => __('Scroll normally', 'sn'),
				'fixed' => __('Fixed in Place', 'sn')
			),
			'std' => 'auto'
		),
		array(
			'name' => __('Background size', 'sn'),
			'id' => $prefix . 'css_bg_size',
			'type' => 'select',
			'options' => array(
				'auto' => __('Auto size', 'sn'),
				'cover' => __('Cover', 'sn')
			),
			'std' => 'auto'
		),
		array(
			'after' => '</div>',
			'name'  => __('Background color', 'sn'),
			'id'    => $prefix . 'css_bg_color',
			'type'  => 'color',
			'std' => ''
		)
	)
);

// Post - gallery
$meta_boxes[] = array(
	'id' => 'post-gallery',
	'title' => __('Post gallery', 'sn'),
	'pages' => array( 'post' ),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Gallery images', 'sn'),
			'id' => $prefix . 'post_gallery',
			'type'  => 'image_advanced',
			'max_file_uploads' => 10
		),
		array(
			'name' => __( 'Pages', 'sn' ),
			'name' => __( 'Show slide bullets?', 'sn' ),
			'id'   => $prefix . "post_gallery_pages",
			'type' => 'checkbox',
			// Value can be 0 or 1
			'std'  => 1,
		),
		array(
			'name' => __( 'Navigation', 'sn' ),
			'name' => __( 'Show prev / next links?', 'sn' ),
			'id'   => $prefix . "post_gallery_nav",
			'type' => 'checkbox',
			// Value can be 0 or 1
			'std'  => 1,
		),
		array(
			'name' => __( 'Animation', 'sn' ),
			'desc' => __( 'Slider animation', 'sn' ),
			'id' => $prefix . "post_gallery_fx",
			'type' => 'select',
			'options'  => array(
				'fade' => 'fade',
				'fadeout' => 'fadeout',
				'scrollHorz' => 'scrollHorz',
				'none' => 'none'
			),
			'multiple' => false,
			'std' => 'scrollHorz'
		),
		array(
			'name' => __( 'Easing', 'sn' ),
			'desc' => __( 'For details visit <a href="http://matthewlein.com/experiments/easing.html" target="_blank">this link</a>', 'sn' ),
			'id' => $prefix . "post_gallery_animation",
			'type' => 'select',
			'options'  => array(
				'linear' => 'linear',
				'swing' => 'swing',
				'jswing' => 'jswing',
				'easeInQuad' => 'easeInQuad',
				'easeInCubic' => 'easeInCubic',
				'easeInQuart' => 'easeInQuart',
				'easeInQuint' => 'easeInQuint',
				'easeInSine' => 'easeInSine',
				'easeInExpo' => 'easeInExpo',
				'easeInCirc' => 'easeInCirc',
				'easeInElastic' => 'easeInElastic',
				'easeInBack' => 'easeInBack',
				'easeInBounce' => 'easeInBounce',
				'easeOutQuad' => 'easeOutQuad',
				'easeOutCubic' => 'easeOutCubic',
				'easeOutQuart' => 'easeOutQuart',
				'easeOutQuint' => 'easeOutQuint',
				'easeOutSine' => 'easeOutSine',
				'easeOutExpo' => 'easeOutExpo',
				'easeOutCirc' => 'easeOutCirc',
				'easeOutElastic' => 'easeOutElastic',
				'easeOutBack' => 'easeOutBack',
				'easeOutBounce' => 'easeOutBounce',
				'easeInOutQuad' => 'easeInOutQuad',
				'easeInOutCubic' => 'easeInOutCubic',
				'easeInOutQuart' => 'easeInOutQuart',
				'easeInOutQuint' => 'easeInOutQuint',
				'easeInOutSine' => 'easeInOutSine',
				'easeInOutExpo' => 'easeInOutExpo',
				'easeInOutCirc' => 'easeInOutCirc',
				'easeInOutElastic' => 'easeInOutElastic',
				'easeInOutBack' => 'easeInOutBack',
				'easeInOutBounce' => 'easeInOutBounce',
			),
			'multiple' => false,
			'std' => 'linear'
		),
		array(
			'name' => __( 'Speed animation', 'sn' ),
			'desc' => __( 'In miliseconds (1 second = 1000 miliseconds).', 'sn' ),
			'id'   => $prefix . "post_gallery_speed",
			'type' => 'text',
			'std'  => '1000',
		),
		array(
			'name' => __( 'Timeout', 'sn' ),
			'desc' => __( 'Automatic slideshow in miliseconds (1 second = 1000 miliseconds). Set 0 for manual start.', 'sn' ),
			'id'   => $prefix . "post_gallery_timeout",
			'type' => 'text',
			'std'  => '5000',
		)
	)
);

// Post - video
$meta_boxes[] = array(
	'id' => 'post-video',
	'title' => __('Post video', 'sn'),
	'pages' => array( 'post' ),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Embed', 'sn'),
			'id' => $prefix . 'post_video',
			'type'  => 'textarea'
		)
	)
);

// Post - link
$meta_boxes[] = array(
	'id' => 'post-link',
	'title' => __('Post link', 'sn'),
	'pages' => array( 'post' ),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Link name', 'sn'),
			'id' => $prefix . 'post_link_name',
			'type'  => 'text'
		),
		array(
			'name' => __('Link URL', 'sn'),
			'id' => $prefix . 'post_link_url',
			'type'  => 'url'
		)
	)
);

// Post - quote
$meta_boxes[] = array(
	'id' => 'post-quote',
	'title' => __('Quote author', 'sn'),
	'pages' => array( 'post' ),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Author name', 'sn'),
			'id' => $prefix . 'post_quote_author',
			'type'  => 'text'
		)
	)
);

// Post - audio
$meta_boxes[] = array(
	'id' => 'post-audio',
	'title' => __('Audio settings', 'sn'),
	'pages' => array( 'post' ),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Audio file', 'sn'),
			'id' => $prefix . 'post_audio_file',
			'type'  => 'file',
			'max_file_uploads' => 1
		)
	)
);

// Page
$meta_boxes[] = array(
	'id' => 'post-section-settings',
	'title' => __('Content settings', 'sn'),
	'pages' => array( 'page', 'sn_portfolio' ),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'before' => '<div id="sn_section_type_before-wrap">',
			'name' => __( 'Hide title', 'sn' ),
			'id'   => $prefix . "hide_title",
			'type' => 'checkbox',
			// Value can be 0 or 1
			'std'  => 0
		),
		array(
			'name'    => __( 'Sections before content', 'sn' ),
			'id'      => $prefix . "page_sections_before",
			'type'    => 'post',
			'clone'	  => true,
			// Post type
			'post_type' => 'sn_sections',
			// Field type, either 'select' or 'select_advanced' (default)
			'field_type' => 'select',
			// Query arguments (optional). No settings means get all published posts
			'query_args' => array(
				'post_status' => 'publish',
				'posts_per_page' => '-1',
			),
			'std'         => '',
			'placeholder' => __( '-Select a section-', 'sn' ),
		),
		array(
			'before' => '</div><div id="sn_section_type_after-wrap">',
			'after' => '</div>',
			'name'    => __( 'Sections after content', 'sn' ),
			'id'      => $prefix . "page_sections_after",
			'type'    => 'post',
			'clone'	  => true,
			// Post type
			'post_type' => 'sn_sections',
			// Field type, either 'select' or 'select_advanced' (default)
			'field_type' => 'select',
			// Query arguments (optional). No settings means get all published posts
			'query_args' => array(
				'post_status' => 'publish',
				'posts_per_page' => '-1',
			),
			'std'         => '',
			'placeholder' => __( '-Select a section-', 'sn' ),
		),
	)
);

// Section
$meta_boxes[] = array(
	'id' => 'section-settings',
	'title' => __('Section settings', 'sn'),
	'pages' => array( 'sn_sections' ),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(

		// GENERAL
		array(
			'before' => '
<script type="text/javascript" src="'.THEME_WEB_ROOT.'/framework/options-framework/js/options-custom.js?ver=3.7"></script>
<h2 class="nav-tab-wrapper">
<a href="#sn_section_type_general-wrap" title="General" class="nav-tab general-tab" id="sn_section_type_general-wrap-tab">'.__( 'General settings', 'sn' ).'</a>
<a href="#sn_section_type_color-wrap" title="Colors" class="nav-tab colors-tab" id="sn_section_type_color-wrap-tab">'.__( 'Color settings', 'sn' ).'</a>
<a href="#sn_section_type_bg-wrap" title="Colors" class="nav-tab colors-tab" id="sn_section_type_bg-wrap-tab">'.__( 'Background settings', 'sn' ).'</a>
<a href="#sn_section_type_slider-wrap" title="Colors" class="nav-tab colors-tab" id="sn_section_type_slider-wrap-tab">'.__( 'Slider settings', 'sn' ).'</a>
<a href="#sn_section_type_map-wrap" title="Colors" class="nav-tab colors-tab" id="sn_section_type_map-wrap-tab">'.__( 'Map settings', 'sn' ).'</a>
</h2>
<div id="sn_section_type_general-wrap" class="group">',
/*			'type' => 'heading',
			'name' => __( 'General settings', 'sn' ),
			'id'   => $prefix . 'section_general',
		),
		array(
*/
			'name'     => __( 'Section type', 'sn' ),
			'id'       => $prefix . "section_type",
			'type'     => 'radio',
			'options'  => array(
				'normal' => __( 'Normal', 'sn' ),
				'slider' => __( 'Slider', 'sn' ),
				'map' => __( 'Map', 'sn' ),
			),
			'multiple'    => false,
			'std'         => 'normal'
		),
		array(
			'name' => __('Vertical position', 'sn'),
			'id' => $prefix . 'css_section_horizont_pos',
			'type' => 'select',
			'options' => array(
				'top' => __('Top', 'sn'),
				'middle' => __('Middle', 'sn'),
				'bottom' => __('Bottom', 'sn')
			),
			'std' => 'middle'
		),
		array(
			'name' => __('Width', 'sn'),
			'id' => $prefix . 'css_section_width',
			'type' => 'select',
			'options' => array(
				'section-fullwidth' => __('Full width (100%)', 'sn'),
				'section-boxed' => __('Boxed (1150px)', 'sn'),
				'section-fullimage' => __('Full image', 'sn'),
			),
			'std' => 'section-fullwidth'
		),
		array(
			'after' => '</div>',
			'name' => __( 'Minimal height', 'sn' ),
			'desc' => __( 'Minimal height description', 'sn' ),
			'id'   => $prefix . "css_section_min_height",
			'type' => 'text',
			'std'  => '300',
		),

		// COLOR
		array(
			'before' => '<div id="sn_section_type_color-wrap" class="group">',
/*			'type' => 'heading',
			'name' => __( 'Color', 'sn' ),
			'id'   => $prefix . 'section_color',
		),
		array(
*/
			'name'  => __('Title color', 'sn'),
			'id'    => $prefix . 'css_title_color',
			'type'  => 'color',
			'std' => ''
		),
		array(
			'name'  => __('Text color', 'sn'),
			'id'    => $prefix . 'css_text_color',
			'type'  => 'color',
			'std' => ''
		),
		array(
			'name'  => __('Secondary color', 'sn'),
			'id'    => $prefix . 'css_text_secondary_color',
			'type'  => 'color',
			'std' => ''
		),
		array(
			'name'  => __('Link color', 'sn'),
			'id'    => $prefix . 'css_link_color',
			'type'  => 'color',
			'std' => ''
		),
		array(
			'name'  => __('Link hover color', 'sn'),
			'id'    => $prefix . 'css_link_color_hover',
			'type'  => 'color',
			'std' => ''
		),
		array(
			'name'  => __('Button border color', 'sn'),
			'id'    => $prefix . 'css_button_bg',
			'type'  => 'color',
			'std' => ''
		),
		array(
			'name'  => __('Button hover border & background color', 'sn'),
			'id'    => $prefix . 'css_button_bg_hover',
			'type'  => 'color',
			'std' => ''
		),
		array(
			'name'  => __('Button text color', 'sn'),
			'id'    => $prefix . 'css_button_color',
			'type'  => 'color',
			'std' => ''
		),
		array(
			'after' => '</div>',
			'name'  => __('Button text hover color ', 'sn'),
			'id'    => $prefix . 'css_button_color_hover',
			'type'  => 'color',
			'std' => ''
		),

		// BG
		array(
			'before' => '<div id="sn_section_type_bg-wrap" class="group">',
/*			'type' => 'heading',
			'name' => __( 'Background', 'sn' ),
			'id'   => $prefix . 'section_bg',
		),
		array(
*/
/*
			'name' => __('Enable Image Background', 'sn'),
			'id' => $prefix .'css_bg_enable',
			'type' => 'checkbox',
			'std'  => 0,
		),
		array(
*/
			'name' => __('Background image', 'sn'),
			'id' => $prefix . 'css_bg_image',
			'type'  => 'image_advanced',
			'max_file_uploads' => 1,
			'std' => ''
		),
		array(
			'name' => __('Background repeat', 'sn'),
			'id' => $prefix . 'css_bg_repeat',
			'type' => 'select',
			'options' => array(
				'no-repeat' => __('No repeat', 'sn'),
				'repeat-x' => __('Repeat horizontally', 'sn'),
				'repeat-y' => __('Repeat vertically', 'sn'),
				'repeat' => __('Repeat', 'sn')
			),
			'std' => 'no-repeat'
		),
		array(
			'name' => __('Background position', 'sn'),
			'id' => $prefix . 'css_bg_position',
			'type' => 'select',
			'options' => array(
				'top left' => __('Top Left', 'sn'),
				'top center' => __('Top Center', 'sn'),
				'top right' => __('Top Right', 'sn'),
				'center left' => __('Center Left', 'sn'),
				'center center' => __('Center Center', 'sn'),
				'center right' => __('Center Right', 'sn'),
				'bottom left' => __('Bottom Left', 'sn'),
				'bottom center' => __('Bottom Center', 'sn'),
				'bottom right' => __('Bottom Right', 'sn')
			),
			'std' => 'center center'
		),
		array(
			'name' => __('Background scroll', 'sn'),
			'id' => $prefix . 'css_bg_attachment',
			'type' => 'select',
			'options' => array(
				'scroll' => __('Scroll normally', 'sn'),
				'fixed' => __('Fixed in Place', 'sn')
			),
			'std' => 'auto'
		),
		array(
			'name' => __('Background size', 'sn'),
			'id' => $prefix . 'css_bg_size',
			'type' => 'select',
			'options' => array(
				'auto' => __('Auto size', 'sn'),
				'cover' => __('Cover', 'sn')
			),
			'std' => 'auto'
		),
		array(
			'after' => '</div>',
			'name'  => __('Background color', 'sn'),
			'id'    => $prefix . 'css_bg_color',
			'type'  => 'color',
			'std' => ''
		),

		// SLIDER
		array(
			'before' => '<div id="sn_section_type_slider-wrap" class="group">',
/*			'type' => 'heading',
			'name' => __( 'Slider settings', 'sn' ),
			'id'   => $prefix . 'section_slider',
		),
		array(
*/
			'name' => __( 'Pages', 'sn' ),
			'name' => __( 'Show slide bullets?', 'sn' ),
			'id'   => $prefix . "section_slider_pages",
			'type' => 'checkbox',
			// Value can be 0 or 1
			'std'  => 1,
		),
		array(
			'name' => __( 'Navigation', 'sn' ),
			'name' => __( 'Show prev / next links?', 'sn' ),
			'id'   => $prefix . "section_slider_nav",
			'type' => 'checkbox',
			// Value can be 0 or 1
			'std'  => 1,
		),
		array(
			'name' => __( 'Animation', 'sn' ),
			'desc' => __( 'Slider animation', 'sn' ),
			'id' => $prefix . "section_slider_fx",
			'type' => 'select',
			'options'  => array(
				'fade' => 'fade',
				'fadeout' => 'fadeout',
				'scrollHorz' => 'scrollHorz',
				'none' => 'none'
			),
			'multiple' => false,
			'std' => 'scrollHorz'
		),
		array(
			'name' => __( 'Easing', 'sn' ),
			'desc' => __( 'For details visit <a href="http://matthewlein.com/experiments/easing.html" target="_blank">this link</a>', 'sn' ),
			'id' => $prefix . "section_slider_animation",
			'type' => 'select',
			'options'  => array(
				'linear' => 'linear',
				'swing' => 'swing',
				'jswing' => 'jswing',
				'easeInQuad' => 'easeInQuad',
				'easeInCubic' => 'easeInCubic',
				'easeInQuart' => 'easeInQuart',
				'easeInQuint' => 'easeInQuint',
				'easeInSine' => 'easeInSine',
				'easeInExpo' => 'easeInExpo',
				'easeInCirc' => 'easeInCirc',
				'easeInElastic' => 'easeInElastic',
				'easeInBack' => 'easeInBack',
				'easeInBounce' => 'easeInBounce',
				'easeOutQuad' => 'easeOutQuad',
				'easeOutCubic' => 'easeOutCubic',
				'easeOutQuart' => 'easeOutQuart',
				'easeOutQuint' => 'easeOutQuint',
				'easeOutSine' => 'easeOutSine',
				'easeOutExpo' => 'easeOutExpo',
				'easeOutCirc' => 'easeOutCirc',
				'easeOutElastic' => 'easeOutElastic',
				'easeOutBack' => 'easeOutBack',
				'easeOutBounce' => 'easeOutBounce',
				'easeInOutQuad' => 'easeInOutQuad',
				'easeInOutCubic' => 'easeInOutCubic',
				'easeInOutQuart' => 'easeInOutQuart',
				'easeInOutQuint' => 'easeInOutQuint',
				'easeInOutSine' => 'easeInOutSine',
				'easeInOutExpo' => 'easeInOutExpo',
				'easeInOutCirc' => 'easeInOutCirc',
				'easeInOutElastic' => 'easeInOutElastic',
				'easeInOutBack' => 'easeInOutBack',
				'easeInOutBounce' => 'easeInOutBounce',
			),
			'multiple' => false,
			'std' => 'linear'
		),
		array(
			'name' => __( 'Speed animation', 'sn' ),
			'desc' => __( 'In miliseconds (1 second = 1000 miliseconds).', 'sn' ),
			'id'   => $prefix . "section_slider_speed",
			'type' => 'text',
			'std'  => '1000',
		),
		array(
			'name' => __( 'Timeout', 'sn' ),
			'desc' => __( 'Automatic slideshow in miliseconds (1 second = 1000 miliseconds). Set 0 for manual start.', 'sn' ),
			'id'   => $prefix . "section_slider_timeout",
			'type' => 'text',
			'std'  => '5000',
		),
		array(
			'name'    => __( 'Slider items', 'sn' ),
			'id'      => $prefix . "section_slider_items",
			'type'    => 'post',
			'clone'	  => true,
			// Post type
			'post_type' => 'sn_sections',
			// Field type, either 'select' or 'select_advanced' (default)
			'field_type' => 'select',
			// Query arguments (optional). No settings means get all published posts
			'query_args' => array(
				'post_status' => 'publish',
				'posts_per_page' => '-1',
			),
			'std'         => '',
			'placeholder' => __( '- Select a slider items -', 'sn' ),
		),
		array(
			'after' => '</div>',
			'name' => __( 'Slider link', 'sn' ),
			'desc' => __( 'URL, for example www.spacetype.com', 'sn' ),
			'id'   => $prefix . "section_slider_link",
			'type' => 'text'
		),
		// MAP
		array(
			'before' => '<div id="sn_section_type_map-wrap" class="group">',
/*			'type' => 'heading',
			'name' => __( 'Map settings', 'sn' ),
			'id'   => $prefix . 'section_map',
		),
		array(
*/
			'name' => __( 'Address', 'sn' ),
			'desc' => __( '1 Infinite Loop, Cupertino, CA 95014, United States', 'sn' ),
			'id'   => $prefix . "section_map_address",
			'type' => 'text'
		),
		array(
			'name' => __( 'Zoom', 'sn' ),
			'desc' => __( 'Range between 1-20, where 20 is maximal zoom', 'sn' ),
			'id'   => $prefix . "section_map_zoom",
			'type' => 'text',
			'std' => '15'
		),
		array(
			'after' => '</div>',
			'name' => __( 'Style', 'sn' ),
			'desc' => __( 'Google map with custom colors. Use <a href="http://www.dwzone-it.com/StyledMapWizard/StyledMapWizard.asp" target="_blank">this tool</a> and paste the code from button "show JSON" here', 'sn' ),
			'id'   => $prefix . "section_map_style",
			'type' => 'textarea'
		)
	)
);

/********************* META BOX REGISTERING ***********************/

/**
 * Register meta boxes
 *
 * @return void
 */
function sn_register_meta_boxes()
{
	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( !class_exists( 'RW_Meta_Box' ) )
		return;

	global $meta_boxes;
	foreach ( $meta_boxes as $meta_box )
	{
		new RW_Meta_Box( $meta_box );
	}
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'sn_register_meta_boxes' );