<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/
*
*  Top Header
*/
global $tx;

if ($tx['top_head']) : ?>
    <div id="top_head" class="top-header align-items-center d-flex">
        <div class="container<?php echo tx_header_layout(); ?> d-flex justify-content-center justify-content-md-between" >
        			<div class="top-header-left-area d-flex align-items-center">
                        <?php if($tx['tx-date']) { ?>
                            <div class="tx-date d-flex align-items-center">
                                <i class="bi bi-clock"></i>
                                 <?php echo date_i18n( get_option('date_format'), current_time('timestamp') ); ?>
                            </div><!-- /.tx-date -->
                        <?php } // Date
                    	 
                           	$welcome_msg = $tx['welcome_msg'];
                            if( $tx['wm_switch'] ) {
                                echo '<div class="welcome_msg d-flex align-items-center">'.$welcome_msg.'</div>';
                            } // welcome message

                            if($tx['tx-phone']) : ?>
                                <div class="phone-number d-flex align-items-center">
                                    <a href="<?php echo esc_url('tel:'.$tx['phone-number']); ?>"><i class="bi bi-telephone-fill"></i><?php echo esc_html($tx['phone-number']); ?></a>
                                </div>
                        <?php endif; // Phone Number

                            if($tx['tx-email']) : ?>
                                <div class="email-address d-flex align-items-center">
                                    <a href="<?php echo esc_url('mailto:'.$tx['email-address']); ?>"><i class="bi bi-envelope-fill"></i><?php echo esc_html($tx['email-address']); ?></a>
                                </div>
                        <?php endif; // Email Address
                            if($tx['news_ticker']) {
                                do_action('tx_news_ticker');
                            } // News Ticker
                        ?>
                           
                	</div><!-- /.top-header-left -->
                        <div class="top-header-right-area d-flex align-items-center">
                            <?php 
                                
                                if ($tx['social_buton_top']) : ?>
                                        <div class="social_media"> 
                                            <?php if (function_exists('tx_social_media')) :
                                                      echo tx_social_media(); 
                                                  endif;
                                            ?>
                                        </div>
                                <?php endif; //social buttons                              

                                if($tx['top_menu'] ) :
                                    if ( has_nav_menu( 'top_menu' ) ) { ?>
                                    <div class="d-none d-sm-none d-md-block"> 
                                    <?php wp_nav_menu( array(
                                        'theme_location' => 'top_menu',
                                        'menu_class'     => 'top_menu',
                                        'depth'          => 2,
                                        ) );
                                    ?>
                                    </div>
                                   
                            <div id="responsive-menu-top" class="d-md-none d-lg-none order-last order-lg-0">
                                <div class="navbar-header">
                                    <!-- .navbar-toggle is used as the toggle for collapsed navbar content -->
                                    <button type="button" class="navbar-toggle tx-top-res-menu" data-toggle="collapse" data-target=".top-nav-collapse">
                                      <span class="x"><i class="bi bi-list"></i></span>
                                    </button>
                                </div><!-- /.navbar-header -->
                                <div class="collapse top-nav-collapse">
                                    <?php
                                      if ( has_nav_menu( 'top_menu' ) ) {
                                          wp_nav_menu( array(
                                              'theme_location'      => 'top_menu',
                                              'container'           => false,
                                              'menu_class'          => 'nav navbar-nav tx-res-menu',
                                              'fallback_cb'         => '',
                                              'depth'               => 2,
                                              )
                                          );
                                      }
                                      ?>
                                </div><!-- /.navbar-collapse -->
                            </div><!--/#responsive-menu-->
                             <?php } 
                                endif; // top menu
                        
                            if ($tx['login_reg']) :
                                do_action('tx_login_register');
                            endif; // login

                            ?>
                        </div><!-- top-header-right-area -->
        </div> <!-- /.container -->
    </div><!-- /.top-header -->
<?php endif;