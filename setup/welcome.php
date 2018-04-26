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


require_once('setupProcessFile.php');
if(file_exists($baseUrl.'conf/config.php'))
{
	if($setupProcess != "preStart")
	{
		$partOfUrl = clean_url($_SERVER['REQUEST_URI']);
		$partOfUrl = substr($partOfUrl, 0, strpos($partOfUrl, 'setup'));
		$url = "http://" . $_SERVER['HTTP_HOST'] .$partOfUrl ."setup/director.php";
		header('Location: ' . $url, true, 302);
		exit();
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome!</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<script src="../core/js/jquery.js"></script>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
</head>
<body>
<?php readfile('../core/html/popup.html') ?>	
<div class="firstBoxDev" style="width: 90%; margin: auto; margin-right: auto; margin-left: auto; display: block; height: auto; margin-top: 15px;" >
	<div class="devBoxTitle">
		<h1>Thank you for downloading gitStatus.</h1>
	</div>
	
	<p style="min-height: 200px; padding: 10px;">Please follow these steps to complete the setup process or click default to accept default settings.</p>
	<table style="width: 100%; padding-left: 20px; padding-right: 20px;" ><tr><th style="text-align: left;"><a onclick="updateStatus('finished');" class="mainLinkClass">Accept Default Settings</a></th><th style="text-align: right;" ><a onclick="updateStatus('step1');" class="mainLinkClass">Customize Settings (advised)</a></th></tr></table>
	<br>
	<br>
</div>
</body>
<form id="defaultVarsForm"></form>
<script type="text/javascript">
	function defaultSettings()
	{
		//change setupProcess to finished
		saveAndVerifyMain("defaultVarsForm");
	}

	function customSettings()
	{
		//change setupProcess to page1
		saveAndVerifyMain("defaultVarsForm");
	}
</script>
<script src="stepsJavascript.js"></script>
</html>