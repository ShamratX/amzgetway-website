<?php
namespace AvasElements\Modules\Grid;

use AvasElements\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'avas-grid';
	}

	public function get_widgets() {
		$widgets = [
			'Grid',
		];

		return $widgets;
	}
}
