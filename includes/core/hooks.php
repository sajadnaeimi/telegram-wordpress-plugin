<?php
/**
 * Hooks and Actions for Telegram Channel Bot
 *
 * @package Telegram_Channel_Bot
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**************************************************************************/
/* Administrative Menu */
add_action( 'admin_menu', 'botscript_chbot_menu' );

/**************************************************************************/
/* Meta Box and Save Actions */
add_action( 'save_post', 'chbot_save_meta_box_data' );

/***************************************************************************/
/* Publishing Actions */
add_action( 'wp_insert_post', 'chbot_publish' );
/***************************************************************************/

add_action("add_meta_boxes", "add_wpch_meta_box");

/* AJAX CALLS */
add_action( 'wp_ajax_wpch_settings', 'eastweb_wpch_settings_ajax' );

add_shortcode ('telegram_channel_post', 'eastweb_wpch_shortcode');
add_action( 'widgets_init', 'eastweb_register_wpch_widget' );
add_action( 'wp_footer', 'eastweb_telegram_floating_button_wpch');
