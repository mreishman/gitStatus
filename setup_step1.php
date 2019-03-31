<?php
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

if($setupProcess != "step1")
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
		<h1>Step 1 of <?php echo $counterSteps; ?></h1>
	</div>
	<p style="padding: 10px;">Which poll type would you like to use? Poll type 1 or 2?</p>
	<p style="padding: 10px;">Poll type 1 is for smaller setups where getting poll information is directly between computers. Because this sends more info, it would be consered less secure.</p>
	<p style="padding: 10px;">Poll type 2 is recommended for larger setups where one computer acts as a server, and gets info from a lot of nodes. This reduces requests made from the host machine. This does, however, require more setup (as there is two watchlists, and config is done on the node as well)</p>
	<div style="border: 1px solid white; margin-bottom:10px; background-color: #888">
		<table width="100%">
			<tr>
				<th width="50%">
					<br>
					Poll Type 1 <span id="pollTypeOneMessage" <?php if ($pollType !== "1"){echo "style='display: none;'";} ?> >(currently selected)</span>
					<br>
					<br>
					<form  id="pollTypeOne">
						<button onclick="toggleMessage(1); saveAndVerifyMain('pollTypeTwo');" >Select</button>
						<input type="hidden" name="pollType" value="1" >
					</form>
					<br>
				</th>
				<th width="50%">
					<br>
					Poll Type 2 <span id="pollTypeTwoMessage" <?php if ($pollType !== "2"){echo "style='display: none;'";} ?> >(currently selected)</span>
					<br>
					<br>
					<form id="pollTypeTwo">
						<button onclick="toggleMessage(2); saveAndVerifyMain('pollTypeTwo');" >Select</button>
						<input type="hidden" name="pollType" value="2" >
					</form>
					<br>
				</th>
			</tr>
		</table>
	</div>
	<table style="width: 100%; padding-left: 20px; padding-right: 20px;" ><tr><th style="text-align: right;" >
		<?php if($counterSteps == 1): ?>
			<a onclick="updateStatus('finished');" class="mainLinkClass">Finish</a>
		<?php else: ?>
			<a onclick="updateStatus('step2');" class="mainLinkClass">Continue</a>
		<?php endif; ?>
	</th></tr></table>
	<br>
	<br>
</div>
</body>
<form id="defaultVarsForm" action="../core/php/saveFunctions/settingsSaveMain.php" method="post"></form>
<script type="text/javascript">
	var successVerifyNum = <?php echo $successVerifyNum; ?>;

	function updateStatusCustom()
	{
		if(document.getElementById("pollTypeTwoMessage").style.display === "block")
		{
			//poll type 2, send to 2
			updateStatus('step2');
		}
		else
		{
			//skip 2
			updateStatus('step3');
		}
	}

	function toggleMessage(num)
	{
		if(num == 2)
		{
			document.getElementById("pollTypeTwoMessage").style.display = "block";
			document.getElementById("pollTypeOneMessage").style.display = "none";
		}
		else
		{
			document.getElementById("pollTypeTwoMessage").style.display = "none";
			document.getElementById("pollTypeOneMessage").style.display = "block";
		}
	}

	function defaultSettings()
	{
		//change setupProcess to finished
		location.reload();
	}

	function customSettings()
	{
		//change setupProcess to page2
		location.reload();
	}

</script>
<script src="stepsJavascript.js"></script>
<script src="../core/js/settingsAll.js"></script>
</html>