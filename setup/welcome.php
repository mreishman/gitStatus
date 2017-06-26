<?php
$baseUrl = "../core/";
if(file_exists('../local/layout.php'))
{
	$baseUrl = "../local/";
	//there is custom information, use this
	require_once('../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}

require_once('setupProcessFile.php');

if($setupProcess != "preStart")
{
	$url = "http://" . $_SERVER['HTTP_HOST'] . "/status/setup/director.php";
	header('Location: ' . $url, true, 301);
	exit();
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome!</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
</head>
<body>
<div class="firstBoxDev" style="width: 90%; margin: auto; margin-right: auto; margin-left: auto; display: block; height: auto; margin-top: 15px;" >
	<div class="devBoxTitle">
		<h1>Thank you for downloading gitStatus.</h1>
	</div>
	
	<p style="min-height: 200px; padding: 10px;">Please follow these steps to complete the setup process or click default to accept default settings.</p>
	<table style="width: 100%;" ><tr><th><a onclick="defaultSettings();" class="mainLinkClass">Accept Default Settings</a></th><th><a class="mainLinkClass">Customize Settings (advised)</a></th></tr></table>
	<br>
	<br>
</div>
</body>
<form id="defaultVarsForm" action="../core/php/saveFunctions/settingsSaveMain.php" method="post"></form>
<script type="text/javascript">
	function defaultSettings()
	{
		//change setupProcess to finished
		document.getElementById('defaultVarsForm').submit();
	}

	function customSettings()
	{
		//change setupProcess to page1
		document.getElementById('defaultVarsForm').submit();
	}
</script>
</html>