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
while($countOfSlash < 20 && !file_exists($varToIndexDir."error.php"))
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

$response = true;


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
	$watchListSave = $arrayWatchList;
	$arrayWatchList = "";

	$numberOfRows = count($$config['watchList']);
	$i = 0;
	foreach ($$config['watchList'] as $key => $value) 
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
	$watchList = $arrayWatchList;
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