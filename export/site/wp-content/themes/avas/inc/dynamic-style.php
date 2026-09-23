<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/

/* ---------------------------------------------------------
  Dynamic styles
------------------------------------------------------------ */
if ( !function_exists( 'tx_custom_css' ) ) :
  add_action('wp_head', 'tx_custom_css');
  function tx_custom_css() {
    // cumstom header background image support for all header styles
    if ( get_header_image() ) : ?>
      <style type="text/css">
        #h-style-1,#h-style-2,#h-style-3,#h-style-4,#h-style-5,#h-style-6,#h-style-7,#h-style-8,#h-style-9,#h-style-10 {
          background-image: url(<?php header_image(); ?>) !important;
        }
      </style>
    <?php endif;

    // Main header height
    $main_height = tx_get_option('main_header_height');
    $sticky_height = tx_get_option('sticky_main_header_height');

    if ( $main_height || $sticky_height ) : ?>
        <style type="text/css">
            @media (min-width: 991px){
                <?php if ( $main_height ) : ?>
                    .main-header {
                        height: <?php echo esc_attr($main_height); ?>px;
                    }
                <?php endif; ?>
                <?php if ( $sticky_height ) : ?>
                    .main-header.sticky-header {
                        height: <?php echo esc_attr($sticky_height); ?>px;
                    }
                <?php endif; ?>
            }
        </style>
    <?php endif;

    // Sticky header box-shadow enable/disable
    if ( tx_is_enabled('sticky_head_box_shadow_switch') ) : ?>
    <style type="text/css">
        .main-header.sticky-header {
            box-shadow: 0 0 10px 0 rgb(0 0 0 / 15%);
        }
    </style>
    <?php endif;

    // main header banner / business disable on responsive device
    if ( tx_is_enabled('banner-bussiness-switch-responsive') ) : ?>
    <style type="text/css">
        @media (max-device-width: 768px) {
            .main-header-right-area {
                display: none;
            }
        }
    </style>
    <?php endif;

    // Top header height
    $top_header_height = tx_get_option('top_header_height');
    if ( $top_header_height ) : ?>
        <style type="text/css">
            .top-header {
                height: <?php echo esc_attr( $top_header_height ); ?>px;
            }
        </style>
    <?php endif;

    // Top header height for mobile phones
    $top_header_height_mobile = tx_get_option('top_header_height_mobile');
    if ( $top_header_height_mobile ) : ?>
        <style type="text/css">
            @media (max-device-width: 768px) {
                .top-header {
                    height: <?php echo esc_attr( $top_header_height_mobile ); ?>px;
                }
            }
        </style>
    <?php endif;

    // welcome message enable/disable option for mobile phones
    if ( ! tx_is_enabled('wm_switch_res', true) ) : ?>
    <style type="text/css">
        @media(max-width: 767px) {
            .welcome_msg {
                display: none !important;
            }
        }
    </style>
    <?php endif;

    // Date enable/disable option for mobile phones
    if ( ! tx_is_enabled('tx-date_res', true) ) : ?>
    <style type="text/css">
        @media(max-width: 767px) {
            .tx-date {
                display: none !important;
            }
        }
    </style>
    <?php endif;

    // Phone number enable/disable option for mobile phones
   if ( ! tx_is_enabled('tx-phone_res', true) ) : ?>
    <style type="text/css">
        @media(max-width: 767px) {
            .phone-number {
                display: none !important;
            }
        }
    </style>
    <?php endif;

    // Email enable/disable option for mobile phones
    if ( ! tx_is_enabled('tx-email_res', true) ) : ?>
    <style type="text/css">
        @media(max-width: 767px) {
            .email-address {
                display: none !important;
            }
        }
    </style>
    <?php endif;

    // News Ticker enable/disable option for mobile phones
    if ( ! tx_is_enabled('news_ticker_res', true) ) : ?>
    <style type="text/css">
        @media (max-width: 767px) {
            .news-ticker-wrap {
                display: none !important;
            }
        }
    </style>
    <?php endif;

    // News ticker width for responsive devices
    $news_ticker_width = tx_get_option('newsticker_width_res');
    if ( $news_ticker_width ) : ?>
        <style type="text/css">
            @media (max-width: 768px) {
                .news-ticker-wrap {
                    width: <?php echo esc_attr($news_ticker_width); ?>px;
                }
            }
        </style>
    <?php endif;

    // Top Menu enable/disable option for mobile phones
    if ( ! tx_is_enabled( 'top_menu_res', true ) ) : ?>
    <style type="text/css">
        @media (max-width: 767px) {
            #responsive-menu-top {
                display: none !important;
            }
        }
    </style>
    <?php endif;

    // Login Register enable/disable option for mobile phones
    if ( ! tx_is_enabled( 'login_reg_res', true ) ) : ?>
    <style type="text/css">
        @media (max-width: 767px) {
            .login_button {
                display: none !important;
            }
        }
    </style>
    <?php endif;

    // Social icon enable/disable option for mobile phones
    if ( ! tx_is_enabled( 'social_buton_top_res', true ) ) : ?>
    <style type="text/css">
        @media (max-width: 767px) {
            .top-header-right-area .social_media {
                display: none !important;
            }
        }
    </style>
    <?php endif;

    // Subheader height
    $sub_header_height = tx_get_option( 'sub_header_height' );
    if ( $sub_header_height !== false && $sub_header_height !== '' ) : ?>
    <style type="text/css">
        .sub-header {
            height: <?php echo esc_attr( $sub_header_height ); ?>px;
        }
    </style>
    <?php endif;

     // Subheader height for responsive devices
    $sub_header_height_responsive = tx_get_option( 'sub_header_height_responsive' );
    if ( $sub_header_height_responsive !== false && $sub_header_height_responsive !== '' ) : ?>
    <style type="text/css">
        @media (max-width: 768px) {
            .sub-header {
                height: <?php echo esc_attr( $sub_header_height_responsive ); ?>px;
            }
        }
    </style>
    <?php endif;

    // header style 10 position
    if ( tx_get_option('header-style-10-position') === 'right' ) : ?>
    <style type="text/css">
        #h-style-10 { left: auto; right: 0; }
    </style>
    <?php endif; ?>

    <!-- header style 10 width, top header social icon font size, border-radius, body padding -->
    <style type="text/css">
        #h-style-10 {
            width: <?php echo esc_attr( tx_get_option('header-style10-width', 250) ); ?>px;
        }
        #header .top-header-right-area .social li a i {
            font-size: <?php echo esc_attr( tx_get_option('social-media-icon-header-size', 14) ); ?>px;
        }
        #header .top-header-right-area .social li {
            border-radius: <?php echo esc_attr( tx_get_option('social-media-icon-header-border-radius', 0) ); ?>px;
        }
        @media(min-width: 992px) {
            .tx_header_style_10 {
                padding-left: <?php echo esc_attr( tx_get_option('header-style10-width', 250) ); ?>px;
            }
        }
    </style>

    <!-- footer social media icon size -->
    <?php if ( tx_is_enabled( 'social_icons_footer' ) ) : ?>
        <style type="text/css">
            #footer .social_media i {
                font-size: <?php echo esc_attr( tx_get_option( 'social_icons_footer_size', 14 ) ); ?>px;
            }
        </style>
    <?php endif; ?>

    <!-- Preloader -->
    <style type="text/css">
    .tx-main-preloader .tx-preloader-bar-outer {
        height: <?php echo esc_attr( tx_get_option( 'preloader-bar-height', 7 ) ); ?>px;
    }
    </style>
    <!-- LearnPress Course min height -->
  <?php if ( class_exists( 'LearnPress' ) ) : ?>
    <style type="text/css">
        .avas .lp-archive-courses .learn-press-courses[data-layout="grid"] .course .course-item .course-content {
            min-height: <?php echo esc_attr( tx_get_option( 'lp_course_min_height', 360 ) ); ?>px;
        }
    </style>
  <?php endif; ?>
