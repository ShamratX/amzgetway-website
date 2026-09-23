<?php
namespace AvasElements\Modules\Wishlist\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use elementor\Group_Control_Typography;
use WPcleverWoosw;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Wishlist extends Widget_Base {

    public function get_name() {
        return 'avas-wishlist';
    }

    public function get_title() {
        return esc_html__( 'Avas Wishlist', 'avas-core' );
    }

    public function get_icon() {
        return 'eicon-cart';
    }

    public function get_categories() {
        return [ 'avas-elements' ];
    }
    
    protected function register_controls() {
        $this->start_controls_section(
            'settings_sec',
            [
                'label' => esc_html__( 'Settings', 'avas-core' )
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
                    '{{WRAPPER}} .tx-wishlist' => 'text-align: {{VALUE}};',
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
        $this->add_responsive_control(
            'wishlist_icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-wishlist .tx-whishlist-icon i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'wishlist_count_color',
            [
                'label' => esc_html__( 'Count Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-wishlist .tx-whishlist-icon .tx-count:after' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'wishlist_count_bg_color',
            [
                'label' => esc_html__( 'Count Background Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-wishlist .tx-whishlist-icon .tx-count:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'wishlist_icon_size',
                [
                    'label' => esc_html__( 'Icon Size', 'avas-core' ),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 300,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .tx-wishlist .tx-whishlist-icon i' => 'font-size: {{SIZE}}px;',
                    ],
                ]
        );
        $this->add_responsive_control(
            'wishlist_count_size',
                [
                    'label' => esc_html__( 'Item Count Size', 'avas-core' ),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 300,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .tx-wishlist .tx-whishlist-icon .tx-count:after' => 'width: {{SIZE}}px;height: {{SIZE}}px;',
                    ],
                ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'wishlist_count_typography',
                'selector' => '{{WRAPPER}} .tx-wishlist .tx-whishlist-icon .tx-count:after',
            ]
        );
        $this->add_responsive_control(
            'wishlist_count_position_y',
                [
                    'label' => esc_html__( 'Item Count Position (Y)', 'avas-core' ),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => -300,
                            'max' => 300,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .tx-whishlist-icon .tx-count:after' => 'top: {{SIZE}}px;',
                    ],
                ]
        );
        $this->add_responsive_control(
            'wishlist_count_position_x',
                [
                    'label' => esc_html__( 'Item Count Position (X)', 'avas-core' ),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => -300,
                            'max' => 300,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .tx-whishlist-icon .tx-count:after' => 'left: {{SIZE}}px;',
                    ],
                ]
        );

        $this->end_controls_section();
    }

    protected function render( ) {
        if ( class_exists( 'WooCommerce' ) && is_plugin_active('woo-smart-wishlist/wpc-smart-wishlist.php') ) :
        $settings = $this->get_settings();
    ?>
        <div class="tx-wishlist">
            <a class="tx-whishlist-icon" href="<?php echo esc_url(WPcleverWoosw::get_url());?>"><i class="bi bi-heart"></i><span class="tx-count" data-count="<?php echo esc_attr(WPcleverWoosw::get_count());?>"></span></a>
        </div>



        <?php    
        else: 
        echo '<h4 class="text-align-center">' . esc_html__( 'Please install and activate "WooCoommerce" and "WPC Smart Wishlist for WooCommerce" plugins', 'avas-core' ) . '</h4>';
        endif; // class WooCommerce
    } // render()
}
