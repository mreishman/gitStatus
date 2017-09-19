<?php

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
if(file_exists('core/conf/cachedStatus.php'))
{ 
	require_once('core/conf/cachedStatus.php');  
}
$version = explode('.', $configStatic['version']);
$newestVersion = explode('.', $configStatic['newestVersion']);

$levelOfUpdate = 0; // 0 is no updated, 1 is minor update and 2 is major update
$beta = false;

$newestVersionCount = count($newestVersion);
$versionCount = count($version);

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
				$beta = true;
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
				$beta = true;
				break;
			}
		}
		else
		{
			if($newestVersion[$i] > $version[$i])
			{
				$levelOfUpdate = 1;
				break;
			}
			elseif($newestVersion[$i] < $version[$i])
			{
				$beta = true;
				break;
			}
		}
	}
	else
	{
		$levelOfUpdate = 1;
		break;
	}
}

require_once('core/php/loadVars.php'); ?>
<!doctype html>
<head>
	<title>Git Status | Settings</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<link rel="stylesheet" type="text/css" href="core/css/jquery-ui.css">
	<link rel="icon" type="image/png" href="core/img/favicon.png" />
	<script src="core/js/jquery.js"></script>
	<script src="core/js/jquery-ui.js"></script>
	<script src="core/js/visibility.core.js"></script>
	<script src="core/js/visibility.fallback.js"></script>
	<script src="core/js/visibility.js"></script>
	<script src="core/js/visibility.timers.js"></script>
	<script src="core/js/jscolor.js"></script>
</head>
<body>
	
	<?php require_once('core/php/templateFiles/sidebar.php'); ?>
	<div id="menu">
			<div onclick="toggleMenuSideBar()" class="nav-toggle pull-right link">
			<a class="show-sidebar" id="show">
		    	<span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		    </a>
			</div>
			<div style="display: inline-block;" >
				<a href="#" class="back-to-top" style="color:#000000;">Back to Top</a>
			</div>
		</div>	
	<div id="main">
		<div class="firstBoxDev">
			<?php require_once('core/php/templateFiles/settingsMain.php');?>
		</div>
		<div class="firstBoxDev">
			<?php require_once('core/php/templateFiles/devBoxSettings.php');?>
		</div>
		<div class="firstBoxDev">
			<?php require_once('core/php/templateFiles/customMessage.php');?>
		</div>
		<div class="firstBoxDev">
			<?php require_once('core/php/templateFiles/issuesSearchVars.php');?>
		</div>
		<div class="firstBoxDev">
			<?php require_once('core/php/templateFiles/colorBG.php');?>
		</div>
		<div class="firstBoxDev">
			<?php require_once('core/php/templateFiles/advancedSettings.php');?>
		</div>
	</div>
	<script type="text/javascript">
	$( function() {
    	$( "#datepicker" ).datepicker();
  	} );

	var counfOfFiltersForbranchName = <?php echo $counfOfFiltersForbranchName; ?>;
	var counfOfFiltersForAuthorName = <?php echo $counfOfFiltersForAuthorName; ?>;
	var counfOfFiltersForComitteeName = <?php echo $counfOfFiltersForComitteeName; ?>;

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
			elementWidth = 542;
		}
		else if (numOfWindows == 2)
		{
			elementWidth = 342;
		}
		else if (numOfWindows == 3)
		{
			elementWidth = 542;
		}
		else if (numOfWindows == 4)
		{
			elementWidth = 500;
		}
		else if (numOfWindows == 5)
		{
			//change if adding more windows to settings.php
			elementWidth = 9000000;
		}
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
	<script src="core/js/settings.js"></script>
<?php require_once('core/php/templateFiles/allPages.php') ?>
<?php readfile('core/html/popup.html') ?>
</body>