<?php

  // Scroll Progressbar
  $scroll_height = tx_get_option( 'scroll-progress-bar-height', 8 );
  if ( $scroll_height ) :
  ?>
    <style type="text/css">
        .tx-scroll-progress-bar { height: <?php echo esc_attr( $scroll_height ); ?>px; }
    </style>
<?php endif;

  // Header style 1, 2, 4, 6, 7, 8 left alignment
  if ( tx_get_option( 'menu-alignment', 'none' ) === 'left' ) : ?>
    <style type="text/css">
        @media(min-width: 992px) {
            #h-style-1 .menu-bar .container,
            #h-style-2 .menu-bar .container,
            #h-style-4 .menu-bar .container,
            #h-style-6 .menu-bar .container,
            #h-style-7 .menu-bar .container,
            #h-style-8 .menu-bar .container {
                justify-content: left !important;
            }
            #h-style-1 .menu-bar .container .navbar,
            #h-style-2 .menu-bar .container .navbar,
            #h-style-4 .menu-bar .container .navbar,
            #h-style-6 .menu-bar .container .navbar,
            #h-style-7 .menu-bar .container .navbar,
            #h-style-8 .menu-bar .container .navbar {
                margin-right: unset;
            }
        }
    </style>
  <?php endif;

  // Header style 1, 2, 4, 6, 7, 8 center alignment
    if ( tx_get_option( 'menu-alignment' ) === 'center' ) : ?>
    <style type="text/css">
        @media (min-width: 992px) {
            #h-style-1 .menu-bar .container,
            #h-style-2 .menu-bar .container,
            #h-style-4 .menu-bar .container,
            #h-style-6 .menu-bar .container,
            #h-style-7 .menu-bar .container,
            #h-style-8 .menu-bar .container {
                justify-content: center !important;
            }
            #h-style-1 .menu-bar .container .navbar,
            #h-style-2 .menu-bar .container .navbar,
            #h-style-4 .menu-bar .container .navbar,
            #h-style-6 .menu-bar .container .navbar,
            #h-style-7 .menu-bar .container .navbar,
            #h-style-8 .menu-bar .container .navbar {
                margin-right: unset;
            }
        }
    </style>
  <?php endif;

    // Header style 1, 2, 4, 6, 7, 8 right alignment
    if ( tx_get_option( 'menu-alignment', 'none' ) === 'right' ) : ?>
    <style type="text/css">
        @media (min-width: 992px) {
            #h-style-1 .menu-bar .container,
            #h-style-2 .menu-bar .container,
            #h-style-4 .menu-bar .container,
            #h-style-6 .menu-bar .container,
            #h-style-7 .menu-bar .container,
            #h-style-8 .menu-bar .container {
                justify-content: end !important;
            }
        }
    </style>
  <?php endif;
    

    if ( tx_get_option( 'menu-alignment', 'none' ) === 'left' ) : ?>
    <style type="text/css">
        @media (min-width: 992px) {
            .tx_logo {
                margin-right: 20px;
            }
            .navbar {
                margin-right: auto;
            }
        }
    </style>
  <?php endif;


    if ( ! is_rtl() && tx_get_option( 'menu-alignment' ) === 'right' ) : ?>
    <style type="text/css">
        @media(min-width: 992px) {
            .navbar { margin-right: unset; }
        }
    </style>
    <?php endif;

    if ( is_rtl() && tx_get_option( 'menu-alignment' ) === 'right' ) : ?>
        <style type="text/css">
            @media(min-width: 992px) {
                .navbar { margin-right: 0; }
            }
        </style>
    <?php endif;
    if ( is_rtl() && tx_get_option( 'menu-alignment' ) === 'right' ) : ?>
    <style type="text/css">
        @media(min-width: 992px) {
            #h-style-3 .container { justify-content: right !important; }
        }
    </style>
    <?php endif;

    if ( is_rtl() && tx_get_option( 'menu-alignment' ) === 'center' ) : ?>
        <style type="text/css">
            @media(min-width: 992px) {
                .navbar { display: contents; text-align: center; }
            }
        </style>
    <?php endif;
    
    if ( tx_get_option('menu-alignment') === 'center' ) : ?>
    <style type="text/css">
        @media(min-width: 992px) {
            .navbar { margin-right: inherit; }
        }
    </style>
    <?php endif;

    if ( tx_get_option('menu-alignment') === 'center' ) : ?>
    <style type="text/css">
        @media(min-width: 992px) {
            #h-style-11 .navbar { margin-right: unset; }
        }
    </style>
    <?php endif; // style 11
    
    if ( tx_get_option('menu-alignment') === 'right' ) : ?>
    <style type="text/css">
        @media(min-width: 992px) {
            #h-style-11 .container { justify-content: right !important; }
            #h-style-11 .navbar { margin-right: unset; }
        }
    </style>
    <?php endif; // style 11

    if ( is_rtl() && tx_get_option('menu-alignment') === 'right' ) : ?>
    <style type="text/css">
        @media(min-width: 992px) {
            #h-style-11 .tx_logo { margin-right: auto; }
        }
    </style>
    <?php endif;


    // Menu Highlight callouts text button animation
    if ( tx_is_enabled( 'menu-highlight-animation', false ) ) : ?>
    <style type="text/css">
        .tx-menu-highlight { animation: none; }
    </style>
    <?php endif;

    // Menu Item animated border 
    if ( tx_is_enabled( 'menu_item_border', false ) ) : ?>
    <style type="text/css">
        .main-menu > li:hover > a:hover:before { opacity: 1; }
    </style>
    <?php endif;

    // Top border
    if ( tx_get_option('menu_item_border_select') === 'menu_item_border_top' ) : ?>
    <style type="text/css">
        .main-menu > li a:before { top: 0; border-top: 2px solid; }
    </style>
    <?php endif;

    // Bottom border
    if ( tx_get_option('menu_item_border_select') === 'menu_item_border_bottom' ) : ?>
    <style type="text/css">
        .main-menu > li a:before { bottom: 0; border-bottom: 2px solid; }
    </style>
    <?php endif;

    // Menu Item Separator
    if ( tx_is_enabled('menu-item-seprator') ) : ?>
    <style type="text/css">
        .main-menu > li.menu-item-has-children > a:after { display: none; }
    </style>
    <?php endif;

    // menu drop down arrow
    if ( tx_is_enabled('menu-dropdown-icon') ) : ?>
    <style type="text/css">
        .main-menu > li.menu-item-has-children > a:after {
            content: "\f107";
            top: <?php echo esc_attr( tx_get_option('menu-dropdown-icon-valign', 0) ); ?>px;
        }
    </style>
    <?php endif;

    // Mega Menu full-width/box-width
    if ( ! tx_is_enabled('megamenu-full-width', true) ) : ?>
    <style type="text/css">
        .tx-mega-menu .mega-menu-item .depth0:before { width: auto; }
    </style>
    <?php endif;

    // Mega Menu Left Position
    $mega_menu_left = tx_get_option('mega_menu_left_position');
    ?>
    <style type="text/css">
        .tx-mega-menu .mega-menu-item .depth0 { left: <?php echo esc_attr( $mega_menu_left ); ?>%; }
    </style>
