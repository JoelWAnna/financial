<?php function editItem($type, &$page, &$accounts, $number, $newtrans, $noforms,
						$month="", $day="", $year="", $description="", $fromAcc="", $toAcc="", $amount="")
{

	if (($type != 'bill') && ($type != 'transaction'))
	{
		return;
	}

						
		if (($type == 'transaction') && !$noforms)
		{
			echo "\n    <tr><form action=\"" . $_SERVER['PHP_SELF']
				. "?page=" . $page . "\" method=\"post\">";
		}
	echo "<td width=55>";
	echo dropDownString(m,$number,$month);
	echo "</td><td width=50>";
	echo dropDownString(d,$number,$day);
	echo "</td><td width=55>";
	echo dropDownString(Y,$number,$year);
	echo "</td><td width=142>";
	echo dropDownString('words',$number,$description);
		if ($type == 'transaction')
		{
			echo "</td><td width=145>";
			echo dropDownString('account',$number,'from',$fromAcc,$page,$accounts);
		}
	echo "</td><td width=143>";
	echo dropDownString('account',$number,'to',$toAcc,$page,$accounts);
	echo "</td><td width=50>";
	echo dropDownString('amount',$number,$amount);
	echo "</td>";
		if (($type == 'transaction') && !$noforms)
		{
			echo "<td colSpan=\"2\" align=center>";
			echo"<input type=\"submit\" name=\"X"
				.$number. "\" value=\"";
			if($newtrans){
				echo "Add New Transaction ";
			}else{
				echo "Submit Changes to ";
			}	
			echo  $number . "\" style=\"background-color: "
				. "abcdef;\"></td>\n  </form></tr>";
		}
}?>
