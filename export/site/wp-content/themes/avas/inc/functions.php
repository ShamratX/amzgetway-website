<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/
* ======================================================================
* functions for header, footer, etc.
* ======================================================================
*/

/* ---------------------------------------------------------
  Mobile version enable / disable
------------------------------------------------------------ */
add_action( 'wp_head', 'tx_mob_desk_switch', 0 );

if ( ! function_exists( 'tx_mob_desk_switch' ) ) :
  function tx_mob_desk_switch() {
      if ( tx_is_enabled('mob_version') ) {
          echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">';
      }
  }
endif;
/* ---------------------------------------------------------
  Welcome
------------------------------------------------------------ */
function tx_welcome_js() { ?>
        <script>
          jQuery(document).ready(function($){'use strict';      
            $('.tx-wel-wrap').css('opacity', '1');
          });
        </script>
<?php }

/* ---------------------------------------------------------
  Layout
------------------------------------------------------------ */
// page layout
if ( ! function_exists('tx_page_layout') ) :
  function tx_page_layout() {
    $layout = tx_get_option('page-layout', 'full-width'); // default to 'full-width'

    if ( $layout === 'full-width' ) {
      echo '-fluid';
    } elseif ( $layout === 'boxed' ) {
      echo '';
    } else {
      echo '-fluid'; // fallback for unexpected values
    }
  }
endif;

// header layout
if ( ! function_exists('tx_header_layout') ) :
  function tx_header_layout() {
    $layout = tx_get_option('header-layout', 'boxed'); // default to 'boxed'

    if ( $layout === 'width' ) {
      echo '-fluid';
    }
    // 'boxed' or anything else: echo nothing
  }
endif;
/* ---------------------------------------------------------
  Header Style
------------------------------------------------------------ */
if ( ! function_exists('tx_header_style') ) :

function tx_header_style() {
    if ( ! tx_is_enabled('header_on_off') ) {
        return;
    }

    $header_style = tx_get_option('header-select', 'header3');

    $allowed_headers = [
        'header1', 'header2', 'header3', 'header4', 'header5',
        'header6', 'header7', 'header8', 'header9', 'header10', 'header11'
    ];

    if ( in_array( $header_style, $allowed_headers, true ) ) {
        $style_number = str_replace('header', '', $header_style);
        get_template_part( 'template-parts/header/style/style', $style_number );
    }
}

endif;

/* ---------------------------------------------------------
   Add header style 10 class on body
------------------------------------------------------------ */
add_filter( 'body_class', 'tx_header_style_ten_class' );
function tx_header_style_ten_class( $classes ) {
    $header_style = tx_get_option( 'header-select', '' );

    if ( $header_style === 'header10' ) {
        $classes[] = 'tx_header_style_10';
    }

    return $classes;
}

/* ---------------------------------------------------------
   Favicon
------------------------------------------------------------ */
add_action('wp_head', 'tx_favicon');

if ( ! function_exists('tx_favicon') ) :
function tx_favicon() {
    if ( function_exists( 'has_site_icon' ) && has_site_icon() ) {
        return; // Use WordPress native site icon if set
    }

    $favicon = tx_get_option('favicon'); // Expected to be an array with 'url' key

    if ( ! empty( $favicon['url'] ) ) {
        echo '<link rel="shortcut icon" type="image/x-icon" href="' . esc_url( $favicon['url'] ) . '"/>';
    } else {
        echo '<link rel="shortcut icon" type="image/x-icon" href="' . esc_url( TX_IMAGES . 'icon.png' ) . '"/>';
    }
}
endif;

