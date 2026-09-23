<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/
**/
global $tx;
?>

<nav class="navbar order-last order-lg-0">
    <?php if ( has_nav_menu( 'main_menu' ) ) : ?>
    <div class="d-none d-sm-none d-md-block">
        <div class="menubar site-nav-inner">
            <!-- Menu goes here -->
            <?php 
                wp_nav_menu(
                array(
                    'theme_location' => 'main_menu',
                    'container_class' => 'navbar-responsive-collapse',
                    'menu_class' => 'nav navbar-nav main-menu tx-mega-menu',
                    'fallback_cb' => '',
                    'menu_id' => 'main-menu',
                    'items_wrap' => '<ul id="%1$s" class="%2$s" role="menu">%3$s</ul>',
                  )
                );
            ?>
        </div> <!-- menubar -->
    </div> <!-- desktop menu -->
    <?php endif; ?>

    <?php 
      if ( has_nav_menu( 'mobile_menu' ) ) { 
      get_template_part( 'template-parts/header/menu/mobile', 'menu' );
     } elseif ( has_nav_menu( 'main_menu' ) ) {
    ?>
    <div id="responsive-menu" class="d-md-none d-lg-none">
            <!-- .navbar-toggle is used as the toggle for collapsed navbar content -->
            <button type="button" class="mobile-nav-toggle">
              <span class="x"><i class="bi bi-list"></i></span> <span class="tx-res-menu-txt"><?php echo esc_html( $tx['tx-res-menu-txt'] ); ?></span>
            </button>
        <div class="tx-mobile-menu" id="tx-res-menu">
            <?php
                wp_nav_menu( array(
                    'theme_location'      => 'main_menu',
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
    <?php } ?>

</nav><!-- End of navigation -->