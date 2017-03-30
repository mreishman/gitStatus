<?php header('Access-Control-Allow-Origin: *'); 
$function = "git --git-dir=".$_POST['location'].".git rev-parse --abbrev-ref HEAD";
$branchName = trim(shell_exec($function));
$keyNoSpace = preg_replace('/\s+/', '_', $_POST['name']);
$function = "git --git-dir=".$_POST['location'].".git log --stat -1 --pretty=\"<b>Author Name:</b> %an, <b>Author Date:</b> %ad, <b>Committer Name:</b> %cn, <b>Committer Date:</b> %cd, <b>Commit:</b> %s}\"";
$branchStats = trim(shell_exec($function));
$branchStats = substr($branchStats, 0, strpos($branchStats, "}"));
$date = date('j m Y');
$time = date('H:i:s');
$response = array(
	'branch' 	=> $branchName,
	'idName'	=> $keyNoSpace,
	'date'		=> $date,
	'time'		=> $time,
	'stats'		=> $branchStats
 );
echo json_encode($response);
?>