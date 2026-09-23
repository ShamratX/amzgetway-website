<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once TX_PLUGIN_PATH . 'themebuilder/classes/utilities.php'; //  utilities
require_once TX_PLUGIN_PATH . 'themebuilder/classes/conditions_manager.php'; //  tx_conditions_manager

/**
 * Render Templates setup
 *
 */
class TX_Render_Templates {

	/**
	** Constructor
	*/
	public function __construct($only_hf = false) {

		// Elementor Frontend
		add_action( 'wp', [ $this, 'global_compatibility' ] );

		// Scripts and Styles
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

		// Theme Builder
		if ( !$only_hf ) { // Prevent Loading in Header or Footer Templates
			add_filter( 'template_include', [ $this, 'convert_to_canvas' ], 12 ); // 12 after WP Pages and WooCommerce.
			add_action( 'elementor/page_templates/canvas/tx_print_content', [ $this, 'canvas_page_content_display' ] );
		}
	}

	public function global_compatibility() {
		add_action( 'get_header', [ $this, 'replace_header' ] );

		add_action( 'get_footer', [ $this, 'replace_footer' ] );
	}

    /**
    ** Check if a Template has Conditions
    */
	public function is_template_available( $type ) {
    	if ( 'content' === $type ) {
			return !is_null(TX_Conditions_Manager::canvas_page_content_display_conditions()) ? true : false;
    	} else {
    		$conditions = json_decode( get_option('tx_'. $type .'_conditions', '[]'), true );
    		$template = TX_Conditions_Manager::header_footer_display_conditions( $conditions );
    		return (!empty( $conditions ) && !is_null($template)) ? true : false;
    	}
	}

    /**
    ** Header
    */
    public function replace_header() {
    	if ( $this->is_template_available('header') ) {
    		require TX_PLUGIN_PATH . 'themebuilder/theme-header.php';
			$templates   = [];
			$templates[] = 'header.php';
			
			remove_all_actions( 'wp_head' ); // Avoid running wp_head hooks again.

			ob_start();
			locate_template( $templates, true );
			ob_get_clean();
        }
    }

	/**
	** Footer
	*/
	public function replace_footer() {
    	if ( $this->is_template_available('footer') ) {
    		require TX_PLUGIN_PATH . 'themebuilder/theme-footer.php';
			$templates   = [];
			$templates[] = 'footer.php';
			
			remove_all_actions( 'wp_footer' ); // Avoid running wp_footer hooks again.

			ob_start();
			locate_template( $templates, true );
			ob_get_clean();
        }
	}

    public function convert_to_canvas( $template ) {
    	$is_theme_builder_edit = \Elementor\Plugin::$instance->preview->is_preview_mode() && Utilities::is_theme_builder_template() ? true : false;
    	$_wp_page_template = get_post_meta(get_the_ID(), '_wp_page_template', true);

    	if ( $this->is_template_available('content') || $is_theme_builder_edit ) {
    		if ( (is_page() || is_single()) && 'elementor_canvas' === $_wp_page_template && !$is_theme_builder_edit ) {
    			return $template;
    		} else {
    			return TX_PLUGIN_PATH . 'themebuilder/canvas.php';
    		}
    	} else {
    		return $template;
    	}
    }

	/**
	** Theme Builder Content Display
	*/
	public function canvas_page_content_display() {
		// Get Template
		$template = TX_Conditions_Manager::canvas_page_content_display_conditions();

		// Display Template
		Utilities::render_elementor_template( $template );
	}

	/**
	 * Enqueue styles and scripts.
	 */
	public function enqueue_scripts() {

		if ( class_exists( '\Elementor\Plugin' ) ) {
			$elementor = \Elementor\Plugin::instance();
			$elementor->frontend->enqueue_styles();
		}

		if ( class_exists( '\ElementorPro\Plugin' ) ) {
			$elementor_pro = \ElementorPro\Plugin::instance();
			$elementor_pro->enqueue_styles();
		}

		// Load Header Template CSS File
		$heder_conditions = json_decode( get_option('tx_header_conditions', '[]'), true );
		$header_template_id = Utilities::get_template_id(TX_Conditions_Manager::header_footer_display_conditions($heder_conditions));

		if ( false !== $header_template_id ) {
			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				$header_css_file = new \Elementor\Core\Files\CSS\Post( $header_template_id );
			} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
				$header_css_file = new \Elementor\Post_CSS_File( $header_template_id );
			}

			$header_css_file->enqueue();
		}

		// Load Footer Template CSS File
		$footer_conditions = json_decode( get_option('tx_footer_conditions', '[]'), true );
		$footer_template_id = Utilities::get_template_id(TX_Conditions_Manager::header_footer_display_conditions($footer_conditions));

		if ( false !== $footer_template_id ) {
			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				$footer_css_file = new \Elementor\Core\Files\CSS\Post( $footer_template_id );
			} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
				$footer_css_file = new \Elementor\Post_CSS_File( $footer_template_id );
			}

			$footer_css_file->enqueue();
		}

		// Load Canvas Content Template CSS File
		$canvas_template_id = Utilities::get_template_id(TX_Conditions_Manager::canvas_page_content_display_conditions());

		if ( false !== $canvas_template_id ) {
			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				$footer_css_file = new \Elementor\Core\Files\CSS\Post( $canvas_template_id );
			} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
				$footer_css_file = new \Elementor\Post_CSS_File( $canvas_template_id );
			}

			$footer_css_file->enqueue();
		}
	}

}

new TX_Render_Templates();