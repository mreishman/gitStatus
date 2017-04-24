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

function toggleMenuSideBar() {
	var widthWindow = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
	if(document.getElementById("sidebar").style.width == '100px')
	{
		document.getElementById("sidebar").style.width = "0px";
		document.getElementById("sidebarBG").style.width = "0px";
		document.getElementById("sidebarMenu").style.display = "none";
		document.cookie = "toggleMenuSideBarGitStatus=closed";
		var windowWidthText = widthWindow+"px";
		document.getElementById("main").style.width = windowWidthText;
		$('#sidebar').removeClass('sidebarIsVisible');
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
	}
}

