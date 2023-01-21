<?php
/**
 * Plugin Name: Advanced Dashboard Widget
 * Plugin URI:  http://example.com/
 * Description: Example plugin of a advanced dashboard widget with options.
 * Author:      WROX
 * Author URI:  http://wrox.com
 */

add_action( 'wp_dashboard_setup', 'pdev_advanced_dashboard_register' );

// Registers dashboard widgets.
function pdev_advanced_dashboard_register() {

	wp_add_dashboard_widget(
		'pdev-advanced-dashboard',
		'Custom Feed',
		'pdev_advanced_dashboard_display',
		'pdev_advanced_dashboard_control'
	);
}

// Dashboard widget callback.
function pdev_advanced_dashboard_display() {

	// Get widget option.
	$feed_url = get_option( 'pdev_dashboard_feed_url' );

	// If no feed, set to the WordPress.org news feed.
	if ( ! $feed_url ) {
		$feed_url = 'https://wordpress.org/news/feed';
	}

	// Open HTML wrapper.
	echo '<div class="rss-widget">';

	// Output RSS feed list.
	wp_widget_rss_output(
		esc_url_raw( $feed_url ),
		[
			'title'        => 'RSS Feed News',
			'items'        => 5,
			'show_summary' => true,
			'show_author'  => false,
			'show_date'    => true
		]
	);

	// Close HTML wrapper.
	echo '</div>';
}

// Dashboard widget control callback.
function pdev_advanced_dashboard_control() {

	// Check if option is set before saving.
	if ( isset( $_POST['pdev_dashboard_feed_url'] ) ) {

		// Update database option.
		update_option(
			'pdev_dashboard_feed_url',
			esc_url_raw( $_POST['pdev_dashboard_feed_url'] )
		);
	}

	// Get widget option.
	$feed_url = get_option( 'pdev_dashboard_feed_url' ); ?>

	<p>
		<label>
			RSS Feed URL:
			<input
				type="text"
				name="pdev_dashboard_feed_url"
				class="widefat"
				value="<?php echo esc_url( $feed_url ); ?>"
			/>
		</label>
	</p>
<?php }
