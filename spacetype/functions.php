<?php
/**
 * SK functions and definitions
 *
 * @package seniores
 */

$prefix = 'sn_';

if (!function_exists('printr')) {
	function printr($var) {
		echo "<pre>";
		print_r($var);
		echo "</pre>";
	}
}

/*-----------------------------------------------------------------------------------*/
/*	Default theme constants - do not change
/*-----------------------------------------------------------------------------------*/

define( 'SN_THEME_NAME', 'Spacetype' );
define( 'SN_THEME_VERSION', '1.0' );

define( 'THEME_WEB_ROOT', get_template_directory_uri() );
define( 'THEME_DOCUMENT_ROOT', get_template_directory() );

define( 'STYLE_WEB_ROOT', get_stylesheet_directory_uri() );
define( 'STYLE_DOCUMENT_ROOT', get_stylesheet_directory() );

define( 'FRAMEWORK_DIRECTORY', THEME_DOCUMENT_ROOT . '/framework/' );
define( 'RWMB_URL', THEME_WEB_ROOT . '/framework/meta-box/' );
define( 'RWMB_DIR', THEME_DOCUMENT_ROOT . '/framework/meta-box/' );

define( 'SN_FRAMEWORK_VERSION', '1.0' );

/*-----------------------------------------------------------------------------------*/
/*	Load Framework Components
/*-----------------------------------------------------------------------------------*/
require_once( FRAMEWORK_DIRECTORY . 'admin-functions.php' );
require_once( FRAMEWORK_DIRECTORY . 'theme-functions.php' );
require_once( FRAMEWORK_DIRECTORY . 'breadcrumbs.php' );
require_once( FRAMEWORK_DIRECTORY . 'mce-table-buttons/mce_table_buttons.php' );
require_once( FRAMEWORK_DIRECTORY . 'shortcodes-generator/shortcodeseditorselector.php' );
require_once( FRAMEWORK_DIRECTORY . 'meta-box/meta-box.php' );

/*-----------------------------------------------------------------------------------*/
/*	Initialize the Options framework
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/framework/options-framework/' );
	require_once dirname( __FILE__ ) . '/framework/options-framework/options-framework.php';
}

/*-----------------------------------------------------------------------------------*/
/*	Initialize the Update framework
/*-----------------------------------------------------------------------------------*/
//require_once( FRAMEWORK_DIRECTORY . 'themeforest-themes-update-master/index.php' );

require_once(FRAMEWORK_DIRECTORY  ."themeforest-themes-update-master/pixelentity-themes-updater/class-pixelentity-themes-updater.php");
$updates = get_site_transient('update_themes');
$updater = new Pixelentity_Themes_Updater('seniores', 'spacetype');
$updates = $updater->check($updates);
set_site_transient('update_themes',$updates);

function sn_is_newer_version() {

	$updates = get_site_transient('update_themes');
	if (isset($updates->response['spacetype'])) {
		return $updates->response['spacetype'];
	} else {
		return false;
	}
}

/*-----------------------------------------------------------------------------------*/
/*	Load Custom Post Types
/*-----------------------------------------------------------------------------------*/
require_once( THEME_DOCUMENT_ROOT . '/inc/post-types.php' );

/*-----------------------------------------------------------------------------------*/
/*	Load Meta boxes
/*-----------------------------------------------------------------------------------*/
require_once( THEME_DOCUMENT_ROOT . '/inc/meta.php' );

/*-----------------------------------------------------------------------------------*/
/*	Load Shortcodes
/*-----------------------------------------------------------------------------------*/
require_once( THEME_DOCUMENT_ROOT . '/inc/shortcodes.php' );

/*-----------------------------------------------------------------------------------*/
/*	Load Widgets
/*-----------------------------------------------------------------------------------*/
require_once( THEME_DOCUMENT_ROOT . '/inc/widgets/widget-contact.php' );
require_once( THEME_DOCUMENT_ROOT . '/inc/widgets/widget-portfolio.php' );
require_once( THEME_DOCUMENT_ROOT . '/inc/widgets/widget-social.php' );
require_once( THEME_DOCUMENT_ROOT . '/inc/widgets/widget-ads.php' );
require_once( THEME_DOCUMENT_ROOT . '/inc/widgets/widget-video.php' );
require_once( THEME_DOCUMENT_ROOT . '/inc/widgets/widget-twitter.php' );

