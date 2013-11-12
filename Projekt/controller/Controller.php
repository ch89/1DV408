<?php

namespace controller;

class Controller {
	// @var Navigator $navigator
	protected $navigator;

	// @var Service $service
	protected $service;

	// @var AuthenticationModel $authenticationModel
	protected $authenticationModel;

	public function Controller() {
		$this->navigator = new \view\Navigator();
		$this->service = new \model\Service();
		$this->authenticationModel = new \model\AuthenticationModel();
	}
}