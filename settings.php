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


if(array_key_exists('pollingRate', $config))
{
	$pollingRate = $config['pollingRate'];
}
else
{
	$pollingRate = $defaultConfig['pollingRate'];
} 
if(array_key_exists('pausePoll', $config))
{
	$pausePoll = $config['pausePoll'];
}
else
{
	$pausePoll = $defaultConfig['pausePoll'];
}
if(array_key_exists('pauseOnNotFocus', $config))
{
	$pauseOnNotFocus = $config['pauseOnNotFocus'];
}
else
{
	$pauseOnNotFocus = $defaultConfig['pauseOnNotFocus'];
}
if(array_key_exists('autoCheckUpdate', $config))
{
	$autoCheckUpdate = $config['autoCheckUpdate'];
}
else
{
	$autoCheckUpdate = $defaultConfig['autoCheckUpdate'];
}

?>
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
			<form id="settingsMainVars" action="core/php/saveFunctions/settingsMainUpdateVars.php" method="post">
				<div class="innerFirstDevBox"  >
					<div class="devBoxTitle">
						<b>Settings</b> <button>Save Changes</button>
					</div>
					<div class="devBoxContent">
						<ul class="settingsUl">
							<li>
								<span class="leftSpacingserverNames" > Polling Rate: </span> <input style="width: 52px;" type="text" name="pollingRate" value="<?php echo $pollingRate;?>" > Minutes
							</li>
							<li>
								<span class="leftSpacingserverNames" > Pause Poll: </span>
									<select name="pausePoll">
				  						<option <?php if($pausePoll == 'true'){echo "selected";} ?> value="true">True</option>
				  						<option <?php if($pausePoll == 'false'){echo "selected";} ?> value="false">False</option>
									</select>
							</li>
							<li style="display: none;">
								<span class="leftSpacingserverNames" > Auto Pause: </span>
									<select name="pauseOnNotFocus">
				  						<option <?php if($pauseOnNotFocus == 'true'){echo "selected";} ?> value="true">True</option>
				  						<option <?php if($pauseOnNotFocus == 'false'){echo "selected";} ?> value="false">False</option>
									</select>
							</li>
							<li>
								<span class="leftSpacingserverNames" > Check Update: </span>
									<select name="autoCheckUpdate">
				  						<option <?php if($autoCheckUpdate == 'true'){echo "selected";} ?> value="true">Auto</option>
				  						<option <?php if($autoCheckUpdate == 'false'){echo "selected";} ?> value="false">Manual</option>
									</select>
							</li>
						</ul>
					</div>
				</div>
			</form>
		</div>
		<div class="firstBoxDev">
			<form id="settingsMainWatch" action="core/php/saveFunctions/settingsMainUpdateWatchList.php" method="post">
				<div class="innerFirstDevBox" style="width: 500px;" >
					<div class="devBoxTitle">
						<b>Watch List</b> <button>Save Changes</button>
					</div>
					<div class="devBoxContent">
						<ul class="settingsUl">
							<?php 
							$i = 0;
							$numCount = 0;
							$arrayOfKeys = array();
							foreach($config['watchList'] as $key => $item): $i++; ?>
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
			</form>
		</div>
	<div>
	<script src="core/js/allPages.js"></script>
	<script type="text/javascript">
		document.getElementById("menuBarLeftSettings").style.backgroundColor  = "#ffffff";
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
</body>
