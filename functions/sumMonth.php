<?php function sumMonth($toOrFrom,$account,$month,$day,$year){
 
	if(!$month){$month =(int)date("m");}

	$month2 = $month-1;

	if(!$day){$day= (int)date("d");}

	if(!$year){$year= (int)date("Y");}

	 if($month2){
		$year2=$year;
		}
	else{$month2 = 12; $year2 = $year -1;}

	return "SELECT SUM( `amount` ) FROM `transactions` WHERE ((("
	. "`month` =" . $month . " && `day` <= " . $day 
	. " && `year` =" . $year	. ") OR ("
	. "`month` =" . $month2 . " && `day` > " . $day
	. " && `year` =" . $year2 . ")) && ( "
	. "`" . $toOrFrom . " account` =". $account . " ))";
}
?>