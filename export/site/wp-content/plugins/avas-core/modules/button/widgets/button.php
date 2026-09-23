<?php
namespace AvasElements\Modules\Button\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Button extends Widget_Base {

    public function get_name() {
        return 'avas-button';
    }

    public function get_title() {
        return esc_html__( 'Avas Button', 'avas-core' );
    }

    public function get_icon() {
        return 'eicon-button';
    }

    public function get_categories() {
        return [ 'avas-elements' ];
    }

    public function get_keywords() {
        return [ 'button' ];
    }
    
    protected function register_controls() {
        $this->start_controls_section(
            'btn_settings',
            [
                'label' => esc_html__( 'Settings', 'avas-core' ),
            ]
        );
        $this->add_control(
            'btn_style',
            [
                'label' => esc_html__( 'Style', 'avas-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'style-0'  => esc_html__( 'Style 0', 'avas-core' ),
                    'style-1'  => esc_html__( 'Style 1', 'avas-core' ),
                    'style-2'  => esc_html__( 'Style 2', 'avas-core' ),
                    'style-3'  => esc_html__( 'Style 3', 'avas-core' ),
                    'style-4'  => esc_html__( 'Style 4', 'avas-core' ),
                    'style-5'  => esc_html__( 'Style 5', 'avas-core' ),
                ],
                'default' => 'style-1',

            ]
        );
        $this->add_control(
            'btn_txt',
            [
                'label'             => esc_html__( 'Button Text', 'avas-core' ),
                'type'              => Controls_Manager::TEXT,
                'default'           => esc_html__( 'HOVER ME', 'avas-core' ),
            ]
        );
        $this->add_control(
            'btn_txt_2',
            [
                'label'             => esc_html__( 'Hover Text', 'avas-core' ),
                'type'              => Controls_Manager::TEXT,
                'default'           => esc_html__( 'CLICK ME', 'avas-core' ),
                'condition'         => [            
                    'btn_style' => [
                        'style-3',
                        'style-5',
                    ]

                ]
            ]
        );
        $this->add_control(
            'btn_link_url',
            [
                'label'       => esc_html__( 'Link URL', 'avas-core' ),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'http://your-link.com',
                'default'     => [
                    'url' => '#',
                ],
            ]
        );
        $this->add_control(
            'selected_icon',
            [
                'label' => esc_html__( 'Icon', 'avas-core' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'skin' => 'inline',
                'label_block' => false,
            ]
        );

        $this->add_responsive_control(
            'icon_align',
            [
                'label' => esc_html__( 'Icon Position', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'avas-core' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'avas-core' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'condition' => [ 
                    'selected_icon[value]!' => '' 
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'max' => 300,
                    ],
                    'em' => [
                        'max' => 25,
                    ],
                    'rem' => [
                        'max' => 25,
                    ],
                ],
                'default' => [
                    'size' => 14,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-btn-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tx-btn-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [ 
                    'selected_icon[value]!' => '' 
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_indent',
            [
                'label' => esc_html__( 'Icon Spacing', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'max' => 300,
                    ],
                    'em' => [
                        'max' => 25,
                    ],
                    'rem' => [
                        'max' => 25,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-btn-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tx-btn-align-left' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [ 
                    'selected_icon[value]!' => '' 
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_vertical_alignment',
            [
                'label' => esc_html__( 'Icon Vertical Alignment', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => -10,
                        'max' => 10,
                    ],
                    'rem' => [
                        'min' => -10,
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-btn-icon i' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tx-btn-icon svg' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [ 
                    'selected_icon[value]!' => '' 
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_width',
            [
                'label'                 => esc_html__( 'Width', 'avas-core' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'max'   => 1500,
                    ],
                ],
                'size_units'            => [ 'px', '%' ],
                'selectors'             => [
                    '{{WRAPPER}} .tx-btn-link' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'separator' => 'before'

            ]
        );
        $this->add_responsive_control(
            'btn_height',
            [
                'label'                 => esc_html__( 'Height', 'avas-core' ),
                'description'                 => esc_html__( 'Adjust the Line Height from Typography to set the text middle', 'avas-core' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'max'   => 500,
                    ],
                ],
                'size_units'            => [ 'px', '%' ],
                'selectors'             => [
                    '{{WRAPPER}} .tx-btn-link' => 'height: {{SIZE}}{{UNIT}}',
                ],

            ]
        );
        $this->add_responsive_control(
            'btn_alignment',
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
                    '{{WRAPPER}} .tx-btn-wrap'   => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .tx-btn-wrap'   => 'justify-content: {{VALUE}};',
                ],
                'separator' => 'before'

            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'btn_styles',
            [
                'label'                 => esc_html__( 'Style', 'avas-core' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs( 'btn_tabs' );

        $this->start_controls_tab(
            'btn_tab_normal',
            [
                'label' => esc_html__( 'Normal', 'avas-core' ),
            ]
        );
        $this->add_control(
            'btn_color',
            [
                'label' => esc_html__('Color', 'avas-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-btn-wrap .tx-btn-link' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tx-btn-wrap .tx-btn-link svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'btn_bg_color',
            [
                'label' => esc_html__('Background Color', 'avas-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-btn-link' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'btn_style!' => ['style-2']
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_background',
                'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ],
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                ],
                'selector' => '{{WRAPPER}} .tx-btn-link',
                'condition' => [
                    'btn_style!' => ['style-2']
                ],
            ]
        );
        $this->add_control(
            'btn_broder_color',
            [
                'label' => esc_html__('Border Color', 'avas-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-btn-wrap.style-1 .tx-btn-link' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'btn_style' => 'style-1'
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_broder_size',
            [
                'label' => esc_html__( 'Border Size', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'max'  => 20,
                    ],

                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-btn-wrap.style-1 .tx-btn-link' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'btn_style' => 'style-1'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'btn_typo',
                'selector'  => '{{WRAPPER}} .tx-btn-link',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'      => 'btn_text_shadow',
                'label'     => esc_html__( 'Text Shadow', 'avas-core' ),
                'selector'  => '{{WRAPPER}} .tx-btn-link, {{WRAPPER}} .tx-btn-icon i',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'btn_box_shadow',
                'selector' => '{{WRAPPER}} .tx-btn-link'
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'btn_border',
                'selector'    =>    '{{WRAPPER}} .tx-btn-link',
                'condition' => [
                    'btn_style!' => ['style-1','style-3','style-5']
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_border_radius',
            [
                'label'   => esc_html__( 'Border Radius', 'avas-core' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'max'  => 100,
                    ],

                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-btn-link'   => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'btn_style!' => ['style-1','style-2','style-3','style-5']
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_padding',
            [
                'label'         => esc_html__( 'Padding', 'avas-core' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .tx-btn-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'btn_style!' => ['style-3','style-5']
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_margin',
            [
                'label'         => esc_html__( 'Margin', 'avas-core' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .tx-btn-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'btn_tab_hover',
            [
                'label' => esc_html__( 'Hover', 'avas-core' ),
            ]
        );
        $this->add_control(
            'btn_hov_color',
            [
                'label' => esc_html__('Color', 'avas-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-btn-wrap .tx-btn-link:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tx-btn-wrap .tx-btn-link:hover svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'btn_bg_hov_color',
            [
                'label' => esc_html__('Background Color', 'avas-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-btn-wrap.style-0 .tx-btn-link:hover, {{WRAPPER}} .tx-btn-wrap.style-1 .tx-btn-link:hover, {{WRAPPER}} .tx-btn-wrap.style-2 .tx-btn-link:after, {{WRAPPER}} .tx-btn-wrap.style-3:hover .tx-btn-link, {{WRAPPER}} .tx-btn-wrap.style-3 .tx-btn-link:before, {{WRAPPER}} .tx-btn-wrap.style-4 .tx-btn-link:hover, {{WRAPPER}} .tx-btn-wrap.style-5 .tx-btn-link:before' => 'background-color: {{VALUE}};',
                ],
                
            ]
        );
         $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_hov_background',
                'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ],
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                ],
                'selector' => '{{WRAPPER}} .tx-btn-wrap.style-0 .tx-btn-link:hover, {{WRAPPER}} .tx-btn-wrap.style-1 .tx-btn-link:hover, {{WRAPPER}} .tx-btn-wrap.style-2 .tx-btn-link:after, {{WRAPPER}} .tx-btn-wrap.style-3:hover .tx-btn-link, {{WRAPPER}} .tx-btn-wrap.style-3 .tx-btn-link:before, {{WRAPPER}} .tx-btn-wrap.style-4 .tx-btn-link:hover, {{WRAPPER}} .tx-btn-wrap.style-5 .tx-btn-link:before',
            ]
        );
        $this->add_control(
            'btn_broder_hover_color',
            [
                'label' => esc_html__('Border Color', 'avas-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-btn-wrap.style-1 .line-1, {{WRAPPER}} .tx-btn-wrap.style-1 .line-2, {{WRAPPER}} .tx-btn-wrap.style-1 .line-3, {{WRAPPER}} .tx-btn-wrap.style-1 .line-4' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .tx-btn-wrap.style-0 .tx-btn-link:hover, {{WRAPPER}} .tx-btn-wrap.style-4 .tx-btn-link:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'btn_style' => ['style-0', 'style-1', 'style-4']
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_broder_hover_size',
            [
                'label' => esc_html__( 'Border Hover Size', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'max'  => 20,
                    ],

                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-btn-wrap.style-1 .line-1, {{WRAPPER}} .tx-btn-wrap.style-1 .line-3' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tx-btn-wrap.style-1 .line-2, {{WRAPPER}} .tx-btn-wrap.style-1 .line-4' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'btn_style' => 'style-1'
                ],
            ]
        );
        $this->add_control(
            'hover_animation',
            [
                'label' => esc_html__( 'Hover Animation', 'avas-core' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
                'condition' => [
                    'btn_style' => ['style-0']
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
        $is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
        $target = $settings['btn_link_url']['is_external'] ? '_blank' : '_self';

        if ( ! empty( $settings['btn_link_url']['url'] ) ) :
            $this->add_render_attribute( 'btn-link', 'href', $settings['btn_link_url']['url'] );
        endif;

        if ( ! empty( $settings['hover_animation'] ) ) {
            $this->add_render_attribute( 'btn-link', 'class', 'elementor-animation-' . $settings['hover_animation'] );
        }

        $this->add_render_attribute( [
            'button-wrapper' => [
                'class' => [
                    'tx-btn-wrap',
                    $settings['btn_style'],
                ]
            ],
            'icon-align' => [
                'class' => [
                    'tx-btn-icon',
                    'tx-btn-align-' . $settings['icon_align'],
                ],
            ],
            'btn-link' => [
                'class' => [
                    'tx-btn-link',
                ],
            ]

        ] );


        ?>

        <div <?php $this->print_render_attribute_string( 'button-wrapper' ); ?>>
            
           <a data-hover="<?php echo esc_attr($settings['btn_txt_2']); ?>" <?php echo $this->get_render_attribute_string( 'btn-link' ); ?> target="<?php echo esc_attr($target); ?>" >

            <?php if ( ! empty( $settings['icon'] ) || ! empty( $settings['selected_icon']['value'] ) && ('left' === $settings['icon_align']) ) : ?>
            <span <?php $this->print_render_attribute_string( 'icon-align' ); ?>>
                <?php if ( $is_new || $migrated ) :
                    Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
                else : ?>
                    <i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
                <?php endif; ?>
            </span>
            <?php endif; ?>

            <?php echo esc_attr( $settings['btn_txt'] ); ?>

            <?php if ( ! empty( $settings['icon'] ) || ! empty( $settings['selected_icon']['value'] ) && ('right' === $settings['icon_align']) ) : ?>
            <span <?php $this->print_render_attribute_string( 'icon-align' ); ?>>
                <?php if ( $is_new || $migrated ) :
                    Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
                else : ?>
                    <i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
                <?php endif; ?>
            </span>
            <?php endif; ?>

            <?php if( 'style-1' === $settings['btn_style'] ): ?>
                <span class="line-1"></span>
                <span class="line-2"></span>
                <span class="line-3"></span>
                <span class="line-4"></span>
            <?php endif; ?>

           </a>
          
        </div><!-- tx-btn-wrap -->
        
        
<?php } // render()

} // class
