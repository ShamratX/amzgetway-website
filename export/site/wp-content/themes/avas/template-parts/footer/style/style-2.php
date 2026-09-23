<?php
/**
 * Footer Style 2
 *
 * @package tx
 * @author theme-x
 * @link https://theme-x.org/
 */

// Get layout type
$footer_cols = tx_get_option( 'footer-bottom-layout2', '4' );
?>

<div class="container footer-style-2 d-flex justify-content-center justify-content-md-between">
    
    <?php if ( $footer_cols === '4' ) : ?>
        <div class="d-flex align-items-center">
            <!-- social link start -->
            <?php if ( tx_is_enabled('social_icons_footer') && tx_get_option('social') ) : ?>
                <div class="social_media">
                    <?php if ( function_exists('tx_social_media') ) :
                        echo tx_social_media();
                    endif; ?>
                </div>
            <?php endif; ?>
            <!-- social link end -->
        </div>
    <?php endif; ?>

    <div class="d-flex align-items-center">
        <div class="copyright">
            <?php 
            $copyright = tx_get_option('copyright', '');
            if ( $copyright ) {
                echo wp_kses_post( $copyright );
            } else {
                echo '<p>Copyright &copy; ' . date("Y") . ', By <a href="https://1.envato.market/mPA2X">Avas WP Theme</a> | All rights reserved.</p>';
            }
            ?>
        </div>
    </div>

    <?php if ( $footer_cols === '4' ) : ?>
        <div class="d-flex align-items-center">
            <!-- footer menu start -->
            <?php if ( tx_is_enabled('footer-menu') && has_nav_menu('footer_menu') ) : ?>
                <?php wp_nav_menu( array(
                    'theme_location' => 'footer_menu',
                    'menu_class'     => 'footer-menu',
                    'depth'          => 1,
                ) ); ?>
            <?php endif; ?>
            <!-- footer menu end -->
        </div>
    <?php endif; ?>

</div><!-- /.container -->