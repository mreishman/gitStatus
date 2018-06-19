var widthWindow = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
var heightWindow = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
var heightVar = (heightWindow-40)+"px";
document.getElementById("main").style.height = heightVar;

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

function toggleMenuSideBar()
{
    var selector = 1;
    var objSett = {0: {sidebar: "0px", sidebarBG: "0px", sidebarMenu: "none", cookie: "toggleMenuSideBarGitStatus=closed", openMenuHamburger: "none", closeMenuHamburger: "inline-block" },1: {sidebar: "100px", sidebarBG: "100px", sidebarMenu: "block", cookie: "toggleMenuSideBarGitStatus=open", openMenuHamburger: "inline-block", closeMenuHamburger: "none" }};
	if(document.getElementById("sidebar").style.width == '100px')
	{
        selector = 0;
        $('#sidebar').removeClass('sidebarIsVisible');
    }
    else
    {
        $('#sidebar').addClass('sidebarIsVisible');
    }
	document.getElementById("sidebar").style.width = objSett[selector]["sidebar"];
	document.getElementById("sidebarBG").style.width = objSett[selector]["sidebarBG"];
	document.getElementById("sidebarMenu").style.display = objSett[selector]["sidebarMenu"];
	document.cookie = objSett[selector]["cookie"];
	calcuateWidth();
    document.getElementById("openMenuHamburger").style.display = objSett[selector]["openMenuHamburger"];
    document.getElementById("closeMenuHamburger").style.display = objSett[selector]["closeMenuHamburger"];	
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

jQuery(document).ready(function()
{
    calcuateWidth();
    
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