<?php
require_once('../../../core/php/update/updateProgressFile.php');
$returnBool = false;
if($updateProgress['percent'] === 100)
{
	$returnBool = true;
}
echo json_encode($returnBool);
