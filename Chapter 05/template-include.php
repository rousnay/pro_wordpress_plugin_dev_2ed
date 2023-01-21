<?php
add_filter( 'template_include', 'pdev_template_include' );

function pdev_template_include( $template ) {

	if ( is_post_type_archive( 'movie' ) ) {

		$template = locate_template( 'pdev-movie-archive.php' );

		if ( ! $locate ) {
			$template = require_once plugin_dir_path( __FILE__ )
			            . 'templates/pdev-movie-archive.php';
		}

	} elseif ( is_singular( 'movie' ) ) {

		$template = locate_template( 'pdev-single-movie.php' );

		if ( ! $locate ) {
			$template = require_once plugin_dir_path( __FILE__ )
			            . 'templates/pdev-single-movie.php';
		}
	}

	return $template;
}
