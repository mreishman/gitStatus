<?php

$config = array(
	'sliceSize'		=> 500,
	'pollingRate'	=> 500,
	'pausePoll'		=> 'false',
	'pauseOnNotFocus' => 'true',
	'autoCheckUpdate' => 'true',
	'developmentTabEnabled' => 'false',
	'enableDevBranchDownload' => 'false',
	'enableSystemPrefShellOrPhp'	=> 'false',
	'expSettingsAvail'	=> 'true',
	'watchList'		=> array(
		'mreishmandev'		=> array(
		'mreishmandev.lan.goedekers.com'	        => '/var/www/html/'
	),
		'mreishmanBlog'		=> array(
		'mreishmandev.lan.goedekers.com'	        => '/var/www/html/blog/'
	)
	)
);