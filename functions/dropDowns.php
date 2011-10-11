<?php function dropDownAccount($transNumber, $current, $transactionAccount, $currentAccountPage, $accountTypes)
{
	$returnString = "<select name=\"{$current}account{$transNumber}\">\n";
	for ($i = 1; $accountTypes[$i]; $i++)
	{
		$returnString .= "\t<option value=\"".$i."\" ";
		$returnString .= selectedString($i, $currentAccountPage, $transactionAccount);
		$returnString .= $accountTypes[$i]."</option>\n";
	}
	$returnString .= "</select>\n";
	return $returnString;
}

function dropDownAccountType($transNumber, $transactionType, $accountTypes)
{
	$returnString  = "<select name=\"" /* . $current . 'accounttype' */
					. "$transNumber\">\n";
	$returnString .= "\t<option value=\"\"></option>\n";
	for ($i = 0; $accountTypes[$i]; $i++)
	{
		$returnString .= "\t<option value=\"".$accountTypes[$i]."\" ";
		$returnString .= selectedString($accountTypes[$i], $transactionType, '');
		$returnString .= $accountTypes[$i]."</option>\n";
	}
	$returnString .= "</select>\n";
	return $returnString;
}

function textField($transNum, $current, $type='description', $iType="text")
{

	if($type == 'amount')
	{
		$length = "maxlength=\"10\" size=\"5\"";
	}
	else
	{
		$length = "maxlength=\"256\"";
	}
	return  "<input type=\"$iType\" name=\"$type"
		. "$transNum\" $length value=\"$current\">\n";
}
function dropDownDate($type, $transNumber, $current, $max, $numPrevYears=1)
{
//$type can be day (d) month  (m) or year (Y) it is case sensitive
//$current == $day/$year/$month
	$i = 1;
	$J = (int)date($type);

	switch ($type)
	{
	case 'Y':
		$type = 'year';
		if (!$max) $max=2;
		$i = $J - $numPrevYears;
		$max += $i;
		break;
	case 'd':
		$type = 'day';
		if (!$max) $max=31;
		break;
	case 'm':
		$type = 'month';
		$months = array(0,'Jan','Feb','Mar','Apr',
						'May','June','July','Aug',
						'Sep','Oct','Nov','Dec');
		if(!$max) $max=12;
		break;
	default:
		return;
	}

	$returnString = "<select name=\"{$type}{$transNumber}\">\n";
	
	for (;$i <= $max; $i++)
	{
		$returnString .= "\t<option value=\"$i\" ";
		$returnString .= selectedString($i,$J,$current);
		$returnString .= ($type=='month') ? $months[$i] : $i;
		$returnString .= "</option>\n";
	}
	$returnString .=  "</select>\n";
	return $returnString;
}


?>
