	<div id="sidebar" <?php if(isset($_COOKIE['toggleMenuSideBarGitStatus'])) 
		{
	    	$open = false;
			if(isset($_COOKIE['toggleMenuSideBarGitStatus'])) 
			{
			    if($_COOKIE['toggleMenuSideBarGitStatus'] == 'open')
			    {
			    	echo "style='width: 100px;'";
			    	$open = true;
			    }
			}
			if($open == false && $levelOfUpdate != 0)
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
		    	if($open == false && $levelOfUpdate != 0)
				{
					echo "style='width: block;'";
				}
				else
				{
		    		echo 'style="display: none;"';
		    	}
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
				<li id="menuBarLeftSettings" onclick="window.location.href = 'settings.php';" >
				Settings
				</li>
				<li id="menuBarLeftUpdate" onclick="window.location.href = 'update.php';" >
				Update
				<?php  if($levelOfUpdate == 1){echo '<img src="core/img/yellowWarning.png" height="10px">';} ?> <?php if($levelOfUpdate == 2 || $levelOfUpdate == 3){echo '<img src="core/img/redWarning.png" height="10px">';} ?>
				</li>
			</ul>

		</div>
	</div>

	<div id="sidebarBG" 
	<?php
	$open = false;
	if(isset($_COOKIE['toggleMenuSideBarGitStatus'])) 
	{
	    if($_COOKIE['toggleMenuSideBarGitStatus'] == 'open')
	    {
	    	echo "style='width: 100px;'";
	    	$open = true;
	    }
	}
	if($open == false && $levelOfUpdate != 0)
	{
		echo "style='width: 100px;'";
	}
?>  >
	</div>