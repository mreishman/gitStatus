
function poll(all = -1)
{
	if(all == '-1')
	{
		var arrayOfFilesLength = arrayOfFiles.length
		for(var i = 0; i < arrayOfFilesLength; i++)
		{
			var urlForSend = 'http://'+arrayOfFiles[i][1]+'/status/core/php/functions/gitBranchName.php?format=json'
			var name = "branchNameDevBox1"+arrayOfFiles[i][0];
			var data = {location: arrayOfFiles[i][2], name: name};
			$.ajax({
			  url: urlForSend,
			  dataType: 'json',
			  data: data,
			  type: 'POST',
			  success: function(data){
			  	pollSuccess(data);
			  }
			});
		}
	}
	else
	{
		var urlForSend = 'http://'+arrayOfFiles[all][1]+'/status/core/php/functions/gitBranchName.php?format=json'
			var name = "branchNameDevBox1"+arrayOfFiles[all][0];
			var data = {location: arrayOfFiles[all][2], name: name};
			$.ajax({
			  url: urlForSend,
			  dataType: 'json',
			  data: data,
			  type: 'POST',
			  success: function(data){
			  	pollSuccess(data);
			  }
			});
	}
}

function pollSuccess(dataInner)
{
	// we make a successful JSONP call!
    var dataStats = dataInner['stats'].split(",");
    var dataBranchForFile = '<span id="'+dataInner['idName']+'";">'+dataInner['branch']+'</span>';
    var dataBranchForFileUpdateTime = '<span id="'+dataInner['idName']+'Update";">'+dataInner['time']+'</span>';
    var dataBranchForFileStats = '<span id="'+dataInner['idName']+'Stats";">';
    for(var j = 0; j < dataStats.length; j++)
    {
    	dataBranchForFileStats += dataStats[j];
    	dataBranchForFileStats += "<br><br>";
    }
    dataBranchForFileStats +='</span>';
    document.getElementById(dataInner['idName']).outerHTML = dataBranchForFile;
    document.getElementById(dataInner['idName']+'Update').outerHTML = dataBranchForFileUpdateTime;
    document.getElementById(dataInner['idName']+'Stats').outerHTML = dataBranchForFileStats;
    var nameForBackground = "innerFirstDevBox"+dataInner['idName'];
    console.log(nameForBackground);
    filterBGColor(dataInner['branch'], nameForBackground);
}

function filterBGColor(filterName, idName)
{
	if(filterName == "master")
	{
		document.getElementById(idName).style.backgroundColor = "lightGreen";
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
