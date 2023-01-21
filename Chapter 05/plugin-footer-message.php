<?php
/**
 * Plugin Name: Footer Message
 * Plugin URI:  http://example.com/
 * Description: Displays a powered by WordPress message in the footer.
 * Author:      WROX
 * Author URI:  http://wrox.com
 */

add_action( 'wp_footer', 'pdev_footer_message', PHP_INT_MAX );

function pdev_footer_message() {
	esc_html_e( 'This site is powered by WordPress.', 'pdev' );
}
