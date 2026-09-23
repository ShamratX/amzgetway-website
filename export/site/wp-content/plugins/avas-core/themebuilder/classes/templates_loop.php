<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once TX_PLUGIN_PATH . 'themebuilder/classes/utilities.php'; //  utilities

/**
** Templates_Loop setup
*/
class TX_Templates_Loop {

	/**
	** Loop Through Custom Templates
	*/
	public static function render_theme_builder_templates( $template ) {
		// WP_Query arguments
		$args = array (
			'post_type'   => array( 'tx_templates' ),
			'post_status' => array( 'publish' ),
			'posts_per_page' => -1,
			'tax_query'   => array(
				array(
					'taxonomy' => 'tx_template_type',
					'field'    => 'slug',
					'terms'    => [ $template, 'user' ],
					'operator' => 'AND'
				)
			)
		);

		// The Query
		$user_templates = get_posts( $args );

		// The Loop
		echo '<ul class="tx-'. esc_attr($template) .'-templates-list tx-my-templates-list" data-pro="test">';

			if ( ! empty( $user_templates ) ) {
				foreach ( $user_templates as $user_template ) {
					$slug = $user_template->post_name;
					$edit_url = str_replace( 'edit', 'elementor', get_edit_post_link( $user_template->ID ) );
					$show_on_canvas = get_post_meta(Utilities::get_template_id($slug), 'tx_'. $template .'_show_on_canvas', true);

					echo '<li>';
				        echo '<h3 class="tx-title">'. esc_html($user_template->post_title) .'</h3>';

				        echo '<div class="tx-action-buttons">';
							// Activate
							echo '<span class="tx-template-conditions button button-primary" data-slug="'. esc_attr($slug) .'" data-show-on-canvas="'. esc_attr($show_on_canvas) .'">'. esc_html__( 'Manage Conditions', 'avas-core' ) .'</span>';
							// Edit
							echo '<a href="'. esc_url($edit_url) .'" class="tx-edit-template button button-primary">'. esc_html__( 'Edit Template', 'avas-core' ) .'</a>';

							// Delete
							$one_time_nonce = wp_create_nonce( 'delete_post-' . $slug );

							echo '<span class="tx-delete-template button button-primary"  data-nonce="'. $one_time_nonce .'" data-slug="'. esc_attr($slug) .'" data-warning="'. esc_html__( 'Are you sure you want to delete this template?', 'avas-core' ) .'"><span class="dashicons dashicons-no-alt"></span></span>';


				        echo '</div>';
					echo '</li>';
				}
			} else {
				echo '<li class="tx-no-templates">You don\'t have any templates yet!</li>';
			}

		echo '</ul>';

		// Restore original Post Data
		wp_reset_postdata();

	}

	/**
	** Loop Through My Templates
	*/
	public static function render_elementor_saved_templates() {

		// WP_Query arguments
		$args = array (
			'post_type' => array( 'elementor_library' ),
			'post_status' => array( 'publish' ),
			'meta_key' => '_elementor_template_type',
			'meta_value' => ['page', 'section'],
			'numberposts' => -1
		);

		// The Query
		$user_templates = get_posts( $args );

		// My Templates List
		echo '<ul class="tx-my-templates-list striped">';

		// The Loop
		if ( ! empty( $user_templates ) ) {
			foreach ( $user_templates as $user_template ) {
				// Edit URL
				$edit_url = str_replace( 'edit', 'elementor', get_edit_post_link( $user_template->ID ) );

				// List
				echo '<li>';
					echo '<h3 class="tx-title">'. esc_html($user_template->post_title) .'</h3>';
					
					echo '<span class="tx-action-buttons">';
						echo '<a href="'. esc_url($edit_url) .'" class="tx-edit-template button button-primary">'. esc_html__( 'Edit', 'avas-core' ) .'</a>';
						echo '<span class="tx-delete-template button button-primary" data-slug="'. esc_attr($user_template->post_name) .'" data-warning="'. esc_html__( 'Are you sure you want to delete this template?', 'avas-core' ) .'"><span class="dashicons dashicons-no-alt"></span></span>';
					echo '</span>';
				echo '</li>';
			}
		} else {
			echo '<li class="tx-no-templates">You don\'t have any templates yet!</li>';
		}
		
		echo '</ul>';

		// Restore original Post Data
		wp_reset_postdata();
	}

