<?php
function generateGroup($data = array())
{
	$group = "{{group}}";
	$selected = "";
	if(isset($data["group"]))
	{
		$group = $data["group"];
	}
	if(isset($data["defaultGroupViewOnLoad"]))
	{
		if($group === $data["defaultGroupViewOnLoad"])
		{
			$selected = "groupTabSelected";
		}
	}
	$groupBlock =  "<div class=\"groupTabShadow\">";
	$groupBlock .= "	<div class=\"groupTab ".$selected." \" id=\"Group".$group."\" onclick=\"showOrHideGroups('".$group."');\" >";
	$groupBlock .= 			$group;
	$groupBlock .= "	</div>";
	$groupBlock .= "</div>";
	return $groupBlock;
}

function generateWindow($data = array())
{

	$groupInfo = "{{groupInfo}}";
	$groupInfoStyle = "{{groupInfoStyle}}";
	$backgroundColor = "{{backgroundColor}}";
	$keyNoSpace = "{{keyNoSpace}}";
	$website = "{{website}}";
	$counter = "{{counter}}";
	$name = "{{name}}";
	$branchView = "{{branchView}}";

	$greenLED = "inline-block";
	$yellowLED = "none";
	$redLED = "none";
	$noticeMessageShow = "none";
	$messageText = "";
	$showRefresh = "inline-block";

	if(isset($data['groupInfo']))
	{
		$groupInfo = $data["groupInfo"];
	}

	if(isset($data['groupInfoStyle']))
	{
		$groupInfoStyle = $data["groupInfoStyle"];
	}

	if(isset($data['backgroundColor']))
	{
		$backgroundColor = $data["backgroundColor"];
	}

	if(isset($data['keyNoSpace']))
	{
		$keyNoSpace = "branchNameDevBox1".$data["keyNoSpace"];
	}

	if(isset($data['website']))
	{
		$website = $data["website"];
	}

	if(isset($data['counter']))
	{
		$counter = $data["counter"];
	}

	if(isset($data['name']))
	{
		$name = $data["name"];
	}

	if(isset($data['branchView']))
	{
		$branchView = $data["branchView"];
	}

	if(isset($data['greenLED']))
	{
		$greenLED = $data["greenLED"];
	}

	if(isset($data['yellowLED']))
	{
		$yellowLED = $data["yellowLED"];
	}

	if(isset($data['redLED']))
	{
		$redLED = $data["redLED"];
	}

	if(isset($data['noticeMessageShow']))
	{
		$noticeMessageShow = $data["noticeMessageShow"];
	}

	if(isset($data['messageText']))
	{
		$messageText = $data["messageText"];
	}

	if(isset($data['showRefresh']))
	{
		$showRefresh = $data["showRefresh"];
	}

	$status = "<span style=\"display: none;\" id=\"".$keyNoSpace."Stats\"></span>";
	$branchData = "<span id=\"".$keyNoSpace."\"><img style=\"width: 20px;\" src=\"core/img/loading.gif\"> Loading...</span>";

	if(isset($data['status']))
	{
		$status = $data["status"];
	}

	if(isset($data['branchData']))
	{
		$branchData = $data["branchData"];
	}

	$blockHTML =  "	<div class=\"firstBoxDev ".$groupInfo." \"  ".$groupInfoStyle." >";
	$blockHTML .= "		<div class=\"innerFirstDevBox\" id=\"innerFirstDevBox".$keyNoSpace."\"  ".$backgroundColor." >";
	$blockHTML .= "			<div onclick=\"toggleDetailBar(event, '".$keyNoSpace."');\" class=\"devBoxTitle\" style=\"cursor: pointer;\" >";
	$blockHTML .= "				<div class=\"led-red\" id=\"".$keyNoSpace."redwWarning\" style=\"display: inline-block; margin-bottom: -8px; display: ".$redLED." \">";
	$blockHTML .= "				</div>";
	$blockHTML .= "				<div class=\"led-yellow\" id=\"".$keyNoSpace."yellowWarning\" style=\"display: inline-block; margin-bottom: -8px; display: ".$yellowLED." \">";
	$blockHTML .= "				</div>";
	$blockHTML .= "				<div class=\"led-green\" id=\"".$keyNoSpace."greenNotice\" style=\"display: inline-block; margin-bottom: -8px; display: ".$greenLED." \">";
	$blockHTML .= "				</div>";
	$blockHTML .= "				<a style=\"color: black;\" href=\"https://".$website."\"><b>".$name."</b></a>";
	$blockHTML .= "				<img id=\"".$keyNoSpace."loadingSpinnerHeader\" class=\"loadingSpinnerHeader\" style=\"width: 25px; margin-bottom: -5px; display: none;\" src=\"core/img/loading.gif\" >";
	$blockHTML .= "				<div class=\"expandMenu\" onclick=\"dropdownShow('".$keyNoSpace."')\" ></div>";
	$blockHTML .= "				<div id=\"dropdown-".$keyNoSpace."\" class=\"dropdown-content\">";
	$blockHTML .= "			    	<a style=\"cursor: pointer\" onclick=\"refreshAction('".$keyNoSpace."','inner');\" >Refresh</a>";
	$blockHTML .= "					<span style=\"display: none;\" >";
	$blockHTML .= "			    	<div id=\"".$keyNoSpace."LogHogOuter\" style=\"display: none; cursor: pointer; width: 100%;\" >";
	$blockHTML .= "						<a id=\"".$keyNoSpace."LogHogInner\" style=\"color: black;\" href=\"#\">Log-Hog</a>";
	$blockHTML .= "					</div>";
	$blockHTML .= "					<div id=\"".$keyNoSpace."MonitorOuter\" style=\"display: none; cursor: pointer; width: 100%;\" >";
	$blockHTML .= "						<a id=\"".$keyNoSpace."MonitorInner\" style=\"color: black;\" href=\"#\">Monitor</a>";
	$blockHTML .= "					</div>";
	$blockHTML .= "					<div id=\"".$keyNoSpace."SearchOuter\" style=\"display: none; cursor: pointer; width: 100%;\" >";
	$blockHTML .= "						<a id=\"".$keyNoSpace."SearchInner\" style=\"color: black;\" href=\"#\">Search</a>";
	$blockHTML .= "					</div>";
	$blockHTML .= "					</span>";
	$blockHTML .= "					<a id=\"".$keyNoSpace."errorMessageLink\" style=\"cursor: pointer; display: none;\">Error</a> ";
	$blockHTML .= "					<a id=\"".$keyNoSpace."noticeMessageLink\" style=\"cursor: pointer; display: none;\">Notice</a> ";
	$blockHTML .= "				</div>";
	$blockHTML .= "			</div>";
	$blockHTML .= "			<div class=\"devBoxContent\">";
	$blockHTML .= "				<span style=\"display: ".$noticeMessageShow.";\" class=\"noticeMessage\" id=\"".$keyNoSpace."NoticeMessage\" >".$messageText."</span> ";
	$blockHTML .= "				<b>";
	$blockHTML .= 					$branchData;
	$blockHTML .= "				</b>";
	$blockHTML .= "				<div class=\"".$branchView."\">";
	$blockHTML .= "					<span style=\"display: none;\" id=\"".$keyNoSpace."UpdateOuter\">";
	$blockHTML .= "						<br><br>";
	$blockHTML .= "						<b>Last Updated:</b>";
	$blockHTML .= "						<span id=\"".$keyNoSpace."Update\"> --Pending-- </span>";
	$blockHTML .= " 					<br>";
	$blockHTML .= " 				</span>";
	$blockHTML .= "					<br>";
	$blockHTML .= 					$status;
	$blockHTML .= "				</div>";
	$blockHTML .= "			</div>";
	$blockHTML .= "		</div>";
	$blockHTML .= "	</div>";
	$blockHTML .= "	<span style=\"display: none;\" id=\"".$keyNoSpace."BranchHistory\" ></span>";
	return $blockHTML;
}

function clean_url($url) {
    $parts = parse_url($url);
    return $parts['path'];
}