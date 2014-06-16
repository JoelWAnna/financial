<?php
function editAcc($number, &$all_Accounts)
{
	$connection = Queries::ConnectToDB(false);
	if($number == 'new')
	{
		$new =true;
		echo "\n    <td align=\"center\">Number</td>\n";
	}
	echo  "    <td align=\"center\">Name</td>\n"
		. "    <td align=\"center\">Type</td>\n"
		. "    <td>Interest Rate</td>\n"
		. "    <td>Budget</td>\n"
		. "    <td align=\"center\">start</td>\n"
		. "</tr>";

	echo  "\n<tr>"
		. "<form action=\"" . $_SERVER['PHP_SELF'] . "?page=-1\" method=\"post\">"
		. "<td align=\"center\">\n";

	if($new)
	{
		$pQuery  = "Select `number` from `".PREFIX.ACCOUNTS."` ORDER BY `number` DESC ";
		$rQuery = $connection->query($pQuery)
			or die("Error in query: $pQuery." . mysql_error());

		$number = 1;
		if($rQuery > 0)
		{
			$row = $rQuery->fetch();
			$number += (int)$row[0];
		}
		echo "<input type=text READONLY size=\"3\" value=" . $number . "></td>\n<td>";

	}
	
	$pQuery2 = "Select * from `" . PREFIX.ACCOUNTS
			 . "` WHERE `" . PREFIX.ACCOUNTS . "`.`number` =" . $number;

	$rQuery2 = $connection->query($pQuery2);
	// or die("Error in query: $pQuery2." . mysql_error());
	if ($rQuery2)
	{
		$rowResults = $rQuery2->fetch();
		
	}
	else
	$rowResults = "";
//if (mysql_num_rows($rQuery2) > 0){
		
		$type = $rowResults['Type'];
/*		for ($i=0;$i < 100;$i++)
		{
			if($accountTypes[$i] == $type){break;}
		}
*/		
		

		echo textField("Name$number", $rowResults['Name']);
		echo "</td>\n<td>";
		if (!$new)
		{
			echo dropDownAccountType("Type$number", $type, $all_Accounts);
		}
		else
		{
			echo "<input type=\"text\" size=12 name=\"Type".$number."\">\n<br>";
			if ($all_Accounts)
			{
				echo dropDownAccountType("2Type$number", $type, $all_Accounts);
				echo "<br>";
			}
			echo "<select name=\"3Type$number\">\n";
			echo "\t<option value=\"\"></option>\n";
			echo "\t<option value=\"Checking\">Checking</option>\n";
			echo "\t<option value=\"Savings\">Savings</option>\n";
			echo "\t<option value=\"Credit Card\">Credit Card</option>\n";
			echo "\t<option value=\"Expense\">Expense</option>\n";
			echo "\t<option value=\"Income \">Income</option>\n";
			echo "</select>";
		}

		echo  "</td>\n"
			. "<td align=\"center\">\n\t";
		echo textField("IRate$number", $rowResults['Interest Rate'], 'amount');
		echo  "</td>\n"
			. "<td align=\"center\">\n\t";
		echo textField("Budget$number", $rowResults['Budget'], 'amount');
		echo "</td>\n"
			. "<td>\n\t";
		echo textField("start$number", $rowResults['start'], 'amount');	
		
		echo  "</td>\n"
			. "<td>\n\t";
		$disable = userIsAdmin() ? "" : "disabled='disabled'";
		echo  "<input type=\"submit\" name=\"account$number\" "
			. "value=\"Add account\" style=\"background-color: "
			. "abcdef;\" $disable >\n\t"
			. "</td>\n  </form>\n"
			. "</tr>\n<tr>";
//}

	return $number;
	
}?>
