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
if(file_exists('core/conf/cachedStatus.php'))
{
	require_once('core/conf/cachedStatus.php');
}
require_once('core/php/update/updateCheck.php');
require_once('core/php/loadVars.php');
require_once('setup/setupProcessFile.php');
?>
<!doctype html>
<head>
	<title>Git Status | Settings</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css?v=<?php echo $configStatic['version']; ?>">
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
	<?php require_once('core/php/templateFiles/header.php'); ?>
	<div id="main" style="overflow: auto; overflow-y: auto;" >
		<div class="firstBoxDev">
			<?php require_once('core/php/templateFiles/settingsMain.php');?>
		</div>
		<div class="firstBoxDev">
			<?php require_once('core/php/templateFiles/settingsPoll.php');?>
		</div>
		<div class="firstBoxDev">
			<?php require_once('core/php/templateFiles/settingsPopup.php');?>
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
	<?php
		echo "var currentVersion = '".$configStatic['version']."';";
	?>
	var counfOfFiltersForbranchName = <?php echo $counfOfFiltersForbranchName; ?>;
	var counfOfFiltersForAuthorName = <?php echo $counfOfFiltersForAuthorName; ?>;
	var counfOfFiltersForComitteeName = <?php echo $counfOfFiltersForComitteeName; ?>;
	var successVerifyNum = <?php echo $successVerifyNum; ?>;

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
	<script src="core/js/settings.js?v=<?php echo $configStatic['version']; ?>"></script>
	<script src="core/js/cacheClear.js?v=<?php echo $configStatic['version']; ?>"></script>
	<script src="core/js/settingsAll.js?v=<?php echo $configStatic['version']; ?>"></script>
<?php readfile('core/html/popup.html') ?>
</body>
