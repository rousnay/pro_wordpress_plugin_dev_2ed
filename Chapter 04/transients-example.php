<?php
// Fetches video from third-party website.
function pdev_fetch_video_title() {
	// Connect to an API to fetch video.
	return $title;
}

// Returns the video title.
function pdev_get_video_title() {

	// Get transient.
	$title = get_transient( 'pdev_video_tutorial' );

	// If the transient doesn't exist or is expired, refresh it.
	if ( ! $title ) {
		$title = pdev_fetch_video_title();

		set_transient( 'pdev_video_tutorial', $title, DAY_IN_SECONDS );
	}

	return $title;
}
