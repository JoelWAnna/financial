<?php function editItem($type,&$page,&$accounts,$number,$newtrans,
/*$type= bill or trans*/			$noforms, $month, $day, $year,
						$description,$fromAcc,$toAcc,$amount){
/**/	if($type == 'trans' && !$noforms){
/**/		echo "\n    <tr><form action=\"" . $_SERVER['PHP_SELF']
/**/			. "?page=" . $page . "\" method=\"post\">";
/**/	}
	echo "<td width=55>";
	dropDown(m,$number,$month);
	echo "</td><td width=50>";
	dropDown(d,$number,$day);
	echo "</td><td width=55>";
	dropDown(Y,$number,$year);
	echo "</td><td width=142>";
	dropDown('words',$number,$description);
/**/	if($type == 'trans'){
/**/		echo "</td><td width=145>";
/**/		dropDown('account',$number,'from',$fromAcc,$page,$accounts);
/**/	}
	echo "</td><td width=143>";
	dropDown('account',$number,'to',$toAcc,$page,$accounts);
	echo "</td><td width=50>";
	dropDown('amount',$number,$amount);
	echo "</td>";
/**/	if($type == 'trans'&& !$noforms){
/**/		echo "<td colSpan=\"2\" align=center>";
/**/		echo"<input type=\"submit\" name=\"X"
/**/			.$number. "\" value=\"";
/**/		if($newtrans){
/**/			echo "Add New Transaction ";
/**/		}else{
/**/			echo "Submit Changes to ";
/**/		}	
/**/		echo  $number . "\" style=\"background-color: "
/**/			. "abcdef;\"></td>\n  </form></tr>";
/**/	}
}?>
