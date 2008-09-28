<?php function selected($i,$j,$s){
	if($s){
			if($s == $i){
				echo " selected=\"selected\"";
			}
		}
		else{
			if($i == $j){
				echo " selected=\"selected\"";
			}
		}
}
?>