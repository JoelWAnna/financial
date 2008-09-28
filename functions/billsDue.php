<?php function billsDue(&$accounts,$allbills){
	$billsQ = 'SELECT * FROM `'.PREFIX.BILLS.'` ';
/**/	if(!$allbills){
/**/		$billsQ .= "WHERE `paid` = CONVERT(_utf8 'FALSE' "
/**/				. "USING latin1) COLLATE latin1_swedish_ci";
/**/	} // width=19%    align=LEFT
	echo "<table border=3>";
	$billsQ .= " ORDER BY `".PREFIX.BILLS."`.`month`, `".PREFIX.BILLS."`.`day`, `".PREFIX.BILLS."`.`year` ASC";
	
	static $total = 0;
	$billsR = mysql_query($billsQ)
		or die("Error in query: $billsQ." . mysql_error());
	if (mysql_num_rows($billsR) > 0){
		while($billRows = mysql_fetch_assoc($billsR)){
			echo "\n  <tr align=left><td";
			if($allbills){
			echo " colspan=2";
			}
			echo "><font size=2>";
			if($billRows['to account'] > 0){
				echo $accounts[$billRows['to account']];
			}
			else {
				echo $billRows['description'];
			}
			echo "</td>\n    <td align=right width=15%><font size=2>";
			
			$temp = $billRows['amount'];
			$total += $temp;
			echo $temp;
		
			echo "&nbsp</td></tr><tr>". "\n    <td align=right><font size=2>"
			. $billRows['month'] . "/" 
			. $billRows['day']. "/"
			. $billRows['year'] . "</td>";
			echo "\n    "
			. "<form action=\"" . $_SERVER['PHP_SELF']. "\" method=\"post\">"
			. "\n      <td width=10><input type=\"submit\" fontsize=2 name=\"paid" . $billRows['number'] . "\" value=\"Paid\""
			." style=\"height: 1.5em; width: 3em\">"
			. "</td>\n    </form>";
/**/			if($allbills){
/**/				echo "\n    <form action=\"" . $_SERVER['PHP_SELF']. "?page=-1\" method=\"post\">"
/**/					. "\n      <td><input type=\"submit\" name=\"unpaid" . $billRows['number'] . "\" "
/**/					. "value=\"Not paid\"  style=\"height: 1.5em; width: 4.5em\"></td>\n    </form>";
/**/			}
			echo "\n  </tr>";
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
	if($allbills){
		echo "<tr><td colspan=2></td>";
	}else{echo "<tr><td></td>";}
	printf("<td align=right><font size=2>%.2f&nbsp </td><td></td></tr></table>\n",$total);

}?>