	/**
	** Render Conditions Popup
	*/
	public static function render_conditions_popup() {
		global $tx;
		// Active Tab
		$active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'tx_tab_header';
		
	?>

    <div class="tx-condition-popup-wrap tx-admin-popup-wrap">
        <div class="tx-condition-popup tx-admin-popup">
            <header>
                <h2><?php esc_html_e( 'Where Do You Want to Display Your Template?', 'avas-core' ); ?></h2>
                <p>
                    <?php esc_html_e( 'Set the conditions that determine where your Template is used throughout your site.', 'avas-core' ); ?><br>
                    <?php esc_html_e( 'For example, choose \'Entire Site\' to display the template across your site.', 'avas-core' ); ?>
                </p>
            </header>
            <span class="close-popup dashicons dashicons-no-alt"></span>

            <!-- Conditions -->
            <div class="tx-conditions-wrap">
                <div class="tx-conditions-sample">
						<!-- Global -->
						<select name="global_condition_select" class="global-condition-select">
							<option value="global"><?php esc_html_e( 'Entire Site', 'avas-core' ); ?></option>
							<option value="archive"><?php esc_html_e( 'Archives', 'avas-core' ); ?></option>
							<option value="single"><?php esc_html_e( 'Singular', 'avas-core' ); ?></option>
						</select>

						<!-- Archive -->
						<select name="archives_condition_select" class="archives-condition-select">
							<?php if ( 'tx_tab_header' === $active_tab || 'tx_tab_footer' === $active_tab ) : ?>
								<option value="all_archives"><?php esc_html_e( 'All Archives', 'avas-core' ); ?></option>
								<option value="posts"><?php esc_html_e( 'Posts Archive', 'avas-core' ); ?></option>
								<option value="author"><?php esc_html_e( 'Author Archive', 'avas-core' ); ?></option>
								<option value="date"><?php esc_html_e( 'Date Archive', 'avas-core' ); ?></option>
								<option value="search"><?php esc_html_e( 'Search Results', 'avas-core' ); ?></option>
								<option value="categories" class="custom-ids"><?php esc_html_e( 'Post Categories', 'avas-core' ); ?></option>
								<option value="tags" class="custom-ids"><?php esc_html_e( 'Post Tags', 'avas-core' ); ?></option>
								<?php if(class_exists('WooCommerce')) : ?>	
									<option value="archive-product" class="custom-ids"><?php esc_html_e( 'Product Archive', 'avas-core' ); ?></option>
								<?php endif; ?>
								<?php if($tx['portfolio_post_type']) : ?>
									<option value="archive-portfolio" class="custom-ids"><?php esc_html_e( $tx['portfolio_title'] . ' Archive', 'avas-core' ); ?></option>
								<?php endif; ?>
								<?php if($tx['service_post_type']) : ?>
									<option value="archive-service" class="custom-ids"><?php esc_html_e( $tx['services_title'] . ' Archive', 'avas-core' ); ?></option>
								<?php endif; ?>	
								<?php if($tx['team_post_type']) : ?>	
									<option value="archive-team" class="custom-ids"><?php esc_html_e( $tx['team_title'] . ' Archive', 'avas-core' ); ?></option>
								<?php endif; ?>	
								
								<?php // Custom Taxonomies
									$custom_taxonomies = Utilities::get_custom_types_of( 'tax', true );
									foreach ($custom_taxonomies as $key => $value) {

										// List Taxonomies
										echo '<option value="'. esc_attr($key) .'" class="custom-type-ids">'. esc_html($value) .'</option>';
									}
								?>					
							<?php else: ?>
								<?php if ( 'tx_tab_archive' === $active_tab ) : ?>
									<option value="all_archives"><?php esc_html_e( 'All Archives', 'avas-core' ); ?></option>
									<option value="posts"><?php esc_html_e( 'Posts Archive', 'avas-core' ); ?></option>
									<option value="author"><?php esc_html_e( 'Author Archive', 'avas-core' ); ?></option>
									<option value="date"><?php esc_html_e( 'Date Archive', 'avas-core' ); ?></option>
									<option value="search"><?php esc_html_e( 'Search Results', 'avas-core' ); ?></option>
									<option value="categories" class="custom-ids"><?php esc_html_e( 'Post Categories', 'avas-core' ); ?></option>
									<option value="tags" class="custom-ids"><?php esc_html_e( 'Post Tags', 'avas-core' ); ?></option>

								<?php if(class_exists('WooCommerce')) : ?>	
									<option value="archive-product" class="custom-ids"><?php esc_html_e( 'Product Archive', 'avas-core' ); ?></option>
								<?php endif; ?>
								<?php if($tx['portfolio_post_type']) : ?>
									<option value="archive-portfolio" class="custom-ids"><?php esc_html_e( $tx['portfolio_title'] . ' Archive', 'avas-core' ); ?></option>
								<?php endif; ?>
								<?php if($tx['service_post_type']) : ?>
									<option value="archive-service" class="custom-ids"><?php esc_html_e( $tx['services_title'] . ' Archive', 'avas-core' ); ?></option>
								<?php endif; ?>	
								<?php if($tx['team_post_type']) : ?>	
									<option value="archive-team" class="custom-ids"><?php esc_html_e( $tx['team_title'] . ' Archive', 'avas-core' ); ?></option>
								<?php endif; ?>	

									<?php // Custom Taxonomies
										$custom_taxonomies = Utilities::get_custom_types_of( 'tax', true );
										foreach ($custom_taxonomies as $key => $value) {
											// List Taxonomies
											echo '<option value="'. esc_attr($key) .'" class="custom-type-ids">'. esc_html($value) .'</option>';
										}
									?>
								
								<?php endif; ?>
							<?php endif; ?>
						</select>

						<!-- Single -->
						<select name="singles_condition_select" class="singles-condition-select">
							<?php if ( 'tx_tab_header' === $active_tab || 'tx_tab_footer' === $active_tab ) : ?>
								<option value="front_page"><?php esc_html_e( 'Front Page', 'avas-core' ); ?></option>
								<option value="page_404"><?php esc_html_e( '404 Page', 'avas-core' ); ?></option>
								<option value="pages" class="custom-ids"><?php esc_html_e( 'Pages', 'avas-core' ); ?></option>
								<option value="posts" class="custom-ids"><?php esc_html_e( 'Posts', 'avas-core' ); ?></option>
								<?php // Custom Post Types
									$custom_post_types = Utilities::get_custom_types_of( 'post', true );
									foreach ($custom_post_types as $key => $value) {
										echo '<option value="'. esc_attr($key) .'" class="custom-type-ids">'. esc_html($value) .'</option>';
									}
								?>					
							<?php else: ?>
								<?php if ( 'tx_tab_single' === $active_tab ) : ?>
									<option value="front_page"><?php esc_html_e( 'Front Page', 'avas-core' ); ?></option>
									<option value="page_404"><?php esc_html_e( '404 Page', 'avas-core' ); ?></option>
									<option value="pages" class="custom-ids"><?php esc_html_e( 'Pages', 'avas-core' ); ?></option>
									<option value="posts" class="custom-ids"><?php esc_html_e( 'Posts', 'avas-core' ); ?></option>

									<?php // Custom Post Types
										$custom_post_types = Utilities::get_custom_types_of( 'post', true );
										foreach ($custom_post_types as $key => $value) {
											echo '<option value="'. esc_attr($key) .'" class="custom-type-ids">'. esc_html($value) .'</option>';
										}
									?>
								
								<?php endif; ?>
							<?php endif; ?>
						</select>

						<input type="text" placeholder="<?php esc_html_e( 'Enter comma separated IDs', 'avas-core' ); ?>" name="condition_input_ids" class="tx-condition-input-ids">
						<span class="tx-delete-template-conditions dashicons dashicons-no-alt"></span>

	                
                </div>
            </div>
          
            <!-- Action Buttons -->
            <span class="tx-add-conditions"><?php esc_html_e( 'Add Conditions', 'avas-core' ); ?></span>
            <span class="tx-save-conditions"><?php esc_html_e( 'Save Conditions', 'avas-core' ); ?></span>

        </div>
    </div>

	<?php
	}


