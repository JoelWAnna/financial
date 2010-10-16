<?php
	extract($_SERVER);
	session_start();
	if ($_GET['logout'] == "true")
	{
		echo "You have been logged out";
		$_SESSION = array();
	}
$ver = 'Financial 0.9.8.0.1';
define('TR','\n  <tr>');
define('TR_','\n  </tr>');
define('TRo','\n  <tr');

// TODO: Make user configurable
date_default_timezone_set('America/Los_Angeles');
//	error_reporting(0);
	if (!file_exists("f-config.php"))
	{
		header('Location: setup/');
	}
	require_once("f-config.php");
	$page = $_GET['page'];
	$ACC_TYPE;
	$ACC_1;
	$ACC_2;
	$ACC_3;
	$connection = mysql_connect(HOSTNAME, USERNAME, PASSWORD)
		or die("Unable to connect !\n is your database set up?".
				"<a href=\"setup\">setup</a>");
	mysql_select_db(DATABASENAME)
		or die("Unable to select database! DATABASENAME\n is your".
				"database set up?<a href=\"setup\">setup</a>");
?>
<html>
<head>
<?php
FINinit();
echo "<title> $ver </title>\n";
echo "<link href=\"resources/styles_main.css\" rel=\"stylesheet\" type=\"text/css\">\n";
if (BrowserInfo() == "IE")
{
	echo "<link href=\"resources/styles_main_ie.css\" rel=\"stylesheet\" type=\"text/css\">\n";
}
echo "<link href=\"resources/styles_account.css\" rel=\"stylesheet\" type=\"text/css\">\n";
if ($page < -1 && ($page != ""))
{
switch(BrowserInfo())
{
case "IE":
	$browser = "_ie";
	break;
case "GC":
case "FF":
default:
	$browser = "";
	break;
}
	echo "<link href=\"resources/styles_-1$browser.css\" rel=\"stylesheet\" type=\"text/css\">\n";
}
?>
</head>
<body>
<?php
	global $authentication;
	$authentication = Authentication();
	if ($authentication == false || $authentication == "invalid" ) return;
	if ($_GET['cleanup'] == "true" && $authentication == "Admin++")
	{
		Panic("cleanup");
		CleanupNumbers(PREFIX.TRANSACTIONS);
		CleanupNumbers(PREFIX.BILLS);
		reloadPHP("main");
	}
	setupAcc($page, $ACC_TYPE, $ACC_1, $ACC_2, $ACC_3);
	if ($page > 0)
	{
		$subPage = $_GET['subPage'];
		if ($subPage == "")	$subPage = 1;
		AccountPageLayout($page, $ACC_TYPE, $ACC_1, $subPage);

	}
	else
	{
		if ($page != -1)
		{
			if($REMOTE_ADDR != "127.0.0.1" && $REMOTE_ADDR !="::1")
				echo "<right><a href=?logout=true>logout</a></right>";
			echo "<center><a href=?page=-1>AccountSetup</a></center>";
			billsDue($page, $ACC_2);
		// Main Page Columns
			if ($ACC_1)
			{
				ShowMainPageColumn(true, $page, $ACC_TYPE, $ACC_1, $ACC_2, $ACC_3);
				ShowMainPageColumn(false, $page, $ACC_TYPE, $ACC_1, $ACC_2, $ACC_3);
				totals($ACC_1,$ACC_3,$ACC_TYPE);
			}
			if(!$page)
			{
				newTR(0,$ACC_1);
			}
		}
		else
		{
				echo  "<div align=center>\n"
					. "  <a href=\"". $_SERVER['PHP_SELF'] ."?page=0\">Go to the Main Page</a>\n"
					. "</div>\n";
		}
		if ($page)
		{
			echo  "<table border=3 align=center>\n"
				. "<tr>";
			$i = editAcc('new',$ACC_TYPE);
			$foo = "account" . $i;
			if (isset($_POST[$foo]))
			{
				if(submitAcc($i,'new'))
				{
					reloadPHP();
				}
			}
			echo "</tr></table>";
		}
	}
	mysql_close($connection); 
?>
</body>
</html>
