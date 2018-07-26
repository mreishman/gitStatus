<?php header('Access-Control-Allow-Origin: *'); 
$location = $_POST['location'];
$maxCount = 100;
if(isset($_POST['maxCount']))
{
	$maxCount = intval(escapeshellarg($_POST['maxCount']));
}
//add check to check if location is in watchlist (if v2 of poll request)

$function = "git --git-dir=".escapeshellarg($location).".git log --max-count=".$maxCount." --max-parents=1";
$arrayOfData = explode("\n", trim(shell_exec($function)));
$newArrayOfData = array("","");
foreach ($arrayOfData as $row)
{
	if($row !== "")
	{
		array_push($newArrayOfData, $row);
	}
}
echo  json_encode($newArrayOfData);