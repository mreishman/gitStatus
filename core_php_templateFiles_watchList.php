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
			<?php if((int)$pollType === 1): ?>
				<li><h2>Example:</h2></li>
				<li class="watchFolderGroups">
				<span>Poll Version 1</span>
				<br>
				<span class="leftSpacingserverNames" > Name:</span> <input disabled="true" class='inputWidth300' type='text' value='Name you want to call website'> 
				<br>
				<span class="leftSpacingserverNames" > WebsiteBase:</span> <input disabled="true" class='inputWidth300' type='text' value='Base URL of website'> 
				<br>
				<span class="leftSpacingserverNames" > Folder:</span> <input disabled="true" class='inputWidth300' type='text' value='Location of github repo on server'> 
				<br>
				<span class="leftSpacingserverNames" > Website:</span> <input disabled="true" class='inputWidth300' type='text' value='Specific directory of website'> 
				<br>
				<span class="leftSpacingserverNames" > githubRepo:</span> <input disabled="true" class='inputWidth300' type='text' value='Name of your github repo: username/repo'> 
				<br>
				<span class="leftSpacingserverNames" > groupInfo:</span> <input disabled="true" class='inputWidth300' type='text' value='Name of group'> 
				<br>
				<span class="leftSpacingserverNames" > urlHit:</span> <input disabled="true" class='inputWidth300' type='text' value='Location of file hit, blank = default'> 
				<br>
 				<span class="leftSpacingserverNames" > gitType:</span>
				<select disabled="true" class='inputWidth300' >
 					<option value="local" >github</option>
 					<option value="external" >gitlab</option>
 				</select>
				</li>
				<?php

				$approvedArrayKeys = array("Name","WebsiteBase","Folder","Website","githubRepo","groupInfo","urlHit","gitType");

				$defaultArray = array(
					'WebsiteBase' =>  '',
					'Folder' =>  '',
					'Website' =>  '',
					'githubRepo' =>  '',
					'groupInfo' =>  '',
					'urlHit' =>  '',
					'gitType'	=>	'github'
				);

				?>
			<?php elseif((int)$pollType === 2): ?>
				<li class="watchFolderGroups">
				<span>Poll Version 2</span>
				<br>
				<span class="leftSpacingserverNames" > Name:</span> <input disabled="true" class='inputWidth300' type='text' value='Name you want to call website'> 
				<br>
				<span class="leftSpacingserverNames" > WebsiteBase:</span> <input disabled="true" class='inputWidth300' type='text' value='Base URL of website'> 
				<br>
				<span class="leftSpacingserverNames" > urlHit:</span> <input disabled="true" class='inputWidth300' type='text' value='Location of file hit, blank = default'> 
				<br>
				</li>
				<?php

				$approvedArrayKeys = array("Name","WebsiteBase","urlHit");

				$defaultArray = array(
					'WebsiteBase' =>  '',
					'Folder' =>  '',
					'urlHit' =>  '',
					"type" => ""
				);

				?>
			<?php endif; ?>
				<li><h2>Your Watch List: </h2></li>
				<?php 
				$i = 0;
				$numCount = 0;
				$arrayOfKeys = array();
				foreach($config['watchList'] as $key => $item): $i++;
					$type = "internal";
					if(isset($item["type"]) && $pollType === 2)
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
		 					if(in_array($key2, $approvedArrayKeys)):
			 					$j++;
			 					?>
				 				<br> <span class="leftSpacingserverNames" > <?php echo $key2; ?>: </span>
				 				<input style="display: none;" type="text" name='watchListItem<?php echo $i; ?>-<?php echo $j; ?>-Name' value="<?php echo $key2;?>" >
				 				<?php
					 				if(!in_array($key2, $arrayOfKeys))
					 				{
					 					array_push($arrayOfKeys, $key2);
					 				}	
				 				?>
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
		 				<br> <input style="display: none" type="text" name="watchListItem<?php echo $i;?>-0" value='<?php echo $j;?>'> 
		 				<span class="leftSpacingserverNames" ></span>
		 				<?php if($type !== "external"): ?>
							<a class="mainLinkClass"  onclick="deleteRowFunction(<?php echo $i; ?>, true);">Remove</a>
							<span> | </span>
						<?php endif; ?>
						<a class="mainLinkClass" onclick="testConnection(dataForWatchFolder<?php echo $i; ?>);" >Check Connection</a>
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