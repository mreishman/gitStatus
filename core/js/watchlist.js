var urlForCurl = "./core/php/functions/sendCurl.php";

function toggleArchive(currnetRow)
{
	var archiveButton = document.getElementById("archiveButton"+currnetRow);
	if(archiveButton.innerHTML === "Archive")
	{
		//unarchive action (change to 1)
		document.getElementById("archiveInput"+currnetRow).value = "true";
		archiveButton.innerHTML = "Un-Archive";
	}
	else
	{
		//archive action (change to 0)
		document.getElementById("archiveInput"+currnetRow).value = "false";
		archiveButton.innerHTML = "Archive";
	}
}

function addRowFunction()
{
	countOfWatchList++;
	countOfClicks++;
	var documentUpdateText = "<li class='watchFolderGroups' id='rowNumber"+countOfWatchList+"'><span class='leftSpacingserverNames' > Name: </span> <input class='inputWidth300' type='text'  name='watchListKey" + countOfWatchList + "' >";
	for(var i = 0; i < numberOfSubRows; i++)
	{
		documentUpdateText += " <input style='display: none;' type='text' name='watchListItem"+countOfWatchList+"-"+(i+1)+"-Name' value="+arrayOfKeysNonEnc[i]+">";
		if(arrayOfKeysNonEnc[i] === "type")
		{
			documentUpdateText += " <br> <span class='leftSpacingserverNames' > "+arrayOfKeysNonEnc[i]+": </span>";
			documentUpdateText += " <select class='inputWidth300' name='watchListItem" + countOfWatchList + "-" + (i+1) + "' >";
			documentUpdateText += " 		<option value=\"local\" selected >Local</option>";
			documentUpdateText += " 		<option value=\"external\" >External</option>";
			documentUpdateText += " </select>";
		}
		else if(arrayOfKeysNonEnc[i] === "gitType")
		{
			documentUpdateText += " <br> <span class='leftSpacingserverNames' > "+arrayOfKeysNonEnc[i]+": </span>";
			documentUpdateText += " <select class='inputWidth300' name='watchListItem" + countOfWatchList + "-" + (i+1) + "' >";
			documentUpdateText += "		<option value=\"github\" selected>GitHub</option>";
		 	documentUpdateText += "		<option value=\"gitlab\" >GitLab</option>";
		 	documentUpdateText += " </select>";
		}
		else if(arrayOfKeysNonEnc[i] === "Archive")
		{
			documentUpdateText += " <br> <span class='leftSpacingserverNames' > "+arrayOfKeysNonEnc[i]+": </span>";
			documentUpdateText += " <a id=\"archiveButton"+countOfWatchList+"\" onclick=\"toggleArchive("+countOfWatchList+");\" class=\"mainLinkClass\" >Archive</a>";
			documentUpdateText += "<input id=\"archiveInput"+countOfWatchList+"\" class='inputWidth300'  type='hidden' name='watchListItem"+countOfWatchList+"-"+(i+1)+"' value='false'>";
		}
		else
		{
			documentUpdateText += "<br> <span class='leftSpacingserverNames' > "+arrayOfKeysNonEnc[i]+": </span>  <input class='inputWidth300' type='text' name='watchListItem" + countOfWatchList + "-" + (i+1) + "' >"
		}
	}
	documentUpdateText += '<br>  <input style="display: none" type="text" name="watchListItem'+countOfWatchList+'-0" value="'+numberOfSubRows+'"> '
	documentUpdateText += " <span class='leftSpacingserverNames' ></span> <a class='mainLinkClass'  onclick='deleteRowFunction("+ countOfWatchList +", true)'>Remove</a><span> | </span><a class='mainLinkClass' onclick='testConnection(dataForWatchFolder"+countOfWatchList+");' >Check Connection</a></li><div style='display:inline-block;' id='newRowLocationForWatchList"+countOfClicks+"'></div>";
	document.getElementById(locationInsert).outerHTML += documentUpdateText;
	document.getElementById('numberOfRows').value = countOfWatchList;
	countOfAddedFiles++;
	locationInsert = "newRowLocationForWatchList"+countOfClicks;
}

