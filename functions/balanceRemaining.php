<?php

function balanceRemainingHeader()
{	echo  "<li class=\"ccHdr\">"
		. "Available"
		. "</li>"
		. "<li class=\"ccHdr\">"
		. "Limit"
		. "</li>";
}

function balanceRemaining($AccountName,$Amount)
{
	$bal = "SELECT `Budget` FROM `".PREFIX.ACCOUNTS
		 . "` WHERE `name` = '$AccountName' LIMIT 1 ";

	$resultbal = mysql_query($bal)
		or die("Error in query: $bal." . mysql_error());

	if (mysql_num_rows($resultbal) <= 0)
	{
		die($bal);
	}
	else
	{
		$row = mysql_fetch_row($resultbal);
		echo  "<li class=\"small\">";
		if ($Amount)
		{
			printf("%.2f", $row[0] + $Amount);
		}
		else
		{
			echo $row[0];
		}
		echo  "</li>"
			. "<li class=\"small\">". $row[0] . "</li>";
	}
	mysql_free_result($resultbal);
}
?>