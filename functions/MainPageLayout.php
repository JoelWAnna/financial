<?php function ShowMainPageColumn($_leftColumn, $_page, $accounttype, &$accounts)
{
	$page = $_page;
	$leftColumn = $_leftColumn;
	$EditAccount = $page ? true : false;

	$headerwritten = false;
	foreach($accounttype as $type)
	{
		if(validAccountforThisPage($type, $leftColumn, $page))
		{
			if (!$headerwritten)
			{
				$left = $leftColumn ? "leftColumn" : "rightColumn";
				echo  "<div id=\"" . $left . "\">\n" . "<ul>\n";
				$headerwritten = true;
			}
			if($EditAccount)
			{
				echo "<li class=\"small\"></li>\n";
			}

			echo "<li class=\"AccountHDR\">"
				. $type . " Accounts</li>\n";

			echo "<li class=\"empty\">&nbsp;</li>\n";

			if($type== "Credit Card")
			{
				balanceRemainingHeader();
			}
			else if ($leftColumn)
			{
				echo  "<li class=\"empty\">&nbsp;</li>\n"
					. "<li class=\"empty\">&nbsp;</li>\n";
			}

			foreach($accounts as $acct)
			{
				if ($acct->type != $type)
					continue;

				$CurrentAccountNumber = $acct->number;

				if($EditAccount)
				{
					$disable = userIsAdmin() ? "" : "disabled='disabled'";
					echo "<form action=\"" . $_SERVER['PHP_SELF']
						. "?page=" . $page . "\" method=\"post\">"
						. "<input type=\"submit\" name=\"" . $CurrentAccountNumber . "\" value=\"edit\" $disable >";
				}

				echo  "\n    <li class=\"accountname\">"
					. "<a href =\"" . $_SERVER['PHP_SELF'] . "?page=" . $CurrentAccountNumber . "\">"
					. $acct->name
					. "</a>" . "</li>\n";

				if($type == "Income")
					$CurrentFunds[$CurrentAccountNumber] = round(currentAmount($CurrentAccountNumber, $leftColumn) * ($leftColumn ? -1 : 1), 2);
				else
					$CurrentFunds[$CurrentAccountNumber] = round(currentAmount($CurrentAccountNumber, !$leftColumn) * ($leftColumn ? 1 : -1), 2);

				$neg = ($CurrentFunds[$CurrentAccountNumber]<0) ? " negative" : ""; 

				echo  "  <li class=\"funds$neg\">";
				printf("%.2f</li>\n", $CurrentFunds[$CurrentAccountNumber]);
				if($type == "Credit Card")
				{
					balanceRemaining($acct->name, $CurrentFunds[$CurrentAccountNumber]);
				}
				else if ($leftColumn)
				{
					echo  "<li class=\"empty\">&nbsp;</li>\n"
						. "<li class=\"empty\">&nbsp;</li>\n";
				}
				if(isset($_POST[$CurrentAccountNumber]))
				{
					editAcc($CurrentAccountNumber, $accounttype);
				}
				$foo = "account" . $CurrentAccountNumber;
				if(isset($_POST[$foo]))
				{
					if(submitAcc($CurrentAccountNumber))
					{
						reloadPHP();
					}
				}
			}
		}
	}
	echo "</ul></div>";
}
?>
