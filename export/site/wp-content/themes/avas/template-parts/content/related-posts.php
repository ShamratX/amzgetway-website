<?php
/**
 * Related Posts Section
 * 
 * @package tx
 * @author theme-x
 * @link https://theme-x.org/
 */

// Get settings safely
$related_count = tx_get_option('related_posts_count', 8);
$related_text  = tx_get_option('related-posts_text', esc_html__('Related Posts', 'avas'));
$related_style = tx_get_option('related_posts_style', 'rp_style_1');

$rp_query = new WP_Query(array(
    'category__in'   => wp_get_post_categories(get_the_ID()),
    'posts_per_page' => $related_count,
    'post__not_in'   => array(get_the_ID()),
));
?>

<?php if ($rp_query->have_posts()) : ?>
    <div class="related-posts">
        <h3 class="related-posts-title"><?php echo wp_kses_post($related_text); ?></h3>
        <div class="related-posts-loop owl-carousel"> 
            <?php while ($rp_query->have_posts()) : $rp_query->the_post(); ?>
                <?php if ($related_style === 'rp_style_1') : ?>
                    <div class="related-posts-item">		
                        <a rel="external" href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) {
                                the_post_thumbnail('tx-r-thumb');
                            } else { ?>
                                <img src="<?php echo esc_url(TX_IMAGES . 'related-posts.png'); ?>" alt="<?php the_title_attribute(); ?>">
                            <?php } ?>
                        </a>
                        <div class="overlay">
                            <?php the_title(sprintf('<h6 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h6>'); ?>
                        </div>
                    </div>

                <?php elseif ($related_style === 'rp_style_2') : ?>
                    <div class="related-posts-item">		
                        <a rel="external" href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) {
                                the_post_thumbnail('tx-r-thumb');
                            } ?>
                            <?php the_title('<h5 class="entry-title">', '</h5>'); ?>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endwhile; ?>
        </div><!-- /.related-posts-loop -->
        <?php wp_reset_postdata(); ?>
    </div><!-- /.related-posts -->
<?php endif; ?>