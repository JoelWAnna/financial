<?php function setupAcc(&$accounttype,&$accounts){
		$index=0;
	$databaseFin='financial';
	mysql_select_db($databaseFin)
		or die('Unable to select database! $databaseFin');
	
	$querytype ="SELECT DISTINCT `Type` FROM `accounts` LIMIT 0 , 30";
	$queryname ="SELECT number, name, type FROM `accounts`";
	
	$typeresult = mysql_query($querytype)
		or die('Error in query: $querytype.' . mysql_error());
	$resultname = mysql_query($queryname)
		or die('Error in query: $queryname.' . mysql_error());
	
	if (mysql_num_rows($typeresult) > 0){
		while($row = mysql_fetch_row($typeresult)){		
			$accounttype[$index++]=$row[0];
		}
	}else{
		echo '<b>Error Line 53</b>';}
	if (mysql_num_rows($resultname) > 0){
		while($row = mysql_fetch_row($resultname)){		
			$accounts[$row[0]]= $row[1];
		}
	}else{
		echo '<b>Error Line 59</b>';
	}
	mysql_free_result($resultname);
	mysql_free_result($typeresult);
	}
?>
