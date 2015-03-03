<?php
/**
 Plugin Name: MCE Table Buttons
 Plugin URI: http://10up.com/plugins-modules/wordpress-mce-table-buttons/
 Description: Add <strong>buttons for table editing</strong> to the WordPress WYSIWYG editor with this <strong>light weight</strong> plug-in.    
 Version: 2.0
 Author: Jake Goldman, 10up, Oomph
 Author URI: http://10up.com
 License: GPLv2 or later
*/

class MCE_Table_Buttons {
	public function __construct() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'content_save_pre', array( $this, 'content_save_pre'), 100 );
	}
	
	public function admin_init() {
		add_filter( 'mce_external_plugins', array( $this, 'mce_external_plugins' ) );
		add_filter( 'mce_buttons_3', array( $this, 'mce_buttons_3' ) );
	}
	
	public function mce_external_plugins( $plugin_array ) {
		$plugin_dir_url = THEME_WEB_ROOT . '/framework/mce-table-buttons/';
		$plugin_array['table'] = $plugin_dir_url . 'table/editor_plugin.js';
		$plugin_array['mcetablebuttons'] = $plugin_dir_url . 'assets/mce-table-buttons.js';
   		return $plugin_array;
	}
	
	public function mce_buttons_3( $buttons ) {
		array_push( $buttons, 'tablecontrols' );
   		return $buttons;
	}
	
	public function content_save_pre( $content ) {
		if ( substr( $content, -8 ) == '</table>' )
			$content .= "\n<br />";
		
		return $content;
	}
}

$mce_table_buttons = new MCE_Table_Buttons;