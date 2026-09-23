<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/
*
* header style 5
*
*/

?>

<div class="header-style-five">
	<div id="h-style-5" class="main-header d-flex align-items-center">
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
	</div><!-- /#h-style-5 -->

	<div class="tx-header-overlay"></div><!-- overlay color -->

	<div class="container<?php echo tx_header_layout(); ?> banner-business d-flex align-items-center">
		
		        	<?php if($tx['banner-bussiness-switch'] == '1') : ?>
	                <?php tx_head_ads(); ?>
	                <?php endif; ?>
	                <?php if($tx['banner-bussiness-switch'] == '2') : ?>
	                <?php get_template_part( 'template-parts/header/business', 'info' ); ?>
	                <?php endif; ?>

	</div><!-- /.container -->

</div><!-- header-style-five -->