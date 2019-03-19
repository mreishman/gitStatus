<form id="settingsMainWatch" action="core/php/saveFunctions/settingsSaveMain.php" method="post">
	<div id="widthForWatchListSection" class="innerFirstDevBox" style="width: 500px;" >
		<div class="devBoxTitle">
			<b>Watch List</b>
			<?php if($setupProcess == "finished" || $setupProcess == "preStart"): ?>
				<a class="buttonButton" onclick="saveWatchList(false);" >Save Changes</a>
			<?php else: ?>
				<a class="buttonButton" onclick="saveWatchList(true);" >Save Changes</a>
			<?php endif; ?>
		</div>
		<div class="devBoxContent">
			<ul class="settingsUl">
			<?php
			if($pollType === "1"): ?>
				<li><h2>Example:</h2></li>
				<li class="watchFolderGroups">
				<span>Poll Version 1</span>
				<br>
				<span class="leftSpacingserverNames" > Name:</span> <input disabled="true" class='inputWidth300' type='text' value='Name you want to call website'>
				<br>
				<span class="leftSpacingserverNames" > Website Base:</span> <input disabled="true" class='inputWidth300' type='text' value='Base URL of website'>
				<br>
				<span class="leftSpacingserverNames" > Folder:</span> <input disabled="true" class='inputWidth300' type='text' value='Location of github repo on server'>
				<br>
				<span class="leftSpacingserverNames" > Website:</span> <input disabled="true" class='inputWidth300' type='text' value='Specific directory of website'>
				<br>
				<span class="leftSpacingserverNames" > Git Repo:</span> <input disabled="true" class='inputWidth300' type='text' value='Name of your github repo: username/repo'>
				<br>
				<span class="leftSpacingserverNames" > Branch List:</span> <input disabled="true" class='inputWidth300' type='text' value='Compare branches list example: master , develop'>
 				<br>
 				<span class="leftSpacingserverNames" > Git Type:</span>
				<select disabled="true" class='inputWidth300' >
 					<option value="local" >github</option>
 					<option value="external" >gitlab</option>
 				</select>
 				<br>
 				<span class="leftSpacingserverNames" > Custom Git:</span> <input disabled="true" class='inputWidth300' type='text' value='Custom url for git. Empty = default'>
 				<br>
				<span class="leftSpacingserverNames" > Group Info:</span> <input disabled="true" class='inputWidth300' type='text' value='Name of group'>
				<br>
				<span class="leftSpacingserverNames" > URL Hit:</span> <input disabled="true" class='inputWidth300' type='text' value='Location of file hit, blank = default'>
				</li>
				<?php

				$approvedArrayKeys = array(
					"Name"				=> "Name",
					"WebsiteBase"		=> "Website Base",
					"Folder"			=> "Folder",
					"Website"			=> "Website",
					"githubRepo"		=> "Git Repo",
					"branchList"		=> "Branch List",
					"gitType"			=> "Git Type",
					"customGit"			=> "Custom Git",
					"groupInfo"			=> "Group Info",
					"urlHit"			=> "URL Hit",
					"Archive"			=> "Archive"
				);

				$defaultArray = array(
					'WebsiteBase' 		=>  '',
					'Folder' 			=>  '',
					'Website' 			=>  '',
					'githubRepo' 		=>  '',
					'branchList'		=>  'master',
					'gitType'			=>	'github',
					'customGit'			=>  '',
					'groupInfo' 		=>  '',
					'urlHit' 			=>  '',
					'Archive' 			=>  'false'
				);

			elseif($pollType === "2"): ?>
				<li class="watchFolderGroups">
				<span>Poll Version 2</span>
				<br>
				<span class="leftSpacingserverNames" > Name:</span> <input disabled="true" class='inputWidth300' type='text' value='Name you want to call website'>
				<br>
				<span class="leftSpacingserverNames" > Website Base:</span> <input disabled="true" class='inputWidth300' type='text' value='Base URL of website'>
				<br>
				<span class="leftSpacingserverNames" > URL Hit:</span> <input disabled="true" class='inputWidth300' type='text' value='Location of file hit, blank = default'>
				<br>
				</li>
				<?php

				$approvedArrayKeys = array(
					"Name"			=> "Name",
					"WebsiteBase"	=> "Website Base",
					"urlHit"		=> "URl Hit",
					"Archive"		=> "Archive"
				);

				$defaultArray = array(
					'WebsiteBase' 	=>  '',
					'Folder' 		=>  '',
					'urlHit' 		=>  '',
					"type" 			=> "",
					"Archive" 		=> 'false'
				);

			endif; ?>
			<script type="text/javascript">
				var arrayOfKeysNonEnc = <?php echo json_encode(array_keys($defaultArray)); ?>
			</script>
				<li><h2>Your Watch List: </h2></li>
				<?php
				$i = 0;
				$numCount = 0;
				foreach($config['watchList'] as $key => $item): $i++;
					$type = "internal";
					if(isset($item["type"]) && $pollType === "2")
					{
						$type = $item["type"];
					}
					?>
					<script type="text/javascript">
						var dataForWatchFolder<?php echo $i?> = JSON.parse('<?php echo json_encode($item); ?>');
					</script>
					<li class="watchFolderGroups" id="rowNumber<?php echo $i; ?>" >
						<span class="leftSpacingserverNames" > Name: </span>
		 				<input <?php if ($type === "external"){ echo "disabled= \"true\";";}?> class='inputWidth300' type='text' name='watchListKey<?php echo $i; ?>' value='<?php echo $key; ?>'>
		 				<?php
		 				$j = 0;
		 				foreach($defaultArray as $key2 => $item2):
		 					if(isset($approvedArrayKeys[$key2])):
			 					$j++;
			 					?>
				 				<br>
				 				<span class="leftSpacingserverNames" > <?php echo $approvedArrayKeys[$key2]; ?>: </span>
				 				<input style="display: none;" type="text" name='watchListItem<?php echo $i; ?>-<?php echo $j; ?>-Name' value="<?php echo $key2;?>" >
				 				<?php
				 				if($key2 === "gitType"):
				 					$gitType = $item2;
				 					if(isset($item[$key2]))
				 					{
				 						$gitType = $item[$key2];
				 					}
				 					?>
					 				<select class='inputWidth300' name='watchListItem<?php echo $i; ?>-<?php echo $j; ?>' >
					 					<option value="github" <?php if($gitType === "github"){echo "selected"; }?> >GitHub</option>
					 					<option value="gitlab" <?php if($gitType === "gitlab"){echo "selected"; }?> >GitLab</option>
					 				</select>
					 			<?php elseif($key2 === "Archive"): ?>
					 				<?php
					 				$value = "false";
					 				if(isset($item[$key2]))
					 				{
					 					$value = (string)$item[$key2];
					 				}
					 				?>
					 				<select class='inputWidth300' name='watchListItem<?php echo $i; ?>-<?php echo $j; ?>' >
					 					<option value="true" <?php if($value === "true"){echo "selected"; }?> >True</option>
					 					<option value="false" <?php if($value === "false"){echo "selected"; }?> >False</option>
					 				</select>
				 				<?php else: ?>
				 				<input class='inputWidth300'  type='text' name='watchListItem<?php echo $i; ?>-<?php echo $j; ?>' value='<?php if(isset($item[$key2])){ echo $item[$key2]; }?>'>
				 				<?php endif;
			 				endif;
		 				endforeach;
		 				if($numCount < $j)
		 				{
		 					$numCount = $j;
		 				}
		 				?>
		 				<input style="display: none" type="text" name="watchListItem<?php echo $i;?>-0" value='<?php echo $j;?>'>
		 				<table width="100%">
	 					<tr>
	 						<th width="50%" style=" text-align: center;">
	 							<a style="display: block;" class="mainLinkClass"  onclick="deleteRowFunction(<?php echo $i; ?>, true);">Remove</a>
	 						</th>
	 						<th width="50%" style=" text-align: center;">
	 							<a style="display: block;" class="mainLinkClass" onclick="testConnection(dataForWatchFolder<?php echo $i; ?>);" >Check Connection</a>
	 						</th>
	 					</tr>
	 				</table>
	 				<table width="100%">
	 					<tr>
	 						<th width="50%" style=" text-align: center;">
	 							<a style="display: block;" class="mainLinkClass" > Move Up One </a>
	 						</th>
	 						<th width="50%" style=" text-align: center;">
	 							<a style="display: block;" class="mainLinkClass" > Move Down One </a>
	 						</th>
	 					</tr>
	 				</table>
					</li>
				<?php endforeach; ?>
				<div style="display: inline-block;" id="newRowLocationForWatchList"></div>
			</ul>
			<ul class="settingsUl">
				<li>
					<a class="mainLinkClass"   onclick="addRowFunction()">Add New Server</a>
				</li>
			</ul>
		</div>
		<div id="hidden" style="display: none">
			<input id="numberOfRows" type="text" name="numberOfRows" value="<?php echo $i;?>">
			<input id="watchListNormal" type="text" name="watchListNormal" value="true" >
		</div>
	</div>
</form>