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
	<title>Git Status | About</title>
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
		
	<div id="main">
		<div id="menu">
			<div onclick="toggleMenuSideBar()" class="nav-toggle pull-right link">
			<a class="show-sidebar" id="show">
		    	<span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		    </a>
			</div>
		</div>
		<div class="firstBoxDev">
			<div class="innerFirstDevBox"  >
				<div class="devBoxTitle">
					<b>Settings</b> <button>Save Changes</button>
				</div>
				<div class="devBoxContent">
					
				</div>
			</div>
		</div>
		<div class="firstBoxDev">
			<div class="innerFirstDevBox" style="width: 500px;" >
				<div class="devBoxTitle">
					<b>Watch List</b> <button>Save Changes</button>
				</div>
				<div class="devBoxContent">
					<ul class="settingsUl">
						<?php 
							$i = 0;
							foreach($config['watchList'] as $key => $item): $i++; ?>
						<li id="rowNumber<?php echo $i; ?>" >
							<span class="leftSpacingserverNames" > Name: </span>
			 				<input style="width: 300px;" type='text' name='watchListKey<?php echo $i; ?>' value='<?php echo $key; ?>'>
			 				<?php
			 				foreach($item as $key2 => $item2): ?>
			 				<br> <span class="leftSpacingserverNames" > <?php echo $key2; ?> </span>
			 				<input style="width: 300px;"  type='text' name='watchListItem<?php echo $i; ?>' value='<?php echo $item2; ?>'>
			 				<?php endforeach; ?>
			 				<br>
							<a class="link underlineLink" onclick="deleteRowFunction(<?php echo $i; ?>, true)">Remove</a>
						</li>
						<br>
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
			</div>
		</div>
	<div>
	<script src="core/js/allPages.js"></script>
	<script type="text/javascript">
		document.getElementById("menuBarLeftSettings").style.backgroundColor  = "#ffffff";
	</script>

	<script type="text/javascript"> 
var countOfWatchList = <?php echo $i; ?>;
var countOfAddedFiles = 0;
function addRowFunction()
{

	countOfWatchList++;
	document.getElementById('newRowLocationForWatchList').innerHTML += "<li id='rowNumber"+countOfWatchList+"'>Name: <input type='text'  name='watchListKey" + countOfWatchList + "' > <input type='text' name='watchListItem" + countOfWatchList + "' ><br> <a style='cursor: pointer;' onclick='deleteRowFunction("+ countOfWatchList +", true)'>Remove</a></li>";
	document.getElementById('numberOfRows').value = countOfWatchList;
	countOfAddedFiles++;
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
				var documentUpdateText = "<li id='rowNumber"+updateItoIMinusOne+"' >Name: ";
				var watchListKeyIdFind = "watchListKey"+i;
				var watchListItemIdFind = "watchListItem"+i;
				var previousElementNumIdentifierForKey  = document.getElementsByName(watchListKeyIdFind);
				var previousElementNumIdentifierForItem  = document.getElementsByName(watchListItemIdFind);
				var nameForId = "fileNotFoundImage" + i;
				var elementByIdPreCheck = document.getElementById(nameForId);
				documentUpdateText += "<input ";
				documentUpdateText += "type='text' name='watchListKey"+updateItoIMinusOne+"' value='"+previousElementNumIdentifierForKey[0].value+"'> ";
				documentUpdateText += "<input type='text' name='watchListItem"+updateItoIMinusOne+"' value='"+previousElementNumIdentifierForItem[0].value+"'>";
				documentUpdateText += '<br> <a style="cursor: pointer;" onclick="deleteRowFunction('+updateItoIMinusOne+', true)">Remove</a>';
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

</body>
