<?php
namespace AvasElements\Modules\EventsCalendar\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Utils;
use AvasElements\TX_Helper;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class EventsCalendar extends Widget_Base {

    public function get_name() {
        return 'avas-events-calendar';
    }

    public function get_title() {
        return esc_html__( 'Avas Events Calendar', 'avas-core' );
    }

    public function get_icon() {
        return 'eicon-calendar';
    }

    public function get_categories() {
        return [ 'avas-elements' ];
    }
	public function register_controls() {

        // Layout Section
        $this->start_controls_section(
            'section_content_layout',
            [
                'label' => esc_html__('Layout', 'avas-core'),
            ]
        );

        $this->add_control(
            'disp_style',
            [
                'label'       => esc_html__('Style', 'avas-core'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'style-1',
                'options'     => [
                    'style-1' => esc_html__('Style 1', 'avas-core'),
                    'style-2' => esc_html__('Style 2', 'avas-core'),
                ],
                
            ]
        );

        $this->add_responsive_control(
            'list_row_gap',
            [
                'label' => esc_html__('Row Gap', 'avas-core'),
                'type'  => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 25,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-event-calendar' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],

            ]
        );

        $this->add_control(
            'show_image',
            [
                'label'   => esc_html__('Show Image', 'avas-core'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'disp_style' => 'style-2'
                ]
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label'   => esc_html__('Show Title', 'avas-core'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );


        $this->add_control(
            'show_date',
            [
                'label'   => esc_html__('Show Date', 'avas-core'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_time',
            [
                'label'   => esc_html__('Show Time', 'avas-core'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'disp_style' => 'style-1'
                ]
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label'   => esc_html__('Show Excerpt', 'avas-core'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'excerpt_words',
            [
                'label'     => esc_html__('Excerpt Length', 'avas-core'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 15,
                'condition' => [
                    'show_excerpt' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_cost',
            [
                'label'   => esc_html__('Show Cost', 'avas-core'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_image',
            [
                'label' => esc_html__('Image', 'avas-core'),
                'condition' => [
                    'disp_style' => 'style-2'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'    => 'image',
                'label'   => esc_html__('Image Size', 'avas-core'),
                'exclude' => ['custom'],
                'default' => 'thumbnail',
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label'   => esc_html__('Image Height', 'avas-core'), 
                'type'    => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-event-calendar .tx-event-image img' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                ],

            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_content_query',
            [
                'label' => esc_html__('Query', 'avas-core'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'event_categories',
            [
                'label'       => esc_html__('Categories', 'avas-core'),
                'type'        => Controls_Manager::SELECT2,
                'options'     => TX_Helper::get_post_type_categories(['taxonomy' => 'tribe_events_cat', 'hide_empty' => false]),
                'default'     => [],
                'label_block' => true,
                'multiple'    => true,
            ]
        );


        $this->add_control(
            'start_date',
            [
                'label'   => esc_html__('Start Date', 'avas-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    ''           => esc_html__('Any Time', 'avas-core'),
                    'now'        => esc_html__('Now', 'avas-core'),
                    'today'      => esc_html__('Today', 'avas-core'),
                    'last month' => esc_html__('Last Month', 'avas-core'),
                    'custom'     => esc_html__('Custom', 'avas-core'),
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'custom_start_date',
            [
                'label'   => esc_html__('Custom Start Date', 'avas-core'),
                'type'    => Controls_Manager::DATE_TIME,
                'condition' => [
                    'start_date' => 'custom'
                ]
            ]
        );

        $this->add_control(
            'end_date',
            [
                'label'   => esc_html__('End Date', 'avas-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    ''           => esc_html__('Any Time', 'avas-core'),
                    'now'        => esc_html__('Now', 'avas-core'),
                    'today'      => esc_html__('Today', 'avas-core'),
                    'next month' => esc_html__('Last Month', 'avas-core'),
                    'custom'     => esc_html__('Custom', 'avas-core'),
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'custom_end_date',
            [
                'label'   => esc_html__('Custom End Date', 'avas-core'),
                'type'    => Controls_Manager::DATE_TIME,
                'condition' => [
                    'end_date' => 'custom'
                ]
            ]
        );

        $this->add_control(
            'limit',
            [
                'label'   => esc_html__('Limit', 'avas-core'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'   => esc_html__('Order by', 'avas-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'event_date',
                'options' => [
                    'event_date' => esc_html__('Event Date', 'avas-core'),
                    'title'      => esc_html__('Title', 'avas-core'),
                    'category'   => esc_html__('Category', 'avas-core'),
                    'rand'       => esc_html__('Random', 'avas-core'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label'   => esc_html__('Order', 'avas-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'DESC' => esc_html__('Descending', 'avas-core'),
                    'ASC'  => esc_html__('Ascending', 'avas-core'),
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'section_style_item',
            [
                'label'     => esc_html__('Events', 'avas-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_item_style');

        $this->start_controls_tab(
            'tab_item_normal',
            [
                'label' => esc_html__('Normal', 'avas-core'),
            ]
        );

        $this->add_control(
            'event_calendar_bg_color_odd',
            [
                'label' => esc_html__('Background Color(Odd)', 'avas-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FCEDDC',
                'selectors' => [
                    '{{WRAPPER}} .tx-event-calendar:nth-child(odd)' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'event_calendar_bg_color_even',
            [
                'label' => esc_html__('Background Color(Even)', 'avas-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#EEE9F6',
                'selectors' => [
                    '{{WRAPPER}} .tx-event-calendar:nth-child(even)' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'event_calendar_sep_color',
            [
                'label' => esc_html__('Separator Color', 'avas-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-event-cal-sep' => 'border-color: {{VALUE}};',
                ],
                'condition' => ['disp_style' => 'style-1']
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'item_shadow',
                'selector' => '{{WRAPPER}} .tx-event-calendar',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'item_border',
                'label'       => esc_html__('Border', 'avas-core'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .tx-event-calendar',
            ]
        );

        $this->add_control(
            'item_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'avas-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tx-event-calendar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_item_hover',
            [
                'label' => esc_html__('Hover', 'avas-core'),
            ]
        );

        $this->add_control(
            'event_calendar_bg_color_odd_hover',
            [
                'label' => esc_html__('Background Color(Odd)', 'avas-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FCEDDC',
                'selectors' => [
                    '{{WRAPPER}} .tx-event-calendar:hover:nth-child(odd)' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'disp_style' => ['style-1'],
                ],
            ]
        );
        $this->add_control(
            'event_calendar_bg_color_even_hover',
            [
                'label' => esc_html__('Background Color(Even)', 'avas-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#EEE9F6',
                'selectors' => [
                    '{{WRAPPER}} .tx-event-calendar:hover:nth-child(even)' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'item_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-event-calendar:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'item_hover_shadow',
                'selector' => '{{WRAPPER}} .tx-event-calendar:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_image',
            [
                'label'     => esc_html__('Image', 'avas-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'disp_style' => ['style-2'],
                ],
            ]
        );

        $this->add_responsive_control(
            'image_padding',
            [
                'label'      => esc_html__('Padding', 'avas-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .tx-event-calendar .tx-event-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_margin',
            [
                'label'      => esc_html__('Margin', 'avas-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .tx-event-calendar .tx-event-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label'      => esc_html__('Image Radius', 'avas-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tx-event-calendar .tx-event-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_opacity',
            [
                'label'   => esc_html__('Opacity (%)', 'avas-core'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 1,
                ],
                'range' => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-event-calendar .tx-event-image img' => 'opacity: {{SIZE}};',
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
                    '{{WRAPPER}} .tx-event-calendar .tx-event-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label'     => esc_html__('Hover Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-event-calendar .tx-event-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => esc_html__('Typography', 'avas-core'),
                'selector' => '{{WRAPPER}} .tx-event-calendar .tx-event-title-wrap',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_date',
            [
                'label'     => esc_html__('Date', 'avas-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_date' => ['yes'],
                ],
            ]
        );

        $this->add_control(
            'date_color',
            [
                'label'     => esc_html__('Date Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-event-cal-date' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'date_typography',
                'label'    => esc_html__('Typography', 'avas-core'),
                'selector' => '{{WRAPPER}} .tx-event-cal-date',
            ]
        );

        $this->add_control(
            'day_color',
            [
                'label'     => esc_html__('Day Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-event-day' => 'color: {{VALUE}};',
                ],
                'condition' => ['disp_style' => 'style-1']
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'day_typography',
                'label'    => esc_html__('Day Typography', 'avas-core'),
                'selector' => '{{WRAPPER}} .tx-event-day',
                'condition' => ['disp_style' => 'style-1']
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_time',
            [
                'label'     => esc_html__('Time', 'avas-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_time' => ['yes'],
                ],
            ]
        );

        $this->add_control(
            'time_color',
            [
                'label'     => esc_html__('Time Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-event-cal-time' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'time_typography',
                'label'    => esc_html__('Typography', 'avas-core'),
                'selector' => '{{WRAPPER}} .tx-event-cal-time',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_excerpt',
            [
                'label'     => esc_html__('Excerpt', 'avas-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_excerpt' => ['yes'],
                ],
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label'     => esc_html__('Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-event-calendar .tx-event-excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'excerpt_typography',
                'label'    => esc_html__('Typography', 'avas-core'),
                'selector' => '{{WRAPPER}} .tx-event-calendar .tx-event-excerpt',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_cost',
            [
                'label'     => esc_html__('Cost', 'avas-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_cost' => ['yes'],
                ],
            ]
        );

        $this->add_control(
            'cost_color',
            [
                'label'     => esc_html__('Cost Color', 'avas-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-event-cal-cost' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'cost_typography',
                'label'    => esc_html__('Typography', 'avas-core'),
                'selector' => '{{WRAPPER}} .tx-event-cal-cost',
            ]
        );

        $this->end_controls_section();

    }

    public function render() {

        $settings = $this->get_settings_for_display();

        global $post;

        $start_date = ('custom' == $settings['start_date']) ? $settings['custom_start_date'] : $settings['start_date'];
        $end_date   = ('custom' == $settings['end_date']) ? $settings['custom_end_date'] : $settings['end_date'];

        $query_args = array_filter([
            'start_date'     => $start_date,
            'end_date'       => $end_date,
            'orderby'        => $settings['orderby'],
            'order'          => $settings['order'],
            'eventDisplay'   => ('custom' == $settings['start_date'] or 'custom' == $settings['end_date']) ? 'custom' : 'all',
            'posts_per_page' => $settings['limit'],
        ]);


        if ( !empty($settings['event_categories'])) {
            $query_args['tax_query'] = [
             'taxonomy' => 'tribe_events_cat',
             'field'    => 'slug',
             'terms'    => $settings['event_categories']
            ];
            $query_args['event_category']    = $settings['event_categories'];
        }

        $query_args = tribe_get_events($query_args);        

        if(!empty($query_args)){
            foreach ($query_args as $post) {
                $this->render_loop_item($post);
            }
        } else {
            echo '<h3>'.esc_html__('No events!', 'avas-core').'</h3>';
        }

        wp_reset_postdata();
    }

    public function render_image() {
        $settings = $this->get_settings_for_display();

        if (!$this->get_settings('show_image')) {
            return;
        }

        $settings['image'] = [
            'id' => get_post_thumbnail_id(),
        ];

        $image_html        = Group_Control_Image_Size::get_attachment_image_html($settings, 'image');
        $placeholder_image_src = Utils::get_placeholder_image_src();

        if (!$image_html) {
            $image_html = '<img src="' . esc_url($placeholder_image_src) . '" alt="' . get_the_title() . '">';
        }

?>

        <div class="tx-event-image tx-background-cover">
                <img src="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size']); ?>" alt="<?php echo get_the_title(); ?>">
        </div>
    <?php
    }

    public function render_title() {
        $settings = $this->get_settings_for_display();
        if (!$this->get_settings('show_title')) {
            return;
        }

    ?>

        <h3 class="tx-event-title-wrap">
            <a href="<?php echo get_permalink(); ?>" class="tx-event-title"><?php the_title() ?></a>
        </h3>
    <?php
    }

    public function render_time() {
        $settings = $this->get_settings_for_display();
        if(tribe_get_start_time() && $settings['show_time']) : ?>
        <div class="tx-event-cal-time">
            <?php
            echo '<i class="bi bi-clock"></i> ' . tribe_get_start_time(); 
            echo tribe_get_datetime_separator(' - ');
            echo tribe_get_end_time();
            ?>
        </div>
        <?php endif;
    }

    public function render_date() {
        if (!$this->get_settings('show_date')) {
            return;
        }
        $event_day = tribe_get_start_date(null, false, 'j');
        $event_month = tribe_get_start_date(null, false, 'M');

    ?>
        <div class="tx-event-date">
            <div class="tx-event-day">
                <?php echo esc_html($event_day);  ?>
            </div>
            <?php echo $event_month; ?>   
        </div>
    <?php
    }

    public function render_excerpt() {
        if (!$this->get_settings('show_excerpt')) {
            return;
        }
        $settings = $this->get_settings_for_display();
    ?>
        <div class="tx-event-excerpt">
        <?php echo TX_Helper::excerpt_limit($settings['excerpt_words']); ?>
        </div>
    <?php

    }

    public function render_loop_item($post) {
        $settings = $this->get_settings_for_display();

    ?>

    <!-- style 1 -->
    <?php if('style-1' === $settings['disp_style']) : ?>
    <div class="container tx-event-calendar <?php echo esc_attr($settings['disp_style']); ?>">
        <div class="row">
            <?php if($settings['show_date']): ?>
            <div class="col-md-2 tx-event-cal-date">
                <?php $this->render_date(); ?>
            </div>
            <?php endif; ?>
            <span class="tx-event-cal-sep"></span>
            <div class="col-md-6">
                <?php $this->render_title(); ?>
                <?php $this->render_excerpt(); ?>
            </div>
            <span class="tx-event-cal-sep"></span>
            <div class="col-md-4 tx-event-cal-meta">
                <?php if(tribe_get_formatted_cost() && $settings['show_cost']): ?>
                    <div class="tx-event-cal-cost">
                        <i class="fa fa-ticket" aria-hidden="true"></i> <?php echo tribe_get_formatted_cost(); ?>
                    </div>
                <?php endif; ?>
                <?php $this->render_time(); ?>
            </div>
        </div>
    </div>
    <?php endif; ?><!-- end style 1 -->

    <!-- style 2 -->
    <?php if('style-2' === $settings['disp_style']) : ?>
        <div class="tx-event-calendar <?php echo esc_attr($settings['disp_style']); ?>">
            <div class="tx-event-cal-image">
                <?php $this->render_image(); ?>
            </div>
            <div class="tx-event-cal-detail">
                <?php if(tribe_get_start_date() && $settings['show_date']): ?>
                    <span class="tx-event-cal-date"><i class="bi bi-calendar4"></i> <?php echo tribe_get_start_date(); ?></span>
                <?php endif; ?>
                <?php $this->render_title(); ?>
                <?php $this->render_excerpt(); ?>
                <?php if(tribe_get_formatted_cost() && $settings['show_cost']): ?>
                    <div class="tx-event-cal-cost">
                        <i class="fa fa-ticket" aria-hidden="true"></i> <?php echo tribe_get_formatted_cost(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?><!-- end style 2 -->

            
<?php
        }
    }
