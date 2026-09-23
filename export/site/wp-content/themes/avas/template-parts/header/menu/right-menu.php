<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/
*
* Right Menu
*
**/
?>
<div class="d-none d-sm-none d-md-block tx-right-menu">
<?php if ( has_nav_menu( 'right_menu' ) ) {
	  	wp_nav_menu( array(
	       'theme_location' => 'right_menu',
	       'menu_class'     => 'nav navbar-nav main-menu tx-mega-menu',
	       'depth'          => 5,
	        ) );
	    } ?>
</div>