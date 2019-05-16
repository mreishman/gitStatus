<?php
$arrayOfGroups = array();
$showTopBarOfGroups = false;
$watchlistConfig = $config["watchList"];
if($pollType === "2")
{
	$watchlistConfig = $config["serverWatchList"];
}
foreach ($watchlistConfig as $key => $value)
{
	if(isset($value['groupInfo']) && !is_null($value['groupInfo']) && ($value['groupInfo'] != "") )
	{
		$showTopBarOfGroups = true;
		if(!in_array($value['groupInfo'], $arrayOfGroups))
		{
			array_push($arrayOfGroups, $value['groupInfo']);
		}
	}
}
array_push($arrayOfGroups, "All");
?>
<form id="settingsMainVars" action="core/php/saveFunctions/settingsSaveMain.php" method="post">
	<div class="innerFirstDevBox"  >
		<div class="devBoxTitle">
			<b>Settings</b>
			<?php if($setupProcess == "finished" || $setupProcess == "preStart"): ?>
				<a class="buttonButton" onclick="saveAndVerifyMain('settingsMainVars');" >Save Changes</a>
			<?php else: ?>
				<button class="buttonButton" onclick="displayLoadingPopup();" >Save Changes</button>
			<?php endif; ?>
		</div>
		<div class="devBoxContent">
			<table width="100%">
				<tr>
					<td>
						Check Update:
					</td>
					<td>
						<select name="autoCheckUpdate">
	  						<option <?php if($autoCheckUpdate == 'true'){echo "selected";} ?> value="true">Auto</option>
	  						<option <?php if($autoCheckUpdate == 'false'){echo "selected";} ?> value="false">Manual</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Default View:
					</td>
					<td>
						<select name="defaultViewBranch">
							<option <?php if($defaultViewBranch == 'Minimized'){echo "selected";} ?> value="Minimized">Minimized</option>
	  						<option <?php if($defaultViewBranch == 'Standard'){echo "selected";} ?> value="Standard">Standard</option>
	  						<option <?php if($defaultViewBranch == 'Expanded'){echo "selected";} ?> value="Expanded">Expanded</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Default View Cookie:
					</td>
					<td>
						<select name="defaultViewBranchCookie">
	  						<option <?php if($defaultViewBranchCookie == 'true'){echo "selected";} ?> value="true">True</option>
	  						<option <?php if($defaultViewBranchCookie == 'false'){echo "selected";} ?> value="false">False</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<p class="description" >Set default view by cookie, overrides above</p>
					</td>
				</tr>
				<tr>
					<td>
						Enable Cache:
					</td>
					<td>
						<select name="cacheEnabled">
	  						<option <?php if($cacheEnabled == 'true'){echo "selected";} ?> value="true">All</option>
	  						<option <?php if($cacheEnabled == 'read'){echo "selected";} ?> value="read">Read Only</option>
	  						<option <?php if($cacheEnabled == 'write'){echo "selected";} ?> value="write">Write Only</option>
	  						<option <?php if($cacheEnabled == 'false'){echo "selected";} ?> value="false">None</option>
						</select>
					</td>
				</tr>
				<?php if($showTopBarOfGroups): ?>
				<tr>
					<td>
						Default Group
					</td>
					<td>
						<select name="defaultGroupViewOnLoad">
							<?php
							sort($arrayOfGroups);
							foreach ($arrayOfGroups as $key => $value):
							?>
							<option <?php if ($defaultGroupViewOnLoad == $value){echo "selected";}?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
							<?php
							endforeach;
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<p class="description" >Default group visible on page load</p>
					</td>
				</tr>
				<?php endif; ?>
			</table>
		</div>
	</div>
</form>