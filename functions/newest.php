<?php function newest($type){
	$typeQ = PREFIX;
	if($type=='trans'){
		$typeQ .= TRANSACTIONS;
	}else if($type=='bill'){
		$typeQ .= BILLS;
	}else{ return -1;}
	$newQ = " SELECT `number` FROM `". $typeQ ."` ORDER BY `". $typeQ ."`.`number` DESC LIMIT 1 ";
	$newR = mysql_query($newQ)
		or die("Error in query: $newQ." . mysql_error());
	if (mysql_num_rows($newR) > 0){
		$return = mysql_fetch_row($newR);
		return ((int)$return[0]+1);
	}else{return -1;}
}
?>