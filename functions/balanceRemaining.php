<?php function balanceRemaining($AccountName,$A,$bool){
	if(!$bool){
		echo "<td colspan=2 align=right><div id=\"small\">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Available</div></td>"
			. "<td align=right><div id=\"small\">&nbsp&nbsp&nbsp&nbsp Limit</div></td>";
		return;
	}
	$bal = "SELECT `Budget` FROM `".PREFIX.ACCOUNTS."` WHERE `name` = '".$AccountName."' LIMIT 1 ";

	$resultbal = mysql_query($bal)
		or die("Error in query: $bal." . mysql_error());
	if (mysql_num_rows($resultbal) > 0){
		$row = mysql_fetch_row($resultbal);
		echo "<td align=right><div id=\"small\">" . "&nbsp&nbsp&nbsp&nbsp ";
			if($A){
				printf("%.2f",$row[0] + $A);
			}else{ echo $row[0];}
		echo "</div></td><td align=right><div id=\"small\">" . "&nbsp&nbsp&nbsp&nbsp ". $row[0] . "</div></td>";
	}else{	die($bal);}
	mysql_free_result($resultbal);
}
?>