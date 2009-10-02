<?php function validAccountforThisPage($type, $left, $page)
{
	if($type == "removed" && $page !=-2)
	{
		return false;
	}
 	
	if (($type!= "Checking") && ($type != "Savings") &&
		($type!= "Credit Card")/*&& ($type!= "Loan")*/)
	{
		return !$left;
	}
	
	
	return $left;
}
?>


<?php function negativeRed($i){
	if($i < 0){
		echo "<font color = red>";
		return true;
	}
	return false;
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
<?php function reloadPHP()
{
	return;
	$page=$_GET['page'];
	echo "<script type=\"text/javascript\">"
		. "function load()" . "{"
		. "window.location.replace(\"".$_SERVER['PHP_SELF'] ."?page="
		. $page . "\");" . "}" . "load();" . "</script>"; 
}
?>