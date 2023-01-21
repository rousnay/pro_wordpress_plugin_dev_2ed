<?php
/**
 * Plugin Name: Simple Dashboard Widget
 * Plugin URI:  http://example.com/
 * Description: Example plugin of a simple dashboard widget.
 * Author:      WROX
 * Author URI:  http://wrox.com
 */

add_action( 'wp_dashboard_setup', 'pdev_simple_dashboard_register' );

// Registers dashboard widgets.
function pdev_simple_dashboard_register() {

	wp_add_dashboard_widget(
		'pdev-simple-dashboard',
		'Plugin: Report Bugs',
		'pdev_simple_dashboard_display'
	);
}

// Dashboard widget callback.
function pdev_simple_dashboard_display() {
	echo '<p>Please contact support@example.com to report bugs.</p>';
}
