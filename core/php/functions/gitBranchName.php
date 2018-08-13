<?php header('Access-Control-Allow-Origin: *'); 

require_once("../../../core/conf/config.php");
require_once("../../../local/default/conf/config.php");
require_once("../../../core/php/loadVars.php");

function sendCurlInner($requestUrl)
{
	$curlInit = curl_init();
	if (false === $curlInit)
	{
        throw new Exception('failed to initialize');
	}
	$headers["User-Agent"] = "Curl/1.0";

	curl_setopt($curlInit, CURLOPT_URL, $requestUrl);
	curl_setopt($curlInit, CURLOPT_HEADER, false);
	curl_setopt($curlInit, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curlInit, CURLOPT_CONNECTTIMEOUT, 3); //timeout in seconds
	curl_setopt($curlInit, CURLOPT_TIMEOUT, 3); //timeout in seconds
	curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($curlInit, CURLOPT_SSL_VERIFYPEER, false);

	$result = curl_exec($curlInit);
	if (false === $result)
	{
    	throw new Exception(curl_error($curlInit), curl_errno($curlInit));
    }

    curl_close($curlInit);
	return $result;
}

function sendCurl($requestUrl)
{
	try
	{
		$result = sendCurlInner($requestUrl);
		return $result;
	}
	catch (Exception $e)
	{
		if(false)
		{
			trigger_error(sprintf(
        	'Curl failed with error #%d: %s',
       		$e->getCode(), $e->getMessage()),
        	E_USER_ERROR);
		}
		return null;
	}
}

function checkForSearch($baseWeb)
{
	$returnString = "";
	if(is_dir("../../../../search"))
	{
		$returnString = $baseWeb."/search";
	}
	elseif(is_dir("../../../../Log-Hog/search"))
	{
		$returnString = $baseWeb."/Log-Hog/search";
	}
	elseif(is_dir("../../../../loghog/search"))
	{
		$returnString = $baseWeb."/loghog/search";
	}
	return $returnString;
}

function checkForMonitor($baseWeb)
{
	$returnString = "";
	if(is_dir("../../../../monitor"))
	{
		$returnString = $baseWeb."/monitor";
	}
	elseif(is_dir("../../../../Log-Hog/top"))
	{
		$returnString = $baseWeb."/Log-Hog/top";
	}
	elseif(is_dir("../../../../loghog/top"))
	{
		$returnString = $baseWeb."/loghog/top";
	}
	elseif(is_dir("../../../../Log-Hog/monitor"))
	{
		$returnString = $baseWeb."/Log-Hog/monitor";
	}
	elseif(is_dir("../../../../loghog/monitor"))
	{
		$returnString = $baseWeb."/loghog/monitor";
	}
	return $returnString;
}

function checkForLogHog($baseWeb)
{
	$returnString = "";
	if(is_dir("../../../../Log-Hog"))
	{
		$returnString = $baseWeb."/Log-Hog";
	}
	elseif(is_dir("../../../../loghog"))
	{
		$returnString = $baseWeb."/loghog";
	}
	return $returnString;
}

function getBranchNameHistoryName($location)
{
	$newFileName = preg_replace('/\s+/', '_', $location );
	if(strpos($newFileName, "/") > -1)
	{
		$newFileName = str_replace('/', '', $newFileName );
	}
	elseif(strpos($newFileName, "\\") > -1)
	{
		$newFileName = str_replace('\\', '', $newFileName );
	}
	return $newFileName;
}

