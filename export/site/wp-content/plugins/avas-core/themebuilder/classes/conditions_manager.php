<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once TX_PLUGIN_PATH . 'themebuilder/classes/utilities.php'; //  utilities

/**
 * Conditions Manager setup
 *
 * @since 1.0
 */
class TX_Conditions_Manager {

    /**
    ** Header & Footer Conditions
    */
    public static function header_footer_display_conditions( $conditions ) {
        $template = NULL;

        // Archive Pages (includes search)
        if ( !is_null( TX_Conditions_Manager::archive_templates_conditions($conditions) ) ) {
            $template = TX_Conditions_Manager::archive_templates_conditions($conditions);
        }

        // Single Pages
        if ( !is_null( TX_Conditions_Manager::single_templates_conditions($conditions) ) ) {
            $template = TX_Conditions_Manager::single_templates_conditions($conditions);
        }

        if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
        	$template_type = Utilities::get_tx_template_type(get_the_ID());
        	
        	if ( 'header' === $template_type || 'footer' === $template_type ) {
        		$template = NULL;
        	}
        }

        if ( !current_user_can('administrator') && ('maintenance' == get_option('elementor_maintenance_mode_mode') || 'coming_soon' == get_option('elementor_maintenance_mode_mode')) ) {
            $template = NULL;
        }

