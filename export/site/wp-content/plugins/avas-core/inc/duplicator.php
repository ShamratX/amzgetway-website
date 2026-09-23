<?php

use Elementor\Core\Files\CSS\Post as Post_CSS;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Post_Duplicator {
	public function __construct() {

		add_filter( 'admin_action_tx_duplicate', array( $this, 'tx__duplicate' ) );
		add_filter( 'post_row_actions', array( $this, 'row_actions' ), 10, 2 );
		add_filter( 'page_row_actions', array( $this, 'row_actions' ), 10, 2 );

	}


	/**
	 *  Duplicator Button added in table row
	 *
	 * @param array $actions
	 * @param WP_Post $post
	 *
	 * @return array
	 */
	public function row_actions( $actions, $post ) {

		if ( current_user_can( 'edit_posts' ) ) {
			$duplicate_url            = admin_url( 'admin.php?action=tx_duplicate&post=' . $post->ID );
			$duplicate_url            = wp_nonce_url( $duplicate_url, 'tx_duplicator' );
			$actions['tx_duplicate']  = sprintf( '<a href="%s" title="%s">%s</a>', $duplicate_url, esc_html__( 'Duplicate ' . esc_attr( $post->post_title ), 'avas-core' ), esc_html__( 'Duplicate', 'avas-core' ) );
		}

		return $actions;
	}

	/**
	 * Duplicate a post
	 * @return void
	 */
	public function tx__duplicate() {

		$nonce   = isset( $_REQUEST['_wpnonce'] ) && ! empty( $_REQUEST['_wpnonce'] ) ? $_REQUEST['_wpnonce'] : null;
		$post_id = isset( $_REQUEST['post'] ) && ! empty( $_REQUEST['post'] ) ? intval( $_REQUEST['post'] ) : null;
		$action  = isset( $_REQUEST['action'] ) && ! empty( $_REQUEST['action'] ) ? trim( sanitize_text_field( $_REQUEST['action'] ) ) : null;

		if ( is_null( $nonce ) || is_null( $post_id ) || $action !== 'tx_duplicate' ) {
			return; // Return if action is not tx_duplicate
		}

		if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'tx_duplicator' ) ) {
			return; // Return if nonce is not valid
		}

		$post = sanitize_post( get_post( $post_id ), 'db' );

		if ( is_null( $post ) ) {
			return; // Return if post is not there.
		}

		$current_user	= wp_get_current_user();
		$allowed_roles	= array('editor', 'administrator', 'author');
		$redirect_url = admin_url( 'edit.php?post_type=' . $post->post_type );

		if ( ! array_intersect( $allowed_roles, $current_user->roles ) ) {
			switch ( $post->post_type ) {
				case 'post':
					$can_edit_others_posts = current_user_can('edit_others_posts');
					break;
				case 'page':
					$can_edit_others_posts = current_user_can('edit_others_pages');
					break;
				default :
					$can_edit_others_posts = current_user_can('edit_others_posts');
					break;
			}

			if ( $current_user->ID !== $post->post_author && ! $can_edit_others_posts ){
				wp_safe_redirect( $redirect_url );
				return;
			}
		}

		$duplicate_post_args = array(
			'post_author'    => $current_user->ID,
			'post_title'     => sprintf(__('%1$s - [Duplicated]', 'avas-core'), $post->post_title),
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_parent'    => $post->post_parent,
			'post_status'    => 'draft',
			'ping_status'    => $post->ping_status,
			'comment_status' => $post->comment_status,
			'post_password'  => $post->post_password,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order,
		);
		$duplicated_id       = wp_insert_post( $duplicate_post_args );

		if ( ! is_wp_error( $duplicated_id ) ) {
			$taxonomies = get_object_taxonomies( $post->post_type );
			if ( ! empty( $taxonomies ) && is_array( $taxonomies ) ) {
				foreach ( $taxonomies as $taxonomy ) {
					$post_terms = wp_get_object_terms( $post_id, $taxonomy, array( 'fields' => 'slugs' ) );
					wp_set_object_terms( $duplicated_id, $post_terms, $taxonomy, false );
				}
			}

			global $wpdb;
			$post_meta = $wpdb->get_results( $wpdb->prepare( "SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id = %d", $post_id ) );

			if ( ! empty( $post_meta ) && is_array( $post_meta ) ) {

				$duplicate_insert_query = "INSERT INTO $wpdb->postmeta ( post_id, meta_key, meta_value ) VALUES ";
				$insert = '';

				foreach ( $post_meta as $meta_info ) {

					$meta_key      = sanitize_text_field( $meta_info->meta_key );
					$meta_value    =  $meta_info->meta_value;

					if ( $meta_key === '_elementor_template_type' ) {
						delete_post_meta( $duplicated_id, '_elementor_template_type' );
					}
					
					if ( ! empty( $insert ) ) {
						$insert .= ', ';
					}

					$insert .= $wpdb->prepare( '(%d, %s, %s)', $duplicated_id, $meta_key, $meta_value );
				}

				$wpdb->query( $duplicate_insert_query . $insert );
			}

				$css = Post_CSS::create($duplicated_id);
                $css->update();

		}

		wp_safe_redirect( $redirect_url );
	}
}

new Post_Duplicator();