<?php function dropDownAccount($transNumber, $current, $transactionAccount, $currentAccountPage, &$all_Accounts)
{
	$returnString = "<select name=\"{$current}account{$transNumber}\">\n\t";
	foreach ($all_Accounts as $acccountGroup)
	{
		foreach ($acccountGroup->accounts as $acct)
		{
			$returnString .= "\t<option value=\"".$acct->number."\" ";
			$returnString .= selectedString($acct->number, $currentAccountPage, $transactionAccount);
			$returnString .= $acct->name."</option>\n\t";
		}
	}
	$returnString .= "</select>\n\t";
	return $returnString;
}

function dropDownAccountType($transNumber, $transactionType, &$all_Accounts)
{
	$returnString  = "<select name=\"" /* . $current . 'accounttype' */
					. "$transNumber\">\n\t";
	$returnString .= "\t<option value=\"\"></option>\n\t";
	foreach ($all_Accounts as $accts)
	{
		$returnString .= "\t<option value=\"". $accts->type ."\" ";
		$returnString .= selectedString($accts->type, $transactionType, '');
		$returnString .= $accts->type ."</option>\n\t";
	}
	$returnString .= "</select>\n\t";
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
		. "$transNum\" $length value=\"$current\">\n\t";
}
function dropDownDate($type, $transNumber, $current, $max, $numPrevYears=1)
{
//$type can be day (d) month  (m) or year (Y) it is case sensitive
//$current == $day/$year/$month
	$i = 1;
	$J = (int)date($type);
	$OnChange = " OnChange=\"jsDateSelector(document.New_Item, $transNumber)\" ";
	$onfocus = " onfocus=\"jsDateSelector(document.New_Item, $transNumber)\" ";

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
		//$OnChange = "";
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

	$returnString = "<select id=\"{$type}{$transNumber}\" name=\"{$type}{$transNumber}\" $OnChange$onfocus>\n\t";

	for (;$i <= $max; $i++)
	{
		$returnString .= "\t<option value=\"$i\" ";
		$returnString .= selectedString($i,$J,$current);
		$returnString .= ($type=='month') ? $months[$i] : $i;
		$returnString .= "</option>\n\t";
	}
	$returnString .=  "</select>\n\t";
	return $returnString;
}

?>
