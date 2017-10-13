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
	$loghog = "";
	if(is_dir("../../../../Log-Hog"))
	{
		$loghog = $_POST['websiteBase']."/Log-Hog";
	}
	elseif(is_dir("../../../../loghog"))
	{
		$loghog = $_POST['websiteBase']."/loghog";
	}
	$monitor = "";
	if(is_dir("../../../../monitor"))
	{
		$monitor = $_POST['websiteBase']."/monitor";
	}
	elseif(is_dir("../../../../Log-Hog/top"))
	{
		$monitor = $_POST['websiteBase']."/Log-Hog/top";
	}
	elseif(is_dir("../../../../loghog/top"))
	{
		$monitor = $_POST['websiteBase']."/loghog/top";
	}
	elseif(is_dir("../../../../Log-Hog/monitor"))
	{
		$monitor = $_POST['websiteBase']."/Log-Hog/monitor";
	}
	elseif(is_dir("../../../../loghog/monitor"))
	{
		$monitor = $_POST['websiteBase']."/loghog/monitor";
	}
	$search = "";
	if(is_dir("../../../../search"))
	{
		$search = $_POST['websiteBase']."/search";
	}
	elseif(is_dir("../../../../Log-Hog/search"))
	{
		$search = $_POST['websiteBase']."/Log-Hog/search";
	}
	elseif(is_dir("../../../../loghog/search"))
	{
		$search = $_POST['websiteBase']."/loghog/search";
	}
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
		'loghog'		=> $loghog,
		'monitor'		=> $monitor,
		'search'		=> $search,
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