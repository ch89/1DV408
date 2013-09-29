<?php
require_once("LoginController.php");
require_once("LoginView.php");
require_once("LoginModel.php");
require_once("User.php");

session_start();
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