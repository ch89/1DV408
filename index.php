<?php

require_once("controller/Controller.php");
require_once("view/ViewBase.php");
require_once("view/GameViewBase.php");
require_once("model/DALBase.php");
require_once("Request.php");
require_once("Router.php");
require_once("model/Service.php");
require_once("model/Console.php");
require_once("view/ConsoleView.php");
require_once("model/Game.php");
require_once("view/GameView.php");
require_once("model/GameDAL.php");
require_once("view/SearchView.php");
require_once("view/AuthenticationView.php");
require_once("model/AuthenticationModel.php");
require_once("model/User.php");
require_once("model/UserDAL.php");
require_once("view/Navigator.php");
require_once("model/ConsoleDAL.php");

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