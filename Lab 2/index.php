<?php
require_once("LoginController.php");
require_once("LoginView.php");
require_once("LoginModel.php");
require_once("User.php");
require_once("CookieDAL.php");

session_start();

if(!isset($_SESSION['IPAddress'])) {
	$_SESSION['IPaddress'] = $_SERVER['REMOTE_ADDR'];
}
if(!isset($_SESSION["userAgent"])) {
	$_SESSION["userAgent"] = $_SERVER['HTTP_USER_AGENT'];
}

if($_SESSION['IPaddress'] != $_SERVER['REMOTE_ADDR'] ||
   $_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT']) {
   	session_unset();
	session_destroy();
}

?>

<!DOCTYPE html>

<html lang="en">
	<head>
		<title>Login</title>
		<meta charset="utf-8">
	</head>

	<body>
		<?php
			$loginController = new LoginController();
			echo $loginController->login();
		?>
	</body>	
</html>