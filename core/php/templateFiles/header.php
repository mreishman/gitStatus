<?php
	$URI = $_SERVER['REQUEST_URI'];
	$listOfPages = array("settings.php","about.php","settings-watchList.php","update.php","settings-auth.php","settings-watchListServer.php");
	$onHome = true;
	foreach ($listOfPages as $page)
	{
		if(strpos($URI, $page) !== false)
		{
			$onHome = false;
			break;
		}
	}
?>
<div id="menu">
	<div class="menuSections" >
		<div
		id="closeMenuHamburger"
		style="
		<?php if($open){echo"display: none;";}else{echo "display: inline-block;";} ?>
		"
		onclick="toggleMenuSideBar()" class="nav-toggle pull-right link">
			<a class="show-sidebar" id="show">
		    	<span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		    </a>
		</div>
		<div
		id="openMenuHamburger"
		style="
		<?php if(!$open){echo"display: none;";}else{echo "display: inline-block;";} ?>
		"
		onclick="toggleMenuSideBar()" class="nav-toggle pull-right link">
			<a style="margin-top: 15px;" class="show-sidebar" id="show">
		    	<span class="icon-bar-top"></span>
		        <span class="icon-bar-mid"></span>
		        <span class="icon-bar-bot"></span>
		    </a>
		</div>
		<div style="display: inline-block;" >
			<a href="#" class="back-to-top" style="color:#000000;">Back to Top</a>
		</div>
		<?php if($onHome): ?>
			<div onclick="pausePollAction();"   id="pauseImage"  style=" <?php if ($pausePoll === "false"): ?> display: inline-block; <?php else: ?> display: none; <?php endif; ?> cursor: pointer; height: 30px; width: 30px; ">
				<img class="menuImage" src="core/img/Pause.png" height="30px">
			</div>
			<div onclick="pausePollAction();"  id="playImage" style=" <?php if ($pausePoll !== "false"): ?> display: inline-block; <?php else: ?> display: none; <?php endif; ?> cursor: pointer; height: 30px; width: 30px; ">
				<img  class="menuImage" src="core/img/Play.png" height="30px">
			</div>
			<div id="refreshDiv" onclick="refreshAction();" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
				<img id="refreshImage" class="menuImage" src="core/img/Refresh.png" height="30px">
			</div>
			<div style="display: inline-block;" >
				<img id="loadingSpinnerMain" class='menuImage' height="30px" style="display: none;" src="core/img/loading.gif">
			</div>
			<span id="loadingSpinnerText" style="color: white; display: inline-block;" ></span>
		<?php endif;?>
	</div>
	<div class="menuSections" >
		<?php if($onHome): ?>
			<div class="buttonSelectorOuter" >
				<div onclick="switchToStandardView();" id="standardViewButtonMainSection" class="<?php if($defaultViewBranch == 'Standard'){echo 'buttonSlectorInnerBoxesSelected';}else{echo'buttonSlectorInnerBoxes';}?> buttonSlectorInnerBoxesAll" style="border-radius: 5px 0px 0px 5px;" >
					Standard
				</div>
				<div onclick="switchToExpandedView();" id="expandedViewButtonMainSection" class="<?php if($defaultViewBranch == 'Expanded'){echo 'buttonSlectorInnerBoxesSelected';}else{echo'buttonSlectorInnerBoxes';}?> buttonSlectorInnerBoxesAll" style="border-radius: 0px 5px 5px 0px">
					Expanded
				</div>
			</div>
		<?php endif;?>
	</div>
	<div class="menuSections" >
		
	</div>
</div>