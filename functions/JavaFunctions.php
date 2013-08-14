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

echo "<script type=\"text/javascript\">\n"
	. "function jsDateSelector(selectbox, tNumb)\n"
	. "{\n\t"
	. "var m = \"month\" + tNumb;\n\t"
	. "var monthDD = document.getElementById(m);\n\t"
	. "var month = parseInt(monthDD.options[monthDD.selectedIndex].value);\n\t"
	. "var y = \"year\" + tNumb;\n\t"
	. "var yearDD = document.getElementById(y);\n\t"
	. "var year = parseInt(yearDD.options[yearDD.selectedIndex].text);\n\t"
	. "var d = \"day\" + tNumb;\n\t"
	. "var dateDD = document.getElementById(d);\n\t"
	
	. "var leapYear = (year%100) && !(year%4);\n\t"
	. "var i = dateDD.options.length;\n\t"

	. "var max = 28;\n\t"
	. "switch ( month)\n\t"
	. "{\n\t"
	. "case 2:\n\t\t"
	. "if(leapYear) max++;\n\t\t"
	. "break;\n\t"
	. "case 4: case 6: case 9: case 11:\n\t\t"
	. "max = 30;\n\t\t"
	. "break;\n\t"
	. "default:\n\t\t"
	. "max = 31;\n\t\t"
	. "break;\n\t"
	. "}\n\t"
	. "console.log(\"case \" + max);\n\n\t"
	. "while(i > max)\n\t"
	. "{\n\t\t"
	. "i--\n\t\t;"
	. "if (i == parseInt(dateDD.options[dateDD.selectedIndex].value))\n\t\t\t;"
	. "dateDD.selectedIndex--;\n\t\t"
	. "dateDD.remove(i);\n\t\t"
	. "}\n\n\t"
	. "while(i < max)\n\t"
	. "{\n\t\t"
	. "i++\n\t\t"
	. "dateDD.options[dateDD.options.length] = new Option(i,i);\n\t"
	. "}\n"
	. "}\n"
	. "</script>\n";
}

?>
