var RevolutionSlider = function () {

    return {
        
        //Revolution Slider - Full Width
        initRSfullWidth: function () {
		    var revapi;
	        jQuery(document).ready(function() {
	            revapi = jQuery('.tp-banner').revolution(
	            {
	                delay:9000,
	                startwidth:1170,
	                startheight:570,
	                hideThumbs:10,
									navigationStyle:"preview4"
	            });
	        });
        },

        //Revolution Slider - Full Screen Offset Container
        initRSfullScreenOffset: function () {
		    var revapi;
	        jQuery(document).ready(function() {
	           revapi = jQuery('.tp-banner').revolution(
	            {
	                delay:15000,
	                startwidth:1170,
	                startheight:400,
	                hideThumbs:10,
	                fullWidth:"off",
	                fullScreen:"on",
	                hideCaptionAtLimit: "",
	                dottedOverlay:"twoxtwo",
	                navigationStyle:"preview4",
	                fullScreenOffsetContainer: ".header"
	            });
	        });
        },

		//Revolution Slider - Full Screen
		initRSfullScreen: function() {
		  var revapi;
		  jQuery(document).ready(function() {
			revapi = jQuery('.fullscreenbanner').revolution(
			  {
				delay: 15000,
				startwidth: 1170,
				startheight: 500,
				hideThumbs: 10,
				fullWidth: "on",
				fullScreen: "on",
				hideCaptionAtLimit: "",
				dottedOverlay: "onexone",
				navigationStyle: "preview4",
				spinner:"",
				forceFullWidth:"on"	// Force The FullWidth, 모바일크롬 출렁거림 방지.
			  });
		  });
		}


    };
}();        