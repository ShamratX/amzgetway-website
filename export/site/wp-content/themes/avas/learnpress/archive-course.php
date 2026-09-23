<?php
/**
 * Template default for displaying content of archive courses page.
 * If you want to override layout default, please override via hook 'learn-press/list-courses/layout', or another hook inside.
 * Override file is will be soon not support on the feature. Because it is many risks.
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 4.0.2
 */



//use LearnPress\TemplateHooks\Course\ListCoursesTemplate;

defined( 'ABSPATH' ) || exit;

/**
 * @since 4.0.0
 *
 * @see LP_Template_General::template_header()
 */
if ( ! wp_is_block_theme() ) {
	do_action( 'learn-press/template-header' );
}
?>


</div>
<div class="row">
<div class="container">


<?php
/**
 * LP Hook
 */
do_action( 'learn-press/before-main-content' );
// $page_title = learn_press_page_title( false );
?>

<div class="lp-content-area">
	<div class="row">

	<div class="col-lg-9 col-md-12">

	


	<?php do_action( 'learn-press/list-courses/layout' ); ?>
	</div>

<?php if (is_active_sidebar('archive-courses-sidebar')) : ?>
	<div id="secondary" class="col-lg-3 col-md-6 lp-sidebar">
	<?php dynamic_sidebar('archive-courses-sidebar'); ?>
	</div><!-- sidebar -->
<?php endif; ?>

</div>
<?php

	
	//do_action( 'learn-press/after-courses-loop' );


	/**
	 * LP Hook
	 */
	do_action( 'learn-press/after-main-content' );

	/**
	 * LP Hook
	 *
	 * @since 4.0.0
	 */
	//do_action( 'learn-press/sidebar' );
	?>

</div>
</div></div>

<?php
/**
 * @since 4.0.0
 *
 * @see   LP_Template_General::template_footer()
 */
if ( ! wp_is_block_theme() ) {
	do_action( 'learn-press/template-footer' );
}
