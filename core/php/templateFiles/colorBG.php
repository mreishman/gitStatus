<?php if($branchColorFilter !== "branchName" && $branchColorFilter !== "authorName" && $branchColorFilter !== "committerName")
{
	//should not trigger, but this will set default to branchName if none is set
	$branchColorFilter = "branchName";
}
?>
<form id="settingsColorBG" action="core/php/saveFunctions/settingsSaveMain.php" method="post">
	<div class="innerFirstDevBox" style="width: 500px;" >
		<div class="devBoxTitle">
			<b>Dev Box Color Settings</b>
			<a class="buttonButton" onclick="saveAndVerifyMain('settingsColorBG');" >Save Changes</a>
		</div>
		<div class="devBoxContent">
				<ul class="settingsUl">
					<li>
						<h2>Color background based on:
						<select id="branchColorTypeSelector" name="branchColorFilter">
							<option <?php if ($branchColorFilter == "branchName"){echo "selected";}?> value="branchName">Name Of Branch</option>
							<option <?php if ($branchColorFilter == "authorName"){echo "selected";}?> value="authorName">Author Name</option>
							<option <?php if ($branchColorFilter == "committerName"){echo "selected";}?> value="committerName">Committer Name</option>
						</select></h2>
					</li>
					<span <?php if ($branchColorFilter != "branchName"){echo "style='display: none;'";}?> id="colorBasedOnNameOfBranch" >
					<?php 
					$counfOfFiltersForbranchName = 0;
					foreach ($errorAndColorArray as $key => $value):
					$counfOfFiltersForbranchName++; ?>
						<li id="newRowLocationForFilterBranch<?php echo $counfOfFiltersForbranchName;?>">
						<div class="colorSelectorDiv">
							 <div class="inner-triangle" ></div> 
							 <button class="backgroundButtonForColor jscolor{valueElement: 'newRowLocationForFilterBranchColor<?php echo $counfOfFiltersForbranchName;?>'}"></button>
						</div>

						<input id="newRowLocationForFilterBranchColor<?php echo $counfOfFiltersForbranchName;?>" style="display: none;" type="text" value="<?php echo $value['color'] ?>"  name="newRowLocationForFilterBranchColor<?php echo $counfOfFiltersForbranchName;?>">
						&nbsp;
						<input id="newRowLocationForFilterBranchName<?php echo $counfOfFiltersForbranchName;?>" type="text" value="<?php echo $key?>" name="newRowLocationForFilterBranchName<?php echo $counfOfFiltersForbranchName;?>">
						&nbsp;
						<select name="newRowLocationForFilterBranchSelect<?php echo $counfOfFiltersForbranchName;?>" >
							<option <?php if($value['type']=="default"){echo "selected";}?> value="default" >Default(=)</option>
							<option <?php if($value['type']=="includes"){echo "selected";}?> value="includes" >Includes</option>
						</select>
						<a class="mainLinkClass"  onclick="deleteRowFunction(<?php echo $counfOfFiltersForbranchName;?>, true)">Remove Filter</a>
						</li>
					<?php endforeach; ?>
						<div style="display: none;" id="newRowLocationForFilterBranchNew"></div>
					</span>
					<span <?php if ($branchColorFilter != "authorName"){echo "style='display: none;'";}?> id="colorBasedOnAuthorName" >
					<?php
					$counfOfFiltersForAuthorName = 0;
					foreach ($errorAndColorAuthorArray as $key => $value): 
						$counfOfFiltersForAuthorName++; ?>
						<li id="newRowLocationForFilterAuthor<?php echo $counfOfFiltersForAuthorName;?>">
						<div class="colorSelectorDiv">
							 <div class="inner-triangle" ></div> 
							 <button class="backgroundButtonForColor jscolor{valueElement: 'newRowLocationForFilterAuthorColor<?php echo $counfOfFiltersForAuthorName;?>'}"></button>
						</div>
						<input id="newRowLocationForFilterAuthorColor<?php echo $counfOfFiltersForAuthorName;?>" style="display: none;" type="text" value="<?php echo $value['color'] ?>"  name="newRowLocationForFilterAuthorColor<?php echo $counfOfFiltersForAuthorName;?>">
						&nbsp;
						<input id="newRowLocationForFilterAuthorName<?php echo $counfOfFiltersForAuthorName;?>" type="text" value="<?php echo $key?>" name="newRowLocationForFilterAuthorName<?php echo $counfOfFiltersForAuthorName;?>">
						&nbsp;
						<select name="newRowLocationForFilterAuthorSelect<?php echo $counfOfFiltersForAuthorName;?>" >
							<option <?php if($value['type']=="default"){echo "selected";}?> value="default" >Default(=)</option>
							<option <?php if($value['type']=="includes"){echo "selected";}?> value="includes" >Includes</option>
						</select>
						<a class="mainLinkClass"   onclick="deleteRowFunction(<?php echo $counfOfFiltersForAuthorName;?>, true)">Remove Filter</a>
						</li>
					<?php endforeach; ?>
						<div style="display: none;" id="newRowLocationForFilterAuthorNew"></div>
					</span>
					<span  <?php if ($branchColorFilter != "committerName"){echo "style='display: none;'";}?> id="colorBasedOnComitteeName" >
					<?php
					$counfOfFiltersForComitteeName = 0;
					foreach ($errorAndColorComitteeArray as $key => $value): 
						$counfOfFiltersForComitteeName++; ?>
						<li id="newRowLocationForFilterComittee<?php echo $counfOfFiltersForComitteeName;?>">
						<div class="colorSelectorDiv">
							 <div class="inner-triangle" ></div> 
							 <button class="backgroundButtonForColor jscolor{valueElement: 'newRowLocationForFilterComitteeColor<?php echo $counfOfFiltersForComitteeName;?>'}"></button>
						</div>
						<input id="newRowLocationForFilterComitteeColor<?php echo $counfOfFiltersForComitteeName;?>" style="display: none;" type="text" value="<?php echo $value['color'] ?>"  name="newRowLocationForFilterComitteeColor<?php echo $counfOfFiltersForComitteeName;?>">
						&nbsp;
						<input id="newRowLocationForFilterComitteeName<?php echo $counfOfFiltersForComitteeName;?>" type="text" value="<?php echo $key?>" name="newRowLocationForFilterComitteeName<?php echo $counfOfFiltersForComitteeName;?>">
						&nbsp;
						<select name="newRowLocationForFilterComitteeSelect<?php echo $counfOfFiltersForComitteeName;?>" >
							<option <?php if($value['type']=="default"){echo "selected";}?> value="default" >Default(=)</option>
							<option <?php if($value['type']=="includes"){echo "selected";}?> value="includes" >Includes</option>
						</select>
						<a class="mainLinkClass"   onclick="deleteRowFunction(<?php echo $counfOfFiltersForComitteeName;?>, true)">Remove Filter</a>
						</li>
					<?php endforeach; ?>
						<div style="display: none;" id="newRowLocationForFilterComitteeNew"></div>
					</span>
					<li>
						<a class="mainLinkClass"   onclick="addRowFunction()">Add New Filter</a>
					</li>
				</ul>
		</div>
	</div>
</form>