/*-----------------------------------------------------------------------------------*/
/*  Set Max Content Width
/* ----------------------------------------------------------------------------------*/

if ( ! isset( $content_width ) )
	$content_width = 1150;

/*-----------------------------------------------------------------------------------*/
/*	SN theme set up
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'sn_theme_setup' ) ) {
	function sn_theme_setup() {

		/* Load translation domain --------------------------------------------------*/
		load_theme_textdomain( 'sn', get_template_directory() . '/languages' );

		/* Register WP 3.0+ Menus ---------------------------------------------------*/
		register_nav_menu( 'menu', 'Primary menu' );

		/* Configure WP 2.9+ Thumbnails ---------------------------------------------*/
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'testimonial', 85, 85, true );
		add_image_size( 'grid1_4', 250, '' );
		add_image_size( 'grid1_3', 350, '' );
		add_image_size( 'grid2_3', 750, '' );
		add_image_size( 'grid1_2', 550, '' );
		add_image_size( 'grid1_1', 1150, '' );
		add_image_size( 'portfolio_3', 350, 350, true );
		add_image_size( 'portfolio_4', 250, 250, true );

        add_filter( 'use_default_gallery_style', '__return_false' );

    	/* Add support for post formats ---------------------------------------------*/
        add_theme_support(
            'post-formats',
            array(
                'gallery',
                'video',
                'audio',
                'link',
                'quote',
                'status'
            )
        );

        add_theme_support( 'automatic-feed-links' );
	}
}
add_action( 'after_setup_theme', 'sn_theme_setup' );

/*-----------------------------------------------------------------------------------*/
/*	Add image size to media uploader
/*-----------------------------------------------------------------------------------*/
function sn_add_custom_sizes( $imageSizes ) {
  $my_sizes = array(
		'grid1_4' => 'Grid 1/4',
		'grid1_3' => 'Grid 1/3',
		'grid2_3' => 'Grid 2/3',
		'grid1_2' => 'Grid 1/2',
		'grid1_1' => 'Grid 1/1',
	);
	return array_merge( $imageSizes, $my_sizes );
}
add_filter( 'image_size_names_choose', 'sn_add_custom_sizes' );

/*-----------------------------------------------------------------------------------*/
/*	Register and load JS
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'sn_enqueue_scripts' ) ) {
	function sn_enqueue_scripts() {

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );

		/* Register our scripts -----------------------------------------------------*/
		wp_register_script( 'modernizr', THEME_WEB_ROOT . '/js/modernizr.js', false, SN_THEME_VERSION, false );
		wp_register_script( 'cycle', THEME_WEB_ROOT . '/js/jquery.cycle.js', array('jquery'), SN_THEME_VERSION, true );
		wp_register_script( 'easing', THEME_WEB_ROOT . '/js/jquery.easing.js', array('jquery'), SN_THEME_VERSION, true );
		wp_register_script( 'hashchange', THEME_WEB_ROOT . '/js/jquery.hashchange.js', array('jquery'), SN_THEME_VERSION, true );
		wp_register_script( 'heights', THEME_WEB_ROOT . '/js/jquery.eqHeights.js', array('jquery'), SN_THEME_VERSION, true );
		wp_register_script( 'sk', THEME_WEB_ROOT . '/js/sk.js', array('jquery'), SN_THEME_VERSION, true );
		wp_register_script( 'app', THEME_WEB_ROOT . '/js/app.js', array('sk'), SN_THEME_VERSION, true );

		if( !is_admin()) {
			wp_deregister_script( 'jquery' );
			wp_register_script( 'jquery', ("http://code.jquery.com/jquery-1.10.2.min.js"), false, '1.10.2', true );
			wp_register_script( 'jquery-migrate', ("http://code.jquery.com/jquery-migrate-1.2.1.min.js"), false, '1.2.1', true );
		}

		/* Enqueue our scripts ------------------------------------------------------*/
		wp_enqueue_script('modernizr');
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-migrate');
		wp_enqueue_script('google_map');
		wp_enqueue_script('cycle');
		wp_enqueue_script('easing');
		wp_enqueue_script('hashchange');
		wp_enqueue_script('heights');
		wp_enqueue_script('gmap');
		wp_enqueue_script('sk');
		wp_enqueue_script('app');

		/* Load main CSS file -------------------------------------------------------*/
		wp_enqueue_style( 'sn-style', THEME_WEB_ROOT . '/css/style.css', false, SN_THEME_VERSION, 'screen, projection' );
		wp_enqueue_style( 'sn-custom', THEME_WEB_ROOT . '/css/custom-styles.css', false, SN_THEME_VERSION, 'screen, projection' );
		wp_enqueue_style( 'sk-print', THEME_WEB_ROOT . '/css/print.css', false, SN_THEME_VERSION, 'print' );
	}
}
add_action('wp_enqueue_scripts', 'sn_enqueue_scripts');

