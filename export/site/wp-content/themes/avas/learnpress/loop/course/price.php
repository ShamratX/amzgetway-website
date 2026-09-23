<?php
/**
 * Template for displaying price of course within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/loop/course/price.php.
 *
 * @author  ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.1
 */

defined( 'ABSPATH' ) || exit();

if ( ! isset( $course ) || ! isset( $price_html ) ) {
    return;
}
?>
<div class="edu-course-footer">
    <?php echo tx_lp_author(); ?>
    <?php echo tx_lp_rating(); ?>
    <?php echo tx_lp_student_endrolled(); ?>
    <?php echo '<div class="lp_post_views">'.tx_getPostViews(get_the_ID()).'</div>'; ?>
</div>
