<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/
*/



/* ---------------------------------------------------------
  Estatik Functions
------------------------------------------------------------ */

/* ----------------------------------------------------------------
    Estatik archive page Sidebar / No Sidebar
----------------------------------------------------------------- */
if(!function_exists('tx_estatik_sidebar_no_sidebar')) :
  function tx_estatik_sidebar_no_sidebar() {
    $sidebar = tx_get_option('estatik-sidebar-select', 'estatik-sidebar-right');

    if ($sidebar === 'estatik-sidebar-none') {
        echo 12;
    } else {
        echo 8;
    }
  }
endif;

/* ----------------------------------------------------------------
    Estatik single page Sidebar / No Sidebar
----------------------------------------------------------------- */
if(!function_exists('tx_estatik_single_sidebar_no_sidebar')) :
  function tx_estatik_single_sidebar_no_sidebar() {
    $sidebar = tx_get_option('estatik-single-sidebar-select', 'estatik-single-sidebar-right');

    if ($sidebar === 'estatik-single-sidebar-none') {
        echo 12;
    } else {
        echo 8;
    }
  }
endif;