	    return $template;
    }

    /**
    ** Canvas Content Conditions
    */
    public static function canvas_page_content_display_conditions() {
        $template = NULL;

		$archives = json_decode( get_option( 'tx_archive_conditions' ), true );
		$singles  = json_decode( get_option( 'tx_single_conditions' ), true );

        if ( empty($archives) && empty($singles) ) {
            return NULL;
        }

        // Archive Pages (includes search)
        if ( !is_null( TX_Conditions_Manager::archive_templates_conditions($archives) ) ) {
            $template = TX_Conditions_Manager::archive_templates_conditions($archives);
        }

        // Single Pages
        if ( !is_null( TX_Conditions_Manager::single_templates_conditions($singles) ) ) {
            $template = TX_Conditions_Manager::single_templates_conditions($singles);
        }

	    return $template;
    }


    /**
    ** Archive Pages Templates Conditions
    */
    public static function archive_templates_conditions( $conditions ) {
        $term_id = '';
        $term_name = '';
        $queried_object = get_queried_object();

        // Get Terms
        if ( ! is_null( $queried_object ) ) {
            if ( isset( $queried_object->term_id ) && isset( $queried_object->taxonomy ) ) {
                $term_id   = $queried_object->term_id;
                $term_name = $queried_object->taxonomy;
            }
        }

        // Reset
        $template = NULL;

        // Archive Pages (includes search)
        if ( is_archive() || is_search() ) {
            if ( ! is_search() ) {
                // Author
                if ( is_author() ) {
                    $template = Utilities::get_template_slug( $conditions, 'archive/author' );
                // Date
                } elseif ( is_date() ) {
                    $template = Utilities::get_template_slug( $conditions, 'archive/date' );
                // Category
                } elseif ( is_category() ) {
                    $template = Utilities::get_template_slug( $conditions, 'archive/categories', $term_id );
                // Tag
                } elseif ( is_tag() ) {
                    $template = Utilities::get_template_slug( $conditions, 'archive/tags', $term_id );
                // service archive
                } elseif ( is_post_type_archive('service') ) {
                    $template = Utilities::get_template_slug( $conditions, 'archive/archive-service', $term_id );    
                // service-category
                } elseif ( is_tax('service-category') ) {
                    $template = Utilities::get_template_slug( $conditions, 'archive/service-category', $term_id );
                // portfolio archive
                } elseif ( is_post_type_archive('portfolio') ) {
                    $template = Utilities::get_template_slug( $conditions, 'archive/archive-portfolio', $term_id );                    
                // portfolio-category
                } elseif ( is_tax('portfolio-category') ) {
                    $template = Utilities::get_template_slug( $conditions, 'archive/portfolio-category', $term_id );
                // team archive
                } elseif ( is_post_type_archive('team') ) {
                    $template = Utilities::get_template_slug( $conditions, 'archive/archive-team', $term_id );
                // team-category
                } elseif ( is_tax('team-category') ) {
                    $template = Utilities::get_template_slug( $conditions, 'archive/team-category', $term_id );
                // product archive
                } elseif ( is_post_type_archive('product') ) {
                    $template = Utilities::get_template_slug( $conditions, 'archive/archive-product', $term_id );    
                // product category    
                } elseif ( is_tax('product_cat') ) {
                    $template = Utilities::get_template_slug( $conditions, 'archive/product_cat', $term_id );
                // product tag    
                } elseif ( is_tax('product_tag') ) {
                    $template = Utilities::get_template_slug( $conditions, 'archive/product_tag', $term_id );
                }


            // Search Page
            } else {
                $template = Utilities::get_template_slug( $conditions, 'archive/search' );
            }

        // Posts Page
        } elseif ( Utilities::is_blog_archive() ) {
            $template = Utilities::get_template_slug( $conditions, 'archive/posts' );
        }

        // Global - For All Archives
        if ( is_null($template) ) {
            $all_archives = Utilities::get_template_slug( $conditions, 'archive/all_archives' );

            if ( ! is_null($all_archives) ) {
                if ( class_exists( 'WooCommerce' ) && is_shop() ) {
                    $template = null;
                } else {
                    if ( is_archive() || is_search() || Utilities::is_blog_archive() ) {
                        $template = $all_archives;
                    }
                }
            }
        }

        return $template;
    }

    /**
    ** Single Pages Templates Conditions
    */
    public static function single_templates_conditions( $conditions ) {
        global $post;

        // Get Posts
        $post_id   = is_null($post) ? '' : $post->ID;
        $post_type = is_null($post) ? '' : $post->post_type;

        // Reset
        $template = NULL;

        // Single Pages
        if ( is_single() || is_front_page() || is_page() || is_404() ) {

            if ( is_single() ) {
                // Blog Posts
                if ( 'post' == $post_type ) {
                    $template = Utilities::get_template_slug( $conditions, 'single/posts', $post_id );
                } elseif ( 'portfolio' == $post_type ) {
                    $template = Utilities::get_template_slug( $conditions, 'single/portfolio', $post_id );
                } elseif ( 'service' == $post_type ) {
                    $template = Utilities::get_template_slug( $conditions, 'single/service', $post_id );
                } elseif ( 'team' == $post_type ) {
                    $template = Utilities::get_template_slug( $conditions, 'single/team', $post_id );
                } elseif ( 'product' == $post_type ) {
                    $template = Utilities::get_template_slug( $conditions, 'single/product', $post_id );
                } elseif ( 'tribe_events' == $post_type ) {
                    $template = Utilities::get_template_slug( $conditions, 'single/tribe_events', $post_id );
                } elseif ( 'lp_course' == $post_type ) {
                    $template = Utilities::get_template_slug( $conditions, 'single/lp_course', $post_id );
                } elseif ( 'properties' == $post_type ) {
                    $template = Utilities::get_template_slug( $conditions, 'single/properties', $post_id );
                } 

            } else {
                // Front page
                if ( is_front_page() && ! Utilities::is_blog_archive() ) {
                    $template = Utilities::get_template_slug( $conditions, 'single/front_page' );
                // Error 404 Page
                } elseif ( is_404() ) {
                    $template = Utilities::get_template_slug( $conditions, 'single/page_404' );
                // Single Page
                } elseif ( is_page() ) {
                    $template = Utilities::get_template_slug( $conditions, 'single/pages', $post_id );
                }
            }

        }

        return $template;
    }
}

new TX_Conditions_Manager();