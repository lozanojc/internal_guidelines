<?php

/**
 * Set some basic info
 */
function sn_admin_init() {
    // Redirect if theme has just been activated
    if(sn_is_theme_activated()){

		//regenerate custom css
		sn_regenerate_css();

        flush_rewrite_rules();
        header( 'Location: '. home_url() .'/wp-admin/admin.php?page=options-framework&activated=true' );
    }
    
    // Enable sessions
    if( !isset( $_SESSION ) ){
        session_start();
    }
    
    if( is_child_theme() ) {
        $temp_obj = wp_get_theme();
        $theme_obj = wp_get_theme( $temp_obj->get('Template') );
    } else {
        $theme_obj = wp_get_theme();    
    }
}
add_action( 'init', 'sn_admin_init', 2 );

/**
 * Load admin JS and CSS
 */

function sn_admin_scripts() {

    wp_register_script( 'sn_admin', THEME_WEB_ROOT . '/framework/js/sn-admin.js', array(), SN_THEME_VERSION);
    wp_enqueue_script('sn_admin');

    wp_enqueue_style('sn_admin_css', THEME_WEB_ROOT .'/framework/css/sn-admin.css');
}
add_action('admin_enqueue_scripts', 'sn_admin_scripts', 50);

/**
 * Has the theme just been activated
 *
 * @return bool
 */
function sn_is_theme_activated() {
    global $pagenow;
    
    if ( is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" )
        return true;
    return false;
}

?>