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

require_once('core/php/loadVars.php'); ?>
<!doctype html>
<head>
	<title>Git Status | Settings</title>
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
			<div style="display: inline-block;" >
				<a href="#" class="back-to-top" style="color:#000000;">Back to Top</a>
			</div>
		</div>	
	<div id="main">
		
		
		<div class="firstBoxDev">
			<form id="settingsMainWatch" action="core/php/saveFunctions/settingsSaveMain.php" method="post">
				<div id="widthForWatchListSection" class="innerFirstDevBox" style="width: 500px;" >
					<div class="devBoxTitle">
						<b>Watch List</b> <button onclick="displayLoadingPopup();" >Save Changes</button>
					</div>
					<div class="devBoxContent">
						<ul class="settingsUl">

							<li><h2>Example:</h2></li>

							<span class="leftSpacingserverNames" > Name:</span> <input disabled="true" class='inputWidth300' type='text' value='Name you want to call website'> 
							<br>
							<span class="leftSpacingserverNames" > WebsiteBase:</span> <input disabled="true" class='inputWidth300' type='text' value='Base URL of website'> 
							<br>
							<span class="leftSpacingserverNames" > Folder:</span> <input disabled="true" class='inputWidth300' type='text' value='Location of github repo on server'> 
							<br>
							<span class="leftSpacingserverNames" > Website:</span> <input disabled="true" class='inputWidth300' type='text' value='Specific directory of website'> 
							<br>
							<span class="leftSpacingserverNames" > githubRepo:</span> <input disabled="true" class='inputWidth300' type='text' value='Name of your github repo: username/repo'> 
							<br>



							<li><h2>Your Watch List: </h2></li>
							<?php 
							$i = 0;
							$numCount = 0;
							$arrayOfKeys = array();
							foreach($config['watchList'] as $key => $item): $i++; ?>
							<div class="watchFolderGroups" >
								<li id="rowNumber<?php echo $i; ?>" >
									<span class="leftSpacingserverNames" > Name: </span>
					 				<input class='inputWidth300' type='text' name='watchListKey<?php echo $i; ?>' value='<?php echo $key; ?>'>
					 				<?php
					 				$j = 0;
					 				foreach($item as $key2 => $item2): $j++; ?>
						 				<br> <span class="leftSpacingserverNames" > <?php echo $key2; ?>: </span><input style="display: none;" type="text" name='watchListItem<?php echo $i; ?>-<?php echo $j; ?>-Name' value="<?php echo $key2;?>" >
						 				<?php
							 				if(!in_array($key2, $arrayOfKeys))
							 				{
							 					array_push($arrayOfKeys, $key2);
							 				}	
						 				?>
						 				<input class='inputWidth300'  type='text' name='watchListItem<?php echo $i; ?>-<?php echo $j; ?>' value='<?php echo $item2; ?>'>
					 				<?php endforeach; 
					 				if($numCount < $j)
					 				{
					 					$numCount = $j;
					 				}
					 				?>
					 				<br> <input style="display: none" type="text" name="watchListItem<?php echo $i;?>-0" value='<?php echo $j;?>'> 
					 				<span class="leftSpacingserverNames" ></span>
									<a class="link underlineLink" onclick="deleteRowFunction(<?php echo $i; ?>, true)">Remove</a>
								</li>
							</div>
							<?php endforeach; ?>
							<div id="newRowLocationForWatchList">
							</div>
						</ul>
						<ul class="settingsUl">
							<li>
								<a class="link underlineLink"  onclick="addRowFunction()">Add New Server</a>
							</li>
						</ul>
					</div>
					<div id="hidden" style="display: none">
						<input id="numberOfRows" type="text" name="numberOfRows" value="<?php echo $i;?>">
					</div>
				</div>
			</form>
		</div>
		
		
	</div>
	<script type="text/javascript">
		function calcuateWidth()
{
	var innerWidthWindow = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
	if(document.getElementById("sidebar").style.width == '100px')
	{
		innerWidthWindow -= 103;
	}
	if(document.getElementById("sidebar").style.width == '100px')
	{
		document.getElementById("main").style.left = "103px";
	}
	else
	{
		document.getElementById("main").style.left = "0px";
	}
	var innerWidthWindowCalc = innerWidthWindow;
	var innerWidthWindowCalcAdd = 0;
	var numOfWindows = 0;
	var elementWidth = 342;
	while(innerWidthWindowCalc > elementWidth)
	{
		innerWidthWindowCalcAdd += elementWidth;
		numOfWindows++;
		
		innerWidthWindowCalc -= elementWidth;
	}
	var windowWidthText = ((innerWidthWindowCalcAdd)+40)+"px";
	document.getElementById("main").style.width = windowWidthText;
	var remainingWidth = innerWidthWindow - ((innerWidthWindowCalcAdd)+40);
	remainingWidth = remainingWidth / 2;
	var windowWidthText = remainingWidth+"px";
	document.getElementById("main").style.marginLeft = windowWidthText;
	document.getElementById("main").style.paddingRight = windowWidthText;
	document.getElementById("widthForWatchListSection").style.width = ((innerWidthWindowCalcAdd))+"px";
}

	</script>
	<script src="core/js/allPages.js"></script>
	<script type="text/javascript">
		document.getElementById("menuBarLeftSettingsWatchList").style.backgroundColor  = "#ffffff";
	</script>

	<script type="text/javascript"> 