function saveBranchNameHistory($branchNameNew, $location)
{
	$newFileName = getBranchNameHistoryName($location);
	$branchHistoryList = array();
	if(is_file("branchNameHistory".$newFileName.".php"))
	{
		include("branchNameHistory".$newFileName.".php");
	}
	if(empty($branchHistoryList) || (isset($branchHistoryList[0]) && $branchHistoryList[0]["name"] !== $branchNameNew))
	{
		//update file
		$newInfoForHistory = "
		<?php
			$"."branchHistoryList = array(
				0	=>	array(
					\"name\"	=>	\"".$branchNameNew."\",
					\"date\"	=>	\"".date("Y-m-d h:i:sa")."\",
				),
			";
			if(!empty($branchHistoryList))
			{
				$counterForBHList = 1;
				foreach ($branchHistoryList as $numberKey => $arrayValue)
				{
					$newInfoForHistory = "
						\"".$counterForBHList."\" =>	array(
							\"name\"	=>	\"".$arrayValue["name"]."\",
							\"date\"	=>	\"".$arrayValue["date"]."\",
						),
					";
					$counterForBHList++;
				}
			}
		$newInfoForHistory .= ");";
		file_put_contents("branchNameHistory".$newFileName.".php", $newInfoForHistory);
	}
}

function getBranchName($location)
{
	$function = "git --git-dir=".escapeshellarg($location).".git rev-parse --abbrev-ref HEAD";
	$branchNameNew = trim(shell_exec($function));
	saveBranchNameHistory($branchNameNew, $location);
	return $branchNameNew;
}

function getBranchStats($location)
{
	$function = "git --git-dir=".escapeshellarg($location).".git log --stat -1 --pretty=\"<b>Author Name:</b> %an, <b>Author Date:</b> %ad, <b>Committer Name:</b> %cn, <b>Committer Date:</b> %cd, <b>Commit:</b> %s}\"";
	$branchStats = trim(shell_exec($function));
	return substr($branchStats, 0, strpos($branchStats, "}"));
}


