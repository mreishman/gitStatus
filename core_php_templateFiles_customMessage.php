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
						<select name="messageTextEnabled">
	  						<option <?php if($messageTextEnabled == 'true'){echo "selected";} ?> value="true">True</option>
	  						<option <?php if($messageTextEnabled == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Message Text:
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="text" name="messageText" value='<?php echo $messageText;?>'>
					</td>
				</tr>
				<tr>
					<td>
						Disable:
					</td>
					<td>
						<select name="enableBlockUntilDate">
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
				<tr>
					<td colspan="2">
						Specified Date:
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="text" id="datepicker" name='datePicker' value='<?php echo $datePicker;?>'>
					</td>
				</tr>
			</table>
		</div>
	</div>
</form>