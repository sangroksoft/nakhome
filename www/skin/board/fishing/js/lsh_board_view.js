$(document).load($(window).bind("load", makeViewResponsive));
function makeViewResponsive( e ) {
	var imgs = $("img");
	$("#lsh-contents-section").find(imgs).addClass("img-responsive").css("display","inline").css("height","auto");

	var ifrcnt = $("iframe").length;
	if(ifrcnt > 0)
	{
		$('iframe').each(function(index) {
			var divs = $('<div id="'+index+'" class="responsive-video">');
			$(this).before(divs);
			divs.append($(this));
		});
	}
}
