<?php
require_once("core/php/functions/commonFunctions.php");
$baseUrl = "core/";
if(file_exists('local/layout.php'))
{
	$baseUrl = "local/";
	//there is custom information, use this
	require_once('local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}

function clean_url($url) {
    $parts = parse_url($url);
    return $parts['path'];
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

$sendPing = true;
$pingResult = shell_exec("ping 127.0.0.1 -c 1");
if(gettype($pingResult) == "null")
{
	$sendPing = false;
}

function generateWindow($data = array())
{

	$groupInfo = "{{groupInfo}}";
	$groupInfoStyle = "{{groupInfoStyle}}";
	$backgroundColor = "{{backgroundColor}}";
	$keyNoSpace = "{{keyNoSpace}}";
	$website = "{{website}}";
	$counter = "{{counter}}";
	$name = "{{name}}";
	$branchView = "{{branchView}}";

	$greenLED = "inline-block";
	$yellowLED = "none";
	$redLED = "none";
	$noticeMessageShow = "none";
	$messageText = "";
	$showRefresh = "inline-block";

	if(isset($data['groupInfo']))
	{
		$groupInfo = $data["groupInfo"];
	}

	if(isset($data['groupInfoStyle']))
	{
		$groupInfoStyle = $data["groupInfoStyle"];
	}

	if(isset($data['backgroundColor']))
	{
		$backgroundColor = $data["backgroundColor"];
	}

	if(isset($data['keyNoSpace']))
	{
		$keyNoSpace = "branchNameDevBox1".$data["keyNoSpace"];
	}

	if(isset($data['website']))
	{
		$website = $data["website"];
	}

	if(isset($data['counter']))
	{
		$counter = $data["counter"];
	}

	if(isset($data['name']))
	{
		$name = $data["name"];
	}

	if(isset($data['branchView']))
	{
		$branchView = $data["branchView"];
	}

	if(isset($data['greenLED']))
	{
		$greenLED = $data["greenLED"];
	}

	if(isset($data['yellowLED']))
	{
		$yellowLED = $data["yellowLED"];
	}

	if(isset($data['redLED']))
	{
		$redLED = $data["redLED"];
	}

	if(isset($data['noticeMessageShow']))
	{
		$noticeMessageShow = $data["noticeMessageShow"];
	}

	if(isset($data['messageText']))
	{
		$messageText = $data["messageText"];
	}

	if(isset($data['showRefresh']))
	{
		$showRefresh = $data["showRefresh"];
	}

	$status = "<span style=\"display: none;\" id=\"branchNameDevBox1".$keyNoSpace."Stats\"></span>";
	$branchData = "<span id=\"branchNameDevBox1".$keyNoSpace."\"><img style=\"width: 20px;\" src=\"core/img/loading.gif\"> Loading...</span>";

	if(isset($data['status']))
	{
		$status = $data["status"];
	}

	if(isset($data['branchData']))
	{
		$branchData = $data["branchData"];
	}

	$blockHTML =  "	<div class=\"firstBoxDev ".$groupInfo." \"  ".$groupInfoStyle." >";
	$blockHTML .= "		<div class=\"innerFirstDevBox\" id=\"innerFirstDevBox".$keyNoSpace."\"  ".$backgroundColor." >";
	$blockHTML .= "			<div class=\"devBoxTitle\">";
	$blockHTML .= "				<div class=\"led-red\" id=\"".$keyNoSpace."redwWarning\" style=\"display: inline-block; margin-bottom: -8px; display: ".$redLED." \">";
	$blockHTML .= "				</div>";
	$blockHTML .= "				<div class=\"led-yellow\" id=\"".$keyNoSpace."yellowWarning\" style=\"display: inline-block; margin-bottom: -8px; display: ".$yellowLED." \">";
	$blockHTML .= "				</div>";
	$blockHTML .= "				<div class=\"led-green\" id=\"".$keyNoSpace."greenNotice\" style=\"display: inline-block; margin-bottom: -8px; display: ".$greenLED." \">";
	$blockHTML .= "				</div>";
	$blockHTML .= "				<a style=\"color: black;\" href=\"https://".$website."\"><b>".$name."</b></a>";
	$blockHTML .= "				<div id=\"".$keyNoSpace."spinnerDiv\" onclick=\"refreshAction('".$counter."','inner');\" style=\"display: ".$showRefresh.";cursor: pointer; height: 25px; width: 25px; \">";
	$blockHTML .= "					<img style=\"margin-bottom: -5px;\" id=\"refreshImage".$keyNoSpace."\" class=\"menuImage\" src=\"core/img/Refresh2.png\" height=\"25px\">";
	$blockHTML .= "				</div>";
	$blockHTML .= "				<img id=\"".$keyNoSpace."loadingSpinnerHeader\" class=\"loadingSpinnerHeader\" style=\"width: 25px; margin-bottom: -5px; display: none;\" src=\"core/img/loading.gif\" >";
	$blockHTML .= "				<div class=\"expandMenu\" onclick=\"dropdownShow('".$keyNoSpace."')\" ></div>";
	$blockHTML .= "				<div id=\"dropdown-".$keyNoSpace."\" class=\"dropdown-content\">";
	$blockHTML .= "			    	<a style=\"cursor: pointer\" onclick=\"refreshAction('".$counter."','inner');\" >Refresh</a>";
	$blockHTML .= "			    	<div id=\"".$keyNoSpace."LogHogOuter\" style=\"display: none; cursor: pointer; width: 100%;\" >";
	$blockHTML .= "						<a id=\"".$keyNoSpace."LogHogInner\" style=\"color: black;\" href=\"#\">Log-Hog</a>";
	$blockHTML .= "					</div>";
	$blockHTML .= "					<div id=\"".$keyNoSpace."MonitorOuter\" style=\"display: none; cursor: pointer; width: 100%;\" >";
	$blockHTML .= "						<a id=\"".$keyNoSpace."MonitorInner\" style=\"color: black;\" href=\"#\">Monitor</a>";
	$blockHTML .= "					</div>";
	$blockHTML .= "					<div id=\"".$keyNoSpace."SearchOuter\" style=\"display: none; cursor: pointer; width: 100%;\" >";
	$blockHTML .= "						<a id=\"".$keyNoSpace."SearchInner\" style=\"color: black;\" href=\"#\">Search</a>";
	$blockHTML .= "					</div>";
	$blockHTML .= "					<a id=\"".$keyNoSpace."errorMessageLink\" style=\"cursor: pointer; display: none;\">Error</a> ";
	$blockHTML .= "					<a id=\"".$keyNoSpace."noticeMessageLink\" style=\"cursor: pointer; display: none;\">Notice</a> ";
	$blockHTML .= "				</div>";
	$blockHTML .= "			</div>";
	$blockHTML .= "			<div class=\"devBoxContent\">";
	$blockHTML .= "				<span style=\"display: ".$noticeMessageShow.";\" class=\"noticeMessage\" id=\"".$keyNoSpace."NoticeMessage\" >".$messageText."</span> ";
	$blockHTML .= "				<b>";
	$blockHTML .= 					$branchData;
	$blockHTML .= "				</b>";
	$blockHTML .= "				<div class=\"".$branchView."\">";
	$blockHTML .= "					<span style=\"display: none;\" id=\"".$keyNoSpace."UpdateOuter\">";
	$blockHTML .= "						<br><br>";
	$blockHTML .= "						<b>Last Updated:</b>";
	$blockHTML .= "						<span id=\"".$keyNoSpace."Update\"> --Pending-- </span>";
	$blockHTML .= " 					<br>";
	$blockHTML .= " 				</span>";
	$blockHTML .= "					<br>";
	$blockHTML .= 					$status;
	$blockHTML .= "				</div>";
	$blockHTML .= "			</div>";
	$blockHTML .= "		</div>";
	$blockHTML .= "	</div>";
	return $blockHTML;
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
	<div id="main">
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
		foreach ($cachedStatusMainObject as $key => $value)
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
		array_push($arrayOfGroups, "All"); 
		if($showTopBarOfGroups):?>
			<div id="groupInfo">
			<?php
			sort($arrayOfGroups);
			foreach ($arrayOfGroups as $key => $value):
			?>
			<div class="groupTabShadow">
				<div class="groupTab <?php if($value === $defaultGroupViewOnLoad){echo 'groupTabSelected';}?> " id="Group<?php echo $value?>" onclick="showOrHideGroups('<?php echo $value?>');" >
					<?php echo $value; ?>
				</div>
			</div>
			<?php
			endforeach;
			?>
			</div>
			<div id="groupInfoPlaceholder" >
			</div>
			<?php
		endif;
		?>
		<?php 
		$h = -1;
		$newArray = array_merge($cachedStatusMainObject, $config['watchList']);
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
			$branchView = "devBoxContentSecondaryExpanded";



			if((!isset($value["type"]) || $value["type"] !== "server" ) && !in_array($keyNoSpace, $alreadyShown))
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

				if(isset($value["groupInfo"]) && strpos($groupInfo, $value["groupInfo"]) === -1)
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

				if($defaultViewBranch == 'Standard')
				{
					$branchView =  "devBoxContentSecondary";
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

	<div style="display: none;" id="storage">
		<div class="container">
			<?php echo generateWindow(); ?>
		</div>
	</div>

	<script>
		<?php

			echo "var pollingRate = ".$pollingRate.";";
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
			echo "arrayOfFiles.push(['";
			echo $key;
			echo "','";
				foreach($item as $key2 => $item2)
			{
				echo $item2;
				echo "','";
			}
			echo "']);";
		}
	?>
	</script>
	<script src="core/js/updateCommon.js"></script>
	<script src="core/js/main.js"></script>
	<script src="core/js/allPages.js"></script>
	<script type="text/javascript">
		document.getElementById("menuBarLeftMain").style.backgroundColor  = "#ffffff";
	</script>
	<?php require_once('core/php/templateFiles/allPages.php') ?>
	<?php readfile('core/html/popup.html') ?>
</body>
<form id="settingsInstallUpdate" action="update/updater.php" method="post" style="display: none"></form>