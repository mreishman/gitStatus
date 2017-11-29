	<div id="sidebar" <?php
	
	if($open)
	{
		echo "style='width: 100px;' class='sidebarIsVisible'";
	}
	?>
	>
		<div id="sidebarMenu"  <?php 
		if($open)
	    {
	    	echo "style='width: block;'";
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
				<?php if($loginAuthType != 'disabled'): ?>
					<li id="menuBarLeftSettingsLDPA" onclick="window.location.href = 'settings-auth.php';" >
					LDPA
					</li>
				<?php endif; ?>
				<li id="menuBarLeftUpdate" onclick="window.location.href = 'update.php';" >
				Update
				<?php  if($levelOfUpdate == 1){echo '<img src="core/img/yellowWarning.png" height="10px">';} ?> <?php if($levelOfUpdate == 2 || $levelOfUpdate == 3){echo '<img src="core/img/redWarning.png" height="10px">';} ?>
				</li>
				<li style="height: 0px; border-top: 1px solid white; border-bottom: 10px solid #aaaaaa;" >
				</li>
				<!-- Monitor -->
				<?php if(file_exists('../monitor/index.php')): ?>
					<li id="monitorLink"  onclick="window.location.href =  '../monitor/';" >Monitor</li>
				<?php endif;?>
				<!-- Search -->
				<?php if(file_exists('../search/index.php')): ?>
					<li id="search-link"  onclick="window.location.href =  '../search/';" >Search</li>
				<?php endif;?>
				<!-- SeleniumMonitor -->
				<?php if(file_exists('../SeleniumMonitor/index.php')): ?>
					<li id="seleniumMonitor-link"  onclick="window.location.href =  '../SeleniumMonitor/';" >SeleniumMonitor</li>
				<?php elseif(file_exists('../seleniumMonitor/index.php')): ?>
					<li id="seleniumMonitor-link"  onclick="window.location.href =  '../seleniumMonitor/';" >SeleniumMonitor</li>
				<?php endif;?>
				<!-- Log-Hog -->
				<?php if(file_exists('../Log-Hog/index.php')): ?>
					<li id="Log-HogLink"  onclick="window.location.href =  '../Log-Hog/';" >Log-Hog</li>
				<?php endif;?>
				<?php if(file_exists('../loghog/index.php')): ?>
					<li id="Loghog-link"  onclick="window.location.href =  '../loghog/';" >Loghog</li>
				<?php endif;?>
				<!-- Log-Hog / Monitor -->
				<?php if(file_exists('../Log-Hog/monitor/index.php')): ?>
					<li id="Log-HogLink"  onclick="window.location.href =  '../Log-Hog/monitor/';" >Monitor</li>
				<?php endif;?>
				<?php if(file_exists('../loghog/monitor/index.php')): ?>
					<li id="Loghog-link"  onclick="window.location.href =  '../loghog/monitor/';" >Monitor</li>
				<?php endif;?>
				<!-- Log-Hog / Search -->
				<?php if(file_exists('../Log-Hog/search/index.php')): ?>
					<li id="Log-HogLink"  onclick="window.location.href =  '../Log-Hog/search/';" >Search</li>
				<?php endif;?>
				<?php if(file_exists('../loghog/search/index.php')): ?>
					<li id="Loghog-link"  onclick="window.location.href =  '../loghog/search/';" >Search</li>
				<?php endif;?>
				<!-- Log=Hog / SeleniumMonitor -->
				<?php if(file_exists('../Log-Hog/seleniumMonitor/index.php')): ?>
					<li id="seleniumMonitor-link"  onclick="window.location.href =  '../Log-Hog/SeleniumMonitor/';" >SeleniumMonitor</li>
				<?php elseif(file_exists('../loghog/seleniumMonitor/index.php')): ?>
					<li id="seleniumMonitor-link"  onclick="window.location.href =  '../loghog/seleniumMonitor/';" >SeleniumMonitor</li>
				<?php endif;?>
			</ul>

		</div>
	</div>

	<div id="sidebarBG" 
	<?php
    if($open)
    {
    	echo "style='width: 100px;'";
    }
?>  >
	</div>