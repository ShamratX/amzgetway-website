<?php
namespace AvasElements\Modules\WPForms;

use AvasElements\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'avas-wpforms';
	}

	public function get_widgets() {
		$widgets = [
			'WPForms',
		];

		return $widgets;
	}
}
