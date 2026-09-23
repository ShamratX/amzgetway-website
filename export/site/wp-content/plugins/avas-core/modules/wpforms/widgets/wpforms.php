<?php
namespace AvasElements\Modules\WPForms\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use AvasElements\TX_Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WPForms extends Widget_Base {

    public function get_name() {
        return 'avas-wpforms';
    }

    public function get_title() {
        return esc_html__( 'Avas WPForms', 'avas-core' );
    }

    public function get_icon() {
        return 'eicon-mail';
    }

    public function get_categories() {
        return [ 'avas-elements' ];
    }

	protected function register_controls() {
        
        if (!function_exists('wpforms')) {
            $this->start_controls_section(
                'tx_notice',
                [
                    'label' => esc_html__('Notice', 'avas-core'),
                ]
            );

            $this->add_control(
                'tx_notice_text',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => __('Please install / activate <strong>WPForms</strong> plugin.', 'avas-core'),
                ]
            );

            $this->end_controls_section();
        } else {
		$this->start_controls_section(
            'tx_wpforms_settings',
            [
                'label' => esc_html__( 'Settings', 'avas-core' )
            ]
        );
        $this->add_control(
            'tx_wpforms_list',
            [
                'label'                 => esc_html__( 'Select a form', 'avas-core' ),
                'type'                  => Controls_Manager::SELECT,
                'label_block'           => true,
                'options'               => TX_Helper::wpforms(),
            ]
        );
  
        $this->end_controls_section();

		$this->start_controls_section(
            'tx_wpforms_label',
            [
                'label' => esc_html__( 'Label', 'avas-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tx_wpforms_label_color',
            [
                'label'     => esc_html__( 'Label Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container-full .wpforms-field-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tx_wpforms_label_typo',
                'label' => esc_html__( 'Typography', 'avas-core' ),
                'selector' => '{{WRAPPER}} div.wpforms-container-full .wpforms-field-label',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'tx_wpforms__input',
            [
                'label' => esc_html__( 'Input', 'avas-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'tx_wpforms_input_height',
            [
                'label' => esc_html__( 'Input Field Height', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container-full input[type=date], {{WRAPPER}} div.wpforms-container-full input[type=datetime], {{WRAPPER}} div.wpforms-container-full input[type=datetime-local], {{WRAPPER}} div.wpforms-container-full input[type=email], {{WRAPPER}} div.wpforms-container-full input[type=month], {{WRAPPER}} div.wpforms-container-full input[type=number], {{WRAPPER}} div.wpforms-container-full input[type=password], {{WRAPPER}} div.wpforms-container-full input[type=range], {{WRAPPER}} div.wpforms-container-full input[type=search], {{WRAPPER}} div.wpforms-container-full input[type=tel], {{WRAPPER}} div.wpforms-container-full input[type=text], {{WRAPPER}} div.wpforms-container-full input[type=time], {{WRAPPER}} div.wpforms-container-full input[type=url], {{WRAPPER}} div.wpforms-container-full input[type=week], {{WRAPPER}} div.wpforms-container-full select' => 'height: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
        $this->add_responsive_control(
            'tx_wpforms_input_width',
            [
                'label' => esc_html__( 'Input Field Width', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,

                'size_units' => [ 'px', '%' ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                    ],
                ],
                'default' => [
                        'unit' => '%'
                ],
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container-full input[type=date], {{WRAPPER}} div.wpforms-container-full input[type=datetime], {{WRAPPER}} div.wpforms-container-full input[type=datetime-local], {{WRAPPER}} div.wpforms-container-full input[type=email], {{WRAPPER}} div.wpforms-container-full input[type=month], {{WRAPPER}} div.wpforms-container-full input[type=number], {{WRAPPER}} div.wpforms-container-full input[type=password], {{WRAPPER}} div.wpforms-container-full input[type=range], {{WRAPPER}} div.wpforms-container-full input[type=search], {{WRAPPER}} div.wpforms-container-full input[type=tel], {{WRAPPER}} div.wpforms-container-full input[type=text], {{WRAPPER}} div.wpforms-container-full input[type=time], {{WRAPPER}} div.wpforms-container-full input[type=url], {{WRAPPER}} div.wpforms-container-full input[type=week], {{WRAPPER}} div.wpforms-container-full select' => 'width: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
        $this->add_control(
            'tx_wpforms_input_placeholder_color',
            [
                'label'     => esc_html__( 'Placeholder Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container-full input::placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container-full textarea::placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tx_wpforms_placeholder_typography',
                'label' => esc_html__( 'Placeholder Typography', 'avas-core' ),
                'selector' => '{{WRAPPER}} div.wpforms-container-full::-webkit-input-placeholder',
            ]
        );
        $this->add_control(
            'tx_wpforms_input_text_color',
            [
                'label'     => esc_html__( 'Input Text Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container-full input' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container-full textarea' => 'color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container-full select' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        // $this->add_control(
        //     'tx_wpforms_others_text_color',
        //     [
        //         'label'     => esc_html__( 'Others Text Color', 'avas-core' ),
        //         'type'      => Controls_Manager::COLOR,
        //         'selectors' => [
        //             '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap.select-state' => 'color: {{VALUE}};',
        //             '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap.select-gender' => 'color: {{VALUE}};',
        //             '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap.accept-this-1' => 'color: {{VALUE}};',
        //         ],
        //     ]
        // );

        $this->add_control(
            'tx_wpforms_input_text_background',
            [
                'label'     => esc_html__( 'Background Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container-full input' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container-full textarea' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} div.wpforms-container-full select' => 'background-color: {{VALUE}};',
                    // '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-date' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tx_wpforms_input_typography',
                'label' => esc_html__( 'Input Typography', 'avas-core' ),
                'selector' => '{{WRAPPER}} div.wpforms-container-full input[type=date], {{WRAPPER}} div.wpforms-container-full input[type=datetime], {{WRAPPER}} div.wpforms-container-full input[type=datetime-local], {{WRAPPER}} div.wpforms-container-full input[type=email], {{WRAPPER}} div.wpforms-container-full input[type=month], {{WRAPPER}} div.wpforms-container-full input[type=number], {{WRAPPER}} div.wpforms-container-full input[type=password], {{WRAPPER}} div.wpforms-container-full input[type=range], {{WRAPPER}} div.wpforms-container-full input[type=search], {{WRAPPER}} div.wpforms-container-full input[type=tel], {{WRAPPER}} div.wpforms-container-full input[type=text], {{WRAPPER}} div.wpforms-container-full input[type=time], {{WRAPPER}} div.wpforms-container-full input[type=url], {{WRAPPER}} div.wpforms-container-full input[type=week], {{WRAPPER}} div.wpforms-container-full select, {{WRAPPER}} div.wpforms-container-full textarea',
            ]
        );
        $this->add_responsive_control(
            'tx_wpforms_textarea_height',
            [
                'label' => esc_html__( 'Textarea Height', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 200,
                ],
                'range' => [
                    'px' => [
                        'min' => 30,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container-full textarea' => 'height: {{SIZE}}{{UNIT}}; display: block;',
                ],
                // 'separator' => 'before',

            ]
        );
        $this->add_responsive_control(
            'tx_wpforms_textarea_width',
            [
                'label' => esc_html__( 'Textarea Width', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container-full textarea' => 'width: {{SIZE}}{{UNIT}}; display: block;',
                ],
                // 'separator' => 'before',

            ]
        );

        $this->add_responsive_control(
            'tx_wpforms_input_space',
            [
                'label' => esc_html__( 'Field Space', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                // 'default' => [
                //     'size' => 25,
                // ],
                'range' => [
                    'px' => [
                        'min' => -150,
                        'max' => 150,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpforms-container .wpforms-field' => 'margin-top: {{SIZE}}{{UNIT}};',
                    // '{{WRAPPER}} .wpcf7-form' => 'margin-top: -{{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name'        => 'tx_wpforms_input_border',
                'label'       => esc_html__( 'Border', 'avas-core' ),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} div.wpforms-container-full input, {{WRAPPER}} div.wpforms-container-full textarea, {{WRAPPER}} div.wpforms-container-full select',
            ]
        );

        $this->add_responsive_control(
            'tx_wpforms_input_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container-full input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} div.wpforms-container-full textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} div.wpforms-container-full select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'tx_wpforms_input_padding',
            [
                'label' => esc_html__( 'Padding', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container-full input, {{WRAPPER}} div.wpforms-container-full textarea, {{WRAPPER}} div.wpforms-container-full select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'tx_wpforms_submit_button',
            [
                'label' => esc_html__( 'Submit Button', 'avas-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tx_wpforms_tabs_button_style' );

        $this->start_controls_tab(
            'tx_wpforms_button_normal',
            [
                'label' => esc_html__( 'Normal', 'avas-core' ),
            ]
        );
        $this->add_responsive_control(
            'tx_wpforms_submit_button_width',
            [
                'label' => esc_html__( 'Width', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container-full button[type=submit]' => 'width: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
        $this->add_responsive_control(
            'tx_wpforms_submit_button_height',
            [
                'label' => esc_html__( 'Height', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container-full button[type=submit]' => 'height: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
        $this->add_control(
            'tx_wpforms_button_text_color',
            [
                'label' => esc_html__( 'Text Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container-full button[type=submit]' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tx_wpforms_button_background_color',
            [
                'label' => esc_html__( 'Background Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container-full button[type=submit]' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'tx_wpforms_button_border',
                'label' => esc_html__( 'Border', 'avas-core' ),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} div.wpforms-container-full button[type=submit]',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'tx_wpforms_button_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container-full button[type=submit]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'tx_wpforms_button_box_shadow',
                'selector' => '{{WRAPPER}} div.wpforms-container-full button[type=submit]',
            ]
        );

        $this->add_responsive_control(
            'tx_wpforms_button_padding',
            [
                'label' => esc_html__( 'Padding', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container-full button[type=submit]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                // 'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tx_wpforms_button_typography',
                'label' => esc_html__( 'Typography', 'avas-core' ),
                'selector' => '{{WRAPPER}} div.wpforms-container-full button[type=submit]',
                // 'separator' => 'before',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tx_wpforms_tab_button_hover',
            [
                'label' => esc_html__( 'Hover', 'avas-core' ),
            ]
        );

        $this->add_control(
            'tx_wpforms_tab_button_hover_color',
            [
                'label' => esc_html__( 'Text Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container-full button[type=submit]:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tx_wpforms_tab_button_background_hover_color',
            [
                'label' => esc_html__( 'Background Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container-full button[type=submit]:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tx_wpforms_tab_button_hover_border_color',
            [
                'label' => esc_html__( 'Border Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.wpforms-container-full button[type=submit]:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

	}
}

	protected function render() {
        $settings = $this->get_settings();

        if ( function_exists( 'wpforms' ) ) {
		
        ?>
        
        <?php if ( !empty( $settings['tx_wpforms_list'] ) ) : ?>
        <div class="tx-contact-form-7">

           <?php echo do_shortcode( '[wpforms id="' . $settings['tx_wpforms_list'] . '" ]' ); ?>
       
        </div><!-- tx-contact-form-7 -->
        <?php endif; ?>

    <?php

        } else { ?>

            <h4><?php echo esc_html__('Please install / activate WPForms plugin.', 'avas-core'); ?></h4>

    <?php }



	} //function render()
} // class
