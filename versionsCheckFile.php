<?php

$versionCheckArray = array(
	'version'		=> '4.1.1',
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
		'3.0'		=> array(
			'branchName'	=> '3.0Update',
			'releaseNotes'  => '<ul><li>Features<ul><li>Added expanded tab for commit history of current branch</li><li>Log-Hog and other apps installed on server will be displayed in an iframe on sidebar</li></ul></li></ul>'
		),
		'3.1'		=> array(
			'branchName'	=> '3.1Update',
			'releaseNotes'  => '<ul><li>Features<ul><li>Added info page to sidebar</li><li>Added background refresh rate (polls less frequently if in background)</li><li>Added different cache options (only save or only read)</li></ul></li></ul>'
		),
		'3.1.1'		=> array(
			'branchName'	=> '3.1.1Update',
			'releaseNotes'  => '<ul><li>Bug Fixes<ul><li>Added better error check for git diff ajax call</li><li>Added git fetch command before check for difference</li><li>Fixed bug with switching sites not correctly upading commit tab</li></ul></li></ul>'
		),
		'3.1.2'		=> array(
			'branchName'	=> '3.1.2Update',
			'releaseNotes'  => '<ul><li>Bug Fixes<ul><li>Fixed bug with get branchname logic for branches not in cache</li></ul></li></ul>'
		),
		'3.2'		=> array(
			'branchName'	=> '3.2Update',
			'releaseNotes'  => '<ul><li>Features<ul><li>Added show more button on commit history</li><li>Added archive button to tmporarly disable watch list or server watch list entries</li><li>Added history feature (shows branch history in info panel)</li></ul></li><li>Bug Fixes<ul><li>Fixed bug with commit display with very long lines breaking styles</li><li>Fixed bug with git diff not working with branches that do not have links</li></ul></li></ul>'
		),
		'3.2.1'		=> array(
			'branchName'	=> '3.2.1Update',
			'releaseNotes'  => '<ul><li>Bug Fixes<ul><li>Fixed bug with new git branch logic</li></ul></li></ul>'
		),
		'3.2.2'		=> array(
			'branchName'	=> '3.2.2Update',
			'releaseNotes'  => '<ul><li>Bug Fixes<ul><li>Fixed bug with git diff logic not loading for master branch</li><li>Fixed styling to make individual loading spinners uniform with other elements</li><li>Added refresh button to info page</li><li>Fixed bug with pause poll from initial load not working exactly as specified</li><li>Added poll check for version update / refresh if version changed.</li><li>Fixed bug with groups showing up if only one group present</li><li>Clicking on links open in new tab (for branch name / website url / issue link)</li></ul></li></ul>'
		),
		'3.2.3'		=> array(
			'branchName'	=> '3.2.3Update',
			'releaseNotes'  => '<ul><li>Bug Fixes<ul><li>Fixed bug with version check poll not starting again after pause</li><li>Fixed styles on header with version number</li><li>Updated styles on about / settings / update page to show more information at some resolutions without scrolling</li><li>Updated styles on watchlist pages to show more information without scrolling</li><li>Added version check to cache save (make sure local version is same as server version)</li></ul></li></ul>'
		),
		'3.2.4'		=> array(
			'branchName'	=> '3.2.4Update',
			'releaseNotes'  => '<ul><li>Features<ul><li>Added links to branch name history (if linked to repo)</li></ul></li><li>Bug Fixes<ul><li>Fixed bug with saving new colors in dev box color settings</li><li>Fixed update bug with versions greater than 10 (inclding x.10, x.x.10, etc)</li></ul></li></ul>'
		),
		'3.3'		=> array(
			'branchName'	=> '3.3Update',
			'releaseNotes'  => '<ul><li>Features<ul><li>Added back submenu (with links to external stuff)</li><li>Added pinned containers (when going between groups, keep some pinned containers view)</li><li>Highlights updated branches (fades after a few seconds)</li></ul></li><li>Bug Fixes<ul><li>Fixed bug with loading spinner not showing up correctly for viewing commits</li><li>Changed default poll type to 2</li></ul></li></ul>'
		),
		'3.3.1'		=> array(
			'branchName'	=> '3.3.1Update',
			'releaseNotes'  => '<ul><li>Features<ul><li>Moved sidebar click to icon instead of just clicking on title bar (easier to click, less misclicks)</li></ul></li><li>Bug Fixes<ul><li>Poll logic now updates server watchlist before poll</li><li>Poll logic respects archvie if changed since initial load</li><li>Poll logic better manages changes in watchlist</li><li>Poll logic now gets version status each request</li></ul></li></ul>'
		),
		'3.3.1.1'		=> array(
			'branchName'	=> '3.3.1.1Update',
			'releaseNotes'  => '<ul><li>Bug Fixes<ul><li>Fixed bug with new poll logic (if less than one server is not marked as archive)</li></ul></li></ul>'
		),
		'3.3.2'		=> array(
			'branchName'	=> '3.3.2Update',
			'releaseNotes'  => '<ul><li>Bug Fixes<ul><li>Now clears cache on watchlist save / watchlist server save</li><li>Fixed display issue with loading spinner on commits after commits finished loading</li><li>New groups should be added on success of new poll requests if any groups are new</li><li>Groups now are removed on end of poll request if not needed anymore</li></ul></li></ul>'
		),
		'3.3.3'		=> array(
			'branchName'	=> '3.3.3Update',
			'releaseNotes'  => '<ul><li>Bug Fixes<ul><li>Fixed default group dropdown for poll type 2</li></ul></li></ul>'
		),
		'3.3.4'		=> array(
			'branchName'	=> '3.3.4Update',
			'releaseNotes'  => '<ul><li>Features<ul><li>Added third option for pause poll (only pause after initial load)</li></ul></li><li>Bug Fixes<ul><li>Fixed js bug on index page with entries where no group was set</li><li>Fixed issue with poll type 1 not loading correct information on page load</li><li>Fixed issue with pause poll on load not working correctly</li><li>Fixed small bug where watchlist data would not properly show up if cacheEnabled was set to readOnly</li></ul></li></ul>'
		),
		'3.4'		=> array(
			'branchName'	=> '3.4Update',
			'releaseNotes'  => '<ul><li>Features<ul><li>Added button to toggle expanded view for individual watchlist items</li><li>Added option to specify branches to show diff of (default or per site configuration)</li></ul></li><li>Bug Fixes<ul><li>Poll Type 1 Bug Fixes<ul><li>Fixed bug with cache object remove on server ping error</li><li>Hides watchlist server tab if poll type is 1</li></ul></li><li>Added checks for server display before remove on error</li><li>Seperated settings into blocks on settings page</li><li>Fixed names in watchlist for input fields</li><li>Fixed issue when adding new servers where archvie was a text field and not a button</li><li>Fixed bug with archive filter on initial poll request</li><li>Fixed bug with not hiding old results when switching between server Git-Diff info tables</li></ul></li></ul>'
		),
		'3.4.1'		=> array(
			'branchName'	=> '3.4.1Update',
			'releaseNotes'  => '<ul><li>Features<ul><li>Added extra verification to git requests (commit, commit history, branch diff) for poll type version 2</li></ul></li><li>Bug Fixes<ul><li>Fixed style issue with git diff in info tab</li><li>Added missing info to sidebar panel<ul><li>Added missing current branch in branch history section of info tab</li><li>Node name now shows up in info section of info tab</li></ul></li><li>Fixed date issue in commit history tab</li><li>Added poll type 1 block to all git requests (commit, commit history, branch diff)</li></ul></li></ul>'
		),
		'3.4.1.1'		=> array(
			'branchName'	=> '3.4.1.1Update',
			'releaseNotes'  => '<ul><li>Bug Fixes<ul><li>Fixed setup bug</li><li>Fixed bug with cache status missing on initial load causing errors</li><li>Fixed bug with default values in config for archive</li><li>Fixed js bug on pages about href for windows</li></ul></li></ul>'
		),
		'3.4.2'		=> array(
			'branchName'	=> '3.4.2Update',
			'releaseNotes'  => '<ul><li>Features<ul><li>Added back individual refresh for poll type 2</li><li>Advanced<ul><li>Added option to block specific requests</li></ul></li></ul></li></ul>'
		),
		'3.4.3'		=> array(
			'branchName'	=> '3.4.3Update',
			'releaseNotes'  => '<ul><li>Features<ul><li>Added option for custom git url</li><li>Buttons to move watchlist blocks up / down</li></ul></li><li>Bug Fixes<ul><li>Fixed issue with errors not displaying correctly when poll fails</li><li>Changed archive to dropdown from button</li><li>Fixed bug where adding a new server / removing a server would show dropdown inputs as text field inputs</li><li>Added consecutive save verify check on saves</li></ul></li></ul>'
		),
		'4.0'		=> array(
			'branchName'	=> '4.0Update',
			'releaseNotes'  => '<ul><li>Features<ul><li>New theme! (Lots of style changes)</li></ul></li><li>Bug Fixes<ul><li>Cleaned up look of settings pages making some settings easier to understand</li><li>Info panel in popup sidebar now easier to read at lower resolution</li><li>LED indicator switches to yellow when unsure of status</li></ul></li></ul>'
		),
		'4.1'		=> array(
			'branchName'	=> '4.1Update',
			'releaseNotes'  => '<ul><li>Features<ul><li>Grouped Groups! (Ctrl / Command click to view more than one group)</li><li>Added a minimized display type (Same as standard prior to 4.1, Standard now shows last update info)</li></ul></li><li>Bug Fixes<ul><li>Expand menu dropdown near bottom of screen now changes directions on first click</li><li>Expand menu dropdown follows scroll of window</li></ul></li></ul>'
		),
		'4.1.1'		=> array(
			'branchName'	=> '4.1.1Update',
			'releaseNotes'  => '<ul><li>Features<ul><li>Added option to select default open tab in expanded info window</li></ul></li><li>Bug Fixes<ul><li>Font style change for updater</li><li>Created tabs for watchlist settings, more servers are now visible on one screen</li></ul></li></ul>'
		),
	)
);
?>
