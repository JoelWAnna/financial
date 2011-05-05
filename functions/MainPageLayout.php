<?php function ShowMainPageColumn($leftColumn, $page, &$accounttype, &$accounts, &$accounts2, &$accounts3)
{
	$EditAccount = $page ? true : false;

	$exit = true;
	for($index = 0; $exit && $accounttype[$index]; $index++)
	{
		if(validAccountforThisPage($accounttype[$index], $leftColumn, $page))
		{
			$left = $leftColumn ? "leftColumn" : "rightColumn";
			echo  "<div id=\"" . $left . "\">\n" . "<ul>\n";
			$exit = false;
		}
	}
	if ($exit) return;

	for($index = 0; $accounttype[$index]; $index++)
	{
		if(validAccountforThisPage($accounttype[$index], $leftColumn, $page))
		{
			if($EditAccount)
			{
				echo "<li class=\"small\"></li>\n";
			}

			echo "<li class=\"AccountHDR\">"
				. $accounttype[$index] . " Accounts</li>\n";

			echo "<li class=\"empty\">&nbsp;</li>\n";

			if($accounttype[$index]== "Credit Card")
			{
				balanceRemainingHeader();
			}
			else if ($leftColumn)
			{
				echo  "<li class=\"empty\">&nbsp;</li>\n"
					. "<li class=\"empty\">&nbsp;</li>\n";
			}

			$AQuery = " SELECT number FROM `".PREFIX.ACCOUNTS."` "
					. "WHERE `Type` = CONVERT( _utf8 '$accounttype[$index]'"
					. "USING latin1 ) COLLATE latin1_swedish_ci LIMIT 0 , 30";

			$rAcc = mysql_query($AQuery)
				or die("Error in query: line 31 $AQuery" . mysql_error());
			
			if (mysql_num_rows($rAcc) <= 0)
			{
				echo "<b>Error Line 47 $resultAccount</b>";
			}
			else
			{
				while($rowAcc = mysql_fetch_row($rAcc))
				{
					$j=$rowAcc[0];
					
					if($EditAccount)
					{
						$disable = userIsAdmin() ? "" : "disabled='disabled'";
						echo "<form action=\"" . $_SERVER['PHP_SELF']
							. "?page=$page\" method=\"post\">"
							. "<input type=\"submit\" name=\"$j\" value=\"edit\" $disable >";
					}

					echo  "\n    <li class=\"accountname\">"
						. "<a href =\"" . $_SERVER['PHP_SELF'] . "?page=$j\">"
						. $accounts[$j]
						. "</a>" . "</li>\n";

					if($accounttype[$index]== "Income")
						$CurrentFunds[$j] = round(currentAmount($j, $leftColumn) * ($leftColumn ? -1 : 1), 2);
					else
						$CurrentFunds[$j] = round(currentAmount($j, !$leftColumn) * ($leftColumn ? 1 : -1), 2);

					$neg = ($CurrentFunds[$j]<0) ? " negative" : ""; 

					echo  "  <li class=\"funds$neg\">";
					printf("%.2f</li>\n", $CurrentFunds[$j]);
					if($accounttype[$index]== "Credit Card")
					{
						balanceRemaining($accounts2[$j],$CurrentFunds[$j]);
					}
					else if ($leftColumn)
					{
						echo  "<li class=\"empty\">&nbsp;</li>\n"
							. "<li class=\"empty\">&nbsp;</li>\n";
					}
					if(isset($_POST[$j]))
					{
						editAcc($j,$accounttype);
					}
					$foo = "account" . $j;
					if(isset($_POST[$foo]))
					{
						if(submitAcc($j))
						{
							reloadPHP();
						}
					}
				}
			}
			mysql_free_result($rAcc);
		}
	}
	echo "</ul></div>";
}
?>
