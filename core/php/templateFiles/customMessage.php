<form id="settingsCustomMessage" action="core/php/saveFunctions/settingsSaveMain.php" method="post">
	<div class="innerFirstDevBox"  >
		<div class="devBoxTitle">
			<b>Custom Message</b>
			<a class="buttonButton" onclick="saveAndVerifyMain('settingsCustomMessage');" >Save Changes</a>
		</div>
		<div class="devBoxContent">
			<table width="100%">
				<tr>
					<td>
						Set Message:
					</td>
					<td>
						<select onchange="toggleMessageText();" name="messageTextEnabled" id="messageTextEnabled">
	  						<option <?php if($messageTextEnabled == 'true'){echo "selected";} ?> value="true">True</option>
	  						<option <?php if($messageTextEnabled == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
					</td>
				</tr>
				<tr class="messageTextTr" <?php if($messageTextEnabled != 'true'){echo "style='display: none'";} ?> >
					<td colspan="2">
						Message Text:
					</td>
				</tr>
				<tr class="messageTextTr" <?php if($messageTextEnabled != 'true'){echo "style='display: none'";} ?> >
					<td colspan="2">
						<input type="text" name="messageText" value='<?php echo $messageText;?>'>
					</td>
				</tr>
				<tr>
					<td>
						Disable:
					</td>
					<td>
						<select onchange="toggleDateBlockText();" name="enableBlockUntilDate" id="enableBlockUntilDate">
	  						<option <?php if($enableBlockUntilDate == 'true'){echo "selected";} ?> value="true">True</option>
	  						<option <?php if($enableBlockUntilDate == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<p class="description" >Disable other git-status severs from getting info from this server untill specified date</p>
					</td>
				</tr>
				<tr class="blockDateTr" <?php if($enableBlockUntilDate != 'true'){echo "style='display: none'";} ?> >
					<td colspan="2">
						Specified Date:
					</td>
				</tr>
				<tr class="blockDateTr" <?php if($enableBlockUntilDate != 'true'){echo "style='display: none'";} ?> >
					<td colspan="2">
						<input type="text" id="datepicker" name='datePicker' value='<?php echo $datePicker;?>'>
					</td>
				</tr>
			</table>
		</div>
	</div>
</form>
<script type="text/javascript">
	function toggleMessageText()
	{
		if(document.getElementById("messageTextEnabled").value == "true")
		{
			$(".messageTextTr").show();
		}
		else
		{
			$(".messageTextTr").hide();
		}
	}

	function toggleDateBlockText()
	{
		if(document.getElementById("enableBlockUntilDate").value == "true")
		{
			$(".blockDateTr").show();
		}
		else
		{
			$(".blockDateTr").hide();
		}
	}
</script>