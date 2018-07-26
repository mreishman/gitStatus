<?php header('Access-Control-Allow-Origin: *'); 
$location = $_POST['location'];

//add check to check if location is in watchlist (if v2 of poll request)

$function = "git --git-dir=".escapeshellarg($location).".git log --max-count=100 --max-parents=1";
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