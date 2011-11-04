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
		foreach ($types->accounts as $fo)
		{
			if ($fo->number = $number)
			{
				return $fo;
			}
		}
	}
	return NULL;
}

function setupAcc(&$page, &$all_Accounts){
	if (strcmp('setup', $page)==0)
	{
		$page = -1;
		return;
	}
	
	$text ="Your setup is incorrect or you have not added databases to your server\n<br>";
	$querytype ="SELECT DISTINCT `Type` FROM `".PREFIX.ACCOUNTS."` ";
	$typeresult = mysql_query($querytype)
	or die(mysql_error()."<br>".$text."<a href=\"setup\">setup</a>");

	$index=0;
	if (mysql_num_rows($typeresult) > 0)
	{
		while($row = mysql_fetch_row($typeresult))
		{
			$all_Accounts[$index] = new AccountType;
			$all_Accounts[$index++]->type = $row[0];
		}
	}//else echo "<b>No account types found\n\n</b>";}
	mysql_free_result($typeresult);

	foreach ($all_Accounts as $accountgroup)
	{
		$queryname = "SELECT `number`, `name` FROM `".PREFIX.ACCOUNTS."` "
				 	."Where `type` = \"" . $accountgroup->type . "\" Order BY `".PREFIX.ACCOUNTS."`.`name` DESC";
		$resultname = mysql_query($queryname) or die("Error in query: $queryname." . mysql_error());

		$foobar = "";
		if (validAccountforThisPage($accountgroup->type, true, false))
		{
			if (($accountgroup->type != "Income") && ($accountgroup->type != "Loan"))
				//$foobar = " ". $accountgroup->type
				;
		}
		
		if (mysql_num_rows($resultname) > 0)
		{
			$index=0;
			while ($row = mysql_fetch_assoc($resultname))
			{
				$foo = new Account;
				$foo->number = $row['number'];
				$foo->name = $row['name'] . $foobar;
				$accountgroup->accounts[$index++] = $foo;
				
			}
		}
		mysql_free_result($resultname);
	}
}
?>
