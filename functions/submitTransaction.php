<?php function submitTransaction($trNum,$negative){
	$AMOUNT = 'amount' . $trNum;
	$DESCRIPTION = 'description' . $trNum;
	$TOACCOUNT = 'toaccount'. $trNum;
	$FROMACCOUNT = 'fromaccount' . $trNum;
	$MONTH = 'month' . $trNum;
	$DAY = 'day' . $trNum;
    $YEAR = 'year' . $trNum;
	$_POST[$AMOUNT]=(float)$_POST[$AMOUNT];
	if (!$_POST[$AMOUNT]){
		echo 'You did not enter a valid amount ';
		
		return false;
	}
	if (!$_POST[$DESCRIPTION]){
		echo ' You did not enter a description ';
		return false;
	}
	if ($_POST[$TOACCOUNT] == $_POST[$FROMACCOUNT]){
		echo ' Accounts cannot be the same ';
		return false;
	}
	if($_POST[$AMOUNT] < 0){
		$temp = $_POST[$TOACCOUNT];
		$_POST[$TOACCOUNT] = $_POST[$FROMACCOUNT];
		$_POST[$FROMACCOUNT] = $temp;
	//	if(!$negative){
		$_POST[$AMOUNT] = -$_POST[$AMOUNT];
	//	}
	}

	$checkChanges = "SELECT * FROM `transactions` WHERE `transactions`.`number` ="
					. $trNum. " LIMIT 1";
	$changesResult = mysql_query($checkChanges)
		or die('Error in query: $checkChanges.' . mysql_error());
	if (mysql_num_rows($changesResult) > 0){
		while($changesR = mysql_fetch_assoc($changesResult)){
			if(($_POST[$MONTH] != $changesR['month'])
				| ($_POST[$DAY] != $changesR['day'])
				| ($_POST[$YEAR] != $changesR['year'])
				| ($_POST[$DESCRIPTION] != $changesR['description'])
				| ($_POST[$AMOUNT] != $changesR['amount'])
				| ($_POST[$TOACCOUNT] != $changesR['to account'])
				| ($_POST[$FROMACCOUNT] != $changesR['from account'])
				)
			{
				$changed = true;
				$updateQ ="UPDATE `financial`.`transactions` SET ";
			}else{
				echo "no changes";
				return false;
			}
		}
	}else{
	if($trNum == 0){echo "HELLLLLL";}
	$updateQ ="Insert Into `financial`.`transactions` SET `transactions`.`number` ='" . $trNum . "', ";
	}
	mysql_free_result($changesResult);

	$connect2 = mysql_connect('localhost','financial')
		or die('Unable to connect!');
	$databaseFin='financial';
	mysql_select_db($databaseFin)
		or die('Unable to select database! $databaseFin');	
	
	
	$updateQ .= "`month` = '"
			. $_POST[$MONTH] . "', `day` = '". $_POST[$DAY] . "', `year` = '"
			. $_POST[$YEAR] . "', `description` = '". $_POST[$DESCRIPTION]
			. "', `amount` = '" . $_POST[$AMOUNT] ."', `from account` = '"
			. $_POST[$FROMACCOUNT] . "', `to account` = '" . $_POST[$TOACCOUNT]. "'";

	if($changed){
		$updateQ .= " WHERE `transactions`.`number` =". $trNum ." LIMIT 1";
	}
	$Result = mysql_query($updateQ)
		or die('Error in query: $updateQ.' . mysql_error());
	mysql_close($connect2);
	$connect = mysql_connect('localhost','guest')
		or die('Unable to connect!');
	return true;
}
?>