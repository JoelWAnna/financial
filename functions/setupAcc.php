<?php function setupAcc(&$page, &$ACC_TYPE, &$accounts){
	if (strcmp('setup', $page)==0)
	{
		$page = -1;
		return;
	}
	$text ="Your setup is incorrect or you have not added databases to your server\n<br>";
	$querytype ="SELECT DISTINCT `Type` FROM `".PREFIX.ACCOUNTS."` LIMIT 0 , 30";
	$typeresult = mysql_query($querytype)
	or die(mysql_error()."<br>".$text."<a href=\"setup\">setup</a>");

	$index=0;
	$accounts = array();
	if (mysql_num_rows($typeresult) > 0)
	{
		while($row = mysql_fetch_row($typeresult))
		{
			$ACC_TYPE[$index++]=$row[0];
		}
	}//else echo "<b>No account types found\n\n</b>";}
	mysql_free_result($typeresult);
	$queryname ="SELECT number, name, type FROM `".PREFIX.ACCOUNTS."` SORT BY `type` DESC";
	$resultname = mysql_query($queryname) or die("Error in query: $queryname." . mysql_error());
	if (mysql_num_rows($resultname) > 0)
	{
		while ($row = mysql_fetch_assoc($resultname))
		{	
			$foo = new Account;
			$foo->number = $row['number'];
			$foo->name = $row['name'];
			$foo->type = $row['type'];
			if (validAccountforThisPage($foo->type, true, false))
			{
				if (($type != "Income") && ($type != "Loan"))
					$foo->name .= " ". $foo->type;
			}
			$accounts[$foo->number] = $foo;
		}
	}//else echo "<b>No accounts found\n</b>";
	mysql_free_result($resultname);

}
?>
