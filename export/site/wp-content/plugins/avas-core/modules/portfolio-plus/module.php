<?php
namespace AvasElements\Modules\PortfolioPlus;

use AvasElements\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'avas-portfolio-plus';
	}

	public function get_widgets() {
		$widgets = [
			'PortfolioPlus',
		];

		return $widgets;
	}
}