<?php
    
    // Responsive menu backgroung color
     $mobile_menu_bg = tx_get_option('mobile-menu-bg-color');
    ?>
    <style type="text/css">
        @media (max-width: 1024px) {
            #tx-res-menu {
                background-color: <?php echo esc_attr( $mobile_menu_bg ); ?>;
            }
        }
    </style>

    <!-- Main Menu Item border-radius -->
    <?php
    $menu_item_radius = tx_get_option('menu_item_border_radius');
    if ( $menu_item_radius ) : ?>
        <style type="text/css">
            .main-menu>li>a,
            .header-style-eight .main-menu>li>a,
            .header-style-four .main-menu>li>a,
            .header-style-one .main-menu>li>a,
            .header-style-seven .main-menu>li>a,
            .header-style-six .main-menu>li>a,
            .header-style-two .main-menu>li>a,
            #h-style-10 .main-menu>li>a {
                border-radius: <?php echo esc_attr( $menu_item_radius ); ?>px;
            }
        </style>
    <?php endif; ?>

    <!-- Responsive Main Menu Icon Text Top -->
    <?php
    $menu_txt_top = tx_get_option('tx-res-menu-txt-top'); ?>
        <style type="text/css">
            .tx-res-menu-txt {
                position: relative;
                top: <?php echo esc_attr($menu_txt_top); ?>px;
            }
        </style>
    <?php

    // Responsive menu item color
    $mobile_menu_item_color = tx_get_option('mobile-menu-item-color');
    ?>
        <style type="text/css">
            @media (max-width: 1024px){
                .navbar-collapse > ul > li > a,
                .navbar-collapse > ul > li > ul > li > a,
                .navbar-collapse > ul > li > ul > li > ul > li > a,
                .navbar-collapse > ul > li > ul > li > ul > li > ul > li > a,
                .navbar-collapse > ul > li > ul > li > ul > li > ul > li > ul > li > a,
                .mb-dropdown-icon:before {
                    color: <?php echo esc_attr($mobile_menu_item_color); ?> !important;
                }
            }
        </style>
    <?php

    // Menu button border radius
    $btn_radius = tx_get_option('menu-btn-border-radius');
    ?>
        <style type="text/css">
            .tx-menu-btn {
                border-radius: <?php echo esc_attr($btn_radius); ?>px;
            }
        </style>
    <?php

    // Logo resize desktop
    $logo_height = tx_get_option('logo-resize');
    if ( $logo_height && $logo_height > 0 ) :
    ?>
        <style>
            .tx_logo img { height: <?php echo esc_attr($logo_height); ?>px; }
        </style>
    <?php endif; ?>

    <?php
    $logo_height_res = tx_get_option('logo-resize-responsive');
    if ( $logo_height_res && $logo_height_res > 0 ) :
    ?>
        <style>
            @media(max-width: 1024px){
                .tx_logo img { height: <?php echo esc_attr($logo_height_res); ?>px; }
            }
        </style>
    <?php endif; ?>
    <?php

    // logo padding mobile

    // header overlay for home page
    if ( tx_is_enabled('header_overlay') ) : ?>
    <style type="text/css">
        .home .tx-header {
            position: absolute;
            left: 0;
            right: 0;
        }
    </style>
    <?php endif;

    // header overlay for inner page
    if ( tx_is_enabled('header_overlay_inner') ) : ?>
    <style type="text/css">
        .sub-header,
        .sub-header-blog {
            position: absolute;
            width: 100%;
            top: 0;
            z-index: 1;
        }
        .page-template-no-sub .tx-header {
            position: absolute;
        }
    </style>
    <?php endif;

  // sticky header enable / disable
     if ( tx_is_enabled('sticky_header') ) : 
    $scroll = tx_get_option('sticky-scroll', 100); // Correct default is 100
