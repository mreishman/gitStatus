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
	<script src="core/js/jscolor.js"></script>
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
			<form id="settingsMainVars" action="core/php/saveFunctions/settingsSaveMain.php" method="post">
				<div class="innerFirstDevBox"  >
					<div class="devBoxTitle">
						<b>Settings</b> <button class="buttonButton" onclick="displayLoadingPopup();" >Save Changes</button>
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
							<li>
								<span class="leftSpacingserverNames" > Default View: </span>
									<select name="defaultViewBranch">
				  						<option <?php if($defaultViewBranch == 'Standard'){echo "selected";} ?> value="Standard">Standard</option>
				  						<option <?php if($defaultViewBranch == 'Expanded'){echo "selected";} ?> value="Expanded">Expanded</option>
									</select>
							</li>
							<li>
								<span class="leftSpacingserverNames" > DV Cookie: </span>

								<select name="defaultViewBranchCookie">
				  						<option <?php if($defaultViewBranchCookie == 'true'){echo "selected";} ?> value="true">True</option>
				  						<option <?php if($defaultViewBranchCookie == 'false'){echo "selected";} ?> value="false">False</option>
									</select>
								<p class="description" >Set default view by cookie, overrides above</p>
								
							</li>
						</ul>
					</div>
				</div>
			</form>
		</div>
		<div class="firstBoxDev">
			<form id="settingsDevBoxVars" action="core/php/saveFunctions/settingsSaveMain.php" method="post">
				<div class="innerFirstDevBox"  >
					<div class="devBoxTitle">
						<b>Dev Box Settings</b> <button class="buttonButton" onclick="displayLoadingPopup();" >Save Changes</button>
					</div>
					<div class="devBoxContent">
						<ul class="settingsUl">
							<li>
								<span class="leftSpacingserverNames" >Dev Branches:</span>
									<select name="enableDevBranchDownload">
				  						<option <?php if($enableDevBranchDownload == 'true'){echo "selected";} ?> value="true">True</option>
				  						<option <?php if($enableDevBranchDownload == 'false'){echo "selected";} ?> value="false">False</option>
									</select>
							</li>
						</ul>
					</div>
				</div>
			</form>
		</div>
		<div class="firstBoxDev">
			<form id="settingsIssueSearchVars" action="core/php/saveFunctions/settingsSaveMain.php" method="post">
				<div class="innerFirstDevBox" style="width: 500px;" >
					<div class="devBoxTitle">
						<b>Link Search</b> <button class="buttonButton" onclick="displayLoadingPopup();" >Save Changes</button>
					</div>
					<div class="devBoxContent">
						<ul class="settingsUl">
							<li>
								<h2>Look for Issues in branch name </h2>
								
							</li>
							<li>
								<input type="checkbox" name="checkForIssueStartsWithNum" <?php if($checkForIssueStartsWithNum == 'true'){echo "checked";} ?> value="true">  Starts With Numbers  <br>
								<input type="checkbox" name="checkForIssueEndsWithNum" <?php if($checkForIssueEndsWithNum == 'true'){echo "checked";} ?> value="true"> Ends With Numbers <br>
								<input type="checkbox" name="checkForIssueCustom" <?php if($checkForIssueCustom == 'true'){echo "checked";} ?> value="true">  Custom [Issue / Issue_ / Issue-] <br>
							</li>
							<!-- <li>
								<a class="link underlineLink" >Add New Watch Condition</a>
							</li> -->
							<li>
								<h2>Look for Issues in commit </h2>
								
							</li>
							<li>
								<input type="checkbox" name="checkForIssueInCommit" <?php if($checkForIssueInCommit == 'true'){echo "checked";} ?> value="true">  Look for #____  <br>
							</li>
						</ul>
					</div>
				</div>
			</form>
		</div>
		<div class="firstBoxDev">
			<form id="settingsColorBG" action="core/php/saveFunctions/settingsSaveMain.php" method="post">
				<div class="innerFirstDevBox" style="width: 500px;" >
					<div class="devBoxTitle">
						<b>Dev Box Color Settings</b> <button class="buttonButton" onclick="displayLoadingPopup();" >Save Changes</button>
					</div>
					<div class="devBoxContent">
							<ul class="settingsUl">
								<li>
									<h2>Color background based on:
									<select id="branchColorTypeSelector" name="branchColorFilter">
										<option <?php if ($branchColorFilter == "branchName"){echo "selected";}?> value="branchName">Name Of Branch</option>
										<option <?php if ($branchColorFilter == "authorName"){echo "selected";}?> value="authorName">Author Name</option>
										<option <?php if ($branchColorFilter == "committerName"){echo "selected";}?> value="committerName">Committer Name</option>
									</select></h2>
								</li>
								<span <?php if ($branchColorFilter != "branchName"){echo "style='display: none;'";}?> id="colorBasedOnNameOfBranch" >
								<?php 
								$counfOfFiltersForbranchName = 0;
								foreach ($errorAndColorArray as $key => $value):
								$counfOfFiltersForbranchName++; ?>
									<li id="newRowLocationForFilterBranch<?php echo $counfOfFiltersForbranchName;?>">
									<div class="colorSelectorDiv">
										 <div class="inner-triangle" ></div> 
										 <button class="backgroundButtonForColor jscolor{valueElement: 'newRowLocationForFilterBranchColor<?php echo $counfOfFiltersForbranchName;?>'}"></button>
									</div>

									<input id="newRowLocationForFilterBranchColor<?php echo $counfOfFiltersForbranchName;?>" style="display: none;" type="text" value="<?php echo $value['color'] ?>"  name="newRowLocationForFilterBranchColor<?php echo $counfOfFiltersForbranchName;?>">
									&nbsp;
									<input id="newRowLocationForFilterBranchName<?php echo $counfOfFiltersForbranchName;?>" type="text" value="<?php echo $key?>" name="newRowLocationForFilterBranchName<?php echo $counfOfFiltersForbranchName;?>">
									&nbsp;
									<select name="newRowLocationForFilterBranchSelect<?php echo $counfOfFiltersForbranchName;?>" >
										<option <?php if($value['type']=="default"){echo "selected";}?> value="default" >Default(=)</option>
										<option <?php if($value['type']=="includes"){echo "selected";}?> value="includes" >Includes</option>
									</select>
									<a class="link underlineLink"  onclick="deleteRowFunction(<?php echo $counfOfFiltersForbranchName;?>, true)">Remove Filter</a>
									</li>
								<?php endforeach; ?>
									<div style="display: none;" id="newRowLocationForFilterBranchNew"></div>
								</span>
								<span <?php if ($branchColorFilter != "authorName"){echo "style='display: none;'";}?> id="colorBasedOnAuthorName" >
								<?php
								$counfOfFiltersForAuthorName = 0;
								foreach ($errorAndColorAuthorArray as $key => $value): 
									$counfOfFiltersForAuthorName++; ?>
									<li id="newRowLocationForFilterAuthor<?php echo $counfOfFiltersForAuthorName;?>">
									<div class="colorSelectorDiv">
										 <div class="inner-triangle" ></div> 
										 <button class="backgroundButtonForColor jscolor{valueElement: 'newRowLocationForFilterAuthorColor<?php echo $counfOfFiltersForAuthorName;?>'}"></button>
									</div>
									<input id="newRowLocationForFilterAuthorColor<?php echo $counfOfFiltersForAuthorName;?>" style="display: none;" type="text" value="<?php echo $value['color'] ?>"  name="newRowLocationForFilterAuthorColor<?php echo $counfOfFiltersForAuthorName;?>">
									&nbsp;
									<input id="newRowLocationForFilterAuthorName<?php echo $counfOfFiltersForAuthorName;?>" type="text" value="<?php echo $key?>" name="newRowLocationForFilterAuthorName<?php echo $counfOfFiltersForAuthorName;?>">
									&nbsp;
									<select name="newRowLocationForFilterAuthorSelect<?php echo $counfOfFiltersForAuthorName;?>" >
										<option <?php if($value['type']=="default"){echo "selected";}?> value="default" >Default(=)</option>
										<option <?php if($value['type']=="includes"){echo "selected";}?> value="includes" >Includes</option>
									</select>
									<a class="link underlineLink"  onclick="deleteRowFunction(<?php echo $counfOfFiltersForAuthorName;?>, true)">Remove Filter</a>
									</li>
								<?php endforeach; ?>
									<div style="display: none;" id="newRowLocationForFilterAuthorNew"></div>
								</span>
								<span  <?php if ($branchColorFilter != "committerName"){echo "style='display: none;'";}?> id="colorBasedOnComitteeName" >
								<?php
								$counfOfFiltersForComitteeName = 0;
								foreach ($errorAndColorComitteeArray as $key => $value): 
									$counfOfFiltersForComitteeName++; ?>
									<li id="newRowLocationForFilterComittee<?php echo $counfOfFiltersForComitteeName;?>">
									<div class="colorSelectorDiv">
										 <div class="inner-triangle" ></div> 
										 <button class="backgroundButtonForColor jscolor{valueElement: 'newRowLocationForFilterComitteeColor<?php echo $counfOfFiltersForComitteeName;?>'}"></button>
									</div>
									<input id="newRowLocationForFilterComitteeColor<?php echo $counfOfFiltersForComitteeName;?>" style="display: none;" type="text" value="<?php echo $value['color'] ?>"  name="newRowLocationForFilterComitteeColor<?php echo $counfOfFiltersForComitteeName;?>">
									&nbsp;
									<input id="newRowLocationForFilterComitteeName<?php echo $counfOfFiltersForComitteeName;?>" type="text" value="<?php echo $key?>" name="newRowLocationForFilterComitteeName<?php echo $counfOfFiltersForComitteeName;?>">
									&nbsp;
									<select name="newRowLocationForFilterComitteeSelect<?php echo $counfOfFiltersForComitteeName;?>" >
										<option <?php if($value['type']=="default"){echo "selected";}?> value="default" >Default(=)</option>
										<option <?php if($value['type']=="includes"){echo "selected";}?> value="includes" >Includes</option>
									</select>
									<a class="link underlineLink"  onclick="deleteRowFunction(<?php echo $counfOfFiltersForComitteeName;?>, true)">Remove Filter</a>
									</li>
								<?php endforeach; ?>
									<div style="display: none;" id="newRowLocationForFilterComitteeNew"></div>
								</span>
								<li>
									<a class="link underlineLink"  onclick="addRowFunction()">Add New Filter</a>
								</li>
							</ul>
					</div>
				</div>
			</form>
		</div>
	</div>
	<script type="text/javascript">

	var counfOfFiltersForbranchName = <?php echo $counfOfFiltersForbranchName; ?>;
	var counfOfFiltersForAuthorName = <?php echo $counfOfFiltersForAuthorName; ?>;
	var counfOfFiltersForComitteeName = <?php echo $counfOfFiltersForComitteeName; ?>;

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
		if(numOfWindows == 1)
		{
			elementWidth = 542;
		}
		else if (numOfWindows == 2)
		{
			elementWidth = 342;
		}
		else if (numOfWindows == 3)
		{
			elementWidth = 542;
		}
		else if (numOfWindows == 4)
		{
			elementWidth = 500;
		}
		else if (numOfWindows == 5)
		{
			//change if adding more windows to settings.php
			elementWidth = 9000000;
		}
		innerWidthWindowCalc -= elementWidth;
	}
	var windowWidthText = ((innerWidthWindowCalcAdd)+40)+"px";
	document.getElementById("main").style.width = windowWidthText;
	var remainingWidth = innerWidthWindow - ((innerWidthWindowCalcAdd)+40);
	remainingWidth = remainingWidth / 2;
	var windowWidthText = remainingWidth+"px";
	document.getElementById("main").style.marginLeft = windowWidthText;
	document.getElementById("main").style.paddingRight = windowWidthText;
}

	</script>
	<script src="core/js/allPages.js"></script>
	<script type="text/javascript">

