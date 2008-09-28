<?php 
function descriptionbox($description,$transNumber){
	echo "<input type=\"text\" name=\"description" . $transNumber
		. "\" maxlength=\"10\" value=\""
		. $description . "\">\n";
	}
?>