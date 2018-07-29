<?php header('Access-Control-Allow-Origin: *');
$location = $_POST['location'];
$currentBranch = $_POST['branchName'];

$returnData = array();
$function = "git --git-dir=".escapeshellarg($location).".git fetch";
shell_exec($function);
$function = "git --git-dir=".escapeshellarg($location).".git rev-list --left-right --count origin/".escapeshellarg($currentBranch)."...".escapeshellarg($currentBranch);
$returnData["compareCurrent"] = trim(shell_exec($function));
$function = "git --git-dir=".escapeshellarg($location).".git rev-list --left-right --count origin/master...".escapeshellarg($currentBranch);
$returnData["compareMaster"] = trim(shell_exec($function));
echo json_encode($returnData);