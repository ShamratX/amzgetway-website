<?php
/**
* 
* header style 3
*
*/

?>

<div id="h-style-3" class="main-header d-flex align-items-center">
	<div class="tx-header-overlay"></div><!-- overlay color -->
	<div class="container<?php echo tx_header_layout(); ?> d-flex align-items-center justify-content-lg-between">
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
	</div><!-- /.container -->
</div><!-- /#h-style-3 -->