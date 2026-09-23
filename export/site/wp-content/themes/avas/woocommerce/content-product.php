<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $tx;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( '', $product ); ?>>
	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<div class="tx-wc-badges">
	<?php		
	// sale
	if ( $product->is_on_sale() ) : ?>
		<span class="tx_wc_sale"><span class="tx_wc_sale_inner"><?php echo wp_kses_post( $tx['woo-sale-badge-text'] ); ?></span></span>
	<?php endif;

	// sold out
    if ( ! $product->is_in_stock() ) : ?>
        <span class="tx_wc_soldout"><span class="tx_wc_soldout_inner"><?php echo wp_kses_post( $tx['woo-soldout-badge-text'] ); ?></span></span>
    <?php endif;

	// featured badge
    $featured = $product->is_featured();
    if($featured) : ?>
    	<span class="tx_wc_featured"><span class="tx_wc_featured_inner"><?php echo wp_kses_post( $tx['woo-featured-badge-text'] ); ?></span></span>
    <?php endif;

    // new badge
    if($tx['woo-new-badge']) :
	   	$newness_days = $tx['woo-new-badge-days']; // days
	   	$created = strtotime( $product->get_date_created() );
	   	if ( ( time() - ( 60 * 60 * 24 * $newness_days ) ) < $created ) {
		    if($tx['woo-new-badge'] == '1') {
		      echo '<span class="tx_wc_new"><span class="tx_wc_new_inner">' . wp_kses_post( $tx['woo-new-badge-text'] ) . '</span></span>';
		    }
	   	}
   	endif;
   	?>
	</div>

    <?php
	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	?>
	<div class="tx-woo-prod-title-wrap">
	<?php
	do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	
	do_action( 'woocommerce_after_shop_loop_item_title' );
?>
	</div>
	<?php

	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item' );
	?>
</li>
