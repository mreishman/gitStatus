<?php

function sendCurl($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec ($ch);
	curl_close ($ch);
	return $result;
}
$url = "https://".$_POST['sendUrlHere'];

$result = sendCurl($url);
if(!$result)
{
	$url = "http://".$_POST['sendUrlHere'];
	$result = sendCurl($url);
}

echo json_encode($result);
?>