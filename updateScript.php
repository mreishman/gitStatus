<?php
  
$arrayOfFiles = array("core_conf_config.php", "core_css_jquery-ui.css","core_html_changelog.html","core_js_angular.min.js","core_js_jquery.xcolor.min.js","core_js_jquery-ui.js","core_js_main.js","core_js_watchlist.js","core_php_functions_logHog.php","core_php_functions_gitBranchName.php","core_php_loadVars.php","core_php_saveFunctions_cachedStatus.php","core_php_saveFunctions_settingsSaveMain.php","core_php_templateFiles_colorBG.php","core_php_templateFiles_customMessage.php","core_php_templateFiles_devBoxSettings.php","core_php_templateFiles_issuesSearchVars.php","core_php_templateFiles_settingsMain.php","core_php_templateFiles_watchList.php","index.php","local_default_template_theme.css","settings.php","settings-watchList.php","setup_director.php","setup_setupProcessFile.php","setup_step1.php","setup_step2.php","setup_updateSetupStatus.php","setup_welcome.php","update.php");

require_once("innerUpgradeStatus.php");

if($innerUpdateProgress['currentFile'] < sizeOf($arrayOfFiles))
{
 
$currentFile = $arrayOfFiles[$innerUpdateProgress['currentFile']]; 
$indexToExtracted = "update/downloads/updateFiles/extracted/";  
$varToIndexDir = "";
$countOfSlash = 0;
while($countOfSlash < 20 && !file_exists($varToIndexDir."index.php"))
{
  $varToIndexDir .= "../";        
}
  
if($currentFile == "core_conf_config.php")
{
   	if (!file_exists($varToIndexDir.'core/css')) 
   	{
    		mkdir($varToIndexDir.'core/css', 0777, true);
	}
	if (!file_exists($varToIndexDir.'setup/')) 
   	{
    		mkdir($varToIndexDir.'setup/', 0777, true);
	}
}
  
//update innerUpgradeStatus file
$newCount = $innerUpdateProgress['currentFile'] + 1;

$currentFileArray = explode("_", $currentFile );  
$sizeOfCurrentFileArray = sizeOf($currentFileArray);

$nameOfFile = $currentFileArray[$sizeOfCurrentFileArray - 1];

$directoryPath = "";
  
for($i = 0; $i < $sizeOfCurrentFileArray - 1; $i++)
{
  $directoryPath .= $currentFileArray[$i]."/"; 
}
 
$newFile = $directoryPath.$nameOfFile;
$fileTransfer = file_get_contents($varToIndexDir.$indexToExtracted.$currentFile);
file_put_contents($varToIndexDir.$newFile,$fileTransfer);  
  
$string = "Updating file ".$newCount." of ".sizeOf($arrayOfFiles). " - Updating this file -  ".$varToIndexDir.$newFile." - with this file - ".$varToIndexDir.$indexToExtracted.$currentFile; 
  
//update message for update  
  
updateProgressFile($string, "", "updateProgressFileNext.php", "");
updateProgressFile($string, "", "updateProgressFile.php", "");   
  
$mainFileContents = file_get_contents("updateProgressLog.php");
$mainFileContents = $string.$mainFileContents;	
file_put_contents("updateProgressLog.php", $mainFileContents);	
	
  
//update innerUpgradeStatus.php
  
$writtenTextTofile = "<?php
	$"."innerUpdateProgress = array(
  	'currentFile'   => '".$newCount."'
	);
	?>
";



file_put_contents($varToIndexDir.$indexToExtracted."innerUpgradeStatus.php", $writtenTextTofile);  

  
}
else
{
  
updateProgressFile("Finished Running Update Script", "", "updateProgressFileNext.php", "");
updateProgressFile("Finished Running Update Script", "", "updateProgressFile.php", "");  
  
}



  
?>
