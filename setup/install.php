<?php
if (file_exists('../f-config.php')){
echo "<p>If you need to reset any of the configuration items in this file,"
	. "please delete f-config.php first.</p>";
}else{
	header('Location: setup-config.php');
}
include('../f-config.php');

//$connection = mysql_connect(HOSTNAME,'root','password');


$acc1_1 = "GRANT SELECT ON `".DATABASENAME."`.* TO '".USERNAME."'@'localhost'   IDENTIFIED BY '".PASSWORD."'";
//$acc1_2 = "GRANT SELECT ON `".DATABASENAME."`.* TO '".USERNAME."'@'%'    IDENTIFIED BY '".PASSWORD."'";
$acc2_1 = "GRANT SELECT,INSERT,UPDATE,DELETE,CREATE,DROP ON `".DATABASENAME."`.* TO '".UPDATEUSER."'@'localhost'"
				. "   IDENTIFIED BY '".UPDATEPASSWORD."'";
//$acc2_2 = "GRANT SELECT,INSERT,UPDATE,DELETE,CREATE,DROP ON `".DATABASENAME."`.* TO '".UPDATEUSER."'@'%'"
//				. "   IDENTIFIED BY '".UPDATEPASSWORD."'";




$Query1 = "CREATE DATABASE `".DATABASENAME."` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;";
mysql_query($Query1) or die(mysql_error());
mysql_query($acc1_1) or die(mysql_error());
//mysql_query($acc1_2) or die(mysql_error());
mysql_query($acc2_1) or die(mysql_error());
//mysql_query($acc2_2) or die(mysql_error());

$Query2	= "CREATE TABLE `".DATABASENAME."`.`".PREFIX.ACCOUNTS."` ("
		. " `number` tinyint( 4 ) NOT NULL AUTO_INCREMENT ,"
		. "`Name` text NOT NULL ,"
		. "`Type` varchar( 15 ) NOT NULL ,"
		. "`Interest Rate` decimal( 5, 5 ) NOT NULL ,"
		. "`Budget` decimal( 10, 2 ) NOT NULL ,"
		. "`start` decimal( 10, 2 ) NOT NULL ,"
		. "PRIMARY KEY ( `number` ) "
		. ") ENGINE = MYISAM DEFAULT CHARSET = latin1;";
mysql_query($Query2) or die(mysql_error());
$Query3 = "CREATE TABLE `".DATABASENAME."`.`".PREFIX.BILLS."` ("
		. "`number` int( 10 ) NOT NULL AUTO_INCREMENT ,"
		. "`month` tinyint( 2 ) NOT NULL ,"
		. "`day` tinyint( 2 ) NOT NULL ,"
		. "`year` smallint( 4 ) NOT NULL ,"
		. "`description` varchar( 150 ) NOT NULL ,"
		. "`amount` decimal( 10, 2 ) NOT NULL ,"
		. "`to account` tinyint( 4 ) NOT NULL ,"
		. "`paid` enum( 'true', 'false' ) NOT NULL default 'false',"
		. "PRIMARY KEY ( `number` ) "
		. ") ENGINE = MYISAM DEFAULT CHARSET = latin1;";
mysql_query($Query3) or die(mysql_error());
$Query4 = "CREATE TABLE `".DATABASENAME."`.`".PREFIX.TRANSACTIONS."` ("
		. "`number` int( 10 ) NOT NULL AUTO_INCREMENT ,"
		. "`month` tinyint( 2 ) NOT NULL ,"
		. "`day` tinyint( 2 ) NOT NULL ,"
		. "`year` int( 4 ) NOT NULL ,"
		. "`description` varchar( 150 ) NOT NULL ,"
		. "`amount` decimal( 10, 2 ) NOT NULL ,"
		. "`from account` tinyint( 4 ) NOT NULL ,"
		. "`to account` tinyint( 4 ) NOT NULL ,"
		. "PRIMARY KEY ( `number` ) "
		. ") ENGINE = MYISAM DEFAULT CHARSET = latin1;";
mysql_query($Query4) or die(mysql_error());
	mysql_close($connection); 	
?>