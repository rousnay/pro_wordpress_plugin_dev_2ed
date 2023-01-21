<?php
/**
 * Plugin Name: Cron Scheduled Event
 * Plugin URI:  http://example.com/
 * Description: Example of scheduling and unscheduling an event.
 * Author:      WROX
 * Author URI:  http://wrox.com
 */

register_activation_hook( __FILE__, 'pdev_cron_example_activation' );

function pdev_cron_activation() {

	if ( ! wp_next_scheduled( 'pdev_example_event' ) ) {
		wp_schedule_event( time(), 'hourly', 'pdev_example_event' );
	}
}

register_deactivation_hook( __FILE__, 'pdev_cron_example_deactivation' );

function pdev_cron_example_deactivation() {

	$timestamp = wp_next_scheduled( 'pdev_example_event' );

	if ( $timestamp ) {
		wp_unschedule_event( $timestamp, 'pdev_example_event' );
	}
}

add_action( 'pdev_example_event', 'pdev_example_email' );

function pdev_example_email() {

	wp_mail(
		'example@example.com',
		'Reminder',
		'Hey, remember to do that important thing!'
	);
}
