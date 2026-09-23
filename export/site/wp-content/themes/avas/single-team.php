<?php
/**
 * 
 * @package tx
 * @author theme-x
 * @link https://theme-x.org/
*
* ====================================
*         Single Team
* ====================================
*
*/


get_header();

global $post;

$hire_me = get_post_meta( $post->ID, 'hire_me', true );
$hour_rate = get_post_meta( $post->ID, 'hour_rate', true );
$skill_title = get_post_meta($post->ID, 'skill_title', true);
$skill_fields = get_post_meta($post->ID, 'skill_fields', true);
?>
	
<div class="container space-content">
  	<div class="row">
  		<?php if (have_posts()): while (have_posts()): the_post(); ?>
		<div class="col-md-5 col-sm-12 team-single-left">
			<?php the_post_thumbnail('tx-ts-thumb'); ?>
			<?php if(tx_is_enabled('team_social_profile')) : ?>
			<div class="team_profile">
				<?php if (!empty($hire_me) || ($hour_rate) ) : $hire_me_hour = $hour_rate; ?>
    				<a href="<?php echo esc_url($hire_me); ?>" class="hire_me"><?php echo esc_attr($hire_me_hour); ?></a>
  				<?php endif; ?>
				<div class="team-social-box"><?php do_action('tx_single_team_social_icons'); ?></div><!-- Social media -->
			</div>
			<?php endif; ?>
			<div id="secondary" class="col-md-10 col-sm-12 widget-area mt40" role="complementary">
			<?php
				if (is_active_sidebar('sidebar-team')) : 
    			dynamic_sidebar('sidebar-team'); ?>
			<?php endif; ?>
			</div>
		</div> <!-- left column end -->

		<div class="col-md-7 col-sm-12 team-single-right">
			<?php do_action('tx_single_team_header'); ?> <!-- team header-->

			<div class="team-content"><?php the_content(); ?></div>

			<div class="team-skills">
			  <?php 
			    if ( !empty($skill_title) ) : ?>
			    <h4 class="skill-title"><?php echo esc_html($skill_title ); ?></h4>
			  <?php 
			    endif;           
			    if ( $skill_fields ) :
			      foreach ( $skill_fields as $field ) :
			        if($field['name'] != '') : ?>
			          <h5 class="skill-name"><?php echo esc_html( $field['name'] ); ?></h5>
			  <?php endif;
			        if($field['value'] != '') : ?>
			        <div class="progress">
			          <div class="progress-bar" role="progressbar" style="width: <?php echo esc_attr( $field['value'] ); ?>%;" aria-valuemin="0" aria-valuemax="100"><?php echo esc_attr( $field['value'] ); ?>%</div>
			        </div>
			  <?php endif;
			        endforeach;
			        endif; ?>
		    </div><!-- team-skills-->

			<?php if(tx_is_enabled('project_experience')): ?>
				<h4 class="project-exp-title"><?php echo esc_html(tx_get_option('project_experience_title', 'Project Experience') ); ?></h4>
				<?php get_template_part( 'template-parts/project', 'experience' ) ?> <!-- project experience-->
			<?php endif; ?>

		</div> <!-- right column end -->

    <?php endwhile;	?>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>

</div></div>
<?php get_footer();