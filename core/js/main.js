var counterForSave = numberOfLogs+1;
var updating = false;

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

function pollTimed()
{
	if(!pausePollFile)
	{
		poll();
	}
}

function poll(all = -1)
{
	if(all == '-1')
	{
		counterForSave = numberOfLogs+1;
		var arrayOfFilesLength = arrayOfFiles.length
		for(var i = 0; i < arrayOfFilesLength; i++)
		{
			var boolForRun = true;
			if(onlyRefreshVisible === "true")
			{
				var name = "innerFirstDevBoxbranchNameDevBox1"+arrayOfFiles[i][0];
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
		counterForSave = 1;
		tryHTTPForPollRequest(all);
	}
}

function tryHTTPForPollRequest(count)
{
	var name = "branchNameDevBox1"+arrayOfFiles[count][0];
	name = name.replace(/\s/g, '_');
	var doPollLogic = true;
	if(arrayOfWatchFilters && arrayOfWatchFilters[name])
	{
		if(arrayOfWatchFilters[name]["enableBlockUntilDate"] == 'true' || arrayOfWatchFilters[name]["enableBlockUntilDate"] == true)
		{
			var dateForEnd = arrayOfWatchFilters[name]["datePicker"];
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
			if (dateForEnd >= today)
			{
				doPollLogic = false;
			} 
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
function tryHttpActuallyPollLogic(count, name)
{
	var urlForSend = 'http://'+arrayOfFiles[count][1]+'/status/core/php/functions/gitBranchName.php?format=json';
	if(arrayOfFiles[count][6] !== "")
	{
		urlForSend = 'http://'+arrayOfFiles[count][6]+'?format=json';
	}
	if(document.getElementById(name))
	{
		document.getElementById(name+'loadingSpinnerHeader').style.display = "inline-block";
		document.getElementById(name+"spinnerDiv").style.display = "none";
	}
	document.getElementById("refreshDiv").style.display = "none";
	var data = {location: arrayOfFiles[count][2], name, githubRepo: arrayOfFiles[count][4], urlForSend ,websiteBase: arrayOfFiles[count][1]};
	var innerData = {};
	if(pollType == 1)
	{
		innerData = data;
	}
	(function(_data){
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
				tryHTTPSForPollRequest(_data);
			}
		});
	}(data));
}


function tryHTTPSForPollRequest(_data)
{
	var urlForSend = _data.urlForSend;
	urlForSend = urlForSend.replace("http","https");
	var data = {location: _data.location, name: _data.name, githubRepo: _data.githubRepo, websiteBase: _data.websiteBase};
	var innerData = {};
	if(pollType == 1)
	{
		innerData = data;
	}
		(function(_data){
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
					pollFailure(xhr.status, error, _data);
				}
			});
		}(data));
}

function showPopupWithMessage(type, message)
{
	showPopup();
	document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='devBoxTitle' ><b>"+type+"</b></div><br><br><div style='width:100%;text-align:center;'>"+message+"<br><br><a class='buttonButton' onclick='hidePopup();'>Ok</a></div>";
}

function decreaseSpinnerCounter(loadingSpinnerText)
{
	document.getElementById('loadingSpinnerMain').style.display = "block";
	var loadingSpinnerText = document.getElementById('loadingSpinnerText');
	loadingSpinnerText.innerHTML = ((counterForSave-1))
	counterForSave--;
	return loadingSpinnerText;
}

