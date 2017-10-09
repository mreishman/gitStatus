<form id="settingsMainVars" action="core/php/saveFunctions/settingsSaveMain.php" method="post">
	<div class="innerFirstDevBox"  >
		<div class="devBoxTitle">
			<b>Settings</b> <button class="buttonButton" onclick="displayLoadingPopup();" >Save Changes</button>
		</div>
		<div class="devBoxContent">
			<ul class="settingsUl">
				<li>
					<span class="leftSpacingserverNames" > Polling Rate: </span> <input style="width: 52px;" type="text" name="pollingRate" value="<?php echo $pollingRate;?>" > Minutes
				</li>
				<li>
					<span class="leftSpacingserverNames" > Pause Poll: </span>
					<select name="pausePoll">
  						<option <?php if($pausePoll == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($pausePoll == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
				</li>
				<li style="display: none;">
					<span class="leftSpacingserverNames" > Auto Pause: </span>
					<select name="pauseOnNotFocus">
  						<option <?php if($pauseOnNotFocus == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($pauseOnNotFocus == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
				</li>
				<li>
					<span class="leftSpacingserverNames" > Check Update: </span>
					<select name="autoCheckUpdate">
  						<option <?php if($autoCheckUpdate == 'true'){echo "selected";} ?> value="true">Auto</option>
  						<option <?php if($autoCheckUpdate == 'false'){echo "selected";} ?> value="false">Manual</option>
					</select>
				</li>
				<li>
					<span class="leftSpacingserverNames" > Default View: </span>
					<select name="defaultViewBranch">
  						<option <?php if($defaultViewBranch == 'Standard'){echo "selected";} ?> value="Standard">Standard</option>
  						<option <?php if($defaultViewBranch == 'Expanded'){echo "selected";} ?> value="Expanded">Expanded</option>
					</select>
				</li>
				<li>
					<span class="leftSpacingserverNames" > DV Cookie: </span>

					<select name="defaultViewBranchCookie">
  						<option <?php if($defaultViewBranchCookie == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($defaultViewBranchCookie == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
					<p class="description" >Set default view by cookie, overrides above</p>
					
				</li>
				<li>
					<span class="leftSpacingserverNames" > Enable Cache: </span>

					<select name="cacheEnabled">
  						<option <?php if($cacheEnabled == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($cacheEnabled == 'false'){echo "selected";} ?> value="false">False</option>
					</select>					
				</li>
			</ul>
		</div>
	</div>
</form>