if ( !function_exists( 'sn_app_run' ) ) {
	function sn_app_run() {

		$app = '<script> App.run(); </script>';
		echo $app;
	}
}
add_action('wp_footer', 'sn_app_run', 20);


function ds_enqueue_jquery_in_footer( &$scripts ) {

	if ( ! is_admin() )
		$scripts->add_data( 'jquery', 'group', 1 );
}
add_action( 'wp_default_scripts', 'ds_enqueue_jquery_in_footer' );

/*-----------------------------------------------------------------------------------*/
/*  Get current page url
/*-----------------------------------------------------------------------------------*/
function getUrl() {
	$url = 'http';

	if ( isset( $_SERVER["HTTPS"] ) && strtolower( $_SERVER["HTTPS"] ) == "on" ) {
	    $url .= "s";
	}

	$url .= '://' . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];

	return $url;
}

/*-----------------------------------------------------------------------------------*/
/*  Register widgetized area and update sidebar with default widgets
/*-----------------------------------------------------------------------------------*/
function sn_widgets_init() {
	register_sidebar( array(
		'name'          => __('Blog widget area', 'sn'),
		'id'            => 'sidebar-blog',
		'before_widget' => '<div class="box-side %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="box-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __('Footer widget area', 'sn'),
		'id'            => 'sidebar-footer',
		'before_widget' => '<div id="%1$s" class="box-side col %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="box-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'sn_widgets_init' );

/*-----------------------------------------------------------------------------------*/
/*	Adds custom classes to the array of body classes.
/*-----------------------------------------------------------------------------------*/
function sn_body_classes( $classes ) {

	$fixed_header = of_get_option('sn_header_fixed');

	if ( !is_404() ) {

		$id = get_the_ID();
		$post_type = get_post_type( $id );
		$blogpage_id = get_option('page_for_posts');

		if ( sn_is_blog_page() && $blogpage_id != 0 ) {
			$classes[] = 'page-id-' . $blogpage_id;
		} elseif ( $post_type == 'sn_portfolio' ) {
			$classes[] = 'page-id-' . $id;
		} elseif ( $post_type == 'post' ) {
			if ( $blogpage_id != 0 )
				$classes[] = 'page-id-' . $blogpage_id;
			else
				$classes[] = 'page-id-blog';
		}

	}

	if ( $fixed_header == 0 ) {
		$classes[] = 'no-fixed-header';
	}

	return $classes;
}
add_filter( 'body_class', 'sn_body_classes' );

/*-----------------------------------------------------------------------------------*/
/*  Remove paragraph from shortcode
/*-----------------------------------------------------------------------------------*/

add_filter('the_content', 'sn_shortcode_empty_paragraph_fix');
function sn_shortcode_empty_paragraph_fix($content) {

	$array = array (
		'<p>[' => '[',
		']</p>' => ']',
		']<br />' => ']'
	);

	$content = strtr($content, $array);
	return $content;
}

/*-----------------------------------------------------------------------------------*/
/*  Lazy load images
/*-----------------------------------------------------------------------------------*/

function sn_add_image_placeholders( $content ) {
	// Don't lazyload for feeds, previews, mobile
	if( is_feed() || is_preview() || ( function_exists( 'is_mobile' ) && is_mobile() ) )
		return $content;
	// Don't lazy-load if the content has already been run through previously
	if ( false !== strpos( $content, 'data-src' ) )
		return $content;
	// In case you want to change the placeholder image
	$placeholder_image = apply_filters( 'lazyload_images_placeholder_image', THEME_WEB_ROOT . '/framework/images/blank.png' );
	// This is a pretty simple regex, but it works
	$content = preg_replace( '#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#', sprintf( '<img${1}src="%s" data-src="${2}"${3}><noscript><img${1}src="${2}"${3}></noscript>', $placeholder_image ), $content );
	return $content;
}

//add_filter( 'the_content', 'sn_add_image_placeholders', 99 );
//add_filter( 'post_thumbnail_html', 'sn_add_image_placeholders', 11 );
//add_filter( 'get_avatar', 'sn_add_image_placeholders', 11 );

/*-----------------------------------------------------------------------------------*/
/*  Set custom excerpt more
/*-----------------------------------------------------------------------------------*/

function sn_custom_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'sn_custom_excerpt_more' );

/*-----------------------------------------------------------------------------------*/
/*  Remove recent comments style from header
/*-----------------------------------------------------------------------------------*/

function sn_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'sn_remove_recent_comments_style' );

/*-----------------------------------------------------------------------------------*/
/*  Get class lightbox and rel lightbox to content images
/*-----------------------------------------------------------------------------------*/

add_filter('the_content', 'addlightboxrel_replace', 12);
add_filter('get_comment_text', 'addlightboxrel_replace');

function addlightboxrel_replace($content) {
	global $post;
	$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
	$replacement = '<a$1href=$2$3.$4$5 class="thickbox" data-rel="thickbox"$6>$7</a>';
	$content = preg_replace($pattern, $replacement, $content);

	return $content;
}

function filter_ptags_on_images($content) {
    // do a regular expression replace...
    // find all p tags that have just
    // <p>maybe some white space<img all stuff up to /> then maybe whitespace </p>
    // replace it with just the p.img-content tag...
    $pattern = '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU';
    $replacement = '<p class="img-content">$1$2$3</p>';
    $content = preg_replace( $pattern, $replacement, $content);

    return $content;
}

// we want it to be run after the autop stuff... 10 is default.
add_filter('the_content', 'filter_ptags_on_images');


/*-----------------------------------------------------------------------------------*/
/*  Add has-submenu class to main menu parent
/*-----------------------------------------------------------------------------------*/
function sn_set_has_submenu( $sorted_menu_items, $args ) {
    $last_top = 0;
    foreach ( $sorted_menu_items as $key => $obj ) {
        // it is a top lv item?
        if ( 0 == $obj->menu_item_parent ) {
            // set the key of the parent
            $last_top = $key;
        } else {
            $sorted_menu_items[$last_top]->classes['has-submenu'] = 'has-submenu';
        }
    }
    return $sorted_menu_items;
}
add_filter( 'wp_nav_menu_objects', 'sn_set_has_submenu', 10, 2 );

/*-----------------------------------------------------------------------------------*/
/*  Get attachment id from image src
/*-----------------------------------------------------------------------------------*/
function sn_get_attachment_id_from_src ($image_src) {
	global $wpdb;
	$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
	$id = $wpdb->get_var($query);
	return $id;
}

/*-----------------------------------------------------------------------------------*/
/*	Get sidebar count
/*-----------------------------------------------------------------------------------*/
function sn_count_sidebar_widgets( $sidebar_id, $echo = true ) {
    $the_sidebars = wp_get_sidebars_widgets();
    if( !isset( $the_sidebars[$sidebar_id] ) )
        return __( 'Invalid sidebar ID', 'sn' );
    if( $echo )
        echo count( $the_sidebars[$sidebar_id] );
    else
        return count( $the_sidebars[$sidebar_id] );
}

/*-----------------------------------------------------------------------------------*/
/*  Apply custom styles to the visual editor
/*-----------------------------------------------------------------------------------*/

/**
 * Add "Styles" drop-down
 */
add_filter( 'mce_buttons_2', 'sn_mce_editor_buttons' );

function sn_mce_editor_buttons( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}

/**
 * Add styles/classes to the "Styles" drop-down
 */
add_filter( 'tiny_mce_before_init', 'sn_mce_before_init' );

function sn_mce_before_init( $settings ) {

	$style_formats = array(
		array(
			'title' => 'Big',
			'inline' => 'span',
			'classes' => 'big'
		),
		array(
			'title' => 'Small',
			'inline' => 'span',
			'classes' => 'small'
		),
		array(
			'title' => 'Light',
			'inline' => 'span',
			'classes' => 'light'
		),
		array(
			'title' => 'Center',
			'block' => 'div',
			'classes' => 'center',
			'wrapper' => true
		)
	);

	$settings['style_formats'] = json_encode( $style_formats );

	return $settings;
}

function sn_change_mce_buttons( $initArray ) {
	$initArray['theme_advanced_buttons2'] = 'formatselect,styleselect,underline,justifyfull,forecolor,|,pastetext,pasteword,removeformat,|,media,charmap,|,outdent,indent,|,undo,redo,wp_help';

	return $initArray;
}
add_filter('tiny_mce_before_init', 'sn_change_mce_buttons');

/*-----------------------------------------------------------------------------------*/
/*	Set default values for the upload media box
/*-----------------------------------------------------------------------------------*/

function sn_media_setup() {
	update_option( 'image_default_align', 'none' );
	update_option( 'image_default_link_type', 'none' );
}
add_action('after_setup_theme', 'sn_media_setup');

/*-----------------------------------------------------------------------------------*/
/*	Template for comments and pingbacks.
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'sn_comment' ) ) :
function sn_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

    $isByAuthor = false;

    if($comment->comment_author_email == get_the_author_meta('email')) {
        $isByAuthor = true;
    }

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class('post'); ?>>
		<div class="post-body">
			<?php _e( 'Pingback:', 'sn' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'sn' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? 'post' : 'post parent' ); ?>>
		<p class="title">
			<span class="img">
				<?php echo get_avatar( $comment, 60 ); ?>
			</span>
			<strong class="h6"><?php echo get_comment_author_link(); ?></strong>
			<?php if( $isByAuthor ) { ?><span class="author-tag"> <?php _e('(author)', 'sn'); ?> </span><?php } ?>
			<span class="date"><?php printf( _x( '%1$s in %2$s', '1: date, 2: time', 'sn' ), get_comment_date(), get_comment_time() ); ?></span>
		</p>

		<div class="post-body">
			<?php if ( '0' == $comment->comment_approved ) : ?>
			<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'sn' ); ?></p>
			<?php endif; ?>
			<?php comment_text(); ?>
		</div>
		<div class="post-foot">
			<?php comment_reply_link( array_merge( $args, array( 'add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div>

	<?php
	endif;
}
endif;

if ( ! function_exists( 'sn_posted_on' ) ) :
function sn_posted_on() {

	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'sn' ) );
	$categories = '';
	if ( $categories_list ) {
		$categories = '<span class="categories-links">' . $categories_list . '</span>';
	}
	$author = get_the_author();
	$date = get_the_date();

	printf( __( 'Posted by %1$s in <strong>%2$s</strong> <span class="line">/</span> %3$s', 'sn' ), $author, $categories, $date );

}
endif;

/*-----------------------------------------------------------------------------------*/
/*  Function for generate message from contact form
/*-----------------------------------------------------------------------------------*/

$response = "";
function sn_generate_response($type, $message) {

	global $response;

	if($type == "success") {
		$response = "<div class='message message-success'>{$message}<a href=\"#\" class=\"close icon icon-close\"><span class=\"vhide\">Close</span></a></div>";
	} else {
		$response = "<div class='message message-error'>{$message}<a href=\"#\" class=\"close icon icon-close\"><span class=\"vhide\">Close</span></a></div>";
	}
}

/*-----------------------------------------------------------------------------------*/
/*  Disable tag cloud inline style
/*-----------------------------------------------------------------------------------*/
add_filter( 'wp_generate_tag_cloud', 'sn_tag_cloud', 10,3 );
function sn_tag_cloud($tag_string){
	return preg_replace("/style='font-size:.+pt;'/", '', $tag_string);
}

/*-----------------------------------------------------------------------------------*/
/*  Update default gallery shortcode
/*-----------------------------------------------------------------------------------*/

remove_shortcode( 'gallery' ); // Remove the default gallery shortcode implementation
add_shortcode( 'gallery', 'sn_gallery_shortcode' ); // And replace it with our own!

/**
* The Gallery shortcode.
*
* This has been taken verbatim from wp-includes/media.php. There's a lot of good stuff in there.
* All you want to do is add some more HTML to it, and since (for some reason) they didn't provide more
* filters to be able to add, we have to replace the Gallery shortcode wholesale.
*
* @param array $attr Attributes of the shortcode.
* @return string HTML content to display gallery.
*/
function sn_gallery_shortcode($attr) {
    global $post;

    static $instance = 0;
    $instance++;

    $output = apply_filters('post_gallery', '', $attr);
    if ( $output != '' )
        return $output;

    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }

    // NOTE: These are all the 'options' you can pass in through the shortcode definition, eg: [gallery itemtag='p']
    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'div',
        'icontag'    => 'p',
        'captiontag' => 'p',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'image_size' => 'grid2_3',
        'ids'    => '',
        'exclude'    => '',
        // Here's the new options stuff we added to the shortcode defaults
        'titletag'  => '',
        'descriptiontag' => '',
        'type' => 'normal',
        'pages' => 'yes',
        'links' => 'yes',
        'animation' => 'fade',
        'easing' => 'linear',
        'speed' => 1000,
        'timeout' => 5000
    ), $attr));

    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';

    if ( !empty($ids) ) {
        $ids = preg_replace( '/[^0-9,]+/', '', $ids );
        $_attachments = get_posts( array('include' => $ids, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( $type == 'slider' )
    	$size = $image_size;

    $container_width = '';
    switch ($image_size) {
    	case 'grid1_4':
    		$container_width = 250;
    		break;
    	case 'grid1_3':
    		$container_width = 350;
    		break;
    	case 'grid2_3':
    		$container_width = 750;
    		break;
    	case 'grid1_2':
    		$container_width = 550;
    		break;
    	case 'grid1_1':
    		$container_width = 1150;
    		break;
    }

    if ( empty($attachments) )
        return '';

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

    $itemtag = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $columns = intval($columns);
    if ($columns > 4)
    	$columns = 4;

    $selector = "gallery-{$instance}";

    $size_class = sanitize_html_class( $size );
    $gallery_style = $gallery_div = '';
    $gallery_slider = "<div id='$selector' style='max-width:{$container_width}px;' class='box-slides galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}' data-cycle-fx='{$animation}' data-cycle-timeout='{$timeout}' data-cycle-easing='{$easing}' data-cycle-speed='{$speed}'>";
    $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class} grid'>";
    //$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );
    $output = ($type == 'slider') ? $gallery_slider : $gallery_div;

    $i = 0;
    foreach ( $attachments as $id => $attachment ) {

    	if ( isset($attr['link']) && 'file' == $attr['link'] ) {
        	$link = wp_get_attachment_link($id, $size, false, false);
        } elseif ( isset($attr['link']) && 'none' == $attr['link'] ) {
        	$link = wp_get_attachment_image($id, $size);
        } else {
        	$link = wp_get_attachment_link($id, $size, true, false);
        }

        $output .=  ($type == 'slider') ? "<{$itemtag} class='gallery-item slide'>" : "<{$itemtag} class='gallery-item col col-1-".$columns."'>";
        $output .= "
            <{$icontag} class='gallery-icon'>
                $link
            </{$icontag}>";

        // MODIFICATION: include the title and description HTML if we've supplied the relevant shortcode parameters (titletag, descriptiontag)
        if ( !empty( $attachment->post_excerpt ) && $type != 'slider' ) {
            $output .= "
                <{$captiontag} class='wp-caption-text gallery-caption'>";
            // The CAPTION, if there is one
            if ( trim( $attachment->post_excerpt ) ) {
                $output .= "
                    " . wptexturize($attachment->post_excerpt);
            }

            // The TITLE, if we've not made the 'titletag' param blank
            if ( $titletag ){
                $output .= "
                    <{$titletag} class=\"gallery-item-title\">" . $attachment->post_title . "</{$titletag}>";
            }

            // The DESCRIPTION, if we've not specified a blank 'descriptiontag'
            if ( $descriptiontag ){
                $output .= "
                    <{$descriptiontag} class=\"gallery-item-description\">" . wptexturize( $attachment->post_content ) . "</{$descriptiontag}>";
            }

            $output .= "
                </{$captiontag}>";
        }
        $output .= "</{$itemtag}>";
    }


    if ( $links == 'yes' || $pages == 'yes' && $type == 'slider' ) {

    	$output .= '<p class="pager">';

			if( $links == 'yes' ) {
				$output .= '<a href="#" class="prev"><span class="vhide">'.__('previous','sn').'</span></a>';
			}

			if( $pages == 'yes' ) {
				$output .= '<span class="pages"></span>';
			}

			if( $links == 'yes' ) {
				$output .= '<a href="#" class="next"><span class="vhide">'.__('next','sn').'</span></a>';
			}

		$output .= '</p>';

    }

    $output .= "</div>\n";

    return $output;
}


/*-----------------------------------------------------------------------------------*/
/*  Add slider options to gallery settings
/*-----------------------------------------------------------------------------------*/

add_action('print_media_templates', 'sn_slider_gallery_settings');
function sn_slider_gallery_settings() {
  // define your backbone template;
  // the "tmpl-" prefix is required,
  // and your input field should have a data-setting attribute
  // matching the shortcode name
?>

	<script type="text/html" id="tmpl-gallery-slider">
		<label class="setting sn-setting">
			<span><?php _e('Gallery type','sn'); ?></span>
			<select data-setting="type">
				<option value="normal"> Normal </option>
				<option value="slider"> Slider </option>
			</select>
		</label>
		<div class="sn_gallery_type" style="display:none">
		<h3 style="clear:both; padding-top:10px;">Slider Settings</h3>
		<label class="setting sn-setting">
			<span><?php _e('Image size','sn'); ?></span>
			<select data-setting="image_size">
				<option value="grid1_4"> Grid 1/4 </option>
				<option value="grid1_3"> Grid 1/3 </option>
				<option value="grid2_3"> Grid 2/3 </option>
				<option value="grid1_2"> Grid 1/2 </option>
				<option value="grid1_1"> Grid 1/1 </option>
			</select>
		</label>
		<label class="setting sn-setting">
			<span><?php _e('Show slide <br />bullets?','sn'); ?></span>
			<select data-setting="pages">
				<option value="yes"> Yes </option>
				<option value="no"> No </option>
			</select>
		</label>
		<label class="setting sn-setting">
			<span><?php _e('Show prev/next <br />links?','sn'); ?></span>
			<select data-setting="links">
				<option value="yes"> Yes </option>
				<option value="no"> No </option>
			</select>
		</label>
		<label class="setting sn-setting">
			<span><?php _e('Animation','sn'); ?></span>
			<select data-setting="animation">
				<option value="fade"> Fade </option>
				<option value="fadeout"> Fadeout </option>
				<option value="scrollHorz"> scrollHorz </option>
				<option value="none"> None </option>
			</select>
		</label>
		<label class="setting sn-setting">
			<span><?php _e('Easing','sn'); ?></span>
			<select data-setting="easing">
				<option value="linear">linear</option>
				<option value="swing">swing</option>
				<option value="jswing">jswing</option>
				<option value="easeInQuad">easeInQuad</option>
				<option value="easeInCubic">easeInCubic</option>
				<option value="easeInQuart">easeInQuart</option>
				<option value="easeInQuint">easeInQuint</option>
				<option value="easeInSine">easeInSine</option>
				<option value="easeInExpo">easeInExpo</option>
				<option value="easeInCirc">easeInCirc</option>
				<option value="easeInElastic">easeInElastic</option>
				<option value="easeInBack">easeInBack</option>
				<option value="easeInBounce">easeInBounce</option>
				<option value="easeOutQuad">easeOutQuad</option>
				<option value="easeOutCubic">easeOutCubic</option>
				<option value="easeOutQuart">easeOutQuart</option>
				<option value="easeOutQuint">easeOutQuint</option>
				<option value="easeOutSine">easeOutSine</option>
				<option value="easeOutExpo">easeOutExpo</option>
				<option value="easeOutCirc">easeOutCirc</option>
				<option value="easeOutElastic">easeOutElastic</option>
				<option value="easeOutBack">easeOutBack</option>
				<option value="easeOutBounce">easeOutBounce</option>
				<option value="easeInOutQuad">easeInOutQuad</option>
				<option value="easeInOutCubic">easeInOutCubic</option>
				<option value="easeInOutQuart">easeInOutQuart</option>
				<option value="easeInOutQuint">easeInOutQuint</option>
				<option value="easeInOutSine">easeInOutSine</option>
				<option value="easeInOutExpo">easeInOutExpo</option>
				<option value="easeInOutCirc">easeInOutCirc</option>
				<option value="easeInOutElastic">easeInOutElastic</option>
				<option value="easeInOutBack">easeInOutBack</option>
				<option value="easeInOutBounce">easeInOutBounce</option>
			</select>
		</label>
		<label class="setting sn-setting">
			<span><?php _e('Speed animation','sn'); ?></span>
			<input type="text" data-setting="speed" id="speed" name="speed" value="1000" />
			<span class="desc">In miliseconds (1 second = 1000 miliseconds).</span>
		</label>
		<label class="setting sn-setting">
			<span><?php _e('Timeout','sn'); ?></span>
			<input type="text" data-setting="timeout" id="timeout" name="timeout" value="5000"  />
			<span class="desc">Automatic slideshow in miliseconds (1 second = 1000 miliseconds). Set 0 for manual start.</span>
		</label>
		</div>
		<script>window.gallerySliderInit()</script>
	</script>

	<script>

	jQuery(document).ready(function(){

		// add your shortcode attribute and its default value to the
		// gallery settings list; $.extend should work as well...
		_.extend(wp.media.gallery.defaults, {
			type: 'normal',
			image_size: 'grid2_3',
			pages: 'yes',
			links: 'yes',
			animation: 'fade',
			easing: 'linear',
			speed: 1000,
			timeout: 5000
		});

		// merge default gallery settings template with yours
		wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
			template: function(view){
				return wp.media.template('gallery-settings')(view)
				+ wp.media.template('gallery-slider')(view);
			}
		});

	});

	</script>

  <?php
};



