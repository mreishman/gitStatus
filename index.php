<?php
require_once("core/php/functions/commonFunctions.php");
require_once("core/php/functions/indexFunctions.php");
$baseUrl = "core/";
if(file_exists('local/layout.php'))
{
	$baseUrl = "local/";
	//there is custom information, use this
	require_once('local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}

if(!file_exists($baseUrl.'conf/config.php'))
{
	$partOfUrl = clean_url($_SERVER['REQUEST_URI']);
	if(strpos($partOfUrl, 'index'))
	{
		$partOfUrl = substr($partOfUrl, 0, strpos($partOfUrl, 'index'));
	}
	$url = "http://" . $_SERVER['HTTP_HOST'] .$partOfUrl ."setup/welcome.php";
	header('Location: ' . $url, true, 302);
	exit();
}
require_once($baseUrl.'conf/config.php');
require_once('core/conf/config.php');
require_once('core/php/configStatic.php');
if(file_exists('core/conf/cachedStatus.php'))
{
	require_once('core/conf/cachedStatus.php');
}
require_once('core/php/update/updateCheck.php');
require_once('core/php/loadVars.php');

if($defaultViewBranchCookie == 'true')
{
	if(isset($_COOKIE['defaultViewBranchCookie']))
	{
		$defaultViewBranch = $_COOKIE['defaultViewBranchCookie'];
	}
}
else
{
	if(isset($_COOKIE['defaultViewBranchCookie']))
	{
		unset($_COOKIE['defaultViewBranchCookie']);
	}
}

$branchView = "devBoxContentSecondaryExpanded";
if($defaultViewBranch == 'Standard')
{
	$branchView =  "devBoxContentSecondary";
}
?>
<!doctype html>
<head>
	<title>Git Status | Index</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<link rel="icon" type="image/png" href="core/img/favicon.png" />
	<script src="core/js/jquery.js"></script>
	<script src="core/js/jquery.xcolor.min.js"></script>

	<script src="core/js/visibility.core.js"></script>
	<script src="core/js/visibility.fallback.js"></script>
	<script src="core/js/visibility.js"></script>
	<script src="core/js/visibility.timers.js"></script>
</head>
<body>
	<?php require_once('core/php/templateFiles/sidebar.php'); ?>
	<?php require_once('core/php/templateFiles/header.php'); ?>
	<div id="main" style="overflow: hidden;">
		<div id="windows" style="display: inline-block; overflow: auto;" >
			<?php
			$arrayOfGroups = array();
			$showTopBarOfGroups = false;
			$count = 0;
			foreach ($config['watchList'] as $key => $value)
			{
				if(isset($value['groupInfo']) && !is_null($value['groupInfo']) && ($value['groupInfo'] != "") )
				{
					$count++;
					if($count > 1)
					{
						$showTopBarOfGroups = true;
					}
					if(!in_array($value['groupInfo'], $arrayOfGroups))
					{
						array_push($arrayOfGroups, $value['groupInfo']);
					}
				}
			}
			if($cacheEnabled === "true" || $cacheEnabled == "read")
			{
				foreach ($cachedStatusMainObject as $key => $value)
				{
					if(isset($value['groupInfo']) && !is_null($value['groupInfo']) && ($value['groupInfo'] != "") )
					{
						$groupInfoNew = $value["groupInfo"];
						$innerGroupArray = array(
							$groupInfoNew
						);
						if(strpos($groupInfoNew, " ") !== -1)
						{
							$innerGroupArray = explode(" ", $groupInfoNew);
						}
						foreach ($innerGroupArray as $groupName)
						{
							if(!isset($config["watchList"][$groupName]))
							{
								//check if it is still set with nameNoSpace logic @todo
								$inArray = false;
								foreach ($config["watchList"] as $key => $value)
								{
									$keyNoSpace = preg_replace('/\s+/', '_', $key);
									if($keyNoSpace === $groupName)
									{
										$inArray = true;
										break;
									}
								}
								if(!$inArray)
								{
									$count++;
									if($count > 1)
									{
										$showTopBarOfGroups = true;
									}
									if(!in_array($groupName, $arrayOfGroups))
									{
										array_push($arrayOfGroups, $groupName);
									}
								}
							}
						}
					}
				}
			}
			array_push($arrayOfGroups, "All"); ?>
			<div id="groupInfo" <?php if(!$showTopBarOfGroups):?> style="display: none;"<?php endif; ?> >
				<?php
				sort($arrayOfGroups);
				foreach ($arrayOfGroups as $key => $value)
				{
					echo generateGroup(array(
						"group"						=>	$value,
						"defaultGroupViewOnLoad"	=>	$defaultGroupViewOnLoad
					));
				}
				?>
			</div>
			<div id="groupInfoPlaceholder" ></div>
			<?php
			$h = -1;
			$newArray = array();
			if($pollType === 1)
			{
				$newArray = $config["watchList"];
			}
			if($cacheEnabled === "true")
			{
				$newArray = array_merge($cachedStatusMainObject, $newArray);
			}
			$alreadyShown = array();
			foreach ($newArray as $key => $value)
			{
				if(strpos($key, "branchNameDevBox1") !== false)
				{
					$key = str_replace("branchNameDevBox1", "", $key);
				}
				$keyNoSpace = preg_replace('/\s+/', '_', $key);
				$showCachedValue = false;
				$enableBlockUntilDate = "";
				$backgroundColor = "";
				$messageTextEnabled = "";
				$messageText = "";
				$errorStatus = "";
				$datePicker = "";
				$data = "<span id=\"branchNameDevBox1".$keyNoSpace."\"><img style=\"width: 20px;\" src=\"core/img/loading.gif\"> Loading...</span>";
				$time = "";
				$status = "<span style=\"display: none;\" id=\"branchNameDevBox1".$keyNoSpace."Stats\"></span>";
				$groupInfo = "";
				$groupInfoStyle = "";
				$website = "#";
				$noticeMessageShow = "none";
				$showRefresh = "inline-block";

				if(!in_array($keyNoSpace, $alreadyShown))
				{
					$h++;
					array_push($alreadyShown, $keyNoSpace);
					if(!empty($cachedStatusMainObject) && $cachedStatusMainObject != array() && $cacheEnabled === "true")
					{
						if(isset($cachedStatusMainObject["branchNameDevBox1".$keyNoSpace]))
						{
							if(isset($cachedStatusMainObject["branchNameDevBox1".$keyNoSpace]["data"]))
							{
								$showCachedValue = true;

								foreach ($cachedStatusMainObject["branchNameDevBox1".$keyNoSpace] as $key2 => $value2)
								{
									if(isset($$key2))
									{
										$$key2 = $value2;
									}
								}
							}
						}
					}

					if(isset($value["groupInfo"]) && !empty($value["groupInfo"]) && strpos($groupInfo, $value["groupInfo"]) === -1)
					{
						$groupInfo .= " ".$value["groupInfo"]." ";
					}

					if(isset($value['Website']))
					{
						$website = $value["Website"];
					}

					if($showTopBarOfGroups && $defaultGroupViewOnLoad !== "All" && strpos($groupInfo, $defaultGroupViewOnLoad) > -1)
					{
						$groupInfoStyle = "style=\"display: none;\"";
					}

					if($backgroundColor !== "")
					{
						$backgroundColor = "style=\"background-color:".$backgroundColor."\"";
					}

					$redLED = "none";
					$yellowLED = "none";
					$greenLED = "none";
					if($errorStatus !== "" && $errorStatus === false)
					{
						$redLED = "inline-block";
					}
					elseif(($messageTextEnabled !== "" && $messageTextEnabled === true) || ($enableBlockUntilDate !== "" && $enableBlockUntilDate === true))
					{
						$yellowLED = "inline-block";
					}
					else
					{
						$greenLED = "inline-block";
					}

					if(($messageTextEnabled !== "" && $messageTextEnabled === true) || ($enableBlockUntilDate !== "" && $enableBlockUntilDate === true))
					{
						$noticeMessageShow = "inline-block";
					}

					if($enableBlockUntilDate !== "" && $enableBlockUntilDate === true)
					{
						$showRefresh = "none";
					}

					echo generateWindow(
						array(
							"groupInfo"				=>	$groupInfo,
							"groupInfoStyle"		=>	$groupInfoStyle,
							"backgroundColor"		=>	$backgroundColor,
							"keyNoSpace"			=>	$keyNoSpace,
							"website"				=>	$website,
							"redLED"				=>	$redLED,
							"yellowLED"				=>	$yellowLED,
							"greenLED"				=>	$greenLED,
							"branchView"			=>	$branchView,
							"noticeMessageShow"		=>	$noticeMessageShow,
							"messageText"			=>	$messageText,
							"showRefresh"			=>	$showRefresh,
							"status"				=>	$status,
							"name"					=>	$key,
							"branchData"			=>	$data,
							"counter"				=>	$h
						)
					);

				}
			}
			?>
		</div>
		<div id="sideBox" style="background-color: rgb(119, 119, 119); margin-left: 25px; top: 45px; border: 1px solid white; position: absolute; display: none;">
			<div class="devBoxTitle" style="padding: 0;">
				<ul class="buttonList">
					<li onclick="closeDetailBar();" >
						<a>Close</a>
					</li>
					<li id="infoTab" onclick="toggleInfoTab();"  class="selectedButton" >
						<a>Info</a>
					</li>
					<li id="commitsTab" onclick="toggleCommitsTab();">
						<a>Commits</a>
					</li>
					<li id="LogHogTab" onclick="toggleIframe('loghog');" style="display: none;" >
						<a>Log-Hog</a>
					</li>
					<li id="MonitorTab" onclick="toggleIframe('monitor');" style="display: none;" >
						<a>Monitor</a>
					</li>
					<li id="SearchTab" onclick="toggleIframe('search');" style="display: none;" >
						<a>Search</a>
					</li>
				</ul>
			</div>
			<div>
				<div id="sideBoxForActualInfo"">
					<table width="100%" style="border-spacing: 0; padding: 10px;">
						<tr>
							<td width="50%" style="vertical-align: top;">
								<h2>Info:</h2>
								<span id="infoMainLeft"></span>
							</td>
							<td width="50%"  style="vertical-align: top;" >
								<h2>Git-Diff:</h2>
								<span style="height: 29px; display: block;" ></span>
								<table width="100%">
									<tr id="gitDiffLoading" style="display: none;">
										<td colspan="2">
											Loading ...
										</td>
									</tr>
									<tr id="gitDiffNoInfo" style="display: none;">
										<td colspan="2">
											No Information Available
										</td>
									</tr>
									<tr class="branchInfoGitDiff">
										<td>
											Origin/CurrentBranch
										</td>
										<td>
											-<span id="minusCurrent" ></span>
											<meter id="minusCurrentMeter" min="0" max="1.2" class="meterCommit meterCommitLeft" ></meter>
											|
											<meter id="plusCurrentMeter" min="0" max="1.2"  class="meterCommit meterCommitRight" ></meter>
											+<span id="plusCurrent" ></span>
										</td>
									</tr>
									<tr class="branchInfoGitDiff">
										<td>
											Origin/Master
										</td>
										<td>
											-<span id="minusMaster" ></span>
											<meter id="minusMasterMeter" min="0" max="1.2" class="meterCommit meterCommitLeft" ></meter>
											|
											<meter id="plusMasterMeter" min="0" max="1.2" class="meterCommit meterCommitRight"></meter>
											+<span id="plusMaster" ></span>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>
				<div id="sideBoxBoxForInfo" style="display: none;" >
					<table width="100%" style="border-spacing: 0;">
						<tr>
							<td width="250px;" style="vertical-align: top;" >
								<ul id="listOfCommitHistory" class="buttonListVert" style="width: 100%; border-right: 1px solid white; overflow: auto; ">
									<li id="spinnerLiForSideBoxBoxForInfo">
										<img style="width: 20px;" src="core/img/loading.gif"> 
									</li>
									<li class="colorAltBG" onclick="getListOfCommits();">
										Refresh
									</li>
									<span id="otherCommitsFromPast" ></span>
								</ul>
							</td>
							<td style="vertical-align: top;">
								<h1 id="mainCommitDiffLoading" style="text-align: center;" ><img style="width: 20px;" src="core/img/loading.gif"> </h1>
								<h1 id="noChangesToDisplay" style="text-align: center; display: none;" >No Changes to Display </h1>
								<span id="spanForMainDiff" style="overflow: auto; display: block; white-space: pre-wrap;" ></span>
							</td>
						</tr>
					</table>
				</div>
				<div id="iframeHolder" style="display: none;">
					<iframe id="iframeForStuff" src="./iframe.html"></iframe>
				</div>
			</div>
		</div>
	</div>

	<div style="display: none;" id="storage">
		<div class="container">
			<?php echo generateWindow(); ?>
		</div>
		<div class="groupEmpty">
			<?php echo generateGroup(); ?>
		</div>
	</div>

	<script>
		<?php

			echo "var pollingRate = ".$pollingRate.";";
			echo "var pollingRateBG = ".$pollingRateBG.";";
			echo "var pausePollFromFile = ".$pausePoll.";";
			echo "var pausePollOnNotFocus = ".$pauseOnNotFocus.";";
			echo "var autoCheckUpdate = ".$autoCheckUpdate.";";
			echo "var dateOfLastUpdate = '".$configStatic['lastCheck']."';";
			echo "var numberOfLogs = ".$h.";";
			echo "var defaultViewBranchCookie = '".$defaultViewBranchCookie."';";
			echo "var checkForIssueStartsWithNum = '".$checkForIssueStartsWithNum."';";
			echo "var checkForIssueEndsWithNum = '".$checkForIssueEndsWithNum."';";
			echo "var checkForIssueCustom = '".$checkForIssueCustom."';";
			echo "var checkForIssueInCommit = '".$checkForIssueInCommit."';";
			echo "var cacheEnabled = '".$cacheEnabled."';";
			echo "var onlyRefreshVisible = '".$onlyRefreshVisible."';";
			echo "var dontNotifyVersion = '".$dontNotifyVersion."';";
			echo "var currentVersion = '".$configStatic['version']."';";
			echo "var pollType ='".$pollType."';";
			echo "var branchView = '".$branchView."';";
			echo "var arrayOfGroups = ".json_encode($arrayOfGroups).";";
			echo "var maxCommits = ".$maxCommits.";";
			if(empty($cachedStatusMainObject))
			{
				echo "var arrayOfWatchFilters = {};";
			}
			else
			{
				echo "var arrayOfWatchFilters = {};";
				foreach ($cachedStatusMainObject as $key => $value) 
				{
					echo "arrayOfWatchFilters['".$key."'] =  {";
					foreach ($value as $value2 => $key2) 
					{
						echo $value2.": ";
						if($key2 !== 'false' && $key2 !== 'true')
						{
					 		echo "'".$key2."',";
					 	}
					 	else
					 	{
					 		echo $key2.",";
					 	}
					} 
					echo "};";
				}
				
			}
		?>
		var branchColorFilter = '<?php echo $branchColorFilter;?>';


		var errorAndColorArray = new Array();
		var errorAndColorAuthorArray = new Array();
		var errorAndColorComitteeArray = new Array();

		try
		{
			var errorAndColorArray = JSON.parse('<?php echo json_encode($errorAndColorArray); ?>');
		}
		catch(e){}

		try
		{
			var errorAndColorAuthorArray = JSON.parse('<?php echo json_encode($errorAndColorAuthorArray); ?>');
		}
		catch(e){}
		
		try
		{
			var errorAndColorComitteeArray = JSON.parse('<?php echo json_encode($errorAndColorComitteeArray); ?>');
		}
		catch(e){}
		
		var pausePoll = false;
		var pausePollFile = false;
		var refreshActionVar;
		var refreshPauseActionVar;
		var userPaused = false;
		var refreshing = false;
		var arrayOfFiles = new Array();

	<?php
		foreach($config['watchList'] as $key => $item)
		{
			echo "arrayOfFiles.push({'";
			echo "Name' :'".$key;
			echo "','";
			$countOfItems = count($item);
			$intCount = 0;
			foreach($item as $key2 => $item2)
			{
				$intCount++;
				echo $key2."': '".$item2;
				echo "'";
				if($intCount !== $countOfItems)
				{
					echo ",'";
				}
			}
			echo "});";
		}
	?>
	</script>
	<script src="core/js/updateCommon.js"></script>
	<script src="core/js/main.js"></script>
	<script src="core/js/allPages.js"></script>
	<script src="core/js/visibility.core.js"></script>
	<script src="core/js/visibility.fallback.js"></script>
	<script src="core/js/visibility.js"></script>
	<script src="core/js/visibility.timers.js"></script>
	<script type="text/javascript">
		document.getElementById("menuBarLeftMain").style.backgroundColor  = "#ffffff";
	</script>
	<?php require_once('core/php/templateFiles/allPages.php') ?>
	<?php readfile('core/html/popup.html') ?>
</body>
<form id="settingsInstallUpdate" action="update/updater.php" method="post" style="display: none"></form>