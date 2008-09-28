<?php function pagelayout($page,&$accounttype,&$accounts){
//Main Page
	$months = array(0,Jan,Feb,Mar,Apr,
					May,June,July,Aug,
					Sep,Oct,Nov,Dec);
	$tdform = "\n    <td";
	$tdformat2 = "</td>".$tdform;
	$tdformat = $tdformat2.">";
	$w = " width=";

	if($page <= 0){
	$page = -$page;
	$count=4;
	$i=0;
	$index=0;
	billsDue($accounts,$page);
	$page =0;
	echo "<table width=98% border=3>";
	
	echo"\n  <tr>\n    <td align=center width=48%>\n      ";
	echo "<table>\n";
	while($accounttype[$index]){
		if(($accounttype[$index]== "Checking")
			| ($accounttype[$index]== "Savings")
			| ($accounttype[$index]== "Credit Card")
			| ($accounttype[$index]== "Loan"))
		{
		echo "  <tr>" . $tdform . "><u><B>" . $accounttype[$index]
			. " Accounts</B></u></td>" . $tdform . ">\n";
		$queryAccount = " SELECT number FROM `".PREFIX.ACCOUNTS."` "
				. "WHERE `Type` = CONVERT( _utf8 '"
				. $accounttype[$index]."' "
				. "USING latin1 ) COLLATE latin1_swedish_ci LIMIT 0 , 30";
		$resultAccount = mysql_query($queryAccount)
			or die('Error in query: line 66.' . mysql_error());
		if($accounttype[$index]== "Credit Card"){
			balanceRemaining($accounts[$index]);
		}
		echo "\n  </tr>";
		if (mysql_num_rows($resultAccount) > 0){
			while($rowAcc = mysql_fetch_row($resultAccount)){
				$j=$rowAcc[0];
				echo "\n  <tr>"
					. $tdform .">"
					."<lis><a href =\"". $_SERVER['PHP_SELF'] ."?page="
					. $j . "\"><span>"
					. $accounts[$j] . "</span></a></lis>"
					."</td>";
					$CurrentFunds[$j] = currentAmount($j);
				echo $tdform . " width=75px align=right>";
				negativeRed($CurrentFunds[$j]);
				echo	$CurrentFunds[$j]. "\n    </td>\n";
				if($accounttype[$index]== "Credit Card"){
					balanceRemaining($accounts[$j],$CurrentFunds[$j] ,true);
				}
				echo "\n  </tr>\n";		
			}
		}else{
			echo '<b>Error Line 97</b>';
		}
		mysql_free_result($result);
		}
		$index++;
	}$index=0;
	echo "</table>";
	echo "</td><td align=center width=48%><table>";
	while($accounttype[$index]){
		if(($accounttype[$index]!= "Checking")
			& ($accounttype[$index]!= "Savings")
			& ($accounttype[$index]!= "Credit Card")
			& ($accounttype[$index]!= "Loan"))
		{ 
		echo "  <tr>" . $tdform . "><u><B>" . $accounttype[$index]
			. " Accounts</B></u></td>" . "\n  </tr>";
		$queryAccount = " SELECT number FROM `".PREFIX.ACCOUNTS."` "
				. "WHERE `Type` = CONVERT( _utf8 '"
				. $accounttype[$index]."' "
				. "USING latin1 ) COLLATE latin1_swedish_ci LIMIT 0 , 30";
		$resultAccount = mysql_query($queryAccount)
			or die('Error in query: line 66.' . mysql_error());
		
		if (mysql_num_rows($resultAccount) > 0){
			while($rowAcc = mysql_fetch_row($resultAccount)){
				$j=$rowAcc[0];
				echo "\n  <tr>"
					. $tdform .">"
					."<lis><a href =\"" . $_SERVER['PHP_SELF'] . "?page="
					. $j . "\"><span>"
					. $accounts[$j] . "</span></a></lis>"
					."</td>";
					$e=true;
					$CurrentFunds[$j] = -currentAmount($j,$e);
				echo $tdform . " width=75px align=right>";
				negativeRed($CurrentFunds[$j]);
				echo	$CurrentFunds[$j]. $tdform .">\n  </tr>\n";		
			}
		}else{
			echo '<b>Error Line 97</b>';
		}
		mysql_free_result($result);
		}
		$index++;
	}
	
	
	
	echo "</td></tr></table></table>";
	newTR($page,$accounts);
}
else{
	$new = newestTransaction();
	$X = "X";
	$X .= $new;
	if (isset($_POST[$X])){
		if(submitTransaction($new)){
			reloadPHP();
			unset($_POST[$X]);
		}
	}	
	echo "<a href=\"" . $_SERVER['PHP_SELF'] . "?page=0\">Back to main</a>";
	echo "<Br><B>".$accounts[$page]."</B>";
	echo "<table bordercolor=\"000\" border=2>\n  ";
	echo "<tr align=center>\n    <td width=165 colSpan=\"3\">date</td>"
		. $tdform.$w."142>description</td>"
		. $tdform.$w."145>from account</td>"
		. $tdform.$w."143>to account</td>"
		. $tdform.$w."50>amount</td>"
		. $tdform.$w."55>balance</td>"
		. "<form action=\"" . $_SERVER['PHP_SELF']
		. "?page=". $page ."\" method=\"post\">"
		. $tdform."><input type=\"submit\" "
		. "name=\"".$new."\" value=\""
		. "Start new transaction"
		. "\"></td></form>\n  </tr>";
	if($new > 0){
		if (isset($_POST[$new])){
			edittrans(false,$page,$accounts,$new,$new);
		}
	}

	$CurrentAm= currentAmount($page);

	$queryAcc = " SELECT * FROM `".PREFIX.TRANSACTIONS."` WHERE `From Account` ="
			. $page." OR `To Account` =".$page." ORDER BY `".PREFIX.TRANSACTIONS."`.`number` DESC";

	$resultAcc = mysql_query($queryAcc)
		or die('Error in query: $queryAcc.' . mysql_error());
	
	if (mysql_num_rows($resultAcc) > 0){
		while($rowdata = mysql_fetch_assoc($resultAcc)){

			
			$X = "X";
			$X .= $rowdata['number'];
			if (isset($_POST[$X])){
				if(submitTransaction($rowdata['number'])){
					reloadPHP();
				}
			unset($_POST[$X]);
			} 
			
			echo "\n  <tr align=center>" . $tdform . $w. "55>"
				. $months[(int)$rowdata['month']]. $tdformat2. $w. "50>"
				. $rowdata['day'] . $tdformat2. $w. "55>"
				. $rowdata['year'] . $tdformat
				. $rowdata['description'] . $tdformat
				. $accounts[$rowdata['from account']] . $tdformat
				. $accounts[$rowdata['to account']]	. $tdformat;
			
			if($rowdata['from account']==$page){
				negativeRed(-1);
				echo "-";
			}
			echo $rowdata['amount'];
			
			echo $tdformat;
			
			if($rowdata['from account']==$page){
				negativeRed($CurrentAm);
				echo $CurrentAm;
				$CurrentAm += $rowdata['amount'];
			}
			
			else{
				if(isZero($CurrentAm)){
					echo 0;
				}
				else{
					negativeRed($CurrentAm);
					echo $CurrentAm;
				}
				$CurrentAm	-= $rowdata['amount'];
			}
			
			echo "</td>\n    ";
			echo "<form action=\"" . $_SERVER['PHP_SELF']. "?page=". $page 
				. "\" method=\"post\">".  $tdform. "><input type=\"submit\" name=\""
				. $rowdata['number']."\" value=\"". "Edit transaction " . $rowdata['number']
				. " \">" . "</td>\n    </form>";
			echo "\n  </tr>";
			
			if (isset($_POST[$rowdata['number']])){
				edittrans(false,$page,$accounts,0,$rowdata['number'],(int)$rowdata['month'],
						$rowdata['day'],$rowdata['year'],
						$rowdata['description'],$rowdata['from account'],
						$rowdata['to account'],$rowdata['amount'],'poop');
			}
		}
	}else{echo '<b>Error No transactions found</b>';}
	echo "\n</table>";
		mysql_free_result($resultAcc);
	}
	
	

}
?>