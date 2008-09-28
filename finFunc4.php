 
 
 
 
 <?php 
 //echo sumMonth("to",0,1,15,2005) . "<br>";
 //echo sumMonth("from",0,0,0,0);
function sumMonth($toOrFrom,$account,$month,$day,$year){
 
	if(!$month){$month =(int)date("m");}
	//echo $month . " month . <br>";
	$month2 = $month-1;
	//echo $month2 . " month2 . <br>";
	if(!$day){$day= (int)date("d");}
	//echo $day . " day . <br>";
	if(!$year){$year= (int)date("Y");}
	//echo $year . " year . <br>";
	 if($month2){
		$year2=$year;
		}
	else{$month2 = 12; $year2 = $year -1;}
			//echo $month2 . " month2 . <br>";
			//echo $year2 . " year2 . <br>";

 
/* 	echo "SELECT SUM( `amount` ) FROM `transactions` WHERE ((("
	. "`month` =" . $month . " && `day` > " . $day 
	. " && `year` =" . $year	. ") OR ("
	. "`month` =" . $month2 . " && `day` < " . $day
	. " && `year` =" . $year2 . ")) && ( "
	. "`" . $toOrFrom . " account` =". $account . " ))"; */
	return "SELECT SUM( `amount` ) FROM `transactions` WHERE ((("
	. "`month` =" . $month . " && `day` <= " . $day 
	. " && `year` =" . $year	. ") OR ("
	. "`month` =" . $month2 . " && `day` > " . $day
	. " && `year` =" . $year2 . ")) && ( "
	. "`" . $toOrFrom . " account` =". $account . " ))";// LIMIT 0 , 30 ";
}
?>