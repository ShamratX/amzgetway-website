!(function($){
	'use strict';

	/* Counter Widget
	------------------------------------- */
	var widgetCounter = function( $scope, $ ) {
	var counter = $scope.find('.tx-counter-number-wrapper').eq(0);
				
		if ( !counter.length ) {
			return;
		}

	var a = 0;
	$(window).scroll(function () {
		var counterItem = $scope.find( '.tx-counter-number' ),
 			oTop = counterItem.offset().top - window.innerHeight,
			 settings = counterItem.data("settings"),
			 duration = settings["duration"];

		if ( a == 0 && $(window).scrollTop() > oTop) {			

			counterItem.each(function () {
			   var size = $(this).text().split(".")[1] ? $(this).text().split(".")[1].length : 0;
			   $(this).prop('Counter', 0).animate({
			      Counter: $(this).text()
			   }, {
			      duration: duration,
			      // delay: delay,
			      step: function (func) {
			         $(this).text(parseFloat(func).toFixed(size));
			      }
			   });
			});

			a = 1;
		}

	});

	};

	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avas-counter.default', widgetCounter ); // Counter
 		
 	} );


})( jQuery );


/* ---------------------------------------------------------
   EOF
------------------------------------------------------------ */