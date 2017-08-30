<form id="settingsDevBoxVars" action="core/php/saveFunctions/settingsSaveMain.php" method="post">
	<div class="innerFirstDevBox"  >
		<div class="devBoxTitle">
			<b>Advanced</b> <button class="buttonButton" onclick="displayLoadingPopup();" >Save Changes</button>
		</div>
		<div class="devBoxContent">
			<ul class="settingsUl">
				<li>
					<span class="leftSpacingserverNames" >Dev Branches:</span>
						<select name="enableDevBranchDownload">
	  						<option <?php if($enableDevBranchDownload == 'true'){echo "selected";} ?> value="true">True</option>
	  						<option <?php if($enableDevBranchDownload == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
				</li>
				<li>
					<span class="leftSpacingserverNames" >Login Auth:</span>
						<select name="loginAuthType">
	  						<option <?php if($loginAuthType == 'disabled'){echo "selected";} ?> value="disabled">Disabled</option>
	  						<option <?php if($loginAuthType == 'LAPD'){echo "selected";} ?> value="LAPD">LAPD</option>
	  						<option <?php if($loginAuthType == 'PHP'){echo "selected";} ?> value="PHP">PHP</option>
	  						<option <?php if($loginAuthType == 'GitHub'){echo "selected";} ?> value="GitHub">GitHub</option>
						</select>
				</li>
			</ul>
		</div>
	</div>
</form>