<?php

function generateWatchlistBlock($defaultArray, $arrayKeys, $key = "{{key}}", $item = array(), $i = "{{i}}")
{
	$stringToReturn = "";
	if(!empty($item))
	{
		$stringToReturn .=	"
		<script type=\"text/javascript\">
			var dataForWatchFolder" . $i . " = " . json_encode($item) . ";
		</script>";
	}
	$stringToReturn .= "
<li class=\"watchFolderGroups\" id=\"rowNumber" . $i . "\" >
	<span class=\"leftSpacingserverNames\" > Name: </span>
	<input class='inputWidth300' type='text' name='watchListKey" . $i . "' value='" . $key . "'>";
	$j = 0;
	foreach($defaultArray as $key2 => $item2)
	{
		$varValue = "REPLACE";
		if(!empty($item))
		{
			$varValue = "";
			if(isset($item[$key2]))
			{
				$varValue = $item[$key2];
			}
		}
		$j++;
		$stringToReturn .=	"
		<br>
		<span class=\"leftSpacingserverNames\" >" . $arrayKeys[$key2] . ": </span>
		<input style=\"display: none;\" type=\"text\" name='watchListItem" . $i . "-" . $j . "-Name' value=\"" . $key2 . "\" >";
 		if($key2 === "type")
 		{
 			$stringToReturn .=	"
	 			<select class='inputWidth300' name='watchListItem" . $i . "-" . $j . "' >";
 			if(!empty($item))
 			{
	 			$stringToReturn .=	"
	 				<option value=\"local\" ";
	 				if($varValue === "local")
	 				{
	 					$stringToReturn .= " selected ";
	 				}
	 				$stringToReturn .= " >Local</option>
	 				<option value=\"external\" ";
	 				if($varValue === "external")
	 				{
	 					$stringToReturn .= " selected ";
	 				}
	 				$stringToReturn .= ">External</option>";
	 		}
	 		else
	 		{
	 			$stringToReturn .= "{{" . $i . "-" . $j . "}}";
	 		}
	 		$stringToReturn .= "</select>";
 		}
 		elseif($key2 === "gitType")
 		{
 			$stringToReturn .=	"
	 			<select class='inputWidth300' name='watchListItem" . $i . "-" . $j . "' >";
 			if(!empty($item))
 			{
				$stringToReturn .=	"
					<option value=\"github\" ";
					if($varValue === "github")
					{
						$stringToReturn .= " selected ";
					}
					$stringToReturn .= " >GitHub</option>
					<option value=\"gitlab\" ";
					if($varValue === "gitlab")
					{
						$stringToReturn .= "selected";
					}
					$stringToReturn .= ">GitLab</option>";
			}
	 		else
	 		{
	 			$stringToReturn .= "{{" . $i . "-" . $j . "}}";
	 		}
	 		$stringToReturn .= "</select>";
		}
		elseif($key2 === "Archive")
		{
			$stringToReturn .=	"
	 			<select class='inputWidth300' name='watchListItem" . $i . "-" . $j . "' >";
			if(!empty($item))
 			{
	 			$value = "false";
	 			if(isset($varValue))
	 			{
	 				$value = (string)$varValue;
	 			}
	 			$stringToReturn .=	"
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
	 				$stringToReturn .= " >False</option>";
	 		}
	 		else
	 		{
	 			$stringToReturn .= "{{" . $i . "-" . $j . "}}";
	 		}
	 		$stringToReturn .= "</select>";
	 	}
	 	else
	 	{
	 		$stringToReturn .=	"
			<input class='inputWidth300'  type='text' name='watchListItem" . $i . "-" . $j . "' value='";
			if(!empty($item))
			{
				if($varValue !== "")
				{
					$stringToReturn .= "$varValue";
				}
			}
			else
			{
				$stringToReturn .= "{{" . $i . "-" . $j . "}}";
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