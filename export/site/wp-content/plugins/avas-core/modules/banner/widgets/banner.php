<?php
namespace AvasElements\Modules\Banner\Widgets;

use elementor\Widget_Base;
use elementor\Controls_Manager;
use elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use elementor\Group_Control_Border;
use elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use elementor\Utils;
use AvasElements\TX_Helper;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Banner extends Widget_Base {

	public function get_name() {
		return 'avas-banner';
	}

	public function get_title() {
		return esc_html__( 'Avas Banner', 'avas-core' );
	}

	public function get_icon() {
		return 'eicon-banner';
	}

	public function get_categories() {
		return [ 'avas-elements' ];
	}

	public function get_keywords() {
		return [ 'image', 'box', 'banner', 'promo' ];
	}

	public function get_style_depends() {
		return [ 'tx-banner'];
	}

	protected function register_controls() {
		// Section: Image ------------
		$this->start_controls_section(
			'section_banner',
			[
				'label' => esc_html__( 'Banner', 'avas-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Image', 'avas-core' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image_size',
				'default' => 'full',
			]
		);
		$this->add_control(
			'image_bg_size',
			[
				'label' => esc_html__( 'Display Size', 'avas-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'cover' => esc_html__( 'Cover', 'avas-core' ),
					'contain' => esc_html__( 'Contain', 'avas-core' ),
					'auto' => esc_html__( 'Auto', 'avas-core' ),
				],
				'default' => 'cover',
				'condition' => [
					'image[url]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .tx-banner-bg-image' => 'background-size: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'image_bg_repeat',
			[
				'label' => esc_html__( 'Repeat', 'avas-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'no-repeat' => esc_html__( 'No Repeat', 'avas-core' ),
					'repeat' => esc_html__( 'Repeat', 'avas-core' ),
					'repeat-x' => esc_html__( 'Repeat-X', 'avas-core' ),
					'repeat-y' => esc_html__( 'Repeat-Y', 'avas-core' ),
				],
				'default' => 'no-repeat',
				'condition' => [
					'image[url]!' => '',
					'image_bg_size' => 'contain',
				],
				'selectors' => [
					'{{WRAPPER}} .tx-banner-bg-image' => 'background-repeat: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'image_bg_position',
			[
				'label' => esc_html__( 'Position', 'avas-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
				'selectors' => [
					'{{WRAPPER}} .tx-banner-bg-image' => 'background-position: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->end_controls_section();
		
		
		

		// Section: Content ----------
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'avas-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
            'content_icon_type',
            [
                'label' => esc_html__( 'Select Icon Type', 'avas-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__( 'None', 'avas-core' ),
                    'icon' => esc_html__( 'Icon', 'avas-core' ),
                    'image' => esc_html__( 'Image', 'avas-core' ),
                ],
            ]
        );

		$this->add_control(
			'content_image',
			[
				'label' => esc_html__( 'Image', 'avas-core' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'content_icon_type' => 'image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'content_image_size',
				'default' => 'full',
				'condition' => [
					'content_icon_type' => 'image',
				],
			]
		);

		$this->add_control(
			'content_icon',
			[
				'label' => esc_html__( 'Icon', 'avas-core' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'far fa-smile-beam',
                    'library' => 'fa-solid',
                ],
				'skin' => 'inline',
				'label_block' => false,
				'condition' => [
					'content_icon_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'content_subtitle',
			[
				'label' => esc_html__( 'Sub Title', 'avas-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => 'Explore',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'content_subtitle_tag',
			[
				'label' => esc_html__( 'Sub Title HTML Tag', 'avas-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => TX_Helper::title_html_tags(),
				'default' => 'h5',
			]
		);

		$this->add_control(
			'content_title',
			[
				'label' => esc_html__( 'Title', 'avas-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => 'The Banner',
			]
		);

		$this->add_control(
			'content_title_tag',
			[
				'label' => esc_html__( 'Title HTML Tag', 'avas-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => TX_Helper::title_html_tags(),
				'default' => 'h3',
			]
		);

		$this->add_control(
			'content_description',
			[
				 'label' => esc_html__( 'Description', 'avas-core' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'content_link_type',
			[
				'label' => esc_html__( 'Link Type', 'avas-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'avas-core' ),
					'title' => esc_html__( 'Title', 'avas-core' ),
					'btn' => esc_html__( 'Button', 'avas-core' ),
					'box' => esc_html__( 'Full Banner', 'avas-core' ),
				],
				'default' => 'btn',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'content_link',
			[
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'label' => esc_html__( 'Link', 'avas-core' ),
				'placeholder' => esc_html__( 'https://your-link.com', 'avas-core' ),
				'default' => [
					'url' => '#',
				],
				'separator' => 'before',
				'condition' => [
					'content_link_type!' => 'none',
				],
			]
		);

		$this->add_control(
			'content_btn_text',
			[
				'label' => esc_html__( 'Button Text', 'avas-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => 'Click Me',
				'separator' => 'before',
				'condition' => [
					'content_link_type' => ['btn','btn-title'],
				],
			]
		);

		$this->add_control(
			'content_btn_icon',
			[
				'label' => esc_html__( 'Button Icon', 'avas-core' ),
				'type' => Controls_Manager::ICONS,
				'skin' => 'inline',
				'label_block' => false,
				'condition' => [
					'content_link_type' => ['btn','btn-title'],
				],
			]
		);
		$this->add_control(
			'content_btn_icon_position',
			[
				'label' => esc_html__( 'Button Icon Position', 'avas-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'after',
				'options' => [
					'before' => esc_html__( 'Before', 'avas-core' ),
					'after' => esc_html__( 'After', 'avas-core' ),
				],
				'condition' => [
					'content_btn_icon!' => ''
				],
			]
		);

		$this->add_control(
			'content_btn_icon_indent',
			[
				'label' => esc_html__( 'Icon Spacing', 'avas-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'condition' => [
					'content_btn_icon!' => ''
				],
				'selectors' => [
					'{{WRAPPER}} .tx-banner-btn-icon-position-before' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tx-banner-btn-icon-position-after' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section(); // End Controls Section

		$this->start_controls_section(
			'section_badge',
			[
				'label' => esc_html__( 'Badge', 'avas-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'badge_style',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__( 'Style', 'avas-core' ),
				'default' => 'style_1',
				'options' => [
					'none' => esc_html__( 'None', 'avas-core' ),
					'style_1' => esc_html__( 'Style 1', 'avas-core' ),
					'style_2' => esc_html__( 'Style 2', 'avas-core' ),
					'style_3' => esc_html__( 'Style 3', 'avas-core' ),
				],
			]
		);

		$this->add_control(
			'badge_title',
			[
				'label' => esc_html__( ' Badge Text', 'avas-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'SALE',
				'condition' => [
					'badge_style!' => 'none',
				],
			]
		);

        $this->add_responsive_control(
			'badge_style_2_size',
			[
				'label' => esc_html__( 'Size', 'avas-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 60,
				],
				'selectors' => [
					'{{WRAPPER}} .tx-banner-badge-style_2 .tx-banner-badge-inner' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'badge_style' => 'style_2',
					'badge_style!' => 'none',
				],
			]
		);

        $this->add_responsive_control(
			'badge_distance',
			[
				'label' => esc_html__( 'Distance', 'avas-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 80,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .tx-banner-badge-style_1 .tx-banner-badge-inner' => 'margin-top: {{SIZE}}{{UNIT}}; transform: translateY(-50%) translateX(-50%) translateX({{SIZE}}{{UNIT}}) rotate(-45deg);',
					'{{WRAPPER}} .tx-banner-badge-style_3' => 'top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'badge_style!' => [ 'none', 'style_2' ],
				],	
			
			]
		);

		$this->add_control(
            'badge_hr_position',
            [
                'label' => esc_html__( 'Position', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'left',
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
                'condition' => [
					'badge_style!' => 'none',
				],
            ]
        );

		$this->end_controls_section(); // End Controls Section

		// Section: Animation ------------
		$this->start_controls_section(
			'section_animation',
			[
				'label' => esc_html__( 'Animation', 'avas-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'image_animation_section',
			[
				'label' => esc_html__( 'Image Animation', 'avas-core' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'image[url]!' => '',
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'image_animation',
			[
				'label' => esc_html__( 'Select Animation', 'avas-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'avas-core' ),
					'zoom-in' => esc_html__( 'Zoom In', 'avas-core' ),
					'zoom-out' => esc_html__( 'Zoom Out', 'avas-core' ),
					'move-left' => esc_html__( 'Move Left', 'avas-core' ),
					'move-right' => esc_html__( 'Move Right', 'avas-core' ),
					'move-up' => esc_html__( 'Move Top', 'avas-core' ),
					'move-down' => esc_html__( 'Move Bottom', 'avas-core' ),
				],
				'default' => 'zoom-in',
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->add_control(
			'image_animation_duration',
			[
				'label' => esc_html__( 'Animation Duration', 'avas-core' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0.4,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .tx-banner-bg-image' => '-webkit-transition-duration: {{VALUE}}s; transition-duration: {{VALUE}}s;',
					'{{WRAPPER}} .tx-banner-bg-overlay' => '-webkit-transition-duration: {{VALUE}}s;transition-duration: {{VALUE}}s;',
				],
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->add_control(
			'image_animation_delay',
			[
				'label' => esc_html__( 'Animation Delay', 'avas-core' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .tx-banner-bg-image' => '-webkit-transition-delay: {{VALUE}}s;transition-delay: {{VALUE}}s;',
					'{{WRAPPER}} .tx-banner-bg-overlay' => '-webkit-transition-delay: {{VALUE}}s;transition-delay: {{VALUE}}s;',
				],
				'condition' => [
					'image[url]!' => '',
					'image_animation!' => 'none',
				],
			]
		);

		$this->add_control(
			'image_animation_timing',
			[
				'label' => esc_html__( 'Animation Timing', 'avas-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => TX_Helper::tx_animation_timings(),
				'default' => 'ease-default',
				'condition' => [
					'image[url]!' => '',
					'image_animation!' => 'none',
				],
			]
		);

		$this->add_control(
			'hover_animation_section',
			[
				'label' => esc_html__( 'Border Animation', 'avas-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'border_animation',
			[
				'label' => esc_html__( 'Select Animation', 'avas-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'avas-core' ),
					'oscar' => esc_html__( 'Oscar', 'avas-core' ),
					'jazz' => esc_html__( 'Jazz', 'avas-core' ),
					'layla' => esc_html__( 'Layla', 'avas-core' ),
					'bubba' => esc_html__( 'Bubba', 'avas-core' ),
					'romeo' => esc_html__( 'Romeo', 'avas-core' ),
					'chicho' => esc_html__( 'Chicho', 'avas-core' ),
					'apollo' => esc_html__( 'Apollo', 'avas-core' ),
				],
				'default' => 'apollo',
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->add_control(
			'border_animation_duration',
			[
				'label' => esc_html__( 'Animation Duration', 'avas-core' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0.4,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .tx-banner-bg-overlay::after' => '-webkit-transition-duration: {{VALUE}}s;transition-duration: {{VALUE}}s;',
					'{{WRAPPER}} .tx-banner-bg-overlay::before' => '-webkit-transition-duration: {{VALUE}}s;transition-duration: {{VALUE}}s;',
				],
				'condition' => [
					'image[url]!' => '',
					'border_animation!' => 'none',
				],
			]
		);

		$this->add_control(
			'border_animation_delay',
			[
				'label' => esc_html__( 'Animation Delay', 'avas-core' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .tx-banner-bg-overlay::after' => '-webkit-transition-delay: {{VALUE}}s;transition-delay: {{VALUE}}s;',
					'{{WRAPPER}} .tx-banner-bg-overlay::before' => '-webkit-transition-delay: {{VALUE}}s;transition-delay: {{VALUE}}s;',
				],
				'condition' => [
					'image[url]!' => '',
					'border_animation!' => 'none',
				],
			]
		);

		$this->add_control(
			'border_animation_section',
			[
				'label' => esc_html__( 'Hover Border Style', 'avas-core' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'image[url]!' => '',
					'border_animation!' => 'none',
				],
			]
		);

		$this->add_control(
			'border_animation_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__( 'Color', 'avas-core' ),
				'default' => 'rgba(255,255,255,0.4)',
				'selectors' => [
					'{{WRAPPER}} .tx-banner-bg-overlay::before' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .tx-banner-bg-overlay::after' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .tx-border-anim-apollo::before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .tx-border-anim-romeo::before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .tx-border-anim-romeo::after' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'image[url]!' => '',
					'border_animation!' => 'none',
				],
			]
		);

		$this->add_control(
			'border_animation_type',
			[
				'label' => esc_html__( 'Type', 'avas-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'solid' => esc_html__( 'Solid', 'avas-core' ),
					'double' => esc_html__( 'Double', 'avas-core' ),
					'dotted' => esc_html__( 'Dotted', 'avas-core' ),
					'dashed' => esc_html__( 'Dashed', 'avas-core' ),
					'groove' => esc_html__( 'Groove', 'avas-core' ),
				],
				'default' => 'solid',
				'selectors' => [
					'{{WRAPPER}} .tx-border-anim-layla::before' => 'border-top-style: {{VALUE}};border-bottom-style: {{VALUE}};',
					'{{WRAPPER}} .tx-border-anim-layla::after' => 'border-left-style: {{VALUE}};border-right-style: {{VALUE}};',
					'{{WRAPPER}} .tx-border-anim-oscar::before' => 'border-style: {{VALUE}};',
					'{{WRAPPER}} .tx-border-anim-bubba::before' => 'border-top-style: {{VALUE}};border-bottom-style: {{VALUE}};',
					'{{WRAPPER}} .tx-border-anim-bubba::after' => 'border-left-style: {{VALUE}};border-right-style: {{VALUE}};',
					'{{WRAPPER}} .tx-border-anim-chicho::before' => 'border-style: {{VALUE}};',
					'{{WRAPPER}} .tx-border-anim-jazz::after' => 'border-top-style: {{VALUE}};border-bottom-style: {{VALUE}};',
				],
				'condition' => [
					'image[url]!' => '',
					'border_animation!' => [ 'none', 'apollo', 'romeo' ],
				],
			]
		);

		$this->add_control(
			'border_animation_width',
			[
				'label' => esc_html__( 'Width', 'avas-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .tx-banner-bg-overlay::before' => 'border-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tx-banner-bg-overlay::after' => 'border-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tx-border-anim-romeo::before' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tx-border-anim-romeo::after' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'image[url]!' => '',
					'border_animation!' => [ 'none', 'apollo' ],
				],
			]
		);

		$this->add_control(
			'border_animation_distance',
			[
				'label' => esc_html__( 'Distance', 'avas-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .tx-border-anim-layla::before' => 'top: calc({{SIZE}}{{UNIT}} + 20px);right: {{SIZE}}{{UNIT}};bottom: calc({{SIZE}}{{UNIT}} + 20px);left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tx-border-anim-layla::after' => 'top: {{SIZE}}{{UNIT}};right: calc({{SIZE}}{{UNIT}} + 20px);bottom: {{SIZE}}{{UNIT}};left: calc({{SIZE}}{{UNIT}} + 20px);',
					'{{WRAPPER}} .tx-border-anim-oscar::before' => 'top: {{SIZE}}{{UNIT}};right: {{SIZE}}{{UNIT}};bottom: {{SIZE}}{{UNIT}};left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tx-border-anim-bubba::before' => 'top: {{SIZE}}{{UNIT}};right: {{SIZE}}{{UNIT}};bottom: {{SIZE}}{{UNIT}};left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tx-border-anim-bubba::after' => 'top: {{SIZE}}{{UNIT}};right: {{SIZE}}{{UNIT}};bottom: {{SIZE}}{{UNIT}};left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tx-border-anim-chicho::before' => 'top: {{SIZE}}{{UNIT}};right: {{SIZE}}{{UNIT}};bottom: {{SIZE}}{{UNIT}};left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'image[url]!' => '',
					'border_animation!' => [ 'none', 'apollo', 'romeo', 'jazz' ],
				],	
			]
		);

		$this->end_controls_section(); // End Controls Section

		
		// Styles
		// Section: Banner ----------
		$this->start_controls_section(
			'section_style_banner',
			[
				'label' => esc_html__( 'Banner', 'avas-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_overlay_colors' );

		$this->start_controls_tab(
			'tab_overlay_normal_colors',
			[
				'label' => esc_html__( 'Normal', 'avas-core' ),
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__( 'Overlay Color', 'avas-core' ),
				'default' => 'rgba(48, 52, 235, 0.7)',
				'selectors' => [
					'{{WRAPPER}} .tx-banner-bg-overlay' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'bg_css_filters',
				'selector' => '{{WRAPPER}} .tx-banner-bg-image',
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_overlay_hover_colors',
			[
				'label' => esc_html__( 'Hover', 'avas-core' ),
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->add_control(
			'overlay_hover_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__( 'Overlay Color', 'avas-core' ),
				'default' => 'rgba(255, 52, 139, 0.65)',
				'selectors' => [
					'{{WRAPPER}} .tx-banner:hover .tx-banner-bg-overlay' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'bg_css_filters_hover',
				'selector' => '{{WRAPPER}} .tx-banner:hover .tx-banner-bg-image',
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'overlay_blend_mode',
			[
				'label' => esc_html__( 'Blend Mode', 'avas-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'normal',
				'options' => [
					'normal' => esc_html__( 'Normal', 'avas-core' ),
					'multiply' => esc_html__( 'Multiply', 'avas-core' ),
					'screen' => esc_html__( 'Screen', 'avas-core' ),
					'overlay' => esc_html__( 'Overlay', 'avas-core' ),
					'darken' => esc_html__( 'Darken', 'avas-core' ),
					'lighten' => esc_html__( 'Lighten', 'avas-core' ),
					'color-dodge' => esc_html__( 'Color-dodge', 'avas-core' ),
					'color-burn' => esc_html__( 'Color-burn', 'avas-core' ),
					'hard-light' => esc_html__( 'Hard-light', 'avas-core' ),
					'soft-light' => esc_html__( 'Soft-light', 'avas-core' ),
					'difference' => esc_html__( 'Difference', 'avas-core' ),
					'exclusion' => esc_html__( 'Exclusion', 'avas-core' ),
					'hue' => esc_html__( 'Hue', 'avas-core' ),
					'saturation' => esc_html__( 'Saturation', 'avas-core' ),
					'color' => esc_html__( 'Color', 'avas-core' ),
					'luminosity' => esc_html__( 'luminosity', 'avas-core' ),
				],
				'selectors' => [
					'{{WRAPPER}} .tx-banner-bg-overlay' => 'mix-blend-mode: {{VALUE}}',
				],
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'banner_height',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Banner Height', 'avas-core' ),
				'size_units' => [ 'px', 'vh' ],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 1000,
					],
					'vh' => [
						'min' => 20,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 280,
				],
				'selectors' => [
					'{{WRAPPER}} .tx-banner-content' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);
 
		$this->end_controls_section(); // End Controls Section
 

		// Section: Content ----------
		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content', 'avas-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		

		$this->start_controls_tabs( 'tabs_content_colors' );

		$this->start_controls_tab(
			'tab_content_normal_colors',
			[
				'label' => esc_html__( 'Normal', 'avas-core' ),
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'content_bg_color',
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'color' => [
						'default' => '#212121',
					],
				],
				'selector' => '{{WRAPPER}} .tx-banner-content',

			]
		);

		$this->add_control(
			'content_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'avas-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tx-banner-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'content_subtitle_color', 
			[
				'label' => esc_html__( 'Sub Title Color', 'avas-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tx-banner-subtitle' => 'color: {{VALUE}}',
					'{{WRAPPER}} .tx-banner-subtitle a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'content_title_color',
			[
				'label' => esc_html__( 'Title Color', 'avas-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tx-banner-title' => 'color: {{VALUE}}',
					'{{WRAPPER}} .tx-banner-title a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'content_description_color',
			[
				'label' => esc_html__( 'Description Color', 'avas-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tx-banner-description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_content_hover_colors',
			[
				'label' => esc_html__( 'Hover', 'avas-core' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'content_hover_bg_color',
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'color' => [
						'default' => '#ddb34f',
					],
				],
				'selector' => '{{WRAPPER}} .tx-banner:hover .tx-banner-content',
			]
		);

		$this->add_control(
			'content_hover_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'avas-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tx-banner:hover .tx-banner-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'content_hover_subtitle_color',
			[
				'label' => esc_html__( 'Title Color', 'avas-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tx-banner:hover .tx-banner-subtitle' => 'color: {{VALUE}}',
					'{{WRAPPER}} .tx-banner:hover .tx-banner-subtitle a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'content_hover_title_color',
			[
				'label' => esc_html__( 'Title Color', 'avas-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tx-banner:hover .tx-banner-title' => 'color: {{VALUE}}',
					'{{WRAPPER}} .tx-banner:hover .tx-banner-title a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'content_hover_description_color',
			[
				'label' => esc_html__( 'Description Color', 'avas-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tx-banner:hover .tx-banner-description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'content_trans_duration',
			[
				'label' => esc_html__( 'Transition Duration', 'avas-core' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0.3,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .tx-banner-content' => '-webkit-transition-duration: {{VALUE}}s; transition-duration: {{VALUE}}s;',
					'{{WRAPPER}} .tx-banner-icon i' => '-webkit-transition-duration: {{VALUE}}s; transition-duration: {{VALUE}}s;',
					'{{WRAPPER}} .tx-banner-title span' => '-webkit-transition-duration: {{VALUE}}s; transition-duration: {{VALUE}}s;',
					'{{WRAPPER}} .tx-banner-title a' => '-webkit-transition-duration: {{VALUE}}s; transition-duration: {{VALUE}}s;',
					'{{WRAPPER}} .tx-banner-description p' => '-webkit-transition-duration: {{VALUE}}s; transition-duration: {{VALUE}}s;',
				],
			]
		);

		

		$this->add_responsive_control(
			'content_padding',
			[
				'label' => esc_html__( 'Padding', 'avas-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 30,
					'right' => 30,
					'bottom' => 30,
					'left' => 30,
				],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tx-banner-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'avas-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
				],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tx-banner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden',
				],
			]
		);
		$this->add_responsive_control(
			'content_width',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Content Width', 'avas-core' ),
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
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .tx-banner-content' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_vr_position',
			[
				'label' => esc_html__( 'Vertical Position', 'avas-core' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
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
				'selectors_dictionary' => [
					'top' => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end'
				],
                'selectors' => [
					'{{WRAPPER}} .tx-banner-content' =>  '-webkit-justify-content: {{VALUE}};justify-content: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'content_align',
			[
				'label' => esc_html__( 'Alignment', 'avas-core' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'center',
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
                'selectors' => [
					'{{WRAPPER}} .tx-banner-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_spacing_x',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Content Spacing X', 'avas-core' ),
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
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .tx-banner-content' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'content_spacing_y',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Content Spacing Y', 'avas-core' ),
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .tx-banner-content' => 'bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Image
		$this->add_control(
			'content_image_section',
			[
				'label' => esc_html__( 'Image', 'avas-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'content_icon_type' => 'image',
				],
			]
		);

		$this->add_responsive_control(
			'content_image_width',
			[
				'label' => esc_html__( 'Width', 'avas-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 300,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .tx-banner-icon img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'content_icon_type' => 'image',
				],
			]
		);


		// Icon
		$this->add_control(
			'content_icon_section',
			[
				'label' => esc_html__( 'Icon', 'avas-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'content_icon_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'content_icon_size',
			[
				'label' => esc_html__( 'Font Size', 'avas-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 27,
				],
				'selectors' => [
					'{{WRAPPER}} .tx-banner-content .tx-banner-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'content_icon_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'content_icon_distance',
			[
				'label' => esc_html__( 'Distance', 'avas-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .tx-banner-content .tx-banner-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'content_icon_type!' => 'none',
				],	
			]
		);

		$this->add_control(
			'content_icon_border_radius',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Border Radius', 'avas-core' ),
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 150,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .tx-banner-content .tx-banner-icon img' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'content_icon_type' => 'image',
				],
			]
		);

		// Sub Title
		$this->add_control(
			'content_subtitle_section',
			[
				'label' => esc_html__( 'Sub Title', 'avas-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_subtitle_typography',
				'selector' => '{{WRAPPER}} .tx-banner-subtitle',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'content_subtitle_shadow',
				'selector' => '{{WRAPPER}} .tx-banner-subtitle',
			]
		);

		$this->add_responsive_control(
			'content_subtitle_distance',
			[
				'label' => esc_html__( 'Distance', 'avas-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .tx-banner-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],	
			]
		);

		// Title
		$this->add_control(
			'content_title_section',
			[
				'label' => esc_html__( 'Title', 'avas-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_title_typography',
				'selector' => '{{WRAPPER}} .tx-banner-title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'content_title_shadow',
				'selector' => '{{WRAPPER}} .tx-banner-title',
			]
		);

		$this->add_responsive_control(
			'content_title_distance',
			[
				'label' => esc_html__( 'Distance', 'avas-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .tx-banner-title' => 'margin: 0 0 {{SIZE}}{{UNIT}};',
				],	
			]
		);

		// Description
		$this->add_control(
			'content_description_section',
			[
				'label' => esc_html__( 'Description', 'avas-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_description_typography',
				'selector' => '{{WRAPPER}} .tx-banner-description',
			]
		);

		$this->add_responsive_control(
			'content_description_distance',
			[
				'label' => esc_html__( 'Distance', 'avas-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .tx-banner-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],	
			]
		);

		$this->end_controls_section(); // End Controls Section

		// Styles
		// Section: Button ------
		$this->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__( 'Button', 'avas-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'content_link_type' => [ 'btn', 'btn-title' ],
				],
			]
		);

		$this->start_controls_tabs( 'tabs_btn_colors' );

		$this->start_controls_tab(
			'tab_btn_normal_colors',
			[
				'label' => esc_html__( 'Normal', 'avas-core' ),
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'btn_bg_color',
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'color' => [
						'default' => '#222222',
					],
				],
				'selector' => '{{WRAPPER}} .tx-banner-btn'
			]
		);

		$this->add_control(
			'btn_color',
			[
				'label' => esc_html__( 'Text Color', 'avas-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tx-banner-btn' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'btn_border_color',
			[
				'label' => esc_html__( 'Border Color', 'avas-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tx-banner-btn' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'btn_box_shadow',
				'selector' => '{{WRAPPER}} .tx-banner-btn',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_btn_hover_colors',
			[
				'label' => esc_html__( 'Hover', 'avas-core' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'btn_hover_bg_color',
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'color' => [
						'default' => '#f9f9f9',
					],
				],
				'selector' => '{{WRAPPER}} .tx-banner:hover .tx-banner-btn',
			]
		);

		$this->add_control(
			'btn_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'avas-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tx-banner:hover .tx-banner-btn' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'btn_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'avas-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tx-banner:hover .tx-banner-btn' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'btn_hover_box_shadow',
				'selector' => '{{WRAPPER}} .tx-banner:hover .tx-banner-btn',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		
		$this->add_control(
			'btn_transition_duration',
			[
				'label' => esc_html__( 'Transition Duration', 'avas-core' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0.2,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .tx-banner-btn' => '-webkit-transition-duration: {{VALUE}}s;transition-duration: {{VALUE}}s',
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'btn_hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'textdomain' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->add_control(
			'btn_typography_divider',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'btn_typography',
				'selector' => '{{WRAPPER}} .tx-banner-btn',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'btn_padding',
			[
				'label' => esc_html__( 'Padding', 'avas-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', ],
				'default' => [
					'top' => 8,
					'right' => 17,
					'bottom' => 8,
					'left' => 17,
				],
				'selectors' => [
					'{{WRAPPER}}  .tx-banner-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'btn_border_type',
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
				'default' => 'solid',
				'selectors' => [
					'{{WRAPPER}}  .tx-banner-btn' => 'border-style: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'btn_border_width',
			[
				'label' => esc_html__( 'Border Width', 'avas-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', ],
				'default' => [
					'top' => 2,
					'right' => 2,
					'bottom' => 2,
					'left' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .tx-banner-btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'btn_border_type!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'btn_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'avas-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 2,
					'right' => 2,
					'bottom' => 2,
					'left' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .tx-banner-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section(); // End Controls Section

		// Styles
		// Section: Badge -----------
		$this->start_controls_section(
			'section_style_badge',
			[
				'label' => esc_html__( 'Badge', 'avas-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'badge_style!' => 'none',
				],
			]
		);

		$this->add_control(
			'badge_text_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__( 'Color', 'avas-core' ),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .tx-banner-badge-inner' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_bg_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__( 'Background Color', 'avas-core' ),
				'default' => '#e83d17',
				'selectors' => [
					'{{WRAPPER}} .tx-banner-badge-inner' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .tx-banner-badge-style_3:before' => ' border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'badge_box_shadow',
				'selector' => '{{WRAPPER}} .tx-banner-badge-inner'
			]
		);

		$this->add_control(
			'badge_box_shadow_divider',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'badge_typography',
				'label' => esc_html__( 'Typography', 'avas-core' ),
				'selector' => '{{WRAPPER}} .tx-banner-badge-inner'
			]
		);

		$this->add_responsive_control(
			'badge_padding',
			[
				'label' => esc_html__( 'Padding', 'avas-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 0,
					'right' => 10,
					'bottom' => 0,
					'left' => 10,
				],
				'size_units' => [ 'px', ],
				'selectors' => [
				'{{WRAPPER}} .tx-banner-badge .tx-banner-badge-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section(); // End Controls Section

	}

	protected function render() {
		$settings = $this->get_settings();

		if ( $settings['badge_style'] !== 'none' && ! empty( $settings['badge_title'] ) ) :

			$this->add_render_attribute( 'tx-banner-badge-attr', 'class', 'tx-banner-badge tx-banner-badge-'. $settings[ 'badge_style'] );
			if ( ! empty( $settings['badge_hr_position'] ) ) :
				$this->add_render_attribute( 'tx-banner-badge-attr', 'class', 'tx-banner-badge-'. $settings['badge_hr_position'] );
			endif; ?>

			<div <?php echo $this->get_render_attribute_string( 'tx-banner-badge-attr' ); ?>>
				<div class="tx-banner-badge-inner"><?php echo $settings['badge_title']; ?></div>
			</div>
		<?php endif;
		
		$image_src = Group_Control_Image_Size::get_attachment_image_src( $settings['image']['id'], 'image_size', $settings );
		$content_image_src = Group_Control_Image_Size::get_attachment_image_src( $settings['content_image']['id'], 'content_image_size', $settings );

		if ( ! $image_src ) {
			$image_src = $settings['image']['url'];
		}

		if ( ! $content_image_src ) {
			$content_image_src = $settings['content_image']['url'];
		}

		$content_btn_element = 'div';
		$content_link = $settings['content_link']['url'];

		if ( '' !== $content_link ) {

			$content_btn_element = 'a';

			$this->add_render_attribute( 'link_attribute', 'href', $settings['content_link']['url'] );

			if ( $settings['content_link']['is_external'] ) {
				$this->add_render_attribute( 'link_attribute', 'target', '_blank' );
			}

			if ( $settings['content_link']['nofollow'] ) {
				$this->add_render_attribute( 'link_attribute', 'nofollow', '' );
			}
		}

		$this->add_render_attribute( 'title_attribute', 'class', 'tx-banner-title' );
		$this->add_render_attribute( 'description_attribute', 'class', 'tx-banner-description' );
		$this->add_render_attribute( 'btn_attribute', 'class', 'tx-banner-btn-wrap' );
		$this->add_render_attribute( 'icon_attribute', 'class', 'tx-banner-icon' );


		?>

		<div class="tx-banner tx-animation">

			<?php if ( 'box' === $settings['content_link_type'] ): ?>
			<a class="tx-banner-link" <?php echo $this->get_render_attribute_string( 'link_attribute' ); ?>></a>	
			<?php endif; ?>
				
			<?php if ( $image_src ) : ?>
				<div class="tx-banner-image">
					<div class="tx-banner-bg-image tx-bg-anim-<?php echo esc_attr($settings['image_animation']); ?> wpr-anim-timing-<?php echo esc_attr( $settings['image_animation_timing'] ); ?>" style="background-image:url(<?php echo esc_url( $image_src ); ?>);"></div>
					<div class="tx-banner-bg-overlay tx-border-anim-<?php echo esc_attr($settings['border_animation']); ?>"></div>
				</div>
			<?php endif; ?>
			
			<div class="tx-banner-content">

				<?php if ( 'none' !== $settings['content_icon_type'] ) : ?>
				<div <?php echo $this->get_render_attribute_string('icon_attribute'); ?>>
					<?php if ( 'icon' === $settings['content_icon_type'] && '' !== $settings['content_icon']['value'] ) : ?>
						<i class="<?php echo esc_attr( $settings['content_icon']['value'] ); ?>"></i>
					<?php elseif ( 'image' === $settings['content_icon_type'] && $content_image_src ) : ?>
						<img src="<?php echo esc_url( $content_image_src ); ?>" >
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<?php if ( '' !== $settings['content_subtitle'] ) : 
					echo '<'. esc_attr($settings['content_subtitle_tag']) .' class="tx-banner-subtitle">';
				?>
						<?php echo wp_kses_post($settings['content_subtitle']); ?>	
				<?php 
					echo '</'. esc_attr($settings['content_subtitle_tag']) .'>';
					endif; ?>

				<?php

				if ( '' !== $settings['content_title'] ) {

					echo '<'. esc_attr($settings['content_title_tag']) .' '. $this->get_render_attribute_string( 'title_attribute' ) .'>';
					if ( 'title' === $settings['content_link_type'] || 'btn-title' === $settings['content_link_type']  ) {
						echo '<a '. $this->get_render_attribute_string( 'link_attribute' ).'>';
					}

					echo '<span>'. wp_kses_post($settings['content_title']) .'</span>';
				
					if ( 'title' === $settings['content_link_type'] || 'btn-title' === $settings['content_link_type']  ) {
						echo '</a>';
					}

					echo '</'. esc_attr($settings['content_title_tag']) .'>';
				}

				?>

				<?php if ( '' !== $settings['content_description'] ) : ?>
					<div <?php echo $this->get_render_attribute_string( 'description_attribute' ); ?>>
						<?php echo '<p>'. wp_kses_post($settings['content_description']) .'</p>'; ?>	
					</div>						
				<?php endif; ?>

				<?php if ( ('btn' === $settings['content_link_type'] || 'btn-title' === $settings['content_link_type']) && ('' !== $settings['content_btn_text'] ) ) : ?>
					<div <?php echo $this->get_render_attribute_string( 'btn_attribute' ); ?>>
						<<?php echo esc_html($content_btn_element); ?> class="tx-banner-btn elementor-animation-<?php echo esc_attr($settings['btn_hover_animation']); ?>" <?php echo $this->get_render_attribute_string( 'link_attribute' ); ?>>

							<?php if ( $settings['content_btn_icon_position'] == 'before' ) : ?>
							<span class="tx-banner-btn-icon tx-banner-btn-icon-position-before">
								<i class="<?php echo esc_attr( $settings['content_btn_icon']['value'] ); ?>"></i>
							</span>
							<span class="tx-banner-btn-text"><?php echo esc_html($settings['content_btn_text']); ?></span>		
							<?php endif; ?>

							
							<?php if ( $settings['content_btn_icon_position'] == 'after' ) : ?>
							<span class="tx-banner-btn-text"><?php echo esc_html($settings['content_btn_text']); ?></span>
							<span class="tx-banner-btn-icon tx-banner-btn-icon-position-after">
								<i class="<?php echo esc_attr( $settings['content_btn_icon']['value'] ); ?>"></i>
							</span>
							<?php endif; ?>
						</<?php echo esc_html($content_btn_element); ?>>
					</div>	
				<?php endif; ?>
			</div>

			<?php 

			if ( $settings['badge_style'] !== 'none' && ! empty( $settings['badge_title'] ) ) :

			$this->add_render_attribute( 'tx-banner-badge-attr', 'class', 'tx-banner-badge tx-banner-badge-'. $settings[ 'badge_style'] );
			if ( ! empty( $settings['badge_hr_position'] ) ) :
				$this->add_render_attribute( 'tx-banner-badge-attr', 'class', 'tx-banner-badge-'. $settings['badge_hr_position'] );
			endif; ?>

			<div <?php echo $this->get_render_attribute_string( 'tx-banner-badge-attr' ); ?>>
				<div class="tx-banner-badge-inner"><?php echo $settings['badge_title']; ?></div>
			</div>
		<?php endif; ?>
		</div>

		
<?php } //render()

} // class
