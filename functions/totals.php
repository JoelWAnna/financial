<?php function totals(&$all_Accounts)
{
	$headerwritten = false;
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
			$total = 0;
			foreach ($accountGroup->accounts as $acct)
			{
				$total += currentAmount($acct->number);
			}
			if($total > 0)
			{
				echo "  <li class=\"name\">" . $type . "</li>\n";

				$neg = ($total < 0) ? " negative" : ""; 

				echo  "  <li class=\"funds$neg\">"
					. $total
					. "</li>\n";


				$total = round($total,2);
				if($total<0)
				{
					echo "<li class=\"fundsneg\">";
				}
				else
				{
					echo "<li class=\"funds\">";
				}

				echo $total;
				echo "</li>";
			}
		}
	}
	echo "</ul>\n</div>";
}
?>
