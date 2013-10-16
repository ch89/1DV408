<?php

namespace login\view;

class RegView {
	private $message = "";

	public function getHeader() {
		return "<h2>Reg Page</h2>";
	}
	public function getReturnButton() {
		return "<a href='?'>Tillbaka</a>";
	}

	public function getRegForm() {
		return "<form action='?reg' method='post'>
					<fieldset>
						$this->message
						<legend>Registrera - Skriv in användarnamn och lösenord</legend>
						Användarnamn: <input type='text' name='username'><br>
						Lösenord: <input type='password' name='password'><br>
						Repetera lösenord: <input type='password' name='passwordRep'><br>
						<input type='submit' name='submit' value='Registrera'>
					</fieldset>
				</form>";
	}

	public function regUser() {
		return isset($_POST["submit"]);
	}

	public function passwordMatch() {
		if($_POST["password"] != $_POST["passwordRep"]) {
			throw new \Exception("Lösenordsfälten matchar inte.");
		}
	}

	public function getUser() {
		$username = new \login\model\UserName($_POST["username"]);
		$password = \login\model\Password::fromCleartext($_POST["password"]);
		return \login\model\UserCredentials::create($username, $password);
	}

	public function setMessage($message) {
		$this->message = $message;
	}
}