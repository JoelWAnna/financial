<?php function editItem($type,&$page,&$accounts,$number,$newtrans,
/*$type= bill or trans*/			$noforms, $month, $day, $year,
						$description,$fromAcc,$toAcc,$amount){
/**/	if($type == 'trans' && !$noforms){
/**/		echo "\n    <tr><form action=\"" . $_SERVER['PHP_SELF']
/**/			. "?page=" . $page . "\" method=\"post\">";
/**/	}
	echo "<td width=55>";
	dropDown(m,$number,$month);
	echo "</td><td width=50>";
	dropDown(d,$number,$day);
	echo "</td><td width=55>";
	dropDown(Y,$number,$year);
	echo "</td><td width=142>";
	dropDown('words',$number,$description);
/**/	if($type == 'trans'){
/**/		echo "</td><td width=145>";
/**/		dropDown('account',$number,'from',$fromAcc,$page,$accounts);
/**/	}
	echo "</td><td width=143>";
	dropDown('account',$number,'to',$toAcc,$page,$accounts);
	echo "</td><td width=50>";
	dropDown('amount',$number,$amount);
	echo "</td>";
/**/	if($type == 'trans'&& !$noforms){
/**/		echo "<td colSpan=\"2\" align=center>";
/**/		echo"<input type=\"submit\" name=\"X"
/**/			.$number. "\" value=\"";
/**/		if($newtrans){
/**/			echo "Add New Transaction ";
/**/		}else{
/**/			echo "Submit Changes to ";
/**/		}	
/**/		echo  $number . "\" style=\"background-color: "
/**/			. "abcdef;\"></td>\n  </form></tr>";
/**/	}
}?>

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
<?php function submitAcc($number,$new){

$NAME = "descriptionName".$number;
$TYPE = "Type".$number;
$TYPE2 = "2Type".$number;
$TYPE3 = "3Type".$number;
$IRATE = "amountIRate".$number;
$BUDGET = "amountBudget".$number;
$START = "amountstart".$number;


	$_POST[$IRATE]=(float)$_POST[$IRATE];
	$_POST[$BUDGET]=(float)$_POST[$BUDGET];
	$_POST[$START]=(float)$_POST[$START];
	
	if (!$_POST[$NAME]){
		echo ' You did not enter a name ';
		return false;
	}
	if($new =='new'){
		if($_POST[$TYPE]){
		$type = $_POST[$TYPE];
		}else if($_POST[$TYPE2]){
			$type = $_POST[$TYPE2];
		}else if($_POST[$TYPE3]){
			$type = $_POST[$TYPE3];
		}else {	
		echo ' You did not enter a type ';
		return false;
		}
	
	}else{
	if (!$_POST[$TYPE]){
		echo ' You did not enter a type ';
		return false;
	}else{$type = $_POST[$TYPE];}
	}

	if($new == 'new'){
	$query ="Insert Into `".DATABASENAME
			."`.`".PREFIX.ACCOUNTS."` SET `"
			.PREFIX.ACCOUNTS."`.`number` ='"
			. $number . "', ";
	}else{
		$query = "UPDATE `" . DATABASENAME. "`.`" . PREFIX . ACCOUNTS. "` SET ";
	}
	$query .= "`Name` = '" . $_POST[$NAME]	. "', `Type` = '" . $type
		. "', `Interest Rate` = '" . $_POST[$IRATE]	. "', `Budget` = '" . $_POST[$BUDGET]
		. "', `start` = '" . $_POST[$START] ."'";
	if(!($new == 'new')){
		$query .= " WHERE `".PREFIX.ACCOUNTS."`.`number` =". $number ." LIMIT 1";
	}

	
	mysql_close($connect);
	$connect = mysql_connect(HOSTNAME, UPDATEUSER, UPDATEPASSWORD)
		or die('Unable to connect!');
	mysql_select_db(DATABASENAME)
		or die('Unable to select database! DATABASENAME');	
	$Rquery = mysql_query($query)
		or die("Error in query: $query." . mysql_error());
	mysql_close($connect);
	$connect = mysql_connect(HOSTNAME, USERNAME, PASSWORD)
		or die('Unable to connect!');
	return true;
	
}?>