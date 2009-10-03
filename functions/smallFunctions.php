<?php function validAccountforThisPage($type, $left, $page)
{
	if(($type == "removed") && ($page != -2))
	{
		return false;
	}
 	
	if (($type!= "Checking") && ($type != "Savings") &&
		($type!= "Credit Card")/*&& ($type!= "Loan")*/)
	{
		return !$left;
	}
	
	
	return $left;
}
?>

<?php function selectedString($i,$j,$s){
	if($s)
	{
		if($s == $i)
		{
			return "selected=\"selected\">";
		}
	}
	else
	{
		if($i == $j)
		{
			return "selected=\"selected\">";
		}
	}
	return ">";
}
?>
<?php function reloadPHP()
{
	$page=$_GET['page'];
	echo "<script type=\"text/javascript\">"
		. "function load()"
		. "{"
		. "window.location.replace(\"" . $_SERVER['PHP_SELF'] . "?page=$page\");"
		. "}"
		. "load();"
		. "</script>"; 
}
?>