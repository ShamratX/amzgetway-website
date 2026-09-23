<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/
*
* Template Name: Doctor
* Template Post Type: team
*
*/

global $tx;
get_header();
$hire_me = get_post_meta( $post->ID, 'hire_me', true );
$hour_rate = get_post_meta( $post->ID, 'hour_rate', true );
$skill_title = get_post_meta($post->ID, 'skill_title', true);
$skill_fields = get_post_meta($post->ID, 'skill_fields', true);
?>

	
<div class="container space-content">
  	<div class="row">
  		<?php if (have_posts()): while (have_posts()): the_post(); ?>
		<div class="col-lg-5 col-md-5 col-sm-6 team-single-left">
			<?php the_post_thumbnail('tx-ts-thumb'); ?>
			<div class="team_profile">
				<?php if (!empty($hire_me) || ($hour_rate) ) : $hire_me_hour = $hour_rate; ?>
    				<a href="<?php echo esc_url($hire_me); ?>" class="hire_me"><?php echo esc_attr($hire_me_hour); ?></a>
  				<?php endif; ?>
				<div class="team-social-box"><?php do_action('tx_single_team_social_icons'); ?></div><!-- Social media -->
			</div>
		<div id="secondary" class="col-md-10 col-sm-12 widget-area mt40" role="complementary">
			<?php
				if (is_active_sidebar('sidebar-team')) : 
    			dynamic_sidebar('sidebar-team'); ?>
			<?php endif; ?>
		</div>
		</div> <!-- left column end -->

		<div class="col-lg-7 col-sm-6">
			<?php do_action('tx_single_team_header'); ?> <!-- team header-->

			<div class="team-content"><?php the_content(); ?></div>
			
			<div class="team-skills doctor">
                    <?php if ( !empty($skill_title) ) : ?>
                         <h4 class="skill-title"><?php echo esc_html($skill_title ); ?></h4>
                    <?php endif; ?>
                         
                    <?php if ( $skill_fields ) : ?>
                        <?php foreach ( $skill_fields as $field ) : ?>
                        	<p class="doctor-skills">
                                <?php if($field['name'] != '') : ?>
                                <span class="skill-name"><?php echo esc_html( $field['name'] ); ?></span>
                            	<?php endif; ?>

                            	<?php if($field['value'] != '') : ?>
	                            <span class="skill-value"><?php echo esc_attr($field['value']); ?></span>
	                            <?php endif; ?>
	                        </p>

                        <?php endforeach; ?>
                    <?php endif; ?>
			</div><!-- skills end-->



			<?php if($tx['project_experience']): ?>
			<h4 class="project-exp-title"><?php echo esc_html($tx['project_experience_title']); ?></h4>
			<?php get_template_part( 'template-parts/project', 'experience' ) ?> <!-- project experience-->
			<?php endif; ?>


		</div> <!-- right column end -->
			
    <?php endwhile;	?>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
    </div> <!--/ end row -->
</div>

<?php get_footer();