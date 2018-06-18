<?php header('Access-Control-Allow-Origin: *'); 
$location = $_POST['location'];
//$location = "/var/www/html/status/";

$commit = trim($_POST['commit']);
//$commit = "f1ce4fa9320af75f7936a61066415f62018c49bf";
//add check to check if location is in watchlist (if v2 of poll request)

$function = "git --git-dir=".escapeshellarg($location).".git show ".escapeshellarg($commit);
$arrayOfData = explode("\n", trim(shell_exec($function)));
$newArrayOfData = array();
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