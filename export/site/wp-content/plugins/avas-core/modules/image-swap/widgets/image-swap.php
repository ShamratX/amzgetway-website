<?php
namespace AvasElements\Modules\ImageSwap\Widgets;

use elementor\Widget_Base;
use elementor\Controls_Manager;
use elementor\Group_Control_Border;
use elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class ImageSwap extends Widget_Base {

	public function get_name() {
		return 'avas-image-swap';
	}

	public function get_title() {
		return esc_html__( 'Avas Image Swap', 'avas-core' );
	}

	public function get_icon() {
		return 'eicon-image-rollover';
	}

	public function get_categories() {
		return [ 'avas-elements' ];
	}

	public function get_keywords() {
		return [ 'image', 'swap', 'exchange', 'switch', 'shifting' ];
	}

	public function get_style_depends() {
		return [ 'tx-image-swap'];
	}

	public function get_script_depends() {
        return [ 'tx-image-swap' ];
    }

	protected function register_controls() {

		$this->start_controls_section(
			'_section_content',
			[
				'label' => esc_html__('Content', 'avas-core'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'select_effect_type',
			[
				'label'   => esc_html__('Select Effect type', 'avas-core'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__('Default', 'avas-core'),
					'slide'   => esc_html__('Slide', 'avas-core'),
				],
			]
		);

		$this->add_control(
			'first_image',
			[
				'type'    => Controls_Manager::MEDIA,
				'label'   => esc_html__('First Image', 'avas-core'),
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'second_image',
			[
				'type'    => Controls_Manager::MEDIA,
				'label'   => esc_html__('Second Image', 'avas-core'),
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'swip_trigger',
			[
				'type'    => Controls_Manager::CHOOSE,
				'label'   => esc_html__('Trigger', 'avas-core'),
				'options' => [
					'hover' => [
						'title' => esc_html__('Hover', 'avas-core'),
						'icon'  => 'eicon-drag-n-drop',
					],
					'click' => [
						'title' => esc_html__('Click', 'avas-core'),
						'icon'  => 'eicon-click',
					],
				],
				'default' => 'hover',
				'condition' => [
					'select_effect_type' => 'default',
				],
			]
		);

		$this->add_control(
			'ig_effects',
			[
				'type'      => Controls_Manager::SELECT,
				'label'     => esc_html__('Effect', 'avas-core'),
				'options'   => [
					'fade'        => esc_html__('Fade', 'avas-core'),
					'move_left'   => esc_html__('Move Left', 'avas-core'),
					'move_top'    => esc_html__('Move Top', 'avas-core'),
					'move_right'  => esc_html__('Move Right', 'avas-core'),
					'move_bottom' => esc_html__('Move Bottom', 'avas-core'),
					'zoom_in'     => esc_html__('Zoom In', 'avas-core'),
					'zoom_out'    => esc_html__('Zoom Out', 'avas-core'),
					'card_left'   => esc_html__('Card Left', 'avas-core'),
					'card_top'    => esc_html__('Card Top', 'avas-core'),
					'card_right'  => esc_html__('Card Right', 'avas-core'),
					'card_bottom' => esc_html__('Card Bottom', 'avas-core'),
				],
				'default'   => 'fade',
				'condition' => [
					'select_effect_type' => 'default',
				],
			]
		);

		$this->add_control(
			'ig_effects_slides',
			[
				'type'      => Controls_Manager::SELECT,
				'label'     => esc_html__('Effect', 'avas-core'),
				'options'   => [
					'top'  => esc_html__('Slide Top', 'avas-core'),
					'bottom'  => esc_html__('Slide Bottom', 'avas-core'),
					'right' => esc_html__('Slide Right', 'avas-core'),
					'left'  => esc_html__('Slide Left', 'avas-core'),
				],
				'default'   => 'right',
				'condition' => [
					'select_effect_type' => 'slide',
				],
			]
		);

		$this->add_control(
			'speed',
			[
				'type'        => Controls_Manager::NUMBER,
				'label'       => esc_html__('Transition Speed', 'avas-core'),
				'description' => esc_html__('Note: Here animation speed is in seconds. Default is 0.5s', 'avas-core'),
				'min'         => 0,
				'max'         => 10,
				'step'        => 0.1,
				'default'     => 0.5,
				'after'       => 's',
				'selectors'   => [
					'{{WRAPPER}} .tx-image-swap-wrapper__inside img' => '-webkit-transition: {{VALUE}}s;',
					'{{WRAPPER}} .tx-image-swap-wrapper__inside img' => 'transition: {{VALUE}}s;',
					'{{WRAPPER}} .tx-image-swap-wrapper'             => '--animation_speed: {{VALUE}}s;',
					'{{WRAPPER}}'                                    => '--animation_speed: {{VALUE}}s;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__('Image', 'avas-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'image_border',
				'selector' => '{{WRAPPER}} .tx-image-swap-wrapper img, {{WRAPPER}} .tx-image-swap-ctn img',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => esc_html__('Border Radius', 'avas-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .tx-image-swap-wrapper img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .tx-image-swap-ctn img'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ($settings['select_effect_type'] == 'slide') {

			$this->slide_images($settings);
		} else {
			$this->default_swap($settings);
		}

	}

	protected function slide_images($settings) {

		$this->add_render_attribute(
			'wrapper',
			[
				'class'        => ['tx-image-swap-ctn', 'slide_' . $settings['ig_effects_slides']],
				'data-trigger' => 'click',
				'data-layout'  => $settings['ig_effects_slides'],
			]
		);
		?>
		<div class="tx_img_main_wrapper_top">
			<div <?php $this->print_render_attribute_string('wrapper');?>>
				<div class="tx-image-swap-fakeone">
					<img src="<?php echo esc_url($settings['first_image']['url']); ?>" />
				</div>
				<div class="tx-image-swap-insider">
					<div class="tx-image-swap-item">
						<img src="<?php echo esc_url($settings['first_image']['url']); ?>" />
					</div>
					<div class="tx-image-swap-item">
						<img src="<?php echo esc_url($settings['second_image']['url']); ?>" />
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	protected function default_swap($settings) {
		$this->add_render_attribute(
			'wrapper',
			[
				'class'        => ['tx-image-swap-wrapper', $settings['ig_effects']],
				'data-trigger' => $settings['swip_trigger'],
				'id'           => 'tx-image-swap-wrapper_id',
			]
		);
		if ('click' == $settings['swip_trigger']) {
			$this->add_render_attribute(
				'wrapper',
				[
					'data-click' => 'inactive',
				]
			);
		}
		$this->add_render_attribute(
			'inside',
			[
				'class' => ['tx-image-swap-wrapper__inside'],
			]
		);
		?>

		<div <?php $this->print_render_attribute_string('wrapper');?>>

			<?php printf('<img class="fake_img" src="%s">', esc_url($settings['first_image']['url']));?>

			<div <?php $this->print_render_attribute_string('inside');?>>
				<?php printf('<img class="img_swap_first" src="%s">', esc_url($settings['first_image']['url']));?>
				<?php printf('<img class="img_swap_second" src="%s">', esc_url($settings['second_image']['url']));?>
			</div>
		</div>
		<?php
	}	

} // class
