<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/
* ======================================================================
*   Demo Data Import 
* ======================================================================
*/

// Demo instruction
if ( ! function_exists( 'tx_plugin_intro_text' ) ) :
  function tx_plugin_intro_text() {
  
    $default_text = '<div class="tx-demo-instructon">';
    $default_text .= '<h3 style="color:#e84d3e;">&#8594; Important Instruction:</h3>';
    $default_text .= '<p>&#9957; Best if used on new WordPress install.</p>';
    $default_text .= '<p>&#9957; If you plan to import more than one demo then please clear the existing demo before import the new demo. You can use the "WP Reset" plugin to reset everything.</p>';
    $default_text .= '<p>&#9957; If the import process gets stuck, please reload the page and click the "Continue & Import" button again.</p>';
    $default_text .= '<p>&#9957; Before start importing demo data please check your server resources to meet our server minimum requirements below.</p>';
    $default_text .= '<h3>System Requirements</h3>';

    // system requirements
    ob_start();
    tx_Welcome_Screen::tx_system_requirements();
    $requirements_output = ob_get_clean();
    $default_text .= $requirements_output;
    $default_text .= '</div>';

    return $default_text;
  }
endif;
add_filter( 'ocdi/plugin_intro_text', 'tx_plugin_intro_text' );

// Demo admin menu
function tx_plugin_page_setup( $default_settings ) {
    $default_settings['page_title']  = esc_html__( 'Avas Demo Data Import' , 'avas' );
    $default_settings['menu_title']  = esc_html__( 'Import Demo Data' , 'avas' );
 
    return $default_settings;
}
add_filter( 'ocdi/plugin_page_setup', 'tx_plugin_page_setup' );

// Demo menu setup
function tx_demo_menu_setup() {
  
          //Set Menu
          $top_menu = get_term_by( 'name', 'Top Menu', 'nav_menu' );
          $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
          $footer_menu = get_term_by( 'name', 'Footer Menu', 'nav_menu' );
          $left_menu = get_term_by( 'name', 'Left Menu', 'nav_menu' );
          $right_menu = get_term_by( 'name', 'Right Menu', 'nav_menu' );
          $side_menu = get_term_by( 'name', 'Side Menu', 'nav_menu' );
          $mobile_menu = get_term_by( 'name', 'Mobile Menu', 'nav_menu' );
          $locations = array();
          if ( $top_menu )     $locations['top_menu']     = $top_menu->term_id;
          if ( $main_menu )    $locations['main_menu']    = $main_menu->term_id;
          if ( $footer_menu )  $locations['footer_menu']  = $footer_menu->term_id;
          if ( $left_menu )    $locations['left_menu']    = $left_menu->term_id;
          if ( $right_menu )   $locations['right_menu']   = $right_menu->term_id;
          if ( $side_menu )    $locations['side_menu']    = $side_menu->term_id;
          if ( $mobile_menu )  $locations['mobile_menu']  = $mobile_menu->term_id;

          set_theme_mod( 'nav_menu_locations', $locations );
        
        wp_delete_post( 1, true ); // delete Hello world post 

}
add_action('tx_demo_menu_setup', 'tx_demo_menu_setup');

// LearnPress Settings
add_action('tx_learnpress_settings', 'tx_learnpress_settings');
function tx_learnpress_settings() {
  $lp_pages = array(
    'learn_press_courses_page_id' => 'Courses',
    'learn_press_profile_page_id' => 'Profile',
    'learn_press_checkout_page_id'  => 'Checkout',
    'learn_press_become_a_teacher_page_id'  => 'Become A Teacher',
    'learn_press_term_conditions_page_id' => 'Term Conditions',
  );
  foreach( $lp_pages as $lp_page_name => $lp_page_title ) {
    $lp_page = get_page_by_title( $lp_page_title );
      if( isset( $lp_page->ID ) && $lp_page->ID ) {
        update_option($lp_page_name, $lp_page->ID);
      }
  }
  flush_rewrite_rules();
}

