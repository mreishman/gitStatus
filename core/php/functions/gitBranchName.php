<?php
//echo json_encode();
$function = "git --git-dir=".$_POST['location'].".git rev-parse --abbrev-ref HEAD";
$response = "";
$response = trim(shell_exec($function));

$date = date('j m Y');
$time = date('H:i:s');

echo json_encode($response);
?>