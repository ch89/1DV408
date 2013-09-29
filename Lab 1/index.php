<?php
//Before code review
session_start();

?>

<html lang="sv">
<head>
	<meta charset="utf-8">
</head>
<body>
<h1>Laborationskod ch222ih</h1>
<?php

$username = "admin";
$password = "pass";

if(isset($_GET["logout"])) {
	echo "<p>Du är nu utloggad</p>";
	unset($_SESSION["username"]);
}

if(isset($_SESSION["username"])) {
	echo "<h2>Inloggad som " . $_SESSION["username"] . "</h2>";
	if(isset($_SESSION["first"])) {
		echo "<p>Inloggningen lyckades</p>";
		unset($_SESSION["first"]);
	}
	echo "<a href='?logout'>Logga ut</a>";
}
else if(isset($_POST["submit"])) {
	if(!empty($_POST["username"])) {
		if(!empty($_POST["password"])) {
			if($_POST["username"] == $username && $_POST["password"] == $password) {
				$_SESSION["username"] = $_POST["username"];
				$_SESSION["first"] = "first";
				header("Location: index.php");
			}
			else {
				echo "<p>Ogiltigt användarnamn och/eller lösenord.</p>";
				displayForm();
			}
		}
		else {
			echo "<p>Lösenord saknas</p>";
			displayForm();
		}
	}
	else {
		echo "<p>Användarnamn saknas</p>";
		displayForm();
	}
}
else {
	displayForm();
}

function displayForm() {
	?>
	<form action="" method="post">
		Användarnamn: <input type="text" name="username"><br>
		Lösenord: <input type="password" name="password"><br>
		Kom ihåg mig: <input type="checkbox" name="remember"><br>
		<input type="submit" name="submit" value="Logga in">
	</form>
	<?php
}

setlocale(LC_ALL, "sv_SE", "sv_SE.utf-8", "sv", "swedish");
echo "<p>Idag är det " . utf8_encode(strftime("%A")) . " den " . strftime("%#d %B") . " år " . strftime("%Y") . " och klockan är " . strftime("%H:%M:%S") . "</p>";

?>

</body>
</html>