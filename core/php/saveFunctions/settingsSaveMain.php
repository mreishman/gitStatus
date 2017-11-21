<?php

$baseUrl = "../../../core/";
if(file_exists('../../../local/layout.php'))
{
	$baseUrl = "../../../local/";
	//there is custom information, use this
	require_once('../../../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
if(file_exists($baseUrl.'conf/config.php'))
{
	require_once($baseUrl.'conf/config.php');
}
else
{
	$config = array();
}
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
			'defaultGroupViewOnLoad'	=> '".$defaultGroupViewOnLoad."',
			".$arrayFilterAll."
			'watchList' => array(
			".$arrayWatchList.")
		);
	?>";

	file_put_contents($fileName, $newInfoForConfig);

require_once("../../../setup/setupProcessFile.php");

if($setupProcess == "finished" || $setupProcess == "preStart")
{
	echo json_encode(true);
}
else
{
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit();
}
?>