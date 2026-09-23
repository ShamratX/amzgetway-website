<?php
/**
* 
* @package tx
* @author theme-x
* @link https://theme-x.org/
* ======================================================================
*   Import content, widgets, theme options settings.
* ======================================================================
*/

// Demo Import files
function tx_import_files() {
  return [
    
    [
      'import_file_name'           => 'Agency',
      'categories'                 => [ 'Agency' ],
      'import_file_url'            => TX_IMPORT_URL.'Agency/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Agency/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Agency/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Agency/screenshot.png',
      'preview_url'                => TX_DEMO_URL.'agency',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),    
    ], // Agency

    [
      'import_file_name'           => 'AirConditioning Services',
      'categories'                 => [ 'Air Conditioning','Services' ],
      'import_file_url'            => TX_IMPORT_URL.'AirConditioningServices/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'AirConditioningServices/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'AirConditioningServices/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'AirConditioningServices/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'air-conditioning-services',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),    
    ], // Air Conditioning Services

    [
      'import_file_name'           => 'AI Technology',
      'categories'                 => [ 'AI', 'Technology','Services' ],
      'import_file_url'            => TX_IMPORT_URL.'AITechnology/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'AITechnology/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'AITechnology/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'AITechnology/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'ai-technology',
      'import_notice' => esc_html__( 'If any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),    
    ], // AI Technology 

    [
      'import_file_name'           => 'App',
      'categories'                 => [ 'App', 'Onepage', 'Landing Page' ],
      'import_file_url'            => TX_IMPORT_URL.'App/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'App/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'App/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'App/screenshot.png',
      'preview_url'                => TX_DEMO_URL.'app',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // App
    
    [
      'import_file_name'           => 'Architecture',
      'categories'                 => [ 'Architecture' ],
      'import_file_url'            => TX_IMPORT_URL.'Architecture/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Architecture/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Architecture/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Architecture/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'architecture',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Architecture

    [
      'import_file_name'           => 'Artificial Intelligence',
      'categories'                 => [ 'artificial intelligence','AI', 'Chat', 'GPT' ],
      'import_file_url'            => TX_IMPORT_URL.'ArtificialIntelligence/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'ArtificialIntelligence/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'ArtificialIntelligence/theme-options.json',
          'option_name' => 'tx',
        ],

      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'ArtificialIntelligence/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'artificial-intelligence',
      'import_notice' => esc_html__( 'If any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),

      'import_json'   => array(
        array(
          'file_url'    => TX_IMPORT_URL.'ArtificialIntelligence/tb.json',
          'option_name' => 'GP_option_name',
        ),
      ),



    ], // Artificial Intelligence

    [
      'import_file_name'           => 'Bakery',
      'categories'                 => [ 'Bakery', 'Food', 'WooCommerce' ],
      'import_file_url'            => TX_IMPORT_URL.'Bakery/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Bakery/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Bakery/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Bakery/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'bakery',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Bakery

    [
      'import_file_name'           => 'Barber Shop',
      'categories'                 => [ 'Barber','Shop','Landing Page', 'Onepage' ],
      'import_file_url'            => TX_IMPORT_URL.'BarberShop/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'BarberShop/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'BarberShop/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'BarberShop/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'barber-shop',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Barber Shop

    [
      'import_file_name'           => 'Beauty Salon',
      'categories'                 => [ 'Beauty','Salon' ],
      'import_file_url'            => TX_IMPORT_URL.'BeautySalon/content.xml',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'BeautySalon/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'BeautySalon/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'beauty-salon',
      'import_notice' => esc_html__( 'If any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),
    ], // Beauty Salon

    [
      'import_file_name'           => 'Bicycle Repair',
      'categories'                 => [ 'Bicycle','Repair','Landing Page', 'Onepage', 'Mechanic' ],
      'import_file_url'            => TX_IMPORT_URL.'BicycleRepair/content.xml',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'BicycleRepair/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'BicycleRepair/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'bicycle-repair',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Bicycle Repair 

     [
      'import_file_name'           => 'Blog',
      'categories'                 => [ 'Blog', 'News' ],
      'import_file_url'            => TX_IMPORT_URL.'Blog/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Blog/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Blog/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Blog/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'blog',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Blog

     [
      'import_file_name'           => 'Business',
      'categories'                 => [ 'Business' ],
      'import_file_url'            => TX_IMPORT_URL.'Business/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Business/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Business/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Business/screenshot.png',
      'preview_url'                => TX_DEMO_URL.'business',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Business

    [
      'import_file_name'           => 'Business Advisor',
      'categories'                 => [ 'Business', 'Advisor', 'Consultant', 'Corporate' ],
      'import_file_url'            => TX_IMPORT_URL.'BusinessAdvisor/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'BusinessAdvisor/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'BusinessAdvisor/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'BusinessAdvisor/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'business-advisor',
      'import_notice' => esc_html__( 'If any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Business Advisor

    [
      'import_file_name'           => 'Business Consultant',
      'categories'                 => [ 'Business', 'Consultant' ],
      'import_file_url'            => TX_IMPORT_URL.'BusinessConsultant/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'BusinessConsultant/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'BusinessConsultant/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'BusinessConsultant/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'business-consultant',
      'import_notice' => esc_html__( 'If any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Business Consultant

    [
      'import_file_name'           => 'Call Center',
      'categories'                 => [ 'Call Center', 'Services' ],
      'import_file_url'            => TX_IMPORT_URL.'CallCenter/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'CallCenter/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'CallCenter/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'CallCenter/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'call-center',
      'import_notice' => esc_html__( 'If any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Call Center

    [
      'import_file_name'           => 'Car Wash',
      'categories'                 => [ 'Car', 'Services', 'Clean', 'Wash' ],
      'import_file_url'            => TX_IMPORT_URL.'CarWash/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'CarWash/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'CarWash/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'CarWash/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'car-wash',
      'import_notice' => esc_html__( 'If any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Car Wash

    [
      'import_file_name'           => 'Charity',
      'categories'                 => [ 'Charity' ],
      'import_file_url'            => TX_IMPORT_URL.'Charity/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Charity/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Charity/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Charity/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'charity',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Charity

    [
      'import_file_name'           => 'Charity Two',
      'categories'                 => [ 'Charity', 'NGO', 'Organization'],
      'import_file_url'            => TX_IMPORT_URL.'CharityTwo/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'CharityTwo/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'CharityTwo/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'CharityTwo/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'charity-two',
      'import_notice' => esc_html__( 'If any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Charity Two

    [
      'import_file_name'           => 'Chef',
      'categories'                 => [ 'Chef' ],
      'import_file_url'            => TX_IMPORT_URL.'Chef/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Chef/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Chef/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Chef/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'chef',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Chef

    [
      'import_file_name'           => 'Cleaning Services',
      'categories'                 => [ 'Cleaning', 'Services' ],
      'import_file_url'            => TX_IMPORT_URL.'CleaningServices/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'CleaningServices/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'CleaningServices/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'CleaningServices/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'cleaning-services',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Cleaning Services

    [
      'import_file_name'           => 'Construction',
      'categories'                 => [ 'Construction', 'Business', 'Company' ],
      'import_file_url'            => TX_IMPORT_URL.'Construction/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Construction/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Construction/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Construction/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'construction',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Construction

    [
      'import_file_name'           => 'Construction Two',
      'categories'                 => [ 'Construction', 'Business', 'Company' ],
      'import_file_url'            => TX_IMPORT_URL.'ConstructionTwo/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'ConstructionTwo/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'ConstructionTwo/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'ConstructionTwo/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'construction-two',
      'import_notice' => esc_html__( 'If any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Construction Two

    [
      'import_file_name'           => 'Consultant',
      'categories'                 => [ 'Consultant', 'Services', 'Adviser', 'Business', 'Company' ],
      'import_file_url'            => TX_IMPORT_URL.'Consultant/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Consultant/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Consultant/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Consultant/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'consultant',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Consultant

    [
      'import_file_name'           => 'Coronavirus',
      'categories'                 => [ 'Coronavirus', 'Onepage', 'Landing Page' ],
      'import_file_url'            => TX_IMPORT_URL.'Coronavirus/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Coronavirus/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Coronavirus/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Coronavirus/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'coronavirus',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Coronavirus

    [
      'import_file_name'           => 'Corporate',
      'categories'                 => [ 'Corporate', 'Services','Business', 'Company' ],
      'import_file_url'            => TX_IMPORT_URL.'Corporate/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Corporate/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Corporate/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Corporate/screenshot.png',
      'preview_url'                => TX_DEMO_URL.'corporate',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Corporate

    [
      'import_file_name'           => 'Corporate Business',
      'categories'                 => [ 'Corporate', 'Services','Business', 'Company' ],
      'import_file_url'            => TX_IMPORT_URL.'CorporateBusiness/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'CorporateBusiness/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'CorporateBusiness/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'CorporateBusiness/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'corporate-business',
      'import_notice' => esc_html__( 'If any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),   
    ], // Corporate Business

    [
      'import_file_name'           => 'Creative',
      'categories'                 => [ 'Agency', 'Creative' ],
      'import_file_url'            => TX_IMPORT_URL.'Creative/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Creative/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Creative/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Creative/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'creative',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Creative

    [
      'import_file_name'           => 'Creative Agency',
      'categories'                 => [ 'Agency', 'Creative', 'WooCommerce' ],
      'import_file_url'            => TX_IMPORT_URL.'CreativeAgency/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'CreativeAgency/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'CreativeAgency/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'CreativeAgency/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'creative-agency',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Creative Agency

    [
      'import_file_name'           => 'Crypto News',
      'categories'                 => [ 'Cryptocurrency', 'News' ],
      'import_file_url'            => TX_IMPORT_URL.'CryptoNews/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'CryptoNews/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'CryptoNews/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'CryptoNews/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'crypto-news',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Crypto News

    [
      'import_file_name'           => 'Cyber Security Services',
      'categories'                 => [ 'Cyber', 'Security', 'Services' ],
      'import_file_url'            => TX_IMPORT_URL.'CyberSecurityServices/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'CyberSecurityServices/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'CyberSecurityServices/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'CyberSecurityServices/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'cyber-security-services',
      'import_notice' => esc_html__( 'If import process get stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Cyber Security Services

    [
      'import_file_name'           => 'Dental Clinic',
      'categories'                 => [ 'Dental', 'Clinic' ],
      'import_file_url'            => TX_IMPORT_URL.'DentalClinic/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'DentalClinic/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'DentalClinic/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'DentalClinic/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'dental-clinic',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Dental Clinic
    [
      'import_file_name'           => 'Design Agency',
      'categories'                 => [ 'Design', 'Agency', 'Services' ],
      'import_file_url'            => TX_IMPORT_URL.'DesignAgency/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'DesignAgency/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'DesignAgency/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'DesignAgency/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'design-agency',
      'import_notice' => esc_html__( 'If import process get stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),    
    ], // Design Agency
    [
      'import_file_name'           => 'Designer',
      'categories'                 => [ 'Designer', 'freelancer','one page' ],
      'import_file_url'            => TX_IMPORT_URL.'Designer/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Designer/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Designer/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Designer/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'designer',
      'import_notice' => esc_html__( 'If import process get stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),    
    ], // Designer
    [
      'import_file_name'           => 'Digital Agency',
      'categories'                 => [ 'Agency', 'Digital', 'Services', 'Onepage' ],
      'import_file_url'            => TX_IMPORT_URL.'DigitalAgency/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'DigitalAgency/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'DigitalAgency/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'DigitalAgency/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'digital-agency',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Digital Agency

    [
      'import_file_name'           => 'Digital Agency Two',
      'categories'                 => [ 'Agency', 'Digital', 'Services' ],
      'import_file_url'            => TX_IMPORT_URL.'DigitalAgencyTwo/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'DigitalAgencyTwo/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'DigitalAgencyTwo/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'DigitalAgencyTwo/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'digital-agency-two',
      'import_notice' => esc_html__( 'If import process get stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Digital Agency Two

    [
      'import_file_name'           => 'Digital Marketing Agency',
      'categories'                 => [ 'Agency', 'Digital', 'Marketing' ],
      'import_file_url'            => TX_IMPORT_URL.'DigitalMarketingAgency/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'DigitalMarketingAgency/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'DigitalMarketingAgency/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'DigitalMarketingAgency/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'digital-marketing-agency',
      'import_notice' => esc_html__( 'If any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Digital Marketing Agency
    [
      'import_file_name'           => 'Driving School',
      'categories'                 => [ 'Driving', 'School', 'Education' ],
      'import_file_url'            => TX_IMPORT_URL.'DrivingSchool/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'DrivingSchool/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'DrivingSchool/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'DrivingSchool/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'driving-school',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Driving School

    [
      'import_file_name'           => 'eBook',
      'categories'                 => [ 'eBook','Publisher', 'Shop', 'WooCommerce' ],
      'import_file_url'            => TX_IMPORT_URL.'eBook/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'eBook/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'eBook/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'eBook/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'ebook',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // eBook


    [
      'import_file_name'           => 'Education',
      'categories'                 => [ 'Education','School','Online Class' ],
      'import_file_url'            => TX_IMPORT_URL.'Education/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Education/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Education/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Education/screenshot.png',
      'preview_url'                => TX_DEMO_URL.'education',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Education

    [
      'import_file_name'           => 'Education Two',
      'categories'                 => [ 'Education','School','Online Class' ],
      'import_file_url'            => TX_IMPORT_URL.'EducationTwo/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'EducationTwo/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'EducationTwo/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'EducationTwo/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'education-two',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Education Two

    [
      'import_file_name'           => 'Events',
      'categories'                 => [ 'Events', 'Conference' ],
      'import_file_url'            => TX_IMPORT_URL.'Events/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Events/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Events/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Events/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'events',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Events

    [
      'import_file_name'           => 'Finance',
      'categories'                 => [ 'Agency', 'Corporation','Business','Company' ],
      'import_file_url'            => TX_IMPORT_URL.'Finance/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Finance/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Finance/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Finance/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'finance',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Finance

    [
      'import_file_name'           => 'Fitness',
      'categories'                 => [ 'Gym','Fitness' ],
      'import_file_url'            => TX_IMPORT_URL.'Fitness/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Fitness/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Fitness/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Fitness/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'fitness',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Fitness

    [
      'import_file_name'           => 'Forum',
      'categories'                 => [ 'Forum','bbPress' ],
      'import_file_url'            => TX_IMPORT_URL.'Forum/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Forum/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Forum/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Forum/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'forum',
      'import_notice' => esc_html__( 'If any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Forum

    [
      'import_file_name'           => 'Gym',
      'categories'                 => [ 'Gym','Fitness' ],
      'import_file_url'            => TX_IMPORT_URL.'Gym/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Gym/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Gym/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Gym/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'gym',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Gym

    [
      'import_file_name'           => 'Handyman',
      'categories'                 => [ 'Handyman'],
      'import_file_url'            => TX_IMPORT_URL.'Handyman/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Handyman/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Handyman/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Handyman/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'handyman',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Handyman

    [
      'import_file_name'           => 'Hosting',
      'categories'                 => [ 'Hosting','Server' ],
      'import_file_url'            => TX_IMPORT_URL.'Hosting/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Hosting/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Hosting/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Hosting/screenshot.png',
      'preview_url'                => TX_DEMO_URL.'hosting',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Hosting

    [
      'import_file_name'           => 'ICO Cryptocurrency',
      'categories'                 => [ 'Cryptocurrency' ],
      'import_file_url'            => TX_IMPORT_URL.'ICOCryptoCurrency/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'ICOCryptoCurrency/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'ICOCryptoCurrency/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'ICOCryptoCurrency/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'ico-cryptocurrency',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // ICO Cryptocurrency

    [
      'import_file_name'           => 'Immigration Visa Consulting',
      'categories'                 => [ 'Immigration', 'Visa', 'Consulting' ],
      'import_file_url'            => TX_IMPORT_URL.'ImmigrationVisaConsulting/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'ImmigrationVisaConsulting/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'ImmigrationVisaConsulting/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'ImmigrationVisaConsulting/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'immigration-visa-consulting',
      'import_notice' => esc_html__( 'If any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Immigration Visa Consulting

    [
      'import_file_name'           => 'Insurance',
      'categories'                 => [ 'Company','Business' ],
      'import_file_url'            => TX_IMPORT_URL.'Insurance/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Insurance/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Insurance/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Insurance/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'insurance',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Insurance

    [
      'import_file_name'           => 'Insurance Two',
      'categories'                 => [ 'Company','Business' ],
      'import_file_url'            => TX_IMPORT_URL.'InsuranceTwo/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'InsuranceTwo/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'InsuranceTwo/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'InsuranceTwo/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'insurance-two',
      'import_notice' => esc_html__( 'If any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),
    ], // Insurance Two

    [
      'import_file_name'           => 'Interior',
      'categories'                 => [ 'Interior','Architecture', 'Design' ],
      'import_file_url'            => TX_IMPORT_URL.'Interior/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Interior/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Interior/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Interior/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'interior',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Interior

    [
      'import_file_name'           => 'ISP',
      'categories'                 => [ 'ISP','Internet', 'Broadband', 'Services' ],
      'import_file_url'            => TX_IMPORT_URL.'ISP/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'ISP/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'ISP/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'ISP/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'isp',
      'import_notice' => esc_html__( 'If any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // ISP

    [
      'import_file_name'           => 'IT Solutions',
      'categories'                 => [ 'IT','Services', 'Solutions' ],
      'import_file_url'            => TX_IMPORT_URL.'ITSolutions/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'ITSolutions/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'ITSolutions/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'ITSolutions/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'it-solutions',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // IT Solutions

    [
      'import_file_name'           => 'Kindergarten',
      'categories'                 => [ 'Education', 'School','Online Class' ],
      'import_file_url'            => TX_IMPORT_URL.'Kindergarten/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Kindergarten/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Kindergarten/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Kindergarten/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'kindergarten',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Kindergarten

    [
      'import_file_name'           => 'Lawyer',
      'categories'                 => [ 'Lawyer','Business','Services' ],
      'import_file_url'            => TX_IMPORT_URL.'Lawyer/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Lawyer/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Lawyer/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Lawyer/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'lawyer',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Lawyer

    [
      'import_file_name'           => 'Magazine',
      'categories'                 => [ 'Magazine','News','Blog' ],
      'import_file_url'            => TX_IMPORT_URL.'Magazine/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Magazine/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Magazine/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Magazine/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'magazine',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Magazine

    [
      'import_file_name'           => 'Mechanic',
      'categories'                 => [ 'Mechanic','Services','Repair' ],
      'import_file_url'            => TX_IMPORT_URL.'Mechanic/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Mechanic/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Mechanic/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Mechanic/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'mechanic',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Mechanic

    [
      'import_file_name'           => 'Medical',
      'categories'                 => [ 'Medical','Hospital','Doctor','Health' ],
      'import_file_url'            => TX_IMPORT_URL.'Medical/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Medical/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Medical/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Medical/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'medical',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Medical

    [
      'import_file_name'           => 'Movers',
      'categories'                 => [ 'Landing Page', 'Onepage','Moving' ],
      'import_file_url'            => TX_IMPORT_URL.'Movers/content.xml',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Movers/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Movers/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'movers',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Movers

    // [
    //   'import_file_name'           => 'Music Band',
    //   'categories'                 => [ 'Landing Page', 'Onepage', 'Music','Band' ],
    //   'import_file_url'            => TX_IMPORT_URL.'MusicBand/content.xml',
    //   'import_widget_file_url'     => TX_IMPORT_URL.'MusicBand/widgets.json',
    //   'import_redux'               => [
    //     [
    //       'file_url'    => TX_IMPORT_URL.'MusicBand/theme-options.json',
    //       'option_name' => 'tx',
    //     ],
    //   ],
    //   'import_preview_image_url'   => TX_IMPORT_URL.'MusicBand/screenshot.jpg',
    //   'preview_url'                => TX_DEMO_URL.'music-band',
    //   'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    // ], // Music Band

    [
      'import_file_name'           => 'News',
      'categories'                 => [ 'News' ],
      'import_file_url'            => TX_IMPORT_URL.'News/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'News/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'News/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'News/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'news',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // News

    [
      'import_file_name'           => 'News Dark',
      'categories'                 => [ 'News' ],
      'import_file_url'            => TX_IMPORT_URL.'NewsDark/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'NewsDark/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'NewsDark/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'NewsDark/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'news-dark',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // News Dark

    [
      'import_file_name'           => 'Nice & Clean',
      'categories'                 => [ 'Clean' ],
      'import_file_url'            => TX_IMPORT_URL.'NiceClean/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'NiceClean/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'NiceClean/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'NiceClean/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'nice-clean',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Nice & Clean

    [
      'import_file_name'           => 'Pest Control',
      'categories'                 => [ 'Pest Control', 'Services' ],
      'import_file_url'            => TX_IMPORT_URL.'PestControl/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'PestControl/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'PestControl/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'PestControl/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'pest-control',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Pest Control

    [
      'import_file_name'           => 'Pet Care',
      'categories'                 => [ 'Pet Care' ],
      'import_file_url'            => TX_IMPORT_URL.'Petcare/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Petcare/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Petcare/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Petcare/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'pet-care',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Pet Care

    [
      'import_file_name'           => 'Photographer',
      'categories'                 => [ 'Photographer' ],
      'import_file_url'            => TX_IMPORT_URL.'Photographer/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Photographer/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Photographer/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Photographer/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'photographer',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Photographer

    [
      'import_file_name'           => 'Pinterest',
      'categories'                 => [ 'Pinterest Style' ],
      'import_file_url'            => TX_IMPORT_URL.'Pinterest/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Pinterest/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Pinterest/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Pinterest/screenshot.png',
      'preview_url'                => TX_DEMO_URL.'pinterest',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Pinterest

    [
      'import_file_name'           => 'Portfolio',
      'categories'                 => [ 'Portfolio' ],
      'import_file_url'            => TX_IMPORT_URL.'Portfolio/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Portfolio/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Portfolio/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Portfolio/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'portfolio',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Portfolio

    [
      'import_file_name'           => 'Printing Services',
      'categories'                 => [ 'Printing', 'Services' ],
      'import_file_url'            => TX_IMPORT_URL.'PrintingServices/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'PrintingServices/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'PrintingServices/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'PrintingServices/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'printing-services',
      'import_notice' => esc_html__( 'If any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Printing Services

    [
      'import_file_name'           => 'Product Landing Page',
      'categories'                 => [ 'Landing Page', 'Onepage' ],
      'import_file_url'            => TX_IMPORT_URL.'ProductLandingPage/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'ProductLandingPage/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'ProductLandingPage/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'ProductLandingPage/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'product-landing-page',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Product Landing Page

    [
      'import_file_name'           => 'Real Estate',
      'categories'                 => [ 'Real Estate' ],
      'import_file_url'            => TX_IMPORT_URL.'RealEstate/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'RealEstate/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'RealEstate/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'RealEstate/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'real-estate',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Real Estate

    [
      'import_file_name'           => 'Restaurant',
      'categories'                 => [ 'Pinterest Style' ],
      'import_file_url'            => TX_IMPORT_URL.'Restaurant/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Restaurant/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Restaurant/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Restaurant/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'restaurant',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Restaurant

    [
      'import_file_name'           => 'Resume',
      'categories'                 => [ 'Resume' ],
      'import_file_url'            => TX_IMPORT_URL.'Resume/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Resume/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Resume/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Resume/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'resume',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Resume

    [
      'import_file_name'           => 'RTL',
      'categories'                 => [ 'RTL', 'Arabic' ],
      'import_file_url'            => TX_IMPORT_URL.'RTL/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'RTL/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'RTL/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'RTL/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'rtl',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // RTL

    [
      'import_file_name'           => 'SaaS',
      'categories'                 => [ 'Software', 'Services','Business', 'Company', 'SaaS' ],
      'import_file_url'            => TX_IMPORT_URL.'Saas/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Saas/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Saas/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Saas/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'saas',
      'import_notice' => esc_html__( 'If any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),   
    ], // SaaS

    [
      'import_file_name'           => 'SEO',
      'categories'                 => [ 'SEO' ],
      'import_file_url'            => TX_IMPORT_URL.'SEO/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'SEO/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'SEO/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'SEO/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'seo',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // SEO

    [
      'import_file_name'           => 'Shop',
      'categories'                 => [ 'Shop', 'WooCommerce' ],
      'import_file_url'            => TX_IMPORT_URL.'Shop/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Shop/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Shop/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Shop/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'shop',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Shop

    [
      'import_file_name'           => 'Spa',
      'categories'                 => [ 'Spa' ],
      'import_file_url'            => TX_IMPORT_URL.'Spa/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Spa/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Spa/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Spa/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'spa',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Spa

    [
      'import_file_name'           => 'Startup',
      'categories'                 => [ 'Startup' ],
      'import_file_url'            => TX_IMPORT_URL.'Startup/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Startup/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Startup/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Startup/screenshot.png',
      'preview_url'                => TX_DEMO_URL.'startup',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Startup

    // [
    //   'import_file_name'           => 'Tattoo Parlour',
    //   'categories'                 => [ 'Parlour','Onepage', 'Landing Page','Tattoo' ],
    //   'import_file_url'            => TX_IMPORT_URL.'TattooParlour/content.xml',
    //   'import_redux'               => [
    //     [
    //       'file_url'    => TX_IMPORT_URL.'TattooParlour/theme-options.json',
    //       'option_name' => 'tx',
    //     ],
    //   ],
    //   'import_preview_image_url'   => TX_IMPORT_URL.'TattooParlour/screenshot.jpg',
    //   'preview_url'                => TX_DEMO_URL.'tattoo-parlour',
    //   'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    // ], // Tattoo Parlour

    [
      'import_file_name'           => 'Technology',
      'categories'                 => [ 'Technology', 'Agency', 'Services' ],
      'import_file_url'            => TX_IMPORT_URL.'Technology/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Technology/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Technology/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Technology/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'technology',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),   
    ], // Technology

    [
      'import_file_name'           => 'Transportation & Logistics',
      'categories'                 => [ 'Transportation', 'Logistics', 'Services' ],
      'import_file_url'            => TX_IMPORT_URL.'TransportationLogistics/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'TransportationLogistics/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'TransportationLogistics/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'TransportationLogistics/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'transportation-logistics',
      'import_notice' => esc_html__( 'If any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again. If the import failed then please re-import again.', 'avas' ),
    ], // Transportation & logistics

    [
      'import_file_name'           => 'Travel',
      'categories'                 => [ 'Travel' ],
      'import_file_url'            => TX_IMPORT_URL.'Travel/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Travel/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Travel/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Travel/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'travel',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Travel

    [
      'import_file_name'           => 'Website Builder',
      'categories'                 => [ 'Onepage', 'Landing Page' ],
      'import_file_url'            => TX_IMPORT_URL.'WebsiteBuilder/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'WebsiteBuilder/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'WebsiteBuilder/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'WebsiteBuilder/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'website-builder',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Website Builder

    [
      'import_file_name'           => 'Web Solutions',
      'categories'                 => [ 'Onepage', 'Landing Page' ],
      'import_file_url'            => TX_IMPORT_URL.'WebSolutions/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'WebSolutions/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'WebSolutions/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'WebSolutions/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'web-solutions',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Web Solutions

    [
      'import_file_name'           => 'Wedding',
      'categories'                 => [ 'Wedding' ],
      'import_file_url'            => TX_IMPORT_URL.'Wedding/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Wedding/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Wedding/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Wedding/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'wedding',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),     
    ], // Wedding

    [
      'import_file_name'           => 'Yoga',
      'categories'                 => [ 'Yoga' ],
      'import_file_url'            => TX_IMPORT_URL.'Yoga/content.xml',
      'import_widget_file_url'     => TX_IMPORT_URL.'Yoga/widgets.json',
      'import_redux'               => [
        [
          'file_url'    => TX_IMPORT_URL.'Yoga/theme-options.json',
          'option_name' => 'tx',
        ],
      ],
      'import_preview_image_url'   => TX_IMPORT_URL.'Yoga/screenshot.jpg',
      'preview_url'                => TX_DEMO_URL.'yoga',
      'import_notice' => esc_html__( 'If the Slider Revolution or any of the plugins failed to activate or stuck on this page for a long time or get Internal Server Error (500) then please refresh the page and click the "Continue & Import" button again.', 'avas' ),    
    ], // Yoga


  ];
}

add_filter( 'ocdi/import_files', 'tx_import_files' );