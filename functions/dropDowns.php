<?php function dropDown($type,$transNumber,$current,$max,$reverseLen,$accounts){
//$type can be day (d) month  (m) or year (Y) it is case sensitive
//$current == $day/$year/$month
	$i=1;
if($type=='account'){//current=where, max-which reverselen=page
	echo "<select name=\"" . $current . $type. $transNumber . "\">\n";
	while($accounts[$i]){
		echo "\t<option value=\"".$i."\"";
		selected($i,$reverseLen,$max);
		echo ">".$accounts[$i++]."</option>\n";
	}
	echo "</select>\n";
	return;
}
if($type == 'words'){$type='description';}
if($type=='amount' | $type=='description'){
	echo "<input type=\"text\" name=\""	. $type
		. $transNumber . "\"" . " maxlength=\"";
	if($type=='amount'){
		echo "10\" size=\"5\"";
	}else{echo "15\"";}
	echo "  value=\"" . $current . "\">\n";
	return;
}





	$J = (int)date($type);
	
	
	if(!$reverseLen){$reverseLen = 0;}
	if($type == 'Y'){
		$type = 'year';
		if(!$max){$max=2;}
		if(!$reverseLen){$reverseLen=1;}
		$i= $J-$reverseLen;
		$max += $i;

	}else{
		if($type == 'd'){
			$type = 'day';
			if(!$max){$max=31;}
		}else{
			if($type =='m'){
				$type = 'month';
				$months = array(0,Jan,Feb,Mar,Apr,
					May,June,July,Aug,
					Sep,Oct,Nov,Dec);
				if(!$max){$max=12;}
			}
		}
	}
	echo "<select name=\"" . $type. $transNumber . "\">\n";
	while($i<$max+1){
		echo "\t<option value=\"";
		echo $i. "\"";
		selected($i,$J,$current);
		echo ">";
		if($type=='month'){echo $months[$i];}
		else{echo $i;}
		echo "</option>\n";
		$i++;
	}
	echo  "</select>\n";
	
}
?>
