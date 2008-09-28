<?php function editBill(&$page,&$accounts,$billNumber){


	echo "<td width=55>";
	monthdropdown(null,$billNumber);
	echo "</td><td width=50>";
	daydropdown(null,$billNumber);
	echo "</td><td width=55>";
	yeardropdown(null,null,null,$billNumber);
	echo "</td><td width=142>";
	descriptionbox(null,$billNumber);
	echo "</td><td width=145>";
	accountdropdown('to',$toAcc,$accounts,$page,$billNumber);
	echo "</td><td width=50>";
	amountbox(null,$billNumber);
	echo "</td>";
}
?>