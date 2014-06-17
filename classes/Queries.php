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
	return $stmt->execute()
		or die ("Error in query: line $login_result" . mysql_error());
    }

	public static function GetAccountBudget($number, &$connection)
	{
		$query = "SELECT `Budget` FROM `".PREFIX.ACCOUNTS
			. "` WHERE `number` = :acctNumber LIMIT 1 ";
		$stmt = $connection->prepare($query);
		$stmt->bindParam(":acctNumber", $number, PDO::PARAM_INT);

		$row = $stmt->execute();
		$row = $stmt->fetch();
		return $row['Budget'];
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
	
	public static function GetBills($showAllBills, $months, &$connection)
	{
		$billsQuery = 'SELECT * FROM `'.PREFIX.BILLS.'` ';
		if (!$showAllBills)
		{
			$month = (int)date("m", strtotime("+$months months"));
			$year = (int)date("Y", strtotime("+$months months"));
			$day = (int)date("d", strtotime("+$months months"));
			$billsQuery .= "WHERE `paid` = CONVERT(_utf8 'FALSE' "
					. "USING latin1) COLLATE latin1_swedish_ci "
					. " && ("
						. "( `". PREFIX . BILLS ."`.`year` < $year)"
						. " || "
						. "(( `". PREFIX . BILLS ."`.`year` = $year) && (`". PREFIX . BILLS ."`.`month` < $month))"
						. " || "
						. "((`". PREFIX . BILLS ."`.`year` = $year) && (`". PREFIX . BILLS ."`.`month` = $month) && (`". PREFIX . BILLS ."`.`day` <= $day))"
					. ")";
		}
		$billsQuery .= " ORDER BY `" . PREFIX . BILLS . "`.`year`, `" . PREFIX . BILLS . "`.`month`, `" . PREFIX
			. BILLS . "`.`day` ASC";
		$stmt = $connection->prepare($billsQuery);
		return $stmt;
	}
	
	//Takes account number and returns start amount for account
	  //plus transactions to account  minus transactions from account
	//include("functions/currentAmount.php");
	//function	currentAmount($accountNumber)
	//Takes account number and returns start amount for account
	//plus transactions to account  minus transactions from account
	//Calls to sumMonth
	//Called by pagelayout
	
	public static function currentAmount(&$connection, $accNumber, $recent = false, $day=false,$month=false,$year=false)
	{ 
			try
			{$returnAmount = 0;
		if(!$recent)
		{
			$query = "SELECT ROUND(start,2) as `start` "
					."FROM `".PREFIX.ACCOUNTS."` "
					."Where number = :acctNumber";
			$stmt = $connection->prepare($query);
			$stmt->bindParam(":acctNumber", $accNumber, PDO::PARAM_INT);
			$stmt->execute();
			if ($stmt->rowCount() > 0)
			{
				$start = $stmt->fetch();
				$returnAmount = $start[0];
			}
			$query = "SELECT SUM( `Amount` ) FROM `".PREFIX.TRANSACTIONS."` "
					 . "WHERE %%ACCTYPE%% = :acctNumber";
			
		
			$plusStmt = $connection->prepare(str_replace("%%ACCTYPE%%", "`To Account`", $query));
			$plusStmt->bindParam(":acctNumber", $accNumber, PDO::PARAM_INT);
			
			$minusStmt = $connection->prepare(str_replace("%%ACCTYPE%%", "`From Account`", $query));
			$minusStmt->bindParam(":acctNumber", $accNumber, PDO::PARAM_INT);
			
			$plusStmt->execute();
			$minusStmt->execute();
			
			if ($plusStmt->rowCount() > 0)
			{
				$sum = $plusStmt->fetch();
				$returnAmount += $sum[0];
			}
			if ($minusStmt->rowCount() > 0)
			{
				$sum = $minusStmt->fetch();
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

		return $returnAmount;
		}
		catch(PDOException $e) {
			echo "Error!: " . $e->getMessage() . "<br/>\n";
			die("");
		}
	}
	
	public static function GetNextAccountNumber(&$connection)
	{
		$pQuery  = "Select `number` from `".PREFIX.ACCOUNTS."` ORDER BY `number` DESC Limit 1";
		$rQuery = $connection->query($pQuery)
			or die("Error in query: $pQuery." . mysql_error());

		$number = 1;
		if($rQuery->rowCount() > 0)
		{
			$row = $rQuery->fetch();
			$number += (int)$row[0];
		}
		return $number;
	}

	public static function GetAccountInfo($number, &$connection)
	{
		$query = "Select * from `" . PREFIX.ACCOUNTS
			 . "` WHERE `" . PREFIX.ACCOUNTS . "`.`number` = :number";
		$stmt = $connection->prepare($query);
		$stmt->bindParam(":number", $number, PDO::PARAM_INT);
		$stmt->execute();
		$account = $stmt->fetch();
		$fetchedAccount = new Account();

		$fetchedAccount->number = $account['number'];
		$fetchedAccount->name = $account['Name'];
		$fetchedAccount->type = $account['Type'];
		$fetchedAccount->interest = $account['Interest Rate'];
		$fetchedAccount->budget = $account['Budget'];
		$fetchedAccount->start = $account['start'];

		return $fetchedAccount;
	}
	
	public static function paid($billNum,$paid)
	{
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
	}
}
?>