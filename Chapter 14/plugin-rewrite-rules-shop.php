<?php
/**
 * Plugin Name: Rewrite Rules Shop
 * Plugin URI:  http://example.com/
 * Description: Adds a rewrite rule to list stores as children of the Stores page.
 * Author:      WROX
 * Author URI:  http://wrox.com
 */

// Add the rewrite rule and flush on activation.
add_action( __FILE__, 'pdev_list_stores_activate' );

function pdev_list_stores_activate() {
	pdev_list_stores_add_rules();
	flush_rewrite_rules();
}

// Flush rewrite rules on deactivation.
register_deactivation_hook( __FILE__, 'pdev_list_stores_deactivate' );

function pdev_list_stores_deactivate() {
	flush_rewrite_rules();
}

// Add rewrite rules.
add_action( 'init', 'pdev_list_stores_add_rules' );

function pdev_list_stores_add_rules() {

	add_rewrite_rule(
		'stores/?([^/]*)',
		'index.php?pagename=stores&store_id=$matches[1]',
		'top'
	);
}

// Add the store_id query var so that WP recognizes it.
add_filter( 'query_vars', 'pdev_list_stores_query_var' );

function pdev_list_stores_query_var( $vars ) {
	$vars[] = 'store_id';
	return $vars;
}
