<?php function mainPage($page,&$accounttype,&$accounts,&$accounts2,&$accounts3){
	?><?$tor = false;$a= "left";
	echo "<div id=\"Main\"><table border=3 class=\"t1\">\n  <tr>";
	for($sides=1;$sides !=-3;$sides -=2){ //LEFT & RIGHT HAND SIDE, SETS WHETHER SIDE IS NEGATIVE OR POSITIVE
		$index=0;
		$tor = !$tor;
		echo "\n    <td align=center>\n      ";
		
		echo "<table>\n";
		while($accounttype[$index]){
			if(leftPage($accounttype[$index], $tor,-$page-$sides)){
				echo "  <tr>" . "\n    <td>";
				if($page){
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
						
						if($page){
							echo "<form action=\"" . $_SERVER['PHP_SELF']. "?page=". $page
								. "\" method=\"post\">\n    <td><input type=\"submit\" name=\""
								. $j."\" value=\"edit" . "\">" . "</td>\n    </form>";	
						}
						echo "\n    <td><li><a href =\"". $_SERVER['PHP_SELF'] ."?page="
							. $j . "\"><span>". $accounts[$j] . "</span></a></li></td>";
						if($accounttype[$index]== "Loan"){$tor = !$tor; $sides = -$sides;}
						$CurrentFunds[$j] = currentAmount($j,!$tor) *$sides;
						if($accounttype[$index]== "Loan"){$tor = !$tor;$sides = -$sides;}
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
		$a= "right";
	}
echo "</tr></table>";
}
?>