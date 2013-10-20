<?php

require_once("Boat.php");
require_once("BoatView.php");
require_once("BoatController.php");
require_once("BoatDAL.php");
require_once("Service.php");
require_once("MemberDAL.php");
require_once("Member.php");

?>

<html lang="sv">
	<head>
		<meta charset="utf-8">
		<title></title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<?php
	
		$boatController = new BoatController();
		echo $boatController->handleRequest();
	
		?>
	</body>
</html>