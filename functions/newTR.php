<?php function newTR($page,&$accounts)
{
?>
<div id="NewTransactions">
  <ul>
<?php
	$nber = $_POST['dayo'];

	if(!$nber)
	{
		$nber=1;
	}
	
	$billorTrans = 'transaction';
	if (isset($_POST['bills']) | isset($_POST['billsSubmit']))
	{
		$billorTrans = 'bill';
	}
	addMore($nber,'o');
	$num = newest($billorTrans);
	echo  "\n    <form action=\"" . $_SERVER['PHP_SELF']
		. "?page=$page&num=$nber\" method=\"post\">";


	for ($j = 0; $j < $nber; $j++)
	{
		editItem($billorTrans,$page,$accounts,($num+$j),true,true);
	}
	

	$submit = $billorTrans . 'sSubmit';
	$disable = userIsAdmin() ? "" : "disabled='disabled'";
	
	echo  "<li class=\"submitTrans\">"
		. "<input type=\"submit\" name=\"$submit\" "
		. "value=\"Add new $billorTrans" . "s\" "
		. "style=\"background-color: abcdef;\" $disable >\n"
		. "  </li>";

	if (isset($_POST[$submit]))
	{
		$previousSubmit = $_GET['num'];
		
		for ($i = 0; $i < $previousSubmit; $i++)
		{
			submitItem($billorTrans,($num+$i));
		}
		reloadPHP();
	}
	echo  "    </form>\n"
		. "  </ul>\n"
		. "</div>\n";
}
?>

<?php function addMore($number,$letter)
{
	echo  "\n    <li class=\"addMore\">"
		. "\n      <form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">";

	echo dropDownDate('d', $letter, $number, 10);

	echo "\n      <input type=\"submit\" name=\"transactions\" "
		. "value=\"more transactions\" style=\"background-color: abcdef;\">\n";
	echo  "\n      <input type=\"submit\" name=\"bills\" "
		. "value=\"more Bills\" style=\"background-color: abcdef;\">\n";
	echo  "\n      </form>"
		. "\n    </li>";
}
?>