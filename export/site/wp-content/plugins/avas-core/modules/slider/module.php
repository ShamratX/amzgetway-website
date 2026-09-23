<?php
namespace AvasElements\Modules\Slider;

use AvasElements\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'avas-slider';
	}

	public function get_widgets() {
		$widgets = [
			'Slider',
		];

		return $widgets;
	}
}
