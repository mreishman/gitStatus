<?php
//echo json_encode();
$function = "git --git-dir=".$_POST['location'].".git rev-parse --abbrev-ref HEAD";
$branchName = trim(shell_exec($function));
$keyNoSpace = preg_replace('/\s+/', '_', $_POST['name']);
$response = array(
	'branch' 	=> $branchName,
	'idName'	=> $keyNoSpace,
 );

$date = date('j m Y');
$time = date('H:i:s');

echo json_encode($response);
?>