<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/
* ======================================================================
*   Updates 
* ======================================================================
*/

require_once TX_THEME_DIR . 'inc/class-updates.php';
class AvasUpdates {
  public $plugin_file=__FILE__;
  public $responseObj;
  public $licenseMessage;
  public $showMessage=false;
  public $slug="Welcome";
  function __construct() {
    $licenseKey=get_option("Avas_lic_Key","");
    $liceEmail=get_option( "Avas_lic_email","");
    $templateDir=get_template_directory(); //or dirname(__FILE__);
    $whitelist = array( '127.0.0.1', '::1' );
    if(TX_Update_Base::CheckWPPlugin($licenseKey,$liceEmail,$this->licenseMessage,$this->responseObj,$templateDir."/style.css") || (in_array( $_SERVER['REMOTE_ADDR'], $whitelist)) ) {
      add_action( 'admin_menu', [$this,'ActiveAdminMenu'],99999);
      add_action( 'admin_post_Avas_el_deactivate_license', [ $this, 'action_deactivate_license' ] );
      add_action( 'after_setup_theme', 'tx_theme_setup' );
      add_action( 'header-style', 'tx_header_style' );
      add_action('admin_head', 'tx_welcome_js');
      require_once TX_THEME_DIR . 'inc/tgm.php';
      require_once TX_THEME_DIR . 'inc/custom-sidebars.php';
      require_once TX_THEME_DIR . 'inc/import.php';
      require_once TX_THEME_DIR . 'import/import-files.php';
      require_once TX_THEME_DIR . 'import/import-slider.php';
    }else{
      if(!empty($licenseKey) && !empty($this->licenseMessage)){
        $this->showMessage=true;
      }
      update_option("Avas_lic_Key","") || add_option("Avas_lic_Key","");
      add_action( 'admin_post_Avas_el_activate_license', [ $this, 'action_activate_license' ] );
      add_action( 'admin_menu', [$this,'InactiveMenu']);
      add_action( 'admin_head', 'tx_active_modal' );
    }
        }

  function ActiveAdminMenu(){
     
  add_menu_page (  "Avas", "Avas", "activate_plugins", $this->slug, [$this,"Activated"], null, 60);
  
  }
  function InactiveMenu() {
    add_menu_page( "Avas", "Avas", 'activate_plugins', $this->slug,  [$this,"LicenseForm"], null, 60 );
    
  }
  function action_activate_license(){
    check_admin_referer( 'el-license' );
    $licenseKey=!empty($_POST['el_license_key'])?$_POST['el_license_key']:"";
    $licenseEmail=!empty($_POST['el_license_email'])?$_POST['el_license_email']:"";
    update_option("Avas_lic_Key",$licenseKey) || add_option("Avas_lic_Key",$licenseKey);
    update_option("Avas_lic_email",$licenseEmail) || add_option("Avas_lic_email",$licenseEmail);
    update_option('_site_transient_update_themes','');
    wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug));
  }
  function action_deactivate_license() {
    check_admin_referer( 'el-license' );
    $message="";
    if(TX_Update_Base::RemoveLicenseKey(__FILE__,$message)){
      update_option("Avas_lic_Key","") || add_option("Avas_lic_Key","");
      update_option('_site_transient_update_themes','');
    }
      wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug));
    }
  function Activated(){
    $whitelist = array( '127.0.0.1', '::1' );
    ?>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <input type="hidden" name="action" value="Avas_el_deactivate_license"/>
            <div class="el-license-container">
                <h3 class="el-license-title"><?php esc_html_e('Your License Info', 'avas');?> </h3>
                <hr>
                <ul class="el-license-info">
                <li>
                    <div>
                        <span class="el-license-info-title"><?php esc_html_e('Status', 'avas');?></span>

                        <?php if ( $this->responseObj->is_valid ) : ?>
                            <span class="el-license-valid"><?php esc_html_e('Valid', 'avas');?></span>
                        <?php else : ?>
                            <span class="el-license-valid"><?php esc_html_e('Invalid', 'avas');?></span>
                        <?php endif; ?>
                    </div>
                </li>

                <li>
                    <div>
                        <span class="el-license-info-title"><?php esc_html_e('License Type', 'avas');?></span>
                        <?php echo esc_html($this->responseObj->license_title); ?>
                    </div>
                </li>
                <?php if( !in_array( $_SERVER['REMOTE_ADDR'], $whitelist) ) : ?>
                <li>
                    <div>
                        <span class="el-license-info-title"><?php esc_html_e('Your License Key', 'avas');?></span>
                        <span class="el-license-key"><?php echo esc_attr( substr($this->responseObj->license_key,0,9)."XXXXXXXX-XXXXXXXX".substr($this->responseObj->license_key,-9) ); ?></span>
                    </div>
                </li>
                <?php endif; ?>
                </ul>
            <?php if( !in_array( $_SERVER['REMOTE_ADDR'], $whitelist) ) : ?>
                <div class="el-license-active-btn">
                    <?php wp_nonce_field( 'el-license' ); ?>
                    <?php submit_button('Deactivate'); ?>
                </div>
            <?php endif; ?>
            </div>
        </form>
    <?php
  }

  
function LicenseForm() {
    ?>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <input type="hidden" name="action" value="Avas_el_activate_license"/>
            <div class="el-license-container">
                <h3 class="el-license-title"><?php esc_html_e('Theme Registration', 'avas');?></h3>
                <h3><?php esc_html_e('Please register the theme to unlock all features and get regular updates.', 'avas'); ?></h3>
                <hr>
        <?php
          if(!empty($this->showMessage) && !empty($this->licenseMessage)){
            ?>
            <div class="notice notice-error is-dismissible">
              <p><?php echo esc_html($this->licenseMessage); ?></p>
            </div>
        <?php
          }
        ?>
            <div class="el-license-field">
              <label for="el_license_key"><?php esc_html_e('Purchase Code', 'avas');?></label>
              <input type="text" class="regular-text code" name="el_license_key" size="50" placeholder="xxxxxxxx-xxxxxxxx-xxxxxxxx-xxxxxxxx" required="required">
              <div><small><?php echo wp_kses('Click <a href="https://youtu.be/lvgylymAPgc" target="_blank">here</a> to watch how to obtain the purchase code.', 'avas');?></small></div>
            </div>
                <div class="el-license-field">
                    <label for="el_license_key"><?php esc_html_e('Email Address', 'avas');?></label>
                    <input type="text" class="regular-text code" name="el_license_email" size="50" placeholder="<?php esc_html_e('Enter your Envato account email address', 'avas'); ?>" required="required">
                    <div><small><?php echo wp_kses('For any issue please go to our <a href="https://tinyurl.com/theme-x-support-desk" target="_blank">support portal</a> and create a ticket.', 'avas');?></small></div>
                </div>
                <div class="el-license-active-btn">
          <?php wp_nonce_field( 'el-license' ); ?>
          <?php submit_button('Activate'); ?>
                </div>
            </div>
        </form>
    <?php
  }
}

new AvasUpdates();

if ( ! function_exists( 'tx_is_license_active' ) ) {
    function tx_is_license_active() {
        $license_key = get_option("Avas_lic_Key");
        $remote_ip = $_SERVER['REMOTE_ADDR'] ?? '';

        $is_local = in_array($remote_ip, ['127.0.0.1', '::1', 'localhost'], true);
        $is_active = $is_local || !empty($license_key);

        return apply_filters('tx_is_license_active', $is_active, $license_key, $_SERVER['HTTP_HOST'] ?? '');
    }
}


/* ---------------------------------------------------------
    EOF
------------------------------------------------------------ */