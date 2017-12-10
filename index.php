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
			foreach ($config['watchList'] as $key => $value)
			{
				if(isset($value['groupInfo']) && !is_null($value['groupInfo']) && ($value['groupInfo'] != "") )
				{
					$showTopBarOfGroups = true;
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
	foreach ($config['watchList'] as $key => $value): 
	$h++;	
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
			class="firstBoxDev <?php echo $value['groupInfo']; ?> " 
			<?php if($showTopBarOfGroups && $defaultGroupViewOnLoad !== "All" && $value['groupInfo'] !== $defaultGroupViewOnLoad)
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
					<a style="color: black;" href="https://<?php echo $value['Website']; ?>"><b><?php echo $key; ?></b></a>
					<div
						id="branchNameDevBox1<?php echo $keyNoSpace; ?>spinnerDiv"
						onclick="refreshAction('refreshImage<?php echo $keyNoSpace; ?>','<?php echo $h;?>','inner');"
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
						id="branchNameDevBox1<?php echo $keyNoSpace; ?>yellowWarning"
						src="core/img/yellowWarning.png"
						height="15px"
						style="
							margin-bottom: 0px; 
							<?php if($showCachedValue && (($messageTextEnabled !== "" && $messageTextEnabled === true) || ($enableBlockUntilDate !== "" && $enableBlockUntilDate === true))): ?>
								display: inline-block;
							<?php else: ?>
								display: none;
							<?php endif; ?>
						"
					>
					<img
						id="branchNameDevBox1<?php echo $keyNoSpace; ?>redwWarning"
						src="core/img/redWarning.png"
						height="15px"
						style="
							margin-bottom: 0px;
							<?php if($showCachedValue && $errorStatus !== "" && $errorStatus === false): ?> 
								display: inline-block;
							<?php else: ?>
								display: none;
							<?php endif; ?>
						"
					>
					<img
						id="branchNameDevBox1<?php echo $keyNoSpace; ?>loadingSpinnerHeader"
						class='loadingSpinnerHeader'
						style="width: 25px; margin-bottom: -5px; display: none;"
						src="core/img/loading.gif"
					>
					<div class="expandMenu" onclick="dropdownShow('<?php echo $keyNoSpace;?>')" ></div>
					<div id="dropdown-<?php echo $keyNoSpace;?>" class="dropdown-content">
					    <a style="cursor: pointer" onclick="refreshAction('refreshImage<?php echo $keyNoSpace; ?>','<?php echo $h;?>','inner');" >Refresh</a>
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
	<?php endforeach; ?>
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