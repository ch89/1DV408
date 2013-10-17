<?php

namespace application\controller;

require_once("application/view/View.php");
require_once("login/controller/LoginController.php");
require_once("login/controller/RegController.php");



class Application {
	private $view;

	private $loginController;
	private $RegController;
	
	public function __construct() {
		$loginModel = new \login\model\LoginModel();

		$loginView = new \login\view\LoginView();
		
		$this->loginController = new \login\controller\LoginController($loginView, $loginModel);
		$this->view = new \application\view\View($loginView);


		$regView = new \login\view\RegView();
		$this->regController = new \login\controller\RegController($regView, $loginModel);
	}
	
	public function doFrontPage() {
		if($this->view->regUser()) {
			return $this->regController->getRegPage();
		}
		else {
				$this->loginController->doToggleLogin();
	
			if ($this->loginController->isLoggedIn()) {
				$loggedInUserCredentials = $this->loginController->getLoggedInUser();
				return $this->view->getLoggedInPage($loggedInUserCredentials);	
			} else {
				return $this->view->getLoggedOutPage();
			}	
		}
	}
}
