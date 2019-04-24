	<div id="sidebar" <?php
	$URI = $_SERVER['REQUEST_URI'];
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
				<li <?php if(strpos($URI, 'about.php') !== false) { echo "class='selected'"; } ?> id="menuBarLeftAbout" onclick="window.location.href = 'about.php';" >
				About
				</li>
				<li <?php if(strpos($URI, 'settings.php') !== false) { echo "class='selected'"; } ?> id="menuBarLeftSettings" onclick="window.location.href = 'settings.php';" >
				Settings
				</li>
				<li <?php if(strpos($URI, 'settings-watchList.php') !== false) { echo "class='selected'"; } ?>  id="menuBarLeftSettingsWatchList" onclick="window.location.href = 'settings-watchList.php';" >
				Watch List
				</li>
				<?php if(strpos($URI, 'settings-watchList.php') !== false): ?>
					<li class="selected" >
						<ul class="menuBarLeft">
							<li class="ignoreHover">
								<a onclick="addRowFunction()">Add Server</a>
							</li>
						</ul>
					</li>
				<?php endif; ?>
				<li <?php if(strpos($URI, 'settings-watchListServer.php') !== false) { echo "class='selected'"; } ?>  <?php if ($pollType !== "2"){ echo "style='display: none;'";} ?> id="menuBarLeftSettingsServerWatchList" onclick="window.location.href = 'settings-watchListServer.php';" >
					Server Watch
				</li>
				<?php if(strpos($URI, 'settings-watchListServer.php') !== false): ?>
					<li class="selected">
						<ul class="menuBarLeft">
							<li class="ignoreHover">
								<a onclick="addRowFunction()">Add Server</a>
							</li>
						</ul>
					</li>
				<?php endif; ?>
				<li <?php if(strpos($URI, 'update.php') !== false) { echo "class='selected'"; } ?> id="menuBarLeftUpdate" onclick="window.location.href = 'update.php';" >
				Update
				<?php  if($levelOfUpdate == 1){echo '<img src="core/img/yellowWarning.png" height="10px">';} ?> <?php if($levelOfUpdate == 2 || $levelOfUpdate == 3){echo '<img src="core/img/redWarning.png" height="10px">';} ?>
				</li>
				<li class="ignoreHover" style="height: 10px; border-top: 1px solid white; cursor: default;" >
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
					<li id="seleniumMonitor-link"  onclick="window.location.href =  '../SeleniumMonitor/';" >Selenium Monitor</li>
				<?php elseif(file_exists('../seleniumMonitor/index.php')): ?>
					<li id="seleniumMonitor-link"  onclick="window.location.href =  '../seleniumMonitor/';" >Selenium Monitor</li>
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
					<li id="seleniumMonitor-link"  onclick="window.location.href =  '../Log-Hog/SeleniumMonitor/';" >Selenium Monitor</li>
				<?php elseif(file_exists('../loghog/seleniumMonitor/index.php')): ?>
					<li id="seleniumMonitor-link"  onclick="window.location.href =  '../loghog/seleniumMonitor/';" >Selenium Monitor</li>
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