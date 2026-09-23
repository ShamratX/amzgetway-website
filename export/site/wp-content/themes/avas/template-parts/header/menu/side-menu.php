<?php
/**
* 
* @package tx
* @author theme-x
*
*  Side Menu
*/
global $tx;

if (class_exists('ReduxFramework')) :   
?>     
        <!-- Side Menu section -->
        <div id="side-menu-wrapper" class="side-menu">
            <a id="side-menu-icon-close" class="s-menu-icon-close" href="#" data-toggle="collapse" data-target="#side-menu-wrapper" aria-expanded="false" aria-controls="side-menu-wrapper"><i class="bi bi-x-lg"></i></a>
           
            <?php 
            // Side Menu goes here
            if (has_nav_menu('side_menu')) :
             wp_nav_menu(array(
                        'theme_location' => 'side_menu',
                        'menu_id'        => 'side_menu',
                        'menu_class'     => 'side-menus',
                        ));
            endif;

            // Menu widget area
            if (is_active_sidebar('side-menu-widget')) : ?>
            <div class="side_menu_widget" role="complementary">
                <?php dynamic_sidebar('side-menu-widget'); ?>
            </div><!-- /.side_menu_widget -->
            <?php endif; ?>

        </div><!-- /#side-menu-wrapper -->

<?php 
endif;
