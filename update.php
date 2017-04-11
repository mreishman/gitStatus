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
	<title>Git Status | Update</title>
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
			<div onclick="toggleMenuSideBar()" class="nav-toggle pull-right link">
			<a class="show-sidebar" id="show">
		    	<span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		    </a>
			</div>
		</div>	
	<div id="main">
		
		<div class="firstBoxDev">
			<div class="innerFirstDevBox"  >
				<div class="devBoxTitle">
					<b>Update</b>
				</div>
				<div class="devBoxContent">
					Current Version <?php echo $configStatic['version']; ?>
					<br><br>
					Last Check for updates -  <?php echo $configStatic['lastCheck'];?>
					<br><br>
					<form id="settingsCheckForUpdate" action="core/php/update/settingsCheckForUpdate.php" method="post">
					<button>Check for Update</button>
					</form>
					
					<form id="settingsCheckForUpdate" action="update/updater.php" method="post">
					<?php
					if($levelOfUpdate != 0){echo '<br><br><button>Install '.$configStatic["newestVersion"].' Update</button>';}
					?>
					</form>
					
						<span id="noUpdate" <?php if($levelOfUpdate != 0){echo "style='display: none;'";} ?> >
						<h2><img id="statusImage1" src="core/img/greenCheck.png" height="15px"> &nbsp; No new updates - You are on the current version!</h2>
						</span>
						<span id="minorUpdate" <?php if($levelOfUpdate != 1){echo "style='display: none;'";} ?> >
							<h2><img id="statusImage2" src="core/img/yellowWarning.png" height="15px"> &nbsp; Minor Updates - <?php echo $configStatic['newestVersion'];?> - bug fixes </h2>
						</span>
						<span id="majorUpdate" <?php if($levelOfUpdate != 2){echo "style='display: none;'";} ?> >
							<h2><img id="statusImage3" src="core/img/redWarning.png" height="15px"> &nbsp; Major Updates - <?php echo $configStatic['newestVersion'];?> - new features!</h2>
						</span>
						<span id="NewXReleaseUpdate" <?php if($levelOfUpdate != 3){echo "style='display: none;'";} ?> >
							<h2><img id="statusImage3" src="core/img/redWarning.png" height="15px"><img id="statusImage3" src="core/img/redWarning.png" height="15px"><img id="statusImage3" src="core/img/redWarning.png" height="15px"> &nbsp; Very Major Updates - <?php echo $configStatic['newestVersion'];?> - a lot of new features!</h2>
						</span>
					
				</div>
			</div>
		</div>
		<?php if($levelOfUpdate != 0): ?>
		<div class="firstBoxDev">
			<div class="innerFirstDevBox" style="width: 600px; max-height: 500px;"  >
				<div class="devBoxTitle">
				Update - Release Notes
				</div>
				<div class="devBoxContent"  >
					<ul id="settingsUl">
					<?php 
					if(array_key_exists('versionList', $configStatic))
					{
						foreach ($configStatic['versionList'] as $key => $value) 
						{
							$version = explode('.', $configStatic['version']);
							$newestVersion = explode('.', $key);
							$levelOfUpdate = 0;
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
							if($levelOfUpdate != 0)
							{
								echo "<li class='settingsUl' ><h2>Changelog For ".$key." update</h2></li>";
								echo $value['releaseNotes'];
							}
						}
					}
					
					?>
					</ul>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<div class="firstBoxDev">
			<div class="innerFirstDevBox" style=" width: 600px; max-height: 500px;"  >
				<div class="devBoxTitle">
					<b>Changelog</b>
				</div>
				<div class="devBoxContent">
					<?php readfile('core/html/changelog.html') ?>
				</div>
			</div>
		</div>
	</div>
	<script src="core/js/allPages.js"></script>
	<script type="text/javascript">
		document.getElementById("menuBarLeftUpdate").style.backgroundColor  = "#ffffff";
	</script>
	<?php require_once('core/php/templateFiles/allPages.php') ?>
</body>