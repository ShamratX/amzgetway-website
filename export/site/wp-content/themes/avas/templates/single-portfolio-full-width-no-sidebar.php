<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/
*
* Template Name: Full Width No Sidebar
* Template Post Type: portfolio
*
*/
global $tx;
$project_completion_title = get_post_meta($post->ID, 'project_completion_title', true);
$completion = get_post_meta($post->ID, 'completion', true);
$project_title = get_post_meta($post->ID, 'project_title', true);
$project_fields = get_post_meta($post->ID, 'project_fields', true);
$web_url = get_post_meta($post->ID, 'web_url', true);
$port_vid_link = get_post_meta( $post->ID, 'port_vid_link', true );
get_header(); 

if (have_posts()): while (have_posts()): the_post(); ?>
<div class="container space-content">
  	<div class="row">
        <div class="col-md-12"> 
        <div class=""><!-- Image part start -->
            <?php 
            $images = get_post_meta($post->ID, 'tx_gallery_id', true);
            if(function_exists('tx_add_gallery_metabox') && $images) { ?>
            <div class="item">  <!-- slider starts -->         
                <ul id="portfolio-gallery-full-width" class="gallery list-unstyled cS-hidden">
                <?php         
               
                if($images) :
                foreach ($images as $image) {

                $image_thumb_url = wp_get_attachment_image_src($image, 'tx-s-thumb'); 
                $thumbs = $image_thumb_url[0];
                $gallery = wp_get_attachment_image($image, 'tx-xl-thumb');

                    echo '<li data-thumb = "'.$thumbs.'">';                
                    echo  wp_kses_post($gallery); // no need to escape
                    echo '</li>';  
            }
                  endif;
            ?>
                </ul>
            </div>  <!-- slider end -->
            <?php } elseif( function_exists('tx_portfolio_video_link') && $port_vid_link ) {
                do_action('tx_portfolio_video_link');
             } else { ?>
             <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('tx-xl-thumb'); ?>
            <?php endif; ?>
            <?php } ?>
        </div><!-- Image part end -->
            <div class="portfolio_content">
                <?php the_content(); ?>
            </div>
            <?php 
                if ($tx['portfolio-comments']) :
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                endif;
            ?> <!-- comments section -->
        </div>

<?php endwhile;	
	endif; ?>
</div></div>
<?php get_footer(); ?>