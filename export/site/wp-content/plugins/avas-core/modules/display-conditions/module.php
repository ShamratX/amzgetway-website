<?php

namespace AvasElements\Modules\DisplayConditions;

use AvasElements\Base\Module_Base;
use Elementor\Element_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use AvasElements\TX_Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Module extends Module_Base {	

	/**
	 * Initialize hooks
	 */
	public function __construct() {

		add_action( 'elementor/element/common/_section_style/after_section_end', [ $this, 'register_controls' ] );
		add_action( 'elementor/element/column/section_advanced/after_section_end', [ $this, 'register_controls' ] );
		add_action( 'elementor/element/section/section_advanced/after_section_end', [ $this, 'register_controls' ] );
		add_action( 'elementor/element/container/section_layout/after_section_end', [ $this, 'register_controls' ] );

		add_filter( 'elementor/frontend/widget/should_render', [ $this, 'content_render' ], 10, 2 );
		add_filter( 'elementor/frontend/column/should_render', [ $this, 'content_render' ], 10, 2 );
		add_filter( 'elementor/frontend/section/should_render', [ $this, 'content_render' ], 10, 2 );
		add_filter( 'elementor/frontend/container/should_render', [ $this, 'content_render' ], 10, 2 );
	}

	public function get_name() {
		return 'avas-display-conditions';
	}

	public function register_controls( $element ) {
		$element->start_controls_section(
			'tx_conditional_logic_section',
			[
				'label' => esc_html__( 'Avas Conditional Display', 'avas-core' ),
				'tab'   => Controls_Manager::TAB_ADVANCED
			]
		);

		$element->add_control(
			'tx_cl_enable',
			[
				'label'          => esc_html__( 'Enable Conditional Display', 'avas-core' ),
				'type'           => Controls_Manager::SWITCHER,
				'default'        => '',
				'label_on'       => esc_html__( 'Yes', 'avas-core' ),
				'label_off'      => esc_html__( 'No', 'avas-core' ),
				'return_value'   => 'yes',
				'style_transfer' => false
			]
		);

		$element->add_control(
			'tx_cl_notice',
			[
				'raw'             => esc_html__( 'Conditional Display will take effect only on preview or live page, and not while editing in Elementor.', 'avas-core' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor',
				'condition'       => [
					'tx_cl_enable' => 'yes'
				]
			]
		);

		

		$element->add_control(
			'tx_cl_visibility_action',
			[
				'label'          => esc_html__( 'Visibility Action', 'avas-core' ),
				'type'           => Controls_Manager::SELECT,
				'options'        => [
					'show'             => esc_html__( 'Show', 'avas-core' ),
					'hide'             => esc_html__( 'Hide', 'avas-core' ),
					'forcefully_hide'  => esc_html__( 'Hide Without Condition', 'avas-core' ),
				],
				'default'        => 'show',
				'toggle'         => false,
				'condition'      => [
					'tx_cl_enable' => 'yes',
				],
				'style_transfer' => false
			]
		);
		$element->add_control(
			'tx_cl_action_apply_if',
			[
				'label'          => esc_html__( 'Action Applicable if', 'avas-core' ),
				'type'           => Controls_Manager::SELECT,
				'options'        => [
					'all'  => esc_html__( 'True All Logic', 'avas-core' ),
					'any'  => esc_html__( 'True Any Logic', 'avas-core' ),
				],
				'default'        => 'all',
				'toggle'         => false,
				'condition'      => [
					'tx_cl_enable'             => 'yes',
					'tx_cl_visibility_action!' => 'forcefully_hide',
				],
				'style_transfer' => false
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'logic_type',
			[
				'label'   => esc_html__( 'Type', 'avas-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'login_status',
				'options' => [
					'login_status' => esc_html__( 'User Status', 'avas-core' ),
					'post_type'    => esc_html__( 'Post Type', 'avas-core' ),
					'frontpage'      => esc_html__( 'Front Page', 'avas-core' ),
					'browser'      => esc_html__( 'Browser', 'avas-core' ),
					'date_time'    => esc_html__( 'Date & Time', 'avas-core' ),
					'recurring_day' => esc_html__( 'Recurring Day', 'avas-core' ),
					'dynamic'      => esc_html__( 'Dynamic Field', 'avas-core' ),
					'query_string' => esc_html__( 'Query String', 'avas-core' ),
				],
			]
		);

		$repeater->add_control(
			'dynamic_field',
			[
				'label'       => esc_html__( 'Dynamic Field', 'avas-core' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => '',
				'dynamic'     => [
					'active' => true,
				],
				'condition'   => [
					'logic_type' => 'dynamic'
				],
				'ai' => [
					'active' => false,
				],
			]
		);

		if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
			$repeater->add_control(
				'logic_operator_dynamic',
				[
					'label'      => esc_html__( 'Logic Operator', 'avas-core' ),
					'show_label' => false,
					'type'       => Controls_Manager::SELECT,
					'options'    => [
						'between'      => esc_html__( 'Include', 'avas-core' ),
						'not_between' => esc_html__( 'Exclude', 'avas-core' ),
					],
					'default'    => 'between',
					'toggle'     => false,
					'condition'  => [
						'logic_type' => 'dynamic',
					]
				]
			);
		}

		$repeater->add_control(
			'login_status_operand',
			[
				'label'     => esc_html__( 'Login Status', 'avas-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'logged_in'   =>  esc_html__( 'Logged In', 'avas-core' ),
					'not_logged_in' => esc_html__( 'Not Logged In', 'avas-core' ),
				],
				'default'   => 'logged_in',
				'toggle'    => false,
				'condition' => [
					'logic_type' => 'login_status',
				]
			]
		);

		$repeater->add_control(
			'user_and_role',
			[
				'label'     => esc_html__( 'Select User Type', 'avas-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'user_role' => esc_html__( 'User Role', 'avas-core' ),
					'user'     => esc_html__( 'User', 'avas-core' ),
				],
				'default'   => '',
				'condition' => [
					'logic_type'           => 'login_status',
					'login_status_operand' => 'logged_in',
				]
			]
		);

		$repeater->add_control(
			'logic_operator_between',
			[
				'label'      => esc_html__( 'Logic Operator', 'avas-core' ),
				'show_label' => false,
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					'between'    => esc_html__( 'Include', 'avas-core' ),
					'not_between'  => esc_html__( 'Exclude', 'avas-core' ),
				],
				'default'    => 'between',
				'toggle'     => false,
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'logic_type',
							'operator' => '===',
							'value'    => 'browser',
						],
						[
							'name'     => 'logic_type',
							'operator' => '===',
							'value'    => 'frontpage',
						],
						[
							'name'     => 'logic_type',
							'operator' => '===',
							'value'    => 'post_type',
						],
						[
							'name'     => 'logic_type',
							'operator' => '===',
							'value'    => 'query_string',
						],
						[
							'relation' => 'and',
							'terms'    => [
								[
									'name'     => 'logic_type',
									'operator' => '===',
									'value'    => 'login_status',
								],
								[
									'name'     => 'login_status_operand',
									'operator' => '===',
									'value'    => 'logged_in',
								],
								[
									'name'     => 'user_and_role',
									'operator' => '!==',
									'value'    => '',
								],
							],
						]
					],
				]
			]
		);

		if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
			$repeater->add_control(
				'dynamic_operand',
				[
					'label'       => esc_html__( 'Value', 'avas-core' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'default'     => '',
					'condition'   => [
						'logic_type' => 'dynamic'
					],
					'ai' => [
						'active' => false,
					],
				]
			);

			$repeater->add_control(
				'tx_cl_dynamic_notice',
				[
					'raw'             => esc_html__( 'Separate multiple value with the | (pipe) character. (e.g. <strong>value 1 | value 2</strong>)', 'avas-core' ),
					'type'            => Controls_Manager::RAW_HTML,
					'content_classes' => 'elementor-descriptor',
					'condition'       => [
						'logic_type' => 'dynamic',
					]
				]
			);
		}

		$roles = $this->get_editable_roles();

		$repeater->add_control(
			'user_role_operand_multi',
			[
				'label'       => esc_html__( 'Select User Roles', 'avas-core' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => $roles,
				'default'     => [],
				'condition'   => [
					'logic_type'           => 'login_status',
					'login_status_operand' => 'logged_in',
					'user_and_role'        => 'user_role'
				]
			]
		);

		$repeater->add_control(
			'user_operand',
			[
				'label'       => esc_html__( 'Select Users', 'avas-core' ),
				'type'        => 'tx-select2',
				'source_name' => 'user',
				'source_type' => 'all',
				'label_block' => true,
				'multiple'    => true,
				'condition'   => [
					'logic_type'           => 'login_status',
					'login_status_operand' => 'logged_in',
					'user_and_role'        => 'user'
				]
			]
		);

		$_post_types = TX_Helper::tx_get_post_types();
		$post_types  = array_merge( [ '' => 'All' ], $_post_types );

		$repeater->add_control(
			'post_type_operand',
			[
				'label'       => esc_html__( 'Select Post Types', 'avas-core' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => $post_types,
				'default'     => key( $post_types ),
				'condition'   => [
					'logic_type' => 'post_type',
				]
			]
		);

		$repeater->add_control(
			'post_operand',
			[
				'label'       => esc_html__( 'Select Any Post', 'avas-core' ),
				'type'        => 'tx-select2',
				'source_name' => 'post_type',
				'source_type' => 'any',
				'label_block' => true,
				'multiple'    => true,
				'condition'   => [
					'logic_type'        => 'post_type',
					'post_type_operand' => ''
				]
			]
		);

		foreach ( $_post_types as $post_type_slug => $post_type_name ) {
			$repeater->add_control(
				"post_operand_{$post_type_slug}",
				[
					'label'       => esc_html__( 'Select ', 'avas-core' ) . $post_type_name,
					'type'        => 'tx-select2',
					'source_name' => 'post_type',
					'source_type' => $post_type_slug,
					'label_block' => true,
					'multiple'    => true,
					'condition'   => [
						'logic_type'        => 'post_type',
						'post_type_operand' => $post_type_slug
					]
				]
			);
		}

		$repeater->add_control(
			'frontpage_operand',
			[
				'label'       => esc_html__( 'Select Front Page', 'avas-core' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'home' => esc_html__( 'Home Page', 'avas-core' ),
				],
				'default'     => 'home',
				'condition'   => [
					'logic_type' => 'frontpage',
				]
			]
		);

		$repeater->add_control(
			'browser_operand',
			[
				'label'       => esc_html__( 'Select Browser', 'avas-core' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => $this->get_browser_list(),
				'default'     => key( $this->get_browser_list() ),
				'condition'   => [
					'logic_type' => 'browser',
				]
			]
		);

		$repeater->add_control(
			'date_time_logic',
			[
				'label'      => esc_html__( 'Date and time', 'avas-core' ),
				'show_label' => false,
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					'equal'      => esc_html__( 'Is', 'avas-core' ),
					'not_equal'  => esc_html__( 'Is Not', 'avas-core' ),
					'between'   => esc_html__( 'Between', 'avas-core' ),
					'not_between' => esc_html__( 'Not Between', 'avas-core' ),
				],
				'default'    => 'equal',
				'toggle'     => false,
				'condition'  => [
					'logic_type' => 'date_time',
				]
			]
		);

		$repeater->add_control(
			'single_date',
			[
				'label'          => esc_html__( 'Date', 'avas-core' ),
				'label_block'    => false,
				'type'           => Controls_Manager::DATE_TIME,
				'picker_options' => [
					'enableTime' => false,
					'altInput'   => true,
					'altFormat'  => 'M j, Y',
					'dateFormat' => 'Y-m-d'
				],
				'conditions'     => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'logic_type',
							'operator' => '===',
							'value'    => 'date_time',
						],
						[
							'name'     => 'date_time_logic',
							'operator' => '!==',
							'value'    => 'between',
						],
						[
							'name'     => 'date_time_logic',
							'operator' => '!==',
							'value'    => 'not_between',
						],
					],
				]
			]
		);

		$repeater->add_control(
			'from_date',
			[
				'label'          => esc_html__( 'From', 'avas-core' ),
				'label_block'    => false,
				'type'           => Controls_Manager::DATE_TIME,
				'picker_options' => [
					'altInput'   => true,
					'altFormat'  => 'M j, Y h:i K',
					'dateFormat' => 'Y-m-d H:i:S'
				],
				'conditions'     => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'logic_type',
							'operator' => '===',
							'value'    => 'date_time',
						],
						[
							'name'     => 'date_time_logic',
							'operator' => '!==',
							'value'    => 'equal',
						],
						[
							'name'     => 'date_time_logic',
							'operator' => '!==',
							'value'    => 'not_equal',
						],
					],
				]
			]
		);

		$repeater->add_control(
			'to_date',
			[
				'label'          => esc_html__( 'To', 'avas-core' ),
				'label_block'    => false,
				'type'           => Controls_Manager::DATE_TIME,
				'picker_options' => [
					'altInput'   => true,
					'altFormat'  => 'M j, Y h:i K',
					'dateFormat' => 'Y-m-d H:i:S'
				],
				'conditions'     => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'logic_type',
							'operator' => '===',
							'value'    => 'date_time',
						],
						[
							'name'     => 'date_time_logic',
							'operator' => '!==',
							'value'    => 'equal',
						],
						[
							'name'     => 'date_time_logic',
							'operator' => '!==',
							'value'    => 'not_equal',
						],
					],
				]
			]
		);

		$repeater->add_control(
			'recurring_day_logic',
			[
				'label'      => esc_html__( 'Recurring Day', 'avas-core' ),
				'show_label' => false,
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					'between'     => esc_html__( 'Between', 'avas-core' ),
					'not_between' => esc_html__( 'Not Between', 'avas-core' ),
				],
				'default'    => 'between',
				'toggle'     => false,
				'condition'  => [
					'logic_type' => 'recurring_day',
				]
			]
		);

        $repeater->add_control(
            'recurring_days_all',
            [
                'label'          => esc_html__( 'All Days', 'avas-core' ),
                'type'           => Controls_Manager::SWITCHER,
                'default'        => '',
                'label_on'       => esc_html__( 'Yes', 'avas-core' ),
                'label_off'      => esc_html__( 'No', 'avas-core' ),
                'return_value'   => 'yes',
                'condition'   => [
                    'logic_type' => 'recurring_day',
                ]
            ]
        );

		$repeater->add_control(
			'recurring_days',
			[
				'label'       => esc_html__( 'Recurring Days', 'avas-core' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => $this->get_days_list(),
				'default'     => [ key( $this->get_days_list() ) ],
				'condition'   => [
					'logic_type' => 'recurring_day',
                    'recurring_days_all!' => 'yes'
				]
			]
		);

		$repeater->add_control(
			'recurring_days_heading',
			[
				'label'     => esc_html__( 'Date Duration', 'avas-core' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'logic_type' => 'recurring_day',
				]
			]
		);

		$repeater->add_control(
			'recurring_days_duration_from',
			[
				'label'          => esc_html__( 'From', 'avas-core' ),
				'label_block'    => false,
				'type'           => Controls_Manager::DATE_TIME,
				'picker_options' => [
					'altInput'   => true,
					'altFormat'  => 'M j, Y',
					'dateFormat' => 'Y-m-d',
					'enableTime' => false,
				],
				'conditions'     => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'logic_type',
							'operator' => '===',
							'value'    => 'recurring_day',
						],
					],
				]
			]
		);

		$repeater->add_control(
			'recurring_days_duration_to',
			[
				'label'          => esc_html__( 'To', 'avas-core' ),
				'label_block'    => false,
				'type'           => Controls_Manager::DATE_TIME,
				'picker_options' => [
					'altInput'   => true,
					'altFormat'  => 'M j, Y',
					'dateFormat' => 'Y-m-d',
					'enableTime' => false,
				],
				'conditions'     => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'logic_type',
							'operator' => '===',
							'value'    => 'recurring_day',
						],
					],
				]
			]
		);

		$repeater->add_control(
			'recurring_days_heading2',
			[
				'label'     => esc_html__( 'Time Duration', 'avas-core' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'logic_type' => 'recurring_day',
				]
			]
		);

		$repeater->add_control(
			'from_time',
			[
				'label'       => esc_html__( 'From', 'avas-core' ),
				'label_block' => false,
                'type'           => Controls_Manager::DATE_TIME,
                'picker_options' => [
                    'altInput'   => true,
                    'altFormat'  => 'h:i K',
                    'enableTime' => true,
                    'noCalendar' => true,
                ],
				'conditions'  => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'logic_type',
							'operator' => '===',
							'value'    => 'recurring_day',
						],
					],
				]
			]
		);

		$repeater->add_control(
			'to_time',
			[
				'label'       => esc_html__( 'To', 'avas-core' ),
				'label_block' => false,
                'type'           => Controls_Manager::DATE_TIME,
                'picker_options' => [
                    'altInput'   => true,
                    'altFormat'  => 'h:i K',
                    'enableTime' => true,
                    'noCalendar' => true,
                ],
				'conditions'  => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'logic_type',
							'operator' => '===',
							'value'    => 'recurring_day',
						],
					],
				]
			]
		);

		$repeater->add_control(
			'query_key',
			[
				'label'       => esc_html__( 'Key', 'avas-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Query Key', 'avas-core' ),
				'condition'   => [
					'logic_type' => 'query_string',
				]
			]
		);

		$repeater->add_control(
			'query_value',
			[
				'label'       => esc_html__( 'Value', 'avas-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Query Value', 'avas-core' ),
				'condition'   => [
					'logic_type' => 'query_string',
				]
			]
		);

		$element->add_control(
			'tx_cl_logics',
			[
				'label'          => esc_html__( 'Logics', 'avas-core' ),
				'type'           => Controls_Manager::REPEATER,
				'fields'         => $repeater->get_controls(),
				'default'        => [
					[
						'logic_type'           => 'login_status',
						'login_status_operand' => 'logged_in',
					],
				],
				'style_transfer' => false,
				// 'title_field'    => '{{{ logic_type }}}',
				'title_field' => '<# print(logic_type.replace(/_/i, " ").split(" ").map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(" ")) #>',
				'condition'      => [
					'tx_cl_enable'             => 'yes',
					'tx_cl_visibility_action!' => 'forcefully_hide',
				]
			]
		);

		$element->end_controls_section();
	}

	/**
	 * Get All editable roles and return array with simple slug|name pare
	 *
	 * @param $first_index
	 * @param $output
	 *
	 * @return array|string
	 */
	public function get_editable_roles() {
		$wp_roles       = [ '' => esc_html__( 'Select', 'avas-core' ) ];
		$all_roles      = wp_roles()->roles;
		$editable_roles = apply_filters( 'editable_roles', $all_roles );

		foreach ( $editable_roles as $slug => $editable_role ) {
			$wp_roles[ $slug ] = $editable_role['name'];
		}

		return $wp_roles;
	}

	/**
	 * Get all browser list and return array with simple slug|name pare
	 *
	 * @return array
	 */
	public function get_browser_list() {
		return [
			'chrome'    => esc_html__( 'Google Chrome', 'avas-core' ),
			'firefox'   => esc_html__( 'Mozilla Firefox', 'avas-core' ),
			'safari'    => esc_html__( 'Safari', 'avas-core' ),
			'i_safari'  => esc_html__( 'Iphone Safari', 'avas-core' ),
			'opera'     => esc_html__( 'Opera', 'avas-core' ),
			'edge'      => esc_html__( 'Edge', 'avas-core' ),
			'ie'        => esc_html__( 'Internet Explorer', 'avas-core' ),
			'mac_ie'    => esc_html__( 'Internet Explorer for Mac OS X', 'avas-core' ),
			'netscape4' => esc_html__( 'Netscape 4', 'avas-core' ),
			'lynx'      => esc_html__( 'Lynx', 'avas-core' ),
			'others'    => esc_html__( 'Others', 'avas-core' ),
		];
	}


	/**
	 * Get all days list of a week and return array with simple slug|name pare
	 *
	 * @return array
	 */
	public function get_days_list() {
		return [
			'sun' => esc_html__( 'Sunday', 'avas-core' ),
			'mon' => esc_html__( 'Monday', 'avas-core' ),
			'tue' => esc_html__( 'Tuesday', 'avas-core' ),
			'wed' => esc_html__( 'Wednesday', 'avas-core' ),
			'thu' => esc_html__( 'Thursday', 'avas-core' ),
			'fri' => esc_html__( 'Friday', 'avas-core' ),
			'sat' => esc_html__( 'Saturday', 'avas-core' )
		];
	}

	/**
	 * Get current browser
	 *
	 * @return string
	 */
	public function get_current_browser() {
		global $is_lynx, $is_gecko, $is_winIE, $is_macIE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone, $is_edge;

		$browser = 'others';

		switch ( true ) {
			case $is_chrome:
				$browser = 'chrome';
				break;
			case $is_gecko:
				$browser = 'firefox';
				break;
			case $is_safari:
				$browser = 'safari';
				break;
			case $is_iphone:
				$browser = 'i_safari';
				break;
			case $is_opera:
				$browser = 'opera';
				break;
			case $is_edge:
				$browser = 'edge';
				break;
			case $is_winIE:
				$browser = 'ie';
				break;
			case $is_macIE:
				$browser = 'mac_ie';
				break;
			case $is_NS4:
				$browser = 'netscape4';
				break;
			case $is_lynx:
				$browser = 'lynx';
				break;

		}

		return $browser;
	}

	public function parse_arg( $arg ) {
		$arg = wp_parse_args( $arg, [
			'tx_cl_enable'            => '',
			'tx_cl_visibility_action' => '',
			'tx_cl_logics'            => [],
			'tx_cl_action_apply_if'   => '',
		] );

		return $arg;
	}

	/**
	 * Check all logics and return the final result
	 *
	 * @param $settings
	 *
	 * @return bool
	 */
	public function check_logics( $settings ) {
		$return                = false;
		$needed_any_logic_true = 'any' === $settings['tx_cl_action_apply_if'];
		$needed_all_logic_true = 'all' === $settings['tx_cl_action_apply_if'];

		foreach ( $settings['tx_cl_logics'] as $cl_logic ) {
			switch ( $cl_logic['logic_type'] ) {
				case 'login_status':
					$return = 'logged_in' === $cl_logic['login_status_operand'] ? is_user_logged_in() : ! is_user_logged_in();

					if ( is_user_logged_in() && $cl_logic['user_and_role'] !== '' ) {
						if ( 'user_role' === $cl_logic['user_and_role'] ) {
							$user_roles = get_userdata( get_current_user_id() )->roles;
							$operand    = $cl_logic['user_role_operand_multi'];
							$result     = array_intersect( $user_roles, $operand );
							$return     = ( 'between' === $cl_logic['logic_operator_between'] ) ? count( $result ) > 0 : count( $result ) == 0;
						} elseif ( 'user' === $cl_logic['user_and_role'] ) {
							$user    = get_current_user_id();
							$operand = array_map( 'intval', (array) $cl_logic['user_operand'] );
							$return  = 'between' === $cl_logic['logic_operator_between'] ? in_array( $user, $operand ) : ! in_array( $user, $operand );
						}
					}

					if ( $needed_any_logic_true && $return ) {
						break( 2 );
					}

					if ( $needed_all_logic_true && ! $return ) {
						break( 2 );
					}

					break;
				case 'post_type':
					$ID                = get_the_ID();
					$post_type_operand = $cl_logic['post_type_operand'];
					$operand           = empty( $post_type_operand ) ? (array) $cl_logic['post_operand'] : (array) $cl_logic["post_operand_{$post_type_operand}"];

					if ( count( $operand ) ) {
						$return = 'between' === $cl_logic['logic_operator_between'] ? in_array( $ID, $operand ) : ! in_array( $ID, $operand );
					} else {
						$post_type = get_post_type( $ID );
						$return    = 'between' === $cl_logic['logic_operator_between'] ? $post_type === $post_type_operand : $post_type !== $post_type_operand;
					}

					if ( $needed_any_logic_true && $return ) {
						break( 2 );
					}

					if ( $needed_all_logic_true && ! $return ) {
						break( 2 );
					}

					break;

				case 'frontpage':
					$return = 'home' === $cl_logic['frontpage_operand'] ? is_front_page() : ! is_front_page();
					break;

				case 'browser':
					$browser = $this->get_current_browser();
					$operand = (array) $cl_logic['browser_operand'];
					$return  = 'between' === $cl_logic['logic_operator_between'] ? in_array( $browser, $operand ) : ! in_array( $browser, $operand );

					if ( $needed_any_logic_true && $return ) {
						break( 2 );
					}

					if ( $needed_all_logic_true && ! $return ) {
						break( 2 );
					}

					break;
				case 'date_time':
					$current_time = current_time( 'U' );
					$from         = ( 'equal' === $cl_logic['date_time_logic'] || 'not_equal' === $cl_logic['date_time_logic'] ) ? strtotime( "{$cl_logic['single_date']} 00:00:00" ) : strtotime( $cl_logic['from_date'] );
					$to           = ( 'equal' === $cl_logic['date_time_logic'] || 'not_equal' === $cl_logic['date_time_logic'] ) ? strtotime( "{$cl_logic['single_date']} 23:59:59" ) : strtotime( $cl_logic['to_date'] );
					$return       = 'equal' === $cl_logic['date_time_logic'] || 'between' === $cl_logic['date_time_logic'] ? $from <= $current_time && $current_time <= $to : $from >= $current_time || $current_time >= $to;

					if ( $needed_any_logic_true && $return ) {
						break( 2 );
					}

					if ( $needed_all_logic_true && ! $return ) {
						break( 2 );
					}

					break;
				case 'recurring_day':
					$current_time = current_time( 'U' );
					$from_date    = isset( $cl_logic['recurring_days_duration_from'] ) && $cl_logic['recurring_days_duration_from'] ? strtotime( "{$cl_logic['recurring_days_duration_from']} 00:00:00" ) : $current_time - WEEK_IN_SECONDS;
					$to_date      = isset( $cl_logic['recurring_days_duration_to'] ) && $cl_logic['recurring_days_duration_to'] ? strtotime( "{$cl_logic['recurring_days_duration_to']} 23:59:59" ) : $current_time + WEEK_IN_SECONDS;
					$is_today     = isset( $cl_logic['recurring_days_all'] ) && 'yes' === $cl_logic['recurring_days_all'] || in_array(strtolower(date('D')), $cl_logic['recurring_days']);
					$from_time    = isset( $cl_logic['from_time'] ) ? strtotime( $cl_logic['from_time'] ) : strtotime( '00:00:00' );
					$to_time      = isset( $cl_logic['to_time'] ) ? strtotime( $cl_logic['to_time'] ) : strtotime( '23:59:59' );

					$return = $is_today && $from_date < $current_time && $to_date > $current_time && $from_time < $current_time && $to_time > $current_time;
					$return = 'between' === $cl_logic['recurring_day_logic'] ? $return : ! $return;

					if ( $needed_any_logic_true && $return ) {
						break( 2 );
					}

					if ( $needed_all_logic_true && ! $return ) {
						break( 2 );
					}

					break;
				case 'dynamic':
					if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
						$dynamic_field = trim( $cl_logic['dynamic_field'] );
						$value         = explode( '|', $cl_logic['dynamic_operand'] );
						$value         = array_map( 'trim', $value );
						$return        = 'between' === $cl_logic['logic_operator_dynamic'] ? in_array( $dynamic_field, $value ) : ! in_array( $dynamic_field, $value );

						if ( $needed_any_logic_true && $return ) {
							break( 2 );
						}

						if ( $needed_all_logic_true && ! $return ) {
							break( 2 );
						}
					}

					break;
				case 'query_string':

					$return = $cl_logic['query_key'] && isset( $_GET[ $cl_logic['query_key'] ] ) && $cl_logic['query_value'] === sanitize_text_field( $_GET[ $cl_logic['query_key'] ] );
					$return = 'between' === $cl_logic['logic_operator_between'] ? $return : ! $return;

					if ( $needed_any_logic_true && $return ) {
						break( 2 );
					}

					if ( $needed_all_logic_true && ! $return ) {
						break( 2 );
					}

					break;
			}
		}

		return $return;
	}

	public function content_render( $should_render, Element_Base $element ) {
		$settings = $element->get_settings_for_display();
		$settings = $this->parse_arg( $settings );
		
		if ( 'yes' === $settings['tx_cl_enable']  ) {
			switch ( $settings['tx_cl_visibility_action'] ) {
				case 'show':
					return $this->check_logics( $settings ) ? true : false;
					break;
				case 'hide':
					return $this->check_logics( $settings ) ? false : true;
					break;
				case 'forcefully_hide':
					return false;
			}
		}

		return $should_render;
	}

}
