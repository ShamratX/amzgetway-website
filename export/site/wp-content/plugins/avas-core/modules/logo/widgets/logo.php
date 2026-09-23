<?php
namespace AvasElements\Modules\Logo\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Logo extends Widget_Base {
        
    public function get_name() {
        return 'avas-logo';
    }

    public function get_title() {
        return esc_html__( ' Avas Logo', 'avas-core' );
    }

    public function get_icon() {
        return 'eicon-logo';
    }

    public function get_categories() {
        return [ 'avas-elements'];
    }

    public function get_keywords() {
        return [ 'site logo', 'image' ];
    }

    protected function register_controls() {
        
        // Section: Logo -------------
        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__( 'General', 'avas-core' ),
            ]
        );
        
        $this->add_control(
            'image',
            [
                'label' => esc_html__( 'Image', 'avas-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'retina_image',
            [
                'label' => esc_html__( 'Retina Image', 'avas-core' ),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'mobile_image',
            [
                'label' => esc_html__( 'Mobile Image', 'avas-core' ),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'title_type',
            [
                'label' => esc_html__( 'Site Title', 'avas-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__( 'None', 'avas-core' ),
                    'default' => esc_html__( 'Default', 'avas-core' ),
                    'custom' => esc_html__( 'Custom', 'avas-core' ),
                ],          
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'custom_title',
            [
                'label' => esc_html__( 'Title Text', 'avas-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'My Custom Logo',
                'condition' => [
                    'title_type' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'description_type',
            [
                'label' => esc_html__( 'Tagline', 'avas-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__( 'None', 'avas-core' ),
                    'default' => esc_html__( 'Default', 'avas-core' ),
                    'custom' => esc_html__( 'Custom', 'avas-core' ),
                ],          
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'custom_description',
            [
                'label' => esc_html__( 'Tagline Text', 'avas-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Tagline',
                'condition' => [
                    'description_type' => 'custom',
                ],
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__( 'Alignment', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'left',
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
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'url_type',
            [
                'label' => esc_html__( 'Logo URL', 'avas-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'none' => esc_html__( 'None', 'avas-core' ),
                    'default' => esc_html__( 'Default', 'avas-core' ),
                    'custom' => esc_html__( 'Custom', 'avas-core' ),
                ],
            ]
        );

        $this->add_control(
            'custom_url',
            [
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://www.your-link.com', 'avas-core' ),
                'condition' => [
                    'url_type' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'remove_front_page_url',
            [
                'label' => esc_html__( 'Disable Link on Front Page', 'avas-core' ),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'url_type!' => 'none',
                ],
            ]
        );

        $this->end_controls_section(); // End Controls Section


        // Styles
        // Section: General ----------
        $this->start_controls_section(
            'section_style_general',
            [
                'label' => esc_html__( 'General', 'avas-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bg_color',
            [
                'label' => esc_html__( 'Background Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-logo-widget' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label' => esc_html__( 'Padding', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tx-logo-widget' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'image_section',
            [
                'label' => esc_html__( 'Image', 'avas-core' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__( 'Width', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 200,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-logo-widget-image' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'position',
            [
                'label' => esc_html__( 'Alignment', 'avas-core' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'center',
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'avas-core' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'avas-core' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'avas-core' ),
                        'icon' => 'eicon-h-align-right',
                    ]
                ],
                'prefix_class'  => 'tx-logo-widget-position-',
            ]
        );

        $this->add_responsive_control(
            'image_distance',
            [
                'label' => esc_html__( 'Distance', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}}.tx-logo-widget-position-left .tx-logo-widget-image' => 'margin-right:{{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.tx-logo-widget-position-right .tx-logo-widget-image' => 'margin-left:{{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.tx-logo-widget-position-center .tx-logo-widget-image' => 'margin-bottom:{{SIZE}}{{UNIT}};',
                ],  
            ]
        );
        
        $this->start_controls_tabs( 'logo_img_effects' );

        $this->start_controls_tab( 'normal',
            [
                'label' => esc_html__( 'Normal', 'avas-core' ),
            ]
        );

        $this->add_control(
            'opacity',
            [
                'label' => esc_html__( 'Opacity', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.0,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-logo-widget-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .tx-logo-widget-image img',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'hover',
            [
                'label' => esc_html__( 'Hover', 'avas-core' ),
            ]
        );

        $this->add_control(
            'opacity_hv',
            [
                'label' => esc_html__( 'Opacity', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.0,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-logo-widget:hover img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters_hv',
                'selector' => '{{WRAPPER}} .tx-logo-widget:hover img',
            ]
        );

        $this->add_control(
            'bg_hv_duration',
            [
                'label' => esc_html__( 'Transition Duration', 'avas-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 0.7,
                'min' => 0,
                'max' => 5,
                'step' => 0.1,
                'selectors' => [
                    '{{WRAPPER}} .tx-logo-widget-image img' => '-webkit-transition-duration: {{VALUE}}s;transition-duration: {{VALUE}}s',
                ],
                
            ]
        );

        $this->add_control(
            'hv_animation',
            [
                'label' => esc_html__( 'Hover Animation', 'avas-core' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'title_section',
            [
                'label' => esc_html__( 'Site Title', 'avas-core' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

       $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-logo-widget-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .tx-logo-widget-title',
            ]
        );

        $this->add_responsive_control(
            'title_distance',
            [
                'label' => esc_html__( 'Distance', 'avas-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx-logo-widget-title' => 'margin: 0 0 {{SIZE}}{{UNIT}};',
                ],  
            ]
        );

        $this->add_control(
            'description_section',
            [
                'label' => esc_html__( 'Tagline', 'avas-core' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

       $this->add_control(
            'description_color',
            [
                'label' => esc_html__( 'Color', 'avas-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-logo-widget-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .tx-logo-widget-description',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'label' => esc_html__( 'Border', 'avas-core' ),
                'selector' => '{{WRAPPER}} .tx-logo-widget',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'avas-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tx-logo-widget' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'selector' => '{{WRAPPER}} .tx-logo-widget'
            ]
        );

        $this->end_controls_section(); // End Controls Section
    }

    public function logo_is_linked() {

        $settings = $this->get_settings();

        if ( 'none' === $settings['url_type'] ) {
            return false;
        }

        if ( 'yes' === $settings['remove_front_page_url'] && is_front_page() ) {
            return false;
        }

        return true;
    }
        

    protected function render() {

    $settings = $this->get_settings(); 

    $image_src = esc_url( $settings['image']['url'] );  
    $mobile_image_src = esc_url( $settings['mobile_image']['url'] );
    
    // Title
    $title = '';
    if ( 'default' === $settings['title_type'] ) {
        $title = get_bloginfo( 'name' );
    } elseif ( 'custom' === $settings['title_type'] ) {
        $title = $settings['custom_title'];
    }

    // Description
    $description = '';
    if ( 'default' === $settings['description_type'] ) {
        $description =  get_bloginfo( 'description' );
    } elseif ( 'custom' === $settings['description_type'] ) {
        $description = $settings['custom_description'];
    }

    // Image hover animation
    $this->add_render_attribute( 'image_attr', 'class', 'tx-logo-widget-image' );
    if ( $settings['hv_animation'] ) {
        $this->add_render_attribute( 'image_attr', 'class', 'elementor-animation-'. $settings['hv_animation'] );
    }

    // Logo URL
    $this->add_render_attribute( 'url_attr', 'class', 'tx-logo-widget-url' );
    $this->add_render_attribute( 'url_attr', 'rel', 'home' );
    
    if ( 'default' === $settings['url_type'] ) {
        $this->add_render_attribute( 'url_attr', 'href',  home_url( '/' ) );
    } elseif ( 'custom' === $settings['url_type'] ) {

        if ( $settings['custom_url']['is_external'] ) {
            $this->add_render_attribute( 'url_attr', 'target', '_blank' );
        }

        if ( $settings['custom_url']['nofollow'] ) {
            $this->add_render_attribute( 'url_attr', 'nofollow', '' );
        }

        $this->add_render_attribute( 'url_attr', 'href',  $settings['custom_url']['url'] );
    }

    ?>
    
    <div class="tx-logo-widget elementor-clearfix">

        <?php if ( !empty( $image_src ) ) : ?>
        <picture <?php echo $this->get_render_attribute_string( 'image_attr' ); ?>>
            <?php if ( ! empty( $mobile_image_src ) ) : ?>
            <source media="(max-width: 767px)" srcset="<?php echo esc_attr( $mobile_image_src ); ?>">   
            <?php endif; ?>

            <?php if ( ! empty( $settings['retina_image']['url'] ) ) : ?>
            <source srcset="<?php echo esc_attr( $image_src ); ?> 1x, <?php echo esc_attr( $settings['retina_image']['url'] ); ?> 2x">  
            <?php endif; ?>
            
            <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr( $title ); ?>">

            <?php if ( $this->logo_is_linked() ) : ?>
                <a <?php echo $this->get_render_attribute_string( 'url_attr' ); ?>></a>
            <?php endif; ?>
        </picture>
        <?php endif; ?>

        <?php if ( ! empty( $title ) || ! empty( $description ) ) : ?>
        <div class="tx-logo-widget-text">
            <?php if ( ! empty( $title ) ) : ?>
                <?php if ( is_home() || is_front_page() ) : ?>
                    <h1 class="tx-logo-widget-title"><?php echo esc_html__( $title ); ?></h1>
                <?php else : ?>
                    <p class="tx-logo-widget-title"><?php echo esc_html__( $title ); ?></p>
                <?php endif; ?>
            <?php endif; ?>

            <?php
            if ( ! empty( $description ) ) : ?>
                <p class="tx-logo-widget-description"><?php echo esc_html__( $description ); ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if ( $this->logo_is_linked() ) : ?>
            <a <?php echo $this->get_render_attribute_string( 'url_attr' ); ?>></a>
        <?php endif; ?>

    </div>
        
<?php
    }
}