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
			'checkForIssueStartsWithNum'	=> '".$checkForIssueStartsWithNum."',
			'checkForIssueEndsWithNum'	=> '".$checkForIssueEndsWithNum."',
			'checkForIssueCustom'	=> '".$checkForIssueCustom."',
			'checkForIssueInCommit => '".$checkForIssueInCommit."',
			'watchList' => array(
			".$arrayWatchList.")
		);
	?>";

	file_put_contents($fileName, $newInfoForConfig);

	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit();
?>