<?php
if(isset($_COOKIE['httpsRedirectStatus']))
{
	unset($_COOKIE['httpsRedirectStatus']);
}
else
{
	if ($_SERVER['HTTPS'] == 'on') {
		setcookie("httpsRedirectStatus", "true");
	    $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	    header('Location: ' . $url, true, 301);
	    exit();
	}
}

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
	$partOfUrl = substr($partOfUrl, 0, strpos($partOfUrl, 'setup'));
	$url = "http://" . $_SERVER['HTTP_HOST'] .$partOfUrl ."setup/welcome.php";
	header('Location: ' . $url, true, 301);
	exit();
}
require_once($baseUrl.'conf/config.php'); 
require_once('core/conf/config.php');
require_once('core/php/configStatic.php');  

$version = explode('.', $configStatic['version']);
$newestVersion = explode('.', $configStatic['newestVersion']);

$levelOfUpdate = 0; // 0 is no updated, 1 is minor update and 2 is major update
$beta = false;

$newestVersionCount = count($newestVersion);
$versionCount = count($version);

for($i = 0; $i < $newestVersionCount; $i++)
{
	if($i < $versionCount)
	{
		if($i == 0)
		{
			if($newestVersion[$i] > $version[$i])
			{
				$levelOfUpdate = 3;
				break;
			}
			elseif($newestVersion[$i] < $version[$i])
			{
				$beta = true;
				break;
			}
		}
		elseif($i == 1)
		{
			if($newestVersion[$i] > $version[$i])
			{
				$levelOfUpdate = 2;
				break;
			}
			elseif($newestVersion[$i] < $version[$i])
			{
				$beta = true;
				break;
			}
		}
		else
		{
			if($newestVersion[$i] > $version[$i])
			{
				$levelOfUpdate = 1;
				break;
			}
			elseif($newestVersion[$i] < $version[$i])
			{
				$beta = true;
				break;
			}
		}
	}
	else
	{
		$levelOfUpdate = 1;
		break;
	}
}
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
	<script src="core/js/visibility.core.js"></script>
	<script src="core/js/visibility.fallback.js"></script>
	<script src="core/js/visibility.js"></script>
	<script src="core/js/visibility.timers.js"></script>
