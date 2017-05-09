<?php

$baseUrl = "../../../core/";
if(file_exists('../../../local/layout.php'))
{
	$baseUrl = "../../../local/";
	//there is custom information, use this
	require_once('../../../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}

require_once($baseUrl.'conf/config.php');
require_once('../../../core/conf/config.php'); 
require_once('../loadVars.php');

	$fileName = ''.$baseUrl.'conf/config.php';


	$numberOfRows = count($watchList);
	$i = 0;
	foreach ($watchList as $key => $value) 
	{
		$i++;
		$j = 0;
		$numberOfRows2 = count($value);
		$arrayWatchList .= "'".$key."' => array(";
		$githubRepoPresent = false;
		foreach ($value as $key2 => $value2) {

			//
			if($key2 = "githubRepo")
			{
				$githubRepoPresent = true;
			}

			$j++;
			$arrayWatchList .= "'".$key2."' =>  '".$value2."'";
			if($j != $numberOfRows2)
			{
				$arrayWatchList .= ",";
			}
		}
		if(!$githubRepoPresent)
		{
			$arrayWatchList .= ",'githubRepo' =>  ''";
		}
		$arrayWatchList .= ")";
		if($i != $numberOfRows)
		{
			$arrayWatchList .= ",";
		}
	}



	$newInfoForConfig = "
	<?php
		$"."config = array(
			'sliceSize' => ".$sliceSize.",
			'pollingRate' => ".$pollingRate.",
			'pausePoll' => '".$pausePoll."',
			'pauseOnNotFocus' => '".$pauseOnNotFocus."',
			'autoCheckUpdate' => '".$autoCheckUpdate."',
			'developmentTabEnabled' => '".$developmentTabEnabled."',
			'enableDevBranchDownload' => '".$enableDevBranchDownload."',
			'defaultViewBranch'	=> '".$defaultViewBranch."',
			'defaultViewBranchCookie'	=> '".$defaultViewBranchCookie."',
			'watchList' => array(
			".$arrayWatchList.")
		);
	?>";

	file_put_contents($fileName, $newInfoForConfig);

	header('Location: ' . $_SERVER['SERVER_NAME'] . 'status/update/updater.php');
	exit();
?>