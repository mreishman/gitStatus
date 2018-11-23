<?php header('Access-Control-Allow-Origin: *');
$location = $_POST['location'];
$currentBranch = $_POST['branchName'];

$returnData = array();
$function = "git --git-dir=".escapeshellarg($location).".git fetch";
shell_exec($function);
$function = "git --git-dir=".escapeshellarg($location).".git rev-list --left-right --count origin/".escapeshellarg($currentBranch)."...".escapeshellarg($currentBranch);
$returnData["compareCurrent"] = trim(shell_exec($function));
$branchListCompare = $_POST['branchList'];
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
	$function = "git --git-dir=".escapeshellarg($location).".git rev-list --left-right --count origin/".escapeshellarg($branchName)."...".escapeshellarg($currentBranch);
	$returnData["compare".$branchName] = trim(shell_exec($function));
}
echo json_encode($returnData);