<?php
class Account
{
public $number;
public $name;
}
class AccountType
{
public $type;
public $accounts;
}

function GetAccountByNumber(&$all_accounts, $number)
{
	foreach ($all_accounts as $types)
	{
		foreach ($types->accounts as $acct)
		{
			if ($acct->number == $number)
			{
				return $acct;
			}
		}
	}
	return NULL;
}

function setupAcc(&$page, &$all_Accounts, $connection){
	if (strcmp('setup', $page)==0)
	{
		$page = -1;
		return;
	}

	$text ="Your setup is incorrect or you have not added databases to your server\n<br>";
	$querytype ="SELECT DISTINCT Type FROM " . PREFIX . ACCOUNTS . " ";
	//$typeresult = $connection->prepare($querytype);
	//if (!$typeresult->execute())
	//	die(mysql_error()."<br>".$text."<a href=\"setup\">setup</a>");

	$index=0;
	try{//$connection->query($querytype);
	foreach ($connection->query($querytype) as $row)
	//while($row = $typeresult->fetch())
	{
		$all_Accounts[$index] = new AccountType;
		$all_Accounts[$index++]->type = $row[0];
	}
	}catch(PDOException $ex) {
    echo "<br>An Error occured!"; //user friendly message
	echo $ex->getMessage();
   }
	//mysql_free_result($typeresult);

	foreach ($all_Accounts as $accountgroup)
	{
		$queryname = "SELECT `number`, `name` FROM `".PREFIX.ACCOUNTS."` "
				 	."Where `type` = \"" . $accountgroup->type . "\"";// Order BY `".PREFIX.ACCOUNTS."`.`name` ASC";
		$resultname = $connection->prepare($queryname);
		if (!$resultname->execute())
			die("Error in query: $queryname." . mysql_error());
		$type = "";
		if (validAccountforThisPage($accountgroup->type, true, false))
		{
			if (($accountgroup->type != "Income") && ($accountgroup->type != "Loan"))
				$type = " ". $accountgroup->type;
		}
		
		$index=0;
		while ($row = $resultname->fetch())
		{
			$tempAccount = new Account;
			$tempAccount->number = $row['number'];
			$tempAccount->name = $row['name'] . $type;
			$accountgroup->accounts[$index++] = $tempAccount;
			
		}
	}
}
?>