if((isset($_POST['location']) && isset($_POST['name']) && isset($_POST['websiteBase'])) && $disablePostRequestWithPostData === "false")
{
	//old version!!!! (prior to 2.0)

	$postLocation = $_POST['location'];
	$postName = $_POST['name'];
	$postWebsiteBase = $_POST['websiteBase'];

	if((strlen(escapeshellarg($postLocation)) < 500) && (strlen(escapeshellarg($postName)) < 500) && (strlen(escapeshellarg($postWebsiteBase)) < 500))
	{
		$response = array(
			'branch' 				=> getBranchName($postLocation),
			'idName'				=> preg_replace('/\s+/', '_', $postName ),
			'date'					=> date('j m Y'),
			'time'					=> trim(shell_exec('date')),
			'stats'					=> getBranchStats($postLocation),
			'messageTextEnabled'	=> $messageTextEnabled,
			'messageText' 			=> $messageText,
			'enableBlockUntilDate'	=> $enableBlockUntilDate,
			'datePicker'			=> $datePicker,
			'loghog'				=> checkForLogHog($postWebsiteBase),
			'monitor'				=> checkForMonitor($postWebsiteBase),
			'search'				=> checkForSearch($postWebsiteBase),
			'otherFunctions'		=> '',
			'location'				=>	$postLocation,
			'WebsiteBase'			=>	$postWebsiteBase
		);
		$newFileName = getBranchNameHistoryName($postLocation);
		if(is_file("branchNameHistory".$newFileName.".php"))
		{
			include("branchNameHistory".$newFileName.".php");
			$response["branchHistoryList"] = $branchHistoryList;
		}
	}
	else
	{
		$response = array(
		'branch' 	=> 'Location var is too long.',
		'otherFunctions'	=> ''
	 );
	}
}
else
{
	if(is_file("lastRequestResults.php"))
	{
		include("lastRequestResults.php");
		$lastResult = json_decode($cachedStatusMainObject, true);
	}

	//new version (2.0 or greater) or just checking
	$response = array(
		'isHere' 		=> true,
		'info'			=> array()
	);
	$datePicker = str_replace('/', '-', $datePicker);
	if(($enableBlockUntilDate == "true" && strtotime($datePicker) < strtotime(date("d-m-Y"))) || $enableBlockUntilDate != "true" )
	{
		$blockedList = array();
		foreach ($serverWatchList as $key => $value)
		{
			if(isset($value["Archive"]) && "true" === $value["Archive"])
			{
				continue;
			}
			if($value["type"] == "local")
			{
				$website = "#";
				if(isset($value["Website"]) && $value["Website"] !== "")
				{
					$website = $value["Website"];
				}
				$websiteBase = null;
				if(isset($value["WebsiteBase"]) && $value["WebsiteBase"] !== "")
				{
					$websiteBase = $value["WebsiteBase"];
				}
				if(isset($value["urlHit"]) && $value["urlHit"] !== "")
				{
					$websiteBase = str_replace("gitBranchName.php", "", $value["urlHit"]);
				}
				$response["info"][$key] = array(
					'isHere' => true,
					'branch' 	=> getBranchName($value['Folder']),
					'date'		=> date('j m Y'),
					'time'		=> trim(shell_exec('date')),
					'stats'		=> getBranchStats($value['Folder']),
					'messageTextEnabled'	=> $messageTextEnabled,
					'messageText' => $messageText,
					'enableBlockUntilDate'	=> $enableBlockUntilDate,
					'datePicker'	=> $datePicker,
					'loghog'		=> checkForLogHog($value['WebsiteBase']),
					'monitor'		=> checkForMonitor($value['WebsiteBase']),
					'search'		=> checkForSearch($value['WebsiteBase']),
					'displayName'	=> $key,
					'groupInfo'		=> $value['groupInfo'],
					'gitType'		=> $value['gitType'],
					'githubRepo'	=> $value['githubRepo'],
					'otherFunctions'	=> '',
					'website'		=> $website,
					'location'		=> $value['Folder'],
					'WebsiteBase'	=> $websiteBase
				);
				$newFileName = getBranchNameHistoryName($value['Folder']);
				if(is_file("branchNameHistory".$newFileName.".php"))
				{
					include("branchNameHistory".$newFileName.".php");
					$response["info"][$key]["branchHistoryList"] = $branchHistoryList;
				}
			}
			else
			{
				if(isset($lastResult[$key]) && $lastResult[$key]["enableBlockUntilDate"] == "true" && strtotime($lastResult[$key]["enableBlockUntilDate"]) >= strtotime(now))
				{
					continue;
				}
				$sendUrlHere = "".$value["WebsiteBase"]."/status/core/php/functions/gitBranchName.php";
				if(isset($value["urlHit"]) && $value["urlHit"] !== "")
				{
					$sendUrlHere = $value["urlHit"];
				}
				$url = "https://".$sendUrlHere;
				$result = sendCurl($url);
				if(!$result)
				{
					$url = "http://".$sendUrlHere;
					$result = sendCurl($url);
				}
				if($result)
				{
					$result = rtrim($result, "\0");
					$result =  json_decode($result, true);
					if($result && $result["info"])
					{
						foreach($result["info"] as $key2 => $data2)
						{
							$response["info"][$key2] = $data2;
							$blockedList[$key] = array(
								"enableBlockUntilDate"	=>	$data2["enableBlockUntilDate"],
								"datePicker"			=>	$data2["datePicker"]
							);
						}
					}
				}
			}
			$newInfoForConfig = "
			<?php
				$"."cachedStatusMainObject = '".json_encode($blockedList)."';
			?>";
			try
			{
				@file_put_contents("lastRequestResults.php",$newInfoForConfig);
			}
			catch (Exception $e)
			{
				
			}
			
		}
	}
	else
	{
		$response["info"]["blocked"] = "true";
		$response["info"]["blockedUntil"] = $datePicker;
		$response["info"]["dateStringTime"] = strtotime($datePicker);
		$response["info"]["dateStringNow"]= strtotime(date("d-m-Y"));
	}
}
echo json_encode($response);
?>