<?php

class LoginView {
	private static $username = "view::LoginView::username";
	private static $password = "view::LoginView::password";
	private static $remember = "view::LoginView::remember";
	private static $submit = "view::LoginView::submit";
	private static $logout = "view::LoginView::logout";
	private static $successMessage = "view::LoginView::successMessage";
	private static $expiryDateFile = "cookieExpiryDate.txt";
	private $message;

	public function userTriesToLogin() {
		return isset($_POST[self::$submit]);
	}

	public function getUser() {
		return new User($_POST[self::$username], $_POST[self::$password]);
	}

	public function rememberMe() {
		return isset($_POST[self::$remember]);
	}

	public function isRemembered() {
		return isset($_COOKIE[self::$username]) && isset($_COOKIE[self::$password]);
	}

	public function getRememberedUser() {
		return new User($_COOKIE[self::$username], $_COOKIE[self::$password]);
	}

	public function checkCookieExpiryDate() {
		$cookieExpiryDate = file_get_contents(self::$expiryDateFile);
				
		if(time() > $cookieExpiryDate) {
			throw new Exception("The cookies expiry date has been manipulated.");
		}
	}

	public function setCookies(User $user) {
		$cookieExpiryDate = time() + 30;
		file_put_contents(self::$expiryDateFile, $cookieExpiryDate);
		setCookie(self::$username, $user->getUsername(), $cookieExpiryDate);
		setCookie(self::$password, $user->getPassword(), $cookieExpiryDate);
	}

	public function removeCookies() {
		setcookie(self::$username, "", time() - 7200);
		setcookie(self::$password, "", time() - 7200);
	}

	public function userWantsToLogout() {
		return isset($_GET[self::$logout]);
	}

	public function getForm() {
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

		return $html;
	}

	public function getAdminHTML(User $user) {
		$html = "<h2>Inloggad som " . $user->getUsername() . "</h2>";
		if($this->hasSuccessMessage()) {
			$html .= "<p>" . $this->getSuccessMessage() . "</p>";
		}
		
		$html .= $this->getLogoutButton();
		return $html;
	}

	public function getLogoutButton() {
		return "<a href='?" . self::$logout . "'>Log out</a>";
	}

	public function setErrorMessage($message) {
		$this->message = $message;
	}

	public function setSuccessMessage($message) {
		$_SESSION[self::$successMessage] = $message;
	}

	private function hasSuccessMessage() {
		return isset($_SESSION[self::$successMessage]);
	}

	private function getSuccessMessage() {
		$message = $_SESSION[self::$successMessage];
		unset($_SESSION[self::$successMessage]);
		return $message;
	}
}