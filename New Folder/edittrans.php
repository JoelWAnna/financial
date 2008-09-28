<?php function edittrans($noforms,&$page,&$accounts,$newtransa,$transNumber,$month, $day, $year, $description,
						$toAcc,$fromAcc,$amount){
	if($newtransa > 0){
		$newtransa++;
	}
	if(!$noforms){
	echo "\n    <tr><form action=\"" . $_SERVER['PHP_SELF']. "?page="
		. $page . "\" method=\"post\">";}
	echo "<td width=55>";
	dateDropdowns(m,$transNumber,$month);
	echo "</td><td width=50>";
	dateDropdowns(d,$transNumber,$day);
	echo "</td><td width=55>";
	dateDropdowns(Y,$transNumber,$year);
	echo "</td><td width=142>";
	inputBox('description',$transNumber,$description);
//	descriptionbox($description,$transNumber);
	echo "</td><td width=145>";
	accountdropdown('from',$toAcc,$accounts,$page,$transNumber);
	echo "</td><td width=143>";
	accountdropdown('to',$fromAcc,$accounts,$page,$transNumber);
	echo "</td><td width=50>";
	//amountbox($amount,$transNumber);
	inputBox('amount',$transNumber,$amount);
	echo "</td>";
	if(!$noforms){

	echo "<td colSpan=\"2\" align=center>";
	
	echo"<input type=\"submit\""
		. " name=\"X".$transNumber. "\" value=\"";
	if($newtransa){
		echo "Add New Transaction ";
	}
	else{
		echo "Submit Changes to ";
	}	
	echo  $transNumber . "\" style=\"background-color: abcdef;\"></td>\n  ";
	echo "</form>";
	echo "</tr>";
	}
}
?>