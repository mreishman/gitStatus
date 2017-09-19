document.getElementById("menuBarLeftSettings").style.backgroundColor  = "#ffffff";

var countOfClicksFilterBranch = 0;
var countOfClicksFilterAuthor = 0;
var countOfClicksFilterComittee = 0;
var cacheClearCount = 0;

function addRowFunction()
{
	var filterType = whichTypeOfFilterIsSelected();
	var counter = 0;
	var highestRowCount = 0;
	documentUpdateText = '<li ';
	if(filterType == 'newRowLocationForFilterBranch')
	{
		counter = countOfClicksFilterBranch;
		countOfClicksFilterBranch++;
		highestRowCount = counfOfFiltersForbranchName;
	}
	else if (filterType == 'newRowLocationForFilterAuthor')
	{
		counter = countOfClicksFilterAuthor;
		countOfClicksFilterAuthor++;
		highestRowCount = counfOfFiltersForAuthorName;
	}
	else
	{
		counter = countOfClicksFilterComittee;
		countOfClicksFilterComittee++;
		highestRowCount = counfOfFiltersForComitteeName;
	}
	documentUpdateText += "id='"+filterType+""+(highestRowCount+counter+1)+"'";
	documentUpdateText += '><div class="colorSelectorDiv"><div class="inner-triangle" ></div><button id='+filterType+'button'+(highestRowCount+counter+1)+' class="backgroundButtonForColor"></button></div>';
	documentUpdateText += '&nbsp;<input id="'+filterType+'Color'+(highestRowCount+counter+1)+'" style="display: none;" type="text" value="000"  name="'+filterType+'Color'+(highestRowCount+counter+1)+'">'
	documentUpdateText += '&nbsp;&nbsp;<input type="text" value="" name="'+filterType+"Name"+(highestRowCount+1+counter)+'" >&nbsp;&nbsp;&nbsp;<select><option value="default" >Default(=)</option><option value="includes" >Includes</option></select>&nbsp;<a class="mainLinkClass"  onclick="deleteRowFunction('+(highestRowCount+1+counter)+', true)">Remove Filter</a></li>';
	documentUpdateText += '<div style="display: none;" id="'+filterType+'New'+(highestRowCount+1+counter)+'"></div>';
	var newFilter = filterType + "New";
	if(counter != 0)
	{
		newFilter += (highestRowCount+counter);
	}
	document.getElementById(newFilter).outerHTML += documentUpdateText;
	var picker = new jscolor(document.getElementById(filterType+'button'+(highestRowCount+counter+1)), {valueElement: filterType+'Color'+(highestRowCount+counter+1)});

}

function deleteRowFunction(currentRow, decreaseCountWatchListNum)
{
	var filterType = whichTypeOfFilterIsSelected();
	var elementToFind = filterType+currentRow;
	if(decreaseCountWatchListNum)
	{
		var countOfHeighestNum = 1;
		console.log(filterType+countOfHeighestNum);
		while (document.getElementById(filterType+countOfHeighestNum))
		{
			countOfHeighestNum++;
		}
		countOfHeighestNum--;
		document.getElementById(elementToFind).outerHTML = "";
		if(currentRow < countOfHeighestNum)
		{
			//this wasn't the last folder deleted, update others
			for(var i = currentRow + 1; i <= countOfHeighestNum; i++)
			{
				var updateItoIMinusOne = i - 1;
				var elementToUpdate = filterType + i;
				documentUpdateText = '<li ';
				if(filterType == 'newRowLocationForFilterBranch')
				{
					counter = countOfClicksFilterBranch;
					highestRowCount = counfOfFiltersForbranchName;
				}
				else if (filterType == 'newRowLocationForFilterAuthor')
				{
					counter = countOfClicksFilterAuthor;
					highestRowCount = counfOfFiltersForAuthorName;
				}
				else
				{
					counter = countOfClicksFilterComittee;
					highestRowCount = counfOfFiltersForComitteeName;
				}
				documentUpdateText += "id='"+filterType+""+updateItoIMinusOne+"'";
				documentUpdateText += '><div class="colorSelectorDiv"><div class="inner-triangle" ></div><button id='+filterType+'button'+updateItoIMinusOne+' class="backgroundButtonForColor"></button></div>';
				documentUpdateText += '&nbsp;<input id="'+filterType+'Color'+updateItoIMinusOne+'" style="display: none;" type="text" value="';
				documentUpdateText += document.getElementById(filterType+'Color'+i).value;
				documentUpdateText += '"  name="'+filterType+'Color'+updateItoIMinusOne+'">'
				documentUpdateText += '&nbsp;&nbsp;<input type="text" value="';
				documentUpdateText += document.getElementById(filterType+'Name'+i).value;
				documentUpdateText += '" name="'+filterType+"Name"+updateItoIMinusOne+'" >&nbsp;&nbsp;&nbsp;<select><option value="default" >Default(=)</option><option value="includes" >Includes</option></select>&nbsp;<a class="mainLinkClass" onclick="deleteRowFunction('+updateItoIMinusOne+', true)">Remove Filter</a></li>';
				document.getElementById(filterType+i).outerHTML = documentUpdateText;

				var picker = new jscolor(document.getElementById(filterType+'button'+updateItoIMinusOne), {valueElement: filterType+'Color'+updateItoIMinusOne});


			}
		}
	}
	else
	{
		document.getElementById(elementToFind).outerHTML = "";
	}
}

