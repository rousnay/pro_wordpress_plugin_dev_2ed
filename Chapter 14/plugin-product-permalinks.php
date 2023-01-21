<?php
/**
 * Plugin Name: Product Permalinks
 * Plugin URI:  http://example.com/
 * Description: Adds custom product rewrite tag and permastruct.
 * Author:      WROX
 * Author URI:  http://wrox.com
 */

// Add the rewrite rule and flush on activation.
add_action( __FILE__, 'pdev_product_permalinks_activate' );

function pdev_product_permalinks_activate() {
	pdev_product_permalinks_rules();
	flush_rewrite_rules();
}

// Flush rewrite rules on deactivation.
register_deactivation_hook( __FILE__, 'pdev_product_permalinks_deactivate' );

function pdev_product_permalinks_deactivate() {
	flush_rewrite_rules();
}

// Add rewrite rules.
add_action( 'init', 'pdev_product_permalinks_add_rules' );

function pdev_product_permalinks_add_rules() {

	// Add rewrite tag.
	add_rewrite_tag( '%product%', '([^/]+)' );

	// Add permastruct.
	add_permastruct( 'product', 'shop/%product%' );
}

// Output product script on front end.
add_action( 'template_redirect', 'pdev_products_display' );

function pdev_products_display() {

	if ( $product = get_query_var( 'product' ) ) {

		// Includes the client's product script.
		// include display-product.php;

		printf(
			'Searching for product: %s?',
			esc_html( $product )
		);
		exit();
	}
}
