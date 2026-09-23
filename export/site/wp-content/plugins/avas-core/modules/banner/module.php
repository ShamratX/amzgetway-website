<?php
namespace AvasElements\Modules\Banner;

use AvasElements\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'avas-banner';
	}

	public function get_widgets() {
		$widgets = [
			'Banner',
		];

		return $widgets;
	}
}
