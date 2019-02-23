<form id="settingsDevBoxVars" action="core/php/saveFunctions/settingsSaveMain.php" method="post">
	<div class="innerFirstDevBox"  >
		<div class="devBoxTitle">
			<b>Advanced</b>
			<a class="buttonButton" onclick="saveAndVerifyMain('settingsDevBoxVars');" >Save Changes</a>
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
					<span class="leftSpacingserverNames" >Allow PT  V1:</span>
						<select name="disablePostRequestWithPostData">
	  						<option <?php if($disablePostRequestWithPostData == 'false'){echo "selected";} ?> value="false">Yes (Not Recommended)</option>
	  						<option <?php if($disablePostRequestWithPostData == 'true'){echo "selected";} ?> value="true">No (Recommended)</option>
						</select>
					<p class="description" >Allows/Disallows the use of other status instances to send V1 requests to this current instance</p>
				</li>
				<li>
					Block:
					<ul style="list-style: none; margin: 0; padding: 0;">
						<li>
							<span>gitBranchName</span>
							<select name="blockGitBranchName">
		  						<option <?php if($blockGitBranchName == 'true'){echo "selected";} ?> value="true">True</option>
		  						<option <?php if($blockGitBranchName == 'false'){echo "selected";} ?> value="false">False</option>
							</select>
						</li>
						<li>
							<span>gitCommitDiff</span>
							<select name="blockGitCommitDiff">
		  						<option <?php if($blockGitCommitDiff == 'true'){echo "selected";} ?> value="true">True</option>
		  						<option <?php if($blockGitCommitDiff == 'false'){echo "selected";} ?> value="false">False</option>
							</select>
						</li>
						<li>
							<span>gitCommitHistory</span>
							<select name="blockGitCommitHistory">
		  						<option <?php if($blockGitCommitHistory == 'true'){echo "selected";} ?> value="true">True</option>
		  						<option <?php if($blockGitCommitHistory == 'false'){echo "selected";} ?> value="false">False</option>
							</select>
						</li>
						<li>
							<span>gitShowCommitStuff</span>
							<select name="blockGitShowCommitStuff">
		  						<option <?php if($blockGitShowCommitStuff == 'true'){echo "selected";} ?> value="true">True</option>
		  						<option <?php if($blockGitShowCommitStuff == 'false'){echo "selected";} ?> value="false">False</option>
							</select>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</form>