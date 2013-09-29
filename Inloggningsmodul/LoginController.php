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
		}
		
		if(isset($_SESSION[self::$userLocation])) {
			return $this->loginView->getLoginHTML($_SESSION[self::$userLocation]);
		}
		else if($this->loginView->userTriesToLogin()) {
			try {
				$user = $this->loginView->getUser();
				$this->loginModel->validUser($user);
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