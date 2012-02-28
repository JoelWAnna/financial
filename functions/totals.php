<?php function totals(&$all_Accounts)
{
	$headerwritten = false;
	$total = 0;
	foreach($all_Accounts as $accountGroup)
	{
		$type = $accountGroup->type;
		if (($type != "Expense") &&
			($type != "Income") &&
			($type != "removed")&&
			($type != "Loan"))
		{
			if (!$headerwritten)
			{
			echo "<div id=\"Totals\">\n"
				. "  <ul>\n"
				. "    <li class=\"hdr_ex\">&nbsp;</li>\n"
				. "    <li class=\"hdr\">SubTotal</li>\n"
				. "    <li class=\"hdr\">Total</li>\n";
				$headerwritten=true;
			}
			$accountGroupTotal = 0;
			foreach ($accountGroup->accounts as $acct)
			{
				$accountGroupTotal += round(currentAmount($acct->number), 2);
			}
			echo "  <li class=\"name\">" . $type . "</li>\n";

			$neg = ($accountGroupTotal < 0) ? " negative" : ""; 

			echo  "  <li class=\"funds$neg\">"
				. $accountGroupTotal
				. "</li>\n";

			$total += round($accountGroupTotal,2);
			$neg = ($total < 0) ? " negative" : ""; 

			echo  "  <li class=\"funds$neg\">"
				. $total . "</li>\n";
		}
	}
	echo "</ul>\n</div>";
}
?>