document.getElementById("menuBarLeftSettings").style.backgroundColor  = "#ffffff";

var countOfClicksFilterBranch = 0;
var countOfClicksFilterAuthor = 0;
var countOfClicksFilterComittee = 0;		

function addRowFunction()
{
	var filterType = whichTypeOfFilterIsSelected();
	var counter = 0;
	var highestRowCount = 0;
	documentUpdateText = '<li ';
	if(filterType == 'newRowLocationForFilterBranch')
	{
		counter = countOfClicksFilterBranch;
		countOfClicksFilterBranch++;
		highestRowCount = counfOfFiltersForbranchName;
	}
	else if (filterType == 'newRowLocationForFilterAuthor')
	{
		counter = countOfClicksFilterAuthor;
		countOfClicksFilterAuthor++;
		highestRowCount = counfOfFiltersForAuthorName;
	}
	else
	{
		counter = countOfClicksFilterComittee;
		countOfClicksFilterComittee++;
		highestRowCount = counfOfFiltersForComitteeName;
	}
	documentUpdateText += "id='"+filterType+""+(highestRowCount+counter+1)+"'";
	documentUpdateText += '><div class="colorSelectorDiv"><div class="inner-triangle" ></div><button id='+filterType+'button'+(highestRowCount+counter+1)+' class="backgroundButtonForColor"></button></div>';
	documentUpdateText += '&nbsp;<input id="'+filterType+'Color'+(highestRowCount+counter+1)+'" style="display: none;" type="text" value="000"  name="'+filterType+'Color'+(highestRowCount+counter+1)+'">'
	documentUpdateText += '&nbsp;&nbsp;<input type="text" value="" name="'+filterType+"Name"+(highestRowCount+1+counter)+'" >&nbsp;&nbsp;&nbsp;<select><option value="default" >Default(=)</option><option value="includes" >Includes</option></select>&nbsp;<a class="link underlineLink"  onclick="deleteRowFunction('+(highestRowCount+1+counter)+', true)">Remove Filter</a></li>';
	documentUpdateText += '<div style="display: none;" id="'+filterType+'New'+(highestRowCount+1+counter)+'"></div>';
	var newFilter = filterType + "New";
	if(counter != 0)
	{
		newFilter += counter;
	}
	document.getElementById(newFilter).outerHTML += documentUpdateText;
	var picker = new jscolor(document.getElementById(filterType+'button'+(highestRowCount+counter+1)), {valueElement: filterType+'Color'+(highestRowCount+counter+1)});

}

