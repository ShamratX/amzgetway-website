<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/
* ======================================================================
*   This is main functions file you may add your custom functions here. 
* ======================================================================
*/


$theme = wp_get_theme();
if ( ! defined( 'TX_THEME_VERSION' ) ) {
  define('TX_THEME_VERSION', $theme->get('Version'));
}
if ( ! defined( 'TX_THEME_DIR' ) ) {
  define( 'TX_THEME_DIR', trailingslashit( get_template_directory() ) );
}
if ( ! defined( 'TX_THEME_URL' ) ) {
  define( 'TX_THEME_URL', trailingslashit( get_template_directory_uri() ) );
}
if ( ! defined( 'TX_STYLESHEET_DIR' ) ) {
  define( 'TX_STYLESHEET_DIR', trailingslashit( get_stylesheet_directory() ) );
}
if ( ! defined( 'TX_STYLESHEET_URL' ) ) {
  define( 'TX_STYLESHEET_URL', trailingslashit( get_stylesheet_directory_uri() ) );
}
if ( ! defined( 'TX_CSS' ) ) {
  define( 'TX_CSS', TX_THEME_URL . 'assets/css/' );
}
if ( ! defined( 'TX_JS' ) ) {
  define( 'TX_JS', TX_THEME_URL . 'assets/js/' );
}
if ( ! defined( 'TX_IMAGES' ) ) {
  define( 'TX_IMAGES', TX_THEME_URL . 'assets/images/' );
}
if ( ! defined( 'TX_IMPORT_URL' ) ) {
  define( 'TX_IMPORT_URL', 'https://avas.live/demo-data/' );
}
if ( ! defined( 'TX_DEMO_URL' ) ) {
  define( 'TX_DEMO_URL', 'https://avas.live/' );
}


// Welcome Screen
if( is_admin() ) :
  require_once TX_THEME_DIR . 'inc/welcome.php';
endif;

// Customizer
if(!class_exists('ReduxFramework')):
  require_once TX_THEME_DIR . 'inc/customizer.php';
endif;

// Functions for header, footer, logo, favicon, etc
require_once TX_THEME_DIR . 'inc/functions.php';

// Theme options
add_action('after_setup_theme', 'tx_load_theme_options', 5); // priority 5 = very early
function tx_load_theme_options() {
  require_once TX_THEME_DIR . 'inc/theme-options.php';
}

// Dynamic Styles
require_once TX_THEME_DIR . 'inc/dynamic-style.php';

// Post Meta Categories, Tags etc
require_once TX_THEME_DIR . 'inc/post-meta.php';

// Pagination
require_once TX_THEME_DIR . 'inc/pagination.php';

// Comments callback
require_once TX_THEME_DIR . 'inc/comments-callback.php';

// Theme Updates
require_once TX_THEME_DIR . 'inc/updates.php';

// Enqueue
require_once TX_THEME_DIR . 'inc/enqueue.php';

// Mega Menu
require_once TX_THEME_DIR . 'inc/mega-menu.php';

// Login
require_once TX_THEME_DIR . 'inc/login.php';

// LearnPress plugin's functions for Education course
if ( class_exists( 'LearnPress' ) ) {
  require_once TX_THEME_DIR . 'learnpress/lp-functions.php'; 
}

// Woocommerece plugin's functions for eCommerce Shop
if ( class_exists( 'WooCommerce' ) ) {
  require_once TX_THEME_DIR . 'woocommerce/woo-functions.php'; 
}

// Estatik plugin's functions for Real Estate
if ( class_exists( 'Estatik' ) ) {
  require_once TX_THEME_DIR . 'estatik/estatik-functions.php'; 
}

// bbPress plugin's functions for Forum
if ( class_exists( 'bbpress' ) ) {
  require_once TX_THEME_DIR . 'bbpress/bbp-functions.php'; 
}


/* ---------------------------------------------------------
    Get option for redux and customizer
------------------------------------------------------------ */
if ( ! function_exists( 'tx_get_option' ) ) {
    function tx_get_option( $key, $default = false ) {
        if ( class_exists( 'ReduxFramework' ) && isset( $GLOBALS['tx'][ $key ] ) ) {
            $value = $GLOBALS['tx'][ $key ];
        } else {
            $value = get_theme_mod( $key, $default );
        }

        return $value !== null ? $value : $default;
    }
}

