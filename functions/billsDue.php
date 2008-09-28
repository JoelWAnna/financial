<?php function billsDue(&$accounts,$allbills){
	$billsQ = 'SELECT * FROM `'.PREFIX.BILLS.'` ';
/**/	if(!$allbills){
/**/		$billsQ .= "WHERE `paid` = CONVERT(_utf8 'FALSE' "
/**/				. "USING latin1) COLLATE latin1_swedish_ci";
/**/	} // width=19%    align=LEFT
?>
<div class="Bills">
<?
	echo "<table border>";
	$billsQ .= " ORDER BY `".PREFIX.BILLS."`.`month`, `".PREFIX.BILLS."`.`day`, `".PREFIX.BILLS."`.`year` ASC";
	
	static $total = 0;
	$billsR = mysql_query($billsQ)
		or die("Error in query: $billsQ." . mysql_error());
	if (mysql_num_rows($billsR) > 0){
		while($billRows = mysql_fetch_assoc($billsR)){
			echo "\n  <tr><td";
			if($allbills){
			echo "colspan=2";
			}
			echo ">";
			if($billRows['to account'] > 0){
				echo $accounts[$billRows['to account']];
			}
			else {
				echo $billRows['description'];
			}
			echo "</td>\n    <td width=15%><li>";
			
			$temp = $billRows['amount'];
			$total += $temp;
			echo $temp;
		
			echo "&nbsp </li></td></tr><tr>". "\n    <td><li>"
			. $billRows['month'] . "/" 
			. $billRows['day']. "/"
			. $billRows['year'] . "</li></td>";
			echo "\n    "
			. "<form action=\"" . $_SERVER['PHP_SELF']. "\" method=\"post\">"
			. "\n      <td width=10><input type=\"submit\"name=\"paid" . $billRows['number'] . "\" value=\"Paid\""
			." >"
			. "</td>\n    </form>";
/**/			if($allbills){
/**/				echo "\n    <form action=\"" . $_SERVER['PHP_SELF']. "?page=-1\" method=\"post\">"
/**/					. "\n      <td><input type=\"submit\" name=\"unpaid" . $billRows['number'] . "\" "
/**/					. "value=\"Not paid\"  style=\" width: 4.5em\"></td>\n    </form>";
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
	?><tr><td
	<?
	if($allbills){	echo " colspan=2";	}
	echo "></td>";	
	printf("<td align=right>%.2f&nbsp </td><td></td></tr></table>\n",$total);
?></div><?
}?>
