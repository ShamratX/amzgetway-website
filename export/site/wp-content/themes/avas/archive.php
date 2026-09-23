<?php
/**
 * Posts archive template
 *
 * @package tx
 * @author theme-x
 * @link https://theme-x.org/
 */

get_header();

// Get queried term object and its custom style (from term meta)
$queried_object = get_queried_object();
$term_id = isset( $queried_object->term_id ) ? $queried_object->term_id : 0;
$term_meta = get_option( "taxonomy_$term_id", [] );
$cat_style = isset( $term_meta['tx_post_term_meta'] ) ? $term_meta['tx_post_term_meta'] : '';

// Get global archive style from theme options
$global_style = tx_get_option( 'cat_temp_style', '' );
?>

<div class="container space-content">
    <div class="row">
        <?php
        if (
            in_array( $global_style, ['cat_style_1', 'cat_style_2', 'cat_style_3'], true ) ||
            in_array( $cat_style, ['style-1', 'style-2', 'style-3'], true )
        ) {
            if ( $global_style === 'cat_style_1' || $cat_style === 'style-1' ) {
                get_template_part( 'template-parts/archive/style', 'one' );
            } elseif ( $global_style === 'cat_style_2' || $cat_style === 'style-2' ) {
                get_template_part( 'template-parts/archive/style', 'two' );
            } elseif ( $global_style === 'cat_style_3' || $cat_style === 'style-3' ) {
                get_template_part( 'template-parts/archive/style', 'three' );
            }
        }
        ?>
    </div>
</div>

<?php get_footer(); ?>