<?php function	currentAccountAmount(&$connection, $accNumber, $subPage)
{
	$BIGINTMAX = "18446744073709551610";

	$queryStartAmo = "SELECT ROUND(start,2) as `start` FROM `".PREFIX.ACCOUNTS."` "
				. "Where `number` =$accNumber";
	$resStartAmo = $connection->query($queryStartAmo)
		or die("Error in query: $queryStartAmo." . mysql_error());
	if ($resStartAmo->rowCount() > 0)
	{
		$row = $resStartAmo->fetch();
		$returnAmount = $row[0];
	}
	
	
	$query_Start = "SELECT SUM( `Amount` ) FROM ("
					. "SELECT * FROM `" . PREFIX.TRANSACTIONS . "` "
					. " WHERE `From Account` = \"" . $accNumber . "\" "
					. " OR `To Account` = \"" . $accNumber . "\" "
					. " ORDER BY `"  . PREFIX.TRANSACTIONS . "`.`year` DESC, "
								."`" . PREFIX.TRANSACTIONS . "`.`month` DESC, "
								."`" . PREFIX.TRANSACTIONS . "`.`day` DESC "
					. "LIMIT " . (($subPage-1) * 100) . ", $BIGINTMAX ) AS tmp "
				. "WHERE `";
	$query_End = " Account` = $accNumber";

	$queryMinus = $query_Start . 'From'. $query_End;
	$queryPlus  = $query_Start .  'To' . $query_End;

	$resMinus = $connection->query($queryMinus)	
		or die("Error in query: \n$queryMinus\n" . mysql_error());
	$resPlus = $connection->query($queryPlus)
		or die("Error in query: \n$queryPlus\n" . mysql_error());

	if ($resPlus->rowCount() > 0)
	{
		$row = $resPlus->fetch();
		$returnAmount += $row[0];
	}
	if ($resMinus->rowCount() > 0)
	{
		$row = $resMinus->fetch();
		$returnAmount -=  $row[0];
	}
	
	return $returnAmount;
}
?>