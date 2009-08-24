<?php function totals(&$accounts,&$accounts3,&$accounttype){?>
	<div id="Totals"><table border=3>
<?	for($index=0;$index < 100; $index++){
	if(!(($accounttype[$index] == "Expense") ||
		 ($accounttype[$index] == "Income") ||
		 ($accounttype[$index] == "removed")))
	{
	$acc[$accounttype[$index]] =0;
		for($F=0;$F<20;$F++){
			if($accounts3[$F]==$accounttype[$index]){
				$acc[$accounttype[$index]] += currentAmount($F);
			}
		}
		if($acc[$accounttype[$index]]){
			$total += $acc[$accounttype[$index]];
			
		?><tr><td align=center><?
		echo "<div";
		if($acc[$accounttype[$index]]<0){echo " id=\"negative\"";}
		echo ">";
		echo $acc[$accounttype[$index]];
		echo "</div>";
		?></td><td align=center><?
		
		echo "<div";
		if($total<0){echo " id=\"negative\"";}
		echo ">";
		echo $total;
		echo "</div>";
		?></td></tr><?
		}
	}
	}?></table></div>
<?
}
?>
