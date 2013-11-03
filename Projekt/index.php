<?php

require_once("Controller.php");
require_once("ViewBase.php");
require_once("GameViewBase.php");
require_once("DALBase.php");
require_once("Request.php");
require_once("Router.php");
require_once("Service.php");
require_once("Console.php");
require_once("ConsoleView.php");
require_once("Game.php");
require_once("GameView.php");
require_once("GameDAL.php");
require_once("SearchView.php");
require_once("AuthenticationView.php");
require_once("AuthenticationModel.php");
require_once("User.php");
require_once("UserDAL.php");
require_once("Navigator.php");

session_start();

?>

<html>
	<head>
		<title>Console</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="/style.css">
	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<h2>Console Collection</h2>

				<nav>
					<ul>
						<li><a href="/">Consoles</a></li>
						<li><a href="/Search">Search</a></li>
						<li><a href="/Authentication">Authentication</a></li>
					</ul>
				</nav>
			</div>
			
			<div id="content">
				<?php
				
				echo Router::route(new Request());
				
				?>
			</div>

			<div id="footer">
				<p>Webbutveckling med PHP - Projektarbete</p>
			</div>
		</div>
		<script src="script.js"></script>
	</body>
</html>