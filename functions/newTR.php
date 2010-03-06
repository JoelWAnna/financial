<?php function newTR($page,&$accounts)
{
?>
<div id="NewTransactions">
 <ul>
 <table border=3 align=center>
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
		echo "</tr>";
	}
	

	$submit = $billorTrans . 'sSubmit';
	
	echo  "<tr>"
		. "<td align=center colspan=7>"
		. "<input type=\"submit\" name=\"$submit\" "
		. "value=\"Add new $billorTrans" . "s\" "
		. "style=\"background-color: abcdef;\">\n"
		. "  </td>"
		. "</form>"
		. "</tr>";


	if (isset($_POST[$submit]))
	{
		$previousSubmit = $_GET['num'];
		
		for ($i = 0; $i < $previousSubmit; $i++)
		{
			submitItem($billorTrans,($num+$i));
		}
		reloadPHP();
	}
	echo "</ul></div>";
}
?>

<?php function addMore($number,$letter)
{
	echo  "<tr>"
		. "<form action=\"" . $_SERVER['PHP_SELF']. "\" method=\"post\">"
		. "<td colspan=7 align=center>";

	echo dropDownDate('d', $letter, $number, 10);

	echo "<input type=\"submit\" name=\"transactions\" "
		. "value=\"more transactions\" style=\"background-color: abcdef;\">\n";
	echo  "  <input type=\"submit\" name=\"bills\" "
		. "value=\"more Bills\" style=\"background-color: abcdef;\">\n";
	echo  "  </td>"
		. "</form></tr>";
}
?>