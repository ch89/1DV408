<?php

require_once("Request.php");
require_once("Router.php");
require_once("Navigator.php");
require_once("DALBase.php");
require_once("Controller.php");
require_once("View.php");
require_once("MemberController.php");
require_once("Member.php");
require_once("MemberDAL.php");
require_once("MemberView.php");
require_once("Service.php");
require_once("BoatController.php");
require_once("Boat.php");
require_once("BoatDAL.php");
require_once("BoatView.php");

session_start();

?>

<html>
	<head>
		<title>Member</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="/style.css">
	</head>
	<body>
		<?php

		echo Router::route(new Request());

		?>

		<script src="script.js"></script>
	</body>
</html>