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
if(isset($_POST['sliceSize']))
{
	$sliceSize = $_POST['sliceSize'];
}
elseif(array_key_exists('sliceSize', $config))
{
	$sliceSize = $config['sliceSize'];
}
else
{
	$sliceSize = $defaultConfig['sliceSize'];
} 
if(isset($_POST['pollingRate']))
{
	$pollingRate = $_POST['pollingRate'];
}
elseif(array_key_exists('pollingRate', $config))
{
	$pollingRate = $config['pollingRate'];
}
else
{
	$pollingRate = $defaultConfig['pollingRate'];
} 
if(isset($_POST['pausePoll']))
{
	$pausePoll = $_POST['pausePoll'];
}
elseif(array_key_exists('pausePoll', $config))
{
	$pausePoll = $config['pausePoll'];
}
else
{
	$pausePoll = $defaultConfig['pausePoll'];
}
if(isset($_POST['pauseOnNotFocus']))
{
	$pauseOnNotFocus = $_POST['pauseOnNotFocus'];
}
elseif(array_key_exists('pauseOnNotFocus', $config))
{
	$pauseOnNotFocus = $config['pauseOnNotFocus'];
}
else
{
	$pauseOnNotFocus = $defaultConfig['pauseOnNotFocus'];
}
if(isset($_POST['autoCheckUpdate']))
{
	$autoCheckUpdate = $_POST['autoCheckUpdate'];
}
elseif(array_key_exists('autoCheckUpdate', $config))
{
	$autoCheckUpdate = $config['autoCheckUpdate'];
}
else
{
	$autoCheckUpdate = $defaultConfig['autoCheckUpdate'];
}
if(isset($_POST['developmentTabEnabled']))
{
	$developmentTabEnabled = $_POST['developmentTabEnabled'];
}
elseif(array_key_exists('developmentTabEnabled', $config))
{
	$developmentTabEnabled = $config['developmentTabEnabled'];
}
else
{
	$developmentTabEnabled = $defaultConfig['developmentTabEnabled'];
}
if(isset($_POST['enableDevBranchDownload']))
{
	$enableDevBranchDownload = $_POST['enableDevBranchDownload'];
}
elseif(array_key_exists('enableDevBranchDownload', $config))
{
	$enableDevBranchDownload = $config['enableDevBranchDownload'];
}
else
{
	$enableDevBranchDownload = $defaultConfig['enableDevBranchDownload'];
}
if(isset($_POST['defaultViewBranch']))
{
	$defaultViewBranch = $_POST['defaultViewBranch'];
}
elseif(array_key_exists('defaultViewBranch', $config))
{
	$defaultViewBranch = $config['defaultViewBranch'];
}
else
{
	$defaultViewBranch = $defaultConfig['defaultViewBranch'];
}
if(isset($_POST['defaultViewBranchCookie']))
{
	$defaultViewBranchCookie = $_POST['defaultViewBranchCookie'];
}
elseif(array_key_exists('defaultViewBranchCookie', $config))
{
	$defaultViewBranchCookie = $config['defaultViewBranchCookie'];
}
else
{
	$defaultViewBranchCookie = $defaultConfig['defaultViewBranchCookie'];
}
if(isset($_POST['checkForIssueStartsWithNum']))
{
	$checkForIssueStartsWithNum = $_POST['checkForIssueStartsWithNum'];
}
elseif(array_key_exists('checkForIssueStartsWithNum', $config))
{
	$checkForIssueStartsWithNum = $config['checkForIssueStartsWithNum'];
}
else
{
	$checkForIssueStartsWithNum = $defaultConfig['checkForIssueStartsWithNum'];
}
if(isset($_POST['checkForIssueEndsWithNum']))
{
	$checkForIssueEndsWithNum = $_POST['checkForIssueEndsWithNum'];
}
elseif(array_key_exists('checkForIssueEndsWithNum', $config))
{
	$checkForIssueEndsWithNum = $config['checkForIssueEndsWithNum'];
}
else
{
	$checkForIssueEndsWithNum = $defaultConfig['checkForIssueEndsWithNum'];
}
if(isset($_POST['checkForIssueCustom']))
{
	$checkForIssueCustom = $_POST['checkForIssueCustom'];
}
elseif(array_key_exists('checkForIssueCustom', $config))
{
	$checkForIssueCustom = $config['checkForIssueCustom'];
}
else
{
	$checkForIssueCustom = $defaultConfig['checkForIssueCustom'];
}
if(isset($_POST['checkForIssueInCommit']))
{
	$checkForIssueInCommit = $_POST['checkForIssueInCommit'];
}
elseif(array_key_exists('checkForIssueInCommit', $config))
{
	$checkForIssueInCommit = $config['checkForIssueInCommit'];
}
else
{
	$checkForIssueInCommit = $defaultConfig['checkForIssueInCommit'];
}
if(array_key_exists('errorAndColorArray', $config))
{
	$errorAndColorArray = $config['errorAndColorArray'];
}
else
{
	$errorAndColorArray = $defaultConfig['errorAndColorArray'];
}
if(array_key_exists('errorAndColorAuthorArray', $config))
{
	$errorAndColorAuthorArray = $config['errorAndColorAuthorArray'];
}
else
{
	$errorAndColorAuthorArray = $defaultConfig['errorAndColorAuthorArray'];
}
if(isset($_POST['errorAndColorComitteeArray']))
{
	$errorAndColorComitteeArray = $_POST['errorAndColorComitteeArray'];
}
elseif(array_key_exists('errorAndColorComitteeArray', $config))
{
	$errorAndColorComitteeArray = $config['errorAndColorComitteeArray'];
}
else
{
	$errorAndColorComitteeArray = $defaultConfig['errorAndColorComitteeArray'];
}
if(isset($_POST['branchColorFilter']))
{
	$branchColorFilter = $_POST['branchColorFilter'];
}
elseif(array_key_exists('branchColorFilter', $config))
{
	$branchColorFilter = $config['branchColorFilter'];
}
else
{
	$branchColorFilter = $defaultConfig['branchColorFilter'];
}


