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
				<br>
				<span class="leftSpacingserverNames" > Type:</span>
				<select disabled="true" class='inputWidth300' >
 					<option value="local" >Local</option>
 					<option value="external" >External</option>
 				</select>

				</li>


				<li><h2>Your Watch List: </h2></li>
				<?php

				$arrayKeys = array(
					'WebsiteBase'		=> 'Website Base',
					'Folder'			=> 'Folder',
					'Website'			=> 'Website',
					'githubRepo'		=> 'Git Repo',
					'branchList'		=> 'Branch List',
					'gitType'			=> 'Git Type',
					'customGit'			=> 'Custom Git',
					'groupInfo'			=> 'Group Info',
					'urlHit'			=> 'URL Hit',
					'type'				=> 'Type',
					'Archive'			=> 'Archive'
				);

				$defaultArray = array(
					'WebsiteBase'		=>  '',
					'Folder'			=>  '',
					'Website'			=>  '',
					'githubRepo'		=>  '',
					'branchList'		=>  'master',
					'gitType'			=>	'',
					'customGit'			=>  '',
					'groupInfo'			=>  '',
					'urlHit'			=>  '',
					'type'				=>  '',
					'Archive'			=>  'false'
				);

				$groups = array(
					'General'	=>	array(
						'WebsiteBase' 		=>  '',
						'Folder' 			=>  '',
						'Website' 			=>  ''
					),
					'Git'		=>	array(
						'githubRepo' 		=>  '',
						'branchList'		=>  'master',
						'gitType'			=>	'github',
						'customGit'			=>  ''
					),
					'Advanced'	=>	array(
						'groupInfo' 		=>  '',
						'urlHit' 			=>  '',
						'type'				=>  '',
						'Archive' 			=>  'false'
					)
				);
				?>
				<script type="text/javascript">
					var arrayOfKeysNonEnc = <?php echo json_encode(array_keys($defaultArray)); ?>;
					var numberOfSubRows = <?php echo count(array_keys($defaultArray)); ?>;
					var countOfWatchList = <?php echo count(array_keys($config['serverWatchList'])); ?>;
				</script>
				<?php
				$i = 0;
				foreach($config['serverWatchList'] as $key => $item){
					$i++;
					echo generateWatchlistBlock($groups, $arrayKeys, $key, $item, $i);
				} ?>
				<div style="display: inline-block;" id="newRowLocationForWatchList"></div>
			</ul>
		</div>
		<div id="hidden" style="display: none">
			<span id="hiddenWatchlistFormBlank">
				<?php echo generateWatchlistBlock($groups, $arrayKeys); ?>
			</span>
			<input id="numberOfRows" type="text" name="numberOfRows" value="<?php echo $i;?>">
			<input id="watchListServer" type="text" name="watchListServer" value="true" >
		</div>
	</div>
</form>