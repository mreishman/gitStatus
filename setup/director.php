<?php

require_once('setupProcessFile.php');


if($setupProcess == "preStart")
{
	$url = "http://" . $_SERVER['HTTP_HOST'] . "/status/setup/welcome.php";
	header('Location: ' . $url, true, 301);
	exit();
}
elseif ($setupProcess == "finished")
{
	$url = "http://" . $_SERVER['HTTP_HOST'] . "/status/index.php";
	header('Location: ' . $url, true, 301);
	exit();
}
else
{
	$url = "http://" . $_SERVER['HTTP_HOST'] . "/status/setup/".$setupProcess.".php";
	header('Location: ' . $url, true, 301);
	exit();
}

?>