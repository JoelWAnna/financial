<?php function submitItem($type,$number,$negative){
	$AMOUNT = 'amount' . $number;
	$DESCRIPTION = 'description' . $number;
	$TOACCOUNT = 'toaccount'. $number;
	$FROMACCOUNT = 'fromaccount' . $number;
	$MONTH = 'month' . $number;
	$DAY = 'day' . $number;
    $YEAR = 'year' . $number;
	$_POST[$AMOUNT]=(float)$_POST[$AMOUNT];
	if (!$_POST[$AMOUNT]){
		echo 'You did not enter a valid amount ';
		return false;
	}
	if (!$_POST[$DESCRIPTION]){
		echo ' You did not enter a description ';
		return false;
	}
if($type=='trans'){
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

	$checkChanges = "SELECT * FROM `".PREFIX.TRANSACTIONS."` WHERE `".PREFIX.TRANSACTIONS."`.`number` ="
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
				$updateQ ="UPDATE `".DATABASENAME."`.`".PREFIX.TRANSACTIONS."` SET ";
			}else{
				echo "no changes";
				return false;
			}
		}
	}else{
	if($trNum == 0){echo "HELLLLLL";}
	$updateQ ="Insert Into `".DATABASENAME."`.`".PREFIX.TRANSACTIONS."` SET `".PREFIX.TRANSACTIONS."`.`number` ='" . $trNum . "', ";
	}
	mysql_free_result($changesResult);

	$connect2 = mysql_connect(HOSTNAME, UPDATEUSER, UPDATEPASSWORD)
		or die('Unable to connect!');
	mysql_select_db(DATABASENAME)
		or die('Unable to select database! DATABASENAME');	
	
	
	$updateQ .= "`month` = '"
			. $_POST[$MONTH] . "', `day` = '". $_POST[$DAY] . "', `year` = '"
			. $_POST[$YEAR] . "', `description` = '". $_POST[$DESCRIPTION]
			. "', `amount` = '" . $_POST[$AMOUNT] ."', `from account` = '"
			. $_POST[$FROMACCOUNT] . "', `to account` = '" . $_POST[$TOACCOUNT]. "'";

	if($changed){
		$updateQ .= " WHERE `".PREFIX.TRANSACTIONS."`.`number` =". $trNum ." LIMIT 1";
	}
	$Result = mysql_query($updateQ)
		or die('Error in query: $updateQ.' . mysql_error());
	mysql_close($connect2);
}
else{
	if(1){
		$connect4 = mysql_connect(HOSTNAME, UPDATEUSER, UPDATEPASSWORD)
			or die('Unable to connect!');

		mysql_select_db(DATABASENAME)
			or die('Unable to select database! DATABASENAME');	
		
		$updateQ ="Insert Into `".DATABASENAME."`.`".PREFIX.BILLS."` SET `".PREFIX.BILLS."`.`number` ='" . $billNum . "', ";
		$updateQ .= "`month` = '"
				. $_POST[$MONTH] . "', `day` = '". $_POST[$DAY] . "', `year` = '"
				. $_POST[$YEAR] . "', `description` = '". $_POST[$DESCRIPTION]
				. "', `amount` = '" . $_POST[$AMOUNT] ."', `to account` = '" . $_POST[$TOACCOUNT]. "'";
		$Result = mysql_query($updateQ)
			or die('Error in query: $updateQ.' . mysql_error());
		mysql_close($connect4);
	}
}
	
	
	
	
	
	
	
	$connect = mysql_connect(HOSTNAME, USERNAME, PASSWORD)
		or die('Unable to connect!');
	return true;
}
?>