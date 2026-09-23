/* Progress Bar
------------------------------------- */
!(function($){
	'use strict';
	var widgetProgressBar = function( $scope, $ ) {
	var progressBar = $scope.find('.tx-progress-bar-wrapper');
				
		if ( !progressBar.length ) {
			return;
		}

		
     new WOW().init();
    

		// const	wow = new WOW();
		// 	wow.init();

	// const	wow = new WOW(  
   //                    {  
   //                    boxClass:     'wow',                        // default  
   //                    animateClass: 'animated',         // default  
   //                    offset:       0,                                // default  
   //                    mobile:       true,                       // default  
   //                    live:         true                           // default  
   //                  }  
   //                  )  
   //                  wow.init(); 

    

	};


	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avas-progress-bar.default', widgetProgressBar ); // Progress bar
 	} );

})( jQuery );

/* ---------------------------------------------------------
   EOF
------------------------------------------------------------ */