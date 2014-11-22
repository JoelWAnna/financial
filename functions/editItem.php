<?php function editItem($type, &$page, $subPage, &$all_Accounts, $number, $newtrans, $noforms=false,
						$month="", $day="", $year="", $description="", $fromAcc="", $toAcc="", $amount="")
{

	if (($type != 'bill') && ($type != 'transaction'))
	{
		return;
	}
	if (false && $noforms)
	echo "<div id=\"" . $type . "row\">\n<ul>\n";			
	if (($type == 'transaction') && !$noforms)
	{
		echo "\n    <form name=\"form$number\" action=\"" . $_SERVER['PHP_SELF']
			. "?page=$page&subPage=$subPage\" method=\"post\">\n";
	}
	echo  "    <li class=\"date no_border\">"
		. dropDownDate('m', $number, $month, 12)
		. dropDownDate('d', $number, $day, 31)
		. dropDownDate('Y',$number,$year, 2)
		. "</li>\n"
		. "    <li class=\"desc no_border\">"
		. textField($number, $description)
		. "</li>\n";

	if ($type == 'transaction')
	{
		echo "    <li class=\"account no_border\">"
			. dropDownAccount($number, 'from', $fromAcc, $page, $all_Accounts);
	}
	echo  "    <li class=\"account no_border\">"
		. dropDownAccount($number, 'to', $toAcc, $page, $all_Accounts)
		. "</li>\n"
		. "    <li class=\"hdr_funds no_border\" width=50>"
		. textField($number, $amount, 'amount')
		. "</li>\n"
		
		. "<li class=\"hdr_funds no_border\">&nbsp</li>";

	if (($type == 'transaction') && !$noforms)
	{
		echo "<li class=\"submit no_border\">";
		echo"<input type=\"submit\" name=\"X"
			.$number. "\" value=\"";
		if($newtrans){
			echo "Add New Transaction";
		}else{
			echo "Submit Changes to " . $number;
		}	
		echo "\" style=\"background-color: "
			. "abcdef;\" ></li>\n  </form></tr>";
	}
	if (false && $noforms)
	echo "</ul>\n</div>";
}
?>
