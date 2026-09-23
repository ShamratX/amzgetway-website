<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/
*/

global $tx;

/* ---------------------------------------------------------
  WooCommerce Functions
------------------------------------------------------------ */

//Number of product per row
add_filter('loop_shop_columns', 'tx_product_columns', 999);
function tx_product_columns() {
  global $tx;  
  return $tx['woo-product-per-row'];
}

//remove frist and last class from product
add_filter( 'woocommerce_post_class', 'tx_remove_prod_post_class', 21, 3 ); 
function tx_remove_prod_post_class( $classes ) {
    if ( 'product' == get_post_type() ) {
        $classes = array_diff( $classes, array( 'first','last' ) );
    }
    return $classes;
}

/**
 * Change number of products that are displayed per page (shop page)
 */
add_filter( 'loop_shop_per_page', 'tx_product_per_page', 20 );
function tx_product_per_page( $cols ) {
    global $tx;
    $cols = $tx['woo-product-per-page'];
    return $cols;
}


 //add hover effect by grabing first gallery image
add_action( 'woocommerce_before_shop_loop_item', 'tx_add_hover_image_product', 15 );

function tx_add_hover_image_product() {
    global $product;
    $attachment_ids = $product->get_gallery_image_ids();
    $count = 0;
    foreach( $attachment_ids as $attachment_id ) { 
        $count++;
        //make sure you're on the Shop Page and that you only get the first image
        if(is_shop() && $count <= 1) {
          if(!empty(wp_get_attachment_image_src( $attachment_id, 'woocommerce_thumbnail' )[0])) :
    ?>
            <!-- <div class="product-secondary-image"> -->
              <img class="tx-woo-hover-image" src="<?php echo wp_get_attachment_image_src( $attachment_id, 'woocommerce_thumbnail' )[0]; ?>" alt="<?php echo esc_attr( get_the_title( $attachment_id ) ); ?>">
            <!-- </div> -->
    <?php 
  endif;
        }
    }
}

function tx_remove_woo_stuff(){
  remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0); // breadcrumbs
}
add_action('template_redirect', 'tx_remove_woo_stuff' );


// re order phone & email on checkout page
add_filter( 'woocommerce_checkout_fields', 'tx_checkout_fields_re_order' );
function tx_checkout_fields_re_order( $fields ) {
  $fields['billing']['billing_phone']['priority'] = 20;
  $fields['billing']['billing_email']['priority'] = 20;
  return $fields;
}

/* ----------------------------------------------------------------
    WooCommerce archive shop page Sidebar / No Sidebar
----------------------------------------------------------------- */
if(!function_exists('tx_woo_sidebar_no_sidebar')) :
  function tx_woo_sidebar_no_sidebar() {
    if (class_exists('ReduxFramework')) {
      global $tx;
      if($tx['woo-sidebar-select'] == null || $tx['woo-sidebar-select'] == 'woo-sidebar-none') {
        echo 12;
      } else {
       echo 9;
      }
    }else{
      echo 9;
    }

  }
endif;

/* ----------------------------------------------------------------
    WooCommerce product single page Sidebar / No Sidebar
----------------------------------------------------------------- */
if(!function_exists('tx_woo_single_sidebar_no_sidebar')) :
  function tx_woo_single_sidebar_no_sidebar() {
    if (class_exists('ReduxFramework')) {
      global $tx;
      if($tx['woo-single-sidebar-select'] == null || $tx['woo-single-sidebar-select'] == 'woo-single-sidebar-none') {
        echo 12;
      } else {
       echo 9;
      }
    }else{
      echo 9;
    }

  }
endif;

/* ---------------------------------------------------------
    cart icon link
------------------------------------------------------------ */
function tx_cart_icon_link() { 

  echo '<a class="tx-cart" href="'. esc_url( wc_get_cart_url() ) .'"><i class="bi bi-bag"></i><span class="tx-count">'. wp_kses_data( WC()->cart->get_cart_contents_count() ) .'</span></a>';
}


/* ---------------------------------------------------------
    add to cart fragment
------------------------------------------------------------ */

add_filter( 'woocommerce_add_to_cart_fragments', 'tx_cart_icon_add_to_cart_fragment' );
function tx_cart_icon_add_to_cart_fragment( $fragments ) {
        ob_start();
        tx_cart_icon_link();
        $fragments['a.tx-cart'] = ob_get_clean();
        return $fragments;
    }


