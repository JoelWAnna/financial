<?php function sumMonth($toOrFrom, $account, $month = 0, $day = 0, $year = 0)
{
 	if(!$month)
	{
		$month = (int)date("m");
	}
	if(!$day)
	{
		$day = (int)date("d");
	}
	if(!$year)
	{
		$year = (int)date("Y");
	}

	if ($month == 1)
	{
		$month2 = 12;
		$year2 = $year -1;
	}
	else
	{
		$month2 = $month-1;
		$year2=$year;
	}
	
	return "SELECT SUM( `amount` ) FROM `".PREFIX.TRANSACTIONS."` "
		.  "WHERE (((`month` = $month && `day` <= $day && `year` = $year ) "
		.  "OR (`month` = $month2 && `day` > $day && `year` = $year2 )) "
		.  "&& ( `$toOrFrom account` = $account ))";
}
?>