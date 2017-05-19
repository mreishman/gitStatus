for (var i = 0; i < numberOfLogs; i++)
{
	checkLogHog(i);
}


function checkLogHog(all)
{

	var urlForSend = '/status/core/php/functions/logHog.php?format=json'
	var websiteBase = arrayOfFiles[all][1];
	var website = arrayOfFiles[all][3];
	var name = "branchNameDevBox1"+arrayOfFiles[i][0];
	name = name.replace(/\s/g, '_');
	var data = {location: arrayOfFiles[all][2], websiteBase: websiteBase, website: website, name: name};
	$.ajax({
	  url: urlForSend,
	  dataType: 'json',
	  data: data,
	  type: 'POST',
	  success: function(data){
	  	if(data['link'] != "null")
	  	{
	  		document.getElementById(name+"LogHogOuter").style.display = "inline-block";
	  		document.getElementById(name+"LogHogInner").href = data['link'];
	  	}
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


function poll(all = -1)
{
	if(all == '-1')
	{
		var arrayOfFilesLength = arrayOfFiles.length
		for(var i = 0; i < arrayOfFilesLength; i++)
		{
			var urlForSend = 'http://'+arrayOfFiles[i][1]+'/status/core/php/functions/gitBranchName.php?format=json'
			var name = "branchNameDevBox1"+arrayOfFiles[i][0];
			name = name.replace(/\s/g, '_');
			var data = {location: arrayOfFiles[i][2], name: name, githubRepo: arrayOfFiles[i][4]};
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
					pollFailure(data, _data);
				}
			});

				}(data));
		}
	}
	else
	{
		var urlForSend = 'http://'+arrayOfFiles[all][1]+'/status/core/php/functions/gitBranchName.php?format=json'
		var name = "branchNameDevBox1"+arrayOfFiles[all][0];
		name = name.replace(/\s/g, '_');
		var data = {location: arrayOfFiles[all][2], name: name, githubRepo: arrayOfFiles[all][4]};
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
					pollFailure(data, _data);
				}
			});

				}(data));
	}
}

function pollFailure(dataInner, dataInnerPass)
{
	var noSpaceName = dataInnerPass['name'].replace(/\s/g, '');
    var dataBranchForFile = '<span id="'+noSpaceName+'";">Error</span>';
    var dataBranchForFileUpdateTime = '<span id="'+noSpaceName+'Update";">n/a</span>';
    var dataBranchForFileStats = '<span id="'+noSpaceName+'Stats";">Could not connect to server</span>';
    document.getElementById(noSpaceName).outerHTML = dataBranchForFile;
    document.getElementById(noSpaceName+'Update').outerHTML = dataBranchForFileUpdateTime;
    document.getElementById(noSpaceName+'Stats').outerHTML = dataBranchForFileStats;
    var nameForBackground = "innerFirstDevBox"+noSpaceName;
    filterBGColor('error', nameForBackground);
}

function pollSuccess(dataInner, dataInnerPass)
{
	// we make a successful JSONP call!
	if(dataInner['branch'])
	{
		var dataStats = dataInner['stats'].replace("','", "'"+'&#44;'+"'");
	    var dataStats = dataStats.split(", <");
	    var dataBranchForFile = '<span id="'+dataInner['idName']+'";">';
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
	    var dataBranchForFileUpdateTime = '<span id="'+dataInner['idName']+'Update";">'+dataInner['time']+'</span>';
	    var dataBranchForFileStats = '<span id="'+dataInner['idName']+'Stats";">';
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
			//console.log(dataInner['branch']);
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
				if(branchName.includes(arrayOfFilters[i]))
				{
					var numForcalc = (branchName.indexOf(arrayOfFilters[i]) + arrayOfFilters[i].length);
					var numForLinkIssue = "";
					while(!isNaN(branchName.charAt(numForcalc)) && numForcalc != (branchName.length))
					{
						numForLinkIssue += branchName.charAt(numForcalc);
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
				}
			}
		}
		dataBranchForFile += '</span>';


	    document.getElementById(dataInner['idName']).outerHTML = dataBranchForFile;
	    document.getElementById(dataInner['idName']+'Update').outerHTML = dataBranchForFileUpdateTime;
	    document.getElementById(dataInner['idName']+'Stats').outerHTML = dataBranchForFileStats;
	    var nameForBackground = "innerFirstDevBox"+dataInner['idName'];
	    filterBGColor(dataInner['branch'], nameForBackground);
	}
	else
	{
		//assume no data was recieved


	var noSpaceName = dataInnerPass['name'].replace(/\s/g, '');
    var dataBranchForFile = '<span id="'+noSpaceName+'";">Error</span>';
    var dataBranchForFileUpdateTime = '<span id="'+noSpaceName+'Update";">n/a</span>';
    var dataBranchForFileStats = '<span id="'+noSpaceName+'Stats";">No Data Recieved from server. Probably could not execute command</span>';
    document.getElementById(noSpaceName).outerHTML = dataBranchForFile;
    document.getElementById(noSpaceName+'Update').outerHTML = dataBranchForFileUpdateTime;
    document.getElementById(noSpaceName+'Stats').outerHTML = dataBranchForFileStats;
    var nameForBackground = "innerFirstDevBox"+noSpaceName;
    filterBGColor('error', nameForBackground);


	}
}

function reverseString(str)
{
    return str.split("").reverse().join("");
}


function filterBGColor(filterName, idName)
{
	var newBG = false;
	if(filterName == "master")
	{
		document.getElementById(idName).style.backgroundColor = "lightGreen";
		newBG = true;
	}
	if(filterName == "error")
	{
		document.getElementById(idName).style.backgroundColor = "#C33";
		newBG = true;
	}
	if(!newBG)
	{
		document.getElementById(idName).style.backgroundColor = "#aaaaaa";
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


poll();
pollingRate = pollingRate * 60000; 
setInterval(pollTimed, pollingRate);

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
    }
    else
    {
    	$('.dropdown-content').hide();
    	document.getElementById("dropdown-"+nameOfElem).style.display = 'block';
    }
}

window.onclick = function(event) {
	if (!event.target.matches('.expandMenu')) {
		$('.dropdown-content').hide();
	}
}