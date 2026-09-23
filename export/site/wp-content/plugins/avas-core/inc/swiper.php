<?php
namespace AvasElements;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;
use AvasElements\TX_Helper;


defined('ABSPATH') || die();

trait Swiper_Controls {

	//Carousel Settings Controls
	protected function register_carousel_settings_controls() {
		$this->start_controls_section(
			'section_carousel_settings',
			[
				'label' => esc_html__('Carousel Settings', 'inbiz-core'),
			]
		);
		$this->add_responsive_control(
            'columns',
            [
                'label'          => esc_html__('Columns', 'inbiz-core'),
                'type'           => Controls_Manager::SELECT,
                'default'        => 3,
                'tablet_default' => 2,
                'mobile_default' => 1,
                'options'        => [
                    1 => '1',
                    2 => '2',
                    3 => '3',
                    4 => '4',
                    5 => '5',
                    6 => '6',
                ],
            ]
        );

        $this->add_control(
            'item_gap',
            [
                'label'   => esc_html__('Item Gap', 'inbiz-core'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 20,
                ],
                'range'   => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
            ]
        );

        $this->add_control(
            'item_match_height',
            [
                'label'        => esc_html__('Item Match Height', 'inbiz-core'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'no',
                'prefix_class' => 'tx-item-match-height-',
                'render_type' => 'template'
            ]
        );
		$this->add_control(
			'skin',
			[
				'label'        => esc_html__('Layout', 'inbiz-core'),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'carousel',
				'options'      => [
					'carousel'  => esc_html__('Carousel', 'inbiz-core'),
					'coverflow' => esc_html__('Coverflow', 'inbiz-core'),
				],
				'render_type'  => 'template',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'coverflow_toggle',
			[
				'label'        => esc_html__('Coverflow Effect', 'inbiz-core'),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'return_value' => 'yes',
				'condition'    => [
					'skin' => 'coverflow'
				]
			]
		);

		$this->start_popover();

		$this->add_control(
			'coverflow_rotate',
			[
				'label'       => esc_html__('Rotate', 'inbiz-core'),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [
					'size' => 50,
				],
				'range'       => [
					'px' => [
						'min'  => -360,
						'max'  => 360,
						'step' => 5,
					],
				],
				'condition'   => [
					'coverflow_toggle' => 'yes'
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'coverflow_stretch',
			[
				'label'       => esc_html__('Stretch', 'inbiz-core'),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [
					'size' => 0,
				],
				'range'       => [
					'px' => [
						'min'  => 0,
						'step' => 10,
						'max'  => 100,
					],
				],
				'condition'   => [
					'coverflow_toggle' => 'yes'
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'coverflow_modifier',
			[
				'label'       => esc_html__('Modifier', 'inbiz-core'),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [
					'size' => 1,
				],
				'range'       => [
					'px' => [
						'min'  => 1,
						'step' => 1,
						'max'  => 10,
					],
				],
				'condition'   => [
					'coverflow_toggle' => 'yes'
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'coverflow_depth',
			[
				'label'       => esc_html__('Depth', 'inbiz-core'),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [
					'size' => 100,
				],
				'range'       => [
					'px' => [
						'min'  => 0,
						'step' => 10,
						'max'  => 1000,
					],
				],
				'condition'   => [
					'coverflow_toggle' => 'yes'
				],
				'render_type' => 'template',
			]
		);

		$this->end_popover();

		$this->add_control(
			'hr_005',
			[
				'type'      => Controls_Manager::DIVIDER,
				'condition' => [
					'skin' => 'coverflow'
				]
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'   => esc_html__('Autoplay', 'inbiz-core'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',

			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'     => esc_html__('Autoplay Speed', 'inbiz-core'),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'pauseonhover',
			[
				'label' => esc_html__('Pause on Hover', 'inbiz-core'),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_responsive_control(
			'slides_to_scroll',
			[
				'type'           => Controls_Manager::SELECT,
				'label'          => esc_html__('Slides to Scroll', 'inbiz-core'),
				'default'        => 1,
				'tablet_default' => 1,
				'mobile_default' => 1,
				'options'        => [
					1 => '1',
					2 => '2',
					3 => '3',
					4 => '4',
					5 => '5',
					6 => '6',
				],
			]
		);

		$this->add_control(
			'centered_slides',
			[
				'label'       => esc_html__('Center Slide', 'inbiz-core'),
				'description' => esc_html__('Use even items from Layout > Columns settings for better preview.', 'inbiz-core'),
				'type'        => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'grab_cursor',
			[
				'label' => esc_html__('Grab Cursor', 'inbiz-core'),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'free_mode',
			[
				'label' => esc_html__('Drag Free Mode', 'inbiz-core'),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'loop',
			[
				'label'   => esc_html__('Loop', 'inbiz-core'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',

			]
		);

		$this->add_control(
			'speed',
			[
				'label'   => esc_html__('Animation Speed (ms)', 'inbiz-core'),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 500,
				],
				'range' => [
					'px' => [
						'min'  => 100,
						'max'  => 5000,
						'step' => 50,
					],
				],
			]
		);

		$this->add_control(
			'observer',
			[
				'label'       => esc_html__('Observer', 'inbiz-core'),
				'description' => esc_html__('When you use carousel in any hidden place (in tabs, accordion etc) keep it yes.', 'inbiz-core'),
				'type'        => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'show_hidden_item',
			[
				'label' => esc_html__('Show Hidden Item', 'inbiz-core'),
				'type'  => Controls_Manager::SWITCHER,
				'prefix_class' => 'tx-show-hidden-item-',
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'hidden_item_opacity',
			[
				'label' => esc_html__('Hidden Item Opacity', 'inbiz-core'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0.1,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'default' => [
                    'size' => 0.5,
                ],
				'selectors' => [
					'{{WRAPPER}} .swiper-slide:not(.swiper-slide-visible)' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'show_hidden_item' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	//Navigation Controls
	protected function register_navigation_controls() {

		// Navigation Controls
        $this->start_controls_section(
            'section_content_navigation',
            [
                'label' => esc_html__('Navigation', 'inbiz-core'),
            ]
        );

		$this->add_control(
			'navigation',
			[
				'label'        => esc_html__('Navigation', 'inbiz-core'),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'arrows',
				'options'      => [
					'arrows'          => esc_html__('Arrows', 'inbiz-core'),
					'dots'            => esc_html__('Dots', 'inbiz-core'),
					'none'            => esc_html__('None', 'inbiz-core'),
				],
				'render_type'  => 'template',
			]
		);
		$this->add_responsive_control(
			'dots_nnx_position',
			[
				'label'          => esc_html__('Dots Horizontal Offset', 'inbiz-core'),
				'type'           => Controls_Manager::SLIDER,
				'default'        => [
					'size' => 0,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'range'          => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions'     => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'dots',
						],
						[
							'name'     => 'dots_position',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
				'selectors'      => [
					'{{WRAPPER}} .tx-dots-container .swiper-pagination-bullets' => 'margin-left: {{SIZE}}px;' 
				],
			]
		);

		$this->add_responsive_control(
			'dots_nny_position',
			[
				'label'          => esc_html__('Dots Vertical Offset', 'inbiz-core'),
				'type'           => Controls_Manager::SLIDER,
				'default'        => [
					'size' => 30,
				],
				'tablet_default' => [
					'size' => 30,
				],
				'mobile_default' => [
					'size' => 30,
				],
				'range'          => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions'     => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'dots',
						],
						[
							'name'     => 'dots_position',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tx-dots-container .swiper-pagination-bullets' => 'margin-bottom: {{SIZE}}px;' 
				],
			]
		);
		$this->add_control(
			'dynamic_bullets',
			[
				'label'     => esc_html__('Dynamic Bullets?', 'inbiz-core'),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'navigation' => ['dots'],
				],
			]
		);

		$this->add_control(
			'show_scrollbar',
			[
				'label' => esc_html__('Show Scrollbar?', 'inbiz-core'),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label'     => esc_html__('Arrows Position', 'inbiz-core'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => TX_Helper::navigation_position(),
				'condition' => [
					'navigation' => 'arrows',
				],

			]
		);
		$this->add_responsive_control(
			'arrows_horizontal_offset',
			[
				'label'          => esc_html__('Arrows Horizontal Offset', 'inbiz-core'),
				'type'           => Controls_Manager::SLIDER,
				'default'        => [
					'size' => 0,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'range'          => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
					],
				],
				'conditions'     => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows',
						],
						[
							'name'     => 'arrows_position',
							'operator' => '!=',
							'value'    => 'center',
						],
						[
							'name'     => 'arrows_position',
							'operator' => '!=',
							'value'    => 'top-center',
						],
						[
							'name'     => 'arrows_position',
							'operator' => '!=',
							'value'    => 'bottom-center',
						],
					],
				],
				'selectors'      => [
					'{{WRAPPER}} .tx-nav-position-top-left, {{WRAPPER}} .tx-nav-position-center-left, {{WRAPPER}} .tx-nav-position-bottom-left' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .tx-nav-position-top-right, {{WRAPPER}} .tx-nav-position-center-right, {{WRAPPER}} .tx-nav-position-bottom-right' => 'right: {{SIZE}}px;',
				],
			]
		);
		$this->add_responsive_control(
			'arrows_horizontal_offset_center_only',
			[
				'label'      => esc_html__('Arrows Horizontal Offset', 'inbiz-core'),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => -40,
				],
				'range'      => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .tx-nav-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .tx-nav-next' => 'right: {{SIZE}}px;',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows',
						],
						[
							'name'  => 'arrows_position',
							'value' => 'center',
						],
					],
				],
			]
		);
		$this->add_responsive_control(
			'arrows_vertical_offset',
			[
				'label'          => esc_html__('Arrows Vertical Offset', 'inbiz-core'),
				'type'           => Controls_Manager::SLIDER,
				'default'        => [
					'size' => 0,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'range'          => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
					],
				],
				'selectors'      => [
					'{{WRAPPER}} .tx-nav-position-top-left, {{WRAPPER}} .tx-nav-position-top-center, {{WRAPPER}} .tx-nav-position-top-right, {{WRAPPER}} .tx-nav-position-center-left' => 'top: {{SIZE}}px;',
					'{{WRAPPER}} .tx-nav-position-bottom-left, {{WRAPPER}} .tx-nav-position-bottom-center, {{WRAPPER}} .tx-nav-position-bottom-right, {{WRAPPER}} .tx-nav-position-center-right' => 'bottom: {{SIZE}}px;'
				],
				'conditions'     => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows',
						],
						[
							'name'     => 'arrows_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);
		$this->add_responsive_control(
			'arrows_space',
			[
				'label'     => esc_html__('Space Between Arrows', 'inbiz-core'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tx-nav-prev' => 'margin-right: {{SIZE}}px;',
					'{{WRAPPER}} .tx-nav-next' => 'margin-left: {{SIZE}}px;',
				],
				'conditions'     => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'arrows',
						],
						[
							'name'     => 'arrows_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'nav_arrows_icon',
			[
				'label'     => esc_html__('Arrows Icon', 'inbiz-core'),
				'type'      => Controls_Manager::SELECT,
				'default'   => '0',
				'options'   => [
					'0'        => esc_html__('Default', 'inbiz-core'),
					'1'        => esc_html__('Style 1', 'inbiz-core'),
					'2'        => esc_html__('Style 2', 'inbiz-core'),
					'3'        => esc_html__('Style 3', 'inbiz-core'),
					'4'        => esc_html__('Style 4', 'inbiz-core'),
					'5'        => esc_html__('Style 5', 'inbiz-core'),
					'6'        => esc_html__('Style 6', 'inbiz-core'),
					'7'        => esc_html__('Style 7', 'inbiz-core'),
					'8'        => esc_html__('Style 8', 'inbiz-core'),
					'9'        => esc_html__('Style 9', 'inbiz-core'),
					'10'       => esc_html__('Style 10', 'inbiz-core'),
					'11'       => esc_html__('Style 11', 'inbiz-core'),
					'12'       => esc_html__('Style 12', 'inbiz-core'),
					'13'       => esc_html__('Style 13', 'inbiz-core'),
					'14'       => esc_html__('Style 14', 'inbiz-core'),
					'15'       => esc_html__('Style 15', 'inbiz-core'),
					'16'       => esc_html__('Style 16', 'inbiz-core'),
					'17'       => esc_html__('Style 17', 'inbiz-core'),
					'18'       => esc_html__('Style 18', 'inbiz-core'),
					'circle-1' => esc_html__('Style 19', 'inbiz-core'),
					'circle-2' => esc_html__('Style 20', 'inbiz-core'),
					'circle-3' => esc_html__('Style 21', 'inbiz-core'),
					'circle-4' => esc_html__('Style 22', 'inbiz-core'),
					'square-1' => esc_html__('Style 23', 'inbiz-core'),
				],
				'condition' => [
					'navigation' => ['arrows'],
				],
			]
		);

		$this->add_control(
			'hide_arrow_on_mobile',
			[
				'label'     => esc_html__('Hide Arrow on Mobile', 'inbiz-core'),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'navigation' => ['arrows'],
				],
			]
		);
		$this->end_controls_section();
	}

	

	//Navigation Style Controls
	protected function register_navigation_style_controls($name) {
		$this->start_controls_section(
            'swiper_navigation_style_section',
            [
              'label'   => esc_html__( 'Navigation', 'inbiz-core' ),
              'tab'     => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
			'arrows_heading',
			[
				'label'     => esc_html__('ARROWS', 'inbiz-core'),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'navigation' => ['arrows'],
				],
				'separator' => 'before'
			]
		);

		$this->start_controls_tabs('tabs_navigation_arrows_style');

		$this->start_controls_tab(
			'tabs_nav_arrows_normal',
			[
				'label'     => esc_html__('Normal', 'inbiz-core'),
				'condition' => [
					'navigation' => ['arrows'],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label'     => esc_html__('Color', 'inbiz-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tx-nav-prev i, {{WRAPPER}} .tx-nav-next i' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => ['arrows'],
				],
			]
		);

		$this->add_control(
			'arrows_background',
			[
				'label'     => esc_html__('Background', 'inbiz-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tx-nav-prev, {{WRAPPER}} .tx-nav-next' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => ['arrows'],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'nav_arrows_border',
				'selector'  => '{{WRAPPER}} .tx-nav-prev, {{WRAPPER}} .tx-nav-next',
				'condition' => [
					'navigation' => ['arrows'],
				],
			]
		);

		$this->add_responsive_control(
			'border_radius',
			[
				'label'      => esc_html__('Border Radius', 'inbiz-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .tx-nav-prev, {{WRAPPER}} .tx-nav-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'navigation' => ['arrows'],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_padding',
			[
				'label'      => esc_html__('Padding', 'inbiz-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .tx-nav-prev, {{WRAPPER}} .tx-nav-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'navigation' => ['arrows'],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_size',
			[
				'label'     => esc_html__('Size', 'inbiz-core'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tx-nav-prev i,
            {{WRAPPER}} .tx-nav-next i' => 'font-size: {{SIZE || 24}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => ['arrows'],
				],
			]
		);

		

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'arrows_box_shadow',
				'selector' => '{{WRAPPER}} .tx-nav-prev, {{WRAPPER}} .tx-nav-next',
				'condition' => [
					'navigation' => ['arrows'],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_nav_arrows_hover',
			[
				'label'     => esc_html__('Hover', 'inbiz-core'),
				'condition' => [
					'navigation' => ['arrows'],
				],
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[
				'label'     => esc_html__('Color', 'inbiz-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tx-nav-prev:hover i, {{WRAPPER}} .tx-nav-next:hover i' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => ['arrows'],
				],
			]
		);

		$this->add_control(
			'arrows_hover_background',
			[
				'label'     => esc_html__('Background', 'inbiz-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tx-nav-prev:hover, {{WRAPPER}} .tx-nav-next:hover' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => ['arrows'],
				],
			]
		);

		$this->add_control(
			'nav_arrows_hover_border_color',
			[
				'label'     => esc_html__('Border Color', 'inbiz-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tx-nav-prev:hover, {{WRAPPER}} .tx-nav-next:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'nav_arrows_border_border!' => '',
					'navigation!'               => ['dots', 'progressbar', 'none'],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'arrows_hover_box_shadow',
				'selector' => '{{WRAPPER}} .tx-nav-prev:hover, {{WRAPPER}} .tx-nav-next:hover',
				'condition' => [
					'navigation' => ['arrows'],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'dots_heading',
			[
				'label'     => esc_html__('DOTS', 'inbiz-core'),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'navigation' => ['dots'],
				],
				'separator' => 'before'
			]
		);

		$this->start_controls_tabs('tabs_navigation_dots_style');

		$this->start_controls_tab(
			'tabs_nav_dots_normal',
			[
				'label'     => esc_html__('Normal', 'inbiz-core'),
				'condition' => [
					'navigation' => ['dots'],
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label'     => esc_html__('Color', 'inbiz-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => ['dots'],
				],
			]
		);

		$this->add_responsive_control(
			'dots_space_between',
			[
				'label'     => esc_html__('Space Between', 'inbiz-core'),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}}' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => ['dots'],
				],
			]
		);

		$this->add_responsive_control(
			'dots_size',
			[
				'label'     => esc_html__('Size', 'inbiz-core'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 5,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => ['dots'],
					'advanced_dots_size' => ''
				],
			]
		);

		$this->add_control(
			'advanced_dots_size',
			[
				'label'     => esc_html__('Advanced Size', 'inbiz-core'),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'navigation' => ['dots'],
				],
			]
		);

		$this->add_responsive_control(
			'advanced_dots_width',
			[
				'label'     => esc_html__('Width(px)', 'inbiz-core'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => ['dots'],
					'advanced_dots_size' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'advanced_dots_height',
			[
				'label'     => esc_html__('Height(px)', 'inbiz-core'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => ['dots'],
					'advanced_dots_size' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'advanced_dots_radius',
			[
				'label'      => esc_html__('Border Radius', 'inbiz-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => ['dots'],
					'advanced_dots_size' => 'yes'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'dots_box_shadow',
				'selector' => '{{WRAPPER}} .swiper-pagination-bullet',
				'condition' => [
					'navigation' => ['dots'],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_nav_dots_active',
			[
				'label'     => esc_html__('Active', 'inbiz-core'),
				'condition' => [
					'navigation' => ['dots'],
				],
			]
		);

		$this->add_control(
			'active_dot_color',
			[
				'label'     => esc_html__('Color', 'inbiz-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet-active' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => ['dots'],
				],
			]
		);

		$this->add_responsive_control(
			'active_dots_size',
			[
				'label'     => esc_html__('Size', 'inbiz-core'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 5,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet-active' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
					// '{{WRAPPER}}' => '--ep-swiper-dots-active-height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => ['dots'],
					'advanced_dots_size' => ''
				],
			]
		);

		$this->add_responsive_control(
			'active_advanced_dots_width',
			[
				'label'     => esc_html__('Width(px)', 'inbiz-core'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => ['dots'],
					'advanced_dots_size' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'active_advanced_dots_height',
			[
				'label'     => esc_html__('Height(px)', 'inbiz-core'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet-active' => 'height: {{SIZE}}{{UNIT}};',
					// '{{WRAPPER}}' => '--ep-swiper-dots-active-height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => ['dots'],
					'advanced_dots_size' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'active_advanced_dots_radius',
			[
				'label'      => esc_html__('Border Radius', 'inbiz-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .swiper-pagination-bullet-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => ['dots'],
					'advanced_dots_size' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'active_advanced_dots_align',
			[
				'label'   => esc_html__('Alignment', 'inbiz-core'),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__('Top', 'inbiz-core'),
						'icon'  => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__('Center', 'inbiz-core'),
						'icon'  => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => esc_html__('Bottom', 'inbiz-core'),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--ep-swiper-dots-align: {{VALUE}};',
				],
				'condition' => [
					'navigation' => ['dots'],
					'advanced_dots_size' => 'yes'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'dots_active_box_shadow',
				'selector' => '{{WRAPPER}} .swiper-pagination-bullet-active',
				'condition' => [
					'navigation' => ['dots'],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		

		$this->add_control(
			'hr_4',
			[
				'type'      => Controls_Manager::DIVIDER,
				'condition' => [
					'show_scrollbar' => 'yes'
				],
			]
		);

		$this->add_control(
			'scrollbar_heading',
			[
				'label'     => esc_html__('SCROLLBAR', 'inbiz-core'),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'show_scrollbar' => 'yes'
				],
			]
		);

		$this->add_control(
			'hr_14',
			[
				'type'      => Controls_Manager::DIVIDER,
				'condition' => [
					'show_scrollbar' => 'yes'
				],
			]
		);

		$this->add_control(
			'scrollbar_color',
			[
				'label'     => esc_html__('Bar Color', 'inbiz-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-scrollbar' => 'background: {{VALUE}}',
				],
				'condition' => [
					'show_scrollbar' => 'yes'
				],
			]
		);

		$this->add_control(
			'scrollbar_drag_color',
			[
				'label'     => esc_html__('Drag Color', 'inbiz-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-scrollbar .swiper-scrollbar-drag' => 'background: {{VALUE}}',
				],
				'condition' => [
					'show_scrollbar' => 'yes'
				],
			]
		);

		$this->add_control(
			'scrollbar_height',
			[
				'label'     => esc_html__('Height', 'inbiz-core'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-container-horizontal > .swiper-scrollbar, {{WRAPPER}} .swiper-horizontal > .swiper-scrollbar' => 'height: {{SIZE}}px;',
				],
				'condition' => [
					'show_scrollbar' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'scrollbar_vertical_offset',
			[
				'label'     => esc_html__('Scrollbar Offset', 'inbiz-core'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-container-horizontal > .swiper-scrollbar, {{WRAPPER}} .swiper-horizontal > .swiper-scrollbar' => 'bottom: {{SIZE}}px;',
				],
				'condition' => [
					'show_scrollbar' => 'yes'
				],
			]
		);
		$this->end_controls_section();
	}


	protected function render_swiper_header_attribute($name) {
		$id = 'tx-' . $name . '-' . $this->get_id();
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute('carousel', 'id', $id);

		$elementor_vp_lg = get_option('elementor_viewport_lg');
		$elementor_vp_md = get_option('elementor_viewport_md');
		$viewport_lg = !empty($elementor_vp_lg) ? $elementor_vp_lg - 1 : 1023;
		$viewport_md = !empty($elementor_vp_md) ? $elementor_vp_md - 1 : 767;
		$pagination_type = 'bullets';

		// if ('arrows' == $settings['navigation']) {
		// 	$this->add_render_attribute('carousel', 'class', 'bdt-arrows-align-' . $settings['arrows_position']);
		// } elseif ('dots' == $settings['navigation']) {
		// 	$this->add_render_attribute('carousel', 'class', 'bdt-dots-align-' . $settings['dots_position']);
		// }

		$this->add_render_attribute(
			[
				'carousel' => [
					'data-settings' => [
						wp_json_encode(array_filter([
							"autoplay"              => ("yes" == $settings["autoplay"]) ? ["delay" => $settings["autoplay_speed"]] : false,
							"loop"                  => ($settings["loop"] == "yes") ? true : false,
							"speed"                 => $settings["speed"]["size"],
							"pauseOnHover"          => ("yes" == $settings["pauseonhover"]) ? true : false,
							"slidesPerView"         => isset($settings["columns_mobile"]) ? (int)$settings["columns_mobile"] : 1,
							"slidesPerGroup"        => isset($settings["slides_to_scroll_mobile"]) ? (int)$settings["slides_to_scroll_mobile"] : 1,
							"spaceBetween"          => !empty($settings["item_gap"]["size"]) ? (int)$settings["item_gap"]["size"] : 20,
							"centeredSlides"        => ($settings["centered_slides"] === "yes") ? true : false,
							"grabCursor"            => ($settings["grab_cursor"] === "yes") ? true : false,
							"freeMode"              => ($settings["free_mode"] === "yes") ? true : false,
							"effect"                => $settings["skin"],
							"observer"              => ($settings["observer"]) ? true : false,
							"observeParents"        => ($settings["observer"]) ? true : false,
							"watchSlidesVisibility" => ($settings["show_hidden_item"]) ? true : false,
							"breakpoints"     => [
								(int)$viewport_md => [
									"slidesPerView"  => isset($settings["columns_tablet"]) ? (int)$settings["columns_tablet"] : 2,
									"spaceBetween"   => !empty($settings["item_gap"]["size"]) ? (int)$settings["item_gap"]["size"] : 20,
									"slidesPerGroup" => isset($settings["slides_to_scroll_tablet"]) ? (int)$settings["slides_to_scroll_tablet"] : 1,
								],
								(int)$viewport_lg => [
									"slidesPerView"  => isset($settings["columns"]) ? (int)$settings["columns"] : 3,
									"spaceBetween"   => !empty($settings["item_gap"]["size"]) ? (int)$settings["item_gap"]["size"] : 20,
									"slidesPerGroup" => isset($settings["slides_to_scroll"]) ? (int)$settings["slides_to_scroll"] : 1,
								]
							],
							"navigation"      => [
								"nextEl" => "#" . $id . " .tx-nav-next",
								"prevEl" => "#" . $id . " .tx-nav-prev",
							],
							"pagination"      => [
								"el"             => "#" . $id . " .swiper-pagination",
								"type"           => $pagination_type,
								"clickable"      => "true",
								'dynamicBullets' => ("yes" == $settings["dynamic_bullets"]) ? true : false,
							],
							"scrollbar"       => [
								"el"   => "#" . $id . " .swiper-scrollbar",
								"hide" => "true",
							],
							'coverflowEffect' => [
								'rotate'       => ("yes" == $settings["coverflow_toggle"]) ? $settings["coverflow_rotate"]["size"] : 50,
								'stretch'      => ("yes" == $settings["coverflow_toggle"]) ? $settings["coverflow_stretch"]["size"] : 0,
								'depth'        => ("yes" == $settings["coverflow_toggle"]) ? $settings["coverflow_depth"]["size"] : 100,
								'modifier'     => ("yes" == $settings["coverflow_toggle"]) ? $settings["coverflow_modifier"]["size"] : 1,
								'slideShadows' => true,
							],
							"watchSlidesProgress" => true,
						]))
					]
				]
			]
		);

		$swiper_class = Plugin::$instance->experiments->is_feature_active( 'e_swiper_latest' ) ? 'swiper' : 'swiper-container';
		$this->add_render_attribute('swiper', 'class', 'swiper-carousel ' . $swiper_class);
	}

	function render_navigation() {
		$settings = $this->get_settings_for_display();
		$hide_arrow_on_mobile = $settings['hide_arrow_on_mobile'] ? 'tx-md-none' : '';
		$this->add_render_attribute(
            [
                'tx-navigation' => [
                    'class' => [
                        'tx-navigation',
                        'tx-nav-position-'.$settings['arrows_position'],
                        $hide_arrow_on_mobile
                    ]
                ]
            ]
        );

		if ('arrows' == $settings['navigation']) : ?>
			<div <?php $this->print_render_attribute_string('tx-navigation'); ?>>
				<div class="tx-nav-prev tx-nav-arrow">
					<i class="tx-arrow-left-<?php echo esc_attr($settings['nav_arrows_icon']); ?>" aria-hidden="true"></i>
				</div>
				<div class="tx-nav-next tx-nav-arrow">
					<i class="tx-arrow-right-<?php echo esc_attr($settings['nav_arrows_icon']); ?>" aria-hidden="true"></i>
				</div>
			</div>
		<?php
		endif;
	}

	function render_pagination() {
		$settings = $this->get_settings_for_display();

		if ('dots' == $settings['navigation']) : ?>
			<div class="tx-dots-container">
				<div class="swiper-pagination"></div>
			</div>

		<?php
		endif;
	}

	function render_footer() {
		$settings = $this->get_settings_for_display();

	?>
		</div>
		<?php
		if ('yes' === $settings['show_scrollbar']) : ?>
			<div class="swiper-scrollbar"></div>
		<?php
		endif; ?>
		</div>

			<?php $this->render_pagination(); ?>
			<?php $this->render_navigation(); ?>


		</div>

<?php
	}
}
