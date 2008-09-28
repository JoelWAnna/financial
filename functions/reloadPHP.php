<?php function reloadPHP(){
	echo "<script type=\"text/javascript\">"
		. "function load()"
		. "{"
		. "window.location.replace(\"".$PHP_SELF ."\");"
		. "}"
		. "</script>";
	echo "<script type=\"text/javascript\">"
		. "load();"
		. "</script>";
}
?>