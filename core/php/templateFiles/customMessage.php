<form id="settingsCustomMessage" action="core/php/saveFunctions/settingsSaveMain.php" method="post">
	<div class="innerFirstDevBox"  >
		<div class="devBoxTitle">
			<b>Custom Message</b> <button class="buttonButton" onclick="displayLoadingPopup();" >Save Changes</button>
		</div>
		<div class="devBoxContent">
			<ul class="settingsUl">
				<li>
					<span class="leftSpacingserverNames">Set Message:</span>
					<select name="enableDevBranchDownload">
  						<option <?php if($enableDevBranchDownload == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($enableDevBranchDownload == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
				</li>
				<li>
					<span class="leftSpacingserverNames">Message Text:</span>
					<input type="text" name="messageText">
				</li>
				<li>
					<span class="leftSpacingserverNames">Disable</span>
					<select name="enableDevBranchDownload">
  						<option <?php if($enableDevBranchDownload == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($enableDevBranchDownload == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
					<p class="description" >Disable other git-status severs from getting info from this server untill specified date</p>
				</li>
				<li>
					<span class="leftSpacingserverNames">Specified Date:</span>
					<input type="text" id="datepicker">
				</li>
			</ul>
		</div>
	</div>
</form>