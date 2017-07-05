<?php
$baseUrl = "../../../core/";
$fileName = ''.$baseUrl.'conf/cachedStatus.php';

$string = "";
foreach ($_POST['arrayOfdata'] as $key => $value) {
	$key = str_replace("'", "", $key);
	$string .= "'".$key."' => array(";
	foreach ($value as $key2) {
		$key2 = str_replace("'", "", $key2);
		$string .= "'".$key2."',";
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
?>