// for switch
if (!function_exists('tx_is_enabled')) {
    function tx_is_enabled($key, $default = true) {
        $value = tx_get_option($key, $default);

        // True for bool true, int 1, string '1'
        if ($value === true || $value === 1 || $value === '1') {
            return true;
        }
        // Safe for legacy/custom mods
        $value = strtolower(trim((string)$value));
        return in_array($value, ['enabled', 'true', 'yes', 'on'], true);
    }
}


/* ---------------------------------------------------------
  Theme Setup
------------------------------------------------------------ */

if( !function_exists('tx_theme_setup') ) :
  
  function tx_theme_setup() {

    // menu setup
    register_nav_menus (array(
      'top_menu'    => esc_html__('Top Menu','avas'),
      'main_menu'   => esc_html__('Main Menu','avas'),
      'left_menu'   => esc_html__('Left Menu(For Header Style 9 only)','avas'),
      'right_menu'  => esc_html__('Right Menu(For Header Style 9 only)','avas'),
      'side_menu'   => esc_html__('Side Header Menu','avas'),
      'footer_menu' => esc_html__('Footer Menu','avas'),
      'mobile_menu' => esc_html__('Mobile Menu','avas'),
    ));

    // Makes theme available for translation.
    load_theme_textdomain( 'avas', TX_THEME_DIR . '/languages' );

    // Supported posts formats
    add_theme_support( 'post-formats', array( 'gallery', 'video' ) );

    // Add RSS Links to head section
    add_theme_support( 'automatic-feed-links' );

    // Title tag support
    add_theme_support( 'title-tag' );

    // Custom logo support
    add_theme_support( 'custom-logo', array(
      'height'      => 100,
      'width'       => 400,
      'flex-height' => true,
      'flex-width'  => true,
      'header-text' => array( 'site-title', 'site-description' ),
    ) );

    // Custom header support
    $args = array(
        'width'              => 1920,
        'height'             => 100,
        'flex-width'         => true,
        'flex-height'        => true,
    );
    add_theme_support( 'custom-header', $args );

    // Custom backgrounds support
    add_theme_support( 'custom-background', array() );

  // WooCommerce support
  if ( class_exists( 'WooCommerce' ) ) {

    add_theme_support('woocommerce');

    // WooCommerce product gallery zoom support
    add_theme_support( 'wc-product-gallery-zoom' );

    // WooCommerce product gallery lightbox support
    add_theme_support( 'wc-product-gallery-lightbox' );

    // WooCommerce product gallery slider support
    add_theme_support( 'wc-product-gallery-slider' );
  }
    // Enable WP Responsive embedded content
    add_theme_support( 'responsive-embeds' );

    // Enable WP Gutenberg Align Wide
    add_theme_support( 'align-wide' );

    // Enable WP Gutenberg Block Style
    add_theme_support( 'wp-block-styles' );

    // Add support for editor styles.
    add_theme_support( 'editor-styles' );

    // Partial refresh support in the Customize
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Enable support for custom Editor Style.
    add_editor_style( 'custom-editor-style.css' );

    // Enable Custom Color Scheme For Block Style
    add_theme_support( 'editor-color-palette', array(
        array(
            'name' => esc_html__( 'deep cerise', 'avas' ),
            'slug' => 'deep-cerise',
            'color' => '#e51681',
        ),    
        array(
            'name' => esc_html__( 'strong magenta', 'avas' ),
            'slug' => 'strong-magenta',
            'color' => '#a156b4',
        ),
        array(
            'name' => esc_html__( 'light grayish magenta', 'avas' ),
            'slug' => 'light-grayish-magenta',
            'color' => '#d0a5db',
        ),
        array(
            'name' => esc_html__( 'very light gray', 'avas' ),
            'slug' => 'very-light-gray',
            'color' => '#eee',
        ),
        array(
            'name' => esc_html__( 'very dark gray', 'avas' ),
            'slug' => 'very-dark-gray',
            'color' => '#444',
        ),
        array(
            'name'  =>  esc_html__( 'strong blue', 'avas' ),
            'slug'  => 'strong-blue',
            'color' => '#0073aa',
        ),
        array(
            'name'  =>  esc_html__( 'lighter blue', 'avas' ),
            'slug'  => 'lighter-blue',
            'color' => '#229fd8',
        ),
    ) );

    // Block Font Sizes
    add_theme_support( 'editor-font-sizes', array(
        array(
            'name' => esc_html__( 'Small', 'avas' ),
            'size' => 12,
            'slug' => 'small'
        ),
        array(
            'name' => esc_html__( 'Regular', 'avas' ),
            'size' => 16,
            'slug' => 'regular'
        ),
        array(
            'name' => esc_html__( 'Large', 'avas' ),
            'size' => 36,
            'slug' => 'large'
        ),
        array(
            'name' => esc_html__( 'Huge', 'avas' ),
            'size' => 50,
            'slug' => 'larger'
        )
    ) );

    // Content Width
    if ( ! isset( $content_width ) ) {
      $content_width = 1140;
    }
  }
