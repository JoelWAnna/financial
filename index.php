<?php
$ver = 'Financial 0.9.8.0.0beta';
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
echo "\n\n<title> $ver </title>";
	echo "<style type=\"text/css\">";
	echo  "#Bills {\n"
		. "width:200px;\n"
		. "font-family:arial, helvetica, sans-serif;\n"
		. "font-size:9pt;\n"
		. "color:#000;\n"
		//. "text-align:center;\n"
		. "text-align:left;\n"
		. "line-height:30px;\n"
		. "} ";
	
	echo  "#Bills ul {\n"
    	. "width:200px;\n"
    	. "margin:0;\n"
    	. "padding:0;\n"
		. "} \n";
	echo  "#Bills ul li {\n"
    	. "width:50px;\n"
    	. "height:30px;\n"
    	. "display:block;\n"
    	. "float:left;\n"
    	. "list-style:none;\n"
    	. "border:5px solid #fff;\n"
	  	. "font-size:7pt;\n"
		. "text-align:center;\n"
    	. "margin:0;\n"
		. "} ";
		
	echo  "#Bills ul li.hdr {\n"
    	. "background:#666;\n"
    	. "color:#fff;\n"
    	//. "font-weight:bold;\n"
    	. "}\n";
		
		echo  "#Bills ul li.hdr2 {\n"
    	. "width:70px;\n"
    	. "background:#666;\n"
    	. "color:#fff;\n"
    	//. "font-weight:bold;\n"
	  	. "font-size:7pt;\n"
		. "text-align:center;\n"
    	. "}\n";
		
		
	echo "#Bills ul li.ent { background:#ccc; } ";
	echo "#Bills ul li.ent2 { width:70px;background:#ccc; } ";
	echo "</style>";
?>
<!--<link href="<?php// echo$app; ?>support/styles.css" rel="stylesheet" type="text/css">-->
<link href="resources/financialstyles.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
	setupAcc($page, $ACC_TYPE, $ACC_1, $ACC_2, $ACC_3);
	if ($page > 0)
	{
		AccountPageLayout($page, $ACC_TYPE, $ACC_1);
	}
	else
	{
		if ($page != -1)
		{
			billsDue($page, $ACC_2);
?><!-- <table><tr><TD  width=19% valign=top></td><TD width=60%> --><?php
		// Main Page Columns
			if ($ACC_1)
			{
				echo "<div id=\"Main\">"
					."<table border=3 class=\"t1\">\n"
					."<tr>";
					ShowMainPageColumn(true, $page, $ACC_TYPE, $ACC_1, $ACC_2, $ACC_3);
					ShowMainPageColumn(false, $page, $ACC_TYPE, $ACC_1, $ACC_2, $ACC_3);
				echo "</tr>\n"
					."</table>";
		?><!-- </td><td width=19% valign=top> --><?php
				totals($ACC_1,$ACC_3,$ACC_TYPE);
			}
		?><!--</td></tr></table>--><?php
			newTR(0,$ACC_1);
		}
		else
		{
				echo "<div align=center><a href=\"?page=0\">Go to the Main Page</a></div>";
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



<?php $F/*
	extract($_POST);extract($_SERVER);
	$host = "127.0.0.1";$local = true;$timeout = "1";
	if ($REMOTE_ADDR) {
		if ($REMOTE_ADDR != $host) {
			$local = false;
		}
	}
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS']))
		{$uri2 = 'https://';}
		else {$uri2 = 'http://';}
	$uri2 .= $_SERVER['HTTP_HOST'];
	$fti = 'ftp://' . $_SERVER['HTTP_HOST'];
	$uri = $uri2 . '/';
	$app = $uri . 'webapps/';
*/?>