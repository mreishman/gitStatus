<?php

$versionCheckArray = array(
	'version'		=> '2.0.2',
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
		'1.5'		=> array(
			'branchName'	=> '1.5Update',
			'releaseNotes'  => '<ul><li>Features<ul><li>Adds links to loghog / monitor in sidebar</li><li>Moved loghog check into the gitbranch logic</li><li>Added option to select default view group</li></ul></li><li>Bug Fixes<ul><li>Fixed issue with updating on home page (fixed refresh loop on some machines)</li><li>Fixed issue with updating on update page (same as above note)</li><li>Added delay check to saving the config file</li><li>Style changes to sidebar</li><li>Popup for duplicate names in watch list</li></ul></li></ul>'
		),
		'1.5.1'		=> array(
			'branchName'	=> '1.5.1Update',
			'releaseNotes'  => '<ul><li>Bug Fixes<ul><li>Changed cache storage method</li><li>More detailed error info</li><li>Fixed bugs with connect test dissapearing when adding / removing items from watch list</li></ul></li></ul>'
		),
		'1.5.3'		=> array(
			'branchName'	=> '1.5.3Update',
			'releaseNotes'  => '<ul><li>Bug Fixes<ul><li>Fix with error display from poll request</li></ul></li></ul>'
		),
		'2.0'		=> array(
			'branchName'	=> '2.0Update',
			'releaseNotes'  => '<ul><li>Features<ul><li>Changed poll method (for server / node setup)</li><li>Added second watchlist (first is a list of servers, second is a list of watch folders)</li><li>Option to change between github to gitlab</li></ul></li><li>Bug Fixes<ul><li>Changed pause to clear timer</li><li>New groups added on first load</li></ul></li></ul>'
		),
		'2.0.1'		=> array(
			'branchName'	=> '2.0.1Update',
			'releaseNotes'  => '<ul><li>Bug Fixes<ul><li>Fixed issue with poll logic and external servers</li><li>Fixed issue with saving on watchlist / watchlist server (for dropdown menu values)</li><li>Fixed setup bug with welcome page not redirecting correctly</li><li>Fixed issue with Dev Box Color Settings display not showing up correctly sometimes</li><li>Fixed issue with title links not correclty showing up for poll type 2</li><li>Fixed issue with block setting and poll type 2 requests for external servers</li></ul></li></ul>'
		),
		'2.0.2'		=> array(
			'branchName'	=> '2.0.2Update',
			'releaseNotes'  => '<ul><li>Bug Fixes<ul><li>Actually fixed issue with names not linking correctly when cached</li></ul></li></ul>'
		),
	)
);
?>
