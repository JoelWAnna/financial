<?php function totals(&$accounts,&$accounts3,&$accounttype){
echo "<table border=3 width=49% height=28.5% align=LEFT>";
for($index=0;$index < 100; $index++){
	
	$acc[$accounttype[$index]] =0;
		for($F=0;$F<20;$F++){
			if($accounts3[$F]==$accounttype[$index]){
				$acc[$accounttype[$index]] += currentAmount($F);
			}	
		}
		if($acc[$accounttype[$index]]){
			$total += $acc[$accounttype[$index]];
			negativeRed($acc[$accounttype[$index]]);
		?><tr><td align=center><?

		echo $acc[$accounttype[$index]];
	
		?></td><td align=center><?
		negativeRed($total);
	   echo $total;
	   ?></td></font></tr><?
	}
}
?>
</table>
<?






/* 

	$billsQ = 'SELECT * FROM `'.PREFIX.BILLS.'` ';
/**	if(!$allbills){
/**		$billsQ .= "WHERE `paid` = CONVERT(_utf8 'FALSE' "
/**				. "USING latin1) COLLATE latin1_swedish_ci";
/**	}
	echo "<table border=3 width=49% align=LEFT>";
	$billsQ .= " ORDER BY `".PREFIX.BILLS."`.`month`, `".PREFIX.BILLS."`.`day`, `".PREFIX.BILLS."`.`year` ASC";
	
	static $total = 0;
	$billsR = mysql_query($billsQ)
		or die("Error in query: $billsQ." . mysql_error());
	if (mysql_num_rows($billsR) > 0){
		while($billRows = mysql_fetch_assoc($billsR)){
			echo "\n  <tr align=center>" . "\n    <td>"
			. $billRows['month'] . "/" 
			. $billRows['day']. "/"
			. $billRows['year'] . "</td>"
			. "\n    <td>";
			if($billRows['to account'] > 0){
				echo $accounts[$billRows['to account']];
			}
			else {
				echo $billRows['description'];
				}
			echo "</td>"."\n    <td>";
			$temp = $billRows['amount'];
			$total += $temp;
			echo $temp;
			echo "</td>"."\n    "
			. "<form action=\"" . $_SERVER['PHP_SELF']. "\" method=\"post\">"
			. "\n      <td><input type=\"submit\" name=\"paid" . $billRows['number'] . "\" value=\"Paid\">"
			. "</td>\n    </form>";
/**			if($allbills){
/**				echo "\n    <form action=\"" . $_SERVER['PHP_SELF']. "?page=-1\" method=\"post\">"
/**					. "\n      <td><input type=\"submit\" name=\"unpaid" . $billRows['number'] . "\" "
/**					. "value=\"Not paid\"></td>\n    </form>";
/**			}
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
	printf("<tr><td colspan=2></td<td>%.2f</td><td></td></tr></table>\n",$total);
 */
}?>
