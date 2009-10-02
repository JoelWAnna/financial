<?php function totals(&$accounts,&$accounts3,&$accounttype)
{
	echo  "<div id=\"Totals\">\n"
		. "<table border=3>";

	for ($index = 0; $index < 100; $index++)
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
				$total += $acc[$accounttype[$index]];
					
				echo "<tr><td align=center>";

				if ($acc[$accounttype[$index]] < 0)
				{
					echo "<div id=\"negative\">";
				}
				else
				{
					echo "<div>";
				}
				
				echo $acc[$accounttype[$index]];
				echo "</div>";
				
				echo "</td><td align=center>";
				
				if($total<0)
				{
					echo "<div id=\"negative\">";
				}
				else
				{
					echo "<div>";
				}
				
				echo $total;
				echo "</div>";
				echo "</td></tr>";
			}
		}
	}
	echo "</table>\n</div>";
}
?>
