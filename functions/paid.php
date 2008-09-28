<?php function paid($billNum,$paid){

	$connect3 = mysql_connect('localhost','financial')
		or die('Unable to connect!');
	$databaseFin='financial';
	mysql_select_db($databaseFin)
		or die('Unable to select database! $databaseFin');	
		
		
	$q	= "UPDATE `financial`.`bills` SET ";
	$q	.= "`paid` = '" . $paid;
	$q	.= "' WHERE `bills`.`number` =". $billNum ." LIMIT 1";
	//echo $q;
	$Result = mysql_query($q)
		or die('Error in query: $q.' . mysql_error());
	mysql_close($connect3);
	$connect = mysql_connect('localhost','guest')
		or die('Unable to connect!');
		
}