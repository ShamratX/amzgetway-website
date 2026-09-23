<?php
namespace AvasElements\Modules\Particles;

use AvasElements\Base\Module_Base;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Control_Media;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	private static $assets_load = null;

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    public function __construct() {

		// Creates  Particles tab at the end of section/column layout tab.
		add_action( 'elementor/element/section/section_layout/after_section_end', array( $this, 'register_controls' ), 10 );
		add_action( 'elementor/element/container/section_layout/after_section_end', array( $this, 'register_controls' ), 10 );
		add_action( 'elementor/element/column/section_advanced/after_section_end', array( $this, 'register_controls' ), 10 );

		add_action( 'elementor/section/print_template', array( $this, '_print_template' ), 10, 2 );
		add_action( 'elementor/container/print_template', array( $this, '_print_template' ), 10, 2 );
		add_action( 'elementor/column/print_template', array( $this, '_print_template' ), 10, 2 );

		// add data before section/column rendering.
		add_action( 'elementor/frontend/section/before_render', array( $this, 'before_render' ), 10, 1 );
		add_action( 'elementor/frontend/container/before_render', array( $this, 'before_render' ), 10, 1 );
		add_action( 'elementor/frontend/column/before_render', array( $this, 'before_render' ), 10, 1 );
		
		add_action( 'elementor/preview/enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_action( 'elementor/frontend/section/before_render', array( $this, 'check_assets_enqueue' ) );
		add_action( 'elementor/frontend/container/before_render', array( $this, 'check_assets_enqueue' ) );
		add_action( 'elementor/frontend/column/before_render', array( $this, 'check_assets_enqueue' ) );

    }

    public function get_name() {
		return 'avas-particles';
	}


	/**
	 * Enqueue scripts.
	 *
	 * Enqueue required JS dependencies for the extension.
	 *
	 * @access public
	 */
	public static function enqueue_scripts() {
        // JS File
        wp_enqueue_script( 'particles', TX_PLUGIN_URL . '/assets/js/widgets/particles/particles.min.js', array('jquery'),TX_PLUGIN_VERSION );
        wp_enqueue_script( 'tx-particles', TX_PLUGIN_URL . '/assets/js/widgets/particles/tx-particles.min.js', array('jquery'),TX_PLUGIN_VERSION );

	}

	 //Register Particles controls.
	public function register_controls( $element ) {

		$element->start_controls_section(
			'section_tx_particles',
			[
				'label' => __( 'Avas Particles', 'avas-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			]
		);
		$element->add_control(
			'tx_particle_switcher',
			[
				'label'        => __( 'Enable Particles', 'avas-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'prefix_class' => 'tx-particles-',
				'render_type'  => 'template',
			]
		);
		$element->add_control (
			'particles_style',
			[
				'label' => __( 'Select Style', 'avas-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'pre_build',
				'options' => [
					'custom'  => __( 'Custom', 'avas-core' ),
					'pre_build' => __( 'Pre Build', 'avas-core' ),
				],
				'condition' => [
					'tx_particle_switcher' => 'yes'
				]
			]
		);

		$element->add_control(
			'particles_code',
			[
				'type'        => Controls_Manager::CODE,
				'label'       => esc_html__( 'Enter Custom JSON', 'avas-core' ),
				'default'     => '',
				'render_type' => 'template',
				'description'   => sprintf(
					__('You can generate custom json from %s here %s  to set particles', 'avas-core'),
					'<a href="https://vincentgarreau.com/particles.js/" target="_blank">',
					'</a>'
				),
				'condition'   => [
					'particles_style' => 'custom',
					'tx_particle_switcher' => 'yes'
				],
			]
		);
        $element->add_control(
            'particles_pre_build_code',
            [
                'label' => esc_html__('Pre Build JSON', 'avas-core'),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => [
                    'default' => __('Default', 'avas-core'),
                    'nasa' => __('Nasa', 'avas-core'),
                    'bubble' => __('Bubble', 'avas-core'),
                    'snow' => __('Snow', 'avas-core'),
                    'nyan_cat' => __('Nyan Cat', 'avas-core'),
                ],
                'default' => 'default',
				'condition'   => [
					'particles_style' => 'pre_build',
					'tx_particle_switcher' => 'yes'
				],
            ]
        );
		$element->add_control(
			'particles_zindex',
			[
				'label'   => __( 'Z-Index', 'avas-core' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
				'condition'   => [
					'tx_particle_switcher' => 'yes'
				],
			]
		);
		$element->add_control(
			'particles_notice',
			[
				'raw'             => __( 'To better view of particles, add background color from the <b>Style Tab</b>', 'avas-core' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition'   => [
					'tx_particle_switcher' => 'yes'
				],
			]
		);
		$element->add_control(
			'particle_hide_on_tablet',
			[
				'label'        => __( 'Hide On Tablet', 'avas-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' =>'no',
				'condition'   => [
					'tx_particle_switcher' => 'yes'
				],
			]
		);
		$element->add_control(
			'particle_hide_on_mobile',
			[
				'label'        => __( 'Hide On Mobile', 'avas-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' =>'no',
				'condition'   => [
					'tx_particle_switcher' => 'yes'
				],
			]
		);
		$element->end_controls_section();

	}

	/**
	 * Render Editor Particles output.
	 *
	 *
	 * @access public
	 * 
	 * @param object $template for current template.
	 * @param object $widget for current widget.
	 */
	public function _print_template( $template, $widget ) {

		//$settings = get_settings_for_display();

		
		if ( $widget->get_name() === 'widget' ) {
			return $template;
		}
		ob_start();
		
		echo '<div class="tx-particle-wrapper" id="tx-particle-id-{{ view.getID() }}" data-particles-style="{{ settings.particles_style }}" data-particle-source="{{ settings.particles_code }}" data-zindex="{{ settings.particles_zindex }}" data-particles-pre-build-code="{{settings.particles_pre_build_code}}" data-hide-on-tablet="{{settings.particle_hide_on_tablet}}" data-hide-on-mobile="{{settings.particle_hide_on_mobile}}"></div>';
		$particles_content = ob_get_contents();
		ob_end_clean();

		return $template . $particles_content;

	}

	/**
	 * Render HTML output on the frontend.
	 *
	 * Written in PHP and used to generate the final Output.
	 *
	 * @access public
	 * @param object $element for current element.
	 */
	public function before_render( $element ) {

		$settings = $element->get_settings_for_display();
		$sectionid = $element->get_id();

		if ( 'yes' == $settings['tx_particle_switcher'] ) {
			$element->add_render_attribute( '_wrapper', [
				'data-particles-style' => $settings['particles_style'],
				'data-particle-source' => ($settings['particles_code']) ? $settings['particles_code']:'',
				'data-particles-pre-build-code' => $settings['particles_pre_build_code'],
				'data-zindex' => $settings['particles_zindex'],
				'data-hide-on-tablet' => $settings['particle_hide_on_tablet'],
				'data-hide-on-mobile' => $settings['particle_hide_on_mobile'],
				'data-zindex' => $settings['particles_zindex'],
				'id' => "tx-particle-id-{$sectionid}",
			] );
		}
	}


	 //Check Assets Enqueue
	public function check_assets_enqueue( $element ) {
		if ( self::$assets_load ) {
			return;
		}
		if ( 'yes' === $element->get_settings_for_display( 'tx_particle_switcher' ) ) {
			// $this->enqueue_styles();
			$this->enqueue_scripts();
			self::$assets_load = true;
			remove_action( 'elementor/frontend/section/before_render', array( $this, 'check_assets_enqueue' ) );
			remove_action( 'elementor/frontend/column/before_render', array( $this, 'check_assets_enqueue' ) );
			remove_action( 'elementor/frontend/container/before_render', array( $this, 'check_assets_enqueue' ) );
		}
	}
}


