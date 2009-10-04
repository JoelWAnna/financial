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
			. "?page=$page\" method=\"post\">";
	}
	echo "<td width=55>";
	echo dropDownDate(m, $number, $month, 12);
	echo "</td><td width=50>";
	
	$maxDay = 31;
	switch ($month)
	{
	case 2:
		$maxDay--;
		if (!($year%100) || ($year%4))
		{	// Not Leap Year
			$maxDay--;
		}
	case 4: case 6: case 9: case 11:
		$maxDay--;
		break;
	default:
		break;
	}
	
	echo dropDownDate(d, $number, $day, $maxDay);
	echo "</td><td width=55>";
	echo dropDownDate('Y',$number,$year, 2);
	echo "</td><td width=142>";
	textField($number, $description);
	if ($type == 'transaction')
	{
		echo "</td><td width=145>";
		dropDownAccount($number, 'from', $fromAcc, $page, $accounts);
	}
	echo "</td><td width=143>";
	dropDownAccount($number, 'to', $toAcc, $page, $accounts);
	echo "</td><td width=50>";
	textField($number, $amount, 'amount');
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
