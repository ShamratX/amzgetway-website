<?php
namespace AvasElements\Modules\Marquee;

use AvasElements\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'avas-marquee';
	}

	public function get_widgets() {
		$widgets = [
			'Marquee',
		];

		return $widgets;
	}
}
