<?php

function findUpdateValue($newestVersionCount, $versionCount, $newestVersion, $version)
{
	for($i = 0; $i < $newestVersionCount; $i++)
	{
		if($i < $versionCount)
		{
			if($i == 0)
			{
				if($newestVersion[$i] > $version[$i])
				{
					return 3;
				}
				elseif($newestVersion[$i] < $version[$i])
				{
					break;
				}
				continue;
			}
			elseif($i == 1)
			{
				if($newestVersion[$i] > $version[$i])
				{
					return 2;
				}
				elseif($newestVersion[$i] < $version[$i])
				{
					break;
				}
				continue;
			}
			if(!isset($newestVersion[$i]))
			{
				break;
			}
			if($newestVersion[$i] > $version[$i])
			{
				return 1;
			}
			elseif($newestVersion[$i] < $version[$i])
			{
				break;
			}
			continue;
		}
		return 1;
	}
	return 0;
}