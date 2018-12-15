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
			<ul class="settingsUl">
				<li>
					<span class="leftSpacingserverNames" > Commits: </span> <input style="width: 52px;" type="text" name="maxCommits" value="<?php echo $maxCommits;?>" > Max
				</li>
				<li>
					Default Branch List:<input style="width: 200px;" type="text" name="defaultBranchList" value="<?php echo $defaultBranchList;?>" >
				</li>
			</ul>
		</div>
	</div>
</form>