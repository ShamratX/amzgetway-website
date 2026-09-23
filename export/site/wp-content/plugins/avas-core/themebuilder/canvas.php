<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once TX_PLUGIN_PATH . 'themebuilder/classes/utilities.php'; //  utilities

\Elementor\Plugin::$instance->frontend->add_body_class( 'elementor-template-canvas' );

$is_preview_mode = \Elementor\Plugin::$instance->preview->is_preview_mode();

get_header();

	Elementor\Modules\PageTemplates\Module::body_open();
	/**
	 * Before canvas page template content.
	 *
	 * Fires before the content of Elementor canvas page template.
	 *
	 * @since 6.4
	 */
	do_action( 'elementor/page_templates/canvas/before_content' );

	// Elementor Editor
	if (( \Elementor\Plugin::$instance->preview->is_preview_mode() && Utilities::is_theme_builder_template()) ) {
	     \Elementor\Plugin::$instance->modules_manager->get_modules( 'page-templates' )->print_content();

	// Frontend
	} else {
		// Display Custom Elementor Templates
		do_action( 'elementor/page_templates/canvas/tx_print_content' );
	}

	/**
	 * After canvas page template content.
	 *
	 * Fires after the content of Elementor canvas page template.
	 *
	 * @since 1.0.0
	 */
	do_action( 'elementor/page_templates/canvas/after_content' );

	get_footer();