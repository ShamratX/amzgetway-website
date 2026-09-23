<?php
namespace AvasElements\Modules\StickySection;

use AvasElements\Base\Module_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function __construct() {

		add_action('elementor/element/section/section_advanced/after_section_end', [$this, 'register_section']);
        add_action('elementor/element/section/sec_sticky_section/before_section_end', [$this, 'register_controls'], 10, 2);
        add_action('elementor/frontend/section/before_render', [$this, 'tx_sticky_sec_render'], 10, 1);
        add_action('elementor/frontend/section/after_render', [$this, 'tx_sticky_script_render'], 10, 1);
        
        add_action('elementor/element/container/section_layout/after_section_end', [$this, 'register_section']);
        add_action('elementor/element/container/sec_sticky_section/before_section_end', [$this, 'register_controls'], 10, 2);
        add_action('elementor/frontend/container/before_render', [$this, 'tx_sticky_sec_render'], 10, 1);
        add_action('elementor/frontend/container/after_render', [$this, 'tx_sticky_script_render'], 10, 1);

	}

	public function get_name() {
		return 'avas-sticky-section';
	}

	public function register_section($element) {

		$element->start_controls_section(
			'sec_sticky_section',
			[
				'tab'   => Controls_Manager::TAB_ADVANCED,
				'label' => esc_html__('Avas Sticky Section', 'avas-core'),
			]
		);

		$element->end_controls_section();
	}

	public function register_controls($section, $args) {

        $section->add_control(
            'sticky_section_switch',
            [
                'label'        => esc_html__('Sticky Enable', 'avas-core'),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
            ]
        );

        $section->add_responsive_control(
            'sticky_section_width',
            [
                'label' => esc_html__( 'Content Width', 'avas-core' ),
                'description'     => esc_html__('Set the content width when enabling the Sticky section for the inner container/column.', 'avas-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'max' => 5000,
                    ],
                    '%' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.tx-sticky-sec.tx-sticky-sec-active' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'sticky_section_switch' => 'yes',
                ],
               
            ]
        );
        $section->add_responsive_control(
            'sticky_section_offset',
            [
                'label'     => esc_html__('Offset', 'avas-core'),
                'type'      => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.tx-sticky-sec.tx-sticky-sec-active' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'sticky_section_switch' => 'yes',
                ],
            ]
        );
        $section->add_control(
            'sticky_section_bg',
            [
                'label'     => esc_html__('Sticky Background Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.tx-sticky-sec.tx-sticky-sec-active' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'sticky_section_switch' => 'yes',
                ],
            ]
        );

        $section->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'label'     => esc_html__('Sticky Box Shadow', 'avas-core'),
                'name'      => 'section_sticky_active_shadow',
                'selector'  => '{{WRAPPER}}.tx-sticky-sec.tx-sticky-sec-active',
                'condition' => [
                    'sticky_section_switch' => 'yes',
                ],
            ]
        );

        $section->add_responsive_control(
            'sticky_section_padding',
            [
                'label'      => esc_html__('Sticky Padding', 'avas-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.tx-sticky-sec.tx-sticky-sec-active' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'sticky_section_switch' => 'yes',
                ],
            ]
        );

        $section->add_control(
            'sticky_section_zindex',
            [
                'label'     => esc_html__('Z-Index', 'avas-core'),
                'type'      => Controls_Manager::NUMBER,
                'min' => -1000,
                'max' => 9999,
                'condition' => [
                    'sticky_section_switch' => 'yes',
                ],
                'selectors'  => [
                    '{{WRAPPER}}.tx-sticky-sec.tx-sticky-sec-active' => 'z-index: {{VALUE}};',
                ],
            ]
        );

    }

	public function tx_sticky_sec_render($section) {

        $settings = $section->get_settings_for_display();

        if('yes' === $settings['sticky_section_switch']):
            $section->add_render_attribute('_wrapper', 'class', 'tx-sticky-sec');
        endif;

    }

    public function tx_sticky_script_render($section) {

        if ( $section->get_settings('sticky_section_switch') == 'yes' ) {
            wp_enqueue_style('tx-sticky-section');
            wp_enqueue_script('tx-sticky-section');
        }

    }

       
 }

