<?php

class MasterController {
	// @var LoginController $loginController
	private $loginController;

	// @var LoginView $loginView
	private $loginView;

	// @var LoginModel $loginModel
	private $loginModel;

	// @var Navigator $navigator
	private $navigator;

	public function MasterController() {
		$this->loginView = new loginView();
		$this->loginModel = new loginModel();
		$this->navigator = new Navigator();
		$this->loginController = new loginController($this->loginView,
													 $this->loginModel, 
													 $this->navigator);
	}

	// @return string
	public function run() {
		if($this->loginModel->isLoggedin()) {
			if($this->loginView->userWantsToLogout()) {
				$this->loginModel->logout();
				$this->loginView->removeCookies();
				$this->navigator->reload();
			}
			else {
				$html = $this->loginView->getAdminHTML($this->loginModel->getUser());
			}
		}
		else {
			$html = $this->loginController->login();
		}

		return $html;
	}
}