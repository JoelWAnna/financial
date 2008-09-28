
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


<?php function edittrans(&$page,&$accounts,$newtransa,$transNumber,$month, $day, $year, $description,
						$fromAcc,$toAcc,$amount){
	if($newtransa > 0){
		$newtransa++;
	}
	echo "\n    <tr><form action=\"" . $PHP_SELF. "?page="
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
	accountdropdown('from',$fromAcc,$accounts,$page);
	echo "</td><td>";
	accountdropdown('to',$toAcc,$accounts,$page);
	echo "</td><td>";
	if($fromAcc==$page){
		amountbox(-$amount);
	}else{
		amountbox($amount);
	}
	echo "</td>"
		. "<td colSpan=\"2\" align=center><input type=\"submit\""
		. " name=\"X".$transNumber. "\" value=\"";
	if($newtransa /*  > 0 */){
		echo "Add New Transaction";
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