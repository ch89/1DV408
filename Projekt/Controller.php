<?php

class Controller {
	// @var Navigator $navigator
	protected $navigator;

	// @var Service $service
	protected $service;

	// @var AuthenticationModel $authenticationModel
	protected $authenticationModel;

	public function Controller() {
		$this->navigator = new Navigator();
		$this->service = new Service();
		$this->authenticationModel = new AuthenticationModel();
	}
}