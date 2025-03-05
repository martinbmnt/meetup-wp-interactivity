<?php
/**
 * Plugin Name:       WP Interactivity Demo Plugin
 * Description:       Example blocks for demonstration purpose at WP MeetUp.
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            Martin Beaumont
 * Author URI:        https://www.martinbeaumont.dev/
 * Text Domain:       wpinteractivitydemo-plugin
 * Domain Path:       /languages
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package WP_Interactivity_Demo
 * @see https://developer.wordpress.org/news/2024/09/how-to-build-a-multi-block-plugin/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_plugin_block_init() {
	register_block_type( __DIR__ . '/build/blocks/posts-with-categories' );
}
add_action( 'init', 'create_block_plugin_block_init' );
