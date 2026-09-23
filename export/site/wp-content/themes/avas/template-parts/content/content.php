<?php
/**
* @package tx
* @author theme-x
* @link https://theme-x.org/
*/
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-content">

        <?php if ( has_post_thumbnail() ) :

            if ( is_home() || is_category() || is_archive() || is_page_template( 'templates/blog.php' ) ) : ?>
                <div class="zoom-thumb">
                    <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
                        <?php the_post_thumbnail('tx-l-thumb'); ?>
                    </a>
                </div>
            <?php else :
                if ( tx_is_enabled('featured-image') ) :
                    the_post_thumbnail('tx-l-thumb');
                endif;
            endif;
        endif; ?>

        <div <?php if ( !is_singular( 'properties' ) ) : ?> class="content-top-20" <?php endif; ?>>
            <?php if ( !is_singular( 'properties' ) ) : ?>
            <header class="entry-header">
                <?php 
                    if ( is_home() || is_category() || is_archive() || is_page_template( 'templates/blog.php' ) ) :
                        the_title( sprintf('<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h1>' );
                    else :
                        if ( tx_is_enabled('posts-title') ) :
                            the_title( '<h1 class="entry-title">', '</h1>' );
                        endif;
                    endif;
                ?>

                <?php if ( 'post' === get_post_type() ) : ?>
                    <div class="entry-meta">
                        <?php tx_date(); ?>
                        <?php tx_author(); ?>
                        <?php tx_comments(); ?>
                        <?php if ( tx_is_enabled('post-views') ) : echo tx_getPostViews( get_the_ID() ); endif; ?>
                        <?php do_action( 'tx_social_share_header' ); ?>
                    </div>
                <?php endif; ?>
            </header>
            <?php endif; ?>

            <?php
            if ( is_home() || is_category() || is_archive() || is_page_template( 'templates/blog.php' ) ) {
                the_excerpt();
            } else {
                the_content( sprintf(
                    esc_attr__( 'Read more %s &rarr;', 'avas' ),
                    the_title( '<span class="screen-reader-text">"', '"</span>', false )
                ) );
            }

            if ( !is_archive() && !is_paged() ) {
                wp_link_pages( array(
                    'before' => '<div class="page-link">' . esc_html__( 'Pages:', 'avas' ),
                    'after'  => '</div>',
                ) );
            }
            ?>
        </div><!-- content-top-20 -->

    </div><!-- .entry-content -->

    <div class="clearfix"></div>

    <?php if ( is_home() || is_category() || is_archive() || is_page_template( 'templates/blog.php' ) ) : ?>
        <!-- No footer for archive/blog loops -->
    <?php else : ?>
    <footer class="entry-footer">
        <?php tx_category(); ?>
        <?php do_action('tx_tags'); ?>
    </footer>
    <?php endif; ?>

</article>