<?php
namespace AvasElements\Modules\OnepageNav\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Icons;
use Elementor\Core\Responsive\Responsive;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class OnepageNav extends Widget_Base {
        
    public function get_name() {
        return 'avas-onepage-nav';
    }

    public function get_title() {
        return esc_html__( 'Avas Onepage Nav', 'avas-core' );
    }

    public function get_icon() {
        return 'eicon-navigator';
    }

    public function get_categories() {
        return [ 'avas-elements'];
    }

    public function get_keywords() {
        return [ 'one page', 'onepage', 'navigation', 'one page scroll', 'scroll navigation', 'floating menu', 'sticky menu', 'page scroll' ];
    }

    public function add_section_settings() {
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__( 'Settings', 'avas-core' ),
            ]
        );

        $this->add_control(
            'nav_item_show_tooltip',
            [
                'label' => esc_html__( 'Show Tooltip', 'avas-core' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        $this->add_control(
            'nav_item_highlight',
            [
                'label' => esc_html__( 'Highlight Active', 'avas-core' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        $this->add_control(
            'nav_item_scroll_speed',
            [
                'label' => esc_html__( 'Scrolling Speed', 'avas-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 500,
                'step' => 100,
                'min' => 0,
                'separator' => 'before'
            ]
        );

        $this->end_controls_section(); // End Controls Section
    }

    public function add_control_nav_item_stretch() {
        $this->add_control(
            'nav_item_stretch',
            [
                'label' => esc_html__( 'Stretch Vertically', 'avas-core' ),
                'type' => Controls_Manager::SWITCHER,
                'selectors_dictionary' => [
                    '' => 'height: auto;',
                    'yes' => 'height: 100%; top: 50%; transform: translateY(-50%); -webkit-transform: translateY(-50%);'
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-nav' => '{{VALUE}}',
                ],
            ]
        );
    }

    public function add_condition_nav_item_stretch() {
        return [
            'nav_item_stretch!' => 'yes',
        ];
    }

    public function add_repeater_args_nav_item_tooltip() {
        return [
            'label' => esc_html__( 'Section Tooltip', 'avas-core' ),
            'type' => Controls_Manager::TEXT,
            'default' => 'Section 1',
        ];
    }

    public function add_repeater_args_nav_item_icon_color() {
        return [
            'label' => esc_html__( 'Icon Color', 'avas-core' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}}.tx-onepage-nav-item i' => 'color: {{VALUE}};',
                '{{WRAPPER}} {{CURRENT_ITEM}}.tx-onepage-nav-item svg' => 'fill: {{VALUE}};',
            ],
        ];
    }

    public function add_section_nav_tooltip() {
        $this->start_controls_section(
            'section_nav_tooltip',
            [
                'label' => esc_html__( 'Tooltip', 'avas-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'nav_tooltip_color',
            [
                'label' => esc_html__( 'Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-nav-item .tx-onepage-tooltip' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_tooltip_bg_color',
            [
                'label' => esc_html__( 'Backgound Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#3F3F3F',
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-nav-item .tx-onepage-tooltip' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .tx-onepage-nav-item .tx-onepage-tooltip:before' => 'border-top-color: {{VALUE}}; border-bottom-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'nav_tooltip_box_shadow',
                'selector' => '{{WRAPPER}} .tx-onepage-nav-item .tx-onepage-tooltip',
            ]
        );

        $this->add_control(
            'nav_tooltip_type_divider',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'nav_item_tooltip_typography',
                'selector' => '{{WRAPPER}} .tx-onepage-nav-item .tx-onepage-tooltip'
            ]
        );

        $this->add_responsive_control(
            'nav_tooltip_width',
            [
                'label' => esc_html__( 'Width', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => 100,
                ],
                'size_units' => [ 'px', ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 150,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-nav-item .tx-onepage-tooltip' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'nav_tooltip_offset',
            [
                'label' => esc_html__( 'Offset', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}}.tx-onepage-nav-hr-left .tx-onepage-nav-item .tx-onepage-tooltip' => 'transform: translate({{SIZE}}%,-50%); -webkit-transform: translate({{SIZE}}%,-50%);',
                    '{{WRAPPER}}.tx-onepage-nav-hr-left .tx-onepage-nav-item:hover .tx-onepage-tooltip' => 'transform: translate(calc({{SIZE}}% - 10%),-50%); -webkit-transform: translate(-webkit-calc({{SIZE}}% - 10%),-50%);',
                    '{{WRAPPER}}.tx-onepage-nav-hr-right .tx-onepage-nav-item .tx-onepage-tooltip' => 'transform: translate(calc(-{{SIZE}}% - 100%),-50%); -webkit-transform: translate(calc(-{{SIZE}}% - 100%),-50%);',
                    '{{WRAPPER}}.tx-onepage-nav-hr-right .tx-onepage-nav-item:hover .tx-onepage-tooltip' => 'transform: translate(calc(-{{SIZE}}% - 100% + 10%),-50%); -webkit-transform: translate(-webkit-calc(-{{SIZE}}% - 100% + 10%),-50%);',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_tooltip_padding',
            [
                'label' => esc_html__( 'Padding', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 5,
                    'right' => 10,
                    'bottom' => 5,
                    'left' => 10,
                ],
                'size_units' => [ 'px', ],
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-nav-item .tx-onepage-tooltip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'nav_tooltip_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 22,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-nav-item .tx-onepage-tooltip' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->end_controls_section(); // End Controls Section
    }

    protected function register_controls() {

        // Section: Navigation -------
        $this->start_controls_section(
            'section_nav',
            [
                'label' => esc_html__('Navigation','avas-core'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'nav_item_id',
            [
                'label' => esc_html__( 'Section ID', 'avas-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'section-one',
            ]
        );

        $repeater->add_control( 'nav_item_tooltip', $this->add_repeater_args_nav_item_tooltip() );
        
        $repeater->add_control(
            'nav_item_icon',
            [
                'label' => esc_html__( 'Select Icon', 'avas-core' ),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'label_block' => false,
                'default' => [
                    'value' => 'fas fa-home',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $repeater->add_control( 'nav_item_icon_color', $this->add_repeater_args_nav_item_icon_color() );

        $this->add_control(
            'nav_items',
            [
                'label' => esc_html__( 'Navigation Items', 'avas-core' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'nav_item_id' => 'section-one',
                        'nav_item_tooltip' => 'Section 1',
                        'nav_item_icon' => [
                            'value' => 'fas fa-home',
                            'library' => 'fa-solid',
                        ],
                    ],
                    [
                        'nav_item_id' => 'section-two',
                        'nav_item_tooltip' => 'Section 2',
                        'nav_item_icon' => [
                            'value' => 'far fa-envelope',
                            'library' => 'fa-regular',
                        ],
                    ],
                    [
                        'nav_item_id' => 'section-three',
                        'nav_item_tooltip' => 'Section 3',
                        'nav_item_icon' => [
                            'value' => 'fas fa-info-circle',
                            'library' => 'fa-solid',
                        ],
                    ],
                ],
                'title_field' => '{{{ nav_item_tooltip }}}',
            ]
        );

        $this->end_controls_section(); // End Controls Section

        // Section: Layout -----------
        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__( 'Layout', 'avas-core' ),
            ]
        );

        $this->add_control_nav_item_stretch();

        $this->add_control(
            'nav_item_position_hr',
            [
                'label' => esc_html__( 'Horizontal Position', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'right',
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'avas-core' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'avas-core' ),
                        'icon' => 'eicon-h-align-right',
                    ]
                ],
                'prefix_class' => 'tx-onepage-nav-hr-'
            ]
        );

        $this->add_control(
            'nav_item_position_vr',
            [
                'label' => esc_html__( 'Vertical Position', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'middle',
                'options' => [
                    'top' => [
                        'title' => esc_html__( 'Top', 'avas-core' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'middle' => [
                        'title' => esc_html__( 'Middle', 'avas-core' ),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'bottom' => [
                        'title' => esc_html__( 'Bottom', 'avas-core' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'prefix_class' => 'tx-onepage-nav-vr-',
                'separator' => 'after',
                'condition' => $this->add_condition_nav_item_stretch(),
            ]
        );

        $this->end_controls_section(); // End Controls Section

        // Section: Settings ---------
        $this->add_section_settings();

        // Styles ====================
        // Section: Nav Wrap ---------
        $this->start_controls_section(
            'section_nav_wrap',
            [
                'label' => esc_html__( 'Navigation Wrapper', 'avas-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'nav_wrap_bg_color',
                'types' => [ 'classic', 'gradient' ],
                'fields_options' => [
                    'color' => [
                        'default' => '#605BE5',
                    ],
                ],
                'selector' => '{{WRAPPER}} .tx-onepage-nav'
            ]
        );

        $this->add_control(
            'nav_wrap_border_color',
            [
                'label' => esc_html__( 'Border Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#232323',
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-nav' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'nav_wrap_box_shadow',
                'selector' => '{{WRAPPER}} .tx-onepage-nav',
            ]
        );

        $this->add_responsive_control(
            'nav_wrap_gutter',
            [
                'label' => esc_html__( 'Gutter', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-nav-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'nav_wrap_padding',
            [
                'label' => esc_html__( 'Padding', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 15,
                    'right' => 15,
                    'bottom' => 15,
                    'left' => 15,
                ],
                'size_units' => [ 'px', ],
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-nav' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_wrap_margin',
            [
                'label' => esc_html__( 'Margin', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'size_units' => [ 'px', ],
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-nav' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'nav_item_stretch!' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'nav_wrap_border_type',
            [
                'label' => esc_html__( 'Border Type', 'avas-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__( 'None', 'avas-core' ),
                    'solid' => esc_html__( 'Solid', 'avas-core' ),
                    'double' => esc_html__( 'Double', 'avas-core' ),
                    'dotted' => esc_html__( 'Dotted', 'avas-core' ),
                    'dashed' => esc_html__( 'Dashed', 'avas-core' ),
                    'groove' => esc_html__( 'Groove', 'avas-core' ),
                ],
                'default' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-nav' => 'border-style: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'nav_wrap_border_width',
            [
                'label' => esc_html__( 'Border Width', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'default' => [
                    'top' => 1,
                    'right' => 1,
                    'bottom' => 1,
                    'left' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-nav' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'nav_wrap_border_type!' => 'none',
                ],
            ]
        );

        $this->add_control(
            'nav_wrap_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'default' => [
                    'top' => 3,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-nav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->end_controls_section(); // End Controls Section

        // Styles ====================
        // Section: Nav Item ---------
        $this->start_controls_section(
            'section_nav_item',
            [
                'label' => esc_html__( 'Navigation Item', 'avas-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->start_controls_tabs( 'nav_item_style' );

        $this->start_controls_tab(
            'nav_item_normal',
            [
                'label' => esc_html__( 'Normal', 'avas-core' ),
            ]
        );

        $this->add_control(
            'nav_item_color',
            [
                'label' => esc_html__( 'Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-nav-item i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tx-onepage-nav-item svg' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_item_bg_color',
            [
                'label' => esc_html__( 'Backgound Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-nav-item i' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .tx-onepage-nav-item svg' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_item_border_color',
            [
                'label' => esc_html__( 'Border Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#E8E8E8',
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-nav-item i' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .tx-onepage-nav-item svg' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'nav_item_box_shadow',
                'selector' => '{{WRAPPER}} .tx-onepage-nav-item i',
                'selector' => '{{WRAPPER}} .tx-onepage-nav-item svg',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'nav_item_hover',
            [
                'label' => esc_html__( 'Hover', 'avas-core' ),
            ]
        );

        $this->add_control(
            'nav_item_hover_color',
            [
                'label' => esc_html__( 'Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFEC00',
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-nav-item:hover i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tx-onepage-active-item i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tx-onepage-nav-item:hover svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .tx-onepage-active-item svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_item_hover_bg_color',
            [
                'label' => esc_html__( 'Backgound Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-nav-item:hover i' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .tx-onepage-active-item i' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .tx-onepage-nav-item:hover svg' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .tx-onepage-active-item svg' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_item_hover_border_color',
            [
                'label' => esc_html__( 'Border Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#E8E8E8',
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-nav-item:hover i' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .tx-onepage-active-item i' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .tx-onepage-nav-item:hover svg' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .tx-onepage-active-item svg' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'nav_item_hover_box_shadow',
                'selector' => '{{WRAPPER}} .tx-onepage-nav-item:hover i, {{WRAPPER}} .tx-onepage-active-item i, {{WRAPPER}} .tx-onepage-nav-item:hover svg, {{WRAPPER}} .tx-onepage-active-item svg',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'nav_item_transition_duration',
            [
                'label' => esc_html__( 'Transition Duration', 'avas-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 0.1,
                'min' => 0,
                'max' => 5,
                'step' => 0.1,
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-nav-item' => 'transition-duration: {{VALUE}}s',
                    '{{WRAPPER}} .tx-onepage-nav-item i' => 'transition-duration: {{VALUE}}s',
                    '{{WRAPPER}} .tx-onepage-nav-item svg' => 'transition-duration: {{VALUE}}s',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'nav_item_icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 17,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-nav-item i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tx-onepage-nav-item svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'nav_item_icon_size_active',
            [
                'label' => esc_html__( 'Active Icon Size', 'avas-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 1.5,
                'min' => 1,
                'max' => 2,
                'step' => 0.1,
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-active-item i' => 'transform: scale({{SIZE}}); -webkit-transform: scale({{SIZE}});',
                    '{{WRAPPER}} .tx-onepage-active-item i:before' => 'transform: scale({{SIZE}}); -webkit-transform: scale({{SIZE}});',
                    '{{WRAPPER}} .tx-onepage-active-item svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'nav_item_highlight' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_item_padding',
            [
                'label' => esc_html__( 'Padding', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 3,
                    'right' => 3,
                    'bottom' => 3,
                    'left' => 3,
                ],
                'size_units' => [ 'px', ],
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-nav-item i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tx-onepage-nav-item svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'nav_item_border_type',
            [
                'label' => esc_html__( 'Border Type', 'avas-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__( 'None', 'avas-core' ),
                    'solid' => esc_html__( 'Solid', 'avas-core' ),
                    'double' => esc_html__( 'Double', 'avas-core' ),
                    'dotted' => esc_html__( 'Dotted', 'avas-core' ),
                    'dashed' => esc_html__( 'Dashed', 'avas-core' ),
                    'groove' => esc_html__( 'Groove', 'avas-core' ),
                ],
                'default' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-nav-item i' => 'border-style: {{VALUE}};',
                    '{{WRAPPER}} .tx-onepage-nav-item svg' => 'border-style: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'nav_item_border_width',
            [
                'label' => esc_html__( 'Border Width', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'default' => [
                    'top' => 1,
                    'right' => 1,
                    'bottom' => 1,
                    'left' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-nav-item i' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tx-onepage-nav-item svg' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'nav_item_border_type!' => 'none',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_item_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-onepage-nav-item i' => 'border-radius: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tx-onepage-nav-item svg' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->end_controls_section(); // End Controls Section

        // Styles ======================
        // Section: Nav Tooltip --------
        $this->add_section_nav_tooltip();

    }

    protected function render() {
        // Get Settings
        $settings = $this->get_settings();

        echo '<div class="tx-onepage-nav" data-speed="'. esc_attr($settings['nav_item_scroll_speed']) .'" data-highlight="'. esc_attr($settings['nav_item_highlight']) .'">';
        
        // Nav Items
        foreach ( $settings['nav_items'] as $item ) {
            echo '<div class="tx-onepage-nav-item elementor-repeater-item-'. esc_attr($item['_id']) .'">';
                echo '<a href="#'. esc_attr($item['nav_item_id']) .'">';
                    echo ( 'yes' === $settings['nav_item_show_tooltip'] ) ? '<span class="tx-onepage-tooltip">'. esc_html($item['nav_item_tooltip']) .'</span>' : '';
                    \Elementor\Icons_Manager::render_icon( $item['nav_item_icon'] );
                echo '</a>';
            echo '</div>';
        }
        
        echo '</div>';
    }
}