<?php function yeardropdown($year,$len,$rlen,$transNumber){
	if(!$len){$len=3;}
	if(!$rlen){$rlen=1;}
	$len -= $rlen;
	$j= (int)date("Y");
	echo "<select name=\"year" . $transNumber . "\">\n";
	for($i=($j-$rlen);$i < ((int)$j+$len);$i++){
		echo "\t<option value=\"".$i."\"";
		selected($i,$j,$year);
		echo ">" .($i)."</option>\n";
	}
	echo "</select>\n";
}
?>