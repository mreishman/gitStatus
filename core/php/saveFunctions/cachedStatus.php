<?php
$baseUrl = "../../../core/";
$fileName = ''.$baseUrl.'conf/cachedStatus.php';
$string = "";
$boolForSave = true;
require_once('../configStatic.php');
if((string)$_POST['currentVersion'] !== $configStatic["version"])
{
	echo "false";
	die();
}


if(isset($_POST['arrayOfdata']))
{
	$arrayOfdata = $_POST['arrayOfdata'];
}
elseif(isset($_POST['clearArray']))
{
	$arrayOfdata = array();
}
else
{
	$boolForSave = false;
}

if($boolForSave)
{
	foreach ($arrayOfdata as $key => $value)
	{
		$key = str_replace("'", "", $key);
		$string .= "'".$key."' => array(";
		foreach ($value as $value2 => $key2)
		{
			$key2 = str_replace("'", "", $key2);
			$string .= "'".$value2."' => '".$key2."',";
		}
		$string .= "),";
	}

	$newInfoForConfig = "
	<?php
		$"."cachedStatusMainObject = array(
			".$string."
		);
	?>";

	file_put_contents($fileName, $newInfoForConfig);

	echo "true";
	die();
}

echo "false";