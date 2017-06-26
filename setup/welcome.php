<?php
$baseUrl = "../core/";
if(file_exists('../local/layout.php'))
{
	$baseUrl = "../local/";
	//there is custom information, use this
	require_once('../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
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
	<table style="width: 100%;" ><tr><th><a class="mainLinkClass">Accept Default Settings</a></th><th><a class="mainLinkClass">Customize Settings (advised)</a></th></tr></table>
	<br>
	<br>
</div>
</body>
</html>