?>
    <script>
        jQuery(document).ready(function ($) {
            "use strict";
            $(document).on("scroll", function () {
                if ($(document).scrollTop() >= <?php echo esc_attr($scroll); ?>) {
                    $(".tx-header").addClass("tx-scrolled");
                    $(".main-header").addClass("sticky-header");
                } else {
                    $(".tx-header").removeClass("tx-scrolled");
                    $(".main-header").removeClass("sticky-header");
                }
            });
        });
    </script>
    <?php endif;
     
    if ( ! tx_is_enabled('sticky_header') ) : ?>
    <style type="text/css">
        @media only screen and (max-width: 768px) {
            #h-style-10 {position: relative;}
        }
    </style>
<?php endif;

    if ( ! tx_is_enabled('sticky_main_header') ) : ?>
    <style type="text/css">
        .sticky-header #h-style-2,
        .sticky-header #h-style-4,
        .sticky-header #h-style-6,
        .sticky-header #h-style-7,
        .sticky-header #h-style-8 {
            display: none !important;
        }
        .main-header.sticky-header {
            height: auto;
        }
        @media(min-width: 992px) {
            #h-style-1.sticky-header .tx-main-head-contain,
            #h-style-2.sticky-header .tx-main-head-contain,
            #h-style-4.sticky-header .tx-main-head-contain,
            #h-style-6.sticky-header .tx-main-head-contain,
            #h-style-7.sticky-header .tx-main-head-contain,
            #h-style-8.sticky-header .tx-main-head-contain {
                display: none !important;
            }
        }
    </style>
