<?php
namespace AvasElements\Modules\Counter\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Text_Shadow;
use elementor\Icons_Manager;
use elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Counter extends Widget_Base {

    public function get_name() {
        return 'avas-counter';
    }

    public function get_title() {
        return esc_html__( 'Avas Counter', 'avas-core' );
    }

    public function get_icon() {
        return 'eicon-counter';
    }

    public function get_categories() {
        return [ 'avas-elements' ];
    }

    public function get_keywords() {
        return [ 'counter', 'number', 'odometer' ];
    }
    
	public function get_script_depends() {
        return [ 'tx-counter' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_counter',
            [
                'label' => esc_html__( 'Counter', 'avas-core' ),
            ]
        );
        $this->add_control(
            'counter_icon_swicher',
            [
                'label'        => esc_html__( 'Display Icon', 'avas-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_responsive_control(
            'counter_icon_select',
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
                    'counter_icon_swicher' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'counter_icon',
            [
                'label' => esc_html__( 'Icon', 'avas-core' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'far fa-smile-beam',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'counter_icon_swicher' => 'yes',
                    'counter_icon_select' => 'icon'
                ]
            ]
        );

        $this->add_control(
            'counter_image',
            [
                'label' => esc_html__( 'Image', 'avas-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'counter_icon_select' => 'image'
                ]
            ]
        );
        $this->add_control(
            'ending_number',
            [
                'label' => esc_html__( 'Number', 'avas-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 999,
                'dynamic' => [
                    'active' => true,
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'prefix',
            [
                'label' => esc_html__( 'Number Prefix', 'avas-core' ),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => '$',
                'placeholder' => 1,
            ]
        );

        $this->add_control(
            'suffix',
            [
                'label' => esc_html__( 'Number Suffix', 'avas-core' ),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => 'M',
                'placeholder' => esc_html__( 'Plus', 'avas-core' ),
            ]
        );

        $this->add_control(
            'duration',
            [
                'label' => esc_html__( 'Animation Duration', 'avas-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 2000,
                'min' => 100,
                'step' => 100,
            ]
        );

        // $this->add_control(
        //     'delay',
        //     [
        //         'label' => esc_html__( 'Delay', 'avas-core' ),
        //         'type' => Controls_Manager::NUMBER,
        //         'default' => 10,
        //     ]
        // );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'avas-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__( 'Cool Number', 'avas-core' ),
            ]
        );
        $this->add_control(
            'counter_layout_style',
            [
                'label' => esc_html__( 'Layout', 'avas-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'style-1' => esc_html__( 'Style 1', 'avas-core' ),
                    'style-2' => esc_html__( 'Style 2', 'avas-core' ),
                    'style-3' => esc_html__( 'Style 3', 'avas-core' ),
                    'style-4' => esc_html__( 'Style 4', 'avas-core' ),
                ],
                'default' => 'style-1',
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'counter_position',
            [
                'label' => esc_html__( 'Position', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'avas-core' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'avas-core' ),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'avas-core' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'toggle' => false,
            ]
        );    
        $this->end_controls_section();

        $this->start_controls_section(
            'section_icon',
            [
                'label' => esc_html__( 'Icon', 'avas-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'counter_icon_swicher' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-counter-wrapper .tx-counter-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tx-counter-wrapper .tx-counter-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'counter_icon_size',
            [
                'label' => esc_html__( 'Size', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 300,
                    ],
                ],
                'condition' => [
                    'counter_icon_swicher' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-counter-wrapper .tx-counter-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tx-counter-wrapper .tx-counter-icon img' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tx-counter-wrapper .tx-counter-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'counter_icon_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'condition' => [
                    'counter_icon_swicher' => 'yes',
                    'counter_icon_select' => 'image'
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-counter-wrapper .tx-counter-icon img' => 'border-radius: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tx-counter-wrapper .tx-counter-icon svg' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'counter_icon_space_vertical_left',
            [
                'label' => esc_html__( 'Icon Spacing Vertical', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'condition' => [
                    'counter_icon_swicher' => 'yes',
                    'counter_layout_style' => ['style-2','style-3'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-counter-wrapper.style-2 .tx-counter-icon, {{WRAPPER}} .tx-counter-wrapper.style-3 .tx-counter-icon' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'counter_icon_space_horizontal_left',
            [
                'label' => esc_html__( 'Icon Spacing Horizontal', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'condition' => [
                    'counter_icon_swicher' => 'yes',
                    'counter_layout_style' => ['style-2','style-3'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-counter-wrapper.style-2.center .tx-counter-icon, {{WRAPPER}} .tx-counter-wrapper.style-3.center .tx-counter-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tx-counter-wrapper.style-2.left .tx-counter-icon, {{WRAPPER}} .tx-counter-wrapper.style-3.left .tx-counter-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tx-counter-wrapper.style-2.right .tx-counter-icon, {{WRAPPER}} .tx-counter-wrapper.style-3.right .tx-counter-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'counter_icon_padding',
            [
                'label' => esc_html__( 'Padding', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tx-counter-wrapper .tx-counter-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'counter_icon_margin',
            [
                'label' => esc_html__( 'Margin', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tx-counter-wrapper .tx-counter-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'counter_icon_shadow',

                'selector' => '{{WRAPPER}} .tx-counter-wrapper .tx-counter-icon',
                'condition' => [
                    'counter_icon_select' => 'icon'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_number',
            [
                'label' => esc_html__( 'Number', 'avas-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'number_color',
            [
                'label' => esc_html__( 'Text Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-counter-number-wrapper' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_number',
                'selector' => '{{WRAPPER}} .tx-counter-number-wrapper',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'number_stroke',
                'selector' => '{{WRAPPER}} .tx-counter-number-wrapper',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'number_shadow',
                'selector' => '{{WRAPPER}} .tx-counter-number-wrapper',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__( 'Title', 'avas-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Text Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-counter-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_title',
                'selector' => '{{WRAPPER}} .tx-counter-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'title_stroke',
                'selector' => '{{WRAPPER}} .tx-counter-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'title_shadow',
                'selector' => '{{WRAPPER}} .tx-counter-title',
            ]
        );

        $this->end_controls_section();
    }


    /**
     * Render counter widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings  = $this->get_settings_for_display();

        $this->add_render_attribute( 'counter-wrapper', [
            'class' => [ 'tx-counter-wrapper', $settings['counter_layout_style'], $settings['counter_position'] ]
        ] );

        $this->add_render_attribute( 'counter', [
            'class' => 'tx-counter-number',
            'data-settings' => [
                           wp_json_encode(array_filter([
                               'duration' => $settings["duration"],
                               // 'delay' => $settings["delay"],
                           ]))
                       ]
        ] );

        $this->add_render_attribute( 'counter-title', 'class', 'tx-counter-title' );

        $this->add_inline_editing_attributes( 'counter-title' );
        ?>

        <?php if($settings['counter_layout_style'] == 'style-1' || $settings['counter_layout_style'] == 'style-2'): ?>
        <div <?php $this->print_render_attribute_string( 'counter-wrapper' ); ?>>

            <?php 
                if ( $settings['counter_icon_swicher'] == 'yes' && $settings['counter_icon_select'] == 'icon' ) { ?>
                    <span class="tx-counter-icon"><?php Icons_Manager::render_icon( $settings['counter_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
            <?php }
                if ( $settings['counter_icon_swicher'] == 'yes' && $settings['counter_icon_select'] == 'image' ) { ?>
                    <span class="tx-counter-icon"><img src="<?php echo esc_attr($settings['counter_image']['url']); ?>"></span>
                <?php }
            ?>

           
            <div class="tx-counter-number-title-wrapper">
                <div class="tx-counter-number-wrapper">
                    <span class="tx-counter-number-prefix"><?php $this->print_unescaped_setting( 'prefix' ); ?></span>
                    <span <?php $this->print_render_attribute_string( 'counter' ); ?>><?php $this->print_unescaped_setting( 'ending_number' ); ?></span>
                    <span class="tx-counter-number-suffix"><?php $this->print_unescaped_setting( 'suffix' ); ?></span>
                </div>
                <?php if ( $settings['title'] ) : ?>
                    <div <?php $this->print_render_attribute_string( 'counter-title' ); ?>><?php $this->print_unescaped_setting( 'title' ); ?></div>
                <?php endif; ?>
            </div>

        </div>
        <?php endif; ?>

        <?php if($settings['counter_layout_style'] == 'style-3'): ?>
        <div <?php $this->print_render_attribute_string( 'counter-wrapper' ); ?>>
            <div class="tx-counter-number-icon-wrapper">
            <?php 
                if ( $settings['counter_icon_swicher'] == 'yes' && $settings['counter_icon_select'] == 'icon' ) { ?>
                    <span class="tx-counter-icon"><?php Icons_Manager::render_icon( $settings['counter_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
            <?php }
                if ( $settings['counter_icon_swicher'] == 'yes' && $settings['counter_icon_select'] == 'image' ) { ?>
                    <span class="tx-counter-icon"><img src="<?php echo esc_attr($settings['counter_image']['url']); ?>"></span>
                <?php }
            ?>
            
                <div class="tx-counter-number-wrapper">
                    <span class="tx-counter-number-prefix"><?php $this->print_unescaped_setting( 'prefix' ); ?></span>
                    <span <?php $this->print_render_attribute_string( 'counter' ); ?>><?php $this->print_unescaped_setting( 'ending_number' ); ?></span>
                    <span class="tx-counter-number-suffix"><?php $this->print_unescaped_setting( 'suffix' ); ?></span>
                </div>
            </div>    
                <?php if ( $settings['title'] ) : ?>
                    <div <?php $this->print_render_attribute_string( 'counter-title' ); ?>><?php $this->print_unescaped_setting( 'title' ); ?></div>
                <?php endif; ?>
            
        </div>
        <?php endif;

        if($settings['counter_layout_style'] == 'style-4'): ?>
        <div <?php $this->print_render_attribute_string( 'counter-wrapper' ); ?>>
            <div class="tx-counter-number-icon-title-wrapper">
            <?php 
                if ( $settings['counter_icon_swicher'] == 'yes' && $settings['counter_icon_select'] == 'icon' ) { ?>
                    <span class="tx-counter-icon"><?php Icons_Manager::render_icon( $settings['counter_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
            <?php }
                if ( $settings['counter_icon_swicher'] == 'yes' && $settings['counter_icon_select'] == 'image' ) { ?>
                    <span class="tx-counter-icon"><img src="<?php echo esc_attr($settings['counter_image']['url']); ?>"></span>
                <?php }
            ?>
            
                <div class="tx-counter-number-wrapper">
                    <span class="tx-counter-number-prefix"><?php $this->print_unescaped_setting( 'prefix' ); ?></span>
                    <span <?php $this->print_render_attribute_string( 'counter' ); ?>><?php $this->print_unescaped_setting( 'ending_number' ); ?></span>
                    <span class="tx-counter-number-suffix"><?php $this->print_unescaped_setting( 'suffix' ); ?></span>
                </div>
               
                <?php if ( $settings['title'] ) : ?>
                    <div <?php $this->print_render_attribute_string( 'counter-title' ); ?>><?php $this->print_unescaped_setting( 'title' ); ?></div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif;

    }
}
