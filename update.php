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
require_once($baseUrl.'conf/config.php');
require_once('core/conf/config.php');
require_once('core/php/configStatic.php');

$version = explode('.', $configStatic['version']);
$newestVersion = explode('.', $configStatic['newestVersion']);

$levelOfUpdate = 0; // 0 is no updated, 1 is minor update and 2 is major update
$beta = false;

$newestVersionCount = count($newestVersion);
$versionCount = count($version);
$levelOfUpdate = $levelOfUpdate = findUpdateValue($newestVersionCount, $versionCount, $newestVersion, $version);
require_once('core/php/loadVars.php'); ?>
<!doctype html>
<head>
	<title>Git Status | Update</title>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css?v=<?php echo $configStatic['version']; ?>">
	<link rel="icon" type="image/png" href="core/img/favicon.png" />
	<script src="core/js/jquery.js"></script>
	<script src="core/js/visibility.core.js"></script>
	<script src="core/js/visibility.fallback.js"></script>
	<script src="core/js/visibility.js"></script>
	<script src="core/js/visibility.timers.js"></script>
</head>
<body>
	<?php require_once('core/php/templateFiles/sidebar.php'); ?>
	<?php require_once('core/php/templateFiles/header.php'); ?>
	<div id="main" style="overflow: auto; overflow-y: auto; right: 0;" >
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
					<button class="buttonButton" onclick="checkForUpdateDefinitely(true);" >Check for Update</button>
					<form id="settingsCheckForUpdate" action="update/updater.php" method="post">
					<?php
					if($levelOfUpdate != 0)
					{
						echo '<br><br><button class="buttonButton" onclick="displayLoadingPopup();">Install '.$configStatic["newestVersion"].' Update</button>';
					}
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
		<div class="firstBoxDev" <?php if($levelOfUpdate == 0): ?> style="display: none;" <?php endif; ?>>
			<div class="innerFirstDevBox" style="width: 600px;"  >
				<div class="devBoxTitle">
				Update - Release Notes
				</div>
				<div class="devBoxContent">
					<ul id="settingsUl">
					<?php
					if(array_key_exists('versionList', $configStatic) && ($levelOfUpdate != 0))
					{
						foreach ($configStatic['versionList'] as $key => $value)
						{
							$version = explode('.', $configStatic['version']);
							$newestVersion = explode('.', $key);
							$newestVersionCount = count($newestVersion);
							$versionCount = count($version);
							$levelOfUpdate = findUpdateValue($newestVersionCount, $versionCount, $newestVersion, $version);
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
	</div>
		<script type="text/javascript">
		<?php echo "var dontNotifyVersion = '".$dontNotifyVersion."';"; ?>

		function calcuateWidth()
		{
			var left = "0px";
			if(document.getElementById("sidebar").style.width == '100px')
			{
				left = "103px";
			}
			document.getElementById("main").style.left = left;
		}


		function showUpdateCheckPopup(data)
		{
			if(data)
			{
				location.reload();
			}
		}
	</script>
	<script src="core/js/allPages.js?v=<?php echo $configStatic['version']; ?>"></script>
	<script src="core/js/updateCommon.js?v=<?php echo $configStatic['version']; ?>"></script>
	<script type="text/javascript">
		var successVerifyNum = <?php echo $successVerifyNum; ?>;
		var updating = false;
		<?php
		echo "var currentVersion = '".$configStatic['version']."';";
		?>
	</script>
	<?php readfile('core/html/popup.html') ?>
</body>