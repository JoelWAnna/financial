<?php function inputBox($type,$number,$current){
	echo "<input type=\"text\" name=\""	. $type
		. $number . "\"" . " maxlength=\"";
	if($type=='amount'){
		echo "10\" size=\"5\"";
	}else{echo "15\"";}
	echo "  value=\"" . $current . "\">\n";
}?>