endif;

/* ------------------------------------------------------------------------
  Enable support for Post Thumbnails on posts, pages and custom post type.
--------------------------------------------------------------------------- */ 
function tx_add_image_size() {
    add_theme_support( 'post-thumbnails' );

    // Helper to retrieve width/height safely from options
    function tx_get_size_value( $key, $default_width = 600, $default_height = 400 ) {
        $size = tx_get_option( $key );

        return [
            'width'  => is_array($size) && isset($size['width']) ? (int) $size['width'] : $default_width,
            'height' => is_array($size) && isset($size['height']) ? (int) $size['height'] : $default_height,
        ];
    }

    $image_sizes = [
        'tx-1920x600-thumb'         => [ 1920, 600, true ],
        'tx-xl-thumb'               => [ 1140, 500, true ],
        'tx-l-thumb'                => [ 750, 420, true ],
        'tx-ts-thumb'               => [ 470, 560, true ],
        'tx-t-thumb'                => [ 270, 300, true ],
        'tx-tf-thumb'               => [ 320, 360, true ],
        'tx-m-thumb'                => [ 580, 460, true ],
        'tx-alter-thumb'            => [ 616, 430, true ],
        'tx-team-alter-thumb'       => [ 525, 525, true ],
        'tx-serv-thumb'             => [ 370, 270, true ],
        'tx-serv-overlay-thumb'     => [ 370, 470, true ],
        'tx-c-thumb'                => [ 320, 220, true ],
        'tx-port-grid-h-thumb'      => [ 485, 335, true ],
        'tx-port-grid-v-thumb'      => [ 390, 438, true ],
        'tx-timeline-thumb'         => [ 460, 300, true ],
        'tx-lp-thumb'               => [ 918, 440, true ],
        'tx-ms-size'                => [ 350, 220, true ],
        'tx-r-thumb'                => [ 270, 188, true ],
        'tx-s-thumb'                => [ 100, 75, true ],
        'tx-pe-thumb'               => [ 150, 100, true ],
        'tx-admin-post-thumb'       => [ 80, 80, true ],
        'tx-bc-thumb'               => [ 360, 0, false ],
        'tx-gall-grid-cols-3'       => [ 373, 0, false ],
        'tx-masonry-cols-3'         => [ 620, 0, false ],
        'tx-masonry-cols-4'         => [ 460, 0, false ],
        'tx-masonry-cols-5'         => [ 365, 0, false ],
        'tx-masonry-cols-6'         => [ 300, 0, false ],
    ];

    foreach ( $image_sizes as $key => $defaults ) {
        $default_width  = $defaults[0];
        $default_height = $defaults[1];
        $crop           = $defaults[2];

        $size = tx_get_size_value( $key, $default_width, $default_height );
        add_image_size( $key, $size['width'], $size['height'], $crop );
    }
}
add_action( 'after_setup_theme', 'tx_add_image_size' );


/* ---------------------------------------------------------
  Title limit
------------------------------------------------------------ */
  function tx_max_title_length( $title ) {
    // Only apply limit in specific contexts
    if ( is_home() || is_category() || is_archive() || 
         is_page_template( 'templates/blog.php' ) || 
         is_page_template( 'templates/blog-three-columns.php' ) || 
         is_page_template( 'templates/blog-two-columns.php' ) ) {

        $max = tx_get_option('title-length');

        // Fallback to 85 if not set
        $max = is_numeric($max) ? (int) $max : 85;

        if ( strlen( $title ) > $max ) {
            return mb_substr( $title, 0, $max ) . '…'; // using mb_substr for multibyte safety
        }
    }

    return $title;
}

  // avoid menu title
  function tx_set_title_length() {
    add_filter( 'the_title', 'tx_max_title_length', 10, 2);
  }

 // avoid menu title
 add_action( 'loop_start', 'tx_set_title_length');


