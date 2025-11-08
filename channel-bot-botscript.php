<?php
/*
Plugin Name: کانال خودکار تلگرام
Plugin URI: http://eastweb.ir/wp-channel-plugin
Description: ارسال خودکار تمامی نوشته های ارسالی شما به کانال های تلگرامی تان.
Version: 5.2.1
Author: Eastweb
Author URI: http://eastweb.ir
License: GPL
*/
$chbot_ver=5.21;
define('CHBOT_VER',"5.21");
define('CHBOT_CNT',"مشاهده مطلب");
define('CHBOT_EMOJI',".");
define('CHBOT_DIR_NAME',dirname(__FILE__));
defined('CHBOT_DIR') or define('CHBOT_DIR',  dirname(__FILE__).DIRECTORY_SEPARATOR);

require_once(CHBOT_DIR."functions.php");

require_once(CHBOT_DIR."admin".DIRECTORY_SEPARATOR."setting.php");

require_once(CHBOT_DIR."hooks.php");
?>