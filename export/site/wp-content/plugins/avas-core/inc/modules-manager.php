<?php
namespace AvasElements;

final class ModuleManager {
	/**
	 * @var Module_Base[]
	 */
	private $modules = [];

	public function __construct() {
		$modules = [
			'animated-heading',
			'animated-shape',
			'background-clip-text',
			'background-slider',
			'banner',
			'breadcrumbs',
			'button',
			'call-to-action',
			'carousel',
			'cart',
			'chart',
			'circle-info',
			'circle-progress-bar',
			'contact-form-seven',
			'countdown',
			'counter',
			'coupon',
			'courses',
			'courses-carousel',
			'display-conditions',
			'dual-button',
			'events-calendar',
			'features',
			'flip-box',
			'flipster',
			'gallery',
			'gravity-form',
			'grid',
			'heading',
			'hotspot',
			'icon-box',
			'image-animate',
			'image-box',
			'image-comparison',
			'image-hover',
			'image-magnifier',
			'image-mask',
			'image-scrolling',
			'image-slide',
			'image-swap',
			'instagram',
			'logo',
			'lottie',
			'mailchimp',
			'marquee',
			'menu',
			'news-ticker',
			'onepage-nav',
			'page-title',
			'particles',
			'popup',
			'portfolio',
			'portfolio-carousel',
			'portfolio-plus',
			'post-alter',
			'post-carousel',
			'post-grid',
			'post-list',
			'post-masonry-grid',
			'post-tiled',
			'price-menu',		
			'price-table',
			'profile',
			'profile-carousel',
			'progress-bar',
			'scroll-up',
			'search',
			'services',
			'services-carousel',
			'side-menu',
			'slider',
			'source-code',
			'sprite-spin',
			'sticky-section',
			'table',
			'team',
			'team-alter',
			'team-carousel',
			'template-shortcode',
			'testimonial',
			'timeline',
			'wishlist',
			'woocommerce-carousel',
			'woocommerce-grid',
			'wpforms',
			'wrapper-link'
		];

		foreach ( $modules as $module_name ) {
			$class_name = str_replace( '-', ' ', $module_name );
			$class_name = str_replace( ' ', '', ucwords( $class_name ) );
			$class_name = __NAMESPACE__ . '\\Modules\\' . $class_name . '\Module';

			
			if ( $class_name::is_active() ) {
				$this->modules[ $module_name ] = $class_name::instance();
			}
		}
	}

	/**
	 * @param string $module_name
	 *
	 * @return Module_Base|Module_Base[]
	 */
	public function get_modules( $module_name ) {
		if ( $module_name ) {
			if ( isset( $this->modules[ $module_name ] ) ) {
				return $this->modules[ $module_name ];
			}

			return null;
		}

		return $this->modules;
	}
}

