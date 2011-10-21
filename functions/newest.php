<?php function newest($type)
{
	$typeQ = PREFIX;
	if ($type == 'transaction')
	{
		$typeQ .= TRANSACTIONS;
	}
	else if ($type == 'bill')
	{
		$typeQ .= BILLS;
	}
	else
	{
		Panic("function newest() called with an invalid argument");
		return -1;
	}
	
	$newQ = " SELECT `number` FROM `$typeQ` ORDER BY `$typeQ`.`number` DESC LIMIT 1 ";
	
	$newR = mysql_query($newQ)
		or die("Error in query: $newQ." . mysql_error());

	$newestNumber = 1;
	if (mysql_num_rows($newR) > 0)
	{
		$row = mysql_fetch_row($newR);
		$newestNumber += (int)$row[0];
	}
	mysql_free_result($newR);
	return $newestNumber;
}
?>