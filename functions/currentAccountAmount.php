<?php function	currentAccountAmount($accNumber, $subPage)
{
	$BIGINTMAX = "18446744073709551610";

	$queryStartAmo = "SELECT ROUND(start,2) as `start` FROM `".PREFIX.ACCOUNTS."` "
				. "Where `number` =$accNumber";
	$resStartAmo = mysql_query($queryStartAmo)
		or die("Error in query: $queryStartAmo." . mysql_error());
	if (mysql_num_rows($resStartAmo) > 0)
	{
		$returnAmount = mysql_result($resStartAmo, 0);
	}
	mysql_free_result($resStartAmo);
	
	
	$query_Start = "SELECT SUM( `Amount` ) FROM ("
					. "SELECT * FROM `" . PREFIX.TRANSACTIONS . "` "
					. "WHERE `From Account` = $accNumber OR `To Account` = $accNumber "
					. "ORDER BY `"  . PREFIX.TRANSACTIONS . "`.`year` DESC, "
								."`". PREFIX.TRANSACTIONS . "`.`month` DESC, "
								."`". PREFIX.TRANSACTIONS . "`.`day` DESC "
					. "LIMIT " . (($subPage-1) * 100) . ", $BIGINTMAX ) AS tmp "
				. "WHERE `";
	$query_End = " Account` = $accNumber";

	$queryMinus = $query_Start . 'From'. $query_End;
	$queryPlus  = $query_Start .  'To' . $query_End;

	$resMinus = mysql_query($queryMinus)	
		or die("Error in query: \n$queryMinus\n" . mysql_error());
	$resPlus = mysql_query($queryPlus)
		or die("Error in query: \n$queryPlus\n" . mysql_error());

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
?>