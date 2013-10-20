<?php

require_once("Member.php");
require_once("Service.php");
require_once("MemberView.php");
require_once("MemberController.php");
require_once("MemberDAL.php");
require_once("MemberList.php");

session_start();

?>

<html lang="sv">
	<head>
		<meta charset="utf-8">
		<title></title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
	
		<?php
	
		$memberController = new MemberController();
		echo $memberController->handleRequest();
	
		?>

	</body>
</html>
