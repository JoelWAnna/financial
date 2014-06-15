<?php

function balanceRemainingHeader()
{	echo  "<li class=\"ccHdr\">"
		. "Available"
		. "</li>"
		. "<li class=\"ccHdr\">"
		. "Limit"
		. "</li>";
}

function balanceRemaining($acct,$Amount, &$connection)
{
	$budget = Queries::GetAccountBudget($acct->number, $connection);
	$fundsAvailable = ($budget + $Amount);
	$neg = ($fundsAvailable < 0) ? "negative" : "";
	echo  "<li class=\"funds small $neg\">";
	printf("%.2f", $fundsAvailable);
	echo  "</li>";
	$neg = ($budget < 0) ? "negative" : "";
	echo "<li class=\"funds small $neg\">". $budget . "</li>";
	
}
?>