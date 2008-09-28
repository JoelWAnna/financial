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