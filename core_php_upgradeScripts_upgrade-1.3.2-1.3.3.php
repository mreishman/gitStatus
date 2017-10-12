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
	$arrayWatchList = "";

	$numberOfRows = count($watchList);
	$i = 0;
	foreach ($watchList as $key => $value) 
	{
		$i++;
		$j = 0;
		$numberOfRows2 = count($value);
		$arrayWatchList .= "'".$key."' => array(";
		$githubRepoPresent = false;
		foreach ($value as $key2 => $value2)
		{
			if($key2 == "urlHit")
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
			$arrayWatchList .= ",'urlHit' =>  ''";
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
			'onlyRefreshVisible'	=> '".$onlyRefreshVisible."',
			'cacheEnabled'	=>	'".$cacheEnabled."',
			'defaultViewBranchCookie'	=> '".$defaultViewBranchCookie."',
			'checkForIssueStartsWithNum'	=> '".$checkForIssueStartsWithNum."',
			'checkForIssueEndsWithNum'	=> '".$checkForIssueEndsWithNum."',
			'checkForIssueCustom'	=> '".$checkForIssueCustom."',
			'checkForIssueInCommit' => '".$checkForIssueInCommit."',
			'branchColorFilter'	=> '".$branchColorFilter."',
			'messageTextEnabled'	=> '".$messageTextEnabled."',
			'messageText' => '".$messageText."',
			'enableBlockUntilDate'	=> '".$enableBlockUntilDate."',
			'datePicker'	=> '".$datePicker."',
			".$arrayFilterAll."
			'watchList' => array(
			".$arrayWatchList.")
		);
	?>";

	file_put_contents($fileName, $newInfoForConfig);

	//header('Location: https://' . $_SERVER['SERVER_NAME'] . '/status/update/updater.php');
	//exit();
?>