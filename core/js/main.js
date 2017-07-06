function checkLogHog(logHogI)
{
	var urlForSend = '/status/core/php/functions/logHog.php?format=json'
	var websiteBase = arrayOfFiles[logHogI][1];
	var website = arrayOfFiles[logHogI][3];
	var name = "branchNameDevBox1"+arrayOfFiles[logHogI][0];
	name = name.replace(/\s/g, '_');
	var data = {location: arrayOfFiles[logHogI][2], websiteBase: websiteBase, website: website, name: name};
	$.ajax({
	  url: urlForSend,
	  dataType: 'json',
	  data: data,
	  type: 'POST',
	  success: function(data){
	  	logHogSuccess(data);
	  },
	});
}

function pollTimed()
{
	if(!pausePollFile)
	{
		poll();
	}
}

function logHogSuccess(data)
{
	if(data['link'] != "null" && data['link'] != null)
  	{
  		//console.log(data['link'] + "   |   "+data['name'] + "   |   "+data['file_headers']);
  		document.getElementById(data['name']+"LogHogOuter").style.display = "inline-block";
  		document.getElementById(data['name']+"LogHogInner").href = data['link'];
  	}
}


function poll(all = -1)
{
	if(!jQuery.isEmptyObject(arrayOfWatchFilters))
	{
		//save object before poll
		var urlForSend = 'core/php/saveFunctions/cachedStatus.php?format=json'
		var data = {arrayOfdata: arrayOfWatchFilters, all: all};
		(function(_data){

			$.ajax({
			url: urlForSend,
			dataType: 'json',
			global: false,
			data: data,
			type: 'POST',
			success: function(data){
				pollTwo(_data['all']);
			}
		});

			}(data));
	}
	else
	{
		pollTwo(all);
	}	
}

function pollTwo(all)
{
	if(all == '-1')
	{
		var arrayOfFilesLength = arrayOfFiles.length
		for(var i = 0; i < arrayOfFilesLength; i++)
		{
			tryHTTPForPollRequest(i);
		}
	}
	else
	{
		tryHTTPForPollRequest(all);
	}
}

function tryHTTPForPollRequest(count)
{
	var urlForSend = 'http://'+arrayOfFiles[count][1]+'/status/core/php/functions/gitBranchName.php?format=json'
	var name = "branchNameDevBox1"+arrayOfFiles[count][0];
	name = name.replace(/\s/g, '_');
	document.getElementById(name+'loadingSpinnerHeader').style.display = "inline-block";
	var data = {location: arrayOfFiles[count][2], name: name, githubRepo: arrayOfFiles[count][4], urlForSend: urlForSend};
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
			error: function(data){
				tryHTTPSForPollRequest(data, _data);
			}
		});

			}(data));
}


function tryHTTPSForPollRequest(data, _data)
{
	var urlForSend = _data.urlForSend;
	urlForSend = urlForSend.replace("http","https");
	var data = {location: _data.location, name: _data.name, githubRepo: _data.githubRepo};
	
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
			error: function(jqXHR, textStatus, errorThrown){
				pollFailure(jqXHR.status, _data);
			}
		});

			}(data));
			
}

function showPopupWithMessage(type, message)
{
	showPopup();
	document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='devBoxTitle' ><b>"+type+"</b></div><br><br><div style='width:100%;text-align:center;'>"+message+"<br><br><a class='buttonButton' onclick='hidePopup();'>Ok</a></div>";
}

function pollFailure(dataInner, dataInnerPass)
{
	var noSpaceName = dataInnerPass['name'].replace(/\s/g, '');
	var nameForBackground = "innerFirstDevBox"+noSpaceName;
	document.getElementById(noSpaceName+'redwWarning').style.display = "inline-block";
	document.getElementById(noSpaceName+'redwWarning').onclick = function(){showPopupWithMessage('Error','Could not connect to server')};
	document.getElementById(noSpaceName+'errorMessageLink').style.display = "block";
	document.getElementById(noSpaceName+'errorMessageLink').onclick = function(){showPopupWithMessage('Error','Could not connect to server')};
    if(document.getElementById(noSpaceName+'Stats').innerHTML == "--Pending--")
	{
	    var dataBranchForFile = '<span id="'+noSpaceName+'";">Error</span>';
	    var dataBranchForFileUpdateTime = '<span id="'+noSpaceName+'Update";">n/a</span>';
	    document.getElementById(noSpaceName+'UpdateOuter').style.display = "none";
	    var dataBranchForFileStats = '<span id="'+noSpaceName+'Stats";">Could not connect to server</span>';
	    displayDataFromPoll(noSpaceName,dataBranchForFile,dataBranchForFileUpdateTime,dataBranchForFileStats)
	    filterBGColor('error', nameForBackground, 1);
	}

	if(arrayOfWatchFilters && !arrayOfWatchFilters[noSpaceName])
	{
		arrayOfWatchFilters[noSpaceName] = new Array(dataBranchForFile,dataBranchForFileUpdateTime,dataBranchForFileStats,true,(document.getElementById(nameForBackground).style.backgroundColor),false);
	}
	else
	{
		if(arrayOfWatchFilters[noSpaceName][3] == false)
		{
			//new error
			arrayOfWatchFilters[noSpaceName][3] = true;
			filterBGColor('error', nameForBackground, 0.5);
		}
		arrayOfWatchFilters[noSpaceName][4] = document.getElementById(nameForBackground).style.backgroundColor;
		arrayOfWatchFilters[noSpaceName][5] = false;
	}
	document.getElementById(noSpaceName+'loadingSpinnerHeader').style.display = "none";
}

