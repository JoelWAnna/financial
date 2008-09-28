<?php function isZero($i){
	if($i < .001 && $i < .002){
		return true;
	}
	else{
		return false;
	}
}
?>

<?php function negativeRed($num){
	if($num < 0){
		echo "<font color = red>";
	}
}
?>