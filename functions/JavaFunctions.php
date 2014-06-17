<?php function FINinit()
{
// TODO: add things here
	jsDate();
}
?>

<?php function Panic($message)
{
echo "<script type=\"text/javascript\">\n"
	. "alert(\"$message\");"
	. "</script>";
}
?>

<?php function PanicIf($test, $message)
{
	if($test)
		Panic($message);
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


<?php
 
function jsDate(){

echo "<script type=\"text/javascript\" src=\"js/jsDateSelector.js\"></script>\n";
	
}

?>
