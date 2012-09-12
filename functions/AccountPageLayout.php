<?php function AccountPageLayout($page, &$all_Accounts, $subPage){
	// Main Page
	// ---------
	// $page cannot be less than 1
	// $subPage cannot be less than 1

	echo  "<a href=\"" . $_SERVER['PHP_SELF'] . "?page=0\">Back to main</a><br>";
	$this_account=GetAccountByNumber($all_Accounts, $page);

	if ($page < 1 || !$this_account)
	{
		echo "No account found with id = $page";
		return;
	}
	$accountKey = $this_account->number;
	$months = array(0,'Jan','Feb','Mar','Apr',
						'May','June','July','Aug',
						'Sep','Oct','Nov','Dec');

	$new = 0;
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



	echo  "<B>".$this_account->name."</B>";
	
	if ($this_account->type == "Credit Card")
	{
		echo "&nbsp APR:".$this_account->interest*100 . "%";
	
	}
	
	
	echo "<BR>";
	$queryAcc = " SELECT * FROM `".PREFIX.TRANSACTIONS."` "
			.	" WHERE `From Account` = \"" . $accountKey . "\" "
			.	" OR `To Account` = \"" . $accountKey . "\" "
			.	" ORDER BY `". PREFIX.TRANSACTIONS ."`.`year` DESC, `"
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

	if (isset($_POST[$new]))
	{
		editItem('transaction', $accountKey, $subPage, $all_Accounts, $new, true);
	}
	else if ($numTransactions <= 0)
	{
		echo '<b>No transactions found</b>';
		echo "  </ul>\n"
			."</div>";
		return;
	}

	$CurrentAm = currentAccountAmount($accountKey, $subPage);

	while ($rowdata = mysql_fetch_assoc($resultAcc))
	{
		$current_transaction = new Transaction($rowdata);

		$X = "X";
		$X .= $current_transaction->number;

		if (isset($_POST[$X]))
		{
			if(submitItem('transaction', $current_transaction->number, true))
			{
				reloadPHP();
			}
			unset($_POST[$X]);
		}

		$fromaccount = $current_transaction->fromAccount($all_Accounts);
		$toaccount = $current_transaction->toAccount($all_Accounts);
		$fromAccountText = $fromaccount->name;
		$toAccountText = $toaccount->name;
		if ($accountKey != $fromaccount->number)
		{
			$fromAccountText = "        <a href=?page=" . $fromaccount->number . ">" . $fromAccountText . "</a>\n";
		}
		else
		{
			$toAccountText = "        <a href=?page=" . $toaccount->number . ">" . $toAccountText . "</a>\n";
		}

		echo "\n"
			. "    <li class=\"date\">"
			. $current_transaction->dateToString();
		echo  "</li>\n"
			. "    <li class=\"desc\">" . $current_transaction->description . "</li>\n"
			. "    <li class=\"account\">\n" . $fromAccountText . "    </li>\n"
			. "    <li class=\"account\">\n" . $toAccountText . "    </li>\n";


		$neg = ($current_transaction->from_Account_Number == $accountKey) ? " negative" : "";

		echo "    <li class=\"hdr_funds$neg\">";
		if ($neg != "")
		{
			echo "-";
		}
		echo $current_transaction->amount . "</li>\n";

		$CurrentAm = round($CurrentAm, 2);
		$neg = ($CurrentAm < 0) ? " negative" : "";

		echo "    <li class=\"hdr_funds$neg\">";
		printf("%.2f", $CurrentAm);
		echo "</li>\n";

		if ($current_transaction->from_Account_Number == $accountKey)
		{
			$CurrentAm += $current_transaction->amount;
		}
		else
		{
			$CurrentAm	-= $current_transaction->amount;
		}
		
		echo  "    <li>\n"
			. "      <form action=\"" . $_SERVER['PHP_SELF'] . "?page=$accountKey&subPage=$subPage\" method=\"post\">\n"
			. "      <input type=\"submit\" name=\"" . $current_transaction->number. "\" value=\""
			. "Edit transaction " . $current_transaction->number . " \" $disable >\n      </form>\n";
		echo "    </li>\n";
		
		if (isset($_POST[$current_transaction->number])){
			editItem('transaction',$accountKey, $subPage, $all_Accounts, $current_transaction->number, false, false, $current_transaction->month, $current_transaction->day,
					$current_transaction->year, $current_transaction->description,
					$current_transaction->from_Account_Number, $current_transaction->to_Account_Number,
					$current_transaction->amount);
		}
	}
	mysql_free_result($resultAcc);


	echo  "  </ul>\n"
		. "</div>";

	}
?>