<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


require_once TX_PLUGIN_PATH . 'themebuilder/classes/templates_loop.php';

class TX_ThemeBuilder {
    public function __construct() {
        $this->tx_init();
    }

    public function tx_init() {
        add_action('admin_menu', array($this, 'tx_theme_builder_menu'));
        add_action('admin_init', array($this, 'tx_theme_builder_export'));
        add_action('admin_init', array($this, 'tx_theme_builder_import'));
        
        // Enqueue Scripts
        add_action( 'admin_enqueue_scripts', [ $this, 'templates_library_scripts' ] );

        require_once TX_PLUGIN_PATH . 'themebuilder/classes/templates_library.php';
    }

    // Register submenu
    function tx_theme_builder_menu() {
    	add_menu_page( 'Theme Builder', 'Theme Builder', 'manage_options', 'tx-theme-builder', array($this,'tx_theme_builder_page') );
    }

    /**
    ** Enqueue Scripts and Styles
    */
    public function templates_library_scripts( $hook ) {

        // Deny if NOT Plugin Page
        if ( strpos($hook, 'tx-theme-builder') ) {

            // enqueue CSS
            wp_enqueue_style( 'tx-theme-builder-css', TX_PLUGIN_ASSEETS .'css/theme-builder.min.css', [], TX_PLUGIN_VERSION );

            // enqueue JS
            wp_enqueue_script( 'tx-theme-builder-js', TX_PLUGIN_ASSEETS .'js/theme-builder.min.js', ['jquery'], TX_PLUGIN_VERSION );

            wp_localize_script(
                'tx-theme-builder-js',
                'TXThemeBuilder', // This is used in the js file to group all of your scripts together
                [
                    'nonce' => wp_create_nonce( 'tx-theme-builder-js' ),
                ]
            );
        }

    }

