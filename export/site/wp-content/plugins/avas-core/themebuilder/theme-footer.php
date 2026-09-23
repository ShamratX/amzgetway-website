<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once TX_PLUGIN_PATH . 'themebuilder/classes/utilities.php'; //  utilities
require_once TX_PLUGIN_PATH . 'themebuilder/classes/conditions_manager.php'; //  tx_conditions_manager

$conditions = json_decode( get_option('tx_footer_conditions', '[]'), true );
$template_slug = TX_Conditions_Manager::header_footer_display_conditions($conditions);

// Render Header
Utilities::render_elementor_template($template_slug);

wp_footer();