	/**
	** Render Create Template Popup
	*/
	public static function render_create_template_popup() {
	?>

    <!-- Custom Template Popup -->
    <div class="tx-user-template-popup-wrap tx-admin-popup-wrap">
        <div class="tx-user-template-popup tx-admin-popup">
        	<header>
	            <h2><?php esc_html_e( 'Elementor Custom Templates', 'avas-core' ); ?></h2>
	            <p><?php esc_html_e( 'Use templates to create the different pieces of your site, and reuse them with one click whenever needed.', 'avas-core' ); ?></p>
			</header>

            <input type="text" name="user_template_title" class="tx-user-template-title" placeholder="<?php esc_html_e( 'Enter template name', 'avas-core' ); ?>">
            <input type="hidden" name="user_template_type" class="user-template-type">
            <span class="tx-create-template"><?php esc_html_e( 'Create Template', 'avas-core' ); ?></span>
            <span class="close-popup dashicons dashicons-no-alt"></span>
        </div>
    </div>

	<?php
	}

	/**
	** Check if Library Template Exists
	*/
	public static function template_exists( $slug ) {
		$result = false;
		$tx_templates = get_posts( ['post_type' => 'tx_templates', 'posts_per_page' => '-1'] );

		foreach ( $tx_templates as $post ) {

			if ( $slug === $post->post_name ) {
				$result = true;
			}
		}

		return $result;
	}

}

new TX_Templates_Loop();