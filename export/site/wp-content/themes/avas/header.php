<?php
/**
* 
* @package tx
* @author theme-x
*
*  Header main file
*/

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <?php wp_head(); ?>
    </head>
    
<body <?php body_class(); ?>>
    <?php 
        wp_body_open();
        if ( tx_is_enabled('preloader') ) {
            get_template_part('template-parts/pre', 'loader');
        }

        if ( tx_is_enabled('top_head') && tx_is_enabled('login_reg') ) {
            get_template_part('template-parts/login', 'form');
        }
    ?>

    <div id="page" class="tx-wrapper container<?php echo tx_page_layout(); ?>">
        <div class="row">
            <header id="header" itemscope="itemscope" itemtype="http://schema.org/WPHeader" class="tx-header">

                <!-- search -->
                <?php do_action('tx_search'); ?>

                <!-- top header -->
                <?php
                $header_select = tx_get_option('header-select', '');
                if ( $header_select && $header_select !== 'header10' ) :
                    if ( tx_is_enabled('top_head') ) {
                        get_template_part('template-parts/header/top', 'header');
                    }
                endif;
                ?>

                <!-- main header -->
                <?php 
                    do_action('header-style');

                    if ( tx_is_enabled('side_menu') ) {
                        get_template_part('template-parts/header/menu/side', 'menu');
                    }
                ?>
                
                
                <?php
                if ( tx_is_enabled('elem_head_switch') ) {
                    $head_template_id = tx_get_option('elem_head', '');
                    if ( $head_template_id ) {
                        echo do_shortcode("[elementor-template id={$head_template_id}]");
                    }
                }
                ?><!-- Elementor Template Header -->
                
                <?php 
                if (
                    ! is_front_page() &&
                    ! is_404() &&
                    ! is_page_template('templates/no-sub.php')
                ) {
                    if ( tx_is_enabled('sub-header-switch') ) {
                        get_template_part('template-parts/header/sub', 'header');
                    }
                }
                ?><!-- sub header -->

            </header><!-- /#header -->