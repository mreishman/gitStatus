<?php

$defaultConfig = array(
	'sliceSize'		=> 500,
	'pollingRate'	=> 500,
	'pausePoll'		=> 'false',
	'pauseOnNotFocus' => 'true',
	'autoCheckUpdate' => 'true',
	'developmentTabEnabled' => 'false',
	'enableDevBranchDownload' => 'false',
	'enableSystemPrefShellOrPhp'	=> 'false',
	'expSettingsAvail'	=> 'true',
	'defaultViewBranch'	=> 'Standard',
	'defaultViewBranchCookie'	=> 'false',
	'checkForIssueInBranchNameFilters'	=> array(
				'Issue','issue','Issue_','issue_','Issue-','issue-','revert-'
				),
	'checkForIssueStartsWithNum'	=> 'true',
	'checkForIssueEndsWithNum'	=> 'true',
	'checkForIssueCustom'	=> 'true',
	'checkForIssueInCommit'	=> 'true',
);