<?php endif;


    if ( ! tx_is_enabled('sticky_header_mob') ) : ?>
    <style type="text/css">
        @media only screen and (max-width: 768px) {
            .main-header.sticky-header {display: none !important;}
        }
    </style>
<?php endif;

    // Portfolio style    
    global $post;
    if( !is_object($post) ) :
      return;
    endif;

    $gutter = get_post_meta($post->ID, 'gutter', true);
    $gutter_portfoio_archive = tx_get_option('portfolio_archive_gutter', 10);
    if($gutter ) : ?>
      <style type="text/css">
        .page-template-portfolio .tx-portfolio-item {padding:<?php echo esc_attr($gutter); ?>px}
      </style>
    <?php endif;
    if($gutter_portfoio_archive) : ?>
      <style type="text/css">
        .post-type-archive-portfolio .tx-portfolio-item,.tax-portfolio-category .tx-portfolio-item {padding:<?php echo esc_attr($gutter_portfoio_archive); ?>px}
      </style>
    <?php endif;

    // sidebar
    if ( tx_is_enabled('sidebar_shadow_switch') ) : ?>
    <style type="text/css">
        #secondary .tribe-compatibility-container,
        #secondary .widget,
        #secondary_2 .widget {
            box-shadow: 0 0 8px 0 rgba(110,123,140,.2);
        }
    </style>
