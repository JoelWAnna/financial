<?php function CleanupNumbers($transactionsOrBills)
{
	$connect = mysql_connect(HOSTNAME, UPDATEUSER, UPDATEPASSWORD)
		or die('Unable to connect!');
	mysql_select_db(DATABASENAME)
		or die('Unable to select database! '.DATABASENAME);	
	
	$i = 0;
	while(1)
	{
		$sqlNumber = " Select `number` from `$transactionsOrBills` "
					." Order by `number` ASC limit $i, 1";
		$resNumber = mysql_query($sqlNumber)	
			or die("Error in query: $sqlNumber.". mysql_error());
		if (mysql_num_rows($resNumber) < 1) break;

		$currentNum = mysql_result($resNumber, 0);
		mysql_free_result($resNumber);

		if ( ++$i != $currentNum)
		{
			$sql2 = "Update `$transactionsOrBills`"
				. "SET `number`=$i WHERE `number` = $currentNum;";
			$res2 = mysql_query($sql2)
				or die("Error in query: $sql2.". mysql_error());
			echo "updated #$currentNum, to be $i/n";
		}
	}
	
	$sql3 = "ALTER TABLE `$transactionsOrBills`  AUTO_INCREMENT =$i";
	mysql_query($sql3) or die("Error in query: $sql3.". mysql_error());

	
	mysql_close($connect);
	$connect = mysql_connect(HOSTNAME, USERNAME, PASSWORD)
		or die('Unable to connect!');
}
?>
