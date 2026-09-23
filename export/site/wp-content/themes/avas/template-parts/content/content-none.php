<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/
*
*/
global $tx;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-content">
        <h4 class="center"><?php echo esc_html($tx['content-none-text']); ?></h4>
    </div><!-- .entry-content -->
</article><!-- #post-## -->