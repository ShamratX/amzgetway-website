<?php
/**
* 
* header style 7
*
*/
global $tx;
?>

<div class="header-style-seven">
    <div id="h-style-7" class="main-header">
        <div class="tx-header-overlay"></div><!-- overlay color -->
        <div class="menu-bar d-flex align-items-center tx-md-none"><!-- menu bar -->
            <div class="container<?php echo tx_header_layout(); ?> d-flex align-items-center justify-content-lg-between">
                    <!-- Main Menu -->  
                    <?php get_template_part( 'template-parts/header/menu/main', 'menu' ); ?>
                    <div class="tx-nav-right-side-items-desktop">
                    <!-- Menu Button -->
                    <?php do_action('tx_menu_btn'); ?>
                    <!-- Search icon -->
                    <?php do_action('tx_search_icon'); ?>
                    <!-- Wishlist icon -->
                    <?php do_action('tx_wishlist_icon'); ?>
                    <!-- Cart icon -->
                    <?php do_action('tx_cart_icon'); ?>
                    <!-- Side menu -->
                    <?php do_action('tx_sidemenu_icon'); ?>
                    </div><!-- tx-nav-right-side-items-desktop -->
            </div><!-- /.container -->
        </div><!-- /.menu-bar -->
        <div class="container<?php echo tx_header_layout(); ?> tx-main-head-contain d-flex align-items-center justify-content-lg-between">
                <!-- logo -->
                <?php do_action('tx_logo'); ?>
                <!-- Main Menu -->
                <div class="tx-spec-mob-nav d-md-none">
                    <?php get_template_part( 'template-parts/header/menu/main', 'menu' ); ?>
                </div>
                    <div class="main-header-right-area tx-md-none">
                        <?php if($tx['banner-bussiness-switch'] == '1') : ?>
                        <?php tx_head_ads(); ?>
                        <?php endif; ?>
                        <?php if($tx['banner-bussiness-switch'] == '2') : ?>
                        <?php get_template_part( 'template-parts/header/business', 'info' ); ?>
                        <?php endif; ?>
                    </div><!-- banner / business info-->

        </div><!-- /.container -->
                    <div class="main-header-right-area tx-spec-mob-ra d-md-none">
                        <?php if($tx['banner-bussiness-switch'] == '1') : ?>
                        <?php tx_head_ads(); ?>
                        <?php endif; ?>
                        <?php if($tx['banner-bussiness-switch'] == '2') : ?>
                        <?php get_template_part( 'template-parts/header/business', 'info' ); ?>
                        <?php endif; ?>
                    </div>
    </div><!-- /#h-style-7 -->
</div><!-- header-style-seven -->

