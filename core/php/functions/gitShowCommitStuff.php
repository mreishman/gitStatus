<?php header('Access-Control-Allow-Origin: *');

require_once("../../../core/conf/config.php");
require_once("../../../local/default/conf/config.php");
require_once("../../../core/php/loadVars.php");

if($blockGitShowCommitStuff !== "false")
{
	echo json_encode(array());
	die();
}

$location = (string)$_POST['location'];
$commit = (string)trim($_POST['commit']);
$newArrayOfData = array();

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
		echo json_encode($newArrayOfData);
		die();
	}
}
else
{
	//check if block
	if(!($disablePostRequestWithPostData === "false"))
	{
		echo json_encode($newArrayOfData);
		die();
	}
}

if(!ctype_alnum($commit))
{
	//incorrect commit data
	echo json_encode($newArrayOfData);
	die();
}

$function = "git --git-dir=".escapeshellarg($location).".git show ".escapeshellarg($commit);
$arrayOfData = explode("\n", trim(shell_exec($function)));
foreach ($arrayOfData as $row)
{
	if($row !== "")
	{
		if(strpos($row, "\t") > -1)
		{
			$row = implode("    ", explode("\t", $row));
		}
		array_push($newArrayOfData, $row);
	}
}

echo  json_encode($newArrayOfData);