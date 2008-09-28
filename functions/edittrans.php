<?php function edittrans(&$page,&$accounts,$newtransa,$transNumber,$month, $day, $year, $description,
						$toAcc,$fromAcc,$amount){
	if($newtransa > 0){
		$newtransa++;
	}
	echo "\n    <tr><form action=\"" . $PHP_SELF. "?page="
		. $page . "&new=".$newtransa."\" method=\"post\">";
	echo "<td>";
	monthdropdown($month);
	echo "</td><td>";
	daydropdown($day);
	echo "</td><td>";
	yeardropdown($year);
	echo "</td><td>";
	descriptionbox($description);
	echo "</td><td>";
	accountdropdown('from',$toAcc,$accounts,$page);
	echo "</td><td>";
	accountdropdown('to',$fromAcc,$accounts,$page);
	echo "</td><td>";
	amountbox($amount);
	echo "</td>"
		. "<td colSpan=\"2\" align=center><input type=\"submit\""
		. " name=\"X".$transNumber. "\" value=\"";
	if($newtransa /*  > 0 */){
		echo "Add New Transaction";
	}
	else{
		echo "Submit Changes";
	}	
	echo "\" style=\"background-color: abcdef;\"></td>\n  ";
	echo "</form></tr>";
}
?>