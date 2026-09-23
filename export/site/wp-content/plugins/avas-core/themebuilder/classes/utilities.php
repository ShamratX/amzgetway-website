<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Utilities {

	/**
	** Get Library Template ID
	*/
	public static function get_template_id( $slug ) {
		
		if( $slug ):
			$template = get_page_by_path( $slug, OBJECT, 'tx_templates' );
		endif;

        return isset( $template->ID ) ? $template->ID : false;
	}

	/**
	** Get Available Custom Post Types or Taxonomies
	*/
	public static function get_custom_types_of( $query, $exclude_defaults = true ) {
		// Taxonomies
		if ( 'tax' === $query ) {
			$custom_types = get_taxonomies( [ 'show_in_nav_menus' => true ], 'objects' );
		
		// Post Types
		} else {
			$custom_types = get_post_types( [ 'show_in_nav_menus' => true ], 'objects' );
		}

		$custom_type_list = [];

		foreach ( $custom_types as $key => $value ) {
			if ( $exclude_defaults ) {
				if ( $key != 'post' && $key != 'page' && $key != 'category' && $key != 'post_tag' ) {
					$custom_type_list[ $key ] = $value->label;
				}
			} else {
				$custom_type_list[ $key ] = $value->label;
			}
		}

		return $custom_type_list;
	}

	/**
	** Get Elementor Template Type
	*/
	public static function get_elementor_template_type( $id ) {
		$post_meta = get_post_meta($id);
		$template_type = isset($post_meta['_elementor_template_type'][0]) ? $post_meta['_elementor_template_type'][0] : false;

        return $template_type;
	}

	/**
	** Render Elementor Template
	*/
	public static function render_elementor_template( $slug ) {
		$template_id = Utilities::get_template_id( $slug );
		$get_elementor_content = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $template_id, false );

		if ( '' === $get_elementor_content ) {
			return;
		}

    	// Render Elementor Template Content
		echo ''. $get_elementor_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}	

	/**
	** Theme Builder Template Check
	*/
	public static function is_theme_builder_template() {
		$current_page = get_post(get_the_ID());

		if ( $current_page ) {
			return strpos($current_page->post_name, 'user-archive') !== false || strpos($current_page->post_name, 'user-single') !== false || strpos($current_page->post_name, 'user-product') !== false;
		} else {
			return false;
		}
	}

	/**
	** Blog Archive Page Check
	*/
	public static function is_blog_archive() {
		$result = false;
		$front_page = get_option( 'page_on_front' );
		$posts_page = get_option( 'page_for_posts' );

		if ( is_home() && '0' === $front_page && '0' === $posts_page || (intval($posts_page) === get_queried_object_id() && !is_404()) ) {
			$result = true;
		}

		return $result;
	}

	/**
    ** Get Library Template Slug
    */
	public static function get_template_slug( $data, $page, $post_id = '' ) {
		if ( is_null($data) ) {
			return;
		}
		
		$template = NULL;

		// Find a Custom Condition
		foreach( $data as $id => $conditions ) {

			if ( in_array( $page .'/'. $post_id, $conditions) ) {

				$template = $id;
			} elseif ( in_array( $page .'/all', $conditions) ) {
				$template = $id;
			} elseif ( in_array( $page, $conditions) ) {
				$template = $id;
			}
		}

		// If a Custom NOT Found, use Global
		if ( is_null($template) ) {
			foreach( $data as $id => $conditions ) {
				if ( in_array( 'global', $conditions) ) {
					$template = $id;
				}
			}
		}

		// tmp remove after 2 months
		$templates_loop = new \WP_Query([
			'post_type' => 'tx_templates',
			'name' => $template,
			'posts_per_page' => 1,
		]);
		
		if ( ! $templates_loop->have_posts() ) {
			return null;
		} else {
			return $template;
		}
	}

	/**
	** Get Template Type
	*/
	public static function get_tx_template_type( $id ) {
		$post_meta = get_post_meta($id);
		$template_type = isset($post_meta['_tx_template_type'][0]) ? $post_meta['_tx_template_type'][0] : false;

        return $template_type;
	}

	

}

new Utilities();