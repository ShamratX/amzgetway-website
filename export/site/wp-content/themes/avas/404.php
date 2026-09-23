<?php
/**
 * 404 Error Page Template
 * 
 * @package tx
 * @author theme-x
 * @link https://theme-x.org/
 */

get_header(); 
?>

<div class="container">
	<div class="row">
		<div class="error-404">
			<h1><?php echo esc_html( tx_get_option('404_numb', '404') ); ?></h1>
			<h4><?php echo esc_html( tx_get_option('404_heading', 'Page Not Found') ); ?></h4>
			<p><?php echo esc_html( tx_get_option('404_desc', 'Sorry, the page you are looking for does not exist.') ); ?></p>
			<a class="tx_404_btn" href="<?php echo esc_url(home_url()); ?>">
			    <?php echo esc_html( tx_get_option('404_btn', 'Back to Home') ); ?>
			</a>
		</div><!-- /.error-404 -->
	</div><!-- /.row -->
</div><!-- /.container -->

<?php get_footer(); ?>