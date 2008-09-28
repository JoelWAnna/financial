<?php function daydropdown($day,$transNumber,$max){
	if(!$max){$max=31;}
	$j= date("d");
	echo "<select name=\"day" . $transNumber . "\">\n";
	$i=0;
	while(++$i < $max+1){
		echo "\t<option value=\"".$i."\"";		
		selected($i,$j,$day);		
		echo ">" .$i."</option>\n";
	}
	echo "</select>\n";
}
?>