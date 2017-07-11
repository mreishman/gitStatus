<form id="settingsDevBoxVars" action="core/php/saveFunctions/settingsSaveMain.php" method="post">
	<div class="innerFirstDevBox"  >
		<div class="devBoxTitle">
			<b>Dev Box Settings</b> <button class="buttonButton" onclick="displayLoadingPopup();" >Save Changes</button>
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
			</ul>
		</div>
	</div>
</form>