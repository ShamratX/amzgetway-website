<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/
 *
 *=========================
 * Search Form Template
 *=========================
 */
?>

<form role="search" method="get" class="tx-search-form-wrap" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="search-field">
		<input type="search" class="s" required="" aria-required="true" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'avas' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	</div>
	<div class="search-button">
		<button type="submit" class="search-submit"><i class="bi bi-search"></i></button>
	</div>
</form>