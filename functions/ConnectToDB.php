<?php
function ConnectToDB($username, $password)
{
	try
	{
	$connection = new PDO("mysql:host=" . HOSTNAME . ";port=3306;dbname=" . DATABASENAME . ";charset=UTF8", UPDATEUSER, UPDATEPASSWORD );
	$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $connection;
	}
	catch(PDOException $e) {
		echo "Error!: " . $e->getMessage() . "<br/>\n";
		die("Unable to connect !\n is your database set up?".
                                "<a href=\"setup\">setup</a>");
	}
}
?>
