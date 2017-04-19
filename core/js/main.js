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
			var data = {location: arrayOfFiles[i][2], name: name};
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
		var data = {location: arrayOfFiles[all][2], name: name};
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
	var dataStats = dataInner['stats'].replace("','", "'"+'&#44;'+"'");
    var dataStats = dataStats.split(", <");
    var dataBranchForFile = '<span id="'+dataInner['idName']+'";">'+dataInner['branch'];
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
    for (var i = 0, len = dataBranchForFileStats.length; i < len; i++) {
	  if(dataBranchForFileStats[i] == "#")
	  {
	  	if(!isNaN(dataBranchForFileStats[i+1]))
	  	{
	  		if(dataBranchForFileStats[i-1] != "&")
	  		{
	  			var j = 1;
		  		var num = "";
		  		while(!isNaN(dataBranchForFileStats[i+j]))
		  		{
		  			num += dataBranchForFileStats[i+j];
		  			j++;
		  		}
		  		if(num != "")
		  		{
		  			var link = '<a href="#'+num+'">'+dataBranchForFileStats[i]+num+'</a>';
		  			dataBranchForFile += " "+link;
			  		dataBranchForFileStats = dataBranchForFileStats.replace(dataBranchForFileStats[i]+num,link);
			  		len = dataBranchForFileStats.length;
			  		i = i + link.length;
		  		}
	  		}
	  	}
	  }
	}

	dataBranchForFile += '</span>'

    document.getElementById(dataInner['idName']).outerHTML = dataBranchForFile;
    document.getElementById(dataInner['idName']+'Update').outerHTML = dataBranchForFileUpdateTime;
    document.getElementById(dataInner['idName']+'Stats').outerHTML = dataBranchForFileStats;
    var nameForBackground = "innerFirstDevBox"+dataInner['idName'];
    filterBGColor(dataInner['branch'], nameForBackground);
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

function refreshAction(refreshImage, all = -1, status = 'outer')
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


