<?php
/**
 * Plugin Name: Remove Bad Words
 * Plugin URI:  http://example.com/
 * Description: Removes bad words from the post title and content.
 * Author:      WROX
 * Author URI:  http://wrox.com
 */

add_filter( 'the_title',   'pdev_remove_bad_words' );
add_filter( 'the_content', 'pdev_remove_bad_words' );

function pdev_remove_bad_words( $text ) {

	$words = [];

	if ( 'the_title' === current_filter() ) {
		$words = [
			'bad_word_a',
			'bad_word_b'
		];
	} elseif ( 'the_content' === current_filter() ) {
		$words = [
			'bad_word_c',
			'bad_word_d'
		];
	}

	if ( $words ) {
		$text = str_replace( $words, '***', $text );
	}

	return $text;
}