// WooCommerce Settings
add_action('tx_woocommerce_settings', 'tx_woocommerce_settings');
function tx_woocommerce_settings() {
      $woopages = array(
        'woocommerce_shop_page_id'      => 'Shop',
        'woocommerce_cart_page_id'     => 'Shopping Cart',
        'woocommerce_checkout_page_id'   => 'Checkout',
        'woocommerce_myaccount_page_id'  => 'My Account'
      );
      foreach( $woopages as $woo_page_name => $woo_page_title ) {
        $woopage = get_page_by_title( $woo_page_title );
        if( isset( $woopage->ID ) && $woopage->ID ) {
          update_option($woo_page_name, $woopage->ID);
        }
      }

      if( class_exists('WC_Admin_Notices') ) {
        WC_Admin_Notices::remove_notice('install');
      }
      delete_transient( '_wc_activation_redirect' );
      
      
      flush_rewrite_rules();
}

// Update WooCommerce Lookup Table
add_action('tx_update_woocommerce_lookup_table', 'tx_update_woocommerce_lookup_table');
function tx_update_woocommerce_lookup_table() {
      if( function_exists('wc_update_product_lookup_tables_is_running') && function_exists('wc_update_product_lookup_tables') ){
        if( !wc_update_product_lookup_tables_is_running() ){
          if( !defined('WP_CLI') ){
            define('WP_CLI', true);
          }
          wc_update_product_lookup_tables();
        }
      }
}

// Import Slider Revolution
// function tx_rev_slider_import($slider_urls) {

//         foreach( $slider_urls as $slider_url ) {

//           if (!class_exists('WP_Http'))
//               include_once( ABSPATH . WPINC . '/class-http.php' );
//           $http = new WP_Http();

//           $response = $http->request($slider_url);

//           if ($response['response']['code'] != 200) {
//               return false;
//           }

//           $upload = wp_upload_bits(basename($slider_url), null, $response['body']);

//           if (!empty($upload['error'])) {
//               return false;
//           }

//           $file_path = $upload['file'];

//           $slider = new RevSliderSliderImport();

//           $slider->importSliderFromPost(true,true,$file_path);

//         }
//         return $slider_urls;
// }

function tx_rev_slider_import( $slider_urls = [] ) {
    if ( ! class_exists( 'RevSlider' ) || empty( $slider_urls ) ) {
        return;
    }

    foreach ( $slider_urls as $slider_url ) {
        // Download the slider zip file to a temp location
        $tmp = download_url( $slider_url );

        if ( is_wp_error( $tmp ) ) {
            error_log('Failed to download slider: ' . $slider_url);
            continue;
        }

        // Import slider using RevSlider class
        try {
            $slider = new RevSlider();
            $slider->importSliderFromPost( true, true, $tmp );
        } catch (Exception $e) {
            error_log('Slider import error: ' . $e->getMessage());
        }

        // Remove temp file
        @unlink( $tmp );
    }
}

// Theme Builder import
function tx_theme_builder_import($tb_url) {
  $encode_options = file_get_contents($tb_url);
  $options = json_decode($encode_options, true);      
            
  foreach ($options as $key => $value) {
    update_option($key, $value);  
  } 

  return $tb_url;

}

// Set frontpage
function tx_get_page_by_title( $page_title, $output = OBJECT ) {
    $args  = array(
        'title'     => $page_title,
        'post_type' => 'page',
    );
    $query = new WP_Query( $args );
    $pages = $query->posts;

    if ( empty( $pages ) ) {
        return null;
    }

    return get_post( $pages[0], $output );
}

/**
 * Set Elementor Active Default Kit
 */
if ( ! function_exists( 'tx_set_elementor_active_kit' ) ) :
  function tx_set_elementor_active_kit() {
      global $wpdb;

      // Find the Default Kit ID
      $default_kit_id = $wpdb->get_var(
          "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'elementor_library' AND post_name = 'default-kit-2'"
      );

      if ( ! $default_kit_id ) {
          wp_die( 'Default Kit not found.' );
      }

      // Update the active kit option in the database
      update_option( 'elementor_active_kit', $default_kit_id );
     
  }
endif;



