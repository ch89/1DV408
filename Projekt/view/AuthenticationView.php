<?php

namespace view;

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

	public function AuthenticationView(\model\AuthenticationModel $authenticationModel) {
		$this->authenticationModel = $authenticationModel;
	}

	// @return string
	public function offlineView() {
		$html = "<h2>Log in</h2>";
		$html .= $this->getLoginForm();
		return $html;
	}

	// @return string
	private function getLoginForm() {
		$html = "<form action='/Authentication/login' method='post'>
					<table>
						<tr>
							<td>Username:</td>
							<td><input type='text' name='" . self::$username . "'></td>
						</tr>
						<tr>
							<td>Password:</td>
							<td><input type='password' name='" . self::$password . "'></td>
						</tr>
						<tr>
							<td><input type='submit' name='" . self::$login . "' value='Log in'></td>
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
		$html = "<p>Logged in as $username</p>";
		$html .= $this->getLogoutButton();
		return $html;
	}

	// @return string
	private function getLogoutButton() {
		return "<a href='/Authentication/logout'><button>Log out</button></a>";
	}

	// @return bool
	public function login() {
		return isset($_POST[self::$login]);
	}

	// @return User
	public function getUser() {
		$password = $this->hashPassword($_POST[self::$password]);
		return new \model\User($_POST[self::$username], $password);
	}

	// @return string
	private function hashPassword($password) {
		$salt = "salt";
		return sha1($password . $salt);
	}
}