function deleteRowFunction(currentRow, decreaseCountWatchListNum)
{
	var elementToFind = "rowNumber" + currentRow;
	document.getElementById(elementToFind).outerHTML = "";
	if(!(decreaseCountWatchListNum))
	{
		return;
	}
	newValue = document.getElementById('numberOfRows').value;
	if(currentRow < newValue)
	{
		//this wasn't the last folder deleted, update others
		for(var i = currentRow + 1; i <= newValue; i++)
		{
			var updateItoIMinusOne = i - 1;
			var elementToUpdate = "rowNumber" + i;
			var documentUpdateText = "<li class='watchFolderGroups' id='rowNumber"+updateItoIMinusOne+"' ><span class='leftSpacingserverNames' > Name: </span> ";
			var watchListKeyIdFind = "watchListKey"+i;
			var previousElementNumIdentifierForKey  = document.getElementsByName(watchListKeyIdFind);
			
			documentUpdateText += "<input class='inputWidth300' type='text' name='watchListKey"+updateItoIMinusOne+"' value='"+previousElementNumIdentifierForKey[0].value+"'> ";
			for(var j = 0; j < numberOfSubRows; j++)
			{
				var watchListItemIdFind = "watchListItem"+i+"-"+(j+1);
				var previousElementNumIdentifierForItem  = document.getElementsByName(watchListItemIdFind);
				documentUpdateText += "<br> <span class='leftSpacingserverNames' > "+arrayOfKeysNonEnc[j]+": </span> <input style='display: none;' type='text' name='watchListItem"+updateItoIMinusOne+"-"+(j+1)+"-Name' value="+arrayOfKeysNonEnc[j]+">  <input class='inputWidth300' type='text' name='watchListItem"+updateItoIMinusOne+"-"+(j+1)+"' value='"+previousElementNumIdentifierForItem[0].value+"'>";
			}
			documentUpdateText += '<br>  <input style="display: none" type="text" name="watchListItem'+updateItoIMinusOne+'-0" value="'+numberOfSubRows+'"> ';
			documentUpdateText += '<span class="leftSpacingserverNames" ></span> <a class="mainLinkClass" onclick="deleteRowFunction('+updateItoIMinusOne+', true)">Remove</a><span> | </span><a class="mainLinkClass" onclick="testConnection(dataForWatchFolder'+updateItoIMinusOne+');" >Check Connection</a>';
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

function testConnection(currentRowInformation)
{
	//get info for request (URL hit, if defined or website base / folder)
	var sendUrlHere = currentRowInformation['urlHit'];
	if(sendUrlHere === "" || sendUrlHere === " ")
	{
		sendUrlHere = currentRowInformation['WebsiteBase'] + "/status/core/php/functions/gitBranchName.php";
	}

	//show popup window
	showPopup();
	var popupHtml = "<div class=\"devBoxTitle\" ><b>Checking connection</b> | <button class=\"buttonButton\" onclick=\"hidePopup();\" >Close</button> </div><br><br>"
	popupHtml += "<div style=\"width:100%;text-align:center; line-height: 50px;\"> <img id=\"connectionCheckMainLoad\" src=\"core/img/loading.gif\" height=\"50\" width=\"50\"> <img style=\"display: none;\" id=\"connectionCheckMainGreen\" src=\"core/img/greenCheck.png\" height=\"50\" width=\"50\"> <img style=\"display: none;\" id=\"connectionCheckMainRed\" src=\"core/img/redWarning.png\" height=\"50\" width=\"50\">Website";
	popupHtml += "<img id=\"connectionCheckStatusLoad\" src=\"core/img/loading.gif\" height=\"50\" width=\"50\"> <img style=\"display: none;\" id=\"connectionCheckStatusGreen\" src=\"core/img/greenCheck.png\" height=\"50\" width=\"50\"> <img style=\"display: none;\" id=\"connectionCheckStatusRed\" src=\"core/img/redWarning.png\" height=\"50\" width=\"50\"> Status </div>";
	document.getElementById('popupContentInnerHTMLDiv').innerHTML = popupHtml;
	
	
	//send check requests
	checkWebsiteInGeneral(currentRowInformation['WebsiteBase']);
	checkWebsiteStatus(sendUrlHere);
}

function checkWebsiteInGeneral(sendUrlHere)
{
	$.ajax({
		url:urlForCurl,
		dataType: 'json',
		type: 'POST',
		data: {sendUrlHere},
		success(json)
		{
			document.getElementById("connectionCheckMainLoad").style.display = "none";
			document.getElementById("connectionCheckMainGreen").style.display = "inline-block";
		},
		error()
		{
			document.getElementById("connectionCheckMainLoad").style.display = "none";
			document.getElementById("connectionCheckMainRed").style.display = "inline-block";
		}
	});
}

function checkWebsiteStatus(sendUrlHere)
{
	$.ajax({
		url:urlForCurl,
		dataType: 'json',
		type: 'POST',
		data: {sendUrlHere},
		success(json)
		{
			document.getElementById("connectionCheckStatusLoad").style.display = "none";
			document.getElementById("connectionCheckStatusGreen").style.display = "inline-block";
		},
		error()
		{
			document.getElementById("connectionCheckStatusLoad").style.display = "none";
			document.getElementById("connectionCheckStatusRed").style.display = "inline-block";
		}
	});
}