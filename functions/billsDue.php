<?php function billsDue(&$accounts,$allbills){
	$billsQ = 'SELECT * FROM `'.PREFIX.BILLS.'` ';
/**/	if(!$allbills){
/**/		$billsQ .= "WHERE `paid` = CONVERT(_utf8 'FALSE' "
/**/				. "USING latin1) COLLATE latin1_swedish_ci";
/**/	}
	echo "<table border=3 width=50% align=center>";
	$billsQ .= " ORDER BY `".PREFIX.BILLS."`.`month`, `".PREFIX.BILLS."`.`day`, `".PREFIX.BILLS."`.`year` ASC";
	
	
	$billsR = mysql_query($billsQ)
		or die("Error in query: $billsQ." . mysql_error());
	if (mysql_num_rows($billsR) > 0){
		while($billRows = mysql_fetch_assoc($billsR)){
			echo "<tr align=center>"	."<td>"
			. $billRows['month'] . "/" 
			. $billRows['day']. "/"
			. $billRows['year'] . "</td>"
			."<td>";
			if($billRows['to account'] > 0){
				echo $accounts[$billRows['to account']];
			}
			else {
				echo $billRows['description'];
				}
			echo "</td>"."<td>". $billRows['amount'] ."</td>"
			."<td>"
			. "<form action=\"" . $_SERVER['PHP_SELF']. "\" method=\"post\">"
			. "<input type=\"submit\" name=\"paid" . $billRows['number'] . "\" value=\"Paid\">"
			. "</td></form>";
/**/			if($allbills){
/**/				echo "<td><form action=\"" . $_SERVER['PHP_SELF']. "?page=-1\" method=\"post\">"
/**/					. "<input type=\"submit\" name=\"unpaid" . $billRows['number'] . "\" "
/**/					. "value=\"Not paid\"></td></form>";
/**/			}
			"</tr>";
			$paidQ = 'paid'.$billRows['number'];
			$unpaidQ = 'un'.$paidQ;
			if(ISSET($_POST[$paidQ])){
				paid($billRows['number'], 'true');
				reloadPHP();
			}
			if(ISSET($_POST[$unpaidQ])){
				paid($billRows['number'], 'false');
				reloadPHP();
			}
		}
	}
	mysql_free_result($billsR);
	echo "</td></tr></table>";
}?>
