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

	private function getCurrentDate() {
		setlocale(LC_ALL, "sv_SE", "sv_SE.utf-8", "sv", "swedish");
		$day = utf8_encode(strftime("%A"));
		$month = strftime("%#d %B");
		$year = strftime("%Y");
		$time = strftime("%H:%M:%S");
		return "<p>Idag är det $day den $month år $year och klockan är $time</p>";
	}

	public function getLoggedinHTML($user) {
		$username = $user->getUsername();
		$html = "<h2>Inloggad som $username</h2>";
		$html .= $this->getLogoutButton();
		$html .= $this->getCurrentDate();
	 	return $html;
	}

	private function getLogoutButton() {
		return "<a href='?logout'>Log out</a>";
	}

	public function getFormHTML() {
		$html = "
			<form action='' method='post'>
				Användarnamn: <input type='text' name='username'><br>
				Lösenord: <input type='password' name='password'><br>
				Kom ihåg mig: <input type='checkbox' name='remember'><br>
				<input type='submit' name='submit'>
			</form>";
		
		if(!empty($this->message)) {
			$form .= "<p>$this->message</p>";
		}

		$html .= $this->getCurrentDate();

		return $html;
	}
}