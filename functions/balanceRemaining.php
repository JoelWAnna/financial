<?php function balanceRemaining($T,$A,$bool){
	 if(!$bool){
	echo "<td align=center>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Available</td><td align=center>&nbsp&nbsp&nbsp&nbsp Limit</td>";
	return;}
	
	$bal = "SELECT `Budget` FROM `accounts` WHERE `name` = '".$T."' LIMIT 1 ";
//echo $bal;
	$resultbal = mysql_query($bal)
		or die('Error in query: $bal.' . mysql_error());
	//echo $A;
	if (mysql_num_rows($resultbal) > 0){
		//while(
		$row = mysql_fetch_row($resultbal);
		//){		
		echo "<td align=center>" . "&nbsp&nbsp&nbsp&nbsp ". $row[0] . "</td><td align=center>"
			. "&nbsp&nbsp&nbsp&nbsp ". ($row[0] + $A) . "</td>";
		
	}/* else{ echo "<td>5</td><td>6</td>";} */
	mysql_free_result($resultbal);
}
?>