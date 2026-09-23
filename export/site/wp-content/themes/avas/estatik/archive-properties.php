<?php

/**
 * @var Es_Settings_Container $es_settings
 */

get_header(); $template = get_option( 'template' ); global $wp_query, $wp_taxonomies; ?>
<div class="container space-content">
	<div class="row">
        <?php if ( tx_get_option('estatik-sidebar-select') === 'estatik-sidebar-left' ) : get_sidebar('estatik'); endif; ?>
        <div class="col-lg-<?php echo tx_estatik_sidebar_no_sidebar(); ?> col-md-8 col-sm-12">
        <?php do_action( 'es_before_content' ); ?>

            <div class="es-wrap">

                <?php do_action( 'es_before_content_list' ); ?>

        	    <?php do_action( 'es_archive_sorting_dropdown' ); ?>

                <div class="<?php es_the_list_classes(); ?>">
                    <?php if ( have_posts() ) : ?>
                        <?php while ( have_posts() ) : the_post();
                            es_load_template( 'content-archive.php' );
                        endwhile; ?>
                    <?php else: ?>
                        <?php get_template_part('template-parts/content/content', 'none'); ?>
                    <?php endif; ?>
                </div>

                <?php do_action( 'es_after_content_list' ); ?>
            </div>

        <?php echo es_the_pagination( $wp_query ); ?>

        <?php do_action( 'es_after_content' ); ?>
        </div>
<?php if ( tx_get_option('estatik-sidebar-select') === 'estatik-sidebar-right' ) : get_sidebar('estatik'); endif; ?>
    </div>
</div>
<?php
get_footer();