/* ---------------------------------------------------------
   Logo
------------------------------------------------------------ */
if ( ! function_exists('tx_logo') ) :
function tx_logo() {
    $site_name = esc_attr( get_bloginfo('name') );
    $site_url  = esc_url( get_site_url() );

    $logo_link = tx_get_option('logo_link_url');
    $logo_link = ! empty( $logo_link ) ? esc_url( $logo_link ) : $site_url;

    $logo_desktop        = tx_get_option('tx_logo');
    $logo_mobile         = tx_get_option('tx_logo_mobile');
    $logo_sticky         = tx_get_option('tx_logo_sticky');
    $logo_mobile_sticky  = tx_get_option('tx_logo_mobile_sticky');
    $is_sticky_enabled   = tx_is_enabled('sticky_header');

    // Desktop Logo
    if ( ! empty($logo_desktop['url']) && ! wp_is_mobile() ) {
        echo '<a class="navbar-brand tx_logo" href="' . $logo_link . '" title="' . $site_name . '">';
        echo '<img src="' . esc_url($logo_desktop['url']) . '" alt="' . $site_name . '">';
        echo '</a>';
    }

    // Mobile Logo
    if ( ! empty($logo_mobile['url']) && wp_is_mobile() ) {
        echo '<a class="navbar-brand tx_logo" href="' . $logo_link . '" title="' . $site_name . '">';
        echo '<img src="' . esc_url($logo_mobile['url']) . '" alt="' . $site_name . '">';
        echo '</a>';
    }

    // Sticky Logos
    if ( $is_sticky_enabled ) {
        // Desktop Sticky
        if ( ! empty($logo_sticky['url']) && ! wp_is_mobile() ) {
            echo '<a class="navbar-brand tx_logo tx_sticky_logo" href="' . $logo_link . '" title="' . $site_name . '">';
            echo '<img src="' . esc_url($logo_sticky['url']) . '" alt="' . $site_name . '">';
            echo '</a>';
        }

        // Mobile Sticky
        if ( ! empty($logo_mobile_sticky['url']) && wp_is_mobile() ) {
            echo '<a class="navbar-brand tx_logo tx_sticky_logo" href="' . $logo_link . '" title="' . $site_name . '">';
            echo '<img src="' . esc_url($logo_mobile_sticky['url']) . '" alt="' . $site_name . '">';
            echo '</a>';
        }
    }

    // Fallback
    if ( ! class_exists('ReduxFramework') && has_custom_logo() ) {
        $custom_logo_id  = get_theme_mod('custom_logo');
        $custom_logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');
        echo '<a class="navbar-brand tx_logo" href="' . $site_url . '">';
        echo '<img src="' . esc_url($custom_logo_url) . '" alt="' . $site_name . '">';
        echo '</a>';
    } elseif ( ! class_exists('ReduxFramework') ) {
        echo '<a class="navbar-brand tx_logo" href="' . $site_url . '">';
        echo '<h1>' . $site_name . '</h1>';
        echo '</a>';
    }
}
endif;
add_action( 'tx_logo', 'tx_logo' );

/* ---------------------------------------------------------
  Search popup
------------------------------------------------------------ */
add_action( 'tx_search', 'tx_search' );
if (!function_exists('tx_search')) :
  
  function tx_search() { ?>
    <div id="search" class="tx-search-form-wrap">
      <form role="search" id="search-form" class="search-box" action="<?php echo esc_url(home_url('/')); ?>" method="get">
          <input type="search" required="" aria-required="true" name="s" placeholder="<?php esc_html_e('Type here & press Enter','avas'); ?>" value="<?php echo get_search_query(); ?>">
          <span class="search-close"><i class="bi bi-x-lg"></i></span>
      </form>
    </div>
<?php
  }
endif;  
                      

/* ---------------------------------------------------------
  Menu Button
------------------------------------------------------------ */
add_action( 'tx_menu_btn', 'tx_menu_btn' );
if ( ! function_exists('tx_menu_btn') ) :
  function tx_menu_btn() {
    if ( tx_is_enabled('menu_btn_switch') ) {
      $btn_url = tx_get_option('menu_btn_url', '');
      $btn_txt = tx_get_option('menu_btn_txt', '');

      if ( $btn_url || $btn_txt ) : ?>
        <div class="tx-menu-btn-wrap">
          <a href="<?php echo esc_url( $btn_url ); ?>" <?php tx_menu_btn_link_new_window(); ?> class="tx-menu-btn">
            <?php echo wp_kses_post( $btn_txt ); ?>
          </a>
        </div>
      <?php endif;
    }
  }
