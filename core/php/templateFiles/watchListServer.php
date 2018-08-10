<form id="settingsMainWatch" action="core/php/saveFunctions/settingsSaveMain.php" method="post">
	<div id="widthForWatchListSection" class="innerFirstDevBox" style="width: 500px;" >
		<div class="devBoxTitle">
			<b>Server Watch List</b>
			<?php if($setupProcess == "finished" || $setupProcess == "preStart"): ?>
				<a class="buttonButton" onclick="saveWatchList(false);" >Save Changes</a>
			<?php else: ?>
				<a class="buttonButton" onclick="saveWatchList(true);" >Save Changes</a>
			<?php endif; ?>
		</div>
		<div class="devBoxContent">
			<ul class="settingsUl">

				<li><h2>Example:</h2></li>
				<li class="watchFolderGroups">
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
				<span class="leftSpacingserverNames" > type:</span>
				<select disabled="true" class='inputWidth300' >
 					<option value="local" >Local</option>
 					<option value="external" >External</option>
 				</select>
 				<br>
 				<span class="leftSpacingserverNames" > gitType:</span>
				<select disabled="true" class='inputWidth300' >
 					<option value="local" >github</option>
 					<option value="external" >gitlab</option>
 				</select>
				</li>


				<li><h2>Your Watch List: </h2></li>
				<?php

				$defaultArray = array(
					'WebsiteBase' =>  '',
					'Folder' =>  '',
					'Website' =>  '',
					'githubRepo' =>  '',
					'groupInfo' =>  '',
					'urlHit' =>  '',
					"type" => "",
					"gitType"	=>	"",
					"Archive" => 'false'
				);

				$i = 0;
				$numCount = 0;
				$arrayOfKeys = array();
				foreach($config['serverWatchList'] as $key => $item): $i++; ?>
				<script type="text/javascript">
					var dataForWatchFolder<?php echo $i?> = JSON.parse('<?php echo json_encode($item); ?>');
				</script>
				<li class="watchFolderGroups" id="rowNumber<?php echo $i; ?>" >
					<span class="leftSpacingserverNames" > Name: </span>
	 				<input class='inputWidth300' type='text' name='watchListKey<?php echo $i; ?>' value='<?php echo $key; ?>'>
	 				<?php
	 				$j = 0;
	 				$archived = "false";
	 				foreach($defaultArray as $key2 => $item2):
	 					$j++;
	 					if($key2 === "Archive")
	 					{
	 						$archived = $item2;
	 					}
	 					?>
		 				<br> <span class="leftSpacingserverNames" > <?php echo $key2; ?>: </span><input style="display: none;" type="text" name='watchListItem<?php echo $i; ?>-<?php echo $j; ?>-Name' value="<?php echo $key2;?>" >
		 				<?php
			 				if(!in_array($key2, $arrayOfKeys))
			 				{
			 					array_push($arrayOfKeys, $key2);
			 				}
			 			if($key2 === "type"):
			 				?>
			 				<select class='inputWidth300' name='watchListItem<?php echo $i; ?>-<?php echo $j; ?>' >
			 					<option value="local" <?php if($item[$key2] === "local"){echo "selected"; }?> >Local</option>
			 					<option value="external" <?php if($item[$key2] === "external"){echo "selected"; }?> >External</option>
			 				</select>
			 			<?php
		 				elseif($key2 === "gitType"):
		 					?>
		 				<select class='inputWidth300' name='watchListItem<?php echo $i; ?>-<?php echo $j; ?>' >
		 					<option value="github" <?php if($item[$key2] === "github"){echo "selected"; }?> >GitHub</option>
		 					<option value="gitlab" <?php if($item[$key2] === "gitlab"){echo "selected"; }?> >GitLab</option>
		 				</select>
		 				<?php
		 				elseif($key2 === "Archive"): ?>
		 					<input id="archiveInput<?php echo $i; ?>" class='inputWidth300'  type='hidden' name='watchListItem<?php echo $i; ?>-<?php echo $j; ?>' value='<?php if (isset($item[$key2])){ echo $item[$key2]; }else{echo "false";} ?>'>
		 					<?php if ($archived === "true"): ?>
								<a id="archiveButton<?php echo $i; ?>" onclick="toggleArchive(<?php echo $i; ?>);" class="mainLinkClass" >Un-Archive</a>
							<?php else: ?>
								<a id="archiveButton<?php echo $i; ?>" onclick="toggleArchive(<?php echo $i; ?>);" class="mainLinkClass" >Archive</a>
							<?php endif; ?>
		 				<?php
		 				else: ?>
		 					<input class='inputWidth300'  type='text' name='watchListItem<?php echo $i; ?>-<?php echo $j; ?>' value='<?php if (isset($item[$key2])){ echo $item[$key2]; } ?>'>
		 				<?php endif; ?>
	 				<?php endforeach; 
	 				if($numCount < $j)
	 				{
	 					$numCount = $j;
	 				}
	 				?>
	 				<br> <input style="display: none" type="text" name="watchListItem<?php echo $i;?>-0" value='<?php echo $j;?>'> 
	 				<span class="leftSpacingserverNames" ></span>
					<a class="mainLinkClass"  onclick="deleteRowFunction(<?php echo $i; ?>, true);">Remove</a>
					<span> | </span>
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
			<input id="watchListServer" type="text" name="watchListServer" value="true" >
		</div>
	</div>
</form>