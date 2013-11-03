<?php

class AuthenticationView extends ViewBase {

	// @var string $username
	private static $username = "view::AuthenticationView::username";

	// @var string $password
	private static $password = "view::AuthenticationView::password";

	// @var string $errors
	private static $errors = "view::AuthenticationView::errors";

	// @var string $login
	private static $login = "view::AuthenticationView::login";

	// @var AuthenticationModel $authenticationModel
	private $authenticationModel;

	public function AuthenticationView(AuthenticationModel $authenticationModel) {
		$this->authenticationModel = $authenticationModel;
	}

	// @return string
	public function offlineView() {
		$html = "<h2>Logga in</h2>";
		$html .= $this->getLoginForm();
		return $html;
	}

	// @return string
	private function getLoginForm() {
		$html = "<form action='/Authentication/login' method='post'>
					<table>
						<tr>
							<td>Användarnamn</td>
							<td><input type='text' name='" . self::$username . "'></td>
						</tr>
						<tr>
							<td>Lösenord</td>
							<td><input type='password' name='" . self::$password . "'></td>
						</tr>
						<tr>
							<td><input type='submit' name='" . self::$login . "' value='Logga in'></td>
							<td></td>
						</tr>
					</table>
				</form>";

		if(!empty($this->message)) {
			$html .= $this->message;
		}

		return $html;
	}

	// @return string
	public function onlineView() {
		$username = $this->authenticationModel->getUsername();
		$html = "<p>Inloggad som $username</p>";
		$html .= $this->getLogoutButton();
		return $html;
	}

	// @return string
	private function getLogoutButton() {
		return "<a href='/Authentication/logout'><button>Logga ut</button></a>";
	}

	// @return bool
	public function login() {
		return isset($_POST[self::$login]);
	}

	// @return User
	public function getUser() {
		$password = $this->hashPassword($_POST[self::$password]);
		return new User($_POST[self::$username], $password);
	}

	// @return string
	private function hashPassword($password) {
		$salt = "salt";
		return sha1($password . $salt);
	}
}