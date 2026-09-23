<?php
/**
 * @package tx
 * @author theme-x
 * @link https://theme-x.org/
 */

get_header();

// Estatik support
if ( class_exists('Estatik') ) {
    $estatik = Es_Property::get_post_type_name();
}

// Helper to render left/right sidebars
function tx_render_single_sidebars( $position = 'left' ) {
    if ( is_singular('post') ) {
        $pos = tx_get_option('sidebar-single', 'sidebar-none');
        if ( $position === 'left' && $pos === 'sidebar-left' ) {
            get_sidebar('single');
        }
        if ( $position === 'right' && $pos === 'sidebar-right' ) {
            get_sidebar('single');
        }
    } elseif ( class_exists('Estatik') && is_singular( Es_Property::get_post_type_name() ) ) {
        $pos = tx_get_option('estatik-single-sidebar-select', 'estatik-single-sidebar-right');
        if ( $position === 'left' && $pos === 'estatik-single-sidebar-left' ) {
            get_sidebar('estatik-single');
        }
        if ( $position === 'right' && $pos === 'estatik-single-sidebar-right' ) {
            get_sidebar('estatik-single');
        }
    }
}
?>

<div class="container space-content">
    <div class="row">
        
        <?php tx_render_single_sidebars('left'); ?>

        <div id="primary" class="col-lg-<?php
            if ( is_singular('post') ) {
                tx_single_sidebar();
            } elseif ( class_exists('Estatik') && is_singular($estatik) ) {
                tx_estatik_single_sidebar_no_sidebar();
            }
        ?> col-md-8 col-sm-12">

            <main id="main" class="site-main">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php tx_setPostViews(get_the_ID()); ?>
                    <?php get_template_part('template-parts/content/content', get_post_format()); ?>

                    <?php if ( is_singular('post') ) : ?>

                        <?php do_action('tx_social_share'); ?>

                        <?php if ( tx_is_enabled('related-posts') ) :
                            get_template_part('template-parts/content/related', 'posts');
                        endif; ?>

                        <?php if ( tx_is_enabled('prev-next-posts') ) :
                            do_action('tx_pagination');
                        endif; ?>

                        <?php if ( ! post_password_required() && tx_is_enabled('author-bio-posts') ) :
                            do_action('tx_author_bio');
                        endif; ?>

                    <?php endif; ?>

                    <?php
                    if ( comments_open() || get_comments_number() ) {
                        comments_template();
                    }
                    ?>
                <?php endwhile; ?>
            </main><!-- #main -->
        </div><!-- #primary -->

        <?php tx_render_single_sidebars('right'); ?>
        
    </div>
</div>

<?php get_footer(); ?>