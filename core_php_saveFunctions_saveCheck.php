<?php

function forEachAddVars($variable)
{
	$returnText = "array(";
	foreach ($variable as $key => $value)
	{
		$returnText .= " '".$key."' => ";
		if(is_array($value) || is_object($value))
		{
			$returnText .= forEachAddVars($value);
		}
		else
		{
			$returnText .= "'".$value."',";
		}
	}
	$returnText .= "),";
	return $returnText;
}

$varToIndexDir = "";
$countOfSlash = 0;
$boolForLoop = false;
while(!$boolForLoop)
{
	if(file_exists($varToIndexDir."settings-watchList.php") || $countOfSlash > 10)
	{
		$boolForLoop = true;
	}
	else
	{
		$varToIndexDir .= "../";
		$countOfSlash++;
	}
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

$response = true;


$arrayWatchList = "";
if(isset($_POST['numberOfRows']) && isset($_POST["watchListNormal"]))
{
	for($i = 1; $i <= $_POST['numberOfRows']; $i++ )
	{
		$arrayWatchList .= "'".$_POST['watchListKey'.$i]."' => array(";
		for($j = 0; $j < $_POST['watchListItem'.$i."-0"]; $j++)
		{
			$jP = $j+1;
			$arrayWatchList .= "'".$_POST['watchListItem'.$i."-".$jP."-Name"]."' => '".$_POST['watchListItem'.$i."-".$jP]."'";
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
	$watchListSave = $arrayWatchList;
	$arrayWatchList = "";

	$numberOfRows = count($config['watchList']);
	$i = 0;
	foreach ($config['watchList'] as $key => $value) 
	{
		$i++;
		$j = 0;
		$numberOfRows2 = count($value);
		$arrayWatchList .= "'".$key."' => array(";
		foreach ($value as $key2 => $value2) {
			$j++;
			$arrayWatchList .= "'".$key2."' => '".$value2."'";
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
	$watchList = $arrayWatchList;
}

$arrayServerWatchList = "";
if(isset($_POST['numberOfRows']) && isset($_POST["watchListServer"]))
{
	for($i = 1; $i <= $_POST['numberOfRows']; $i++ )
	{
		$arrayServerWatchList .= "'".$_POST['watchListKey'.$i]."' => array(";
		for($j = 0; $j < $_POST['watchListItem'.$i."-0"]; $j++)
		{
			$jP = $j+1;
			$arrayServerWatchList .= "'".$_POST['watchListItem'.$i."-".$jP."-Name"]."' => '".$_POST['watchListItem'.$i."-".$jP]."'";
			if($j != ($_POST['watchListItem'.$i."-0"]-1))
			{
				$arrayServerWatchList .= ",";
			}
		}
		$arrayServerWatchList .= ")";
		if($i != $_POST['numberOfRows'])
		{
			$arrayServerWatchList .= ",";
		}
	}
	$serverWatchListSave = $arrayServerWatchList;
	$arrayServerWatchList = "";

	$numberOfRows = count($config['serverWatchList']);
	$i = 0;
	foreach ($config['serverWatchList'] as $key => $value) 
	{
		$i++;
		$j = 0;
		$numberOfRows2 = count($value);
		$arrayServerWatchList .= "'".$key."' => array(";
		foreach ($value as $key2 => $value2) {
			$j++;
			$arrayServerWatchList .= "'".$key2."' => '".$value2."'";
			if($j != $numberOfRows2)
			{
				$arrayServerWatchList .= ",";
			}
		}
		$arrayServerWatchList .= ")";
		if($i != $numberOfRows)
		{
			$arrayServerWatchList .= ",";
		}
	}
	$serverWatchList = $arrayServerWatchList;
}


if(isset($_POST['branchColorFilter']))
{
	$arrayOfArrays = ['errorAndColorArray' => 'newRowLocationForFilterBranch', 'errorAndColorAuthorArray' => 'newRowLocationForFilterAuthor', 'errorAndColorComitteeArray' => 'newRowLocationForFilterComittee'];
	foreach ($arrayOfArrays as $key => $value) 
	{
		$$key = "'".$key."' => array(";
		$countOfBranchColorFilterCount = 1; 
		//Name , Color, Select
		while (isset($_POST[$value.'Name'.$countOfBranchColorFilterCount])) 
		{
			$$key .= "'".$_POST[$value.'Name'.$countOfBranchColorFilterCount]."' => array(";
			//logic for save
			$$key .= "'color' => '".$_POST[$value.'Color'.$countOfBranchColorFilterCount]."',";
			$$key .= "'type' => '".$_POST[$value.'Select'.$countOfBranchColorFilterCount]."',";
			$$key .= "),";
			$countOfBranchColorFilterCount++;
		}
		$$key .= "),";
	}

	$errorAndColorArrayTmp = $defaultConfig['errorAndColorArray'];
	$errorAndColorAuthorArrayTmp = $defaultConfig['errorAndColorAuthorArray'];
	$errorAndColorComitteeArrayTmp = $defaultConfig['errorAndColorComitteeArray'];

	if (isset($config['errorAndColorArray']))
	{
		$errorAndColorArrayTmp = $config['errorAndColorArray'];
	}

	if (isset($config['errorAndColorAuthorArray']))
	{
		$errorAndColorAuthorArrayTmp = $config['errorAndColorAuthorArray'];
	}

	if (isset($config['errorAndColorComitteeArray']))
	{
		$errorAndColorComitteeArrayTmp = $config['errorAndColorComitteeArray'];
	}

	$arrayOfArrays = ['errorAndColorArray' => $errorAndColorArrayTmp, 'errorAndColorAuthorArray' => $errorAndColorAuthorArrayTmp, 'errorAndColorComitteeArray' => $errorAndColorComitteeArrayTmp];
	foreach ($arrayOfArrays as $key => $value) 
	{
		$keySave = $key."Save";
		$$keySave = "'".$key."' => array(";
		$numberOfRows = count($value);
		foreach ($value as $key2 => $value2)
		{
			$$keySave .= "'".$key2."' => array(";
			$numberOfRows2 = count($value2);
			foreach ($value2 as $key3 => $value3) 
			{
				$$keySave .= "'".$key3."' => '".$value3."',";
			}
			$$keySave .= "),";
		} 
		$$keySave .= "),";
	}	

}

foreach ($defaultConfig as $key => $value)
{
	if(isset($_POST[$key]))
	{
		if(array_key_exists($key, $config))
		{
			if($_POST[$key] != $config[$key])
			{
				$response = false;
				break;
			}
		}
		else
		{
			if($_POST[$key] != $value)
			{
				$response = false;
				break;
			}
		}

	}
	elseif(isset($$key))
	{
		$key2 = $key."Save";
		if($$key != $$key2)
		{
			$response = false;
			break;
		}
	}
}

echo json_encode($response);
?>