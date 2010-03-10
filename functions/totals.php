<?php function totals(&$accounts,&$accounts3,&$accounttype)
{
	$exit = true;
	for ($index = 0; !$exit && $accounttype[$index]; $index++)
	{
		if (($accounttype[$index] != "Expense") &&
			($accounttype[$index] != "Income") &&
			($accounttype[$index] != "removed"))
		{
		
		$exit = false;
		}
	}
	if ($exit) return;

	for ($index = 0; $accounttype[$index]; $index++)
	{
		if (($accounttype[$index] != "Expense") &&
			($accounttype[$index] != "Income") &&
			($accounttype[$index] != "removed"))
		{
			$acc[$accounttype[$index]] = 0;
			for ($i = 0; $i < 20; $i++)
			{
				if($accounts3[$i]==$accounttype[$index])
				{
					$acc[$accounttype[$index]] += currentAmount($i);
				}
			}
			if($acc[$accounttype[$index]])
			{
				echo "  <li class=\"name\">$accounttype[$index]</li>\n";
				$total += $acc[$accounttype[$index]];

				$neg = ($acc[$accounttype[$index]] < 0) ? " negative" : ""; 

				echo  "  <li class=\"funds$neg\">"
					. $acc[$accounttype[$index]]
					. "</li>\n";
				
				
				if($total<0)
				{
					echo "<li class=\"fundsneg\">";
				}
				else
				{
					echo "<li class=\"funds\">";
				}
				
				echo $total;
				echo "</li>";
			}
		}
	}
	echo "</ul>\n</div>";
}
?>
