<?php function setupAcc(&$accounttype,&$accounts){
		$index=0;
	$databaseFin='financial';
	mysql_select_db($databaseFin)
		or die('Unable to select database! $databaseFin');
	
	$querytype ="SELECT DISTINCT `Type` FROM `accounts` LIMIT 0 , 30";
	$queryname ="SELECT number, name, type FROM `accounts`";
	
	$typeresult = mysql_query($querytype)
		or die('Error in query: $querytype.' . mysql_error());
	$resultname = mysql_query($queryname)
		or die('Error in query: $queryname.' . mysql_error());
	
	if (mysql_num_rows($typeresult) > 0){
		while($row = mysql_fetch_row($typeresult)){		
			$accounttype[$index++]=$row[0];
		}
	}else{
		echo '<b>Error Line 53</b>';}
	if (mysql_num_rows($resultname) > 0){
		while($row = mysql_fetch_row($resultname)){		
			$accounts[$row[0]]= $row[1];
		}
	}else{
		echo '<b>Error Line 59</b>';
	}
	mysql_free_result($resultname);
	mysql_free_result($typeresult);
	}
?>

<?php function selected($i,$j,$s){
	if($s){
			if($s == $i){
				echo " selected=\"selected\"";
			}
		}
		else{
			if($i == $j){
				echo " selected=\"selected\"";
			}
		}
}
?>

<?php function monthdropdown($month){
	$months = array(0,Jan,Feb,Mar,Apr,
					May,June,July,Aug,
					Sep,Oct,Nov,Dec);
	$j= date("m");
	echo "<select name=\"month\">\n";
	for($i=1;$i<13;$i++){
		echo "\t<option value=\"";
		if($i<10){ echo "0";}
		echo $i. "\"";
		selected($i,$j,$month);
		echo ">". $months[$i]."</option>\n";
	}
	echo  "</select>\n";
	}
?>

<?php function daydropdown($day){
	$j= date("d");
	echo "<select name=\"day\">\n";
	$i=0;
	while(++$i <32){
		echo "\t<option value=\"".$i."\"";		
		selected($i,$j,$day);		
		echo ">" .$i."</option>\n";
	}
	echo "</select>\n";
}
?>

<?php function yeardropdown($year,$len,$rlen){
	if(!$len){$len=3;}
	if(!$rlen){$rlen=1;}
	$len -= $rlen;
	$j= (int)date("Y");
	echo "<select name=\"year\">\n";
	for($i=($j-$rlen);$i < ((int)$j+$len);$i++){
		echo "\t<option value=\"".$i."\"";
		selected($i,$j,$year);/* if($i==0){echo " selected=\"selected\" ";} */
		echo ">" .($i)."</option>\n";
	}
	echo "</select>\n";
}
?>

<?php function descriptionbox($description){
	echo "<input type=\"text\" name=\"description\" maxlength=\"10\" value=\""
		. $description . "\">\n";
	}
?>

<?php function accountdropdown($where,$which,&$accounts,&$page){

	echo "<select name=\"" . $where . "account\">\n";
	$i=1;
	while($accounts[$i]){
		echo "\t<option value=\"".$i."\"";
		selected($i,$page,$which);
		echo ">".$accounts[$i++]."</option>\n";
	}
	echo "</select>\n";
}
?>

<?php function amountbox($amount){
	echo "<input type=\"number\" name=\"amount\""
		. " maxlength=\"9\" size=\"5\" value=\""
		. $amount . "\" showlength=\"4\">\n";
}
?>

<?php function negativeRed($num){
	if($num < 0){
		echo "<font color = red>";
	}
}
?>

<?php function isZero($i){
	if($i < .001 && $i < .002){
		return true;
	}
	else{
		return false;
	}
}
?>

<?php function newestTransaction(){
$newQ = " SELECT `number` FROM `transactions` ORDER BY `transactions`.`number` DESC LIMIT 1 ";
	 
	$newR = mysql_query($newQ)
		or die('Error in query: $newQ.' . mysql_error());
	if (mysql_num_rows($newR) > 0){
		$return = mysql_fetch_row($newR);
		
		return ((int)$return[0]+1);
	}
	else{return -1;}
}
?>