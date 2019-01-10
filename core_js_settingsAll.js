var modiferUrl = "";

function saveAndVerifyMain(idForForm, modifier = "")
{
	modiferUrl = modifier;
	idForFormMain = idForForm;
	idForm = "#"+idForForm;
	displayLoadingPopup();
	data = $(idForm).serializeArray();
	$.ajax({
        type: "post",
        url: modiferUrl+"core/php/saveFunctions/settingsSaveMain.php",
        data,
        complete()
        {
          //verify saved
          verifySaveTimer();
        }
      });

}

function verifySaveTimer()
{
	countForVerifySave = 0;
	pollCheckForUpdate = setInterval(timerVerifySave,3000);
}

function timerVerifySave()
{
	countForVerifySave++;
	if(countForVerifySave < 20)
	{
		var urlForSend = modiferUrl+"core/php/saveFunctions/saveCheck.php?format=json";
		$.ajax(
		{
			url: urlForSend,
			dataType: "json",
			data: data,
			type: "POST",
			success(data)
			{
				if(data === true)
				{
					clearInterval(pollCheckForUpdate);
					if(idForFormMain === "settingsMainWatch")
					{
						showPopupForCacheClear = false;
						clearCache();
					}
					else
					{
						if(document.getElementsByName("pollType")[0])
						{
							if(document.getElementsByName("pollType")[0].value !== "2")
							{
								document.getElementById("menuBarLeftSettingsServerWatchList").style.display = "none";
							}
							else
							{
								document.getElementById("menuBarLeftSettingsServerWatchList").style.display = "block";
							}
						}
						saveVerified();
					}
				}
			},
		});
	}
	else
	{
		clearInterval(pollCheckForUpdate);
		saveError();
	}
}

function saveVerified()
{
	saveSuccess();
	location.reload();
}

function saveSuccess()
{
	document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Saved Changes!</div><br><br><div style='width:100%;text-align:center;'> <img src='core/img/greenCheck.png' height='50' width='50'> </div>";
}

function saveError()
{
	document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Error</div><br><br><div style='width:100%;text-align:center;'> An Error Occured While Saving... </div>";
	fadeOutPopup();
}

function fadeOutPopup()
{
	setTimeout(hidePopup, 1000);
}