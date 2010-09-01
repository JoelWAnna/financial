<?php //Takes account number and returns start amount for account
	  //plus transactions to account  minus transactions from account
function	currentAmount($accNumber,$recent = false,$day=false,$month=false,$year=false)
{
	$returnAmount = 0;
	if(!$recent){
		$queryStartAmo = "SELECT ROUND(start,2) as `start` FROM `".PREFIX.ACCOUNTS."` Where number =" . $accNumber;
		$resStartAmo = mysql_query($queryStartAmo)
			or die('Error in query: $queryStartAmo.' . mysql_error());
			
	
		if (mysql_num_rows($resStartAmo) > 0)
		{
			$returnAmount = mysql_result($resStartAmo, 0);
		}
		mysql_free_result($resStartAmo);

		$querySt = 'SELECT SUM( `Amount` ) FROM `'.PREFIX.TRANSACTIONS.'` WHERE `';		
		$queryEnd =' Account` ='. $accNumber;
		$resMinus = mysql_query($querySt . 'From'. $queryEnd)	
			or die('Error in query: $resultMinus.'. mysql_error());
		$resPlus = mysql_query($querySt . 'To'. $queryEnd)
			or die('Error in query: $resultPlus.' . mysql_error());
		if (mysql_num_rows($resPlus) > 0)
		{
			$returnAmount += mysql_result($resPlus, 0);
		}
		if (mysql_num_rows($resMinus) > 0)
		{
			$returnAmount -= mysql_result($resMinus, 0);
		}
		mysql_free_result($resPlus);
		mysql_free_result($resMinus);
		
		return $returnAmount;
	}
	$queryto = sumMonth("to",$accNumber,$day,$month,$year);
	$resPlus = mysql_query($queryto)
		or die('Error in query: $resultPlus.' . mysql_error());
	if (mysql_num_rows($resPlus) > 0)
	{
		while($rPlus = mysql_fetch_row($resPlus))
		{
			$returnAmount += $rPlus[0];
		}
	}else
	{
		echo 'error no rows in $resPlus';
	}
	mysql_free_result($resPlus);

	return $returnAmount;
}
?>