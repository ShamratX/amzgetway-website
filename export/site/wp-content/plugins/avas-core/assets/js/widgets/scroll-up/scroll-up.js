!( function( $, elementor ) {

	'use strict';

	var widgetScrollUp = function( $scope, $ ) {
	    
		var $scrollUp = $scope.find('.tx-scroll-up-btn'),
		$settings     =  $scrollUp.data('settings');

	    if ( ! $scrollUp.length ) {
	    	return;
	    }

		$(window).scroll(function() {
			if ($(window).scrollTop() > 300) {
			    $scrollUp.addClass("tx-scroll-up");
			} else {
				$scrollUp.removeClass("tx-scroll-up");
			}
		});

	    $($scrollUp).on('click', function(event){
	    	event.preventDefault();
	    	$('html,body').animate({
                    scrollTop: 0
                }, 400);
                return false;

	    });

	};

	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avas-scroll-up.default', widgetScrollUp );
	});

}( jQuery, window.elementorFrontend ) );
