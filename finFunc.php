
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

<?php function	currentAmount($one){
	global $page;
	$queryCurAmo = "SELECT current FROM accounts Where number =";
	if($one){
		$queryCurAmo .= $one;
	}else{
		$queryCurAmo .= $page;
	}
	$resultCurAmo = mysql_query($queryCurAmo)
		or die('Error in query: $queryCurAmo.' . mysql_error());
	if (mysql_num_rows($resultCurAmo) > 0){
		while($rowCurAmo = mysql_fetch_row($resultCurAmo)){
			$CurAmo = $rowCurAmo[0];
		}
	}else{
		echo '<b>Error No start found line 155</b>';
	}
	mysql_free_result($resultnum);
	
	$querySt = 'SELECT SUM( `Amount` )'
			. ' FROM `transactions` WHERE `';		
	$queryEnd =' Account` =';
	if($one){
		$queryEnd .= $one;
	}else{
		$queryEnd .= $page;
	}			
	$resultminus = mysql_query($querySt . 'From'. $queryEnd)	
		or die('Error in query: Line 128.'. mysql_error());
	$resultplus = mysql_query($querySt . 'To'. $queryEnd)
		or die('Error in query: Line 130.' . mysql_error());

	if (mysql_num_rows($resultplus) > 0){
		while($rowplus = mysql_fetch_row($resultplus)){		
			$CurAmo += $rowplus[0];

		}
	}else{echo 'error line 136';}
	
	if (mysql_num_rows($resultminus) > 0){
		while($rowminus = mysql_fetch_row($resultminus)){		
			$CurAmo -= $rowminus[0];
		}
	}else{echo 'error line 142';}
	mysql_free_result($resultplus);
	mysql_free_result($resultminus);
	
	return $CurAmo;
}
?>



<?php function myEnterTrans($trNum){
	$_POST['amount']=(float)$_POST['amount'];
	if (!$_POST['amount']){
		echo 'You did not enter a valid amount ';
		return null;
		}
	if (!$_POST['month'] | !$_POST['day'] | !$_POST['year'] | !$_POST['description']
		| !$_POST['toaccount'] | !$_POST['fromaccount'])
	{
		echo ' You did not complete all of the required fields';
		return null;
	}
	if ($_POST['toaccount'] == $_POST['fromaccount']){
		echo ' accounts cannot be the same';
		return null;
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
			$changed = false;
			if($_POST['month'] != $changesR['month']){
				if($debug){echo $_POST['month'] . "<br>".$changesR['month'];}
				$changed = true; }
			if($_POST['day'] != $changesR['day']){
				if($debug){echo $_POST['day'] . "<br>".$changesR['day'];}
				$changed = true; }
			if($_POST['year'] != $changesR['year']){
				if($debug){echo $_POST['year'] . "<br>".$changesR['year'];}
				$changed = true; }	
			if($_POST['description'] != $changesR['description']){
				if($debug){echo $_POST['description'] . "<br>".$changesR['description'];}
				$changed = true; }		
			if($_POST['amount'] != $changesR['amount']){
				if($debug){echo $_POST['amount'] . "<br>".$changesR['amount'];}
				$changed = true; }
			if($_POST['toaccount'] != $changesR['to account']){
				if($debug){echo $_POST['to account'] . "<br>".$changesR['to account'];}
				$changed = true; }	
			if($_POST['fromaccount'] != $changesR['from account']){
				if($debug){echo $_POST['fromaccount'] . "<br>".$changesR['from account'];}
				$changed = true; }			
			if($changed == false){
				echo "no changes";
				return null;
			}
			else{$updateQ ="UPDATE `financial`.`transactions` SET ";
				
			}
		}
	}else{
		if($trNum == 0)echo "HELLLLLL";
		$updateQ ="Insert Into `financial`.`transactions` SET `transactions`.`number` ='" . $trNum . "', ";
		$new = 1 + $trNum;
		$newT= true;
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
	//echo $updateQ;
	$Result = mysql_query($updateQ)
		or die('Error in query: $updateQ.' . mysql_error());
	
	global $tdform;
	global $tdformat2;
	global $tdformat;
	global $w;
	global $page;
	global $CurrentAm;
	$months = array(0,Jan,Feb,Mar,Apr,
					May,June,July,Aug,
					Sep,Oct,Nov,Dec);
	global $accounts;

	if(!$newT){echo "\n  <tr align=center>" . $tdform . $w. "55>"
				. $months[(int)$_POST['month']]. $tdformat2. $w. "50>"
				. $_POST['day'] . $tdformat2. $w. "55>"
				. $_POST['year'] . $tdformat
				. $_POST['description'] . $tdformat
				. $accounts[$_POST['fromaccount']] . $tdformat
				. $accounts[$_POST['toaccount']]	. $tdformat;
			
			if($_POST['fromaccount']==$page){
				negativeRed(-1);
				echo "-";
			}
			echo $_POST['amount'];
			
			echo $tdformat;
			
			if($_POST['fromaccount']==$page){
				negativeRed($CurrentAm);
				echo $CurrentAm;
				$CurrentAm += $_POST['amount'];
				if($debug){
					echo "</td><td>" . $CurrentAm 
						 . "</td><td>". -$_POST['amount'];}
			}
			
			else{
				if(isZero($CurrentAm)){
					echo 0;
				}
				else{
					negativeRed($CurrentAm);
					echo $CurrentAm;
				}
				$CurrentAm	-= $_POST['amount'];
				if($debug){
					echo "</td><td>" . $CurrentAm
						. "</td><td>". $_POST['amount'];
				}
			}
			echo "</td>\n    ";
			echo "<form action=\"" . $_SERVER['PHP_SELF']. "?page=". $page 
				. "&new=".$new."\" method=\"post\">".  $tdform. "><input type=\"submit\" name=\""
				. $trNum . "\" value=\"". "Edit transaction " . $trNum
				. " \">" . "</td>\n    </form>";
			echo "\n  </tr>";
	}
	
	mysql_close($connect2);
	$connect = mysql_connect('localhost','guest')
		or die('Unable to connect!');
	if($newT){return true;//new trans
	}
	return false;
	}
	
?>