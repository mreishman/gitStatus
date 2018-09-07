function checkForUpdateDefinitely(showPopupForNoUpdate = false)
{
	if(!updating)
	{
		updating = true;
		if(showPopupForNoUpdate)
		{
			displayLoadingPopup("./core/img/");
		}
		$.getJSON('core/php/update/settingsCheckForUpdate.php', {}, function(data) 
		{
			if(data.version == "1" || data.version == "2" | data.version == "3")
			{
				//Update needed
				if(dontNotifyVersion != data.versionNumber)
				{
					dataFromUpdateCheck = data;
					timeoutVar = setInterval(function(){updateUpdateCheckWaitTimer();},3000);
				}
			}
			else if (data.version == "0")
			{
				if(showPopupForNoUpdate)
				{
					showPopup();
					document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='devBoxTitle' >No Update Needed</div><br><div style='width:100%;text-align:center;'>You are on the most current version</div><div class='buttonButton' onclick='hidePopup();' style='margin-left:50px; margin-right:50px;margin-top:25px;'>Okay!</div></div>";
				}
			}
			else
			{
				//error?
				showPopup();
				document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='devBoxTitle' >Error when checking for update</div><br><div style='padding-left:10px;padding-right:10px;'>An error occured while trying to check for updates. Make sure you are connected to the internet and settingsCheckForUpdate.php has sufficient rights to write / create files. </div><div class='buttonButton' onclick='hidePopup();' style='margin-left:50px; margin-right:50px;margin-top:5px;'>Okay!</div></div>";
			}
			
		});
		updating = false;
	}
}

function updateUpdateCheckWaitTimer()
{
	$.getJSON("core/php/update/configStaticCheck.php", {}, function(data) 
	{
		if(currentVersion != data)
		{
			clearInterval(timeoutVar);
			showUpdateCheckPopup(dataFromUpdateCheck);
		}
	});
}