function deleteRowFunction(currentRow, decreaseCountWatchListNum)
{
	var filterType = whichTypeOfFilterIsSelected();
	var elementToFind = filterType+currentRow;
	if(decreaseCountWatchListNum)
	{
		var countOfHeighestNum = 1;
		console.log(filterType+countOfHeighestNum);
		while (document.getElementById(filterType+countOfHeighestNum))
		{
			countOfHeighestNum++;
		}
		countOfHeighestNum--;
		document.getElementById(elementToFind).outerHTML = "";
		if(currentRow < countOfHeighestNum)
		{
			//this wasn't the last folder deleted, update others
			for(var i = currentRow + 1; i <= countOfHeighestNum; i++)
			{
				var updateItoIMinusOne = i - 1;
				var elementToUpdate = filterType + i;
				documentUpdateText = '<li ';
				if(filterType == 'newRowLocationForFilterBranch')
				{
					counter = countOfClicksFilterBranch;
					highestRowCount = counfOfFiltersForbranchName;
				}
				else if (filterType == 'newRowLocationForFilterAuthor')
				{
					counter = countOfClicksFilterAuthor;
					highestRowCount = counfOfFiltersForAuthorName;
				}
				else
				{
					counter = countOfClicksFilterComittee;
					highestRowCount = counfOfFiltersForComitteeName;
				}
				documentUpdateText += "id='"+filterType+""+updateItoIMinusOne+"'";
				documentUpdateText += '><div class="colorSelectorDiv"><div class="inner-triangle" ></div><button id='+filterType+'button'+updateItoIMinusOne+' class="backgroundButtonForColor"></button></div>';
				documentUpdateText += '&nbsp;<input id="'+filterType+'Color'+updateItoIMinusOne+'" style="display: none;" type="text" value="';
				documentUpdateText += document.getElementById(filterType+'Color'+i).value;
				documentUpdateText += '"  name="'+filterType+'Color'+updateItoIMinusOne+'">'
				documentUpdateText += '&nbsp;&nbsp;<input type="text" value="';
				documentUpdateText += document.getElementById(filterType+'Name'+i).value;
				documentUpdateText += '" name="'+filterType+"Name"+updateItoIMinusOne+'" >&nbsp;&nbsp;&nbsp;<select><option value="default" >Default(=)</option><option value="includes" >Includes</option></select>&nbsp;<a class="link underlineLink"  onclick="deleteRowFunction('+updateItoIMinusOne+', true)">Remove Filter</a></li>';
				document.getElementById(filterType+i).outerHTML = documentUpdateText;

				var picker = new jscolor(document.getElementById(filterType+'button'+updateItoIMinusOne), {valueElement: filterType+'Color'+updateItoIMinusOne});


			}
		}
	}
	else
	{
		document.getElementById(elementToFind).outerHTML = "";
	}
}

