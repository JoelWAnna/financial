<?php function ShowMainPageColumn($leftColumn, $page, &$accounttype, &$accounts, &$accounts2, &$accounts3))
{
	$EditAccount = $page ? true : false;
	echo "\n    <td align=center>\n      "
		."      <table>\n";	

	for($index = 0; $accounttype[$index]; $index++)
	{
		if(validAccountforThisPage($accounttype[$index], $leftColumn, $page))
		{
			echo  "  <tr>\n"
				. "    <td>";

			if($EditAccount){
				echo "</td>\n    <td>";
			}

			echo  "<u><B>"
				. $accounttype[$index] . " Accounts"
				. "</B></u>"
				. "</td>\n";
			if($accounttype[$index]== "Credit Card")
			{
				balanceRemainingHeader();
			}
			echo "\n  </tr>";

			$AQuery = " SELECT number FROM `".PREFIX.ACCOUNTS."` "
					. "WHERE `Type` = CONVERT( _utf8 '$accounttype[$index]'"
					. "USING latin1 ) COLLATE latin1_swedish_ci LIMIT 0 , 30";

			$rAcc = mysql_query($AQuery)
				or die("Error in query: line 31 $AQuery" . mysql_error());


			
			
			if (mysql_num_rows($rAcc) > 0){
				while($rowAcc = mysql_fetch_row($rAcc)){
					$j=$rowAcc[0];
					echo "\n  <tr>";
					
					if($EditAccount){
						echo "<form action=\"" . $_SERVER['PHP_SELF']
							. "?page=$page\" method=\"post\">"
							. "\n    <td>"
							. "<input type=\"submit\" name=\"$j\" value=\"edit\">"
							. "</td>\n    </form>";	
					}
					echo  "\n    <td><li>"
						. "<a href =\"" . $_SERVER['PHP_SELF'] . "?page=$j\">"
						. "<span>" . $accounts[$j] . "</span>"
						. "</a>"
						. "</li></td>";

					if($accounttype[$index]== "Loan")
						$CurrentFunds[$j] = currentAmount($j,$leftColumn) * ($leftColumn ? -1 : 1);
					else
						$CurrentFunds[$j] = currentAmount($j,!$leftColumn) * ($leftColumn ? 1 : -1);

					echo "\n    <td width=75px align=right>";
					
					
					if($CurrentFunds[$j]<0)
					{
						echo "<div id=\"negative\">";
					}
					else
					{
						echo "<div>";
					}
					printf("%.2f</div></td>\n", $CurrentFunds[$j]);
					if($accounttype[$index]== "Credit Card")
						{balanceRemaining($accounts2[$j],$CurrentFunds[$j]);}
					if(isset($_POST[$j])){
						echo "</tr><tr>";
						editAcc($j,$accounttype);
						echo "</tr><tr>";
					}
					$foo = "account" . $j;
					if(isset($_POST[$foo])){
						if(submitAcc($j)){
						reloadPHP();
						}
					}
					echo "\n  </tr>\n";		
				}
			}else{echo "<b>Error Line 98 $resultAccount</b>";}
			mysql_free_result($rAcc);
		}
	}
	echo "</table>";
	echo"</td>";
	echo "</div>";
}
?>