var arrayOfFilesLength = arrayOfFiles.length
for(var i = 0; i < arrayOfFilesLength; i++)
{
	var urlForSend = 'https://'+arrayOfFiles[i][1]+'/status/core/php/functions/gitBranchName.php?format=json'
	var data = {location: arrayOfFiles[i][2]};
	$.ajax({
	  url: urlForSend,
	  dataType: 'json',
	  data: data,
	  type: 'POST',
	  jsonpCallback: 'MyJSONPCallback', // specify the callback name if you're hard-coding it
	  success: function(data){
	    // we make a successful JSONP call!
	    console.log(data);
	  }
	});
}