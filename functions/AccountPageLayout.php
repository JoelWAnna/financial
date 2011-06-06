<?php function AccountPageLayout($page, &$accounttype, &$accounts, $subPage){
	// Main Page
	// ---------
	// $page cannot be less than 1
	// $subPage cannot be less than 1

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
	if (isset($_POST[$X]))
	{
		if(submitItem('transaction',$new))
		{
			reloadPHP();
			unset($_POST[$X]);
		}
	}

	echo  "<Br><B>".$accounts[$accountKey]."</B>";


	$queryAcc = " SELECT * FROM `".PREFIX.TRANSACTIONS."`"
			.	" WHERE `From Account` =$accountKey OR `To Account` =$accountKey "
			.	"ORDER BY `". PREFIX.TRANSACTIONS ."`.`year` DESC, `"
							. PREFIX.TRANSACTIONS ."`.`month` DESC, `"
							. PREFIX.TRANSACTIONS ."`.`day` DESC ";

	$queryAcc2 = $queryAcc . "LIMIT " . (($subPage-1)*100) . ", " . 100 . ";"; 

	$resultAcc = mysql_query($queryAcc)
		or die("Error in query: $queryAcc." . mysql_error());
	
	$numTransactions = mysql_num_rows($resultAcc);

	if ($numTransactions > 100)
	{
		mysql_free_result($resultAcc);
		$resultAcc = mysql_query($queryAcc2)
			or die("Error in query: $queryAcc2." . mysql_error());
		
		for ($i = 1; $i < ($numTransactions / 100)+1; $i++)
		{
			if ( $i != $subPage)
			{
				echo "<a href=\"". $_SERVER['PHP_SELF'] . "?page=$page&subPage=$i\">";
			}
			echo ($i);
			if ( $i != $subPage)
			{
				echo "</a>";
			}
			echo "&nbsp;";			
		}
	}
	$disable = userIsAdmin() ? "" : "disabled='disabled'";
						
	echo  "<div id=\"AccountTransactions\">\n"
		. "  <ul>\n"
		. "    <li class=\"AT_hdr hdr_date\">date</li>\n"
		. "    <li class=\"AT_hdr \">description</li>\n"
		. "    <li class=\"AT_hdr \">from account</li>\n"
		. "    <li class=\"AT_hdr \">to account</li>\n"
		. "    <li class=\"AT_hdr hdr_funds\">amount</li>\n"
		. "    <li class=\"AT_hdr hdr_funds\">balance</li>\n"
		. "    <li class=\"AT_hdr submit\">\n"
		. "      <form action=\"" . $_SERVER['PHP_SELF'] . "?page=$accountKey&subPage=$subPage\" method=\"post\">\n"
		. "      <input type=\"submit\" name=\"$new\" value=\"Start new transaction\" $disable >\n"
		. "      </form>\n"
		. "    </li>\n";

	if ($numTransactions <= 0)
	{
		echo '<b> - No transactions found</b>';
		return;
	}

	if($new > 0)
	{
		if (isset($_POST[$new]))
		{
			editItem('transaction', $accountKey, $subPage, $accounts, $new, true);
		}
	}

	$CurrentAm = currentAccountAmount($accountKey, $subPage);

	while ($rowdata = mysql_fetch_assoc($resultAcc))
	{
		$X = "X";
		$X .= $rowdata['number'];
		if (isset($_POST[$X]))
		{
			if(submitItem('transaction', $rowdata['number']))
			{
				reloadPHP();
			}
			unset($_POST[$X]);
		}

		echo "\n"
			. "    <li class=\"date\">";
			printf("%s %02d %s", $months[(int)$rowdata['month']], $rowdata['day'], $rowdata['year']);
		echo  "</li>\n"
			. "    <li class=\"desc\">" . $rowdata['description'] . "</li>\n"
			. "    <li class=\"account\">"
			. $accounts[$rowdata['from account']] . "</li>\n"
			. "    <li class=\"account\">"
			. $accounts[$rowdata['to account']]	. "</li>\n";


		$neg = ($rowdata['from account'] == $accountKey) ? " negative" : "";

		echo "    <li class=\"hdr_funds$neg\">";
		if ($neg != "")
		{
			echo "-";
		}
		echo $rowdata['amount'] . "</li>\n";

		$CurrentAm = round($CurrentAm, 2);
		$neg = ($CurrentAm < 0) ? " negative" : "";

		echo "    <li class=\"hdr_funds$neg\">";
		printf("%.2f", $CurrentAm);
		echo "</li>\n";

		if ($rowdata['from account'] == $accountKey)
		{
			$CurrentAm += $rowdata['amount'];
		}
		else
		{
			$CurrentAm	-= $rowdata['amount'];
		}
		
		echo  "    <li>\n"
			. "      <form action=\"" . $_SERVER['PHP_SELF'] . "?page=$accountKey&subPage=$subPage\" method=\"post\">\n"
			. "      <input type=\"submit\" name=\"" . $rowdata['number']. "\" value=\""
			. "Edit transaction " . $rowdata['number'] . " \" $disable >\n      </form>\n";
		echo "    </li>\n";
		
		if (isset($_POST[$rowdata['number']])){
			editItem('transaction',$accountKey, $subPage, $accounts,$rowdata['number'],false,false,
					(int)$rowdata['month'],$rowdata['day'],$rowdata['year'],
					$rowdata['description'],$rowdata['from account'],
					$rowdata['to account'],$rowdata['amount']);
		}
	}
	mysql_free_result($resultAcc);	


	echo  "  </ul>\n"
		. "</div>";

	}
?>