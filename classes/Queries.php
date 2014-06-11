<?php
class Queries
{
	public static function ConnectToDB($update)
	{
		$dbUser = USERNAME;
		$dbPasswd = PASSWORD;
		if ($update)
		{
			$dbUser = UPDATEUSER;
			$dbPasswd = UPDATEPASSWORD;
		}
		try
		{
		$connection = new PDO("mysql:host=" . HOSTNAME . ";port=3306;dbname=" . DATABASENAME . ";charset=UTF8", $dbUser,  $dbPasswd);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $connection;
		}
		catch(PDOException $e) {
			echo "Error!: " . $e->getMessage() . "<br/>\n";
			die("Unable to connect !\n is your database set up?".
									"<a href=\"setup\">setup</a>");
		}
	}

    public static function login(&$connection, $username, $password)
    {
        $query = " Select `privileges` "
        . " from " . PREFIX. "users"
	. " Where `login` = :login"
	. " AND `pwd` = :pwd ;";
	$stmt = $connection->prepare($query);
	$stmt->bindParam(":login", $username, PDO::PARAM_STR);
	$stmt->bindParam(":pwd", $password, PDO::PARAM_STR);
        return $stmt;
    }

    public static function GetTransactions($accountKey, $subPage)
    {
        $query = " SELECT * FROM `".PREFIX.TRANSACTIONS."` "
	.	" WHERE `From Account` = \"" . $accountKey . "\" "
	.	" OR `To Account` = \"" . $accountKey . "\" "
	.	" ORDER BY `". PREFIX.TRANSACTIONS ."`.`year` DESC, `"
	. PREFIX.TRANSACTIONS ."`.`month` DESC, `"
	. PREFIX.TRANSACTIONS ."`.`day` DESC, `"
        . PREFIX.TRANSACTIONS ."`.`description` DESC ";

	return $query;// . "LIMIT " . (($subPage-1)*100) . ", " . 100 . ";"; 
    }
    public static function	currentAccountAmount(&$connection, $accNumber, $subPage)
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
 public static function sumMonth($toOrFrom, $account, $month = 0, $day = 0, $year = 0)
{
 	if(!$month)
	{
		$month = (int)date("m");
	}
	if(!$day)
	{
		$day = (int)date("d");
	}
	if(!$year)
	{
		$year = (int)date("Y");
	}

	if ($month == 1)
	{
		$month2 = 12;
		$year2 = $year -1;
	}
	else
	{
		$month2 = $month-1;
		$year2=$year;
	}
	
	return "SELECT SUM( `amount` ) FROM `".PREFIX.TRANSACTIONS."` "
		.  "WHERE (((`month` = $month && `day` <= $day && `year` = $year ) "
		.  "OR (`month` = $month2 && `day` > $day && `year` = $year2 )) "
		.  "&& ( `$toOrFrom account` = $account ))";
}
}
?>