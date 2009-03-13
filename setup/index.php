<?php
//define('WP_INSTALLING', true);
//These three defines are required to allow us to use require_wp_db() to load the database class while being wp-content/wp-db.php aware
/* define('ABSPATH', dirname(dirname(__FILE__)).'/');
define('WPINC', 'wp-includes');
define('WP_CONTENT_DIR', ABSPATH . 'wp-content');

require_once('../wp-includes/compat.php');
require_once('../wp-includes/functions.php');
require_once('../wp-includes/classes.php');
 */
if (!file_exists('f-config-sample.php')){
	echo 'Sorry, I need a f-config-sample.php file to work from.';
	die;
}
$configFile = file('f-config-sample.php');

if ( !is_writable('../')){
	echo "Sorry, I can't write to the directory. You'll have to either change the permissions on your Financial directory or create your f-config.php manually.";
	die;
}
// Check if wp-config.php has been created
if (file_exists('../f-config.php')){
	header('Location: install.php');
	die;
}
if (isset($_GET['step']))
	$step = $_GET['step'];
else
	$step = 0;

function display_header(){
	header( 'Content-Type: text/html; charset=utf-8' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Financial Setup Configuration File</title>
</head>
<body>
<?php
}//end function display_header();

switch($step) {
	case 0:
		display_header();
?>

<p>Welcome to Financial. Before getting started, we need some information on the database. You will need to know the following items before proceeding.</p>
<ol>

	<li>Database name</li>
	<li>Database username</li>
	<li>Database password</li>
	<li>Database host</li>
	<li>Table prefix (if you want to run more than one WordPress in a single database) </li>
</ol>
<p><strong>If for any reason this automatic file creation doesn't work, don't worry. All this does is fill in the database information to a configuration file. You may also simply open <code>wp-config-sample.php</code> in a text editor, fill in your information, and save it as <code>wp-config.php</code>. </strong></p>
<p>In all likelihood, these items were supplied to you by your ISP. If you do not have this information, then you will need to contact them before you can continue. If you&#8217;re all ready&hellip;</p>

<p class="step"><a href="index.php?step=1" class="button">Let&#8217;s go!</a></p>
<?php
	break;

	case 1:
		display_header();
	?>
<form method="post" action="index.php?step=2">
	<p>Below you should enter your database connection details. If you're not sure about these, contact your host. </p>
	<table class="form-table">
		<tr>
			<th scope="row"><label for="dbname">Database Name</label></th>
			<td><input name="dbname" id="dbname" type="text" size="25" value="financial" /></td>
			<td>The name of the database you want to run WP in. </td>
		</tr>
		<tr>
			<th scope="row"><label for="uname">User Name</label></th>
			<td><input name="uname" id="uname" type="text" size="25" value="username" /></td>
			<td>Your MySQL username for viewing</td>
		</tr>
		<tr>
			<th scope="row"><label for="pwd">Password</label></th>
			<td><input name="pwd" id="pwd" type="text" size="25" value="password" /></td>
			<td>...and MySQL password for viewing.</td>
		</tr>
			<th scope="row"><label for="uname">User Name</label></th>
			<td><input name="uname2" id="uname2" type="text" size="25" value="admin" /></td>
			<td>Your MySQL username for changes</td>
		</tr>
		<tr>
			<th scope="row"><label for="pwd">Password</label></th>
			<td><input name="pwd2" id="pwd2" type="text" size="25" value="adminpassword" /></td>
			<td>...and MySQL password for changes.</td>
		</tr>
		<tr>
			<th scope="row"><label for="dbhost">Database Host</label></th>
			<td><input name="dbhost" id="dbhost" type="text" size="25" value="localhost" /></td>
			<td>99% chance you won't need to change this value.</td>
		</tr>
		<tr>
			<th scope="row"><label for="prefix">Table Prefix</label></th>
			<td><input name="prefix" id="prefix" type="text" id="prefix" value="wp_" size="25" /></td>
			<td>If you want to run multiple WordPress installations in a single database, change this.</td>
		</tr>
	</table>
	<p class="step"><input name="submit" type="submit" value="Submit" class="button" /></p>
</form>
<?php
	break;

	case 2:
	$dbname  = trim($_POST['dbname']);
	$uname   = trim($_POST['uname']);
	$passwrd = trim($_POST['pwd']);
	$uname2   = trim($_POST['uname2']);
	$passwrd2 = trim($_POST['pwd2']);
	$dbhost  = trim($_POST['dbhost']);
	$prefix  = trim($_POST['prefix']);
	if (empty($prefix)) $prefix = 'wp_';

/* 	// Test the db connection.
	define('DB_NAME', $dbname);
	define('DB_USER', $uname);
	define('DB_PASSWORD', $passwrd);
	define('DB_HOST', $dbhost);

	// We'll fail here if the values are no good.
	require_wp_db();
	if ( !empty($wpdb->error) )
		wp_die($wpdb->error->get_error_message()); */

	$handle = fopen('../f-config.php', 'w');

		define('HOSTNAME','localhost');
define('USERNAME','guest');
define('UPDATEUSER','financial');
define('UPDATEPASSWORD','');
define('PASSWORD','');
define('DATABASENAME','financial');
define('ACCOUNTS','accounts');
define('TRANSACTIONS','transactions');
define('BILLS','bills');
define('PREFIX','wp_');	
	
	
	foreach ($configFile as $line_num => $line) {
		switch (substr($line,0,16)) {
			case "define('DATABASE":
				fwrite($handle, str_replace("putyourdbnamehere", $dbname, $line));
				break;
			case "define('USERNAME":
				fwrite($handle, str_replace("'usernamehere'", "'$uname'", $line));
				break;
			case "define('UPDATEUS":
				fwrite($handle, str_replace("'usernamehere'", "'$uname2'", $line));
				break;
			case "define('PASSWORD":
				fwrite($handle, str_replace("'yourpasswordhere'", "'$passwrd'", $line));
				break;
			case "define('UPDATEPA":
				fwrite($handle, str_replace("'yourpasswordhere'", "'$passwrd2'", $line));
				break;
			case "define('HOSTNAME":
				fwrite($handle, str_replace("'localhost'", $dbhost, $line));
				break;
			case "define('PREFIX',":
				fwrite($handle, str_replace('wp_', $prefix, $line));
				break;
			default:
				fwrite($handle, $line);
		}
	}
	fclose($handle);

	display_header();
?>
<p>All right sparky! You've made it through this part of the installation. WordPress can now communicate with your database. If you are ready, time now to&hellip;</p>

<p class="step"><a href="install.php" class="button">Run the install</a></p>
<?php
	break;
}
?>
</body>
</html>
