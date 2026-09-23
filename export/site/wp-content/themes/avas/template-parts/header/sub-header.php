<?php
/**
 * Sub Header Refactored
 * @package tx
 * @author theme-x
 * @link https://theme-x.org/
 */
$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');
$sh_banner_id = get_post_meta(get_the_ID(), 'tx_subheader_bg', true);
$sh_banner_img_url = wp_get_attachment_image_src($sh_banner_id, 'full');
$sh_banner_image = isset($sh_banner_img_url[0]) ? $sh_banner_img_url[0] : '';

function tx_subheader_enabled() {
    return (
        tx_is_enabled('sub_h_post_title.page') ||
        tx_is_enabled('sub_h_post_breadcrumbs.page') ||
        tx_is_enabled('sub_h_post_title.post') ||
        tx_is_enabled('sub_h_post_breadcrumbs.post') ||
        tx_is_enabled('sub_h_post_title.portfolio') ||
        tx_is_enabled('sub_h_post_breadcrumbs.portfolio') ||
        tx_is_enabled('sub_h_post_title.service') ||
        tx_is_enabled('sub_h_post_breadcrumbs.service') ||
        tx_is_enabled('sub_h_post_title.team') ||
        tx_is_enabled('sub_h_post_breadcrumbs.team') ||
        tx_is_enabled('sub_h_post_title.lp_course') ||
        tx_is_enabled('sub_h_post_breadcrumbs.lp_course') ||
        tx_is_enabled('sub_h_post_title.product') ||
        tx_is_enabled('sub_h_post_breadcrumbs.product') ||
        tx_is_enabled('sub_h_post_title.properties') ||
        tx_is_enabled('sub_h_post_breadcrumbs.properties') ||
        tx_is_enabled('sub_h_post_title.tribe_events') ||
        tx_is_enabled('sub_h_post_breadcrumbs.tribe_events') ||
        tx_is_enabled('sub_h_post_title.bbpress') ||
        tx_is_enabled('sub_h_post_breadcrumbs.bbpress')
    );
}

if (tx_subheader_enabled()) : ?>
    <div class="sub-header" <?php if (!empty($sh_banner_image)) { echo 'style="background-image:url(' . esc_attr($sh_banner_image) . ')"'; } elseif (is_page() && has_post_thumbnail()) { echo 'style="background-image:url(' . esc_url($featured_img_url) . ')"'; } ?>>
        <div class="sub-header-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php if (tx_is_enabled('sub_h_title')) : ?>
                        <h1 class="sub-header-title entry-title">
                            <?php
                            if (is_home() && get_option('show_on_front') === 'page' && get_option('page_for_posts')) {
                                echo esc_html(get_the_title(get_option('page_for_posts')));
                            } elseif (is_archive() || is_search()) {
                                the_archive_title();
                            } elseif (is_page() || is_singular()) {
                                the_title();
                            }
                            ?>
                        </h1>
                    <?php endif; ?>
                </div>

                <div class="col-12">
                    <?php if (tx_is_enabled('breadcrumbs')) : ?>
                        <?php do_action('tx_breadcrumbs'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif;