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
        document.getElementById("openMenuHamburger").style.display = "none";
        document.getElementById("closeMenuHamburger").style.display = "inline-block";
	}
	else
	{
		document.getElementById("sidebar").style.width = "100px";
		document.getElementById("sidebarBG").style.width = "100px";
		document.getElementById("sidebarMenu").style.display = "block";
		document.cookie = "toggleMenuSideBarGitStatus=open";
		calcuateWidth();	
		$('#sidebar').addClass('sidebarIsVisible');
        document.getElementById("openMenuHamburger").style.display = "inline-block";
        document.getElementById("closeMenuHamburger").style.display = "none";
	}
}


calcuateWidth();

function resizeFunction()
{
	calcuateWidth();
	var heightWindow = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
	var heightVar = (heightWindow-40)+"px";
	document.getElementById("main").style.height = heightVar;
    if(document.getElementById("windows"))
    {
        document.getElementById("windows").style.height = heightVar;
        document.getElementById("sideBox").style.height = (heightWindow-100)+"px";
        document.getElementById("listOfCommitHistory").style.height = (heightWindow-138)+"px";
        document.getElementById("spanForMainDiff").style.height = (heightWindow-138)+"px";
    }
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
    resizeFunction();
});