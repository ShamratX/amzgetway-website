<?php
/**
 * Template for displaying content of single course.
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 4.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Header for page
 */
get_header( 'course' );
tx_setPostViews(get_the_ID()); 
?>
</div>
	
<?php
/**
 * @since 3.0.0
 */
do_action( 'learn-press/before-main-content' );
?>

<?php
do_action( 'learn-press/before-main-content-single-course' );

while ( have_posts() ) {
	the_post();
	learn_press_get_template( 'content-single-course' ); ?>
    <div class="container space-100">
        <div class="row">
            <div class="col-md-8">
            <?php tx_related_courses(); ?>
            </div>
        </div>
    </div>
<?php
}

/**
 * @since 3.0.0
 */
do_action( 'learn-press/after-main-content-single-course' );

do_action( 'learn-press/after-main-content' );

/**
 * LP sidebar
 */
do_action( 'learn-press/sidebar' );

/**
 * Footer for page
 */
get_footer( 'course' );
