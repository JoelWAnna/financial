<?php function paid($billNum,$paid){
	mysql_close($connect);
	$connect3 = mysql_connect(HOSTNAME, UPDATEUSER, UPDATEPASSWORD)
		or die('Unable to connect!');
	mysql_select_db(DATABASENAME)
		or die('Unable to select database! '.DATABASENAME);	
	$q	= "UPDATE `".DATABASENAME."`.`".PREFIX.BILLS."` SET ";
	$q	.= "`paid` = '" . $paid . "' WHERE `" . PREFIX.BILLS
	. "`.`number` =". $billNum ." LIMIT 1";
	$Result = mysql_query($q)
		or die("Error in query: $q." . mysql_error());
	mysql_close($connect3);
	$connect = mysql_connect(HOSTNAME, USERNAME, PASSWORD)
		or die('Unable to connect!');
	mysql_select_db(DATABASENAME)
		or die('Unable to select database! '.DATABASENAME);	
}?>