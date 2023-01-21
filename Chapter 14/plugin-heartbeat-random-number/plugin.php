<?php
/**
 * Plugin Name: Heartbeat Random Number
 * Plugin URI:  http://example.com/
 * Description: Generates and saves a random number using the Heartbeat API.
 * Author:      WROX
 * Author URI:  http://wrox.com
 */

// Load heartbeat.js file.
add_action( 'wp_enqueue_scripts', 'pdev_random_number_scripts' );

function pdev_random_number_scripts() {

	wp_enqueue_script(
		'pdev-heartbeat-random-number',
		plugin_dir_url( __FILE__ ) . 'heartbeat.js',
		[ 'heartbeat', 'jquery' ],
		null,
		true
	);
}

// Receive data from heartbeat.
add_filter( 'heartbeat_received', 'pdev_random_number_received', 10, 2 );

function pdev_random_number_received( $response, $data ) {

	// Bail if no plugin data sent.
	if ( empty( $data['pdev_random_number'] ) ) {
		return $response;
	}

	// Sanitize the data.
	$response['pdev_random_number'] = floatval( $data['pdev_random_number'] );

	// Update database option.
	update_option(
		'pdev_heartbeat_random_number',
		$response['pdev_random_number']
	);

	// Return the response.
	return $response;
}
