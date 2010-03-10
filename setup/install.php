<?php
error_reporting(0);
if(isset($_POST['installed'])){

	header('Location: ../index.php?page=setup');
}
if (file_exists('../f-config.php')){
echo "<table height=20% align=center><tr><td><p align=center>If you need to reset any of the configuration items, "
	. "please delete f-config.php first.</p></td></tr></table>";
}else{
	header('Location: index.php');
}include('../f-config.php');







echo "<table align=center height=20%><tr>";
echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">";
echo "<td colspan=2>Root name</td><td>Root Password</td><td></td></tr><tr>";
echo "<td colspan=2><input type=\"text\" name=\"root\" value=\"".$_POST['root']."\" ></td>";
echo "<td><input type=\"password\" name=\"password\" value=\"".$_POST['password']."\"></td></tr><tr>";
echo "<td>Database<br>Tables<br>Users</td>"
	. "<td><input type=\"checkbox\" name=\"database\" value=\"database\" checked><br>";
echo "<input type=\"checkbox\" name=\"tables\" value=\"tables\" checked>"
	. "<br><input type=\"checkbox\" name=\"users\" value=\"users\" checked></td><td>"
	. "<input type=\"submit\" name=\"submit\" value=\"Install selected items\"></td>\n";
	echo "\n  </tr></table>";
	
echo //"<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">"
	 "<p align=center>Have you already installed<input type=\"submit\" name=\"installed\" value=\"Go to program\"></p>\n";
	echo "\n  </form>";

	
	
	if(isset($_POST['submit'])){
//	if(!$_POST['root'] & !$_POST['password']){
	//	echo "try again";
	//	die;
//	}
$any = 3;
	$connection = mysql_connect(HOSTNAME,$_POST['root'],$_POST['password']);
	if(!$connection){
	echo "<p align=center>Invalid hostname username or password</p>";
	die;
	}


if(isset($_POST['database'])){
$Query1 = "CREATE DATABASE `".DATABASENAME."` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;";
mysql_query($Query1) or die(mysql_error());
}else{ $any--;}
if(isset($_POST['tables'])){



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
		. "`description` varchar( 256 ) NOT NULL ,"
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
		. "`description` varchar( 256 ) NOT NULL ,"
		. "`amount` decimal( 10, 2 ) NOT NULL ,"
		. "`from account` tinyint( 4 ) NOT NULL ,"
		. "`to account` tinyint( 4 ) NOT NULL ,"
		. "PRIMARY KEY ( `number` ) "
		. ") ENGINE = MYISAM DEFAULT CHARSET = latin1;";
mysql_query($Query4) or die(mysql_error());
}else{ $any--;}
if(isset($_POST['users'])){

$acc1_1 = "GRANT SELECT ON `".DATABASENAME."`.* TO '".USERNAME."'@'localhost'   IDENTIFIED BY '".PASSWORD."'";
//$acc1_2 = "GRANT SELECT ON `".DATABASENAME."`.* TO '".USERNAME."'@'%'    IDENTIFIED BY '".PASSWORD."'";
$acc2_1 = "GRANT SELECT,INSERT,UPDATE,DELETE,CREATE,DROP ON `".DATABASENAME."`.* TO '".UPDATEUSER."'@'localhost'"
				. "   IDENTIFIED BY '".UPDATEPASSWORD."'";
//$acc2_2 = "GRANT SELECT,INSERT,UPDATE,DELETE,CREATE,DROP ON `".DATABASENAME."`.* TO '".UPDATEUSER."'@'%'"
//				. "   IDENTIFIED BY '".UPDATEPASSWORD."'";
mysql_query($acc1_1) or die(mysql_error());
//mysql_query($acc1_2) or die(mysql_error());
mysql_query($acc2_1) or die(mysql_error());
//mysql_query($acc2_2) or die(mysql_error());
}else{ $any--;}

	if(!$any){
	echo "<p align=center>You need to select at least one item to install</p>";
	}
	mysql_close($connection); 
}

?>