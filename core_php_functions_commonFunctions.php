<?php

function findUpdateValue($newestVersionCount, $versionCount, $newestVersion, $version)
{
	for($i = 0; $i < $newestVersionCount; $i++)
	{
		if($i < $versionCount)
		{
			if($i == 0)
			{
				if(intval($newestVersion[$i]) > intval($version[$i]))
				{
					return 3;
				}
				elseif(intval($newestVersion[$i]) < intval($version[$i]))
				{
					break;
				}
				continue;
			}
			elseif($i == 1)
			{
				if(intval($newestVersion[$i]) > intval($version[$i]))
				{
					return 2;
				}
				elseif(intval($newestVersion[$i]) < intval($version[$i]))
				{
					break;
				}
				continue;
			}
			if(!isset($newestVersion[$i]))
			{
				break;
			}
			if(intval($newestVersion[$i]) > intval($version[$i]))
			{
				return 1;
			}
			elseif(intval($newestVersion[$i]) < intval($version[$i]))
			{
				break;
			}
			continue;
		}
		return 1;
	}
	return 0;
}