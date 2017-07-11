<form id="settingsCustomMessage" action="core/php/saveFunctions/settingsSaveMain.php" method="post">
	<div class="innerFirstDevBox"  >
		<div class="devBoxTitle">
			<b>Custom Message</b> <button class="buttonButton" onclick="displayLoadingPopup();" >Save Changes</button>
		</div>
		<div class="devBoxContent">
			<ul class="settingsUl">
				<li>
					<span class="leftSpacingserverNames">Set Message:</span>
					<select name="messageTextEnabled">
  						<option <?php if($messageTextEnabled == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($messageTextEnabled == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
				</li>
				<li>
					<span class="leftSpacingserverNames">Message Text:</span>
					<input type="text" name="messageText" value='<?php echo $messageText;?>'>
				</li>
				<li>
					<span class="leftSpacingserverNames">Disable</span>
					<select name="enableBlockUntilDate">
  						<option <?php if($enableBlockUntilDate == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($enableBlockUntilDate == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
					<p class="description" >Disable other git-status severs from getting info from this server untill specified date</p>
				</li>
				<li>
					<span class="leftSpacingserverNames">Specified Date:</span>
					<input type="text" id="datepicker" name='datePicker' value='<?php echo $datePicker;?>'>
				</li>
			</ul>
		</div>
	</div>
</form>