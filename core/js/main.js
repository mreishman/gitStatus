var counterForSave = numberOfLogs+1;
var updating = false;
var pollTimer = null;
var blocekdInnerObj = {};
var currentIdOfMainSidebar = "";
var currentOpenMenu = "";

function escapeHTML(unsafeStr)
{
	return unsafeStr.toString()
	.replace(/&/g, "&amp;")
	.replace(/</g, "&lt;")
	.replace(/>/g, "&gt;")
	.replace(/\"/g, "&quot;")
	.replace(/\'/g, "&#39;")
	.replace(/\//g, "&#x2F;");
}

function poll(all = -1, counterForSaveNew = 1)
{
	(function(_all, _counterForSaveNew){
		$.ajax({
			url: "./core/php/functions/getWatchlist.php",
			dataType: 'json',
			global: false,
			data: {},
			type: 'POST',
			success: function(data){
				var dataVersion = data["version"];
				if(String(dataVersion) !== String(currentVersion))
				{
					//version changed, stop polls and show message
					if(!isPaused())
					{
						pausePollFunction();
					}
					showPopup();
					document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='devBoxTitle' ><b>gitStatus has been updated. Please Refresh</b></div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>gitStatus has been updated, and is now on a new version. Please refresh the page.</div><div><div class='buttonButton' onclick='location.reload();' style='margin-left:50px; margin-right:50px;margin-top:35px;'>Reload</div></div>";
				}
				else
				{
					var watchlistData = data["watchlist"];
					var arrayOfFilesLength = arrayOfFiles.length;
					var dataKeys = Object.keys(watchlistData);
					var dataLength = dataKeys.length;
					for(var i = 0; i < arrayOfFilesLength; i++)
					{
						//check if arrayOfFile server is still in data
						var iFound = false;
						numberOfLogs = 0;
						for(var j = 0; j < dataLength; j++)
						{
							if(arrayOfFiles[i]["Name"] === dataKeys[j])
							{
								if((!("Archive" in watchlistData[dataKeys[j]])) || (watchlistData[dataKeys[j]]["Archive"] === "false" || watchlistData[dataKeys[j]]["Archive"] === ""))
								{
									iFound = true;
								}
								break;
							}
						}
						if(!iFound)
						{
							if(pollType === "2")
							{
								//more info required
								var arrayOfWatchFiltersKeys = Object.keys(arrayOfWatchFilters);
								var arrayOfWatchFiltersKeysLength = arrayOfWatchFiltersKeys.length;
								for(var j = 0; j < arrayOfWatchFiltersKeysLength; j++)
								{
									if(arrayOfWatchFilters[arrayOfWatchFiltersKeys[j]]["groupInfo"].indexOf(arrayOfFiles[i]["Name"]) > -1)
									{
										numberOfLogs--;
										if(onServerRemoveRemoveNotError)
										{
											//show error on specific poll
											pollFailure("Error", "Server removed from watchlist", {location: arrayOfWatchFilters[arrayOfWatchFiltersKeys[j]].location, name: arrayOfWatchFiltersKeys[j], githubRepo: "", websiteBase: arrayOfWatchFilters[arrayOfWatchFiltersKeys[j]].websiteBase, id: "innerFirstDevBox"+arrayOfWatchFiltersKeys[j]});
										}
										else
										{
											if(document.getElementById("innerFirstDevBox"+arrayOfWatchFiltersKeys[j]))
											{
												document.getElementById("innerFirstDevBox"+arrayOfWatchFiltersKeys[j]).parentNode.id = "removeThis";
												$("#removeThis").remove();
											}
										}
										//remove from archive
										var noSpaceName = arrayOfWatchFiltersKeys[j].replace(/\s/g, '');
										delete arrayOfWatchFilters[noSpaceName];
									}
								}
							}
							else
							{
								numberOfLogs--;
								var htmlId = "innerFirstDevBoxbranchNameDevBox1"+(arrayOfFiles[i]["Name"].replace(/\s/g, '_'));
								if(onServerRemoveRemoveNotError)
								{
									//show error on specific poll
									pollFailure("Error", "Server removed from watchlist", {location: arrayOfFiles[i].location, name: arrayOfFiles[i].name, githubRepo: arrayOfFiles[i].githubRepo, websiteBase: arrayOfFiles[i].websiteBase, id: htmlId});
								}
								else
								{
									if(document.getElementById(htmlId))
									{
										document.getElementById(htmlId).parentNode.id = "removeThis";
										$("#removeThis").remove();
									}
								}
								//remove from archive
								var noSpaceName = "branchNameDevBox1"+(arrayOfFiles[i]["Name"].replace(/\s/g, ''));
								if(noSpaceName in arrayOfWatchFilters)
								{
									delete arrayOfWatchFilters[noSpaceName];
								}
							}
						}
					}
					//update arrayOfFiles (sname for both poll 1 and 2 because it's not specific except for name)
					arrayOfFiles = new Array();
					var dataKeys = Object.keys(watchlistData);
					var dataLength = dataKeys.length;
					for(var j = 0; j < dataLength; j++)
					{
						if((!("Archive" in watchlistData[dataKeys[j]])) || (watchlistData[dataKeys[j]]["Archive"] === "false" || watchlistData[dataKeys[j]]["Archive"] === ""))
						{
							arrayOfFiles.push(watchlistData[dataKeys[j]]);
							arrayOfFiles[(arrayOfFiles.length - 1)]["Name"] = dataKeys[j];
						}
					}
					pollTwo(_all, _counterForSaveNew);
				}
			},
			error: function(xhr, error){

			}
		});
	}(all, counterForSaveNew));
}

function pollTwo(all, counterForSaveNew)
{
	document.getElementById('loadingSpinnerMain').style.display = "block";
	if(all === -1)
	{
		counterForSave = numberOfLogs+1;
		var arrayOfFilesLength = arrayOfFiles.length
		//Change ALL leds to yellow
		$(".led-green").hide();
		$(".led-red").hide();
		$(".led-yellow").css("display","inline-block");
		for(var i = 0; i < arrayOfFilesLength; i++)
		{
			var boolForRun = true;
			if(onlyRefreshVisible === "true")
			{
				var name = "innerFirstDevBoxbranchNameDevBox1"+arrayOfFiles[i]["Name"];
				name = name.replace(/\s/g, '_');
				if( document.getElementById(name))
				{
					if( document.getElementById(name).parentElement.style.display === "none")
					{
						boolForRun = false;
					}
				}
			}
			if(boolForRun)
			{
				$("."+arrayOfFiles[i]["Name"]+" .loadingSpinnerHeader").css('display', 'inline-block');
				$("."+arrayOfFiles[i]["Name"]+" .warningSpanHeader").css('display','none');
				$("."+arrayOfFiles[i]["Name"]+" .refreshImageDevBox").css('display', 'none');
				tryHTTPForPollRequest(i);
			}
			else
			{
				pollCompleteLogic();
			}
		}
	}
	else
	{
		counterForSave = counterForSaveNew;
		tryHTTPForPollRequest(all);
	}
}

function getToday()
{
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var yyyy = today.getFullYear();

	if(dd<10)
	{
	    dd='0'+dd
	}

	if(mm<10)
	{
	    mm='0'+mm
	}
	return mm+'/'+dd+'/'+yyyy;
}

function tryHTTPForPollRequest(count, name = null)
{
	if(!name)
	{
		name = "branchNameDevBox1"+arrayOfFiles[count]["Name"];
	}
	name = name.replace(/\s/g, '_');
	var doPollLogic = true;
	var dateForEnd = null;
	if(arrayOfWatchFilters && arrayOfWatchFilters[name] && arrayOfWatchFilters[name]["enableBlockUntilDate"] == 'true')
	{
		dateForEnd = arrayOfWatchFilters[name]["datePicker"];
	}
	else if(blocekdInnerObj && blocekdInnerObj[name] && blocekdInnerObj[name]["enableBlockUntilDate"] == 'true' )
	{
		dateForEnd = blocekdInnerObj[name]["datePicker"];
	}
	if(dateForEnd !== null)
	{
		var today = getToday();
		if (dateForEnd >= today)
		{
			doPollLogic = false;
		}
	}
	if(doPollLogic)
	{
		tryHttpActuallyPollLogic(count, name);
	}
	else
	{
		pollCompleteLogic();
	}
}

function showLoadingSpinnerHeader(name)
{
	if(document.getElementById(name))
	{
		if(document.getElementById(name+'loadingSpinnerHeader') && document.getElementById(name+'loadingSpinnerHeader').style.display !== "inline-block")
		{
			document.getElementById(name+'loadingSpinnerHeader').style.display = "inline-block";
		}
		if(document.getElementById(name+"warningSpanHeader") && document.getElementById(name+"warningSpanHeader").style.display !== "none")
		{
			document.getElementById(name+"warningSpanHeader").style.display = "none";
		}
	}
}

function hideLoadingSpinnerHeader(name)
{
	if(document.getElementById(name))
	{
		if(document.getElementById(name+'loadingSpinnerHeader') && document.getElementById(name+'loadingSpinnerHeader').style.display !== "none")
		{
			document.getElementById(name+'loadingSpinnerHeader').style.display = "none";
		}
		if(document.getElementById(name+"warningSpanHeader") && document.getElementById(name+"warningSpanHeader").style.display !== "inline-block")
		{
			document.getElementById(name+"warningSpanHeader").style.display = "inline-block";
		}
	}
}

function getPollDataTypeTwo(name)
{
	var urlForSend = 'http://'+arrayOfWatchFilters[name]["WebsiteBase"]+'/status/core/php/functions/gitBranchName.php?format=json';
	if("urlHit" in arrayOfWatchFilters[name] && arrayOfWatchFilters[name]["urlHit"] !== "")
	{
		urlForSend = 'http://'+arrayOfWatchFilters[name]["urlHit"]+'?format=json';
	}
	var folder = "";
	var githubRepo = "";
	var branchList = "";
	if("branchList" in arrayOfWatchFilters[name])
	{
		branchList = arrayOfWatchFilters[name]["branchList"];
	}
	if("Folder" in arrayOfWatchFilters[name])
	{
		folder = arrayOfWatchFilters[name]["Folder"];
	}
	if("githubRepo" in arrayOfWatchFilters[name])
	{
		githubRepo = arrayOfWatchFilters[name]["githubRepo"];
	}
	return {pollType, location: folder, name, githubRepo, urlForSend ,websiteBase: arrayOfWatchFilters[name]["WebsiteBase"], id: name.replace("branchNameDevBox1", ""),branchList};
}

function getPollData(count, name)
{
	var urlForSend = 'http://'+arrayOfFiles[count]["WebsiteBase"]+'/status/core/php/functions/gitBranchName.php?format=json';
	if(arrayOfFiles[count]["urlHit"] !== "")
	{
		urlForSend = 'http://'+arrayOfFiles[count]["urlHit"]+'?format=json';
	}
	var id = name.replace("branchNameDevBox1", "");
	var subBoxes = document.getElementsByClassName(id);
	var countOfSubServers = subBoxes.length;
	if(countOfSubServers > 0)
	{
		for(var i = 0; i < countOfSubServers; i++)
		{
			var nameForBackground = subBoxes[i].getElementsByClassName("innerFirstDevBox")[0].id;
			var noSpaceName = nameForBackground.replace("innerFirstDevBox", "");
			showLoadingSpinnerHeader(noSpaceName);
		}
	}
	var folder = "";
	var githubRepo = "";
	var branchList = "";
	if("branchList" in arrayOfFiles[count])
	{
		branchList = arrayOfFiles[count]["branchList"];
	}
	if("Folder" in arrayOfFiles[count])
	{
		folder = arrayOfFiles[count]["Folder"];
	}
	if("githubRepo" in arrayOfFiles[count])
	{
		githubRepo = arrayOfFiles[count]["githubRepo"];
	}
	return {pollType, location: folder, name, githubRepo, urlForSend ,websiteBase: arrayOfFiles[count]["WebsiteBase"], id: arrayOfFiles[count]["Name"],branchList};
}


function tryHttpActuallyPollLogic(count, name)
{
	var data = {};
	var innerData = {};
	if(count !== null)
	{
		data = getPollData(count, name);
		if(pollType == "1")
		{
			innerData = data;
		}
	}
	else
	{
		data = getPollDataTypeTwo(name);
		innerData = data;
	}
	var urlForSend = data["urlForSend"];
	showLoadingSpinnerHeader(name);
	loadingSpinnerText.innerHTML = (counterForSave);
	document.getElementById("refreshDiv").style.display = "none";
	(function(_data, _innerData){
			$.ajax({
			url: urlForSend,
			dataType: 'json',
			global: false,
			data: innerData,
			type: 'POST',
			success: function(data){
				pollSuccess(data, _data);
			},
			error: function(xhr, error){
				tryHTTPSForPollRequest(_data, _innerData);
			}
		});
	}(data, innerData));
}


function tryHTTPSForPollRequest(data2, _innerData)
{
	var urlForSend = data2.urlForSend;
	urlForSend = urlForSend.replace("http","https");
	var data = _innerData;
	(function(_data){
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			global: false,
			data: data,
			type: 'POST',
			success: function(data){
				pollSuccess(data, _data);
			},
			error: function(xhr, error){
				pollFailure(xhr.status, error, _data);
			}
		});
	}(data2));
}

function showPopupWithMessage(type, message)
{
	showPopup();
	document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='devBoxTitle' ><b>"+type+"</b></div><br><br><div style='width:100%;text-align:center;'>"+message+"<br><br><a class='buttonButton' onclick='hidePopup();'>Ok</a></div>";
}

function decreaseSpinnerCounter()
{
	if(document.getElementById('loadingSpinnerMain').style.display !== "block")
	{
		document.getElementById('loadingSpinnerMain').style.display = "block";
	}
	var loadingSpinnerText = document.getElementById('loadingSpinnerText');
	counterForSave--;
	loadingSpinnerText.innerHTML = (counterForSave);
	return loadingSpinnerText;
}

function addGroup(groupName)
{
	if(arrayOfGroups.indexOf(groupName) === -1 && groupName !== "")
	{
		arrayOfGroups.push(groupName);
		var item = $("#storage .groupEmpty").html();
		item = item.replace(/{{group}}/g, groupName);
		$("#groupInfo").append(item);
		if(document.getElementById("groupInfo").style.display === "none")
		{
			var showGroupsCheck = false;
			var arrayOfGroupsLength = arrayOfGroups.length;
			if(arrayOfGroupsLength > 2)
			{
				showGroupsCheck = true;
			}
			else
			{
				for(var groupCount = 0; groupCount < arrayOfGroupsLength; groupCount++)
				{
					var groupCheck = arrayOfGroups[groupCount];
					if(groupCheck !== "All")
					{
						if($("."+groupCheck).length < ($(".firstBoxDev").length - 1))
						{
							showGroupsCheck = true;
						}
					}
				}
			}
			if(showGroupsCheck)
			{
				document.getElementById("groupInfo").style.display = "block";
			}
		}
	}
}

function removeGroup(groupName)
{
	arrayOfGroups.splice(arrayOfGroups.indexOf(groupName),1);
	$("#Group"+groupName).remove();
}

function cleanUpGroups()
{
	var newArrayOfGroups = ["All"];
	var arrayOfWatchFiltersKey = Object.keys(arrayOfWatchFilters);
	var arrayOfWatchFiltersKeylength = arrayOfWatchFiltersKey.length;
	for(var i = 0; i < arrayOfWatchFiltersKeylength; i++)
	{
		var listOfGroupNames = arrayOfWatchFilters[arrayOfWatchFiltersKey[i]]["groupInfo"];
		if(typeof listOfGroupNames !== "undefined" && listOfGroupNames !== "" && listOfGroupNames !== null)
		{
			var listOfGroupNames = listOfGroupNames.split(" ");
			var listOfGroupNamesLength = listOfGroupNames.length;
			for(var j = 0; j < listOfGroupNamesLength; j++)
			{
				var groupName = listOfGroupNames[j];
				if(arrayOfGroups.indexOf(groupName) !== -1 && groupName !== "")
				{
					newArrayOfGroups.push(groupName);
				}
			}
		}
	}
	var arrayOfGroupsToRemove = [];
	var lengthOfOldGroups = arrayOfGroups.length;
	for(var i = 0; i < lengthOfOldGroups; i++)
	{
		//check if in old group and not new one
		if(newArrayOfGroups.indexOf(arrayOfGroups[i]) === -1)
		{
			arrayOfGroupsToRemove.push(arrayOfGroups[i])
		}
	}
	var lengthOfGroupsToRemove = arrayOfGroupsToRemove.length;
	if(lengthOfGroupsToRemove > 0)
	{
		for(var i = 0; i < lengthOfGroupsToRemove; i ++)
		{
			removeGroup(arrayOfGroupsToRemove[i]);
		}
	}
}

function pollCompleteLogic()
{
	var loadingSpinnerText = decreaseSpinnerCounter();
	if(counterForSave >= 1)
	{
		return;
	}
	if(cacheEnabled === "true" || cacheEnabled === "write")
	{
		loadingSpinnerText.innerHTML = "Saving..."
		if(!jQuery.isEmptyObject(arrayOfWatchFilters))
		{
			//save object after poll
			var urlForSend = 'core/php/saveFunctions/cachedStatus.php?format=json'
			var data = {arrayOfdata: arrayOfWatchFilters, currentVersion};
			(function(_data){

				$.ajax({
				url: urlForSend,
				dataType: 'json',
				global: false,
				data: data,
				type: 'POST',
				complete: function(data)
				{
					document.getElementById('loadingSpinnerMain').style.display = "none";
					loadingSpinnerText.innerHTML = "";
					document.getElementById("refreshDiv").style.display = "inline-block";
					}
				});
			}(data));
		}
	}
	else
	{
		document.getElementById('loadingSpinnerMain').style.display = "none";
	}
	cleanUpGroups();
}

function pollFailure(xhr, error, dataInnerPass)
{
	var noSpaceName = dataInnerPass['name'].replace(/\s/g, '');
	var nameForBackground = "innerFirstDevBox"+noSpaceName;
	if(document.getElementById(nameForBackground))
	{
		pollFailureInner(xhr, error, noSpaceName, nameForBackground);
	}
	else
	{
		//get all with class of id
		var subBoxes = document.getElementsByClassName(dataInnerPass["id"]);
		var countOfBoxes = subBoxes.length;
		if(countOfBoxes > 0)
		{
			for(var i = 0; i < countOfBoxes; i++)
			{
				nameForBackground = subBoxes[i].getElementsByClassName("innerFirstDevBox")[0].id;
				noSpaceName = nameForBackground.replace("innerFirstDevBox", "");
				pollFailureInner(xhr, error, noSpaceName, nameForBackground);
			}
		}
	}
}

function pollFailureInner(xhr, error, noSpaceName, nameForBackground)
{
	switchToColorLed(noSpaceName, "red");
	document.getElementById(noSpaceName+'redwWarning').onclick = function(){showPopupWithMessage('Error','Could not connect to server')};
	document.getElementById(noSpaceName+'errorMessageLink').style.display = "block";
	document.getElementById(noSpaceName+'errorMessageLink').onclick = function(){showPopupWithMessage('Error','Could not connect to server')};
    if(document.getElementById(noSpaceName+'Stats').innerHTML != JSON.stringify(error) && document.getElementById(noSpaceName+'Stats').innerHTML == "--Pending--")
	{
	    var dataBranchForFile = '<span id="'+noSpaceName+'";">Error</span>';
	    var dataBranchForFileUpdateTime = '<span id="'+noSpaceName+'Update";">'+JSON.stringify(xhr)+'</span>';
	    document.getElementById(noSpaceName+'UpdateOuter').style.display = "none";
	    var dataBranchForFileStats = '<span id="'+noSpaceName+'Stats";">'+JSON.stringify(error)+'</span>';
	    displayDataFromPoll(noSpaceName,dataBranchForFile,dataBranchForFileUpdateTime,dataBranchForFileStats)
	    filterBGColor('error', nameForBackground, 1);
	}

	if(arrayOfWatchFilters && !arrayOfWatchFilters[noSpaceName])
	{
		arrayOfWatchFilters[noSpaceName] = {
				data: dataBranchForFile,
				time: dataBranchForFileUpdateTime,
				status: dataBranchForFileStats,
				errorStatus : true,
				backgroundColor : (document.getElementById(nameForBackground).style.backgroundColor),
				messageTextEnabled: false,
				messageText: null,
				enableBlockUntilDate: false,
				datePicker: null,
				groupInfo: "",
				location: null,
				WebsiteBase: null,
				website: null,
				urlHit: ""
			};
	}
	else
	{
		if(arrayOfWatchFilters[noSpaceName]["errorStatus"] == false)
		{
			//new error
			arrayOfWatchFilters[noSpaceName]["errorStatus"] = true;
			filterBGColor('error', nameForBackground, 0.5);
		}
		arrayOfWatchFilters[noSpaceName]["backgroundColor"] = document.getElementById(nameForBackground).style.backgroundColor;
		arrayOfWatchFilters[noSpaceName]["messageTextEnabled"] = false;
		arrayOfWatchFilters[noSpaceName]["groupInfo"] = "";
		if(!("location" in arrayOfWatchFilters[noSpaceName]))
		{
			arrayOfWatchFilters[noSpaceName]["location"] = null;
		}
		if(!("WebsiteBase" in arrayOfWatchFilters[noSpaceName]))
		{
			arrayOfWatchFilters[noSpaceName]["WebsiteBase"] = null;
		}
		if(!("Website" in arrayOfWatchFilters[noSpaceName]))
		{
			arrayOfWatchFilters[noSpaceName]["website"] = null;
		}
		if(!("urlHit" in arrayOfWatchFilters[noSpaceName]))
		{
			arrayOfWatchFilters[noSpaceName]["urlHit"] = "";
		}
	}
	hideLoadingSpinnerHeader(noSpaceName);
	document.getElementById("refreshDiv").style.display = "inline-block";
	pollCompleteLogic();
}

function pollSuccess(dataInner, dataInnerPass)
{
	if(pollType === "1")
	{
		pollSuccessInner(dataInner, dataInnerPass, {});
	}
	else if(pollType === "2")
	{
		if("info" in dataInner)
		{
			if("blocked" in dataInner["info"] && dataInner["info"]["blocked"] == "true")
			{
				if(!blocekdInnerObj[name])
				{
					blocekdInnerObj[name] = {};
				}
				blocekdInnerObj[name]["datePicker"] = dataInner["info"]["blocked"];
				blocekdInnerObj[name]["enableBlockUntilDate"] = dataInner["info"]["blockedUntil"];
				pollFailure("Error","Blocked Request", dataInnerPass);
			}
			else
			{
				decreaseSpinnerCounter();
				var keysInfo = Object.keys(dataInner["info"]);
				var keysInfoLength = keysInfo.length;
				var currentClass = dataInnerPass["id"];
				var classObjects = $("."+currentClass);
				var classObjectsKeysLength = classObjects.length;
				for(var h = 0; h < classObjectsKeysLength; h++)
				{
					var iFound = false;
					for(var i = 0; i < keysInfoLength; i++)
					{
						var name = "branchNameDevBox1"+keysInfo[i];
						name = name.replace(/\s/g, '_');
						if(classObjects[h].contains($("."+currentClass+" #"+name)[0]))
						{
							dataInner["info"][keysInfo[i]]["name"] = name;
							pollSuccessInner(dataInner["info"][keysInfo[i]],dataInner["info"][keysInfo[i]], dataInnerPass);
							iFound = true;
							break;
						}
					}
					if(!iFound)
					{
						var failName = $("."+currentClass)[h].innerHTML.split("innerFirstDevBox")[2].split("\"")[0].trim();
						var failId = $("."+currentClass)[h].innerHTML.split("id=\"")[2].split("\"")[0].trim();
						if(onServerRemoveRemoveNotError)
						{
							//show error on specific poll
							pollFailure("Error", "Server removed from watchlist", {location: "", name: failName, githubRepo: "", websiteBase: "", id: failId });
						}
						else
						{
							$("."+currentClass)[h].id = "removeThis";
							$("#removeThis").remove();
						}
						//remove from archive
						var noSpaceName = failName.replace(/\s/g, '');
						delete arrayOfWatchFilters[noSpaceName];

					}
				}
				for(var i = 0; i < keysInfoLength; i++)
				{
					var name = "branchNameDevBox1"+keysInfo[i];
					name = name.replace(/\s/g, '_');
					var iFound = false;
					for(var h = 0; h < classObjectsKeysLength; h++)
					{
						if(classObjects[h].contains($("."+currentClass+" #"+name)[0]))
						{
							iFound = true;
							break;
						}
					}
					if(!iFound)
					{
						//new thing, show
						dataInner["info"][keysInfo[i]]["name"] = name;
						pollSuccessInner(dataInner["info"][keysInfo[i]],dataInner["info"][keysInfo[i]], dataInnerPass);
					}
				}
			}
		}
		else
		{
			pollFailure("Error","Incorrect Poll Request Type", dataInnerPass);
		}
	}
}

function generateBranchHistory(dataInner, repoName, baseRepoUrl)
{
	if("branchHistoryList" in dataInner && dataInner["branchHistoryList"].length > 0)
	{
		var htmlToReturn = "<table style=\"word-break; break-all; width: 100%;\" ><tr><th width=\"50%\" ></th><th width=\"50%\" ></th></tr><tr><td>";
		if(repoName !== "")
		{
			htmlToReturn += "<a style=\"color: black;\" target=\"_blank\" href=\"https://"+baseRepoUrl+"/"+repoName+"/tree/"+dataInner["branch"]+"\">";
		}
		htmlToReturn += dataInner["branch"];
		if(repoName !== "")
		{
			htmlToReturn += "</a>";
		}
		htmlToReturn += "</td><td>Current</td></tr>";
		var BHLlength =  dataInner["branchHistoryList"].length;
		for(var BHLcount = 0; BHLcount < BHLlength; BHLcount++)
		{
			if(BHLcount === 0 && dataInner["branchHistoryList"][0]["name"] === dataInner["branch"])
			{
				continue;
			}
			htmlToReturn += "<tr><td>";
			if(repoName !== "")
			{
				htmlToReturn += "<a style=\"color: black;\" target=\"_blank\" href=\"https://"+baseRepoUrl+"/"+repoName+"/tree/"+dataInner["branchHistoryList"][BHLcount]["name"]+"\">";
			}
			htmlToReturn += dataInner["branchHistoryList"][BHLcount]["name"]+"</td><td>"+dataInner["branchHistoryList"][BHLcount]["date"];
			if(repoName !== "")
			{
				htmlToReturn += "</a>";
			}
			htmlToReturn += "</td></tr>";
		}
		htmlToReturn += "</table>";
		return htmlToReturn;
	}
	else
	{
		return "No Branch History Available. Please make sure node is on version 3.2 or greater.";
	}
}

function pollSuccessInner(dataInner, dataInnerPass, dataInnerPassMaster)
{
	var dataToFilterBy = "error";
	var noSpaceName = dataInnerPass['name'].replace(/\s/g, '');
	var groupNames = dataInner["groupInfo"];
	var branchList = false;
	if("branchList" in dataInnerPass && dataInnerPass["branchList"] !== "")
	{
		branchList = dataInnerPass["branchList"];
	}
	if("id" in dataInnerPassMaster)
	{
		groupNames	+= " " + dataInnerPassMaster["id"];
	}
	if(!document.getElementById(noSpaceName))
	{
		//no there, add
		var item = $("#storage .container").html();
		item = item.replace(/{{keyNoSpace}}/g, noSpaceName);
		item = item.replace(/{{name}}/g,dataInner["displayName"]);
		var website = "#";
		if("website" in dataInner)
		{
			var websitePass = dataInner["website"];
			if(dataInner["website"].indexOf("http") === -1)
			{
				websitePass = "http://"+dataInner["website"];
			}
			website = websitePass;
		}
		item = item.replace(/{{website}}/g,website);
		if(branchView === "Standard")
		{
			item = item.replace(/{{upArrow}}/g,"display: none;");
			item = item.replace(/{{downArrow}}/g,"");
			item = item.replace(/{{branchView}}/g,"devBoxContentSecondary");
			item = item.replace(/{{branchViewTwo}}/g,"devBoxContentTertiary");
		}
		else if(branchView === "Expanded")
		{
			item = item.replace(/{{upArrow}}/g,"");
			item = item.replace(/{{downArrow}}/g,"display: none;");
			item = item.replace(/{{branchView}}/g,"devBoxContentSecondaryExpanded");
			item = item.replace(/{{branchViewTwo}}/g,"devBoxContentTertiaryExpanded");
		}
		else
		{
			item = item.replace(/{{upArrow}}/g,"");
			item = item.replace(/{{downArrow}}/g,"");
			item = item.replace(/{{branchView}}/g,"devBoxContentSecondary");
			item = item.replace(/{{branchViewTwo}}/g,"devBoxContentTertiary");
		}
		item = item.replace(/{{groupInfo}}/g,groupNames);
		$("#windows").append(item);
	}
	else
	{
		if(typeof groupNames !== "undefined")
		{
			//check if all classes are there
			var parentElementOfDiv = document.getElementById("innerFirstDevBox"+noSpaceName).parentElement;
			var listOfClasses = parentElementOfDiv.classList;
			var listOfClassesLength = listOfClasses.length;
			var groupNamesArray = groupNames.split(" ");
			var groupNamesArrayLength = groupNamesArray.length;
			for(var i = 0; i < groupNamesArrayLength; i++)
			{
				var grouName = groupNamesArray[i].trim();
				var found = false;
				for(var j = 0; j < listOfClassesLength; j++)
				{
					var classNameTest = listOfClasses[j].trim();
					if(classNameTest === grouName)
					{
						found = true;
						break;
					}
				}
				if(!found)
				{
					parentElementOfDiv.className += parentElementOfDiv.className ? " "+grouName  : grouName;
				}
			}
		}
		var source = "#innerFirstDevBox"+noSpaceName+" .devBoxTitle a";
		if(source && $(source) && $(source)[0] && src)
		{
			var src = $(source)[0].href;
			if(typeof dataInner["website"] !== "undefined" && src !== dataInner["website"])
			{
				var websitePass = dataInner["website"];
				if(dataInner["website"].indexOf("http") === -1)
				{
					websitePass = "http://"+dataInner["website"];
				}
				$(source)[0].href = websitePass;
			}
		}
	}
	addGroup(dataInner["groupInfo"]);
	if(dataInner['branch'] && dataInner['branch'] != 'Location var is too long.')
	{
		var linkList = "";
		switchToColorLed(noSpaceName, "green");
		document.getElementById(noSpaceName+'errorMessageLink').style.display = "none";
		document.getElementById(noSpaceName+'noticeMessageLink').style.display = "none";
		var dataStats = dataInner['stats'].replace("','", "'"+'&#44;'+"'");
	    var dataStats = dataStats.split(", <");
	    var repoName = "";
	    var repoDataPresent = ((typeof dataInner["githubRepo"] !== "undefined" && dataInner["githubRepo"] != 'undefined') && (dataInner["githubRepo"] != ''));
	    if(!repoDataPresent)
	    {
	    	repoDataPresent = ((typeof dataInnerPass["githubRepo"] !== "undefined" && dataInnerPass["githubRepo"] != 'undefined') && (dataInnerPass["githubRepo"] != ''));
	    	if(repoDataPresent)
	    	{
	    		repoName = dataInnerPass["githubRepo"];
	    	}
	    }
	    else
	    {
	    	repoName = dataInner["githubRepo"];
	    }
	    var baseRepoUrl = "github.com"
	    if("gitType" in dataInner)
	    {
	    	var gitType = dataInner["gitType"];
	    	if(gitType === "github")
	    	{
	    		baseRepoUrl = "github.com";
	    	}
	    	else if(gitType === "gitlab")
	    	{
	    		baseRepoUrl = "gitlab.com";
	    	}
	    	if("customGit" in dataInner && customGit !== "")
	    	{
	    		baseRepoUrl = dataInner["customGit"];
	    	}
	    }
	    $("#"+noSpaceName+"BranchHistory").html(generateBranchHistory(dataInner, repoName, baseRepoUrl));
	    var dataBranchForFile = '<span id="'+noSpaceName+'";">';
	    if(repoDataPresent)
	    {
	    	dataBranchForFile += '<a style="color: black;" target="_blank" href="https://'+baseRepoUrl+'/'+repoName+'/tree/'+dataInner['branch']+'">';
	    	linkList += '<a style="color: black;" target="_blank" href="https://'+baseRepoUrl+'/'+repoName+'/tree/'+dataInner['branch']+'">Branch</a>';
	    }
	    dataBranchForFile += dataInner['branch'];
	    if(repoDataPresent)
	    {
	    	dataBranchForFile += '</a>';
	    }
	    var link = "";
	    var linksFromCommitMessage = [];
	    var dataBranchForFileUpdateTime = '<span id="'+noSpaceName+'Update";">'+dataInner['time']+'</span>';
	    document.getElementById(noSpaceName+'UpdateOuter').style.display = "block";
	    document.getElementById(noSpaceName+'Stats').style.display = "block";
	    var dataBranchForFileStats = '<span id="'+noSpaceName+'Stats";">';
	    for(var j = 0; j < dataStats.length; j++)
	    {
	    	if(j != 0)
	    	{
	    		dataBranchForFileStats += "<";
	    	}
	    	dataBranchForFileStats += dataStats[j];
	    	dataBranchForFileStats += "<br><br>";
	    }
	    dataBranchForFileStats +='</span>';
	    if(repoDataPresent)
	    {
		    if(checkForIssueInCommit == "true")
		    {
			    for(var i = 0, len = dataBranchForFileStats.length; i < len; i++)
			    {
					if((dataBranchForFileStats[i] == "#") && (!isNaN(dataBranchForFileStats[i+1])) && (dataBranchForFileStats[i-1] != "&"))
					{
						var j = 1;
				  		var num = "";
				  		if(dataBranchForFileStats[i+j] != " " && (!isNaN(dataBranchForFileStats[i+j])))
				  		{
				  			while((!isNaN(dataBranchForFileStats[i+j])) && dataBranchForFileStats[i+j] != " ")
					  		{
					  			num += dataBranchForFileStats[i+j];
					  			j++;
					  		}
					  		if(!isNaN(num));
					  		{
				  				link = '<a target="_blank" style="color: black;"  href="https://'+baseRepoUrl+'/'+repoName+'/issues/'+num+'">'+dataBranchForFileStats[i]+num+'</a>';
					  			dataBranchForFile += " "+link;
					  			linkList += " "+link;
					  			linksFromCommitMessage.push(num.toString());
						  		dataBranchForFileStats = dataBranchForFileStats.replace(dataBranchForFileStats[i]+num,link);
						  		len = dataBranchForFileStats.length;
						  		i = i + link.length;
					  		}
				  		}
					}
				}
			}
			//loop through filters, if match -> get number, add to title if != link


			//num for start
			if(checkForIssueStartsWithNum == "true")
			{
				var numForStart = "";
				var countForStartLoop = 0;
				var branchName = dataInner['branch'];
				while(!isNaN(branchName.charAt(countForStartLoop)) && countForStartLoop != (branchName.length))
				{
					//starts with number
					numForStart += branchName.charAt(countForStartLoop);
					countForStartLoop++;
				}

				if(numForStart != "" && (linksFromCommitMessage.indexOf(numForStart) == -1))
				{
					link = '<a target="_blank" style="color: black;"  href="https://'+baseRepoUrl+'/'+repoName+'/issues/'+numForStart+'">#'+numForStart+'</a>';
					dataBranchForFile += " "+link;
					linkList += " "+link;
				}
			}


			//num for end
			if(checkForIssueEndsWithNum == "true")
			{
				var numForEnd = "";
				var countForEndLoop = branchName.length - 1;

				while(!isNaN(branchName.charAt(countForEndLoop)) && countForEndLoop != 0)
				{
					numForEnd += branchName.charAt(countForEndLoop);
					countForEndLoop--;
				}
				numForEnd = reverseString(numForEnd);

				if(numForEnd != "" && (linksFromCommitMessage.indexOf(numForEnd) == -1) && numForEnd != numForStart)
				{
					link = '<a target="_blank" style="color: black;"  href="https://'+baseRepoUrl+'/'+repoName+'/issues/'+numForEnd+'">#'+numForEnd+'</a>';
					dataBranchForFile += " "+link;
					linkList += " "+link;
				}
			}

			//other
			if(checkForIssueCustom == "true")
			{
				var arrayOfFilters = ["Issue","issue","Issue_","issue_","Issue-","issue-","revert-"];
				var arrayOfFiltersLength =  arrayOfFilters.length;
				for(var i = 0; i < arrayOfFiltersLength; i++)
				{
					var branchNameTMP = branchName;
					while(branchNameTMP.includes(arrayOfFilters[i]))
					{
						var numForcalc = (branchNameTMP.indexOf(arrayOfFilters[i]) + arrayOfFilters[i].length);
						var numForLinkIssue = "";
						while(!isNaN(branchNameTMP.charAt(numForcalc)) && numForcalc != (branchNameTMP.length))
						{
							numForLinkIssue += branchNameTMP.charAt(numForcalc);
							numForcalc++;
						}

						if(numForLinkIssue != "" && (linksFromCommitMessage.indexOf(numForLinkIssue) == -1) && numForLinkIssue != numForStart && numForLinkIssue != numForEnd)
						{
							link = '<a target="_blank" style="color: black;"  href="https://'+baseRepoUrl+'/'+repoName+'/issues/'+numForLinkIssue+'">#'+numForLinkIssue+'</a>';
							dataBranchForFile += " "+link;
							linkList += " "+link;
						}
						branchNameTMP = branchNameTMP.substring(numForcalc);
					}
				}
			}
		}
		dataBranchForFile += '</span>';
		var nameForBackground = "innerFirstDevBox"+noSpaceName;
	    dataToFilterBy = dataInner['branch'];
	    if(branchColorFilter == "authorName")
	    {
	    	dataToFilterByArray = dataBranchForFileStats.split("<br>");
	    	dataToFilterByArray = dataToFilterByArray[0].split("</b>");
	    	dataToFilterBy = $.trim(dataToFilterByArray[1]);

	    }
	    else if(branchColorFilter == "committerName")
	    {
	    	dataToFilterByArray = dataBranchForFileStats.split("<br>");
	    	dataToFilterByArray = dataToFilterByArray[0].split("</b>");
	    	dataToFilterBy = $.trim(dataToFilterByArray[1]);
	    }
	    var setFadeBool = false;
	    var urlHit = "";
	    if("urlForSend" in dataInnerPassMaster)
	    {
	    	let urlCheck = dataInnerPassMaster["urlForSend"] + "/core/php/functions/gitBranchName.php?format=json";
	    	if(dataInnerPassMaster["urlForSend"] !== "http://"+urlCheck || dataInnerPassMaster["urlForSend"] !== "https://"+urlCheck)
	    	{
	    		urlHit = dataInnerPassMaster["urlForSend"];
	    	}
	    }
	    if(arrayOfWatchFilters && !arrayOfWatchFilters[noSpaceName])
		{
			arrayOfWatchFilters[noSpaceName] = {
				data: dataBranchForFile,
				time: dataBranchForFileUpdateTime,
				status: dataBranchForFileStats,
				errorStatus : false,
				backgroundColor : (document.getElementById(nameForBackground).style.backgroundColor),
				messageTextEnabled: false,
				messageText: null,
				enableBlockUntilDate: false,
				datePicker: null,
				groupInfo: groupNames,
				location: "location" in dataInner ? dataInner["location"] : null,
				WebsiteBase: "WebsiteBase" in dataInner ? dataInner["WebsiteBase"] : null,
				website: "website" in dataInner ? dataInner["website"] : null,
				branchList: branchList,
				urlHit: urlHit
			};
		}
		else
		{
			//check if new
			if(arrayOfWatchFilters[noSpaceName]["data"] !== dataBranchForFile)
			{
				setFadeBool = true;
			}
			arrayOfWatchFilters[noSpaceName]["data"] = dataBranchForFile;
			arrayOfWatchFilters[noSpaceName]["time"] = dataBranchForFileUpdateTime;
			arrayOfWatchFilters[noSpaceName]["status"] = dataBranchForFileStats;
			if(arrayOfWatchFilters[noSpaceName]["errorStatus"] == true)
			{
				//was error
				arrayOfWatchFilters[noSpaceName]["errorStatus"] = false;
			}
			arrayOfWatchFilters[noSpaceName]["groupInfo"] = groupNames;
			arrayOfWatchFilters[noSpaceName]["location"] = "location" in dataInner ? dataInner["location"] : null;
			arrayOfWatchFilters[noSpaceName]["WebsiteBase"] = "WebsiteBase" in dataInner ? dataInner["WebsiteBase"] : null;
			arrayOfWatchFilters[noSpaceName]["website"] = "website" in dataInner ? dataInner["website"] : null;
			arrayOfWatchFilters[noSpaceName]["branchList"] = branchList;
			arrayOfWatchFilters[noSpaceName]["urlHit"] = urlHit;
		}

		filterBGColor(dataToFilterBy, nameForBackground, 1);
		arrayOfWatchFilters[noSpaceName]["backgroundColor"] = document.getElementById(nameForBackground).style.backgroundColor;
		//custom message stuff
		if(Object.values(dataInner).indexOf('messageTextEnabled') > -1)
		{

			var dateForEnd = dataInner['datePicker'];
			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();

			if(dd<10) {
			    dd='0'+dd
			}

			if(mm<10) {
			    mm='0'+mm
			}

			today = mm+'/'+dd+'/'+yyyy;

			if(dataInner['messageTextEnabled'] == 'true')
			{
				arrayOfWatchFilters[noSpaceName]["messageTextEnabled"] = true;
				arrayOfWatchFilters[noSpaceName]["messageText"] = dataInner['messageText'];
				document.getElementById(noSpaceName+'NoticeMessage').innerHTML = dataInner['messageText'];
			}
			else
			{
				arrayOfWatchFilters[noSpaceName]["messageTextEnabled"] = false;
				arrayOfWatchFilters[noSpaceName]["messageText"] = null;
				document.getElementById(noSpaceName+'NoticeMessage').innerHTML = "";
				document.getElementById(noSpaceName+'NoticeMessage').style.display = "none";
			}
			if(dataInner['enableBlockUntilDate'] == 'true' && dateForEnd >= today)
			{
				arrayOfWatchFilters[noSpaceName]["enableBlockUntilDate"] = true;
				arrayOfWatchFilters[noSpaceName]["datePicker"] = dataInner['datePicker'];
				document.getElementById(noSpaceName+'NoticeMessage').innerHTML += " Blocking poll requests untill: "+dataInner['datePicker'];
			}
			else
			{
				arrayOfWatchFilters[noSpaceName]["enableBlockUntilDate"] = false;
			}
			if(dataInner['messageTextEnabled'] == 'true' || dataInner['enableBlockUntilDate'] == 'true')
			{
				switchToColorLed(noSpaceName, "yellow");
				document.getElementById(noSpaceName+'NoticeMessage').style.display = "inline-block";
			}
			else
			{
				switchToColorLed(noSpaceName, "green");
				document.getElementById(noSpaceName+'NoticeMessage').style.display = "none";
			}
		}

		//Log-Hog / monitor
		if(dataInner.hasOwnProperty("loghog"))
		{
			if(dataInner['loghog'] != "")
			{
				document.getElementById(noSpaceName+"LogHogOuter").style.display = "inline-block";
  				document.getElementById(noSpaceName+"LogHogInner").href = "http://"+dataInner['loghog'];
			}

			if(dataInner['monitor'] != "")
			{
				document.getElementById(noSpaceName+"MonitorOuter").style.display = "inline-block";
  				document.getElementById(noSpaceName+"MonitorInner").href = "http://"+dataInner['monitor'];
			}

			if(dataInner['search'] != "")
			{
				document.getElementById(noSpaceName+"SearchOuter").style.display = "inline-block";
  				document.getElementById(noSpaceName+"SearchInner").href = "http://"+dataInner['search'];
			}
		}


		if(linkList !== "" && linkList !== document.getElementById(noSpaceName+"extraLinks").innerHTML)
		{
			document.getElementById(noSpaceName+"extraLinks").innerHTML = linkList;
		}

		if(setFadeBool)
		{
			setFade(noSpaceName);
		}
	}
	else
	{
		var errorMessage = "No Data Recieved from server. Probably could not execute command";
		if(dataInner['branch'] == 'Location var is too long.')
		{
			errorMessage = "Location var is too long.";
		}
		//assume no data was recieved
		switchToColorLed(noSpaceName, "red");
		document.getElementById(noSpaceName+'errorMessageLink').style.display = "block";
		document.getElementById(noSpaceName+'errorMessageLink').onclick = function(){showPopupWithMessage('Error',errorMessage)};
	    var dataBranchForFile = '<span id="'+noSpaceName+'";">Error</span>';
	    var dataBranchForFileUpdateTime = '<span id="'+noSpaceName+'Update";">n/a</span>';
	    var dataBranchForFileStats = '<span id="'+noSpaceName+'Stats";">'+errorMessage+'</span>';
	    var nameForBackground = "innerFirstDevBox"+noSpaceName;
	    if(arrayOfWatchFilters && !arrayOfWatchFilters[noSpaceName])
		{
			arrayOfWatchFilters[noSpaceName] = {
				data: dataBranchForFile,
				time: dataBranchForFileUpdateTime,
				status: dataBranchForFileStats,
				errorStatus : true,
				backgroundColor : (document.getElementById(nameForBackground).style.backgroundColor),
				messageTextEnabled: false,
				messageText: null,
				enableBlockUntilDate: false,
				datePicker: null,
				groupInfo: "",
				location: null,
				WebsiteBase: null,
				website: null,
				branchList: false
			};
		}
		else
		{
			if(arrayOfWatchFilters[noSpaceName]["errorStatus"] == false)
			{
				//new error
				arrayOfWatchFilters[noSpaceName]["errorStatus"] = true;
				filterBGColor('error', nameForBackground, 0.5);
			}
			arrayOfWatchFilters[noSpaceName]["backgroundColor"] = document.getElementById(nameForBackground).style.backgroundColor;
			arrayOfWatchFilters[noSpaceName]["messageTextEnabled"] = false;
			arrayOfWatchFilters[noSpaceName]["groupInfo"] = "";
			arrayOfWatchFilters[noSpaceName]["branchList"] = false;
			if(!("location" in arrayOfWatchFilters[noSpaceName]))
			{
				arrayOfWatchFilters[noSpaceName]["location"] = null;
			}
			if(!("WebsiteBase" in arrayOfWatchFilters[noSpaceName]))
			{
				arrayOfWatchFilters[noSpaceName]["WebsiteBase"] = null;
			}
			if(!("Website" in arrayOfWatchFilters[noSpaceName]))
			{
				arrayOfWatchFilters[noSpaceName]["website"] = null;
			}
		}
	}
	displayDataFromPoll(noSpaceName,dataBranchForFile,dataBranchForFileUpdateTime,dataBranchForFileStats);
	hideLoadingSpinnerHeader(noSpaceName);
	pollCompleteLogic();
}

function switchToColorLed(noSpaceName, type)
{
	var typeArray = {red: {0: "inline-block", 1: "none", 2: "none"}, yellow: {0: "none", 1: "inline-block", 2: "none"}, green: {0: "none", 1: "none", 2: "inline-block"}};
	if(document.getElementById(noSpaceName+'redwWarning'))
	{
		document.getElementById(noSpaceName+'redwWarning').style.display = typeArray[type][0];
		document.getElementById(noSpaceName+'yellowWarning').style.display = typeArray[type][1];
		document.getElementById(noSpaceName+'greenNotice').style.display = typeArray[type][2];
	}
}

function displayDataFromPoll(noSpaceName,dataBranchForFile,dataBranchForFileUpdateTime,dataBranchForFileStats)
{
	document.getElementById(noSpaceName+'Stats').style.display = "block";
	document.getElementById(noSpaceName).outerHTML = dataBranchForFile;
	document.getElementById(noSpaceName+'Update').outerHTML = dataBranchForFileUpdateTime;
	document.getElementById(noSpaceName+'Stats').outerHTML = dataBranchForFileStats;
}

function reverseString(str)
{
    return str.split("").reverse().join("");
}


function filterBGColor(filterName, idName, opacity)
{
	var newBG = false;
	var filterByThisArray = errorAndColorComitteeArray;
	var defaultColor = "#777777";
	if (branchColorFilter == "branchName")
	{
		filterByThisArray = errorAndColorArray;
	}
	else if (branchColorFilter == "authorName")
	{
		filterByThisArray = errorAndColorAuthorArray;
	}

	for(var property in filterByThisArray)
	{
		if(!(filterByThisArray.hasOwnProperty(property)))
		{
			continue;
		}
		if(filterByThisArray[property].type == "includes")
		{
			if(filterName.includes(property))
			{
				newBG = true;
			}
		}
		else
		{
			if(filterName == property)
			{
				newBG = true;
			}
		}
		if(newBG)
		{
			if(opacity != 1)
			{
				document.getElementById(idName).style.backgroundColor = $.xcolor.opacity((filterByThisArray[property].color), (document.getElementById(idName).style.backgroundColor), opacity);
			}
			else
			{
				document.getElementById(idName).style.backgroundColor = "#"+filterByThisArray[property].color;
			}
			break;
		}
	}
	if(!newBG)
	{
		document.getElementById(idName).style.backgroundColor = defaultColor;
	}
}

function refreshAction(all = -1, status = 'outer')
{
	clearTimeout(refreshActionVar);
	var counterNew = 0;
	var refreshNum = parseInt(all);
	if(refreshNum !== -1)
	{
		if(isNaN(refreshNum))
		{
			counterForSave = counterNew;
			tryHTTPForPollRequest(null, all);
			refreshActionVar = setTimeout(function(){endRefreshAction()}, 1500);
		}
	}
	else
	{
		poll();
		refreshActionVar = setTimeout(function(){endRefreshAction()}, 1500);
	}
}

function endRefreshAction()
{
	if(isPaused())
	{
		document.title = "Git Status | Paused";
	}
	else
	{
		document.title = "Git Status | Index";
	}
}

function togglePlayPause()
{
	if(!isPaused())
	{
		document.getElementById("pauseImage").style.display = "none";
		document.getElementById("playImage").style.display = "inline-block";
	}
	else
	{
		document.getElementById("pauseImage").style.display = "inline-block";
		document.getElementById("playImage").style.display = "none";
	}
}

function isPaused()
{
	if(document.getElementById("pauseImage").style.display !== "none")
	{
		return false;
	}
	return true;
}

function pausePollAction()
{
	if(isPaused())
	{
		togglePlayPause();
		startPoll();
	}
	else
	{
		pausePollFunction();
	}
}

function pausePollFunction()
{
	togglePlayPause();
	document.title = "Status | Paused";
	Visibility.stop(pollTimer);
}

function startPoll()
{
	pollTimer = Visibility.every(pollingRate, pollingRateBG, function () { poll(); });
}

function singleDecreaseView(idOfBlock)
{
	if($('#innerFirstDevBox'+idOfBlock+' .devBoxContentSecondaryExpanded').hasClass('devBoxContentSecondaryExpanded'))
	{
		if($('#innerFirstDevBox'+idOfBlock+' .devBoxContentSecondaryExpanded .devBoxContentTertiaryExpanded').hasClass('devBoxContentTertiaryExpanded'))
		{
			$('#innerFirstDevBox'+idOfBlock+' .devBoxContentTertiaryExpanded').addClass('devBoxContentTertiary');
			$('#innerFirstDevBox'+idOfBlock+' .devBoxContentTertiaryExpanded').removeClass('devBoxContentTertiaryExpanded');
		}
		else
		{
			$('#innerFirstDevBox'+idOfBlock+' .devBoxContentSecondaryExpanded').addClass('devBoxContentSecondary');
			$('#innerFirstDevBox'+idOfBlock+' .devBoxContentSecondaryExpanded').removeClass('devBoxContentSecondaryExpanded');
			$("#"+idOfBlock+"UpArrow").addClass("disabledArrow");
		}
		$("#"+idOfBlock+"DownArrow").removeClass("disabledArrow");
	}
}

function singleIncreaseView(idOfBlock)
{
	if($('#innerFirstDevBox'+idOfBlock+' .devBoxContentTertiary').hasClass('devBoxContentTertiary'))
	{
		if($('#innerFirstDevBox'+idOfBlock+' .devBoxContentSecondaryExpanded').hasClass('devBoxContentSecondaryExpanded'))
		{
			$('#innerFirstDevBox'+idOfBlock+' .devBoxContentTertiary').addClass('devBoxContentTertiaryExpanded');
			$('#innerFirstDevBox'+idOfBlock+' .devBoxContentTertiary').removeClass('devBoxContentTertiary');
			$("#"+idOfBlock+"DownArrow").addClass("disabledArrow");
		}
		else
		{
			$('#innerFirstDevBox'+idOfBlock+' .devBoxContentSecondary').addClass('devBoxContentSecondaryExpanded');
			$('#innerFirstDevBox'+idOfBlock+' .devBoxContentSecondary').removeClass('devBoxContentSecondary');
		}
		$("#"+idOfBlock+"UpArrow").removeClass("disabledArrow");
	}
}

function switchToMinimizedView()
{
	if($('#minimizedViewButtonMainSection').hasClass('buttonSlectorInnerBoxes'))
	{
		if(defaultViewBranchCookie = "true")
		{
			document.cookie = "defaultViewBranchCookie=Minimized";
		}
		removeAllButtonSelectorClasses('minimizedViewButtonMainSection');
		branchView = "Minimized";
		$('#minimizedViewButtonMainSection').addClass('buttonSlectorInnerBoxesSelected');
		$('#minimizedViewButtonMainSection').removeClass('buttonSlectorInnerBoxes');

		$('.devBoxContentSecondaryExpanded').addClass('devBoxContentSecondary');
		$('.devBoxContentSecondaryExpanded').removeClass('devBoxContentSecondaryExpanded');

		$('.devBoxContentTertiaryExpanded').addClass('devBoxContentTertiary');
		$('.devBoxContentTertiaryExpanded').removeClass('devBoxContentTertiaryExpanded');

		$(".downArrow").removeClass("disabledArrow");
		$(".upArrow").addClass("disabledArrow");
	}
}

function switchToStandardView()
{
	if($('#standardViewButtonMainSection').hasClass('buttonSlectorInnerBoxes'))
	{
		if(defaultViewBranchCookie = "true")
		{
			document.cookie = "defaultViewBranchCookie=Standard";
		}
		removeAllButtonSelectorClasses('standardViewButtonMainSection');
		branchView = "Standard";
		$('#standardViewButtonMainSection').addClass('buttonSlectorInnerBoxesSelected');
		$('#standardViewButtonMainSection').removeClass('buttonSlectorInnerBoxes');

		$('.devBoxContentSecondary').addClass('devBoxContentSecondaryExpanded');
		$('.devBoxContentSecondary').removeClass('devBoxContentSecondary');

		$('.devBoxContentTertiaryExpanded').addClass('devBoxContentTertiary');
		$('.devBoxContentTertiaryExpanded').removeClass('devBoxContentTertiaryExpanded');

		$(".downArrow").removeClass("disabledArrow");
		$(".upArrow").removeClass("disabledArrow");
	}
}

function switchToExpandedView()
{
	if($('#expandedViewButtonMainSection').hasClass('buttonSlectorInnerBoxes'))
	{
		if(defaultViewBranchCookie = "true")
		{
			document.cookie = "defaultViewBranchCookie=Expanded";
		}
		removeAllButtonSelectorClasses('expandedViewButtonMainSection');
		branchView = "Expanded";
		$('#expandedViewButtonMainSection').addClass('buttonSlectorInnerBoxesSelected');
		$('#expandedViewButtonMainSection').removeClass('buttonSlectorInnerBoxes');

		$('.devBoxContentSecondary').addClass('devBoxContentSecondaryExpanded');
		$('.devBoxContentSecondary').removeClass('devBoxContentSecondary');

		$('.devBoxContentTertiary').addClass('devBoxContentTertiaryExpanded');
		$('.devBoxContentTertiary').removeClass('devBoxContentTertiary');

		$(".downArrow").addClass("disabledArrow");
		$(".upArrow").removeClass("disabledArrow");
	}
}

function removeAllButtonSelectorClasses(ignore)
{
	if(ignore != 'standardViewButtonMainSection')
	{
		if($('#standardViewButtonMainSection').hasClass('buttonSlectorInnerBoxesSelected'))
		{
			$('#standardViewButtonMainSection').removeClass('buttonSlectorInnerBoxesSelected');
			$('#standardViewButtonMainSection').addClass('buttonSlectorInnerBoxes');
		}
	}

	if(ignore != 'expandedViewButtonMainSection')
	{
		if($('#expandedViewButtonMainSection').hasClass('buttonSlectorInnerBoxesSelected'))
		{
			$('#expandedViewButtonMainSection').removeClass('buttonSlectorInnerBoxesSelected');
			$('#expandedViewButtonMainSection').addClass('buttonSlectorInnerBoxes');

		}
	}

	if(ignore != 'minimizedViewButtonMainSection')
	{
		if($('#minimizedViewButtonMainSection').hasClass('buttonSlectorInnerBoxesSelected'))
		{
			$('#minimizedViewButtonMainSection').removeClass('buttonSlectorInnerBoxesSelected');
			$('#minimizedViewButtonMainSection').addClass('buttonSlectorInnerBoxes');

		}
	}
}

function calcuateWidth()
{
	var innerWidthWindow = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
	var mainWidth = 0;
	if(document.getElementById("sidebar").style.width == '100px')
	{
		innerWidthWindow -= 103;
		mainWidth = 103;
	}
	document.getElementById("main").style.left = ""+mainWidth+"px";

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
	if(document.getElementById("sideBox").style.display !== "none")
	{
		windowWidthText = innerWidthWindow+"px";
	}
	document.getElementById("main").style.width = windowWidthText;
	var remainingWidth = innerWidthWindow - ((innerWidthWindowCalcAdd)+40);
	remainingWidth = remainingWidth / 2;
	var windowWidthText = remainingWidth+"px";
	if(document.getElementById("sideBox").style.display !== "none")
	{
		windowWidthText = "0px";
	}
	document.getElementById("main").style.paddingLeft = windowWidthText;
	document.getElementById("main").style.paddingRight = windowWidthText;
	if(document.getElementById("sideBox").style.display !== "none")
	{
		document.getElementById("sideBox").style.width = ((innerWidthWindow)-410)+"px";
	}
	document.getElementById("iframeForStuff").style.width = ((innerWidthWindow)-415)+"px";
}

function showOrHideGroups(event, groupName)
{
	//change tab to selected / unselected
	if((event.ctrlKey || event.metaKey) && groupName !== "All")
	{
		event.preventDefault();
		if($('#GroupAll').hasClass('groupTabSelected'))
		{
			$('#GroupAll').removeClass('groupTabSelected');
		}
		//if hold ctrl and not 'all'
		if($('#Group'+groupName).hasClass('groupTabSelected'))
		{
			$('#Group'+groupName).removeClass('groupTabSelected');
		}
		else
		{
			$('#Group'+groupName).addClass('groupTabSelected');
		}
	}
	else
	{
		if($('#Group'+groupName).hasClass('groupTabSelected') && $('.groupTab.groupTabSelected').length == 1)
		{
			$('.groupTab').removeClass('groupTabSelected');
			$('#GroupAll').addClass('groupTabSelected');
		}
		else
		{
			$('.groupTab').removeClass('groupTabSelected');
			$('#Group'+groupName).addClass('groupTabSelected');
		}
	}

	//show / hide groups
	updateGroupsShown();
}

function updateGroupsShown()
{
	if($(".groupTabSelected")[0].attributes["data-group"].value != "All")
	{
		$('.firstBoxDev').hide();
		$('.pinned').show();
		var lengthOfGroups = $(".groupTabSelected").length;
		for(var counterOfGroups = 0; counterOfGroups < lengthOfGroups; counterOfGroups++)
		{
			$('.'+$(".groupTabSelected")[counterOfGroups].attributes["data-group"].value).show();
		}
	}
	else
	{
		$('.firstBoxDev').show();
	}
}

function dropdownShow(nameOfElem)
{
    if(document.getElementById("dropdown-"+nameOfElem).style.display == 'block')
    {
    	$('.dropdown-content').hide();
    	$('.dropdown-content').css('margin-top',"0px");
    	currentOpenMenu = "";
    }
    else
    {
    	$('.dropdown-content').hide();
    	var currentElement = document.getElementById("dropdown-"+nameOfElem);
    	currentElement.style.display = 'block';
    	currentElement.style.marginTop = "0px";
    	$("#dropdown-"+nameOfElem).css("top" , "" + ($("#innerFirstDevBox"+nameOfElem+" .expandMenu").position().top + $("#innerFirstDevBox"+nameOfElem+" .expandMenu").height()) + "px")
    	currentElement = document.getElementById("dropdown-"+nameOfElem);
    	var elementLowestPosition = (currentElement.getBoundingClientRect().top+currentElement.offsetHeight);
    	var heightWindow = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
    	if(elementLowestPosition > heightWindow)
    	{
    		currentElement.style.marginTop = "-"+(currentElement.offsetHeight+25)+"px";
    	}
    	currentOpenMenu = nameOfElem;
    }
}

$( "#windows" ).scroll(function() {
	let nameOfElem = currentOpenMenu;
	if(nameOfElem === "")
	{
		return;
	}
  	if(document.getElementById("dropdown-"+nameOfElem).style.display === 'block')
  	{
  		let heightWindow = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
  		if($("#innerFirstDevBox"+nameOfElem+" .expandMenu").position().top < 0 || ($("#innerFirstDevBox"+nameOfElem+" .expandMenu").position().top) > heightWindow)
  		{
  			forceCloseDropdownMenu();
  		}
  		else
  		{
  			let currentElement = document.getElementById("dropdown-"+nameOfElem);
  			$("#dropdown-"+nameOfElem).css("top" , "" + ($("#innerFirstDevBox"+nameOfElem+" .expandMenu").position().top + $("#innerFirstDevBox"+nameOfElem+" .expandMenu").height()) + "px")
  			let elementLowestPosition = (currentElement.getBoundingClientRect().top+currentElement.offsetHeight);
	    	let heightWindow = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
	    	if(elementLowestPosition > heightWindow)
	    	{
	    		currentElement.style.marginTop = "-"+(currentElement.offsetHeight+25)+"px";
	    	}
  		}
  	}
});

window.onclick = function(event) {
	if (!event.target.matches('.expandMenu'))
	{
		forceCloseDropdownMenu();
	}
}

function forceCloseDropdownMenu()
{
	$('.dropdown-content').hide();
	$('.dropdown-content').css('margin-top',"0px");
	currentOpenMenu = "";
}

function showUpdateCheckPopup(data)
{
	showPopup();
	var textForInnerHTML = "<div class='devBoxTitle' >New Version Available!</div><br><div style='width:100%;text-align:center;'>Version "+escapeHTML(data.versionNumber)+" is now available!</div><div class='buttonButton' onclick='installUpdates();' style='margin-left:50px; margin-right:50px;margin-top:25px;'>Update Now</div><div onclick='saveSettingFromPopupNoCheckMaybe();' class='buttonButton' style='margin-left:50px; margin-right:50px;margin-top:10px;'>Maybe Later</div><br><div style='width:100%; padding-left:45px; padding-top:5px;'>";
	textForInnerHTML += "<span style='display: none;'>";
	textForInnerHTML += "<input id='dontShowPopuForThisUpdateAgain'";
	if(dontNotifyVersion == data.versionNumber)
	{
		//textForInnerHTML += " checked "
	}
	dontNotifyVersion = data.versionNumber;
	textForInnerHTML += "type='checkbox'>Don't notify me about this update again";
	textForInnerHTML += "</span>";
	textForInnerHTML += "</div></div>";
	document.getElementById("popupContentInnerHTMLDiv").innerHTML = textForInnerHTML;
}

function saveSettingFromPopupNoCheckMaybe()
{
	if(document.getElementById("dontShowPopuForThisUpdateAgain").checked)
	{
		var urlForSend = "core/php/settingsSaveAjax.php?format=json";
		var data = {dontNotifyVersion: dontNotifyVersion };
		$.ajax({
				  url: urlForSend,
				  dataType: "json",
				  data: data,
				  type: "POST",
		complete: function(data){
			hidePopup();
  	},
		});
	}
	else
	{
	hidePopup();
	}
}

function installUpdates()
{
    displayLoadingPopup();
	//reset vars in post request
	var urlForSend = 'core/php/update/resetUpdateFilesToDefault.php?format=json'
	var data = {status: "" };
	$.ajax(
	{
		url: urlForSend,
		dataType: "json",
		data: data,
		type: "POST",
		complete: function(data)
		{
			//set thing to check for updated files.
			timeoutVar = setInterval(function(){verifyChange();},3000);
		}
	});
}

function verifyChange()
{
    var urlForSend = 'update/updateActionCheck.php?format=json'
	var data = {status: "" };
	$.ajax(
	{
		url: urlForSend,
		dataType: "json",
		data: data,
		type: "POST",
		success(data)
		{
			if(data == 'finishedUpdate')
			{
				clearInterval(timeoutVar);
				actuallyInstallUpdates();
			}
		}
	});
}

function actuallyInstallUpdates()
{
    $("#settingsInstallUpdate").submit();
}

function resetDevBoxTitleColor()
{
	$(".devBoxTitle , .devBoxActions").css("background-color","");
}

function setDevBoxTitleColor(key)
{
	$("#innerFirstDevBox"+key+" .devBoxTitle , #innerFirstDevBox"+key+" .devBoxActions").css("background-color","#FFFFFF");
}

function toggleDetailBar(e, key)
{
	resetDevBoxTitleColor();
	setDevBoxTitleColor(key);
	if(document.getElementById("sideBox").style.display == "none")
	{
		document.getElementById("sideBox").style.display = "inline-block";
		document.getElementById("windows").style.width = "365px";
	}
	currentIdOfMainSidebar = key;
	resizeFunction();

	//external Links
	document.getElementById("LogHogTab").style.display = "none";
	document.getElementById("MonitorTab").style.display = "none";
	document.getElementById("SearchTab").style.display = "none";
	if(document.getElementById(key+"LogHogInner").href != window.location.href+"#" && document.getElementById(key+"LogHogInner").href != "#" && document.getElementById(key+"LogHogInner").href != "")
	{
		document.getElementById("LogHogTab").style.display = "inline-block";
	}
	if(document.getElementById(key+"MonitorInner").href != window.location.href+"#" && document.getElementById(key+"MonitorInner").href != "#" && document.getElementById(key+"MonitorInner").href != "")
	{
		document.getElementById("MonitorTab").style.display = "inline-block";
	}
	if(document.getElementById(key+"SearchInner").href != window.location.href+"#" && document.getElementById(key+"SearchInner").href != "#" && document.getElementById(key+"SearchInner").href != "")
	{
		document.getElementById("SearchTab").style.display = "inline-block";
	}

	//info
	if($("#infoTab").hasClass("selectedButton"))
	{
		getInfo();
	}
	else if($("#commitsTab").hasClass("selectedButton"))
	{
		getListOfCommits();
	}
	else
	{
		if(defaultExpandTab === "info")
		{
			toggleInfoTab();
		}
		else if(defaultExpandTab === "commits") {
			toggleCommitsTab();
		}
	}
}

function closeDetailBar()
{
	$('#iframeForStuff').prop('src', "./iframe.html");
	resetDevBoxTitleColor();
	document.getElementById("sideBox").style.display = "none";
	document.getElementById("windows").style.width = "auto";
	resizeFunction();
}

function hideAllSubFrames()
{
	$(".buttonList li").removeClass("selectedButton");
	document.getElementById("sideBoxBoxForInfo").style.display = "none";
	document.getElementById("iframeHolder").style.display = "none";
	document.getElementById("sideBoxForActualInfo").style.display = "none";
	$('#iframeForStuff').prop('src', "./iframe.html");
}

function toggleCommitsTab()
{
	hideAllSubFrames();
	$("#commitsTab").addClass("selectedButton");
	document.getElementById("sideBoxBoxForInfo").style.display = "block";
	getListOfCommits();
}

function toggleInfoTab()
{
	hideAllSubFrames();
	$("#infoTab").addClass("selectedButton");
	document.getElementById("sideBoxForActualInfo").style.display = "block";
	getInfo();
}

function toggleIframe(site)
{
	hideAllSubFrames();
	if(site == "loghog")
	{
		$("#LogHogTab").addClass("selectedButton");
		$('#iframeForStuff').prop('src', document.getElementById(currentIdOfMainSidebar+"LogHogInner").href);
	}
	else if(site === "monitor")
	{
		$("#MonitorTab").addClass("selectedButton");
		$('#iframeForStuff').prop('src', document.getElementById(currentIdOfMainSidebar+"MonitorInner").href);
	}
	else if(site === "search")
	{
		$("#SearchTab").addClass("selectedButton");
		$('#iframeForStuff').prop('src', document.getElementById(currentIdOfMainSidebar+"SearchInner").href);
	}
	document.getElementById("iframeHolder").style.display = "block";
}

function getInfo()
{
	document.getElementById("gitDiffNoInfo").style.display = "none";
	document.getElementById("gitDiffLoading").style.display = "table-row";
	document.getElementById("tableForCommitHistory").style.display = "none";
	$(".branchInfoGitDiff").hide();
	var idName = currentIdOfMainSidebar;
	if((!(idName in arrayOfWatchFilters)) || (!("WebsiteBase" in arrayOfWatchFilters[idName])) || (arrayOfWatchFilters[idName]["WebsiteBase"] === "") || arrayOfWatchFilters[idName]["location"] === null)
	{
		document.getElementById("gitDiffNoInfo").style.display = "table-row";
		document.getElementById("gitDiffLoading").style.display = "none";
		$("#branchHistoryHolder").html("No Branch History Available.");
		//noot work
		return;
	}
	$("#infoBranchName").html($("#"+idName).html());
	$("#nameMainLeft").html("<b>Name: </b>"+idName.split("branchNameDevBox1")[1]);
	$("#infoMainLeft").html($("#innerFirstDevBox"+idName+" .devBoxContentSecondary").html());
	$("#branchHistoryHolder").html($("#"+idName+"BranchHistory").html());
	getDiffCommits();
}

function getDiffCommits()
{
	var idName = currentIdOfMainSidebar;

	var urlForSend = arrayOfWatchFilters[idName]["WebsiteBase"];
	if(!(urlForSend.indexOf("http") > -1))
	{
		urlForSend = "https://"+urlForSend;
	}
	if(!(urlForSend.indexOf("core") > -1))
	{
		urlForSend += "/status/core/php/functions/";
	}
	urlForSend += "gitCommitDiff.php";
	var branchName = $("#"+idName+" a").html();
	if(branchName === undefined)
	{
		branchName = $("#"+idName).html();
	}
	var branchList = defaultBranchList;
	if(idName in arrayOfWatchFilters && "branchList" in arrayOfWatchFilters[idName] && arrayOfWatchFilters[idName]["branchList"] !== false && arrayOfWatchFilters[idName]["branchList"] !== "")
	{
		branchList = arrayOfWatchFilters[idName]["branchList"];
	}
	var data = {pollType, location: arrayOfWatchFilters[idName]["location"], branchName, branchList};
	(function(_data){
			$.ajax({
			url: urlForSend,
			dataType: 'json',
			global: false,
			data,
			type: 'POST',
			success: function(data)
			{
				showDiffCommits(data);
			},
			error: function(xhr, error)
			{
				getDiffCommitsHttp();
			}
		});
	}(data));
}

function getDiffCommitsHttp()
{
	var idName = currentIdOfMainSidebar;

	var urlForSend = arrayOfWatchFilters[idName]["WebsiteBase"];
	if(!(urlForSend.indexOf("http") > -1))
	{
		urlForSend = "http://"+urlForSend;
	}
	if(!(urlForSend.indexOf("core") > -1))
	{
		urlForSend += "/status/core/php/functions/";
	}
	urlForSend += "gitCommitDiff.php";
	var branchName = $("#"+idName+" a").html();
	if(branchName === undefined)
	{
		branchName = $("#"+idName).html();
	}
	var branchList = defaultBranchList;

	var data = {pollType, location: arrayOfWatchFilters[idName]["location"], branchName, branchList};
	(function(_data){
			$.ajax({
			url: urlForSend,
			dataType: 'json',
			global: false,
			data,
			type: 'POST',
			success: function(data)
			{
				showDiffCommits(data);
			},
			error: function(xhr, error)
			{
				document.getElementById("gitDiffNoInfo").style.display = "table-row";
				document.getElementById("gitDiffLoading").style.display = "none";
			}
		});
	}(data));
}

function showDiffCommits(data)
{
	while(document.getElementById("tableForCommitHistory").rows.length > 0)
	{
		document.getElementById("tableForCommitHistory").deleteRow(0);
	}
	var dataKeys = Object.keys(data);
	var dataKeysLength = dataKeys.length;
	for(var branchNameCount = 0; branchNameCount < dataKeysLength; branchNameCount++)
	{
		var currentBranchName = dataKeys[branchNameCount];
		var currentBranchStats= data[dataKeys[branchNameCount]];
		if(currentBranchStats === "")
		{
			currentBranchStats = "0\t0";
		}
		data[currentBranchName] = {};
		data[currentBranchName]["currentData"] = currentBranchStats;
		if(currentBranchStats !== "Branch Not Found")
		{
			data[currentBranchName]["commitDiff"] = currentBranchStats.split(/\D/);
		}
	}
	var baseForLeft = 0;
	var baseForRight = 0;
	for(var branchNameCount = 0; branchNameCount < dataKeysLength; branchNameCount++)
	{
		var currentBranchName = dataKeys[branchNameCount];
		if("commitDiff" in data[currentBranchName])
		{
			if(baseForLeft < data[currentBranchName]["commitDiff"][0])
			{
				baseForLeft = data[currentBranchName]["commitDiff"][0];
			}
			if(baseForRight < data[currentBranchName]["commitDiff"][1])
			{
				baseForLeft = data[currentBranchName]["commitDiff"][1];
			}
		}
	}
	if(baseForLeft == 0)
	{
		baseForLeft = 1;
	}
	if(baseForRight == 0)
	{
		baseForRight = 1;
	}
	if(baseForRight === undefined || baseForLeft === undefined)
	{
		commitListGetError();
		return;
	}
	for(var branchNameCount = 0; branchNameCount < dataKeysLength; branchNameCount++)
	{
		var currentBranchName = dataKeys[branchNameCount];
		var table = document.getElementById("tableForCommitHistory");
		var newRow = table.rows.length - 1;
		var row = table.insertRow(newRow);
		var cell1 = row.insertCell(0);
	    var cell2 = row.insertCell(1);
	    var cell3 = row.insertCell(2);
	    var cell4 = row.insertCell(3);
	    var cell5 = row.insertCell(4);
	    var cell6 = row.insertCell(5);
	    cell1.innerHTML = "Origin/"+currentBranchName;
	    if("commitDiff" in data[currentBranchName])
	    {
	    	var commitDiffLeft = data[currentBranchName]["commitDiff"][0];
	    	var commitDiffRight = data[currentBranchName]["commitDiff"][1];
			cell2.innerHTML = "- "+commitDiffLeft;
			cell3.innerHTML = "<meter min=\"0\" max=\"1.2\" value=\""+(commitDiffLeft/baseForLeft)+"\" class=\"meterCommit meterCommitLeft\" ></meter>";
			cell4.innerHTML = " | ";
			cell5.innerHTML = "<meter min=\"0\" max=\"1.2\" value=\""+(commitDiffRight/baseForRight)+"\"  class=\"meterCommit meterCommitRight\" ></meter>";
			cell6.innerHTML = "+ "+commitDiffRight;
		}
		else
		{
			cell3.innerHTML = data[currentBranchName]["currentData"];
		}

	}
	document.getElementById("gitDiffLoading").style.display = "none";
	document.getElementById("tableForCommitHistory").style.display = "table";
	$(".branchInfoGitDiff").css("display","table-row");
}

function commitListGetError()
{
	document.getElementById("spinnerLiForSideBoxBoxForInfo").style.display = "none";
	document.getElementById("noChangesToDisplay").style.display = "block";
}


function getListOfCommits()
{
	document.getElementById("noChangesToDisplay").style.display = "none";
	var idName = currentIdOfMainSidebar;
	$("#spanForMainDiff").html("");
	document.getElementById("spinnerLiForSideBoxBoxForInfo").style.display = "list-item";
	$("#otherCommitsFromPast").html("");
	if((!(idName in arrayOfWatchFilters)) || (!("WebsiteBase" in arrayOfWatchFilters[idName])) || (arrayOfWatchFilters[idName]["WebsiteBase"] === "") || arrayOfWatchFilters[idName]["location"] === null)
	{
		//cant get data for commits, show correct message
		commitListGetError();
		return;
	}
	var urlForSend = arrayOfWatchFilters[idName]["WebsiteBase"];
	if(!(urlForSend.indexOf("http") > -1))
	{
		urlForSend = "https://"+urlForSend;
	}
	if(!(urlForSend.indexOf("core") > -1))
	{
		urlForSend += "/status/core/php/functions/";
	}
	urlForSend += "gitCommitHistory.php";
	var data = {pollType, location: arrayOfWatchFilters[idName]["location"], maxCount: maxCommits};
	(function(_data){
			$.ajax({
			url: urlForSend,
			dataType: 'json',
			global: false,
			data,
			type: 'POST',
			success: function(data)
			{
				commitListSuccess(data);
			},
			error: function(xhr, error)
			{
				//show appropriate error message
				commitListGetError();
				getListOfCommitsHttp();
			}
		});
	}(data));
}

function getListOfCommitsHttp()
{
	var idName = currentIdOfMainSidebar;
	var urlForSend = arrayOfWatchFilters[idName]["WebsiteBase"];
	if(!(urlForSend.indexOf("http") > -1))
	{
		urlForSend = "http://"+urlForSend;
	}
	if(!(urlForSend.indexOf("core") > -1))
	{
		urlForSend += "/status/core/php/functions/";
	}
	urlForSend += "gitCommitHistory.php";
	var data = {pollType, location: arrayOfWatchFilters[idName]["location"], maxCount: maxCommits};
	(function(_data){
			$.ajax({
			url: urlForSend,
			dataType: 'json',
			global: false,
			data,
			type: 'POST',
			success: function(data)
			{
				commitListSuccess(data);
			},
			error: function(xhr, error)
			{
				//show appropriate error message
				commitListGetError();
			}
		});
	}(data));
}

function commitListSuccess(data)
{
	setTimeout(function(){commitListSuccessInner(data);}, 25);
}

function commitListSuccessInner(data)
{
	//style and format commit history, display in left column
	var htmlForCommits = "";
	var counterOfData = data.length;
	//find first commit id
	var idForCommit = "";
	for(var i = 0; i < counterOfData; i++)
	{
		if(data[i].indexOf("commit") > -1)
		{
			idForCommit = data[i].replace("commit","").trim();
			break;
		}
	}
	var extCounter = 0;
	var idForFirstCommit = idForCommit;
	htmlForCommits += "<li class=\"commitLi\" id=\""+idForCommit+"\" onclick=\"viewCommit('"+idForCommit+"');\" >";
	for(var i = 0; i < counterOfData; i++)
	{
		if(data[i] === "")
		{
			continue;
		}
		if(i+2 < counterOfData && data[i+1].indexOf("commit") > -1 && data[i+2].indexOf("Author") > -1)
		{
			extCounter++;
			htmlForCommits += data[i];
			idForCommit = data[i+1].replace("commit","").trim();
			htmlForCommits += "</li>";
			if(extCounter % 20 === 1 && extCounter !== 1)
			{
				htmlForCommits += "<li ";
				if(extCounter > 30)
				{
					htmlForCommits += " style=\"display: none;\" ";
				}
				htmlForCommits += " id=\"commitShow"+parseInt(extCounter/20)+"\" class=\" ";
				if(extCounter < 30)
				{
					htmlForCommits += " colorAltBG ";
				}
				htmlForCommits += " commitGroup"+((parseInt(extCounter/20))-1)+" \" onclick=\"showMoreCommits("+parseInt(extCounter/20)+")\" >Show More</li>";
			}
			htmlForCommits += "<li class=\"commitLi ";
			if(extCounter % 2 !== 0)
			{
				htmlForCommits += " colorAltBG ";
			}
			if(extCounter > 20)
			{
				htmlForCommits += " commitGroup"+parseInt(extCounter/20)+" ";
			}
			htmlForCommits += " \" style=\" ";
			if(extCounter > 20)
			{
				htmlForCommits += " display: none; "
			}
			htmlForCommits += " \" id=\""+idForCommit+"\" onclick=\"viewCommit('"+idForCommit+"');\" >";
		}
		else if(i + 1 < counterOfData && data[i].indexOf("commit") > -1 && data[i+1].indexOf("Author") > -1)
		{
			continue;
		}
		else if(data[i-1].indexOf("commit") > -1 && data[i].indexOf("Author") > -1)
		{
			htmlForCommits += "<b>"+data[i].replace("Author:","").trim()+"</b>";
		}
		else if(data[i-1].indexOf("Author") > -1 && data[i].indexOf("Date") > -1)
		{
			var dataTmp = data[i].replace("Date:","").trim();
			dataTmp = new Date(dataTmp);
			htmlForCommits += "<span style=\"float:right;\" ><b>"+(dataTmp.getMonth()+1)+"/"+dataTmp.getDate()+"/"+dataTmp.getFullYear()+"</b></span>";
			htmlForCommits += "<br>";
		}
		else
		{
			htmlForCommits += data[i];
			htmlForCommits += "<br>";
		}
	}
	htmlForCommits += "</li>";
	$("#otherCommitsFromPast").html(htmlForCommits);
	viewCommit(idForFirstCommit);
	document.getElementById("noChangesToDisplay").style.display = "none";
	document.getElementById("spinnerLiForSideBoxBoxForInfo").style.display = "none";
}

function showMoreCommits(groupNumber)
{
	$(".commitGroup"+groupNumber).show();
	$("#commitShow"+groupNumber).hide();
}

function viewCommit(idForCommit)
{
	$("#listOfCommitHistory li").removeClass("selectedButton");
	$("#"+idForCommit).addClass("selectedButton");
	var idName = currentIdOfMainSidebar;
	document.getElementById("mainCommitDiffLoading").style.display = "block";
	$("#spanForMainDiff").html("");
	if((!(idName in arrayOfWatchFilters)) || (!("WebsiteBase" in arrayOfWatchFilters[idName])) || (arrayOfWatchFilters[idName]["WebsiteBase"] === "") || arrayOfWatchFilters[idName]["location"] === null)
	{
		//cant get data for commits, show correct message
		return;
	}
	var urlForSend = arrayOfWatchFilters[idName]["WebsiteBase"];
	if(!(urlForSend.indexOf("http") > -1))
	{
		urlForSend = "https://"+urlForSend;
	}
	if(!(urlForSend.indexOf("core") > -1))
	{
		urlForSend += "/status/core/php/functions/";
	}
	urlForSend += "gitShowCommitStuff.php";
	var data = {pollType, location: arrayOfWatchFilters[idName]["location"], commit: idForCommit};
	(function(_data){
			$.ajax({
			url: urlForSend,
			dataType: 'json',
			global: false,
			data,
			type: 'POST',
			success: function(data)
			{
				commitStuffSuccess(data);
			},
			error: function(xhr, error)
			{
				//show appropriate error message
				viewCommitHttp(idForCommit);
			}
		});
	}(data));
}

function viewCommitHttp(idForCommit)
{
	var idName = currentIdOfMainSidebar;
	var urlForSend = arrayOfWatchFilters[idName]["WebsiteBase"];
	if(!(urlForSend.indexOf("http") > -1))
	{
		urlForSend = "http://"+urlForSend;
	}
	if(!(urlForSend.indexOf("core") > -1))
	{
		urlForSend += "/status/core/php/functions/";
	}
	urlForSend += "gitShowCommitStuff.php";
	var data = {pollType, location: arrayOfWatchFilters[idName]["location"], commit: idForCommit};
	(function(_data){
			$.ajax({
			url: urlForSend,
			dataType: 'json',
			global: false,
			data,
			type: 'POST',
			success: function(data)
			{
				commitStuffSuccess(data);
			},
			error: function(xhr, error)
			{
				//show appropriate error message
				document.getElementById("spinnerLiForSideBoxBoxForInfo").style.display = "none";
				document.getElementById("mainCommitDiffLoading").style.display = "none";
				document.getElementById("noChangesToDisplay").style.display = "block";
				document.getElementById("noChangesToDisplay").style.display = "block";
			}
		});
	}(data));
}


function commitStuffSuccess(data)
{
	document.getElementById("noChangesToDisplay").style.display = "block";
	document.getElementById("noChangesToDisplay").style.display = "none";
	document.getElementById("mainCommitDiffLoading").style.display = "none";
	var htmlForCommit = "";
	var counterOfData = data.length;
	var current = "start";
	var currentNumberMinus = 0;
	var currentNumberPlus = 0;
	var skip = 0;
	for(var i = 0; i < counterOfData; i++)
	{
		if(data[i] === "" || data[i].indexOf("\ No newline at end of file") > -1 || data[i].indexOf("+++") === 0 || data[i].indexOf("---") === 0)
		{
			continue;
		}
		else if(data[i].indexOf("@@ -") > -1 && skip > 0)
		{
			var locations = data[i];
			locations = locations.split("@@");
			var locationNum = locations[1];
			var extraData = locations[2];
			locationNum = locationNum.split(",");
			currentNumberMinus = parseInt(locationNum[0].substr(2));
			currentNumberPlus = parseInt(locationNum[1].split(" ")[1].substr(1));
			skip--;
		}
		else if(skip > 0)
		{
			skip--;
			continue;
		}
		else if(data[i].indexOf("diff --git") === 0)
		{
			if(current === "start")
			{
				htmlForCommit += "<div style=\"border-bottom: 1px solid black; padding-top: 10px; background-color: rgb(170, 170, 170);\" ></div>";
			}
			else
			{
				htmlForCommit += "</table>";
			}
			var fileName = data[i].replace("diff --git a/","");
			fileName = fileName.substring(0, fileName.indexOf(" b/"));
			fileName = escapeHTML(fileName);
			htmlForCommit += "<div style=\"background-color: rgb(170, 170, 170); padding: 10px;\"  >"+fileName+"</div>";
			current = "commit";
			currentNumberMinus = 0;
			currentNumberPlus = 0;
			skip = 2;
			htmlForCommit += "<table width=\"100%\" style=\"border-spacing: 0; word-break: break-all;\" ><tr><td style=\"width: 60px;\" ></td><td style=\"width: 60px;\" ></td><td></td></tr>";
		}
		else if(current === "start")
		{
			if(data[i].indexOf("commit ") === 0)
			{
				htmlForCommit += "<div style=\"background-color: rgb(170, 170, 170); padding-top: 10px;\" ></div><div style=\"background-color: rgb(170, 170, 170); float: right;\"  >"+escapeHTML(data[i]).replace("commit","").trim()+"</div>";
			}
			else if(data[i].indexOf("Author: ") === 0)
			{
				htmlForCommit += "<div style=\"background-color: rgb(170, 170, 170); padding: 10px;\"  ><b>"+escapeHTML(data[i].substring(0, data[i].indexOf(" <"))).replace("Author: ","").trim()+":</b>";
			}
			else if(data[i].indexOf("Date: ") === 0)
			{
				var commitDate = data[i].replace("Date: ","").trim();
				commitDate = new Date(commitDate);
				var minForCommit = commitDate.getMinutes();
				if(minForCommit < 10)
				{
					minForCommit = "0"+minForCommit;
				}
				htmlForCommit += " "+commitDate.getMonth()+"/"+commitDate.getDate()+"/"+commitDate.getFullYear()+" - "+commitDate.getHours()+":"+minForCommit+"</div>";
			}
			else
			{
				htmlForCommit += "<div style=\"background-color: rgb(170, 170, 170); padding-left: 10px;\"  >"+escapeHTML(data[i]).trim()+"</div>";
			}
		}
		else if(data[i].indexOf("-") === 0)
		{
			htmlForCommit += "<tr style=\"background-color: rgb(205, 50, 50, 0.5);\" ><td>"+currentNumberMinus+"</td><td ></td><td>"+escapeHTML(data[i]).substr(1)+"</td></tr>";
			currentNumberMinus++;
		}
		else if(data[i].indexOf("+") === 0)
		{
			htmlForCommit += "<tr style=\"background-color: rgb(50, 205, 50, 0.5);\" ><td></td><td>"+currentNumberPlus+"</td><td>"+escapeHTML(data[i]).substr(1)+"</td></tr>";
			currentNumberPlus++;
		}
		else
		{
			htmlForCommit += "<tr><td>"+currentNumberMinus+"</td><td>"+currentNumberPlus+"</td><td>"+escapeHTML(data[i])+"</td></tr>";
			currentNumberMinus++;
			currentNumberPlus++;
		}

	}
	htmlForCommit += "</table>";
	$("#spanForMainDiff").html(htmlForCommit);
}

function escapeHTML(unsafeStr)
{
	try
	{
		return unsafeStr.toString()
		.replace(/&/g, "&amp;")
		.replace(/</g, "&lt;")
		.replace(/>/g, "&gt;")
		.replace(/\"/g, "&#34;")
		.replace(/\'/g, "&#39;")
		.replace(/\//g, "&#x2F;");
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function togglePinStatus(keyNoSpace)
{
	if(document.getElementById(keyNoSpace+"PinPinned").style.display === "none")
	{
		document.getElementById(keyNoSpace+"PinPinned").style.display = "inline";
		document.getElementById(keyNoSpace+"Pin").style.display = "none";
		$("#innerFirstDevBox"+keyNoSpace).parent().addClass("pinned");
	}
	else
	{
		document.getElementById(keyNoSpace+"PinPinned").style.display = "none";
		document.getElementById(keyNoSpace+"Pin").style.display = "inline";
		$("#innerFirstDevBox"+keyNoSpace).parent().removeClass("pinned");
	}
	updateGroupsShown();
}

function setFade(keyNoSpace)
{
	$("#innerFirstDevBox"+keyNoSpace).css("backgroundColor", "rgb(255,255,0)");
	$("#innerFirstDevBox"+keyNoSpace).addClass("tmpHighlight");
}

function fadeColorToColor(keyNoSpace)
{
	keyNoSpace = keyNoSpace.split("innerFirstDevBox")[1];
	var currentColor = arrayOfWatchFilters[keyNoSpace]["backgroundColor"];
	currentColor = currentColor.split("(")[1];
	currentColor = currentColor.substring(0, currentColor.indexOf(")")).split(",");
	$("#innerFirstDevBox"+keyNoSpace).removeClass("tmpHighlight");
	setTimeout(function(){
		var d = 1000;
		for(var i=0; i<=255; i=i+1){
		    d  += 10;
		    (function(ii,dd, cc, keyNoSpace){
		        setTimeout(function(){
		        	var r = (255-ii);
		        	if(parseInt(cc[0]) > r)
		        	{
		        		r = parseInt(cc[0]);
		        	}
		        	var g = (255-ii);
		        	if(parseInt(cc[1]) > g)
		        	{
		        		g = parseInt(cc[1]);
		        	}
		        	var b = (0+ii);
		        	if(parseInt(cc[2]) < b)
		        	{
		        		b = parseInt(cc[2]);
		        	}
		            $("#innerFirstDevBox"+keyNoSpace).css('backgroundColor','rgb('+r+','+g+','+b+')');
		        }, dd);
		    })(i,d, currentColor, keyNoSpace);
		}
	}, 1500);
}

function startPauseOnNotFocus()
{
	Visibility.every(300, 3000, function () { checkIfPageHidden(); });
}

function isPageHidden()
{
	return document.hidden || document.msHidden || document.webkitHidden || document.mozHidden;
}

function checkIfPageHidden()
{
	if(isPageHidden())
	{
		return;
	}
	var currentHighlight = $(".tmpHighlight");
	var currentHighlightLength = currentHighlight.length;
	if(currentHighlightLength > 0)
	{
		for(var currentHighlightCount = 0; currentHighlightCount < currentHighlightLength; currentHighlightCount++)
		{
			fadeColorToColor(currentHighlight[currentHighlightCount].id)
		}
	}
}

/* KEEP AT BOTTOM OF FILE */

$( document ).ready(function()
{
	pollingRate = pollingRate * 60000;
	pollingRateBG = pollingRateBG * 60000;

	if (autoCheckUpdate == true)
	{
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();

		if(dd<10) {
		    dd='0'+dd
		}

		if(mm<10) {
		    mm='0'+mm
		}

		today = mm+'-'+dd+'-'+yyyy;
		if(today != dateOfLastUpdate)
		{
			checkForUpdateDefinitely();
		}
	}

	if(pausePollFromFile !== "true")
	{
		poll();
		if(pausePollFromFile !== "almostTrue")
		{
			startPoll();
		}
	}

	startPauseOnNotFocus();

});