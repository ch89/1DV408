<?php

class LoginController {

	//@var string $username
	//@var string password
	//@var LoginView $loginView
	//@var loginModel $loginModel
	
	private static $username = "username";
	private static $password = "password";
	private $loginView;
	private $loginModel;

	public function LoginController() {
		$this->loginView = new LoginView();
		$this->loginModel = new LoginModel();
	}

	private function checkCookies() {
		try {
			$username = $_COOKIE[self::$username];
			$password = $_COOKIE[self::$password];
			$this->loginModel->checkCookie($username, $password);

			$_SESSION[self::$username] = $_COOKIE[self::$username];
			$this->loginView->setMessage("Inloggad med cookies.");
			header("Location: index.php");
		}
		catch(Exception $e) {
			setcookie(self::$username, "", time() - 7200);
			setcookie(self::$password, "", time() - 7200);
			$this->loginView->setErrorMessage($e->getMessage());
			$this->loginModel->removeCookieData();
		}
	}

	private function checkLogin() {
		try {
			$user = $this->loginView->getUser();
			$this->loginModel->validUser($user);

			if($this->loginView->rememberMe()) {
				$username = $user->getUsername();
				$password = $user->getPassword();
				$time = time() + 60;

				setcookie(self::$username, $username, $time);
				setcookie(self::$password, $password, $time);
				$this->loginModel->saveCookieData($username, $password, $time);
				$this->loginView->setMessage("Vi kommer ihåg dig nästa gång.");
			}
			else {
				$this->loginView->setMessage("Inloggningen lyckades.");
			}

			$_SESSION[self::$username] = $user->getUsername();
			header("Location: index.php");
		}
		catch(Exception $e) {
			$this->loginView->setErrorMessage($e->getMessage());
		}
	}

	//@return string Returns html for form

	public function login() {
		if($this->loginView->userLogsout()) {
			setcookie(self::$username, "", time() - 7200);
			setcookie(self::$password, "", time() - 7200);
			$this->loginModel->removeCookieData($_SESSION[self::$username]);
			unset($_SESSION[self::$username]);
			header("Location: index.php");
		}
		else {
			if(isset($_SESSION[self::$username])) {
				return $this->loginView->getLoggedinHTML($_SESSION[self::$username]);
			}
			else if(isset($_COOKIE[self::$username]) && isset($_COOKIE[self::$password])) {
				$this->checkCookies();
			}
			
			else if($this->loginView->userTriesToLogin()) {
				$this->checkLogin();
			}
		}
		return $this->loginView->getFormHTML();
	}
}