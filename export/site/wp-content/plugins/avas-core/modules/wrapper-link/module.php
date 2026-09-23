<?php

namespace AvasElements\Modules\WrapperLink;

use Elementor\Controls_Manager;
use AvasElements\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Module extends Module_Base {

	public function __construct() {
		parent::__construct();
		$this->add_actions();
	}

	public function get_name() {
		return 'avas-wrapper-link';
	}

	public function register_section( $element ) {

		if ( 'section' === $element->get_name() || 'column' === $element->get_name() || 'container' === $element->get_name() ) {
			$tabs = Controls_Manager::TAB_LAYOUT;
		} else {
			$tabs = Controls_Manager::TAB_CONTENT;
		}

		$element->start_controls_section(
			'sec_wraplink',
			[ 
				'tab'   => $tabs,
				'label' => esc_html__('Avas Wrapper Link', 'avas-core'),
			]
		);

		$element->end_controls_section();
	}


	public function register_controls( $widget, $args ) {
		$widget->add_control(
			'tx_wrapper_link',
			[ 
				'label' => esc_html__( 'Link', 'avas-core' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://example.com', 'avas-core' ),
				'show_external' => true,
				'default' => [ 'url' => '' ],
				'dynamic' => [ 'active' => true ],
				'render_type' => 'none',
			]
		);
	}


	public function wrapper_link_before_render( $widget ) {
		$element_link = $widget->get_settings_for_display( 'tx_wrapper_link' );

		if ( $element_link && ! empty( $element_link['url'] ) ) {
			$element_link['url'] = esc_url( $element_link['url'] );

			$widget->add_render_attribute(
				'_wrapper',
				[ 
					'data-tx-wrapper-link' => wp_json_encode( $element_link, true ),
					'style' => 'cursor: pointer',
					'class' => 'tx-wrapper-link'
				]
			);
		}
	}

	public function enqueue_scripts() {
		wp_enqueue_script( 'tx-wrapper-link' );
	}

	public function should_script_enqueue( $widget ) {
		$element_link = $widget->get_settings_for_display( 'tx_wrapper_link' );

		if ( $element_link && ! empty( $element_link['url'] ) ) {
			$this->enqueue_scripts();
		}
	}

	protected function add_actions() {

		// Add container settings
		add_action( 'elementor/element/container/section_layout_container/after_section_end', [ $this, 'register_section' ] );
		add_action( 'elementor/element/container/sec_wraplink/before_section_end', [ $this, 'register_controls' ], 10, 2 );
		add_action( 'elementor/frontend/container/after_render', [ $this, 'should_script_enqueue' ] );


		// Add section settings
		add_action( 'elementor/element/section/section_advanced/after_section_end', [ $this, 'register_section' ] );
		add_action( 'elementor/element/section/sec_wraplink/before_section_end', [ $this, 'register_controls' ], 10, 2 );

		// Add column settings
		add_action( 'elementor/element/column/section_advanced/after_section_end', [ $this, 'register_section' ] );
		add_action( 'elementor/element/column/sec_wraplink/before_section_end', [ $this, 'register_controls' ], 10, 2 );

		// Add widget settings
		add_action( 'elementor/element/common/_section_style/after_section_end', [ $this, 'register_section' ] );
		add_action( 'elementor/element/common/sec_wraplink/before_section_end', [ $this, 'register_controls' ], 10, 2 );


		add_action( 'elementor/frontend/before_render', [ $this, 'wrapper_link_before_render' ], 10, 1 );

		add_action( 'elementor/frontend/before_render', [ $this, 'should_script_enqueue' ] );
	}
}
