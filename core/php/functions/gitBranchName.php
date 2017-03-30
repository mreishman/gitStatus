<?php header('Access-Control-Allow-Origin: *'); 
$function = "git --git-dir=".$_POST['location'].".git rev-parse --abbrev-ref HEAD";
$branchName = trim(shell_exec($function));
$keyNoSpace = preg_replace('/\s+/', '_', $_POST['name']);
$date = date('j m Y');
$time = date('H:i:s');
$response = array(
	'branch' 	=> $branchName,
	'idName'	=> $keyNoSpace,
	'date'		=> $date,
	'time'		=> $time
 );
echo json_encode($response);
?>