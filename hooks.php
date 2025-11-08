<?php
/*
eastweb.ir information structures. all rights reserved
*/

/* Runs when plugin is activated */
register_activation_hook(CHBOT_DIR."channel-bot-botscript.php",'botscript_chbot_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook(CHBOT_DIR."channel-bot-botscript.php", 'botscript_chbot_remove' );



/**************************************************************************/
/*Administative Menu*/
add_action( 'admin_menu', 'botscript_chbot_menu' );

/**************************************************************************/
/*wp5 deprecated*/
//add_action( 'post_submitbox_misc_actions', 'chbot_post_submitbox_misc_actions' );

//add_action( 'add_meta_boxes_submit', 'chbot_add_meta_box' );

add_action( 'save_post', 'chbot_save_meta_box_data' );

/***************************************************************************/
//add_action('publish_post', 'chbot_publish',10,2);
//add_action(  'transition_post_status',  'chbot_future_action', 10, 3 );
add_action( 'wp_insert_post', 'chbot_publish' );
/***************************************************************************/

add_action("add_meta_boxes", "add_wpch_meta_box");

add_action('wp_dashboard_setup', 'eastweb_dashboard_rss_widget');
/*AJAX CALLS*/
add_action( 'wp_ajax_wpch_settings', 'eastweb_wpch_settings_ajax' );

add_shortcode ('eastweb_channel_post', 'eastweb_wpch_shortcode');
add_action( 'widgets_init', 'eastweb_register_wpch_widget' );
add_action( 'wp_footer', 'eastweb_telegram_floating_button_wpch');
?>