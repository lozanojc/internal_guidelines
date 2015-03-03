<?php

/*-----------------------------------------------------------------------------------
/*	Add Portfolio Post Type
/*---------------------------------------------------------------------------------*/
function sn_post_type_portfolio() {
	$args = array(
		'labels' => array(
			'name' => __( 'Portfolio', 'sn' ),
			'singular_name' => __( 'Portfolio', 'sn' ),
			'add_new' => __( 'Add New Portfolio', 'sn' ),
			'add_new_item' => __( 'Add New Portfolio Item', 'sn' ),
			'edit' => __( 'Edit', 'sn' ),
			'edit_item' => __( 'Edit Portfolio', 'sn' ),
			'new_item' => __( 'New Portfolio Item', 'sn' ),
			'view' => __( 'View Portfolio', 'sn' ),
			'view_item' => __( 'View Portfolio', 'sn' ),
			'search_items' => __( 'Search Portfolio', 'sn' ),
			'not_found' => __( 'No portfolio found', 'sn' ),
			'not_found_in_trash' => __( 'No portfolio found in Trash', 'sn' ),
			'parent' => __( 'Parent Portfolio', 'sn' ),
		),
		'public' => true,
		'exclude_from_search' => true,
		'capability_type' => 'post',
		'rewrite' => array( 'slug' => 'portfolio' ),
		'supports' => array('title','editor','thumbnail','page-attributes')
	);

	register_post_type( 'sn_portfolio', $args );
}
add_action( 'init', 'sn_post_type_portfolio', 1 );

#-----------------------------------------------------------------
# Correct Menu Highlighter
#-----------------------------------------------------------------
add_filter('nav_menu_css_class', 'current_type_nav_class', 10, 2);

if ( !function_exists( 'current_type_nav_class' ) ) {
	function current_type_nav_class($css_class, $item) {

		global $portfolio_page_id;

		if ( get_post_type() == 'sn_portfolio' ) {
			$css_class = array_filter($css_class, "sn_sortmenucss");

			if ($item->object_id == $portfolio_page_id) {
				array_push($css_class, 'current_page_parent');
			};

		}

		return $css_class;
	}
}

if ( !function_exists( 'sn_sortmenucss' ) ) {
	function sn_sortmenucss($css_class) {

		$current_value = "current_page_parent";
		return ($css_class != $current_value);

	}
}

/*-----------------------------------------------------------------------------------
/*	Add Portfolio Taxonomies
/*---------------------------------------------------------------------------------*/

function sn_taxonomy_portfolio()
{
	$args = array(
		'labels' => array(
			'name'              => _x( 'Categories', 'taxonomy general name', 'sn' ),
			'singular_name'     => _x( 'Category', 'taxonomy singular name', 'sn' ),
			'search_items'      => __( 'Search Category', 'sn' ),
			'all_items'         => __( 'All Categories', 'sn' ),
			'parent_item'       => __( 'Parent Category', 'sn' ),
			'parent_item_colon' => __( 'Parent Category:', 'sn' ),
			'edit_item'         => __( 'Edit Category', 'sn' ),
			'update_item'       => __( 'Update Category', 'sn' ),
			'add_new_item'      => __( 'Add New Category', 'sn' ),
			'new_item_name'     => __( 'New Category Name', 'sn' ),
			'menu_name'         => __( 'Categories', 'sn' ),
		),
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'category', 'with_front' => false ),
		'show_admin_column' => true,
		'hierarchical' => true
	);

	register_taxonomy( 'sn_portfolio_category', 'sn_portfolio', $args );
	//flush_rewrite_rules();
}
add_action( 'init', 'sn_taxonomy_portfolio', 1 );

/*-----------------------------------------------------------------------------------
/*	Add Section Post Type
/*---------------------------------------------------------------------------------*/
function sn_post_type_section() {
	$args = array(
		'labels' => array(
			'name' => __( 'Sections', 'sn' ),
			'singular_name' => __( 'Section', 'sn' ),
			'add_new' => __( 'Add New Section', 'sn' ),
			'add_new_item' => __( 'Add New Section', 'sn' ),
			'edit' => __( 'Edit', 'sn' ),
			'edit_item' => __( 'Edit Section', 'sn' ),
			'new_item' => __( 'New Section', 'sn' ),
			'view' => __( 'View Section', 'sn' ),
			'view_item' => __( 'View Section', 'sn' ),
			'search_items' => __( 'Search Section', 'sn' ),
			'not_found' => __( 'No sections found', 'sn' ),
			'not_found_in_trash' => __( 'No sections found in Trash', 'sn' ),
			'parent' => __( 'Parent Section', 'sn' ),
		),
		'public' => true,
		'exclude_from_search' => true,
		'capability_type' => 'post',
		//'rewrite' => array( 'slug' => 'portfolio' ),
		'supports' => array('title','editor')
	);

	register_post_type( 'sn_sections', $args );
}
add_action( 'init', 'sn_post_type_section', 1 );


?>