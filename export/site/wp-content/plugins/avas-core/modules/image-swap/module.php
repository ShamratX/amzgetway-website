<?php
namespace AvasElements\Modules\ImageSwap;

use AvasElements\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'avas-image-swap';
	}

	public function get_widgets() {
		$widgets = [
			'ImageSwap',
		];

		return $widgets;
	}
}
