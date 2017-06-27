<?php

$defaultConfig = array(
	'sliceSize'		=> 500,
	'pollingRate'	=> 1,
	'pausePoll'		=> 'false',
	'pauseOnNotFocus' => 'true',
	'autoCheckUpdate' => 'true',
	'developmentTabEnabled' => 'false',
	'enableDevBranchDownload' => 'false',
	'enableSystemPrefShellOrPhp'	=> 'false',
	'expSettingsAvail'	=> 'true',
	'defaultViewBranch'	=> 'Standard',
	'defaultViewBranchCookie'	=> 'false',
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
	'watchList' => array(
			'Example Server' => array('WebsiteBase' =>  'website.com','Folder' =>  '/var/www/html/','Website' =>  'website.com','githubRepo' => 'githubRepo', 'groupInfo'=> 'Group')
			)
);