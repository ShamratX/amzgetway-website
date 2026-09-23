(function($){
	'use strict';

	/* Menu Widget
	------------------------------------- */
	var widgetMenu = function ($scope, $) {
		// $('.mobile-nav-toggle').on('click',function(){
		// 	$(this).find($(".bi")).toggleClass('bi-list bi-x');
		// });
		$('.mobile-nav-toggle').on('click', function($scope) {
                $('.tx-mobile-menu').toggleClass('tx-res-menu-toggle');
                $(this).find($(".bi")).toggleClass('bi-list bi-x');
                $('#top_head').toggleClass('d-none');
                $('.mobile-nav-toggle').toggleClass('tx-mob-sticky');
                $('#wpadminbar').toggleClass('position-fixed');
                $(this).find($(".bi")).toggleClass('bi-list bi-x');
            });
	};


	$( window ).on( 'elementor/frontend/init', function() {
 		elementorFrontend.hooks.addAction( 'frontend/element_ready/avas-menu.default', widgetMenu ); // Menu
 		
 	} );


})( jQuery );


/* ---------------------------------------------------------
   EOF
------------------------------------------------------------ */