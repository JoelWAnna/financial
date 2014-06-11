<?php //Takes account number and returns start amount for account
	  //plus transactions to account  minus transactions from account
function	currentAmount( &$connection, $accNumber, $recent = false, $day=false,$month=false,$year=false)
{
	$returnAmount = 0;
	if(!$recent){
		$queryStartAmo = "SELECT ROUND(start,2) as `start` FROM `".PREFIX.ACCOUNTS."` Where number =" . $accNumber;
		$resStartAmo = $connection->query($queryStartAmo)
			or die('Error in query: $queryStartAmo.' . mysql_error());
			 
	
		if ($resStartAmo->rowCount() > 0)
		{
			$start = $resStartAmo->fetch();
			$returnAmount = $start[0];
		}
		//mysql_free_result($resStartAmo);

		$querySt = 'SELECT SUM( `Amount` ) FROM `'.PREFIX.TRANSACTIONS.'` WHERE `';
		$queryEnd =' Account` ='. $accNumber;
		$resMinus = $connection->query($querySt . 'From'. $queryEnd)
			or die('Error in query: $resultMinus.'. mysql_error());
		$resPlus = $connection->query($querySt . 'To'. $queryEnd)
			or die('Error in query: $resultPlus.' . mysql_error());
		if ($resPlus->rowCount() > 0)
		{
			$sum = $resPlus->fetch();
			$returnAmount += $sum[0];
		}
		if ($resMinus->rowCount() > 0)
		{
			$sum = $resMinus->fetch();
			$returnAmount -= $sum[0];
		}
		
		return $returnAmount;
	}
	$queryto = Queries::sumMonth("to",$accNumber,$day,$month,$year);
	$resPlus = $connection->query($queryto)
		or die('Error in query: $resultPlus.' . mysql_error());
	if ($resPlus->rowCount() > 0)
	{
		while($rPlus = $resPlus->fetch())
		{
			$returnAmount += $rPlus[0];
		}
	}else
	{
		echo 'error no rows in $resPlus';
	}
	//mysql_free_result($resPlus);

	return $returnAmount;
}
?>