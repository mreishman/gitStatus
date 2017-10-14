<?php header('Access-Control-Allow-Origin: *'); 

$disablePostRequestWithPostData = false;

if((isset($_POST['location']) && isset($_POST['name']) && isset($_POST['websiteBase'])) && !$disablePostRequestWithPostData)
{
	//old version!!!! (prior to 1.6)

	$postLocation = $_POST['location'];
	$postName = $_POST['name'];
	$postWebsiteBase = $_POST['websiteBase'];

	if((strlen(escapeshellarg($postLocation)) < 500) && (strlen(escapeshellarg($postName)) < 500) && (strlen(escapeshellarg($postWebsiteBase)) < 500))
	{
		require_once('../loadVars.php');
		$function = "git --git-dir=".escapeshellarg($postLocation).".git rev-parse --abbrev-ref HEAD";
		$branchName = trim(shell_exec($function));
		$keyNoSpace = preg_replace('/\s+/', '_', $postName );
		$function = "git --git-dir=".escapeshellarg($postLocation).".git log --stat -1 --pretty=\"<b>Author Name:</b> %an, <b>Author Date:</b> %ad, <b>Committer Name:</b> %cn, <b>Committer Date:</b> %cd, <b>Commit:</b> %s}\"";
		$branchStats = trim(shell_exec($function));
		$branchStats = substr($branchStats, 0, strpos($branchStats, "}"));
		$date = date('j m Y');
		$time = trim(shell_exec('date'));;
		$loghog = "";
		if(is_dir("../../../../Log-Hog"))
		{
			$loghog = $postWebsiteBase."/Log-Hog";
		}
		elseif(is_dir("../../../../loghog"))
		{
			$loghog = $postWebsiteBase."/loghog";
		}
		$monitor = "";
		if(is_dir("../../../../monitor"))
		{
			$monitor = $postWebsiteBase."/monitor";
		}
		elseif(is_dir("../../../../Log-Hog/top"))
		{
			$monitor = $postWebsiteBase."/Log-Hog/top";
		}
		elseif(is_dir("../../../../loghog/top"))
		{
			$monitor = $postWebsiteBase."/loghog/top";
		}
		elseif(is_dir("../../../../Log-Hog/monitor"))
		{
			$monitor = $postWebsiteBase."/Log-Hog/monitor";
		}
		elseif(is_dir("../../../../loghog/monitor"))
		{
			$monitor = $postWebsiteBase."/loghog/monitor";
		}
		$search = "";
		if(is_dir("../../../../search"))
		{
			$search = $postWebsiteBase."/search";
		}
		elseif(is_dir("../../../../Log-Hog/search"))
		{
			$search = $postWebsiteBase."/Log-Hog/search";
		}
		elseif(is_dir("../../../../loghog/search"))
		{
			$search = $postWebsiteBase."/loghog/search";
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
}
else
{
	//new version (1.6 or greater) or just checking
	$response = array(
			'isHere' => true
		);

}
echo json_encode($response);
?>