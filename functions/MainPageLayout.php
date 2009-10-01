<?php function mainPage($page,&$accounttype,&$accounts,&$accounts2,&$accounts3)
{
	
	$EditAccount = $page ? true : false;
	
	echo "<div id=\"Main\">"
		."<table border=3 class=\"t1\">\n"
		."<tr>";
	
	ShowColumn("left", $page, &$accounttype, &$accounts, &$accounts2, &$accounts3)));
	ShowColumn("right",$page, &$accounttype, &$accounts, &$accounts2, &$accounts3)));
	
	echo "</tr>\n"
		."</table>";
}

function ShowColum($columnSide, $page, &$accounttype, &$accounts, &$accounts2, &$accounts3))
{
	if ($columnSide == "left")
	{
		$leftColumn = true;
		$sides = 1;
	}
	else if ($columnSide == "right")
	{
		$leftColumn = false;
		$sides = -1;
	}
	echo "\n    <td align=center>\n      ";

	echo "<table>\n";
	
	$index=0;
	while($accounttype[$index])
	{
	
	$ValidAccountForThisPage = false;
	if ($columnSide == "left")
		ValidAccountForThisPage = firstColumn($accounttype[$index], -$page-$sides))
	else
		ValidAccountForThisPage	= secondColumn($accounttype[$index], -$page-$sides))
	
		if(ValidAccountForThisPage)
		{
			echo "  <tr>" . "\n    <td>";
			if($EditAccount){
				echo "</td><td>";
			}
			echo "<u><B>" . $accounttype[$index]
				. " Accounts</B></u></td>" . "\n";
			$qAcc = " SELECT number FROM `".PREFIX.ACCOUNTS."` "
				. "WHERE `Type` = CONVERT( _utf8 '" . $accounttype[$index]."' "
				. "USING latin1 ) COLLATE latin1_swedish_ci LIMIT 0 , 30";
			$rAcc = mysql_query($qAcc)
				or die("Error in query: line 17 $qAcc" . mysql_error());
			if($accounttype[$index]== "Credit Card")
				{balanceRemaining($accounts[$index]);}
			echo "\n  </tr>";
			if (mysql_num_rows($rAcc) > 0){
				while($rowAcc = mysql_fetch_row($rAcc)){
					$j=$rowAcc[0];
					echo "\n  <tr>";
					
					if($EditAccount){
						echo "<form action=\"" . $_SERVER['PHP_SELF']. "?page=". $page
							. "\" method=\"post\">\n    <td><input type=\"submit\" name=\""
							. $j."\" value=\"edit" . "\">" . "</td>\n    </form>";	
					}
					echo "\n    <td><li><a href =\"". $_SERVER['PHP_SELF'] ."?page="
						. $j . "\"><span>". $accounts[$j] . "</span></a></li></td>";

					if($accounttype[$index]== "Loan")
						$CurrentFunds[$j] = currentAmount($j,$leftColumn) * -$sides;
					else
						$CurrentFunds[$j] = currentAmount($j,!$leftColumn) *$sides;

					echo "\n    <td width=75px align=right>";
					echo "<div";
					if($CurrentFunds[$j]<0){echo " id=\"negative\"";}
					printf(">%.2f</div></td>\n",$CurrentFunds[$j]);
					if($accounttype[$index]== "Credit Card")
						{balanceRemaining($accounts2[$j],$CurrentFunds[$j] ,true);}
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
			}else{echo "<b>Error Line 37 $resultAccount</b>";}
			mysql_free_result($rAcc);
		}
		$index++;
	}
	echo "</table>";
	echo"</td>";
	echo "</div>";
}
?>