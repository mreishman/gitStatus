<?php
require_once("../core/php/functions/watchlistFunctions.php");
$baseUrl = "../core/";
if(file_exists('../local/layout.php'))
{
	$baseUrl = "../local/";
	//there is custom information, use this
	require_once('../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}

function clean_url($url) {
    $parts = parse_url($url);
    return $parts['path'];
}


require_once($baseUrl.'conf/config.php');
require_once('setupProcessFile.php');

if($setupProcess != "step3")
{
	$partOfUrl = clean_url($_SERVER['REQUEST_URI']);
	$partOfUrl = substr($partOfUrl, 0, strpos($partOfUrl, 'setup'));
	$url = "http://" . $_SERVER['HTTP_HOST'] .$partOfUrl ."setup/director.php";
	header('Location: ' . $url, true, 302);
	exit();
}
$counterSteps = 1;
while(file_exists('step'.$counterSteps.'.php'))
{
	$counterSteps++;
}
$counterSteps--;
require_once('../core/php/loadVars.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome!</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<script src="../core/js/jquery.js"></script>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<style type="text/css">
		.innerFirstDevBox .devBoxTitle{
			display: none;
		}
		#widthForWatchListSection{
			width: 100% !important;
		}
	</style>
</head>
<body>
<?php readfile('../core/html/popup.html') ?>
<div class="firstBoxDev" style="width: 90%; margin: auto; margin-right: auto; margin-left: auto; display: block; height: auto; margin-top: 15px;" >
	<div class="devBoxTitle">
		<h1>Step 3 of <?php echo $counterSteps; ?></h1>
	</div>
	<p style="padding: 10px;">Server Watch List: These are the local (or remote, if this is a server) folders that are being watched by status. Please enter some in the fields below:</p>
	<div style="border: 1px solid white; margin-bottom:10px; background-color: #888">
		<?php require_once('../core/php/templateFiles/watchListServer.php'); ?>
	</div>
	<table style="width: 100%; padding-left: 20px; padding-right: 20px;" ><tr><th style="text-align: right;" >
		<?php if($counterSteps == 3): ?>
			<a onclick="updateStatus('finished');" class="mainLinkClass">Finish</a>
		<?php else: ?>
			<a onclick="updateStatus('step4');" class="mainLinkClass">Continue</a>
		<?php endif; ?>
	</th></tr></table>
	<br>
	<br>
</div>
</body>
<form id="defaultVarsForm" action="../core/php/saveFunctions/settingsSaveMain.php" method="post"></form>
<script type="text/javascript">
	var successVerifyNum = <?php echo $successVerifyNum; ?>;

	function defaultSettings()
	{
		//change setupProcess to finished
		location.reload();
	}

	function customSettings()
	{
		//change setupProcess to page2
		document.getElementById('settingsMainWatch').action = "../core/php/saveFunctions/settingsSaveMain.php";
		document.getElementById('settingsMainWatch').submit();
	}
</script>
<script src="../core/js/watchlist.js"></script>
<script src="stepsJavascript.js"></script>
</html>