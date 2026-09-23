<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/
* 
* bbPress/Forum Sidebar
* 
*/


	  if (is_active_sidebar('sidebar-bbpress')) : ?>
		<div id="secondary" class="widget-area col-lg-3 col-md-3 col-sm-12" role="complementary">
	        <?php dynamic_sidebar('sidebar-bbpress'); ?>
		</div><!-- #secondary -->
	<?php endif;
