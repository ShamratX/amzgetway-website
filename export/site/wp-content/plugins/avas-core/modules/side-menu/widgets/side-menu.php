<?php
namespace AvasElements\Modules\SideMenu\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class SideMenu extends Widget_Base {

    public function get_name() {
        return 'avas-side-menu';
    }

    public function get_title() {
        return esc_html__( 'Avas Side Menu', 'avas-core' );
    }

    public function get_icon() {
        return 'eicon-menu-bar';
    }

    public function get_categories() {
        return [ 'avas-elements' ];
    }

    
	protected function register_controls() {

        $this->start_controls_section(
            'settings_secs',
            [
                'label' => esc_html__( 'Settings', 'avas-core' )
            ]
        );
        $this->add_control(
            'sm_icon_switch',
            [
                'label' => esc_html__( 'Icon Library', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'yes' => [
                        'title' => esc_html__( 'Enable', 'avas-core' ),
                        'icon' => 'eicon-check',
                    ],
                    'no' => [
                        'title' => esc_html__( 'Disable', 'avas-core' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'no',

            ]
        );
        $this->add_control(
            'sm_icon',
            [
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-bars',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'sm_icon_switch' => 'yes'
                ]
            ]
        );
        $this->add_responsive_control(
            'align',
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
                'selectors' => [
                    '{{WRAPPER}} #side-menu-icon' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'style_settings',
            [
                'label' => esc_html__( 'Style', 'avas-core' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_control(
            'sm_icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #side-menu-icon' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'sm_icon_hov_color',
            [
                'label' => esc_html__( 'Icon Hover Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #side-menu-icon:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'sm_close_color',
            [
                'label' => esc_html__( 'Close Icon Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .side-menu .s-menu-icon-close' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'sm_icon_size',
                [
                    'label' => esc_html__( 'Icon Size', 'avas-core' ),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 300,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} #side-menu-icon i' => 'font-size: {{SIZE}}px;',
                    ],
                ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'sm_bg_color',
                'selector'  => '{{WRAPPER}} #side-menu-wrapper',
            ]
        );
        $this->add_control(
            'sm_text_color',
            [
                'label' => esc_html__( 'Text Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #side-menu-wrapper' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'sm_link_color',
            [
                'label' => esc_html__( 'Link Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .side-menu a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'sm_link_hov_color',
            [
                'label' => esc_html__( 'Link Hover Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .side-menu a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

    }

	protected function render( ) {
       
        $settings = $this->get_settings();
        if( 'yes'=== $settings['sm_icon_switch'] ) :
    ?>
    <a id="side-menu-icon" class="side_menu_icon" data-toggle="collapse" href="#side-menu-wrapper" role="button" aria-expanded="false" aria-controls="side-menu-wrapper">
        <?php Icons_Manager::render_icon( $settings['sm_icon'], [ 'aria-hidden' => 'true' ] ); ?>
    </a>
    <?php else: ?>
    <a id="side-menu-icon" class="side_menu_icon" data-toggle="collapse" href="#side-menu-wrapper" role="button" aria-expanded="false" aria-controls="side-menu-wrapper"><i class="bi bi-list"></i></a>

    <!-- Side menu -->
    <?php get_template_part( 'template-parts/header/menu/side', 'menu' ); ?>


<?php 
endif;   
    } // render()
}
