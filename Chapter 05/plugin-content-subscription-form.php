<?php
/**
 * Plugin Name: Content Subscription Form
 * Plugin URI:  http://example.com/
 * Description: Displays a subscription form at the end of the post content.
 * Author:      WROX
 * Author URI:  http://wrox.com
 */

add_filter( 'the_content', 'pdev_content_subscription_form', PHP_INT_MAX );

function pdev_content_subscription_form( $content ) {

	if ( is_singular( 'post' ) && in_the_loop() ) {

		$content .= '<div class="pdev-subscription">
			<p>Thank you for reading. Please subscribe to my email list for updates.</p>
			<form method="post">
				<p>
					<label>
						Email:
						<input type="email" value="" />
					</label>
				</p>
				<p>
					<input type="submit" value="Submit" />
				</p>
			</form>
		</div>';
	}

	return $content;
}
