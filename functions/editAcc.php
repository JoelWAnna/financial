<?php function editAcc($number,&$accountType){
	if($number == 'new'){
	$new =true;
	echo "<td align=\"center\">Number</td>";
	}
	echo "<td align=\"center\">Name</td><td align=\"center\">Type</td><td>Interest Rate</td><td>Budget</td><td align=\"center\">start</td></tr>";
	echo "\n    <tr><form action=\"" . $_SERVER['PHP_SELF']
			. "?page=-1\" method=\"post\"><td align=\"center\">";
	if($new){
		$ppp  = "Select `number` from `".PREFIX.ACCOUNTS."` ORDER BY `number` DESC ";
	$Rppp = mysql_query($ppp)
		or die("Error in query: $ppp." . mysql_error());
	if(mysql_num_rows($Rppp) > 0){
		$row = mysql_fetch_row($Rppp);
		$number = $row[0];
		$number++;
		echo "<input type=text READONLY size=\"3\" value=$number></td><td>";
	}mysql_free_result($Rppp);
	}
	$ppp  = "Select * from `".PREFIX.ACCOUNTS."` WHERE `".PREFIX.ACCOUNTS."`.`number` =" . $number;
	$Rppp = mysql_query($ppp);
	//	or die("Error in query: $ppp." . mysql_error());
	


//if (mysql_num_rows($Rppp) > 0){
		$pppR = mysql_fetch_assoc($Rppp);
		$type = $pppR['Type'];
		for($i=0;$i < 100;$i++){
			if($accountType[$i] == $type){break;}
		}
		
		

		dropDown('words','Name'.$number,$pppR['Name']);
		echo "</td><td>";
		if(!$new){
		dropDown('accounttype','Type'.$number,'','',$type,$accountType);
		}
		else{
			echo "<input type=\"text\" size=12 name=\"Type".$number."\"><br>";
			dropDown('accounttype','2Type'.$number,'','',$type,$accountType);
			echo "<br><select name=\"3Type".$number."\">";
			echo "\t<option value=\"\"></option>\n";
			echo "\t<option value=\"Checking\">Checking</option>\n";
			echo "\t<option value=\"Savings\">Savings</option>\n";
			echo "\t<option value=\"Credit Card\">Credit Card</option>\n";
			echo "\t<option value=\"Expense\">Expense</option>\n";
			echo "\t<option value=\"Income \">Income</option>\n";
			echo "</select>";
		}
		echo "</td><td align=\"center\">";
		dropDown('amount','IRate'.$number,$pppR['Interest Rate']);
		echo "</td><td align=\"center\">";
		dropDown('amount','Budget'.$number,$pppR['Budget']);
		echo "</td><td>";
		dropDown('amount','start'.$number,$pppR['start']);	
		
		echo "</td><td>";
		echo"<input type=\"submit\" name=\"account".$number."\" value=\"Add account\" style=\"background-color: "
			. "abcdef;\"></td>\n  </form></tr><tr>";
//}
		mysql_free_result($Rppp);
	return $number;
	
}?>