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
	    document.getElementById(data['idName']).outerHTML = data['branch'];
	  }
	});
}