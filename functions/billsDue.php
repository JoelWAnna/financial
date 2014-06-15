<?php function billsDue($allbills, &$all_Accounts, $months, $connection)
{
	$stmt = Queries::GetBills($allbills, $months, $connection);
	$stmt->execute();
	static $total = 0;
	if ($stmt->rowCount() > 0)
	{
		echo  "<div id=\"bills\">\n"
			. "  <ul>\n"
			. "    <li class=\"hdr1\">Account</li>\n"
		 	. "   <li class=\"hdr2\">Date</li>\n"
		 	. "   <li class=\"hdr3\">Amount</li>\n"
			. "    <li class=\"hdr_4\">&nbsp;</li>\n";

		if ($allbills)
		{
			echo "<li class=\"hdr_4\">&nbsp;</li>\n";
		}
		foreach ($stmt->fetchall() as $billRows)
		{


			echo  "<li class=\"ent1\">"
				. "<a href=\"" . $_SERVER['PHP_SELF'] . "?page=" . $billRows['to account'] . "\">";
			if ($billRows['to account'] > 0)
			{
				$toaccount = GetAccountByNumber($all_Accounts, $billRows['to account']);
				// TODO fixme 
				echo substr($toaccount->name, 0, 14);
			}
			else
			{
				echo $billRows['description'];
			}
			echo  "</a></li>\n";

			echo "\n <li class=\"ent2\">"
				. $billRows['month'] . "/" 
				. $billRows['day']   . "/"
				. $billRows['year']  . "</li>";

			$temp = $billRows['amount'];
			$total += $temp;
			echo  "<li class=\"ent3\">" . $temp . "</li>\n";


			$disable = userIsAdmin() ? "" : "disabled='disabled'";

			echo "\n"
				. "<li class=\"ent4\">"
				. "<form action=\"" . $_SERVER['PHP_SELF']. "\" method=\"post\">"
				. "\n      <input type=\"submit\"name=\"paid"
				. $billRows['number'] . "\" value=\"Paid\" $disable "
			." >\n    </form></li>";

			if ($allbills)
			{
				$disable = userIsAdmin() ? "" : "disabled='disabled'";
				echo "\n    <li class=\"ent4\"><form action=\"" . $_SERVER['PHP_SELF']. "?page=-1\""
					. " method=\"post\">\n      <input type=\"submit\" name="
					. "\"unpaid" . $billRows['number'] . "\" value=\"Not paid\""
					. "  style=\" width: 4.5em\" $disable >\n    </form></li>";
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
		echo "<li class=\"ftr_total\">";
		printf("%.2f", $total);
		echo "</li></ul>\n</div>";
	}
	//mysql_free_result($billsR);


}
?>

