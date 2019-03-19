<?php

function generateWatchlistBlock($defaultArray, $arrayKeys, $key, $item, $i)
{
	$stringToReturn =	"
<script type=\"text/javascript\">
	var dataForWatchFolder" . $i . " = " . json_encode($item) . ";
</script>
<li class=\"watchFolderGroups\" id=\"rowNumber" . $i . "\" >
	<span class=\"leftSpacingserverNames\" > Name: </span>
	<input class='inputWidth300' type='text' name='watchListKey" . $i . "' value='" . $key . "'>";
	$j = 0;
	foreach($defaultArray as $key2 => $item2)
	{
		$j++;
		$stringToReturn .=	"
		<br>
		<span class=\"leftSpacingserverNames\" >" . $arrayKeys[$key2] . ": </span>
		<input style=\"display: none;\" type=\"text\" name='watchListItem" . $i . "-" . $j . "-Name' value=\"" . $key2 . "\" >";
 		if($key2 === "type")
 		{
 			$stringToReturn .=	"
 			<select class='inputWidth300' name='watchListItem" . $i . "-" . $j . "' >
 				<option value=\"local\" ";
 				if($item[$key2] === "local")
 				{
 					$stringToReturn .= " selected ";
 				}
 				$stringToReturn .= " >Local</option>
 				<option value=\"external\" ";
 				if($item[$key2] === "external")
 				{
 					$stringToReturn .= " selected ";
 				}
 				$stringToReturn .= ">External</option>
 			</select>";
 		}
 		elseif($key2 === "gitType")
 		{
			$stringToReturn .=	"
			<select class='inputWidth300' name='watchListItem" . $i . "-" . $j . "' >
				<option value=\"github\" ";
				if($item[$key2] === "github")
				{
					$stringToReturn .= " selected ";
				}
				$stringToReturn .= " >GitHub</option>
				<option value=\"gitlab\" ";
				if($item[$key2] === "gitlab")
				{
					$stringToReturn .= "selected";
				}
				$stringToReturn .= ">GitLab</option>
			</select>";
		}
		elseif($key2 === "Archive")
		{
 			$value = "false";
 			if(isset($item[$key2]))
 			{
 				$value = (string)$item[$key2];
 			}
 			$stringToReturn .=	"
 			<select class='inputWidth300' name='watchListItem" . $i . "-" . $j . "' >
 				<option value=\"true\" ";
 				if($value === "true")
 				{
 					$stringToReturn .= " selected ";
 				}
 				$stringToReturn .= " >True</option>
 				<option value=\"false\" ";
 				if($value === "false")
 				{
 					$stringToReturn .= " selected ";
 				}
 				$stringToReturn .= " >False</option>
 			</select>";
	 	}
	 	else
	 	{
	 		$stringToReturn .=	"
			<input class='inputWidth300'  type='text' name='watchListItem" . $i . "-" . $j . "' value='";
			if(isset($item[$key2]))
			{
				$stringToReturn .= "$item[$key2]";
			}
			$stringToReturn .= "'>";
		}
	}
	$stringToReturn .= "
	<input style=\"display: none\" type=\"text\" name=\"watchListItem" . $i . "-0\" value='" . $j . "'>
			<table width=\"100%\">
				<tr>
					<th width=\"50%\" style=\" text-align: center;\">
						<a style=\"display: block;\" class=\"mainLinkClass\" onclick=\"deleteRowFunction(" . $i . ", true);\">Remove</a>
					</th>
					<th width=\"50%\" style=\" text-align: center;\">
						<a style=\"display: block;\" class=\"mainLinkClass\" onclick=\"testConnection(dataForWatchFolder" . $i . ");\" >Check Connection</a>
					</th>
				</tr>
			</table>
			<table width=\"100%\">
				<tr>
					<th width=\"50%\" style=\" text-align: center;\">
						<a style=\"display: block;\" class=\"mainLinkClass\" > Move Up One </a>
					</th>
					<th width=\"50%\" style=\" text-align: center;\">
						<a style=\"display: block;\" class=\"mainLinkClass\" > Move Down One </a>
					</th>
				</tr>
			</table>
	</li>";
	return $stringToReturn;
}