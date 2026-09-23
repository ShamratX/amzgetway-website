<?php
namespace AvasElements\Modules\ProgressBar\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class ProgressBar extends Widget_Base {

    public function get_name() {
        return 'avas-progress-bar';
    }

    public function get_title() {
        return esc_html__( 'Avas Progress Bar', 'avas-core' );
    }

    public function get_icon() {
        return 'eicon-skill-bar';
    }

    public function get_categories() {
        return [ 'avas-elements' ];
    }

    public function get_style_depends() {
        return [ 'tx-progress-bar','animation' ];
    }

    public function get_script_depends() {
        return [ 'wow', 'tx-progressbar' ];
    }

    public function get_keywords() {
        return [ 'progress', 'bar', 'skill' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'progressbar_content',
            [
                'label' => esc_html__( 'Progress Bar', 'avas-core' ),
            ]
        );
        
            $this->add_control(
                'tx_progress_bar_style',
                [
                    'label' => esc_html__( 'Style', 'avas-core' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'horizontal',
                    'options' => [
                        'horizontal' => esc_html__( 'Horizontal', 'avas-core' ),
                        'vertical'   => esc_html__( 'Vertical', 'avas-core' ),
                    ],
                ]
            );

            $this->add_control(
                'tx_progress_bar_type',
                [
                    'label' => esc_html__( 'Style', 'avas-core' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'normal',
                    'options' => [
                        'normal'   => esc_html__( 'Normal', 'avas-core' ),
                        'striped' => esc_html__( 'Striped', 'avas-core' ),
                    ],
                ]
            );


            $repeater = new Repeater();

            $repeater->add_control(
                'tx_progressbar_title', 
                [
                    'label'       => esc_html__( 'Title', 'avas-core' ),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => esc_html__( 'WordPress' , 'avas-core' ),
                ]
            );

            $repeater->add_control(
                'tx_progressbar_value', 
                [
                    'label' => esc_html__( 'Progress Bar Value', 'avas-core' ),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 75,
                    ]
                ]
            );

            $repeater->add_control(
                'tx_progressbar_color', 
                [
                    'label'     => esc_html__( 'Progress bar color', 'avas-core' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .tx-progress-bar' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $repeater->add_control(
                'tx_progressbar_value_color', 
                [
                    'label'     => esc_html__( 'Progress bar value color', 'avas-core' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .percent-label' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $repeater->add_control(
                'tx_progressbar_value_bg_color', 
                [
                    'label'     => esc_html__( 'Progress bar value background color', 'avas-core' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .percent-label' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $repeater->add_control(
                'tx_progressbar_indicator_color', 
                [
                    'label'     => esc_html__( 'Progress Indicator', 'avas-core' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}.tx-progress-indicator .tx-progressbar-content .tx-progress-bar::after' => 'background-color: {{VALUE}};border-color: {{VALUE}};'
                    ],
                ]
            );

            $repeater->add_control(
                'progressbar_before_after', 
                [
                    'label'         => esc_html__( 'Value Indicator', 'avas-core' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'return_value'  => 'yes',
                    'default'       => 'no',
                ]
            );
            $repeater->add_control(
                'progressbar_value_before_after_color', 
                [
                    'label'     => esc_html__( 'Indicator color', 'avas-core' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}.tx-progressbar-value-bottom .tx-progressbar-content .percent-label::after' => 'border-top: 5px solid {{VALUE}};',
                    ],
                    'condition' => [
                        'progressbar_before_after' =>'yes',
                    ],
                    'separator' => 'before',
                ]
            );      


            $this->add_control(
            'tx_progressbar_list',
            [
                'label'     => esc_html__( 'Progress Bar', 'avas-core' ),
                'type'      => Controls_Manager::REPEATER,
                'fields'    => $repeater->get_controls(),
                'prevent_empty'=>false,
                'default' => [
                    [
                        'tx_progressbar_title'         => esc_html__('WordPress','avas-core'),
                        'tx_progressbar_color'         => '#111',
                        'tx_progressbar_value_color'   => '#111',
                        
                    ],

                ],
                'title_field' => '{{{ tx_progressbar_title }}}',
            ]
        );

        $this->end_controls_section();

        // Progress Bar value style tab start
        $this->start_controls_section(
            'tx_progressbar_items_style',
            [
                'label'     => esc_html__( 'Items Style', 'avas-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_responsive_control(
                'tx_progress_height',
                [
                    'label' => esc_html__( 'Height', 'avas-core' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                        
                    ],
                    'default' => [
                        'size' => 10,
                        'unit' => 'px',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .tx-progress-bar-wrapper .tx-progressbar-content' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'tx_progress_bar_style' =>'horizontal',
                    ],

                ]
            );

            $this->add_responsive_control(
                'tx_progress_position',
                [
                    'label' => esc_html__( 'Progress Position Top-Bottom', 'avas-core' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -100,
                            'max' => 100,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .tx-progress-bar-wrapper .tx-progress-bar' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'tx_progress_bar_style' =>'horizontal',
                    ],

                ]
            );
            $this->add_responsive_control(
                'tx_progress_spacing',
                [
                    'label' => esc_html__( 'Spacing btween two bars', 'avas-core' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => -100,
                            'max' => 300,
                        ],
                        
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .tx-progress-bar-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'tx_progress_bar_style' =>'horizontal',
                    ],

                ]
            );
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'progressbarbackground',
                    'label' => esc_html__( 'Background', 'avas-core' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .tx-progress-bar-wrapper .tx-progressbar-content',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'progressbar_items_border',
                    'label' => esc_html__( 'Border', 'avas-core' ),
                    'selector' => '{{WRAPPER}} .tx-progress-bar-wrapper .tx-progressbar-content', 
                ]
            );

            $this->add_responsive_control(
                'progressbar_items_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'avas-core' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .tx-progress-bar-wrapper .tx-progressbar-content' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                        '{{WRAPPER}} .tx-progress-bar-wrapper .tx-progress-bar' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'progressbar_items_box_shadow',
                    'label' => esc_html__( 'Box Shadow', 'avas-core' ),
                    'selector' => '{{WRAPPER}} .tx-progress-bar-wrapper .tx-progressbar-content',
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'progressbar_items_padding',
                [
                    'label' => esc_html__( 'Item Padding', 'avas-core' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .tx-progress-bar-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'progressbar_items_inner_padding',
                [
                    'label' => esc_html__( 'Item Inner Padding', 'avas-core' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .tx-progress-bar-wrapper .tx-progressbar-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'progress_bar_indicator',
                [
                    'label' => esc_html__( 'Progress Indicator', 'avas-core' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no',
                    'separator' => 'before',
                ]
            );


            $this->add_control(
                'indicatordimention',
                [
                    'label' => esc_html__( 'Indicator Size', 'avas-core' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 200,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 24,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .tx-progress-indicator .tx-progressbar-content .tx-progress-bar::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'progress_bar_indicator' =>'yes',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'indicatorbackground',
                    'label' => esc_html__( 'Indicator Background', 'avas-core' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .tx-progress-indicator .tx-progressbar-content .tx-progress-bar::after',
                    'condition' => [
                        'progress_bar_indicator' =>'yes',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'progressbar_indicator_border',
                    'label' => esc_html__( 'Border', 'avas-core' ),
                    'selector' => '{{WRAPPER}} .tx-progress-indicator .tx-progressbar-content .tx-progress-bar::after',
                    'condition' => [
                        'progress_bar_indicator' =>'yes',
                    ],
                ]
            );

            $this->add_responsive_control(
                'progressbar_indicator_border_radius',
                [
                    'label' => esc_html__( 'Indicator Border Radius', 'avas-core' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .tx-progress-indicator .tx-progressbar-content .tx-progress-bar::after' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                    'condition' => [
                        'progress_bar_indicator' =>'yes',
                    ],
                ]
            );            
            

        $this->end_controls_section(); // Progress Bar value style tab end        

        // Style tab Title section
        $this->start_controls_section(
            'tx_progressbar_title_style',
            [
                'label' => esc_html__( 'Title', 'avas-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'progress_text_postion',
                [
                    'label' => esc_html__( 'Position', 'avas-core' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__( 'Inner', 'avas-core' ),
                    'label_off' => esc_html__( 'Outer', 'avas-core' ),
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'titlebackground',
                    'label' => esc_html__( 'Background', 'avas-core' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .tx_progress_title',
                ]
            );

            $this->add_responsive_control(
                'progressbar_title_padding',
                [
                    'label' => esc_html__( 'Padding', 'avas-core' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .tx_progress_title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'progressbar_title_margin',
                [
                    'label' => esc_html__( 'Margin', 'avas-core' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .tx_progress_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'progressbar_title_border',
                    'label' => esc_html__( 'Border', 'avas-core' ),
                    'selector' => '{{WRAPPER}} .tx_progress_title',
                ]
            );

            $this->add_responsive_control(
                'progressbar_title_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'avas-core' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .tx_progress_title' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'progressbar_title_box_shadow',
                    'label' => esc_html__( 'Box Shadow', 'avas-core' ),
                    'selector' => '{{WRAPPER}} .tx_progress_title',
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'progressbar_progressbar_title_color',
                [
                    'label'     => esc_html__( 'Color', 'avas-core' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .tx_progress_title' => 'color: {{VALUE}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'progressbar_title_typography',
                    'label' => esc_html__( 'Typography', 'avas-core' ),
                    'selector' => '{{WRAPPER}} .tx_progress_title',
                    'separator' => 'before',
                ]
            );

        $this->end_controls_section(); // Progress Bar title style tab end

        // Progress Bar value style tab start
        $this->start_controls_section(
            'tx_progressbar_value_style',
            [
                'label'     => esc_html__( 'Value', 'avas-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'progress_value_postion',
                [
                    'label' => esc_html__( 'Position', 'avas-core' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__( 'Inner', 'avas-core' ),
                    'label_off' => esc_html__( 'Outer', 'avas-core' ),
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );
            $this->add_control(
                'progressbar_value_color',
                [
                    'label'     => esc_html__( 'Color', 'avas-core' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .tx-progressbar-content .percent-label' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_responsive_control(
                'progressbar_value_padding',
                [
                    'label' => esc_html__( 'Padding', 'avas-core' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .tx-progressbar-content .percent-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'progressbar_value_border',
                    'label' => esc_html__( 'Border', 'avas-core' ),
                    'selector' => '{{WRAPPER}} .tx-progressbar-content .percent-label',
                ]
            );

            $this->add_responsive_control(
                'progressbar_value_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'avas-core' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .tx-progressbar-content .percent-label' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'progressbar_value_box_shadow',
                    'label' => esc_html__( 'Box Shadow', 'avas-core' ),
                    'selector' => '{{WRAPPER}} .tx-progressbar-content .percent-label',
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'progressbar_value_typography',
                    'label' => esc_html__( 'Typography', 'avas-core' ),
                    'selector' => '{{WRAPPER}} .tx-progress-bar-wrapper .tx-progressbar-content .percent-label',
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'progressbar_value_position',
                [
                    'label' => esc_html__( 'Position', 'avas-core' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -100,
                            'max' => 100,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .tx-progress-bar-wrapper .tx-progressbar-content .percent-label' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'tx_progress_bar_style' =>'horizontal',
                        'progress_value_postion!' => 'yes'
                    ],

                ]
            );

        $this->end_controls_section(); // Progress Bar value style tab end


    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();
        $progressbar_list = $settings['tx_progressbar_list'];
        $progress_type_class = ( $settings['tx_progress_bar_type'] == 'striped' ) ? 'tx-progress-bar-striped ' : '';

        
            if( $settings['tx_progressbar_list'] ) {
              
                foreach ( $settings['tx_progressbar_list'] as $key => $item ) {

                    $column_repeater_key = $this->get_repeater_setting_key( 'tx_progressbar_title', 'tx_progressbar_list', $key );

                    $this->add_render_attribute( $column_repeater_key, 'class', 'tx-progress-bar-wrapper' );
                    $this->add_render_attribute( $column_repeater_key, 'class', 'tx-progress-bar-style-'. esc_attr( $settings['tx_progress_bar_style'] ) );

                    if( $settings['progress_value_postion'] == 'yes' ) {
                        $this->add_render_attribute( $column_repeater_key, 'class', 'tx-progress-value-inner' );
                    }
                    if( $settings['progress_text_postion'] == 'yes' ) {
                        $this->add_render_attribute( $column_repeater_key, 'class', 'tx-progress-text-inner' );
                    }

                    $this->add_render_attribute( $column_repeater_key, 'class', 'elementor-repeater-item-'. esc_attr( $item['_id'] ) );
                    if( $item['progressbar_before_after'] == 'yes' ) {
                        $this->add_render_attribute( $column_repeater_key, 'class', 'tx-progressbar-value-bottom' );
                    }

                    if( $settings['progress_bar_indicator'] == 'yes' ) {
                        $this->add_render_attribute( $column_repeater_key, 'class', 'tx-progress-indicator' );
                    }
                    ?>

                    <div <?php echo $this->get_render_attribute_string( $column_repeater_key ); ?> >
                        <p class="tx_progress_title"><?php echo wp_kses_post( $item['tx_progressbar_title'] );?></p>
                        <div class="tx-progressbar-content">
                            <div class="tx-progress-bar wow <?php echo esc_attr( $progress_type_class ); if( $settings['tx_progress_bar_style'] == 'vertical' ){ echo esc_attr('fadeInUp'); }else{ echo esc_attr('fadeInLeft'); } ?>" data-wow-duration="2s" data-wow-delay="0" role="progressbar"
                                style="<?php if( $settings['tx_progress_bar_style'] == 'vertical' ){ echo 'height:'.esc_attr( $item['tx_progressbar_value']['size'] ).'%';} else{ echo 'width:'.esc_attr( $item['tx_progressbar_value']['size'] ).'%'; }?>;" aria-valuenow="<?php echo esc_attr( $item['tx_progressbar_value']['size'] );?>" aria-valuemin="0" aria-valuemax="100">
                                <span class="percent-label"><?php echo esc_attr( $item['tx_progressbar_value']['size'] ).'%';?></span>
                            </div>
                        </div>
                    </div>

            <?php
                } // End foreach
            }

    }
}