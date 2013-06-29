<?php function submitItem($type, $number, $updating=false)
{
	$stmt;
	try
	{
	$connection = new PDO("mysql:host=" . HOSTNAME . ";port=3306;dbname=" . DATABASENAME . ";charset=UTF8", UPDATEUSER, UPDATEPASSWORD );
	$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	}
	catch(PDOException $e) {
		echo "Error!: " . $e->getMessage() . "<br/>\n";
		die("Unable to connect !\n is your database set up?".
                                "<a href=\"setup\">setup</a>");
	}
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
				. " VALUES (NULL, :month, :day, :year "
				.", :description, :amount, :toaccount) ";

		$stmt = $connection->prepare($insertQuery);
		$stmt->bindParam(":month", $_POST[$MONTH], PDO::PARAM_INT);
		$stmt->bindParam(":day", $_POST[$DAY], PDO::PARAM_INT);
		$stmt->bindParam(":year", $_POST[$YEAR], PDO::PARAM_INT);
		$stmt->bindParam(":description", $_POST[$DESCRIPTION], PDO::PARAM_STR);
		$stmt->bindParam(":amount", $_POST[$AMOUNT]);
		$stmt->bindParam(":toaccount", $_POST[$TOACCOUNT], PDO::PARAM_INT);
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
			$changesResult = $connection->query($checkChanges)
				or die('Error in query: $checkChanges.' . mysql_error());
			if ($changesResult->rowCount() > 0)
			{
				while($changesR = $changesResult->fetch())
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
						$stmt = $connection->prepare($insertQuery);
					}
				}
			}
			mysql_free_result($changesResult);
		}
		else
		{
			$insertQuery = "Insert Into `" . DATABASENAME . "`.`" . PREFIX.TRANSACTIONS . "` "
			. " (`month`, `day`, `year`, `description`, `amount`, `to account`, `from account`) "
			. " VALUES (:month, :day, :year "
			. ", :description, :amount, :toaccount, :fromaccount) ";

			$stmt = $connection->prepare($insertQuery);
			$stmt->bindParam(":month", $_POST[$MONTH], PDO::PARAM_INT);
			$stmt->bindParam(":day", $_POST[$DAY], PDO::PARAM_INT);
			$stmt->bindParam(":year", $_POST[$YEAR], PDO::PARAM_INT);
			$stmt->bindParam(":description", $_POST[$DESCRIPTION], PDO::PARAM_STR);
			$stmt->bindParam(":amount", $_POST[$AMOUNT]);
			$stmt->bindParam(":toaccount", $_POST[$TOACCOUNT], PDO::PARAM_INT);
			$stmt->bindParam(":fromaccount", $_POST[$FROMACCOUNT], PDO::PARAM_INT);
		}
	}
	$Result = $stmt->execute()
		or die("Error in query: $insertQuery." . mysql_error());

	$connection = null;
	return true;
}?>
