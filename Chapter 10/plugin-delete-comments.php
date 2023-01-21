<?php
/**
 * Plugin Name: Delete Comments
 * Plugin URI:  http://example.com/
 * Description: Deletes old spam or moderated comments on a schedule.
 * Author:      WROX
 * Author URI:  http://wrox.com
 */

function pdev_delete_comments_options() {

	return get_option( 'pdev_delete_comments', [
		'status' => 'spam',
		'days'   => 15
	] );
}

add_action( 'admin_init', 'pdev_delete_comments_init' );

function pdev_delete_comments_init() {

	// Register settings on the discussion screen.
	register_setting(
		'discussion',
		'pdev_delete_comments'
	);

	// Register comment status field.
	add_settings_field(
		'pdev_comment_status',
		'Comment Status to Delete',
		'pdev_comment_status_field',
		'discussion',
		'default'
	);

	// Register days field.
	add_settings_field(
		'pdev_comment_days',
		'Delete Comments Older Than',
		'pdev_comment_days_field',
		'discussion',
		'default'
	);

	// Schedule the cron event if not scheduled.
	if ( ! wp_next_scheduled( 'pdev_delete_comments_event' ) ) {
		wp_schedule_event( time(), 'daily', 'pdev_delete_comments_event' );
	}
}

function pdev_comment_status_field() {

	$options = pdev_delete_comments_options();
	$status  = $options['status']; ?>

	<select name="pdev_delete_comments[status]">
		<option value="spam" <?php selected( $status, 'spam' ); ?>>
			Spam
		</option>
		<option value="moderated" <?php selected( $status, 'moderated' ); ?>>
			Moderated
		</option>
	</select>

<?php }

function pdev_comment_days_field() {

	$options = pdev_delete_comments_options();
	$days    = absint( $options['days'] );

	printf(
		'<input type="number" name="pdev_delete_comments[days]" value="%s">',
		esc_attr( $days )
	);
}

add_action( 'pdev_delete_comments_event', 'pdev_delete_comments_task' );

function pdev_delete_comments_task() {
	global $wpdb;

	$options = pdev_delete_comments_options();
	$status  = $options['status'];
	$days    = absint( $options['days'] );

	// Set default comment_approved value to spam.
	$comment_approved = 'spam';

	// If moderated status, WordPress stores this as '0'.
	if ( 'moderated' !== $status ) {
		$comment_approved = '0';
	}

	// Build and run the query to delete comments.
	$sql = "DELETE FROM $wpdb->comments
	        WHERE ( comment_approved = '$comment_approved' )
		AND DATEDIFF( now(), comment_date ) > %d";

	$wpdb->query( $wpdb->prepare( $sql, $days ) );
}

register_deactivation_hook( __FILE__, 'pdev_delete_comments_deactivate' );

function pdev_delete_comments_deactivate() {

	$timestamp = wp_next_scheduled( 'pdev_delete_comments_event' );

	if ( false !== $timestamp ) {
		wp_unschedule_event( $timestamp, 'pdev_delete_comments_event' );
	}
}
