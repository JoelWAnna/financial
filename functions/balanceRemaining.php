<?php function balanceRemaining($T,$A,$bool){
	if(!$bool){
		echo "<td align=right>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Available"
			. "</td><td align=right>&nbsp&nbsp&nbsp&nbsp Limit</td>";
		return;
	}
	$bal = "SELECT `Budget` FROM `".PREFIX.ACCOUNTS."` WHERE `name` = '".$T."' LIMIT 1 ";

	$resultbal = mysql_query($bal)
		or die('Error in query: $bal.' . mysql_error());
	if (mysql_num_rows($resultbal) > 0){
		$row = mysql_fetch_row($resultbal);
		echo "<td align=right>" . "&nbsp&nbsp&nbsp&nbsp ";
			if($A){
				printf("%.2f",$row[0] + $A);
			}else{ echo $row[0];}
		echo "</td><td align=right>" . "&nbsp&nbsp&nbsp&nbsp ". $row[0] . "</td>";
	}else{	die($bal);}
	mysql_free_result($resultbal);
}
?>