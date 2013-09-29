<?php

class LoginView {
	private $message = "";

	public function userTriesToLogin() {
		return isset($_POST["submit"]);
	}

	public function userLogsout() {
		return isset($_GET["logout"]);
	}

	public function setErrorMessage($message) {
		$this->message = $message;
	}

	public function getUser() {
		return new User($_POST["username"], $_POST["password"]);
	}

	public function getLoginHTML($user) {
		$username = $user->getUsername();
		$html = "<h2>Inloggad som $username</h2>";
		$html .= $this->getLogoutButton();
	 	echo $html;
	}

	public function getLogoutButton() {
		return "<a href='?logout'>Log out</a>";
	}

	public function getFormHTML() {
		$form = "
			<form action='' method='post'>
				Användarnamn: <input type='text' name='username'><br>
				Lösenord: <input type='password' name='password'><br>
				Kom ihåg mig: <input type='checkbox' name='remember'><br>
				<input type='submit' name='submit'>
			</form>";
		
		if(!empty($this->message)) {
			$form .= "<p>$this->message</p>";
		}

		echo $form;
	}
}