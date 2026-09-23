<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * TX_Templates_Actions setup
 *
 * @since 1.0
 */
class TX_Templates_Actions {

	/**
	** Constructor
	*/
	public function __construct() {

		// Save Conditions
		add_action( 'wp_ajax_tx_save_template_conditions', [ $this, 'tx_save_template_conditions' ] );

		// Create Template
		add_action( 'wp_ajax_tx_create_template', [ $this, 'tx_create_template' ] );

		// Reset Template
		add_action( 'wp_ajax_tx_delete_template', [ $this, 'tx_delete_template' ] );	

	}

	/**
	** Save Template Conditions
	*/
	public function tx_save_template_conditions() {

		$nonce = $_POST['nonce'];

		if ( !wp_verify_nonce( $nonce, 'tx-theme-builder-js')  || !current_user_can( 'manage_options' ) ) {
		  exit; // Get out of here, the nonce is rotten!
		}

		$template = isset($_POST['template']) ? sanitize_text_field(wp_unslash($_POST['template'])): false;

		// Header
		if ( isset($_POST['tx_header_conditions']) ) {
			update_option( 'tx_header_conditions', $this->sanitize_conditions($_POST['tx_header_conditions']) );  // phpcs:ignore

			
		}

		// Footer
		if ( isset($_POST['tx_footer_conditions']) ) {
			update_option( 'tx_footer_conditions', $this->sanitize_conditions($_POST['tx_footer_conditions']) );  // phpcs:ignore

			
		}

		// Archive
		if ( isset($_POST['tx_archive_conditions']) ) {
			update_option( 'tx_archive_conditions', $this->sanitize_conditions($_POST['tx_archive_conditions']) );  // phpcs:ignore
		}

		// Single
		if ( isset($_POST['tx_single_conditions']) ) {
			update_option( 'tx_single_conditions', $this->sanitize_conditions($_POST['tx_single_conditions']) );  // phpcs:ignore
		}

	}

	public function sanitize_conditions( $data ) {
		return wp_unslash( json_encode( array_filter( json_decode(stripcslashes($data), true) ) ) );
	}

	/**
	** Create Template
	*/
	public function tx_create_template() {

		$nonce = $_POST['nonce'];

		if ( !wp_verify_nonce( $nonce, 'tx-theme-builder-js')  || !current_user_can( 'manage_options' ) ) {
		  exit; // Get out of here, the nonce is rotten!
		}

		$user_template_type = isset($_POST['user_template_type']) ? sanitize_text_field(wp_unslash($_POST['user_template_type'])): false;
		$user_template_library = isset($_POST['user_template_library']) ? sanitize_text_field(wp_unslash($_POST['user_template_library'])): false;
		$user_template_title = isset($_POST['user_template_title']) ? sanitize_text_field(wp_unslash($_POST['user_template_title'])): false;
		$user_template_slug = isset($_POST['user_template_slug']) ? sanitize_text_field(wp_unslash($_POST['user_template_slug'])): false;
		
		$check_post_type =( $user_template_library == 'tx_templates' );

		if ( $user_template_title && $check_post_type ) {
			// Create
			$template_id = wp_insert_post(array (
				'post_type' 	=> $user_template_library,
				'post_title' 	=> $user_template_title,
				'post_name' 	=> $user_template_slug,
				'post_content' 	=> '',
				'post_status' 	=> 'publish'
			));

			// Set Types
			if ( 'tx_templates' === $_POST['user_template_library'] ) {

				wp_set_object_terms( $template_id, [$user_template_type, 'user'], 'tx_template_type' );

					if ( 'header' === $_POST['user_template_type'] ) {
						update_post_meta( $template_id, '_elementor_template_type', 'tx-theme-builder-header' );
					} elseif ( 'footer' === $_POST['user_template_type'] ) {
						update_post_meta( $template_id, '_elementor_template_type', 'tx-theme-builder-footer' );
					} else {
						update_post_meta( $template_id, '_elementor_template_type', 'tx-theme-builder' );
					}

					update_post_meta( $template_id, '_tx_template_type', $user_template_type );

			} else {
				update_post_meta( $template_id, '_elementor_template_type', 'page' );
			}

			// Set Canvas Template
			update_post_meta( $template_id, '_wp_page_template', 'elementor_canvas' ); //tmp - maybe set for tx_templates only

			// Send ID to JS
			echo esc_html($template_id);
		}
	}

	/**
	** Reset Template
	*/
	public function tx_delete_template() {

		$nonce = $_POST['nonce'];

		if ( !wp_verify_nonce( $nonce, 'delete_post-' . $_POST['template_slug'] )  || !current_user_can( 'manage_options' ) ) {
		  exit; // Get out of here, the nonce is rotten!
		}

		$template_slug = isset($_POST['template_slug']) ? sanitize_text_field(wp_unslash($_POST['template_slug'])): '';
		$template_library = isset($_POST['template_library']) ? sanitize_text_field(wp_unslash($_POST['template_library'])): '';

		$post = get_page_by_path( $template_slug, OBJECT, $template_library );

		if ( get_post_type($post->ID) == 'tx_templates' ) {
			wp_delete_post( $post->ID, true );
		}
	}

	

	
}


new TX_Templates_Actions();