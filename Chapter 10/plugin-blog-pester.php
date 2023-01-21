<?php
/**
 * Plugin Name: Blog Pester
 * Plugin URI:  http://example.com/
 * Description: Sends a reminder email if no posts have been written in three days.
 * Author:      WROX
 * Author URI:  http://wrox.com
 */

register_activation_hook( __FILE__, 'pdev_pester_activate' );

function pdev_pester_activate() {

	if ( ! wp_next_scheduled( 'pdev_pester_event' ) ) {
		wp_schedule_event( time(), 'daily', 'pdev_pester_event' );
	}
}

register_deactivation_hook( __FILE__, 'pdev_pester_deactivate' );

function pdev_pester_deactivate() {

	$timestamp = wp_next_scheduled( 'pdev_pester_event' );

	if ( false !== $timestamp ) {
		wp_unschedule_event( $timestamp, 'pdev_pester_event' );
	}
}

add_action( 'pdev_pester_event', 'pdev_pester_check' );

function pdev_pester_check() {
	global $wpdb;

	// Query the latest published post date.
	$query = "SELECT post_date
	          FROM $wpdb->posts
	          WHERE post_status = 'publish'
		  AND post_type = 'post'
		  ORDER BY post_date
		  DESC LIMIT 1";

	$latest_post_date = $wpdb->get_var( $wpdb->prepare( $query ) );

	// Check if latest post is older than three days.
	// If it is, send email reminder.
	if ( strtotime( $latest_post_date ) <= strtotime( '-3 days' ) ) {

		$email   = 'example@example.com';
		$subject = 'Blog Reminder';
		$message = 'Hey! You have not written a blog post in three days!';

		wp_mail( $email, $subject, $message );
	}
}
