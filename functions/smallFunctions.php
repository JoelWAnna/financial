<?php function leftPage($type, $equalTo,$three){
	if($type == "removed" & $three !=3){
		return false;
	}
 	if($equalTo){ 
		if(($type== "Checking")| ($type== "Savings")
				| ($type== "Credit Card")//| ($type== "Loan")
				)
				{return true;}
	}else{
		if(($type!= "Checking")& ($type!= "Savings")
			& ($type!= "Credit Card")//& ($type!= "Loan")
		)
		{return true;}
	} 
	
	return false;
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