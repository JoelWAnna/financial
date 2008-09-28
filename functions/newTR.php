<?php function newTR($page,&$accounts){
	?><div id="newtr"><table border=3 align=center><?
	$nber=$_POST['dayo'];////////////////////////////////
	if(!$nber){$nber=1;}
	$billorTrans = 'trans';
	if(isset($_POST['bills']) | isset($_POST['billsSubmit']))
	{	$billorTrans = 'bill';	}
	addMore($nber,'o');////////////////////////////////
	$num = newest($billorTrans);
	echo "\n    <form action=\"" . $_SERVER['PHP_SELF']."\" method=\"post\">";
	for($j=0;$j<$nber;$j++){
		editItem($billorTrans,$page,$accounts,($num+$j),true,true);
		echo "</tr>";
	}
	if($billorTrans == 'trans'){
		$billorTrans .= 'action';
	}
	echo "<tr><td align=center colspan=7><input type=\"submit\""
		. " name=\"" . $billorTrans . "sSubmit\" value=\""
		. "Add new ". $billorTrans . "s\" style=\"background-color:"
		. " abcdef;\">\n  </td>" . "</form>" . "</tr>";	
	$submit=$billorTrans.'sSubmit';
	if (isset($_POST[$submit])){
		if($billorTrans=='transaction'){$billorTrans='trans';}
		for($i=0;$i<15;$i++){
			submitItem($billorTrans,($num+$i));
		}
		reloadPHP();
	}
	?></div><?
}?>
<?php function addMore($number,$letter){
	echo "<tr><form action=\"" . $_SERVER['PHP_SELF']. "\" method=\"post\"><td colspan=7 align=center>";
	dropDown(d,$letter,$number,10);
	echo "<input type=\"submit\""
		. " name=\"transactions\" value=\"";
	echo "more transactions";
	echo "\" style=\"background-color: abcdef;\">\n  ";
	echo "<input type=\"submit\""
		. " name=\"bills\" value=\"";
	echo "more Bills";
	echo "\" style=\"background-color: abcdef;\">\n  ";
	echo "</td>
	</form></tr>";
}?>