function pollCompleteLogic()
{
	document.getElementById('loadingSpinnerMain').style.display = "block";
	var loadingSpinnerText = decreaseSpinnerCounter();
	if(counterForSave < 1)
	{
		if(cacheEnabled === "true")
		{
			loadingSpinnerText.innerHTML = "Saving..."
			if(!jQuery.isEmptyObject(arrayOfWatchFilters))
			{
				//save object after poll
				var urlForSend = 'core/php/saveFunctions/cachedStatus.php?format=json'
				var data = {arrayOfdata: arrayOfWatchFilters};
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
	}		
}

function pollFailure(xhr, error, dataInnerPass)
{
	var noSpaceName = dataInnerPass['name'].replace(/\s/g, '');
	var nameForBackground = "innerFirstDevBox"+noSpaceName;
	switchToColorLed(noSpaceName, "red");
	document.getElementById(noSpaceName+'redwWarning').onclick = function(){showPopupWithMessage('Error','Could not connect to server')};
	document.getElementById(noSpaceName+'errorMessageLink').style.display = "block";
	document.getElementById(noSpaceName+'errorMessageLink').onclick = function(){showPopupWithMessage('Error','Could not connect to server')};
    document.getElementById(noSpaceName+'spinnerDiv').style.display = "inline-block";
    if(document.getElementById(noSpaceName+'Stats').innerHTML != JSON.stringify(error) && document.getElementById(noSpaceName+'Stats').innerHTML == "")
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
				datePicker: null
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
	}
	document.getElementById(noSpaceName+'loadingSpinnerHeader').style.display = "none";
	document.getElementById(noSpaceName+"spinnerDiv").style.display = "inline-block";
	document.getElementById("refreshDiv").style.display = "inline-block";
	pollCompleteLogic();
}

function pollSuccess(dataInner, dataInnerPass)
{
	if(pollType === "1")
	{
		pollSuccessInner(dataInner, dataInnerPass);
	}
	else if(pollType === "2")
	{
		if("info" in dataInner)
		{
			decreaseSpinnerCounter();
			var keysInfo = Object.keys(dataInner["info"]);
			var keysInfoLength = keysInfo.length;
			for(var i = 0; i < keysInfoLength; i++)
			{
				var name = "branchNameDevBox1"+keysInfo[i];
				dataInner["info"][keysInfo[i]]["name"] = name.replace(/\s/g, '_');
				pollSuccessInner(dataInner["info"][keysInfo[i]],dataInner["info"][keysInfo[i]])
			}
		}
	}
}

function pollSuccessInner(dataInner, dataInnerPass)
{
	var dataToFilterBy = "error";
	var noSpaceName = dataInnerPass['name'].replace(/\s/g, '');
	if(!document.getElementById(noSpaceName))
	{
		//no there, add
		var item = $("#storage .container").html();
		item = item.replace(/{{keyNoSpace}}/g, noSpaceName);
		if(!$('#standardViewButtonMainSection').hasClass('buttonSlectorInnerBoxes'))
		{
			item = item.replace(/{{branchView}}/g, "devBoxContentSecondary");
		}
		if(!$('#expandedViewButtonMainSection').hasClass('buttonSlectorInnerBoxes'))
		{
			item = item.replace(/{{branchView}}/g, "devBoxContentSecondaryExpanded");
		}
		item = item.replace(/{{name}}/g,dataInner["displayName"]);
		item = item.replace(/{{website}}/g,"#");
		$("#main").append(item);
	}
	document.getElementById(noSpaceName+'spinnerDiv').style.display = "inline-block";
	if(dataInner['branch'] && dataInner['branch'] != 'Location var is too long.')
	{
		switchToColorLed(noSpaceName, "green");
		document.getElementById(noSpaceName+'errorMessageLink').style.display = "none";
		document.getElementById(noSpaceName+'noticeMessageLink').style.display = "none";
		var dataStats = dataInner['stats'].replace("','", "'"+'&#44;'+"'");
	    var dataStats = dataStats.split(", <");
	    var dataBranchForFile = '<span id="'+noSpaceName+'";">';
	    if((dataInnerPass["githubRepo"] != 'undefined') && (dataInnerPass["githubRepo"] != ''))
	    {
	    	dataBranchForFile += '<a style="color: black;" href="https://github.com/'+dataInnerPass["githubRepo"]+'/tree/'+dataInner['branch']+'">';
	    }
	    dataBranchForFile += dataInner['branch'];
	    if((dataInnerPass["githubRepo"] != 'undefined') && (dataInnerPass["githubRepo"] != ''))
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
	    if(checkForIssueInCommit == "true")
	    {
		    for (var i = 0, len = dataBranchForFileStats.length; i < len; i++) 
		    {
			  if(dataBranchForFileStats[i] == "#")
			  {
			  	if(!isNaN(dataBranchForFileStats[i+1]))
			  	{
			  		if(dataBranchForFileStats[i-1] != "&")
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
					  			if((dataInnerPass["githubRepo"] != 'undefined') && (dataInnerPass["githubRepo"] != ''))
					  			{
					  				link = '<a style="color: black;"  href="https://github.com/'+dataInnerPass["githubRepo"]+'/issues/'+num+'">'+dataBranchForFileStats[i]+num+'</a>';
						  			dataBranchForFile += " "+link;
						  			linksFromCommitMessage.push(num.toString());
							  		dataBranchForFileStats = dataBranchForFileStats.replace(dataBranchForFileStats[i]+num,link);
							  		len = dataBranchForFileStats.length;
							  		i = i + link.length;
					  			}
					  		}
				  		}
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
				if((dataInnerPass["githubRepo"] != 'undefined') && (dataInnerPass["githubRepo"] != ''))
				{
					link = '<a style="color: black;"  href="https://github.com/'+dataInnerPass["githubRepo"]+'/issues/'+numForStart+'">#'+numForStart+'</a>';
					dataBranchForFile += " "+link;
				}
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
				if((dataInnerPass["githubRepo"] != 'undefined') && (dataInnerPass["githubRepo"] != ''))
				{
					link = '<a style="color: black;"  href="https://github.com/'+dataInnerPass["githubRepo"]+'/issues/'+numForEnd+'">#'+numForEnd+'</a>';
					dataBranchForFile += " "+link;
				}
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
						if((dataInnerPass["githubRepo"] != 'undefined') && (dataInnerPass["githubRepo"] != ''))
						{
							link = '<a style="color: black;"  href="https://github.com/'+dataInnerPass["githubRepo"]+'/issues/'+numForLinkIssue+'">#'+numForLinkIssue+'</a>';
							dataBranchForFile += " "+link;
						}
					}
					branchNameTMP = branchNameTMP.substring(numForcalc);
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
				datePicker: null
			};
		}
		else
		{
			arrayOfWatchFilters[noSpaceName]["data"] = dataBranchForFile;
			arrayOfWatchFilters[noSpaceName]["time"] = dataBranchForFileUpdateTime;
			arrayOfWatchFilters[noSpaceName]["status"] = dataBranchForFileStats;
			if(arrayOfWatchFilters[noSpaceName]["errorStatus"] == true)
			{
				//was error
				arrayOfWatchFilters[noSpaceName]["errorStatus"] = false;
			}

		}
		
		filterBGColor(dataToFilterBy, nameForBackground, 1);
		arrayOfWatchFilters[noSpaceName]["backgroundColor"] = document.getElementById(nameForBackground).style.backgroundColor;
		//custom message stuff
		(Object.values(dataInner).indexOf('messageTextEnabled') > -1)
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
				document.getElementById(noSpaceName+'spinnerDiv').style.display = "none";
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
				datePicker: null
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
		}
	}
	displayDataFromPoll(noSpaceName,dataBranchForFile,dataBranchForFileUpdateTime,dataBranchForFileStats);
	document.getElementById(noSpaceName+'loadingSpinnerHeader').style.display = "none";
	document.getElementById(noSpaceName+"spinnerDiv").style.display = "inline-block";
	pollCompleteLogic();
}

