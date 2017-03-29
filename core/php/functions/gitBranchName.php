<?php
$response = "";
$response = trim(shell_exec('git --git-dir=/var/www/html/.git rev-parse --abbrev-ref HEAD'));

$date = date('j m Y');
$time = date('H:i:s');

echo json_encode($response);
?>
