<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/
* ============================
*       Page Sidebar Left
* ============================
*/


	  if (is_active_sidebar('sidebar-page-left')) : ?>
		<div id="secondary" class="widget-area col-lg-3 col-md-6 col-sm-12" role="complementary">
	        <?php dynamic_sidebar('sidebar-page-left'); ?>
		</div><!-- #secondary -->
	<?php endif;
