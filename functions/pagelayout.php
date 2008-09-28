<?php function pagelayout($page,&$accounttype,&$accounts,&$accounts2,&$accounts3){
//Main Page
	$months = array(0,Jan,Feb,Mar,Apr,
					May,June,July,Aug,
					Sep,Oct,Nov,Dec);
	$tdform = "\n    <td";
	$tdformat2 = "</td>".$tdform;
	$tdformat = $tdformat2.">";
	$w = " width=";

	if($page < 1){
	$i=0;
	billsDue($accounts,$page);	totals($accounts,$accounts3,$accounttype);
	$total =0;
	echo "<br><table width=98% border=3>";
	echo"\n  <tr>";
	$tor = false;
for($p=2;$p;$p--){
	$index=0;
	$tor = !$tor;
	echo "\n    <td align=center width=48%>\n      ";
	echo "<table>\n";
	while($accounttype[$index]){
 		$go=false;
		if($accounttype[$index]!= "removed"){
			if($tor){
			
				if(($accounttype[$index]== "Checking")| ($accounttype[$index]== "Savings")
				| ($accounttype[$index]== "Credit Card")| ($accounttype[$index]== "Loan"))
				{$go=true;}
			}else{
				if(($accounttype[$index]!= "Checking")
					& ($accounttype[$index]!= "Savings")
					& ($accounttype[$index]!= "Credit Card")
					& ($accounttype[$index]!= "Loan"))
				{$go=true;}
			}
		} 		
		if($go){
			echo "  <tr>" . $tdform . "><u><B>" . $accounttype[$index]
				. " Accounts</B></u></td>" . $tdform . ">\n";
	/*		if($tor){
/*/////////////		$acc[$accounttype[$index]] =0;
/*/////////////		for($F=0;$F<20;$F++){
/*/////////////			if($accounts3[$F]==$accounttype[$index]){
/*/////////////				$acc[$accounttype[$index]] += currentAmount($F);
/*/////////////			}	
/*/////////////		}
/*/////////////		if($acc[$accounttype[$index]]){
/*/////////////			$total += $acc[$accounttype[$index]];
/*/////////////			negativeRed($acc[$accounttype[$index]]);
/*/////////////			echo $acc[$accounttype[$index]];
/*/////////////	
/*/////////////		echo "</td><td>";
/*/////////////		negativeRed($total);
/*/////////////		echo"$total</td>";
/*/////////////		}
/*/////////////	}	*/
		$queryAccount = " SELECT number FROM `".PREFIX.ACCOUNTS."` "
				. "WHERE `Type` = CONVERT( _utf8 '"
				. $accounttype[$index]."' "
				. "USING latin1 ) COLLATE latin1_swedish_ci LIMIT 0 , 30";
		$resultAccount = mysql_query($queryAccount)
			or die('Error in query: line 66.' . mysql_error());
/*/////////////*/if($tor){	
/*/////////////*/	if($accounttype[$index]== "Credit Card"){
/*/////////////*/		balanceRemaining($accounts[$index]);
/*/////////////*/	}
/*/////////////*/	echo "\n  </tr>";
/*/////////////*/}
		if (mysql_num_rows($resultAccount) > 0){
			while($rowAcc = mysql_fetch_row($resultAccount)){
				$j=$rowAcc[0];
				echo "\n  <tr>"
					. $tdform .">"
					."<lis><a href =\"". $_SERVER['PHP_SELF'] ."?page="
					. $j . "\"><span>"
					. $accounts[$j] . "</span></a></lis>"
					."</td>";
					if($tor){
						$CurrentFunds[$j] = currentAmount($j);
					}else{
						$e=true;
						$CurrentFunds[$j] = -currentAmount($j,$e);
					}
				echo $tdform . " width=75px align=right>";
				negativeRed($CurrentFunds[$j]);
				printf("%.2f</td>\n",$CurrentFunds[$j]);
/*/////////////*/if($tor){
/*/////////////*/		if($accounttype[$index]== "Credit Card"){
/*/////////////*/			balanceRemaining($accounts2[$j],$CurrentFunds[$j] ,true);
/*/////////////*/		}
/*/////////////*/}
				echo "\n  </tr>\n";		
			}
		}else{
			echo "<b>Error Line 97 $resultAccount</b>";
		}
		mysql_free_result($result);
		}
		$index++;
	}
/*/////////////*/	if($tor){
/*/////////////*/		echo "</table>";
/*/////////////*/		echo "</td>";
/*/////////////*/	}
}
	
	
	
	echo "</td></tr></table></table>";
	newTR(0,$accounts);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else{/////////////PAGE  > 0
	$new = newest('trans');
	$X = "X";
	$X .= $new;
	if (isset($_POST[$X])){
		if(submitItem('trans',$new)){
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
			editItem('trans',$page,$accounts,$new,true);
		}
	}

	$CurrentAm= currentAmount($page);

	$queryAcc = " SELECT * FROM `".PREFIX.TRANSACTIONS."` WHERE `From Account` ="
			. $page." OR `To Account` =".$page." ORDER BY `".PREFIX.TRANSACTIONS."`.`year` DESC, `"
			.PREFIX.TRANSACTIONS."`.`month` DESC, `".PREFIX.TRANSACTIONS
			."`.`day` DESC";
 
	$resultAcc = mysql_query($queryAcc)
		or die('Error in query: $queryAcc.' . mysql_error());
	
	if (mysql_num_rows($resultAcc) > 0){
		while($rowdata = mysql_fetch_assoc($resultAcc)){

			
			$X = "X";
			$X .= $rowdata['number'];
			if (isset($_POST[$X])){
				if(submitItem('trans',$rowdata['number'])){
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
				printf("%.2f",$CurrentAm);
				$CurrentAm += $rowdata['amount'];
			}
			
			else{
				$CurrentAm =round($CurrentAm,2);
				negativeRed($CurrentAm);
				printf("%.2f",$CurrentAm);
				$CurrentAm	-= $rowdata['amount'];
			}
			
			echo "</td>\n    ";
			echo "<form action=\"" . $_SERVER['PHP_SELF']. "?page=". $page 
				. "\" method=\"post\">".  $tdform. "><input type=\"submit\" name=\""
				. $rowdata['number']."\" value=\"". "Edit transaction " . $rowdata['number']
				. " \">" . "</td>\n    </form>";
			echo "\n  </tr>";
			
			if (isset($_POST[$rowdata['number']])){
				editItem('trans',$page,$accounts,$rowdata['number'],false,false,
						(int)$rowdata['month'],$rowdata['day'],$rowdata['year'],
						$rowdata['description'],$rowdata['from account'],
						$rowdata['to account'],$rowdata['amount']);
			}
		}
	}else{echo '<b>Error No transactions found</b>';}
	echo "\n</table>";
		mysql_free_result($resultAcc);
	}
	
	

}
?>