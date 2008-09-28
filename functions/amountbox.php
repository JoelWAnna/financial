<?php function amountbox($amount){
	echo "<input type=\"number\" name=\"amount\""
		. " maxlength=\"9\" size=\"5\" value=\""
		. $amount . "\" showlength=\"4\">\n";
}
?>