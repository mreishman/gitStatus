	<div id="sidebar" <?php
	$open = false;
	if(isset($_COOKIE['toggleMenuSideBarGitStatus'])) 
		{
	    	$open = false;
			if(isset($_COOKIE['toggleMenuSideBarGitStatus'])) 
			{
			    if($_COOKIE['toggleMenuSideBarGitStatus'] == 'open')
			    {
			    	echo "style='width: 100px;' class='sidebarIsVisible'";
			    	$open = true;
			    }
			}
			if($open == false && $levelOfUpdate != 0)
			{
				echo "style='width: 100px;' class='sidebarIsVisible'";
			}
		}
	?>
	>
		<div id="sidebarMenu"  <?php if(isset($_COOKIE['toggleMenuSideBarGitStatus'])) 
		{
    		if($open == true)
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
		<div class="paddingTopForLeftMenu">
		</div>
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
				<li id="menuBarLeftSettingsWatchList" onclick="window.location.href = 'settings-watchList.php';" >
				Watch List
				</li>
				<li id="menuBarLeftUpdate" onclick="window.location.href = 'update.php';" >
				Update
				<?php  if($levelOfUpdate == 1){echo '<img src="core/img/yellowWarning.png" height="10px">';} ?> <?php if($levelOfUpdate == 2 || $levelOfUpdate == 3){echo '<img src="core/img/redWarning.png" height="10px">';} ?>
				</li>
				<?php if(file_exists('../monitor/index.php')): ?>
					<li id="monitorLink"  onclick="window.location.href =  '../status/';" >Monitor</li>
				<?php endif;?>
				<?php if(file_exists('../Log-Hog/index.php')): ?>
					<li id="Log-HogLink"  onclick="window.location.href =  '../Log-Hog/';" >Log-Hog</li>
				<?php endif;?>
				<?php if(file_exists('../loghog/index.php')): ?>
					<li id="Loghog-link"  onclick="window.location.href =  '../loghog/';" >Loghog</li>
				<?php endif;?>
			</ul>

		</div>
	</div>

	<div id="sidebarBG" 
	<?php
    if($open == true)
    {
    	echo "style='width: 100px;'";
    	$open = true;
    }
	if($open == false && $levelOfUpdate != 0)
	{
		echo "style='width: 100px;'";
	}
?>  >
	</div>