<?php function editItem($type,&$page,&$accounts,$number,$newtrans,
/*$type= bill or trans*/			$noforms, $month, $day, $year,
						$description,$toAcc,$fromAcc,$amount){


	if($type == 'trans'){
		if(!$noforms){
		echo "\n    <tr><form action=\"" . $_SERVER['PHP_SELF']. "?page="
			. $page . "\" method=\"post\">";}
	}
	
	echo "<td width=55>";
	dateDropdowns(m,$number,$month);
	echo "</td><td width=50>";
	dateDropdowns(d,$number,$day);
	echo "</td><td width=55>";
	dateDropdowns(Y,$number,$year);
	echo "</td><td width=142>";
	inputBox('description',$number,$description);
	echo "</td><td width=145>";
	accountdropdown('from',$toAcc,$accounts,$page,$number);
	echo "</td><td width=143>";
	accountdropdown('to',$fromAcc,$accounts,$page,$number);
	echo "</td><td width=50>";
	inputBox('amount',$number,$amount);
	echo "</td>";
	
	
	if($type == 'trans'&& !$noforms){

		echo "<td colSpan=\"2\" align=center>";
		echo"<input type=\"submit\""
			. " name=\"X".$number. "\" value=\"";
		if($newtrans){
			echo "Add New Transaction ";
		}
		else{
			echo "Submit Changes to ";
		}	
		echo  $number . "\" style=\"background-color: abcdef;\"></td>\n  ";
		echo "</form>";
		echo "</tr>";
		
	}
}
?>