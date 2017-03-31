<?php

$baseUrl = "../../";
if(file_exists('../../../local/layout.php'))
{
	$baseUrl = "../../../local/";
	//there is custom information, use this
	require_once('../../../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}

require_once($baseUrl.'conf/config.php'); 
require_once('../../conf/config.php');
require_once('../../../core/conf/config.php'); 
require_once('../loadVars.php');

	$arrayWatchList = "";
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

	$fileName = ''.$baseUrl.'conf/config.php';

	$newInfoForConfig = "
	<?php
		$"."config = array(
			'pollingRate' => ".$pollingRate.",
			'pausePoll' => '".$pausePoll."',
			'pauseOnNotFocus' => '".$pauseOnNotFocus."',
			'autoCheckUpdate' => '".$autoCheckUpdate."',
			'developmentTabEnabled' => '".$developmentTabEnabled."',
			'enableDevBranchDownload' => '".$enableDevBranchDownload."',
			'watchList' => array(
			".$arrayWatchList.")
		);
	?>";

	file_put_contents($fileName, $newInfoForConfig);

	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit();
?>