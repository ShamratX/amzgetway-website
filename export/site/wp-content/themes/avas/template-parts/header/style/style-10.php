<?php
/**
* 
* header style 10
*
*/

?>

<div id="h-style-10" class="main-header">
	<div class="tx-header-overlay"></div><!-- overlay color -->
	<div class="container<?php echo tx_header_layout(); ?> tx-h-style-10-cont">

	    	<!-- logo -->
        	<?php do_action('tx_logo'); ?>
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

	        <?php // Menu widget area
            if (is_active_sidebar('side-menu-widget')) : ?>
            <div class="side_menu_widget" role="complementary">
                <?php dynamic_sidebar('side-menu-widget'); ?>
            </div><!-- /.side_menu_widget -->
            <?php endif; ?>

	</div><!-- /.container -->
</div><!-- /#h-style-10 -->