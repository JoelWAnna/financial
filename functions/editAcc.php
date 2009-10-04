<?php function editAcc($number, &$accountTypes){
	if($number == 'new')
	{
		$new =true;
		echo "<td align=\"center\">Number</td>";
	}
	echo  "<td align=\"center\">Name</td>"
		. "<td align=\"center\">Type</td>"
		. "<td>Interest Rate</td>"
		. "<td>Budget</td>"
		. "<td align=\"center\">start</td>"
		. "</tr>";

	echo  "\n    <tr>"
		. "<form action=\"" . $_SERVER['PHP_SELF'] . "?page=-1\" method=\"post\">"
		. "<td align=\"center\">";
		
	if($new){
		$pQuery  = "Select `number` from `".PREFIX.ACCOUNTS."` ORDER BY `number` DESC ";
		
		$rQuery = mysql_query($pQuery)
			or die("Error in query: $pQuery." . mysql_error());

		if(mysql_num_rows($rQuery) > 0)
		{
			$row = mysql_fetch_row($rQuery);
			$number = $row[0];
			$number++;
			echo "<input type=text READONLY size=\"3\" value=$number></td><td>";
		}
		mysql_free_result($rQuery);
	}
	
	$pQuery2 = "Select * from `" . PREFIX.ACCOUNTS
			 . "` WHERE `" . PREFIX.ACCOUNTS . "`.`number` =$number";
	$rQuery2 = mysql_query($pQuery2);
	//	or die("Error in query: $pQuery2." . mysql_error());
	


//if (mysql_num_rows($rQuery2) > 0){
		$rowResults = mysql_fetch_assoc($rQuery2);
		$type = $rowResults['Type'];
/*		for ($i=0;$i < 100;$i++)
		{
			if($accountTypes[$i] == $type){break;}
		}
*/		
		

		textField("Name$number", $rowResults['Name']);
		echo "</td><td>";
		if (!$new)
		{
			dropDownAccountType("Type$number", $type,$accountTypes);
		}
		else
		{
			echo "<input type=\"text\" size=12 name=\"Type".$number."\"><br>";
			dropDownAccountType("2Type$number", $type,$accountTypes);
			echo "<br><select name=\"3Type$number\">";
			echo "\t<option value=\"\"></option>\n";
			echo "\t<option value=\"Checking\">Checking</option>\n";
			echo "\t<option value=\"Savings\">Savings</option>\n";
			echo "\t<option value=\"Credit Card\">Credit Card</option>\n";
			echo "\t<option value=\"Expense\">Expense</option>\n";
			echo "\t<option value=\"Income \">Income</option>\n";
			echo "</select>";
		}

		echo "</td><td align=\"center\">";
		textField("IRate$number", $rowResults['Interest Rate'], 'amount');
		echo "</td><td align=\"center\">";
		textField("Budget$number", $rowResults['Budget'], 'amount');
		echo "</td><td>";
		textField("start$number", $rowResults['start'], 'amount');	
		
		echo  "</td><td>";
		echo  "<input type=\"submit\" name=\"account$number\" "
			. "value=\"Add account\" style=\"background-color: "
			. "abcdef;\">"
			. "</td>\n  </form>"
			. "</tr><tr>";
//}
		mysql_free_result($rQuery2);
	return $number;
	
}?>