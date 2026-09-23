<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * TX_Templates_Library setup
 *
 * @since 1.0
 */
class TX_Templates_Library {

	/**
	** Constructor
	*/
	public function __construct() {

		// Register CPTs
		add_action( 'init', [ $this, 'register_templates_library_cpt' ] );
		add_action( 'template_redirect', [ $this, 'block_template_frontend' ] );

		// Init Theme Builder
		require_once TX_PLUGIN_PATH . 'themebuilder/classes/render_templates.php';

		// Template Actions
		require_once TX_PLUGIN_PATH . 'themebuilder/classes/templates_actions.php';

		// Enable Elementor for 'tx_templates'
		$this->add_elementor_cpt_support();

	}

	/**
	** Register Templates Library
	*/
	public function redirect_to_options_page() {
		if ( get_current_screen()->post_type == 'tx_templates' && isset($_GET['action']) && $_GET['action'] == 'edit' ) {
				wp_redirect('admin.php?page=tx-theme-builder');
		}
	}

	public function register_templates_library_cpt() {

		$args = array(
			'label'				  => esc_html__( 'Avas Theme Builder', 'avas-core' ),
			'public'              => true,
			'rewrite'             => false,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'show_in_nav_menus'   => false,
			'exclude_from_search' => true,
			'capability_type'     => 'post',
			'hierarchical'        => false,
		);

		register_post_type( 'tx_templates', $args );

		$tax_args = [
			'hierarchical' 		=> true,
			'show_ui' 			=> true,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
			'query_var' 		=> is_admin(),
			'rewrite' 			=> false,
			'public' 			=> false,
		];
		
	    register_taxonomy( 'tx_template_type', 'tx_templates', $tax_args );

	}

	/**
	** Don't display on the frontend for non edit_posts capable users
	*/
	public function block_template_frontend() {
		if ( is_singular( 'tx_templates' ) && ! current_user_can( 'edit_posts' ) ) {
			wp_redirect( site_url(), 301 );
			die;
		}
	}

	/**
	*** Add elementor support for tx_templates.
	**/
	function add_elementor_cpt_support() {
		if ( ! is_admin() ) {
			return;
		}

		$cpt_support = get_option( 'elementor_cpt_support' );
		
		if ( ! $cpt_support ) {
		    update_option( 'elementor_cpt_support', ['post', 'page', 'tx_templates', 'portfolio', 'service', 'team'] );
		} elseif ( ! in_array( 'tx_templates', $cpt_support ) ) {
		    $cpt_support[] = 'tx_templates';
		    update_option( 'elementor_cpt_support', $cpt_support );
		}
	}

}

new TX_Templates_Library();