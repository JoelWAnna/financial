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
	$bal = "SELECT `Budget` FROM `".PREFIX.ACCOUNTS
		 . "` WHERE `number` = \"" . $acct->number . "\" LIMIT 1 ";

	$resultbal = $connection->query($bal)
		or die("Error in query: $bal." . mysql_error());

	if ($resultbal->rowCount() <= 0)
	{
		die($bal);
	}
	else
	{
		$row = $resultbal->fetch();
		$neg = (($row[0] + $Amount) < 0) ? "negative" : "";
		echo  "<li class=\"funds small $neg\">";
		printf("%.2f", $row[0] + $Amount);
		echo  "</li>";
		$neg = (($row[0]) < 0) ? "negative" : "";
		echo "<li class=\"funds small $neg\">". $row[0] . "</li>";
	}
	//mysql_free_result($resultbal);
}
?>