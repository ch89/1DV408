<?php

class LoginController {
	
	private static $userLocation = "user";
	private $loginView;
	private $loginModel;

	public function LoginController() {
		$this->loginView = new LoginView();
		$this->loginModel = new LoginModel();
	}

	public function login() {
		if($this->loginView->userLogsout()) {
			unset($_SESSION[self::$userLocation]);
			setcookie(self::$userLocation, "", time() - 7200);
		}

		if(isset($_SESSION[self::$userLocation])) {
			return $this->loginView->getLoggedinHTML($_SESSION[self::$userLocation]);
		}
		else if(isset($_COOKIE[self::$userLocation])) {
			return $this->loginView->getLoggedinHTML($_COOKIE[self::$userLocation]);

			//$_SESSION[self::$userLocation] = $_COOKIE[self::$userLocation];
			//header("Location: index.php");
		}
		
		else if($this->loginView->userTriesToLogin()) {
			try {
				$user = $this->loginView->getUser();
				$this->loginModel->validUser($user);

				if(isset($_POST["remember"])) {
					setcookie(self::$userLocation, $user, time() + 7200);
				}

				$_SESSION[self::$userLocation] = $user;
				header("Location: index.php");
			}
			catch(Exception $e) {
				$this->loginView->setErrorMessage($e->getMessage());
			}
		}
		return $this->loginView->getFormHTML();
	}
}