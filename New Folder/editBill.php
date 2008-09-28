<?php function editBill(&$page,&$accounts,$billNumber){


	echo "<td width=55>";
	dateDropdowns(m,$billNumber);
	echo "</td><td width=50>";
	dateDropdowns(d,$billNumber);
	echo "</td><td width=55>";
	dateDropdowns(Y,$billNumber);
	echo "</td><td width=142>";
	inputBox('description',$billNumber);
	echo "</td><td width=145>";
	accountdropdown('to',$toAcc,$accounts,$page,$billNumber);
	echo "</td><td width=50>";
	//amountbox(null,$billNumber);
	inputBox('amount',$billNumber);
	echo "</td>";
}
?>


