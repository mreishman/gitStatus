<?php

$baseUrl = "core/";
if(file_exists('local/layout.php'))
{
	$baseUrl = "local/";
	//there is custom information, use this
	require_once('local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
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
	<div id="sidebar" >
		<div id="sidebarMenu" style="display: none;">
		<?php require_once('core/php/templateFiles/sidebar.php'); ?>
		</div>
	</div>
	<div id="sidebarBG"  >
	</div>
	<div id="main">
		<div id="menu">
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
		<div onclick="refreshAction();" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
			<img id="refreshImage" class="menuImage" src="core/img/Refresh.png" height="30px">
		</div>
	</div>
	<?php foreach ($config['watchList'] as $key => $value):
	$keyNoSpace = preg_replace('/\s+/', '_', $key); ?>
		<div class="firstBoxDev">
		<div class="innerFirstDevBox"  >
			<div class="devBoxTitle">
				<?php echo $key; ?>
			</div>
			<div class="devBoxContent">
				Current Branch: 
				<span id="branchNameDevBox1<?php echo $keyNoSpace;?>";">
					--Pending--
				</span>
			</div>
		</div>
		</div>
	<?php endforeach; ?>
	</div>
	<div id="title">&nbsp;</div>

	<script>
		<?php
			if(array_key_exists('pollingRate', $config))
			{
				echo "var pollingRate = ".$config['pollingRate'].";";
			}
			else
			{
				echo "var pollingRate = ".$defaultConfig['pollingRate'].";";
			} 
			if(array_key_exists('pausePoll', $config))
			{
				echo "var pausePollFromFile = ".$config['pausePoll'].";";
			}
			else
			{
				echo "var pausePollFromFile = ".$defaultConfig['pausePoll'].";";
			}
			if(array_key_exists('pauseOnNotFocus', $config))
			{
				echo "var pausePollOnNotFocus = ".$config['pauseOnNotFocus'].";";
			}
			else
			{
				echo "var pausePollOnNotFocus = ".$defaultConfig['pauseOnNotFocus'].";";
			}
			if(array_key_exists('autoCheckUpdate', $config))
			{
				echo "var autoCheckUpdate = ".$config['autoCheckUpdate'].";";
			}
			else
			{
				echo "var autoCheckUpdate = ".$defaultConfig['autoCheckUpdate'].";";
			}
		echo "var dateOfLastUpdate = '".$configStatic['lastCheck']."';";
		?>

		var pausePoll = false;
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
				echo $key2;
				echo "','";
				echo $item2;
			}
			echo "']);";
		}
	?>
	</script>
	<script src="core/js/main.js"></script>
	<script src="core/js/allPages.js"></script>
</body>
