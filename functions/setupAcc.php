<?php function setupAcc(&$accounttype,&$accounts,&$accounts2,&$accounts3){
	$querytype ="SELECT DISTINCT `Type` FROM `".PREFIX.ACCOUNTS."` LIMIT 0 , 30";
	$queryname ="SELECT number, name, type FROM `".PREFIX.ACCOUNTS."`";
	$typeresult = mysql_query($querytype) or die("Error in query: $querytype." . mysql_error());
	$resultname = mysql_query($queryname) or die("Error in query: $queryname." . mysql_error());
	$index=0;
	if (mysql_num_rows($typeresult) > 0){
		while($row = mysql_fetch_row($typeresult)){		
			$accounttype[$index++]=$row[0];
		}
	}else{echo "<b>Error Line 17 $typeresult</b>";}
	mysql_free_result($typeresult);
	if (mysql_num_rows($resultname) > 0){
		while($row = mysql_fetch_assoc($resultname)){	
			$number = $row['number'];
			$name = $row['name'];
			$type = $row['type'];
			$accounts2[$number]= $name;
			$accounts[$number]= $name;
			if(($type == "Checking")
				| ($type== "Savings")
				| ($type== "Credit Card")
				| ($type== "Loan")){
				$accounts[$number].= " ". $type;
			}
			$accounts3[$number]= $type;
			
		}
	}else{echo "<b>Error Line 26 $resultname</b>";}
	mysql_free_result($resultname);
	
}
?>
