<?php

function balanceRemainingHeader()
{	echo  "<li class=\"ccHdr\">"
		. "Available"
		. "</li>"
		. "<li class=\"ccHdr\">"
		. "Limit"
		. "</li>";
}

function balanceRemaining($acct,$Amount)
{
	$bal = "SELECT `Budget` FROM `".PREFIX.ACCOUNTS
		 . "` WHERE `number` = \"" . $acct->number . "\" LIMIT 1 ";

	$resultbal = mysql_query($bal)
		or die("Error in query: $bal." . mysql_error());

	if (mysql_num_rows($resultbal) <= 0)
	{
		die($bal);
	}
	else
	{
		$row = mysql_fetch_row($resultbal);
		$neg = (($row[0] + $Amount) < 0) ? "negative" : "";
		echo  "<li class=\"funds small $neg\">";
		printf("%.2f", $row[0] + $Amount);
		echo  "</li>";
		$neg = (($row[0]) < 0) ? "negative" : "";
		echo "<li class=\"funds small $neg\">". $row[0] . "</li>";
	}
	mysql_free_result($resultbal);
}
?>