// Demo plugin setup
function tx_register_plugins( $plugins ) {
  // List of plugins used by all theme demos.
  $theme_plugins = [
    [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
    ],
    [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
    ],
    [
          'name'               => esc_html__( 'Slider Revolution', 'avas' ), // The plugin name.
          'slug'               => 'revslider', // The plugin slug (typically the folder name).
          'source'             => 'https://avas.live/revslider/revslider.zip', // The plugin source.
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
    ],  
  ];

  // Check if user is on the theme recommended plugins step and a demo was selected.
  if (
    isset( $_GET['step'] ) &&
    $_GET['step'] === 'import' &&
    isset( $_GET['import'] )
  ) {

    // Air Conditioning Services
    if ( $_GET['import'] === '1' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // AI Technology
    if ( $_GET['import'] === '2' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'MC4WP: Mailchimp for WordPress', 'avas' ), // The plugin name.
          'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // Artificial Intelligence
    if ( $_GET['import'] === '5' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'MC4WP: Mailchimp for WordPress', 'avas' ), // The plugin name.
          'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }
 
    // Bakery
    if ( $_GET['import'] === '6' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Woocommerce', 'avas' ), // The plugin name.
          'slug'               => 'woocommerce', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'WPC Smart Quick View for WooCommerce', 'avas' ), // The plugin name.
          'slug'               => 'woo-smart-quick-view', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'WPC Smart Wishlist for WooCommerce', 'avas' ), // The plugin name.
          'slug'               => 'woo-smart-wishlist', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'WPC Smart Compare for WooCommerce', 'avas' ), // The plugin name.
          'slug'               => 'woo-smart-compare', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Slider Revolution', 'avas' ), // The plugin name.
          'slug'               => 'revslider', // The plugin slug (typically the folder name).
          'source'             => 'https://avas.live/revslider/revslider.zip', // The plugin source.
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
      ];
    }

    // Beauty Salon
    if ( $_GET['import'] === '8' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'MC4WP: Mailchimp for WordPress', 'avas' ), // The plugin name.
          'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Woocommerce', 'avas' ), // The plugin name.
          'slug'               => 'woocommerce', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'WPC Smart Quick View for WooCommerce', 'avas' ), // The plugin name.
          'slug'               => 'woo-smart-quick-view', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'WPC Smart Wishlist for WooCommerce', 'avas' ), // The plugin name.
          'slug'               => 'woo-smart-wishlist', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'WPC Smart Compare for WooCommerce', 'avas' ), // The plugin name.
          'slug'               => 'woo-smart-compare', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // Bicycle Repair
    if ( $_GET['import'] === '9' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // Business Advisor
    if ( $_GET['import'] === '12' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // Business Consultant
    if ( $_GET['import'] === '13' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'MC4WP: Mailchimp for WordPress', 'avas' ), // The plugin name.
          'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // Call Center
    if ( $_GET['import'] === '14' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // Car Wash
    if ( $_GET['import'] === '15' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // Charity
    if ( $_GET['import'] === '16' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Give - Donation Plugin', 'avas' ), // The plugin name.
          'slug'               => 'give', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Slider Revolution', 'avas' ), // The plugin name.
          'slug'               => 'revslider', // The plugin slug (typically the folder name).
          'source'             => 'https://avas.live/revslider/revslider.zip', // The plugin source.
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
      ];
    }

    // Charity Two
    if ( $_GET['import'] === '17' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'The Events Calendar', 'avas' ), // The plugin name.
          'slug'               => 'the-events-calendar', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'MC4WP: Mailchimp for WordPress', 'avas' ), // The plugin name.
          'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // Chef
    if ( $_GET['import'] === '18' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Slider Revolution', 'avas' ), // The plugin name.
          'slug'               => 'revslider', // The plugin slug (typically the folder name).
          'source'             => 'https://avas.live/revslider/revslider.zip', // The plugin source.
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
      ];
    }

    // Construction Two
    if ( $_GET['import'] === '21' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'MC4WP: Mailchimp for WordPress', 'avas' ), // The plugin name.
          'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // Coronavirus
    if ( $_GET['import'] === '23' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // Corporate Business
    if ( $_GET['import'] === '25' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'MC4WP: Mailchimp for WordPress', 'avas' ), // The plugin name.
          'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // Creative Agency
    if ( $_GET['import'] === '27' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Woocommerce', 'avas' ), // The plugin name.
          'slug'               => 'woocommerce', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'WPC Smart Quick View for WooCommerce', 'avas' ), // The plugin name.
          'slug'               => 'woo-smart-quick-view', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'WPC Smart Wishlist for WooCommerce', 'avas' ), // The plugin name.
          'slug'               => 'woo-smart-wishlist', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'WPC Smart Compare for WooCommerce', 'avas' ), // The plugin name.
          'slug'               => 'woo-smart-compare', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Slider Revolution', 'avas' ), // The plugin name.
          'slug'               => 'revslider', // The plugin slug (typically the folder name).
          'source'             => 'https://avas.live/revslider/revslider.zip', // The plugin source.
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
      ];
    }

    // Crypto News
    if ( $_GET['import'] === '28' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
      ];
    }

    // Cyber Security Services
    if ( $_GET['import'] === '29' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'MC4WP: Mailchimp for WordPress', 'avas' ), // The plugin name.
          'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // Design Agency
    if ( $_GET['import'] === '31' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
      ];
    }

    // Designer
    if ( $_GET['import'] === '32' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
      ];
    }

    // Digital Agency Two
    if ( $_GET['import'] === '34' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'MC4WP: Mailchimp for WordPress', 'avas' ), // The plugin name.
          'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // Digital Marketing Agency
    if ( $_GET['import'] === '35' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'MC4WP: Mailchimp for WordPress', 'avas' ), // The plugin name.
          'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // eBook
    if ( $_GET['import'] === '37' ) {

      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Woocommerce', 'avas' ), // The plugin name.
          'slug'               => 'woocommerce', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'WPC Smart Quick View for WooCommerce', 'avas' ), // The plugin name.
          'slug'               => 'woo-smart-quick-view', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'WPC Smart Wishlist for WooCommerce', 'avas' ), // The plugin name.
          'slug'               => 'woo-smart-wishlist', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'WPC Smart Compare for WooCommerce', 'avas' ), // The plugin name.
          'slug'               => 'woo-smart-compare', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Slider Revolution', 'avas' ), // The plugin name.
          'slug'               => 'revslider', // The plugin slug (typically the folder name).
          'source'             => 'https://avas.live/revslider/revslider.zip', // The plugin source.
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // Education
    if ( $_GET['import'] === '38' ) {

      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'LearnPress', 'avas' ), // The plugin name.
          'slug'               => 'learnpress', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'LearnPress Course Review', 'avas' ), // The plugin name.
          'slug'               => 'learnpress-course-review', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Slider Revolution', 'avas' ), // The plugin name.
          'slug'               => 'revslider', // The plugin slug (typically the folder name).
          'source'             => 'https://avas.live/revslider/revslider.zip', // The plugin source.
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // Education Two
    if ( $_GET['import'] === '39' ) {

      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'LearnPress', 'avas' ), // The plugin name.
          'slug'               => 'learnpress', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'LearnPress Course Review', 'avas' ), // The plugin name.
          'slug'               => 'learnpress-course-review', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Slider Revolution', 'avas' ), // The plugin name.
          'slug'               => 'revslider', // The plugin slug (typically the folder name).
          'source'             => 'https://avas.live/revslider/revslider.zip', // The plugin source.
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // Events
    if ( $_GET['import'] === '40' ) {

      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'The Events Calendar', 'avas' ), // The plugin name.
          'slug'               => 'the-events-calendar', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Slider Revolution', 'avas' ), // The plugin name.
          'slug'               => 'revslider', // The plugin slug (typically the folder name).
          'source'             => 'https://avas.live/revslider/revslider.zip', // The plugin source.
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // Forum
    if ( $_GET['import'] === '43' ) {

      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'bbPress', 'avas' ), // The plugin name.
          'slug'               => 'bbpress', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // ICO Cryptocurrency
    if ( $_GET['import'] === '47' ) {

      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        
      ];
    }

    // Immigration Visa Consulting
    if ( $_GET['import'] === '48' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'MC4WP: Mailchimp for WordPress', 'avas' ), // The plugin name.
          'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // Insurance Two
    if ( $_GET['import'] === '50' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'MC4WP: Mailchimp for WordPress', 'avas' ), // The plugin name.
          'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Prime Slider', 'avas' ), // The plugin name.
          'slug'               => 'bdthemes-prime-slider-lite', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // ISP
    if ( $_GET['import'] === '52' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'MC4WP: Mailchimp for WordPress', 'avas' ), // The plugin name.
          'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // IT Solutions
    if ( $_GET['import'] === '53' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'MC4WP: Mailchimp for WordPress', 'avas' ), // The plugin name.
          'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // Magazine
    if ( $_GET['import'] === '56' ) {

      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
      ];
    }

    // Movers
    if ( $_GET['import'] === '59' ) {

      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
      ];
    }

    // News Dark
    if ( $_GET['import'] === '61' ) {

      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
      ];
    }

    // Pest Control
    if ( $_GET['import'] === '63' ) {

      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'MC4WP: Mailchimp for WordPress', 'avas' ), // The plugin name.
          'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
      ];
    }

    // Pet Care
    if ( $_GET['import'] === '64' ) {

      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'MC4WP: Mailchimp for WordPress', 'avas' ), // The plugin name.
          'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Woocommerce', 'avas' ), // The plugin name.
          'slug'               => 'woocommerce', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'WPC Smart Quick View for WooCommerce', 'avas' ), // The plugin name.
          'slug'               => 'woo-smart-quick-view', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'WPC Smart Wishlist for WooCommerce', 'avas' ), // The plugin name.
          'slug'               => 'woo-smart-wishlist', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'WPC Smart Compare for WooCommerce', 'avas' ), // The plugin name.
          'slug'               => 'woo-smart-compare', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // Pinterest
    if ( $_GET['import'] === '66' ) {

      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
      ];
    }

    // Portfolio
    if ( $_GET['import'] === '67' ) {

      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'MC4WP: Mailchimp for WordPress', 'avas' ), // The plugin name.
          'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
      ];
    }

    // Printing Services
    if ( $_GET['import'] === '68' ) {

      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'MC4WP: Mailchimp for WordPress', 'avas' ), // The plugin name.
          'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Woocommerce', 'avas' ), // The plugin name.
          'slug'               => 'woocommerce', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'WPC Smart Quick View for WooCommerce', 'avas' ), // The plugin name.
          'slug'               => 'woo-smart-quick-view', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'WPC Smart Wishlist for WooCommerce', 'avas' ), // The plugin name.
          'slug'               => 'woo-smart-wishlist', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'WPC Smart Compare for WooCommerce', 'avas' ), // The plugin name.
          'slug'               => 'woo-smart-compare', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // Real Estate
    if ( $_GET['import'] === '70' ) {

      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Estatik', 'avas' ), // The plugin name.
          'slug'               => 'estatik', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Slider Revolution', 'avas' ), // The plugin name.
          'slug'               => 'revslider', // The plugin slug (typically the folder name).
          'source'             => 'https://avas.live/revslider/revslider.zip', // The plugin source.
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];

    }

    // Resume
    if ( $_GET['import'] === '72' ) {

      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
      ];
    }

    // SaaS
    if ( $_GET['import'] === '74' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'MC4WP: Mailchimp for WordPress', 'avas' ), // The plugin name.
          'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // Shop
    if ( $_GET['import'] === '76' ) {

      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Woocommerce', 'avas' ), // The plugin name.
          'slug'               => 'woocommerce', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'WPC Smart Quick View for WooCommerce', 'avas' ), // The plugin name.
          'slug'               => 'woo-smart-quick-view', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'WPC Smart Wishlist for WooCommerce', 'avas' ), // The plugin name.
          'slug'               => 'woo-smart-wishlist', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'WPC Smart Compare for WooCommerce', 'avas' ), // The plugin name.
          'slug'               => 'woo-smart-compare', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Slider Revolution', 'avas' ), // The plugin name.
          'slug'               => 'revslider', // The plugin slug (typically the folder name).
          'source'             => 'https://avas.live/revslider/revslider.zip', // The plugin source.
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // Technology
    if ( $_GET['import'] === '79' ) {
      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'MC4WP: Mailchimp for WordPress', 'avas' ), // The plugin name.
          'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Slider Revolution', 'avas' ), // The plugin name.
          'slug'               => 'revslider', // The plugin slug (typically the folder name).
          'source'             => 'https://avas.live/revslider/revslider.zip', // The plugin source.
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }

    // Transportation & logistics
    if ( $_GET['import'] === '80' ) {

      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
      ];
    }

    // Yoga
    if ( $_GET['import'] === '85' ) {

      $theme_plugins = [
        [
          'name'               => esc_html__( 'Elementor', 'avas' ), // The plugin name.
          'slug'               => 'elementor', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Contact Form 7', 'avas' ), // The plugin name.
          'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'The Events Calendar', 'avas' ), // The plugin name.
          'slug'               => 'the-events-calendar', // The plugin slug (typically the folder name).
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],
        [
          'name'               => esc_html__( 'Slider Revolution', 'avas' ), // The plugin name.
          'slug'               => 'revslider', // The plugin slug (typically the folder name).
          'source'             => 'https://avas.live/revslider/revslider.zip', // The plugin source.
          'required'           => true, // If false, the plugin is only 'recommended' instead of required.
        ],

      ];
    }
 
    

  }
 
  return array_merge( $plugins, $theme_plugins );
}
add_filter( 'ocdi/register_plugins', 'tx_register_plugins' );

/* ---------------------------------------------------------
    EOF
------------------------------------------------------------ */