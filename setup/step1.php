<?php
$baseUrl = "../core/";
if(file_exists('../local/layout.php'))
{
	$baseUrl = "../local/";
	//there is custom information, use this
	require_once('../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php'); 
require_once('setupProcessFile.php');

if($setupProcess != "step1")
{
	$url = "http://" . $_SERVER['HTTP_HOST'] . "/status/setup/director.php";
	header('Location: ' . $url, true, 301);
	exit();
}
$counterSteps = 1;
while(file_exists('step'.$counterSteps.'.php'))
{
	$counterSteps++;
}
$counterSteps--;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome!</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<script src="../core/js/jquery.js"></script>
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
<div class="firstBoxDev" style="width: 90%; margin: auto; margin-right: auto; margin-left: auto; display: block; height: auto; margin-top: 15px;" >
	<div class="devBoxTitle">
		<h1>Step 1 of <?php echo $counterSteps; ?></h1>
	</div>
	<p style="padding: 10px;">Watch List: These are the other servers you would like to keep track of. Please enter some in the fields below:</p>
	<div style="border: 1px solid white; margin-bottom:10px; background-color: #888">
		<?php require_once('../core/php/templateFiles/watchList.php'); ?>
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
	function defaultSettings()
	{
		//change setupProcess to finished
		location.reload();
	}

	function customSettings()
	{
		//change setupProcess to page2
		document.getElementById('settingsMainWatch').submit();
	}
	function updateStatus(status)
	{
		var urlForSend = './updateSetupStatus.php?format=json'
		var data = {status: status };
		$.ajax({
				  url: urlForSend,
				  dataType: 'json',
				  data: data,
				  type: 'POST',
		success: function(data)
		{
			if(status == "finished")
			{
				defaultSettings();
			}
			else
			{
				customSettings();
			}
	  	},
			});
		return false;
	}

	var countOfWatchList = <?php echo $i; ?>;
var countOfAddedFiles = 0;
var countOfClicks = 0;
var locationInsert = "newRowLocationForWatchList";
var numberOfSubRows = <?php echo $numCount; ?>;
var arrayOfKeysJsonEncoded = '<?php echo json_encode($arrayOfKeys); ?>';
var arrayOfKeysNonEnc = JSON.parse(arrayOfKeysJsonEncoded);


</script>
<script src="../core/js/watchlist.js"></script>
</html>