endif;

/* ---------------------------------------------------------
  menu button link open in new window target = _blank
------------------------------------------------------------ */
if ( ! function_exists('tx_menu_btn_link_new_window') ) :
  function tx_menu_btn_link_new_window() {
      if ( tx_is_enabled('menu_btn_link_new_window') ) {
          echo 'target="_blank"';
      }
  }
endif;

/* ---------------------------------------------------------
  Search Icon
------------------------------------------------------------ */
add_action( 'tx_search_icon', 'tx_search_icon' );
if ( ! function_exists('tx_search_icon') ) :

  function tx_search_icon() {
      if ( tx_is_enabled('search') ) {
          echo '<a class="search-icon" href="#search"><i class="bi bi-search"></i></a>';
      }
  }
endif;

/* ---------------------------------------------------------
    Side Menu / Hamburger Icon
------------------------------------------------------------ */
add_action('tx_sidemenu_icon', 'tx_sidemenu_icon');
function tx_sidemenu_icon() {
    if ( tx_is_enabled('side_menu') ) : ?>
        <a id="side-menu-icon" class="side_menu_icon"
           data-toggle="collapse"
           href="#side-menu-wrapper"
           role="button"
           aria-expanded="false"
           aria-controls="side-menu-wrapper">
           <i class="bi bi-list"></i>
        </a>
    <?php endif;
}


/* ---------------------------------------------------------
  Header Banner Ads
------------------------------------------------------------ */
if (!function_exists('tx_head_ads')) :
  function tx_head_ads() {
    $banner_enabled = tx_get_option('banner-bussiness-switch');
    $ads_type       = tx_get_option('h_ads_switch'); // 1 = image, 2 = JS
    $ad_img         = tx_get_option('head_ad_banner');
    $ad_link        = tx_get_option('head_ad_banner_link');
    $ad_js          = tx_get_option('head_ad_js');

    if ( $banner_enabled === '1' ) :
        ?>
        <div class="tx_h_a">
            <?php if ( $ads_type === '1' && ! empty($ad_img) && ! empty($ad_img['url']) ) : ?>
                <a href="<?php echo esc_url($ad_link); ?>" <?php tx_head_ad_banner_link_new_window(); ?>>
                    <img src="<?php echo esc_url($ad_img['url']); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" />
                </a>
            <?php elseif ( $ads_type === '2' && ! empty($ad_js) ) : ?>
                <?php echo do_shortcode($ad_js); ?>
            <?php endif; ?>
        </div>
        <?php
    endif;
}
endif;


