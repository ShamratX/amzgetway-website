<?php
namespace AvasElements\Modules\ServicesCarousel\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use elementor\Group_Control_Border;
use elementor\Icons_Manager;
use elementor\Utils;
use AvasElements\TX_Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class ServicesCarousel extends Widget_Base {

    public function get_name() {
        return 'avas-services-carousel';
    }

    public function get_title() {
        return esc_html__( 'Avas Services Carousel', 'avas-core' );
    }

    public function get_icon() {
        return 'eicon-posts-carousel';
    }

    public function get_categories() {
        return [ 'avas-elements' ];
    }

    public function get_script_depends() {
        return [ 'tx-owl-carousel', 'carousel-widgets' ];
    }

    public function get_style_depends() {
        return [ 'tx-owl-carousel' ];
    }

	protected function register_controls() {
       
		$this->start_controls_section(
            'settings',
            [
                'label' => esc_html__( 'Content Settings', 'avas-core' )
            ]
        );
        
        $this->add_control(
            'tx_categories',
            [
                'label'       => esc_html__( 'Categories', 'avas-core' ),
                'type'        => Controls_Manager::SELECT2,
                'options'     => TX_Helper::get_post_type_categories('service-category'),
                'default'     => [],
                'label_block' => true,
                'multiple'    => true,
            ]
        );
        
        $this->add_control(
            'number_of_posts',
            [
                'label' => esc_html__( 'Number of Posts', 'avas-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 8
            ]
        );
        
        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'avas-core'),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'ASC' => esc_html__('Ascending', 'avas-core'),
                    'DESC' => esc_html__('Descending', 'avas-core'),
                ),
                'default' => 'DESC',
            ]
        );
        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Order By', 'avas-core'),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'none' => esc_html__('No order', 'avas-core'),
                    'ID' => esc_html__('Post ID', 'avas-core'),
                    'author' => esc_html__('Author', 'avas-core'),
                    'title' => esc_html__('Title', 'avas-core'),
                    'date' => esc_html__('Published date', 'avas-core'),
                    'rand' => esc_html__('Random order', 'avas-core'),
                    'menu_order' => esc_html__('Menu order', 'avas-core'),
                ),
                'default' => 'date',
            ]
        );
        $this->add_control(
            'offset',
            [
                'label' => esc_html__( 'Offset', 'avas-core' ),
                'type' => Controls_Manager::NUMBER,
               
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image',
                'exclude' => [ 'custom' ],
                'default' => 'tx-serv-thumb',
            ]
        );
        $this->add_control(
            'display',
            [
                'label'     => esc_html__( 'Style', 'avas-core' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'grid',
                'options'   => [
                        'grid'    => esc_html__('Style 1','avas-core'),
                        'grid_2'    => esc_html__('Style 2','avas-core'),
                        'overlay'    => esc_html__('Overlay','avas-core'),
                    ],
            ]
        );
        $this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__( 'Alignment', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                // 'default' => 'center',
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'avas-core' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'avas-core' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'avas-core' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'toggle' => false,
                'tender_type' => 'template',
                // 'prefix_class' => 'tx-hd-align-',
                'selectors'         => [
                    '{{WRAPPER}} .tx-services-content' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'image_display',
            [
                'label' => esc_html__( 'Image', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Yes', 'avas-core' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'No', 'avas-core' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show',
               'separator' => 'before',
               'condition' => [
                    'display' => ['grid', 'grid_2']
               ]
            ]
        );
        $this->add_control(
            'icon_image',
            [
                'label' => esc_html__( 'Icon Image', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Yes', 'avas-core' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'No', 'avas-core' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show',
                'condition' => [
                    'display' => 'grid_2'
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_position_x',
            [
                'label' => esc_html__( 'Icon Image Position X', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1200,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-services-item.grid_2 .tx-services-content .tx-services-content-icon' => 'left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_image' => 'show',
                    'display' => 'grid_2'
                ],
            ] 
        );
        $this->add_responsive_control(
            'icon_position_y',
            [
                'label' => esc_html__( 'Icon Image Position Y', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-services-item.grid_2 .tx-services-content .tx-services-content-icon' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_image' => 'show',
                    'display' => 'grid_2'
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Icon Image Size', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-services-item.grid_2 .tx-services-content .tx-services-content-icon img' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_image' => 'show',
                    'display' => 'grid_2'
                ],
                'separator' => 'after'
            ] 
        );
        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Yes', 'avas-core' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'No', 'avas-core' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show',
                
            ]
        );
        $this->add_control(
            'title_lenth',
            [
                'label' => esc_html__( 'Title Lenth', 'avas-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '30',
                'condition' => [
                    'title' => 'show',
                ]

            ]
        );
        $this->add_control(
            'category_display',
            [
                'label' => esc_html__( 'Category', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Yes', 'avas-core' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'No', 'avas-core' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show',
            ]
        );
        $this->add_control(
            'bio',
            [
                'label' => esc_html__( 'Description', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Yes', 'avas-core' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'No', 'avas-core' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show'
            ]
        );
        $this->add_control(
            'excerpt_words',
            [
                'label' => esc_html__( 'Desc Words Limit', 'avas-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '20',
                'condition' => [
                    'bio' => 'show',
                ],
            ]
        );
        $this->add_control(
            'icon',
            [
                'label' => esc_html__( 'Overlay Icon', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'block' => [
                        'title' => esc_html__( 'Yes', 'avas-core' ),
                        'icon' => 'eicon-check',
                    ],
                    'none' => [
                        'title' => esc_html__( 'No', 'avas-core' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'block',
                'condition' => [
                    'display' => 'grid'
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-services-featured a:after'   => 'display: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'arrow',
            [
                'label' => esc_html__( 'Overlay Arrow', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Yes', 'avas-core' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'No', 'avas-core' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show',
                'condition' => [
                    'display' => 'overlay'
                ],
            ]
        );

        $this->end_controls_section();
         $this->start_controls_section(
            'carousel_settings',
            [
                'label' => esc_html__('Carousel Settings', 'avas-core'),
            ]
        );
         $this->add_control(
            'display_mobile',
            [
                'label' => esc_html__( 'Posts Per Row on Mobile', 'avas-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 1
            ]
        );
        $this->add_control(
            'display_tablet',
            [
                'label' => esc_html__( 'Posts Per Row on Tablet', 'avas-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 2
            ]
        );
        $this->add_control(
            'display_laptop',
            [
                'label' => esc_html__( 'Posts Per Row on Laptop', 'avas-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 3
            ]
        );
        $this->add_control(
            'display_desktop',
            [
                'label' => esc_html__( 'Posts Per Row on Desktop', 'avas-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 3
            ]
        );
        $this->add_control(
            'gutter',
            [
                'label' => esc_html__( 'Gutter', 'avas-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 20
            ]
        );
        
        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__( 'Autoplay', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'yes' => [
                        'title' => esc_html__( 'Yes', 'avas-core' ),
                        'icon' => 'eicon-check',
                    ],
                    'no' => [
                        'title' => esc_html__( 'No', 'avas-core' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'yes',
                'toggle' => false,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'smart_speed',
            [
                'label' => esc_html__('Slide Change Speed', 'avas-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 600,
                'condition' => [
                    'autoplay' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'autoplay_timeout',
            [
                'label' => esc_html__('Slide Change Delay', 'avas-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 2000,
                'condition' => [
                    'autoplay' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'pause_on_hover',
            [
                'label' => esc_html__( 'Autoplay pause on hover', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'yes' => [
                        'title' => esc_html__( 'Yes', 'avas-core' ),
                        'icon' => 'eicon-check',
                    ],
                    'no' => [
                        'title' => esc_html__( 'No', 'avas-core' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'yes',
                'toggle' => false,
                'condition' => [
                    'autoplay' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'loop',
            [
                'label' => esc_html__( 'Loop', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'yes' => [
                        'title' => esc_html__( 'Yes', 'avas-core' ),
                        'icon' => 'eicon-check',
                    ],
                    'no' => [
                        'title' => esc_html__( 'No', 'avas-core' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'yes',
                'toggle' => false,
            ]
        );
        $this->add_responsive_control(
            'navigation',
            [
                'label' => esc_html__( 'Navigation', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'yes' => [
                        'title' => esc_html__( 'Yes', 'avas-core' ),
                        'icon' => 'eicon-check',
                    ],
                    'no' => [
                        'title' => esc_html__( 'No', 'avas-core' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'yes',
                'toggle' => false,
               
            ]
        );
        $this->add_responsive_control(
            'nav_position',
            [
                'label' => esc_html__( 'Navigation Position', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'tx-nav-top' => [
                        'title' => esc_html__( 'Top', 'avas-core' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'tx-nav-middle' => [
                        'title' => esc_html__( 'Middle', 'avas-core' ),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'tx-nav-bottom' => [
                        'title' => esc_html__( 'Bottom', 'avas-core' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'toggle' => false,
                'default' => 'tx-nav-bottom',
                'condition' => [
                    'navigation' => 'yes'
                ],
            ]
        );
        $this->add_responsive_control(
            'nav_alignment',
            [
                'label' => esc_html__( 'Navigation Alignment', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'tx-nav-left' => [
                        'title' => esc_html__( 'Left', 'avas-core' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'tx-nav-center' => [
                        'title' => esc_html__( 'Center', 'avas-core' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'tx-nav-right' => [
                        'title' => esc_html__( 'Right', 'avas-core' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'toggle' => false,
                'default' => 'tx-nav-center',
                'condition' => [
                    'nav_position!' => 'tx-nav-middle',
                    'navigation' => 'yes'
                ],
            ]
        );
        $this->add_responsive_control(
            'nav_top_spacing',
            [
                'label' => esc_html__( 'Navigation Spacing', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => -150,
                        'max' => 150,
                    ],
                   
                ],
                'condition' => [
                    'navigation' => 'yes',
                    'nav_position' => 'tx-nav-top',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-nav-top.tx-nav-center .tx-carousel.owl-carousel .owl-nav, {{WRAPPER}} .tx-nav-top.tx-nav-left .tx-carousel.owl-carousel .owl-nav, {{WRAPPER}} .tx-nav-top.tx-nav-right .tx-carousel.owl-carousel .owl-nav' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'nav_spacing',
            [
                'label' => esc_html__( 'Navigation Spacing', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => -150,
                        'max' => 150,
                    ],
                   
                ],
                'condition' => [
                    'navigation' => 'yes',
                    'nav_position' => 'tx-nav-middle',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-nav-middle .tx-carousel.owl-carousel .owl-nav button.owl-prev' => 'left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tx-nav-middle .tx-carousel.owl-carousel .owl-nav button.owl-next' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'nav_bottom_spacing',
            [
                'label' => esc_html__( 'Navigation Spacing', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => -150,
                        'max' => 150,
                    ],
                   
                ],
                'condition' => [
                    'navigation' => 'yes',
                    'nav_position' => 'tx-nav-bottom',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-nav-bottom.tx-nav-center .tx-carousel.owl-carousel .owl-nav, {{WRAPPER}} .tx-nav-bottom.tx-nav-left .tx-carousel.owl-carousel .owl-nav, {{WRAPPER}} .tx-nav-bottom.tx-nav-right .tx-carousel.owl-carousel .owl-nav' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'nav_indent',
            [
                'label' => esc_html__( 'Navigation Indent', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        // 'min' => -150,
                        'max' => 100,
                    ],
                   
                ],
                'condition' => [
                    'navigation' => 'yes',
                    'nav_position' => ['tx-nav-top','tx-nav-bottom'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-carousel.owl-carousel .owl-nav button.owl-prev' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'dots',
            [
                'label' => esc_html__( 'Dots', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'block' => [
                        'title' => esc_html__( 'Yes', 'avas-core' ),
                        'icon' => 'eicon-check',
                    ],
                    'none' => [
                        'title' => esc_html__( 'No', 'avas-core' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'none',
                'toggle' => false,
                'selectors'         => [
                    '{{WRAPPER}} .tx-carousel.owl-carousel .owl-dots'   => 'display: {{VALUE}};',
                ],
               
            ]
        );
        $this->end_controls_section();

        // Style section started
        $this->start_controls_section(
            'styles',
            [
              'label'   => esc_html__( 'Styles', 'avas-core' ),
              'tab'     => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'overlay_bg_color',
            [
                'label' => esc_html__('Overlay Background Color', 'avas-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-services-featured a:before' => 'background-color: {{VALUE}};',
                ],

            ]
        );
        $this->add_control(
            'overlay_icon_color',
            [
                'label' => esc_html__('Overlay Icon Color', 'avas-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-services-featured a:after, {{WRAPPER}} .tx-services-overlay-item i' => 'color: {{VALUE}};',
                ],
                
            ]
        );
        $this->add_control(
            'cont_bg_color',
            [
                'label'     => esc_html__( 'Content Background Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-services-content' => 'background-color: {{VALUE}}',
                ],
                
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'cont_box_shadow',
                'selector' => '{{WRAPPER}} .tx-services-content',
                'condition' => [
                    'display' => ['grid', 'grid_2'],
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'serv_box_shadow_hover',
                'label'     => esc_html__( 'Box Shadow Hover', 'avas-core' ),
                'selector' => '{{WRAPPER}} .tx-services-item:hover',
                'condition' => [
                    'display' => 'grid',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'cont_border',
                'selector'    =>    '{{WRAPPER}} .tx-services-content',
                'condition' => [
                    'display' => ['grid', 'grid_2'],
                ],
            ]
        );
        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__( 'Content Padding', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tx-services-item .tx-services-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__( 'Icon Image Background Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-services-item.grid_2 .tx-services-content .tx-services-content-icon i' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'icon_image' => 'show',
                    'display' => 'grid_2'
                ],
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'icon_padding',
            [
                'label' => esc_html__( 'Icon Image Padding', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tx-services-item.grid_2 .tx-services-content .tx-services-content-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition' => [
                    'icon_image' => 'show',
                    'display' => 'grid_2'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'icon_img_border',
                'selector'    =>    '{{WRAPPER}} .tx-services-item.grid_2 .tx-services-content .tx-services-content-icon',
                'condition' => [
                    'icon_image' => 'show',
                    'display' => 'grid_2'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_img_shadow',
                'selector' => '{{WRAPPER}} .tx-services-item.grid_2 .tx-services-content .tx-services-content-icon',
                'condition' => [
                    'icon_image' => 'show',
                    'display' => 'grid_2'
                ],
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__( 'Title Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-services-title' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'title' => 'show',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'title_color_hover',
            [
                'label'     => esc_html__( 'Title Hover Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-services-title a:hover, {{WRAPPER}} .tx-services-overlay-item .tx-services-title:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'title' => 'show',
                ],
            ]
        );
        
        $this->add_control(
            'title_bg_color',
            [
                'label'     => esc_html__( 'Title Background Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-services-title-holder' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'title' => 'show',
                    'display' => 'overlay',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'title_typography',
                   'selector'  => '{{WRAPPER}} .tx-services-title',
                   'condition' => [
                      'title' => 'show',
                    ],
              ]
        );
        $this->add_control(
            'desc_color',
            [
                'label'     => esc_html__( 'Excerpt Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-services-overlay-item .tx-services-excp, {{WRAPPER}} .tx-services-excp' => 'color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'desc_typography',
                   'selector'  => '{{WRAPPER}} .tx-services-overlay-item .tx-services-excp, {{WRAPPER}} .tx-services-excp',
              ]
        );
        $this->add_control(
            'cate_color',
            [
                'label'     => esc_html__( 'Category Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-serv-cat' => 'color: {{VALUE}}; border-color: {{VALUE}};',
                ],
                
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'cate_hov_color',
            [
                'label'     => esc_html__( 'Category Hover Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-serv-cat:hover' => 'color: {{VALUE}}; border-color: {{VALUE}};',
                ],
                
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'cat_typography',
                   'selector'  => '{{WRAPPER}} .tx-serv-cat',
              ]
        );
        $this->add_control(
            'navigation_color',
            [
                'label'     => esc_html__( 'Navigation Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-carousel.owl-carousel .owl-nav button.owl-prev i, {{WRAPPER}} .tx-carousel.owl-carousel .owl-nav button.owl-next i' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'navigation' => 'yes',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'navigation_hover_color',
            [
                'label'     => esc_html__( 'Navigation Hover Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-carousel.owl-carousel .owl-nav button.owl-prev:hover i, {{WRAPPER}} .tx-carousel.owl-carousel .owl-nav button.owl-next:hover i' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'navigation' => 'yes',
                ],
            ]
        );
      
        $this->add_control(
            'navigation_hover_bg_color',
            [
                'label'     => esc_html__( 'Navigation Background Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-carousel.owl-carousel .owl-nav button.owl-prev, {{WRAPPER}} .tx-carousel.owl-carousel .owl-nav button.owl-next' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'navigation' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'navigation_hover_bg_hover_color',
            [
                'label'     => esc_html__( 'Navigation Background Hover Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-carousel.owl-carousel .owl-nav button.owl-prev:hover, {{WRAPPER}} .tx-carousel.owl-carousel .owl-nav button.owl-next:hover' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'navigation' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'nav_icon_size',
            [
                'label' => esc_html__( 'Navigation Icon Size', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-carousel.owl-carousel .owl-nav button.owl-next i, {{WRAPPER}} .tx-carousel.owl-carousel .owl-nav button.owl-prev i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'nav_border_radius',
            [
                'label' => esc_html__( 'Navigation Border Radius', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-carousel.owl-carousel .owl-nav button.owl-next, {{WRAPPER}} .tx-carousel.owl-carousel .owl-nav button.owl-prev' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation' => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'nav_border',
                'selector'    =>    '{{WRAPPER}} .tx-carousel.owl-carousel .owl-nav button.owl-next, {{WRAPPER}} .tx-carousel.owl-carousel .owl-nav button.owl-prev',
                'condition' => [
                    'navigation' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'nav_padding',
            [
                'label' => esc_html__( 'Navigation Padding', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tx-carousel.owl-carousel .owl-nav button.owl-next, {{WRAPPER}} .tx-carousel.owl-carousel .owl-nav button.owl-prev' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
                'condition' => [
                    'navigation' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'dots_bg_color',
            [
                'label'     => esc_html__( 'Dots Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-carousel.owl-carousel button.owl-dot span' => 'background-color: {{VALUE}};',
                ],
                'separator' => 'before',
                'condition' => [
                    'dots' => 'block',
                ],
            ]
        );
        $this->add_control(
            'dots_active_bg_color',
            [
                'label'     => esc_html__( 'Dots Active Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-carousel.owl-carousel button.owl-dot.active span' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'dots' => 'block',
                ],
            ]
        );
        $this->add_control(
            'dots_size',
            [
                'label' => esc_html__( 'Dots Size', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                   
                ],
                'default' => [
                    'size' => 12,
                ],
                'condition' => [
                    'dots' => 'block',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-carousel.owl-carousel button.owl-dot span' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();
    }
    
    protected function render() {
      
        $settings = $this->get_settings_for_display();
        $tx_categories = $settings['tx_categories'];

            $this->add_render_attribute( 
                [
                    'tx-carousel-wrapper' => [
                        'class' => [
                            'tx-testimonial-wrap',
                            $settings['nav_position'],
                            $settings['nav_alignment'],
                        ] 
                    ]
                ]
            );

            $this->add_render_attribute( 'tx-carousel', 'class', 'tx-carousel owl-carousel owl-theme' );
            $this->add_render_attribute(
                [
                    'tx-carousel' => [
                        'data-settings' => [
                            wp_json_encode(array_filter([
                               'navigation' => ('yes' === $settings['navigation']),
                               'autoplay' => ('yes' === $settings['autoplay']),
                               'autoplay_timeout' => absint($settings['autoplay_timeout']),
                               'smart_speed' => absint($settings['smart_speed']),
                               'pause_on_hover' => ('yes' === $settings['pause_on_hover']),
                               'loop' => ('yes' === $settings['loop']),
                               'display_mobile' => $settings['display_mobile'],
                               'display_tablet' => $settings['display_tablet'],
                               'display_laptop' => $settings['display_laptop'],
                               'display_desktop' => $settings['display_desktop'],
                               'gutter' => $settings['gutter'],
                            ]))
                        ]
                    ]
                ]
            );

       
        if( !empty($tx_categories) ) {

            $query_args = array(
                'post_type' => 'service',
                'orderby' => $settings['orderby'],
                'order' => $settings['order'],
                'ignore_sticky_posts' => 1,
                'post_status' => 'publish',
                'showposts' => $settings['number_of_posts'],
                'offset' => $settings['offset'],
                'tax_query' => array(
                'relation' => 'AND',
                    array(
                        'taxonomy' => 'service-category',
                        'field'    => 'slug',
                        'terms'    => $tx_categories,
                    ),
                )
            );

        } else {

            $query_args = array(
                'post_type' => 'service',
                'orderby' => $settings['orderby'],
                'order' => $settings['order'],
                'ignore_sticky_posts' => 1,
                'post_status' => 'publish',
                'showposts' => $settings['number_of_posts'],
                'offset' => $settings['offset'],
            );
        }
        global $post;

        $post_query = new \WP_Query( $query_args );

        ?>

        <div <?php echo $this->get_render_attribute_string( 'tx-carousel-wrapper' ); ?>>

            <?php
          
            if ($post_query->have_posts()) : 

            ?>

            <div <?php echo $this->get_render_attribute_string( 'tx-carousel' ); ?> >
                <?php while ($post_query->have_posts()) : $post_query->the_post();
                        global $post;
                        $terms = get_the_terms( $post->ID, 'service-category' );
                        if ( $terms && ! is_wp_error( $terms ) ) :
                          $taxonomy = array();
                          foreach ( $terms as $term ) :
                            $taxonomy[] = $term->name;
                          endforeach;
                          $cat_name = join( " ", $taxonomy);
                          $cat_link = get_term_link( $term );
                        else:
                        $cat_name = '';
                        endif;
                ?>
                        <?php if($settings['display'] == 'grid') : ?>
                            <div class="tx-services-item <?php echo esc_attr($settings['display']); ?>">
                            <?php if (has_post_thumbnail() && $settings['image_display'] == 'show') : ?>
                                <div class="tx-services-featured">
                                    <a href="<?php the_permalink(); ?>" rel="bookmark">
                                        <?php the_post_thumbnail($settings['image_size']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                                <div class="tx-services-content">
                                    <?php if($settings['title'] == 'show') : ?>
                                    <h3 class="tx-services-title"><a href="<?php the_permalink() ?>" rel="bookmark" ><?php echo TX_Helper::title_lenth($settings['title_lenth']); ?></a></h3>
                                    <?php endif; ?>
                                    <?php if($settings['bio'] == 'show') : ?>
                                    <div class="tx-services-excp"><?php echo TX_Helper::excerpt_limit($settings['excerpt_words']); ?></div>
                                    <?php endif; ?> 
                                    <?php if(!empty($cat_name) && $settings['category_display'] == 'show') : ?>
                                        <a class="tx-serv-cat" href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_attr($cat_name); ?></a>
                                    <?php endif; ?>
                                </div><!-- /.tx-services-content -->
                            </div><!-- /.tx-services-item -->
                        <?php endif; ?>

                        <?php if($settings['display'] == 'grid_2') : 
                            $icon_img_id = get_post_meta(get_the_ID(), 'icon_img', true);
                            $icon_img_url = wp_get_attachment_image_src( $icon_img_id, 'thumbnail' );
                            $icon_image = ( !empty($icon_img_url[0]) ) ? $icon_img_url[0] : null;
                        ?>
                            <div class="tx-services-item <?php echo esc_attr($settings['display']); ?>">
                            <?php if (has_post_thumbnail() && $settings['image_display'] == 'show') : ?>
                                <div class="tx-services-featured">
                                    <a href="<?php the_permalink(); ?>" rel="bookmark">
                                        <?php the_post_thumbnail($settings['image_size']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                                <div class="tx-services-content">
                                    <?php if ( $settings['icon_image'] == 'show' && !empty($icon_image) ) : ?>
                                        <span class="tx-services-content-icon"><img src="<?php echo esc_attr($icon_image); ?>" alt="<?php the_title(); ?>" /></span>
                                    <?php endif; ?>
                                    <?php if($settings['title'] == 'show') : ?>
                                    <h3 class="tx-services-title"><a href="<?php the_permalink() ?>" rel="bookmark" ><?php echo TX_Helper::title_lenth($settings['title_lenth']); ?></a></h3>
                                    <?php endif; ?>
                                    <?php if($settings['bio'] == 'show') : ?>
                                    <div class="tx-services-excp"><?php echo TX_Helper::excerpt_limit($settings['excerpt_words']); ?></div>
                                    <?php endif; ?> 
                                    <?php if(!empty($cat_name) && $settings['category_display'] == 'show') : ?>
                                        <a class="tx-serv-cat" href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_attr($cat_name); ?></a>
                                    <?php endif; ?>
                                </div><!-- /.tx-services-content -->
                            </div><!-- /.tx-services-item -->
                        <?php endif; ?>


                        <?php if($settings['display'] == 'overlay') : ?>
                            <?php $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), $settings['image_size']); ?>

                            <div class="tx-services-overlay-item" <?php if (has_post_thumbnail()) : echo 'style="background-image:url('.$featured_img_url.')"'; endif;?>>
                                <div class="tx-services-content">
                                    <?php if($settings['title'] == 'show') : ?>
                                    <div class="tx-services-title-holder">
                                        <h3 class="tx-services-title"><a href="<?php the_permalink() ?>" rel="bookmark" ><?php echo TX_Helper::title_lenth($settings['title_lenth']); ?></a></h3>
                                    </div>
                                    <?php endif; ?>
                                    <?php if(!empty($cat_name) && $settings['category_display'] == 'show') : ?>
                                        <a class="tx-serv-cat" href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_attr($cat_name); ?></a>
                                    <?php endif; ?>
                                    <?php if($settings['bio'] == 'show') : ?>
                                    <div class="tx-services-excp"><?php echo TX_Helper::excerpt_limit($settings['excerpt_words']); ?></div>
                                    <?php endif; ?>
                                    <?php if($settings['arrow'] == 'show') : ?>  
                                    <a href="<?php the_permalink(); ?>"><i class="bi bi-arrow-right"></i></a>
                                    <?php endif; ?> 
                                </div><!-- /.tx-services-content -->
                            </div><!-- /.tx-services-item -->
                        <?php endif; ?>  
                <?php endwhile;
                wp_reset_postdata(); ?>
            </div><!-- tx-carousel -->
            
           
         
            <?php
            else:
                get_template_part('template-parts/content/content', 'none');
            endif;
            ?>
            <div class="clearfix"></div>
        </div><!-- tx-carousel-wrapper -->


<?php

    } // render()

} // class 