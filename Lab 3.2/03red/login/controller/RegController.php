<?php

namespace login\controller;

require_once("./login/view/RegView.php");

class RegController {

	private $regView;
	private $loginModel;

	public function __construct(\login\view\RegView $regView, \login\model\LoginModel $loginModel) {
		$this->regView = $regView;
		$this->loginModel = $loginModel;
	}

	public function getRegPage() {
		$html = $this->regView->getHeader();

		if($this->regView->regUser()) {
			try {
				$user = $this->regView->getUser();
				$this->regView->passwordMatch();
				$this->loginModel->allUsers->regNewUser($user);
				$this->regView->setSuccessMessage();
			}
			catch(\Exception $e) {
				$this->regView->setFailMessage($e->getMessage());
			}
		}

		$html .= $this->regView->getReturnButton();
		$html .= $this->regView->getRegForm();
		return new \common\view\Page("Laboration. Inloggad", $html);
	}
}