/* ---------------------------------------------------------
  Excerpt word limit (Filtered)
------------------------------------------------------------ */
function tx_excerpt_filter($excerpt) {
    $limit = 35;
    $custom_limit = tx_get_option('excerpt-word-limit');
    if (!empty($custom_limit) && is_numeric($custom_limit)) {
        $limit = (int) $custom_limit;
    }

    $words = explode(' ', strip_tags($excerpt), $limit + 1);

    if (count($words) > $limit) {
        array_pop($words);
        $excerpt = implode(' ', $words) . '...';
    } else {
        $excerpt = implode(' ', $words);
    }

    $excerpt = preg_replace('`$begin:math:display$[^$end:math:display$]*\]`','', $excerpt);

    $read_more = tx_get_option('read-more');
    $read_more_text = tx_get_option('read-more-text');

    if ($read_more && (is_post_type_archive('post') || is_page('blog') || is_category() || is_tag())) {
        $excerpt .= ' <a class="tx-read-more" href="' . esc_url(get_permalink()) . '">' . esc_html($read_more_text) . '</a>';
    }

    return '<p class="tx-excerpt">' . $excerpt . '</p>';
}
add_filter('the_excerpt', 'tx_excerpt_filter');

/* ---------------------------------------------------------
  Excerpt word limit
------------------------------------------------------------ */
function tx_excerpt_limit($limit) {

      $excerpt = explode(' ', get_the_excerpt(), $limit);
      if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt);
      } else {
        $excerpt = implode(" ",$excerpt);
      } 
      $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);

      return $excerpt;
  }

/* ---------------------------------------------------------
  Content word limit
------------------------------------------------------------ */
  function tx_content($limit) {
      $content = explode(' ', get_the_content(), $limit);
      if (count($content)>=$limit) {
        array_pop($content);
        $content = implode(" ",$content).'...';
      } else {
        $content = implode(" ",$content);
      } 
      $content = preg_replace('/\[.+\]/','', $content);
      $content = apply_filters('the_content', $content); 
      $content = str_replace(']]>', ']]&gt;', $content);
      return $content;
  }

/* ---------------------------------------------------------
  Page content
------------------------------------------------------------ */
if(!function_exists('tx_content_page')) :
  add_action( 'tx_content_page', 'tx_content_page' );
  function tx_content_page() { ?>
        <!-- <div id="primary" class="col-md-12"> -->
            <div id="main" class="site-main">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/content/content', 'page'); ?>
                    <?php
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>
                <?php endwhile; // end of the loop.  ?>
            </div><!-- #main -->
        <!-- </div> --><!-- #primary -->

<?php }

endif;

/* ---------------------------------------------------------
  Post format
------------------------------------------------------------ */
function tx_post_format( $template ) {
    if ( is_single() && has_post_format() ) {
        $post_format_template = locate_template( 'single-' . get_post_format() . '.php' );
        if ( $post_format_template ) {
            $template = $post_format_template;
        }
    }

    return $template;
}   
add_filter( 'template_include', 'tx_post_format' );


/* ----------------------------------------------------------------
    Index, Archives, Category etc post page Sidebar / No Sidebar
----------------------------------------------------------------- */
if ( ! function_exists('tx_sidebar_no_sidebar') ) :
function tx_sidebar_no_sidebar() {
    $sidebar = tx_get_option('sidebar-select');

    return ( empty($sidebar) || $sidebar === 'sidebar-none' ) ? 12 : 8;
}
endif;

/* ---------------------------------------------------------
    Single Post Sidebar / No Sidebar
------------------------------------------------------------ */
if ( ! function_exists('tx_single_sidebar') ) :
function tx_single_sidebar() {
    $sidebar = tx_get_option('sidebar-single');

    return ( empty($sidebar) || $sidebar === 'sidebar-none' ) ? 12 : 8;
}
endif;

/* ---------------------------------------------------------
    Add sideber class to body for index, archive etc page
------------------------------------------------------------ */
if ( ! function_exists('tx_sidebar_class_body_archive') ) :

