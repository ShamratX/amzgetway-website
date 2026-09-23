<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once TX_PLUGIN_PATH . 'themebuilder/classes/utilities.php'; //  utilities
require_once TX_PLUGIN_PATH . 'themebuilder/classes/conditions_manager.php'; //  tx_conditions_manager

$conditions = json_decode( get_option('tx_header_conditions', '[]'), true );
$template_slug = TX_Conditions_Manager::header_footer_display_conditions($conditions);

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
	<?php if ( ! current_theme_supports( 'title-tag' ) ) : ?>
		<title>
			<?php echo esc_html(wp_get_document_title()); ?>
		</title>
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php

do_action( 'wp_body_open' );

// Render Header
Utilities::render_elementor_template($template_slug);
