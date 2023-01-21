<?php
/**
 * Plugin Name: PDEV Alert Box
 * Plugin URI: https://example.com
 * Description: A plugin example that places two input buttons in the blog footer that when clicked display an alert box.
 * Version: 0.1
 * Author: WROX
 * Author URI: https://wrox.com
 */

/* Add the translation function after the plugins loaded hook. */
add_action( 'plugins_loaded', 'pdev_alert_box_load_translation' );
             
/**
 * Loads a translation file if the paged being viewed isn't in the admin.
 *
 * @since 0.1
 */
function pdev_alert_box_load_translation() {
             
    /* If we're not in the admin, load any translation of our plugin. */
    if ( !is_admin() )
       load_plugin_textdomain( 'pdev-alert-box', false, 'pdev-alert-box/languages' );
}

/* Add our script function to the print scripts action. */
add_action( 'wp_print_scripts', 'pdev_alert_box_load_script' );
             
/**
 * Loads the alert box script and localizes text strings that need translation.
 *
 * @since 0.1
 */
function pdev_alert_box_load_script() {
             
    /* If we're in the WordPress admin, don't go any farther. */
    if ( is_admin() )
        return;
             
    /* Get script path and file name. */
    $script = trailingslashit( plugins_url( 'pdev-alert-box' ) ) .'pdev-alert-box-script.js';
             
    /* Enqueue our script for use. */
    wp_enqueue_script( 'pdev-alert-box', $script, false, 0.1 );
             
    /* Localize text strings used in the JavaScript file. */
    wp_localize_script( 'pdev-alert-box', 'pdev_alert_box_L10n', array(
        'pdev_box_1' => __( 'Alert boxes are annoying!', 'pdev-alert-box' ),
        'pdev_box_2' => __( 'They are really annoying!', 'pdev-alert-box' ),
    ) );
}

/* Add our alert box buttons to the site footer. */
add_action( 'wp_footer', 'pdev_alert_box_display_buttons' );
             
/**
 * Displays two input buttons with a paragraph.  Each button has an onClick()
 * event that loads a JavaScript alert box.
 *
 * @since 0.1
 */
function pdev_alert_box_display_buttons() {
             
    /* Get the HTML for the first input button. */
    $pdev_alert_box_buttons = '<input type="button" onclick="pdev_show_alert_box_1()"
    value="' . esc_attr__( 'Press me!', 'pdev-alert-box' ) . '" />';
             
    /* Get the HTML for the second input button. */
    $pdev_alert_box_buttons .= '<input type="button" onclick="pdev_show_alert_box_2()"
    value="' . esc_attr__( 'Now press me!', 'pdev-alert-box' ) . '" />';
             
    /* Wrap the buttons in a paragraph tag. */
    echo '<p>' . $pdev_alert_box_buttons . '</p>';
}
             
