<form id="settingsIssueSearchVars" action="core/php/saveFunctions/settingsSaveMain.php" method="post">
	<div class="innerFirstDevBox" style="width: 500px;" >
		<div class="devBoxTitle">
			<b>Link Search</b> <button class="buttonButton" onclick="displayLoadingPopup();" >Save Changes</button>
		</div>
		<div class="devBoxContent">
			<ul class="settingsUl">
				<li>
					<h2>Look for Issues in branch name </h2>
					
				</li>
				<li>
					<input type="checkbox" name="checkForIssueStartsWithNum" <?php if($checkForIssueStartsWithNum == 'true'){echo "checked";} ?> value="true">  Starts With Numbers  <br>
					<input type="checkbox" name="checkForIssueEndsWithNum" <?php if($checkForIssueEndsWithNum == 'true'){echo "checked";} ?> value="true"> Ends With Numbers <br>
					<input type="checkbox" name="checkForIssueCustom" <?php if($checkForIssueCustom == 'true'){echo "checked";} ?> value="true">  Custom [Issue / Issue_ / Issue-] <br>
				</li>
				<!-- <li>
					<a class="link underlineLink" >Add New Watch Condition</a>
				</li> -->
				<li>
					<h2>Look for Issues in commit </h2>
					
				</li>
				<li>
					<input type="checkbox" name="checkForIssueInCommit" <?php if($checkForIssueInCommit == 'true'){echo "checked";} ?> value="true">  Look for #____  <br>
				</li>
			</ul>
		</div>
	</div>
</form>