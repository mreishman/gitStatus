function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

var widthWindow = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
var heightWindow = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

function toggleMenuSideBar() {
	if(document.getElementById("sidebar").style.width == '100px')
	{
		document.getElementById("sidebar").style.width = "0px";
		document.getElementById("sidebarBG").style.width = "0px";
		document.getElementById("sidebarMenu").style.display = "none";
		document.cookie = "toggleMenuSideBarGitStatus=closed";
		calcuateWidth();
		$('#sidebar').removeClass('sidebarIsVisible');
	}
	else
	{
		document.getElementById("sidebar").style.width = "100px";
		document.getElementById("sidebarBG").style.width = "100px";
		document.getElementById("sidebarMenu").style.display = "block";
		document.cookie = "toggleMenuSideBarGitStatus=open";
		calcuateWidth();	
		$('#sidebar').addClass('sidebarIsVisible');
	}
}



var heightVar = (heightWindow-40)+"px";
document.getElementById("main").style.height = heightVar;

calcuateWidth();

function resizeFunction()
{
	calcuateWidth();
	var heightWindow = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
	var heightVar = (heightWindow-40)+"px";
	document.getElementById("main").style.height = heightVar;
}

$(window).resize(function(){
    resizeFunction();
});

jQuery(document).ready(function() {
    var offset = 220;
    var duration = 500;
    $('#main').scroll(function() {
        if ($('#main').scrollTop() > offset) {
            jQuery('.back-to-top').fadeIn(duration);
        } else {
            jQuery('.back-to-top').fadeOut(duration);
        }
    });
    
    jQuery('.back-to-top').click(function(event) {
        event.preventDefault();
        $('#main').animate({scrollTop: 0}, duration);
        return false;
    });
});