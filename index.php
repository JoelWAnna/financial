<?php
	extract($_SERVER);
	session_start();
	if (isset($_GET['logout']) && ($_GET['logout'] == "true"))
	{
		echo "You have been logged out";
		$_SESSION = array();
	}
//define('TR','\n  <tr>');
//define('TR_','\n  </tr>');
//define('TRo','\n  <tr');

// TODO: Make user configurable
date_default_timezone_set('America/Los_Angeles');
//	error_reporting(0);
	if (!file_exists("f-config.php"))
	{
		header('Location: setup/');
	}
	require_once("f-config.php");
	$page = isset($_GET['page']) ? $_GET['page'] : 0;
	global $connection;
try {
	$connection = new PDO("mysql:host=" . HOSTNAME . ";port=3306;dbname=" . DATABASENAME . ";charset=UTF8", USERNAME, PASSWORD );
	$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//$connection = mysql_connect(HOSTNAME, USERNAME, PASSWORD)
	//	or die("Unable to connect !\n is your database set up?".
	//			"<a href=\"setup\">setup</a>");
	//mysql_select_db(DATABASENAME)
	//	or die("Unable to select database! DATABASENAME\n is your".
	//			"database set up?<a href=\"setup\">setup</a>");
	}
catch(PDOException $e) {
    echo "Error!: " . $e->getMessage() . "<br/>\n";
	 die("Unable to connect !\n is your database set up?".
				"<a href=\"setup\">setup</a>");
}
?>
<html>
<head>
<?php
FINinit();
echo "<title> ",VERSIONSTR," </title>\n";
//echo "<link href=\"resources/styles_main.css\" rel=\"stylesheet\" type=\"text/css\">\n";
//if (BrowserInfo() == "IE")
//{
//	echo "<link href=\"resources/styles_main_ie.css\" rel=\"stylesheet\" type=\"text/css\">\n";
//}
echo "<link href=\"resources/styles_account.css\" rel=\"stylesheet\" type=\"text/css\">\n";
if ($page < -1)
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
	//	echo "<link href=\"resources/styles_-1$browser.css\" rel=\"stylesheet\" type=\"text/css\">\n";
}
?>
<link rel="stylesheet" type="text/css" href="resources/styles_new.css" />
<link rel="stylesheet" type="text/css" href="resources/styles_new2.css" />
</head>
<body>
<?php
	global $authentication;
	$authentication = Authentication($connection);
	if ($authentication == false || $authentication == "invalid" ) 
	{
		die("Failed to authenticate" . $authentication);
	}
	if (isset($_GET['cleanup']) && $_GET['cleanup'] == "true" && $authentication == "Admin++")
	{
		Panic("cleanup");
		CleanupNumbers(PREFIX.TRANSACTIONS);
		CleanupNumbers(PREFIX.BILLS);
		reloadPHP("main");
	}

	$all_Accounts;
	setupAcc($page, $all_Accounts, $connection);
	if ($page > 0)
	{
		$subPage = isset($_GET['subPage']) ? $_GET['subPage'] : 1;
		AccountPageLayout($connection, $page, $all_Accounts, $subPage);

	}
	else
	{
		if ($page != -1)
		{
			

			$num_months = isset($_GET['billmonths']) ? $_GET['billmonths'] : 1;
?>
	<!--		 <div id="wrapper">
        <div id="headerwrap">
        <div id="header">
           <p>
				header
			</p>
        </div>
        </div>
		-->

        <div id="navigationwrap">
        <div id="navigation">
            <p><?php
		if($REMOTE_ADDR != "127.0.0.1" && $REMOTE_ADDR !="::1")
				echo "<right><a href=?logout=true>logout</a></right>";
			echo "<a href=?page=-1>AccountSetup</a>";
?></p>
        </div>
        </div>
        <div id="bills_wrap">
		<?php
			billsDue($page, $all_Accounts, $num_months, $connection);
?>
        </div>
		
        <div id="contentwrap">
        <div id="content">
		<?php
			// Main Page Columns
			if ($all_Accounts)
			{
				ShowMainPageColumn(true, $page, $all_Accounts, $connection);
				ShowMainPageColumn(false, $page, $all_Accounts, $connection);
?> 
        </div>
        </div>
        <div id="rightcolumnwrap">
				<?php
				totals($all_Accounts, $connection);
				?>
				</div>
				<?php
			}
			?>
		
        <div id="footerwrap">
		<?php
			if(!$page)
			{
				newTR(0, $all_Accounts);
			}?>
		</div>
		<?php
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
			$i = editAcc('new', $all_Accounts);
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
		?>
		</div>
		<?php
	}
	$connection = null; 
?>
</body>
</html>
