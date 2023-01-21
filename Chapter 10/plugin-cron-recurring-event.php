<?php
/**
 * Plugin Name: Cron Recurring Event
 * Plugin URI:  http://example.com/
 * Description: Sends an email every hour.
 * Author:      WROX
 * Author URI:  http://wrox.com
 */

register_activation_hook( __FILE__, 'pdev_cron_activation' );

function pdev_cron_activation() {

	$args = [
		'example@example.com'
	];

	if ( ! wp_next_scheduled( 'pdev_hourly_email', $args ) ) {

		wp_schedule_event( time(), 'hourly', 'pdev_hourly_email', $args );
	}
}

add_action( 'pdev_hourly_email', 'pdev_send_email' );

function pdev_send_email( $email ) {

	wp_mail(
		sanitize_email( $email ),
		'Reminder',
		'Hey, remember to do that important thing!'
	);
}
