<?php header('Access-Control-Allow-Origin: *');

require_once("../../../core/conf/config.php");
require_once("../../../local/default/conf/config.php");
require_once("../../../core/php/loadVars.php");

if($blockGitCommitDiff !== "false")
{
	echo json_encode(array());
	die();
}

$location = (string)$_POST['location'];
$branchListCompare = "master";
if(isset($_POST['branchList']))
{
	$branchListCompare = (string)$_POST['branchList'];
}
$pollType = null;
if(isset($_POST['pollType']))
{
	$pollType = 1;
	if(2 === intval($_POST['pollType']))
	{
		$pollType = 2;
	}
}

//if poll type is set, and poll type is 2: you can verify that location is real location (check config). Also if poll type 1 is set to block, block it.

if($pollType === 2)
{
	//verify
	$verified = false;
	foreach ($serverWatchList as $key => $value)
	{
		if($value["Folder"] === $location)
		{
			$verified = true;
			break;
		}
	}
	if(!$verified)
	{
		echo json_encode(array());
		die();
	}
}
else
{
	//check if block
	if(!($disablePostRequestWithPostData === "false"))
	{
		echo json_encode(array());
		die();
	}
}

//get branch name
$function = "git --git-dir=".escapeshellarg($location).".git  branch | grep \* | cut -d ' ' -f2";
$currentBranch = trim(shell_exec($function));

$function = "git --git-dir=".escapeshellarg($location).".git  branch";
$branchList = trim(shell_exec($function));
$branchList = explode("\n", $branchList);
$newBranchList = array();
foreach ($branchList as $branchName)
{
	array_push($newBranchList, strtolower(trim($branchName)));
}
$branchList = $newBranchList;

$returnData = array();
$function = "git --git-dir=".escapeshellarg($location).".git fetch";
shell_exec($function);
$function = "git --git-dir=".escapeshellarg($location).".git rev-list --left-right --count origin/".escapeshellarg($currentBranch)."...".escapeshellarg($currentBranch);
$returnData["current"] = trim(shell_exec($function));
if(strpos($branchListCompare, ",") === -1)
{
	$branchListCompare = array($branchListCompare);
}
else
{
	$branchListCompare = explode(",", $branchListCompare);
}
foreach ($branchListCompare as $branchCompare)
{
	$branchName = trim($branchCompare);
	if(in_array(strtolower($branchName), $branchList))
	{
		$function = "git --git-dir=".escapeshellarg($location).".git rev-list --left-right --count origin/".escapeshellarg($branchName)."...".escapeshellarg($currentBranch);
		$returnData[$branchName] = trim(shell_exec($function));
	}
	else
	{
		$returnData[$branchName] = "Branch Not Found";
	}
}
echo json_encode($returnData);