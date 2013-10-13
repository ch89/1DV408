<?php

class MasterController {
	private $loginController;
	private $loginView;
	private $loginModel;
	private $navigator;

	public function MasterController() {
		$this->loginView = new loginView();
		$this->loginModel = new loginModel();
		$this->navigator = new Navigator();
		$this->loginController = new loginController($this->loginView, $this->loginModel, $this->navigator);
	}

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