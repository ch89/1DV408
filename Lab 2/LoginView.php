<?php

class LoginView {

	//@var string $message
	//@var string $successMessage
	//@var string $username
	//@var string $password
	//@var string $remember
	//@var string $submit
	//@var string $logout

	private $message = "";
	private static $successMessage = "successMessage";
	private static $username = "username";
	private static $password = "password";
	private static $remember = "remember";
	private static $submit = "submit";
	private static $logout = "logout";

	//@return bool

	public function userTriesToLogin() {
		return isset($_POST[self::$submit]);
	}

	//@return bool

	public function userLogsout() {
		return isset($_GET[self::$logout]);
	}

	//@param string $mess

	public function setMessage($mess) {
		$_SESSION[self::$successMessage] = "<p>$mess</p>";
	}

	//@param string $message

	public function setErrorMessage($message) {
		$this->message = $message;
	}

	//@return bool

	public function rememberMe() {
		return isset($_POST[self::$remember]);
	}

	//@return User

	public function getUser() {
		return new User($_POST[self::$username], $_POST[self::$password]);
	}

	//@return string The current date

	private function getCurrentDate() {
		setlocale(LC_ALL, "sv_SE", "sv_SE.utf-8", "sv", "swedish");
		$day = utf8_encode(strftime("%A"));
		$month = strftime("%#d %B");
		$year = strftime("%Y");
		$time = strftime("%H:%M:%S");
		return "<p>Idag är det $day den $month år $year och klockan är $time</p>";
	}

	//@return string The success message after login/logout

	private function getMessage() {
		if(isset($_SESSION[self::$successMessage])) {
			$mess = $_SESSION[self::$successMessage];
			unset($_SESSION[self::$successMessage]);
			return $mess;
		}
	}

	//@return string The admin HTML

	public function getLoggedinHTML($username) {
		$html = "<h2>$username</h2>";
		$html .= $this->getMessage();
		$html .= $this->getLogoutButton();
		$html .= $this->getCurrentDate();
	 	return $html;
	}

	//@return string Logout button

	private function getLogoutButton() {
		return "<a href='?" . self::$logout . "'>Log out</a>";
	}

	//@return string

	public function getFormHTML() {
		$html = "
			<form action='' method='post'>
				Användarnamn: <input type='text' name='" . self::$username . "'><br>
				Lösenord: <input type='password' name='" . self::$password . "'><br>
				Kom ihåg mig: <input type='checkbox' name='" . self::$remember . "'><br>
				<input type='submit' name='" . self::$submit . "'>
			</form>";
		
		if(!empty($this->message)) {
			$html .= "<p>$this->message</p>";
		}

		$html .= $this->getCurrentDate();

		return $html;
	}
}