/* ---------------------------------------------------------
    cart icon
------------------------------------------------------------ */

if ( class_exists( 'WooCommerce' ) ) {
  add_action( 'tx_cart_icon', 'tx_cart_icon' );
  function tx_cart_icon() {
    global $tx;
    if($tx['tx-cart']) : ?>
      <div class="tx-cart-icon-wrap">
        
        <?php tx_cart_icon_link(); ?>
        <?php if( !is_cart() && !is_checkout() ): ?>
            <?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
        <?php endif; ?>
      </div><!-- tx-cart-wrap -->
    <?php  endif;
  
  }
    
}

/* ---------------------------------------------------------
    Wishlist on header
------------------------------------------------------------ */
add_action( 'tx_wishlist_icon', 'tx_wishlist_icon' );
function tx_wishlist_icon() { 
if ( class_exists( 'WPCleverWoosw' ) ) :
  global $tx;
    if($tx['tx-wishlist']) :
?>

  <a class="tx-whishlist-icon" href="<?php echo esc_url(WPcleverWoosw::get_url());?>"><i class="bi bi-heart"></i><span class="tx-count" data-count="<?php echo esc_attr(WPcleverWoosw::get_count());?>"></span></a>

<?php
endif;
endif;
}

/* ----------------------------------------------------------------------
  "WPC Smart Quick View for WooCommerce" plugin for Quick View products.
------------------------------------------------------------------------- */
if ( class_exists( 'WPCleverWoosq' ) ) :
//hide default Quick View button on product
add_filter( 'woosq_button_position', function() {
    return '0';
} );

// add quickview to the product
add_action( 'woocommerce_before_shop_loop_item', function () {
  echo do_shortcode( '[woosq]' );
}, 12 );
endif;

/* --------------------------------------------------------------------
  "WPC Smart Wishlist for WooCommerce" plugin for Wishlist products.
----------------------------------------------------------------------- */
if ( class_exists( 'WPCleverWoosw' ) ) :
//hide default wishlist button on product archive page
add_filter( 'woosw_button_position_archive', function() {
    return '0';
} );

//hide default wishlist button on product single page
add_filter( 'woosw_button_position_single', function() {
    return '0';
} );

// add wishlist to the product
add_action( 'woocommerce_before_shop_loop_item', function () {
  echo do_shortcode( '[woosw]' );
}, 12 );

// add wishlist to the single product
add_action( 'woocommerce_after_add_to_cart_button', function () {
  echo do_shortcode( '[woosw]' );
}, 12 );
endif;

/* -------------------------------------------------------------------
  "WPC Smart Compare" for WooCommerce plugin for Compare products.
-------------------------------------------------------------------- */
if ( class_exists( 'WPCleverWoosc' ) ) :
//hide default compare button on product archive page
add_filter( 'woosc_button_position_archive', function() {
    return '0';
} );

//hide default compare button on product single page
add_filter( 'woosc_button_position_single', function() {
    return '0';
} );

// add compare to the product
add_action( 'woocommerce_before_shop_loop_item', function () {
  echo do_shortcode( '[woosc]' );
}, 12 );

// add compare to the single product
add_action( 'woocommerce_after_add_to_cart_button', function () {
  echo do_shortcode( '[woosc]' );
}, 12 );
endif;

/* ---------------------------------------------------------
  Change "Add to cart" button position on products
------------------------------------------------------------ */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );

/* ---------------------------------------------------------
  Change "Read more" button text
------------------------------------------------------------ */
add_filter( 'woocommerce_product_add_to_cart_text', 'tx_wc_read_more_text' );
  
function tx_wc_read_more_text( $text ) {
   global $product;
   global $tx;
   if ( $product && ! $product->is_in_stock() ) {
       return $tx['woo-readmore-text'] ;
   }
   return $text;
}


/* ---------------------------------------------------------
  Change "Out of stock" text on single product
------------------------------------------------------------ */
add_filter( 'woocommerce_get_availability', 'tx_wc_out_of_stock_text', 1, 2);

function tx_wc_out_of_stock_text( $availability, $_product ) {
  global $product;
  global $tx;

  if ( !$_product->is_in_stock() ) $availability['availability'] = $tx['woo-outofstock-text'];

  return $availability;
}


/* ---------------------------------------------------------
  EOF
------------------------------------------------------------ */