var countOfWatchList = <?php echo $i; ?>;
var countOfAddedFiles = 0;
var countOfClicks = 0;
var locationInsert = "newRowLocationForWatchList";
var numberOfSubRows = <?php echo $numCount; ?>;
var arrayOfKeysJsonEncoded = '<?php echo json_encode($arrayOfKeys); ?>';
var arrayOfKeysNonEnc = JSON.parse(arrayOfKeysJsonEncoded);
function addRowFunction()
{

	countOfWatchList++;
	countOfClicks++;
	var documentUpdateText = "<li id='rowNumber"+countOfWatchList+"'><span class='leftSpacingserverNames' > Name: </span> <input class='inputWidth300' type='text'  name='watchListKey" + countOfWatchList + "' >";
	for(var i = 0; i < numberOfSubRows; i++)
	{
		documentUpdateText += "<br> <span class='leftSpacingserverNames' > "+arrayOfKeysNonEnc[i]+": </span> <input style='display: none;' type='text' name='watchListItem"+countOfWatchList+"-"+(i+1)+"-Name' value="+arrayOfKeysNonEnc[i]+">   <input class='inputWidth300' type='text' name='watchListItem" + countOfWatchList + "-" + (i+1) + "' >"
	}
	documentUpdateText += '<br>  <input style="display: none" type="text" name="watchListItem'+countOfWatchList+'-0" value="'+numberOfSubRows+'"> '
	documentUpdateText += " <span class='leftSpacingserverNames' ></span> <a class='link underlineLink' onclick='deleteRowFunction("+ countOfWatchList +", true)'>Remove</a></li><div id='newRowLocationForWatchList"+countOfClicks+"'></div>";
	document.getElementById(locationInsert).outerHTML += documentUpdateText;
	document.getElementById('numberOfRows').value = countOfWatchList;
	countOfAddedFiles++;
	locationInsert = "newRowLocationForWatchList"+countOfClicks;
}

function deleteRowFunction(currentRow, decreaseCountWatchListNum)
{
	var elementToFind = "rowNumber" + currentRow;
	document.getElementById(elementToFind).outerHTML = "";
	if(decreaseCountWatchListNum)
	{
		newValue = document.getElementById('numberOfRows').value;
		if(currentRow < newValue)
		{
			//this wasn't the last folder deleted, update others
			for(var i = currentRow + 1; i <= newValue; i++)
			{
				var updateItoIMinusOne = i - 1;
				var elementToUpdate = "rowNumber" + i;
				var documentUpdateText = "<li id='rowNumber"+updateItoIMinusOne+"' ><span class='leftSpacingserverNames' > Name: </span> ";
				var watchListKeyIdFind = "watchListKey"+i;
				
				var previousElementNumIdentifierForKey  = document.getElementsByName(watchListKeyIdFind);
				
				documentUpdateText += "<input class='inputWidth300' ";
				documentUpdateText += "type='text' name='watchListKey"+updateItoIMinusOne+"' value='"+previousElementNumIdentifierForKey[0].value+"'> ";
				for(var j = 0; j < numberOfSubRows; j++)
				{
					var watchListItemIdFind = "watchListItem"+i+"-"+(j+1);
					var previousElementNumIdentifierForItem  = document.getElementsByName(watchListItemIdFind);
					documentUpdateText += "<br> <span class='leftSpacingserverNames' > "+arrayOfKeysNonEnc[j]+": </span> <input style='display: none;' type='text' name='watchListItem"+updateItoIMinusOne+"-"+(j+1)+"-Name' value="+arrayOfKeysNonEnc[j]+">  <input class='inputWidth300' type='text' name='watchListItem"+updateItoIMinusOne+"-"+(j+1)+"' value='"+previousElementNumIdentifierForItem[0].value+"'>";
				}
				documentUpdateText += '<br>  <input style="display: none" type="text" name="watchListItem'+updateItoIMinusOne+'-0" value="'+numberOfSubRows+'"> ';
				documentUpdateText += '<span class="leftSpacingserverNames" ></span> <a class="link underlineLink" onclick="deleteRowFunction('+updateItoIMinusOne+', true)">Remove</a>';
				documentUpdateText += '</li>';
				document.getElementById(elementToUpdate).outerHTML = documentUpdateText;
			}
		}
		newValue--;
		if(countOfAddedFiles > 0)
		{
			countOfAddedFiles--;
			countOfWatchList--;
		}
		document.getElementById('numberOfRows').value = newValue;
	}

}	


</script>
<?php require_once('core/php/templateFiles/allPages.php') ?>
<?php readfile('core/html/popup.html') ?>
</body>
