<?php
$version = explode('.', $configStatic['version']);
$newestVersion = explode('.', $configStatic['newestVersion']);

$levelOfUpdate = 0; // 0 is no updated, 1 is minor update and 2 is major update
$beta = false;

$newestVersionCount = count($newestVersion);
$versionCount = count($version);
$levelOfUpdate = $levelOfUpdate = findUpdateValue($newestVersionCount, $versionCount, $newestVersion, $version);