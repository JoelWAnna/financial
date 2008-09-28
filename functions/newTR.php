<?php function newTR(&$page,&$accounts){
	echo "<table width=98% border=3>";
	$new = newestTransaction();
	if (isset($_POST['XXXxxx'])){
		$nber=$_POST['dayo'];
	}
	else{$nber=2;
	}
	//<td colspan=2>
	echo "<tr><form action=\"" . $_SERVER['PHP_SELF']./*  "?page="
		. $page . */ "\" method=\"post\"><td>";
	daydropdown($tt,'o',10);
	echo "</td><td><input type=\"submit\""
		. " name=\"XXXxxx\" value=\"";
	echo "more boxes";
	echo "\" style=\"background-color: abcdef;\">\n  ";
	echo "</td></form>";//</tr><tr>
	
	
	echo "\n    <form action=\"" . $_SERVER['PHP_SELF']./*  "?page="
		. $page . */"\" method=\"post\">";
		
/* 	edittrans(true,$page,$accounts,$new,$new);
	echo "<td align=center><input type=\"submit\""
		. " name=\"XXX\" value=\"";
	echo "Add new Transaction";
	echo "\" style=\"background-color: abcdef;\">\n  ";
	echo "</td>"; */
	//echo "</tr>";
	

	for($tt=0;$tt<$nber;$tt++){
		echo "</tr>";
		edittrans(true,$page,$accounts,$new+$tt,$new+$tt);
		if($tt+1==$nber){	echo "<td align=center><input type=\"submit\""
		. " name=\"XXX\" value=\"";
	echo "Add new Transaction";
	echo "\" style=\"background-color: abcdef;\">\n  ";
	echo "</td>";}
	}
	echo "</form>";
	
	
	
	
	if (isset($_POST['XXX'])){
		// if(submitTransaction($new)){
			// for($tt=1;$tt<$nber;$tt++){
				// if(submitTransaction(($new+$tt))){
				// /* 	$new += 1; */
					// echo "tt\n$tt\n$new<br><BR><BR><BR>";
				// }else{		/* echo $tt; */
				// echo "errortt\n$tt\n$new";
				// }
			// }
			// /* $new += 1;
			 // */
			// //reloadPHP();
		// }
		for($i=0;$i<=15/* $nber */;$i++){
			submitTransaction(($new+$i));
			
		}
		reloadPHP();
	}
/* 	$X = "X";
	$X .= $new;
	if (isset($_POST[$X])){
		if(submitTransaction($new)){
			reloadPHP();
		}
	}	 */
	echo "</table>";
}
?>