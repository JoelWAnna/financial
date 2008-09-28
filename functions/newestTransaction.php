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