<form id="settingsPopupVars" action="core/php/saveFunctions/settingsSaveMain.php" method="post">
	<div class="innerFirstDevBox"  >
		<div class="devBoxTitle">
			<b>Popup Settings</b>
			<?php if($setupProcess == "finished" || $setupProcess == "preStart"): ?>
				<a class="buttonButton" onclick="saveAndVerifyMain('settingsPopupVars');" >Save Changes</a>
			<?php else: ?>
				<button class="buttonButton" onclick="displayLoadingPopup();" >Save Changes</button>
			<?php endif; ?>
		</div>
		<div class="devBoxContent">
			<table width="100%">
				<tr>
					<td>
						Max Commits:
					</td>
					<td>
						<input style="width: 52px;" type="text" name="maxCommits" value="<?php echo $maxCommits;?>" >
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Default Branch List:
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input style="width: 200px;" type="text" name="defaultBranchList" value="<?php echo $defaultBranchList;?>" >
					</td>
				</tr>
			</table>
		</div>
	</div>
</form>