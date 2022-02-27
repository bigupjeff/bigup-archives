<?php
/**
 * Plugin Name: Bigup: Archives
 * Plugin URI: https://jeffersonreal.com
 * Description: An archive list menu widget.
 * Version: 0.2
 * Author: Jefferson Real
 * Author URI: https://jeffersonreal.com
 * License: GPL2
 *
 * @package bigup_archives
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 * @license GPL2+
 */

/*
 * Init the plugin (enqueue scripts and styles)
 *
function bigup_archives_scripts_and_styles() {
    wp_register_style( 'bigup_archives_widget_css', plugins_url ( 'css/widget.css', __FILE__ ), array(), '0.1', 'all' );
}
add_action( 'wp_enqueue_scripts', 'bigup_archives_scripts_and_styles' );
*/


/**
* Init the widget
*/
include( plugin_dir_path( __FILE__ ) . 'parts/widget.php');
