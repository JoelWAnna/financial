<?php function totals(&$accounts,&$accounts3,&$accounttype){
	echo "<table border=3 width=19% align=right>";
	for($index=0;$index < 100; $index++){
	
	$acc[$accounttype[$index]] =0;
		for($F=0;$F<20;$F++){
			if($accounts3[$F]==$accounttype[$index]){
				$acc[$accounttype[$index]] += currentAmount($F);
			}	
		}
		if($acc[$accounttype[$index]]){
			$total += $acc[$accounttype[$index]];
			negativeRed($acc[$accounttype[$index]]);
		?><tr><td align=center><?

		echo $acc[$accounttype[$index]];
	
		?></td><td align=center><?
		negativeRed($total);
	   echo $total;
	   ?></td></font></tr><?
		}
	}
	echo "</table>";
}
?>
