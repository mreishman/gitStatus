var cacheClearCount = 0;
var showPopupForCacheClear = true;

function clearCache()
{
	//ajax to php to empty cache
	displayLoadingPopup();
	var urlForSend = 'core/php/saveFunctions/cachedStatus.php?format=json'
	var data = {clearArray: true, currentVersion};
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
				if(jQuery.isEmptyObject(data))
				{
					if(showPopupForCacheClear)
					{
						cacheClearSuccess();
					}
					else
					{
						saveVerified();
					}
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