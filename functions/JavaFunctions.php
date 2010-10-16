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

<?php function reloadPHP($page = "")
{
	switch($page)
	{
	case "main":
		$page = 0;
		break;
	case "":
		$page=$_GET['page'];
		break;
	}
	echo "<script type=\"text/javascript\">"
		. "function load()"
		. "{"
		. "window.location.replace(\"" . $_SERVER['PHP_SELF'] . "?page=$page\");"
		. "}"
		. "load();"
		. "</script>"; 
}
?>
