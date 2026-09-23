<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/
*
* Team Category
*
*/
// global $tx;
get_header();
// $item_per_page = $tx['team_archive_per_page'];
// $display = $tx['team_archive_display'];
// $title = $tx['team_archive_title'];
// $desc = $tx['team_archive_excerpt'];
// $social_profiles = $tx['team_archive_social_profiles'];
// $team_category = $tx['team_archive_category'];

$item_per_page     = tx_get_option('team_archive_per_page', 12);
$display           = tx_get_option('team_archive_display', 'grid_t');
$title             = tx_is_enabled('team_archive_title');
$desc              = tx_is_enabled('team_archive_excerpt');
$social_profiles   = tx_is_enabled('team_archive_social_profiles');
$team_category     = tx_is_enabled('team_archive_category');
?>

<div class="container space-content">
	<div class="row">
		<?php
		// global $tx;
		$term = get_queried_object();
		$args = array(
		          'post_type'           => 'team',
		          'status'              => 'published',
		          'team-category' 		=> $term->slug,
		          'posts_per_page'      => $item_per_page,
		);

		$query = new WP_Query( $args ); ?>
  		<?php if ( $query->have_posts() ) : ?>
  	 	
  		
		<?php while ( $query->have_posts() ) : $query->the_post(); ?>
			<div class="col-lg-3 col-xs-12 col-sm-6">
				<div class="team <?php echo esc_attr($display); ?>">
				<figure>
					<a href="<?php the_permalink(); ?>" rel="bookmark">
					<?php the_post_thumbnail('tx-t-thumb'); ?>		
					<?php if($display == 'grid_t'): ?>
					<figcaption>
						<?php if($title) : ?>
							<h4><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
						<?php endif; ?>
						<?php
							global $post;
					        $terms = get_the_terms( $post->ID, 'team-category' );
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
						<?php if(!empty($cat_name) && $team_category ) : ?>
						<p class="team-cat"><a href="<?php echo esc_url($cat_link); ?>"><?php echo esc_html($cat_name); ?></a></p>
						<?php endif; ?>
						<?php if($desc == 1) : ?>
						<div class="team-bio"><?php echo tx_excerpt_limit(15); ?></div>
						<?php endif; ?>
						<?php if($social_profiles ): do_action('tx_single_team_social_icons'); endif; ?>
					</figcaption>
					<?php endif; ?>
					</a>

					<?php if( $display == 'card_t' ) : 
						if($team_category || $title || $desc || $social_profiles):
					?>
					<div class="tx-team-card">
							
							<?php if($title) : ?>
							<h4><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
							<?php endif; ?>

							<?php
							global $post;
					        $terms = get_the_terms( $post->ID, 'team-category' );
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
						
						<?php if(!empty($cat_name) && $team_category == 1) : ?>
						<p class="team-cat"><a href="<?php echo esc_url($cat_link); ?>"><?php echo esc_html($cat_name); ?></a></p>
						<?php endif; ?>

						<?php if($desc) : ?>
							<div class="team-bio"><?php echo tx_excerpt_limit(15); ?></div>
						<?php endif; 
							 endif; ?>
						
						<?php if($social_profiles) : do_action('tx_single_team_social_icons'); endif; ?>
					</div>
					<?php endif; ?>
				</figure>
				</div><!-- team -->
			</div>	<!-- col-lg-3 col-xs-12 col-sm-6 -->
		<?php endwhile; ?>

	    
		<?php wp_reset_postdata(); ?>

		<?php else:  ?>
	    <?php get_template_part('template-parts/content/content', 'none'); ?>
	  	<?php endif; ?>
	  	<div class="tx-clear"></div>
	  	<!-- pagination -->
		<?php tx_pagination_number($query->max_num_pages,"",$paged); ?>
</div></div>

<?php get_footer(); ?>
