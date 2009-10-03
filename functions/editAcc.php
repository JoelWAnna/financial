<?php function editAcc($number,&$accountType){
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
		for ($i=0;$i < 100;$i++)
		{
			if($accountType[$i] == $type){break;}
		}
		
		

		echo dropDownString('words',"Name$number",$rowResults['Name']);
		echo "</td><td>";
		if (!$new)
		{
			echo dropDownString('accounttype',"Type$number",'','',$type,$accountType);
		}
		else
		{
			echo "<input type=\"text\" size=12 name=\"Type".$number."\"><br>";
			echo dropDownString('accounttype',"2Type$number",'','',$type,$accountType);
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
		echo dropDownString('amount',"IRate$number", $rowResults['Interest Rate']);
		echo "</td><td align=\"center\">";
		echo dropDownString('amount',"Budget$number", $rowResults['Budget']);
		echo "</td><td>";
		echo dropDownString('amount',"start$number", $rowResults['start']);	
		
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