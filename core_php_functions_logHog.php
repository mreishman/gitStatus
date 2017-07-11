<?php
$website = $_POST['website'];
$websiteBase = $_POST['websiteBase'];
$name = $_POST['name'];
$exists = false;
$link = "null";
$file_headers_send = "";
$fileArrayOuter = array(
	'fileArray' => array(
	$website	=>	'Log-Hog',
	$websiteBase	=>	'Log-Hog'
	),
	'fileArray2' => array(
	$website	=>	'loghog',
	$websiteBase	=>	'loghog',
	)
);

foreach ($fileArrayOuter as $key => $value) 
{
	foreach ($value as $key2 => $value2) 
	{
		if(!$exists)
		{
			$file = "https://".$key2;
			if(substr($file, -1) != '/')
			{
				$file .= "/";
			}
			$file .= $value2."/index.php";
			$file_headers = @get_headers($file);
			if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') 
			{   

			}
			else 
			{
				$file_headers_send = $file_headers;
			    $exists = true;
			    $link = $file;
			    break;
			}
		}
	}
}
$response = array(
	'link' 	=> $link,
	'name'	=> $name,
	'file_headers'	=> $file_headers_send
 );
echo json_encode($response);
?>