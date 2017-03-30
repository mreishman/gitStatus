<?php

require_once('verifyWriteStatus.php');
checkForUpdate($_SERVER['REQUEST_URI']);

//check for previous update, if failed

$varToIndexDir = "";
$countOfSlash = 0;
while($countOfSlash < 20 && !file_exists($varToIndexDir."index.php"))
{
  $varToIndexDir .= "../";        
}

$baseUrl = $varToIndexDir."core/";
if(file_exists($varToIndexDir.'local/layout.php'))
{
  $baseUrl = $varToIndexDir."local/";
  //there is custom information, use this
  require_once($varToIndexDir.'local/layout.php');
  $baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php'); 
require_once($varToIndexDir.'core/conf/config.php');


if(array_key_exists('watchList', $config))
{
	$watchList = $config['watchList'];
}
else
{
	$watchList = $defaultConfig['watchList'];
}
if(array_key_exists('sliceSize', $config))
{
	$sliceSize = $config['sliceSize'];
}
else
{
	$sliceSize = $defaultConfig['sliceSize'];
} 
if(array_key_exists('pollingRate', $config))
{
	$pollingRate = $config['pollingRate'];
}
else
{
	$pollingRate = $defaultConfig['pollingRate'];
} 
if(array_key_exists('pausePoll', $config))
{
	$pausePoll = $config['pausePoll'];
}
else
{
	$pausePoll = $defaultConfig['pausePoll'];
}
if(array_key_exists('pauseOnNotFocus', $config))
{
	$pauseOnNotFocus = $config['pauseOnNotFocus'];
}
else
{
	$pauseOnNotFocus = $defaultConfig['pauseOnNotFocus'];
}
if(array_key_exists('autoCheckUpdate', $config))
{
	$autoCheckUpdate = $config['autoCheckUpdate'];
}
else
{
	$autoCheckUpdate = $defaultConfig['autoCheckUpdate'];
}
if(array_key_exists('developmentTabEnabled', $config))
{
	$developmentTabEnabled = $config['developmentTabEnabled'];
}
else
{
	$developmentTabEnabled = $defaultConfig['developmentTabEnabled'];
}
if(array_key_exists('enableDevBranchDownload', $config))
{
	$enableDevBranchDownload = $config['enableDevBranchDownload'];
}
else
{
	$enableDevBranchDownload = $defaultConfig['enableDevBranchDownload'];
}

$arrayWatchList = "";
$numberOfRows = count($watchList);
$i = 0;
foreach ($watchList as $key => $value) 
{
	$i++;
	$j = 0;
	$numberOfRows2 = count($value);
	$arrayWatchList .= "'".$key."' => array(";
	foreach ($value as $key2 => $value2) {
		$j++;
		$arrayWatchList .= "'".$key2."' =>  '".$value2."'";
		if($j != $numberOfRows2)
		{
			$arrayWatchList .= ",";
		}
	}
	$arrayWatchList .= ")";
	if($i != $numberOfRows)
	{
		$arrayWatchList .= ",";
	}
}



?>