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
		var windowWidthText = widthWindow+"px";
		document.getElementById("main").style.width = windowWidthText;
		$('#sidebar').removeClass('sidebarIsVisible');
		document.getElementById("main").style.left = "0px";
	}
	else
	{
		document.getElementById("sidebar").style.width = "100px";
		document.getElementById("sidebarBG").style.width = "100px";
		document.getElementById("sidebarMenu").style.display = "block";
		document.cookie = "toggleMenuSideBarGitStatus=open";
		var windowWidthText = (widthWindow - 102)+"px";
		document.getElementById("main").style.width = windowWidthText;	
		$('#sidebar').addClass('sidebarIsVisible');
		document.getElementById("main").style.left = "100px";
	}
}


if(document.getElementById("sidebar").style.width == '100px')
{
	document.getElementById("main").style.left = "100px";
}
else
{
	document.getElementById("main").style.left = "0px";
}
var heightVar = (heightWindow-40)+"px";
document.getElementById("main").style.height = heightVar;

