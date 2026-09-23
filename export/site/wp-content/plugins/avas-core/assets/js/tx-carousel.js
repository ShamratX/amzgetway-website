/**
 * Carousel widget
 */

(function ($, elementor) {

	'use strict';

	var widgetCarousel = function ($scope, $) {

		var carouselWrapper = $scope.find('.tx-widget-carousel');

		if (!carouselWrapper.length) {
			return;
		}

		var carouselContainer = carouselWrapper.find('.swiper-carousel'),
			settings = carouselWrapper.data('settings');

		const Swiper = elementorFrontend.utils.swiper;
		initSwiper();
		async function initSwiper() {
			var swiper = await new Swiper(carouselContainer, settings); // this is an example
			if (settings.pauseOnHover) {
				$(carouselContainer).hover(function () {
					(this).swiper.autoplay.stop();
				}, function () {
					(this).swiper.autoplay.start();
				});
			}
		};
	};


	jQuery(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/avas-carousel.default', widgetCarousel);
	});

}(jQuery, window.elementorFrontend));
