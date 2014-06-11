<?php function Authentication(&$connection)
{
	$connection = Queries::ConnectToDB(false);
	extract($_SERVER);
	if ($REMOTE_ADDR == "127.0.0.1" || $REMOTE_ADDR =="::1" || $REMOTE_ADDR=="192.168.1.100") return "Admin++";
	$ret = "invalid";
	if(isset($_POST['login']) && isset($_POST['pwd']))
	{
		$_SESSION['login']	= $_POST['login'];
		$_SESSION['pwd']	= sha1($_POST['pwd']);
	}
	else
	{
		if (!isset($_SESSION['login']) || !isset($_SESSION['pwd']))
		{
			loginForm();
			return $ret;
		}
	}
	$stmt = Queries::login($connection,  $_SESSION['login'], $_SESSION['pwd']);
	$login_result = $stmt->execute()
	or die ("Error in query: line $login_result" . mysql_error());
	if (!$login_result)
	{
		echo "login failed";
			loginForm();
			return $ret;
	}
	$rowdata = $login_result;

	switch($rowdata['privileges'])
	{
	case 0:
		$ret = "guest";
		break;
	case 1:
		$ret = "admin";
		break;
	case 64:
		$ret = "Admin++";
		break;
	default:
		break;
	}
	return $ret;
}
function loginForm() {
		echo "\n <form action=\"" . $_SERVER['PHP_SELF']
				. "?page=$page\" method=\"post\">\n"
				. "username\t"//. " <li class=\"\">"
				. textField("", "", "login")
				//. "</li>\n"
				. "<br>\npassword\t"//. " <li class=\"\">"
				. textField("", "", "pwd", "password")
				;//. "</li>\n";
			echo "<input type=\"submit\" name=\"loginsubmit\" value=\"";
			echo "Login\" style=\"background-color: "
			. "abcdef;\">\n </form>";
}
?>
<?php function userIsAdmin() {
	return ($GLOBALS['authentication'] != "guest" && $GLOBALS['authentication'] !="invalid");
}
?>
