<?php function ShowMainPageColumn($_leftColumn, $_page, &$all_Accounts, &$connection)
{
	$page = $_page;
	$leftColumn = $_leftColumn;
	$EditAccount = $page ? true : false;

	$headerwritten = false;
	foreach($all_Accounts as $accountGroup)
	{
		if(validAccountforThisPage($accountGroup->type, $leftColumn, $page))
		{
			if (!$headerwritten)
			{
				$left = $leftColumn ? "left" : "right";
				$left .= "accountcolumn";
				echo  "<div id=\"" . $left . "Wrapper\">\n";
				echo  "<div id=\"" . $left . "\">\n" . "<ul>\n";
				$headerwritten = true;
			}
			if($EditAccount)
			{
				echo "<li class=\"small\"></li>\n";
			}

			echo "<li class=\"AccountHDR\">"
				. $accountGroup->type . " Accounts</li>\n";

			echo "<li class=\"empty\">&nbsp;</li>\n";

			if($accountGroup->type== "Credit Card")
			{
				balanceRemainingHeader();
			}
			else if ($leftColumn)
			{
				echo  "<li class=\"empty\">&nbsp;</li>\n"
					. "<li class=\"empty\">&nbsp;</li>\n";
			}

			foreach($accountGroup->accounts as $acct)
			{
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
                    // TODO fixme 
					. substr($acct->name, 0, 26)
					. "</a>" . "</li>\n";

				if($accountGroup->type == "Income")
					$CurrentFunds[$CurrentAccountNumber] = round(currentAmount($connection, $CurrentAccountNumber, $leftColumn) * ($leftColumn ? -1 : 1), 2);
				else
					$CurrentFunds[$CurrentAccountNumber] = round(currentAmount($connection, $CurrentAccountNumber, !$leftColumn) * ($leftColumn ? 1 : -1), 2);

				$neg = ($CurrentFunds[$CurrentAccountNumber]<0) ? " negative" : ""; 

				echo  "  <li class=\"funds$neg\">";
				printf("%.2f</li>\n", $CurrentFunds[$CurrentAccountNumber]);
				if($accountGroup->type == "Credit Card")
				{
					balanceRemaining($acct, $CurrentFunds[$CurrentAccountNumber], $connection);
				}
				else if ($leftColumn)
				{
					echo  "<li class=\"empty\">&nbsp;</li>\n"
						. "<li class=\"empty\">&nbsp;</li>\n";
				}
				if(isset($_POST[$CurrentAccountNumber]))
				{
					editAcc($CurrentAccountNumber, $all_Accounts);
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
	echo "</ul></div></div>";
}
?>
