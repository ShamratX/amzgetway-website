<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/
*
* ============================
*         Footer
* ============================
*/

?>

<div class="footer">
    <?php  
    if ( tx_is_enabled('elem_footer_switch') ) :
        $tp = tx_get_option('elem_footer', '');
        if ( $tp ) {
            echo do_shortcode( "[elementor-template id=$tp]" );
        }
    endif;
    ?><!-- Elementor Template Footer -->
<?php
$footer_cols = tx_get_option('footer_cols', 3); // default to 3 cols

if (
    is_active_sidebar('footer-1') ||
    is_active_sidebar('footer-2') ||
    is_active_sidebar('footer-3') ||
    is_active_sidebar('footer-4') ||
    is_active_sidebar('footer-5') ||
    is_active_sidebar('footer-6')
) {
    if ( tx_is_enabled('footer_top') ) : ?>
        <div id="footer-top" class="footer_bg">
            <div class="footer-top-overlay"></div>
            <div class="container<?php echo tx_footer_width(); ?>">
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <?php dynamic_sidebar('footer-5'); ?>
                    </div>
                    <div class="col-lg-<?php echo esc_attr($footer_cols); ?> col-sm-6">
                        <?php dynamic_sidebar('footer-1'); ?>
                    </div>
                    <div class="col-lg-<?php echo esc_attr($footer_cols); ?> col-sm-6">
                        <?php dynamic_sidebar('footer-2'); ?>
                    </div>
                    <div class="col-lg-<?php echo esc_attr($footer_cols); ?> col-sm-6">
                        <?php dynamic_sidebar('footer-3'); ?>
                    </div>
                    <div class="col-lg-<?php echo esc_attr($footer_cols); ?> col-sm-6">
                        <?php dynamic_sidebar('footer-4'); ?>
                    </div>
                    <div class="col-lg-12 col-sm-12">
                        <?php dynamic_sidebar('footer-6'); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div id="footer-top" class="footer_bg">
            <div class="container<?php echo tx_footer_width(); ?>">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <?php dynamic_sidebar('footer-1'); ?>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <?php dynamic_sidebar('footer-2'); ?>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <?php dynamic_sidebar('footer-3'); ?>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <?php dynamic_sidebar('footer-4'); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;
} ?>

<?php if ( tx_is_enabled('footer_bottom') ) : ?>
    <div id="footer">
        <?php do_action('footer-style'); ?>
    </div><!-- /#footer -->
<?php endif; ?>

<?php if ( tx_is_enabled('back_top') ) : ?>
    <div id="back_top" class="back_top"><i class="bi bi-arrow-up"></i></div>
<?php endif; ?><!-- back to top -->

<?php if ( ! tx_is_enabled('footer_bottom') ) : ?>
    <div id="footer">
        <div class="container footer-style-1">
            <div class="row">
                <div class="col-md-5 col-xs-12">
                    <div class="copyright">
                        <p>
                            Copyright &copy;
                            <a href="https://avas.live">Avas WordPress Theme</a> | All rights reserved.
                        </p>
                    </div>
                </div><!-- col-md-5 -->
                <div class="col-md-7 col-xs-12">
                    <?php 
                        if ( tx_is_enabled('footer-menu') && has_nav_menu('footer_menu') ) {
                            wp_nav_menu(array(
                                'theme_location' => 'footer_menu',
                                'menu_class'     => 'footer-menu',
                                'depth'          => 1,
                            ));
                        }
                    ?><!-- footer menu end -->
                </div><!-- col-md-7 -->
            </div><!-- row -->
        </div><!-- container -->
    </div><!-- /#footer -->
<?php endif; ?>           

</div><!-- /.footer -->
</div> <!-- /.row -->
</div><!-- /#page -->
<?php wp_footer(); ?>
</body>
</html>