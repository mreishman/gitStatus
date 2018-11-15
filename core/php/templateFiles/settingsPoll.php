<form id="settingsPollVars" action="core/php/saveFunctions/settingsSaveMain.php" method="post">
	<div class="innerFirstDevBox"  >
		<div class="devBoxTitle">
			<b>Poll Settings</b>
			<?php if($setupProcess == "finished" || $setupProcess == "preStart"): ?>
				<a class="buttonButton" onclick="saveAndVerifyMain('settingsPollVars');" >Save Changes</a>
			<?php else: ?>
				<button class="buttonButton" onclick="displayLoadingPopup();" >Save Changes</button>
			<?php endif; ?>
		</div>
		<div class="devBoxContent">
			<ul class="settingsUl">
				<li>
					<span class="leftSpacingserverNames" > Polling Rate: </span> <input style="width: 52px;" type="text" name="pollingRate" value="<?php echo $pollingRate;?>" > Minutes
				</li>
				<li>
					<span class="leftSpacingserverNames" > BG Poll Rate: </span> <input style="width: 52px;" type="text" name="pollingRateBG" value="<?php echo $pollingRateBG;?>" > Minutes
				</li>
				<li>
					<span class="leftSpacingserverNames" > Pause Poll: </span>
					<select name="pausePoll">
  						<option <?php if($pausePoll == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($pausePoll == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
				</li>
				<li>
					<span class="leftSpacingserverNames" > Poll Type: </span>
					<select name="pollType">
  						<option <?php if($pollType == 1){echo "selected";} ?> value="1">Version 1 [backwards compatable]</option>
  						<option <?php if($pollType == 2){echo "selected";} ?> value="2">Version 2 [more secure]</option>
					</select>
				</li>
				<li>
					<span class="leftSpacingserverNames" >On Remove of server: </span>
					<select name="onServerRemoveRemoveNotError">
  						<option <?php if($onServerRemoveRemoveNotError == 'true'){echo "selected";} ?> value="true">Show Errorr</option>
  						<option <?php if($onServerRemoveRemoveNotError == 'false'){echo "selected";} ?> value="false">Hide Server</option>
					</select>
				</li>
				<li>
					<span class="leftSpacingserverNames"> Refresh Visible</span>
					<select name="onlyRefreshVisible">
						<option <?php if ($onlyRefreshVisible == 'true'){echo "selected";}?> value="true">True</option>
						<option <?php if ($onlyRefreshVisible == 'false'){echo "selected";}?> value="false">False</option>
					</select>
					<p class="description" >Only refresh data for visible sites</p>
				</li>
			</ul>
		</div>
	</div>
</form>