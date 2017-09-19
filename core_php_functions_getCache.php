<?php
if(file_exists('../../conf/cachedStatus.php'))
{ 
	require_once('../../conf/cachedStatus.php');  
}

echo json_encode($cachedStatusMainObject);
?>