$arrayWatchList = "";

if(isset($_POST['numberOfRows']))
{
	
	for($i = 1; $i <= $_POST['numberOfRows']; $i++ )
	{
		$arrayWatchList .= "'".$_POST['watchListKey'.$i]."' => array("; // '".$_POST['watchListItem'.$i]."'";
		for($j = 0; $j < $_POST['watchListItem'.$i."-0"]; $j++)
		{
			$jP = $j+1;
			$arrayWatchList .= "'".$_POST['watchListItem'.$i."-".$jP."-Name"]."' =>  '".$_POST['watchListItem'.$i."-".$jP]."'";
			if($j != ($_POST['watchListItem'.$i."-0"]-1))
			{
				$arrayWatchList .= ",";
			}
		}
		$arrayWatchList .= ")";
		if($i != $_POST['numberOfRows'])
		{
			$arrayWatchList .= ",";
		}
	}

}
else
{
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
}

$arrayFilterAll = "";

if(isset($_POST['branchColorFilter']))
{
	$arrayOfArrays = ['errorAndColorArray' => 'newRowLocationForFilterBranch', 'errorAndColorAuthorArray' => 'newRowLocationForFilterAuthor', 'errorAndColorComitteeArray' => 'newRowLocationForFilterComittee'];
	foreach ($arrayOfArrays as $key => $value) 
	{
		$arrayFilterAll .= "'".$key."' => array(";
		$countOfBranchColorFilterCount = 1; 
		//Name , Color, Select
		while (isset($_POST[$value.'Name'.$countOfBranchColorFilterCount])) 
		{
			$arrayFilterAll .= "'".$_POST[$value.'Name'.$countOfBranchColorFilterCount]."' => array(";
			//logic for save
			$arrayFilterAll .= "'color' => '".$_POST[$value.'Color'.$countOfBranchColorFilterCount]."',";
			$arrayFilterAll .= "'type' => '".$_POST[$value.'Select'.$countOfBranchColorFilterCount]."'";
			$arrayFilterAll .= "),";
			$countOfBranchColorFilterCount++;
		}
		$arrayFilterAll .= "),";
	}
}
else
{
	$arrayOfArrays = ['errorAndColorArray' => $errorAndColorArray, 'errorAndColorAuthorArray' => $errorAndColorAuthorArray, 'errorAndColorComitteeArray' => $errorAndColorComitteeArray];
	foreach ($arrayOfArrays as $key => $value) 
	{
		$arrayFilterAll .= "'".$key."' => array(";
		$numberOfRows = count($value);
		foreach ($value as $key2 => $value2)
		{
			$arrayFilterAll .= "'".$key2."' => array(";
			$numberOfRows2 = count($value2);
			foreach ($value2 as $key3 => $value3) 
			{
				$arrayFilterAll .= "'".$key3."' =>  '".$value3."',";
			}
			$arrayFilterAll .= "),";
		} 
		$arrayFilterAll .= "),";
	}	

}

?>