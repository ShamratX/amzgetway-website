<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/
*
* Services Archives
*
**/
get_header();

$item_per_page         = tx_get_option( 'service_archive_item', 9 );
$display               = tx_get_option( 'service_archive_display', 'grid' );
$title                 = tx_is_enabled( 'service_archive_title' );
$desc                  = tx_is_enabled( 'service_archive_excerpt' );
$link                  = tx_is_enabled( 'service_archive_link' );
$serv_category         = tx_is_enabled( 'service_archive_category' );
$service_excerpt_limit = tx_get_option( 'service_excerpt_limit', 20 );
?>

<div class="container space-content">
	<div class="row">
		<?php
		  $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

		  $args = array(
		          'post_type'       => 'service',
		          'status'          => 'published', 
		          'posts_per_page'  => $item_per_page,
		          'paged'           => $paged,
		    );

		  $serv_query = new WP_Query( $args );
		?>
			<?php
      			if ($serv_query->have_posts()) : 
      				while ($serv_query->have_posts()) : $serv_query->the_post();

      				global $post;
			        $terms = get_the_terms( $post->ID, 'service-category' );
			        if ( $terms && ! is_wp_error( $terms ) ) :
			          $taxonomy = array();
			          foreach ( $terms as $term ) :
			            $taxonomy[] = $term->name;
			          endforeach;
			          $cat_name = join( " ", $taxonomy);
			          $cat_link = get_term_link( $term );
			      	else:
			      		$cat_name = '';
			      	endif;	
      		?>
	      				<?php if($display == 'grid') : ?>
	      				<div class="col-lg-4 col-md-6">
	      					<div class="tx-services-item">
	      					<?php if (has_post_thumbnail()) : ?>
	      						<div class="tx-services-featured">
									<a href="<?php the_permalink(); ?>" rel="bookmark">
										<?php the_post_thumbnail('tx-serv-thumb'); ?>
									</a>
								</div>
							<?php endif; ?>
								<div class="tx-services-content">
									<?php if($title) : ?>
									<h3 class="tx-services-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									<?php endif; ?>
									
									<?php if($desc) : ?>
									<p class="tx-services-excp"><?php echo esc_html(tx_excerpt_limit($service_excerpt_limit)); ?></p>
									<?php endif; ?>	
									
									<?php if(!empty($cat_name) && $serv_category) : ?>
										<a class="tx-serv-cat" href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_attr($cat_name); ?></a>
									<?php endif; ?>
								</div><!-- /.tx-services-content -->
							</div><!-- /.tx-services-item -->
	      				</div>
      				<?php elseif($display == 'overlay') : ?>
	      				<div class="col-lg-4 col-md-6">
	      					<?php $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'tx-serv-overlay-thumb'); ?>

	      					<div class="tx-services-overlay-item" <?php if (has_post_thumbnail()) : echo 'style="background-image:url('.$featured_img_url.')"'; endif;?>>
								<div class="tx-services-content">
									<?php if($title) : ?>
									<div class="tx-services-title-holder">
										<h3 class="tx-services-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									</div>
									<?php endif; ?>
									
									<?php if($desc) : ?>
									<p class="tx-services-excp"><?php echo esc_html(tx_excerpt_limit($service_excerpt_limit)); ?></p>
									<?php endif; ?>

									<?php if($link) : ?>	
									<a href="<?php the_permalink(); ?>"><i class="bi bi-arrow-right"></i></a>
									<?php endif; ?>

								</div><!-- /.tx-services-content -->
							</div><!-- /.tx-services-item -->
	      				</div>
      				<?php endif; ?>


      		<?php 	endwhile;
      				wp_reset_postdata();
      			else:  
			    	get_template_part('template-parts/content/content', 'none');
			    endif;
			?>
		<div class="tx-clear"></div>
		<!-- pagination -->
		<?php tx_pagination_number($serv_query->max_num_pages,"",$paged); ?>
</div>
</div>
<?php get_footer( ); ?>