    // theme builder screen
    public function tx_theme_builder_page() {
    ?>

        <div class="wrap tx-settings-page-wrap">
            <div class="tx-settings-page-header">
                <h1><?php echo esc_html_e('Theme Builder','avas-core') ?></h1>
                <p><?php esc_html_e( 'Create custom templates with Elementor.', 'avas-core' ); ?></p>

                <!-- Custom Template -->
                <div class="tx-preview-buttons">
                    <div class="tx-user-template">
                        <span><?php esc_html_e( 'New Template', 'avas-core' ); ?></span>
                        <span class="plus-icon">+</span>
                    </div>
                </div>

            </div>

            <div class="tx-settings-page">
            <form method="post" action="options.php">
                <?php

                // Active Tab
                $active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'tx_tab_header';
                ?>

                <!-- Template ID Holder -->
                <input type="hidden" name="tx_template" id="tx_template" value="">

                <!-- Conditions Popup -->
                <?php TX_Templates_Loop::render_conditions_popup(true); ?>

                <!-- Create Templte Popup -->
                <?php TX_Templates_Loop::render_create_template_popup(); ?>

                <!-- Tabs -->
                <div class="nav-tab-wrapper tx-nav-tab-wrapper">
                    <a href="?page=tx-theme-builder&tab=tx_tab_header" data-title="Header" class="nav-tab <?php echo ($active_tab == 'tx_tab_header') ? 'nav-tab-active' : ''; ?>">
                        <?php esc_html_e( 'Header', 'avas-core' ); ?>
                    </a>
                    <a href="?page=tx-theme-builder&tab=tx_tab_footer" data-title="Footer" class="nav-tab <?php echo ($active_tab == 'tx_tab_footer') ? 'nav-tab-active' : ''; ?>">
                        <?php esc_html_e( 'Footer', 'avas-core' ); ?>
                    </a>
                    <a href="?page=tx-theme-builder&tab=tx_tab_archive" data-title="Archive" class="nav-tab <?php echo ($active_tab == 'tx_tab_archive') ? 'nav-tab-active' : ''; ?>">
                        <?php esc_html_e( 'Archive', 'avas-core' ); ?>
                    </a>
                    <a href="?page=tx-theme-builder&tab=tx_tab_single" data-title="Single" class="nav-tab <?php echo ($active_tab == 'tx_tab_single') ? 'nav-tab-active' : ''; ?>">
                        <?php esc_html_e( 'Single', 'avas-core' ); ?>
                    </a>
                </div>

                <?php if ( $active_tab == 'tx_tab_header' ) : ?>

                    <!-- Save Conditions -->
                    <input type="hidden" name="tx_header_conditions" id="tx_header_conditions" value="<?php echo esc_attr(get_option('tx_header_conditions', '[]')); ?>">

                    <?php TX_Templates_Loop::render_theme_builder_templates( 'header' ); ?>

                <?php elseif ( $active_tab == 'tx_tab_footer' ) : ?>

                    <!-- Save Conditions -->
                    <input type="hidden" name="tx_footer_conditions" id="tx_footer_conditions" value="<?php echo esc_attr(get_option('tx_footer_conditions', '[]')); ?>">

                    <?php TX_Templates_Loop::render_theme_builder_templates( 'footer' ); ?>

                <?php elseif ( $active_tab == 'tx_tab_archive' ) : ?>

                    <!-- Save Conditions -->
                    <input type="hidden" name="tx_archive_conditions" id="tx_archive_conditions" value="<?php echo esc_attr(get_option('tx_archive_conditions', '[]')); ?>">

                    <?php TX_Templates_Loop::render_theme_builder_templates( 'archive' ); ?>

                <?php elseif ( $active_tab == 'tx_tab_single' ) : ?>

                    <!-- Save Conditions -->
                    <input type="hidden" name="tx_single_conditions" id="tx_single_conditions" value="<?php echo esc_attr(get_option('tx_single_conditions', '[]')); ?>">

                    <?php TX_Templates_Loop::render_theme_builder_templates( 'single' ); ?>

                <?php endif; ?>

            </form>
            </div>
        </div>

        <!-- export import conditions forms -->
        <div class="tx-theme-builder-export-import">
            <h3><?php esc_html_e( 'Export Import Templates Conditions', 'avas-core' ); ?></h3>
                <!-- export -->
                <form method="post">
                    <input type="hidden" name="tbix_action" value="export_settings" />
                    <?php wp_nonce_field( 'tb_export_nonce', 'tb_export_nonce' ); ?>
                    <p><?php submit_button( __( 'Export' ), 'secondary', 'submit', false ); ?></p>
                </form>

                <!-- import -->
                <form method="post" enctype="multipart/form-data">
                    <input type="file" name="import_file"/>
                    <input type="hidden" name="tbix_action" value="import_settings" />
                    <?php wp_nonce_field( 'tb_import_nonce', 'tb_import_nonce' ); ?>
                    <?php submit_button( __( 'Import' ), 'secondary', 'submit', false ); ?>
                </form>

        </div>
<?php
    }


/**
 * Process a settings export that generates a .json file of the Theme Builder template conditions
 */
public function tx_theme_builder_export($hook) {

        if( empty( $_POST['tbix_action'] ) || 'export_settings' != $_POST['tbix_action'] )
            return;

        if( ! wp_verify_nonce( $_POST['tb_export_nonce'], 'tb_export_nonce' ) )
            return;

        if( ! current_user_can( 'manage_options' ) )
            return;

        $options = wp_load_alloptions();
        $old_settings = array('tx_header_conditions', 'tx_footer_conditions', 'tx_archive_conditions', 'tx_single_conditions');
        $need_options = array();

            foreach ($options as $name => $value) {
                if ( in_array($name, $old_settings) && $value != '' ) {
                    $need_options[$name] = $value;
                }
            }
            $json_file = json_encode($need_options); // Encode data into json data
            
            ignore_user_abort( true );
            nocache_headers();
            header("Content-Type: text/json; charset=" . get_option( 'blog_charset'));
            header("Content-Disposition: attachment; filename=theme-builder.json");
            header( "Expires: 0" );

            ob_clean();
            echo $json_file;
            exit();
}


/**
 * Process a settings import from a json file
 */
public function tx_theme_builder_import() {

    if( empty( $_POST['tbix_action'] ) || 'import_settings' != $_POST['tbix_action'] )
        return;

    if( ! wp_verify_nonce( $_POST['tb_import_nonce'], 'tb_import_nonce' ) )
        return;

    if( ! current_user_can( 'manage_options' ) )
        return;

    $extension = end( explode( '.', $_FILES['import_file']['name'] ) );

    if( $extension != 'json' ) {
        wp_die( __( 'Please upload a valid .json file' ) );
    }

    $import_file = $_FILES['import_file']['tmp_name'];

    if( empty( $import_file ) ) {
        wp_die( __( 'Please upload a file to import' ) );
    }

    $encode_options = file_get_contents($import_file);
    $options = json_decode($encode_options, true);      
            
      foreach ($options as $key => $value) {
        update_option($key, $value);
      } 

    wp_safe_redirect( admin_url( 'admin.php?page=tx-theme-builder' ) ); exit;

}


}

new TX_ThemeBuilder();