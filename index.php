<?php
$ver = 'Financial 0.9.7.5.0';
define('TR','\n  <tr>');
define('TR_','\n  </tr>');
define('TRo','\n  <tr');

	error_reporting(0);
	
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
<head><title><?php echo $ver; ?></title>
<!--<link href="<?php// echo$app; ?>support/styles.css" rel="stylesheet" type="text/css">-->
<link href="resources/financialstyles.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
	setupAcc($page, $ACC_TYPE, $ACC_1, $ACC_2, $ACC_3);
	if ($page > 0)
	{
		pagelayout2($page,$ACC_TYPE,$ACC_1);
	}
	else
	{
		if ($page != -1)
		{
			billsDue($page, $ACC_2);
?><!-- <table><tr><TD  width=19% valign=top></td><TD width=60%> --><?
			mainPage($page,$ACC_TYPE,$ACC_1,$ACC_2,$ACC_3);
?><!-- </td><td width=19% valign=top> --><?
			totals($ACC_1,$ACC_3,$ACC_TYPE);
?><!--</td></tr></table>--><?
			newTR(0,$ACC_1);
		}
		if ($page)
		{
			echo "<table border=3 align=center><tr>";
			$i =editAcc('new',$ACC_TYPE);
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


<?/*
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