<?php

require_once("LoginModel.php");
require_once("LoginView.php");
require_once("LoginController.php");
require_once("User.php");
require_once("Navigator.php");
require_once("MasterController.php");

session_start();

?>

<!DOCTYPE html>
<html lang="sv">
	<head>
		<meta charset="utf-8">
		<title>Lab3</title>
	</head>
	<body>
		<?php

		$masterController = new MasterController();
		echo $masterController->run();

		?>
	</body>
</html>