function pollSuccess(dataInner, dataInnerPass)
{
	var dataToFilterBy = "error";
	var noSpaceName = dataInnerPass['name'].replace(/\s/g, '');
	if(dataInner['branch'] && dataInner['branch'] != 'Location var is too long.')
	{
		document.getElementById(noSpaceName+'redwWarning').style.display = "none";
		document.getElementById(noSpaceName+'errorMessageLink').style.display = "none";
		document.getElementById(noSpaceName+'yellowWarning').style.display = "none";
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
			arrayOfWatchFilters[noSpaceName] = new Array(dataBranchForFile,dataBranchForFileUpdateTime,dataBranchForFileStats,false,(document.getElementById(nameForBackground).style.backgroundColor),false,null);
		}
		else
		{
			arrayOfWatchFilters[noSpaceName][0] = dataBranchForFile;
			arrayOfWatchFilters[noSpaceName][1] = dataBranchForFileUpdateTime;
			arrayOfWatchFilters[noSpaceName][2] = dataBranchForFileStats;
			if(arrayOfWatchFilters[noSpaceName][3] == true)
			{
				//was error
				arrayOfWatchFilters[noSpaceName][3] = false;
			}

		}
		
		filterBGColor(dataToFilterBy, nameForBackground, 1);
		arrayOfWatchFilters[noSpaceName][4] = document.getElementById(nameForBackground).style.backgroundColor;
		//custom message stuff
		(Object.values(dataInner).indexOf('messageTextEnabled') > -1)
		{
			if(dataInner['messageTextEnabled'] == 'true')
			{
				document.getElementById(noSpaceName+'yellowWarning').style.display = "inline-block";
				arrayOfWatchFilters[noSpaceName][5] = true;
				document.getElementById(noSpaceName+'NoticeMessage').style.display = "inline-block";
				arrayOfWatchFilters[noSpaceName][6] = dataInner['messageText'];
				document.getElementById(noSpaceName+'NoticeMessage').innerHTML = dataInner['messageText'];
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
		document.getElementById(noSpaceName+'redwWarning').style.display = "inline-block";
		document.getElementById(noSpaceName+'errorMessageLink').style.display = "block";
		document.getElementById(noSpaceName+'errorMessageLink').onclick = function(){showPopupWithMessage('Error',errorMessage)};
	    var dataBranchForFile = '<span id="'+noSpaceName+'";">Error</span>';
	    var dataBranchForFileUpdateTime = '<span id="'+noSpaceName+'Update";">n/a</span>';
	    var dataBranchForFileStats = '<span id="'+noSpaceName+'Stats";">'+errorMessage+'</span>';
	    var nameForBackground = "innerFirstDevBox"+noSpaceName;
	    if(arrayOfWatchFilters && !arrayOfWatchFilters[noSpaceName])
		{
			arrayOfWatchFilters[noSpaceName] = new Array(dataBranchForFile,dataBranchForFileUpdateTime,dataBranchForFileStats,true,(document.getElementById(nameForBackground).style.backgroundColor));
		}
		else
		{
			if(arrayOfWatchFilters[noSpaceName][3] == false)
			{
				//new error
				arrayOfWatchFilters[noSpaceName][3] = true;
				filterBGColor('error', nameForBackground, 0.5);
			}
			arrayOfWatchFilters[noSpaceName][4] = document.getElementById(nameForBackground).style.backgroundColor;
			arrayOfWatchFilters[noSpaceName][5] = false;
		}
	}
	displayDataFromPoll(noSpaceName,dataBranchForFile,dataBranchForFileUpdateTime,dataBranchForFileStats);
	document.getElementById(noSpaceName+'loadingSpinnerHeader').style.display = "none";
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

function refreshAction(refreshImage, all = -1, status = 'outer')
{
	if(refreshing == false)
	{
		clearTimeout(refreshActionVar);
		if(status == "inner")
		{
			document.getElementById(refreshImage).src="core/img/refresh-animated-2.gif";
		}
		else
		{
			//outer default
			document.getElementById(refreshImage).src="core/img/refresh-animated.gif";
		}
		
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
		refreshActionVar = setTimeout(function(){endRefreshAction(refreshImage, status)}, 1500);
	}
}

function endRefreshAction(refreshImage, status)
{
	if(status == "inner")
	{
		document.getElementById(refreshImage).src="core/img/Refresh2.png"; 
	}
	else
	{
		//outer default
		document.getElementById(refreshImage).src="core/img/Refresh.png"; 
	}
	
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
	for (var i = 0; i < numberOfLogs; i++)
	{
		checkLogHog(i);
	}
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
		window.location.href = "core/php/update/settingsCheckForUpdate.php";
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
	document.title = "Log Hog | Paused";
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

