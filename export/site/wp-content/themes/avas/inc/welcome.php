<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/
*
* Welcome Screen
*
*/

if( !class_exists('tx_Welcome_Screen') ) {
  class tx_Welcome_Screen {
    public $is_activated;
    function __construct() {
      $this->tx_init();
    }

    public function tx_init() {
      $this->is_activated = get_option('is_valid');
      add_action('admin_menu', array($this, 'tx_welcome_menu'));
      add_action('admin_init', array($this, 'tx_theme_redirect'));
    }

    public function tx_welcome_menu() {
      call_user_func('add_'. 'menu' .'_page', 'Welcome Menu', 'Avas', 'edit_posts', 'Welcome', array($this, 'tx_welcome_msg'), null, 60);
      add_submenu_page( 'Welcome', 'License', 'License', 'import', 'admin.php?page=Welcome' );    
    if( !is_plugin_active('avas-core/avas-core.php') || !is_plugin_active('one-click-demo-import/one-click-demo-import.php') ) :
      add_submenu_page( 'Welcome', 'Manage Plugins', 'Manage Plugins', 'manage_options', 'admin.php?page=manage-plugins' );
    endif;

    if(class_exists('OCDI_Plugin') && is_plugin_active('avas-core/avas-core.php')) :
      add_submenu_page( 'Welcome', 'Import Demo', 'Import Demo', 'manage_options', 'admin.php?page=one-click-demo-import' );
    endif;
    
    if(class_exists('ReduxFramework')) :
      if( is_child_theme() ) :
        add_submenu_page( 'Welcome', 'Theme Options', 'Theme Options', 'manage_options', 'admin.php?page=AvasChild' );
      else:
        add_submenu_page( 'Welcome', 'Theme Options', 'Theme Options', 'manage_options', 'admin.php?page=avas' );
      endif;
    endif;

    if ( is_plugin_active('elementor/elementor.php') && class_exists('TX_ThemeBuilder') ) :
      add_submenu_page( 'Welcome', 'Theme Builder', 'Theme Builder', 'manage_options', 'admin.php?page=tx-theme-builder' );
    endif;


    }

    public function tx_welcome_msg() { 
      $theme = wp_get_theme();
    ?>

      <div class="tx-wel-wrap">
         <?php echo '<p style="border-bottom:1px solid #e6e6e6;margin-top: 30px; margin-bottom: 35px;"></p>'; ?>
        <h1><?php esc_html_e( 'Welcome to Avas', 'avas'); ?><a href="https://avas.live/changelog/" target="_blank"><span class="tx-avas-ver"><?php echo esc_html__('v','avas'); ?><?php echo wp_sprintf( $theme->get( 'Version' ) ); ?></span></a></h1>
        
        <div class="tx-wel-txt">
          <?php echo '<p>'.wp_kses_post('Thanks for choosing the Avas theme.','avas').'</p>';
          if( !is_plugin_active('avas-core/avas-core.php') || !is_plugin_active('one-click-demo-import/one-click-demo-import.php') ) :
              echo '<p>'.wp_kses_post('This theme requires the following plugins installed: <strong>Avas Core, One Click Demo Import.</strong>','avas').'</p>';
          ?>
          <h3><a class="button-primary" href="<?php echo esc_url(admin_url('admin.php?page=manage-plugins')); ?>"><?php esc_html_e('Manage Plugins','avas'); ?></a></h3>
        <?php endif; 
          if( is_plugin_active('avas-core/avas-core.php') && is_plugin_active('one-click-demo-import/one-click-demo-import.php') ) : ?>
          <p><?php echo esc_html__('To import demo data please go to Dashboard > Avas > Import Demo or click the button below','avas');?></p>
        <a href="<?php echo esc_url(admin_url('admin.php?page=one-click-demo-import')); ?>" class="button button-primary"><?php echo esc_html_e('Import Demo','avas');?> </a>
        <?php endif;   
          echo '<p>'.wp_kses_post('For more information about how to install theme and import demo data please check our <a href="'.esc_url('https://avas.live/documentation/').'" target="_blank">Documentation.</a>','avas').'</p>'; ?>

          <?php echo '<p>'.wp_kses_post('For any issue please contact us via our <a href="'.esc_url('https://theme-x.org/support-desk/').'" target="_blank">Support Portal.</a>','avas').'<br><span style="font-style:italic;font-size:82%">'.esc_html__('Please note: Our support does not include any customization.', 'avas'). '</span></p>'; ?>

        </div><!-- tx-wel-txt -->
        <div class="tx-sys-info">
          <h2>System Requirements</h2>
          <?php $this->tx_system_requirements(); ?>
        </div><!-- tx-sys-info -->
      <div>
          <?php echo '<p style="border-bottom:1px solid #e6e6e6;margin-top: 30px; margin-bottom: 35px;"></p>'; ?>
          <iframe width="860" height="520" src="https://www.youtube.com/embed/u5hv4_QZdWo" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        </div>
      </div>
    <?php
        }
  
    public function tx_theme_redirect() {
      global $pagenow;
      if ( is_admin() && isset( $_GET['activated'] ) && 'themes.php' == $pagenow ) {
        wp_redirect(admin_url('admin.php?page=Welcome')); 
      }
    }

    static function tx_system_requirements() {
      $php_version = phpversion();
      $max_execution_time = ini_get( 'max_execution_time' );
      $memory_limit = ini_get( 'memory_limit' );
      $post_limit = ini_get( 'post_max_size' );
      $uploads = wp_upload_dir();
      $upload_path = $uploads['basedir'];
      $yes_icon = '<span class="tx-sys-valid"><i class="dashicons-before dashicons-yes"></i></span>';
      $no_icon = '<span class="tx-sys-invalid"><i class="dashicons-before dashicons-no-alt"></i></span>';
    ?>
      <ul class="tx-sys-req">
        <li>
          <span class="tx-sys-left">PHP Version: </span>
    <?php
      if ( version_compare( $php_version, '7.4', '<' ) ) {
            echo  wp_kses_post($no_icon);
            echo  '<span class="tx-sys-right">Currently: ' . $php_version . ' (Minimum: 7.4 Recommended)</span>' ;
    ?>

    <?php
        } else {
            echo  wp_kses_post($yes_icon);
            echo  '<span class="tx-sys-right">Currently: ' . $php_version . '</span>' ;
        }
        
    ?>
        </li>
        <li>
          <span class="tx-sys-left">Memory Limit: </span>
    <?php       
      if ( intval( $memory_limit ) < '256' ) {
            echo  wp_kses_post($no_icon);
            echo  '<span class="tx-sys-right">Currently: ' . $memory_limit . ' (Minimum: 256M Recommended)</span>' ;
        } else {
            echo  wp_kses_post($yes_icon);
            echo  '<span class="tx-sys-right">Currently: ' . $memory_limit . '</span>' ;
        }
    ?>
        </li>

        <li>
          <span class="tx-sys-left">Max Post Limit: </span>
    <?php 
      if ( intval( $post_limit ) < '32' ) {
        echo  wp_kses_post($no_icon);
        echo  '<span class="tx-sys-right">Currently: ' . $post_limit . ' (Minimum: 32M Recommended)</span>' ;
      } else {
        echo  wp_kses_post($yes_icon);
        echo  '<span class="tx-sys-right">Currently: ' . $post_limit . '</span>' ;
      }
    ?>
        </li>
        
        <li>
          <span class="tx-sys-left">Maximum Execution Time: </span>
    <?php 
      if ( $max_execution_time < '90' ) {
            echo  wp_kses_post($no_icon);
            echo  '<span class="tx-sys-right">Currently: ' . $max_execution_time . '(Minimum: 90 Recommended)</span>' ;
        } else {
            echo  wp_kses_post($yes_icon);
            echo  '<span class="tx-sys-right">Currently: ' . $max_execution_time . '</span>' ;
        }
    ?>
        </li>

        <li>
          <span class="tx-sys-left">Uploads Folder Writable: </span>
    <?php 
      if ( !is_writable( $upload_path ) ) {
        echo  wp_kses_post($no_icon);
        echo  '<span class="tx-sys-right">No';
      } else {
          echo  wp_kses_post($yes_icon);
          echo  '<span class="tx-sys-right">Yes';
      }
    ?>
        </li>

      </ul>

    <?php 
    }

  }

  new tx_Welcome_Screen();
}

