jQuery(document).ready(function($){'use strict';

	
	// demo import text remove
	$(function() {
	    $(".wp-submenu li:contains('Import Demo Data')").remove();
	    $(".wp-submenu li:contains('Install Plugins')").remove();
	});

	// registration notice modal
	$("#tx_register_notice").dialog({
        modal: true,
        autoOpen: false,
        show: {effect: "blind", duration: 800}
    });   
    $("#tx_register_notice").dialog("open");


}); // End of jquery    

/* ---------------------------------------------------------
   EOF
------------------------------------------------------------ */