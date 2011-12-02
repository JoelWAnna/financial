<?php function submitItem($type, $number, $updating=false)
{
	$AMOUNT = 'amount' . $number;
	$DESCRIPTION = 'description' . $number;
	$TOACCOUNT = 'toaccount'. $number;
	$FROMACCOUNT = 'fromaccount' . $number;
	$MONTH = 'month' . $number;
	$DAY = 'day' . $number;
    $YEAR = 'year' . $number;
	$_POST[$AMOUNT]=(float)$_POST[$AMOUNT];
	if (!$_POST[$AMOUNT])
	{
		Panic("You did not enter a valid amount");
		return false;
	}
	if($type=='bill')
	{
		$insertQuery ="Insert Into `" . DATABASENAME . "`.`" . PREFIX.BILLS . "` "
				. " (`number`, `month`, `day`, `year`, `description`, `amount`, `to account`) "
				. " VALUES (NULL, '" . $_POST[$MONTH] . "', '" . $_POST[$DAY] . "', '" . $_POST[$YEAR] . "' "
				.", '" . $_POST[$DESCRIPTION] . "', '" . $_POST[$AMOUNT] . "', '" . $_POST[$TOACCOUNT] . "') ";
	}
	else if ($type == 'transaction')
	{
		if (!$_POST[$DESCRIPTION])
		{
			Panic("You did not enter a description");
			return false;
		}
		if ($_POST[$TOACCOUNT] == $_POST[$FROMACCOUNT])
		{
			Panic("Accounts cannot be the same");
			return false;
		}
		if($_POST[$AMOUNT] < 0)
		{
			$temp = $_POST[$TOACCOUNT];
			$_POST[$TOACCOUNT] = $_POST[$FROMACCOUNT];
			$_POST[$FROMACCOUNT] = $temp;
			$_POST[$AMOUNT] = -$_POST[$AMOUNT];
		}
		if ($updating)
		{
			$checkChanges = "SELECT * FROM `".PREFIX.TRANSACTIONS."` WHERE `"
						. PREFIX.TRANSACTIONS."`.`number` =" . $number . " LIMIT 1";
			$changesResult = mysql_query($checkChanges)
				or die('Error in query: $checkChanges.' . mysql_error());
			if (mysql_num_rows($changesResult) > 0)
			{
				while($changesR = mysql_fetch_assoc($changesResult))
				{
					if(($_POST[$MONTH] == $changesR['month'])
						& ($_POST[$DAY] == $changesR['day'])
						& ($_POST[$YEAR] == $changesR['year'])
						& ($_POST[$DESCRIPTION] == $changesR['description'])
						& ($_POST[$AMOUNT] == $changesR['amount'])
						& ($_POST[$TOACCOUNT] == $changesR['to account'])
						& ($_POST[$FROMACCOUNT] == $changesR['from account']))
					{
						Panic("no changes");
						return false;
					}
					else
					{
						$insertQuery ="UPDATE `" . DATABASENAME . "`.`" . PREFIX . TRANSACTIONS . "` SET "
								. " `month` = '" . $_POST[$MONTH]
								. "', `day` = '" . $_POST[$DAY]
								. "', `year` = '" . $_POST[$YEAR]
								. "', `description` = '" . $_POST[$DESCRIPTION]
								. "', `amount` = '" . $_POST[$AMOUNT]
								. "', `to account` = '" . $_POST[$TOACCOUNT]. "'"
								. ", `from account` = '" . $_POST[$FROMACCOUNT] . "'"
								. " WHERE `".PREFIX.TRANSACTIONS."`.`number` =". $number ." LIMIT 1";
					}
				}
			}
			mysql_free_result($changesResult);
		}
		else
		{
			$insertQuery = "Insert Into `" . DATABASENAME . "`.`" . PREFIX.TRANSACTIONS . "` "
			. " (`number`, `month`, `day`, `year`, `description`, `amount`, `to account`, `from account`) "
			. " VALUES (NULL, '" . $_POST[$MONTH] . "', '" . $_POST[$DAY] . "', '" . $_POST[$YEAR] . "' "
			. ", '" . $_POST[$DESCRIPTION] . "', '" . $_POST[$AMOUNT] . "', '" . $_POST[$TOACCOUNT] . "', '" . $_POST[$FROMACCOUNT] . "') ";
		}
	}
	$connect = mysql_connect(HOSTNAME, UPDATEUSER, UPDATEPASSWORD)
		or die('Unable to connect!');
	mysql_select_db(DATABASENAME)
		or die('Unable to select database! '.DATABASENAME);
	$Result = mysql_query($insertQuery)
		or die("Error in query: $insertQuery." . mysql_error());
	mysql_close($connect);
	$connect = mysql_connect(HOSTNAME, USERNAME, PASSWORD)
		or die('Unable to connect!');
	return true;
}?>
