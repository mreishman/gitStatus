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


	<?php require_once('core/php/templateFiles/sidebar.php'); 
	if($_SERVER['HTTPS'] == 'on'){
    echo "<div style=' position: absolute; display: inline-table; width: 100%; background: red; text-align: center;  height: 34px;' >Please switch to http</div>";	
	}
	?>
	
	<div id="main">
		<div id="menu">
			<div onclick="toggleMenuSideBar()" class="nav-toggle pull-right link">
			<a class="show-sidebar" id="show">
		    	<span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		    </a>
			</div>
			<div onclick="refreshAction('refreshImage');" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
				<img id="refreshImage" class="menuImage" src="core/img/Refresh.png" height="30px">
			</div>
		</div>
	<?php 
	$h = -1;
	foreach ($config['watchList'] as $key => $value): 
	$h++;	
	$keyNoSpace = preg_replace('/\s+/', '_', $key); ?>
		<div class="firstBoxDev">
			<div class="innerFirstDevBox"  >
				<div class="devBoxTitle">
					<b><?php echo $key; ?></b>
					<div onclick="refreshAction('refreshImage<?php echo $key; ?>','<?php echo $h;?>','inner');" style="display: inline-block; cursor: pointer; height: 17px; width: 17px; ">
						<img id="refreshImage<?php echo $key; ?>" class="menuImage" src="core/img/Refresh2.png" height="17px">
					</div> 
				</div>
				<div class="devBoxContent">
					<b><span id="branchNameDevBox1<?php echo $keyNoSpace;?>";">
						--Pending--
					</span></b>
					<br><br>
					<b>Last Updated:</b>
					<span id="branchNameDevBox1<?php echo $keyNoSpace;?>Update";">
						--Pending--
					</span>
					<br><br>
					<span id="branchNameDevBox1<?php echo $keyNoSpace;?>Stats";">
						--Pending--
					</span>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
	</div>

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
</body>
