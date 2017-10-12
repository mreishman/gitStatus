<?php

$versionCheckArray = array(
	'version'		=> '1.4.3',
	'versionList'		=> array(
		'1.0'	        => array(
			'branchName'	=> '1.0Update',
			'releaseNotes'	=> '<ul><li>Bug Fixes<ul><li>Adds check for header redirect</li><li>Fixed Unpause - on focus (if default paused) Bug</li><li>Adds remove directory / watch folder button</li></ul></li></ul>'
		),
		'1.1'		=> array(
			'branchName'	=> '1.1Update',
			'releaseNotes'  => '<ul><li>Features<ul><li>Added link to log-hog on watch servers (if installed)</li><li>Changes BG color of servers on master branch. </li><li>Auto-refresh / Pause auto refresh</li><li>Title for website is now a link to the website (www.website.com) - HTTPS:// is added by default</li><li>Re-adds ability to download dev branches</li></ul></li><li>Bug Fixes<ul><li>Fixed server add bug (non saved folders being removed when adding new server to watchlist)</li><li>Added error logic to ajax request</li><li>Opening and closing menu adjust width correctly</li><li>Navbar is fixed at top (does not scroll)</li></ul></ul>'
		),
		'1.2'		=> array(
			'branchName'	=> '1.2Update',
			'releaseNotes'  => '<ul><li>Features<ul><li>Looks for issue number in commit message (#____)</li><li>Adds link to branch name on branch</li><li>Links website name to name</li><li>Looks for issue number in branch name</li></ul></li><li>Bug Fixes<ul><li>Fixed update for gif files</li><li>Checks for a comma before splitting data. Fixes random breaks in commit messages that include commas.</li><li>Adds on hover css to menubar</li></ul></li></ul>'
		),
		'1.3'		=> array(
			'branchName'	=> '1.3Update',
			'releaseNotes'  => '<ul><li>Features<ul><li>New settings page for watch list / main settings.</li><li>Tabbed groups for servers</li><li>Back to top button when scrolled down on page</li><li>Added loading popup for some pages</li><li>Customize the color of branches by either<ul><li>Branch Name</li><li>Author Name</li><li>Comittee Name</li></ul></li><li>General Style Changes</li></ul></li></ul>'
		),
		'1.4'		=> array(
			'branchName'	=> '1.4Update',
			'releaseNotes'  => '<ul><li>Features<ul><li>Cached server info - saves a version for offline / errors</li><li>Adds ability to add custom text for servers in the overview</li><li>Adds ability to block requests to a server untill x date</li><li>Added setup on first launch</li></ul></li><li>Bug Fixes<ul><li>Adjusts position of dropdown menu when near edges of screen</li><li>Fixed issue where only the first -revert was tagged</li><li>Adjustments to the look of buttons.</li></ul></li></ul>'
		),
		'1.4.1'		=> array(
			'branchName'	=> '1.4.1Update',
			'releaseNotes'  => '<ul><li>Fixes issues with cache saving</li><li>Fixed bug with errors on checking branch info from remove servers</li><li>Bug fixes for setup process</li><li>Bug fixes for update process</li></ul>'
		),
		'1.4.2'		=> array(
			'branchName'	=> '1.4.2Update',
			'releaseNotes'  => '<ul><li>Added button to reset cache (if needed, under advanced)</li><li>Added button to enable / disable cache</li><li>Fixed update bug with version numbers and changelog</li></ul>'
		),
		'1.4.3'		=> array(
			'branchName'	=> '1.4.3Update',
			'releaseNotes'  => '<ul><li>Features<ul><li>Updated updater</li><li>Option (default true) to only refresh visible tabs</li><li>Added custom options for post urls</li></ul></li><li>Bug Fixes<ul><li>Fixed issue with cache clear popup verify cleared</li><li>Fixed some bugs with displaying cache information</li></ul></li></ul>'
		),
	)
);
?>
