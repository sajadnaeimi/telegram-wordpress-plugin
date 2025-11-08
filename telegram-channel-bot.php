<?php
/**
 * Plugin Name: Telegram Channel Bot
 * Plugin URI: https://github.com/sajadnaeimi/telegram-wordpress-plugin
 * Description: Automatically sends WordPress posts to Telegram channels
 * Version: 6.0.0
 * Author: Community Contributors
 * Author URI: https://github.com/sajadnaeimi
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: telegram-channel-bot
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Define plugin constants
define('TELEGRAM_CHANNEL_BOT_VERSION', '6.0.0');
define('TELEGRAM_CHANNEL_BOT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('TELEGRAM_CHANNEL_BOT_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CHBOT_VER', '6.0.0');
define('CHBOT_DIR', TELEGRAM_CHANNEL_BOT_PLUGIN_DIR);
define('CHBOT_CNT', 'مشاهده مطلب');
define('CHBOT_EMOJI', '.');

// Include core files
require_once TELEGRAM_CHANNEL_BOT_PLUGIN_DIR . 'includes/core/functions.php';
require_once TELEGRAM_CHANNEL_BOT_PLUGIN_DIR . 'includes/core/hooks.php';
require_once TELEGRAM_CHANNEL_BOT_PLUGIN_DIR . 'includes/admin/settings.php';

// Activation and deactivation hooks
register_activation_hook(__FILE__, 'botscript_chbot_install');
register_deactivation_hook(__FILE__, 'botscript_chbot_remove');

// Initialize plugin
add_action('plugins_loaded', 'telegram_channel_bot_init');

function telegram_channel_bot_init() {
    load_plugin_textdomain('telegram-channel-bot', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
