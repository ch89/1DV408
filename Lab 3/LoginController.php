<?php

class LoginController {
	// @var LoginView $loginView
	private $loginView;

	// @var LoginModel $loginModel
	private $loginModel;

	// @var Navigator $navigator
	private $navigator;

	// @param LoginView $loginView
	// @param LoginModel $loginModel
	// @param Navigator $navigator
	public function LoginController(LoginView $loginView, 
									LoginModel $loginModel,
									Navigator $navigator) {
		
		assert($loginView instanceof LoginView);
		assert($loginModel instanceof LoginModel);
		assert($navigator instanceof Navigator);

		$this->loginView = $loginView;
		$this->loginModel = $loginModel;
		$this->navigator = $navigator;
	}

	// @return string
	public function login() {
		if($this->loginView->isRemembered()) {
			$this->loginWithCookies();
		}
		else if($this->loginView->userTriesToLogin()) {
			$this->loginWithoutCookies();
		}
		return $this->loginView->getForm();
	}

	// @throws Exception If the cookies have been manipulated
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

	// @throws Exception If the username and/or password are incorrect
	private function loginWithoutCookies() {
		try {
			$user = $this->loginView->getUser();
			if($this->loginModel->validUser($user)) {
				$this->loginModel->login($user);

				if($this->loginView->rememberMe()) {
					$this->loginView->setCookies($user);
					$this->loginView->setSuccessMessage("Vi kommer ihåg dig nästa gång.");
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