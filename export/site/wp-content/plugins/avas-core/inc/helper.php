<?php
namespace AvasElements;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TX_Helper {

	// get all post types
	static function get_all_post_types() {

    $tx_post_types = get_post_types( array( 'public'   => true, 'show_in_nav_menus' => true ) );
    $tx_exclude_post_types = array( 'elementor_library', 'attachment', 'product', 'lp_course', 'lp_lesson', 'lp_quiz', 'give_forms' );

    foreach ( $tx_exclude_post_types as $exclude_cpt ) {
        unset($tx_post_types[$exclude_cpt]);
    }

    $post_types = array_merge($tx_post_types);
    return $post_types;

	}

    /**
     * Get All Post Types
     * @return array
     */
    public static function tx_get_post_types()
    {
        $post_types = get_post_types(['public' => true, 'show_in_nav_menus' => true], 'objects');
        $post_types = wp_list_pluck($post_types, 'label', 'name');

        return array_diff_key($post_types, ['elementor_library', 'attachment']);
    }

    // get_query_post_list
    public static function get_query_post_list($post_type = 'any', $limit = -1, $search = '')
    {
        global $wpdb;
        $where = '';
        $data = [];

        if (-1 == $limit) {
            $limit = '';
        } elseif (0 == $limit) {
            $limit = "limit 0,1";
        } else {
            $limit = $wpdb->prepare(" limit 0,%d", esc_sql($limit));
        }

        if ('any' === $post_type) {
            $in_search_post_types = get_post_types(['exclude_from_search' => false]);
            if (empty($in_search_post_types)) {
                $where .= ' AND 1=0 ';
            } else {
                $where .= " AND {$wpdb->posts}.post_type IN ('" . join("', '",
                    array_map('esc_sql', $in_search_post_types)) . "')";
            }
        } elseif (!empty($post_type)) {
            $where .= $wpdb->prepare(" AND {$wpdb->posts}.post_type = %s", esc_sql($post_type));
        }

        if (!empty($search)) {
            $where .= $wpdb->prepare(" AND {$wpdb->posts}.post_title LIKE %s", '%' . esc_sql($search) . '%');
        }

        $query = "select post_title,ID  from $wpdb->posts where post_status = 'publish' $where $limit";
        $results = $wpdb->get_results($query);
        if (!empty($results)) {
            foreach ($results as $row) {
                $data[$row->ID] = $row->post_title;
            }
        }
        return $data;
    }

    // Get all Posts
    static function get_all_posts() {

        $post_list = get_posts( array(
            'post_type'         => 'post',
            'orderby'           => 'date',
            'order'             => 'DESC',
            'posts_per_page'    => -1,
        ) );

        $posts = array();

        if ( ! empty( $post_list ) && ! is_wp_error( $post_list ) ) {
            foreach ( $post_list as $post ) {
               $posts[ $post->ID ] = $post->post_title;
            }
        }

        return $posts;
    }

