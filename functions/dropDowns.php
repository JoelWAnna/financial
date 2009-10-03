<?php function dropDownString($type, $transNumber, $current, $max=0, $reverseLen=0, $accounts=0)
{
//$type can be day (d) month  (m) or year (Y) it is case sensitive
//$current == $day/$year/$month

	if($type=='account')
	{
		$returnString = "<select name=\"{$current}{$type}{$transNumber}\">\n";
		for ($i = 1; $accounts[$i]; $i++)
		{
			$returnString .= "\t<option value=\"".$i."\"";
			$returnString .= selectedString($i, $reverseLen, $max);
			$returnString .= $accounts[$i]."</option>\n";
		}
		$returnString .= "</select>\n";
		return $returnString;
	}

	if($type=='accounttype')
	{
		$returnString  = "<select name=\"" ./*  $current . $type. */ "$transNumber\">\n";
		$returnString .= "\t<option value=\"\"></option>\n";
		for ($i = 0; $accounts[$i]; $i++)
		{
			$returnString .= "\t<option value=\"".$accounts[$i]."\"";
			$returnString .= selectedString($accounts[$i], $reverseLen, $max);
			$returnString .= $accounts[$i]."</option>\n";
		}
		$returnString .= "</select>\n";
		return $returnString;
	}
	
	if($type == 'words')
	{
		$type = 'description';
	}
	
	if($type == 'amount' | $type == 'description')
	{
		$returnString = "<input type=\"text\" name=\"{$type}{$transNumber}\" ";

		if($type == 'amount')
		{
			$returnString .= "maxlength=\"10\" size=\"5\"";
		}
		else
		{
			$returnString .= "maxlength=\"15\"";
		}
		$returnString .= "  value=\"$current\">\n";
		return $returnString;
	}

	$J = (int)date($type);

	if($type == 'Y')
	{
		$type = 'year';
		if (!$max)
		{
			$max=2;
		}
		if (!$reverseLen)
		{
			$reverseLen = 1;
		}
		$max += $J - $reverseLen;
	}
	else if ($type == 'd')
	{
		$type = 'day';
		if (!$max)
		{
			$max=31;
		}
	}
	else if ($type == 'm')
	{
			$type = 'month';
			$months = array(0,Jan,Feb,Mar,Apr,
							May,June,July,Aug,
							Sep,Oct,Nov,Dec);
			if(!$max)
			{
				$max=12;
			}
	}
	
	
	//$returnString 
	$returnString = "<select name=\"{$type}{$transNumber}\">\n";
	
	for ($i=1; $i <= $max; $i++;)
	{
		$returnString .= "\t<option value=\"";
		$returnString .= $i. "\"";
		$returnString .= selectedString($i,$J,$current);

		if($type=='month')
		{
			$returnString .= $months[$i];
		}
		else
		{
			$returnString .= $i;
		}
		$returnString .= "</option>\n";
	}
	$returnString .=  "</select>\n";
	return $returnString;
}
?>
