<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/
* 
* Estatik Single Sidebar
* 
*/


	  if (is_active_sidebar('sidebar-estatik-single')) : ?>
		<div id="secondary" class="widget-area col-lg-4 col-md-4 col-sm-12" role="complementary">
	        <?php dynamic_sidebar('sidebar-estatik-single'); ?>
		</div><!-- #secondary -->
	<?php endif;
