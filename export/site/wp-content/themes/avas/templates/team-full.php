<?php
/**
 * Template Name: Team Full Width (Publish & Reload page)
 *
 * @package tx
 * @author theme-x
 * @link https://theme-x.org/
 */

get_header();

// Use fallback if meta values are missing
$post_id = get_the_ID();

$item_per_page     = get_post_meta( $post_id, 'item_per_page', true ) ?: 12;
$display           = get_post_meta( $post_id, 'display', true ) ?: 'grid_t';
$title             = get_post_meta( $post_id, 'title', true ) ?: 'show';
$desc              = get_post_meta( $post_id, 'desc', true ) ?: 'show';
$social_profiles   = get_post_meta( $post_id, 'social_profiles', true ) ?: 'show';
$team_category     = get_post_meta( $post_id, 'team_category', true ) ?: 'show';
?>

<div class="container-fluid">
	<div class="row">
		<?php
		$paged = max( get_query_var('paged'), get_query_var('page'), 1 );

		$args = [
			'post_type'      => 'team',
			'posts_per_page' => $item_per_page,
			'paged'          => $paged
		];

		$query = new WP_Query( $args );

		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) : $query->the_post();
		?>
		<div class="col-lg-2 col-xs-12 col-sm-6">
			<div class="team <?php echo esc_attr($display); ?>">
				<figure>
					<a href="<?php the_permalink(); ?>" rel="bookmark">
						<?php the_post_thumbnail('tx-tf-thumb'); ?>
						<?php if ( $display === 'grid_t' ) : ?>
							<figcaption>
								<?php if ( $title === 'show' ) : ?>
									<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
								<?php endif; ?>

								<?php
								$terms     = get_the_terms( get_the_ID(), 'team-category' );
								$cat_name  = '';
								$cat_link  = '';

								if ( $terms && ! is_wp_error( $terms ) ) {
									$cat_name = join(" ", wp_list_pluck($terms, 'name'));
									$cat_link = get_term_link( $terms[0] );
								}
								?>

								<?php if ( $cat_name && $team_category === 'show' ) : ?>
									<p class="team-cat"><a href="<?php echo esc_url($cat_link); ?>"><?php echo esc_html($cat_name); ?></a></p>
								<?php endif; ?>

								<?php if ( $desc === 'show' ) : ?>
									<div class="team-bio"><?php echo tx_excerpt_limit(15); ?></div>
								<?php endif; ?>

								<?php if ( $social_profiles === 'show' ) : do_action('tx_single_team_social_icons'); endif; ?>
							</figcaption>
						<?php endif; ?>
					</a>

					<?php if ( $display === 'card_t' ) :
						if ( $title === 'show' || $desc === 'show' || $team_category === 'show' || $social_profiles === 'show' ) : ?>
							<div class="tx-team-card">
								<?php if ( $title === 'show' ) : ?>
									<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
								<?php endif; ?>

								<?php if ( $cat_name && $team_category === 'show' ) : ?>
									<p class="team-cat"><a href="<?php echo esc_url($cat_link); ?>"><?php echo esc_html($cat_name); ?></a></p>
								<?php endif; ?>

								<?php if ( $desc === 'show' ) : ?>
									<div class="team-bio"><?php echo tx_excerpt_limit(15); ?></div>
								<?php endif; ?>

								<?php if ( $social_profiles === 'show' ) : do_action('tx_single_team_social_icons'); endif; ?>
							</div>
						<?php endif;
					endif; ?>
				</figure>
			</div><!-- /.team -->
		</div><!-- /.col -->
		<?php endwhile; ?>
		
		<?php wp_reset_postdata(); ?>
		<?php else: ?>
			<?php get_template_part('template-parts/content/content', 'none'); ?>
		<?php endif; ?>

		<div class="tx-clear"></div>

		<!-- pagination -->
		<?php tx_pagination_number($query->max_num_pages, '', $paged); ?>
	</div>
</div>

<?php get_footer();