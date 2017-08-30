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
if(file_exists($baseUrl.'conf/config.php'))
{
	require_once($baseUrl.'conf/config.php');
}
else
{
	$config = array();
}
require_once($varToIndexDir.'core/conf/config.php');


foreach ($defaultConfig as $key => $value)
{
	if(isset($_POST[$key]))
	{
		$$key = $_POST[$key];
	}
	elseif(array_key_exists($key, $config))
	{
		$$key = $config[$key];
	}
	else
	{
		$$key = $value;
	} 
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