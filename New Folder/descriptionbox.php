<?php function descriptionbox($description,$transNumber){
	echo "<input type=\"text\" name=\"description" . $transNumber
		. "\" maxlength=\"10\"  value=\""
		. $description . "\">\n";
	}
?>
<?php function amountbox($amount,$transNumber){
	echo "<input type=\"text\" name=\"amount"
		. $transNumber . "\""
		. " maxlength=\"10\" size=\"5\"  value=\""
		. $amount . "\">\n";
}
?>

