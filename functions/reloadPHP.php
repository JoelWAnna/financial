<?php function reloadPHP(){
	$page=$_GET['page'];
	echo "<script type=\"text/javascript\">"
		. "function load()"
		. "{"
		. "window.location.replace(\"".$_SERVER['PHP_SELF'] ."?page="
		. $page . "\");"
		. "}"
		. "</script>";
	echo "<script type=\"text/javascript\">"
		. "load();"
		. "</script>";
}
?>