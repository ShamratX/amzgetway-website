<?php
namespace AvasElements\Modules\PortfolioPlus\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use AvasElements\TX_Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PortfolioPlus extends Widget_Base {

    public function get_name() {
        return 'avas-portfolio-plus';
    }

    public function get_title() {
        return esc_html__( 'Avas Portfolio Plus', 'avas-core' );
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_categories() {
        return [ 'avas-elements' ];
    }

    public function get_script_depends() {
        return [ 'tx-isotope', 'tx-imagesloaded','infinite-scroll' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'settings',
            [
                'label' => esc_html__( 'Settings', 'avas-core' )
            ]
        );
        $this->add_control(
            'post_type',
            [
                'label' => esc_html__('Post Types', 'avas-core'),
                'type' => Controls_Manager::SELECT,
                'description' => esc_html__('If you could not see any Portfolio item then please add Portfolio via WordPress Dashboard > Portfolio > Add New Portfolio','avas-core'),
                'default' => 'portfolio',
                'options' => TX_Helper::get_all_post_types(),
            ]
        );
        $this->add_control(
            'portfolio_filter',
            [
                'label' => esc_html__( 'Category Filter', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'yes' => [
                        'title' => esc_html__( 'Yes', 'avas-core' ),
                        'icon' => 'eicon-check',
                    ],
                    'no' => [
                        'title' => esc_html__( 'No', 'avas-core' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'portfolio_filter_all_text',
            [
                'label'   => esc_html__( 'Filter "All" text', 'avas-core' ),
                'type'    => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default'     => 'All',
                'label_block' => true,
                'condition' => [
                       'portfolio_filter' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'tax_query',
            [
                'label' => esc_html__( 'Categories', 'avas-core' ),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => TX_Helper::get_all_categories(),
                'condition' => [
                       'portfolio_filter' => 'no'
                ]
            ]
        );
        $this->add_control(
            'display',
            [
                'label'     => esc_html__( 'Style', 'avas-core' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'card-h',
                'options'   => [
                        'masonry'    => esc_html__('Masonry','avas-core'),
                        'grid-h'    => esc_html__('Grid Horizontal','avas-core'),
                        'grid-v'    => esc_html__('Grid Vertical','avas-core'),
                        'card-h'    => esc_html__('Card Horizontal','avas-core'),
                        'card-v'    => esc_html__('Card Vertical','avas-core'),
                    ],
            ]
        );
        $this->add_responsive_control(
            'portfolio_plus_columns',
            [
                'label' => esc_html__( 'Columns', 'avas-core' ),
                'label_block' => true,
                'type' => Controls_Manager::SELECT,             
                'desktop_default' => '33.330%',
                'mobile_default' => '100%',
                'options' => [
                    '100%' => esc_html__( '1 Column', 'avas-core' ),
                    '50%' => esc_html__( '2 Columns', 'avas-core' ),
                    '33.330%' => esc_html__( '3 Columns', 'avas-core' ),
                    '25%' => esc_html__( '4 Columns', 'avas-core' ),
                    '20%' => esc_html__( '5 Columns', 'avas-core' ),
                    '16.67%' => esc_html__( '6 Columns', 'avas-core' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-portfolio-item' => 'width: {{VALUE}};',
                ],
                'render_type' => 'template'
            ]
        );
        $this->add_responsive_control(
            'gap',
            [
                'label'     => esc_html__( 'Gap', 'avas-core' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units'  => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => 15,
                    'right' => 15,
                    'bottom' => 15,
                    'left' => 15,
                    'unit' => 'px',
                ],
                'selectors'   => [
                    '{{WRAPPER}} .tx-portfolio-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'number_of_posts',
            [
                'label' => esc_html__( 'Number of Posts', 'avas-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 6,
               
            ]
        );
        $this->add_control(
            'offset',
            [
              'label'         => esc_html__( 'Offset', 'avas-core' ),
              'type'          => Controls_Manager::NUMBER,
            ]
        );
        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'avas-core'),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'ASC' => esc_html__('Ascending', 'avas-core'),
                    'DESC' => esc_html__('Descending', 'avas-core'),
                ),
                'default' => 'DESC',
            ]
        );
        $this->add_control(
            'post_sortby',
            [
                'label'     => esc_html__( 'Post sort by', 'avas-core' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'latestpost',
                'options'   => [
                        'latestpost'      => esc_html__( 'Latest posts', 'avas-core' ),
                        'popularposts'    => esc_html__( 'Popular posts', 'avas-core' ),
                        'mostdiscussed'    => esc_html__( 'Most discussed', 'avas-core' ),
                    ],
            ]
        );
        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Order By', 'avas-core'),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'none' => esc_html__('No order', 'avas-core'),
                    'ID' => esc_html__('Post ID', 'avas-core'),
                    'author' => esc_html__('Author', 'avas-core'),
                    'title' => esc_html__('Title', 'avas-core'),
                    'date' => esc_html__('Published date', 'avas-core'),
                    'modified' => esc_html__('Modified date', 'avas-core'),
                    'parent' => esc_html__('By parent', 'avas-core'),
                    'rand' => esc_html__('Random order', 'avas-core'),
                    'comment_count' => esc_html__('Comment count', 'avas-core'),
                    'menu_order' => esc_html__('Menu order', 'avas-core'),
                ),
                'default' => 'date',
                'condition' => [
                    'post_sortby' => ['latestpost'],
                ],
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Yes', 'avas-core' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'No', 'avas-core' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show',
                'condition' => [
                    'display' => ['card-h', 'card-v']
                ]
            ]
        );
        $this->add_control(
          'title_limit',
          [
            'label'         => esc_html__( 'Title Letter Limit', 'avas-core' ),
            'type'          => Controls_Manager::NUMBER,
            'default'       => 50,
            'condition' => [
                'title' => 'show',
                'display' => ['card-h', 'card-v']
            ],
          ]
        );
        $this->add_control(
            'desc',
            [
                'label' => esc_html__( 'Description', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Yes', 'avas-core' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'No', 'avas-core' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'hide',
                'condition' => [
                    'display' => ['card-h', 'card-v']
                ]
            ]
        );
        $this->add_control(
          'desc_limit',
          [
            'label'         => esc_html__( 'Description Letter Limit', 'avas-core' ),
            'type'          => Controls_Manager::NUMBER,
            'default'       => 20,
            'condition' => [
                'desc' => 'show',
                'display' => ['card-h', 'card-v']
            ],
          ]
        );
        $this->add_control(
            'port_category',
            [
                'label' => esc_html__( 'Category', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Yes', 'avas-core' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'No', 'avas-core' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show',
                'condition' => [
                    'display' => ['card-h', 'card-v']
                ]
                
            ]
        );
        $this->add_control(
            'tx_portfolio_plus_hover_icons',
            [
                'label' => esc_html__( 'Hover Icons', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Yes', 'avas-core' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'No', 'avas-core' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show',
                
            ]
        );
        $this->add_control(
            'tx_portfolio_plus_popup',
            [
                'label' => esc_html__( 'Popup', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Yes', 'avas-core' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'No', 'avas-core' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show',
                'condition' => [
                    'tx_portfolio_plus_hover_icons' => ['hide'],
                    'display' => ['card-h', 'card-v']
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'pagination_settings',
            [
                'label' => esc_html__( 'Pagination', 'avas-core' )
            ]
        );
        $this->add_control(
            'pagination',
            [
                'label' => esc_html__( 'Pagination', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Yes', 'avas-core' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'No', 'avas-core' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show',
            ]
        );
        $this->add_control(
            'pagination_style',
            [
                'label' => esc_html__( 'Pagination', 'avas-core' ),
                'label_block' => true,
                'type' => Controls_Manager::SELECT,
                'default' => 'loadmore',
                'options' => [
                    'loadmore' => esc_html__( 'Load More', 'avas-core' ),
                    'numbering' => esc_html__( 'Numbering', 'avas-core' ),
                    
                ],
                'condition' => [
                    'pagination' => 'show',
                ],
            ]
        );
        $this->add_control(
            'pagination_load_more',
            [
                'label' => esc_html__( 'Load More Label', 'avas-core' ),
                'description' => esc_html__( 'Load More button will display in live page only.', 'avas-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'View More',
                'condition' => [
                    'pagination' => 'show',
                    'pagination_style' => 'loadmore'
                ],
            ]
        );
        $this->add_control(
            'pagination_no_post',
            [
                'label' => esc_html__( 'No More Posts Label', 'avas-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'No More Posts',
                'condition' => [
                    'pagination' => 'show',
                    'pagination_style' => 'loadmore'
                ],
            ]
        );
        $this->add_control(
            'pagination_numbering_prev',
            [
                'label' => esc_html__( 'Previous Label', 'avas-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Previous',
                'condition' => [
                    'pagination' => 'show',
                    'pagination_style' => 'numbering'
                ],
            ]
        );
        
        $this->add_control(
            'pagination_numbering_next',
            [
                'label' => esc_html__( 'Next Label', 'avas-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Next',
                'condition' => [
                    'pagination' => 'show',
                    'pagination_style' => 'numbering'
                ],
            ]
        );
    
      $this->end_controls_section();

      // style section started
        $this->start_controls_section(
            'styles',
            [
                'label'     => esc_html__( 'Styles', 'avas-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'portfolio_plus_border_radius',
            [
                'label' => esc_html__( 'Image Border Radius', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors' => [
                    '{{WRAPPER}} .tx-port-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
                'card_bg_color', 
                [
                    'label'     => esc_html__( 'Content Background Color', 'avas-core' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .tx-portfolio-plus-card-content' => 'background-color: {{VALUE}};',
                    ],
                    'condition' => [
                        'display' => ['card-h', 'card-v']
                    ],
                    'separator' => 'before',
                ]
        );
        $this->add_responsive_control(
            'portfolio_plus_content_padding',
            [
                'label' => esc_html__( 'Content Padding', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors' => [
                    '{{WRAPPER}} .tx-portfolio-plus-card-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'display' => ['card-h', 'card-v']
                ]
            ]
        );
        $this->add_responsive_control(
            'portfolio_plus_content_margin',
            [
                'label' => esc_html__( 'Content Margin', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors' => [
                    '{{WRAPPER}} .tx-portfolio-plus-card-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'display' => ['card-h', 'card-v']
                ]
            ]
        );
        $this->add_responsive_control(
            'portfolio_plus_content_border_radius',
            [
                'label' => esc_html__( 'Content Border Radius', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors' => [
                    '{{WRAPPER}} .tx-portfolio-plus-card-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'display' => ['card-h', 'card-v']
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'portfolio_plus_content_border',
                'selector' => '{{WRAPPER}} .tx-portfolio-plus-card-content'
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'portfolio_plus_content_shadow',
                'selector' => '{{WRAPPER}} .tx-portfolio-plus-card-content'
            ]
        );
        $this->add_responsive_control(
          'portfolio_plus_content_alignment',
          [
            'label' => esc_html__( 'Content Alignment', 'avas-core' ),
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
              ]
            ],
            'selectors' => [
              '{{WRAPPER}} .tx-portfolio-plus-card-content' => 'text-align: {{VALUE}};',
            ],
            'condition' => [
                    'display' => ['card-h', 'card-v']
                ]

          ]
        );
        $this->add_responsive_control(
            'title_color',
            [
                'label'     => esc_html__( 'Title Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-port-title' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'title' => 'show',
                    'display' => ['card-h', 'card-v']
                ],
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'title_color_hover',
            [
                'label'     => esc_html__( 'Title Hover Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-port-title a:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'title' => 'show',
                    'display' => ['card-h', 'card-v']
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'title_typography',
                   'selector'  => '{{WRAPPER}} .tx-port-title',
                   'condition' => [
                      'title' => 'show',
                      'display' => ['card-h', 'card-v']
                    ],
              ]
        );
        $this->add_responsive_control(
            'portfolio_plus_title_padding',
            [
                'label' => esc_html__( 'Tile Padding', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors' => [
                    '{{WRAPPER}} .tx-port-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'title' => 'show',
                    'display' => ['card-h', 'card-v']
                ],
            ]
        );
        $this->add_responsive_control(
            'desc_color',
            [
                'label'     => esc_html__( 'Description Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-port-excp' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'desc' => 'show',
                    'display' => ['card-h', 'card-v']
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'desc_typography',
                   'selector'  => '{{WRAPPER}} .tx-port-excp',
                   'condition' => [
                      'desc' => 'show',
                      'display' => ['card-h', 'card-v']
                    ],
              ]
        );
        $this->add_responsive_control(
            'cat_color',
            [
                'label'     => esc_html__( 'Category Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-portfolio-plus-category' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'port_category' => 'show',
                    'display' => ['card-h', 'card-v']
                ],
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'cat_color_hover',
            [
                'label'     => esc_html__( 'Category Hover Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-portfolio-plus-category:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'port_category' => 'show',
                    'display' => ['card-h', 'card-v']
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'cat_typography',
                   'selector'  => '{{WRAPPER}} .tx-portfolio-plus-category',
                   'condition' => [
                      'port_category' => 'show',
                      'display' => ['card-h', 'card-v']
                    ],
              ]
        );
        $this->add_responsive_control(
            'portfolio_plus_cat_padding',
            [
                'label' => esc_html__( 'Category Spacing', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors' => [
                    '{{WRAPPER}} .tx-portfolio-plus-category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'port_category' => 'show',
                    'display' => ['card-h', 'card-v']
                ],
            ]
        );
        $this->add_responsive_control(
            'tx_portfolio_plus_hover_icons_color',
            [
                'label'     => esc_html__( 'Hover Icon Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-portfolio-plus-modal-arrow-icon, {{WRAPPER}} .tx-portfolio-plus-link-arrow-icon, .tx-portfolio-plus-link-arrow, {{WRAPPER}} .tx-portfolio-plus-modal-arrow' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'tx_portfolio_plus_hover_icons' => 'show',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'tx_portfolio_plus_hover_icons_hover_color',
            [
                'label'     => esc_html__( 'Hover Icon Background Hover Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-portfolio-plus-modal-arrow-icon:hover, {{WRAPPER}} .tx-portfolio-plus-link-arrow-icon:hover, {{WRAPPER}} .tx-portfolio-plus-link-arrow:hover, {{WRAPPER}} .tx-portfolio-plus-modal-arrow:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'tx_portfolio_plus_hover_icons' => 'show',
                ],
            ]
        );
        $this->add_responsive_control(
            'tx_portfolio_plus_hover_icons_bg_color',
            [
                'label'     => esc_html__( 'Hover Icon BG Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-portfolio-plus-modal-arrow-icon, {{WRAPPER}} .tx-portfolio-plus-link-arrow-icon, {{WRAPPER}} .tx-portfolio-plus-link-arrow, {{WRAPPER}} .tx-portfolio-plus-modal-arrow' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'tx_portfolio_plus_hover_icons' => 'show',
                ],
            ]
        );
        $this->add_responsive_control(
            'tx_portfolio_plus_hover_icons_hover_bg_color',
            [
                'label'     => esc_html__( 'Hover Icon BG Hover Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-portfolio-plus-modal-arrow-icon:hover, {{WRAPPER}} .tx-portfolio-plus-link-arrow-icon:hover, {{WRAPPER}} .tx-portfolio-plus-link-arrow:hover, {{WRAPPER}} .tx-portfolio-plus-modal-arrow:hover' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'tx_portfolio_plus_hover_icons' => 'show',
                ],
            ]
        );
        $this->add_responsive_control(
            'tx_portfolio_plus_hover_icons_size',
            [
                'label' => esc_html__( 'Hover Icon Size', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 30,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-portfolio-plus-modal-arrow-icon, {{WRAPPER}} .tx-portfolio-plus-link-arrow-icon, {{WRAPPER}} .tx-portfolio-plus-link-arrow, {{WRAPPER}} .tx-portfolio-plus-modal-arrow' => 'font-size: {{SIZE}}{{UNIT}};padding: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                      'tx_portfolio_plus_hover_icons' => 'show',
                    ],
            ]
        );
        $this->add_responsive_control(
            'tx_portfolio_plus_hover_icons_title_space',
            [
                'label' => esc_html__( 'Hover Icon Title Spacing', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-portfolio-plus-link-arrow' => 'right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                      'display' => ['card-h', 'card-v']
                    ],
            ]
        );
        $this->add_responsive_control(
            'tx_portfolio_plus_hover_icons_spacing',
            [
                'label' => esc_html__( 'Hover Icon Spacing', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-portfolio-plus-modal-arrow-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tx-portfolio-plus-link-arrow-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                      'tx_portfolio_plus_hover_icons' => 'show',
                      'display!' => ['card-h', 'card-v']
                    ],
            ]
        );
        $this->add_responsive_control(
            'tx_portfolio_plus_hover_icons_padding',
                [
                    'label' => esc_html__( 'Hover Icon Padding', 'avas-core' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .tx-portfolio-plus-modal-arrow, {{WRAPPER}} .tx-portfolio-plus-link-arrow, {{WRAPPER}} .tx-portfolio-plus-modal-arrow-icon, {{WRAPPER}} .tx-portfolio-plus-link-arrow-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ],
                    'condition' => [
                      'tx_portfolio_plus_hover_icons' => 'show',
                      // 'display' => ['card-h', 'card-v']
                    ],
                ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'style_filter',
            [
                'label'     => esc_html__( 'Filter', 'avas-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                  'portfolio_filter' => 'yes'
                ]
            ]
        );
        $this->add_responsive_control(
            'category_filter_color',
            [
                'label'     => esc_html__( 'Filter Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .portfolio-filters li' => 'color: {{VALUE}};',
                ],
                'condition' => [
                  'portfolio_filter' => 'yes'
                ]

            ]
        );
        $this->add_responsive_control(
            'category_filter_hover_color',
            [
                'label'     => esc_html__( 'Filter Hover Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .portfolio-filters li:hover, {{WRAPPER}} .portfolio-filters li.active' => 'color: {{VALUE}};',
                ],
                'condition' => [
                  'portfolio_filter' => 'yes'
                ]

            ]
        );
        $this->add_responsive_control(
            'category_filter_bg_color',
            [
                'label'     => esc_html__( 'Filter Background Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .portfolio-filters li' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                  'portfolio_filter' => 'yes'
                ]

            ]
        );
        $this->add_responsive_control(
            'category_filter_bg_hover_color',
            [
                'label'     => esc_html__( 'Filter Background Hover Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .portfolio-filters li:hover, {{WRAPPER}} .portfolio-filters li.active' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                  'portfolio_filter' => 'yes'
                ]

            ]
        );
        $this->add_responsive_control(
            'category_filter_border_color',
            [
                'label'     => esc_html__( 'Filter Border Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .portfolio-filters li' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                  'portfolio_filter' => 'yes'
                ]

            ]
        );
        $this->add_responsive_control(
            'category_filter_border_hover_color',
            [
                'label'     => esc_html__( 'Filter Border Hover Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .portfolio-filters li:hover, {{WRAPPER}} .portfolio-filters li.active' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                  'portfolio_filter' => 'yes'
                ]

            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'category_filter_typography',
                   'selector'  => '{{WRAPPER}} .portfolio-filters li',
                   'condition' => [
                      'portfolio_filter' => 'yes',
                    ],
              ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'category_filter_border',
                'selector'    =>    '{{WRAPPER}} .portfolio-filters li',
                'condition' => [
                  'portfolio_filter' => 'yes'
                ]
            ]
        );
        $this->add_responsive_control(
            'category_filter_border_radius',
            [
                'label' => esc_html__( 'Filter Border Radius', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-filters li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                      'portfolio_filter' => 'yes',
                    ],
            ]
        );
        $this->add_responsive_control(
                'category_filter_padding',
                [
                    'label' => esc_html__( 'Filter Padding', 'avas-core' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .portfolio-filters li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ],
                    'condition' => [
                              'portfolio_filter' => 'yes',
                            ],
                ]
        );
        $this->add_responsive_control(
                'category_filter_margin',
                [
                    'label' => esc_html__( 'Filter Margin', 'avas-core' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .portfolio-filters li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ],
                    'condition' => [
                              'portfolio_filter' => 'yes',
                            ],
                ]
        );
        $this->add_responsive_control(
          'category_filter_alignment',
          [
            'label' => esc_html__( 'Filter Alignment', 'avas-core' ),
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
              ]
            ],
            'selectors' => [
              '{{WRAPPER}} .portfolio-filter-wrap' => 'text-align: {{VALUE}};',
            ],
            'condition' => [
                          'portfolio_filter' => 'yes',
                        ],
          ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'style_pagination',
            [
                'label'     => esc_html__( 'Pagination', 'avas-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
                'pagination_color',
                [
                    'label'     => esc_html__( 'Pagination Color', 'avas-core' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .tx-pagination-widgets a, {{WRAPPER}} .tx-portfolio-plus .tx-post-nav-previous a' => 'color: {{VALUE}};',
                    ],
                    'condition' => [
                        'pagination' => 'show',
                    ],
                    'separator' => 'before',
                ]
          );
      $this->add_responsive_control(
            'pagination_hover_color',
            [
                'label'     => esc_html__( 'Pagination Hover Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-pagination-widgets ul li:hover a, {{WRAPPER}} .tx-portfolio-plus .tx-post-nav-previous a:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'pagination' => 'show',
                ],
            ]
      );
      $this->add_responsive_control(
            'pagination_current_color',
            [
                'label'     => esc_html__( 'Pagination Active Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-pagination-widgets ul li .current' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'pagination' => 'show',
                    'pagination_style' => 'numbering'
                ],
            ]
      );
      $this->add_responsive_control(
            'pagination_border_color',
            [
                'label'     => esc_html__( 'Pagination Border Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-pagination-widgets ul li, {{WRAPPER}} .tx-portfolio-plus .tx-post-nav-previous a' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'pagination' => 'show',
                ],
            ]
      );
      
      $this->add_responsive_control(
            'pagination_hover_border_color',
            [
                'label'     => esc_html__( 'Pagination Hover Border Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-pagination-widgets ul li:hover, {{WRAPPER}} .tx-portfolio-plus .tx-post-nav-previous a:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'pagination' => 'show',
                ],
            ]
      );
      $this->add_responsive_control(
            'pagination_bg_color',
            [
                'label'     => esc_html__( 'Pagination Background Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-pagination-widgets ul li, {{WRAPPER}} .tx-portfolio-plus .tx-post-nav-previous a' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'pagination' => 'show',
                ],
            ]
      );
        $this->add_responsive_control(
            'pagination_hover_bg_color',
            [
                'label'     => esc_html__( 'Pagination Hover Background Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-pagination-widgets ul li:hover, {{WRAPPER}} .tx-portfolio-plus .tx-post-nav-previous a:hover' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'pagination' => 'show',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'pagination_typography',
                   'selector'  => '{{WRAPPER}} .tx-pagination-widgets ul li, {{WRAPPER}} .tx-portfolio-plus .tx-post-nav-previous a',
                   'condition' => [
                      'pagination' => 'show',
                    ],
              ]
        );
       $this->add_responsive_control(
            'pagination_align',
            [
                'label' => esc_html__( 'Pagination Align', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-pagination-widgets' => 'left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                      'pagination' => 'show',
                      'pagination_style' => 'numbering'
                    ],
            ]
        );
        $this->add_responsive_control(
          'pagination_alignment',
          [
            'label' => esc_html__( 'Pagination Alignment', 'avas-core' ),
            'type' => Controls_Manager::CHOOSE,
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
              ]
            ],
            'selectors' => [
              '{{WRAPPER}} .tx-pagination-widgets, {{WRAPPER}} .tx-portfolio-plus .tx-post-nav-previous, {{WRAPPER}} .tx-portfolio-plus #tx-infscr-loading' => 'text-align: {{VALUE}};',
            ],
            'condition' => [
                          'pagination' => 'show',
                        ],
          ]
        );
        $this->add_responsive_control(
                'pagination_padding',
                [
                    'label' => esc_html__( 'Pagination Padding', 'avas-core' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .tx-pagination-widgets, {{WRAPPER}} .tx-portfolio-plus .tx-post-nav-previous a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ],
                    'condition' => [
                              'pagination' => 'show',
                            ],
                ]
        );
        $this->add_responsive_control(
            'portfolio_plus_pagination_border_radius',
            [
                'label' => esc_html__( 'Pagination Border Radius', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors' => [
                    '{{WRAPPER}} .tx-portfolio-plus .tx-post-nav-previous a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                      'pagination' => 'show',
                      'pagination_style' => 'loadmore'
                    ],
            ]
        );
        $this->add_responsive_control(
            'pagination_no_more_posts_color',
            [
                'label'     => esc_html__( 'No More Posts Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-portfolio-plus #tx-no-more-posts' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'pagination' => 'show',
                    'pagination_style' => 'loadmore'
                ],
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'pagination_no_more_posts_typography',
                   'selector'  => '{{WRAPPER}} .tx-portfolio-plus #tx-infscr-loading div#tx-no-more-posts',
                   'condition' => [
                      'pagination' => 'show',
                      'pagination_style' => 'loadmore'
                    ],
              ]
        );

      
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();
        $display = $settings['display'];
        $title = $settings['title'];
        $desc = $settings['desc'];
        $port_category = $settings['port_category'];
        $pagination = $settings['pagination'];
        $portfolio_filter = $settings['portfolio_filter'];
        $showposts = '';
        $post_types = $settings['post_type']; 
        $tax_queries = $settings['tax_query'];
        $offset = $settings['offset'];
        $number_of_posts = $settings['number_of_posts'];

        global $post, $tx;

        $project_completion_title = get_post_meta($post->ID, 'project_completion_title', true);
        $completion = get_post_meta($post->ID, 'completion', true);
        $project_title = get_post_meta($post->ID, 'project_title', true);
        $project_fields = get_post_meta($post->ID, 'project_fields', true);
        $web_url = get_post_meta($post->ID, 'web_url', true);
        $btn_txt = get_post_meta($post->ID, 'btn_txt', true);
        $btn_url = get_post_meta($post->ID, 'btn_url', true);
        $port_vid_link = get_post_meta( $post->ID, 'port_vid_link', true );

        if ( get_query_var('paged') ) :
            $paged = get_query_var('paged');
        elseif ( get_query_var('page') ) :
            $paged = get_query_var('page');
        else :
            $paged = 1;
        endif;
        
        $query_args = TX_Helper::setup_query_args($settings, $showposts);
        $queryd = new \WP_Query( $query_args );
        
?>

<div class="tx-portfolio-plus">
    <?php if($portfolio_filter == 'yes') : ?>
    <div class="portfolio-filter-wrap">
        <ul class="portfolio-filters">
        <?php

        $taxonomies = get_object_taxonomies( $post_types, 'objects' );

        foreach( $taxonomies as $taxonomy ) {
           
            $terms = get_terms(array(
                'taxonomy' => $taxonomy->name,
                'hide_empty' => false,
            ));
        ?>
            <li class="active" data-filter="*"><?php echo esc_attr__($settings['portfolio_filter_all_text']); ?></li>
        <?php
            foreach( $terms as $term ) {
                $term_name = strtolower($term->name);
                $term_name = str_replace(' ', '-', $term_name);
                echo '<li  data-filter=".'.esc_attr($term_name).'">'.esc_attr($term->name).'</li>';

            }
        }
        ?>
        </ul>
    </div>
    <?php endif; ?>

    <div id="tx-portfolio-<?php echo esc_attr($this->get_id()); ?>" class="tx-portfolio">
    <?php
      if ($queryd->have_posts()) : while ($queryd->have_posts()) : $queryd->the_post();

        global $post;
        $taxonomies = get_object_taxonomies( $post_types, 'objects' );

        foreach( $taxonomies as $taxonomy ) {
   
        $terms = get_the_terms( $post->ID, $taxonomy->name );
        if ( $terms && ! is_wp_error( $terms ) ) :
          $taxonomy = array();
          foreach ( $terms as $term ) :
            $taxonomy[] = $term->name;
          endforeach;
          $cat_name = join( " ", str_replace(' ', '-', $taxonomy));
          $cat_link = get_term_link( $term );
          $cat = strtolower($cat_name);
        else :
          $cat = '';
        endif;

        }

    ?>

    <div class="tx-portfolio-item <?php echo esc_attr($cat); ?> <?php echo esc_attr($display); ?>">
        
        <div class="tx-port-overlay"> 
            
            <div class="tx-port-img">
              <?php
                $img_url = get_the_post_thumbnail_url(get_the_ID(), '');
                $img_h_grid = get_the_post_thumbnail_url(get_the_ID(), 'tx-port-grid-h-thumb');
                $img_v_grid = get_the_post_thumbnail_url(get_the_ID(), 'tx-port-grid-v-thumb');
              ?>

              <?php if('masonry' === $display) : ?>
                <?php if($settings['tx_portfolio_plus_hover_icons'] == 'show') : ?>
                <img src="<?php echo esc_attr($img_url); ?>" alt="<?php the_title(); ?>" >
                <span class="tx-portfolio-plus-arrow-buttons">
                    <span class="tx-portfolio-plus-modal-arrow-icon" data-toggle="modal" data-target="#txModalItem-<?php echo get_the_id(); ?>"><i class="bi bi-arrow-down-right"></i></span>
                    <a class="tx-portfolio-plus-link-arrow-icon" href="<?php the_permalink(); ?>"><i class="bi bi-arrow-up-right"></i></a>
                </span>
                <?php else : ?>
                <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_attr($img_url); ?>" alt="<?php the_title(); ?>" ></a>
                <?php endif; ?>
              <?php endif; ?>
                
              <?php if('grid-h' === $display) : ?>
                <?php if($settings['tx_portfolio_plus_hover_icons'] == 'show') : ?>
                <img src="<?php echo esc_attr($img_h_grid); ?>" alt="<?php the_title(); ?>">
                <span class="tx-portfolio-plus-arrow-buttons">
                    <span class="tx-portfolio-plus-modal-arrow-icon" data-toggle="modal" data-target="#txModalItem-<?php echo get_the_id(); ?>"><i class="bi bi-arrow-down-right"></i></span>
                    <a class="tx-portfolio-plus-link-arrow-icon" href="<?php the_permalink(); ?>"><i class="bi bi-arrow-up-right"></i></a>
                </span>
                <?php else : ?>
                <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_attr($img_h_grid); ?>" alt="<?php the_title(); ?>" ></a>
                <?php endif; ?>
              <?php endif; ?>

              <?php if( 'grid-v' === $display ) : ?>
                <?php if($settings['tx_portfolio_plus_hover_icons'] == 'show') : ?>
                <img src="<?php echo esc_attr($img_v_grid); ?>" alt="<?php the_title(); ?>">
                <span class="tx-portfolio-plus-arrow-buttons">
                    <span class="tx-portfolio-plus-modal-arrow-icon" data-toggle="modal" data-target="#txModalItem-<?php echo get_the_id(); ?>"><i class="bi bi-arrow-down-right"></i></span>
                    <a class="tx-portfolio-plus-link-arrow-icon" href="<?php the_permalink(); ?>"><i class="bi bi-arrow-up-right"></i></a>
                </span>
                <?php else : ?>
                <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_attr($img_v_grid); ?>" alt="<?php the_title(); ?>" ></a>
                <?php endif; ?>
              <?php endif; ?>

              <?php if('card-h' === $display) : ?>
                <?php if($settings['tx_portfolio_plus_hover_icons'] == 'show') : ?>
                <img src="<?php echo esc_attr($img_h_grid); ?>" alt="<?php the_title(); ?>" >
                <span class="tx-portfolio-plus-modal-arrow" data-toggle="modal" data-target="#txModalItem-<?php echo get_the_id(); ?>"><i class="bi bi-arrow-down-right"></i></span>
                <?php elseif( $settings['tx_portfolio_plus_hover_icons'] == 'hide' && $settings['tx_portfolio_plus_popup'] == 'hide' ) : ?>
                    <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_attr($img_h_grid); ?>" alt="<?php the_title(); ?>" ></a>
                <?php else : ?>
                <a href="<?php the_permalink(); ?>" data-toggle="modal" data-target="#txModalItem-<?php echo get_the_id(); ?>"><img src="<?php echo esc_attr($img_h_grid); ?>" alt="<?php the_title(); ?>" ></a>
                <?php endif; ?>
              <?php endif; ?>
              
              <?php if( 'card-v' === $display ) : ?>
                <?php if($settings['tx_portfolio_plus_hover_icons'] == 'show') : ?>
                <img src="<?php echo esc_attr($img_v_grid); ?>" alt="<?php the_title(); ?>" >
                <span class="tx-portfolio-plus-modal-arrow" data-toggle="modal" data-target="#txModalItem-<?php echo get_the_id(); ?>"><i class="bi bi-arrow-down-right"></i></span>
                <?php elseif( $settings['tx_portfolio_plus_hover_icons'] == 'hide' && $settings['tx_portfolio_plus_popup'] == 'hide' ) : ?>
                    <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_attr($img_v_grid); ?>" alt="<?php the_title(); ?>" ></a>
                <?php else : ?>
                <a href="<?php the_permalink(); ?>" data-toggle="modal" data-target="#txModalItem-<?php echo get_the_id(); ?>"><img src="<?php echo esc_attr($img_v_grid); ?>" alt="<?php the_title(); ?>" ></a>
                <?php endif; ?>
              <?php endif; ?>
                
            </div>
            <!-- /.tx-port-img -->    

        </div>
        <!-- ./tx-port-overlay -->

            <?php if('card-h' === $display || 'card-v' === $display): ?>
            <div class="tx-portfolio-plus-card-content">
                
                <?php if('show' === $title ) : ?>
                  <h4 class="tx-port-title"><a href="<?php echo get_the_permalink();?>"><?php echo TX_Helper::title_lenth($settings['title_limit']); ?></a></h4>
                <?php endif; ?>

                <?php if('show' === $desc) : ?>
                  <p class="tx-port-excp"><?php echo esc_html(tx_excerpt_limit($settings['desc_limit'])); ?></p>
                <?php endif; ?>
                
                <?php if( !empty($cat) && 'show' === $port_category ) : ?>
                        <a class="tx-portfolio-plus-category" href="<?php echo esc_url($cat_link); ?>"><?php echo esc_attr($cat); ?></a>
                <?php endif; ?>
                <?php if($settings['tx_portfolio_plus_hover_icons'] == 'show') : ?>
                <a class="tx-portfolio-plus-link-arrow" href="<?php echo get_the_permalink();?>" aria-hidden="true"><i class="bi bi-arrow-up-right"></i></a>
                <?php endif; ?>
            </div><!-- tx-port-card-content -->
            <?php endif; ?>


            <!-- Modal Portfolio Body area Start -->
            <div class="modal fade bd-example-modal-lg" id="txModalItem-<?php echo get_the_id(); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                    <div class="modal-content">
                        
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true"> <i class="bi bi-x-circle"></i></span>
                            </button>
                        </div>
                        
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="portfolio-popup-thumbnail">
                                         <?php if (has_post_thumbnail()) { ?>
                                             <!-- <div class="image"> -->
                                                 <?php the_post_thumbnail('large'); ?>
                                             <!-- </div> -->
                                         <?php } ?>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="text-content">
                                        <h3>
                                             <?php the_title(); ?>
                                        </h3>

                                        <?php the_content(); ?>
                                    </div>
                                    <!-- End of .text-content -->

                                    <?php if ( !empty($web_url) || !empty($btn_txt) || !empty($btn_url) || $tx['portfolio-time'] == '1' || $tx['portfolio-author'] == '1'  ): ?>
                                        <div class="widget">
                                            <?php tx_portfolio_meta(); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ( !empty($project_completion_title) || !empty($completion) ) : ?>
                                    <div class="widget">
                                        <?php if ( !empty($project_completion_title) ) : ?>
                                            <h3 class="widget-title"><?php printf(esc_html__('%s', 'avas'), $project_completion_title ); ?></h3>
                                        <?php endif; ?>
                                        <?php if ( !empty($completion) ) : ?>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: <?php echo esc_attr($completion); ?>%;" aria-valuenow="<?php echo esc_attr($completion); ?>" aria-valuemin="0" aria-valuemax="100"><?php echo esc_attr($completion); ?>%</div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                            <!-- End of .row Body-->
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal Portfolio area -->

        </div><!-- /.tx-portfolio-item -->

        <?php
         //   endif;
          endwhile;
        ?>
        
        <?php
          else:  
          get_template_part('template-parts/content/content', 'none');
          endif;
        ?>
        </div><!-- /.tx-portfolio -->
    <?php
        if($settings['pagination'] == 'show' && $settings['pagination_style'] == 'numbering') :
    ?>  
            <div class="tx-pagination-widgets">
            <?php
            $page_tot = ceil(($queryd->found_posts - (int)$offset) / (int)$number_of_posts);
            if ( $page_tot > 1 ) {
            $big = 999999999;
            echo paginate_links( array(
                  'base'      => str_replace( $big, '%#%',get_pagenum_link( 999999999, false ) ),
                  'format'    => '?paged=%#%',
                  'current'   => max( 1, $paged ),
                  'total'     => ceil(($queryd->found_posts - (int)$offset) / (int)$number_of_posts),
                  'prev_next' => true,
                    'prev_text'    => esc_html( $settings['pagination_numbering_prev'] ),
                    'next_text'    => esc_html( $settings['pagination_numbering_next'] ),
                  'end_size'  => 1,
                  'mid_size'  => 2,
                  'type'      => 'list'
                    )
                );
            }
            ?>
            </div><!-- /.tx-pagination-widgets -->
        <?php endif; ?>
            
        <?php if ( $settings['pagination'] == 'show' && $settings['pagination_style'] == 'loadmore' ) : ?>
            <div class="tx-post-pagination-container">
                <?php $page_tot = ceil(($queryd->found_posts - (int)$offset) / (int)$number_of_posts); if ( $page_tot > 1 ) : ?>
                    <div class="tx-post-load-more">
                        <div id="tx-infinite-nav<?php echo esc_attr($this->get_id()); ?>" class="tx-post-infinite">
                            <div class="tx-post-nav-previous">
                               <?php next_posts_link( $settings['pagination_load_more'], $queryd->max_num_pages ); ?>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
            </div><!-- close .tx-post-pagination-container -->
        <?php endif; ?>

        <script>
    jQuery(document).ready(function($) { 'use strict';  
        /* Default Isotope Load Code */
        var $container<?php echo esc_attr($this->get_id()); ?> = $('#tx-portfolio-<?php echo esc_attr($this->get_id()); ?>').isotope();
        $container<?php echo esc_attr($this->get_id()); ?>.imagesLoaded( function() {
            
            $(".tx-portfolio-item").addClass("tx-isotope-animation-start");
            
            $container<?php echo esc_attr($this->get_id()); ?>.isotope({
                itemSelector: '.tx-portfolio-item',             
                percentPosition: true,
               
            });
            
        });

        /* END Default Isotope Code */
        <?php if ( $settings['pagination'] == 'show' && $settings['pagination_style'] == 'loadmore' ) : ?>

        /* Begin Infinite Scroll */

        $container<?php echo esc_attr($this->get_id()); ?>.infinitescroll({

        errorCallback: function(){  $("#tx-infinite-nav<?php echo esc_attr($this->get_id()); ?>").delay(10).fadeOut(1000, function(){ $(this).remove(); }); },
          navSelector  : "#tx-infinite-nav<?php echo esc_attr($this->get_id()); ?>",  
          nextSelector : ".tx-post-nav-previous a", 
          itemSelector : ".tx-portfolio-item", 
            loading: {
                img: "<?php echo TX_PLUGIN_ASSEETS . 'img/loading.gif' ; ?>",
                msgText: "",
                finishedMsg: "<div id='tx-no-more-posts'><?php echo esc_html($settings['pagination_no_post']); ?></div>",
                speed: 0,
            }
          },

          // trigger Isotope as a callback
          function( newElements ) {
              
              //Add JS as needed here
              
            var $newElems = $( newElements );
    
                $newElems.imagesLoaded(function(){
                    
                $container<?php echo esc_attr($this->get_id()); ?>.isotope( "appended", $newElems );
                $(".tx-portfolio-item").addClass("tx-isotope-animation-start");
                
            });

          }
        );
        /* END Infinite Scroll */
        
        <?php endif; ?>
        
        <?php if ( $settings['pagination'] == 'show' && $settings['pagination_style'] == 'loadmore' ) : ?>
        /* PAUSE FOR LOAD MORE */
        $(window).unbind(".infscr");
        // Resume Infinite Scroll
        $("#tx-infinite-nav<?php echo esc_attr($this->get_id()); ?> .tx-post-nav-previous a").click(function(){
            $container<?php echo esc_attr($this->get_id()); ?>.infinitescroll("retrieve");
            return false;
        });
        /* End Infinite Scroll */
        <?php endif; ?>
        
    });
    </script>


    

  <?php
    wp_reset_postdata();
  ?>

    <div class="clearfix"></div>
</div> <!-- ./tx-row -->


<?php

    } // function render()
} // class Portfolio
