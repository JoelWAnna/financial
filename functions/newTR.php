<?php function newTR(&$page,&$accounts){
	echo "<table border=3 align=center>";
	$new = newestTransaction();
	$bill = newestBill();
		if (isset($_POST['transactions']) | isset($_POST['Bills'])){
			unset($_POST['transactions']);
			$nber=$_POST['dayo'];
		}else{
			$nber=1;
		}
		test($nber,'o');
		echo "\n    <form action=\"" . $_SERVER['PHP_SELF']."\" method=\"post\">";
		
		
		
		if (isset($_POST['Bills'])){		
			unset($_POST['Bills']);		
			for($tt=0;$tt<$nber;$tt++){
				editBill($page,$accounts,$bill+$tt);
				echo "</tr>";
			}
			echo "<tr>";
			echo "<td align=center colspan=7><input type=\"submit\""
				. " name=\"billsSubmit\" value=\"";
			echo "Add new bILLS";
			echo "\" style=\"background-color: abcdef;\">\n  ";
			echo "</td>" . "</form>" . "</tr>";
			
			
		}else{

			
			
			for($tt=0;$tt<$nber;$tt++){
			
				edittrans(true,$page,$accounts,$new+$tt,$new+$tt);
				echo "</tr>";
			}		
			echo "<tr>";
			echo "<td align=center colspan=7><input type=\"submit\""
				. " name=\"XXX\" value=\"";
			echo "Add new Transaction(s)";
			echo "\" style=\"background-color: abcdef;\">\n  ";
			echo "</td>" . "</form>" . "</tr>";
		}
	
	
		if (isset($_POST['XXX'])){
			unset($_POST['XXX']);	
			for($i=0;$i<15;$i++){
				submitTransaction(($new+$i));
			}
			reloadPHP();
		}
		if (isset($_POST['billsSubmit'])){
			for($p=0;$p<15;$p++){
				submitBill(($bill+$p));
			}
			reloadPHP();
		}
}
?>

<?php function test($nber,$letter){
	echo "<tr><form action=\"" . $_SERVER['PHP_SELF']. "\" method=\"post\"><td colspan=7 align=center>";
	daydropdown($nber,$letter,10);
	echo "<input type=\"submit\""
		. " name=\"transactions\" value=\"";
	echo "more transactions";
	echo "\" style=\"background-color: abcdef;\">\n  ";
	echo "<input type=\"submit\""
		. " name=\"Bills\" value=\"";
	echo "more Bills";
	echo "\" style=\"background-color: abcdef;\">\n  ";
	echo "</td>
	</form></tr>";
	}
?>