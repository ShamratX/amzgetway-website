<?php
namespace AvasElements\Modules\Grid\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Css_Filter;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use AvasElements\TX_Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Grid extends Widget_Base {

    public function get_name() {
        return 'avas-grid';
    }

    public function get_title() {
        return esc_html__( 'Avas Grid', 'avas-core' );
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_categories() {
        return [ 'avas-elements' ];
    }

	protected function register_controls() {
       
		$this->start_controls_section(
            'sec_content',
            [
                'label' => esc_html__( 'Content', 'avas-core' )
            ]
        );
       
        $repeater = new Repeater();
        
        $repeater->add_control(
            'user_image', 
            [
                'label' => esc_html__('Image', 'avas-core'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'icon_switch',
            [
                'label'        => esc_html__( 'Icon', 'avas-core' ),
                'type'         => Controls_Manager::SWITCHER,
            ]
        );
        $repeater->add_control(
            'ib_select',
            [
                'label' => esc_html__( 'Select Icon or Image', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'icon' => [
                        'title' => esc_html__( 'Icon', 'avas-core' ),
                        'icon' => 'far fa-smile-beam',
                    ],
                    'image' => [
                        'title' => esc_html__( 'Image', 'avas-core' ),
                        'icon' => 'far fa-image',
                    ]
                ],
                'default' => 'icon',
                'condition' => [
                    'icon_switch' => 'yes'
                ]
            ]
        );
        $repeater->add_control(
            'ib_icon',
            [
                'label' => esc_html__( 'Icon', 'avas-core' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-snowflake',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'ib_select' => 'icon',
                    'icon_switch' => 'yes'
                ]
            ]
        );
        $repeater->add_control(
            'ib_image',
            [
                'label' => esc_html__( 'Image', 'avas-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'ib_select' => 'image',
                    'icon_switch' => 'yes'
                ]
            ]
        );
        $repeater->add_control(
            'title', 
            [
                'label' => esc_html__('Title', 'avas-core'),
                'default' => 'Curabitur ligula sapien tincidunt',
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'link_url', 
            [
                'label' => esc_html__('Link URL', 'avas-core'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'http://your-link.com',
                'condition' => [
                    'title!' => ''
                ]
            ]
        );
        $repeater->add_control(
            'description', 
            [
                'label' => esc_html__('Descripton', 'avas-core'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt.', 'avas-core' ),
            ]
        );
        $repeater->add_control(
            'read_more_switch',
            [
                'label'        => esc_html__( 'Read More', 'avas-core' ),
                'type'         => Controls_Manager::SWITCHER,
            ]
        );
        $repeater->add_control(
            'read_more_text',
            [
                'label'       => esc_html__( 'Read More Text', 'avas-core' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Read More', 'avas-core' ),
                'placeholder' => esc_html__( 'Enter Text', 'avas-core' ),
                'condition' => [
                    'read_more_switch' => 'yes'
                ]
            ]

        );

        $repeater->add_control(
            'read_more_link',
            [
                'label'     => esc_html__( 'Read More Link', 'avas-core' ),
                'type'      => Controls_Manager::URL,
                'dynamic'   => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'avas-core' ),
                'default'     => [
                    'url' => '#',
                ],
                'condition' => [
                    'read_more_text!' => ''
                ]
            ]
        );
        $repeater->add_control(
            'read_more_icon',
            [
                'label' => esc_html__( 'Read More Icon', 'avas-core' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'skin'             => 'inline',
                'label_block'      => false,
                'condition' => [
                    'read_more_switch' => 'yes'
                ]
            ]
        );

       
        $this->add_control(
            'items',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [

                    [
                        'title' => wp_kses_post('Tristique senectus et netus'),
                        'description' => wp_kses_post('Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt.', 'avas-core'),
                    ],
                    [
                        'title' => wp_kses_post('Mauris ultricies pulvinar abitant', 'avas-core'),
                        'description' => wp_kses_post('Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt.', 'avas-core'),
                    ],
                    [
                        'title' => wp_kses_post('Arcu purus lacinia sed diam', 'avas-core'),
                        'description' => wp_kses_post('Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt.', 'avas-core'),
                    ],
                    [
                        'title' => wp_kses_post('Sollicitudin dolor diam vitae', 'avas-core'),
                        'description' => wp_kses_post('Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt.', 'avas-core'),
                    ],
                ],

                'title_field' => '{{{ title }}}',
            ]
        );
        
        $this->end_controls_section();

        // settings
        $this->start_controls_section(
            'sec_settings',
            [
                'label' => esc_html__( 'Settings', 'avas-core' )
            ]
        );
        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'avas-core' ),
                'label_block' => true,
                'type' => Controls_Manager::SELECT,             
                'desktop_default' => '33.330%',
                'mobile_default' => '100%',
                'options' => [
                    '100%' => esc_html__( '1 Column', 'avas-core' ),
                    '50%' => esc_html__( '2 Columns', 'avas-core' ),
                    '33.330%' => esc_html__( '3 Columns', 'avas-core' ),
                    '25%' => esc_html__( '4 Columns', 'avas-core' ),
                    '20%' => esc_html__( '5 Columns', 'avas-core' ),
                    '16.67%' => esc_html__( '6 Columns', 'avas-core' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-grid-item' => 'width: {{VALUE}};',
                ],
                'render_type' => 'template'
            ]
        );
        $this->add_responsive_control(
            'column_gap',
            [
                'label' => esc_html__( 'Gap', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tx-grid-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                
            ]
        );
        $this->add_control(
            'tx_lightbox',
            [
                'label' => esc_html__( 'Lightbox', 'avas-core' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
            ]
        );
        $this->end_controls_section();


        // Style section started
        $this->start_controls_section(
            'styles_section_grid',
            [
              'label'   => esc_html__( 'Styles', 'avas-core' ),
              'tab'     => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->start_controls_tabs( 'sec_grid_tabs' );

        $this->start_controls_tab( 'normal',
            [
                'label' => esc_html__( 'Normal', 'avas-core' ),
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'sec_grid_background',
                'label' => esc_html__( 'Background', 'avas-core' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .tx-grid-container',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'sec_grid_border',
                'label' => esc_html__( 'Border', 'avas-core' ),
                'selector' => '{{WRAPPER}} .tx-grid-container',
            ]
        );
        $this->add_responsive_control(
            'sec_grid_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tx-grid-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'sec_grid_padding',
            [
                'label' => esc_html__( 'Padding', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tx-grid-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'sec_grid_box_shadow',
                'selector' => '{{WRAPPER}} .tx-grid-container'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'hover',
            [
                'label' => esc_html__( 'Hover', 'avas-core' ),
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'sec_grid_hov_background',
                'label' => esc_html__( 'Background', 'avas-core' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .tx-grid-container:hover',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'sec_grid_hov_border',
                'label' => esc_html__( 'Border', 'avas-core' ),
                'selector' => '{{WRAPPER}} .tx-grid-container:hover',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'sec_grid_hov_box_shadow',
                'selector' => '{{WRAPPER}} .tx-grid-container:hover'
            ]
        );
        $this->add_control(
            'sec_grid_background_hover_transition',
            [
                'label' => esc_html__( 'Transition Duration', 'avas-core' ) . ' (s)',
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-grid-container:hover' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'styles_image',
            [
              'label'   => esc_html__( 'Image', 'avas-core' ),
              'tab'     => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_responsive_control(
            'img_width',
            [
                'label' => esc_html__( 'Image Size', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-car-grid-image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_img_border',
                'label' => esc_html__( 'Border', 'avas-core' ),
                'selector' => '{{WRAPPER}} .tx-car-grid-image img',
            ]
        );
        $this->add_responsive_control(
            'img_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tx-car-grid-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs( 'image_effects' );

        $this->start_controls_tab( 'normal',
            [
                'label' => esc_html__( 'Normal', 'avas-core' ),
            ]
        );

        $this->add_control(
            'opacity',
            [
                'label' => esc_html__( 'Opacity', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-car-grid-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .tx-car-grid-image img',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'hover',
            [
                'label' => esc_html__( 'Hover', 'avas-core' ),
            ]
        );

        $this->add_control(
            'opacity_hover',
            [
                'label' => esc_html__( 'Opacity', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-grid-container:hover .tx-car-grid-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters_hover',
                'selector' => '{{WRAPPER}} .tx-grid-container:hover .tx-car-grid-image img',
            ]
        );
        $this->add_control(
            'background_hover_transition',
            [
                'label' => esc_html__( 'Transition Duration', 'avas-core' ) . ' (s)',
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-grid-container:hover .tx-car-grid-image img' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'styles_icon',
            [
              'label'   => esc_html__( 'Icon', 'avas-core' ),
              'tab'     => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Icon / Image Size', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 300,
                    ],
                ],
                'default' => [
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-car-grid-icon-wrap i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tx-car-grid-icon-wrap img' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tx-car-grid-icon-wrap svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_x',
            [
                'label' => esc_html__( 'Offset X', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px' ],
                'range' => [
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-car-grid-icon-wrap' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_y',
            [
                'label' => esc_html__( 'Offset Y', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px' ],
                'range' => [
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-car-grid-icon-wrap' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__( 'Icon Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-car-grid-icon-wrap i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tx-car-grid-icon-wrap svg' => 'fill: {{VALUE}};',
                ],
                
            ]
        );
        $this->add_control(
            'icon_hover_color',
            [
                'label'     => esc_html__( 'Icon Hover Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-grid-container:hover .tx-car-grid-icon-wrap i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tx-grid-container:hover .tx-car-grid-icon-wrap svg' => 'fill: {{VALUE}};',
                ],
                
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'styles_content',
            [
              'label'   => esc_html__( 'Content', 'avas-core' ),
              'tab'     => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__( 'Alignment', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
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
                'selectors'         => [
                    '{{WRAPPER}} .tx-grid-container'   => 'text-align: {{VALUE}};',
                ],

            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'car_grid_cont_background',
                'label' => esc_html__( 'Background', 'avas-core' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .tx-car-grid-content',
            ]
        );
        $this->add_responsive_control(
            'cont_pad',
            [
                'label' => esc_html__( 'Content Padding', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tx-car-grid-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'cont_margin',
            [
                'label' => esc_html__( 'Content Margin', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tx-car-grid-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'cont_only_border',
                'label' => esc_html__( 'Content Border', 'avas-core' ),
                'selector' => '{{WRAPPER}} .tx-car-grid-content',
            ]
        );
        $this->add_responsive_control(
            'cont_border_radius',
            [
                'label' => esc_html__( 'Content Border Radius', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tx-car-grid-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'content_only_box_shadow',
                'selector' => '{{WRAPPER}} .tx-car-grid-content'
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__( 'Title Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-car-grid-title' => 'color: {{VALUE}};',
                ],
                
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'title_hov_color',
            [
                'label'     => esc_html__( 'Title Hover Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-car-grid-title:hover' => 'color: {{VALUE}};',
                ],
                
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'title_typography',
                   'selector'  => '{{WRAPPER}} .tx-car-grid-title',
                   
              ]
        );
        $this->add_group_control(
            Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'title_text_stroke',
                'label'     => esc_html__( 'Title Text Stroke', 'avas-core' ),
                'selector' => '{{WRAPPER}} .tx-car-grid-title',
            ]
        );
        $this->add_control(
            'description_color',
            [
                'label'     => esc_html__( 'Descripton Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-car-grid-description' => 'color: {{VALUE}};',
                ],
                
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'description_typography',
                   'selector'  => '{{WRAPPER}} .tx-car-grid-description',
                   
              ]
        );
        $this->add_control(
            'readmore_color',
            [
                'label'     => esc_html__( 'Read More Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-car-grid-read-more a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tx-car-grid-read-more svg' => 'fill: {{VALUE}};',
                ],
               
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'readmore_hover_color',
            [
                'label'     => esc_html__( 'Read More Hover Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-car-grid-read-more a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tx-car-grid-read-more a:hover svg' => 'fill: {{VALUE}};',
                ],
                
                 
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'readmore_typography',
                   'selector'  => '{{WRAPPER}} .tx-car-grid-read-more a',
                  
              ]
        );
        $this->add_control(
            'readmore_icon_size',
            [
                'label' => esc_html__( 'Read More Icon Size', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-car-grid-read-more i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tx-car-grid-read-more svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'read_more_icon_indent',
            [
                'label' => esc_html__( 'Icon Spacing', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-car-grid-read-more i, {{WRAPPER}} .tx-car-grid-read-more svg' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'readmore_padding',
            [
                'label' => esc_html__( 'Read More Padding', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tx-car-grid-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                
            ]
        );
        $this->add_responsive_control(
            'readmore_margin',
            [
                'label' => esc_html__( 'Read More Margin', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tx-car-grid-read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                
            ]
        );
        $this->end_controls_section();
    
    }
    
    public function render() {
        $settings = $this->get_settings_for_display();

    ?>
    <div class="tx-grid-wrapper">
    <?php foreach ( $settings['items'] as $index => $item ) :
        $target_title = $item['link_url']['is_external'] ? '_blank' : '_self';
        $target_readmore = $item['read_more_link']['is_external'] ? '_blank' : '_self';
        $image = $item['user_image']['url'];
        $lightbox = 'tx_lightbox' . $index;
 
        $this->add_render_attribute(
            [
                $lightbox => [
                    'data-elementor-open-lightbox' => $settings['tx_lightbox'],
                    'data-elementor-lightbox-slideshow' => $this->get_id(),
                    'href' => $image,
                ]
            ]
        );
    ?>
        <div class="tx-grid-item">
            <div class="tx-grid-container">
                <?php if(!empty($image)) : ?>
                    <div class="tx-car-grid-image">
                        <?php if('yes' === $settings['tx_lightbox']) : ?>
                            <a <?php $this->print_render_attribute_string( $lightbox ); ?>>
                                <img src="<?php echo esc_attr($image);?>" alt="<?php echo esc_attr( $item['title'] ); ?>">
                            </a>
                        <?php else: ?>
                            <img src="<?php echo esc_attr($image);?>" alt="<?php echo esc_attr( $item['title'] ); ?>">
                        <?php endif; ?>
                    </div><!-- tx-car-grid-image -->
                <?php endif; ?>
                <?php 
                    if ( 'icon' === $item['ib_select'] && 'yes' === $item['icon_switch'] ) : ?>
                        <span class="tx-car-grid-icon-wrap">
                            <?php Icons_Manager::render_icon( $item['ib_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </span>
                <?php
                    elseif ( 'image' === $item['ib_select'] && 'yes' === $item['icon_switch'] ) : ?>
                        <span class="tx-car-grid-icon-wrap">
                            <img src="<?php echo esc_attr($item['ib_image']['url']); ?>">
                        </span>
                <?php endif; ?>

                <div class="tx-car-grid-content">
                <?php if ( !empty($item['link_url']['url']) ) : ?>
                    <a href="<?php echo esc_url( $item['link_url']['url'] ); ?>" target="<?php echo esc_attr($target_title); ?>"><h4 class="tx-car-grid-title"><?php echo wp_kses_post( $item['title'] ); ?></h4></a>
                <?php else : ?>
                    <h4 class="tx-car-grid-title"><?php echo wp_kses_post( $item['title'] ); ?></h4>    
                <?php endif; ?>

                    <div class="tx-car-grid-description">
                        <?php echo wp_kses_post( $item['description'] ); ?>
                    </div>
                    
                    <?php if ( !empty($item['read_more_link']['url']) && 'yes' === $item['read_more_switch'] ) : ?>
                        <div class="tx-car-grid-read-more">
                            <a href="<?php echo $item['read_more_link']['url']; ?>" target="<?php echo esc_attr($target_readmore); ?>"><?php echo esc_html( $item['read_more_text'] ); ?><?php Icons_Manager::render_icon( $item['read_more_icon'], [ 'aria-hidden' => 'true' ] ); ?></a>
                        </div>
                    <?php endif; ?> 
                </div><!-- tx-car-grid-content -->
            </div><!-- tx-grid-container -->
        </div><!-- tx-grid-item -->
    <?php endforeach; ?>
    </div>
    <?php
    }


} // class end