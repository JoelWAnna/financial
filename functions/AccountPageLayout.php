<?php function AccountPageLayout($page,&$accounttype,&$accounts){
	// Main Page
	// ---------
	// $page cannot be less than 1
	echo  "<a href=\"" . $_SERVER['PHP_SELF'] . "?page=0\">Back to main</a><br>";
	if ($page < 1 || !$accounts[$page])
	{
		echo "No account found with id = $page";
		return;
	}
	$accountKey = $page;
	

	$months = array(0,Jan,Feb,Mar,Apr,
					May,June,July,Aug,
					Sep,Oct,Nov,Dec);

	$new = newest('transaction');
	$X = "X";
	$X .= $new;
	if (isset($_POST[$X])){
		if(submitItem('transaction',$new)){
			reloadPHP();
			unset($_POST[$X]);
		}
	}	
	echo  "<Br><B>".$accounts[$accountKey]."</B>";
	echo  "<table bordercolor=\"000\" border=2>\n  ";
	echo  "<tr align=center>\n"
		. "    <td width=165 colSpan=\"3\">date</td>\n"
		. "    <td width=142>description</td>\n"
		. "    <td width=145>from account</td>\n"
		. "    <td width=143>to account</td>\n"
		. "    <td width=50>amount</td>\n"
		. "    <td width=55>balance</td>\n\n";
	
	echo "    <form action=\""
		. $_SERVER['PHP_SELF']
		. "?page=". $accountKey
		. "\" method=\"post\">\n";

	echo  "    <td>"
		. "<input type=\"submit\" name=\"".$new."\""
		. "value=\"Start new transaction\"></td>\n"
		. "    </form>\n"
		. "</tr>";

	if($new > 0){
		if (isset($_POST[$new])){
			editItem('transaction',$accountKey,$accounts,$new,true);
		}
	}

	$CurrentAm= currentAmount($accountKey);

	$queryAcc = " SELECT * FROM `".PREFIX.TRANSACTIONS."` WHERE `From Account` ="
			. $accountKey." OR `To Account` =".$accountKey." ORDER BY `".PREFIX.TRANSACTIONS."`.`year` DESC, `"
			.PREFIX.TRANSACTIONS."`.`month` DESC, `".PREFIX.TRANSACTIONS
			."`.`day` DESC";
 
	$resultAcc = mysql_query($queryAcc)
		or die('Error in query: $queryAcc.' . mysql_error());
	
	if (mysql_num_rows($resultAcc) <= 0)
	{
		echo '<b> - No transactions found</b>';
	}
	else
	{
		while($rowdata = mysql_fetch_assoc($resultAcc)){

			
			$X = "X";
			$X .= $rowdata['number'];
			if (isset($_POST[$X])){
				if(submitItem('transaction',$rowdata['number'])){
					reloadPHP();
				}
			unset($_POST[$X]);
			} 
			
			echo "\n  <tr align=center>" . "\n    <td width=55>"
				. $months[(int)$rowdata['month']]. "</td>"."\n    <td". " width=". "50>"
				. $rowdata['day'] . "</td>"."\n    <td width=55>"
				. $rowdata['year'] . "</td>\n    <td>"
				. $rowdata['description'] . "</td>"."\n    <td".">"
				. $accounts[$rowdata['from account']] . "</td>"."\n    <td".">"
				. $accounts[$rowdata['to account']]	. "</td>"."\n    <td".">";
				
			$idFA = "positive\">";
			if ($rowdata['from account'] == $accountKey)
			{
				$idFA = "negative\">-";
			}
						
			echo "<div id=\"$idFA"
				. $rowdata['amount'];
			echo "</div>";
			
			echo "</td>\n    <td>";
			
			if ($rowdata['from account'] == $accountKey)
			{
				$idRD = "positive";
				if ($CurrentAm < 0)
				{
					$idRD = "negative";
				}
				echo "<div id=\"$idRD\">";
				printf("%.2f", $CurrentAm);
				echo "</div>";
				$CurrentAm += $rowdata['amount'];
			}
			else
			{
				$CurrentAm = round($CurrentAm, 2);
				$idRD = "positive";
				if ($CurrentAm < 0)
				{
					$idRD = "negative";
				}
				echo "<div id=\"$idRD\">";
				printf("%.2f", $CurrentAm);
				echo "</div>";
				$CurrentAm	-= $rowdata['amount'];
			}
			
			echo "</td>\n    ";
			echo "<form action=\"" . $_SERVER['PHP_SELF']. "?page=". $accountKey 
				. "\" method=\"post\">\n"
				. "<td><input type=\"submit\" name=\""
				. $rowdata['number']."\" value=\"". "Edit transaction " . $rowdata['number']
				. " \">" . "</td>\n    </form>";
			echo "\n  </tr>";
			
			if (isset($_POST[$rowdata['number']])){
				editItem('transaction',$accountKey,$accounts,$rowdata['number'],false,false,
						(int)$rowdata['month'],$rowdata['day'],$rowdata['year'],
						$rowdata['description'],$rowdata['from account'],
						$rowdata['to account'],$rowdata['amount']);
			}
		}
	}
	echo "\n</table>";
		mysql_free_result($resultAcc);
	}
?>