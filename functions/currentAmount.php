<?php //function	currentAmount($accountNumber) 
	  //Takes account number and returns start amount for account
	  //plus transactions to account  minus transactions from account
function	currentAmount($accNumber,$recent,$day,$month,$year){
if(!$recent){	
	$queryStartAmo = "SELECT start FROM accounts Where number =" . $accNumber;
	$resStartAmo = mysql_query($queryStartAmo)
		or die('Error in query: $queryStartAmo.' . mysql_error());
	if (mysql_num_rows($resStartAmo) > 0){
		$rStartAmo = mysql_fetch_row($resStartAmo);
		$returnAmount = $rStartAmo[0];
	}else{
		echo '<b>error no rows in $resStartAmo</b>';
	}
	//mysql_free_result($resultnum);

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
	$returnAmount = 0;
//	$queryfrom = sumMonth("from",$accNumber,$day,$month,$year);
	$queryto = sumMonth("to",$accNumber,$day,$month,$year);
	
	/* $querySt = 'SELECT SUM( `Amount` ) FROM `transactions` WHERE `';		
	$queryEnd =' Account` ='. $accNumber; */
	
/* 	$resMinus = mysql_query($queryfrom)	
		or die('Error in query: $resultMinus.'. mysql_error());
	 */$resPlus = mysql_query($queryto)
		or die('Error in query: $resultPlus.' . mysql_error());

	if (mysql_num_rows($resPlus) > 0){
		while($rPlus = mysql_fetch_row($resPlus)){		
			$returnAmount += $rPlus[0];
		}
	}else{
		echo 'error no rows in $resPlus';
	}
/* 	if (mysql_num_rows($resMinus) > 0){
		while($rMinus = mysql_fetch_row($resMinus)){		
			$returnAmount -= $rMinus[0];
		}
	}else{
		echo 'error no rows in $resMinus';
	} */
	mysql_free_result($resPlus);
/* 	mysql_free_result($resMinus);
 */	

	return $returnAmount;
	
}
?>