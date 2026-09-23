<?php
namespace AvasElements\Modules\Marquee\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Elementor\Repeater;
use AvasElements\TX_Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Marquee extends Widget_Base {

    public function get_name() {
        return 'avas-marquee';
    }

    public function get_title() {
        return esc_html__( 'Avas Marquee', 'avas-core' );
    }

    public function get_icon() {
        return 'eicon-carousel';
    }
    public function get_keywords() {
        return [ 'marquee','scroll', 'text', 'scroll text', 'animation'];
    }
    public function get_categories() {
        return [ 'avas-elements' ];
    }

	protected function register_controls() {
        $this->start_controls_section(
            'marq_settings',
            [
                'label' => esc_html__('Settings', 'avas-core'),
            ]
        );
        $this->add_control(
            'title_tags',
            [
                'label'   => esc_html__('Title HTML Tag', 'avas-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h5',
                'options' => TX_Helper::title_html_tags(),
            ]
        );
        $this->add_responsive_control(
            'animation_play_state',
            [
                'label'   => esc_html__('Animation', 'avas-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'running',
                'options' => [
                    'running'    => esc_html__('Start', 'avas-core'),
                    'paused'   => esc_html__('Stop', 'avas-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-marquee-content' => 'animation-play-state: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'stop_on_hover',
            [
                'label'   => esc_html__('Stop on hover', 'avas-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'paused',
                'options' => [
                    'running'    => esc_html__('No', 'avas-core'),
                    'paused'   => esc_html__('Yes', 'avas-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-marquee-wrap:hover .tx-marquee-content' => 'animation-play-state: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'animation_direction',
            [
                'label'   => esc_html__('Direction', 'avas-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'normal',
                'options' => [
                    'normal'    => esc_html__('Normal', 'avas-core'),
                    'reverse'   => esc_html__('Reverse', 'avas-core'),
                    'alternate'   => esc_html__('Alternate', 'avas-core'),
                    'alternate-reverse'   => esc_html__('Alternate Reverse', 'avas-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-marquee-content' => 'animation-direction: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'animation_speed',
            [
                'label' => esc_html__( 'Speed', 'plugin-name' ),
                'type' => Controls_Manager::SLIDER,
                'size_unit' => [ 's' ],        
                'range' => [
                    's' => [
                        'step' => 1,
                        'max' => 300,
                    ],

                ],
                'default' => [
                    'unit' => 's',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-marquee-content' => 'animation-duration: {{SIZE}}{{UNIT}};',
                ],       

            ]
        );
        $this->end_controls_section();
		$this->start_controls_section(
            'marq_repeater',
            [
                'label' => esc_html__( 'Marquee', 'avas-core' )
            ]
        );
       
        $repeater = new Repeater();

        $repeater->add_control(
            'select_type',
            [
                'label' => esc_html__( 'Select Type', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'icon' => [
                        'title' => esc_html__( 'Icon', 'avas-core' ),
                        'icon' => 'eicon-star',
                    ],
                    'image' => [
                        'title' => esc_html__( 'Image', 'avas-core' ),
                        'icon' => 'eicon-image',
                    ],
                ],
                'default' => 'icon',
                'toggle' => false,
            ]
        );
        $repeater->add_control(
            'marq_icon',
            [
                'label'   => esc_html__( 'Icon', 'avas-core' ),
                'type'        => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'select_type'   => 'icon'
                ]
            ]
        );
        $repeater->add_control(
            'image',
            [
                'type' => Controls_Manager::MEDIA,
                'show_label' => false,
                'dynamic' => [
                    'active' => true
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'select_type' => 'image'
                ],
            ]
        );
        $repeater->add_control(
            'marq_title', [
                'label' => esc_html__( 'Title', 'avas-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'marquee' , 'avas-core' ),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'marq_title_link',
            [
                'label'       => esc_html__('Button Link', 'avas-core'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => ['active' => true],
                'placeholder' => 'http://your-link.com',
            ]
        );

        $this->add_control(
            'marquee',
            [
                'type'    => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'marq_title'      => esc_html('Nail Gel Refill' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Acrylic Nail Extension' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Natural Nail Gel' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Different Nail Art' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Manicure Service' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Pedicure Service' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Hair Oil Massage' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Hair extension Service' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Hair Gloss' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Different Facial Service' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Face Bleaching' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Cleansing' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Skin Treatment' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Waxing' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Oil Massage' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Threading' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Eyebrow Tint' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Eyebrow Microblading' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Eyelash Extension' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Eyelash Tint' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Casual Makeup' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Event Makeup' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Engagement Makeup' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Bridal Makeup' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Face Shaping' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Botinol' ),
                    ],


                ],
                'title_field' => '{{{ marq_title }}}',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'marq_style',
            [
                'label' => esc_html__( 'Style', 'avas-core' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_control(
            'marq_text_color',
            [
                'label'     => esc_html__( 'Marquee Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-marquee-item *' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'marq_text_hov_color',
            [
                'label'     => esc_html__( 'Marquee Hover Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-marquee-item:hover *' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'marq_icon_color',
            [
                'label'     => esc_html__( 'Icon Color', 'avas-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-marquee-item .tx-marquee-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tx-marquee-item .tx-marquee-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'marq_icon_img_size',
            [
                'label' => esc_html__( 'Icon / Image Size', 'avas-core' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-marquee-item .tx-marquee-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tx-marquee-item .tx-marquee-icon img, {{WRAPPER}} .tx-marquee-item .tx-marquee-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
             'name' => 'marq_title_typography',
             'label' => esc_html__( 'Typography', 'avas-core' ),
                'selector' => '{{WRAPPER}} .tx-marquee-item',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'text_stroke',
                'selector' => '{{WRAPPER}} .tx-marquee-item *',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'text_shadow',
                'selector' => '{{WRAPPER}} .tx-marquee-item *',
            ]
        );
        $this->add_control(
            'marq_icon_margin',
            [
                'label' => esc_html__( 'Icon Margin', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                // 'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tx-marquee-item .tx-marquee-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
       
        $this->end_controls_section();
    }

	protected function render() {
		$settings = $this->get_settings();
        
    ?>

<div class="tx-marquee-wrap">
    <div class="tx-marquee-content" aria-hidden="true">
    <?php foreach ($settings['marquee'] as $marquee) {
            $this->add_render_attribute('tx-marquee', 'class', 'tx-marquee-item', true);
            $this->add_render_attribute(
                        [
                            'tx-marquee-link' => [
                                'class' => [
                                    'tx-marquee-link',
                                ],
                                'href'   => isset($marquee['marq_title_link']['url']) ? esc_url($marquee['marq_title_link']['url']) : '',
                                'target' => $marquee['marq_title_link']['is_external'] ? '_blank' : '_self'
                            ]
                        ],
                        '',
                        '',
                        true
                    );
          
    ?>     
        <div <?php echo $this->get_render_attribute_string('tx-marquee'); ?>>

            <?php if ( !empty( $marquee['marq_title_link']['url'] ) ): ?>
                    <a <?php echo $this->get_render_attribute_string('tx-marquee-link'); ?>>

                        <?php echo '<'.$settings['title_tags'].'>' . $marquee['marq_title'] . '</'.$settings['title_tags'].'>'; ?>

                        <?php if ( 'icon' === $marquee['select_type'] ) : ?>
                          <span class="tx-marquee-icon">
                             <?php Icons_Manager::render_icon( $marquee['marq_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                          </span>
                        <?php endif; ?>

                        <?php if ( 'image' === $marquee['select_type'] ) : ?>
                          <span class="tx-marquee-icon">
                            <?php echo wp_get_attachment_image( $marquee['image']['id'] ); ?>
                          </span>
                        <?php endif; ?>

                    </a>

            <?php else: ?>

                <?php echo '<'.$settings['title_tags'].'>' . $marquee['marq_title']; '</'.$settings['title_tags'].'>'; ?>

                <?php if ( 'icon' === $marquee['select_type'] ) : ?>
                  <span class="tx-marquee-icon">
                     <?php Icons_Manager::render_icon( $marquee['marq_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                  </span>
                <?php endif; ?>
                
                <?php if ( 'image' === $marquee['select_type'] ) : ?>
                  <span class="tx-marquee-icon">
                    <?php echo wp_get_attachment_image( $marquee['image']['id'] ); ?>
                  </span>
                <?php endif; ?>

            <?php endif; ?>

        </div><!-- tx-marquee-item -->

    <?php } ?>

    </div><!-- tx-marquee-container -->
</div><!-- tx-marquee-wrap -->    


<?php	} // render()
} // class 
