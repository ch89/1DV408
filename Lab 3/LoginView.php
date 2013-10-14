<?php

class LoginView {
	// @var string $username
	private static $username = "view::LoginView::username";

	// @var string $password
	private static $password = "view::LoginView::password";

	// @var string $remember
	private static $remember = "view::LoginView::remember";

	// @var string $submit
	private static $submit = "view::LoginView::submit";

	// @var string $logout
	private static $logout = "view::LoginView::logout";

	// @var string $successMessage
	private static $successMessage = "view::LoginView::successMessage";

	// @var string $expiryDateFile
	private static $expiryDateFile = "cookieExpiryDate.txt";

	// @var string $message
	private $message;

	// @return boolean
	public function userTriesToLogin() {
		return isset($_POST[self::$submit]);
	}

	// @return User
	public function getUser() {
		return new User($_POST[self::$username], $_POST[self::$password]);
	}

	// @return boolean
	public function rememberMe() {
		return isset($_POST[self::$remember]);
	}

	// @return boolean
	public function isRemembered() {
		return isset($_COOKIE[self::$username]) && isset($_COOKIE[self::$password]);
	}

	// @return User
	public function getRememberedUser() {
		return new User($_COOKIE[self::$username], $_COOKIE[self::$password]);
	}

	// @throws Exception If the cookies expiry date has been manipulated 
	public function checkCookieExpiryDate() {
		$cookieExpiryDate = file_get_contents(self::$expiryDateFile);
				
		if(time() > $cookieExpiryDate) {
			throw new Exception("The cookies expiry date has been manipulated.");
		}
	}

	// @param User $user 
	public function setCookies(User $user) {
		assert($user instanceof User);

		$cookieExpiryDate = time() + 30;
		file_put_contents(self::$expiryDateFile, $cookieExpiryDate);
		setCookie(self::$username, $user->getUsername(), $cookieExpiryDate);
		setCookie(self::$password, $user->getPassword(), $cookieExpiryDate);
	}

	public function removeCookies() {
		setcookie(self::$username, "", time() - 7200);
		setcookie(self::$password, "", time() - 7200);
	}

	// @return boolean
	public function userWantsToLogout() {
		return isset($_GET[self::$logout]);
	}

	// @return string
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

	// @return string
	public function getAdminHTML(User $user) {
		assert($user instanceof User);

		$html = "<h2>Inloggad som " . $user->getUsername() . "</h2>";
		if($this->hasSuccessMessage()) {
			$html .= "<p>" . $this->getSuccessMessage() . "</p>";
		}
		
		$html .= $this->getLogoutButton();
		return $html;
	}

	// @return string
	public function getLogoutButton() {
		return "<a href='?" . self::$logout . "'>Log out</a>";
	}

	// @param string $message
	public function setErrorMessage($message) {
		assert(is_string($message));
		$this->message = $message;
	}

	// @param string $message
	public function setSuccessMessage($message) {
		assert(is_string($message));
		$_SESSION[self::$successMessage] = $message;
	}

	// @return boolean
	private function hasSuccessMessage() {
		return isset($_SESSION[self::$successMessage]);
	}

	// @param string
	private function getSuccessMessage() {
		$message = $_SESSION[self::$successMessage];
		unset($_SESSION[self::$successMessage]);
		return $message;
	}
}