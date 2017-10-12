<?php
  
$arrayOfFiles = array("core_php_upgradeScripts_upgrade-1.3.2-1.3.3.php", "core_conf_config.php","core_html_changelog.html","core_js_allPages.js","core_js_main.js","core_js_settings.js","core_php_loadVars.php","core_php_saveFunctions_settingsSaveMain.php","core_php_templateFiles_settingsMain.php","core_php_templateFiles_watchList.php","core_php_update_checkVersionOfConfig.php","core_php_update_checkVersionOfLayout.php","core_php_update_configStaticCheck.php","core_php_update_getPercentUpdate.php","core_php_update_performSettingsInstallUpdateAction.php","core_php_update_resetUpdateFilesToDefault.php","core_php_update_settingsInstallUpdate.php","core_php_versionCheck.php","core_template_theme.css","index.php","local_default_template_theme.css","update_index.php","not_a_real_file.php");

require_once("innerUpgradeStatus.php");

if($innerUpdateProgress['currentFile'] < sizeOf($arrayOfFiles))
{

sleep(2);  
$currentFile = $arrayOfFiles[$innerUpdateProgress['currentFile']]; 
$indexToExtracted = "update/downloads/updateFiles/extracted/";  
$varToIndexDir = "";
$countOfSlash = 0;
while($countOfSlash < 20 && !file_exists($varToIndexDir."index.php"))
{
  $varToIndexDir .= "../";        
}
  
if($currentFile == "core_php_versionCheck.php")
{
   include($varToIndexDir."/core/php/upgradeScripts/upgrade-1.3.2-1.3.3.php");
}
	
if($currentFile == "not_a_real_file.php")
{
	//redirect to external upgrade thing	
	header("Location: ".$varToIndexDir."update/downloads/updateFiles/extracted/updater-tmp.html"); 
	exit();
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

 
sleep(2);  
}
else
{
  
updateProgressFile("Finished Running Update Script", "", "updateProgressFileNext.php", "");
updateProgressFile("Finished Running Update Script", "", "updateProgressFile.php", "");  
  
}



  
?>
