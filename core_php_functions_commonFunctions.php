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
			}
			else
			{
				if(isset($newestVersion[$i]))
				{
					if($newestVersion[$i] > $version[$i])
					{
						return 1;
					}
					elseif($newestVersion[$i] < $version[$i])
					{
						break;
					}
				}
				else
				{
					break;
				}
			}
		}
		else
		{
			return 1;
		}
	}
	return 0;
}