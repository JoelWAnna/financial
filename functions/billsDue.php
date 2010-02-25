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
		echo "<div id=\"Bills\">\n";
	
		echo  "<ul><li class=\"hdr\">Account</li>"
			. "<li class=\"hdr\">Amount</li>"
			. "<li class=\"hdr2\">&nbsp;   Date   &nbsp;</li>";
		while ($billRows = mysql_fetch_assoc($billsR))
		{	
			echo  "<li class=\"ent\">";
			if ($billRows['to account'] > 0)
			{
				echo $accounts[$billRows['to account']];
			}
			else
			{
				echo $billRows['description'];
			}
			echo  "</li>\n";
			$temp = $billRows['amount'];
			$total += $temp;
			echo  "<li class=\"ent\">" . $temp . "&nbsp </li>\n";
		
			echo "\n <li class=\"ent2\">"
				. $billRows['month'] . "/" 
				. $billRows['day']. "/"
				. $billRows['year'] . "</li>"
				. "\n    "
				. "<form action=\"" . $_SERVER['PHP_SELF']. "\" method=\"post\">"
				. "\n      <li class=\"ent\"><input type=\"submit\"name=\"paid"
				. $billRows['number'] . "\" value=\"Paid\""
			." ></li>\n    </form>";
				
			if ($allbills)
			{
				echo "\n    <form action=\"" . $_SERVER['PHP_SELF']. "?page=-1\""
					. " method=\"post\">\n      <td><input type=\"submit\" name="
					. "\"unpaid" . $billRows['number'] . "\" value=\"Not paid\""
					. "  style=\" width: 4.5em\"></td>\n    </form>";
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

		printf("<li class=\"ent\">%.2f&nbsp </li></ul>\n</div>",$total);
	}
	mysql_free_result($billsR);

	
}
?>

