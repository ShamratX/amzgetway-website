<?php
namespace AvasElements\Modules\Slider\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Stroke;
use AvasElements\TX_Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Slider extends Widget_Base {

    public function get_name() {
        return 'avas-slider';
    }

    public function get_title() {
        return esc_html__( 'Avas Slider', 'avas-core' );
    }

    public function get_icon() {
        return 'eicon-slides';
    }

    public function get_categories() {
        return [ 'avas-elements' ];
    }

    public function get_keywords() {
        return ['slider', 'hero', 'banner', 'animation'];
    }

    public function get_style_depends() {
        return ['tx-slider'];
    }

    public function get_script_depends() {
        return ['imagesloaded', 'tx-slider'];
    }

	protected function register_controls() {
        $this->start_controls_section(
            'section_content_sliders',
            [
                'label' => esc_html__('Sliders', 'avas-core'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'tab_title',
            [
                'label'       => esc_html__('Title', 'avas-core'),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => ['active' => true],
                'default'     => esc_html__('Slide Title', 'avas-core'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tab_image',
            [
                'label'   => esc_html__('Background Image', 'avas-core'),
                'type'    => Controls_Manager::MEDIA,
                'dynamic' => ['active' => true],
            ]
        );

        $repeater->add_control(
            'tab_content',
            [
                'label'      => esc_html__('Content', 'avas-core'),
                'type'       => Controls_Manager::WYSIWYG,
                'dynamic'    => ['active' => true],
                'default'    => esc_html__('Slide Content', 'avas-core'),
                'show_label' => false,
            ]
        );
        $repeater->add_control(
            'button_text',
            [
                'label'       => esc_html__('Button Text', 'avas-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__('Read More', 'avas-core'),
                // 'placeholder' => esc_html__('Read More', 'avas-core'),
            ]
        );
        $repeater->add_control(
            'tab_link',
            [
                'label'       => esc_html__('Button Link', 'avas-core'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => ['active' => true],
                'placeholder' => 'http://your-link.com',
                'default'     => [
                    'url' => '#',
                ],
            ]
        );
         $repeater->add_control(
            'slider_icon',
            [
                'label'       => esc_html__('Icon', 'avas-core'),
                'type'        => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'label_block' => false,
                'skin' => 'inline'
            ]
        );

        

        $repeater->add_control(
            'tab_image_layer',
            [
                'label'   => esc_html__('Image Layer', 'avas-core'),
                'type'    => Controls_Manager::MEDIA,
                'dynamic' => ['active' => true],
                'separator' => 'before'
            ]
        );
        
        $this->add_control(
            'tabs',
            [
                'label' => esc_html__('Slider Items', 'avas-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tab_title'   => esc_html__('Avas WordPress Theme', 'avas-core'),
                        'tab_content' => esc_html__('Cras hendrerit suscipit ligula id ultrices a leo quis consequat.', 'avas-core'),
                    ],
                    [
                        'tab_title'   => esc_html__('Most Customizable Theme', 'avas-core'),
                        'tab_content' => esc_html__('Cras hendrerit suscipit ligula id ultrices a leo quis consequat.', 'avas-core'),
                    ],
                    [
                        'tab_title'   => esc_html__('Elementor Theme', 'avas-core'),
                        'tab_content' => esc_html__('Cras hendrerit suscipit ligula id ultrices a leo quis consequat.', 'avas-core'),
                    ],
                ],
                'title_field' => '{{{ tab_title }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_layout',
            [
                'label' => esc_html__('Layout', 'avas-core'),
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label'   => esc_html__('Height', 'avas-core'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 550,
                ],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 1200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-slide-item' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_max_width',
            [
                'label'   => esc_html__('Content Width', 'avas-core'),
                'type'    => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 2500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-desc' => 'width: {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'origin',
            [
                'label'   => esc_html__('Content Position', 'avas-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'center',
                'options' => [
                    'top-left'      => esc_html__('Top Left', 'avas-core'),
                    'top-center'    => esc_html__('Top Center', 'avas-core'),
                    'top-right'     => esc_html__('Top Right', 'avas-core'),
                    'center'        => esc_html__('Center', 'avas-core'),
                    'center-left'   => esc_html__('Center Left', 'avas-core'),
                    'center-right'  => esc_html__('Center Right', 'avas-core'),
                    'bottom-left'   => esc_html__('Bottom Left', 'avas-core'),
                    'bottom-center' => esc_html__('Bottom Center', 'avas-core'),
                    'bottom-right'  => esc_html__('Bottom Right', 'avas-core'),
                ]
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label'   => esc_html__('Content Alignment', 'avas-core'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'avas-core'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'avas-core'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'avas-core'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__('Justified', 'avas-core'),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'prefix_class' => 'elementor%s-align-',
                'default'      => 'center',
            ]
        );
        $this->add_responsive_control(
            'tab_image_layer_size',
            [
                'label'   => esc_html__('Image Layer Size', 'avas-core'),
                'type'    => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em' ],
                'range' => [
                    'px' => [
                        'max' => 2000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider-image-layer img' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control(
            'tab_image_layer_position_x',
            [
                'label'   => esc_html__('Image Layer Position X', 'avas-core'),
                'type'    => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em' ],
                'range' => [
                    'px' => [
                        'max' => 2000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider-image-layer' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'tab_image_layer_position_y',
            [
                'label'   => esc_html__('Image Layer Position Y', 'avas-core'),
                'type'    => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em' ],
                'range' => [
                    'px' => [
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider-image-layer' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );        

        $this->add_control(
            'show_title',
            [
                'label'   => esc_html__('Show Title', 'avas-core'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'title_tags',
            [
                'label'   => esc_html__('Title HTML Tag', 'avas-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => TX_Helper::title_html_tags(),
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_button',
            [
                'label'   => esc_html__('Show Button', 'avas-core'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'icon_align',
            [
                'label'   => esc_html__('Button Icon Position', 'avas-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'left'  => esc_html__('Left', 'avas-core'),
                    'right' => esc_html__('Right', 'avas-core'),
                ],
                'condition' => [
                    'slider_icon[value]!' => '',
                ],
            ]
        );

        $this->add_control(
            'icon_indent',
            [
                'label'   => esc_html__('Button Icon Spacing', 'avas-core'),
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
                    'slider_icon[value]!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-button-icon-align-right' => is_rtl() ? 'margin-right: {{SIZE}}{{UNIT}};' : 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tx-slider .tx-button-icon-align-left'  => is_rtl() ? 'margin-left: {{SIZE}}{{UNIT}};' : 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'scroll_to_section',
            [
                'label' => esc_html__('Scroll to Section', 'avas-core'),
                'type'  => Controls_Manager::SWITCHER,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'section_id',
            [
                'label'       => esc_html__('Section ID', 'avas-core'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => 'Section ID Here',
                'description' => 'Enter section ID of this page, ex: #my-section',
                'label_block' => true,
                'condition'   => [
                    'scroll_to_section' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'slider_scroll_to_section_icon',
            [
                'label'       => esc_html__('Scroll to Section Icon', 'avas-core'),
                'type'        => Controls_Manager::ICONS,
                'fa4compatibility' => 'scroll_to_section_icon',
                'default' => [
                    'value' => 'fas fa-angle-double-down',
                    'library' => 'fa-solid',
                ],
                'condition'   => [
                    'scroll_to_section' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // $this->start_controls_section(
        //     'section_content_button',
        //     [
        //         'label'     => esc_html__('Button', 'avas-core'),
        //         'condition' => [
        //             'show_button' => 'yes',
        //         ],
        //     ]
        // );

        // $this->add_control(
        //     'button_text',
        //     [
        //         'label'       => esc_html__('Button Text', 'avas-core'),
        //         'type'        => Controls_Manager::TEXT,
        //         'default'     => esc_html__('Read More', 'avas-core'),
        //         'placeholder' => esc_html__('Read More', 'avas-core'),
        //     ]
        // );

        // $this->add_control(
        //     'slider_icon',
        //     [
        //         'label'       => esc_html__('Icon', 'avas-core'),
        //         'type'        => Controls_Manager::ICONS,
        //         'fa4compatibility' => 'icon',
        //         'label_block' => false,
        //         'skin' => 'inline'
        //     ]
        // );

        // $this->add_control(
        //     'icon_align',
        //     [
        //         'label'   => esc_html__('Icon Position', 'avas-core'),
        //         'type'    => Controls_Manager::SELECT,
        //         'default' => 'right',
        //         'options' => [
        //             'left'  => esc_html__('Left', 'avas-core'),
        //             'right' => esc_html__('Right', 'avas-core'),
        //         ],
        //         'condition' => [
        //             'slider_icon[value]!' => '',
        //         ],
        //     ]
        // );

        // $this->add_control(
        //     'icon_indent',
        //     [
        //         'label'   => esc_html__('Icon Spacing', 'avas-core'),
        //         'type'    => Controls_Manager::SLIDER,
        //         'default' => [
        //             'size' => 8,
        //         ],
        //         'range' => [
        //             'px' => [
        //                 'max' => 50,
        //             ],
        //         ],
        //         'condition' => [
        //             'slider_icon[value]!' => '',
        //         ],
        //         'selectors' => [
        //             '{{WRAPPER}} .tx-slider .tx-button-icon-align-right' => is_rtl() ? 'margin-right: {{SIZE}}{{UNIT}};' : 'margin-left: {{SIZE}}{{UNIT}};',
        //             '{{WRAPPER}} .tx-slider .tx-button-icon-align-left'  => is_rtl() ? 'margin-left: {{SIZE}}{{UNIT}};' : 'margin-right: {{SIZE}}{{UNIT}};',
        //         ],
        //     ]
        // );

        // $this->end_controls_section();

        $this->start_controls_section(
            'section_content_navigation',
            [
                'label' => esc_html__('Navigation', 'avas-core'),
            ]
        );

        $this->add_control(
            'navigation',
            [
                'label'   => esc_html__('Navigation', 'avas-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'arrows',
                'options' => [
                    'both'            => esc_html__('Arrows and Dots', 'avas-core'),
                    'arrows-fraction' => esc_html__('Arrows and Fraction', 'avas-core'),
                    'arrows'          => esc_html__('Arrows', 'avas-core'),
                    'dots'            => esc_html__('Dots', 'avas-core'),
                    'progressbar'     => esc_html__('Progress', 'avas-core'),
                    'none'            => esc_html__('None', 'avas-core'),
                ],
                'prefix_class' => 'tx-navigation-type-',
                'render_type' => 'template',
            ]
        );

        $this->add_control(
            'dynamic_bullets',
            [
                'label'     => esc_html__('Dynamic Bullets?', 'avas-core'),
                'type'      => Controls_Manager::SWITCHER,
                'condition' => [
                    'navigation' => ['dots', 'both'],
                ],
            ]
        );

        $this->add_control(
            'show_scrollbar',
            [
                'label'     => esc_html__('Show Scrollbar?', 'avas-core'),
                'type'      => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'both_position',
            [
                'label'     => esc_html__('Arrows and Dots Position', 'avas-core'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'center',
                'options'   => TX_Helper::navigation_position(),
                'condition' => [
                    'navigation' => 'both',
                ],

            ]
        );

        $this->add_control(
            'arrows_fraction_position',
            [
                'label'     => esc_html__('Arrows and Fraction Position', 'avas-core'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'center',
                'options'   => TX_Helper::navigation_position(),
                'condition' => [
                    'navigation' => 'arrows-fraction',
                ],

            ]
        );

        $this->add_control(
            'arrows_position',
            [
                'label'     => esc_html__('Arrows Position', 'avas-core'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'center',
                'options'   => TX_Helper::navigation_position(),
                'condition' => [
                    'navigation' => 'arrows',
                ],

            ]
        );

        $this->add_control(
            'dots_position',
            [
                'label'     => esc_html__('Dots Position', 'avas-core'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'bottom-center',
                'options'   => TX_Helper::pagination_position(),
                'condition' => [
                    'navigation' => 'dots',
                ],

            ]
        );

        $this->add_control(
            'progress_position',
            [
                'label'   => esc_html__('Progress Position', 'avas-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'bottom',
                'options' => [
                    'bottom' => esc_html__('Bottom', 'avas-core'),
                    'top'    => esc_html__('Top', 'avas-core'),
                ],
                'condition' => [
                    'navigation' => 'progressbar',
                ],

            ]
        );

        $this->add_control(
            'nav_arrows_icon',
            [
                'label'   => esc_html__('Arrows Icon', 'avas-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => '0',
                'options' => [
                    '0' => esc_html__('Default', 'avas-core'),
                    '1' => esc_html__('Style 1', 'avas-core'),
                    '2' => esc_html__('Style 2', 'avas-core'),
                    '3' => esc_html__('Style 3', 'avas-core'),
                    '4' => esc_html__('Style 4', 'avas-core'),
                    '5' => esc_html__('Style 5', 'avas-core'),
                    '6' => esc_html__('Style 6', 'avas-core'),
                    '7' => esc_html__('Style 7', 'avas-core'),
                    '8' => esc_html__('Style 8', 'avas-core'),
                    '9' => esc_html__('Style 9', 'avas-core'),
                    '10' => esc_html__('Style 10', 'avas-core'),
                    '11' => esc_html__('Style 11', 'avas-core'),
                    '12' => esc_html__('Style 12', 'avas-core'),
                    '13' => esc_html__('Style 13', 'avas-core'),
                    '14' => esc_html__('Style 14', 'avas-core'),
                    '15' => esc_html__('Style 15', 'avas-core'),
                    '16' => esc_html__('Style 16', 'avas-core'),
                    '17' => esc_html__('Style 17', 'avas-core'),
                    '18' => esc_html__('Style 18', 'avas-core'),
                    'circle-1' => esc_html__('Style 19', 'avas-core'),
                    'circle-2' => esc_html__('Style 20', 'avas-core'),
                    'circle-3' => esc_html__('Style 21', 'avas-core'),
                    'circle-4' => esc_html__('Style 22', 'avas-core'),
                    'square-1' => esc_html__('Style 23', 'avas-core'),
                ],
                'condition' => [
                    'navigation' => ['arrows-fraction', 'both', 'arrows'],
                ],
            ]
        );

        $this->add_control(
            'hide_arrow_on_mobile',
            [
                'label'     => esc_html__('Hide Arrow on Mobile ?', 'avas-core'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'condition' => [
                    'navigation' => ['arrows-fraction', 'arrows', 'both'],
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_slider_settings',
            [
                'label' => esc_html__('Slider Settings', 'avas-core'),
            ]
        );

        $this->add_control(
            'transition',
            [
                'label'   => esc_html__('Transition', 'avas-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'slide',
                'options' => [
                    'slide'     => esc_html__('Slide', 'avas-core'),
                    'fade'      => esc_html__('Fade', 'avas-core'),
                    'cube'      => esc_html__('Cube', 'avas-core'),
                    'coverflow' => esc_html__('Coverflow', 'avas-core'),
                    'flip'      => esc_html__('Flip', 'avas-core'),
                ],
            ]
        );

        $this->add_control(
            'effect',
            [
                'label'   => esc_html__('Text Effect', 'avas-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left'    => esc_html__('Slide Right to Left', 'avas-core'),
                    'bottom'  => esc_html__('Slider Bottom to Top', 'avas-core'),
                ],
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'     => esc_html__('Autoplay', 'avas-core'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label'     => esc_html__('Autoplay Speed', 'avas-core'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 5000,
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'pauseonhover',
            [
                'label' => esc_html__('Pause on Hover', 'avas-core'),
                'type'  => Controls_Manager::SWITCHER,
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'loop',
            [
                'label'   => esc_html__('Loop', 'avas-core'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );

        $this->add_control(
            'speed',
            [
                'label'   => esc_html__('Animation Speed (ms)', 'avas-core'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 500,
                ],
                'range' => [
                    'px' => [
                        'min'  => 100,
                        'max'  => 5000,
                        'step' => 50,
                    ],
                ],
            ]
        );

        $this->add_control(
            'observer',
            [
                'label'       => esc_html__('Observer', 'avas-core'),
                'description' => esc_html__('When you use carousel in any hidden place (in tabs, accordion etc) keep it yes.', 'avas-core'),
                'type'        => Controls_Manager::SWITCHER,
            ]
        );

        $this->end_controls_section();

        //Style
        $this->start_controls_section(
            'section_style_slider',
            [
                'label' => esc_html__('Slider', 'avas-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'slider_background_color',
            [
                'label'     => esc_html__('Background Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#4E2FE9',
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-slide-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'overlay_type',
            [
                'label'   => esc_html__('Overlay', 'avas-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none'       => esc_html__('None', 'avas-core'),
                    'background' => esc_html__('Background', 'avas-core'),
                    'blend'      => esc_html__('Blend', 'avas-core'),
                ],
            ]
        );
        $this->add_control(
            'background_size',
            [
                'label'   => esc_html__('Background Size', 'avas-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'auto'       => esc_html__('Auto', 'avas-core'),
                    'contain' => esc_html__('Contain', 'avas-core'),
                    'cover'      => esc_html__('Cover', 'avas-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider-image-wrapper' => 'background-size: {{VALUE}};'
                ],
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'background_position',
            [
                'label'   => esc_html__('Background Position', 'avas-core'),
                'type'    => Controls_Manager::SELECT,
                // 'default' => 'cover',
                'options' => [
                    'bottom'       => esc_html__('Bottom', 'avas-core'),
                    'center' => esc_html__('Center', 'avas-core'),
                    'left'      => esc_html__('Left', 'avas-core'),
                    'right'      => esc_html__('Right', 'avas-core'),
                    'top'      => esc_html__('Top', 'avas-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider-image-wrapper' => 'background-position: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'background_repeat',
            [
                'label'   => esc_html__('Background Repeat', 'avas-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'repeat',
                'options' => [
                    'repeat'       => esc_html__('Repeat', 'avas-core'),
                    'no-repeat' => esc_html__('No Repeat', 'avas-core'),
                    'repeat-x'      => esc_html__('Repeat X', 'avas-core'),
                    'repeat-y'      => esc_html__('Repeat Y', 'avas-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider-image-wrapper' => 'background-repeat: {{VALUE}};'
                ],
                'condition' => [
                    'background_size' => ['auto', 'contain'],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'overlay_color',
                'label' => esc_html__('Background', 'avas-core'),
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slider-image-wrapper:before',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                    'color' => [
                        'default' => 'rgba(3, 4, 16, 0.4)',
                    ],
                ],
                'condition' => [
                    'overlay_type' => ['background', 'blend'],
                ],
            ]
        );

        $this->add_control(
            'blend_type',
            [
                'label'     => esc_html__('Blend Type', 'avas-core'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'multiply',
                'options'   => TX_Helper::tx_blend_options(),
                'condition' => [
                    'overlay_type' => 'blend',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slider-image-wrapper:before' => 'mix-blend-mode: {{VALUE}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label'      => esc_html__('Margin', 'avas-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label'      => esc_html__('Padding', 'avas-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_title',
            [
                'label'     => esc_html__('Title', 'avas-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_title' => ['yes'],
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_background',
            [
                'label'     => esc_html__('Background', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-title' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_padding',
            [
                'label'      => esc_html__('Padding', 'avas-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => esc_html__('Typography', 'avas-core'),
                'selector' => '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'title_text_stroke',
                'label' => esc_html__('Text_Stroke', 'avas-core'),
                'selector' => '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-title',
            ]
        );

        $this->add_responsive_control(
            'title_space',
            [
                'label' => esc_html__('Space', 'avas-core'),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_text',
            [
                'label' => esc_html__('Text', 'avas-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label'     => esc_html__('Text Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_background',
            [
                'label'     => esc_html__('Background', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-text' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_padding',
            [
                'label'      => esc_html__('Padding', 'avas-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'text_typography',
                'label'    => esc_html__('Text Typography', 'avas-core'),
                'selector' => '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-text',
            ]
        );

        $this->add_responsive_control(
            'text_space',
            [
                'label' => esc_html__('Text Space', 'avas-core'),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_button',
            [
                'label'     => esc_html__('Button', 'avas-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_button' => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => esc_html__('Normal', 'avas-core'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label'     => esc_html__('Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-link' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-link svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label'     => esc_html__('Background Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-link' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border',
                'label'       => esc_html__('Border', 'avas-core'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-link',
                'separator'   => 'before',
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label'      => esc_html__('Border Radius', 'avas-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label'      => esc_html__('Padding', 'avas-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-link',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'label'    => esc_html__('Typography', 'avas-core'),
                'selector' => '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-link',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => esc_html__('Hover', 'avas-core'),
            ]
        );

        $this->add_control(
            'hover_color',
            [
                'label'     => esc_html__('Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-link:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-link:hover svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_hover_color',
            [
                'label'     => esc_html__('Background Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-link:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-slide-item .tx-slide-link:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_animation',
            [
                'label' => esc_html__('Animation', 'avas-core'),
                'type'  => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_navigation',
            [
                'label'     => esc_html__('Navigation', 'avas-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'conditions'   => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'operator' => '!=',
                            'value' => 'none',
                        ],
                        [
                            'name'     => 'show_scrollbar',
                            'value'    => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'arrows_heading',
            [
                'label'     => esc_html__('A R R O W S', 'avas-core'),
                'type'      => Controls_Manager::HEADING,
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->start_controls_tabs('tabs_navigation_arrows_style');

        $this->start_controls_tab(
            'tabs_nav_arrows_normal',
            [
                'label' => esc_html__('Normal', 'avas-core'),
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'arrows_color',
            [
                'label'     => esc_html__('Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-navigation-prev i, {{WRAPPER}} .tx-slider .tx-navigation-next i' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'arrows_background',
            [
                'label'     => esc_html__('Background', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-navigation-prev, {{WRAPPER}} .tx-slider .tx-navigation-next' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'nav_arrows_border',
                'selector'    => '{{WRAPPER}} .tx-slider .tx-navigation-prev, {{WRAPPER}} .tx-slider .tx-navigation-next',
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'nav_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'avas-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tx-slider .tx-navigation-prev, {{WRAPPER}} .tx-slider .tx-navigation-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_padding',
            [
                'label' => esc_html__('Padding', 'avas-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-navigation-prev, {{WRAPPER}} .tx-slider .tx-navigation-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'arrows_size',
            [
                'label' => esc_html__('Size', 'avas-core'),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-navigation-prev i,
                    {{WRAPPER}} .tx-slider .tx-navigation-next i' => 'font-size: {{SIZE || 36}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'arrows_space',
            [
                'label' => esc_html__('Space Between Arrows', 'avas-core'),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-navigation-prev' => 'margin-right: {{SIZE}}px;',
                    '{{WRAPPER}} .tx-slider .tx-navigation-next' => 'margin-left: {{SIZE}}px;',
                ],
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_nav_arrows_hover',
            [
                'label' => esc_html__('Hover', 'avas-core'),
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'arrows_hover_color',
            [
                'label'     => esc_html__('Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-navigation-prev:hover i, {{WRAPPER}} .tx-slider .tx-navigation-next:hover i' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'arrows_hover_background',
            [
                'label'     => esc_html__('Background', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-navigation-prev:hover, {{WRAPPER}} .tx-slider .tx-navigation-next:hover' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'nav_arrows_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-navigation-prev:hover, {{WRAPPER}} .tx-slider .tx-navigation-next:hover'  => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'nav_arrows_border_border!' => '',
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'hr_1',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'dots_heading',
            [
                'label'     => esc_html__('D O T S', 'avas-core'),
                'type'      => Controls_Manager::HEADING,
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                ],
            ]
        );

        $this->start_controls_tabs('tabs_navigation_dots_style');

        $this->start_controls_tab(
            'tabs_nav_dots_normal',
            [
                'label'     => esc_html__('Normal', 'avas-core'),
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'dots_color',
            [
                'label'     => esc_html__('Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .swiper-pagination-bullet' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_space_between',
            [
                'label'     => esc_html__('Space Between', 'avas-core'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}}' => '--sl-swiper-dots-space-between: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_size',
            [
                'label'     => esc_html__('Size', 'avas-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 5,
                        'max' => 20,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                    'advanced_dots_size' => ''
                ],
            ]
        );

        $this->add_control(
            'advanced_dots_size',
            [
                'label'     => esc_html__('Advanced Size', 'avas-core'),
                'type'      => Controls_Manager::SWITCHER,
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_responsive_control(
            'advanced_dots_width',
            [
                'label'     => esc_html__('Width(px)', 'avas-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                    'advanced_dots_size' => 'yes'
                ],
            ]
        );

        $this->add_responsive_control(
            'advanced_dots_height',
            [
                'label'     => esc_html__('Height(px)', 'avas-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                    'advanced_dots_size' => 'yes'
                ],
            ]
        );

        $this->add_responsive_control(
            'advanced_dots_radius',
            [
                'label'      => esc_html__('Border Radius', 'avas-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                    'advanced_dots_size' => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'dots_box_shadow',
                'selector' => '{{WRAPPER}} .swiper-pagination-bullet',
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_nav_dots_active',
            [
                'label'     => esc_html__('Active', 'avas-core'),
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'active_dot_color',
            [
                'label'     => esc_html__('Active Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .swiper-pagination-bullet-active' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_responsive_control(
            'active_dots_size',
            [
                'label'     => esc_html__('Size', 'avas-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 5,
                        'max' => 20,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet-active' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}' => '--sl-swiper-dots-active-height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                    'advanced_dots_size' => ''
                ],
            ]
        );

        $this->add_responsive_control(
            'active_advanced_dots_width',
            [
                'label'     => esc_html__('Width(px)', 'avas-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                    'advanced_dots_size' => 'yes'
                ],
            ]
        );

        $this->add_responsive_control(
            'active_advanced_dots_height',
            [
                'label'     => esc_html__('Height(px)', 'avas-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet-active' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}' => '--sl-swiper-dots-active-height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                    'advanced_dots_size' => 'yes'
                ],
            ]
        );

        $this->add_responsive_control(
            'active_advanced_dots_radius',
            [
                'label'      => esc_html__('Border Radius', 'avas-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .swiper-pagination-bullet-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                    'advanced_dots_size' => 'yes'
                ],
            ]
        );

        $this->add_responsive_control(
            'active_advanced_dots_align',
            [
                'label'   => esc_html__('Alignment', 'avas-core'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'avas-core'),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'avas-core'),
                        'icon'  => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'avas-core'),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--sl-swiper-dots-align: {{VALUE}};',
                ],
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                    'advanced_dots_size' => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'dots_active_box_shadow',
                'selector' => '{{WRAPPER}} .swiper-pagination-bullet-active',
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'hr_2',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => [
                    'navigation' => 'arrows-fraction',
                ],
            ]
        );

        $this->add_control(
            'fraction_heading',
            [
                'label'     => esc_html__('F R A C T I O N', 'avas-core'),
                'type'      => Controls_Manager::HEADING,
                'condition' => [
                    'navigation' => 'arrows-fraction',
                ],
            ]
        );

        $this->add_control(
            'hr_12',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => [
                    'navigation' => 'arrows-fraction',
                ],
            ]
        );

        $this->add_control(
            'fraction_color',
            [
                'label'     => esc_html__('Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .swiper-pagination-fraction' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation' => 'arrows-fraction',
                ],
            ]
        );

        $this->add_control(
            'active_fraction_color',
            [
                'label'     => esc_html__('Active Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .swiper-pagination-current' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation' => 'arrows-fraction',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'fraction_typography',
                'label'     => esc_html__('Typography', 'avas-core'),
                'selector'  => '{{WRAPPER}} .tx-slider .swiper-pagination-fraction',
                'condition' => [
                    'navigation' => 'arrows-fraction',
                ],
            ]
        );

        $this->add_control(
            'hr_3',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => [
                    'navigation' => 'progressbar',
                ],
            ]
        );

        $this->add_control(
            'progresbar_heading',
            [
                'label'     => esc_html__('P R O G R E S B A R', 'avas-core'),
                'type'      => Controls_Manager::HEADING,
                'condition' => [
                    'navigation' => 'progressbar',
                ],
            ]
        );

        $this->add_control(
            'hr_13',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => [
                    'navigation' => 'progressbar',
                ],
            ]
        );

        $this->add_control(
            'progresbar_color',
            [
                'label'     => esc_html__('Bar Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .swiper-pagination-progressbar' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation' => 'progressbar',
                ],
            ]
        );

        $this->add_control(
            'progres_color',
            [
                'label'     => esc_html__('Progress Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'after',
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .swiper-pagination-progressbar .swiper-pagination-progressbar-fill' => 'background: {{VALUE}}',
                ],
                'condition' => [
                    'navigation' => 'progressbar',
                ],
            ]
        );

        $this->add_control(
            'hr_4',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition'   => [
                    'show_scrollbar' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'scrollbar_heading',
            [
                'label'     => esc_html__('S C R O L L B A R', 'avas-core'),
                'type'      => Controls_Manager::HEADING,
                'condition'   => [
                    'show_scrollbar' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'hr_14',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition'   => [
                    'show_scrollbar' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'scrollbar_color',
            [
                'label'     => esc_html__('Bar Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .swiper-scrollbar' => 'background: {{VALUE}}',
                ],
                'condition'   => [
                    'show_scrollbar' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'scrollbar_drag_color',
            [
                'label'     => esc_html__('Drag Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .swiper-scrollbar .swiper-scrollbar-drag' => 'background: {{VALUE}}',
                ],
                'condition'   => [
                    'show_scrollbar' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'scrollbar_height',
            [
                'label'   => esc_html__('Height', 'avas-core'),
                'type'    => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .swiper-container-horizontal > .swiper-scrollbar' => 'height: {{SIZE}}px;',
                ],
                'condition'   => [
                    'show_scrollbar' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'hr_5',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'navi_offset_heading',
            [
                'label'     => esc_html__('O F F S E T', 'avas-core'),
                'type'      => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'hr_6',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_responsive_control(
            'arrows_ncx_position',
            [
                'label'   => esc_html__('Arrows Horizontal Offset', 'avas-core'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'tablet_default' => [
                    'size' => 0,
                ],
                'mobile_default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'conditions'   => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'arrows',
                        ],
                        [
                            'name'     => 'arrows_position',
                            'operator' => '!=',
                            'value'    => 'center',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--sl-swiper-carousel-arrows-ncx: {{SIZE}}px;'
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_ncy_position',
            [
                'label'   => esc_html__('Arrows Vertical Offset', 'avas-core'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 40,
                ],
                'tablet_default' => [
                    'size' => 40,
                ],
                'mobile_default' => [
                    'size' => 40,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--sl-swiper-carousel-arrows-ncy: {{SIZE}}px;'
                ],
                'conditions'   => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'arrows',
                        ],
                        [
                            'name'     => 'arrows_position',
                            'operator' => '!=',
                            'value'    => 'center',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_acx_position',
            [
                'label'   => esc_html__('Arrows Horizontal Offset', 'avas-core'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 35,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-navigation-prev' => 'left: {{SIZE}}px;',
                    '{{WRAPPER}} .tx-slider .tx-navigation-next' => 'right: {{SIZE}}px;',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'arrows',
                        ],
                        [
                            'name'  => 'arrows_position',
                            'value' => 'center',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_nnx_position',
            [
                'label'   => esc_html__('Dots Horizontal Offset', 'avas-core'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'tablet_default' => [
                    'size' => 0,
                ],
                'mobile_default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'conditions'   => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'dots',
                        ],
                        [
                            'name'     => 'dots_position',
                            'operator' => '!=',
                            'value'    => '',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .swiper-pagination-bullets.swiper-pagination-horizontal' => 'bottom: {{SIZE}}px;'
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_nny_position',
            [
                'label'   => esc_html__('Dots Vertical Offset', 'avas-core'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => -30,
                ],
                'tablet_default' => [
                    'size' => -30,
                ],
                'mobile_default' => [
                    'size' => -30,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .swiper-pagination-bullets.swiper-pagination-horizontal' => 'left: {{SIZE}}px;'
                ],
                'conditions'   => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'dots',
                        ],
                        [
                            'name'     => 'dots_position',
                            'operator' => '!=',
                            'value'    => '',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'both_ncx_position',
            [
                'label'   => esc_html__('Arrows & Dots Horizontal Offset', 'avas-core'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'tablet_default' => [
                    'size' => 0,
                ],
                'mobile_default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'conditions'   => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'both',
                        ],
                        [
                            'name'     => 'both_position',
                            'operator' => '!=',
                            'value'    => 'center',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--sl-swiper-carousel-both-ncx: {{SIZE}}px;'
                ],
            ]
        );

        $this->add_responsive_control(
            'both_ncy_position',
            [
                'label'   => esc_html__('Arrows & Dots Vertical Offset', 'avas-core'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 40,
                ],
                'tablet_default' => [
                    'size' => 40,
                ],
                'mobile_default' => [
                    'size' => 40,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--sl-swiper-carousel-both-ncy: {{SIZE}}px;'
                ],
                'conditions'   => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'both',
                        ],
                        [
                            'name'     => 'both_position',
                            'operator' => '!=',
                            'value'    => 'center',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'both_cx_position',
            [
                'label'   => esc_html__('Arrows Offset', 'avas-core'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 35,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-navigation-prev' => 'left: {{SIZE}}px;',
                    '{{WRAPPER}} .tx-slider .tx-navigation-next' => 'right: {{SIZE}}px;',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'both',
                        ],
                        [
                            'name'  => 'both_position',
                            'value' => 'center',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'both_cy_position',
            [
                'label'   => esc_html__('Dots Offset', 'avas-core'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => -55,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-dots-container' => 'transform: translateY({{SIZE}}px);',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'both',
                        ],
                        [
                            'name'  => 'both_position',
                            'value' => 'center',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_fraction_ncx_position',
            [
                'label'   => esc_html__('Arrows & Fraction Horizontal Offset', 'avas-core'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'tablet_default' => [
                    'size' => 0,
                ],
                'mobile_default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'conditions'   => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'arrows-fraction',
                        ],
                        [
                            'name'     => 'arrows_fraction_position',
                            'operator' => '!=',
                            'value'    => 'center',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--sl-swiper-carousel-arrows-fraction-ncx: {{SIZE}}px;'
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_fraction_ncy_position',
            [
                'label'   => esc_html__('Arrows & Fraction Vertical Offset', 'avas-core'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 40,
                ],
                'tablet_default' => [
                    'size' => 40,
                ],
                'mobile_default' => [
                    'size' => 40,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--sl-swiper-carousel-arrows-fraction-ncy: {{SIZE}}px;'
                ],
                'conditions'   => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'arrows-fraction',
                        ],
                        [
                            'name'     => 'arrows_fraction_position',
                            'operator' => '!=',
                            'value'    => 'center',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_fraction_cx_position',
            [
                'label'   => esc_html__('Arrows Offset', 'avas-core'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 35,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-navigation-prev' => 'left: {{SIZE}}px;',
                    '{{WRAPPER}} .tx-slider .tx-navigation-next' => 'right: {{SIZE}}px;',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'arrows-fraction',
                        ],
                        [
                            'name'  => 'arrows_fraction_position',
                            'value' => 'center',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_fraction_cy_position',
            [
                'label'   => esc_html__('Fraction Offset', 'avas-core'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => -55,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .swiper-pagination-fraction' => 'transform: translateY({{SIZE}}px);',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'arrows-fraction',
                        ],
                        [
                            'name'  => 'arrows_fraction_position',
                            'value' => 'center',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'progress_y_position',
            [
                'label'   => esc_html__('Progress Offset', 'avas-core'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .swiper-pagination-progressbar' => 'transform: translateY({{SIZE}}px);',
                ],
                'condition' => [
                    'navigation' => 'progressbar',
                ],
            ]
        );

        $this->add_responsive_control(
            'scrollbar_vertical_offset',
            [
                'label'   => esc_html__('Scrollbar Offset', 'avas-core'),
                'type'    => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .swiper-container-horizontal > .swiper-scrollbar' => 'bottom: {{SIZE}}px;',
                ],
                'condition'   => [
                    'show_scrollbar' => 'yes'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_scroll_to_top',
            [
                'label'      => esc_html__('Scroll to Top', 'avas-core'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'conditions' => [
                    'terms' => [
                        [
                            'name'  => 'scroll_to_section',
                            'value' => 'yes',
                        ],
                        [
                            'name'     => 'section_id',
                            'operator' => '!=',
                            'value'    => '',
                        ],
                    ],
                ],
            ]
        );

        $this->start_controls_tabs('tabs_scroll_to_top_style');

        $this->start_controls_tab(
            'scroll_to_top_normal',
            [
                'label' => esc_html__('Normal', 'avas-core'),
            ]
        );

        $this->add_control(
            'scroll_to_top_color',
            [
                'label'     => esc_html__('Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-sl-scroll-to-section a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'scroll_to_top_background',
            [
                'label'     => esc_html__('Background', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-sl-scroll-to-section a' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'scroll_to_top_shadow',
                'selector' => '{{WRAPPER}} .tx-slider .tx-sl-scroll-to-section a',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'scroll_to_top_border',
                'label'       => esc_html__('Border', 'avas-core'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .tx-slider .tx-sl-scroll-to-section a',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'scroll_to_top_radius',
            [
                'label'      => esc_html__('Border Radius', 'avas-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tx-slider .tx-sl-scroll-to-section a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'scroll_to_top_padding',
            [
                'label'      => esc_html__('Padding', 'avas-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tx-slider .tx-sl-scroll-to-section a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'scroll_to_top_icon_size',
            [
                'label' => esc_html__('Icon Size', 'avas-core'),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .tx-slider .tx-sl-scroll-to-section a' => 'font-size: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'scroll_to_top_bottom_space',
            [
                'label' => esc_html__('Bottom Space', 'avas-core'),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 300,
                        'step' => 5,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .tx-slider .tx-sl-scroll-to-section' => 'margin-bottom: {{SIZE}}px;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'scroll_to_top_hover',
            [
                'label' => esc_html__('Hover', 'avas-core'),
            ]
        );

        $this->add_control(
            'scroll_to_top_hover_color',
            [
                'label'     => esc_html__('Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-sl-scroll-to-section a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'scroll_to_top_hover_background',
            [
                'label'     => esc_html__('Background', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-sl-scroll-to-section a:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'scroll_to_top_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'scroll_to_top_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-slider .tx-sl-scroll-to-section a:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render_loop_header() {
        $settings = $this->get_settings_for_display();
        $id       = 'tx-slider-' . $this->get_id();

        $this->add_render_attribute('slider', 'id', $id);
        $this->add_render_attribute('slider', 'class', 'tx-slider');

        if ('arrows' == $settings['navigation']) {
            $this->add_render_attribute('slider', 'class', 'tx-arrows-align-' . $settings['arrows_position']);
        } elseif ('dots' == $settings['navigation']) {
            $this->add_render_attribute('slider', 'class', 'tx-dots-align-' . $settings['dots_position']);
        } elseif ('both' == $settings['navigation']) {
            $this->add_render_attribute('slider', 'class', 'tx-arrows-dots-align-' . $settings['both_position']);
        } elseif ('arrows-fraction' == $settings['navigation']) {
            $this->add_render_attribute('slider', 'class', 'tx-arrows-dots-align-' . $settings['arrows_fraction_position']);
        }

        if ('arrows-fraction' == $settings['navigation']) {
            $pagination_type = 'fraction';
        } elseif ('both' == $settings['navigation'] or 'dots' == $settings['navigation']) {
            $pagination_type = 'bullets';
        } elseif ('progressbar' == $settings['navigation']) {
            $pagination_type = 'progressbar';
        } else {
            $pagination_type = '';
        }

        $this->add_render_attribute(
            [
                'slider' => [
                    'data-settings' => [
                        wp_json_encode(array_filter([
                            "autoplay"       => ("yes" == $settings["autoplay"]) ? ["delay"          => $settings["autoplay_speed"]] : false,
                            "loop"           => ($settings["loop"] == "yes") ? true : false,
                            "speed"          => $settings["speed"]["size"],
                            "pauseOnHover"   => ("yes" == $settings["pauseonhover"]) ? true : false,
                            "observer"       => ($settings["observer"]) ? true : false,
                            "observeParents" => ($settings["observer"]) ? true : false,
                            "effect"         => $settings["transition"],
                            "navigation"     => [
                                "nextEl" => "#" . $id . " .tx-navigation-next",
                                "prevEl" => "#" . $id . " .tx-navigation-prev",
                            ],
                            "pagination" => [
                                "el"             => "#" . $id . " .swiper-pagination",
                                "type"           => $pagination_type,
                                "clickable"      => "true",
                                'dynamicBullets' => ("yes" == $settings["dynamic_bullets"]) ? true : false,

                            ],
                            "scrollbar" => [
                                "el"            => "#" . $id . " .swiper-scrollbar",
                                "hide"          => "true",
                            ],
                        ]))
                    ]
                ]
            ]
        );

        if (!isset($settings['scroll_to_section_icon']) && !Icons_Manager::is_migration_allowed()) {
            // add old default
            $settings['scroll_to_section_icon'] = 'fas fa-arrow-down';
        }

        $migrated  = isset($settings['__fa4_migrated']['slider_scroll_to_section_icon']);
        $is_new    = empty($settings['scroll_to_section_icon']) && Icons_Manager::is_migration_allowed();

?>
        <div <?php echo $this->get_render_attribute_string('slider'); ?>>
            <div class="swiper swiper-container">
                <?php if ($settings['scroll_to_section'] && $settings['section_id']) : ?>
                    <div class="tx-sl-scroll-to-section tx-position-bottom-center">
                        <a href="<?php echo esc_url($settings['section_id']); ?>" tx-scroll>
                            <span class="tx-sl-scroll-to-section-icon">

                                <?php if ($is_new || $migrated) :
                                    Icons_Manager::render_icon($settings['slider_scroll_to_section_icon'], ['aria-hidden' => 'true', 'class' => 'fa-fw']);
                                else : ?>
                                    <i class="<?php echo esc_attr($settings['scroll_to_section_icon']); ?>" aria-hidden="true"></i>
                                <?php endif; ?>

                            </span>
                        </a>
                    </div>
                <?php endif;
            }

            public function render_navigation() {
                $settings = $this->get_settings_for_display();
                $hide_arrow_on_mobile = $settings['hide_arrow_on_mobile'] ? ' tx-visible@m' : '';

                if ('arrows' == $settings['navigation']) : ?>
                    <div class="tx-position-z-index tx-position-<?php echo esc_attr($settings['arrows_position'] . $hide_arrow_on_mobile); ?>">
                        <div class="tx-arrows-container tx-slidenav-container">
                            <a href="" class="tx-navigation-prev tx-slidenav-previous tx--icon tx-slidenav">
                                <i class="tx--icon-arrow-left-<?php echo esc_attr($settings['nav_arrows_icon']); ?>" aria-hidden="true"></i>
                            </a>
                            <a href="" class="tx-navigation-next tx-slidenav-next tx--icon tx-slidenav">
                                <i class="tx--icon-arrow-right-<?php echo esc_attr($settings['nav_arrows_icon']); ?>" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                <?php endif;
            }

            public function render_pagination() {
                $settings = $this->get_settings_for_display();

                if ('dots' == $settings['navigation'] or 'arrows-fraction' == $settings['navigation']) : ?>
                    <div class="tx-position-z-index tx-position-<?php echo esc_attr($settings['dots_position']); ?>">
                        <div class="tx-dots-container">
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>

                <?php elseif ('progressbar' == $settings['navigation']) : ?>
                    <div class="swiper-pagination tx-position-z-index tx-position-<?php echo esc_attr($settings['progress_position']); ?>"></div>
                <?php endif;
            }

            public function render_both_navigation() {
                $settings = $this->get_settings_for_display();
                $hide_arrow_on_mobile = $settings['hide_arrow_on_mobile'] ? 'tx-visible@m' : '';

                ?>
                <div class="tx-position-z-index tx-position-<?php echo esc_attr($settings['both_position']); ?>">
                    <div class="tx-arrows-dots-container tx-slidenav-container ">

                        <div class="tx-flex tx-flex-middle">
                            <div class="<?php echo esc_attr($hide_arrow_on_mobile); ?>">
                                <a href="" class="tx-navigation-prev tx-slidenav-previous tx--icon tx-slidenav">
                                    <i class="tx--icon-arrow-left-<?php echo esc_attr($settings['nav_arrows_icon']); ?>" aria-hidden="true"></i>
                                </a>
                            </div>

                            <?php if ('center' !== $settings['both_position']) : ?>
                                <div class="swiper-pagination"></div>
                            <?php endif; ?>

                            <div class="<?php echo esc_attr($hide_arrow_on_mobile); ?>">
                                <a href="" class="tx-navigation-next tx-slidenav-next tx--icon tx-slidenav">
                                    <i class="tx--icon-arrow-right-<?php echo esc_attr($settings['nav_arrows_icon']); ?>" aria-hidden="true"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            <?php
            }

            public function render_arrows_fraction() {
                $settings             = $this->get_settings_for_display();
                $hide_arrow_on_mobile = $settings['hide_arrow_on_mobile'] ? 'tx-visible@m' : '';

            ?>
                <div class="tx-position-z-index tx-position-<?php echo esc_attr($settings['arrows_fraction_position']); ?>">
                    <div class="tx-arrows-fraction-container tx-slidenav-container ">

                        <div class="tx-flex tx-flex-middle">
                            <div class="<?php echo esc_attr($hide_arrow_on_mobile); ?>">
                                <a href="" class="tx-navigation-prev tx-slidenav-previous tx--icon tx-slidenav">
                                    <i class="tx--icon-arrow-left-<?php echo esc_attr($settings['nav_arrows_icon']); ?>" aria-hidden="true"></i>
                                </a>
                            </div>

                            <?php if ('center' !== $settings['arrows_fraction_position']) : ?>
                                <div class="swiper-pagination"></div>
                            <?php endif; ?>

                            <div class="<?php echo esc_attr($hide_arrow_on_mobile); ?>">
                                <a href="" class="tx-navigation-next tx-slidenav-next tx--icon tx-slidenav">
                                    <i class="tx--icon-arrow-right-<?php echo esc_attr($settings['nav_arrows_icon']); ?>" aria-hidden="true"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            <?php
            }

            protected function render_loop_footer() {
                $settings    = $this->get_settings_for_display();

            ?>
                <?php if ('yes' === $settings['show_scrollbar']) : ?>
                    <div class="swiper-scrollbar"></div>
                <?php endif; ?>
            </div>
            <?php if ('both' == $settings['navigation']) : ?>
                <?php $this->render_both_navigation(); ?>
                <?php if ('center' === $settings['both_position']) : ?>
                    <div class="tx-position-z-index tx-position-bottom">
                        <div class="tx-dots-container">
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php elseif ('arrows-fraction' == $settings['navigation']) : ?>
                <?php $this->render_arrows_fraction(); ?>
                <?php if ('center' === $settings['arrows_fraction_position']) : ?>
                    <div class="tx-dots-container">
                        <div class="swiper-pagination"></div>
                    </div>
                <?php endif; ?>
            <?php else : ?>
                <?php $this->render_pagination(); ?>
                <?php $this->render_navigation(); ?>
            <?php endif; ?>
        </div>

    <?php
            }

            public function render() {
                $settings  = $this->get_settings_for_display();

                $this->render_loop_header();

    ?>
        <div class="swiper-wrapper">
            <?php $counter = 1; ?>
            <?php foreach ($settings['tabs'] as $item) : ?>

                <?php
                    $image_src = isset($item['tab_image']['id']) ? wp_get_attachment_image_src($item['tab_image']['id'], 'full') : '';
                    $image     = $image_src ? $image_src[0] : '';
                    $image_url = wp_get_attachment_image_url($item['tab_image']['id'], 'full', false);

                    $image_layer_src = isset($item['tab_image_layer']['id']) ? wp_get_attachment_image_src($item['tab_image_layer']['id'], 'full') : '';
                    $image_layer     = $image_layer_src ? $image_layer_src[0] : '';
                    $image_layer_url = wp_get_attachment_image_url($item['tab_image_layer']['id'], 'full', false);

                    $this->add_render_attribute(
                        [
                            'slide-item' => [
                                'class' => [
                                    'tx-slide-item',
                                    'swiper-slide',
                                    'tx-slide-effect-' . $settings['effect']
                                ],
                            ]
                        ],
                        '',
                        '',
                        true
                    );

                    $this->add_render_attribute(
                        [
                            'slider-link' => [
                                'class' => [
                                    'tx-slide-link',
                                    $settings['button_hover_animation'] ? 'elementor-animation-' . $settings['button_hover_animation'] : '',
                                ],
                                'href'   => isset($item['tab_link']['url']) ? esc_url($item['tab_link']['url']) : '#',
                                'target' => $item['tab_link']['is_external'] ? '_blank' : '_self'
                            ]
                        ],
                        '',
                        '',
                        true
                    );

                    if (!isset($settings['icon']) && !Icons_Manager::is_migration_allowed()) {
                        // add old default
                        $settings['icon'] = 'fas fa-arrow-right';
                    }

                    $migrated  = isset($settings['__fa4_migrated']['slider_icon']);
                    $is_new    = empty($settings['icon']) && Icons_Manager::is_migration_allowed();

                    $this->add_render_attribute('tx-slide-title', 'class', ['tx-slide-title tx-clearfix'], true);

                ?>
                <div <?php echo $this->get_render_attribute_string('slide-item'); ?>>

                        <?php if ($image) : ?>
                            <div class="tx-slider-image-wrapper" style="background-image: url(<?php echo esc_attr($image_url); ?>)"></div>
                        <?php endif; ?>

                        <div class="tx-slide-desc tx-position-large tx-position-<?php echo ($settings['origin']); ?> tx-position-z-index">

                            <?php if (('' !== $item['tab_title']) && ($settings['show_title'])) : ?>
                                <<?php echo $settings['title_tags']; ?> <?php echo $this->get_render_attribute_string('tx-slide-title'); ?>>
                                    <?php echo wp_kses_post($item['tab_title']); ?>
                                </<?php echo $settings['title_tags']; ?>>
                            <?php endif; ?>

                            <?php if ('' !== $item['tab_content']) : ?>
                                <div class="tx-slide-text"><?php echo $this->parse_text_editor($item['tab_content']); ?></div>
                            <?php endif; ?>

                            <?php if ((!empty($item['tab_link']['url'])) && ($settings['show_button'])) : ?>
                                <div class="tx-slide-link-wrapper">
                                    <a <?php echo $this->get_render_attribute_string('slider-link'); ?>>

                                        <?php echo esc_html($item['button_text']); ?>

                                        <?php if ($item['slider_icon']['value']) : ?>
                                            <span class="tx-button-icon-align-<?php echo esc_attr($settings['icon_align']); ?>">

                                                <?php if ($is_new || $migrated) :
                                                    Icons_Manager::render_icon($item['slider_icon'], ['aria-hidden' => 'true', 'class' => 'fa-fw']);
                                                else : ?>
                                                    <i class="<?php echo esc_attr($item['icon']); ?>" aria-hidden="true"></i>
                                                <?php endif; ?>

                                            </span>
                                        <?php endif; ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if ($image_layer) : ?>
                            <div class="tx-slider-image-layer">
                                <img src="<?php echo esc_attr($image_layer_url); ?>" alt="<?php printf(strip_tags($item['tab_title']));?>"> 
                            </div>
                        <?php endif; ?>

                </div>
            <?php
                    $counter++;
                endforeach;
            ?>
        </div>
<?php
                $this->render_loop_footer();
    }
}
