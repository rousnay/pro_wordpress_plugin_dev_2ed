<?php
/**
 * Plugin Name: Clean Revisions
 * Plugin URI:  http://example.com/
 * Description: Removes post revisions older than 30 days every week.
 * Author:      WROX
 * Author URI:  http://wrox.com
 */

register_activation_hook( __FILE__, 'pdev_clean_rev_activate' );

function pdev_clean_rev_activate() {

	if ( ! wp_next_scheduled( 'pdev_clean_rev_event' ) ) {
		wp_schedule_event( time(), 'weekly', 'pdev_clean_rev_event' );
	}
}

register_deactivation_hook( __FILE__, 'pdev_clean_rev_deactivate' );

function pdev_clean_rev_deactivate() {

	$timestamp = wp_next_scheduled( 'pdev_clean_rev_event' );

	if ( false !== $timestamp ) {
		wp_unschedule_event( $timestamp, 'pdev_clean_rev_event' );
	}
}

add_filter( 'cron_schedules', 'pdev_clean_rev_cron_schedules' );

function pdev_clean_rev_cron_schedules( $schedules ) {

	$schedules['weekly'] = [
		'interval' => 604800,
		'display'  => 'Once Weekly'
	];

	return $schedules;
}

add_action( 'pdev_clean_rev_event', 'pdev_clean_rev_delete' );

function pdev_clean_rev_delete() {
	global $wpdb;

	$sql = "DELETE a,b,c
	        FROM $wpdb->posts array
		LEFT JOIN $wpdb->term_relationships b ON (a.ID = b.object_id)
		LEFT JOIN $wpdb->postmeta c ON (a.ID = c.post_id)
		WHERE a.post_type = 'revision'
		AND DATEDIFF( now(), a.post_modified ) > 30";

	$wpdb->query( $wpdb->prepare( $sql ) );
}
