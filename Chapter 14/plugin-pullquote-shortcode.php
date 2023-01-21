<?php
/**
 * Plugin Name: Pullquote Shortcode
 * Plugin URI:  http://example.com/
 * Description: Outputs a quote via the [pdev_pullquote] shortcode.
 * Author:      WROX
 * Author URI:  http://wrox.com
 */

add_action( 'init', 'pdev_register_pullquote_shortcodes' );

// Register shortcodes.
function pdev_register_pullquote_shortcodes() {
	add_shortcode( 'pdev_pullquote', 'pdev_pullquote_shortcode' );
}

// Shortcode callback function.
function pdev_pullquote_shortcode( $attr, $content = '' ) {

	// Bail if there is no content.
	if ( ! $content ) {
		return '';
	}

	// Return formatted content.
	return sprintf(
		'<blockquote class="pdev-pullquote">%s</blockquote>',
		wpautop( wp_kses_post( $content ) )
	);
}
