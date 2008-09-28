<?php function myEnterTrans($trNum){
	$_POST['amount']=(float)$_POST['amount'];
	if (!$_POST['amount']){
		echo 'You did not enter a valid amount ';
		return false;
		}
	if (!$_POST['month'] | !$_POST['day'] | !$_POST['year'] | !$_POST['description']
		| !$_POST['toaccount'] | !$_POST['fromaccount'])
	{
		echo ' You did not complete all of the required fields';
		return false;
	}
	if ($_POST['toaccount'] == $_POST['fromaccount']){
		echo ' accounts cannot be the same';
		return false;
		}
		
	if($_POST['amount'] < 0){
		if($debug){echo $_POST['toaccount']. "BR".$_POST['fromaccount']."<BR>";}
		$temp = $_POST['toaccount'];
		$_POST['toaccount'] = $_POST['fromaccount'];
		$_POST['fromaccount'] = $temp;
		if($debug){echo $_POST['toaccount']. "BR".$_POST['fromaccount'];
		echo $_POST['amount']. "<br>";}
		$_POST['amount'] = -$_POST['amount'];
		if($debug){echo $_POST['amount']. "<br>";}
		}
		
		
		
	$checkChanges = "SELECT * FROM `transactions` WHERE `transactions`.`number` ="
					. $trNum. " LIMIT 1";
	$changesResult = mysql_query($checkChanges)
		or die('Error in query: $checkChanges.' . mysql_error());
	if (mysql_num_rows($changesResult) > 0){
		while($changesR = mysql_fetch_assoc($changesResult)){
			if(($_POST['month'] != $changesR['month'])
				| ($_POST['day'] != $changesR['day'])
				| ($_POST['year'] != $changesR['year'])
				| ($_POST['description'] != $changesR['description'])
				| ($_POST['amount'] != $changesR['amount'])
				| ($_POST['toaccount'] != $changesR['to account'])
				| ($_POST['fromaccount'] != $changesR['from account'])
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
			. $_POST['month'] . "', `day` = '". $_POST['day'] . "', `year` = '"
			. $_POST['year'] . "', `description` = '". $_POST['description']
			. "', `amount` = '" . $_POST['amount'] ."', `from account` = '"
			. $_POST['fromaccount'] . "', `to account` = '" . $_POST['toaccount']. "'";

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