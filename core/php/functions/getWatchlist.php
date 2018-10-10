<?php
$baseDir = "../../../";
$baseUrl = $baseDir."core/";
if(file_exists($baseDir.'local/layout.php'))
{
	$baseUrl = $baseDir."local/";
	//there is custom information, use this
	require_once($baseDir.'local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php');
require_once($baseDir.'core/conf/config.php');
require_once($baseDir.'core/php/configStatic.php');
require_once($baseDir.'core/php/loadVars.php');

echo json_encode(array("watchlist" => $watchList, "version" => $configStatic['version']));