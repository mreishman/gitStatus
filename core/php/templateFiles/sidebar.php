	<div id="sidebar" <?php if(isset($_COOKIE['toggleMenuSideBarGitStatus'])) 
		{
	    	if($_COOKIE['toggleMenuSideBarGitStatus'] == 'open')
	    	{
	    		echo "style='width: 100px;'";
	    	}
		}
	?>
	>
		<div id="sidebarMenu"  <?php if(isset($_COOKIE['toggleMenuSideBarGitStatus'])) 
		{
    		if($_COOKIE['toggleMenuSideBarGitStatus'] == 'open')
		    {
		    	echo "style='width: block;'";
		    }
		    else
		    {
		    	echo 'style="display: none;"';
		    }
		}
		else
		{
			echo 'style="display: none;"';
		}
		?>>
			<ul class="menuBarLeft" >
				<li id="menuBarLeftMain" onclick="window.location.href = 'index.php';" >
				Main
				</li>
				<li id="menuBarLeftAbout" onclick="window.location.href = 'about.php';" >
				About
				</li>
				<li id="menuBarLeftSettings" onclick="window.location.href = 'about.php';" >
				Settings
				</li>
				<li id="menuBarLeftUpdate" onclick="window.location.href = 'about.php';" >
				Update
				</li>
			</ul>

		</div>
	</div>

	<div id="sidebarBG" 
	<?php if(isset($_COOKIE['toggleMenuSideBarGitStatus'])) 
{
    if($_COOKIE['toggleMenuSideBarGitStatus'] == 'open')
    {
    	echo "style='width: 100px;'";
    }
}
?>  >
	</div>