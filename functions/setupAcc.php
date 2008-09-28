<?php function setupAcc(&$accounttype,&$accounts){
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
		while($row = mysql_fetch_row($resultname)){		
			$accounts[$row[0]]= $row[1];
		}
	}else{echo "<b>Error Line 26 $resultname</b>";}
	mysql_free_result($resultname);
}
?>
