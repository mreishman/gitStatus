<?php

$defaultConfig = array(
	'sliceSize'		=> 500,
	'pollingRate'	=> 1,
	'pausePoll'		=> 'false',
	'pauseOnNotFocus' => 'true',
	'pollType'		=> 1,
	'disablePostRequestWithPostData'	=> 'false',	
	'autoCheckUpdate' => 'true',
	'developmentTabEnabled' => 'false',
	'enableDevBranchDownload' => 'false',
	'enableSystemPrefShellOrPhp'	=> 'false',
	'expSettingsAvail'	=> 'true',
	'defaultViewBranch'	=> 'Standard',
	'cacheEnabled'		=> 'true',
	'dontNotifyVersion'	=> '0',
	'onlyRefreshVisible'	=> 'true',
	'defaultViewBranchCookie'	=> 'false',
	'loginAuthType'	=> 'disabled',
	'errorAndColorArray'	=> array(
		'error'	=> array(
			'color'	=> 'C33',
			'type'	=> 'default'
			),
		'master'	=> array(
			'color'	=> '32CD32',
			'type'	=> 'default'
			),
		'revert-'	=> array(
			'color'	=> 'EE7600',
			'type'	=> 'includes'
			)
		),
	'errorAndColorAuthorArray'	=> array(
		'error'	=> array(
			'color'	=> 'C33',
			'type'	=> 'default'
			),
		'dave'	=> array(
			'color'	=> '32CD32',
			'type'	=> 'default'
			),
		'matt'	=> array(
			'color'	=> 'EE7600',
			'type'	=> 'includes'
			)
		),
	'errorAndColorComitteeArray'	=> array(
		'error'	=> array(
			'color'	=> 'C33',
			'type'	=> 'default'
			),
		'dave'	=> array(
			'color'	=> '32CD32',
			'type'	=> 'default'
			),
		'matt'	=> array(
			'color'	=> 'EE7600',
			'type'	=> 'includes'
			)
		),
	'branchColorFilter'	=> 'branchName',
	'checkForIssueInBranchNameFilters'	=> array(
				'Issue','issue','Issue_','issue_','Issue-','issue-','revert-'
				),
	'checkForIssueStartsWithNum'	=> 'true',
	'checkForIssueEndsWithNum'	=> 'true',
	'checkForIssueCustom'	=> 'true',
	'checkForIssueInCommit'	=> 'true',
	'branchColorFilter'	=> 'branchColorFilter',
	'messageTextEnabled'	=> 'false',
	'messageText' => 'Example Message',
	'enableBlockUntilDate'	=> 'false',
	'defaultGroupViewOnLoad'	=> 'All',
	'datePicker'	=> '07/04/2017',
	'watchList' => array(
			'Example Server' => array('WebsiteBase' =>  'website.com','urlHit' => 'location of file if not default')
			),
	'serverWatchList' => array(
			'Example Server' => array('WebsiteBase' =>  'website.com','Folder' =>  '/var/www/html/', 'Website' =>  'website.com','githubRepo' => 'githubRepo', 'groupInfo'=> 'Group', 'urlHit' => 'location of file if not default', "type" => "local", "gitType" => "github")
			)
);