function switchToColorLed(noSpaceName, type)
{
	if(type === "red")
	{
		document.getElementById(noSpaceName+'redwWarning').style.display = "inline-block";
		document.getElementById(noSpaceName+'yellowWarning').style.display = "none";
		document.getElementById(noSpaceName+'greenNotice').style.display = "none";
	}
	else if(type === "yellow")
	{
		document.getElementById(noSpaceName+'redwWarning').style.display = "none";
		document.getElementById(noSpaceName+'yellowWarning').style.display = "inline-block";
		document.getElementById(noSpaceName+'greenNotice').style.display = "none";
	}
	else
	{
		document.getElementById(noSpaceName+'redwWarning').style.display = "none";
		document.getElementById(noSpaceName+'yellowWarning').style.display = "none";
		document.getElementById(noSpaceName+'greenNotice').style.display = "inline-block";
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
	var filterByThisArray = [];
	var defaultColor = "#aaaaaa";
	if (branchColorFilter == "branchName")
	{
		filterByThisArray = errorAndColorArray;
	}
	else if (branchColorFilter == "authorName")
	{
		filterByThisArray = errorAndColorAuthorArray;
	}
	else
	{
		filterByThisArray = errorAndColorComitteeArray;
	}

	for(var property in filterByThisArray)
	{
		if (filterByThisArray.hasOwnProperty(property)) 
		{
			if(filterByThisArray[property].type == "includes")
			{
				if(filterName.includes(property) && newBG != true)
				{
					if(opacity != 1)
					{
						document.getElementById(idName).style.backgroundColor = $.xcolor.opacity((filterByThisArray[property].color), (document.getElementById(idName).style.backgroundColor), opacity);
					}
					else
					{
						document.getElementById(idName).style.backgroundColor = "#"+filterByThisArray[property].color;
					}
					newBG = true;
				}
			}
			else
			{
				if(filterName == property)
				{
					if(opacity != 1)
					{
						document.getElementById(idName).style.backgroundColor = $.xcolor.opacity((filterByThisArray[property].color), (document.getElementById(idName).style.backgroundColor), opacity);
					}
					else
					{
						document.getElementById(idName).style.backgroundColor = "#"+filterByThisArray[property].color;
					}
					newBG = true;
				}
			}
		}
	}
	if(!newBG)
	{
		document.getElementById(idName).style.backgroundColor = defaultColor;
	}
}

var refreshing = false;

function refreshAction(all = -1, status = 'outer')
{
	if(refreshing == false)
	{
		clearTimeout(refreshActionVar);
		
		refreshing = true;
		if(pausePoll)
		{
			clearTimeout(refreshPauseActionVar);
			pausePoll = false;
			if(all == '-1')
			{
				poll();
			}
			else
			{
				poll(all);	
			}
			refreshPauseActionVar = setTimeout(function(){pausePoll = true;}, 1000);
		}
		else
		{
			if(all == '-1')
			{
				poll();
			}
			else
			{
				poll(all);	
			}
		}
		refreshActionVar = setTimeout(function(){endRefreshAction()}, 1500);
	}
}

function endRefreshAction()
{	
	refreshing = false;
	if(pausePoll)
	{
		document.title = "Git Status | Paused";
	}
	else
	{
		document.title = "Git Status | Index";
	}
}

$( document ).ready(function()
{
	poll();
	pollingRate = pollingRate * 60000; 
	setInterval(pollTimed, pollingRate);
});

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

if(pausePollFromFile)
{
	pausePollFile = true;
	document.getElementById('pauseImage').src="core/img/Play.png";
}

function pausePollAction()
{
	if(pausePollFile)
	{
		userPaused = false;
		pausePollFile = false;
		document.getElementById('pauseImage').src="core/img/Pause.png";
	}
	else
	{
		userPaused = true;
		pausePollFunction();
	}
}

function pausePollFunction()
{
	pausePollFile = true;
	document.getElementById('pauseImage').src="core/img/Play.png";
	document.title = "Status | Paused";
}

function switchToStandardView() 
{
	if($('#standardViewButtonMainSection').hasClass('buttonSlectorInnerBoxes'))
	{
		if($('#expandedViewButtonMainSection').hasClass('buttonSlectorInnerBoxesSelected'))
		{
			if(defaultViewBranchCookie = "true")
			{
				document.cookie = "defaultViewBranchCookie=Standard";
			}
			removeAllButtonSelectorClasses('standardViewButtonMainSection');

			$('#standardViewButtonMainSection').addClass('buttonSlectorInnerBoxesSelected');
			$('#standardViewButtonMainSection').removeClass('buttonSlectorInnerBoxes');

			$('.devBoxContentSecondaryExpanded').addClass('devBoxContentSecondary');
			$('.devBoxContentSecondaryExpanded').removeClass('devBoxContentSecondaryExpanded');
		}
	}
}

function switchToExpandedView() 
{
	if($('#expandedViewButtonMainSection').hasClass('buttonSlectorInnerBoxes'))
	{
		if($('#standardViewButtonMainSection').hasClass('buttonSlectorInnerBoxesSelected'))
		{
			if(defaultViewBranchCookie = "true")
			{
				document.cookie = "defaultViewBranchCookie=Expanded";
			}
			removeAllButtonSelectorClasses('expandedViewButtonMainSection');

			$('#expandedViewButtonMainSection').addClass('buttonSlectorInnerBoxesSelected');
			$('#expandedViewButtonMainSection').removeClass('buttonSlectorInnerBoxes');

			$('.devBoxContentSecondary').addClass('devBoxContentSecondaryExpanded');
			$('.devBoxContentSecondary').removeClass('devBoxContentSecondary');
		}
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
}

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
}

function showOrHideGroups(groupName)
{
	//show / hide groups
	if(groupName != "All")
	{
		$('.firstBoxDev').hide();
		$('.'+groupName).show();
	}
	else
	{
		$('.firstBoxDev').show();
	}
	//change tab to selected / unselected

	//unselect all
	$('.groupTab').removeClass('groupTabSelected');
	$('#Group'+groupName).addClass('groupTabSelected');
}

function dropdownShow(nameOfElem) {
    if(document.getElementById("dropdown-"+nameOfElem).style.display == 'block')
    {
    	$('.dropdown-content').hide();
    	$('.dropdown-content').css('margin-top',"0px");
    }
    else
    {
    	$('.dropdown-content').hide();
    	var currentElement = document.getElementById("dropdown-"+nameOfElem);
    	currentElement.style.display = 'block';
    	currentElement.style.marginTop = "0px";
    	var elementLowestPosition = (currentElement.getBoundingClientRect().top+currentElement.offsetHeight);
    	var heightWindow = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
    	if(elementLowestPosition > heightWindow)
    	{
    		currentElement.style.marginTop = "-"+(currentElement.offsetHeight+25)+"px";
    	}
    }
}

window.onclick = function(event) {
	if (!event.target.matches('.expandMenu')) 
	{
		$('.dropdown-content').hide();
		$('.dropdown-content').css('margin-top',"0px");
	}
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