<?php function newestBill(){
$newestBill = " SELECT `number` FROM `bills` ORDER BY `bills`.`number` DESC LIMIT 1 ";
	 
	$newR = mysql_query($newestBill)
		or die('Error in query: $newestBill.' . mysql_error());
	if (mysql_num_rows($newR) > 0){
		$return = mysql_fetch_row($newR);
		
		return ((int)$return[0]+1);
	}
	else{return -1;}
}
?>