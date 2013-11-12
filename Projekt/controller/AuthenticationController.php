<?php

namespace controller;

class AuthenticationController extends Controller {
	
	// @var AuthenticationView $authenticationView
	private $authenticationView;
	
	public function AuthenticationController() {
		parent::Controller();
		$this->authenticationView = new \view\AuthenticationView($this->authenticationModel);
	}

	// @return string
	public function index() {
		if($this->authenticationModel->isLoggedin()) {
			return $this->authenticationView->onlineView();
		}
		else {
			return $this->authenticationView->offlineView();
		}
	}

	// @throws Exception
	// Kastar ett undantag om användaren inte kan hittas i databasen
	public function login() {
		if($this->authenticationView->login()) {
			try {
				$user = $this->authenticationView->getUser();
				$this->service->findUser($user->getUsername(), $user->getPassword());
				$this->authenticationModel->login($user->getUsername());
			}
			catch(Exception $e) {
				$this->authenticationView->setErrorMessage($e->getMessage());
			}
		}
		$this->navigator->redirectToAuthenticationIndex();
	}

	public function logout() {
		if($this->authenticationModel->isLoggedin()) {
			$this->authenticationModel->logout();
		}
		$this->navigator->redirectToAuthenticationIndex();
	}
}