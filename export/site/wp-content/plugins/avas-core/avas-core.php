<?php
/*
Plugin Name: Avas Core
Plugin URI: https://1.envato.market/mPA2X
Description: This plugin for Avas WordPress theme only. To use Avas theme properly you must activate this plugin.
Author: theme-x
Version: 6.6.2
Author URI: https://avas.live/
Text Domain: avas-core
*/

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

$plugin_data = get_file_data(__FILE__, array('Version' => 'Version'), false);
$plugin_version = $plugin_data['Version'];

// Plugin Version
define('TX_PLUGIN_VERSION', $plugin_version);

// Plugin Path
define( 'TX_PLIUGIN__FILE__', __FILE__ );
define( 'TX_PLUGIN_PATH', plugin_dir_path( TX_PLIUGIN__FILE__ ) );

// Plugin URL
define( 'TX_PLUGIN_URL', plugins_url( '', __FILE__ ) );

if ( ! defined( 'TX_PLUGIN_ASSEETS' ) ) {
  define('TX_PLUGIN_ASSEETS', TX_PLUGIN_URL.'/assets/');
}


/**
 * Include language
 */
add_action( 'plugins_loaded', 'tx_load_plugin_textdomain' );
function tx_load_plugin_textdomain() {
	load_plugin_textdomain( 'avas-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

/**
 * Include files
 */
include_once ABSPATH . 'wp-admin/includes/plugin.php';

if ( !class_exists( 'ReduxFramework' ) ) :
  require_once TX_PLUGIN_PATH . 'inc/redux-core/framework.php'; // Redux Framework
endif;

require_once TX_PLUGIN_PATH . 'inc/enqueue.php'; // Enqueue
require_once TX_PLUGIN_PATH . 'inc/functions.php'; // Functions
require_once TX_PLUGIN_PATH . 'inc/cpt.php'; // Custom Post Type
require_once TX_PLUGIN_PATH . 'inc/gallery.php'; // for gallery post format
require_once TX_PLUGIN_PATH . 'inc/breadcrumbs.php'; // Breadcrumbs
require_once TX_PLUGIN_PATH . 'inc/social-media.php'; // Social Media
require_once TX_PLUGIN_PATH . 'inc/meta/metaboxes.php'; // Metaboxes
require_once TX_PLUGIN_PATH . 'inc/meta/author-bio.php'; // Author Bio
require_once TX_PLUGIN_PATH . 'inc/meta/post.php'; // Posts meta
require_once TX_PLUGIN_PATH . 'inc/meta/taxonomy.php'; // Posts taxonomy
require_once TX_PLUGIN_PATH . 'inc/meta/service.php'; // Services meta
require_once TX_PLUGIN_PATH . 'inc/meta/portfolio.php'; // Portfolio meta
require_once TX_PLUGIN_PATH . 'inc/meta/team.php'; // Team meta
require_once TX_PLUGIN_PATH . 'inc/widgets/recent-post-widget.php'; // recent-post-widget
require_once TX_PLUGIN_PATH . 'inc/widgets/posts-gallery-widget.php'; // posts-gallery-widget
require_once TX_PLUGIN_PATH . 'inc/widgets/posts-carousel-widget.php'; // posts-carousel-widget
require_once TX_PLUGIN_PATH . 'inc/widgets/category-widget.php'; //  category widget
require_once TX_PLUGIN_PATH . 'inc/widgets/tag-widget.php'; //  Tag widget
require_once TX_PLUGIN_PATH . 'inc/widgets/text-widget.php'; //  Text widget
require_once TX_PLUGIN_PATH . 'inc/duplicator.php'; //  duplicate function for post types

if( is_plugin_active('elementor/elementor.php') ) : 
  require_once TX_PLUGIN_PATH . 'themebuilder/themebuilder.php'; //  themebuilder
endif;

if(is_plugin_active('bbpress/bbpress.php')):
require_once TX_PLUGIN_PATH . 'inc/widgets/bbp-login-widget.php'; //  bbPress login widget
endif;

require_once TX_PLUGIN_PATH . 'inc/handler.php'; // Elementor support handler

/**
 * update checker
 */
require TX_PLUGIN_PATH . 'inc/update/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
  'https://avas.live/avas-core.json',
  __FILE__,
  'avas-core'
);

/* ------------------------------------------------------------------------------
   EOF
--------------------------------------------------------------------------------- */