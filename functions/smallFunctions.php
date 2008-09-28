<?php function isZero($i){
/* 	if($i < .001 && $i < .002){
		return true;
	}
	return false; */
}
?>
<?php function negativeRed($i){
	if($i < 0){
		echo "<font color = red>";
	}
}
?>
<?php function selected($i,$j,$s){
	if($s){
		if($s == $i){
			echo " selected=\"selected\"";
		}
	}else{
		if($i == $j){
			echo " selected=\"selected\"";
		}
	}
}
?>
<?php function reloadPHP(){
	$page=$_GET['page'];
	echo "<script type=\"text/javascript\">"
		. "function load()" . "{"
		. "window.location.replace(\"".$_SERVER['PHP_SELF'] ."?page="
		. $page . "\");" . "}" . "load();" . "</script>"; 
}
?>