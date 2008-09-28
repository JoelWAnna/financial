<?php function newTR(&$page,&$accounts){
	echo "<table width=98% border=3>";
	$new = newestTransaction();
	echo "\n    <tr><form action=\"" . $_SERVER['PHP_SELF']. "?page="
		. $page . "&new=".($new+1) ."\" method=\"post\">";
		
	edittrans(true,$page,$accounts,$new,$new);
	echo "<td align=center><input type=\"submit\""
		. " name=\"XXX\" value=\"";
	echo "Add new Transaction";
	echo "\" style=\"background-color: abcdef;\">\n  ";
	echo "</td></form>";
	//echo "</tr>";
	
	if (isset($_POST['XXXxxx'])){
		$nber=$_POST['dayo'];
	}
	else{$nber=2;
	}
	for($tt=1;$tt<$nber;$tt++){
		echo "</tr>";
		edittrans(true,$page,$accounts,$new+$tt,$new+$tt);
	
	}
	echo "<form action=\"" . $_SERVER['PHP_SELF']. "?page="
		. $page . "&new=".($new+$tt)."\" method=\"post\"><td align=center>";
	daydropdown($tt,'o',10);
	echo "<input type=\"submit\""
		. " name=\"XXXxxx\" value=\"";
	echo "more boxes";
	echo "\" style=\"background-color: abcdef;\">\n  ";
	echo "</td></form>";
	
	
	
	if (isset($_POST['XXX'])){
		if(submitTransaction($new)){
			if(submitTransaction(($new+1))){
				$new += 1;
			}
			$new += 1;
			reloadPHP();
		}
	}
	$X = "X";
	$X .= $new;
	if (isset($_POST[$X])){
		if(submitTransaction($new)){
			$new = $_GET['new'];
			reloadPHP();
		}
	}	
	echo "</table>";
}
?>