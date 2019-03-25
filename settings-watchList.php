<?php
require_once("core/php/functions/commonFunctions.php");
require_once("core/php/functions/watchlistFunctions.php");
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
require_once('core/php/loadVars.php');
require_once('setup/setupProcessFile.php');
?>
<!doctype html>
<head>
	<title>Git Status | Settings</title>
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
	<div id="main">
		<div class="firstBoxDev">
			<?php require_once('core/php/templateFiles/watchList.php'); ?>
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
		var elementWidth = 410;
		while(innerWidthWindowCalc > elementWidth)
		{
			innerWidthWindowCalcAdd += elementWidth;
			numOfWindows++;
			innerWidthWindowCalc -= elementWidth;
		}
		var remainingWidth = innerWidthWindow - ((innerWidthWindowCalcAdd)+40);
		remainingWidth = remainingWidth / 2;
		var windowWidthText = remainingWidth+"px";
		document.getElementById("main").style.paddingLeft = windowWidthText;
		document.getElementById("main").style.paddingRight = windowWidthText;
		document.getElementById("widthForWatchListSection").style.width = ((innerWidthWindowCalcAdd))+"px";
	}

	function saveWatchList(post)
	{
		var duplicateNames = false;
		//check for duplicate names
		var counter = 1;
		var arrayOfNames = new Array();
		while(document.getElementsByName("watchListKey"+counter).length > 0)
		{
			var checkName = document.getElementsByName("watchListKey"+counter)[0].value;
			if(!((arrayOfNames.indexOf(checkName) > -1)))
			{
				arrayOfNames.push(checkName);
			}
			else
			{
				duplicateNames = true;
			}
			counter++;
		}
		if(!duplicateNames)
		{
			if(!post)
			{
				saveAndVerifyMain("settingsMainWatch");
			}
			else
			{
				displayLoadingPopup();
				document.getElementById("settingsMainWatch").submit();
			}
		}
		else
		{
			//show popup
			showPopup();
			document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='devBoxTitle' ><b>Error</b></div><br><br><div style='width:100%;text-align:center;'> Names must be unique <br> <button class='buttonButton' onclick='hidePopup();'>Ok</button> </div>";
		}

	}
<?php
	echo "var currentVersion = '".$configStatic['version']."';";
?>
	var successVerifyNum = <?php echo $successVerifyNum; ?>;
</script>
<script src="core/js/allPages.js?v=<?php echo $configStatic['version']; ?>"></script>
<script src="core/js/cacheClear.js?v=<?php echo $configStatic['version']; ?>"></script>
<script src="core/js/settingsAll.js?v=<?php echo $configStatic['version']; ?>"></script>
<script type="text/javascript">
	document.getElementById("menuBarLeftSettingsWatchList").style.backgroundColor  = "#ffffff";
</script>
<script src="core/js/watchlist.js?v=<?php echo $configStatic['version']; ?>"></script>

<?php readfile('core/html/popup.html') ?>
</body>
