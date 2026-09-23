<?php

/**
 * User Profile
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

do_action( 'bbp_template_before_user_profile' ); ?>

<div id="bbp-user-profile" class="bbp-user-profile">
	<!-- <h2 class="entry-title">@<?php //bbp_displayed_user_field( 'user_nicename' ); ?></h2> -->
	<div class="bbp-user-section">
		<h3><?php esc_html_e( 'Profile', 'avas' ); ?></h3>
		
		<ul class="tx_bbp_list_group list-group">
			<?php if ( bbp_get_displayed_user_field( 'display_name' ) ) : ?>
			<li class="list-group-item">
				<p class="bbp-user-name"><strong><?php echo esc_html__('Name: ', 'avas'); ?></strong><?php echo bbp_rel_nofollow( bbp_get_displayed_user_field( 'display_name' ) ); ?></p>
			</li>
			<?php endif; ?>
			<?php if ( bbp_get_displayed_user_field( 'age' ) ) : ?>
			<li class="list-group-item">
				<p class="bbp-user-age"><strong><?php echo esc_html__('Age: ', 'avas'); ?></strong><?php echo bbp_rel_nofollow( bbp_get_displayed_user_field( 'age' ) ); ?></p>
			</li>
			<?php endif; ?>
			<?php if ( bbp_get_displayed_user_field( 'gender' ) ) : ?>
			<li class="list-group-item">
				<p class="bbp-user-gender"><strong><?php echo esc_html__('Gender: ', 'avas'); ?></strong><?php echo bbp_rel_nofollow( bbp_get_displayed_user_field( 'gender' ) ); ?></p>
			</li>
			<?php endif; ?>
			<?php if ( bbp_get_displayed_user_field( 'description' ) ) : ?>
			<li class="list-group-item">
				<p><strong><?php echo esc_html('Biographical Info: ', 'avas'); ?></strong></p>
				<p class="bbp-user-description"><?php echo bbp_rel_nofollow( bbp_get_displayed_user_field( 'description' ) ); ?></p>
			</li>
			<?php endif; ?>
			<?php if( bbp_get_displayed_user_field('address') ): ?>
			<li class="list-group-item">
				<p class="bbp-user-description"><strong><?php echo esc_html__('Address: ', 'avas'); ?></strong><?php echo bbp_rel_nofollow( bbp_get_displayed_user_field( 'address' ) ); ?></p>
			</li>
			<?php endif; ?>
			<?php if ( bbp_get_displayed_user_field( 'user_url' ) ) : ?>
			<li class="list-group-item">
				<p class="bbp-user-website"><strong><?php echo esc_html__('Website: ', 'avas'); ?></strong><?php  echo bbp_rel_nofollow( bbp_make_clickable( bbp_get_displayed_user_field( 'user_url' ) ) ); ?></p>
			</li>
			<?php endif; ?>
		</ul>

		<h3><?php esc_html_e( 'Forums', 'avas' ); ?></h3>
		<p class="bbp-user-forum-role"><strong><?php echo esc_html__('Registered: ', 'avas'); ?></strong><?php echo bbp_get_time_since( bbp_get_displayed_user_field( 'user_registered' ) ); ?></p>
		<?php if ( bbp_get_user_last_posted() ) : ?>

			<p class="bbp-user-last-activity"><strong><?php echo esc_html__('Last Activity: ', 'avas'); ?></strong><?php  echo bbp_get_time_since( bbp_get_user_last_posted(), false, true ); ?></p>

		<?php endif; ?>

		<p class="bbp-user-topic-count"><strong><?php echo esc_html__('Topics Started: ', 'avas'); ?></strong><?php echo bbp_get_user_topic_count(); ?></p>
		<p class="bbp-user-reply-count"><strong><?php echo esc_html__('Replies Created: ', 'avas'); ?></strong><?php echo bbp_get_user_reply_count(); ?></p>
		<p class="bbp-user-forum-role"><strong><?php echo esc_html__('Forum Role: ', 'avas'); ?></strong><?php  echo bbp_get_user_display_role(); ?></p>

		<div class="social_profile">
			<?php if( bbp_get_displayed_user_field('facebook') !='' ): ?>
			<a href="<?php echo bbp_rel_nofollow( bbp_get_displayed_user_field( 'facebook' ) ); ?>" target="_blank" class="profile_link_fb"><i class="fab fa-facebook-square" aria-hidden="true"></i></a>
			<?php endif; ?>
			<?php if( bbp_get_displayed_user_field('twitter') !='' ): ?>
			<a href="<?php echo bbp_rel_nofollow( bbp_get_displayed_user_field( 'twitter' ) ); ?>" target="_blank" class="profile_link"><i class="fab fa-twitter-square" aria-hidden="true"></i></a>
			<?php endif; ?>
			<?php if( bbp_get_displayed_user_field('linkedin') !='' ): ?>
			<a href="<?php echo bbp_rel_nofollow( bbp_get_displayed_user_field( 'linkedin' ) ); ?>" target="_blank" class="profile_link"><i class="fab fa-linkedin-square" aria-hidden="true"></i></a>
			<?php endif; ?>
			<?php if( bbp_get_displayed_user_field('instagram') !='' ): ?>
			<a href="<?php echo bbp_rel_nofollow( bbp_get_displayed_user_field( 'instagram' ) ); ?>" target="_blank" class="profile_link"><i class="fab fa-instagram" aria-hidden="true"></i></a>
			<?php endif; ?>
		</div>

	</div>
</div><!-- #bbp-author-topics-started -->

<?php do_action( 'bbp_template_after_user_profile' );
