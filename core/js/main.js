
function poll(all = -1)
{
	if(all == '-1')
	{
		var arrayOfFilesLength = arrayOfFiles.length
		for(var i = 0; i < arrayOfFilesLength; i++)
		{
			var urlForSend = 'https://'+arrayOfFiles[i][1]+'/status/core/php/functions/gitBranchName.php?format=json'
			var name = "branchNameDevBox1"+arrayOfFiles[i][0];
			var data = {location: arrayOfFiles[i][2], name: name};
			$.ajax({
			  url: urlForSend,
			  dataType: 'json',
			  data: data,
			  type: 'POST',
			  jsonpCallback: 'MyJSONPCallback', // specify the callback name if you're hard-coding it
			  success: function(data){
			    // we make a successful JSONP call!
			    var dataStats = data['stats'].split(",");
			    var dataBranchForFile = '<span id="'+data['idName']+'";">'+data['branch']+'</span>';
			    var dataBranchForFileUpdateTime = '<span id="'+data['idName']+'Update";">'+data['time']+'</span>';
			    var dataBranchForFileStats = '<span id="'+data['idName']+'Stats";">';
			    for(var j = 0; j < dataStats.length; j++)
			    {
			    	dataBranchForFileStats += dataStats[j];
			    	dataBranchForFileStats += "<br><br>";
			    }
			    dataBranchForFileStats +='</span>';
			    document.getElementById(data['idName']).outerHTML = dataBranchForFile;
			    document.getElementById(data['idName']+'Update').outerHTML = dataBranchForFileUpdateTime;
			    document.getElementById(data['idName']+'Stats').outerHTML = dataBranchForFileStats;
			  }
			});
		}
	}
	else
	{
		var urlForSend = 'https://'+arrayOfFiles[all][1]+'/status/core/php/functions/gitBranchName.php?format=json'
			var name = "branchNameDevBox1"+arrayOfFiles[all][0];
			var data = {location: arrayOfFiles[all][2], name: name};
			$.ajax({
			  url: urlForSend,
			  dataType: 'json',
			  data: data,
			  type: 'POST',
			  jsonpCallback: 'MyJSONPCallback', // specify the callback name if you're hard-coding it
			  success: function(data){
			    // we make a successful JSONP call!
			    var dataBranchForFile = '<span id="'+data['idName']+'";">'+data['branch']+'</span>';
			    var dataBranchForFileUpdateTime = '<span id="'+data['idName']+'Update";">'+data['time']+'</span>';
			    document.getElementById(data['idName']).outerHTML = dataBranchForFile;
			    document.getElementById(data['idName']+'Update').outerHTML = dataBranchForFileUpdateTime;
			  }
			});
	}
}

function refreshAction(refreshImage, all = -1)
{
	console.log(all);
	clearTimeout(refreshActionVar);
	document.getElementById(refreshImage).src="core/img/refresh-animated.gif";
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
	refreshActionVar = setTimeout(function(){endRefreshAction(refreshImage)}, 1500);
}

function endRefreshAction(refreshImage)
{
	document.getElementById(refreshImage).src="core/img/Refresh.png"; 
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

