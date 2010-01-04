<?php function FINinit()
{
// TODO: add things here
}
?>

<?php function Panic($message)
{
echo "<script type=\"text/javascript\">\n"
	. "alert(\"$message\");"
	. "</script>";
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