@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );


/*
 * Function creates post duplicate as a draft and redirects then to the edit post screen
 */
function rd_duplicate_post_as_draft(){
	global $wpdb;
	if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
		wp_die('No post to duplicate has been supplied!');
	}

	/*
	 * get the original post id
	 */
	$post_id = (isset($_GET['post']) ? $_GET['post'] : $_POST['post']);
	/*
	 * and all the original post data then
	 */
	$post = get_post( $post_id );

	/*
	 * if you don't want current user to be the new post author,
	 * then change next couple of lines to this: $new_post_author = $post->post_author;
	 */
	$current_user = wp_get_current_user();
	$new_post_author = $current_user->ID;

	/*
	 * if post data exists, create the post duplicate
	 */
	if (isset( $post ) && $post != null) {

		/*
		 * new post data array
		 */
		$args = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft',
			'post_title'     => $post->post_title,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order
		);

		/*
		 * insert the post by wp_insert_post() function
		 */
		$new_post_id = wp_insert_post( $args );

		/*
		 * get all current post terms ad set them to the new post draft
		 */
		$taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
		foreach ($taxonomies as $taxonomy) {
			$post_terms = wp_get_object_terms($post_id, $taxonomy);
			for ($i=0; $i<count($post_terms); $i++) {
				wp_set_object_terms($new_post_id, $post_terms[$i]->slug, $taxonomy, true);
			}
		}

		/*
		 * duplicate all post meta
		 */
		$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
		if (count($post_meta_infos)!=0) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			foreach ($post_meta_infos as $meta_info) {
				$meta_key = $meta_info->meta_key;
				$meta_value = addslashes($meta_info->meta_value);
				$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query.= implode(" UNION ALL ", $sql_query_sel);
			$wpdb->query($sql_query);
		}


		/*
		 * finally, redirect to the edit post screen for the new draft
		 */
		wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
		exit;
	} else {
		wp_die('Post creation failed, could not find original post: ' . $post_id);
	}
}
add_action( 'admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft' );

/*
 * Add the duplicate link to action list for post_row_actions
 */
function rd_duplicate_post_link( $actions, $post ) {
	if (current_user_can('edit_posts')) {
		$actions['duplicate'] = '<a href="admin.php?action=rd_duplicate_post_as_draft&amp;post=' . $post->ID . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
	}
	return $actions;
}

add_filter( 'post_row_actions', 'rd_duplicate_post_link', 10, 2 );
add_filter( 'sn_sections_row_actions', 'rd_duplicate_post_link', 10, 2 );
