<?php

function balanceRemainingHeader()
{
	$fourspaces = "&nbsp&nbsp&nbsp&nbsp";

	echo  "<td colspan=2 align=right>"
		. "<div id=\"small\">"
		. "$fourspaces&nbsp&nbsp Available"
		. "</div></td>"
		. "<td align=right>"
		. "<div id=\"small\">"
		. "$fourspaces Limit"
		. "</div></td>";
}

function balanceRemaining($AccountName,$Amount)
{
	$bal = "SELECT `Budget` FROM `".PREFIX.ACCOUNTS.
		 . "` WHERE `name` = '$AccountName' LIMIT 1 ";

	$resultbal = mysql_query($bal)
		or die("Error in query: $bal." . mysql_error());

	if (mysql_num_rows($resultbal) > 0)
	{
		$fourspaces = "&nbsp&nbsp&nbsp&nbsp";

		$row = mysql_fetch_row($resultbal);
		echo  "<td align=right>"
			. "<div id=\"small\">$fourspaces ";
		if ($Amount)
		{
			printf("%.2f", $row[0] + $Amount);
		}
		else
		{
			echo $row[0];
		}
			
		echo  "</div></td>"
			. "<td align=right>"
			. "<div id=\"small\">$fourspaces ". $row[0] . "</div></td>";
	}
	else
	{
		die($bal);
	}
	mysql_free_result($resultbal);
}
?>