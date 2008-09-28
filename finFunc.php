
<?php function reloadPHP(){


	echo "<script type=\"text/javascript\">"
		. "function load()"
		. "{"
		. "window.location.replace(\"".$PHP_SELF ."\");"
		. "}"
		. "</script>";
	echo "<script type=\"text/javascript\">"
		. "load();"
		. "</script>";
}
?>


<?php function edittrans($newtransa,$transNumber,$month, $day, $year, $description,
						$toAcc,$fromAcc,$amount){
	global $debug2;

	global $page;
	/* 	if($debug2){
	echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">"
		. "<table bordercolor=\"000\" border=2><tr>";
	} */
	if($newtransa > 0){
		$newtransa++;
	}
	
	echo "\n    <tr><form action=\"" . $_SERVER['PHP_SELF']. "?page="
					. $page . "&new=".$newtransa."\" method=\"post\">";

	echo "<td>";
	monthdropdown($month);
	echo "</td><td>";
	daydropdown($day);
	echo "</td><td>";
	yeardropdown($year);
	echo "</td><td>";
	descriptionbox($description);
	echo "</td><td>";
	accountdropdown('from',$toAcc);
	echo "</td><td>";
	accountdropdown('to',$fromAcc);
	echo "</td><td>";
	amountbox($amount);
	$X = "X";
	echo "</td>"
		. "<td colSpan=\"2\" align=center><input type=\"submit\""
		. " name=\"".$X.$transNumber. "\" value=\"";
	if($newtransa > 0){
		echo "Add new Transaction";
	}
	else{
		echo "Submit Changes";
	}	
	echo "\" style=\"background-color: abcdef;\"></td>\n  ";

	
	
	

echo "</form></tr>";
}
?>

<?php //function	currentAmount($accountNumber) 
	  //Takes account number and returns start amount for account
	  //plus transactions to account  minus transactions from account
function	currentAmount($accNumber){
	$queryStartAmo = "SELECT start FROM accounts Where number =" . $accNumber;
	$resStartAmo = mysql_query($queryStartAmo)
		or die('Error in query: $queryStartAmo.' . mysql_error());
	if (mysql_num_rows($resStartAmo) > 0){
		$rStartAmo = mysql_fetch_row($resStartAmo);
		$returnAmount = $rStartAmo[0];
	}else{
		echo '<b>error no rows in $resStartAmo</b>';
	}
	mysql_free_result($resultnum);

	$querySt = 'SELECT SUM( `Amount` ) FROM `transactions` WHERE `';		
	$queryEnd =' Account` ='. $accNumber;
	
	$resMinus = mysql_query($querySt . 'From'. $queryEnd)	
		or die('Error in query: $resultMinus.'. mysql_error());
	$resPlus = mysql_query($querySt . 'To'. $queryEnd)
		or die('Error in query: $resultPlus.' . mysql_error());

	if (mysql_num_rows($resPlus) > 0){
		while($rPlus = mysql_fetch_row($resPlus)){		
			$returnAmount += $rPlus[0];
		}
	}else{
		echo 'error no rows in $resPlus';
	}
	if (mysql_num_rows($resMinus) > 0){
		while($rMinus = mysql_fetch_row($resMinus)){		
			$returnAmount -= $rMinus[0];
		}
	}else{
		echo 'error no rows in $resMinus';
	}
	mysql_free_result($resPlus);
	mysql_free_result($resMinus);
	
	return $returnAmount;
}
?>



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
			//$changed = false;
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
			/* if($changed == false){
				echo "no changes";
				return false;
			} */
			//else{
			//$updateQ ="UPDATE `financial`.`transactions` SET ";
			//}
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