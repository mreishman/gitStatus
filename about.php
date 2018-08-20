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
require_once('core/php/update/updateCheck.php');
require_once('core/php/loadVars.php'); ?>
<!doctype html>
<head>
	<title>Git Status | About</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css?v=<?php echo $configStatic['version']; ?>">
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
	<div id="main" style="overflow: auto; overflow-y: auto;" >
		<div class="firstBoxDev">
			<div class="innerFirstDevBox"  >
				<div class="devBoxTitle">
					<b>About</b>
				</div>
				<div class="devBoxContent">
					gitStatus
					<br><br>
					A Simple Git Status Monitor
					<br><br>
					Version <?php echo $configStatic['version']; ?>
				</div>
			</div>
		</div>
		<div class="firstBoxDev">
			<div class="innerFirstDevBox"  >
				<div class="devBoxTitle">
					<b>Github:</b>
				</div>
				<div class="devBoxContent">
					<a style="color: black;" href="https://github.com/mreishman/gitStatus">Github link</a>
					<br><br>
					<a style="color: black;" href="https://github.com/mreishman/gitStatus/issues">Issues</a>
				</div>
			</div>
		</div>
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
	<div>
	<script type="text/javascript">
	function calcuateWidth()
	{
		var left = "0px";
		if(document.getElementById("sidebar").style.width == '100px')
		{
			left = "100px";
		}
		document.getElementById("main").style.left = left;
	}
	</script>
	<script src="core/js/allPages.js?v=<?php echo $configStatic['version']; ?>"></script>
	<script type="text/javascript">
		document.getElementById("menuBarLeftAbout").style.backgroundColor  = "#ffffff";
	</script>
	<?php require_once('core/php/templateFiles/allPages.php') ?>
</body>