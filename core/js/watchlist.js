var urlForCurl = "./core/php/functions/sendCurl.php";
var countOfAddedFiles = 0;
var countOfClicks = 0;
var locationInsert = "newRowLocationForWatchList";

function generateTypeSelect(value)
{
	returnText = "";
	returnText += "<option value=\"local\"";
	if(value === "local")
	{
		returnText += " selected ";
	}
	returnText += ">Local</option>";
	returnText += "<option value=\"external\"";
	if(value === "external")
	{
		returnText += " selected ";
	}
	returnText += " >External</option>";
	return returnText;
}

function generateGitTypeSelect(value)
{
	returnText = "";
	returnText += "<option value=\"github\"";
	if(value === "github")
	{
		returnText += " selected ";
	}
	returnText += ">GitHub</option>";
	returnText += "<option value=\"gitlab\"";
	if(value === "gitlab")
	{
		returnText += " selected ";
	}
	returnText += " >GitLab</option>";
	return returnText;
}

function generateTrueFalseSelect(value)
{
	returnText = "";
	returnText += "<option value=\"true\"";
	if(value === "true")
	{
		returnText += " selected ";
	}
	returnText += ">True</option>";
	returnText += "<option value=\"false\"";
	if(value === "false")
	{
		returnText += " selected ";
	}
	returnText += " >False</option>";
	return returnText;
}

function addRowFunction()
{
	countOfWatchList++;
	countOfClicks++;
	let item = $("#hiddenWatchlistFormBlank").html();
	item = item.replace(/{{i}}/g, countOfWatchList);
	item = item.replace(/{{key}}/g, "");
	for(var i = 0; i < numberOfSubRows; i++)
	{
		let find = "{{"+countOfWatchList+"-"+(i+1)+"}}";
		let replaceString = new RegExp(find, 'g');

		if(arrayOfKeysNonEnc[i] === "type")
		{
			item = item.replace(replaceString, generateTypeSelect("local"));
		}
		else if(arrayOfKeysNonEnc[i] === "gitType")
		{
			item = item.replace(replaceString, generateGitTypeSelect("github"));
		}
		else if(arrayOfKeysNonEnc[i] === "Archive")
		{
			item = item.replace(replaceString, generateTrueFalseSelect("false"));
		}
		else
		{
			item = item.replace(replaceString, "");
		}
	}
	locationInsert = "newRowLocationForWatchList"+countOfClicks;
	item += "<div style=\"display: inline-block;\" id=\""+locationInsert+"\"></div>";
	document.getElementById(locationInsert).outerHTML += item;
	document.getElementById('numberOfRows').value = countOfWatchList;
	countOfAddedFiles++;
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
		updateLaterFolders(currentRow, newValue);
	}
	newValue--;
	if(countOfAddedFiles > 0)
	{
		countOfAddedFiles--;
		countOfWatchList--;
	}
	document.getElementById('numberOfRows').value = newValue;
}

function updateLaterFolders(currentRow, newValue)
{
	for(var i = currentRow + 1; i <= newValue; i++)
	{
		var updateItoIMinusOne = i - 1;
		var elementToUpdate = "rowNumber" + i;
		let item = $("#hiddenWatchlistFormBlank").html();
		item = item.replace(/{{i}}/g, updateItoIMinusOne);
		let watchListKeyIdFind = "watchListKey"+i;
		let previousElementNumIdentifierForKey  = document.getElementsByName(watchListKeyIdFind)[0].value;
		item = item.replace(/{{key}}/g, previousElementNumIdentifierForKey);
		for(var j = 0; j < numberOfSubRows; j++)
		{
			let watchListItemIdFind = "watchListItem"+i+"-"+(j+1);
			let previousElementNumIdentifierForItem  = document.getElementsByName(watchListItemIdFind)[0].value;
			let find = "{{"+updateItoIMinusOne+"-"+(j+1)+"}}";
			let replaceString = new RegExp(find, 'g');

			if(arrayOfKeysNonEnc[j] === "type")
			{
				item = item.replace(replaceString, generateTypeSelect(previousElementNumIdentifierForItem));
			}
			else if(arrayOfKeysNonEnc[j] === "gitType")
			{
				item = item.replace(replaceString, generateGitTypeSelect(previousElementNumIdentifierForItem));
			}
			else if(arrayOfKeysNonEnc[j] === "Archive")
			{
				item = item.replace(replaceString, generateTrueFalseSelect(previousElementNumIdentifierForItem));
			}
			else
			{
				item = item.replace(replaceString, previousElementNumIdentifierForItem);
			}
		}
		document.getElementById(elementToUpdate).outerHTML = item;
	}
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