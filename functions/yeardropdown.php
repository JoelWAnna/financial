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