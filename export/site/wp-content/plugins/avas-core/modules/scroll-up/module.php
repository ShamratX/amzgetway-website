<?php
namespace AvasElements\Modules\ScrollUp;

use AvasElements\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'avas-scroll-up';
	}

	public function get_widgets() {
		$widgets = [
			'ScrollUp',
		];

		return $widgets;
	}
}
