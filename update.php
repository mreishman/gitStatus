<?php
require_once("core/php/functions/commonFunctions.php");
$baseUrl = "core/";
if(file_exists('local/layout.php'))
{
	$baseUrl = "local/";
	//there is custom information, use this
	require_once('local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php'); 
require_once('core/conf/config.php');
require_once('core/php/configStatic.php');  

$version = explode('.', $configStatic['version']);
$newestVersion = explode('.', $configStatic['newestVersion']);

$levelOfUpdate = 0; // 0 is no updated, 1 is minor update and 2 is major update
$beta = false;

$newestVersionCount = count($newestVersion);
$versionCount = count($version);
$levelOfUpdate = $levelOfUpdate = findUpdateValue($newestVersionCount, $versionCount, $newestVersion, $version);
require_once('core/php/loadVars.php'); ?>
<!doctype html>
<head>
	<title>Git Status | Update</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<link rel="icon" type="image/png" href="core/img/favicon.png" />
	<script src="core/js/jquery.js"></script>
	<script src="core/js/visibility.core.js"></script>
	<script src="core/js/visibility.fallback.js"></script>
	<script src="core/js/visibility.js"></script>
	<script src="core/js/visibility.timers.js"></script>
</head>
<body>
	
	<?php require_once('core/php/templateFiles/sidebar.php'); ?>
	<?php require_once('core/php/templateFiles/header.php'); ?>
	<div id="main">
		
		<div class="firstBoxDev">
			<div class="innerFirstDevBox"  >
				<div class="devBoxTitle">
					<b>Update</b>
				</div>
				<div class="devBoxContent">
					Current Version <?php echo $configStatic['version']; ?>
					<br><br>
					Last Check for updates -  <?php echo $configStatic['lastCheck'];?>
					<br><br>
					<form id="settingsCheckForUpdate" action="core/php/update/settingsCheckForUpdate.php" method="post">
					<button class="buttonButton" onclick="displayLoadingPopup();" >Check for Update</button>
					</form>
					
					<form id="settingsCheckForUpdate" action="update/updater.php" method="post">
					<?php
					if($levelOfUpdate != 0){echo '<br><br><button class="buttonButton" onclick="displayLoadingPopup();">Install '.$configStatic["newestVersion"].' Update</button>';}
					?>
					</form>
					
						<span id="noUpdate" <?php if($levelOfUpdate != 0){echo "style='display: none;'";} ?> >
						<h2><img id="statusImage1" src="core/img/greenCheck.png" height="15px"> &nbsp; No new updates - You are on the current version!</h2>
						</span>
						<span id="minorUpdate" <?php if($levelOfUpdate != 1){echo "style='display: none;'";} ?> >
							<h2><img id="statusImage2" src="core/img/yellowWarning.png" height="15px"> &nbsp; Minor Updates - <?php echo $configStatic['newestVersion'];?> - bug fixes </h2>
						</span>
						<span id="majorUpdate" <?php if($levelOfUpdate != 2){echo "style='display: none;'";} ?> >
							<h2><img id="statusImage3" src="core/img/redWarning.png" height="15px"> &nbsp; Major Updates - <?php echo $configStatic['newestVersion'];?> - new features!</h2>
						</span>
						<span id="NewXReleaseUpdate" <?php if($levelOfUpdate != 3){echo "style='display: none;'";} ?> >
							<h2><img id="statusImage3" src="core/img/redWarning.png" height="15px"><img id="statusImage3" src="core/img/redWarning.png" height="15px"><img id="statusImage3" src="core/img/redWarning.png" height="15px"> &nbsp; Very Major Updates - <?php echo $configStatic['newestVersion'];?> - a lot of new features!</h2>
						</span>
					
				</div>
			</div>
		</div>
		<?php if($levelOfUpdate != 0): ?>
		<div class="firstBoxDev">
			<div class="innerFirstDevBox" style="width: 600px;"  >
				<div class="devBoxTitle">
				Update - Release Notes
				</div>
				<div class="devBoxContent"  >
					<ul id="settingsUl">
					<?php 
					if(array_key_exists('versionList', $configStatic))
					{
						foreach ($configStatic['versionList'] as $key => $value) 
						{
							$version = explode('.', $configStatic['version']);
							$newestVersion = explode('.', $key);
							$levelOfUpdate = 0;
							for($i = 0; $i < $newestVersionCount; $i++)
							{
								if($i < $versionCount)
								{
									if($i == 0)
									{
										if($newestVersion[$i] > $version[$i])
										{
											$levelOfUpdate = 3;
											break;
										}
										elseif($newestVersion[$i] < $version[$i])
										{
											break;
										}
									}
									elseif($i == 1)
									{
										if($newestVersion[$i] > $version[$i])
										{
											$levelOfUpdate = 2;
											break;
										}
										elseif($newestVersion[$i] < $version[$i])
										{
											break;
										}
									}
									else
									{
										if(isset($newestVersion[$i]))
										{
											if($newestVersion[$i] > $version[$i])
											{
												$levelOfUpdate = 1;
												break;
											}
											elseif($newestVersion[$i] < $version[$i])
											{
												break;
											}
										}
									}
								}
								else
								{
									$levelOfUpdate = 1;
									break;
								}
							}
							if($levelOfUpdate != 0)
							{
								echo "<li class='settingsUl' ><h2>Changelog For ".$key." update</h2></li>";
								echo $value['releaseNotes'];
							}
						}
					}
					
					?>
					</ul>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<div class="firstBoxDev">
			<div class="innerFirstDevBox" style=" width: 600px;"  >
				<div class="devBoxTitle">
					<b>Changelog</b>
				</div>
				<div class="devBoxContent">
					<?php readfile('core/html/changelog.html') ?>
				</div>
			</div>
		</div>
	</div>
		<script type="text/javascript">
		function calcuateWidth()
{
	var innerWidthWindow = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
	if(document.getElementById("sidebar").style.width == '100px')
	{
		innerWidthWindow -= 103;
	}
	if(document.getElementById("sidebar").style.width == '100px')
	{
		document.getElementById("main").style.left = "103px";
	}
	else
	{
		document.getElementById("main").style.left = "0px";
	}
	var innerWidthWindowCalc = innerWidthWindow;
	var innerWidthWindowCalcAdd = 0;
	var numOfWindows = 0;
	var elementWidth = 342;
	while(innerWidthWindowCalc > elementWidth)
	{
		innerWidthWindowCalcAdd += elementWidth;
		numOfWindows++;
		if(numOfWindows == 1)
		{
			elementWidth = 342;
		}
		<?php if($levelOfUpdate != 0): ?>
		else if (numOfWindows == 2)
		{
			elementWidth = 642;
		}
		else if (numOfWindows == 3)
		{
			//change if adding more windows to update.php
			elementWidth = 9000000;
		}
		<?php else: ?>
		else if (numOfWindows == 2)
		{
			//change if adding more windows to update.php
			elementWidth = 9000000;
		}
		<?php endif; ?>
		innerWidthWindowCalc -= elementWidth;
	}
	var windowWidthText = ((innerWidthWindowCalcAdd)+40)+"px";
	document.getElementById("main").style.width = windowWidthText;
	var remainingWidth = innerWidthWindow - ((innerWidthWindowCalcAdd)+40);
	remainingWidth = remainingWidth / 2;
	var windowWidthText = remainingWidth+"px";
	document.getElementById("main").style.marginLeft = windowWidthText;
	document.getElementById("main").style.paddingRight = windowWidthText;
}

	</script>
	<script src="core/js/allPages.js"></script>
	<script type="text/javascript">
		document.getElementById("menuBarLeftUpdate").style.backgroundColor  = "#ffffff";
	</script>
	<?php require_once('core/php/templateFiles/allPages.php') ?>
	<?php readfile('core/html/popup.html') ?>
</body>