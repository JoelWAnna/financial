<html>
<head><title>Financial 0.9.5.2</title>

<?php
require_once("f-config.php");
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
	echo "<!--";
	echo "<link href=\"" .$app
		. "support/styles.css\" rel=\""
		. "stylesheet\" type=\"text/css\">";
	echo "-->";
?>
</head>

<?php //Initialize
	$page = $_GET['page'];
	$accounttype;
	$accounts;
	//setupSql();
	$connection = mysql_connect(HOSTNAME, USERNAME, PASSWORD)
		or die('Unable to connect !');
	setupAcc($accounttype,$accounts);
	echo "<body>";
	pagelayout($page,$accounttype,$accounts);
	mysql_close($connection); 
?>
<?php function setupSql(){
	echo 'poop';
}
?>
</body>
</html>