</head>
<body>
	<?php require_once('core/php/templateFiles/sidebar.php'); ?>
	<div id="menu">
		<div class="menuSections" >
			<div onclick="toggleMenuSideBar()" class="nav-toggle pull-right link">
				<a class="show-sidebar" id="show">
			    	<span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			    </a>
			</div>
			<div onclick="pausePollAction();" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
				<img id="pauseImage" class="menuImage" src="core/img/Pause.png" height="30px">
			</div>
			<div onclick="refreshAction('refreshImage');" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
				<img id="refreshImage" class="menuImage" src="core/img/Refresh.png" height="30px">
			</div>
			<div style="display: inline-block;" >
				<a href="#" class="back-to-top" style="color:#000000;">Back to Top</a>
			</div>
		</div>
		<div class="menuSections" >
			<div class="buttonSelectorOuter" >
				<div onclick="switchToStandardView();" id="standardViewButtonMainSection" class="<?php if($defaultViewBranch == 'Standard'){echo 'buttonSlectorInnerBoxesSelected';}else{echo'buttonSlectorInnerBoxes';}?> buttonSlectorInnerBoxesAll" style="border-radius: 5px 0px 0px 5px;" >
					Standard
				</div>
				<div onclick="switchToExpandedView();" id="expandedViewButtonMainSection" class="<?php if($defaultViewBranch == 'Expanded'){echo 'buttonSlectorInnerBoxesSelected';}else{echo'buttonSlectorInnerBoxes';}?> buttonSlectorInnerBoxesAll" style="border-radius: 0px 5px 5px 0px">
					Expanded
				</div>
			</div>
		</div>
		<div class="menuSections" >
			
		</div>
	</div>
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
			if($showTopBarOfGroups):?>
			<div id="groupInfo">
			<div class="groupTabShadow" >
				<div class="groupTab groupTabSelected" id="GroupAll" onclick="showOrHideGroups('All');" >
					All
				</div>
			</div>
			<?php
			sort($arrayOfGroups);
			foreach ($arrayOfGroups as $key => $value):
			?>
			<div class="groupTabShadow">
				<div class="groupTab" id="Group<?php echo $value?>" onclick="showOrHideGroups('<?php echo $value?>');" >
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
	$keyNoSpace = preg_replace('/\s+/', '_', $key); ?>
		<div class="firstBoxDev <?php echo $value['groupInfo']; ?> ">
			<div class="innerFirstDevBox" id="innerFirstDevBoxbranchNameDevBox1<?php echo $keyNoSpace; ?>" >
				<div class="devBoxTitle">
					<a style="color: black;" href="https://<?php echo $value['Website']; ?>"><b><?php echo $key; ?></b></a>
					
					<div onclick="refreshAction('refreshImage<?php echo $keyNoSpace; ?>','<?php echo $h;?>','inner');" style="display: inline-block; cursor: pointer; height: 25px; width: 25px; ">
						<img style="margin-bottom: -5px;" id="refreshImage<?php echo $keyNoSpace; ?>" class="menuImage" src="core/img/Refresh2.png" height="25px">
					</div>
					<img id="branchNameDevBox1<?php echo $keyNoSpace; ?>yellowWarning" src="core/img/yellowWarning.png" height="15px" style="margin-bottom: 0px; display: none;">
					<img id="branchNameDevBox1<?php echo $keyNoSpace; ?>redwWarning" src="core/img/redWarning.png" height="15px" style="margin-bottom: 0px; display: none;">
					<div class="expandMenu" onclick="dropdownShow('<?php echo $keyNoSpace;?>')" ></div>
					 <div id="dropdown-<?php echo $keyNoSpace;?>" class="dropdown-content">
					    <a style="cursor: pointer" onclick="refreshAction('refreshImage<?php echo $keyNoSpace; ?>','<?php echo $h;?>','inner');" >Refresh</a>
					    <div id="branchNameDevBox1<?php echo $keyNoSpace;?>LogHogOuter" style="display: none; cursor: pointer; width: 100%;" >
							<a id="branchNameDevBox1<?php echo $keyNoSpace;?>LogHogInner" style="color: black;" href="#">Log-Hog</a>
						</div>
						<a id="branchNameDevBox1<?php echo $keyNoSpace;?>errorMessageLink" style="cursor: pointer; display: none;">Error</a> 
						<a id="branchNameDevBox1<?php echo $keyNoSpace;?>noticeMessageLink" style="cursor: pointer; display: none;">Notice</a> 
					  </div>
				</div>
				<div class="devBoxContent">
					<b><span id="branchNameDevBox1<?php echo $keyNoSpace;?>">
						<img style="width: 20px;" src="core/img/loading.gif"> Loading...
					</span></b>
					<div class="<?php if($defaultViewBranch == 'Standard'){echo 'devBoxContentSecondary';}else{echo'devBoxContentSecondaryExpanded';}?>">
					<span style="display: none;" id="branchNameDevBox1<?php echo $keyNoSpace;?>UpdateOuter">
						<br><br>
						<b>Last Updated:</b>
						<span id="branchNameDevBox1<?php echo $keyNoSpace;?>Update">
							--Pending--
						</span>
						<br>
					</span>
					<br>
					<span style="display: none;" id="branchNameDevBox1<?php echo $keyNoSpace;?>Stats">
						--Pending--
					</span>
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
			echo "var numberOfLogs = '".$h."';";
			echo "var defaultViewBranchCookie = '".$defaultViewBranchCookie."';";
			echo "var checkForIssueStartsWithNum = '".$checkForIssueStartsWithNum."';";
			echo "var checkForIssueEndsWithNum = '".$checkForIssueEndsWithNum."';";
			echo "var checkForIssueCustom = '".$checkForIssueCustom."';";
			echo "var checkForIssueInCommit = '".$checkForIssueInCommit."';";
		?>
		var branchColorFilter = '<?php echo $branchColorFilter;?>';
		var errorAndColorArray = JSON.parse('<?php echo json_encode($errorAndColorArray); ?>');
		var errorAndColorAuthorArray = JSON.parse('<?php echo json_encode($errorAndColorAuthorArray); ?>');
		var errorAndColorComitteeArray = JSON.parse('<?php echo json_encode($errorAndColorComitteeArray); ?>'); 
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
	<script src="core/js/main.js"></script>
	<script src="core/js/allPages.js"></script>
	<script type="text/javascript">
		document.getElementById("menuBarLeftMain").style.backgroundColor  = "#ffffff";
	</script>
	<?php require_once('core/php/templateFiles/allPages.php') ?>
</body>