function whichTypeOfFilterIsSelected()
{
	var valueForPopup = document.getElementById('branchColorTypeSelector').value;
	if(valueForPopup == 'branchName')
	{
		return 'newRowLocationForFilterBranch';
	}
	else if (valueForPopup == 'authorName')
	{
		return 'newRowLocationForFilterAuthor';
	}
	else
	{
		return 'newRowLocationForFilterComittee';
	}
}	

function switchToNewFilterBranchColor()
{
	var filterType = whichTypeOfFilterIsSelected();
	document.getElementById('colorBasedOnNameOfBranch').style.display = 'none';
	document.getElementById('colorBasedOnAuthorName').style.display = 'none';
	document.getElementById('colorBasedOnComitteeName').style.display = 'none';
	if(filterType == 'newRowLocationForFilterBranch')
	{
		document.getElementById('colorBasedOnNameOfBranch').style.display = 'block';
	}
	else if (filterType == 'newRowLocationForFilterAuthor')
	{
		document.getElementById('colorBasedOnAuthorName').style.display = 'block';
	}
	else
	{
		document.getElementById('colorBasedOnComitteeName').style.display = 'block';
	}
}

function clearCache()
{
	//ajax to php to empty cache
	displayLoadingPopup();
	var urlForSend = 'core/php/saveFunctions/cachedStatus.php?format=json'
	var data = {clearArray: true};
	console.log(data);
	(function(_data)
	{
		$.ajax({
		url: urlForSend,
		dataType: 'json',
		global: false,
		data: data,
		type: 'POST',
		success(data)
		{
			console.log(data);
		},
		complete: function(data)
		{
			verifyCacheClear();
		}
		});
	}(data));

}

function verifyCacheClear()
{
	cacheClearCount++;
	if(cacheClearCount < 90)
	{
		//ajax to verify cache is cleared
		var urlForSend = 'core/php/functions/getCache.php?format=json'
		var data = {};
		(function(_data)
		{
			$.ajax({
			url: urlForSend,
			dataType: 'json',
			global: false,
			data: data,
			type: 'POST',
			success: function(data)
			{
				console.log(data);
				if(!data)
				{
					cacheClearSuccess();
				}
				else
				{
					setTimeout(verifyCacheClear, 1000);
				}
			},
			failure: function(data)
			{
				verifyCacheClear();
			}
			});
		}(data));
	}
	else
	{
		cacheClearUnsuccess();
	}
}

function cacheClearSuccess()
{
	document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='devBoxTitle' ><b>Cache Cleared!</b></div><br><br><div style='width:100%;text-align:center;'> Cache Cleared <button class='buttonButton' onclick='hidePopup();' >Ok!</button></div>";
}

function cacheClearUnsuccess()
{
	document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='devBoxTitle' ><b>Cache Not Cleared</b></div><br><br><div style='width:100%;text-align:center;'> An error occured when clearing cache <br> <button class='buttonButton' onclick='hidePopup();' >Ok :c</button></div>";
}

document.getElementById("branchColorTypeSelector").addEventListener("change", switchToNewFilterBranchColor, false);