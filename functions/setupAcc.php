<?php function setupAcc(&$page, &$ACC_TYPE, &$ACC_1, &$ACC_2, &$ACC_3){
	if ($page=='setup')
	{
		$page = -1;
		return;
	}
	$text ="Your setup is incorrect or you have not added databases to your server\n<br>";
	$querytype ="SELECT DISTINCT `Type` FROM `".PREFIX.ACCOUNTS."` LIMIT 0 , 30";
	$queryname ="SELECT number, name, type FROM `".PREFIX.ACCOUNTS."`";
	$typeresult = mysql_query($querytype)
	or die(mysql_error()."<br>".$text."<a href=\"setup\\setup-config.php\">setup</a>");

	$resultname = mysql_query($queryname) or die("Error in query: $queryname." . mysql_error());
	$index=0;

	if (mysql_num_rows($typeresult) > 0){
		while($row = mysql_fetch_row($typeresult)){		
			$ACC_TYPE[$index++]=$row[0];
		}
	}//else echo "<b>No account types found\n\n</b>";}
	mysql_free_result($typeresult);
	if (mysql_num_rows($resultname) > 0){
		while($row = mysql_fetch_assoc($resultname)){	
			$number = $row['number'];
			$name = $row['name'];
			$type = $row['type'];
			$ACC_2[$number]= $name;
			$ACC_1[$number]= $name;
			if(validAccountforThisPage($type, true, false)){
				$ACC_1[$number].= " ". $type;
			}
			$ACC_3[$number]= $type;
			
		}
	}//else echo "<b>No accounts found\n</b>";
	mysql_free_result($resultname);
	
}
?>