<?php endif;
    
    // woocommerce
    if(class_exists('WooCommerce')) :
      if ( ! tx_is_enabled('woo_number_result') ) : ?>
    <style type="text/css">
        .woocommerce-result-count {display: none}
    </style>
<?php endif;

      if ( ! tx_is_enabled('woo_default_sorting_dropdown') ) : ?>
    <style type="text/css">
        .woocommerce-ordering {display: none}
    </style>
<?php endif;

      // product title alignment
      if ( tx_get_option('prod-title-alignment') === 'left' ) : ?>
    <style>.tx-woo-prod-title-wrap { text-align: left; }</style>
<?php endif;

      if ( tx_get_option('prod-title-alignment') === 'center' ) : ?>
    <style>.tx-woo-prod-title-wrap { text-align: center; }</style>
<?php endif;

      if ( tx_get_option('prod-title-alignment') === 'right' ) : ?>
    <style>.tx-woo-prod-title-wrap { text-align: right; }</style>
<?php endif;

    endif;// woocommerce class end

    // Pagination arrow size
    if ( $font_size = tx_get_option('pagination_num_arrow_size') ) : ?>
    <style type="text/css">
        .tx-pagination a,
        .tx-pagination span,
        .tx-pagination a i {
            font-size: <?php echo esc_attr($font_size); ?>px;
        }
    </style>
<?php endif;

/* Custom Fonts */
$fonts = [
    'CustomFont'    => tx_get_option( 'tx_custom_font_ttf' ),
    'CustomFontTwo' => tx_get_option( 'tx_custom_font_two' ),
];

$css = '';
foreach ( $fonts as $family => $opt ) {
    // grab URL whether Redux returns array or string
    if ( is_array( $opt ) ) {
        $url = ! empty( $opt['url'] ) ? $opt['url'] : '';
    } else {
        $url = (string) $opt;
    }
    if ( ! $url ) {
        continue;
    }
    $url = esc_url( $url );
    $css .= "
@font-face {
  font-family: '{$family}';
  src: url('{$url}') format('truetype');
}
";
}

if ( $css ) : ?>
<style>
<?php echo $css; ?>
</style>
<?php endif; ?>
    
    <!-- Custom CSS -->
      <style type="text/css">
        <?php echo tx_get_option('custom_css'); ?>
      </style>
    <?php 

    // Footer top widget alignment
    if ( tx_get_option('footer-top-widget-alignment', 'left') === 'left' ) : ?>
    <style type="text/css">
        #footer-top aside { display: block; }
    </style>
<?php endif;

    if ( tx_get_option('footer-top-widget-alignment') === 'center' ) : ?>
    <style type="text/css">
        #footer-top aside { display: table; }
    </style>
<?php endif; ?>

    <!-- scroll to top broder radius / back to top border radius -->
    <style type="text/css">
      #back_top{border-radius: <?php echo esc_attr(tx_get_option('back_top_radius', 0)); ?>px}
    </style>

    <?php if ( tx_get_option('back_top_position', '2') === '1' ) : ?>
    <style type="text/css">
        #back_top { left: 30px; right: auto; }
    </style>
<?php endif;

  } // function tx_custom_css
endif;

    // Custom JS Head
    add_action('wp_head', 'custom_js_head');
    function custom_js_head() {
      $custom_js = tx_get_option('custom_js_head');
        echo $custom_js;
    }

    // Custom JS Footer
    add_action('wp_footer', 'custom_js_footer');
    function custom_js_footer() {
        $custom_js = tx_get_option('custom_js_footer');
            echo $custom_js;
    }


/* ---------------------------------------------------------
  EOF
------------------------------------------------------------ */      