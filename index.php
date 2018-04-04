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
		<?php endif; ?>
	<?php 
	$h = -1;
	$newArray = array_merge($cachedStatusMainObject, $config['watchList']);
	$alreadyShown = array();
	foreach ($newArray as $key => $value): 
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
	$data = "";
	$time = "";
	$status = "";
	if((!isset($value["type"]) || $value["type"] !== "server" ) && !in_array($keyNoSpace, $alreadyShown)):
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
		} ?>
			<div 
				class="firstBoxDev <?php if(isset($value['groupInfo'])){ echo $value['groupInfo']; } ?> " 
				<?php if($showTopBarOfGroups && $defaultGroupViewOnLoad !== "All" && isset($value['groupInfo']) && $value['groupInfo'] !== $defaultGroupViewOnLoad)
				{
					echo 'style="display: none;"';
				}
				?>
			>
				<div
					class="innerFirstDevBox"
					id="innerFirstDevBoxbranchNameDevBox1<?php echo $keyNoSpace; ?>" 
					<?php if($showCachedValue && $backgroundColor !== "")
					{
						echo "style='background-color:".$backgroundColor."'";
					}
					?>
				>
					<div class="devBoxTitle">
						<?php $showLED = true; ?>
						<div class="led-red" id="branchNameDevBox1<?php echo $keyNoSpace; ?>redwWarning" style="display: inline-block; margin-bottom: -8px; 
								<?php if($showCachedValue && $errorStatus !== "" && $errorStatus === false): 
									$showLED = false;
								?> 
									display: inline-block;
								<?php else: ?>
									display: none;
								<?php endif; ?>
							"
						>
						</div>
						<div class="led-yellow" id="branchNameDevBox1<?php echo $keyNoSpace; ?>yellowWarning" style="display: inline-block; margin-bottom: -8px; 
								<?php if($showLED && $showCachedValue && (($messageTextEnabled !== "" && $messageTextEnabled === true) || ($enableBlockUntilDate !== "" && $enableBlockUntilDate === true))):
									$showLED = false;
								?>
									display: inline-block;
								<?php else: ?>
									display: none;
								<?php endif; ?>
							"
						>
						</div>
						<div class="led-green" id="branchNameDevBox1<?php echo $keyNoSpace; ?>greenNotice" style="display: inline-block; margin-bottom: -8px; 
								<?php if($showLED): ?>
									display: inline-block;
								<?php else: ?>
									display: none;
								<?php endif; ?>
							">
						</div>
						<a style="color: black;" href="<?php if(isset($value['Website'])): ?> https://<?php echo $value['Website']; else: echo "#"; endif; ?> "><b><?php echo $key; ?></b></a>
						<div
							class="refreshImageDevBox"
							id="branchNameDevBox1<?php echo $keyNoSpace; ?>spinnerDiv"
							onclick="refreshAction('<?php echo $h;?>','inner');"
							style="
								<?php if( $showCachedValue && $enableBlockUntilDate !== "" && $enableBlockUntilDate === true): ?>
									display: none;
								<?php else: ?>
									display: inline-block;
								<?php endif; ?>
								cursor: pointer; height: 25px; width: 25px; "
						>
							<img style="margin-bottom: -5px;" id="refreshImage<?php echo $keyNoSpace; ?>" class="menuImage" src="core/img/Refresh2.png" height="25px">
						</div>
						<img
							id="branchNameDevBox1<?php echo $keyNoSpace; ?>loadingSpinnerHeader"
							class='loadingSpinnerHeader'
							style="width: 25px; margin-bottom: -5px; display: none;"
							src="core/img/loading.gif"
						>
						<div class="expandMenu" onclick="dropdownShow('<?php echo $keyNoSpace;?>')" ></div>
						<div id="dropdown-<?php echo $keyNoSpace;?>" class="dropdown-content">
						    <a style="cursor: pointer" onclick="refreshAction('<?php echo $h;?>','inner');" >Refresh</a>
						    <div id="branchNameDevBox1<?php echo $keyNoSpace;?>LogHogOuter" style="display: none; cursor: pointer; width: 100%;" >
								<a id="branchNameDevBox1<?php echo $keyNoSpace;?>LogHogInner" style="color: black;" href="#">Log-Hog</a>
							</div>
							<div id="branchNameDevBox1<?php echo $keyNoSpace;?>MonitorOuter" style="display: none; cursor: pointer; width: 100%;" >
								<a id="branchNameDevBox1<?php echo $keyNoSpace;?>MonitorInner" style="color: black;" href="#">Monitor</a>
							</div>
							<div id="branchNameDevBox1<?php echo $keyNoSpace;?>SearchOuter" style="display: none; cursor: pointer; width: 100%;" >
								<a id="branchNameDevBox1<?php echo $keyNoSpace;?>SearchInner" style="color: black;" href="#">Search</a>
							</div>
							<a id="branchNameDevBox1<?php echo $keyNoSpace;?>errorMessageLink" style="cursor: pointer; display: none;">Error</a> 
							<a id="branchNameDevBox1<?php echo $keyNoSpace;?>noticeMessageLink" style="cursor: pointer; display: none;">Notice</a> 
						  </div>
					</div>
					<div class="devBoxContent">

					<span
						<?php if($showCachedValue && (($messageTextEnabled !== "" && $messageTextEnabled === true) || ($enableBlockUntilDate !== "" && $enableBlockUntilDate === true))): ?>
							style="display: inline-block;"
						<?php else: ?>
							style="display: none;"
						<?php endif; ?>
						class="noticeMessage"
						id="branchNameDevBox1<?php echo $keyNoSpace;?>NoticeMessage"
					>
						<?php if($showCachedValue && $messageText !== ""):
							echo $messageText;
						endif; ?>

						<?php if($showCachedValue && $datePicker !== ""):
							echo "Blocking poll requests untill: ".$datePicker;
						endif; ?>
					</span>
						<b>
							<?php if($showCachedValue && $data !== ""):
								echo $data;
							else: ?>
							<span id="branchNameDevBox1<?php echo $keyNoSpace;?>">
								<img style="width: 20px;" src="core/img/loading.gif"> Loading...
							</span>
							<?php endif; ?>
						</b>
						<div class="<?php if($defaultViewBranch == 'Standard'){echo 'devBoxContentSecondary';}else{echo'devBoxContentSecondaryExpanded';}?>">
						<span style="display: none;" id="branchNameDevBox1<?php echo $keyNoSpace;?>UpdateOuter">
							<br><br>
							<b>Last Updated:</b>
							<?php if($showCachedValue && $time !== ""):
								echo $time;
							else: ?>
								<span id="branchNameDevBox1<?php echo $keyNoSpace;?>Update">
								--Pending--
								</span>
							<?php endif; ?>
							<br>
						</span>
						<br>
						<?php if($showCachedValue && $status !== ""):?>
							<?php echo $status; ?>
						<?php else: ?>
							<span style="display: none;" id="branchNameDevBox1<?php echo $keyNoSpace;?>Stats">--Pending--</span>
						<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		<?php 
		endif;
	endforeach; ?>
	</div>

	<div style="display: none;" id="storage">
		<div class="container">
			<div class="firstBoxDev {{groupInfo}} " >
				<div class="innerFirstDevBox" id="innerFirstDevBox{{keyNoSpace}}" >
					<div class="devBoxTitle">
						<div class="led-red" id="{{keyNoSpace}}redwWarning" style="display: inline-block; margin-bottom: -8px; display: inline-block;">
						</div>
						<div class="led-yellow" id="{{keyNoSpace}}yellowWarning" style="display: inline-block; margin-bottom: -8px; display: none;">
						</div>
						<div class="led-green" id="{{keyNoSpace}}greenNotice" style="display: inline-block; margin-bottom: -8px; display: none;">
						</div>
						<a style="color: black;" href="https://{{website}}"><b>{{name}}</b></a>
						<div id="{{keyNoSpace}}spinnerDiv" onclick="refreshAction('{{counter}}','inner');" style="display: inline-block;cursor: pointer; height: 25px; width: 25px; ">
							<img style="margin-bottom: -5px;" id="refreshImage{{keyNoSpace}}" class="menuImage" src="core/img/Refresh2.png" height="25px">
						</div>
						<img id="{{keyNoSpace}}loadingSpinnerHeader" class='loadingSpinnerHeader' style="width: 25px; margin-bottom: -5px; display: none;" src="core/img/loading.gif" >
						<div class="expandMenu" onclick="dropdownShow('{{keyNoSpace}}')" ></div>
						<div id="dropdown-{{keyNoSpace}}" class="dropdown-content">
						    <a style="cursor: pointer" onclick="refreshAction('{{counter}}','inner');" >Refresh</a>
						    <div id="{{keyNoSpace}}LogHogOuter" style="display: none; cursor: pointer; width: 100%;" >
								<a id="{{keyNoSpace}}LogHogInner" style="color: black;" href="#">Log-Hog</a>
							</div>
							<div id="{{keyNoSpace}}MonitorOuter" style="display: none; cursor: pointer; width: 100%;" >
								<a id="{{keyNoSpace}}MonitorInner" style="color: black;" href="#">Monitor</a>
							</div>
							<div id="{{keyNoSpace}}SearchOuter" style="display: none; cursor: pointer; width: 100%;" >
								<a id="{{keyNoSpace}}SearchInner" style="color: black;" href="#">Search</a>
							</div>
							<a id="{{keyNoSpace}}errorMessageLink" style="cursor: pointer; display: none;">Error</a> 
							<a id="{{keyNoSpace}}noticeMessageLink" style="cursor: pointer; display: none;">Notice</a> 
						  </div>
					</div>
					<div class="devBoxContent">

					<span style="display: none;" class="noticeMessage" id="{{keyNoSpace}}NoticeMessage" >
					</span>
						<b>
							<span id="{{keyNoSpace}}">
								<img style="width: 20px;" src="core/img/loading.gif"> Loading...
							</span>
							
						</b>
						<div class="{{branchView}}">
							<span style="display: none;" id="{{keyNoSpace}}UpdateOuter">
								<br><br>
								<b>Last Updated:</b>
								<span id="{{keyNoSpace}}Update">
									--Pending--
								</span>
								<br>
							</span>
							<br>
							<span style="display: none;" id="{{keyNoSpace}}Stats">--Pending--</span>
						</div>
					</div>
				</div>
			</div>
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