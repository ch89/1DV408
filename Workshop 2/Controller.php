<?php

class Controller {
	// @var Navigator $navigator
	protected $navigator;

	// @var Service $service
	protected $service;

	public function Controller() {
		$this->navigator = new Navigator();
		$this->service = new Service();
	}
}