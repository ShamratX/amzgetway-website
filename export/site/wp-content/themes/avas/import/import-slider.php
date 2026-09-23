<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/
* ======================================================================
*   Import Slider
* ======================================================================
*/
// demo after import setup 
function tx_after_import_setup( $selected_import ) {

      if ( 'Agency' === $selected_import['import_file_name'] ) {

        //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Agency/avas-agency.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider
        
        //Set Menu
        do_action( 'tx_demo_menu_setup' );

        //Set Front page
        $page = tx_get_page_by_title( 'Home Agency');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

      }elseif ( 'AirConditioningServices' === $selected_import['import_file_name'] ) {

        //Set Menu
        do_action( 'tx_demo_menu_setup' );

        //Set Front page
        $page = tx_get_page_by_title( 'Home ACS');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

      }elseif ( 'AI Technology' === $selected_import['import_file_name'] ) {
        
        // import theme builder
        $tb_url = TX_IMPORT_URL.'AITechnology/theme-builder.json';
        tx_theme_builder_import($tb_url);

        //Set Menu
        do_action( 'tx_demo_menu_setup' );
        //Set Front page
        $page = tx_get_page_by_title( 'Home AI Technology');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

      }elseif ( 'App' === $selected_import['import_file_name'] ) {
        
         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'App/avas-app.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

        //Set Front page
        $page = tx_get_page_by_title( 'Home App');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

        //Set Menu
        do_action( 'tx_demo_menu_setup' );

      }elseif ( 'Architecture' === $selected_import['import_file_name'] ) {
        
         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Architecture/avas-architecture.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

        //Set Menu
        do_action( 'tx_demo_menu_setup' );

        //Set Front page
        $page = tx_get_page_by_title( 'Home Architecture');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Artificial Intelligence' === $selected_import['import_file_name'] ) {

        // import theme builder
        $tb_url = TX_IMPORT_URL.'ArtificialIntelligence/theme-builder.json';
        tx_theme_builder_import($tb_url); 

        //Set Menu
        do_action( 'tx_demo_menu_setup' );

        //Set Front page
        $page = tx_get_page_by_title( 'Home Artificial Intelligence');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Bakery' === $selected_import['import_file_name'] ) {
        
         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Bakery/avas-bakery.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

        //Set Menu
        do_action( 'tx_demo_menu_setup' );

        //Set Front page
        $page = tx_get_page_by_title( 'Home Bakery');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

        // WooCommerce Settings
        do_action( 'tx_woocommerce_settings' );

        // Update WooCommerce Lookup Table
        do_action( 'tx_update_woocommerce_lookup_table' );

        // delete WooCommerce transient
        delete_transient('wc_products_onsale');

    }elseif ( 'Barber Shop' === $selected_import['import_file_name'] ) {
        
         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'BarberShop/avas-barber-shop.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

         //Set Menu
        do_action( 'tx_demo_menu_setup' );

        //Set Front page
        $page = tx_get_page_by_title( 'Home Barber Shop');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Beauty Salon' === $selected_import['import_file_name'] ) {
        
        // import theme builder
        $tb_url = TX_IMPORT_URL.'BeautySalon/theme-builder.json';
        tx_theme_builder_import($tb_url);
        
        //Set Menu
        do_action( 'tx_demo_menu_setup' );

        //Set Front page
        $page = tx_get_page_by_title( 'Home Beauty Salon');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Bicycle Repair' === $selected_import['import_file_name'] ) {

        //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Bicycle Repair');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }
        
    }elseif ( 'Blog' === $selected_import['import_file_name'] ) {
        
         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Blog/avas-blog.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

        //Set Menu
        do_action( 'tx_demo_menu_setup' );

        //Set Front page
        $page = tx_get_page_by_title( 'Home Blog');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Business' === $selected_import['import_file_name'] ) {
        
         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Business/avas-business.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

         //Set Menu
        do_action( 'tx_demo_menu_setup' );
        //Set Front page
        $page = tx_get_page_by_title( 'Home Business');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Business Advisor' === $selected_import['import_file_name'] ) {
        
         //Set Menu
        do_action( 'tx_demo_menu_setup' );
        //Set Front page
        $page = tx_get_page_by_title( 'Home Business Advisor');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Business Consultant' === $selected_import['import_file_name'] ) {
        
        // import theme builder
        $tb_url = TX_IMPORT_URL.'BusinessConsultant/theme-builder.json';
        tx_theme_builder_import($tb_url);

        //Set Menu
        do_action( 'tx_demo_menu_setup' );
        //Set Front page
        $page = tx_get_page_by_title( 'Home Business Consultant');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Call Center' === $selected_import['import_file_name'] ) {
        
        // import theme builder
        $tb_url = TX_IMPORT_URL.'CallCenter/theme-builder.json';
        tx_theme_builder_import($tb_url);

        //Set Menu
        do_action( 'tx_demo_menu_setup' );
        //Set Front page
        $page = tx_get_page_by_title( 'Home Call Center');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Car Wash' === $selected_import['import_file_name'] ) {
        
        // import theme builder
        $tb_url = TX_IMPORT_URL.'CarWash/theme-builder.json';
        tx_theme_builder_import($tb_url);

        //Set Menu
        do_action( 'tx_demo_menu_setup' );
        //Set Front page
        $page = tx_get_page_by_title( 'Home Car Wash');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Charity' === $selected_import['import_file_name'] ) {
        
         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {
          $slider_urls = [TX_IMPORT_URL.'Charity/avas-charity.zip'];
          tx_rev_slider_import($slider_urls);
        } //RevSliderSlider

        //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Charity');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Charity Two' === $selected_import['import_file_name'] ) {

        // Activate Elementor Default Kit
        tx_set_elementor_active_kit();
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
        
        //Set Front page
        $page = tx_get_page_by_title('Home');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

        // import theme builder
        $tb_url = TX_IMPORT_URL.'CharityTwo/theme-builder.json';
        tx_theme_builder_import($tb_url);

    }elseif ( 'Chef' === $selected_import['import_file_name'] ) {
        
         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {
          $slider_urls = [TX_IMPORT_URL.'Chef/avas-chef.zip'];
          tx_rev_slider_import($slider_urls);
        } //RevSliderSlider

        //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Chef');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Cleaning Services' === $selected_import['import_file_name'] ) {
      
         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {
          $slider_urls = [TX_IMPORT_URL.'CleaningServices/avas-cleaning-services.zip'];
          tx_rev_slider_import($slider_urls);
        } //RevSliderSlider

        //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Cleaning Services');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Construction' === $selected_import['import_file_name'] ) {

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {
          $slider_urls = [TX_IMPORT_URL.'Construction/avas-construction.zip'];
          tx_rev_slider_import($slider_urls);
        } //RevSliderSlider

        //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Construction');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Construction Two' === $selected_import['import_file_name'] ) {

        // Activate Elementor Default Kit
        tx_set_elementor_active_kit();
        
        //Set Menu
        do_action( 'tx_demo_menu_setup' );
        
        //Set Front page
        $page = tx_get_page_by_title('Home');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

        // import theme builder
        $tb_url = TX_IMPORT_URL.'ConstructionTwo/theme-builder.json';
        tx_theme_builder_import($tb_url);

    }elseif ( 'Consultant' === $selected_import['import_file_name'] ) {
        
         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Consultant/avas-consultant.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

        //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Consultant');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Coronavirus' === $selected_import['import_file_name'] ) {

        //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Coronavirus');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }
        
    }elseif ( 'Corporate' === $selected_import['import_file_name'] ) {

        //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Corporate');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }
        
         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Corporate/avas-corporate.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Corporate Business' === $selected_import['import_file_name'] ) {
        
        // import theme builder
        $tb_url = TX_IMPORT_URL.'CorporateBusiness/theme-builder.json';
        tx_theme_builder_import($tb_url);

        //Set Menu
        do_action( 'tx_demo_menu_setup' );
        //Set Front page
        $page = tx_get_page_by_title( 'Home Corporate Business');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Creative' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Creative');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Creative/avas-creative.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Creative Agency' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Creative Agency');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

        // WooCommerce Settings
        // do_action( 'tx_woocommerce_settings' );

        // // Update WooCommerce Lookup Table
        // do_action( 'tx_update_woocommerce_lookup_table' );

        // // delete WooCommerce transient
        // delete_transient('wc_products_onsale');

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'CreativeAgency/avas-creative-agency.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Crypto News' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Crypto News');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Cyber Security Services' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Cyber Security Services');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Dental Clinic' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Dental Clinic');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'DentalClinic/avas-dental-clinic.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Design Agency' === $selected_import['import_file_name'] ) {

        // Activate Elementor Default Kit
        tx_set_elementor_active_kit();
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
        
        //Set Front page
        $page = tx_get_page_by_title('Home');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

        // import theme builder
        $tb_url = TX_IMPORT_URL.'DigitalAgencyTwo/theme-builder.json';
        tx_theme_builder_import($tb_url);
        
    }elseif ( 'Designer' === $selected_import['import_file_name'] ) {

        //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Designer');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }
        
    }elseif ( 'Digital Agency' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Digital Agency');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'DigitalAgency/avas-digital-agency.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Digital Agency Two' === $selected_import['import_file_name'] ) {

        // Activate Elementor Default Kit
        tx_set_elementor_active_kit();
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
        
        //Set Front page
        $page = tx_get_page_by_title('Home');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

        // import theme builder
        $tb_url = TX_IMPORT_URL.'DigitalAgencyTwo/theme-builder.json';
        tx_theme_builder_import($tb_url);

    }elseif ( 'Digital Marketing Agency' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );

         //Set Front page
        $page = tx_get_page_by_title( 'Home DMA');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

        // import theme builder
        $tb_url = TX_IMPORT_URL.'DigitalMarketingAgency/theme-builder.json';
        tx_theme_builder_import($tb_url);

    }elseif ( 'Driving School' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Driving School');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'DrivingSchool/avas-driving-school.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'eBook' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home eBook');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

        // WooCommerce Settings
        // do_action( 'tx_woocommerce_settings' );

        // // Update WooCommerce Lookup Table
        // do_action( 'tx_update_woocommerce_lookup_table' );

        // // delete WooCommerce transient
        // delete_transient('wc_products_onsale');

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'eBook/avas-ebook.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Education' === $selected_import['import_file_name'] ) {
        
        //Set Menu
        do_action( 'tx_demo_menu_setup' );
        //Set Front page
        $page = tx_get_page_by_title( 'Home Education');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }
        //LearnPress
        do_action('tx_learnpress_settings');

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Education/avas-education.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Education Two' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Education Two');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }
        
        //LearnPress
        do_action('tx_learnpress_settings');

        //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'EducationTwo/avas-education-two.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Events' === $selected_import['import_file_name'] ) {
        
        //Set Menu
        do_action( 'tx_demo_menu_setup' );
        //Set Front page
        $page = tx_get_page_by_title( 'Home Events');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

        //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Events/avas-events.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider    

    }elseif ( 'Finance' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Finance');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Finance/avas-finance.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Fitness' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Fitness');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Fitness/avas-fitness.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Forum' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Forum');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Gym' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Gym');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Gym/avas-gym.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Handyman' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Handyman');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Handyman/avas-handyman.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Hosting' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Hosting');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Hosting/avas-hosting.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'ICO Cryptocurrency' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home ICO Cryptocurrency');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Immigration Visa Consulting' === $selected_import['import_file_name'] ) {
        
        // import theme builder
        $tb_url = TX_IMPORT_URL.'ImmigrationVisaConsulting/theme-builder.json';
        tx_theme_builder_import($tb_url);

        //Set Menu
        do_action( 'tx_demo_menu_setup' );

        //Set Front page
        $page = tx_get_page_by_title('Home');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }


    }elseif ( 'Insurance' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Insurance');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Insurance/avas-insurance.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Insurance Two' === $selected_import['import_file_name'] ) {
        
        // import theme builder
        $tb_url = TX_IMPORT_URL.'InsuranceTwo/theme-builder.json';
        tx_theme_builder_import($tb_url);

        // Activate Elementor Default Kit
        tx_set_elementor_active_kit();

        //Set Menu
        do_action( 'tx_demo_menu_setup' );

        //Set Front page
        $page = tx_get_page_by_title('Home');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Interior' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Interior');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Interior/avas-interior.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'ISP' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home ISP');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

        // import theme builder
        $tb_url = TX_IMPORT_URL.'ISP/theme-builder.json';
        tx_theme_builder_import($tb_url);

    }elseif ( 'IT Solutions' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
        
        //Set Front page
        $page = tx_get_page_by_title( 'Home IT Solutions');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

        // import theme builder
        $tb_url = TX_IMPORT_URL.'ITSolutions/theme-builder.json';
        tx_theme_builder_import($tb_url);

    }elseif ( 'Kindergarten' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Kindergarten');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Kindergarten/avas-kindergarten.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Lawyer' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Lawyer');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Lawyer/avas-lawyer.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Magazine' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Magazine');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Mechanic' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Mechanic');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Mechanic/avas-mechanic.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Medical' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Medical');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Medical/avas-medical.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Movers' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Movers');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'News' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home News');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'News/avas-news.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'News Dark' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home News Dark');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Nice & Clean' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Nice and Clean');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'NiceClean/avas-nice-and-clean-header.zip', TX_IMPORT_URL.'NiceClean/avas-nice-and-clean-services.zip', TX_IMPORT_URL.'NiceClean/avas-nice-and-clean-projects.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Portfolio' === $selected_import['import_file_name'] ) {

       // import theme builder
        $tb_url = TX_IMPORT_URL.'Portfolio/theme-builder.json';
        tx_theme_builder_import($tb_url); 
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Portfolio');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Pest Control' === $selected_import['import_file_name'] ) {

       // import theme builder
        $tb_url = TX_IMPORT_URL.'PestControl/theme-builder.json';
        tx_theme_builder_import($tb_url); 
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Pest Control');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Pet Care' === $selected_import['import_file_name'] ) {

       // import theme builder
        $tb_url = TX_IMPORT_URL.'Petcare/theme-builder.json';
        tx_theme_builder_import($tb_url); 
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Pet Care');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Photographer' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Photographer');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Photographer/avas-photographer.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Pinterest' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Pinterest');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Printing Services' === $selected_import['import_file_name'] ) {
        
        // import theme builder
        $tb_url = TX_IMPORT_URL.'PrintingServices/theme-builder.json';
        tx_theme_builder_import($tb_url);

        // WooCommerce Settings
        do_action( 'tx_woocommerce_settings' );

        // Update WooCommerce Lookup Table
        do_action( 'tx_update_woocommerce_lookup_table' );

        //Set Menu
        do_action( 'tx_demo_menu_setup' );
        //Set Front page
        $page = tx_get_page_by_title( 'Home Printing Services');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Product Landing Page' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Product Landing Page');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'ProductLandingPage/avas-product-landing-page.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Real Estate' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Real Estate');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'RealEstate/avas-real-estate.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Restaurant' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Restaurant');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Restaurant/avas-restaurant.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Resume' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Resume');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'RTL' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home RTL');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'RTL/avas-rtl.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'SaaS' === $selected_import['import_file_name'] ) {
        
        // import theme builder
        $tb_url = TX_IMPORT_URL.'Saas/theme-builder.json';
        tx_theme_builder_import($tb_url);

        //Set Menu
        do_action( 'tx_demo_menu_setup' );
        //Set Front page
        $page = tx_get_page_by_title( 'Home SaaS');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'SEO' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home SEO');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'SEO/avas-seo.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Shop' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Shop');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

        // WooCommerce Settings
        do_action( 'tx_woocommerce_settings' );

        // Update WooCommerce Lookup Table
        do_action( 'tx_update_woocommerce_lookup_table' );

        // delete WooCommerce transient
        delete_transient('wc_products_onsale');

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Shop/avas-shop.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Spa' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Spa');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Spa/avas-spa.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Startup' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Startup');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Startup/avas-startup.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Technology' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Technology');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Technology/avas-technology.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Transportation & Logistics' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Transportation and Logistics');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

    }elseif ( 'Travel' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Travel');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Travel/avas-travel.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Web Solutions' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Web Solutions');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'WebSolutions/avas-web-solutions.zip', TX_IMPORT_URL.'WebSolutions/avas-web-solutions-projects.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Website Builder' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Website Builder');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'WebsiteBuilder/avas-website-builder.zip', TX_IMPORT_URL.'WebsiteBuilder/avas-website-builder-discover.zip', TX_IMPORT_URL.'WebsiteBuilder/avas-website-builder-customizable.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Wedding' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Wedding');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Wedding/avas-wedding.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }elseif ( 'Yoga' === $selected_import['import_file_name'] ) {
        
       //Set Menu
        do_action( 'tx_demo_menu_setup' );
         //Set Front page
        $page = tx_get_page_by_title( 'Home Yoga');
        if ( isset( $page->ID ) ) {
          update_option( 'page_on_front', $page->ID );
          update_option( 'show_on_front', 'page' );
        }

         //Import Revolution Slider
        if ( class_exists( 'RevSliderSlider' ) ) {

          $slider_urls = [TX_IMPORT_URL.'Yoga/avas-yoga.zip'];
          tx_rev_slider_import($slider_urls);

        } //RevSliderSlider

    }


    
}
add_action( 'ocdi/after_import', 'tx_after_import_setup' );

/* ---------------------------------------------------------
    EOF
------------------------------------------------------------ */