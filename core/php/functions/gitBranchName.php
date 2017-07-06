<?php header('Access-Control-Allow-Origin: *'); 
if(strlen(escapeshellarg($_POST['location'])) < 500)
{
	require_once('../loadVars.php');
	$function = "git --git-dir=".escapeshellarg($_POST['location']).".git rev-parse --abbrev-ref HEAD";
	$branchName = trim(shell_exec($function));
	$keyNoSpace = preg_replace('/\s+/', '_', $_POST['name']);
	$function = "git --git-dir=".escapeshellarg($_POST['location']).".git log --stat -1 --pretty=\"<b>Author Name:</b> %an, <b>Author Date:</b> %ad, <b>Committer Name:</b> %cn, <b>Committer Date:</b> %cd, <b>Commit:</b> %s}\"";
	$branchStats = trim(shell_exec($function));
	$branchStats = substr($branchStats, 0, strpos($branchStats, "}"));
	$date = date('j m Y');
	$time = trim(shell_exec('date'));;
	$response = array(
		'branch' 	=> $branchName,
		'idName'	=> $keyNoSpace,
		'date'		=> $date,
		'time'		=> $time,
		'stats'		=> $branchStats,
		'messageTextEnabled'	=> $messageTextEnabled,
		'messageText' => $messageText,
		'enableBlockUntilDate'	=> $enableBlockUntilDate,
		'datePicker'	=> $datePicker,
		'otherFunctions'	=> ''
	);
}
else
{
	$response = array(
	'branch' 	=> 'Location var is too long.',
	'otherFunctions'	=> ''
 );
}
echo json_encode($response);
?>