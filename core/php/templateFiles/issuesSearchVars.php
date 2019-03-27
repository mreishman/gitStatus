<form id="settingsIssueSearchVars" action="core/php/saveFunctions/settingsSaveMain.php" method="post">
	<div class="innerFirstDevBox" style="width: 500px;" >
		<div class="devBoxTitle">
			<b>Link Search</b>
			<a class="buttonButton" onclick="saveAndVerifyMain('settingsIssueSearchVars');" >Save Changes</a>
		</div>
		<div class="devBoxContent">
			<table>
				<tr>
					<th>
						<h2>Look for Issues in branch name </h2>
					</th>
				</tr>
				<tr>
					<td>
						<input type="checkbox" name="checkForIssueStartsWithNum" <?php if($checkForIssueStartsWithNum == 'true'){echo "checked";} ?> value="true">  Starts With Numbers
					</td>
				</tr>
				<tr>
					<td>
						<input type="checkbox" name="checkForIssueEndsWithNum" <?php if($checkForIssueEndsWithNum == 'true'){echo "checked";} ?> value="true"> Ends With Numbers
					</td>
				</tr>
				<tr>
					<td>
						<input type="checkbox" name="checkForIssueCustom" <?php if($checkForIssueCustom == 'true'){echo "checked";} ?> value="true">  Custom [Issue / Issue_ / Issue-]
					</td>
				</tr>
				<tr>
					<th>
						<h2>Look for Issues in commit </h2>
					</th>
				</tr>
				<tr>
					<td>
						<input type="checkbox" name="checkForIssueInCommit" <?php if($checkForIssueInCommit == 'true'){echo "checked";} ?> value="true">  Look for #____
					</td>
				</tr>
			</table>
		</div>
	</div>
</form>