<html>
<head><title>Financial 0.9.5.3.5b</title><?php
	error_reporting(0);
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
?><!--<link href="<?php echo$app; ?>support/styles.css" rel="stylesheet" type="text/css">
--><?php
	require_once("f-config.php");
	$page = $_GET['page'];
	$accounttype;
	$accounts;
	$connection = mysql_connect(HOSTNAME, USERNAME, PASSWORD)
		or die('Unable to connect !');
	mysql_select_db(DATABASENAME)
		or die('Unable to select database! DATABASENAME');
	setupAcc($accounttype,$accounts);
?></head>
<body><?php
	pagelayout($page,$accounttype,$accounts);
	mysql_close($connection); 
?></body>
</html>