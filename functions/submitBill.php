<?php function submitBill($billNum){
	$AMOUNT = 'amount' . $billNum;
	$DESCRIPTION = 'description' . $billNum;
	$TOACCOUNT = 'toaccount'. $billNum;
	$MONTH = 'month' . $billNum;
	$DAY = 'day' . $billNum;
    $YEAR = 'year' . $billNum;
	$_POST[$AMOUNT]=(float)$_POST[$AMOUNT];
	if (!$_POST[$AMOUNT]){
		echo 'You did not enter a valid amount ';
		return false;
	}
	if (!$_POST[$DESCRIPTION]){
		echo ' You did not enter a description ';
		return false;
	}
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
	$connect = mysql_connect(HOSTNAME, USERNAME, PASSWORD)
		or die('Unable to connect!');
	return true;
}
?>