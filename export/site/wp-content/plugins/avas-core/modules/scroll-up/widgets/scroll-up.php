<?php
namespace AvasElements\Modules\ScrollUp\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class ScrollUp extends Widget_Base {

	public function get_name() {
		return 'avas-scroll-up';
	}

	public function get_title() {
		return esc_html__( 'Avas Scroll Up', 'avas-core' );
	}

	public function get_icon() {
		return 'eicon-button';
	}

	public function get_categories() {
		return [ 'avas-elements' ];
	}

	public function get_keywords() {
		return [ 'scroll up', 'back to top', 'scroll to top' ];
	}

    public function get_style_depends() {
        return [ 'tx-scroll-up' ];
    }
    public function get_script_depends() {
        return ['tx-scroll-up'];
    }
	
	protected function register_controls() {
        $this->start_controls_section(
            'section_content_scroll_button',
            [
                'label' => esc_html__( 'Button', 'avas-core' ),
            ]
        );

        $this->add_control(
            'scroll_button_text',
            [
                'label'       => esc_html__( 'Button Text', 'avas-core' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [ 'active' => true ],
                'default'     => esc_html__( 'Scroll Up', 'avas-core' ),
            ]
        );

        $this->add_responsive_control(
            'scroll_button_align',
            [
                'label'        => esc_html__( 'Button Alignment', 'avas-core' ),
                'type'         => Controls_Manager::CHOOSE,
                'prefix_class' => 'elementor%s-align-',
                'default'      => 'center',
                'options'      => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'avas-core' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'avas-core' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'avas-core' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justified', 'avas-core' ),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'condition' => [
                    'scroll_button_position' => '',
                ],
            ]
        );

        $this->add_control(
            'button_icon',
            [
                'label'       => esc_html__( 'Button Icon', 'avas-core' ),
                'type'        => Controls_Manager::ICONS,
                'fa4compatibility' => 'scroll_button_icon',
                'default' => [
                    'value' => 'fas fa-angle-up',
                    'library' => 'fa-solid',
                ],
                'skin' => 'inline',
                'label_block' => false
            ]
        );

        $this->add_control(
            'icon_align',
            [
                'label'   => esc_html__( 'Icon Position', 'avas-core' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'left'  => esc_html__( 'Before', 'avas-core' ),
                    'right' => esc_html__( 'After', 'avas-core' ),
                ],
                'condition' => [
                    'button_icon[value]!' => '',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_size',
            [
                'label'   => esc_html__( 'Icon Size', 'avas-core' ),
                'type'    => Controls_Manager::SLIDER,
                // 'default' => [
                //     'size' => 8,
                // ],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'condition' => [
                    'button_icon[value]!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-scroll-up-btn i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tx-scroll-up-btn svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_indent',
            [
                'label'   => esc_html__( 'Icon Spacing', 'avas-core' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 8,
                ],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'condition' => [
                    'button_icon[value]!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-scroll-up-btn .tx-scroll-up-btn-align-icon-right' => is_rtl() ? 'margin-right: {{SIZE}}{{UNIT}};' : 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tx-scroll-up-btn .tx-scroll-up-btn-align-icon-left'  => is_rtl() ? 'margin-left: {{SIZE}}{{UNIT}};' : 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'txnav_position',
            [
                'label' => esc_html__( 'Position', 'avas-core' ),
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
            ]
        );
        $this->add_responsive_control(
            'txnav_alignment',
            [
                'label' => esc_html__( 'Alignment', 'avas-core' ),
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
                'default' => 'tx-nav-right',
            ]
        );

        $this->add_responsive_control(
            'txnav_spacing_y',
            [
                'label' => esc_html__( 'Y', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'default' => [
                    'size' => 30,
                ],
                'range' => [
                    'px' => [
                        'max' => 200,
                    ],
                   
                ],
                'condition' => [
                    'txnav_alignment!' => 'tx-nav-center',
                    'txnav_position!' => 'tx-nav-middle',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-scroll-up-wrap.tx-nav-top' => 'top: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tx-scroll-up-wrap.tx-nav-bottom' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'txnav_spacing_x',
            [
                'label' => esc_html__( 'X', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'default' => [
                    'size' => 30,
                ],
                'range' => [
                    'px' => [
                        'max' => 200,
                    ],
                   
                ],
                'condition' => [
                    'txnav_alignment!' => 'tx-nav-center',
                    'txnav_position!' => 'tx-nav-middle',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-scroll-up-wrap.tx-nav-left' => 'left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tx-scroll-up-wrap.tx-nav-right' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'scroll_up_section_zindex',
            [
                'label'     => esc_html__('Z-Index', 'avas-core'),
                'type'      => Controls_Manager::NUMBER,
                'min' => -1000,
                'max' => 9999,
                'selectors'  => [
                    '{{WRAPPER}} .tx-scroll-up-wrap' => 'z-index: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_scroll_button',
            [
                'label' => esc_html__( 'Button', 'avas-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_scroll_button_style' );

        $this->start_controls_tab(
            'tab_scroll_button_normal',
            [
                'label' => esc_html__( 'Normal', 'avas-core' ),
            ]
        );

        $this->add_control(
            'scroll_button_text_color',
            [
                'label'     => esc_html__( 'Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-scroll-up-btn' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tx-scroll-up-btn svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'scroll_button_background_color',
                'label' => esc_html__( 'Background Color', 'avas-core' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .tx-scroll-up-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'scroll_button_border',
                'label'       => esc_html__( 'Border', 'avas-core' ),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .tx-scroll-up-btn',
                'separator'   => 'before',
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'avas-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tx-scroll-up-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'scroll_button_padding',
            [
                'label'      => esc_html__( 'Padding', 'avas-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tx-scroll-up-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'scroll_button_typography',
                'label'    => esc_html__( 'Typography', 'avas-core' ),
                'selector' => '{{WRAPPER}} .tx-scroll-up-btn',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'scroll_button_box_shadow',
                'selector' => '{{WRAPPER}} .tx-scroll-up-btn',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_scroll_button_hover',
            [
                'label' => esc_html__( 'Hover', 'avas-core' ),
            ]
        );

        $this->add_control(
            'scroll_button_hover_color',
            [
                'label'     => esc_html__( 'Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-scroll-up-btn:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tx-scroll-up-btn:hover svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'scroll_button_background_hover_color',
                'label' => esc_html__( 'Background Color', 'avas-core' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .tx-scroll-up-btn:hover',
            ]
        );

        $this->add_control(
            'scroll_button_hover_border_color',
            [
                'label'     => esc_html__( 'Border Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'scroll_button_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-scroll-up-btn:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    

    protected function render() {

        $settings = $this->get_settings_for_display();

        if ( ! isset( $settings['scroll_button_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
            // add old default
            $settings['scroll_button_icon'] = 'fas fa-arrow-down';
        }

        $migrated  = isset( $settings['__fa4_migrated']['button_icon'] );
        $is_new    = empty( $settings['scroll_button_icon'] ) && Icons_Manager::is_migration_allowed();

        ?>
        <div class="tx-scroll-up-wrap <?php echo $settings['txnav_position'] . ' ' . $settings['txnav_alignment']; ?>">
            <button class="tx-scroll-up-btn">
                <span class="tx-scroll-up-btn-content-wrapper">
                    <?php if ( ! empty( $settings['button_icon']['value'] ) ) : ?>
                    <span class="tx-scroll-up-btn-align-icon-<?php echo esc_attr($settings['icon_align']); ?>">

                        <?php if ( $is_new || $migrated ) :
                            Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
                        else : ?>
                            <i class="<?php echo esc_attr( $settings['scroll_button_icon'] ); ?>" aria-hidden="true"></i>
                        <?php endif; ?>

                    </span>
                    <?php endif; ?>
                    <span class="tx-scroll-up-btn-text"><?php echo esc_html($settings['scroll_button_text']); ?></span>
                </span>
            </button>
        </div>

        <?php
    }

    
}
