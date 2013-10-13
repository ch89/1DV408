<?php

class LoginController {
	private $loginView;
	private $loginModel;
	private $navigator;

	public function LoginController(LoginView $loginView, LoginModel $loginModel, Navigator $navigator) {
		$this->loginView = $loginView;
		$this->loginModel = $loginModel;
		$this->navigator = $navigator;
	}

	public function login() {
		if($this->loginView->isRemembered()) {
			$this->loginWithCookies();
		}
		else if($this->loginView->userTriesToLogin()) {
			$this->loginWithoutCookies();
		}
		return $this->loginView->getForm();
	}

	private function loginWithCookies() {
		try {
			$user = $this->loginView->getRememberedUser();
			if($this->loginModel->validUser($user)) {
				$this->loginView->checkCookieExpiryDate();
				$this->loginModel->login($user);
				$this->loginView->setCookies($user);
				$this->loginView->setSuccessMessage("Inloggad med kakor.");
				$this->navigator->reload();
			}
			else {
				throw new Exception("Ogiltiga kakor.");
			}
		}
		catch(Exception $e) {
			$this->loginView->setErrorMessage($e->getMessage());
		}
	}

	private function loginWithoutCookies() {
		try {
			$user = $this->loginView->getUser();
			if($this->loginModel->validUser($user)) {
				$this->loginModel->login($user);

				if($this->loginView->rememberMe()) {
					$this->loginView->setCookies($user);
					$this->loginView->setSuccessMessage("Inloggningen lyckades och vi kommer ihåg dig nästa gång.");
				}
				else {
					$this->loginView->setSuccessMessage("Inloggningen lyckades.");
				}
				
				$this->navigator->reload();
			}
			else {
				throw new Exception("Ogiltigt användarnamn och/eller lösenord.");
			}
		}
		catch(Exception $e) {
			$this->loginView->setErrorMessage($e->getMessage());
		}
	}
}