<?php function setupAcc(){
		$index=0;
		global $accounttype;
		global $accounts;
	$databaseFin='financial';
	mysql_select_db($databaseFin)
		or die('Unable to select database! $databaseFin');
	
	$querytype ="SELECT DISTINCT `Type` FROM `accounts` LIMIT 0 , 30";
	$queryname ="SELECT number, name, type FROM `accounts`";
	
	$typeresult = mysql_query($querytype)
		or die('Error in query: $querytype.' . mysql_error());
	$resultname = mysql_query($queryname)
		or die('Error in query: $queryname.' . mysql_error());
	
	if (mysql_num_rows($typeresult) > 0){
		while($row = mysql_fetch_row($typeresult)){		
			$accounttype[$index++]=$row[0];
		}
	}else{
		echo '<b>Error Line 53</b>';}
	if (mysql_num_rows($resultname) > 0){
		while($row = mysql_fetch_row($resultname)){		
			$accounts[$row[0]]= $row[1];
		}
	}else{
		echo '<b>Error Line 59</b>';
	}
	mysql_free_result($resultname);
	mysql_free_result($typeresult);
	}
?>

<?php function selected($i,$j,$s){
	if($s){
			if($s == $i){
				echo " selected=\"selected\"";
			}
		}
		else{
			if($i == $j){
				echo " selected=\"selected\"";
			}
		}
}
?>

<?php function monthdropdown($month){
	global $months;
	$j= date("m");
	echo "<select name=\"month\">\n";
	for($i=1;$i<13;$i++){
		echo "\t<option value=\"";
		if($i<10){ echo "0";}
		echo $i. "\"";
		selected($i,$j,$month);
		echo ">". $months[$i]."</option>\n";
	}
	echo  "</select>\n";
	}
?>

<?php function daydropdown($day){
	$j= date("d");
	echo "<select name=\"day\">\n";
	$i=0;
	while(++$i <32){
		echo "\t<option value=\"".$i."\"";		
		selected($i,$j,$day);		
		echo ">" .$i."</option>\n";
	}
	echo "</select>\n";
}
?>

<?php function yeardropdown($year,$len,$rlen){
	if(!$len){$len=3;}
	if(!$rlen){$rlen=1;}
	$len -= $rlen;
	$j= (int)date("Y");
	echo "<select name=\"year\">\n";
	for($i=($j-$rlen);$i < ((int)$j+$len);$i++){
		echo "\t<option value=\"".$i."\"";
		selected($i,$j,$year);/* if($i==0){echo " selected=\"selected\" ";} */
		echo ">" .($i)."</option>\n";
	}
	echo "</select>\n";
}
?>

<?php function descriptionbox($description){
	echo "<input type=\"text\" name=\"description\" maxlength=\"10\" value=\""
		. $description . "\">\n";
	}
?>

<?php function accountdropdown($where,$which){
	global $accounts;
	global $page;
	echo "<select name=\"" . $where . "account\">\n";
	$i=1;
	while($accounts[$i]){
		echo "\t<option value=\"".$i."\"";
		selected($i,$page,$which);
		echo ">".$accounts[$i++]."</option>\n";
	}
	echo "</select>\n";
}
?>

<?php function amountbox($amount){
	echo "<input type=\"number\" name=\"amount\""
		. " maxlength=\"9\" size=\"5\" value=\""
		. $amount . "\" showlength=\"4\">\n";
}
?>

<?php function edittrans($transNumber,$month, $day, $year, $description,
						$toAcc,$fromAcc,$amount){
	global $debug2;global $newtransa;

	global $page;
/* 	if($debug2){
	echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">"
		. "<table bordercolor=\"000\" border=2><tr>";
	} */
	
	echo "\n    <tr><form action=\"" . $_SERVER['PHP_SELF']. "?page="
					. $page . "\" method=\"post\">";

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
	if($newtransa){
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

<?php function negativeRed($num){
	if($num < 0){
		echo "<font color = red>";
	}
}
?>

<?php function isZero($i){
	if($i < .001 && $i < .002){
		return true;
	}
	else{
		return false;
	}
}
?>

<?php function newestTransaction(){
$newQ = " SELECT `number` FROM `transactions` ORDER BY `transactions`.`number` DESC LIMIT 1 ";
	 
	$newR = mysql_query($newQ)
		or die('Error in query: $newQ.' . mysql_error());
	if (mysql_num_rows($newR) > 0){
		$return = mysql_fetch_row($newR);
		
		return ((int)$return[0]+1);
	}
	else{return -1;}
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
		$new= true;
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

	if(!$new){echo "\n  <tr align=center>" . $tdform . $w. "55>"
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
				. "\" method=\"post\">".  $tdform. "><input type=\"submit\" name=\""
				. $trNum . "\" value=\"". "Edit transaction " . $trNum
				. " \">" . "</td>\n    </form>";
			echo "\n  </tr>";
	}	
	mysql_close($connect2);
	$connect = mysql_connect('localhost','guest')
		or die('Unable to connect!');
}
?>