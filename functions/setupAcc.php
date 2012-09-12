<?php

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
		#$queryname = "SELECT `number`, `name` FROM `".PREFIX.ACCOUNTS."` "
		$queryname = "SELECT * FROM `".PREFIX.ACCOUNTS."` "
				 	."Where `type` = \"" . $accountgroup->type . "\"";// Order BY `".PREFIX.ACCOUNTS."`.`name` ASC";
		$resultname = mysql_query($queryname) or die("Error in query: $queryname." . mysql_error());

		$type = "";
		if (validAccountforThisPage($accountgroup->type, true, false))
		{
			if (($accountgroup->type != "Income") && ($accountgroup->type != "Loan"))
				$type = " ". $accountgroup->type;
		}
		
		if (mysql_num_rows($resultname) > 0)
		{
			$index=0;
			while ($row = mysql_fetch_assoc($resultname))
			{
				$tempAccount = new Account;
				$tempAccount->number = $row['number'];
				$tempAccount->name = $row['Name'] . $type;
				$tempAccount->type = $row['Type'];
				$tempAccount->interest = $row['Interest Rate'];
				$tempAccount->budget = $row['Budget'];
				#$tempAccount->start = $row['start'];
				
				$accountgroup->accounts[$index++] = $tempAccount;
				
			}
		}
		mysql_free_result($resultname);
	}
}
?>
