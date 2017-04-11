<script type="text/javascript">
var widthWindow = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
var windowWidthText = (widthWindow - 102)+"px";
<?php if(isset($_COOKIE['toggleMenuSideBarGitStatus'])) 
{
	if($_COOKIE['toggleMenuSideBarGitStatus'] == 'open')
    {
    	echo "document.getElementById('main').style.width = windowWidthText;	";
    }
    else
    {
    	if($open == false && $levelOfUpdate != 0)
		{
			echo "document.getElementById('main').style.width = windowWidthText;	";
		}
    }
}
?>
</script>