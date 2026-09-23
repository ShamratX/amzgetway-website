<?php
/**
 * Template for displaying course content within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/content-course.php
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 4.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();
$user = LP_Global::user();
$course = LP_Global::course();
?>

<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="lp-course-price">
	   <?php $course = learn_press_get_course();
            if ( $price_html = $course->get_course_price_html() ) { ?>
	        <span class="price"><?php echo wp_kses_post($price_html); ?></span>
	    <?php } ?>
    </div>
	<div class="course-item">
		<?php

		/**
		 * LP Hook
		 *
		 * @since 3.0.0
		 *
		 * @called loop/course/thumbnail.php
		 * @echo DIV tag
		 */
		do_action( 'learn-press/before-courses-loop-item' );
		?>

		<a href="<?php the_permalink(); ?>" class="course-permalink">

			<?php
			/**
			 * @since 3.0.0
			 *
			 * @called loop/course/title.php
			 */
			do_action( 'learn-press/courses-loop-item-title' );
			?>

		</a>

		<?php

		/**
		 * LP Hook
		 *
		 * @since 3.0.0
		 *
		 * @see LP_Template_Course::courses_loop_item_meta()
		 * @see LP_Template_Course::courses_loop_item_info_begin()
		 * @see LP_Template_Course::clearfix()
		 * @see LP_Template_Course::courses_loop_item_price()
		 * @see LP_Template_Course::courses_loop_item_info_end()
		 * @see LP_Template_Course::loop_item_user_progress()
		 */
		do_action( 'learn-press/after-courses-loop-item' );

		?>
	</div>
</li>
