<?php function amountbox($amount,$transNumber){
	echo "<input type=\"number\" name=\"amount"
		. $transNumber . "\""
		. " maxlength=\"9\" size=\"5\" value=\""
		. $amount . "\" showlength=\"4\">\n";
}
?>