function tx_sidebar_class_body_archive( $classes = [] ) {
    $sidebar = tx_get_option('sidebar-select', 'sidebar-right'); // Default fallback

    if ( $sidebar === 'sidebar-right' ) {
        $classes[] = 'sidebar-right';
    } elseif ( $sidebar === 'sidebar-left' ) {
        $classes[] = 'sidebar-left';
    } else {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}

endif;

add_filter('body_class', 'tx_sidebar_class_body_archive');

/* ---------------------------------------------------------
    Add sideber class to body for single post
------------------------------------------------------------ */
if ( ! function_exists('tx_sidebar_classes_body_single') ) :

function tx_sidebar_classes_body_single( $classes = [] ) {
    $sidebar = tx_get_option('sidebar-single', 'sidebar-right'); // Set default as needed

    if ( $sidebar === 'sidebar-right' ) {
        $classes[] = 'sidebar-right';
    } elseif ( $sidebar === 'sidebar-left' ) {
        $classes[] = 'sidebar-left';
    } else {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}

endif;

add_filter('body_class', 'tx_sidebar_classes_body_single');

/* ---------------------------------------------------------
    Remove Category: and Tag: word from archive title
------------------------------------------------------------ */
if(!function_exists('tx_remove_cat_tag_word')) :
function tx_remove_cat_tag_word( $title ) {
    if ( is_category() || is_tag() ) {
        $title = single_cat_title( '', false );
    }
    return $title;
}
add_filter( 'get_the_archive_title', 'tx_remove_cat_tag_word' );
endif;

/* ---------------------------------------------------------
    Tag limit
------------------------------------------------------------ */

//Register tag cloud filter callback
add_filter('widget_tag_cloud_args', 'tx_tag_widget_limit');
//Limit number of tags inside widget
function tx_tag_widget_limit($args) {
    // Check if taxonomy option inside widget is set to tags
    if ( isset($args['taxonomy']) && $args['taxonomy'] === 'post_tag' ) {
        $tag_limit = tx_get_option('tag_limit'); // Use helper
        if ( ! empty($tag_limit) && is_numeric($tag_limit) ) {
            $args['number'] = (int) $tag_limit;
        }
    }
    return $args;
}

/* ---------------------------------------------------------
    Display post thumbnail on posts list at backend
------------------------------------------------------------ */

function tx_admin_post_cols($cols) {
    return array_merge(
        array_splice($cols, 0, 1),
        ["tx-admin-thumb" => "Thumb"],
        $cols
    );
}

function tx_admin_post_thumb_col($col, $id) {
    if ($col == "tx-admin-thumb") {
        $link = get_edit_post_link();
        $thumb = get_the_post_thumbnail($id, "tx-admin-post-thumb");    
        echo wp_kses_post($thumb ? "<a href='$link'>$thumb</a>" : '<img src="'.TX_IMAGES.'no-image.png">');
    }
}


add_filter('manage_posts_columns','tx_admin_post_cols');

add_action('manage_posts_custom_column', 'tx_admin_post_thumb_col', 10, 2 );

/* ------------------------------------------------------------------------------------------
    Set locale for change the comma to decimal avoid brakes Elementor generated CSS style.
--------------------------------------------------------------------------------------------- */
setlocale(LC_NUMERIC, 'en_US.UTF-8');

/* -------------------------------------------------------
   Notice: WP_Scripts::localize was called incorrectly.
---------------------------------------------------------- */

add_filter('doing_it_wrong_trigger_error', function () {return false;}, 10, 0);

/* ---------------------------------------------------------
    Remove WordPress Default gallery border
------------------------------------------------------------ */
add_filter( 'use_default_gallery_style', '__return_false' );


/* ---------------------------------------------------------
    Allow user role subscriber to Upload Media
------------------------------------------------------------ */
if (!function_exists('tx_allow_subscriber_uploads')) :

add_action('admin_init', 'tx_allow_subscriber_uploads');
function tx_allow_subscriber_uploads() {
    if ( current_user_can('subscriber') && !current_user_can('upload_files') ){
        $subscriber = get_role('subscriber');
        $subscriber->add_cap('upload_files');
    }
}

endif;

/* ---------------------------------------------------------
    Custom Font Support // ttf extension support
------------------------------------------------------------ */
if( is_admin() && isset($_GET['page']) && $_GET['page'] == 'avas' ){
  add_filter('upload_mimes', 'tx_custom_font_support');
  function tx_custom_font_support( $existing_mimes = array() ){
    $existing_mimes['ttf'] = 'font/ttf';
    return $existing_mimes;
  }
}




/* ---------------------------------------------------------
    Support mime types
------------------------------------------------------------ */

function tx_custom_mime_types($mimes = []) {
    $mimes['ttf']   = 'font/ttf';
    $mimes['otf']  = 'font/otf';
    $mimes['woff']  = 'font/woff';
    $mimes['woff2'] = 'font/woff2';
    $mimes['eot']   = 'application/vnd.ms-fontobject';
    $mimes['svg']   = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'tx_custom_mime_types', 1, 1);

/* ---------------------------------------------------------
    EOF
------------------------------------------------------------ */
