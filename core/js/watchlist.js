
function addRowFunction()
{

	countOfWatchList++;
	countOfClicks++;
	var documentUpdateText = "<li class='watchFolderGroups' id='rowNumber"+countOfWatchList+"'><span class='leftSpacingserverNames' > Name: </span> <input class='inputWidth300' type='text'  name='watchListKey" + countOfWatchList + "' >";
	for(var i = 0; i < numberOfSubRows; i++)
	{
		documentUpdateText += "<br> <span class='leftSpacingserverNames' > "+arrayOfKeysNonEnc[i]+": </span> <input style='display: none;' type='text' name='watchListItem"+countOfWatchList+"-"+(i+1)+"-Name' value="+arrayOfKeysNonEnc[i]+">   <input class='inputWidth300' type='text' name='watchListItem" + countOfWatchList + "-" + (i+1) + "' >"
	}
	documentUpdateText += '<br>  <input style="display: none" type="text" name="watchListItem'+countOfWatchList+'-0" value="'+numberOfSubRows+'"> '
	documentUpdateText += " <span class='leftSpacingserverNames' ></span> <a class='mainLinkClass'  onclick='deleteRowFunction("+ countOfWatchList +", true)'>Remove</a></li><div style='display:inline-block;' id='newRowLocationForWatchList"+countOfClicks+"'></div>";
	document.getElementById(locationInsert).outerHTML += documentUpdateText;
	document.getElementById('numberOfRows').value = countOfWatchList;
	countOfAddedFiles++;
	locationInsert = "newRowLocationForWatchList"+countOfClicks;
}

function deleteRowFunction(currentRow, decreaseCountWatchListNum)
{
	var elementToFind = "rowNumber" + currentRow;
	document.getElementById(elementToFind).outerHTML = "";
	if(decreaseCountWatchListNum)
	{
		newValue = document.getElementById('numberOfRows').value;
		if(currentRow < newValue)
		{
			//this wasn't the last folder deleted, update others
			for(var i = currentRow + 1; i <= newValue; i++)
			{
				var updateItoIMinusOne = i - 1;
				var elementToUpdate = "rowNumber" + i;
				var documentUpdateText = "<li class='watchFolderGroups' id='rowNumber"+updateItoIMinusOne+"' ><span class='leftSpacingserverNames' > Name: </span> ";
				var watchListKeyIdFind = "watchListKey"+i;
				
				var previousElementNumIdentifierForKey  = document.getElementsByName(watchListKeyIdFind);
				
				documentUpdateText += "<input class='inputWidth300' ";
				documentUpdateText += "type='text' name='watchListKey"+updateItoIMinusOne+"' value='"+previousElementNumIdentifierForKey[0].value+"'> ";
				for(var j = 0; j < numberOfSubRows; j++)
				{
					var watchListItemIdFind = "watchListItem"+i+"-"+(j+1);
					var previousElementNumIdentifierForItem  = document.getElementsByName(watchListItemIdFind);
					documentUpdateText += "<br> <span class='leftSpacingserverNames' > "+arrayOfKeysNonEnc[j]+": </span> <input style='display: none;' type='text' name='watchListItem"+updateItoIMinusOne+"-"+(j+1)+"-Name' value="+arrayOfKeysNonEnc[j]+">  <input class='inputWidth300' type='text' name='watchListItem"+updateItoIMinusOne+"-"+(j+1)+"' value='"+previousElementNumIdentifierForItem[0].value+"'>";
				}
				documentUpdateText += '<br>  <input style="display: none" type="text" name="watchListItem'+updateItoIMinusOne+'-0" value="'+numberOfSubRows+'"> ';
				documentUpdateText += '<span class="leftSpacingserverNames" ></span> <a class="mainLinkClass" onclick="deleteRowFunction('+updateItoIMinusOne+', true)">Remove</a>';
				documentUpdateText += '</li>';
				document.getElementById(elementToUpdate).outerHTML = documentUpdateText;
			}
		}
		newValue--;
		if(countOfAddedFiles > 0)
		{
			countOfAddedFiles--;
			countOfWatchList--;
		}
		document.getElementById('numberOfRows').value = newValue;
	}

}	

function testConnection(currentRow)
{
	//get info for request (URL hit, if defined or website base / folder)
}