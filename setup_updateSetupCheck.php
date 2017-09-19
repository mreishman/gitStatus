<?php

require_once('setupProcessFile.php');

$boolVar = ($setupProcess === $_POST['status']);

echo json_encode($boolVar);
?>