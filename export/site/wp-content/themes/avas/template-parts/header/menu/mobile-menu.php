<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/
*
* Mobile Menu
*
**/
global $tx;
?>

<div id="responsive-menu" class="d-md-none d-lg-none">
            <!-- .navbar-toggle is used as the toggle for collapsed navbar content -->
            <button type="button" class="mobile-nav-toggle">
              <span class="x"><i class="bi bi-list"></i></span> 
                <?php
                $menu_text = tx_get_option('tx-res-menu-txt');
                if ( ! empty( $menu_text ) ) :
                ?>
                    <span class="tx-res-menu-txt"><?php echo esc_html( $menu_text ); ?></span>
                <?php endif; ?>
            </button>
        <div class="tx-mobile-menu" id="tx-res-menu">
            <?php
                wp_nav_menu( array(
                    'theme_location'      => 'mobile_menu',
                    'container'           => false,
                    'menu_class'          => 'tx-res-menu',
                    'fallback_cb'         => '',
                    'depth'               => 5,
                    )
                );
            ?>
            <div class="tx-nav-right-side-items-mobile">
                <!-- sidemenu -->
                <?php get_template_part( 'template-parts/header/menu/side', 'menu' ); ?>
                <!-- Menu Button -->
                <?php do_action('tx_menu_btn'); ?>
                <!-- Search icon -->
                <?php do_action('tx_search_icon'); ?>
                <!-- Wishlist icon -->
                <?php do_action('tx_wishlist_icon'); ?>
                <!-- Cart icon -->
                <?php do_action('tx_cart_icon'); ?>
                <!-- Hamburger/Sidemenu Icon -->
                <?php do_action('tx_sidemenu_icon'); ?>
            </div><!-- tx-nav-right-side-items-mobile -->
        </div><!-- /.tx-mobile-menu -->
    </div><!--/#responsive-menu-->
