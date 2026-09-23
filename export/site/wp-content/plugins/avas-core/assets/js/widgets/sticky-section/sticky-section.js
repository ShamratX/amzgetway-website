!( function( $, elementor ) {

	'use strict';

	var widgetSectionSticky = function( $scope, $ ) {

        var offset = $('.tx-sticky-sec').offset().top;

        // $(window).scroll(function(){
        //   var sticky = $('.tx-sticky-sec'),
        //       scroll = $(window).scrollTop();
            
        //   if (scroll >= offset) {
        //    sticky.addClass('tx-sticky-sec-active');
        //   } else {
        //    sticky.removeClass('tx-sticky-sec-active');
        //   }

        // });

        $(window).scroll(function() {
        if ($(this).scrollTop() > 1){  
            $('.tx-sticky-sec').addClass("tx-sticky-sec-active");
          }
          else{
            $('.tx-sticky-sec').removeClass("tx-sticky-sec-active");
          }
        });

	};

	$(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/global', widgetSectionSticky );
	});

}( jQuery, window.elementorFrontend ) );