/* ---------------------------------------------------------
  News Ticker
------------------------------------------------------------ */
if (!function_exists('tx_news_ticker')) :
  
  function tx_news_ticker() {
    $cat_ids     = tx_get_option('news_ticker_categories');
    $post_count  = tx_get_option('newsticker-posts-per-page', 5);
    $order       = tx_get_option('news_ticker_order', 'DESC');
    $orderby     = tx_get_option('news_ticker_orderby', 'date');
    $bar_text    = tx_get_option('news_ticker_bar_text', 'Latest News');

    $query_args = [
        'posts_per_page' => $post_count,
        'order'          => $order,
        'nopaging'       => false,
        'meta_key'       => 'post_views_count',
        'orderby'        => $orderby,
        'post_status'    => 'publish',
    ];

    if (!empty($cat_ids)) {
        $query_args['cat'] = $cat_ids;
    }

    $args = new WP_Query($query_args);

    if ($args->have_posts()) {
        ?>
        <div class="news-ticker-wrap d-flex align-items-center">
            <div class="tx_news_ticker_main">
                <div class="tx_news_ticker_bar">
                    <?php echo esc_html__($bar_text, 'avas'); ?>
                </div>
            </div>

            <div id="news-ticker" class="news-ticker owl-carousel d-flex align-items-center">
                <?php while ($args->have_posts()) : $args->the_post(); ?>
                    <div class="news-inner">
                        <?php the_title(sprintf('<h6 class="news-ticker-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h6>'); ?>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>
        <?php
    }
}
endif;
add_action( 'tx_news_ticker', 'tx_news_ticker' );
/* ---------------------------------------------------------
  ads link open in new window target = _blank
------------------------------------------------------------ */
if ( ! function_exists('tx_head_ad_banner_link_new_window') ) :

function tx_head_ad_banner_link_new_window() {
    if ( tx_is_enabled('head_ad_banner_link_new_window') ) {
        echo 'target="_blank"';
    }
}

endif;

/* ---------------------------------------------------------
  Insert ads after paragraph of single post content.
------------------------------------------------------------ */
function tx_insert_post_ads( $content ) {
    // Skip admin or non-posts
    if ( ! is_singular( 'post' ) || is_admin() ) {
        return $content;
    }

    if ( ! tx_is_enabled( 'post_ads' ) ) {
        return $content;
    }

    $banner_url   = tx_get_option( 's_ad_banner_link', '' );
    $banner_image = tx_get_option( 's_ad_banner' );
    $banner_image_url = ! empty( $banner_image['url'] ) ? $banner_image['url'] : '';
    $after_p      = tx_get_option( 's_ads_after_p', 2 );
    $ad_js        = tx_get_option( 's_ad_js', '' );
    $ads_switch   = tx_is_enabled( 's_ads_switch' );

    $img_code = '';
    $js_code  = '';

    if ( $banner_image_url ) {
        $img_code = '<div class="ad_300_250"><a href="' . esc_url( $banner_url ) . '"><img src="' . esc_url( $banner_image_url ) . '" alt="ads" ></a></div>';
    }

    if ( $ad_js ) {
        $js_code = '<div class="ad_300_250">' . wp_kses_post( $ad_js ) . '</div>';
    }

    if ( $ads_switch && $img_code ) {
        return tx_insert_after_paragraph( $img_code, $after_p, $content );
    }

    if ( $js_code ) {
        return tx_insert_after_paragraph( $js_code, $after_p, $content );
    }

    return $content;
}
add_filter( 'the_content', 'tx_insert_post_ads' );
  
// Parent Function that makes the magic happen
function tx_insert_after_paragraph( $insertion, $paragraph_id, $content ) {
    $closing_p = '</p>';
    $paragraphs = explode( $closing_p, $content );
    foreach ($paragraphs as $index => $paragraph) {
 
        if ( trim( $paragraph ) ) {
            $paragraphs[$index] .= $closing_p;
        }
 
        if ( $paragraph_id == $index + 1 ) {
            $paragraphs[$index] .= $insertion;
        }
    }
     
    return implode( '', $paragraphs );
}

/* ---------------------------------------------------------
  Sticky Header
------------------------------------------------------------ */
if ( ! function_exists('tx_sticky_header') ) :

function tx_sticky_header() {
    echo tx_is_enabled('sticky_header') ? 'float-panel' : 'no-sticky';
}

endif;

/* ---------------------------------------------------------
  Footer layout
------------------------------------------------------------ */
if ( ! function_exists('tx_footer_width') ) :
function tx_footer_width() {
    $layout = tx_get_option('footer_layout', 'boxed'); // default to 'boxed'

    if ( $layout === 'width' ) {
        echo '-fluid';
    }
    // If boxed or unknown, echo nothing
}
endif;

/* ---------------------------------------------------------
  Footer Style
------------------------------------------------------------ */
add_action( 'footer-style', 'tx_footer_style' );
if ( ! function_exists('tx_footer_style') ) :
  function tx_footer_style() {
    $footer_style = tx_get_option('footer-select', 'footer2'); // default from Redux config

    switch ( $footer_style ) {
      case 'footer1':
        get_template_part( 'template-parts/footer/style/style', '1' );
        break;

      case 'footer2':
        get_template_part( 'template-parts/footer/style/style', '2' );
        break;

      case 'footer3':
        get_template_part( 'template-parts/footer/style/style', '3' );
        break;
    }
  }

endif;

/* ---------------------------------------------------------
  Cookie Notice Bar
------------------------------------------------------------ */

add_action( 'wp_footer', 'tx_cookieconsent', 900 );

function tx_cookieconsent() {
    if ( ! tx_is_enabled('cookie_notice') ) {
        return;
    }

    ?>
    <script>
        'use strict';
        const cc = new CookieConsent({
            type: 'opt-out',
            content: {
                header: '<?php echo esc_html__( 'Cookies used on the website!', 'avas' ); ?>',
                message: '<?php echo wp_kses_post( tx_get_option('cookie_notice_text', '') ); ?>',
                dismiss: '<?php echo esc_attr( tx_get_option('cookie_notice_accept', 'Got it') ); ?>',
                link: '<?php echo esc_attr( tx_get_option('cookie_notice_learnmore_text', 'Learn more') ); ?>',
                href: '<?php echo esc_url( tx_get_option('cookie_notice_learnmore_link', '#' ) ); ?>',
                target: '_blank',
                policy: ''
            },
            elements: {
                deny: '',
            },
            cookie: {
                expiryDays: '<?php echo esc_attr( tx_get_option('cookie_expiry', '30') ); ?>',
                domain: '',
            },
            position: '<?php echo esc_attr( tx_get_option('cookie_notice_position', 'bottom') ); ?>',
        });
    </script>
    <?php
}

 /* ---------------------------------------------------------
  Dark Mode
------------------------------------------------------------ */
add_action( 'wp_footer', 'tx_dark_mode' );
function tx_dark_mode() {
    if ( ! tx_is_enabled( 'tx_dark_mode' ) ) {
        return;
    }

    ?>
    <script>
      jQuery(document).ready(function($){'use strict';

          var options = {
            bottom: '45px',
            right: '90px',
            left: 'unset',
            time: '0.5s',
            mixColor: '<?php echo esc_attr( tx_get_option("darkmode_mixcolor", "#ffffff") ); ?>',
            backgroundColor: '<?php echo esc_attr( tx_get_option("darkmode_bgcolor", "#ffffff") ); ?>',
            buttonColorDark: '<?php echo esc_attr( tx_get_option("darkmode_btncolordark", "#100f2c") ); ?>',
            buttonColorLight: '<?php echo esc_attr( tx_get_option("darkmode_btncolorlight", "#ffffff") ); ?>',
            saveInCookies: <?php echo tx_get_option("darkmode_saveInCookies", true ) ? 'true' : 'false'; ?>,
            label: '🌓',
            autoMatchOsTheme: <?php echo tx_get_option("darkmode_autoMatchOsTheme", true ) ? 'true' : 'false'; ?>
          };

          const darkmode = new Darkmode(options);

          <?php if ( tx_is_enabled('tx_dark_mode_toggle') ) : ?>
              darkmode.toggle(); // enable dark mode on load
          <?php endif; ?>

          <?php if ( tx_is_enabled('tx_dark_mode_btn') ) : ?>
              darkmode.showWidget(); // show widget
          <?php endif; ?>

      });
    </script>
    <?php
}

/* ---------------------------------------------------------
  Active Modal
------------------------------------------------------------ */

function tx_active_modal() {

 if( isset($_GET["page"]) && $_GET["page"] == "Welcome") { 
    return;
  } elseif(is_admin()) {

    ?>
  <div id="tx_register_notice" class="tx_active_modal_register">
      <p class="tx_active_modal_register"><?php echo esc_html_e('Please register the Avas theme to unlock all the features.','avas'); ?></p>
      <a href="<?php echo esc_url(admin_url('admin.php?page=Welcome')); ?>" class="button button-primary"><?php echo esc_html_e('Register','avas');?> </a>
      
  </div>
<?php }

}

/* ---------------------------------------------------------
    Theme Updates
------------------------------------------------------------ */

add_filter ( 'pre_set_site_transient_update_themes', 'tx_update_theme' );
  function tx_update_theme ( $transient ) {
 if( empty( $transient->checked['avas'] ) )
    return $transient;

  $ch = curl_init();
 
  curl_setopt($ch, CURLOPT_URL, TX_DEMO_URL.'avas.json' );
 
 // 3 second timeout to avoid issue on the server
 curl_setopt($ch, CURLOPT_TIMEOUT, 3 ); 
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

 $result = curl_exec($ch);
 curl_close($ch);

 // make sure that we received the data in the response is not empty
 if( empty( $result ) )
   return $transient;

 //check server version against current installed version
 if( $data = json_decode( $result ) ){
   if( version_compare( $transient->checked['avas'], $data->new_version, '<' ) )
 $transient->response['avas'] = (array) $data;
 }
 
 return $transient;

}

/* ---------------------------------------------------------
  Single Team Social Icons
------------------------------------------------------------ */
add_action('tx_single_team_social_icons', 'tx_single_team_social_icons');
function tx_single_team_social_icons() {
  global $post;
  $team_fb = get_post_meta( $post->ID, 'team_fb', true );
  $team_tw = get_post_meta( $post->ID, 'team_tw', true );
  $team_gp = get_post_meta( $post->ID, 'team_gp', true );
  $team_ln = get_post_meta( $post->ID, 'team_ln', true );
  $team_in = get_post_meta( $post->ID, 'team_in', true );
  
  if (!empty($team_fb || $team_tw || $team_gp || $team_ln || $team_in) ) : ?>       
        <ul class="team-social">
              <?php if (!empty($team_fb)) : ?>
              <li><a href="<?php echo esc_url($team_fb); ?>" target="_blank"><i class="fab fa-facebook"></i></a></li>
              <?php endif; ?>
              <?php if (!empty($team_tw)) : ?>
              <li><a href="<?php echo esc_url($team_tw); ?>" target="_blank"><i class="fab fa-twitter"></i></a></li>
              <?php endif; ?>
              <?php if (!empty($team_gp)) : ?>
              <li><a href="<?php echo esc_url($team_gp); ?>" target="_blank"><i class="fab fa-youtube"></i></a></li>
              <?php endif; ?>
              <?php if (!empty($team_ln)) : ?>
              <li><a href="<?php echo esc_url($team_ln); ?>" target="_blank"><i class="fab fa-linkedin"></i></a></li>
              <?php endif; ?>
              <?php if (!empty($team_in)) : ?>
              <li><a href="<?php echo esc_url($team_in); ?>" target="_blank"><i class="fab fa-instagram"></i></a></li>
              <?php endif; ?>
        </ul>
        <?php endif;
}


/* ---------------------------------------------------------
  Single team header
------------------------------------------------------------ */
add_action('tx_single_team_header', 'tx_single_team_header');
function tx_single_team_header() { ?>
  <header class="team-title">
    <h2 class="team-name"><?php the_title(); ?></h2>
  <?php
    global $post;
    $terms = get_the_terms( $post->ID, 'team-category' );
    if ( $terms && ! is_wp_error( $terms ) ) :
      $taxonomy = array();
      foreach ( $terms as $term ) :
        $taxonomy[] = $term->name;
      endforeach;
      $cat_name = join( " ", $taxonomy);
      $cat_link = get_term_link( $term );
    else:
      $cat_name = '';
    endif;
    if(!empty($cat_name)) : ?>
      <p class="team-cat"><a href="<?php echo esc_url($cat_link); ?>"><?php echo esc_html($cat_name); ?></a></p>
    <?php endif; ?>  
  </header>
<?php
}

/* ---------------------------------------------------------
  keyboard accessible drop-down menu
------------------------------------------------------------ */
  add_action('wp_footer', 'tx_keyboard_accessible_drop_down_menu'); 
function tx_keyboard_accessible_drop_down_menu() {
    if ( ! tx_is_enabled('keyboard_accessible_dropdown_menu') ) {
        return;
    }
    ?>
    <script>
    jQuery(document).ready(function($) {
        "use strict";
        $(".menu-item-has-children > a").focus(function(){
            $(this).siblings(".sub-menu").addClass("tx_focused")
        }).blur(function(){
            $(this).siblings(".sub-menu").removeClass("tx_focused")
        });

        $(".sub-menu a").focus(function(){
            $(this).parents(".sub-menu").addClass("tx_focused")
        }).blur(function(){
            $(this).parents(".sub-menu").removeClass("tx_focused")
        });
    });
    </script>
    <?php
}

/* ---------------------------------------------------------
  Reader Progress-bar
------------------------------------------------------------ */
  add_action('wp_footer', 'tx_scroll_progress_bar'); 
  function tx_scroll_progress_bar() {
      if ( ! tx_is_enabled('scroll-progress-bar') ) {
          return;
      }
      ?>
      <script>
          jQuery(document).ready(function($){'use strict';
              $(document).topProgressBar({});
          });
      </script>
      <?php
  }

/* ---------------------------------------------------------
  One Page Navigation
------------------------------------------------------------ */
  add_action('wp_footer', 'tx_one_page_nav');
  function tx_one_page_nav() {
      if ( ! tx_is_enabled('one_page_nav') ) {
          return;
      }
      ?>
      <script>
          jQuery(document).ready(function($){'use strict';
              $('.main-menu').onePageNav();
          });
      </script>
      <?php
  }


/* ---------------------------------------------------------
  Custom fonts
------------------------------------------------------------ */


function tx_get_uploaded_custom_fonts() {
    // Array: 'FontFamilyName' => Redux option key
    $fonts = [
        'CustomFont'    => 'tx_custom_font_ttf',
        'CustomFontTwo' => 'tx_custom_font_two',
        // Add more as needed
    ];

    $registered = [];
    foreach ( $fonts as $family => $opt_key ) {

        $opt = tx_get_option( $opt_key );
        $url = is_array( $opt ) ? ($opt['url'] ?? '') : $opt;


        if ( $url ) {
            $registered[ $family ] = $url;
        }
    }
    return $registered; // ['CustomFont' => 'url', ...]
}

/**
 * Enqueue all @font-face rules for uploaded fonts only
 */
function tx_enqueue_custom_fonts() {
    $fonts = tx_get_uploaded_custom_fonts();
    $css = '';
    foreach ( $fonts as $family => $url ) {
        // Fix protocol for mixed content
        if ( is_ssl() ) {
            $url = preg_replace( '/^http:/i', 'https:', $url );
        }
        $css .= "
          @font-face {
            font-family: '{$family}';
            src: url('" . esc_url( $url ) . "') format('truetype');
            font-weight: 400;
            font-style: normal;
          }
        ";
    }
    if ( $css ) {
        wp_add_inline_style( 'elementor-frontend', $css );
        wp_add_inline_style( 'elementor-editor',   $css );
    }
}
add_action( 'wp_enqueue_scripts',                       'tx_enqueue_custom_fonts', 20 );
add_action( 'elementor/frontend/after_enqueue_styles',  'tx_enqueue_custom_fonts', 20 );
add_action( 'elementor/preview/enqueue_styles',         'tx_enqueue_custom_fonts', 20 );
add_action( 'elementor/editor/after_enqueue_styles',    'tx_enqueue_custom_fonts', 20 );

/**
 * Register only the uploaded fonts in Elementor
 */
add_action( 'elementor/init', function() {
    add_filter( 'elementor/fonts/groups', function( $groups ) {
        // Show "Avas Custom Font" group only if there are fonts
        if ( ! tx_get_uploaded_custom_fonts() ) return $groups;
        return [ 'tx-custom-fonts' => __( 'Avas Custom Font', 'avas' ) ] + $groups;
    } );

    add_filter( 'elementor/fonts/additional_fonts', function( $elementor_fonts ) {
        $fonts = tx_get_uploaded_custom_fonts();
        $customs = [];
        foreach ( $fonts as $family => $url ) {
            $customs[ $family ] = 'tx-custom-fonts';
        }
        return $customs + $elementor_fonts;
    } );
} );




/* ---------------------------------------------------------
  EOF
------------------------------------------------------------ */