    // Get Post Formats
    static function get_post_format() {
        $terms = get_terms( array( 
            'taxonomy' => 'post_format',
            'hide_empty' => true,
        ));
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
        foreach ( $terms as $term ) {
            $options[ $term->term_id ] = $term->name;
        }
        }
        return $options;
    }

    // Get all Authors
    static function get_all_auhtors() {

            $options = array();

            $users = get_users();

            foreach ( $users as $user ) {
                $options[ $user->ID ] = $user->display_name;
            }

            return $options;
    }

    // Get all user roles
    static function user_roles()
    {
        global $wp_roles;

        $all = $wp_roles->roles;
        $all_roles = array();

        if (!empty($all)) {
            foreach ($all as $key => $value) {
                $all_roles[$key] = $all[$key]['name'];
            }
        }

        return $all_roles;
    }

    // Get all Tags
    static function get_all_tags() {

        $options = array();

        $tags = get_tags();

        foreach ( $tags as $tag ) {
            $options[ $tag->term_id ] = $tag->name;
        }

        return $options;
    }

    // get all registered taxonomies
    static function get_all_taxonomies() {
        $map = array();
        $taxonomies = get_taxonomies();
        foreach ($taxonomies as $taxonomy) {
            $map [$taxonomy] = $taxonomy;
        }
        return $map;
    }

    // get categories from taxonomies
    static function get_post_type_categories($catarg) {

        $categories = get_terms( $catarg );

        $options = [];

        if (is_wp_error($categories)) {
            return $options;
        }

        if (false !== $categories and is_array($categories)) {
            foreach ( $categories as $category ) {
                $options[ $category->slug ] = $category->name;
            }
        }

        return $options;
    }  

	// get all taxonomies
	static function get_all_categories() {

    global $wpdb;

    $results = array();
    foreach ($wpdb->get_results("
        SELECT terms.slug AS 'slug', terms.name AS 'label', termtaxonomy.taxonomy AS 'type'
        FROM $wpdb->terms AS terms
        JOIN $wpdb->term_taxonomy AS termtaxonomy ON terms.term_id = termtaxonomy.term_id
        LIMIT 999
    ") as $result) {
        $results[$result->type . ':' . $result->slug] = $result->type . ':' . $result->label;
    }

    return $results;
	}

    // query arguements setup
	static function setup_query_args($settings, $showposts) {

        if ( get_query_var('paged') ) :
            $paged = get_query_var('paged');
        elseif ( get_query_var('page') ) :
            $paged = get_query_var('page');
        else :
            $paged = 1;
        endif;
        
        if ( $settings['post_sortby'] == 'popularposts' ) {
            $query_args = [
                'order' => $settings['order'],
                'ignore_sticky_posts' => 1,
                'post_status' => 'publish',
                'showposts'   => $showposts,
                'meta_key' => 'post_views_count',
                'orderby' => 'meta_value_num',
                'posts_per_page' => $settings['number_of_posts'],
                'offset' => $settings['offset'],
                'paged'       => $paged,
            ];
        } elseif ( $settings['post_sortby'] == 'mostdiscussed' ) {
            $query_args = [
                'orderby' => 'comment_count',
                'order' => $settings['order'],
                'ignore_sticky_posts' => 1,
                'post_status' => 'publish',
                'showposts'   => $showposts,
                'posts_per_page' => $settings['number_of_posts'],
                'offset' => $settings['offset'],
                'paged'       => $paged,
            ];
        } else {
            $query_args = [
                'orderby' => $settings['orderby'],
                'order' => $settings['order'],
                'ignore_sticky_posts' => 1,
                'post_status' => 'publish',
                'showposts'   => $showposts,
                'posts_per_page' => $settings['number_of_posts'],
                'offset' => $settings['offset'],
                'paged'       => $paged,
            ];
        }

            if (!empty($settings['post_type'])) {
                $query_args['post_type'] = $settings['post_type'];
            }
            if (!empty($settings['tax_query'])) {
                $tax_queries = $settings['tax_query'];
                $query_args['tax_query'] = array();
                $query_args['tax_query']['relation'] = 'OR';
                foreach ($tax_queries as $taxquery) {
                    list($tax, $term) = explode(':', $taxquery);
                    if (empty($tax) || empty($term))
                        continue;
                    $query_args['tax_query'][] = array(
                        'taxonomy' => $tax,
                        'field' => 'slug',
                        'terms' => $term
                    );
                }
            }
        return $query_args;
    }

    // Post Title Lenth
    static function title_lenth($charlength) {

        $title = get_the_title();
        $charlength++;

        if ( mb_strlen( $title ) > $charlength ) {
            $subex = mb_substr( $title, 0, $charlength - 0 );
            $exwords = explode( ' ', $subex );
            $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
            if ( $excut < 0 ) {
                return mb_substr( $subex, 0, $excut );
            } else {
                return $subex;
            }

        } else {
            return $title;
        }
    }

    // Post excerpt limit
    static function excerpt_limit($limit) {
      $excerpt = explode(' ', get_the_excerpt(), $limit);
      if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).' ';
      } else {
        $excerpt = implode(" ",$excerpt);
      } 
      $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
      return $excerpt;
    }

    // woocommerce product gallery first image hover on product
    static function woo_image_hover() {
        global $product;

        $attachment_ids = $product->get_gallery_image_ids();
        $count = 0;
        foreach( $attachment_ids as $attachment_id ) { 
            $count++;
            
            if($count <= 1) {
            ?>
            <div class="tx-woo-hover-image">
                <img src="<?php echo wp_get_attachment_image_src( $attachment_id, 'woocommerce_thumbnail' )[0]; ?>" alt="<?php echo esc_attr( get_the_title( $attachment_id ) ); ?>">
            </div>
            <?php 
            }
        }
    }

    // social profile 
    static function social_profile($link) {

        $phone = $link['phone'];
        $email = $link['email'];
        $facebook = $link['facebook'];
        $twitter = $link['twitter'];
        $linkedin = $link['linkedin'];
        $instagram = $link['instagram'];
        $behance = $link['behance'];
        $dribbble = $link['dribbble'];
        $pinterest = $link['pinterest'];
        $youtube = $link['youtube'];
        ?>

        <div class="tx-social-profile">
            <?php if ( !empty($phone) ) : ?>
                <a href="tel:<?php echo esc_attr( $phone ); ?>"><i class="bi bi-telephone" aria-hidden="true"></i></a>
            <?php endif; ?>
            <?php if ( !empty($email) ) : ?>
                <a href="mailto:<?php echo esc_attr( $email ); ?>"><i class="bi bi-envelope" aria-hidden="true"></i></a>
            <?php endif; ?>
            <?php if ( !empty($facebook) ) : ?>
                <a href="<?php echo esc_url( $facebook ); ?>"><i class="fab fa-facebook" aria-hidden="true"></i></a>
            <?php endif; ?>
            <?php if ( !empty($twitter) ) : ?>
                <a href="<?php echo esc_url( $twitter ); ?>"><i class="fa-brands fa-x-twitter" aria-hidden="true"></i></a>
            <?php endif; ?>
            <?php if ( !empty($linkedin) ) : ?>
                <a href="<?php echo esc_url( $linkedin ); ?>"><i class="fab fa-linkedin" aria-hidden="true"></i></a>
            <?php endif; ?>
            <?php if ( !empty($instagram) ) : ?>
                <a href="<?php echo esc_url( $instagram ); ?>"><i class="fab fa-instagram" aria-hidden="true"></i></a>
            <?php endif; ?>
            <?php if ( !empty($behance) ) : ?>
                <a href="<?php echo esc_url( $behance ); ?>"><i class="fab fa-behance" aria-hidden="true"></i></a>
            <?php endif; ?>
            <?php if ( !empty($dribbble) ) : ?>
                <a href="<?php echo esc_url( $dribbble ); ?>"><i class="fab fa-dribbble" aria-hidden="true"></i></a>
            <?php endif; ?>          
            <?php if ( !empty($pinterest) ) : ?>
                <a href="<?php echo esc_url( $pinterest ); ?>"><i class="fab fa-pinterest" aria-hidden="true"></i></a>
            <?php endif; ?>
            <?php if ( !empty($youtube) ) : ?>
                <a href="<?php echo esc_url( $youtube ); ?>"><i class="fab fa-youtube" aria-hidden="true"></i></a>
            <?php endif; ?>
        </div><!-- tx-social-profile -->

    <?php
    }

    // Instagram Feed
    static function instagram_feed() {

    global $tx;
    $access_token = $tx['instagram_api'];

        if (!empty($access_token)) {

            $api_url = 'https://api.instagram.com/v1/users/self/media/recent/?access_token=' . $access_token;
            $json_data = wp_remote_fopen( $api_url );
            $data  = json_decode( $json_data, true );
            $meta = [];

                if ( ! empty( $data['data'] ) ) {

                    foreach ( $data['data'] as $feed ) {

                        array_push( $meta, 
                            array(
                                'image' => [
                                    'small'  => $feed['images']['thumbnail']['url'],
                                    'medium' => $feed['images']['low_resolution']['url'],
                                    'large'  => $feed['images']['standard_resolution']['url'],
                                ],
                                'link'      => $feed['link'],
                                'like'      => $feed['likes']['count'],
                                'comment'   => [
                                    'count' => $feed['comments']['count']
                                ],
                            ) 
                        );

                    }

                    return $meta;
                }

        } 

    } 

    // Contact Form 7
    static function contact_form_seven() {
        $wpcf7_form_list = get_posts(array(
            'post_type' => 'wpcf7_contact_form',
            'showposts' => -1,
        ));
        $options = array();
        $options[0] = esc_html__( 'Select a Contact Form', 'avas-core' );
        if ( ! empty( $wpcf7_form_list ) && ! is_wp_error( $wpcf7_form_list ) ) {
            foreach ( $wpcf7_form_list as $post ) {
                $options[ $post->ID ] = $post->post_title;
            }
        } else {
            $options[0] = esc_html__( 'Create a Form First', 'avas-core' );
        }
        return $options;
    }

    // Contact Form 7
    static function wpforms() {
        $wpforms_list = get_posts(array(
            'post_type' => 'wpforms',
            'showposts' => -1,
        ));
        $options = array();
        $options[0] = esc_html__( 'Select a form', 'avas-core' );
        if ( ! empty( $wpforms_list ) && ! is_wp_error( $wpforms_list ) ) {
            foreach ( $wpforms_list as $post ) {
                $options[ $post->ID ] = $post->post_title;
            }
        } else {
            $options[0] = esc_html__( 'Create a form first', 'avas-core' );
        }
        return $options;
    }

    // Gravity Form
    public static function gravity_form() {
        $options = array();

        if (class_exists('GFCommon')) {
            $gravity_forms = \RGFormsModel::get_forms(null, 'title');

            if (!empty($gravity_forms) && !is_wp_error($gravity_forms)) {

                $options[0] = esc_html__('Select Gravity Form', 'avas-core');
                foreach ($gravity_forms as $form) {
                    $options[$form->id] = $form->title;
                }

            } else {
                $options[0] = esc_html__('Create a form first', 'avas-core');
            }
        }

        return $options;
    }

    // Get all image shapes for image mask
    public static function get_image_shapes() {
        $path       = TX_PLUGIN_URL . '/assets/img/mask/';
        $shape_name = 'shape';
        $extension  = '.svg';
        $list       = [ 0 => esc_html__( 'Select Mask', 'avas-core' ) ];
        
        for ( $i = 1; $i <= 81; $i ++ ) {
            $list[ $path . $shape_name . '-' . $i . $extension ] = ucwords( $shape_name . ' ' . $i );
        }
        
        return $list;
    }


    // Position for navigation, icons, arrow, etc
    public static function tx__position() {
        $position_options = [
            ''              => esc_html__('Default', 'avas-core'),
            'top-left'      => esc_html__('Top Left', 'avas-core'),
            'top-center'    => esc_html__('Top Center', 'avas-core'),
            'top-right'     => esc_html__('Top Right', 'avas-core'),
            'center'        => esc_html__('Center', 'avas-core'),
            'center-left'   => esc_html__('Center Left', 'avas-core'),
            'center-right'  => esc_html__('Center Right', 'avas-core'),
            'bottom-left'   => esc_html__('Bottom Left', 'avas-core'),
            'bottom-center' => esc_html__('Bottom Center', 'avas-core'),
            'bottom-right'  => esc_html__('Bottom Right', 'avas-core'),
        ];

        return $position_options;
    }

    // html tags
    public static function title_html_tags() {

        $tags = [
            'h1'    => 'H1',
            'h2'    => 'H2',
            'h3'    => 'H3',
            'h4'    => 'H4',
            'h5'    => 'H5',
            'h6'    => 'H6',
            'div'   => 'div',
            'span'  => 'Span',
            'p'     => 'P'
        ];

        return $tags;

    }

    // navigation positions
    public static function navigation_position() {

        $position_options = [
            'top-left'      => esc_html__('Top Left', 'avas-core'),
            'top-center'    => esc_html__('Top Center', 'avas-core'),
            'top-right'     => esc_html__('Top Right', 'avas-core'),
            'center'        => esc_html__('Center', 'avas-core'),
            'center-left'   => esc_html__('Center Left', 'avas-core'),
            'center-right'  => esc_html__('Center Right', 'avas-core'),
            'bottom-left'   => esc_html__('Bottom Left', 'avas-core'),
            'bottom-center' => esc_html__('Bottom Center', 'avas-core'),
            'bottom-right'  => esc_html__('Bottom Right', 'avas-core'),
        ];

        return $position_options;

    }

    // pagination positions
    public static function pagination_position() {

        $position_options = [
            'top-left'      => esc_html__('Top Left', 'avas-core'),
            'top-center'    => esc_html__('Top Center', 'avas-core'),
            'top-right'     => esc_html__('Top Right', 'avas-core'),
            'center-left'   => esc_html__('Center Left', 'avas-core'),
            'center-right'  => esc_html__('Center Right', 'avas-core'),
            'bottom-left'   => esc_html__('Bottom Left', 'avas-core'),
            'bottom-center' => esc_html__('Bottom Center', 'avas-core'),
            'bottom-right'  => esc_html__('Bottom Right', 'avas-core'),
        ];

        return $position_options;

    }

    //Blend options
    public static function tx_blend_options() {
        $blend_options = [
            'multiply'    => esc_html__('Multiply', 'avas-core'),
            'screen'      => esc_html__('Screen', 'avas-core'),
            'overlay'     => esc_html__('Overlay', 'avas-core'),
            'darken'      => esc_html__('Darken', 'avas-core'),
            'lighten'     => esc_html__('Lighten', 'avas-core'),
            'color-dodge' => esc_html__('Color-Dodge', 'avas-core'),
            'color-burn'  => esc_html__('Color-Burn', 'avas-core'),
            'hard-light'  => esc_html__('Hard-Light', 'avas-core'),
            'soft-light'  => esc_html__('Soft-Light', 'avas-core'),
            'difference'  => esc_html__('Difference', 'avas-core'),
            'exclusion'   => esc_html__('Exclusion', 'avas-core'),
            'hue'         => esc_html__('Hue', 'avas-core'),
            'saturation'  => esc_html__('Saturation', 'avas-core'),
            'color'       => esc_html__('Color', 'avas-core'),
            'luminosity'  => esc_html__('Luminosity', 'avas-core'),
        ];

        return $blend_options;
    }

    // Transition options
    public static function tx_transition_options() {

    $transition_options = [
        ''                    => esc_html__('None', 'avas-core'),
        'fade'                => esc_html__('Fade', 'avas-core'),
        'scale-up'            => esc_html__('Scale Up', 'avas-core'),
        'scale-down'          => esc_html__('Scale Down', 'avas-core'),
        'slide-top'           => esc_html__('Slide Top', 'avas-core'),
        'slide-bottom'        => esc_html__('Slide Bottom', 'avas-core'),
        'slide-left'          => esc_html__('Slide Left', 'avas-core'),
        'slide-right'         => esc_html__('Slide Right', 'avas-core'),
        'slide-top-small'     => esc_html__('Slide Top Small', 'avas-core'),
        'slide-bottom-small'  => esc_html__('Slide Bottom Small', 'avas-core'),
        'slide-left-small'    => esc_html__('Slide Left Small', 'avas-core'),
        'slide-right-small'   => esc_html__('Slide Right Small', 'avas-core'),
        'slide-top-medium'    => esc_html__('Slide Top Medium', 'avas-core'),
        'slide-bottom-medium' => esc_html__('Slide Bottom Medium', 'avas-core'),
        'slide-left-medium'   => esc_html__('Slide Left Medium', 'avas-core'),
        'slide-right-medium'  => esc_html__('Slide Right Medium', 'avas-core'),
    ];

        return $transition_options;
    }


    //Animations
    public static function tx_animations() {
        $animation_options = [
            'fade-in'      => esc_html__('Fade In', 'avas-core'),
            'fade-out'      => esc_html__('Fade Out', 'avas-core'),
            'slide-top'      => esc_html__('Slide Top', 'avas-core'),
        ];

        return $animation_options;
    }

    
    //Animation Timings
    public static function tx_animation_timings() {
        $timing_options = [
            'ease-default'      => esc_html__('Default','avas-core'),
            'linear'            => esc_html__('Linear','avas-core'),
            'ease-in'           => esc_html__('Ease In','avas-core'),
            'ease-out'          => esc_html__('Ease Out','avas-core'),
            'ease-in-out'       => esc_html__('Ease In Out','avas-core'),
            'ease-in-quad'      => esc_html__('Ease In Quad','avas-core'),
            'ease-in-cubic'     => esc_html__('Ease In Cubic','avas-core'),
            'ease-in-quart'     => esc_html__('Ease In Quart','avas-core'),
            'ease-in-quint'     => esc_html__('Ease In Quint','avas-core'),
            'ease-in-sine'      => esc_html__('Ease In Sine','avas-core'),
            'ease-in-expo'      => esc_html__('Ease In Expo','avas-core'),
            'ease-in-circ'      => esc_html__('Ease In Circ','avas-core'),
            'ease-in-back'      => esc_html__('Ease In Back','avas-core'),
            'ease-out-quad'     => esc_html__('Ease Out Quad','avas-core'),
            'ease-out-cubic'    => esc_html__('Ease Out Cubic','avas-core'),
            'ease-out-quart'    => esc_html__('Ease Out Quart','avas-core'),
            'ease-out-quint'    => esc_html__('Ease Out Quint','avas-core'),
            'ease-out-sine'     => esc_html__('Ease Out Sine','avas-core'),
            'ease-out-expo'     => esc_html__('Ease Out Expo','avas-core'),
            'ease-out-circ'     => esc_html__('Ease Out Circ','avas-core'),
            'ease-out-back'     => esc_html__('Ease Out Back','avas-core'),
            'ease-in-out-quad'  => esc_html__('Ease In Out Quad','avas-core'),
            'ease-in-out-cubic' => esc_html__('Ease In Out Cubic','avas-core'),
            'ease-in-out-quart' => esc_html__('Ease In Out Quart','avas-core'),
            'ease-in-out-quint' => esc_html__('Ease In Out Quint','avas-core'),
            'ease-in-out-sine'  => esc_html__('Ease In Out Sine','avas-core'),
            'ease-in-out-expo'  => esc_html__('Ease In Out Expo','avas-core'),
            'ease-in-out-circ'  => esc_html__('Ease In Out Circ','avas-core'),
            'ease-in-out-back'  => esc_html__('Ease In Out Back','avas-core')
        ];

        return $timing_options;
    }


} //class TX_Helper



