<?php
namespace AvasElements\Modules\Wishlist;

use AvasElements\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'avas-wishlist';
	}

	public function get_widgets() {
		$widgets = [
			'Wishlist',
		];

		return $widgets;
	}
}
