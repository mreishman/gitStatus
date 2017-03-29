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
	    var dataBranchForFile = '<span id="'+data['idName']+'";">'+data['branch']+'</span>';
	    var dataBranchForFileUpdateTime = '<span id="'+data['idName']+'Update";">'+data['time']+'</span>';
	    document.getElementById(data['idName']).outerHTML = dataBranchForFile;
	    document.getElementById(data['idName']+'Update').outerHTML = dataBranchForFileUpdateTime;
	  }
	});
}