<?php function totals(&$all_Accounts, &$connection)
{
	echo "<div id=\"Totals\">\n"
			. "  <ul>\n"
			. "    <li class=\"hdr_ex\">&nbsp;</li>\n"
			. "    <li class=\"hdr\">Type Total</li>\n"
			. "    <li class=\"hdr\">Total</li>\n";

	$total = 0;
	foreach($all_Accounts as $accountGroup)
	{
		$type = $accountGroup->type;
		if (($type != "Expense") &&
			($type != "Income") &&
			($type != "removed")&&
			($type != "Loan"))
		{
			
			$accountGroupTotal = 0;
			foreach ($accountGroup->accounts as $acct)
			{
				$accountGroupTotal += round(Queries::currentAmount($connection, $acct->number), 2);
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
	echo "  <li class=\"name\">&nbsp</li>\n";
	echo  "  <li class=\"funds\">&nbsp</li>\n";
	$neg = ($total < 0) ? " negative" : ""; 

	echo  "  <li class=\"funds$neg\">"
		. $total . "</li>\n";
	foreach($all_Accounts as $accountGroup)
	{
		$type = $accountGroup->type;
		if (($type == "Loan"))
		{
			foreach($accountGroup->accounts as $acct)
			{
				if ($acct->name == "Mortgage Escrow") continue;
				echo "  <li class=\"name\">" . $acct->name . "</li>\n";
				$loanTotal = round(Queries::currentAmount($connection, $acct->number), 2);
				$neg = ($loanTotal < 0) ? " negative" : ""; 
				echo  "  <li class=\"funds$neg\">"
					. $loanTotal
					. "</li>\n";

				$total += round($loanTotal,2);
				$neg = ($total < 0) ? " negative" : ""; 

				echo  "  <li class=\"funds$neg\">"
					. $total . "</li>\n";
			}
			
		}
	}	
	
	echo "</ul>\n</div>";
}
?>
