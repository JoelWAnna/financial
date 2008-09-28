<?php function newTR(&$page,&$accounts){
	echo "<table border=3 align=center>";
	$new = newestTransaction();
	if (isset($_POST['XXXxxx'])){
		$nber=$_POST['dayo'];
	}
	else{$nber=2;
	}
	
	echo "<tr><form action=\"" . $_SERVER['PHP_SELF']. "\" method=\"post\"><td colspan=4 align=right>";
	daydropdown($nber,'o',10);
	echo "</td><td colspan=3 align=left><input type=\"submit\""
		. " name=\"XXXxxx\" value=\"";
	echo "more boxes";
	echo "\" style=\"background-color: abcdef;\">\n  ";
	echo "</td></form>";//</tr><tr>
	
	
	echo "\n    <form action=\"" . $_SERVER['PHP_SELF']."\" method=\"post\">";

	

	for($tt=0;$tt<$nber;$tt++){
		echo "</tr>";
		edittrans(true,$page,$accounts,$new+$tt,$new+$tt);
	}
	echo "</tr><tr>";
	echo "<td align=center colspan=7><input type=\"submit\""
		. " name=\"XXX\" value=\"";
	echo "Add new Transaction";
	echo "\" style=\"background-color: abcdef;\">\n  ";
	echo "</td>";
	
	echo "</form>";
	echo "</tr>";
	
	
	
	if (isset($_POST['XXX'])){
	
		for($i=0;$i<=15/* $nber */;$i++){
			submitTransaction(($new+$i));
			
		}
		reloadPHP();
	}

	
}
?>