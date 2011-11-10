<?php function editItem($type, &$page, $subPage, &$all_Accounts, $number, $newtrans, $noforms=false,
						$month="", $day="", $year="", $description="", $fromAcc="", $toAcc="", $amount="")
{

	if (($type != 'bill') && ($type != 'transaction'))
	{
		return;
	}
						
	if (($type == 'transaction') && !$noforms)
	{
		echo "\n    <form name=\"form$number\" action=\"" . $_SERVER['PHP_SELF']
			. "?page=$page&subPage=$subPage\" method=\"post\">\n";
	}
	echo  "    <li class=\"date\">"
		. dropDownDate('m', $number, $month, 12)
		. dropDownDate('d', $number, $day, 31)
		. dropDownDate('Y',$number,$year, 2)
		. "</li>\n"
		. "    <li class=\"desc\">"
		. textField($number, $description)
		. "</li>\n";

	if ($type == 'transaction')
	{
		echo "    <li class=\"account\">"
			. dropDownAccount($number, 'from', $fromAcc, $page, $all_Accounts);
	}
	echo  "    <li class=\"account\">"
		. dropDownAccount($number, 'to', $toAcc, $page, $all_Accounts)
		. "</li>\n"
		. "    <li class=\"\" width=50>"
		. textField($number, $amount, 'amount')
		. "</li>\n";

	if (($type == 'transaction') && !$noforms)
	{
		echo "<td colSpan=\"2\" align=center>";
		echo"<input type=\"submit\" name=\"X"
			.$number. "\" value=\"";
		if($newtrans){
			echo "Add New Transaction";
		}else{
			echo "Submit Changes to " . $number;
		}	
		echo "\" style=\"background-color: "
			. "abcdef;\" ></td>\n  </form></tr>";
	}
}
?>
