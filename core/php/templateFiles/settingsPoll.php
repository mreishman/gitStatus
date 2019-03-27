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
			<table width="100%">
				<tr>
					<td>
						Polling Rate:
					</td>
					<td>
						<input style="width: 52px; margin-left: 5px;" type="text" name="pollingRate" value="<?php echo $pollingRate;?>" > Min
					</td>
				</tr>
				<tr>
					<td>
						Background Poll Rate:
					</td>
					<td>
						<input style="width: 52px; margin-left: 5px;" type="text" name="pollingRateBG" value="<?php echo $pollingRateBG;?>" > Min
					</td>
				</tr>
				<tr>
					<td>
						Pause Poll:
					</td>
					<td>
						<select name="pausePoll">
	  						<option <?php if($pausePoll == 'true'){echo "selected";} ?> value="true">Yes</option>
	  						<option <?php if($pausePoll == 'almostTrue'){echo "selected";} ?> value="almostTrue">After First</option>
	  						<option <?php if($pausePoll == 'false'){echo "selected";} ?> value="false">No</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Poll Type:
					</td>
					<td>
						<select name="pollType">
	  						<option <?php if($pollType == "1"){echo "selected";} ?> value="1">Version 1</option>
	  						<option <?php if($pollType == "2"){echo "selected";} ?> value="2">Version 2</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<p class="description" >Poll Type Version 1: _______</p>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<p class="description" >Poll Type Version 2: _______</p>
					</td>
				</tr>
				<tr>
					<td>
						On Remove of server:
					</td>
					<td>
						<select name="onServerRemoveRemoveNotError">
	  						<option <?php if($onServerRemoveRemoveNotError == 'true'){echo "selected";} ?> value="true">Show Errorr</option>
	  						<option <?php if($onServerRemoveRemoveNotError == 'false'){echo "selected";} ?> value="false">Hide Server</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Refresh Visible
					</td>
					<td>
						<select name="onlyRefreshVisible">
							<option <?php if ($onlyRefreshVisible == 'true'){echo "selected";}?> value="true">True</option>
							<option <?php if ($onlyRefreshVisible == 'false'){echo "selected";}?> value="false">False</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<p class="description" >Only refresh data for visible sites. With poll type 2, this will still send a request even if only one of a network servers blocks are visible</p>
					</td>
				</tr>
			</table>
		</div>
	</div>
</form>