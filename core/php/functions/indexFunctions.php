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
	$groupBlock .= "	<div data-group=\"".$group."\" class=\"groupTab ".$selected." \" id=\"Group".$group."\" onclick=\"showOrHideGroups('".$group."');\" >";
	$groupBlock .= 			$group;
	$groupBlock .= "	</div>";
	$groupBlock .= "</div>";
	return $groupBlock;
}

function generateWindow($data = array(), $pollType)
{

	$groupInfo = "{{groupInfo}}";
	$groupInfoStyle = "{{groupInfoStyle}}";
	$backgroundColor = "{{backgroundColor}}";
	$keyNoSpace = "{{keyNoSpace}}";
	$website = "{{website}}";
	$counter = "{{counter}}";
	$name = "{{name}}";
	$branchView = "{{branchView}}";
	$upArrow = "{{upArrow}}";
	$downArrow = "{{downArrow}}";

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

	if($branchView === "devBoxContentSecondary")
	{
		$upArrow = "display: none;";
		$downArrow = "";
	}
	elseif($branchView === "devBoxContentSecondaryExpanded")
	{
		$upArrow = "";
		$downArrow = "display: none;";
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
	$blockHTML .= "			<div  class=\"devBoxTitle\" >";
	$blockHTML .= "				<span id=\"".$keyNoSpace."warningSpanHeader\" class=\"warningSpanHeader\"  >";
	$blockHTML .= "					<div class=\"led-red\" id=\"".$keyNoSpace."redwWarning\" style=\"display: inline-block; margin-bottom: -8px; display: ".$redLED." \"></div>";
	$blockHTML .= "					<div class=\"led-yellow\" id=\"".$keyNoSpace."yellowWarning\" style=\"display: inline-block; margin-bottom: -8px; display: ".$yellowLED." \"></div>";
	$blockHTML .= "					<div class=\"led-green\" id=\"".$keyNoSpace."greenNotice\" style=\"display: inline-block; margin-bottom: -8px; display: ".$greenLED." \"></div>";
	$blockHTML .= "				</span>";
	$blockHTML .= "				<img id=\"".$keyNoSpace."loadingSpinnerHeader\" class=\"loadingSpinnerHeader\" style=\"width: 20px; margin-bottom: -7px; display: none; margin-top: 3px; margin-left: 3px; margin-right: 1px;\" src=\"core/img/loading.gif\" >";
	$blockHTML .= "				<a style=\"color: black;\" target=\"_blank\" href=\"https://".$website."\"><b>".$name."</b></a>";
	$blockHTML .= "			</div>";
	$blockHTML .= "			<div style=\"background-color: white; padding-left: 5px;  padding-right: 5px;\" >";
	$blockHTML .= "			<img onclick=\"togglePinStatus('".$keyNoSpace."');\" id=\"".$keyNoSpace."Pin\" style=\"cursor: pointer; height: 18px;\" src=\"core/img/pin.png\">";
	$blockHTML .= "			<img onclick=\"togglePinStatus('".$keyNoSpace."');\" id=\"".$keyNoSpace."PinPinned\" style=\"cursor: pointer; height: 18px; display: none;\" src=\"core/img/pinPinned.png\">";
	$blockHTML .= "			<img onclick=\"toggleDetailBar(event, '".$keyNoSpace."');\" style=\"cursor: pointer; height: 18px;\" src=\"core/img/externalLink.png\">";
	$blockHTML .= "			<img class=\"downArrow\" onclick=\"singleSwitchToExpandView('".$keyNoSpace."');\" id=\"".$keyNoSpace."DownArrow\" style=\"cursor: pointer; height: 18px; ".$downArrow." \" src=\"core/img/downarrow.png\">";
	$blockHTML .= "			<img class=\"upArrow\" onclick=\"singleSwitchToStandardView('".$keyNoSpace."');\" id=\"".$keyNoSpace."UpArrow\" style=\"cursor: pointer; height: 18px; ".$upArrow."  \" src=\"core/img/uparrow.png\">";
	$blockHTML .= "				<div class=\"expandMenu\" onclick=\"dropdownShow('".$keyNoSpace."')\" ></div>";
	$blockHTML .= "			    	<a  style=\"cursor: pointer; ";
	if($pollType !== "1")
	{
		$blockHTML .= " display: none; ";
	}
	$blockHTML .= "					 \" onclick=\"refreshAction('".$keyNoSpace."','inner');\" ><img style=\"height: 18px;\" src=\"core/img/Refresh2.png\"></a>";
	$blockHTML .= "				<div  id=\"dropdown-".$keyNoSpace."\" class=\"dropdown-content\">";
	$blockHTML .= "			    	<div id=\"".$keyNoSpace."LogHogOuter\" style=\"display: none; cursor: pointer; width: 100%;\" >";
	$blockHTML .= "						<a id=\"".$keyNoSpace."LogHogInner\" style=\"color: black;\" target=\"_blank\" href=\"#\">Log-Hog</a>";
	$blockHTML .= "					</div>";
	$blockHTML .= "					<div id=\"".$keyNoSpace."MonitorOuter\" style=\"display: none; cursor: pointer; width: 100%;\" >";
	$blockHTML .= "						<a id=\"".$keyNoSpace."MonitorInner\" style=\"color: black;\" target=\"_blank\" href=\"#\">Monitor</a>";
	$blockHTML .= "					</div>";
	$blockHTML .= "					<div id=\"".$keyNoSpace."SearchOuter\" style=\"display: none; cursor: pointer; width: 100%;\" >";
	$blockHTML .= "						<a id=\"".$keyNoSpace."SearchInner\" style=\"color: black;\" target=\"_blank\" href=\"#\">Search</a>";
	$blockHTML .= "					</div>";
	$blockHTML .= "					<a id=\"".$keyNoSpace."errorMessageLink\" style=\"cursor: pointer; display: none;\">Error</a> ";
	$blockHTML .= "					<a id=\"".$keyNoSpace."noticeMessageLink\" style=\"cursor: pointer; display: none;\">Notice</a> ";
	$blockHTML .= "				</div>";
	$blockHTML .= " 		</div>";
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