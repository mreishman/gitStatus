<form id="settingsDevBoxVars" action="core/php/saveFunctions/settingsSaveMain.php" method="post">
	<div class="innerFirstDevBox"  >
		<div class="devBoxTitle">
			<b>Advanced</b>
			<a class="buttonButton" onclick="saveAndVerifyMain('settingsDevBoxVars');" >Save Changes</a>
		</div>
		<div class="devBoxContent">
			<table width="100%">
				<tr>
					<td>
						Dev Branches:
					</td>
					<td>
						<select name="enableDevBranchDownload">
	  						<option <?php if($enableDevBranchDownload == 'true'){echo "selected";} ?> value="true">True</option>
	  						<option <?php if($enableDevBranchDownload == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Save Success Num:
					</td>
					<td>
						<select name="successVerifyNum">
	  						<option <?php if($successVerifyNum == 1){echo "selected";} ?> value="1">1</option>
	  						<option <?php if($successVerifyNum == 2){echo "selected";} ?> value="2">2</option>
	  						<option <?php if($successVerifyNum == 3){echo "selected";} ?> value="3">3</option>
	  						<option <?php if($successVerifyNum == 4){echo "selected";} ?> value="4">4</option>
	  						<option <?php if($successVerifyNum == 5){echo "selected";} ?> value="5">5</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Allow Poll Type Version 1:
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<select name="disablePostRequestWithPostData">
	  						<option <?php if($disablePostRequestWithPostData == 'false'){echo "selected";} ?> value="false">Yes (Not Recommended)</option>
	  						<option <?php if($disablePostRequestWithPostData == 'true'){echo "selected";} ?> value="true">No (Recommended)</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<p class="description" >Allows/Disallows the use of other status instances to send V1 requests to this current instance</p>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Block:
					</td>
				</tr>
				<tr>
					<td>
						gitBranchName
					</td>
					<td>
						<select name="blockGitBranchName">
	  						<option <?php if($blockGitBranchName == 'true'){echo "selected";} ?> value="true">True</option>
	  						<option <?php if($blockGitBranchName == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						gitCommitDiff
					</td>
					<td>
						<select name="blockGitCommitDiff">
  						<option <?php if($blockGitCommitDiff == 'true'){echo "selected";} ?> value="true">True</option>
  						<option <?php if($blockGitCommitDiff == 'false'){echo "selected";} ?> value="false">False</option>
					</select>
					</td>
				</tr>
				<tr>
					<td>
						gitCommitHistory
					</td>
					<td>
						<select name="blockGitCommitHistory">
	  						<option <?php if($blockGitCommitHistory == 'true'){echo "selected";} ?> value="true">True</option>
	  						<option <?php if($blockGitCommitHistory == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						gitShowCommitStuff
					</td>
					<td>
						<select name="blockGitShowCommitStuff">
	  						<option <?php if($blockGitShowCommitStuff == 'true'){echo "selected";} ?> value="true">True</option>
	  						<option <?php if($blockGitShowCommitStuff == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
					</td>
				</tr>
			</table>
		</div>
	</div>
</form>