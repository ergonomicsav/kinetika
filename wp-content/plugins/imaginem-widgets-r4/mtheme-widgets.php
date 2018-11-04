<?php
/*
Plugin Name: iMaginem Widget Set r4
Plugin URI: http://www.imaginemthemes.com/plugins/mthemeshortcodes
Description: Imaginem Themes Widget Set.
Version: 1.5
Author: iMaginem
Author URI: http://www.imaginemthemes.com
*/

define('MTHEME_WIDGET_PREFIX', "THEME");
require_once ( plugin_dir_path( __FILE__ ) . 'widgets/image-upload/image-upload-widget.php');
require_once ( plugin_dir_path( __FILE__ ) . 'widgets/instagram-widget.php');
require_once ( plugin_dir_path( __FILE__ ) . 'widgets/sidebar-gallery.php');
require_once ( plugin_dir_path( __FILE__ ) . 'widgets/recent.php');
require_once ( plugin_dir_path( __FILE__ ) . 'widgets/popular.php');
require_once ( plugin_dir_path( __FILE__ ) . 'widgets/social.php');
require_once ( plugin_dir_path( __FILE__ ) . 'widgets/flickr.php');
require_once ( plugin_dir_path( __FILE__ ) . 'widgets/address.php');
require_once ( plugin_dir_path( __FILE__ ) . 'widgets/video.php');
require_once ( plugin_dir_path( __FILE__ ) . 'widgets/portfolio-related-list.php');
require_once ( plugin_dir_path( __FILE__ ) . 'widgets/portfolio-type.php');
require_once ( plugin_dir_path( __FILE__ ) . 'widgets/login_widget.php');
require_once ( plugin_dir_path( __FILE__ ) . 'widgets/event-list.php');
require_once ( plugin_dir_path( __FILE__ ) . 'widgets/event-type.php');
?>