function whichTypeOfFilterIsSelected()
{
	var valueForPopup = document.getElementById('branchColorTypeSelector').value;
	if(valueForPopup == 'branchName')
	{
		return 'newRowLocationForFilterBranch';
	}
	else if (valueForPopup == 'authorName')
	{
		return 'newRowLocationForFilterAuthor';
	}
	else
	{
		return 'newRowLocationForFilterComittee';
	}
}	

function switchToNewFilterBranchColor()
{
	var filterType = whichTypeOfFilterIsSelected();
	document.getElementById('colorBasedOnNameOfBranch').style.display = 'none';
	document.getElementById('colorBasedOnAuthorName').style.display = 'none';
	document.getElementById('colorBasedOnComitteeName').style.display = 'none';
	if(filterType == 'newRowLocationForFilterBranch')
	{
		document.getElementById('colorBasedOnNameOfBranch').style.display = 'block';
	}
	else if (filterType == 'newRowLocationForFilterAuthor')
	{
		document.getElementById('colorBasedOnAuthorName').style.display = 'block';
	}
	else
	{
		document.getElementById('colorBasedOnComitteeName').style.display = 'block';
	}
}

document.getElementById("branchColorTypeSelector").addEventListener("change", switchToNewFilterBranchColor, false);

</script>
<?php require_once('core/php/templateFiles/allPages.php') ?>
<?php readfile('core/html/popup.html') ?>
</body>
