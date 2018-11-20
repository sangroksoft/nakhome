var LayerSlider = function () {

    return {

        //Layer Slider
        initLayerSlider: function () {
		    $(document).ready(function(){
		        jQuery("#layerslider").layerSlider({
			        skin: 'fullwidth',
			        responsive : true,
			        responsiveUnder : 960,
			        layersContainer : 960,
					navPrevNext:false,
					navStartStop:false,
					showCircleTimer:false,
			        skinsPath: 'assets/plugins/layer-slider/layerslider/skins/'
			    });
		    });     
        }

    };
}();        