<?php header('Access-Control-Allow-Origin: *'); 

require_once("../../../core/conf/config.php");
require_once("../../../local/default/conf/config.php");
require_once("../../../core/php/loadVars.php");

function sendCurl($requestUrl)
{
	try
	{
		$ch = curl_init();
		if (false === $ch)
		{
	        throw new Exception('failed to initialize');
		}
		$headers["User-Agent"] = "Curl/1.0";

		curl_setopt($ch, CURLOPT_URL, $requestUrl);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3); //timeout in seconds
		curl_setopt($ch, CURLOPT_TIMEOUT, 3); //timeout in seconds
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$result = curl_exec($ch);
		if (false === $result)
		{
	    	throw new Exception(curl_error($ch), curl_errno($ch));
	    }

	    curl_close($ch);
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
	}
}

function checkForSearch($baseWeb)
{
	if(is_dir("../../../../search"))
	{
		return $baseWeb."/search";
	}
	
	if(is_dir("../../../../Log-Hog/search"))
	{
		return $baseWeb."/Log-Hog/search";
	}
	
	if(is_dir("../../../../loghog/search"))
	{
		return $baseWeb."/loghog/search";
	}

	return "";
}

function checkForMonitor($baseWeb)
{
	if(is_dir("../../../../monitor"))
	{
		return $baseWeb."/monitor";
	}
	
	if(is_dir("../../../../Log-Hog/top"))
	{
		return $baseWeb."/Log-Hog/top";
	}
	
	if(is_dir("../../../../loghog/top"))
	{
		return $baseWeb."/loghog/top";
	}
	
	if(is_dir("../../../../Log-Hog/monitor"))
	{
		return $baseWeb."/Log-Hog/monitor";
	}
	
	if(is_dir("../../../../loghog/monitor"))
	{
		return $baseWeb."/loghog/monitor";
	}
	return "";
}

function checkForLogHog($baseWeb)
{
	if(is_dir("../../../../Log-Hog"))
	{
		return $baseWeb."/Log-Hog";
	}
	
	if(is_dir("../../../../loghog"))
	{
		return $baseWeb."/loghog";
	}
	return "";
}

function getBranchName($location)
{
	$function = "git --git-dir=".escapeshellarg($location).".git rev-parse --abbrev-ref HEAD";
	return trim(shell_exec($function));
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
			'branch' 	=> getBranchName($postLocation),
			'idName'	=> preg_replace('/\s+/', '_', $postName ),
			'date'		=> date('j m Y'),
			'time'		=> trim(shell_exec('date')),
			'stats'		=> getBranchStats($postLocation),
			'messageTextEnabled'	=> $messageTextEnabled,
			'messageText' => $messageText,
			'enableBlockUntilDate'	=> $enableBlockUntilDate,
			'datePicker'	=> $datePicker,
			'loghog'		=> checkForLogHog($postWebsiteBase),
			'monitor'		=> checkForMonitor($postWebsiteBase),
			'search'		=> checkForSearch($postWebsiteBase),
			'otherFunctions'	=> ''
		);
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
	$blockedList = array();
	foreach ($serverWatchList as $key => $value)
	{
		if($value["type"] == "local")
		{
			$website = "#";
			if($value["Website"])
			{
				$website = $value["Website"];
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
				'website'		=> $website
			);
		}
		else
		{
			
			if($lastResult[$key]["enableBlockUntilDate"] == "true" && strtotime($lastResult[$key]["enableBlockUntilDate"]) >= strtotime(now))
			{
				continue;
			}
			$sendUrlHere = "".$value["WebsiteBase"]."/status/core/php/functions/gitBranchName.php";
			if($value["urlHit"] !== "")
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
		file_put_contents("lastRequestResults.php",$newInfoForConfig);
	}
}
echo json_encode($response);
?>