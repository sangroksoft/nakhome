function checkagent()
{
	var agent = navigator.userAgent.toLowerCase();
	var agname = "";
	if ( (navigator.appName == 'Netscape' && navigator.userAgent.search('Trident') != -1) || (agent.indexOf("msie") != -1) ) {agname = "ie";}
	else 
	{
		if (agent.indexOf("chrome") != -1) {agname = "chrome";}
		else if (agent.indexOf("safari") != -1) {agname = "safari";}
		else if (agent.indexOf("firefox") != -1) {agname = "firefox";}
	}
    return agname;
}

var browser = checkagent();
if(browser == "ie") {	var sm_width = 768;}
else {var sm_width = 751;}

jQuery(document).ready(function() {
    $("#lsh-hamburger-fixed").click(function(e) {
        e.preventDefault();
        $("#lsh-nav-mob-wrapper").toggleClass("active")
    });
    $("#lsh-sidebar-close").click(function(e) {
        e.preventDefault();
        $("#lsh-nav-mob-wrapper").toggleClass("active")
    });
    $(".lsh-ahref").click(function(e) {
        e.preventDefault();
        $(".list-group-item").removeClass("active")
    })
});

$(document).load($(window).bind("load resize", listenWidth));

function listenWidth(e) {
    if ($("#divwrap").outerWidth() < 991) {
        $(".lsh-toggle-fluid").removeClass("container").addClass("container-fluid")
    } else {
        $(".lsh-toggle-fluid").removeClass("container-fluid").addClass("container")
    }

	var wrapper_width = $("#divwrap").outerWidth();
	/*
	if(wrapper_width < sm_width)
	{
		$("#shipImgs").remove().insertAfter($("#shipSelect")).hide();  
		$("#shipSelect").css({"width":"80%"});
	}
	else
	{
		$("#shipImgs").remove().insertAfter($("#shipWrap")).show();
		$("#shipSelect").css({"width":"100%"});
	}
	*/

}
$("#lsh-pc-menu>ul>li>a").mouseover(function() {
    if ($("nav#lsh-pc-menu>ul>li>div").is(":hidden")) {
        $("nav#lsh-pc-menu>ul>li").removeClass("on");
        $(this).parents().addClass("on");
        $("nav#lsh-pc-menu>ul>li>div").fadeOut(1);
        $("+div", this).fadeIn(1)
    }
});
$("#lsh-pc-menu").mouseleave(function() {
    $("nav#lsh-pc-menu>ul>li").removeClass("on");
    $("nav#lsh-pc-menu>ul>li>div").fadeOut(1)
});
/*
// 윈도우창크기 조절이벤트
$(window).on('load resize', function()
{
	console.log(11);
});
*/

