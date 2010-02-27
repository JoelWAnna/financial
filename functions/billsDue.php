<?php function billsDue($allbills, &$accounts)
{
	$billsQ = 'SELECT * FROM `'.PREFIX.BILLS.'` ';
	if (!$allbills)
	{
		$billsQ .= "WHERE `paid` = CONVERT(_utf8 'FALSE' "
				. "USING latin1) COLLATE latin1_swedish_ci";
	}
	
	$billsQ .= " ORDER BY `" . PREFIX . BILLS . "`.`month`, `" . PREFIX
			. BILLS . "`.`day`, `" . PREFIX . BILLS . "`.`year` ASC";
	
	static $total = 0;
	
	$billsR = mysql_query($billsQ)
				or die("Error in query: $billsQ." . mysql_error());
				
	if (mysql_num_rows($billsR) > 0)
	{
?>
		<div id="Bills">
		<ul>
		<li class="hdr1">Account</li>
		<li class="hdr2">Date</li>
		<li class="hdr3">Amount</li>
		<li class="_hdr">&nbsp;</li>
<?php
		if ($allbills)
		{
			echo "<li class=\"_hdr\">&nbsp;</li>\n";
		}
		while ($billRows = mysql_fetch_assoc($billsR))
		{	

				
			echo  "<li class=\"ent1\">"
				. "<a href=\"" . $_SERVER['PHP_SELF'] . "?page=" . $billRows['to account'] . "\">";
			if ($billRows['to account'] > 0)
			{
				echo $accounts[$billRows['to account']];
			}
			else
			{
				echo $billRows['description'];
			}
			echo  "</a></li>\n";
			
			echo "\n <li class=\"ent2\">"
				. $billRows['month'] . "/" 
				. $billRows['day']. "/"
				. $billRows['year'] . "</li>";
			
			$temp = $billRows['amount'];
			$total += $temp;
			echo  "<li class=\"ent3\">" . $temp . "&nbsp </li>\n";
		


			echo "\n"
				. "<li>"
				. "<form action=\"" . $_SERVER['PHP_SELF']. "\" method=\"post\">"
				. "\n      <input type=\"submit\"name=\"paid"
				. $billRows['number'] . "\" value=\"Paid\""
			." >\n    </form></li>";

			if ($allbills)
			{
				echo "\n    <li><form action=\"" . $_SERVER['PHP_SELF']. "?page=-1\""
					. " method=\"post\">\n      <input type=\"submit\" name="
					. "\"unpaid" . $billRows['number'] . "\" value=\"Not paid\""
					. "  style=\" width: 4.5em\">\n    </form></li>";
			}
			$paidQ = 'paid'.$billRows['number'];
			$unpaidQ = 'un'.$paidQ;
			if (ISSET($_POST[$paidQ]))
			{
				paid($billRows['number'], 'true');
				reloadPHP();
			}
			if (ISSET($_POST[$unpaidQ]))
			{
				paid($billRows['number'], 'false');
				reloadPHP();
			}
		}
		echo "<li class=\"ftr\">Total</li>";
		echo "<li class=\"ent\">";
		printf("%.2f&nbsp",$total);
		echo "</li></ul>\n</div>";
	}
	mysql_free_result($billsR);

	
}
?>

